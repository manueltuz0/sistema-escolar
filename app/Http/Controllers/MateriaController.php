<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriaController extends Controller
{
    /**
     * Mostrar todas las materias.
     */
    public function index()
    {
        $materias = Materia::orderBy('semestre')
            ->orderBy('nombre')
            ->get();

        return view('materias.index', compact('materias'));
    }


    /**
     * Mostrar formulario para registrar una materia.
     */
    public function create()
    {
        return view('materias.create');
    }


    /**
     * Guardar una nueva materia.
     */
    public function store(Request $request)
{
    $request->validate([

        'clave' => [
            'required',
            'string',
            'max:50',
            'unique:materias,clave'
        ],

        'nombre' => [
            'required',
            'string',
            'max:150'
        ],

        'horas_semana' => [
            'required',
            'integer',
            'min:1',
            'max:20'
        ],

        'descripcion' => [
            'nullable',
            'string'
        ],

        'semestre' => [
            'required',
            'integer',
            'min:1',
            'max:6'
        ],

    ]);

    Materia::create([

        'clave' => $request->clave,

        'nombre' => $request->nombre,

        'horas_semana' => $request->horas_semana,

        'descripcion' => $request->descripcion,

        'semestre' => $request->semestre,

        'activa' => true,

    ]);

    return redirect()
        ->route('materias.index')
        ->with(
            'success',
            'Materia registrada correctamente.'
        );
}


    /**
     * Mostrar una materia.
     */
    public function show(string $id)
    {
        $materia = Materia::findOrFail($id);

        return view(
            'materias.show',
            compact('materia')
        );
    }


    /**
     * Mostrar formulario para editar una materia.
     */
    public function edit(string $id)
    {
        $materia = Materia::findOrFail($id);

        return view(
            'materias.edit',
            compact('materia')
        );
    }


    /**
     * Actualizar una materia.
     */
    public function update(Request $request, string $id)
    {
        $materia = Materia::findOrFail($id);


        $request->validate([

            'clave' => [
                'required',
                'string',
                'max:50',
                'unique:materias,clave,' . $materia->id
            ],

            'nombre' => [
                'required',
                'string',
                'max:150'
            ],

            'horas_semana' => [
                'required',
                'integer',
                'min:1',
                'max:20'
            ],

            'descripcion' => [
                'nullable',
                'string'
            ],

            'semestre' => [
                'required',
                'integer',
                'min:1',
                'max:6'
            ],

        ]);


        $materia->update([

            'clave' =>
                $request->clave,

            'nombre' =>
                $request->nombre,

            'horas_semana' =>
                $request->horas_semana,

            'descripcion' =>
                $request->descripcion,

            'semestre' =>
                $request->semestre,

            'activa' =>
                $request->has('activa'),

        ]);


        return redirect()
            ->route('materias.index')
            ->with(
                'success',
                'Materia actualizada correctamente.'
            );
    }


    /**
     * Eliminar una materia.
     */
    public function destroy(string $id)
    {
        $materia = Materia::findOrFail($id);

        $materia->delete();

        return redirect()
            ->route('materias.index')
            ->with(
                'success',
                'Materia eliminada correctamente.'
            );
    }
}