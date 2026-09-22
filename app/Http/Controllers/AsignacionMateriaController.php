<?php

namespace App\Http\Controllers;

use App\Models\AsignacionMateria;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\CicloEscolar;
use Illuminate\Http\Request;

class AsignacionMateriaController extends Controller
{
    public function index()
    {
        $asignaciones = AsignacionMateria::with([
            'docente',
            'materia',
            'grupo',
            'cicloEscolar'
        ])->get();

        return view('asignaciones_materias.index', compact('asignaciones'));
    }

    public function create()
    {
        $docentes = Docente::orderBy('apellidos')->get();
        $materias = Materia::where('activa', true)
            ->orderBy('nombre')
            ->get();
        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();
        $ciclosEscolares = CicloEscolar::orderByDesc('activo')
            ->orderByDesc('fecha_inicio')
            ->get();

        return view('asignaciones_materias.create', compact(
            'docentes',
            'materias',
            'grupos',
            'ciclosEscolares'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'materia_id' => 'required|exists:materias,id',
            'grupo_id' => 'required|exists:grupos,id',
            'ciclo_escolar_id' => 'required|exists:ciclos_escolares,id',
        ]);

        AsignacionMateria::create([
            'docente_id' => $request->docente_id,
            'materia_id' => $request->materia_id,
            'grupo_id' => $request->grupo_id,
            'ciclo_escolar_id' => $request->ciclo_escolar_id,
        ]);

        return redirect()->route('asignaciones_materias.index')
            ->with('success', 'Asignación registrada correctamente.');
    }

    public function show(string $id)
    {
        $asignacion = AsignacionMateria::with([
            'docente',
            'materia',
            'grupo',
            'cicloEscolar'
        ])->findOrFail($id);

        return view('asignaciones_materias.show', compact('asignacion'));
    }

    public function edit(string $id)
    {
        $asignacion = AsignacionMateria::findOrFail($id);

        $docentes = Docente::orderBy('apellidos')->get();
        $materias = Materia::orderBy('nombre')->get();
        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();
        $ciclosEscolares = CicloEscolar::orderByDesc('activo')
            ->orderByDesc('fecha_inicio')
            ->get();

        return view('asignaciones_materias.edit', compact(
            'asignacion',
            'docentes',
            'materias',
            'grupos',
            'ciclosEscolares'
        ));
    }

    public function update(Request $request, string $id)
    {
        $asignacion = AsignacionMateria::findOrFail($id);

        $request->validate([
            'docente_id' => 'required|exists:docentes,id',
            'materia_id' => 'required|exists:materias,id',
            'grupo_id' => 'required|exists:grupos,id',
            'ciclo_escolar_id' => 'required|exists:ciclos_escolares,id',
        ]);

        $asignacion->update([
            'docente_id' => $request->docente_id,
            'materia_id' => $request->materia_id,
            'grupo_id' => $request->grupo_id,
            'ciclo_escolar_id' => $request->ciclo_escolar_id,
        ]);

        return redirect()->route('asignaciones_materias.index')
            ->with('success', 'Asignación actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $asignacion = AsignacionMateria::findOrFail($id);

        $asignacion->delete();

        return redirect()->route('asignaciones_materias.index')
            ->with('success', 'Asignación eliminada correctamente.');
    }
}