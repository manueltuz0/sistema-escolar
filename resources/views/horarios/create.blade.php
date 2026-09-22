<x-app-layout>

    <style>

        .horario-form-container {
            max-width: 760px;
            margin: 0 auto;
            padding: 35px 20px 50px;
        }

        .form-card {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 28px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        }

        .form-header {
            margin-bottom: 24px;
        }

        .form-header h1 {
            margin: 0;
            font-size: 25px;
            font-weight: 700;
            color: #1f2937;
        }

        .form-header p {
            margin: 6px 0 0;
            color: #6b7280;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .form-control {
            width: 100%;
            height: 40px;
            padding: 0 11px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            background: #ffffff;
            color: #374151;
            font-size: 13px;
            box-sizing: border-box;
        }

        .form-control:focus {
            outline: none;
            border-color: #198754;
            box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.12);
        }

        .assignment-message {
            display: none;
            margin: 10px 0 16px;
            padding: 10px 12px;
            border-radius: 5px;
            background: #fef3c7;
            border: 1px solid #fde68a;
            color: #92400e;
            font-size: 12px;
        }

        .assignment-message.show {
            display: block;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
        }

        .btn {
            display: inline-block;
            border: none;
            border-radius: 5px;
            padding: 9px 18px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-success {
            background: #198754;
            color: white;
        }

        .btn-success:hover {
            background: #157347;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .errors-box {
            margin-bottom: 18px;
            padding: 12px 15px;
            border-radius: 6px;
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            font-size: 12px;
        }

        .errors-box ul {
            margin: 0;
            padding-left: 18px;
        }

        @media (max-width: 700px) {

            .form-card {
                padding: 20px;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                text-align: center;
            }

        }

    </style>


    <div class="horario-form-container">

        <div class="form-card">

            {{-- TÍTULO --}}

            <div class="form-header">

                <h1>
                    Registrar Nuevo Horario
                </h1>

                <p>
                    Selecciona el docente, materia, grupo, salón y horario de la clase.
                </p>

            </div>


            {{-- ERRORES --}}

            @if($errors->any())

                <div class="errors-box">

                    <strong>
                        Revisa los siguientes datos:
                    </strong>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form action="{{ route('horarios.store') }}"
                  method="POST"
                  id="horarioForm">

                @csrf


                {{-- ASIGNACIÓN OCULTA --}}

                <input type="hidden"
                       name="asignacion_materia_id"
                       id="asignacion_materia_id"
                       value="{{ old('asignacion_materia_id') }}">


                {{-- DOCENTE --}}

                <div class="form-group">

                    <label for="docente_id">
                        Docente:
                    </label>

                    <select id="docente_id"
                            class="form-control"
                            required>

                        <option value="">
                            Selecciona un docente
                        </option>

                        @foreach($asignaciones->unique('docente_id') as $asignacion)

                            @if($asignacion->docente)

                                <option value="{{ $asignacion->docente_id }}"
                                    {{ old('docente_id') == $asignacion->docente_id ? 'selected' : '' }}>

                                    {{ $asignacion->docente->nombres }}
                                    {{ $asignacion->docente->apellidos }}

                                </option>

                            @endif

                        @endforeach

                    </select>

                </div>


                {{-- MATERIA --}}

                <div class="form-group">

                    <label for="materia_id">
                        Materia:
                    </label>

                    <select id="materia_id"
                            class="form-control"
                            required>

                        <option value="">
                            Selecciona una materia
                        </option>

                        @foreach($asignaciones->unique('materia_id') as $asignacion)

                            @if($asignacion->materia)

                                <option value="{{ $asignacion->materia_id }}"
                                    {{ old('materia_id') == $asignacion->materia_id ? 'selected' : '' }}>

                                    {{ $asignacion->materia->nombre }}

                                </option>

                            @endif

                        @endforeach

                    </select>

                </div>


                {{-- GRUPO --}}

                <div class="form-group">

                    <label for="grupo_id">
                        Grupo:
                    </label>

                    <select id="grupo_id"
                            class="form-control"
                            required>

                        <option value="">
                            Selecciona un grupo
                        </option>

                        @foreach($asignaciones->unique('grupo_id') as $asignacion)

                            @if($asignacion->grupo)

                                <option value="{{ $asignacion->grupo_id }}"
                                    {{ old('grupo_id') == $asignacion->grupo_id ? 'selected' : '' }}>

                                    {{ $asignacion->grupo->grado }}°
                                    {{ $asignacion->grupo->nombre }}

                                </option>

                            @endif

                        @endforeach

                    </select>

                </div>


                {{-- MENSAJE DE ASIGNACIÓN --}}

                <div id="assignmentMessage"
                     class="assignment-message">

                    Selecciona una combinación válida de docente, materia y grupo.

                </div>


                {{-- SALÓN --}}

                <div class="form-group">

                    <label for="aula_id">
                        Salón:
                    </label>

                    <select name="aula_id"
                            id="aula_id"
                            class="form-control"
                            required>

                        <option value="">
                            Selecciona un salón
                        </option>

                        @foreach($aulas as $aula)

                            <option value="{{ $aula->id }}"
                                {{ old('aula_id') == $aula->id ? 'selected' : '' }}>

                                {{ $aula->nombre }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- DÍA --}}

                <div class="form-group">

                    <label for="dia">
                        Día:
                    </label>

                    <select name="dia"
                            id="dia"
                            class="form-control"
                            required>

                        <option value="">
                            Selecciona un día
                        </option>

                        @foreach([
                            'Lunes',
                            'Martes',
                            'Miércoles',
                            'Jueves',
                            'Viernes'
                        ] as $dia)

                            <option value="{{ $dia }}"
                                {{ old('dia') === $dia ? 'selected' : '' }}>

                                {{ $dia }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- HORA DE INICIO --}}

                <div class="form-group">

                    <label for="hora_inicio">
                        Hora de inicio (24 horas):
                    </label>

                    <input type="time"
                           name="hora_inicio"
                           id="hora_inicio"
                           class="form-control"
                           value="{{ old('hora_inicio') }}"
                           required>

                </div>


                {{-- HORA DE FIN --}}

                <div class="form-group">

                    <label for="hora_fin">
                        Hora de fin (24 horas):
                    </label>

                    <input type="time"
                           name="hora_fin"
                           id="hora_fin"
                           class="form-control"
                           value="{{ old('hora_fin') }}"
                           required>

                </div>


                {{-- BOTONES --}}

                <div class="form-actions">

                    <button type="submit"
                            class="btn btn-success">

                        Guardar Horario

                    </button>


                    <a href="{{ route('horarios.index') }}"
                       class="btn btn-secondary">

                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>


    {{-- JAVASCRIPT PARA ENCONTRAR LA ASIGNACIÓN --}}

   {{-- JAVASCRIPT PARA ENCONTRAR LA ASIGNACIÓN --}}

@php

    $asignacionesJson = $asignaciones->map(function ($asignacion) {

        return [
            'id' => $asignacion->id,
            'docente_id' => $asignacion->docente_id,
            'materia_id' => $asignacion->materia_id,
            'grupo_id' => $asignacion->grupo_id,
        ];

    })->values()->toJson();

@endphp


<script>

    document.addEventListener('DOMContentLoaded', function () {

        const docenteSelect =
            document.getElementById('docente_id');

        const materiaSelect =
            document.getElementById('materia_id');

        const grupoSelect =
            document.getElementById('grupo_id');

        const assignmentInput =
            document.getElementById('asignacion_materia_id');

        const message =
            document.getElementById('assignmentMessage');

        const form =
            document.getElementById('horarioForm');


        const asignaciones =
            {!! $asignacionesJson !!};


        function actualizarAsignacion() {

            const docenteId =
                docenteSelect.value;

            const materiaId =
                materiaSelect.value;

            const grupoId =
                grupoSelect.value;


            const asignacion =
                asignaciones.find(function (item) {

                    return String(item.docente_id) === String(docenteId)
                        && String(item.materia_id) === String(materiaId)
                        && String(item.grupo_id) === String(grupoId);

                });


            if (asignacion) {

                assignmentInput.value =
                    asignacion.id;

                message.classList.remove('show');

            } else {

                assignmentInput.value = '';


                if (
                    docenteId ||
                    materiaId ||
                    grupoId
                ) {

                    message.textContent =
                        'La combinación de docente, materia y grupo no tiene una asignación registrada.';

                    message.classList.add('show');

                } else {

                    message.classList.remove('show');

                }

            }

        }


        docenteSelect.addEventListener(
            'change',
            actualizarAsignacion
        );


        materiaSelect.addEventListener(
            'change',
            actualizarAsignacion
        );


        grupoSelect.addEventListener(
            'change',
            actualizarAsignacion
        );


        form.addEventListener(
            'submit',
            function (event) {

                actualizarAsignacion();


                if (!assignmentInput.value) {

                    event.preventDefault();

                    message.textContent =
                        'La combinación de docente, materia y grupo no tiene una asignación registrada. Primero registra esa asignación en Horarios y Asignación de Materias.';

                    message.classList.add('show');

                }

            }
        );


        actualizarAsignacion();

    });

</script>
</x-app-layout>