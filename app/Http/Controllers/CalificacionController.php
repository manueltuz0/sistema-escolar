<?php

namespace App\Http\Controllers;

use App\Models\Calificacion;
use App\Models\AsignacionMateria;
use App\Models\Grupo;
use App\Models\PeriodoEvaluacion;
use App\Models\Alumno;
use Illuminate\Http\Request;

class CalificacionController extends Controller
{
    /**
     * Mostrar pantalla de captura de calificaciones.
     */
    public function index(Request $request)
    {
        $grupoId = $request->grupo_id;
        $asignacionId = $request->asignacion_materia_id;
        $periodoId = $request->periodo_evaluacion_id;

        /*
        |--------------------------------------------------------------------------
        | BÚSQUEDA DE ALUMNOS PARA CONSULTAR BOLETA
        |--------------------------------------------------------------------------
        */

        $busquedaAlumno = $request->busqueda_alumno;

        $alumnosBusqueda = collect();

        if ($busquedaAlumno) {

            $alumnosBusqueda = Alumno::with('grupo')
                ->where(function ($query) use ($busquedaAlumno) {

                    $query->where(
                        'matricula',
                        'like',
                        '%' . $busquedaAlumno . '%'
                    )
                    ->orWhere(
                        'nombres',
                        'like',
                        '%' . $busquedaAlumno . '%'
                    )
                    ->orWhere(
                        'apellidos',
                        'like',
                        '%' . $busquedaAlumno . '%'
                    );

                })
                ->orderBy('apellidos')
                ->orderBy('nombres')
                ->limit(20)
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | GRUPOS
        |--------------------------------------------------------------------------
        */

        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MATERIAS ASIGNADAS AL GRUPO
        |--------------------------------------------------------------------------
        */

        $asignaciones = collect();

        if ($grupoId) {

            $asignaciones = AsignacionMateria::with([
                'materia',
                'grupo',
                'docente',
                'cicloEscolar'
            ])
                ->where('grupo_id', $grupoId)
                ->orderBy('materia_id')
                ->get();
        }


        /*
        |--------------------------------------------------------------------------
        | PERIODOS DE EVALUACIÓN
        |--------------------------------------------------------------------------
        */

        $periodos = PeriodoEvaluacion::where('activo', true)
            ->orderBy('orden')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | IDENTIFICAR PARCIALES
        |--------------------------------------------------------------------------
        */

        $parcial1 = $periodos->first(function ($periodo) {

            return strtolower(trim($periodo->nombre)) === 'parcial 1';

        });


        $parcial2 = $periodos->first(function ($periodo) {

            return strtolower(trim($periodo->nombre)) === 'parcial 2';

        });


        $parcial3 = $periodos->first(function ($periodo) {

            return strtolower(trim($periodo->nombre)) === 'parcial 3';

        });


        $periodoFinal = $periodos->first(function ($periodo) {

            return strtolower(trim($periodo->nombre)) === 'final';

        });


        /*
        |--------------------------------------------------------------------------
        | ALUMNOS DEL GRUPO
        |--------------------------------------------------------------------------
        */

        $alumnos = collect();


        /*
        |--------------------------------------------------------------------------
        | CALIFICACIONES
        |--------------------------------------------------------------------------
        */

        $calificaciones = collect();


        /*
        |--------------------------------------------------------------------------
        | ASIGNACIÓN SELECCIONADA
        |--------------------------------------------------------------------------
        */

        $asignacion = null;


        if ($grupoId && $asignacionId) {

            $asignacion = $asignaciones
                ->firstWhere('id', $asignacionId);


            if ($asignacion) {

                /*
                |--------------------------------------------------------------
                | Alumnos del grupo
                |--------------------------------------------------------------
                */

                $alumnos = Alumno::where(
                    'grupo_id',
                    $grupoId
                )
                    ->orderBy('apellidos')
                    ->orderBy('nombres')
                    ->get();


                /*
                |--------------------------------------------------------------
                | Calificaciones
                |--------------------------------------------------------------
                */

                $calificaciones = Calificacion::where(
                    'asignacion_materia_id',
                    $asignacionId
                )
                    ->whereHas('alumno', function ($query) use ($grupoId) {

                        $query->where(
                            'grupo_id',
                            $grupoId
                        );

                    })
                    ->get()
                    ->groupBy('alumno_id')
                    ->map(function ($items) {

                        return $items->keyBy(
                            'periodo_evaluacion_id'
                        );

                    });
            }
        }


        /*
        |--------------------------------------------------------------------------
        | MOSTRAR VISTA
        |--------------------------------------------------------------------------
        */

        return view(
            'calificaciones.index',
            compact(
                'grupos',
                'asignaciones',
                'periodos',
                'alumnos',
                'calificaciones',
                'grupoId',
                'asignacionId',
                'periodoId',
                'parcial1',
                'parcial2',
                'parcial3',
                'periodoFinal',
                'asignacion',
                'busquedaAlumno',
                'alumnosBusqueda'
            )
        );
    }


    /**
     * Guardar calificaciones.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'asignacion_materia_id' => [
                'required',
                'exists:asignaciones_materias,id'
            ],

            'calificaciones' => [
                'required',
                'array'
            ],

            'calificaciones.*' => [
                'array'
            ],

            'calificaciones.*.*' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | OBTENER ASIGNACIÓN
        |--------------------------------------------------------------------------
        */

        $asignacion = AsignacionMateria::findOrFail(
            $request->asignacion_materia_id
        );


        /*
        |--------------------------------------------------------------------------
        | GUARDAR CALIFICACIONES
        |--------------------------------------------------------------------------
        */

        foreach (
            $request->calificaciones
            as $alumnoId => $periodos
        ) {

            $alumno = Alumno::find($alumnoId);


            if (!$alumno) {
                continue;
            }


            /*
            |--------------------------------------------------------------
            | Verificar que el alumno pertenezca al grupo
            |--------------------------------------------------------------
            */

            if (
                (int) $alumno->grupo_id !==
                (int) $asignacion->grupo_id
            ) {
                continue;
            }


            /*
            |--------------------------------------------------------------
            | Guardar cada periodo
            |--------------------------------------------------------------
            */

            foreach (
                $periodos
                as $periodoId => $valor
            ) {

                /*
                | No guardar campos vacíos.
                */

                if (
                    $valor === null ||
                    $valor === ''
                ) {
                    continue;
                }


                /*
                | Buscar periodo.
                */

                $periodo = PeriodoEvaluacion::find(
                    $periodoId
                );


                if (!$periodo) {
                    continue;
                }


                /*
                | El FINAL no se captura manualmente.
                */

                if (
                    strtolower(
                        trim($periodo->nombre)
                    ) === 'final'
                ) {
                    continue;
                }


                /*
                | Crear o actualizar.
                */

                Calificacion::updateOrCreate(

                    [
                        'alumno_id' =>
                            $alumnoId,

                        'asignacion_materia_id' =>
                            $asignacion->id,

                        'periodo_evaluacion_id' =>
                            $periodoId,
                    ],

                    [
                        'calificacion' =>
                            $valor,
                    ]

                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | REGRESAR
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'calificaciones.index',
                [
                    'grupo_id' =>
                        $asignacion->grupo_id,

                    'asignacion_materia_id' =>
                        $asignacion->id,

                    'periodo_evaluacion_id' =>
                        $request->periodo_evaluacion_id,
                ]
            )
            ->with(
                'success',
                'Calificaciones guardadas correctamente.'
            );
    }


    /**
     * Mostrar la boleta completa de un alumno.
     */
    public function boleta(Alumno $alumno)
    {
        /*
        |--------------------------------------------------------------------------
        | TODAS LAS CALIFICACIONES DEL ALUMNO
        |--------------------------------------------------------------------------
        */

        $calificaciones = Calificacion::with([

            'asignacionMateria.materia',

            'asignacionMateria.grupo',

            'asignacionMateria.cicloEscolar',

            'periodoEvaluacion'

        ])
            ->where(
                'alumno_id',
                $alumno->id
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | MOSTRAR BOLETA
        |--------------------------------------------------------------------------
        */

        return view(
            'calificaciones.boleta',
            compact(
                'alumno',
                'calificaciones'
            )
        );
    }
}