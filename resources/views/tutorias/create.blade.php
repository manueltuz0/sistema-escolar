@extends('layouts.app')

@section('content')

<style>
    .tutoria-container {
        max-width: 1100px;
        margin: 30px auto;
        padding: 0 20px;
    }

    .tutoria-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .tutoria-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
    }

    .btn-regresar {
        text-decoration: none;
        background: #6b7280;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-regresar:hover {
        background: #4b5563;
    }

    .card {
        background: white;
        border-radius: 14px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,.08);
    }

    .card h2 {
        margin-top: 0;
        color: #1f2937;
        font-size: 20px;
    }

    .card-subtitle {
        color: #6b7280;
        margin-bottom: 20px;
    }

    .incidencia-card {
        background: #f8fafc;
        border-left: 5px solid #f59e0b;
        border-radius: 10px;
        padding: 20px;
    }

    .incidencia-titulo {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .incidencia-titulo h3 {
        margin: 0;
        color: #111827;
    }

    .estado {
        background: #fef3c7;
        color: #92400e;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .datos-incidencia {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .dato {
        background: white;
        padding: 12px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .dato strong {
        display: block;
        color: #6b7280;
        font-size: 12px;
        margin-bottom: 5px;
        text-transform: uppercase;
    }

    .dato span {
        color: #111827;
        font-weight: 600;
    }

    .descripcion {
        grid-column: 1 / -1;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    label {
        margin-bottom: 7px;
        font-weight: 600;
        color: #374151;
    }

    input,
    select,
    textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 14px;
        background: white;
    }

    textarea {
        min-height: 100px;
        resize: vertical;
    }

    input:focus,
    select:focus,
    textarea:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37,99,235,.12);
    }

    .acciones {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
    }

    .btn-cancelar {
        text-decoration: none;
        background: #e5e7eb;
        color: #374151;
        padding: 11px 20px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-guardar {
        border: none;
        background: #2563eb;
        color: white;
        padding: 11px 22px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-guardar:hover {
        background: #1d4ed8;
    }

    .alerta {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 5px;
    }

    .sin-incidencia {
        background: #f3f4f6;
        padding: 18px;
        border-radius: 10px;
        color: #6b7280;
    }

    @media (max-width: 768px) {

        .form-grid,
        .datos-incidencia {
            grid-template-columns: 1fr;
        }

        .descripcion {
            grid-column: auto;
        }

        .tutoria-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
    }
</style>


<div class="tutoria-container">

    {{-- ENCABEZADO --}}
    <div class="tutoria-header">

        <div>
            <h1>Registrar tutoría</h1>

            <p style="color:#6b7280; margin-top:6px;">
                Seguimiento y atención del alumno
            </p>
        </div>

        <a href="{{ route('tutorias.index') }}" class="btn-regresar">
            ← Regresar
        </a>

    </div>


    {{-- MENSAJE --}}
    @if(session('success'))

        <div class="alerta">
            {{ session('success') }}
        </div>

    @endif


    {{-- ERRORES --}}
    @if($errors->any())

        <div style="
            background:#fef2f2;
            border:1px solid #fecaca;
            color:#991b1b;
            padding:15px;
            border-radius:8px;
            margin-bottom:20px;
        ">

            <strong>Hay algunos errores:</strong>

            <ul style="margin-bottom:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- INCIDENCIA RELACIONADA --}}
    {{-- ========================================================= --}}

    <div class="card">

        <h2>Incidencia que origina esta tutoría</h2>

        <p class="card-subtitle">
            Esta sección muestra los antecedentes registrados en la incidencia.
        </p>


        @if($incidenciaSeleccionada)

            <div class="incidencia-card">

                <div class="incidencia-titulo">

                    <h3>
                        Incidencia #{{ $incidenciaSeleccionada->id }}
                    </h3>

                    <span class="estado">
                        {{ $incidenciaSeleccionada->estado }}
                    </span>

                </div>


                <div class="datos-incidencia">

                    <div class="dato">

                        <strong>Alumno</strong>

                        <span>
                            {{ $incidenciaSeleccionada->alumno->nombres }}
                            {{ $incidenciaSeleccionada->alumno->apellidos }}
                        </span>

                    </div>


                    <div class="dato">

                        <strong>Matrícula</strong>

                        <span>
                            {{ $incidenciaSeleccionada->alumno->matricula }}
                        </span>

                    </div>


                    <div class="dato">

                        <strong>Grupo</strong>

                        <span>
                            {{ $incidenciaSeleccionada->alumno->grupo->nombre ?? 'Sin grupo' }}
                        </span>

                    </div>


                    <div class="dato">

                        <strong>Fecha</strong>

                        <span>
                            {{ \Carbon\Carbon::parse($incidenciaSeleccionada->fecha)->format('d/m/Y') }}
                        </span>

                    </div>


                    <div class="dato">

                        <strong>Tipo</strong>

                        <span>
                            {{ $incidenciaSeleccionada->tipo }}
                        </span>

                    </div>


                    @if($incidenciaSeleccionada->lugar)

                        <div class="dato">

                            <strong>Lugar</strong>

                            <span>
                                {{ $incidenciaSeleccionada->lugar }}
                            </span>

                        </div>

                    @endif


                    <div class="dato descripcion">

                        <strong>Descripción de la incidencia</strong>

                        <span>
                            {{ $incidenciaSeleccionada->descripcion }}
                        </span>

                    </div>


                    @if($incidenciaSeleccionada->acciones_realizadas)

                        <div class="dato descripcion">

                            <strong>Acciones realizadas anteriormente</strong>

                            <span>
                                {{ $incidenciaSeleccionada->acciones_realizadas }}
                            </span>

                        </div>

                    @endif


                    @if($incidenciaSeleccionada->observaciones)

                        <div class="dato descripcion">

                            <strong>Observaciones</strong>

                            <span>
                                {{ $incidenciaSeleccionada->observaciones }}
                            </span>

                        </div>

                    @endif

                </div>

            </div>


        @else

            <div class="sin-incidencia">

                No se seleccionó una incidencia.

                Puedes registrar una tutoría independiente,
                pero lo recomendable para el seguimiento es
                entrar desde una incidencia existente.

            </div>

        @endif

    </div>


    {{-- ========================================================= --}}
    {{-- FORMULARIO DE TUTORÍA --}}
    {{-- ========================================================= --}}

    <form action="{{ route('tutorias.store') }}" method="POST">

        @csrf


        <div class="card">

            <h2>Información de la tutoría</h2>

            <p class="card-subtitle">
                Registra aquí la atención, acuerdos y seguimiento realizado.
            </p>


            <div class="form-grid">


                {{-- ALUMNO --}}
                <div class="form-group">

                    <label for="alumno_id">
                        Alumno *
                    </label>

                    <select
                        name="alumno_id"
                        id="alumno_id"
                        required
                    >

                        <option value="">
                            Seleccionar alumno
                        </option>

                        @foreach($alumnos as $alumno)

                            <option
                                value="{{ $alumno->id }}"
                                {{ old(
                                    'alumno_id',
                                    $incidenciaSeleccionada->alumno_id ?? ''
                                ) == $alumno->id ? 'selected' : '' }}
                            >

                                {{ $alumno->apellidos }},
                                {{ $alumno->nombres }}

                                @if($alumno->grupo)
                                    - {{ $alumno->grupo->nombre }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                    @error('alumno_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- FECHA --}}
                <div class="form-group">

                    <label for="fecha">
                        Fecha de tutoría *
                    </label>

                    <input
                        type="date"
                        name="fecha"
                        id="fecha"
                        value="{{ old('fecha', date('Y-m-d')) }}"
                        required
                    >

                    @error('fecha')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- INCIDENCIA --}}
                <div class="form-group full">

                    <label for="incidencia_id">
                        Incidencia relacionada
                    </label>

                    <select
                        name="incidencia_id"
                        id="incidencia_id"
                    >

                        <option value="">
                            Sin incidencia relacionada
                        </option>

                        @foreach($incidencias as $incidencia)

                            <option
                                value="{{ $incidencia->id }}"
                                {{ old(
                                    'incidencia_id',
                                    $incidenciaSeleccionada->id ?? ''
                                ) == $incidencia->id ? 'selected' : '' }}
                            >

                                #{{ $incidencia->id }}
                                -
                                {{ $incidencia->alumno->nombres }}
                                {{ $incidencia->alumno->apellidos }}
                                -
                                {{ $incidencia->tipo }}
                                -
                                {{ \Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y') }}

                            </option>

                        @endforeach

                    </select>

                    @error('incidencia_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- TIPO --}}
                <div class="form-group">

                    <label for="tipo">
                        Tipo de tutoría *
                    </label>

                    <select
                        name="tipo"
                        id="tipo"
                        required
                    >

                        <option value="">
                            Seleccionar
                        </option>

                        <option
                            value="Individual"
                            {{ old('tipo') == 'Individual' ? 'selected' : '' }}
                        >
                            Individual
                        </option>

                        <option
                            value="Seguimiento"
                            {{ old('tipo') == 'Seguimiento' ? 'selected' : '' }}
                        >
                            Seguimiento
                        </option>

                        <option
                            value="Conductual"
                            {{ old('tipo') == 'Conductual' ? 'selected' : '' }}
                        >
                            Conductual
                        </option>

                        <option
                            value="Académica"
                            {{ old('tipo') == 'Académica' ? 'selected' : '' }}
                        >
                            Académica
                        </option>

                        <option
                            value="Orientación"
                            {{ old('tipo') == 'Orientación' ? 'selected' : '' }}
                        >
                            Orientación
                        </option>

                        <option
                            value="Familiar"
                            {{ old('tipo') == 'Familiar' ? 'selected' : '' }}
                        >
                            Familiar
                        </option>

                    </select>

                    @error('tipo')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- MOTIVO --}}
                <div class="form-group">

                    <label for="motivo">
                        Motivo de la tutoría *
                    </label>

                    <input
                        type="text"
                        name="motivo"
                        id="motivo"
                        value="{{ old('motivo') }}"
                        placeholder="¿Por qué se realiza la tutoría?"
                        required
                    >

                    @error('motivo')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- SITUACIÓN --}}
                <div class="form-group full">

                    <label for="situacion">
                        Situación encontrada
                    </label>

                    <textarea
                        name="situacion"
                        id="situacion"
                        placeholder="Describe la situación encontrada durante la tutoría..."
                    >{{ old('situacion') }}</textarea>

                    @error('situacion')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- ACUERDOS --}}
                <div class="form-group full">

                    <label for="acuerdos">
                        Acuerdos establecidos
                    </label>

                    <textarea
                        name="acuerdos"
                        id="acuerdos"
                        placeholder="Escribe los acuerdos establecidos..."
                    >{{ old('acuerdos') }}</textarea>

                    @error('acuerdos')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- COMPROMISO ALUMNO --}}
                <div class="form-group">

                    <label for="compromisos_alumno">
                        Compromisos del alumno
                    </label>

                    <textarea
                        name="compromisos_alumno"
                        id="compromisos_alumno"
                        placeholder="Compromisos que asumirá el alumno..."
                    >{{ old('compromisos_alumno') }}</textarea>

                    @error('compromisos_alumno')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- COMPROMISO TUTOR --}}
                <div class="form-group">

                    <label for="compromisos_tutor">
                        Compromisos del tutor
                    </label>

                    <textarea
                        name="compromisos_tutor"
                        id="compromisos_tutor"
                        placeholder="Compromisos que asumirá el tutor..."
                    >{{ old('compromisos_tutor') }}</textarea>

                    @error('compromisos_tutor')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- FECHA SEGUIMIENTO --}}
                <div class="form-group">

                    <label for="fecha_seguimiento">
                        Próxima fecha de seguimiento
                    </label>

                    <input
                        type="date"
                        name="fecha_seguimiento"
                        id="fecha_seguimiento"
                        value="{{ old('fecha_seguimiento') }}"
                    >

                    @error('fecha_seguimiento')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- ESTADO --}}
                <div class="form-group">

                    <label for="estado">
                        Estado de la tutoría *
                    </label>

                    <select
                        name="estado"
                        id="estado"
                        required
                    >

                        <option
                            value="Pendiente"
                            {{ old('estado', 'Pendiente') == 'Pendiente' ? 'selected' : '' }}
                        >
                            Pendiente
                        </option>

                        <option
                            value="En seguimiento"
                            {{ old('estado') == 'En seguimiento' ? 'selected' : '' }}
                        >
                            En seguimiento
                        </option>

                        <option
                            value="Concluida"
                            {{ old('estado') == 'Concluida' ? 'selected' : '' }}
                        >
                            Concluida
                        </option>

                    </select>

                    @error('estado')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>


                {{-- OBSERVACIONES --}}
                <div class="form-group full">

                    <label for="observaciones">
                        Observaciones
                    </label>

                    <textarea
                        name="observaciones"
                        id="observaciones"
                        placeholder="Observaciones adicionales..."
                    >{{ old('observaciones') }}</textarea>

                    @error('observaciones')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>

            </div>


            {{-- BOTONES --}}
            <div class="acciones">

                <a
                    href="{{ route('tutorias.index') }}"
                    class="btn-cancelar"
                >
                    Cancelar
                </a>

                <button
                    type="submit"
                    class="btn-guardar"
                >
                    Guardar tutoría
                </button>

            </div>

        </div>

    </form>

</div>

@endsection