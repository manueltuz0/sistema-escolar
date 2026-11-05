@extends('layouts.app')

@section('content')

<style>
    .actividad-container {
        max-width: 1100px;
        margin: 25px auto;
        padding: 0 15px;
        color: #4b2633;
    }

    .actividad-card {
        background: #fff;
        border: 1px solid #eadde2;
        border-radius: 13px;
        margin-bottom: 22px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(70, 20, 40, .06);
    }

    .actividad-header {
        background: #f8edf1;
        color: #7b1e3a;
        padding: 16px 20px;
        font-weight: 700;
        border-bottom: 1px solid #eadde2;
    }

    .actividad-body {
        padding: 22px;
    }

    .datos-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
    }

    .dato {
        padding-bottom: 12px;
        border-bottom: 1px solid #f0e8eb;
    }

    .dato-label {
        display: block;
        font-size: 13px;
        color: #806b73;
        margin-bottom: 5px;
    }

    .dato-valor {
        font-weight: 600;
        color: #4b2633;
    }

    .descripcion {
        background: #fcf7f9;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
        line-height: 1.6;
        white-space: pre-line;
    }

    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .tabla-alumnos {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .tabla-alumnos th {
        background: #f8edf1;
        color: #7b1e3a;
        text-align: left;
        padding: 13px;
        font-size: 13px;
    }

    .tabla-alumnos td {
        padding: 13px;
        border-bottom: 1px solid #eee5e9;
        vertical-align: middle;
    }

    .tabla-alumnos tr:hover {
        background: #fcf7f9;
    }

    .estado {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .estado-presente {
        background: #e5f5eb;
        color: #18733c;
    }

    .estado-ausente {
        background: #fde8e8;
        color: #b42318;
    }

    .estado-justificado {
        background: #fff3d6;
        color: #946200;
    }

    .resumen {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 20px;
    }

    .resumen-item {
        background: #fcf7f9;
        border: 1px solid #eadde2;
        border-radius: 9px;
        padding: 15px;
        text-align: center;
    }

    .resumen-numero {
        display: block;
        font-size: 25px;
        font-weight: 700;
        color: #7b1e3a;
    }

    .resumen-texto {
        font-size: 12px;
        color: #806b73;
    }

    .btn-custom {
        display: inline-block;
        padding: 11px 20px;
        border-radius: 7px;
        text-decoration: none;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .btn-volver {
        background: #eee7ea;
        color: #603443;
    }

    .btn-volver:hover {
        background: #e4d8de;
        color: #603443;
    }

    .btn-editar {
        background: #7b1e3a;
        color: #fff;
    }

    .btn-editar:hover {
        background: #5d142b;
        color: #fff;
    }

    .acciones {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .sin-datos {
        text-align: center;
        padding: 25px;
        color: #806b73;
    }

    @media(max-width: 650px) {
        .datos-grid {
            grid-template-columns: 1fr;
        }

        .resumen {
            grid-template-columns: 1fr;
        }

        .acciones {
            flex-direction: column;
            align-items: stretch;
        }

        .acciones a {
            text-align: center;
        }
    }
</style>

<div class="actividad-container">

    {{-- ENCABEZADO --}}
    <div style="margin-bottom:22px;">

        <h2 style="color:#7b1e3a; margin-bottom:5px;">
            Detalle de actividad grupal
        </h2>

        <p style="color:#806b73; margin:0;">
            Consulta la información y los participantes de esta actividad.
        </p>

    </div>

    {{-- ÚNICOS BOTONES DE ACCIÓN --}}
    <div class="acciones">

        <a href="{{ route('tutorias.actividades.index') }}"
           class="btn-custom btn-volver">
            ← Volver a actividades
        </a>

        <a href="{{ route('tutorias.actividades.edit', $actividad->id) }}"
           class="btn-custom btn-editar">
            Editar actividad
        </a>

    </div>

    {{-- INFORMACIÓN GENERAL --}}
    <div class="actividad-card">

        <div class="actividad-header">
            Información general de la actividad
        </div>

        <div class="actividad-body">

            <div class="datos-grid">

                <div class="dato">
                    <span class="dato-label">Docente responsable</span>

                    <span class="dato-valor">
                        {{ $actividad->docente
                            ? $actividad->docente->nombres . ' ' . $actividad->docente->apellidos
                            : 'No disponible' }}
                    </span>
                </div>

                <div class="dato">
                    <span class="dato-label">Grupo</span>

                    <span class="dato-valor">
                        {{ $actividad->grupo
                            ? $actividad->grupo->grado . '.' . $actividad->grupo->nombre
                            : 'No disponible' }}
                    </span>
                </div>

                <div class="dato">
                    <span class="dato-label">Ciclo escolar</span>

                    <span class="dato-valor">
                        {{ $actividad->cicloEscolar?->nombre ?? 'No disponible' }}
                    </span>
                </div>

                <div class="dato">
                    <span class="dato-label">Fecha de actividad</span>

                    <span class="dato-valor">
                        {{ $actividad->fecha?->format('d/m/Y') ?? 'No disponible' }}
                    </span>
                </div>

                <div class="dato">
                    <span class="dato-label">Tema</span>

                    <span class="dato-valor">
                        {{ $actividad->tema }}
                    </span>
                </div>

                <div class="dato">
                    <span class="dato-label">Tipo de actividad</span>

                    <span class="dato-valor">
                        {{ $actividad->tipo }}
                    </span>
                </div>

            </div>

            {{-- DESCRIPCIÓN --}}
            <div class="descripcion">

                <strong>Descripción de la actividad</strong>

                <p style="margin:8px 0 0;">
                    {{ $actividad->descripcion ?: 'Sin descripción registrada.' }}
                </p>

            </div>

            {{-- OBSERVACIONES --}}
            <div class="descripcion">

                <strong>Observaciones generales</strong>

                <p style="margin:8px 0 0;">
                    {{ $actividad->observaciones ?: 'Sin observaciones registradas.' }}
                </p>

            </div>

        </div>
    </div>

    {{-- PARTICIPANTES --}}
    <div class="actividad-card">

        <div class="actividad-header">
            Participantes y asistencia
        </div>

        <div class="actividad-body">

            @php
                $alumnos = $actividad->alumnos;

                $total = $alumnos->count();

                $presentes = $alumnos->filter(function ($alumno) {
                    return $alumno->pivot->asistencia === 'Presente';
                })->count();

                $ausentes = $alumnos->filter(function ($alumno) {
                    return $alumno->pivot->asistencia === 'Ausente';
                })->count();

                $justificados = $alumnos->filter(function ($alumno) {
                    return $alumno->pivot->asistencia === 'Justificado';
                })->count();
            @endphp

            {{-- RESUMEN DE ASISTENCIA --}}
            <div class="resumen">

                <div class="resumen-item">
                    <span class="resumen-numero">{{ $total }}</span>
                    <span class="resumen-texto">Alumnos participantes</span>
                </div>

                <div class="resumen-item">
                    <span class="resumen-numero">{{ $presentes }}</span>
                    <span class="resumen-texto">Presentes</span>
                </div>

                <div class="resumen-item">
                    <span class="resumen-numero">{{ $ausentes + $justificados }}</span>
                    <span class="resumen-texto">Ausentes y justificados</span>
                </div>

            </div>

            @if($alumnos->count() > 0)

                <div class="table-responsive">

                    <table class="tabla-alumnos">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Alumno</th>
                                <th>Matrícula</th>
                                <th>Asistencia</th>
                                <th>Observaciones individuales</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($alumnos as $alumno)

                                <tr>

                                    <td>{{ $loop->iteration }}</td>

                                    <td>
                                        {{ $alumno->apellidos }},
                                        {{ $alumno->nombres }}
                                    </td>

                                    <td>
                                        {{ $alumno->matricula }}
                                    </td>

                                    <td>

                                        @php
                                            $asistencia = $alumno->pivot->asistencia;

                                            $clase = match($asistencia) {
                                                'Presente' => 'estado-presente',
                                                'Ausente' => 'estado-ausente',
                                                'Justificado' => 'estado-justificado',
                                                default => ''
                                            };
                                        @endphp

                                        <span class="estado {{ $clase }}">
                                            {{ $asistencia }}
                                        </span>

                                    </td>

                                    <td>
                                        {{ $alumno->pivot->observaciones ?: 'Sin observaciones' }}
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="sin-datos">

                    <p style="font-size:16px; font-weight:600;">
                        No hay alumnos registrados en esta actividad.
                    </p>

                    <p style="margin:0;">
                        Puedes editar la actividad para agregar participantes.
                    </p>

                </div>

            @endif

        </div>
    </div>

</div>

@endsection
