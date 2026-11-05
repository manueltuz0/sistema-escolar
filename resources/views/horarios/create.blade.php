@extends('layouts.app')

@section('content')

@php
    $ciclosEscolares = $asignaciones
        ->pluck('cicloEscolar')
        ->filter()
        ->unique('id')
        ->sortByDesc('fecha_inicio')
        ->values();

    $asignacionesJs = $asignaciones->map(function ($asignacion) {
        return [
            'id' => $asignacion->id,
            'docente_id' => $asignacion->docente_id,
            'materia_id' => $asignacion->materia_id,
            'semestre' => $asignacion->materia->semestre ?? null,
            'grupo_id' => $asignacion->grupo_id,
            'grado' => $asignacion->grupo->grado ?? null,
            'grupo_ciclo_id' => $asignacion->grupo->ciclo_escolar_id ?? null,
            'ciclo_escolar_id' => $asignacion->ciclo_escolar_id,
            'docente' => trim(
                ($asignacion->docente->nombres ?? '') . ' ' .
                ($asignacion->docente->apellidos ?? '')
            ),
            'materia' => $asignacion->materia->nombre ?? '',
            'grupo' => trim(
                ($asignacion->grupo->grado ?? '') . '° ' .
                ($asignacion->grupo->nombre ?? '')
            ),
            'ciclo' => $asignacion->cicloEscolar->nombre ?? '',
        ];
    })->values();
@endphp

<style>
    .horario-container {
        max-width: 850px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .horario-card {
        background: #FFFFFF;
        border: 1px solid #E8DDE1;
        border-radius: 12px;
        padding: 32px 36px;
        box-shadow: 0 4px 16px rgba(70, 20, 38, 0.08);
    }

    .horario-title {
        font-size: 28px;
        font-weight: 700;
        color: #7B1E3A;
        margin-bottom: 8px;
    }

    .horario-description {
        color: #62565B;
        margin-bottom: 26px;
        line-height: 1.6;
    }

    .section-title {
        font-size: 17px;
        font-weight: 700;
        color: #7B1E3A;
        border-bottom: 1px solid #E8DDE1;
        padding-bottom: 8px;
        margin: 24px 0 18px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #49202E;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #D8C8CE;
        border-radius: 7px;
        font-size: 15px;
        color: #30252A;
        background: #FFFFFF;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #7B1E3A;
        box-shadow: 0 0 0 3px rgba(123, 30, 58, 0.12);
    }

    .form-control:disabled {
        background: #F8F4F5;
        color: #75666C;
        cursor: not-allowed;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .required-note {
        font-size: 13px;
        color: #75666C;
        margin-top: 5px;
        line-height: 1.5;
    }

    .buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 28px;
    }

    .btn {
        border: none;
        border-radius: 7px;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background: #7B1E3A;
        color: #FFFFFF;
    }

    .btn-primary:hover {
        background: #5F152C;
        color: #FFFFFF;
    }

    .btn-secondary {
        background: #F8F4F5;
        color: #7B1E3A;
        border: 1px solid #D8C8CE;
    }

    .btn-secondary:hover {
        background: #EFE3E7;
        color: #5F152C;
    }

    .error-box {
        background: #FFF1F2;
        border: 1px solid #E9AAB7;
        color: #8A1835;
        padding: 14px 16px;
        border-radius: 7px;
        margin-bottom: 20px;
    }

    .error-box ul {
        margin: 8px 0 0 20px;
    }

    .info-box {
        display: none;
        background: #F8F4F5;
        border: 1px solid #D8C8CE;
        color: #5F152C;
        padding: 12px 14px;
        border-radius: 7px;
        margin: 0 0 20px;
        font-size: 14px;
        line-height: 1.6;
    }

    .info-box.error {
        background: #FFF1F2;
        border-color: #E9AAB7;
        color: #8A1835;
    }

    @media (max-width: 700px) {
        .horario-card {
            padding: 24px 18px;
        }

        .horario-title {
            font-size: 24px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .buttons {
            flex-direction: column;
        }

        .btn {
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>

<div class="horario-container">
    <div class="horario-card">

        <div class="horario-title">
            Registrar nuevo horario
        </div>

        <div class="horario-description">
            Selecciona al docente y su materia asignada, después define el día y la duración de la clase.
            El sistema comprobará los conflictos y asignará automáticamente un aula disponible.
        </div>

        @if ($errors->any())
            <div class="error-box" role="alert">
                <strong>No se pudo completar la operación:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            id="horarioForm"
            method="POST"
            action="{{ route('horarios.store') }}"
        >
            @csrf

            <input
                type="hidden"
                name="asignacion_materia_id"
                id="asignacion_materia_id"
                value="{{ old('asignacion_materia_id') }}"
            >

            <div class="section-title">Datos de la asignación</div>

            <div class="form-group">
                <label for="docente_id">Docente</label>

                <select id="docente_id" class="form-control" required>
                    <option value="">Selecciona un docente</option>

                    @foreach ($docentes as $docente)
                        <option
                            value="{{ $docente->id }}"
                            @selected((string) old('docente_id') === (string) $docente->id)
                        >
                            {{ $docente->apellidos }}, {{ $docente->nombres }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="semestre">Semestre</label>

                <select id="semestre" class="form-control" required disabled>
                    <option value="">Selecciona primero un docente</option>
                </select>

                <div class="required-note">
                    Solo aparecerán los semestres en los que el docente tenga materias asignadas.
                </div>
            </div>

            <div class="form-group">
                <label for="materia_id">Materia</label>

                <select id="materia_id" class="form-control" required disabled>
                    <option value="">Selecciona primero docente y semestre</option>

                    @foreach ($materias as $materia)
                        <option
                            value="{{ $materia->id }}"
                            data-semestre="{{ $materia->semestre }}"
                        >
                            {{ $materia->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="grado">Grado del grupo</label>

                    <select id="grado" class="form-control" required>
                        <option value="">Selecciona un grado</option>

                        @foreach ([1, 2, 3, 4, 5, 6] as $gradoDisponible)
                            <option
                                value="{{ $gradoDisponible }}"
                                @selected((string) old('grado') === (string) $gradoDisponible)
                            >
                                {{ $gradoDisponible }}°
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="grupo_id">Grupo</label>

                    <select id="grupo_id" class="form-control" required disabled>
                        <option value="">Selecciona primero un grado</option>

                        @foreach ($grupos as $grupo)
                            <option
                                value="{{ $grupo->id }}"
                                data-grado="{{ $grupo->grado }}"
                                data-ciclo="{{ $grupo->ciclo_escolar_id }}"
                            >
                                {{ $grupo->grado }}° {{ $grupo->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="ciclo_escolar_id">Ciclo escolar</label>

                <select id="ciclo_escolar_id" class="form-control" required>
                    <option value="">Selecciona un ciclo escolar</option>

                    @foreach ($ciclosEscolares as $ciclo)
                        <option
                            value="{{ $ciclo->id }}"
                            @selected((string) old('ciclo_escolar_id') === (string) $ciclo->id)
                        >
                            {{ $ciclo->nombre }}
                            @if ($ciclo->activo)
                                (Activo)
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            <div id="asignacionInfo" class="info-box" role="status"></div>

            <div class="section-title">Día y duración de la clase</div>

            <div class="form-group">
                <label for="dia">Día</label>

                <select id="dia" name="dia" class="form-control" required>
                    <option value="">Selecciona un día</option>

                    @foreach (['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes'] as $dia)
                        <option
                            value="{{ $dia }}"
                            @selected(old('dia') === $dia)
                        >
                            {{ $dia }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="hora_inicio">Hora de inicio</label>

                    <input
                        type="time"
                        id="hora_inicio"
                        name="hora_inicio"
                        class="form-control"
                        value="{{ old('hora_inicio') }}"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="hora_fin">Hora de fin</label>

                    <input
                        type="time"
                        id="hora_fin"
                        name="hora_fin"
                        class="form-control"
                        value="{{ old('hora_fin') }}"
                        required
                    >
                </div>
            </div>

            <div class="info-box" style="display:block">
                <strong>Asignación automática de aula</strong><br>
                No necesitas seleccionar un salón. El sistema elegirá uno disponible.
                Si el docente, el grupo o todas las aulas están ocupados, te mostrará un error.
            </div>

            <div class="buttons">
                <button type="submit" class="btn btn-primary">
                    Guardar horario
                </button>

                <a href="{{ route('horarios.index') }}" class="btn btn-secondary">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
const asignaciones = {{ Illuminate\Support\Js::from($asignacionesJs) }};

document.addEventListener('DOMContentLoaded', function () {
    const docenteSelect = document.getElementById('docente_id');
    const semestreSelect = document.getElementById('semestre');
    const materiaSelect = document.getElementById('materia_id');
    const gradoSelect = document.getElementById('grado');
    const grupoSelect = document.getElementById('grupo_id');
    const cicloSelect = document.getElementById('ciclo_escolar_id');
    const asignacionInput = document.getElementById('asignacion_materia_id');
    const asignacionInfo = document.getElementById('asignacionInfo');
    const form = document.getElementById('horarioForm');

    const valoresAnteriores = {
        docente: @json(old('docente_id', '')),
        semestre: @json(old('semestre', '')),
        materia: @json(old('materia_id', '')),
        grado: @json(old('grado', '')),
        grupo: @json(old('grupo_id', '')),
        ciclo: @json(old('ciclo_escolar_id', ''))
    };

    function mostrarMensaje(mensaje, esError = false) {
        asignacionInfo.textContent = mensaje;
        asignacionInfo.classList.toggle('error', esError);
        asignacionInfo.style.display = 'block';
    }

    function limpiarMensaje() {
        asignacionInfo.textContent = '';
        asignacionInfo.classList.remove('error');
        asignacionInfo.style.display = 'none';
    }

    function filtrarSemestres() {
        const docenteId = docenteSelect.value;
        const semestreAnterior = semestreSelect.value || valoresAnteriores.semestre;

        semestreSelect.innerHTML = '';

        const opcionInicial = document.createElement('option');
        opcionInicial.value = '';
        opcionInicial.textContent = docenteId
            ? 'Selecciona un semestre'
            : 'Selecciona primero un docente';

        semestreSelect.appendChild(opcionInicial);

        const semestres = [...new Set(
            asignaciones
                .filter(item =>
                    String(item.docente_id) === String(docenteId) &&
                    item.semestre !== null &&
                    item.semestre !== ''
                )
                .map(item => Number(item.semestre))
        )].sort((a, b) => a - b);

        semestres.forEach(function (semestre) {
            const opcion = document.createElement('option');
            opcion.value = String(semestre);
            opcion.textContent = semestre === 1
                ? '1.er semestre'
                : semestre + '.º semestre';

            semestreSelect.appendChild(opcion);
        });

        semestreSelect.disabled = !docenteId;

        if (semestres.length === 0 && docenteId) {
            opcionInicial.textContent =
                'Este docente no tiene materias con semestre registrado';
        }

        if (semestres.map(String).includes(String(semestreAnterior))) {
            semestreSelect.value = String(semestreAnterior);
        }

        filtrarMaterias();
    }

    function filtrarMaterias() {
        const docenteId = docenteSelect.value;
        const semestre = semestreSelect.value;
        const materiaAnterior = materiaSelect.value || valoresAnteriores.materia;

        materiaSelect.value = '';

        Array.from(materiaSelect.options).forEach(function (option) {
            if (!option.value) {
                option.hidden = false;
                return;
            }

            const tieneAsignacion = asignaciones.some(function (item) {
                return String(item.docente_id) === String(docenteId)
                    && String(item.semestre) === String(semestre)
                    && String(item.materia_id) === String(option.value);
            });

            option.hidden = !docenteId
                || !semestre
                || String(option.dataset.semestre) !== String(semestre)
                || !tieneAsignacion;
        });

        materiaSelect.disabled = !docenteId || !semestre;

        const materiasVisibles = Array.from(materiaSelect.options).filter(
            option => option.value && !option.hidden
        );

        materiaSelect.options[0].textContent = !docenteId || !semestre
            ? 'Selecciona primero docente y semestre'
            : materiasVisibles.length
                ? 'Selecciona una materia'
                : 'No hay materias asignadas en este semestre';

        if (materiasVisibles.some(option => option.value === String(materiaAnterior))) {
            materiaSelect.value = String(materiaAnterior);
        }

        buscarAsignacion();
    }

    function filtrarGrupos() {
        const grado = gradoSelect.value;
        const ciclo = cicloSelect.value;
        const grupoAnterior = grupoSelect.value || valoresAnteriores.grupo;

        grupoSelect.value = '';

        Array.from(grupoSelect.options).forEach(function (option) {
            if (!option.value) {
                option.hidden = false;
                return;
            }

            const coincideGrado = String(option.dataset.grado) === String(grado);
            const coincideCiclo = !ciclo ||
                String(option.dataset.ciclo) === String(ciclo);

            option.hidden = !(coincideGrado && coincideCiclo);
        });

        grupoSelect.disabled = !grado;

        if (Array.from(grupoSelect.options).some(option =>
            option.value === String(grupoAnterior) && !option.hidden
        )) {
            grupoSelect.value = String(grupoAnterior);
        }

        buscarAsignacion();
    }

    function buscarAsignacion() {
        asignacionInput.value = '';
        limpiarMensaje();

        const docenteId = docenteSelect.value;
        const semestre = semestreSelect.value;
        const materiaId = materiaSelect.value;
        const grupoId = grupoSelect.value;
        const cicloId = cicloSelect.value;

        if (!docenteId || !semestre || !materiaId || !grupoId || !cicloId) {
            return;
        }

        const asignacion = asignaciones.find(function (item) {
            return String(item.docente_id) === String(docenteId)
                && String(item.semestre) === String(semestre)
                && String(item.materia_id) === String(materiaId)
                && String(item.grupo_id) === String(grupoId)
                && String(item.ciclo_escolar_id) === String(cicloId);
        });

        if (!asignacion) {
            mostrarMensaje(
                'No existe una asignación para esta combinación de docente, materia, grupo y ciclo escolar. Revisa el módulo Asignar Materia.',
                true
            );
            return;
        }

        asignacionInput.value = asignacion.id;

        mostrarMensaje(
            'Asignación encontrada: ' + asignacion.docente +
            ' · ' + asignacion.materia +
            ' · Grupo ' + asignacion.grupo +
            ' · Ciclo ' + asignacion.ciclo + '.'
        );
    }

    docenteSelect.addEventListener('change', function () {
        valoresAnteriores.semestre = '';
        valoresAnteriores.materia = '';
        filtrarSemestres();
    });

    semestreSelect.addEventListener('change', function () {
        valoresAnteriores.materia = '';
        filtrarMaterias();
    });

    materiaSelect.addEventListener('change', buscarAsignacion);
    gradoSelect.addEventListener('change', function () {
        valoresAnteriores.grupo = '';
        filtrarGrupos();
    });

    grupoSelect.addEventListener('change', function () {
        valoresAnteriores.grupo = '';
        buscarAsignacion();
    });

    cicloSelect.addEventListener('change', function () {
        valoresAnteriores.grupo = '';
        filtrarGrupos();
    });

    form.addEventListener('submit', function (event) {
        if (!asignacionInput.value) {
            event.preventDefault();

            mostrarMensaje(
                'Selecciona una combinación que tenga una asignación de materia registrada antes de guardar el horario.',
                true
            );

            asignacionInfo.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        }
    });

    // Restaurar las selecciones anteriores si hubo errores de validación.
    docenteSelect.value = valoresAnteriores.docente;
    gradoSelect.value = valoresAnteriores.grado;
    cicloSelect.value = valoresAnteriores.ciclo;

    filtrarGrupos();
    filtrarSemestres();

    if (valoresAnteriores.grupo) {
        grupoSelect.value = valoresAnteriores.grupo;
    }

    buscarAsignacion();
});
</script>

@endsection