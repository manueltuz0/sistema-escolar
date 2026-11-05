<?php

namespace App\Http\Controllers;

use App\Models\ActividadTutoria;
use App\Models\Alumno;
use App\Models\CicloEscolar;
use App\Models\Docente;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActividadTutoriaController extends Controller
{
    /**
     * Mostrar las actividades grupales.
     */
    public function index()
    {
        $actividades = ActividadTutoria::with([
            'docente',
            'grupo',
            'cicloEscolar',
            'alumnos'
        ])
        ->orderByDesc('fecha')
        ->paginate(10);

        return view('tutorias.actividades.index', compact('actividades'));
    }

    /**
     * Mostrar formulario para registrar una actividad.
     */
    public function create()
    {
        $docentes = Docente::where('activo', true)
            ->orderBy('nombres')
            ->get();

        $grupos = Grupo::with('cicloEscolar')
            ->orderBy('grado')
            ->orderBy('nombre')
            ->get();

        $ciclos = CicloEscolar::orderByDesc('fecha_inicio')->get();

        return view('tutorias.actividades.create', compact(
            'docentes',
            'grupos',
            'ciclos'
        ));
    }

    /**
     * Guardar una actividad grupal y sus participantes.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'grupo_id' => 'required|exists:grupos,id',
            'ciclo_escolar_id' => 'required|exists:ciclos_escolares,id',
            'fecha' => 'required|date',
            'tema' => 'required|string|max:150',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'alumnos' => 'required|array|min:1',
            'alumnos.*.id' => 'required|exists:alumnos,id',
            'alumnos.*.asistencia' => 'required|in:Presente,Ausente,Justificado',
            'alumnos.*.observaciones' => 'nullable|string',
        ]);

        DB::transaction(function () use ($datos) {
            $actividad = ActividadTutoria::create([
                'docente_id' => $datos['docente_id'],
                'grupo_id' => $datos['grupo_id'],
                'ciclo_escolar_id' => $datos['ciclo_escolar_id'],
                'fecha' => $datos['fecha'],
                'tema' => $datos['tema'],
                'tipo' => $datos['tipo'],
                'descripcion' => $datos['descripcion'] ?? null,
                'observaciones' => $datos['observaciones'] ?? null,
            ]);

            $participantes = [];

            foreach ($datos['alumnos'] as $alumno) {
                $participantes[$alumno['id']] = [
                    'asistencia' => $alumno['asistencia'],
                    'observaciones' => $alumno['observaciones'] ?? null,
                ];
            }

            $actividad->alumnos()->attach($participantes);
        });

        return redirect()
            ->route('tutorias.actividades.index')
            ->with('success', 'Actividad grupal registrada correctamente.');
    }

    /**
     * Mostrar una actividad grupal.
     */
    public function show(ActividadTutoria $actividade)
    {
        $actividade->load([
            'docente',
            'grupo',
            'cicloEscolar',
            'alumnos'
        ]);

        return view('tutorias.actividades.show', [
            'actividad' => $actividade
        ]);
    }

    /**
     * Mostrar formulario para editar una actividad.
     */
    public function edit(ActividadTutoria $actividade)
    {
        $actividade->load('alumnos');

        $docentes = Docente::where('activo', true)
            ->orderBy('nombres')
            ->get();

        $grupos = Grupo::with('cicloEscolar')
            ->orderBy('grado')
            ->orderBy('nombre')
            ->get();

        $ciclos = CicloEscolar::orderByDesc('fecha_inicio')->get();

        return view('tutorias.actividades.edit', [
            'actividad' => $actividade,
            'docentes' => $docentes,
            'grupos' => $grupos,
            'ciclos' => $ciclos,
        ]);
    }

    /**
     * Actualizar una actividad y sus participantes.
     */
    public function update(Request $request, ActividadTutoria $actividade)
    {
        $datos = $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'grupo_id' => 'required|exists:grupos,id',
            'ciclo_escolar_id' => 'required|exists:ciclos_escolares,id',
            'fecha' => 'required|date',
            'tema' => 'required|string|max:150',
            'tipo' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'observaciones' => 'nullable|string',
            'alumnos' => 'required|array|min:1',
            'alumnos.*.id' => 'required|exists:alumnos,id',
            'alumnos.*.asistencia' => 'required|in:Presente,Ausente,Justificado',
            'alumnos.*.observaciones' => 'nullable|string',
        ]);

        DB::transaction(function () use ($datos, $actividade) {
            $actividade->update([
                'docente_id' => $datos['docente_id'],
                'grupo_id' => $datos['grupo_id'],
                'ciclo_escolar_id' => $datos['ciclo_escolar_id'],
                'fecha' => $datos['fecha'],
                'tema' => $datos['tema'],
                'tipo' => $datos['tipo'],
                'descripcion' => $datos['descripcion'] ?? null,
                'observaciones' => $datos['observaciones'] ?? null,
            ]);

            $participantes = [];

            foreach ($datos['alumnos'] as $alumno) {
                $participantes[$alumno['id']] = [
                    'asistencia' => $alumno['asistencia'],
                    'observaciones' => $alumno['observaciones'] ?? null,
                ];
            }

            $actividade->alumnos()->sync($participantes);
        });

        return redirect()
            ->route('tutorias.actividades.show', $actividade)
            ->with('success', 'Actividad grupal actualizada correctamente.');
    }

    /**
     * Eliminar una actividad grupal.
     */
    public function destroy(ActividadTutoria $actividade)
    {
        $actividade->delete();

        return redirect()
            ->route('tutorias.actividades.index')
            ->with('success', 'Actividad grupal eliminada correctamente.');
    }
}