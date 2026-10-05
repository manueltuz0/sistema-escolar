<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Boleta de Calificaciones</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 25px;
            background: #eeeeee;
            font-family: Arial, Helvetica, sans-serif;
            color: #222;
        }

        .boleta {
            width: 100%;
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border: 1px solid #bbb;
        }

        /* ENCABEZADO */

        .encabezado {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #333;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }

        .institucion {
            text-align: center;
            flex: 1;
        }

        .institucion .gobierno {
            font-size: 13px;
            font-weight: bold;
        }

        .institucion .cobay {
            font-size: 34px;
            font-weight: bold;
            letter-spacing: 2px;
            margin: 3px 0;
        }

        .institucion .subtitulo {
            font-size: 12px;
        }

        .titulo {
            text-align: center;
            font-size: 21px;
            font-weight: bold;
            margin: 12px 0;
        }

        /* DATOS DEL ALUMNO */

        .datos {
            border: 1px solid #777;
            padding: 10px;
            margin-bottom: 15px;
        }

        .datos-grid {
            display: grid;
            grid-template-columns: 1fr 1.5fr 1fr;
            gap: 8px 20px;
            font-size: 13px;
        }

        .dato {
            padding: 3px;
        }

        .dato strong {
            font-weight: bold;
        }

        /* TABLA */

        .tabla-boleta {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .tabla-boleta th,
        .tabla-boleta td {
            border: 1px solid #555;
            padding: 7px 5px;
        }

        .tabla-boleta th {
            background: #e8e8e8;
            text-align: center;
            font-weight: bold;
        }

        .tabla-boleta td {
            text-align: center;
        }

        .tabla-boleta .materia {
            text-align: left;
            font-weight: bold;
        }

        .tabla-boleta .clave {
            text-align: left;
            white-space: nowrap;
        }

        .promedio {
            font-weight: bold;
        }

        .vacio {
            color: #777;
        }

        /* RESUMEN */

        .resumen {
            margin-top: 15px;
            display: flex;
            justify-content: flex-end;
        }

        .promedio-general {
            border: 1px solid #555;
            padding: 10px 20px;
            font-size: 15px;
            font-weight: bold;
        }

        /* FIRMAS */

        .firmas {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 35px;
    margin-top: 70px;
    text-align: center;
    font-size: 12px;
    align-items: end;
}

.sello {
    display: flex;
    justify-content: center;
    align-items: center;
}

.sello-espacio {
    width: 150px;
    height: 70px;
    border-bottom: 1px solid #333;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    padding-bottom: 8px;
    font-size: 10px;
    font-weight: bold;
}


        .firma-linea {
            border-top: 1px solid #333;
            padding-top: 8px;
        }

        /* BOTONES */

        .acciones {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .boton {
            border: none;
            border-radius: 5px;
            padding: 10px 16px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .regresar {
            background: #6c757d;
            color: white;
        }

        .imprimir {
            background: #198754;
            color: white;
        }

        /* IMPRESIÓN */

        @media print {

            @page {
                size: landscape;
                margin: 10mm;
            }

            body {
                background: white;
                padding: 0;
            }

            .boleta {
                max-width: none;
                border: none;
                padding: 5px;
            }

            .acciones {
                display: none;
            }

            .tabla-boleta {
                font-size: 9px;
            }

            .tabla-boleta th,
            .tabla-boleta td {
                padding: 5px 3px;
            }
        }

    </style>
</head>

<body>

<div class="boleta">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="encabezado">

        <div class="institucion">

            <div class="gobierno">
                GOBIERNO DEL ESTADO DE YUCATÁN
            </div>

            <div class="cobay">
                COBAY
            </div>

            <div class="subtitulo">
                COLEGIO DE BACHILLERES DEL ESTADO DE YUCATÁN
            </div>

        </div>

    </div>


    <div class="titulo">
        BOLETA DE CALIFICACIONES
    </div>


    {{-- ========================================================= --}}
    {{-- DATOS DEL ALUMNO --}}
    {{-- ========================================================= --}}

    <div class="datos">

        <div class="datos-grid">

            <div class="dato">
                <strong>Matrícula:</strong>
                {{ $alumno->matricula }}
            </div>

            <div class="dato">
                <strong>Alumno:</strong>
                {{ $alumno->nombres }}
                {{ $alumno->apellidos }}
            </div>

            <div class="dato">
                <strong>Grupo:</strong>

                @if($alumno->grupo)

                    {{ $alumno->grupo->grado }}°{{ $alumno->grupo->nombre }}

                @else

                    Sin grupo

                @endif

            </div>


            <div class="dato">
                <strong>Plantel:</strong>
                CHICHIMILÁ
            </div>

            <div class="dato">
                <strong>Semestre:</strong>

                @if($alumno->grupo)
                    {{ $alumno->grupo->grado }}
                @else
                    —
                @endif

            </div>

            <div class="dato">
                <strong>Ciclo escolar:</strong>

                @php

                    $ciclo = $calificaciones
                        ->pluck('asignacionMateria.cicloEscolar')
                        ->filter()
                        ->first();

                @endphp

                {{ $ciclo ? $ciclo->nombre : '2026-2027' }}

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- CALIFICACIONES --}}
    {{-- ========================================================= --}}

    @if($calificaciones->count() > 0)

        @php

            /*
             * Obtener períodos existentes.
             */

            $periodos = $calificaciones
                ->pluck('periodoEvaluacion')
                ->filter()
                ->unique('id')
                ->sortBy('orden')
                ->values();


            /*
             * Separar parciales.
             */

            $parcial1 = $periodos->first(function ($periodo) {

                return strtolower(trim($periodo->nombre))
                    === 'parcial 1';

            });


            $parcial2 = $periodos->first(function ($periodo) {

                return strtolower(trim($periodo->nombre))
                    === 'parcial 2';

            });


            $parcial3 = $periodos->first(function ($periodo) {

                return strtolower(trim($periodo->nombre))
                    === 'parcial 3';

            });


            /*
             * Buscar examen ordinario si posteriormente
             * se agrega al sistema.
             */

            $examenOrdinario = $periodos->first(function ($periodo) {

                return strtolower(trim($periodo->nombre))
                    === 'examen ordinario';

            });


            /*
             * Agrupar por materia.
             */

            $materias = $calificaciones
                ->groupBy('asignacion_materia_id');


            /*
             * Promedios generales.
             */

            $promediosMaterias = [];

        @endphp


        <table class="tabla-boleta">

            <thead>

                <tr>

                    <th rowspan="2">
                        CLAVE
                    </th>

                    <th rowspan="2">
                        ASIGNATURA
                    </th>

                    <th colspan="3">
                        PARCIALES
                    </th>

                    <th rowspan="2">
                        PROMEDIO
                    </th>

                    <th rowspan="2">
                        EXAMEN<br>
                        ORDINARIO
                    </th>

                    <th rowspan="2">
                        CALIFICACIÓN<br>
                        FINAL
                    </th>

                </tr>

                <tr>

                    <th>
                        1
                    </th>

                    <th>
                        2
                    </th>

                    <th>
                        3
                    </th>

                </tr>

            </thead>


            <tbody>

                @foreach($materias as $grupoCalificaciones)

                    @php

                        $primera =
                            $grupoCalificaciones->first();

                        $materia =
                            $primera->asignacionMateria->materia;


                        /*
                         * Obtener cada parcial.
                         */

                        $cal1 = $parcial1
                            ? $grupoCalificaciones->firstWhere(
                                'periodo_evaluacion_id',
                                $parcial1->id
                            )
                            : null;


                        $cal2 = $parcial2
                            ? $grupoCalificaciones->firstWhere(
                                'periodo_evaluacion_id',
                                $parcial2->id
                            )
                            : null;


                        $cal3 = $parcial3
                            ? $grupoCalificaciones->firstWhere(
                                'periodo_evaluacion_id',
                                $parcial3->id
                            )
                            : null;


                        /*
                         * Obtener valores existentes.
                         */

                        $valores = collect([
                            $cal1?->calificacion,
                            $cal2?->calificacion,
                            $cal3?->calificacion
                        ])
                        ->filter(function ($valor) {

                            return $valor !== null;

                        })
                        ->map(function ($valor) {

                            return (float) $valor;

                        });


                        /*
                         * Promedio de los tres parciales.
                         */

                        $promedio = $valores->count() > 0
                            ? $valores->avg()
                            : null;


                        if ($promedio !== null) {

                            $promediosMaterias[] =
                                $promedio;

                        }


                        /*
                         * Examen ordinario.
                         */

                        $examen = $examenOrdinario
                            ? $grupoCalificaciones->firstWhere(
                                'periodo_evaluacion_id',
                                $examenOrdinario->id
                            )
                            : null;


                        /*
                         * Por ahora la calificación final
                         * utiliza el promedio de los parciales.
                         *
                         * Cuando agreguemos examen ordinario,
                         * aquí podremos cambiar la fórmula.
                         */

                        $final = $promedio;

                    @endphp


                    <tr>

                        <td class="clave">

                            {{ $materia->clave }}

                        </td>


                        <td class="materia">

                            {{ $materia->nombre }}

                        </td>


                        {{-- Parcial 1 --}}

                        <td>

                            @if($cal1)

                                {{ number_format(
                                    $cal1->calificacion,
                                    0
                                ) }}

                            @else

                                <span class="vacio">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- Parcial 2 --}}

                        <td>

                            @if($cal2)

                                {{ number_format(
                                    $cal2->calificacion,
                                    0
                                ) }}

                            @else

                                <span class="vacio">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- Parcial 3 --}}

                        <td>

                            @if($cal3)

                                {{ number_format(
                                    $cal3->calificacion,
                                    0
                                ) }}

                            @else

                                <span class="vacio">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- PROMEDIO --}}

                        <td class="promedio">

                            @if($promedio !== null)

                                {{ number_format(
                                    $promedio,
                                    2
                                ) }}

                            @else

                                —

                            @endif

                        </td>


                        {{-- EXAMEN ORDINARIO --}}

                        <td>

                            @if($examen)

                                {{ number_format(
                                    $examen->calificacion,
                                    0
                                ) }}

                            @else

                                <span class="vacio">
                                    —
                                </span>

                            @endif

                        </td>


                        {{-- CALIFICACIÓN FINAL --}}

                        <td class="promedio">

                            @if($final !== null)

                                {{ number_format(
                                    $final,
                                    2
                                ) }}

                            @else

                                —

                            @endif

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>


        {{-- ===================================================== --}}
        {{-- PROMEDIO GENERAL --}}
        {{-- ===================================================== --}}

        @php

            $promedioGeneral =
                count($promediosMaterias) > 0
                    ? array_sum($promediosMaterias)
                        / count($promediosMaterias)
                    : null;

        @endphp


        @if($promedioGeneral !== null)

            <div class="resumen">

                <div class="promedio-general">

                    PROMEDIO GENERAL:

                    {{ number_format(
                        $promedioGeneral,
                        2
                    ) }}

                </div>

            </div>

        @endif


    @else

        <div class="observaciones">

            No existen calificaciones registradas para este alumno.

        </div>

    @endif


    






{{-- ========================================================= --}}
{{-- FIRMAS Y SELLO --}}
{{-- ========================================================= --}}

<div class="firmas">

    <div>
        <div class="firma-linea">
            RESPONSABLE DE CONTROL ESCOLAR
        </div>
    </div>


    <div class="sello">

        <div class="firma-linea">
            SELLO DEL PLANTEL
        </div>

    </div>


    <div>
        <div class="firma-linea">
            DIRECCIÓN DEL PLANTEL
        </div>
    </div>

</div>


    {{-- ========================================================= --}}
    {{-- BOTONES --}}
    {{-- ========================================================= --}}

    <div class="acciones">

        <a
            href="{{ route('calificaciones.index') }}"
            class="boton regresar">

            Regresar

        </a>


        <button
            type="button"
            class="boton imprimir"
            onclick="window.print()">

            Imprimir / Guardar PDF

        </button>

    </div>

</div>

</body>

</html>