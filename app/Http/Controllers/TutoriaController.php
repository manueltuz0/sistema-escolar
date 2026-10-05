<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Incidencia;
use App\Models\Tutoria;
use Illuminate\Http\Request;

class TutoriaController extends Controller
{
    /**
     * Mostrar listado de tutorías.
     */
    public function index(Request $request)
    {
        $query = Tutoria::with([
            'alumno.grupo',
            'incidencia'
        ])->latest('fecha');


        /*
        |--------------------------------------------------------------------------
        | BUSCAR ALUMNO
        |--------------------------------------------------------------------------
        */

        if ($request->filled('buscar')) {

            $buscar = trim($request->buscar);

            $query->whereHas('alumno', function ($q) use ($buscar) {

                $q->where('matricula', 'like', "%{$buscar}%")
                    ->orWhere('nombres', 'like', "%{$buscar}%")
                    ->orWhere('apellidos', 'like', "%{$buscar}%");

            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTRAR POR ESTADO
        |--------------------------------------------------------------------------
        */

        if ($request->filled('estado')) {

            $query->where(
                'estado',
                $request->estado
            );
        }


        /*
        |--------------------------------------------------------------------------
        | PAGINACIÓN
        |--------------------------------------------------------------------------
        */

        $tutorias = $query
            ->paginate(10)
            ->withQueryString();


        return view(
            'tutorias.index',
            compact('tutorias')
        );
    }


    /**
     * Formulario para registrar una tutoría.
     *
     * Si se recibe incidencia_id:
     *
     * /tutorias/create?incidencia_id=3
     *
     * se carga automáticamente esa incidencia.
     */
    public function create(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ALUMNOS
        |--------------------------------------------------------------------------
        */

        $alumnos = Alumno::with('grupo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | INCIDENCIA SELECCIONADA
        |--------------------------------------------------------------------------
        */

        $incidenciaSeleccionada = null;


        if ($request->filled('incidencia_id')) {

            $incidenciaSeleccionada = Incidencia::with([
                'alumno.grupo'
            ])->find(
                $request->incidencia_id
            );
        }


        /*
        |--------------------------------------------------------------------------
        | INCIDENCIAS DISPONIBLES
        |--------------------------------------------------------------------------
        |
        | Se utilizan para mostrar las incidencias que pueden
        | relacionarse con una tutoría.
        |
        */

        $incidencias = Incidencia::with([
            'alumno.grupo'
        ])
            ->whereIn('estado', [
                'Pendiente',
                'En seguimiento',
                'Atendida'
            ])
            ->latest('fecha')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'tutorias.create',
            compact(
                'alumnos',
                'incidencias',
                'incidenciaSeleccionada'
            )
        );
    }


    /**
     * Guardar tutoría.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | ALUMNO
            |--------------------------------------------------------------------------
            */

            'alumno_id' => [
                'required',
                'exists:alumnos,id'
            ],


            /*
            |--------------------------------------------------------------------------
            | INCIDENCIA RELACIONADA
            |--------------------------------------------------------------------------
            */

            'incidencia_id' => [
                'nullable',
                'exists:incidencias,id'
            ],


            /*
            |--------------------------------------------------------------------------
            | DATOS DE TUTORÍA
            |--------------------------------------------------------------------------
            */

            'fecha' => [
                'required',
                'date'
            ],

            'tipo' => [
                'required',
                'string',
                'max:100'
            ],

            'motivo' => [
                'required',
                'string',
                'max:255'
            ],

            'situacion' => [
                'nullable',
                'string'
            ],

            'acuerdos' => [
                'nullable',
                'string'
            ],

            'compromisos_alumno' => [
                'nullable',
                'string'
            ],

            'compromisos_tutor' => [
                'nullable',
                'string'
            ],

            'fecha_seguimiento' => [
                'nullable',
                'date'
            ],

            'estado' => [
                'required',
                'in:Pendiente,En seguimiento,Concluida'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | GUARDAR TUTORÍA
        |--------------------------------------------------------------------------
        */

        $tutoria = Tutoria::create($datos);


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR INCIDENCIA
        |--------------------------------------------------------------------------
        |
        | Si la tutoría nace de una incidencia,
        | automáticamente pasa a "En seguimiento".
        |
        */

        if (!empty($datos['incidencia_id'])) {

            Incidencia::where(
                'id',
                $datos['incidencia_id']
            )->update([
                'estado' => 'En seguimiento'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | REGRESAR
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'tutorias.show',
                $tutoria
            )
            ->with(
                'success',
                'La tutoría se registró correctamente y quedó vinculada con la incidencia.'
            );
    }


    /**
     * Mostrar una tutoría.
     */
    public function show(Tutoria $tutoria)
    {
        $tutoria->load([
            'alumno.grupo',
            'incidencia.alumno.grupo'
        ]);


        return view(
            'tutorias.show',
            compact('tutoria')
        );
    }


    /**
     * Formulario de edición.
     */
    public function edit(Tutoria $tutoria)
    {
        /*
        |--------------------------------------------------------------------------
        | CARGAR TUTORÍA
        |--------------------------------------------------------------------------
        */

        $tutoria->load([
            'alumno.grupo',
            'incidencia.alumno.grupo'
        ]);


        /*
        |--------------------------------------------------------------------------
        | ALUMNOS
        |--------------------------------------------------------------------------
        */

        $alumnos = Alumno::with('grupo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | INCIDENCIAS
        |--------------------------------------------------------------------------
        */

        $incidencias = Incidencia::with([
            'alumno.grupo'
        ])
            ->latest('fecha')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | INCIDENCIA SELECCIONADA
        |--------------------------------------------------------------------------
        */

        $incidenciaSeleccionada = $tutoria->incidencia;


        return view(
            'tutorias.edit',
            compact(
                'tutoria',
                'alumnos',
                'incidencias',
                'incidenciaSeleccionada'
            )
        );
    }


    /**
     * Actualizar tutoría.
     */
    public function update(
        Request $request,
        Tutoria $tutoria
    ) {

        $datos = $request->validate([

            'alumno_id' => [
                'required',
                'exists:alumnos,id'
            ],

            'incidencia_id' => [
                'nullable',
                'exists:incidencias,id'
            ],

            'fecha' => [
                'required',
                'date'
            ],

            'tipo' => [
                'required',
                'string',
                'max:100'
            ],

            'motivo' => [
                'required',
                'string',
                'max:255'
            ],

            'situacion' => [
                'nullable',
                'string'
            ],

            'acuerdos' => [
                'nullable',
                'string'
            ],

            'compromisos_alumno' => [
                'nullable',
                'string'
            ],

            'compromisos_tutor' => [
                'nullable',
                'string'
            ],

            'fecha_seguimiento' => [
                'nullable',
                'date'
            ],

            'estado' => [
                'required',
                'in:Pendiente,En seguimiento,Concluida'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | GUARDAR CAMBIOS
        |--------------------------------------------------------------------------
        */

        $tutoria->update($datos);


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR INCIDENCIA
        |--------------------------------------------------------------------------
        */

        if (!empty($datos['incidencia_id'])) {

            Incidencia::where(
                'id',
                $datos['incidencia_id']
            )->update([
                'estado' => 'En seguimiento'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | REGRESAR
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'tutorias.show',
                $tutoria
            )
            ->with(
                'success',
                'La tutoría se actualizó correctamente.'
            );
    }


    /**
     * Eliminar tutoría.
     */
    public function destroy(Tutoria $tutoria)
    {
        $tutoria->delete();


        return redirect()
            ->route('tutorias.index')
            ->with(
                'success',
                'La tutoría se eliminó correctamente.'
            );
    }
}