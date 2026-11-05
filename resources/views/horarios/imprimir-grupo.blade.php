<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horario grupal - COBAY</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: #111;
            font-size: 9px;
        }

        .acciones {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 15px;
        }

        .boton {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            background: #7B1E3A;
            color: white;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
        }

        .encabezado {
            display: grid;
            grid-template-columns: 1fr 3fr 1fr;
            align-items: center;
            text-align: center;
            gap: 10px;
            margin-bottom: 12px;
        }

        .logo-texto {
            font-size: 13px;
            font-weight: bold;
            color: #7B1E3A;
        }

        .titulo h1 {
            font-size: 15px;
            margin: 2px 0;
        }

        .titulo p {
            margin: 3px 0;
            font-weight: bold;
        }

        .datos {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 5px 18px;
            margin-bottom: 12px;
            font-size: 10px;
        }

        .dato {
            border-bottom: 1px solid #555;
            padding: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #333;
            padding: 4px 3px;
            text-align: center;
            overflow-wrap: anywhere;
        }

        th {
            background: #e9e9e9;
            font-weight: bold;
        }

        .tabla-horario th:first-child,
        .tabla-horario td:first-child {
            width: 85px;
            font-weight: bold;
        }

        .tabla-horario td {
            height: 48px;
            vertical-align: middle;
        }

        .materia {
            font-weight: bold;
            font-size: 9px;
        }

        .docente {
            display: block;
            font-size: 8px;
            margin-top: 4px;
        }

        .descanso td {
            height: auto;
            background: #e9e9e9;
            font-weight: bold;
            letter-spacing: 3px;
            padding: 5px;
        }

        .subtitulo {
            margin: 14px 0 5px;
            font-size: 11px;
            font-weight: bold;
        }

        .tabla-asignaturas th,
        .tabla-asignaturas td {
            padding: 4px;
            text-align: left;
            font-size: 8px;
        }

        .tabla-asignaturas th:nth-child(2),
        .tabla-asignaturas td:nth-child(2),
        .tabla-asignaturas th:nth-child(3),
        .tabla-asignaturas td:nth-child(3) {
            text-align: center;
            width: 90px;
        }

        .tabla-asignaturas th:last-child,
        .tabla-asignaturas td:last-child {
            width: 30%;
        }

        .firmas {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 30px;
            margin-top: 25px;
            text-align: center;
            font-size: 8px;
        }

        .firma {
            border-top: 1px solid #333;
            padding-top: 5px;
        }

        .nota {
            margin-top: 8px;
            font-size: 8px;
        }

        @media print {
            .acciones {
                display: none;
            }

            body {
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    <div class="acciones">
        <button class="boton" onclick="window.print()">
            Imprimir / Guardar PDF
        </button>

        <a href="{{ route('horarios.index') }}" class="boton">
            Regresar
        </a>
    </div>

    <header class="encabezado">
        <div class="logo-texto">
            GOBIERNO<br>
            DEL ESTADO DE YUCATÁN
        </div>

        <div class="titulo">
            <h1>COLEGIO DE BACHILLERES DEL ESTADO DE YUCATÁN</h1>
            <p>PLANTEL CHICHIMILÁ</p>
            <p>HORARIO GRUPAL MATUTINO</p>
        </div>

        <div class="logo-texto">
            COBAY<br>
            CHICHIMILÁ
        </div>
    </header>

    <section class="datos">
        <div class="dato">
            <strong>PLANTEL:</strong> CHICHIMILÁ
        </div>

        <div class="dato">
            <strong>CICLO ESCOLAR:</strong>
            {{ $horarios->first()?->asignacionMateria?->cicloEscolar?->nombre ?? '2026-2027' }}
        </div>

        <div class="dato">
            <strong>TURNO:</strong> MATUTINO
        </div>

        <div class="dato">
            <strong>GRUPO:</strong>
            {{ $grupo->grado }}° {{ $grupo->nombre }}
        </div>

        <div class="dato">
            <strong>SEMESTRE:</strong>
            {{ $horarios->first()?->asignacionMateria?->materia?->semestre
                ?? $grupo->grado }}°
        </div>

        <div class="dato">
            <strong>TOTAL DE HORAS:</strong>
            {{ $horarios->count() }}
            clases registradas
        </div>
    </section>

    <table class="tabla-horario">
        <thead>
            <tr>
                <th>HORA</th>
                @foreach($diasSemana as $dia)
                    <th>{{ mb_strtoupper($dia) }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach($bloques as $bloque)
                @if($bloque['inicio'] === '10:00')
                    <tr class="descanso">
                        <td colspan="6">D E S C A N S O</td>
                    </tr>
                @endif

                <tr>
                    <td>
                        {{ $bloque['inicio'] }}–{{ $bloque['fin'] }}
                    </td>

                    @foreach($diasSemana as $dia)
                        @php
                            $clase = $horarios->first(function ($horario) use ($dia, $bloque) {
                                return $horario->dia === $dia
                                    && substr((string) $horario->hora_inicio, 0, 5) === $bloque['inicio']
                                    && substr((string) $horario->hora_fin, 0, 5) === $bloque['fin'];
                            });
                        @endphp

                        <td>
                            @if($clase)
                                <span class="materia">
                                    {{ $clase->asignacionMateria->materia->nombre ?? 'Sin materia' }}
                                </span>

                                <span class="docente">
                                    {{ $clase->asignacionMateria->docente->nombres ?? '' }}
                                    {{ $clase->asignacionMateria->docente->apellidos ?? '' }}
                                </span>
                            @else
                                —
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2 class="subtitulo">ASIGNATURAS Y DOCENTES</h2>

    <table class="tabla-asignaturas">
        <thead>
            <tr>
                <th>ASIGNATURA</th>
                <th>HORAS PROGRAMADAS</th>
                <th>ID DOCENTE</th>
                <th>DOCENTE QUE LA IMPARTE</th>
            </tr>
        </thead>

        <tbody>
            @php
                $asignaturas = $horarios
                    ->groupBy('asignacion_materia_id');
            @endphp

            @forelse($asignaturas as $clases)
                @php
                    $primera = $clases->first();
                    $asignacion = $primera->asignacionMateria;
                    $horasMateria = $clases->sum(function ($horario) {
                        return (
                            \Carbon\Carbon::parse($horario->hora_fin)->diffInMinutes(
                                \Carbon\Carbon::parse($horario->hora_inicio)
                            )
                        ) / 50;
                    });
                @endphp

                <tr>
                    <td>
                        {{ $asignacion->materia->nombre ?? 'Sin materia' }}
                    </td>

                    <td>{{ number_format($horasMateria, 1) }}</td>

                    <td>{{ $asignacion->docente->id ?? '—' }}</td>

                    <td>
                        {{ $asignacion->docente->nombres ?? '' }}
                        {{ $asignacion->docente->apellidos ?? '' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">
                        Aún no se han registrado horarios para este grupo.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="nota">
        Documento generado por el Sistema Escolar.
        Verifica que todas las clases estén programadas antes de imprimir.
    </p>

    <div class="firmas">
        <div class="firma">
            DOCENTE RESPONSABLE
        </div>

        <div class="firma">
            SELLO DEL PLANTEL
        </div>

        <div class="firma">
            DIRECCIÓN ACADÉMICA
        </div>
    </div>

</body>
</html>
