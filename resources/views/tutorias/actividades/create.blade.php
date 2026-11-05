@extends('layouts.app')

@section('content')
<style>
    .tutoria-container {
        max-width: 1100px;
        margin: 25px auto;
        padding: 0 15px;
        color: #4b2633;
    }

    .tutoria-card {
        background: #fff;
        border: 1px solid #eadde2;
        border-radius: 13px;
        margin-bottom: 22px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(70, 20, 40, .06);
    }

    .tutoria-card-header {
        background: #f8edf1;
        padding: 16px 20px;
        font-weight: 700;
        color: #7b1e3a;
        border-bottom: 1px solid #eadde2;
    }

    .tutoria-card-body {
        padding: 22px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .form-group {
        margin-bottom: 5px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 7px;
        color: #603443;
    }

    .form-control {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #cfc4c9;
        border-radius: 7px;
        background: #fff;
        color: #4b2633;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #7b1e3a;
        box-shadow: 0 0 0 3px rgba(123, 30, 58, .10);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 90px;
    }

    .required {
        color: #b42318;
    }

    .participants-info {
        background: #f8edf1;
        border-radius: 8px;
        padding: 13px;
        margin-bottom: 15px;
    }

    .participants-list {
        border: 1px solid #eadde2;
        border-radius: 8px;
        max-height: 380px;
        overflow-y: auto;
        margin-top: 12px;
    }

    .participant {
        display: grid;
        grid-template-columns: 30px minmax(150px, 1fr) 130px minmax(150px, 1fr);
        align-items: center;
        gap: 10px;
        padding: 12px;
        border-bottom: 1px solid #eee5e9;
    }

    .participant:last-child {
        border-bottom: none;
    }

    .participant:hover {
        background: #fcf7f9;
    }

    .participant input[type="checkbox"] {
        width: 17px;
        height: 17px;
        accent-color: #7b1e3a;
    }

    .student-name {
        font-weight: 600;
    }

    .student-matricula {
        display: block;
        font-size: 12px;
        color: #777;
        margin-top: 3px;
    }

    .participant select,
    .participant input[type="text"] {
        width: 100%;
        padding: 8px;
        border: 1px solid #d8cbd0;
        border-radius: 6px;
        box-sizing: border-box;
    }

    .participant.hidden-by-filter {
        display: none;
    }

    .btn-primary-custom {
        background: #7b1e3a;
        color: white;
        border: none;
        border-radius: 7px;
        padding: 12px 22px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-primary-custom:hover {
        background: #5d142b;
    }

    .btn-secondary-custom {
        display: inline-block;
        text-decoration: none;
        background: #eee7ea;
        color: #603443;
        border-radius: 7px;
        padding: 12px 20px;
        font-weight: 600;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-bottom: 30px;
    }

    .error-message {
        color: #b42318;
        font-size: 13px;
        margin-top: 5px;
    }

    .empty-students {
        padding: 20px;
        text-align: center;
        color: #777;
    }

    @media(max-width: 750px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group.full {
            grid-column: auto;
        }

        .participant {
            grid-template-columns: 25px 1fr;
        }

        .participant select,
        .participant input[type="text"] {
            grid-column: 2;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions button,
        .form-actions a {
            text-align: center;
        }
    }
</style>

<div class="tutoria-container">

    <h2 style="color:#7b1e3a; margin-bottom:20px;">
        Registrar actividad grupal
    </h2>

    <form action="{{ route('tutorias.actividades.store') }}" method="POST">
        @csrf

        {{-- INFORMACIÓN GENERAL --}}
        <div class="tutoria-card">

            <div class="tutoria-card-header">
                Información general de la actividad
            </div>

            <div class="tutoria-card-body">

                <div class="form-grid">

                    <div class="form-group">
                        <label>
                            Docente responsable <span class="required">*</span>
                        </label>

                        <select name="docente_id" class="form-control" required>
                            <option value="">Seleccionar docente</option>

                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id }}"
                                    {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->nombres }} {{ $docente->apellidos }}
                                </option>
                            @endforeach
                        </select>

                        @error('docente_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- GRUPO --}}
                    <div class="form-group">
                        <label>
                            Grupo <span class="required">*</span>
                        </label>

                        <select name="grupo_id" id="grupo_id" class="form-control" required>
                            <option value="">Seleccionar grupo</option>

                            @foreach($grupos as $grupo)
                                <option
                                    value="{{ $grupo->id }}"
                                    data-ciclo="{{ $grupo->ciclo_escolar_id }}"
                                    {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}
                                >
                                    {{ $grupo->grado }}.{{ $grupo->nombre }}
                                    — {{ $grupo->cicloEscolar?->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('grupo_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CICLO ESCOLAR --}}
                    <div class="form-group">
                        <label>
                            Ciclo escolar <span class="required">*</span>
                        </label>

                        <select name="ciclo_escolar_id" id="ciclo_escolar_id"
                                class="form-control" required>

                            <option value="">Seleccionar ciclo escolar</option>

                            @foreach($ciclos as $ciclo)
                                <option
                                    value="{{ $ciclo->id }}"
                                    {{ old('ciclo_escolar_id') == $ciclo->id ? 'selected' : '' }}
                                >
                                    {{ $ciclo->nombre }}
                                </option>
                            @endforeach
                        </select>

                        @error('ciclo_escolar_id')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- FECHA --}}
                    <div class="form-group">
                        <label>
                            Fecha de actividad <span class="required">*</span>
                        </label>

                        <input
                            type="date"
                            name="fecha"
                            class="form-control"
                            value="{{ old('fecha', date('Y-m-d')) }}"
                            required
                        >

                        @error('fecha')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- TEMA --}}
                    <div class="form-group">
                        <label>
                            Tema de la actividad <span class="required">*</span>
                        </label>

                        <select name="tema" class="form-control" required>
                            <option value="">Seleccionar tema</option>

                            @php
                                $temas = [
                                    'Prevención de adicciones',
                                    'Bienestar emocional',
                                    'Manejo del estrés',
                                    'Convivencia escolar',
                                    'Prevención del acoso escolar',
                                    'Orientación vocacional',
                                    'Responsabilidad académica',
                                    'Proyecto de vida',
                                    'Sexualidad responsable',
                                    'Valores y toma de decisiones',
                                    'Otro',
                                ];
                            @endphp

                            @foreach($temas as $tema)
                                <option value="{{ $tema }}"
                                    {{ old('tema') == $tema ? 'selected' : '' }}>
                                    {{ $tema }}
                                </option>
                            @endforeach
                        </select>

                        @error('tema')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- TIPO --}}
                    <div class="form-group">
                        <label>
                            Tipo de actividad <span class="required">*</span>
                        </label>

                        <select name="tipo" class="form-control" required>
                            <option value="">Seleccionar tipo</option>

                            @foreach([
                                'Plática',
                                'Taller',
                                'Dinámica grupal',
                                'Conferencia',
                                'Orientación',
                                'Otra'
                            ] as $tipo)
                                <option value="{{ $tipo }}"
                                    {{ old('tipo') == $tipo ? 'selected' : '' }}>
                                    {{ $tipo }}
                                </option>
                            @endforeach
                        </select>

                        @error('tipo')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- DESCRIPCIÓN --}}
                    <div class="form-group full">
                        <label>Descripción de la actividad</label>

                        <textarea
                            name="descripcion"
                            class="form-control"
                            placeholder="Describe qué se realizó durante la actividad..."
                        >{{ old('descripcion') }}</textarea>

                        @error('descripcion')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- OBSERVACIONES --}}
                    <div class="form-group full">
                        <label>Observaciones generales</label>

                        <textarea
                            name="observaciones"
                            class="form-control"
                            placeholder="Escribe observaciones generales de la actividad..."
                        >{{ old('observaciones') }}</textarea>

                        @error('observaciones')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        {{-- PARTICIPANTES --}}
        <div class="tutoria-card">

            <div class="tutoria-card-header">
                Participantes de la actividad
            </div>

            <div class="tutoria-card-body">

                <div class="participants-info">
                    <strong>Alumnos del grupo</strong>
                    <p style="margin:5px 0 0; font-size:13px;">
                        Selecciona el grupo para mostrar sus alumnos.
                        Marca a los participantes y registra su asistencia.
                    </p>
                </div>

                <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:12px;">

                    <input
                        type="text"
                        id="buscarAlumno"
                        class="form-control"
                        style="max-width:300px;"
                        placeholder="Buscar alumno por nombre o matrícula..."
                    >

                    <button type="button" id="seleccionarTodos"
                            class="btn-secondary-custom">
                        Seleccionar todos
                    </button>

                    <button type="button" id="quitarSeleccion"
                            class="btn-secondary-custom">
                        Quitar selección
                    </button>

                </div>

                <div id="contadorAlumnos" style="margin-bottom:10px; font-size:13px;">
                    Selecciona un grupo para mostrar sus alumnos.
                </div>

                <div class="participants-list" id="listaAlumnos">

                    @foreach($grupos as $grupo)
                        @foreach($grupo->alumnos as $alumno)

                            <div
                                class="participant"
                                data-grupo="{{ $grupo->id }}"
                                data-texto="{{ strtolower($alumno->nombres . ' ' . $alumno->apellidos . ' ' . $alumno->matricula) }}"
                            >

                                <input
                                    type="checkbox"
                                    class="check-alumno"
                                    name="alumnos[{{ $alumno->id }}][id]"
                                    value="{{ $alumno->id }}"
                                    {{ old('alumnos.' . $alumno->id . '.id') ? 'checked' : '' }}
                                >

                                <div>
                                    <span class="student-name">
                                        {{ $alumno->apellidos }}, {{ $alumno->nombres }}
                                    </span>

                                    <span class="student-matricula">
                                        Matrícula: {{ $alumno->matricula }}
                                    </span>
                                </div>

                                <select name="alumnos[{{ $alumno->id }}][asistencia]">
                                    @foreach(['Presente', 'Ausente', 'Justificado'] as $asistencia)
                                        <option value="{{ $asistencia }}"
                                            {{ old('alumnos.' . $alumno->id . '.asistencia', 'Presente') == $asistencia ? 'selected' : '' }}>
                                            {{ $asistencia }}
                                        </option>
                                    @endforeach
                                </select>

                                <input
                                    type="text"
                                    name="alumnos[{{ $alumno->id }}][observaciones]"
                                    placeholder="Observación individual"
                                    value="{{ old('alumnos.' . $alumno->id . '.observaciones') }}"
                                >

                            </div>

                        @endforeach
                    @endforeach

                </div>

                @error('alumnos')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                @error('alumnos.*.id')
                    <div class="error-message">{{ $message }}</div>
                @enderror

            </div>
        </div>

        {{-- BOTONES --}}
        <div class="form-actions">

            <a href="{{ route('tutorias.actividades.index') }}"
               class="btn-secondary-custom">
                Cancelar
            </a>

            <button type="submit" class="btn-primary-custom">
                Guardar actividad
            </button>

        </div>

    </form>
</div>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const grupoSelect = document.getElementById('grupo_id');
    const cicloSelect = document.getElementById('ciclo_escolar_id');
    const alumnos = document.querySelectorAll('.participant');
    const buscar = document.getElementById('buscarAlumno');
    const contador = document.getElementById('contadorAlumnos');

    // Habilitar campos únicamente cuando el alumno está seleccionado.
    function sincronizarAlumno(alumno) {
        const checkbox = alumno.querySelector('.check-alumno');
        const campos = alumno.querySelectorAll('select, input[type="text"]');

        campos.forEach(function (campo) {
            campo.disabled = !checkbox.checked;
        });
    }

    function filtrarAlumnos() {

        const grupoSeleccionado = grupoSelect.value;
        const texto = buscar.value.toLowerCase().trim();

        let visibles = 0;
        let seleccionados = 0;

        alumnos.forEach(function (alumno) {

            const perteneceGrupo =
                grupoSeleccionado !== '' &&
                alumno.dataset.grupo === grupoSeleccionado;

            const coincideBusqueda =
                alumno.dataset.texto.includes(texto);

            const mostrar = perteneceGrupo && coincideBusqueda;

            alumno.classList.toggle('hidden-by-filter', !mostrar);

            if (mostrar) {
                visibles++;

                if (alumno.querySelector('.check-alumno').checked) {
                    seleccionados++;
                }
            }

            sincronizarAlumno(alumno);
        });

        if (grupoSeleccionado === '') {
            contador.textContent =
                'Selecciona un grupo para mostrar sus alumnos.';
        } else {
            contador.textContent =
                'Alumnos encontrados: ' + visibles +
                ' | Seleccionados: ' + seleccionados;
        }
    }

    grupoSelect.addEventListener('change', function () {

        const opcion = grupoSelect.options[grupoSelect.selectedIndex];
        const cicloId = opcion.dataset.ciclo;

        if (cicloId) {
            cicloSelect.value = cicloId;
        }

        buscar.value = '';
        filtrarAlumnos();
    });

    buscar.addEventListener('input', filtrarAlumnos);

    document.getElementById('seleccionarTodos').addEventListener('click', function () {

        alumnos.forEach(function (alumno) {

            if (!alumno.classList.contains('hidden-by-filter')) {
                alumno.querySelector('.check-alumno').checked = true;
            }

        });

        filtrarAlumnos();
    });

    document.getElementById('quitarSeleccion').addEventListener('click', function () {

        alumnos.forEach(function (alumno) {

            if (!alumno.classList.contains('hidden-by-filter')) {
                alumno.querySelector('.check-alumno').checked = false;
            }

        });

        filtrarAlumnos();
    });

    document.querySelectorAll('.check-alumno').forEach(function (checkbox) {
        checkbox.addEventListener('change', filtrarAlumnos);
    });

    // Recuperar el grupo seleccionado después de una validación.
    if (grupoSelect.value) {

        const opcion = grupoSelect.options[grupoSelect.selectedIndex];

        if (opcion.dataset.ciclo) {
            cicloSelect.value = opcion.dataset.ciclo;
        }
    }

       // Aplicar estado inicial de los campos.
    filtrarAlumnos();

});
</script>

@endsection
