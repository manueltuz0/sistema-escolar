<x-app-layout>
    <style>
        .captura-page {
            --vino: #7B1E3A;
            --vino-oscuro: #5D142B;
            --vino-claro: #F8F4F5;
            --rosa: #F2E7EB;
            --borde: #E7D9DE;
            --texto: #33262B;
            --muted: #786A70;
            max-width: 1600px;
            margin: 0 auto;
            padding: 28px 22px 44px;
            color: var(--texto);
        }

        .captura-page * {
            box-sizing: border-box;
        }

        .captura-header,
        .captura-panel {
            background: #fff;
            border: 1px solid var(--borde);
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(65,18,36,.04);
            margin-bottom: 16px;
        }

        .captura-header {
            padding: 22px 26px;
            border-top: 5px solid var(--vino);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
        }

        .captura-header h1 {
            margin: 0;
            color: var(--vino);
            font-size: 26px;
            line-height: 1.25;
            font-weight: 800;
        }

        .captura-header p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        .captura-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid var(--vino);
            border-radius: 8px;
            padding: 11px 16px;
            font-size: 13px;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition: .18s ease;
            line-height: 1.3;
        }

        .captura-btn-primary {
            background: var(--vino);
            color: #fff;
        }

        .captura-btn-primary:hover {
            background: var(--vino-oscuro);
        }

        .captura-btn-outline {
            background: #fff;
            color: var(--vino);
        }

        .captura-btn-outline:hover {
            background: var(--vino-claro);
        }

        .captura-panel {
            padding: 20px;
        }

        .captura-label {
            display: block;
            color: var(--vino);
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 9px;
        }

        .captura-select {
            width: 100%;
            min-height: 43px;
            padding: 9px 12px;
            border: 1px solid #C9AAB5;
            border-radius: 7px;
            background: #fff;
            color: var(--texto);
            font-size: 13px;
        }

        .captura-select:focus {
            outline: 2px solid #E8C8D3;
            border-color: var(--vino);
        }

        .captura-group-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .captura-group-title {
            border-left: 5px solid var(--vino);
            padding-left: 14px;
        }

        .captura-group-title small {
            display: block;
            color: var(--vino);
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .captura-group-title strong {
            color: var(--vino);
            font-size: 22px;
        }

        .captura-count {
            padding: 10px 14px;
            border-radius: 8px;
            background: var(--vino-claro);
            color: var(--vino);
            border: 1px solid var(--borde);
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
        }

        .captura-notice {
            padding: 13px 16px;
            border: 1px solid var(--borde);
            border-radius: 9px;
            background: var(--vino-claro);
            color: var(--vino);
            font-size: 13px;
        }

        .captura-notice strong {
            font-weight: 800;
        }

        .captura-alert-success {
            padding: 13px 16px;
            border: 1px solid #B7DCC3;
            border-radius: 9px;
            background: #F0FAF2;
            color: #1E6A37;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .captura-alert-error {
            padding: 13px 16px;
            border: 1px solid #E8B8C0;
            border-radius: 9px;
            background: #FFF3F4;
            color: #8D1830;
            margin-bottom: 16px;
            font-size: 13px;
        }

        /* Resumen del horario */
        .captura-resumen {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 20px;
        }

        .captura-resumen-card {
            border: 1px solid var(--borde);
            border-radius: 10px;
            padding: 16px;
            background: #fff;
        }

        .captura-resumen-card small {
            display: block;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .captura-resumen-card strong {
            display: block;
            color: var(--vino);
            font-size: 27px;
            line-height: 1.2;
        }

        .captura-resumen-card span {
            display: block;
            color: var(--muted);
            font-size: 11px;
            margin-top: 5px;
        }

        .captura-progreso {
            height: 12px;
            background: #F0E5E9;
            border-radius: 20px;
            overflow: hidden;
            margin-top: 14px;
        }

        .captura-progreso-barra {
            height: 100%;
            background: var(--vino);
            border-radius: 20px;
            transition: width .25s ease;
        }

        .captura-estado {
            margin-top: 13px;
            padding: 13px 15px;
            border: 1px solid var(--borde);
            border-radius: 9px;
            font-size: 13px;
        }

        .captura-estado-incompleto {
            background: #FFF8E8;
            border-color: #F0D69A;
            color: #805B10;
        }

        .captura-estado-completo {
            background: #F0FAF2;
            border-color: #B7DCC3;
            color: #1E6A37;
        }

        .captura-table-wrap {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--borde);
            border-radius: 10px;
            background: #fff;
        }

        .captura-table {
            width: 100%;
            min-width: 1120px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .captura-table th {
            background: var(--vino);
            color: #fff;
            border: 1px solid #692039;
            padding: 13px 9px;
            text-align: center;
            font-size: 13px;
            font-weight: 800;
        }

        .captura-table th:first-child {
            width: 125px;
        }

        .captura-table td {
            border: 1px solid var(--borde);
            padding: 7px;
            vertical-align: top;
            background: #fff;
        }

        .captura-table .time-cell {
            background: var(--vino-claro);
            color: var(--vino);
            text-align: center;
            vertical-align: middle;
            font-weight: 800;
            font-size: 13px;
        }

        .time-cell span {
            display: block;
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
            margin-top: 3px;
        }

        .captura-class-card {
            min-height: 76px;
            border: 1px solid var(--materia-borde, var(--borde));
            border-left: 5px solid var(--materia-color, var(--vino));
            border-radius: 7px;
            padding: 9px 10px;
            background: var(--materia-fondo, #FCF8FA);
            overflow-wrap: anywhere;
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }

        .captura-class-card .status {
            color: var(--materia-color, var(--vino));
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: .04em;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .captura-class-card strong {
            display: block;
            color: var(--materia-color, var(--vino));
            font-size: 12px;
            margin-bottom: 4px;
        }

        .captura-class-card span {
            display: block;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.45;
            margin-top: 3px;
        }

        .captura-cell-select {
            width: 100%;
            min-height: 39px;
            padding: 8px 9px;
            border: 1px solid #C9AAB5;
            border-radius: 7px;
            background: #fff;
            color: var(--texto);
            font-size: 12px;
        }

        .captura-cell-select:focus {
            outline: 2px solid #E8C8D3;
            border-color: var(--vino);
        }

        .captura-cell-help {
            margin: 6px 2px 0;
            color: var(--muted);
            font-size: 10px;
        }

        .captura-receso td {
            padding: 10px;
            text-align: center;
            background: var(--rosa);
            color: var(--vino);
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .02em;
        }

        .captura-form-actions {
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 10px;
            margin: 15px 0;
        }

        /* Acciones compactas dentro de cada materia */
        .captura-card-actions {
            display: flex;
            align-items: flex-start;
            gap: 4px;
            margin-top: 5px;
        }

        .captura-mini-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 3px;
            border: 0;
            border-radius: 5px;
            padding: 5px 6px;
            min-height: 25px;
            font-size: 10px;
            line-height: 1.1;
            font-weight: 700;
            cursor: pointer;
        }

        .captura-edit-summary {
            list-style: none;
            background: #F8F4F5;
            color: #5D142B;
            border: 1px solid #E7D9DE;
        }

        .captura-edit-summary::-webkit-details-marker { display: none; }
        .captura-delete-btn { background: #DC2626; color: #fff; }
        .captura-edit-panel {
            position: absolute;
            z-index: 20;
            width: 220px;
            padding: 9px;
            background: #fff;
            border: 1px solid #E7D9DE;
            border-radius: 7px;
            box-shadow: 0 5px 16px rgba(0,0,0,.14);
        }
        .captura-edit-details { position: relative; }
        .captura-edit-select {
            width: 100%;
            padding: 6px;
            font-size: 11px;
            border: 1px solid #D1D5DB;
            border-radius: 5px;
            color: #33262B;
            background: #fff;
        }
        .no-print { }

        @media print {
            @page { size: landscape; margin: 8mm; }
            body { background: #fff !important; }
            .no-print,
            .captura-card-actions,
            .captura-edit-panel,
            .captura-edit-summary,
            .captura-delete-btn,
            .captura-form-actions,
            .captura-header,
            .captura-page > .captura-panel:first-of-type,
            .captura-resumen,
            .captura-estado,
            .captura-notice { display: none !important; }
            .captura-page { max-width: none !important; padding: 0 !important; margin: 0 !important; }
            .captura-panel { border: 0 !important; box-shadow: none !important; padding: 0 !important; margin: 0 !important; }
            .captura-table-wrap { overflow: visible !important; border: 0 !important; }
            .captura-table { width: 100% !important; min-width: 0 !important; font-size: 8px !important; }
            .captura-table th { padding: 5px 3px !important; font-size: 9px !important; }
            .captura-table td { padding: 3px !important; }
            .captura-table th:first-child { width: 70px !important; }
            .captura-table .time-cell { font-size: 8px !important; }
            .time-cell span { font-size: 7px !important; }
            .captura-class-card { min-height: 0 !important; padding: 4px !important; border-left-width: 3px !important; box-shadow: none !important; }
            .captura-class-card .status { font-size: 7px !important; margin-bottom: 2px !important; }
            .captura-class-card strong { font-size: 8px !important; margin-bottom: 2px !important; }
            .captura-class-card span { font-size: 7px !important; line-height: 1.2 !important; margin-top: 1px !important; }
            .captura-receso td { padding: 4px !important; font-size: 8px !important; }
        }

        @media(max-width: 700px) {
            .captura-page {
                padding: 15px 10px 28px;
            }

            .captura-header {
                align-items: flex-start;
                flex-direction: column;
                padding: 18px;
            }

            .captura-header h1 {
                font-size: 22px;
            }

            .captura-panel {
                padding: 14px;
            }

            .captura-group-info {
                align-items: flex-start;
                flex-direction: column;
            }

            .captura-resumen {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="captura-page">

        @if(session('success'))
            <div class="captura-alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="captura-alert-error">
                <strong style="display:block;margin-bottom:6px;">
                    No se pudo guardar el horario.
                </strong>

                <ul style="list-style:disc;padding-left:20px;margin:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <header class="captura-header">
            <div>
                <h1>Captura rápida de horarios</h1>
                <p>Organiza las materias del grupo por día y bloque de clase.</p>
            </div>

            <a href="{{ route('horarios.index') }}"
               class="captura-btn captura-btn-outline">
                ← Volver a horarios
            </a>
        </header>

        <section class="captura-panel">
            <form action="{{ route('horarios.captura-rapida') }}" method="GET">
                <label for="grupo_id" class="captura-label">
                    Selecciona el grupo
                </label>

                <div style="display:grid;grid-template-columns:minmax(0,1fr) auto;gap:12px;align-items:center;">
                    <select name="grupo_id" id="grupo_id" required class="captura-select">
                        <option value="">Seleccionar grupo...</option>

                        @foreach($grupos as $grupo)
                            <option value="{{ $grupo->id }}"
                                @selected($grupoSeleccionado && $grupoSeleccionado->id == $grupo->id)>
                                {{ $grupo->grado }}° {{ $grupo->nombre }}@if($grupo->especialidad) — {{ $grupo->especialidad }}@endif
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="captura-btn captura-btn-primary">
                        ⌕ Consultar grupo
                    </button>
                </div>
            </form>
        </section>

        @if($grupoSeleccionado)

            @php
                $diasVista = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'];

                $bloquesVista = [
                    ['inicio' => '07:00', 'fin' => '07:50'],
                    ['inicio' => '07:50', 'fin' => '08:40'],
                    ['inicio' => '08:40', 'fin' => '09:30'],
                    ['inicio' => '10:00', 'fin' => '10:50'],
                    ['inicio' => '10:50', 'fin' => '11:40'],
                    ['inicio' => '11:40', 'fin' => '12:30'],
                    ['inicio' => '12:30', 'fin' => '13:20'],
                    ['inicio' => '13:20', 'fin' => '14:10'],
                ];

                $totalBloques = count($diasVista) * count($bloquesVista);
                $bloquesOcupados = 0;

                foreach ($diasVista as $diaContar) {
                    foreach ($bloquesVista as $bloqueContar) {
                        $existeBloque = $horarios->first(function ($horario) use ($diaContar, $bloqueContar) {
                            return $horario->dia === $diaContar
                                && substr((string) $horario->hora_inicio, 0, 5) === $bloqueContar['inicio']
                                && substr((string) $horario->hora_fin, 0, 5) === $bloqueContar['fin'];
                        });

                        if ($existeBloque) {
                            $bloquesOcupados++;
                        }
                    }
                }

                $bloquesLibres = $totalBloques - $bloquesOcupados;
                $porcentajeOcupado = $totalBloques > 0
                    ? round(($bloquesOcupados / $totalBloques) * 100)
                    : 0;
            @endphp

            <section class="captura-panel">
                <div class="captura-group-info">
                    <div class="captura-group-title">
                        <small>Grupo seleccionado</small>

                        <strong>
                            {{ $grupoSeleccionado->grado }}° {{ $grupoSeleccionado->nombre }}
                        </strong>

                        @if($grupoSeleccionado->especialidad)
                            <div style="color:var(--muted);font-size:12px;margin-top:3px;">
                                {{ $grupoSeleccionado->especialidad }}
                            </div>
                        @endif
                    </div>

                    <div class="captura-count">
                        ▣ {{ $asignaciones->count() }} materias asignadas
                    </div>
                </div>

                <div class="captura-resumen">
                    <div class="captura-resumen-card">
                        <small>Bloques ocupados</small>
                        <strong>{{ $bloquesOcupados }}</strong>
                        <span>Clases registradas en la cuadrícula</span>
                    </div>

                    <div class="captura-resumen-card">
                        <small>Bloques libres</small>
                        <strong>{{ $bloquesLibres }}</strong>
                        <span>Espacios disponibles para programar</span>
                    </div>

                    <div class="captura-resumen-card">
                        <small>Ocupación semanal</small>
                        <strong>{{ $porcentajeOcupado }}%</strong>
                        <span>{{ $bloquesOcupados }} de {{ $totalBloques }} bloques ocupados</span>

                        <div class="captura-progreso">
                            <div class="captura-progreso-barra"
                                 style="width:{{ $porcentajeOcupado }}%;"></div>
                        </div>
                    </div>
                </div>

                @if($bloquesLibres > 0)
                    <div class="captura-estado captura-estado-incompleto">
                        <strong>Horario con espacios libres.</strong>
                        Hay {{ $bloquesLibres }} bloques sin clase registrada.
                        Puedes dejarlos libres si así lo requiere la planificación del grupo.
                    </div>
                @else
                    <div class="captura-estado captura-estado-completo">
                        <strong>Todos los bloques están ocupados.</strong>
                        Revisa que la distribución de materias corresponda a la planificación escolar.
                    </div>
                @endif
            </section>

            @if($asignaciones->isEmpty())

                <div class="captura-notice" style="margin-bottom:16px;">
                    Este grupo todavía no tiene materias asignadas.
                    Revisa las asignaciones de materias y docentes antes de capturar su horario.
                </div>

            @else

                <div class="captura-notice"
                     style="margin-bottom:12px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;">

                    <span>
                        ⓘ Selecciona una materia por casilla. Las casillas vacías quedarán libres.
                    </span>

                    <div class="no-print" style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
                        <a href="{{ route('horarios.imprimir-grupo', $grupoSeleccionado->id) }}"
                           target="_blank"
                           rel="noopener"
                           class="captura-btn captura-btn-outline">
                            Imprimir horario
                        </a>

                        <button type="submit"
                                form="formCapturaRapida"
                                class="captura-btn captura-btn-primary">
                            ▣ Guardar horario semanal
                        </button>
                    </div>
                </div>

                {{-- Formulario independiente para guardar las casillas libres.
                     Los select usan el atributo form para evitar formularios anidados. --}}
                <form action="{{ route('horarios.guardar-captura-rapida') }}"
                      method="POST"
                      id="formCapturaRapida"
                      class="no-print">
                    @csrf
                    <input type="hidden" name="grupo_id" value="{{ $grupoSeleccionado->id }}">
                </form>

                <div class="captura-table-wrap">
                        <table class="captura-table">
                            <thead>
                                <tr>
                                    <th>Horario</th>

                                    @foreach($diasVista as $dia)
                                        <th>{{ $dia }}</th>
                                    @endforeach
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($bloquesVista as $indice => $bloque)

                                    @if($bloque['inicio'] === '10:00')
                                        <tr class="captura-receso">
                                            <td colspan="6">
                                                RECESO — 09:30 a 10:00
                                            </td>
                                        </tr>
                                    @endif

                                    <tr>
                                        <td class="time-cell">
                                            {{ $bloque['inicio'] }}
                                            <span>a {{ $bloque['fin'] }}</span>
                                        </td>

                                        @foreach($diasVista as $dia)

                                            @php
                                                $horarioExistente = $horarios->first(function ($horario) use ($dia, $bloque) {
                                                    return $horario->dia === $dia
                                                        && substr((string) $horario->hora_inicio, 0, 5) === $bloque['inicio']
                                                        && substr((string) $horario->hora_fin, 0, 5) === $bloque['fin'];
                                                });

                                                $seleccionAnterior = old("clases.$dia.$indice", '');

                                                $nombreMateria = strtolower(
                                                    (string) ($horarioExistente?->asignacionMateria?->materia?->nombre ?? '')
                                                );

                                                $coloresMateria = [
                                                    'matemáticas' => ['#2563EB', '#EFF6FF', '#BFDBFE'],
                                                    'matematicas' => ['#2563EB', '#EFF6FF', '#BFDBFE'],
                                                    'química' => ['#15803D', '#F0FDF4', '#BBF7D0'],
                                                    'quimica' => ['#15803D', '#F0FDF4', '#BBF7D0'],
                                                    'ética' => ['#7C3AED', '#F5F3FF', '#DDD6FE'],
                                                    'etica' => ['#7C3AED', '#F5F3FF', '#DDD6FE'],
                                                    'metodología' => ['#C2410C', '#FFF7ED', '#FED7AA'],
                                                    'metodologia' => ['#C2410C', '#FFF7ED', '#FED7AA'],
                                                    'taller de lectura' => ['#BE185D', '#FDF2F8', '#FBCFE8'],
                                                    'inglés' => ['#0E7490', '#ECFEFF', '#A5F3FC'],
                                                    'ingles' => ['#0E7490', '#ECFEFF', '#A5F3FC'],
                                                    'informática' => ['#475569', '#F1F5F9', '#CBD5E1'],
                                                    'informatica' => ['#475569', '#F1F5F9', '#CBD5E1'],
                                                    'tutorías' => ['#A16207', '#FEFCE8', '#FDE68A'],
                                                    'tutorias' => ['#A16207', '#FEFCE8', '#FDE68A'],
                                                    'paraescolares' => ['#0F766E', '#F0FDFA', '#99F6E4'],
                                                ];

                                                $colorMateria = ['#7B1E3A', '#F8F4F5', '#E7D9DE'];

                                                foreach ($coloresMateria as $palabra => $paleta) {
                                                    if ($nombreMateria !== '' && str_contains($nombreMateria, $palabra)) {
                                                        $colorMateria = $paleta;
                                                        break;
                                                    }
                                                }
                                            @endphp

                                            <td>
                                                @if($horarioExistente)

                                                    <div class="captura-class-card"
                                                         style="--materia-color:{{ $colorMateria[0] }};--materia-fondo:{{ $colorMateria[1] }};--materia-borde:{{ $colorMateria[2] }};">

                                                        <div class="status">Registrada</div>

                                                        <strong>
                                                            {{ $horarioExistente->asignacionMateria->materia->nombre ?? 'Materia' }}
                                                        </strong>

                                                        <span>
                                                            {{ $horarioExistente->asignacionMateria->docente->nombres ?? '' }}
                                                            {{ $horarioExistente->asignacionMateria->docente->apellidos ?? '' }}
                                                        </span>

                                                        <span>
                                                            Aula: {{ $horarioExistente->aula->nombre ?? 'Asignada' }}
                                                        </span>
                                                    </div>
                                                     
<div class="captura-card-actions no-print">
    <details class="captura-edit-details">
        <summary class="captura-mini-btn captura-edit-summary">✏️ Editar</summary>
        <div class="captura-edit-panel">
            <form action="{{ route('horarios.captura-rapida.actualizar', $horarioExistente->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="grupo_id" value="{{ $grupoSeleccionado->id }}">
                <label style="display:block;font-size:10px;font-weight:700;margin-bottom:5px;">Materia y docente</label>
                <select name="asignacion_materia_id" required class="captura-edit-select">
                    @foreach($asignaciones as $asignacion)
                        <option value="{{ $asignacion->id }}" @selected($asignacion->id == $horarioExistente->asignacion_materia_id)>
                            {{ $asignacion->materia->nombre ?? 'Materia' }} — {{ $asignacion->docente->nombres ?? $asignacion->docente->nombre ?? 'Docente' }} {{ $asignacion->docente->apellidos ?? '' }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="captura-mini-btn" style="margin-top:6px;background:#15803D;color:#fff;width:100%;">Guardar</button>
            </form>
        </div>
    </details>

    <form action="{{ route('horarios.captura-rapida.eliminar', $horarioExistente->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta clase del horario?');">
        @csrf
        @method('DELETE')
        <input type="hidden" name="grupo_id" value="{{ $grupoSeleccionado->id }}">
        <button type="submit" class="captura-mini-btn captura-delete-btn">🗑 Eliminar</button>
    </form>
</div>

                                                @else
                                                                                    
                                                    <select form="formCapturaRapida"
                                                            name="clases[{{ $dia }}][{{ $indice }}]"
                                                            class="captura-cell-select">

                                                        <option value="">— Libre —</option>

                                                        @foreach($asignaciones as $asignacion)
                                                            <option value="{{ $asignacion->id }}"
                                                                @selected((string) $seleccionAnterior === (string) $asignacion->id)>

                                                                {{ $asignacion->materia->nombre ?? 'Materia sin nombre' }}
                                                                —
                                                                {{ $asignacion->docente->nombres ?? '' }}
                                                                {{ $asignacion->docente->apellidos ?? '' }}
                                                            </option>
                                                        @endforeach

                                                    </select>

                                                    <div class="captura-cell-help">
                                                        Bloque disponible
                                                    </div>
                                                    
                                                @endif
                                            </td>

                                        @endforeach
                                    </tr>

                                @endforeach
                            </tbody>
                        </table>
                </div>

                <div class="captura-form-actions no-print">
                    <button type="reset" form="formCapturaRapida" class="captura-btn captura-btn-outline">
                        Limpiar selección
                    </button>

                    <button type="submit"
                            form="formCapturaRapida"
                            class="captura-btn captura-btn-primary"
                            onclick="return confirm('¿Guardar los bloques seleccionados para este grupo?');">
                        ▣ Guardar horario semanal
                    </button>
                </div>

                <div class="captura-notice">
                    <strong>Importante:</strong>
                    cada casilla guardada representa una clase de 50 minutos.
                    Los horarios registrados se muestran sin volver a enviarse.
                    El sistema asigna el aula automáticamente y valida los empalmes.
                </div>

            @endif
        @endif
    </div>
</x-app-layout>