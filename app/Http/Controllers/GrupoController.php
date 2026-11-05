<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\CicloEscolar;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    /**
     * Mostrar todos los grupos en una sola vista.
     */
    public function index(Request $request)
    {
        $busqueda = trim($request->input('buscar', ''));
        $grado = $request->input('grado');

        $query = Grupo::with('cicloEscolar')
            ->withCount('alumnos')
            ->orderBy('grado')
            ->orderBy('nombre');

        // Buscar por nombre o especialidad.
        if ($busqueda !== '') {
            $query->where(function ($q) use ($busqueda) {
                $q->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('especialidad', 'like', "%{$busqueda}%");
            });
        }

        // Filtrar por grado.
        if ($grado !== null && $grado !== '') {
            $query->where('grado', $grado);
        }

        // Obtener todos los grupos sin paginación.
        $grupos = $query->get();

        // Obtener los grados disponibles para el filtro.
        $grados = Grupo::select('grado')
            ->distinct()
            ->orderBy('grado')
            ->pluck('grado');

        return view('grupos.index', compact(
            'grupos',
            'grados',
            'busqueda',
            'grado'
        ));
    }

    /**
     * Mostrar formulario para crear grupo.
     */
    public function create()
    {
        $ciclosEscolares = CicloEscolar::orderByDesc('id')->get();

        return view('grupos.create', compact('ciclosEscolares'));
    }

    /**
     * Guardar nuevo grupo.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:20'],
            'grado' => ['required', 'integer', 'min:1', 'max:12'],
            'especialidad' => ['nullable', 'string', 'max:100'],
            'ciclo_escolar_id' => [
                'required',
                'exists:ciclos_escolares,id',
            ],
        ]);

        Grupo::create($datos);

        return redirect()
            ->route('grupos.index')
            ->with('success', 'El grupo se registró correctamente.');
    }

    /**
     * Mostrar información del grupo.
     */
    public function show(Grupo $grupo)
    {
        $grupo->load([
            'cicloEscolar',
            'alumnos' => function ($query) {
                $query->orderBy('apellidos')->orderBy('nombres');
            },
            'asignacionesMaterias.materia',
            'asignacionesMaterias.docente',
        ]);

        return view('grupos.show', compact('grupo'));
    }

    /**
     * Mostrar formulario para editar grupo.
     */
    public function edit(Grupo $grupo)
    {
        $ciclosEscolares = CicloEscolar::orderByDesc('id')->get();

        return view('grupos.edit', compact('grupo', 'ciclosEscolares'));
    }

    /**
     * Actualizar grupo.
     */
    public function update(Request $request, Grupo $grupo)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:20'],
            'grado' => ['required', 'integer', 'min:1', 'max:12'],
            'especialidad' => ['nullable', 'string', 'max:100'],
            'ciclo_escolar_id' => [
                'required',
                'exists:ciclos_escolares,id',
            ],
        ]);

        $grupo->update($datos);

        return redirect()
            ->route('grupos.show', $grupo)
            ->with('success', 'El grupo se actualizó correctamente.');
    }

    /**
     * Eliminar grupo.
     */
    public function destroy(Grupo $grupo)
    {
        if ($grupo->alumnos()->exists()) {
            return redirect()
                ->route('grupos.index')
                ->with(
                    'error',
                    'No se puede eliminar este grupo porque tiene alumnos asignados.'
                );
        }

        $grupo->delete();

        return redirect()
            ->route('grupos.index')
            ->with('success', 'El grupo se eliminó correctamente.');
    }
}
