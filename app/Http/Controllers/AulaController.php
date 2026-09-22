<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::orderBy('nombre')->get();

        return view('aulas.index', compact('aulas'));
    }

    public function create()
    {
        return view('aulas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'ubicacion' => 'nullable|string|max:100',
            'capacidad' => 'nullable|integer|min:1',
            'disponible' => 'required|boolean',
        ]);

        Aula::create([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'capacidad' => $request->capacidad,
            'disponible' => $request->disponible,
        ]);

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula registrada correctamente.');
    }

    public function show(string $id)
    {
        $aula = Aula::findOrFail($id);

        return view('aulas.show', compact('aula'));
    }

    public function edit(string $id)
    {
        $aula = Aula::findOrFail($id);

        return view('aulas.edit', compact('aula'));
    }

    public function update(Request $request, string $id)
    {
        $aula = Aula::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:50',
            'ubicacion' => 'nullable|string|max:100',
            'capacidad' => 'nullable|integer|min:1',
            'disponible' => 'required|boolean',
        ]);

        $aula->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'capacidad' => $request->capacidad,
            'disponible' => $request->disponible,
        ]);

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula actualizada correctamente.');
    }

    public function destroy(string $id)
    {
        $aula = Aula::findOrFail($id);

        $aula->delete();

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula eliminada correctamente.');
    }
}