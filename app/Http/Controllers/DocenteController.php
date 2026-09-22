<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\Request;

class DocenteController extends Controller
{
    public function index()
    {
        $docentes = Docente::all();

        return view('docentes.index', compact('docentes'));
    }

    public function create()
    {
        return view('docentes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_empleado' => 'required|string|max:20|unique:docentes,numero_empleado',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:docentes,email',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:100',
        ]);

        Docente::create([
            'numero_empleado' => $request->numero_empleado,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
        ]);

        return redirect()->route('docentes.index')
            ->with('success', 'Docente registrado correctamente.');
    }

    public function show(string $id)
    {
        $docente = Docente::findOrFail($id);

        return view('docentes.show', compact('docente'));
    }

    public function edit(string $id)
    {
        $docente = Docente::findOrFail($id);

        return view('docentes.edit', compact('docente'));
    }

    public function update(Request $request, string $id)
    {
        $docente = Docente::findOrFail($id);

        $request->validate([
            'numero_empleado' => 'required|string|max:20|unique:docentes,numero_empleado,' . $docente->id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:docentes,email,' . $docente->id,
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:100',
        ]);

        $docente->update([
            'numero_empleado' => $request->numero_empleado,
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'especialidad' => $request->especialidad,
        ]);

        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $docente = Docente::findOrFail($id);

        $docente->delete();

        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado correctamente.');
    }
}