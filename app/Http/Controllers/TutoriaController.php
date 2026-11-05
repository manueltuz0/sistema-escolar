<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Docente;
use App\Models\Tutoria;
use Illuminate\Http\Request;

class TutoriaController extends Controller
{
    /**
     * Mostrar listado de atenciones individuales.
     */
    public function index(Request $request)
    {
        $query = Tutoria::with([
            'alumno.grupo',
            'docente',
            'seguimientos'
        ])->latest('fecha');

        // Buscar alumno por matrícula, nombre o apellido.
        if ($request->filled('buscar')) {
            $buscar = trim($request->buscar);

            $query->whereHas('alumno', function ($q) use ($buscar) {
                $q->where('matricula', 'like', "%{$buscar}%")
                    ->orWhere('nombres', 'like', "%{$buscar}%")
                    ->orWhere('apellidos', 'like', "%{$buscar}%");
            });
        }

        // Filtrar por estado.
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $tutorias = $query->paginate(10)->withQueryString();

        return view('tutorias.index', compact('tutorias'));
    }

    /**
     * Mostrar formulario para registrar atención individual.
     */
    public function create()
    {
        $alumnos = Alumno::with('grupo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        $docentes = Docente::where('activo', true)
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('tutorias.create', compact(
            'alumnos',
            'docentes'
        ));
    }

    /**
     * Guardar una atención individual.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'alumno_id' => [
                'required',
                'exists:alumnos,id'
            ],

            'docente_id' => [
                'nullable',
                'exists:docentes,id'
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
                'date',
                'after_or_equal:fecha'
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

        $tutoria = Tutoria::create($datos);

        return redirect()
            ->route('tutorias.show', $tutoria)
            ->with(
                'success',
                'La atención individual se registró correctamente.'
            );
    }

    /**
     * Mostrar una atención individual.
     */
    public function show(Tutoria $tutoria)
    {
        $tutoria->load([
            'alumno.grupo',
            'docente',
            'seguimientos'
        ]);

        return view('tutorias.show', compact('tutoria'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Tutoria $tutoria)
    {
        $tutoria->load([
            'alumno.grupo',
            'docente',
            'seguimientos'
        ]);

        $alumnos = Alumno::with('grupo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        $docentes = Docente::where('activo', true)
            ->orderBy('nombres')
            ->orderBy('apellidos')
            ->get();

        return view('tutorias.edit', compact(
            'tutoria',
            'alumnos',
            'docentes'
        ));
    }

    /**
     * Actualizar una atención individual.
     */
    public function update(Request $request, Tutoria $tutoria)
    {
        $datos = $request->validate([
            'alumno_id' => [
                'required',
                'exists:alumnos,id'
            ],

            'docente_id' => [
                'nullable',
                'exists:docentes,id'
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
                'date',
                'after_or_equal:fecha'
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

        $tutoria->update($datos);

        return redirect()
            ->route('tutorias.show', $tutoria)
            ->with(
                'success',
                'La atención individual se actualizó correctamente.'
            );
    }

    /**
     * Eliminar una atención individual.
     */
    public function destroy(Tutoria $tutoria)
    {
        // Evitar eliminar atenciones que tengan seguimientos registrados.
        if ($tutoria->seguimientos()->exists()) {
            return redirect()
                ->route('tutorias.index')
                ->with(
                    'error',
                    'No se puede eliminar esta atención porque tiene seguimientos registrados.'
                );
        }

        $tutoria->delete();

        return redirect()
            ->route('tutorias.index')
            ->with(
                'success',
                'La atención individual se eliminó correctamente.'
            );
    }
}
