<x-app-layout>
    <style>
        .citatorio-show-page {
            --vino: #7B1E3A;
            --vino-oscuro: #5D142B;
            --texto: #33262B;
            --suave: #786A70;
            --borde: #E7D9DE;
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px 48px;
            color: var(--texto);
        }
        .show-header, .info-card, .history-card {
            background: #fff;
            border: 1px solid var(--borde);
            border-radius: 16px;
            box-shadow: 0 7px 22px rgba(65,25,42,.05);
        }
        .show-header {
            display:flex; justify-content:space-between; align-items:center;
            gap:16px; padding:22px 26px; margin-bottom:18px;
        }
        .show-header h1 { margin:0 0 5px; font-size:26px; font-weight:750; }
        .show-header p { margin:0; color:var(--suave); }
        .header-actions, .action-row { display:flex; gap:9px; flex-wrap:wrap; }
        .btn-vino, .btn-light {
            display:inline-flex; align-items:center; justify-content:center;
            padding:10px 15px; border-radius:9px; text-decoration:none;
            font-weight:650; cursor:pointer; border:1px solid var(--borde);
        }
        .btn-vino { background:var(--vino); color:#fff; border-color:var(--vino); }
        .btn-vino:hover { background:var(--vino-oscuro); }
        .btn-light { color:var(--vino); background:#fff; }
        .section-title { font-size:18px; font-weight:750; margin:24px 0 12px; }
        .info-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:15px; }
        .info-card { padding:20px 22px; }
        .info-card h2 { font-size:16px; color:var(--vino); font-weight:750; margin:0 0 15px; }
        .data-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:13px 18px; }
        .data-item small { display:block; color:var(--suave); font-size:12px; margin-bottom:3px; }
        .data-item strong { display:block; font-size:14px; overflow-wrap:anywhere; }
        .full { grid-column:1/-1; }
        .history-card { padding:20px; margin-top:12px; }
        .history-top { display:flex; justify-content:space-between; align-items:center; gap:12px; margin-bottom:14px; }
        .history-top h2 { margin:0; font-size:18px; font-weight:750; }
        .count { background:#f8edf1; color:var(--vino); border-radius:20px; padding:5px 11px; font-size:12px; font-weight:750; }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; min-width:760px; }
        th { background:#fbf5f7; color:var(--vino-oscuro); text-align:left; font-size:12px; }
        th,td { padding:12px 10px; border-bottom:1px solid #f0e7eb; vertical-align:top; }
        td { font-size:13px; }
        tr.actual { background:#fff9fb; }
        .estado { display:inline-block; border-radius:20px; padding:5px 9px; font-size:11px; font-weight:750; background:#fff4dc; color:#875d09; }
        .estado.atendido { background:#eaf7ee; color:#216338; }
        .estado.cancelado { background:#fceced; color:#9b2933; }
        .empty { text-align:center; color:var(--suave); padding:25px; }
        .print-only { display:none; }

        @media(max-width:700px) {
            .show-header { align-items:flex-start; flex-direction:column; }
            .info-grid, .data-grid { grid-template-columns:1fr; }
            .full { grid-column:auto; }
        }

        @media print {
            @page { size: letter; margin: 16mm; }
            body { background:#fff !important; }
            body * { visibility:hidden !important; }
            #citatorio-imprimible, #citatorio-imprimible * { visibility:visible !important; }
            #citatorio-imprimible {
                display:block !important;
                position:absolute; left:0; top:0; width:100%;
                border:0 !important; box-shadow:none !important; padding:0 !important;
                margin:0 !important;
            }
            .no-print, .history-card, .show-header { display:none !important; }
            .print-only { display:block !important; }
            .print-title { text-align:center; margin-bottom:24px; }
            .print-title h1 { font-size:21px; margin:0 0 5px; }
            .print-title p { margin:0; font-size:12px; }
            .print-section { margin:18px 0; }
            .print-section h2 { font-size:14px; border-bottom:1px solid #555; padding-bottom:5px; margin-bottom:10px; }
            .print-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px 20px; }
            .print-field { font-size:12px; min-height:30px; }
            .print-field strong { display:block; font-size:10px; text-transform:uppercase; margin-bottom:3px; }
            .print-text { font-size:12px; line-height:1.5; white-space:pre-wrap; }
            .signature-row { display:grid; grid-template-columns:1fr 1fr; gap:45px; margin-top:75px; text-align:center; font-size:11px; }
            .signature-line { border-top:1px solid #222; padding-top:7px; }
        }
    </style>

    @php
        $alumno = $citatorio->alumno;
        $grupo = $alumno?->grupo;
        $totalCitatorios = $historial->count();
    @endphp

    <div class="citatorio-show-page">
        <div class="show-header no-print">
            <div>
                <h1>Detalle del citatorio</h1>
                <p>Consulta el citatorio y el historial del alumno.</p>
            </div>
            <div class="header-actions">
                <a href="{{ route('citatorios.index') }}" class="btn-light">← Regresar</a>
                <a href="{{ route('citatorios.edit', $citatorio) }}" class="btn-light">Editar</a>
                <form method="POST" action="{{ route('citatorios.notificar', $citatorio) }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-vino" style="background:#25D366;border-color:#25D366;">
                        Enviar por WhatsApp
                    </button>
                </form>
                <button type="button" onclick="window.print()" class="btn-vino">Imprimir citatorio</button>
            </div>
        </div>

        <div class="info-grid no-print">
            <section class="info-card">
                <h2>Datos del alumno</h2>
                <div class="data-grid">
                    <div class="data-item full"><small>Nombre completo</small><strong>{{ $alumno?->nombres }} {{ $alumno?->apellidos }}</strong></div>
                    <div class="data-item"><small>Matrícula</small><strong>{{ $alumno?->matricula ?? '—' }}</strong></div>
                    <div class="data-item"><small>Semestre</small><strong>{{ $grupo?->grado ? $grupo->grado . '.º semestre' : '—' }}</strong></div>
                    <div class="data-item"><small>Grupo</small><strong>{{ $grupo?->nombre ?? '—' }}</strong></div>
                </div>
            </section>
            <section class="info-card">
                <h2>Datos del responsable</h2>
                <div class="data-grid">
                    <div class="data-item full"><small>Nombre</small><strong>{{ $citatorio->responsable_nombre }}</strong></div>
                    <div class="data-item"><small>Parentesco</small><strong>{{ $citatorio->responsable_parentesco }}</strong></div>
                    <div class="data-item"><small>Teléfono</small><strong>{{ $citatorio->responsable_telefono }}</strong></div>
                    <div class="data-item full"><small>Correo electrónico</small><strong>{{ $citatorio->responsable_email ?: '—' }}</strong></div>
                </div>
            </section>
        </div>

        <section id="citatorio-imprimible" class="info-card" style="margin-top:16px;">
            <div class="print-only print-title">
                <h1>COBAY PLANTEL CHICHIMILÁ</h1>
                <p>CITATORIO PARA PADRE, MADRE O TUTOR</p>
            </div>

            <div class="no-print">
                <h2 style="font-size:18px;color:var(--vino);font-weight:750;margin:0 0 16px;">Información del citatorio seleccionado</h2>
                <div class="data-grid">
                    <div class="data-item"><small>Fecha de emisión</small><strong>{{ $citatorio->fecha_emision?->format('d/m/Y') ?? '—' }}</strong></div>
                    <div class="data-item"><small>Fecha de cita</small><strong>{{ $citatorio->fecha_cita?->format('d/m/Y') ?? '—' }}</strong></div>
                    <div class="data-item"><small>Hora de cita</small><strong>{{ $citatorio->hora_cita ? \Illuminate\Support\Str::substr($citatorio->hora_cita, 0, 5) : '—' }}</strong></div>
                    <div class="data-item"><small>Estado</small><strong>{{ $citatorio->estado }}</strong></div>
                    <div class="data-item full"><small>Motivo</small><strong style="font-weight:500;white-space:pre-wrap;">{{ $citatorio->motivo }}</strong></div>
                    <div class="data-item full"><small>Observaciones</small><strong style="font-weight:500;white-space:pre-wrap;">{{ $citatorio->observaciones ?: '—' }}</strong></div>
                </div>
            </div>

            <div class="print-only">
                <div class="print-section">
                    <p style="font-size:12px;line-height:1.6;">
                        Por medio del presente, solicitamos la asistencia del padre, madre o tutor del alumno
                        <strong>{{ $alumno?->nombres }} {{ $alumno?->apellidos }}</strong>,
                        para tratar el asunto que se describe a continuación.
                    </p>
                </div>
                <div class="print-section">
                    <h2>Datos del alumno</h2>
                    <div class="print-grid">
                        <div class="print-field"><strong>Nombre del alumno</strong>{{ $alumno?->nombres }} {{ $alumno?->apellidos }}</div>
                        <div class="print-field"><strong>Matrícula</strong>{{ $alumno?->matricula ?? '—' }}</div>
                        <div class="print-field"><strong>Semestre y grupo</strong>{{ $grupo?->grado ? $grupo->grado . '.º semestre' : '—' }} · {{ $grupo?->nombre ?? '—' }}</div>
                    </div>
                </div>
                <div class="print-section">
                    <h2>Datos del padre, madre o responsable</h2>
                    <div class="print-grid">
                        <div class="print-field"><strong>Nombre</strong>{{ $citatorio->responsable_nombre }}</div>
                        <div class="print-field"><strong>Parentesco</strong>{{ $citatorio->responsable_parentesco }}</div>
                        <div class="print-field"><strong>Teléfono</strong>{{ $citatorio->responsable_telefono }}</div>
                    </div>
                </div>
                <div class="print-section">
                    <h2>Motivo del citatorio</h2>
                    <div class="print-text">{{ $citatorio->motivo }}</div>
                </div>
                @if($citatorio->observaciones)
                    <div class="print-section">
                        <h2>Observaciones</h2>
                        <div class="print-text">{{ $citatorio->observaciones }}</div>
                    </div>
                @endif
                <div class="print-section">
                    <p style="font-size:12px;">Fecha de emisión: <strong>{{ $citatorio->fecha_emision?->format('d/m/Y') ?? '—' }}</strong></p>
                    <p style="font-size:12px;">Se solicita su presencia el día <strong>{{ $citatorio->fecha_cita?->format('d/m/Y') ?? '—' }}</strong> a las <strong>{{ $citatorio->hora_cita ? \Illuminate\Support\Str::substr($citatorio->hora_cita, 0, 5) : '—' }}</strong> horas.</p>
                </div>
                <div class="signature-row">
                    <div class="signature-line">Firma del padre, madre o tutor</div>
                    <div class="signature-line">Firma de la autoridad escolar</div>
                </div>
            </div>
        </section>

        <section class="history-card no-print">
            <div class="history-top">
                <h2>Historial de citatorios del alumno</h2>
                <span class="count">{{ $totalCitatorios }} {{ $totalCitatorios === 1 ? 'citatorio' : 'citatorios' }}</span>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha de emisión</th>
                            <th>Fecha de cita</th>
                            <th>Motivo</th>
                            <th>Responsable</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historial as $registro)
                            <tr class="{{ $registro->id === $citatorio->id ? 'actual' : '' }}">
                                <td>{{ $registro->fecha_emision?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ $registro->fecha_cita?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($registro->motivo, 75) }}</td>
                                <td>{{ $registro->responsable_nombre }}</td>
                                <td><span class="estado {{ strtolower($registro->estado) }}">{{ $registro->estado }}</span></td>
                                <td>
                                    <div class="action-row">
                                        @if($registro->id !== $citatorio->id)
                                            <a href="{{ route('citatorios.show', $registro) }}" class="btn-light">Ver</a>
                                        @else
                                            <span class="btn-light" style="background:#f8edf1;">Actual</span>
                                        @endif
                                        <a href="{{ route('citatorios.show', $registro) }}" class="btn-light">Imprimir</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="empty">Este alumno todavía no tiene citatorios registrados.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</x-app-layout>