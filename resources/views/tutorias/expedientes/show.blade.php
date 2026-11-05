
@extends('layouts.app')

@section('content')

<style>
    .expediente-page {
        max-width: 1450px;
        margin: 0 auto;
        padding: 28px 24px 45px;
        color: #333;
    }

    /* ENCABEZADO */
    .exp-header {
        background: linear-gradient(120deg, #7B1E3A, #4f1026);
        color: white;
        padding: 28px 32px;
        border-radius: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
        box-shadow: 0 6px 18px rgba(93,20,43,.16);
    }

    .exp-header h2 {
        margin: 0 0 7px;
        font-size: 25px;
        font-weight: 750;
    }

    .exp-header p {
        margin: 0;
        color: #f1dfe5;
        font-size: 14px;
    }

    .exp-back {
        background: white;
        color: #7B1E3A;
        text-decoration: none;
        padding: 11px 18px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .exp-back:hover {
        background: #f5e9ed;
        color: #5D142B;
    }

    /* TARJETAS GENERALES */
    .exp-card {
        background: white;
        border: 1px solid #eee2e6;
        border-radius: 14px;
        padding: 23px;
        margin-bottom: 22px;
        box-shadow: 0 3px 12px rgba(30,20,25,.04);
    }

    .exp-card-title {
        color: #701b35;
        font-size: 17px;
        font-weight: 750;
        margin: 0 0 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .exp-card-title:before {
        content: "";
        width: 5px;
        height: 22px;
        background: #7B1E3A;
        border-radius: 5px;
    }

    /* INFORMACIÓN DEL ALUMNO */
    .student-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 20px;
    }

    .student-data {
        background: #faf7f8;
        border: 1px solid #f0e5e9;
        border-radius: 10px;
        padding: 14px 16px;
        min-width: 0;
    }

    .data-label {
        display: block;
        color: #887780;
        font-size: 11px;
        font-weight: 750;
        text-transform: uppercase;
        letter-spacing: .5px;
        margin-bottom: 7px;
    }

    .data-value {
        color: #342a2e;
        font-size: 14px;
        font-weight: 650;
        overflow-wrap: anywhere;
    }

    /* INDICADORES */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 23px;
    }

    .stat-card {
        background: white;
        border: 1px solid #eee2e6;
        border-radius: 13px;
        padding: 19px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 3px 12px rgba(30,20,25,.04);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: #f5e8ed;
        color: #7B1E3A;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
        flex-shrink: 0;
    }

    .stat-number {
        font-size: 25px;
        font-weight: 800;
        color: #3d2931;
        line-height: 1.2;
    }

    .stat-label {
        color: #81737a;
        font-size: 12px;
        margin-top: 4px;
    }

    /* TUTORÍAS COMPACTAS */
    .tutoria-compacta {
        border: 1px solid #eadde2;
        border-left: 4px solid #7B1E3A;
        border-radius: 11px;
        background: white;
        margin-bottom: 12px;
        overflow: hidden;
    }

    .tutoria-resumen {
        padding: 16px 19px;
        display: grid;
        grid-template-columns: 1.1fr 1fr 1.5fr auto;
        align-items: center;
        gap: 15px;
        cursor: pointer;
        list-style: none;
    }

    .tutoria-resumen::-webkit-details-marker {
        display: none;
    }

    .tutoria-resumen:hover {
        background: #faf6f8;
    }

    .resumen-tipo {
        color: #572033;
        font-size: 14px;
        font-weight: 750;
    }

    .resumen-label {
        display: block;
        color: #927e86;
        font-size: 10px;
        text-transform: uppercase;
        font-weight: 750;
        margin-bottom: 4px;
    }

    .resumen-valor {
        color: #44383d;
        font-size: 12px;
        overflow-wrap: anywhere;
    }

    .ver-detalles {
        color: #7B1E3A;
        font-size: 12px;
        font-weight: 750;
        white-space: nowrap;
    }

    .ver-detalles .cerrar {
        display: none;
    }

    .tutoria-compacta[open] .ver-detalles .abrir {
        display: none;
    }

    .tutoria-compacta[open] .ver-detalles .cerrar {
        display: inline;
    }

    .tutoria-contenido {
        border-top: 1px solid #eee4e8;
        padding: 18px;
        background: #fff;
    }

    /* ESTADOS */
    .status-pill {
        display: inline-block;
        padding: 7px 13px;
        border-radius: 30px;
        background: #f5e8ed;
        color: #7B1E3A;
        font-size: 11px;
        font-weight: 750;
        white-space: nowrap;
    }

    /* DETALLES */
    .tutoria-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 15px;
    }

    .detail-box {
        background: #faf8f9;
        border-radius: 9px;
        padding: 13px 15px;
        min-width: 0;
    }

    .detail-box.full {
        grid-column: 1 / -1;
    }

    .detail-label {
        display: block;
        color: #8a747d;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 6px;
    }

    .detail-value {
        font-size: 13px;
        line-height: 1.6;
        color: #44383d;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    /* SEGUIMIENTOS */
    .follow-section {
        border-top: 1px solid #eee4e8;
        margin-top: 20px;
        padding-top: 17px;
    }

    .follow-title {
        font-size: 13px;
        color: #6c1b34;
        font-weight: 750;
        margin-bottom: 12px;
    }

    .follow-item {
        background: #f9f6f7;
        border: 1px solid #eee5e8;
        border-radius: 9px;
        padding: 14px;
        margin-top: 9px;
    }

    .follow-head {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 9px;
        font-size: 12px;
    }

    /* BOTÓN */
    .exp-action {
        display: inline-block;
        margin-top: 17px;
        background: #7B1E3A;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        padding: 9px 15px;
        font-size: 12px;
        font-weight: 700;
    }

    .exp-action:hover {
        background: #5D142B;
        color: white;
    }

    /* ACTIVIDADES GRUPALES */
    .activity-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .activity-box {
        border: 1px solid #eadde2;
        background: #faf7f8;
        border-radius: 11px;
        padding: 18px;
        border-left: 4px solid #9b5470;
    }

    .activity-box h4 {
        color: #572033;
        font-size: 15px;
        font-weight: 750;
        margin: 0 0 10px;
    }

    .activity-info {
        font-size: 13px;
        color: #574a50;
        line-height: 1.7;
    }

    /* SIN REGISTROS */
    .empty-state {
        text-align: center;
        padding: 30px 15px;
        color: #91838a;
        background: #faf8f9;
        border-radius: 10px;
        font-size: 13px;
    }

    /* RESPONSIVE */
    @media(max-width: 900px) {
        .student-grid,
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .tutoria-resumen {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width: 600px) {
        .expediente-page {
            padding: 16px 12px 30px;
        }

        .exp-header {
            align-items: flex-start;
            flex-direction: column;
            padding: 22px;
        }

        .student-grid,
        .stats-grid,
        .tutoria-details,
        .activity-grid {
            grid-template-columns: 1fr;
        }

        .tutoria-resumen {
            grid-template-columns: 1fr;
        }

        .detail-box.full {
            grid-column: auto;
        }

        .exp-card {
            padding: 17px;
        }
    }
</style>

@php
    $tutorias = $alumno->tutorias ?? collect();
    $actividades = $alumno->actividadesTutorias ?? collect();

    $pendientes = $tutorias->where('estado', 'Pendiente')->count();
    $enSeguimiento = $tutorias->where('estado', 'En seguimiento')->count();
    $concluidas = $tutorias->where('estado', 'Concluida')->count();
@endphp

<div class="expediente-page">

    {{-- ENCABEZADO --}}
    <div class="exp-header">
        <div>
            <h2>Expediente de Tutoría</h2>
            <p>Historial de atención y seguimiento académico del alumno</p>
        </div>

        <a href="{{ route('tutorias.index') }}" class="exp-back">
            ← Regresar a tutorías
        </a>
    </div>

    {{-- INFORMACIÓN DEL ALUMNO --}}
    <div class="exp-card">
        <h3 class="exp-card-title">Información del alumno</h3>

        <div class="student-grid">

            <div class="student-data">
                <span class="data-label">Nombre completo</span>
                <div class="data-value">
                    {{ $alumno->nombres }} {{ $alumno->apellidos }}
                </div>
            </div>

            <div class="student-data">
                <span class="data-label">Matrícula</span>
                <div class="data-value">
                    {{ $alumno->matricula ?? $alumno->idmatricula ?? 'No registrada' }}
                </div>
            </div>

            <div class="student-data">
                <span class="data-label">Grupo</span>
                <div class="data-value">
                    @if($alumno->grupo)
                        {{ $alumno->grupo->grado }} {{ $alumno->grupo->nombre }}
                    @else
                        Sin grupo asignado
                    @endif
                </div>
            </div>

            <div class="student-data">
                <span class="data-label">Correo electrónico</span>
                <div class="data-value">
                    {{ $alumno->email ?? 'No registrado' }}
                </div>
            </div>

        </div>
    </div>

    {{-- RESUMEN --}}
    <div class="stats-grid">

        <div class="stat-card">
            <div class="stat-icon">📋</div>
            <div>
                <div class="stat-number">{{ $tutorias->count() }}</div>
                <div class="stat-label">Tutorías individuales</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⏳</div>
            <div>
                <div class="stat-number">{{ $pendientes }}</div>
                <div class="stat-label">Pendientes</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🔄</div>
            <div>
                <div class="stat-number">{{ $enSeguimiento }}</div>
                <div class="stat-label">En seguimiento</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">✓</div>
            <div>
                <div class="stat-number">{{ $concluidas }}</div>
                <div class="stat-label">Concluidas</div>
            </div>
        </div>

    </div>

    {{-- HISTORIAL DE TUTORÍAS INDIVIDUALES --}}
    <div class="exp-card">

        <h3 class="exp-card-title">
            Historial de tutorías individuales
        </h3>

        @forelse($tutorias as $tutoria)

            <details class="tutoria-compacta">

                {{-- RESUMEN VISIBLE --}}
                <summary class="tutoria-resumen">

                    <div>
                        <span class="resumen-label">Tipo de tutoría</span>
                        <div class="resumen-tipo">
                            {{ $tutoria->tipo ?? 'Tutoría individual' }}
                        </div>
                    </div>

                    <div>
                        <span class="resumen-label">Fecha</span>
                        <div class="resumen-valor">
                            {{ $tutoria->fecha
                                ? \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y')
                                : 'No registrada' }}
                        </div>
                    </div>

                    <div>
                        <span class="resumen-label">Motivo</span>
                        <div class="resumen-valor">
                            {{ $tutoria->motivo ?? 'Sin motivo registrado' }}
                        </div>
                    </div>

                    <div>
                        <span class="status-pill">
                            {{ $tutoria->estado }}
                        </span>

                        <div class="ver-detalles mt-2">
                            <span class="abrir">Ver detalles ↓</span>
                            <span class="cerrar">Ocultar detalles ↑</span>
                        </div>
                    </div>

                </summary>

                {{-- INFORMACIÓN DESPLEGABLE --}}
                <div class="tutoria-contenido">

                    <div class="tutoria-details">

                        <div class="detail-box">
                            <span class="detail-label">Docente responsable</span>
                            <div class="detail-value">
                                @if($tutoria->docente)
                                    {{ $tutoria->docente->nombres }}
                                    {{ $tutoria->docente->apellidos }}
                                @else
                                    No asignado
                                @endif
                            </div>
                        </div>

                        <div class="detail-box">
                            <span class="detail-label">Motivo</span>
                            <div class="detail-value">
                                {{ $tutoria->motivo ?? 'Sin información' }}
                            </div>
                        </div>

                        <div class="detail-box full">
                            <span class="detail-label">Situación</span>
                            <div class="detail-value">
                                {{ $tutoria->situacion ?? 'Sin información' }}
                            </div>
                        </div>

                        <div class="detail-box full">
                            <span class="detail-label">Acuerdos</span>
                            <div class="detail-value">
                                {{ $tutoria->acuerdos ?? 'Sin acuerdos registrados' }}
                            </div>
                        </div>

                        <div class="detail-box">
                            <span class="detail-label">Compromisos del alumno</span>
                            <div class="detail-value">
                                {{ $tutoria->compromisos_alumno ?? 'Sin información' }}
                            </div>
                        </div>

                        <div class="detail-box">
                            <span class="detail-label">Compromisos del tutor</span>
                            <div class="detail-value">
                                {{ $tutoria->compromisos_tutor ?? 'Sin información' }}
                            </div>
                        </div>

                        @if($tutoria->observaciones)
                            <div class="detail-box full">
                                <span class="detail-label">Observaciones</span>
                                <div class="detail-value">
                                    {{ $tutoria->observaciones }}
                                </div>
                            </div>
                        @endif

                    </div>

                    {{-- HISTORIAL DE SEGUIMIENTOS --}}
                    <div class="follow-section">

                        <div class="follow-title">
                            Historial de seguimientos
                        </div>

                        @forelse($tutoria->seguimientos as $seguimiento)

                            <div class="follow-item">

                                <div class="follow-head">
                                    <strong>
                                        Fecha programada:
                                        {{ $seguimiento->fecha_programada
                                            ? \Carbon\Carbon::parse($seguimiento->fecha_programada)->format('d/m/Y')
                                            : 'No registrada' }}
                                    </strong>

                                    <span class="status-pill">
                                        {{ $seguimiento->estado }}
                                    </span>
                                </div>

                                @if($seguimiento->fecha_realizada)
                                    <div class="detail-value">
                                        <strong>Fecha realizada:</strong>
                                        {{ \Carbon\Carbon::parse($seguimiento->fecha_realizada)->format('d/m/Y') }}
                                    </div>
                                @endif

                                <div class="detail-value mt-2">
                                    <strong>Resultado:</strong>
                                    {{ $seguimiento->resultado ?? 'Sin resultado registrado' }}
                                </div>

                                <div class="detail-value mt-1">
                                    <strong>Acuerdos:</strong>
                                    {{ $seguimiento->acuerdos ?? 'Sin acuerdos registrados' }}
                                </div>

                                @if($seguimiento->observaciones)
                                    <div class="detail-value mt-1">
                                        <strong>Observaciones:</strong>
                                        {{ $seguimiento->observaciones }}
                                    </div>
                                @endif

                            </div>

                        @empty

                            <div class="empty-state">
                                No hay seguimientos registrados para esta tutoría.
                            </div>

                        @endforelse

                    </div>

                    <a href="{{ route('tutorias.show', $tutoria) }}"
                       class="exp-action">
                        Ver tutoría completa →
                    </a>

                </div>

            </details>

        @empty

            <div class="empty-state">
                Este alumno todavía no tiene tutorías individuales registradas.
            </div>

        @endforelse

    </div>

    {{-- ACTIVIDADES GRUPALES --}}
    <div class="exp-card">

        <h3 class="exp-card-title">
            Actividades grupales de tutoría
        </h3>

        @if($actividades->isNotEmpty())

            <div class="activity-grid">

                @foreach($actividades as $actividad)

                    <div class="activity-box">

                        <h4>
                            {{ $actividad->nombre ?? $actividad->titulo ?? 'Actividad grupal' }}
                        </h4>

                        <div class="activity-info">

                            <div>
                                <strong>Tipo:</strong>
                                {{ $actividad->tipo ?? 'Actividad grupal' }}
                            </div>

                            <div>
                                <strong>Fecha:</strong>
                                {{ $actividad->fecha
                                    ? \Carbon\Carbon::parse($actividad->fecha)->format('d/m/Y')
                                    : 'No registrada' }}
                            </div>

                            <div>
                                <strong>Docente responsable:</strong>

                                @if($actividad->docente)
                                    {{ $actividad->docente->nombres }}
                                    {{ $actividad->docente->apellidos }}
                                @else
                                    No asignado
                                @endif
                            </div>

                            @if($actividad->descripcion)
                                <div class="mt-2">
                                    <strong>Descripción:</strong>
                                    {{ $actividad->descripcion }}
                                </div>
                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

        @else

            <div class="empty-state">
                Este alumno no tiene actividades grupales registradas.
            </div>

        @endif

    </div>

</div>

@endsection
