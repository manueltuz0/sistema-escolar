<x-app-layout>

    <style>

        .horarios-container {
            max-width: 1450px;
            margin: 0 auto;
            padding: 25px 20px 40px;
        }

        /* ENCABEZADO */

        .page-header {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .page-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .page-header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #6b7280;
        }

        .new-button {
            background: #198754;
            color: white;
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .new-button:hover {
            background: #157347;
        }


        /* FLUJO */

        .organization-box {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 18px;
        }

        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 12px;
        }

        .flow {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .flow-item {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1e40af;
            padding: 10px 20px;
            border-radius: 7px;
            text-decoration: none;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
            min-width: 170px;
        }

        .flow-item:hover {
            background: #dbeafe;
        }

        .flow-item small {
            display: block;
            margin-top: 4px;
            font-size: 10px;
            font-weight: 400;
            color: #4b5563;
        }

        .arrow {
            font-size: 20px;
            font-weight: bold;
            color: #6b7280;
        }


        /* FILTROS */

        .filter-box {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 18px;
            margin-bottom: 18px;
        }

        .filter-title {
            font-size: 15px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 15px;
        }

        .filter-form {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
        }

        .filter-group label {
            font-size: 11px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 5px;
        }

        .filter-group select {
            width: 100%;
            height: 36px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            padding: 0 10px;
            font-size: 12px;
            background: white;
        }

        .filter-buttons {
            grid-column: 1 / -1;
            display: flex;
            gap: 8px;
        }

        .filter-button {
            border: none;
            background: #2563eb;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
        }

        .filter-button:hover {
            background: #1d4ed8;
        }

        .clear-button {
            background: #6b7280;
            color: white;
            text-decoration: none;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 11px;
            font-weight: 600;
        }

        .clear-button:hover {
            background: #4b5563;
        }


        /* TABLA */

        .table-box {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px;
            margin-bottom: 18px;
        }

        .table-title {
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            margin: 4px 0 10px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .horarios-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 950px;
        }

        .horarios-table th {
            background: #1f2937;
            color: white;
            padding: 8px;
            text-align: left;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
        }

        .horarios-table td {
            border: 1px solid #e5e7eb;
            padding: 7px 8px;
            font-size: 11px;
            color: #374151;
            vertical-align: middle;
        }

        .horarios-table tbody tr:hover {
            background: #f9fafb;
        }

        .day-badge {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            border-radius: 4px;
            padding: 4px 7px;
            font-size: 10px;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .action-button {
            border: none;
            text-decoration: none;
            border-radius: 4px;
            padding: 5px 7px;
            font-size: 10px;
            font-weight: 600;
            cursor: pointer;
        }

        .view-button {
            background: #2563eb;
            color: white;
        }

        .edit-button {
            background: #f59e0b;
            color: white;
        }

        .delete-button {
            background: #dc2626;
            color: white;
        }

        .action-buttons form {
            margin: 0;
        }


        /* VISTA SEMANAL */

        .weekly-box {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 12px;
            overflow-x: auto;
        }

        .weekly-title {
            font-size: 14px;
            font-weight: 700;
            color: #1f2937;
            margin: 4px 0 10px;
        }

        .weekly-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1100px;
            table-layout: fixed;
        }

        .weekly-table th {
            background: #2563eb;
            color: white;
            border: 1px solid #1d4ed8;
            padding: 8px;
            text-align: center;
            font-size: 11px;
        }

        .weekly-table th:first-child {
            width: 125px;
        }

        .weekly-table td {
            border: 1px solid #d1d5db;
            padding: 5px;
            vertical-align: top;
            height: 95px;
            background: white;
        }

        .hour-cell {
            background: #1f2937 !important;
            color: white;
            text-align: center;
            font-size: 10px;
            font-weight: 600;
            vertical-align: middle !important;
        }

        .class-card {
            border-radius: 6px;
            border: 1px solid #bfdbfe;
            background: #eff6ff;
            padding: 7px;
            margin-bottom: 5px;
            color: #1f2937;
        }

        .class-card:last-child {
            margin-bottom: 0;
        }

        .class-card strong {
            display: block;
            color: #1e3a8a;
            font-size: 11px;
            margin-bottom: 5px;
        }

        .class-info {
            display: block;
            font-size: 9px;
            color: #4b5563;
            margin-top: 3px;
        }

        .class-actions {
            display: flex;
            gap: 3px;
            margin-top: 6px;
            flex-wrap: wrap;
        }

        .class-actions a,
        .class-actions button {
            font-size: 9px;
            padding: 3px 5px;
            border-radius: 3px;
            border: none;
            text-decoration: none;
            cursor: pointer;
        }

        .class-actions form {
            margin: 0;
        }

        .class-view {
            background: #2563eb;
            color: white;
        }

        .class-edit {
            background: #f59e0b;
            color: white;
        }

        .class-delete {
            background: #dc2626;
            color: white;
        }

        .empty-cell {
            text-align: center;
            color: #9ca3af;
            font-size: 13px;
            vertical-align: middle !important;
        }

        .empty-message {
            text-align: center;
            padding: 30px 10px;
            color: #6b7280;
            font-size: 13px;
        }


        /* RESPONSIVO */

        @media (max-width: 800px) {

            .page-header {
                flex-direction: column;
                align-items: stretch;
            }

            .new-button {
                text-align: center;
            }

            .filter-form {
                grid-template-columns: 1fr;
            }

            .filter-buttons {
                grid-column: auto;
            }

            .flow {
                flex-direction: column;
            }

            .arrow {
                transform: rotate(90deg);
            }

        }

    </style>


    <div class="horarios-container">


        {{-- ENCABEZADO --}}

        <div class="page-header">

    <div>

        <h1>
            Horarios y Asignación de Materias
        </h1>

        <p>
            Administra los horarios, docentes, materias, grupos y aulas.
        </p>

    </div>

    <div style="display: flex; gap: 8px; align-items: center;">

        <a href="{{ route('materias.create') }}"
           class="new-button">

            + Nueva Materia

        </a>

        <a href="{{ route('horarios.create') }}"
           class="new-button">

            + Nuevo Horario

        </a>

    </div>

</div>

        {{-- FILTROS --}}

        <div class="filter-box">

            <div class="filter-title">
                Consultar horarios
            </div>

            <form action="{{ route('horarios.index') }}"
                  method="GET"
                  class="filter-form">


                {{-- GRADO --}}

                <div class="filter-group">

                    <label for="grado">
                        Seleccionar grado
                    </label>

                    <select name="grado"
                            id="grado">

                        <option value="">
                            -- Mostrar todos los grados --
                        </option>

                        @foreach($grados as $gradoItem)

                            <option value="{{ $gradoItem }}"
                                {{ (string) $grado === (string) $gradoItem ? 'selected' : '' }}>

                                {{ $gradoItem }}°

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- GRUPO --}}

                <div class="filter-group">

                    <label for="grupo_id">
                        Seleccionar grupo
                    </label>

                    <select name="grupo_id"
                            id="grupo_id">

                        <option value="">
                            -- Mostrar todos los grupos --
                        </option>

                        @foreach($grupos as $grupoItem)

                            <option value="{{ $grupoItem->id }}"
                                    data-grado="{{ $grupoItem->grado }}"
                                {{ (string) $grupoId === (string) $grupoItem->id ? 'selected' : '' }}>

                                {{ $grupoItem->grado }}° {{ $grupoItem->nombre }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- DOCENTE --}}

                <div class="filter-group">

                    <label for="docente_id">
                        Seleccionar docente
                    </label>

                    <select name="docente_id"
                            id="docente_id">

                        <option value="">
                            -- Mostrar todos los docentes --
                        </option>

                        @foreach($docentes as $docenteItem)

                            <option value="{{ $docenteItem->id }}"
                                {{ (string) $docenteId === (string) $docenteItem->id ? 'selected' : '' }}>

                                {{ $docenteItem->nombres }}
                                {{ $docenteItem->apellidos }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- BOTONES --}}

                <div class="filter-buttons">

                    <button type="submit"
                            class="filter-button">

                        Consultar horarios

                    </button>


                    <a href="{{ route('horarios.index') }}"
                       class="clear-button">

                        Limpiar filtros

                    </a>

                </div>

            </form>

        </div>


        {{-- TABLA DE HORARIOS --}}

        <div class="table-box">

            <div class="table-title">
                Todos los horarios registrados
            </div>

            @if($horarios->isEmpty())

                <div class="empty-message">

                    No se encontraron horarios con los filtros seleccionados.

                </div>

            @else

                <div class="table-responsive">

                    <table class="horarios-table">

                        <thead>

                            <tr>

                                <th>ID</th>
                                <th>Docente</th>
                                <th>Materia</th>
                                <th>Grupo</th>
                                <th>Día</th>
                                <th>Hora de inicio</th>
                                <th>Hora de fin</th>
                                <th>Aula</th>
                                <th>Acciones</th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($horarios as $horario)

                                <tr>

                                    <td>
                                        {{ $horario->id }}
                                    </td>


                                    <td>

                                        {{ $horario->asignacionMateria->docente->nombres ?? 'Sin docente' }}

                                        {{ $horario->asignacionMateria->docente->apellidos ?? '' }}

                                    </td>


                                    <td>

                                        {{ $horario->asignacionMateria->materia->nombre ?? 'Sin materia' }}

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


        {{-- VISTA SEMANAL --}}


<div class="weekly-box">

    <div class="weekly-title">
        Vista semanal de horarios
    </div>

    @if($horarios->isEmpty())

        <div class="empty-message">
            No hay horarios para mostrar en la vista semanal.
        </div>

    @else

        @php

            $horas = $horarios
                ->map(function ($horario) {

                    return [
                        'inicio' => $horario->hora_inicio,
                        'fin' => $horario->hora_fin,
                    ];

                })
                ->unique(function ($hora) {

                    return $hora['inicio'] . '|' . $hora['fin'];

                })
                ->sortBy(function ($hora) {

                    return $hora['inicio'];

                })
                ->values();

            $diasSemana = [
                'Lunes',
                'Martes',
                'Miércoles',
                'Jueves',
                'Viernes'
            ];

        @endphp


        <div style="overflow-x:auto;">

            <table class="weekly-table">

                <thead>

                    <tr>

                        <th>
                            Hora
                        </th>

                        @foreach($diasSemana as $dia)

                            <th>
                                {{ $dia }}
                            </th>

                        @endforeach

                    </tr>

                </thead>


                <tbody>

                    @foreach($horas as $hora)

                        <tr>

                            <td class="hour-cell">

                                {{ \Carbon\Carbon::parse($hora['inicio'])->format('H:i') }}

                                -

                                {{ \Carbon\Carbon::parse($hora['fin'])->format('H:i') }}

                            </td>


                            @foreach($diasSemana as $dia)

                                @php

                                    $clases = $horarios->filter(function ($item) use ($dia, $hora) {

                                        return $item->dia === $dia
                                            && $item->hora_inicio === $hora['inicio']
                                            && $item->hora_fin === $hora['fin'];

                                    });

                                @endphp


                                <td>

                                    @if($clases->isEmpty())

                                        <div class="empty-cell">
                                            —
                                        </div>

                                    @else

                                        @foreach($clases as $clase)

                                            <div class="class-card">

                                                <strong>

                                                    {{ $clase->asignacionMateria->materia->nombre ?? 'Sin materia' }}

                                                </strong>


                                                <span class="class-info">

                                                    👨‍🏫

                                                    {{ $clase->asignacionMateria->docente->nombres ?? 'Sin docente' }}

                                                    {{ $clase->asignacionMateria->docente->apellidos ?? '' }}

                                                </span>


                                                <span class="class-info">

                                                    👥

                                                    {{ $clase->asignacionMateria->grupo->grado ?? '' }}°

                                                    {{ $clase->asignacionMateria->grupo->nombre ?? 'Sin grupo' }}

                                                </span>


                                                <span class="class-info">

                                                    🏫

                                                    {{ $clase->aula->nombre ?? 'Sin aula' }}

                                                </span>

                                            </div>

                                        @endforeach

                                    @endif

                                </td>

                            @endforeach

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>


    {{-- FILTRO DE GRUPOS SEGÚN EL GRADO --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const gradoSelect = document.getElementById('grado');
            const grupoSelect = document.getElementById('grupo_id');

            if (!gradoSelect || !grupoSelect) {
                return;
            }

            function actualizarGrupos() {

                const gradoSeleccionado = gradoSelect.value;

                const opciones = grupoSelect.querySelectorAll('option[data-grado]');

                opciones.forEach(function (opcion) {

                    if (
                        gradoSeleccionado === '' ||
                        opcion.dataset.grado === gradoSeleccionado
                    ) {

                        opcion.style.display = '';

                    } else {

                        opcion.style.display = 'none';

                    }

                });

                /*
                 * Si el grupo seleccionado no pertenece
                 * al grado seleccionado, regresamos a
                 * "todos los grupos".
                 */

                const opcionActual = grupoSelect.options[grupoSelect.selectedIndex];

                if (
                    opcionActual &&
                    opcionActual.dataset.grado &&
                    gradoSeleccionado !== '' &&
                    opcionActual.dataset.grado !== gradoSeleccionado
                ) {

                    grupoSelect.value = '';

                }

            }


            gradoSelect.addEventListener('change', actualizarGrupos);

            actualizarGrupos();

        });

    </script>

</x-app-layout>