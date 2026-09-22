<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * Mostrar todos los alumnos.
     */
   public function index()
{
    $alumnos = Alumno::with('grupo')->get();

    return view('alumnos.index', compact('alumnos'));
}   

    /**
     * Mostrar el formulario para registrar un alumno.
     */
public function create()
{
    $grupos = \App\Models\Grupo::orderBy('grado')
        ->orderBy('nombre')
        ->get();

    return view('alumnos.create', compact('grupos'));
}

    /**
     * Guardar un nuevo alumno.
     */
public function store(Request $request)
{
    $request->validate([
        'matricula' => 'required|string|max:50|unique:alumnos,matricula',
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:alumnos,email',
        'grupo_id' => 'required|exists:grupos,id',
    ]);

    Alumno::create([
        'matricula' => $request->matricula,
        'nombres' => $request->nombres,
        'apellidos' => $request->apellidos,
        'email' => $request->email,
        'grupo_id' => $request->grupo_id,
    ]);

    return redirect()->route('alumnos.index')
        ->with('success', 'Alumno registrado correctamente.');
}

    /**
     * Mostrar un alumno específico.
     */
    public function show(string $id)
    {
        $alumno = Alumno::findOrFail($id);

        return view('alumnos.show', compact('alumno'));
    }

    /**
     * Mostrar el formulario para editar un alumno.
     */
public function edit(string $id)
{
    $alumno = Alumno::with('grupo')->findOrFail($id);

    $grupos = \App\Models\Grupo::orderBy('grado')
        ->orderBy('nombre')
        ->get();

    return view('alumnos.edit', compact('alumno', 'grupos'));
}

    /**
     * Actualizar un alumno.
     */
public function update(Request $request, string $id)
{
    $alumno = Alumno::findOrFail($id);

    $request->validate([
        'matricula' => 'required|string|max:50|unique:alumnos,matricula,' . $alumno->id,
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:alumnos,email,' . $alumno->id,
        'grupo_id' => 'required|exists:grupos,id',
    ]);

    $alumno->update([
        'matricula' => $request->matricula,
        'nombres' => $request->nombres,
        'apellidos' => $request->apellidos,
        'email' => $request->email,
        'grupo_id' => $request->grupo_id,
    ]);

    return redirect()->route('alumnos.index')
        ->with('success', 'Alumno actualizado correctamente.');
}

    /**
     * Eliminar un alumno.
     */
    public function destroy(string $id)
    {
        $alumno = Alumno::findOrFail($id);

        $alumno->delete();

        return redirect()
            ->route('alumnos.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }
}