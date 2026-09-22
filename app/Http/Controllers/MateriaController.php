<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    public function index()
    {
        $materias = Materia::orderBy('semestre')
            ->orderBy('nombre')
            ->get();

        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'clave' => 'required|string|max:50|unique:materias,clave',
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'semestre' => 'required|integer|min:1|max:6',
        ]);

        Materia::create([
            'clave' => $request->clave,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'semestre' => $request->semestre,
        ]);

        return redirect()
            ->route('materias.index')
            ->with('success', 'Materia registrada correctamente.');
    }

    public function show(string $id)
    {
        $materia = Materia::findOrFail($id);

        return view('materias.show', compact('materia'));
    }

    public function edit(string $id)
    {
        $materia = Materia::findOrFail($id);

        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, string $id)
    {
        $materia = Materia::findOrFail($id);

        $request->validate([
            'clave' => 'required|string|max:50|unique:materias,clave,' . $materia->id,
            'nombre' => 'required|string|max:150',
            'descripcion' => 'nullable|string',
            'semestre' => 'required|integer|min:1|max:6',
        ]);

        $materia->update([
            'clave' => $request->clave,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'semestre' => $request->semestre,
        ]);

        return redirect()
            ->route('materias.index')
            ->with('success', 'Materia actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $materia = Materia::findOrFail($id);

        $materia->delete();

        return redirect()
            ->route('materias.index')
            ->with('success', 'Materia eliminada correctamente.');
    }
}