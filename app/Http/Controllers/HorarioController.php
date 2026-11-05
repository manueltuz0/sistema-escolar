<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\AsignacionMateria;
use App\Models\Grupo;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Aula;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HorarioController extends Controller
{
    /**
     * Mostrar la pantalla de captura rápida semanal.
     */
    public function capturaRapida(Request $request)
    {
        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        $grupoSeleccionado = null;
        $asignaciones = collect();
        $horarios = collect();

        if ($request->filled('grupo_id')) {
            $grupoSeleccionado = Grupo::findOrFail($request->grupo_id);

            $asignaciones = AsignacionMateria::with([
                'docente',
                'materia',
                'grupo',
                'cicloEscolar',
            ])
                ->where('grupo_id', $grupoSeleccionado->id)
                ->where('ciclo_escolar_id', $grupoSeleccionado->ciclo_escolar_id)
                ->get()
                ->sortBy(function ($asignacion) {
                    return $asignacion->materia->nombre ?? '';
                })
                ->values();

            $horarios = Horario::with([
                'asignacionMateria.docente',
                'asignacionMateria.materia',
                'asignacionMateria.grupo',
                'aula',
            ])
                ->whereHas('asignacionMateria', function ($query) use ($grupoSeleccionado) {
                    $query->where('grupo_id', $grupoSeleccionado->id)
                        ->where('ciclo_escolar_id', $grupoSeleccionado->ciclo_escolar_id);
                })
                ->get();
        }

        return view('horarios.captura-rapida', compact(
            'grupos',
            'grupoSeleccionado',
            'asignaciones',
            'horarios'
        ));
    }

    /**
     * Guardar la captura rápida de toda la semana.
     * Cada casilla seleccionada representa una clase de 50 minutos.
     * Las casillas vacías no eliminan ni modifican horarios existentes.
     */
    public function guardarCapturaRapida(Request $request)
    {
        $datos = $request->validate([
            'grupo_id' => ['required', 'integer', 'exists:grupos,id'],
            'clases' => ['nullable', 'array'],
            'clases.*' => ['nullable', 'array'],
            'clases.*.*' => ['nullable', 'integer', 'exists:asignaciones_materias,id'],
        ]);

        $grupo = Grupo::findOrFail($datos['grupo_id']);

        $dias = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

        $bloques = [
            ['inicio' => '07:00', 'fin' => '07:50'],
            ['inicio' => '07:50', 'fin' => '08:40'],
            ['inicio' => '08:40', 'fin' => '09:30'],
            ['inicio' => '10:00', 'fin' => '10:50'],
            ['inicio' => '10:50', 'fin' => '11:40'],
            ['inicio' => '11:40', 'fin' => '12:30'],
            ['inicio' => '12:30', 'fin' => '13:20'],
            ['inicio' => '13:20', 'fin' => '14:10'],
        ];

        $clases = $datos['clases'] ?? [];

        // Validar días y bloques recibidos desde el formulario.
        foreach ($clases as $dia => $selecciones) {
            if (!in_array($dia, $dias, true)) {
                throw ValidationException::withMessages([
                    'clases' => 'Se recibió un día no válido.',
                ]);
            }

            foreach ($selecciones as $indice => $asignacionId) {
                if (!ctype_digit((string) $indice) || !array_key_exists((int) $indice, $bloques)) {
                    throw ValidationException::withMessages([
                        'clases' => 'Se recibió un bloque de horario no válido.',
                    ]);
                }
            }
        }

        $guardados = 0;

        DB::transaction(function () use ($clases, $grupo, $dias, $bloques, &$guardados) {
            foreach ($dias as $dia) {
                foreach ($bloques as $indice => $bloque) {
                    $asignacionId = $clases[$dia][$indice] ?? null;

                    // No guardar casillas vacías.
                    if (!$asignacionId) {
                        continue;
                    }

                    // Asegurarse de que la materia pertenece al grupo y ciclo elegidos.
                    $asignacion = AsignacionMateria::with([
                        'docente',
                        'materia',
                        'grupo',
                    ])
                        ->where('id', $asignacionId)
                        ->where('grupo_id', $grupo->id)
                        ->where('ciclo_escolar_id', $grupo->ciclo_escolar_id)
                        ->first();

                    if (!$asignacion) {
                        throw ValidationException::withMessages([
                            'clases' => 'Una de las materias seleccionadas no pertenece al grupo elegido.',
                        ]);
                    }

                    $conflicto = $this->buscarConflicto(
                        $asignacion,
                        $dia,
                        $bloque['inicio'],
                        $bloque['fin']
                    );

                    if ($conflicto !== null) {
                        $nombreMateria = $asignacion->materia->nombre ?? 'la materia';

                        throw ValidationException::withMessages([
                            'clases' => $dia . ', ' . $bloque['inicio'] . '–' . $bloque['fin'] . ': ' . $nombreMateria . '. ' . $conflicto,
                        ]);
                    }

                    $aula = $this->buscarAulaDisponible(
                        $asignacion,
                        $dia,
                        $bloque['inicio'],
                        $bloque['fin']
                    );

                    if (!$aula) {
                        throw ValidationException::withMessages([
                            'clases' => 'No hay aulas disponibles el ' . $dia . ' de ' . $bloque['inicio'] . ' a ' . $bloque['fin'] . '.',
                        ]);
                    }

                    Horario::create([
                        'asignacion_materia_id' => $asignacion->id,
                        'aula_id' => $aula->id,
                        'dia' => $dia,
                        'hora_inicio' => $bloque['inicio'],
                        'hora_fin' => $bloque['fin'],
                    ]);

                    $guardados++;
                }
            }
        });

        return redirect()
            ->route('horarios.captura-rapida', ['grupo_id' => $grupo->id])
            ->with(
                'success',
                $guardados > 0
                    ? "Se registraron {$guardados} bloques de clase correctamente."
                    : 'No se registraron clases porque no seleccionaste ninguna casilla.'
            );
    }

    /**
     * Mostrar horarios y permitir consultarlos por semestre,
     * grado, grupo y docente.
     */
    public function index(Request $request)
    {
        $grado = $request->grado;
        $grupoId = $request->grupo_id;
        $docenteId = $request->docente_id;
        $semestre = $request->semestre;

        $query = Horario::with([
            'asignacionMateria.docente',
            'asignacionMateria.materia',
            'asignacionMateria.grupo',
            'asignacionMateria.cicloEscolar',
            'aula',
        ]);

        // Filtrar por grado.
        if ($grado !== null && $grado !== '') {
            $query->whereHas('asignacionMateria.grupo', function ($q) use ($grado) {
                $q->where('grado', $grado);
            });
        }

        // Filtrar por grupo.
        if ($grupoId !== null && $grupoId !== '') {
            $query->whereHas('asignacionMateria.grupo', function ($q) use ($grupoId) {
                $q->where('id', $grupoId);
            });
        }

        // Filtrar por docente.
        if ($docenteId !== null && $docenteId !== '') {
            $query->whereHas('asignacionMateria.docente', function ($q) use ($docenteId) {
                $q->where('id', $docenteId);
            });
        }

        // Filtrar por semestre de la materia.
        if ($semestre !== null && $semestre !== '') {
            $query->whereHas('asignacionMateria.materia', function ($q) use ($semestre) {
                $q->where('semestre', $semestre);
            });
        }

        // Ordenar los horarios por día y hora.
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

        // Grados disponibles.
        $grados = Grupo::select('grado')
            ->distinct()
            ->orderBy('grado')
            ->pluck('grado');

        // Grupos disponibles.
        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        // Docentes disponibles.
        $docentes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        // Semestres que tienen materias asignadas.
        $semestres = Materia::query()
            ->whereNotNull('semestre')
            ->whereIn('id', function ($subquery) {
                $subquery->select('materia_id')
                    ->from('asignaciones_materias');
            })
            ->distinct()
            ->orderBy('semestre')
            ->pluck('semestre');

        return view('horarios.index', compact(
            'horarios',
            'grados',
            'grupos',
            'docentes',
            'grado',
            'grupoId',
            'docenteId',
            'semestre',
            'semestres'
        ));
    }

    /**
     * Mostrar el formulario para registrar un horario.
     */
    public function create()
    {
        $docentes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        $materias = Materia::orderBy('nombre')
            ->get();

        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        $asignaciones = AsignacionMateria::with([
            'docente',
            'materia',
            'grupo',
            'cicloEscolar',
        ])
            ->get()
            ->sortBy(function ($asignacion) {
                return
                    ($asignacion->docente->apellidos ?? '') . ' ' .
                    ($asignacion->docente->nombres ?? '') . ' ' .
                    ($asignacion->materia->nombre ?? '') . ' ' .
                    ($asignacion->grupo->grado ?? '') . ' ' .
                    ($asignacion->grupo->nombre ?? '');
            })
            ->values();

        return view('horarios.create', compact(
            'docentes',
            'materias',
            'grupos',
            'asignaciones'
        ));
    }

    /**
     * Registrar un horario y asignar un aula automáticamente.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asignacion_materia_id' => [
                'required',
                'exists:asignaciones_materias,id',
            ],
            'dia' => [
                'required',
                'in:Lunes,Martes,Miércoles,Jueves,Viernes',
            ],
            'hora_inicio' => [
                'required',
                'date_format:H:i',
            ],
            'hora_fin' => [
                'required',
                'date_format:H:i',
                'after:hora_inicio',
            ],
        ], [
            'asignacion_materia_id.required' => 'Selecciona una asignación de materia.',
            'asignacion_materia_id.exists' => 'La asignación seleccionada no existe.',
            'dia.required' => 'Selecciona el día de la clase.',
            'dia.in' => 'El día seleccionado no es válido.',
            'hora_inicio.required' => 'Indica la hora de inicio.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_fin.required' => 'Indica la hora de finalización.',
            'hora_fin.date_format' => 'La hora de finalización debe tener el formato HH:MM.',
            'hora_fin.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $asignacion = AsignacionMateria::with([
            'docente',
            'materia',
            'grupo',
        ])->findOrFail($request->asignacion_materia_id);

        $conflicto = $this->buscarConflicto(
            $asignacion,
            $request->dia,
            $request->hora_inicio,
            $request->hora_fin
        );

        if ($conflicto !== null) {
            return back()
                ->withErrors(['horario' => $conflicto])
                ->withInput();
        }

        $aula = $this->buscarAulaDisponible(
            $asignacion,
            $request->dia,
            $request->hora_inicio,
            $request->hora_fin
        );

        if (!$aula) {
            return back()
                ->withErrors([
                    'horario' => 'No hay aulas disponibles en ese día y horario. Prueba con otro horario.',
                ])
                ->withInput();
        }

        Horario::create([
            'asignacion_materia_id' => $asignacion->id,
            'aula_id' => $aula->id,
            'dia' => $request->dia,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()
            ->route('horarios.index')
            ->with(
                'success',
                'Horario registrado correctamente. Aula asignada automáticamente: ' . $aula->nombre . '.'
            );
    }
     
/**
 * Generar el horario grupal para imprimir.
 */
public function imprimirGrupo(string $grupo)
{
    $grupo = Grupo::findOrFail($grupo);

    $horarios = Horario::with([
        'asignacionMateria.docente',
        'asignacionMateria.materia',
        'asignacionMateria.grupo',
        'asignacionMateria.cicloEscolar',
        'aula',
    ])
        ->whereHas('asignacionMateria', function ($query) use ($grupo) {
            $query->where('grupo_id', $grupo->id)
                ->where('ciclo_escolar_id', $grupo->ciclo_escolar_id);
        })
        ->orderBy('hora_inicio')
        ->get()
        ->sortBy(function ($horario) {
            $ordenDias = [
                'Lunes' => 1,
                'Martes' => 2,
                'Miércoles' => 3,
                'Jueves' => 4,
                'Viernes' => 5,
            ];

            return ($ordenDias[$horario->dia] ?? 99)
                . '-' . $horario->hora_inicio;
        })
        ->values();

    $diasSemana = [
        'Lunes',
        'Martes',
        'Miércoles',
        'Jueves',
        'Viernes',
    ];

    $bloques = [
        ['inicio' => '07:00', 'fin' => '07:50'],
        ['inicio' => '07:50', 'fin' => '08:40'],
        ['inicio' => '08:40', 'fin' => '09:30'],
        ['inicio' => '10:00', 'fin' => '10:50'],
        ['inicio' => '10:50', 'fin' => '11:40'],
        ['inicio' => '11:40', 'fin' => '12:30'],
        ['inicio' => '12:30', 'fin' => '13:20'],
        ['inicio' => '13:20', 'fin' => '14:10'],
    ];

    return view('horarios.imprimir-grupo', compact(
        'grupo',
        'horarios',
        'diasSemana',
        'bloques'
    ));
}

    /**
     * Mostrar los detalles de un horario.
     */
    public function show(string $id)
    {
        $horario = Horario::with([
            'asignacionMateria.docente',
            'asignacionMateria.materia',
            'asignacionMateria.grupo',
            'asignacionMateria.cicloEscolar',
            'aula',
        ])->findOrFail($id);

        return view('horarios.show', compact('horario'));
    }

    /**
     * Mostrar el formulario de edición.
     */
    public function edit(string $id)
    {
        $horario = Horario::with([
            'asignacionMateria.docente',
            'asignacionMateria.materia',
            'asignacionMateria.grupo',
            'asignacionMateria.cicloEscolar',
            'aula',
        ])->findOrFail($id);

        $docentes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        $materias = Materia::orderBy('nombre')
            ->get();

        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        $asignaciones = AsignacionMateria::with([
            'docente',
            'materia',
            'grupo',
            'cicloEscolar',
        ])->get();

        return view('horarios.edit', compact(
            'horario',
            'docentes',
            'materias',
            'grupos',
            'asignaciones'
        ));
    }

    /**
     * Actualizar un horario conservando las validaciones.
     */
    public function update(Request $request, string $id)
    {
        $horario = Horario::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'asignacion_materia_id' => [
                'required',
                'exists:asignaciones_materias,id',
            ],
            'dia' => [
                'required',
                'in:Lunes,Martes,Miércoles,Jueves,Viernes',
            ],
            'hora_inicio' => [
                'required',
                'date_format:H:i',
            ],
            'hora_fin' => [
                'required',
                'date_format:H:i',
                'after:hora_inicio',
            ],
        ], [
            'asignacion_materia_id.required' => 'Selecciona una asignación de materia.',
            'asignacion_materia_id.exists' => 'La asignación seleccionada no existe.',
            'dia.required' => 'Selecciona el día de la clase.',
            'dia.in' => 'El día seleccionado no es válido.',
            'hora_inicio.required' => 'Indica la hora de inicio.',
            'hora_inicio.date_format' => 'La hora de inicio debe tener el formato HH:MM.',
            'hora_fin.required' => 'Indica la hora de finalización.',
            'hora_fin.date_format' => 'La hora de finalización debe tener el formato HH:MM.',
            'hora_fin.after' => 'La hora de finalización debe ser posterior a la hora de inicio.',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $asignacion = AsignacionMateria::with([
            'docente',
            'materia',
            'grupo',
        ])->findOrFail($request->asignacion_materia_id);

        $conflicto = $this->buscarConflicto(
            $asignacion,
            $request->dia,
            $request->hora_inicio,
            $request->hora_fin,
            $horario->id
        );

        if ($conflicto !== null) {
            return back()
                ->withErrors(['horario' => $conflicto])
                ->withInput();
        }

        $aula = $this->buscarAulaDisponible(
            $asignacion,
            $request->dia,
            $request->hora_inicio,
            $request->hora_fin,
            $horario->id
        );

        if (!$aula) {
            return back()
                ->withErrors([
                    'horario' => 'No hay aulas disponibles en ese día y horario. Prueba con otro horario.',
                ])
                ->withInput();
        }

        $horario->update([
            'asignacion_materia_id' => $asignacion->id,
            'aula_id' => $aula->id,
            'dia' => $request->dia,
            'hora_inicio' => $request->hora_inicio,
            'hora_fin' => $request->hora_fin,
        ]);

        return redirect()
            ->route('horarios.index')
            ->with(
                'success',
                'Horario actualizado correctamente. Aula asignada automáticamente: ' . $aula->nombre . '.'
            );
    }

    /**
     * Eliminar un horario.
     */
    public function destroy(string $id)
    {
        $horario = Horario::findOrFail($id);

        $horario->delete();

        return redirect()
            ->route('horarios.index')
            ->with('success', 'Horario eliminado correctamente.');
    }
    
/**
 * Actualiza la materia asignada a una clase desde la captura rápida.
 */
public function actualizarCapturaRapida(Request $request, string $horario)
{
    $datos = $request->validate([
        'grupo_id' => ['required', 'exists:grupos,id'],
        'asignacion_materia_id' => [
            'required',
            'exists:asignaciones_materias,id',
        ],
    ]);

    $registro = Horario::findOrFail($horario);
    $grupo = Grupo::findOrFail($datos['grupo_id']);

    // Verificar que la clase pertenezca al grupo seleccionado.
    $perteneceAlGrupo = AsignacionMateria::where(
        'id',
        $registro->asignacion_materia_id
    )
        ->where('grupo_id', $grupo->id)
        ->exists();

    if (!$perteneceAlGrupo) {
        return redirect()
            ->route('horarios.captura-rapida', [
                'grupo_id' => $grupo->id,
            ])
            ->withErrors([
                'clase' => 'La clase seleccionada no pertenece a este grupo.',
            ]);
    }

    // Verificar que la nueva asignación corresponda al mismo grupo.
    $asignacion = AsignacionMateria::where(
        'id',
        $datos['asignacion_materia_id']
    )
        ->where('grupo_id', $grupo->id)
        ->first();

    if (!$asignacion) {
        return redirect()
            ->route('horarios.captura-rapida', [
                'grupo_id' => $grupo->id,
            ])
            ->withErrors([
                'clase' => 'La materia seleccionada no corresponde a este grupo.',
            ]);
    }

    // Comprobar empalmes con el docente o el grupo.
    $conflicto = $this->buscarConflicto(
        $asignacion,
        $registro->dia,
        substr((string) $registro->hora_inicio, 0, 5),
        substr((string) $registro->hora_fin, 0, 5),
        $registro->id
    );

    if ($conflicto) {
        return redirect()
            ->route('horarios.captura-rapida', [
                'grupo_id' => $grupo->id,
            ])
            ->withErrors(['clase' => $conflicto]);
    }

    // Buscar un aula disponible para la nueva asignación.
    $aula = $this->buscarAulaDisponible(
        $asignacion,
        $registro->dia,
        substr((string) $registro->hora_inicio, 0, 5),
        substr((string) $registro->hora_fin, 0, 5),
        $registro->id
    );

    if (!$aula) {
        return redirect()
            ->route('horarios.captura-rapida', [
                'grupo_id' => $grupo->id,
            ])
            ->withErrors([
                'clase' => 'No hay un aula disponible para ese horario.',
            ]);
    }

    // Actualizar la materia y el aula, conservando día y horario.
    $registro->asignacion_materia_id = $asignacion->id;
    $registro->aula_id = $aula->id;
    $registro->save();

    return redirect()
        ->route('horarios.captura-rapida', [
            'grupo_id' => $grupo->id,
        ])
        ->with('success', 'La clase se actualizó correctamente.');
}

/**
 * Elimina una clase desde la captura rápida.
 */
public function eliminarCapturaRapida(Request $request, string $horario)
{
    $datos = $request->validate([
        'grupo_id' => ['required', 'exists:grupos,id'],
    ]);

    $registro = Horario::findOrFail($horario);
    $grupo = Grupo::findOrFail($datos['grupo_id']);

    // Impedir que se elimine una clase de otro grupo.
    $perteneceAlGrupo = AsignacionMateria::where(
        'id',
        $registro->asignacion_materia_id
    )
        ->where('grupo_id', $grupo->id)
        ->exists();

    if (!$perteneceAlGrupo) {
        return redirect()
            ->route('horarios.captura-rapida', [
                'grupo_id' => $grupo->id,
            ])
            ->withErrors([
                'clase' => 'La clase seleccionada no pertenece a este grupo.',
            ]);
    }

    $registro->delete();

    return redirect()
        ->route('horarios.captura-rapida', [
            'grupo_id' => $grupo->id,
        ])
        ->with('success', 'La clase se eliminó correctamente.');
}

    /**
     * Comprobar que el docente y el grupo no tengan
     * otra clase traslapada en el mismo ciclo escolar.
     */
    private function buscarConflicto(
        AsignacionMateria $asignacion,
        string $dia,
        string $horaInicio,
        string $horaFin,
        ?int $excluirHorarioId = null
    ): ?string {
        $consultaBase = Horario::query()
            ->where('dia', $dia)
            ->where('hora_inicio', '<', $horaFin)
            ->where('hora_fin', '>', $horaInicio)
            ->when($excluirHorarioId, function ($query) use ($excluirHorarioId) {
                $query->where('id', '!=', $excluirHorarioId);
            });

        $conflictoDocente = (clone $consultaBase)
            ->whereHas('asignacionMateria', function ($query) use ($asignacion) {
                $query->where('docente_id', $asignacion->docente_id)
                    ->where('ciclo_escolar_id', $asignacion->ciclo_escolar_id);
            })
            ->exists();

        if ($conflictoDocente) {
            return 'El docente ya tiene otra clase programada durante ese horario.';
        }

        $conflictoGrupo = (clone $consultaBase)
            ->whereHas('asignacionMateria', function ($query) use ($asignacion) {
                $query->where('grupo_id', $asignacion->grupo_id)
                    ->where('ciclo_escolar_id', $asignacion->ciclo_escolar_id);
            })
            ->exists();

        if ($conflictoGrupo) {
            return 'El grupo ya tiene otra materia programada durante ese horario.';
        }

        return null;
    }

    /**
     * Buscar un aula disponible que no tenga otra clase
     * traslapada en ese horario y ciclo escolar.
     */
    private function buscarAulaDisponible(
        AsignacionMateria $asignacion,
        string $dia,
        string $horaInicio,
        string $horaFin,
        ?int $excluirHorarioId = null
    ): ?Aula {
        $aulas = Aula::where('disponible', true)
            ->orderBy('id')
            ->get();

        foreach ($aulas as $aula) {
            $ocupada = Horario::query()
                ->where('aula_id', $aula->id)
                ->where('dia', $dia)
                ->where('hora_inicio', '<', $horaFin)
                ->where('hora_fin', '>', $horaInicio)
                ->whereHas('asignacionMateria', function ($query) use ($asignacion) {
                    $query->where('ciclo_escolar_id', $asignacion->ciclo_escolar_id);
                })
                ->when($excluirHorarioId, function ($query) use ($excluirHorarioId) {
                    $query->where('id', '!=', $excluirHorarioId);
                })
                ->exists();

            if (!$ocupada) {
                return $aula;
            }
        }

        return null;
    }
}