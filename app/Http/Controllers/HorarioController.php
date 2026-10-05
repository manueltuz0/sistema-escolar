<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\AsignacionMateria;
use App\Models\Grupo;
use App\Models\Docente;
use App\Models\Materia;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        // Filtros seleccionados
        $grado = $request->grado;
        $grupoId = $request->grupo_id;
        $docenteId = $request->docente_id;

        // Consulta principal de horarios
        $query = Horario::with([
            'asignacionMateria.docente',
            'asignacionMateria.materia',
            'asignacionMateria.grupo',
            'asignacionMateria.cicloEscolar',
        ]);

        // Filtrar por grado
        if ($grado) {
            $query->whereHas('asignacionMateria.grupo', function ($q) use ($grado) {
                $q->where('grado', $grado);
            });
        }

        // Filtrar por grupo
        if ($grupoId) {
            $query->whereHas('asignacionMateria.grupo', function ($q) use ($grupoId) {
                $q->where('id', $grupoId);
            });
        }

        // Filtrar por docente
        if ($docenteId) {
            $query->whereHas('asignacionMateria.docente', function ($q) use ($docenteId) {
                $q->where('id', $docenteId);
            });
        }

        // Orden automático:
        // Lunes → Martes → Miércoles → Jueves → Viernes
        // y dentro de cada día por hora
        $horarios = $query
            ->orderByRaw("
                FIELD(
                    dia,
                    'Lunes',
                    'Martes',
                    'Miércoles',
                    'Jueves',
                    'Viernes'
                )
            ")
            ->orderBy('hora_inicio')
            ->get();

        // Grados disponibles
        $grados = Grupo::select('grado')
            ->distinct()
            ->orderBy('grado')
            ->pluck('grado');

        // Grupos disponibles
        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        // Docentes disponibles
        $docentes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        return view('horarios.index', compact(
            'horarios',
            'grados',
            'grupos',
            'docentes',
            'grado',
            'grupoId',
            'docenteId'
        ));
    }

  public function create()
{
    $docentes = Docente::orderBy('apellidos')
        ->orderBy('nombres')
        ->get();

    $materias = \App\Models\Materia::orderBy('nombre')
        ->get();

    $grupos = Grupo::orderBy('grado')
        ->orderBy('nombre')
        ->get();

    $asignaciones = AsignacionMateria::with([
        'docente',
        'materia',
        'grupo',
        'cicloEscolar'
    ])
        ->get()
        ->sortBy(function ($asignacion) {
            return
                ($asignacion->docente->apellidos ?? '') . ' ' .
                ($asignacion->docente->nombres ?? '') . ' ' .
                ($asignacion->materia->nombre ?? '');
        });

    return view('horarios.create', compact(
        'docentes',
        'materias',
        'grupos',
        'asignaciones'
    ));
}

    public function store(Request $request)
    {
        $request->validate([
            'asignacion_materia_id' => 'required|exists:asignaciones_materias,id',
            'dia' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        Horario::create([
            'asignacion_materia_id' => $request->asignacion_materia_id,
            'dia' => $request->dia,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()
            ->route('horarios.index')
            ->with('success', 'Horario registrado correctamente.');
    }

    public function show(string $id)
    {
        $horario = Horario::with([
            'asignacionMateria.docente',
            'asignacionMateria.materia',
            'asignacionMateria.grupo',
            'asignacionMateria.cicloEscolar',
        ])->findOrFail($id);

        return view('horarios.show', compact('horario'));
    }

    public function edit(string $id)
    {
        $horario = Horario::findOrFail($id);

        // Todos los docentes
        $docentes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        // Todas las materias
        $materias = Materia::orderBy('nombre')
            ->get();

        // Todos los grupos
        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        // Asignaciones existentes
        $asignaciones = AsignacionMateria::with([
            'docente',
            'materia',
            'grupo',
            'cicloEscolar'
        ])->get();

        return view('horarios.edit', compact(
            'horario',
            'docentes',
            'materias',
            'grupos',
            'asignaciones'
        ));
    }

    public function update(Request $request, string $id)
    {
        $horario = Horario::findOrFail($id);

        $request->validate([
            'asignacion_materia_id' => 'required|exists:asignaciones_materias,id',
            'dia' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i|after:hora_inicio',
        ]);

        $horario->update([
            'asignacion_materia_id' => $request->asignacion_materia_id,
            'dia' => $request->dia,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()
            ->route('horarios.index')
            ->with('success', 'Horario actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $horario = Horario::findOrFail($id);

        $horario->delete();

        return redirect()
            ->route('horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }
}