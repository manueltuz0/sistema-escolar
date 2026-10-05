<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Incidencia;
use Illuminate\Http\Request;

class IncidenciaController extends Controller
{
    /**
     * Mostrar listado de incidencias.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ESTADÍSTICAS
        |--------------------------------------------------------------------------
        */

        $totalIncidencias = Incidencia::count();

        $pendientes = Incidencia::where(
            'estado',
            'Pendiente'
        )->count();

        $enSeguimiento = Incidencia::where(
            'estado',
            'En seguimiento'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | CONSULTA DE INCIDENCIAS
        |--------------------------------------------------------------------------
        */

        $query = Incidencia::with([
            'alumno.grupo'
        ])->latest('fecha');


        /*
        |--------------------------------------------------------------------------
        | BUSCAR POR ALUMNO
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
        | PAGINACIÓN
        |--------------------------------------------------------------------------
        */

        $incidencias = $query
            ->paginate(10)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'incidencias.index',
            compact(
                'incidencias',
                'totalIncidencias',
                'pendientes',
                'enSeguimiento'
            )
        );
    }


    /**
     * Mostrar formulario para registrar una incidencia.
     */
    public function create()
    {
        $alumnos = Alumno::with('grupo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        return view(
            'incidencias.create',
            compact('alumnos')
        );
    }


    /**
     * Guardar una nueva incidencia.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([

            'alumno_id' => [
                'required',
                'exists:alumnos,id'
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

            'descripcion' => [
                'required',
                'string'
            ],

            'prioridad' => [
                'required',
                'in:Baja,Media,Alta'
            ],

            'estado' => [
                'required',
                'in:Pendiente,En seguimiento,Atendida,Concluida'
            ],

            'lugar' => [
                'nullable',
                'string',
                'max:150'
            ],

            'acciones_realizadas' => [
                'nullable',
                'string'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | GUARDAR EN BASE DE DATOS
        |--------------------------------------------------------------------------
        */

        Incidencia::create($datos);


        /*
        |--------------------------------------------------------------------------
        | REGRESAR AL LISTADO
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('incidencias.index')
            ->with(
                'success',
                'La incidencia se registró correctamente.'
            );
    }


    /**
     * Mostrar historial completo de un alumno.
     *
     * Incluye:
     *
     * - Datos del alumno
     * - Grupo
     * - Todas sus incidencias
     * - Todas sus tutorías
     * - Estadísticas de sus incidencias
     */
    public function historial(Alumno $alumno)
    {
        /*
        |--------------------------------------------------------------------------
        | DATOS DEL ALUMNO
        |--------------------------------------------------------------------------
        */

        $alumno->load([
            'grupo'
        ]);


        /*
        |--------------------------------------------------------------------------
        | INCIDENCIAS DEL ALUMNO
        |--------------------------------------------------------------------------
        */

        $incidencias = Incidencia::where(
            'alumno_id',
            $alumno->id
        )
            ->latest('fecha')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ESTADÍSTICAS DEL ALUMNO
        |--------------------------------------------------------------------------
        */

        $totalIncidencias = $incidencias->count();

        $pendientes = $incidencias
            ->where('estado', 'Pendiente')
            ->count();

        $enSeguimiento = $incidencias
            ->where('estado', 'En seguimiento')
            ->count();

        $atendidas = $incidencias
            ->where('estado', 'Atendida')
            ->count();

        $concluidas = $incidencias
            ->where('estado', 'Concluida')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | TUTORÍAS DEL ALUMNO
        |--------------------------------------------------------------------------
        */

        $tutorias = $alumno->tutorias()
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MOSTRAR HISTORIAL
        |--------------------------------------------------------------------------
        */

        return view(
            'incidencias.historial',
            compact(
                'alumno',
                'incidencias',
                'tutorias',
                'totalIncidencias',
                'pendientes',
                'enSeguimiento',
                'atendidas',
                'concluidas'
            )
        );
    }


    /**
     * Mostrar una incidencia específica.
     */
    public function show(Incidencia $incidencia)
    {
        /*
        |--------------------------------------------------------------------------
        | CARGAR RELACIONES
        |--------------------------------------------------------------------------
        */

        $incidencia->load([
            'alumno.grupo',
            'tutorias'
        ]);


        /*
        |--------------------------------------------------------------------------
        | MOSTRAR DETALLE
        |--------------------------------------------------------------------------
        */

        return view(
            'incidencias.show',
            compact('incidencia')
        );
    }


    /**
     * Mostrar formulario para editar.
     */
    public function edit(Incidencia $incidencia)
    {
        /*
        |--------------------------------------------------------------------------
        | CARGAR ALUMNO Y GRUPO
        |--------------------------------------------------------------------------
        */

        $incidencia->load([
            'alumno.grupo'
        ]);


        /*
        |--------------------------------------------------------------------------
        | OBTENER ALUMNOS
        |--------------------------------------------------------------------------
        */

        $alumnos = Alumno::with('grupo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MOSTRAR FORMULARIO
        |--------------------------------------------------------------------------
        */

        return view(
            'incidencias.edit',
            compact(
                'incidencia',
                'alumnos'
            )
        );
    }


    /**
     * Actualizar incidencia.
     */
    public function update(
        Request $request,
        Incidencia $incidencia
    ) {

        /*
        |--------------------------------------------------------------------------
        | VALIDAR DATOS
        |--------------------------------------------------------------------------
        */

        $datos = $request->validate([

            'alumno_id' => [
                'required',
                'exists:alumnos,id'
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

            'descripcion' => [
                'required',
                'string'
            ],

            'prioridad' => [
                'required',
                'in:Baja,Media,Alta'
            ],

            'estado' => [
                'required',
                'in:Pendiente,En seguimiento,Atendida,Concluida'
            ],

            'lugar' => [
                'nullable',
                'string',
                'max:150'
            ],

            'acciones_realizadas' => [
                'nullable',
                'string'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR EN BASE DE DATOS
        |--------------------------------------------------------------------------
        */

        $incidencia->update($datos);


        /*
        |--------------------------------------------------------------------------
        | REGRESAR AL DETALLE
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'incidencias.show',
                $incidencia
            )
            ->with(
                'success',
                'La incidencia se actualizó correctamente.'
            );
    }


    /**
     * Eliminar una incidencia.
     */
    public function destroy(Incidencia $incidencia)
    {
        /*
        |--------------------------------------------------------------------------
        | ELIMINAR
        |--------------------------------------------------------------------------
        */

        $incidencia->delete();


        /*
        |--------------------------------------------------------------------------
        | REGRESAR AL LISTADO
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('incidencias.index')
            ->with(
                'success',
                'La incidencia se eliminó correctamente.'
            );
    }
}