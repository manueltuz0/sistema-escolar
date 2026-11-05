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
        $query = Incidencia::with('alumno.grupo')
            ->latest('fecha');

        // Buscar por nombre, apellido o matrícula.
        if ($request->filled('buscar')) {
            $buscar = trim($request->buscar);

            $query->whereHas('alumno', function ($q) use ($buscar) {
                $q->where('matricula', 'like', "%{$buscar}%")
                    ->orWhere('nombres', 'like', "%{$buscar}%")
                    ->orWhere('apellidos', 'like', "%{$buscar}%");
            });
        }

        $incidencias = $query
            ->paginate(10)
            ->withQueryString();

        return view('incidencias.index', compact('incidencias'));
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

        return view('incidencias.create', compact('alumnos'));
    }

    /**
     * Guardar una nueva incidencia.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'alumno_id' => [
                'required',
                'exists:alumnos,id',
            ],

            'fecha' => [
                'required',
                'date',
            ],

            'tipo' => [
                'required',
                'string',
                'max:100',
            ],

            'descripcion' => [
                'required',
                'string',
            ],

            'estado' => [
                'required',
                'in:Pendiente,En seguimiento,Atendida,Concluida',
            ],

            'lugar' => [
                'nullable',
                'string',
                'max:150',
            ],

            'acciones_realizadas' => [
                'nullable',
                'string',
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],
        ]);

        Incidencia::create($datos);

        return redirect()
            ->route('incidencias.index')
            ->with('success', 'La incidencia se registró correctamente.');
    }

    /**
     * Mostrar historial de incidencias de un alumno.
     */
    public function historial(Alumno $alumno)
    {
        $alumno->load('grupo');

        $incidencias = Incidencia::where('alumno_id', $alumno->id)
            ->latest('fecha')
            ->get();

        $totalIncidencias = $incidencias->count();

        return view('incidencias.historial', compact(
            'alumno',
            'incidencias',
            'totalIncidencias'
        ));
    }

    /**
     * Mostrar una incidencia específica.
     */
    public function show(Incidencia $incidencia)
    {
        $incidencia->load('alumno.grupo');

        return view('incidencias.show', compact('incidencia'));
    }

    /**
     * Mostrar formulario para editar.
     */
    public function edit(Incidencia $incidencia)
    {
        $incidencia->load('alumno.grupo');

        $alumnos = Alumno::with('grupo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        return view(
            'incidencias.edit',
            compact('incidencia', 'alumnos')
        );
    }

    /**
     * Actualizar incidencia.
     */
    public function update(Request $request, Incidencia $incidencia)
    {
        $datos = $request->validate([
            'alumno_id' => [
                'required',
                'exists:alumnos,id',
            ],

            'fecha' => [
                'required',
                'date',
            ],

            'tipo' => [
                'required',
                'string',
                'max:100',
            ],

            'descripcion' => [
                'required',
                'string',
            ],

            'estado' => [
                'required',
                'in:Pendiente,En seguimiento,Atendida,Concluida',
            ],

            'lugar' => [
                'nullable',
                'string',
                'max:150',
            ],

            'acciones_realizadas' => [
                'nullable',
                'string',
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],
        ]);

        $incidencia->update($datos);

        return redirect()
            ->route('incidencias.show', $incidencia)
            ->with('success', 'La incidencia se actualizó correctamente.');
    }

    /**
     * Eliminar una incidencia.
     */
    public function destroy(Incidencia $incidencia)
    {
        $incidencia->delete();

        return redirect()
            ->route('incidencias.index')
            ->with('success', 'La incidencia se eliminó correctamente.');
    }
}
