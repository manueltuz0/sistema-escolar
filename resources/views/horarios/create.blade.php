@extends('layouts.app')

@section('content')

<style>
    .horario-container {
        max-width: 850px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .horario-card {
        background: #ffffff;
        border-radius: 10px;
        padding: 32px 36px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .horario-title {
        font-size: 30px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }

    .horario-description {
        color: #6b7280;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }

    .form-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 15px;
        background: #fff;
        box-sizing: border-box;
    }

    .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.12);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .buttons {
        display: flex;
        gap: 12px;
        margin-top: 28px;
    }

    .btn {
        border: none;
        border-radius: 6px;
        padding: 11px 20px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
    }

    .btn-success {
        background: #198754;
        color: white;
    }

    .btn-success:hover {
        background: #157347;
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5c636a;
    }

    .error-box {
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 12px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }

    .info-box {
        display: none;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        padding: 10px 14px;
        border-radius: 6px;
        margin-top: 8px;
        font-size: 14px;
    }

    @media (max-width: 700px) {
        .horario-card {
            padding: 25px 20px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>

<div class="horario-container">

    <div class="horario-card">

        <div class="horario-title">
            Registrar Nuevo Horario
        </div>

        <div class="horario-description">
            Selecciona el docente, materia, grupo y horario de la clase.
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="error-box">
                <strong>Hay algunos errores:</strong>

                <ul style="margin: 8px 0 0 18px;">
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

            {{-- ID de la asignación. El usuario no lo verá --}}
            <input
                type="hidden"
                name="asignacion_materia_id"
                id="asignacion_materia_id"
                value=""
            >

            {{-- DOCENTE --}}
            <div class="form-group">

                <label for="docente_id">
                    Docente:
                </label>

                <select
                    id="docente_id"
                    name="docente_id"
                    class="form-control"
                    required
                >
                    <option value="">
                        Selecciona un docente
                    </option>

                    @foreach ($docentes as $docente)
                        <option value="{{ $docente->id }}">
                            {{ $docente->nombres }} {{ $docente->apellidos }}
                        </option>
                    @endforeach

                </select>

            </div>


            {{-- MATERIA --}}
            <div class="form-group">

                <label for="materia_id">
                    Materia:
                </label>

                <select
                    id="materia_id"
                    name="materia_id"
                    class="form-control"
                    required
                >
                    <option value="">
                        Selecciona una materia
                    </option>

                    @foreach ($materias as $materia)
                        <option value="{{ $materia->id }}">
                            {{ $materia->nombre }}
                        </option>
                    @endforeach

                </select>

            </div>


            {{-- GRADO --}}
            <div class="form-group">

                <label for="grado">
                    Grado:
                </label>

                <select
                    id="grado"
                    name="grado"
                    class="form-control"
                    required
                >
                    <option value="">
                        Selecciona un grado
                    </option>

                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}">
                            {{ $i }}°
                        </option>
                    @endfor

                </select>

            </div>


            {{-- GRUPO --}}
            <div class="form-group">

                <label for="grupo_id">
                    Grupo:
                </label>

                <select
                    id="grupo_id"
                    name="grupo_id"
                    class="form-control"
                    required
                    disabled
                >
                    <option value="">
                        Selecciona primero un grado
                    </option>

                    @foreach ($grupos as $grupo)
                        <option
                            value="{{ $grupo->id }}"
                            data-grado="{{ $grupo->grado }}"
                        >
                            {{ $grupo->nombre }}
                        </option>
                    @endforeach

                </select>

            </div>


            {{-- MENSAJE DE ASIGNACIÓN --}}
            <div
                id="asignacionInfo"
                class="info-box"
            >
                Se encontró la asignación correspondiente.
            </div>


            {{-- DÍA --}}
            <div class="form-group">

                <label for="dia">
                    Día:
                </label>

                <select
                    id="dia"
                    name="dia"
                    class="form-control"
                    required
                >
                    <option value="">
                        Selecciona un día
                    </option>

                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miércoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>

                </select>

            </div>


            {{-- HORAS --}}
            <div class="form-row">

                <div class="form-group">

                    <label for="hora_inicio">
                        Hora de inicio:
                    </label>

                    <input
                        type="time"
                        id="hora_inicio"
                        name="hora_inicio"
                        class="form-control"
                        required
                    >

                </div>


                <div class="form-group">

                    <label for="hora_fin">
                        Hora de fin:
                    </label>

                    <input
                        type="time"
                        id="hora_fin"
                        name="hora_fin"
                        class="form-control"
                        required
                    >

                </div>

            </div>


            {{-- BOTONES --}}
            <div class="buttons">

                <button
                    type="submit"
                    class="btn btn-success"
                >
                    Guardar Horario
                </button>

                <a
                    href="{{ route('horarios.index') }}"
                    class="btn btn-secondary"
                >
                    Cancelar
                </a>

            </div>

        </form>

    </div>

</div>


<script>

    const asignaciones = {!! json_encode(
        $asignaciones->map(function ($asignacion) {
            return [
                'id' => $asignacion->id,
                'docente_id' => $asignacion->docente_id,
                'materia_id' => $asignacion->materia_id,
                'grupo_id' => $asignacion->grupo_id,
            ];
        })->values()
    ) !!};


    const docenteSelect = document.getElementById('docente_id');
    const materiaSelect = document.getElementById('materia_id');
    const gradoSelect = document.getElementById('grado');
    const grupoSelect = document.getElementById('grupo_id');

    const asignacionInput =
        document.getElementById('asignacion_materia_id');

    const asignacionInfo =
        document.getElementById('asignacionInfo');

    const form =
        document.getElementById('horarioForm');


    gradoSelect.addEventListener('change', function () {

        const gradoSeleccionado = this.value;

        grupoSelect.value = '';

        if (!gradoSeleccionado) {

            grupoSelect.disabled = true;

            Array.from(grupoSelect.options).forEach(option => {

                if (option.value !== '') {
                    option.hidden = true;
                }

            });

            return;
        }

        grupoSelect.disabled = false;

        Array.from(grupoSelect.options).forEach(option => {

            if (option.value === '') {
                option.hidden = false;
                return;
            }

            const gradoGrupo =
                option.dataset.grado;

            option.hidden =
                gradoGrupo !== gradoSeleccionado;

        });

    });


    function buscarAsignacion() {

        const docenteId = docenteSelect.value;
        const materiaId = materiaSelect.value;
        const grupoId = grupoSelect.value;

        asignacionInput.value = '';
        asignacionInfo.style.display = 'none';

        if (!docenteId || !materiaId || !grupoId) {
            return;
        }

        const asignacion = asignaciones.find(function (item) {

            return (
                String(item.docente_id) === String(docenteId) &&
                String(item.materia_id) === String(materiaId) &&
                String(item.grupo_id) === String(grupoId)
            );

        });


        if (asignacion) {

            asignacionInput.value = asignacion.id;

            asignacionInfo.textContent =
                'La asignación de este docente, materia y grupo está disponible.';

            asignacionInfo.style.display = 'block';

        }

    }


    docenteSelect.addEventListener(
        'change',
        buscarAsignacion
    );

    materiaSelect.addEventListener(
        'change',
        buscarAsignacion
    );

    grupoSelect.addEventListener(
        'change',
        buscarAsignacion
    );


    form.addEventListener('submit', function (event) {

        if (!asignacionInput.value) {

            event.preventDefault();

            alert(
                'No existe una asignación de materia para el docente, materia y grupo seleccionados.'
            );

        }

    });

</script>
@endsection