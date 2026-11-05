<x-app-layout>
    <style>
        :root {
            --vino: #7B1E3A;
            --vino-oscuro: #5D142B;
            --vino-claro: #F8F4F5;
            --borde: #E7D9DE;
            --texto: #33262B;
            --muted: #786A70;
            --blanco: #FFFFFF;
        }

        .horarios-container {
            max-width: 1500px;
            margin: 0 auto;
            padding: 25px 20px 40px;
            color: var(--texto);
        }

        .page-header,
        .panel {
            background: var(--blanco);
            border: 1px solid var(--borde);
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(65, 18, 36, .04);
            margin-bottom: 18px;
        }

        .page-header {
            padding: 22px;
            border-top: 5px solid var(--vino);
        }

        .page-header h1 {
            margin: 0;
            font-size: 25px;
            font-weight: 800;
            color: var(--vino);
        }

        .page-header p {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 13px;
        }

        .panel {
            padding: 19px;
        }

        .section-title {
            color: var(--vino);
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 5px;
        }

        .section-description {
            margin: 0 0 16px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
        }

        .flow {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .flow-item {
            display: block;
            background: var(--vino-claro);
            border: 1px solid var(--borde);
            border-radius: 9px;
            padding: 14px;
            text-decoration: none;
            color: var(--vino);
            font-size: 13px;
            font-weight: 800;
            transition: .2s;
        }

        .flow-item:hover {
            border-color: var(--vino);
            background: #F2E7EB;
        }

        .flow-item small {
            display: block;
            margin-top: 5px;
            color: var(--muted);
            font-size: 11px;
            font-weight: 400;
            line-height: 1.5;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 14px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .filter-group label {
            color: var(--texto);
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .filter-group select {
            width: 100%;
            min-height: 40px;
            padding: 8px 10px;
            border: 1px solid #D8C8CE;
            border-radius: 7px;
            background: white;
            color: var(--texto);
            font-size: 12px;
        }

        .filter-group select:focus {
            outline: 2px solid #E8C8D3;
            border-color: var(--vino);
        }

        .filter-buttons {
            grid-column: 1 / -1;
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .btn {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 10px 14px;
            border: 1px solid var(--vino);
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 800;
            transition: .2s;
        }

        .btn-primary {
            background: var(--vino);
            color: white;
        }

        .btn-primary:hover {
            background: var(--vino-oscuro);
        }

        .btn-outline {
            background: white;
            color: var(--vino);
        }

        .btn-outline:hover {
            background: var(--vino-claro);
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .horarios-table,
        .weekly-table {
            width: 100%;
            border-collapse: collapse;
        }

        .horarios-table {
            min-width: 1000px;
        }

        .horarios-table th {
            padding: 11px 10px;
            background: var(--vino);
            color: white;
            text-align: left;
            white-space: nowrap;
            font-size: 11px;
            font-weight: 800;
        }

        .horarios-table td {
            padding: 10px;
            border-bottom: 1px solid #EFE5E8;
            font-size: 12px;
            vertical-align: middle;
        }

        .horarios-table tbody tr:nth-child(even) {
            background: #FCFAFB;
        }

        .horarios-table tbody tr:hover {
            background: var(--vino-claro);
        }

        .day-badge,
        .semester-badge {
            display: inline-block;
            border-radius: 20px;
            padding: 5px 9px;
            background: var(--vino-claro);
            color: var(--vino);
            border: 1px solid var(--borde);
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
        }

        .action-button {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 6px 8px;
            border-radius: 6px;
            border: 1px solid var(--borde);
            text-decoration: none;
            cursor: pointer;
            font-size: 10px;
            font-weight: 800;
        }

        .view-button {
            background: var(--vino-claro);
            color: var(--vino);
        }

        .edit-button {
            background: white;
            border-color: var(--vino);
            color: var(--vino);
        }

        .delete-button {
            background: var(--vino);
            border-color: var(--vino);
            color: white;
        }

        .action-buttons form {
            margin: 0;
        }

        .weekly-wrap {
            overflow-x: auto;
        }

        .weekly-table {
            min-width: 1050px;
            table-layout: fixed;
        }

        .weekly-table th {
            padding: 11px 8px;
            background: var(--vino);
            color: white;
            text-align: center;
            border: 1px solid #692039;
            font-size: 11px;
        }

        .weekly-table th:first-child {
            width: 125px;
        }

        .weekly-table td {
            border: 1px solid var(--borde);
            padding: 7px;
            vertical-align: top;
            height: 90px;
            background: white;
        }

        .hour-cell {
            background: var(--vino-claro) !important;
            color: var(--vino);
            font-weight: 800;
            text-align: center;
            vertical-align: middle !important;
            font-size: 11px;
        }

        .class-card {
            border: 1px solid var(--borde);
            border-left: 4px solid var(--vino);
            border-radius: 7px;
            padding: 8px;
            margin-bottom: 6px;
            background: #FCFAFB;
            overflow-wrap: anywhere;
        }

        .class-card:last-child {
            margin-bottom: 0;
        }

        .class-card strong {
            display: block;
            margin-bottom: 5px;
            color: var(--vino);
            font-size: 11px;
        }

        .class-info {
            display: block;
            margin-top: 4px;
            color: var(--muted);
            font-size: 10px;
            line-height: 1.5;
        }

        .empty-cell {
            text-align: center;
            color: #B6A9AE;
            padding-top: 20px;
        }

        .empty-message {
            padding: 30px 12px;
            text-align: center;
            color: var(--muted);
            font-size: 13px;
            background: #FCFAFB;
            border: 1px dashed var(--borde);
            border-radius: 8px;
        }

        .alert-success {
            background: var(--vino-claro);
            border: 1px solid var(--borde);
            color: var(--vino);
            border-radius: 8px;
            padding: 12px 15px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .collapsible-panel {
            padding: 0;
            overflow: hidden;
        }

        .collapsible-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 19px;
            cursor: pointer;
            list-style: none;
            color: var(--vino);
            font-size: 16px;
            font-weight: 800;
        }

        .collapsible-summary::-webkit-details-marker {
            display: none;
        }

        .collapsible-summary::after {
            content: "⌄";
            color: var(--vino);
            font-size: 20px;
            line-height: 1;
            transition: transform .2s ease;
        }

        .collapsible-panel[open] .collapsible-summary::after {
            transform: rotate(180deg);
        }

        .toggle-label {
            margin-left: auto;
            color: var(--vino);
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .collapsible-content {
            padding: 0 19px 19px;
        }

        .capture-panel {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 22px;
            background: linear-gradient(135deg, #FFFFFF 0%, #F8F4F5 100%);
            border: 1px solid var(--borde);
            border-left: 5px solid var(--vino);
            border-radius: 10px;
        }

        .capture-panel h3 {
            margin: 0 0 7px;
            color: var(--vino);
            font-size: 18px;
            font-weight: 800;
        }

        .capture-panel p {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .capture-panel .btn {
            flex-shrink: 0;
            min-height: 42px;
        }

        @media (max-width: 650px) {
            .collapsible-summary {
                padding: 15px;
            }

            .collapsible-content {
                padding: 0 12px 14px;
            }

            .capture-panel {
                align-items: stretch;
                flex-direction: column;
                padding: 17px;
            }

            .capture-panel .btn {
                width: 100%;
            }
        }

        @media (max-width: 1000px) {
            .filter-form {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .flow {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 650px) {
            .horarios-container {
                padding: 15px 10px 25px;
            }

            .page-header {
                padding: 17px;
            }

            .page-header h1 {
                font-size: 21px;
            }

            .panel {
                padding: 14px;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .filter-buttons {
                grid-column: auto;
            }

            .filter-buttons .btn {
                flex: 1;
            }
        }
    </style>

    <div class="horarios-container">

        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- ENCABEZADO SIN BOTONES DUPLICADOS --}}
        <header class="page-header">
            <h1>Horarios escolares</h1>
            <p>
                Consulta y organiza los horarios por semestre, docente o grupo.
                Las aulas se asignan automáticamente.
            </p>
        </header>
        </section>

        {{-- ACCIONES PRINCIPALES: SOLO APARECEN AQUÍ --}}
        <section class="panel">
            <h2 class="section-title">Cómo organizar los horarios</h2>

            <p class="section-description">
                Sigue estos pasos para registrar materias, asignarlas a los grupos
                y programar sus horarios.
            </p>

            <div class="flow">
                <a href="{{ route('materias.create') }}" class="flow-item">
                    1. Registrar materias
                    <small>
                        Define el nombre, las horas y el semestre de cada materia.
                    </small>
                </a>

                <a href="{{ route('asignaciones_materias.create') }}"
                   class="flow-item">
                    2. Asignar materias
                    <small>
                        Relaciona al docente con una materia, un grupo y un ciclo escolar.
                    </small>
                </a>

                <a href="{{ route('horarios.create') }}" class="flow-item">
                    3. Crear horario
                    <small>
                        Selecciona el día y las horas; el sistema busca un aula disponible.
                    </small>
                </a>
            </div>
        </section>

        {{-- FILTROS --}}
        <section class="panel">
            <h2 class="section-title">Consultar horarios</h2>

            <p class="section-description">
                Selecciona un semestre, docente, grado o grupo.
                Puedes combinar varios filtros.
            </p>

            <form action="{{ route('horarios.index') }}"
                  method="GET"
                  class="filter-form">

                <div class="filter-group">
                    <label for="semestre">Semestre</label>

                    <select name="semestre" id="semestre">
                        <option value="">Todos los semestres</option>

                        @foreach(range(1, 6) as $semestreItem)
                            <option value="{{ $semestreItem }}"
                                {{ (string) ($semestre ?? '') === (string) $semestreItem ? 'selected' : '' }}>
                                {{ $semestreItem }}° semestre
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="docente_id">Docente</label>

                    <select name="docente_id" id="docente_id">
                        <option value="">Todos los docentes</option>

                        @foreach($docentes as $docenteItem)
                            <option value="{{ $docenteItem->id }}"
                                {{ (string) ($docenteId ?? '') === (string) $docenteItem->id ? 'selected' : '' }}>
                                {{ $docenteItem->apellidos }}, {{ $docenteItem->nombres }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="grado">Grado</label>

                    <select name="grado" id="grado">
                        <option value="">Todos los grados</option>

                        @foreach($grados as $gradoItem)
                            <option value="{{ $gradoItem }}"
                                {{ (string) ($grado ?? '') === (string) $gradoItem ? 'selected' : '' }}>
                                {{ $gradoItem }}°
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="grupo_id">Grupo</label>

                    <select name="grupo_id" id="grupo_id">
                        <option value="">Todos los grupos</option>

                        @foreach($grupos as $grupoItem)
                            <option value="{{ $grupoItem->id }}"
                                data-grado="{{ $grupoItem->grado }}"
                                {{ (string) ($grupoId ?? '') === (string) $grupoItem->id ? 'selected' : '' }}>
                                {{ $grupoItem->grado }}° {{ $grupoItem->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-buttons">
                    <button type="submit" class="btn btn-primary">
                        Consultar horarios
                    </button>

                    <a href="{{ route('horarios.index') }}"
                       class="btn btn-outline">
                        Limpiar filtros
                    </a>
                </div>
            </form>
        </section>

        {{-- LISTADO DE HORARIOS PLEGABLE --}}
        <details class="panel collapsible-panel">
            <summary class="collapsible-summary">
                <span>Listado de horarios</span>
                <span class="toggle-label">Desplegar listado</span>
            </summary>
            <div class="collapsible-content">
                <p class="section-description">
                    {{ $horarios->count() }} horario(s) encontrados. Abre esta sección cuando necesites consultar, editar o eliminar un registro.
                </p>

            <p class="section-description">
                {{ $horarios->count() }} horario(s) encontrados.
            </p>

            @if($horarios->isEmpty())
                <div class="empty-message">
                    No se encontraron horarios con los filtros seleccionados.
                    Puedes cambiar los filtros o registrar un horario nuevo.
                </div>
            @else
                <div class="table-wrap">
                    <table class="horarios-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Docente</th>
                                <th>Materia</th>
                                <th>Semestre</th>
                                <th>Grupo</th>
                                <th>Día</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Aula asignada</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($horarios as $horario)
                                <tr>
                                    <td>{{ $horario->id }}</td>

                                    <td>
                                        {{ $horario->asignacionMateria->docente->apellidos ?? '' }},
                                        {{ $horario->asignacionMateria->docente->nombres ?? 'Sin docente' }}
                                    </td>

                                    <td>
                                        {{ $horario->asignacionMateria->materia->nombre ?? 'Sin materia' }}
                                    </td>

                                    <td>
                                        @if($horario->asignacionMateria->materia->semestre ?? false)
                                            <span class="semester-badge">
                                                {{ $horario->asignacionMateria->materia->semestre }}°
                                            </span>
                                        @else
                                            —
                                        @endif
                                    </td>

                                    <td>
                                        {{ $horario->asignacionMateria->grupo->grado ?? '' }}°
                                        {{ $horario->asignacionMateria->grupo->nombre ?? 'Sin grupo' }}
                                    </td>

                                    <td>
                                        <span class="day-badge">
                                            {{ $horario->dia }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                                    </td>

                                    <td>
                                        {{ $horario->aula->nombre ?? 'Sin aula' }}
                                    </td>

                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('horarios.show', $horario->id) }}"
                                               class="action-button view-button">
                                                Ver
                                            </a>

                                            <a href="{{ route('horarios.edit', $horario->id) }}"
                                               class="action-button edit-button">
                                                Editar
                                            </a>

                                            <form action="{{ route('horarios.destroy', $horario->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('¿Seguro que deseas eliminar este horario?');">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="action-button delete-button">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
            </div>
        </details>

        <section class="panel">
            <h2 class="section-title">Captura rápida semanal</h2>
            <p class="section-description">
                Llena el horario de un grupo de lunes a viernes en una sola pantalla. Las materias y docentes se cargan según las asignaciones del grupo y las aulas se asignan automáticamente.
            </p>

            <div class="capture-panel">
                <div>
                    <h3>Organiza el horario de cada grupo</h3>
                    <p>
                        Selecciona un grupo, elige las materias en los bloques de 50 minutos y guarda la semana. Los horarios registrados también aparecerán en el listado de arriba.
                    </p>
                </div>

                <a href="{{ route('horarios.captura-rapida') }}" class="btn btn-primary">
                    Abrir captura rápida
                </a>
            </div>
        </section>
    </div>

    {{-- FILTRAR GRUPOS SEGÚN EL GRADO --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const listado = document.querySelector('.collapsible-panel');
            const textoDesplegar = document.querySelector('.toggle-label');

            if (listado && textoDesplegar) {
                const actualizarTextoListado = function () {
                    textoDesplegar.textContent = listado.open
                        ? 'Ocultar listado'
                        : 'Desplegar listado';
                };

                listado.addEventListener('toggle', actualizarTextoListado);
                actualizarTextoListado();
            }

            const gradoSelect = document.getElementById('grado');
            const grupoSelect = document.getElementById('grupo_id');

            if (!gradoSelect || !grupoSelect) {
                return;
            }

            function actualizarGrupos() {
                const gradoSeleccionado = gradoSelect.value;
                const opciones = grupoSelect.querySelectorAll('option[data-grado]');

                opciones.forEach(function (opcion) {
                    const coincide =
                        gradoSeleccionado === '' ||
                        opcion.dataset.grado === gradoSeleccionado;

                    opcion.hidden = !coincide;
                });

                const seleccionada = grupoSelect.options[grupoSelect.selectedIndex];

                if (
                    seleccionada &&
                    seleccionada.dataset.grado &&
                    gradoSeleccionado !== '' &&
                    seleccionada.dataset.grado !== gradoSeleccionado
                ) {
                    grupoSelect.value = '';
                }
            }

            gradoSelect.addEventListener('change', actualizarGrupos);
            actualizarGrupos();
        });
    </script>
</x-app-layout>