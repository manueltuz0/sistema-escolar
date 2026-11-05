<?php

namespace App\Http\Controllers;

use App\Models\AsignacionMateria;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\CicloEscolar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AsignacionMateriaController extends Controller
{
    /**
     * Mostrar todas las asignaciones de materias.
     */
    public function index()
    {
        $asignaciones = AsignacionMateria::with([
            'docente',
            'materia',
            'grupo',
            'cicloEscolar',
        ])
            ->orderBy('grupo_id')
            ->orderBy('materia_id')
            ->get();

        return view(
            'asignaciones_materias.index',
            compact('asignaciones')
        );
    }

    /**
     * Mostrar el formulario para registrar una asignación.
     */
    public function create()
    {
        $docentes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        $materias = Materia::where('activa', true)
            ->whereNotNull('semestre')
            ->orderBy('semestre')
            ->orderBy('nombre')
            ->get();

        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        $ciclosEscolares = CicloEscolar::orderByDesc('activo')
            ->orderByDesc('fecha_inicio')
            ->get();

        $semestres = collect(range(1, 6));

        return view('asignaciones_materias.create', compact(
            'docentes',
            'materias',
            'grupos',
            'ciclosEscolares',
            'semestres'
        ));
    }

    /**
     * Guardar una nueva asignación.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'docente_id' => [
                'required',
                'integer',
                'exists:docentes,id',
            ],

            'materia_id' => [
                'required',
                'integer',
                Rule::exists('materias', 'id')
                    ->where('activa', true),
            ],

            'grupo_id' => [
                'required',
                'integer',
                'exists:grupos,id',
            ],

            'ciclo_escolar_id' => [
                'required',
                'integer',
                'exists:ciclos_escolares,id',
            ],
        ], [
            'docente_id.required' =>
                'Selecciona un docente.',

            'docente_id.exists' =>
                'El docente seleccionado no existe.',

            'materia_id.required' =>
                'Selecciona una materia.',

            'materia_id.exists' =>
                'La materia seleccionada no existe o no está activa.',

            'grupo_id.required' =>
                'Selecciona un grupo.',

            'grupo_id.exists' =>
                'El grupo seleccionado no existe.',

            'ciclo_escolar_id.required' =>
                'Selecciona un ciclo escolar.',

            'ciclo_escolar_id.exists' =>
                'El ciclo escolar seleccionado no existe.',
        ]);

        $materia = Materia::findOrFail($datos['materia_id']);
        $grupo = Grupo::findOrFail($datos['grupo_id']);

        /*
         * El semestre de la materia debe coincidir
         * con el grado del grupo.
         *
         * Ejemplo:
         * Matemáticas de semestre 1 -> grupo de grado 1.
         */
        if ((int) $materia->semestre !== (int) $grupo->grado) {
            return back()
                ->withErrors([
                    'materia_id' =>
                        'La materia seleccionada pertenece al semestre ' .
                        $materia->semestre .
                        ', pero el grupo seleccionado es de ' .
                        $grupo->grado .
                        '°. Selecciona una materia del semestre correspondiente.',
                ])
                ->withInput();
        }

        /*
         * No permitir repetir la misma combinación
         * de docente, materia, grupo y ciclo escolar.
         */
        $duplicada = AsignacionMateria::where(
            'docente_id',
            $datos['docente_id']
        )
            ->where('materia_id', $datos['materia_id'])
            ->where('grupo_id', $datos['grupo_id'])
            ->where('ciclo_escolar_id', $datos['ciclo_escolar_id'])
            ->exists();

        if ($duplicada) {
            return back()
                ->withErrors([
                    'materia_id' =>
                        'Esta materia ya está asignada a ese docente y grupo durante el ciclo escolar seleccionado.',
                ])
                ->withInput();
        }

        AsignacionMateria::create([
            'docente_id' => $datos['docente_id'],
            'materia_id' => $datos['materia_id'],
            'grupo_id' => $datos['grupo_id'],
            'ciclo_escolar_id' => $datos['ciclo_escolar_id'],
        ]);

        return redirect()
            ->route('asignaciones_materias.index')
            ->with(
                'success',
                'Asignación de materia registrada correctamente.'
            );
    }

    /**
     * Mostrar una asignación específica.
     */
    public function show(string $id)
    {
        $asignacion = AsignacionMateria::with([
            'docente',
            'materia',
            'grupo',
            'cicloEscolar',
        ])->findOrFail($id);

        return view(
            'asignaciones_materias.show',
            compact('asignacion')
        );
    }

    /**
     * Mostrar el formulario de edición.
     */
    public function edit(string $id)
    {
        $asignacion = AsignacionMateria::findOrFail($id);

        $docentes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        $materias = Materia::orderBy('semestre')
            ->orderBy('nombre')
            ->get();

        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        $ciclosEscolares = CicloEscolar::orderByDesc('activo')
            ->orderByDesc('fecha_inicio')
            ->get();

        $semestres = collect(range(1, 6));

        return view('asignaciones_materias.edit', compact(
            'asignacion',
            'docentes',
            'materias',
            'grupos',
            'ciclosEscolares',
            'semestres'
        ));
    }

    /**
     * Actualizar una asignación existente.
     */
    public function update(Request $request, string $id)
    {
        $asignacion = AsignacionMateria::findOrFail($id);

        $datos = $request->validate([
            'docente_id' => [
                'required',
                'integer',
                'exists:docentes,id',
            ],

            'materia_id' => [
                'required',
                'integer',
                'exists:materias,id',
            ],

            'grupo_id' => [
                'required',
                'integer',
                'exists:grupos,id',
            ],

            'ciclo_escolar_id' => [
                'required',
                'integer',
                'exists:ciclos_escolares,id',
            ],
        ], [
            'docente_id.required' =>
                'Selecciona un docente.',

            'materia_id.required' =>
                'Selecciona una materia.',

            'grupo_id.required' =>
                'Selecciona un grupo.',

            'ciclo_escolar_id.required' =>
                'Selecciona un ciclo escolar.',
        ]);

        $materia = Materia::findOrFail($datos['materia_id']);
        $grupo = Grupo::findOrFail($datos['grupo_id']);

        if ((int) $materia->semestre !== (int) $grupo->grado) {
            return back()
                ->withErrors([
                    'materia_id' =>
                        'La materia no corresponde al semestre del grupo seleccionado.',
                ])
                ->withInput();
        }

        $duplicada = AsignacionMateria::where(
            'docente_id',
            $datos['docente_id']
        )
            ->where('materia_id', $datos['materia_id'])
            ->where('grupo_id', $datos['grupo_id'])
            ->where('ciclo_escolar_id', $datos['ciclo_escolar_id'])
            ->where('id', '!=', $asignacion->id)
            ->exists();

        if ($duplicada) {
            return back()
                ->withErrors([
                    'materia_id' =>
                        'Ya existe esta asignación para el docente, grupo y ciclo escolar seleccionados.',
                ])
                ->withInput();
        }

        $asignacion->update([
            'docente_id' => $datos['docente_id'],
            'materia_id' => $datos['materia_id'],
            'grupo_id' => $datos['grupo_id'],
            'ciclo_escolar_id' => $datos['ciclo_escolar_id'],
        ]);

        return redirect()
            ->route('asignaciones_materias.index')
            ->with(
                'success',
                'Asignación actualizada correctamente.'
            );
    }

    /**
     * Eliminar una asignación.
     */
    public function destroy(string $id)
    {
        $asignacion = AsignacionMateria::findOrFail($id);

        /*
         * Si la asignación ya tiene horarios relacionados,
         * la base de datos puede impedir su eliminación.
         */
        try {
            $asignacion->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()
                ->route('asignaciones_materias.index')
                ->with(
                    'error',
                    'No se puede eliminar esta asignación porque tiene horarios u otros registros relacionados.'
                );
        }

        return redirect()
            ->route('asignaciones_materias.index')
            ->with(
                'success',
                'Asignación eliminada correctamente.'
            );
    }
}