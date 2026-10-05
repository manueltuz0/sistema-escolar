<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar incidencia</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }

        .contenedor {
            width: 96%;
            max-width: 1200px;
            margin: 30px auto;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .titulo {
            margin: 0;
            font-size: 25px;
            font-weight: 600;
        }

        .subtitulo {
            margin-top: 5px;
            color: #6b7280;
            font-size: 14px;
        }

        .botones {
            display: flex;
            gap: 10px;
        }

        .boton {
            display: inline-block;
            border: none;
            border-radius: 7px;
            padding: 10px 16px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
        }

        .boton-regresar {
            background: #e5e7eb;
            color: #374151;
        }

        .boton-regresar:hover {
            background: #d1d5db;
        }

        .boton-guardar {
            background: #2563eb;
            color: white;
        }

        .boton-guardar:hover {
            background: #1d4ed8;
        }

        .tarjeta {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: 18px;
            overflow: hidden;
        }

        .tarjeta-titulo {
            padding: 15px 20px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 17px;
            font-weight: 600;
        }

        .tarjeta-contenido {
            padding: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px 25px;
        }

        .campo {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .campo-completo {
            grid-column: 1 / -1;
        }

        label {
            font-size: 13px;
            font-weight: 600;
            color: #374151;
        }

        .requerido {
            color: #dc2626;
        }

        input,
        select,
        textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            padding: 11px 13px;
            font-size: 14px;
            font-family: Arial, Helvetica, sans-serif;
            background: white;
            color: #1f2937;
            outline: none;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, .10);
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .alumno-info {
            margin-top: 8px;
            padding: 10px 12px;
            border-radius: 7px;
            background: #eff6ff;
            border: 1px solid #dbeafe;
            color: #1e40af;
            font-size: 13px;
        }

        .error {
            color: #dc2626;
            font-size: 12px;
        }

        .alerta-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
        }

        .acciones-finales {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        @media (max-width: 700px) {

            .encabezado {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .grid {
                grid-template-columns: 1fr;
            }

            .campo-completo {
                grid-column: auto;
            }

            .botones {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    {{-- ENCABEZADO --}}
    <div class="encabezado">

        <div>

            <h1 class="titulo">
                Editar incidencia
            </h1>

            <div class="subtitulo">
                Modifica la información de la incidencia registrada.
            </div>

        </div>

        <div class="botones">

            <a href="{{ route('incidencias.show', $incidencia) }}"
               class="boton boton-regresar">

                ← Regresar

            </a>

        </div>

    </div>


    {{-- ERRORES DE VALIDACIÓN --}}
    @if($errors->any())

        <div class="alerta-error">

            <strong>
                Hay algunos errores en el formulario:
            </strong>

            <ul style="margin-bottom: 0;">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- FORMULARIO --}}
    <form
        action="{{ route('incidencias.update', $incidencia) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        {{-- INFORMACIÓN DEL ALUMNO --}}
        <div class="tarjeta">

            <div class="tarjeta-titulo">
                👤 Información del alumno
            </div>

            <div class="tarjeta-contenido">

                <div class="grid">

                    <div class="campo campo-completo">

                        <label for="alumno_id">

                            Alumno
                            <span class="requerido">*</span>

                        </label>

                        <select
                            name="alumno_id"
                            id="alumno_id"
                            required
                        >

                            <option value="">
                                Selecciona un alumno
                            </option>

                            @foreach($alumnos as $alumno)

                                <option
                                    value="{{ $alumno->id }}"
                                    @selected(
                                        old(
                                            'alumno_id',
                                            $incidencia->alumno_id
                                        ) == $alumno->id
                                    )
                                >

                                    {{ $alumno->apellidos }},
                                    {{ $alumno->nombres }}

                                    — Matrícula:
                                    {{ $alumno->matricula }}

                                    @if($alumno->grupo)

                                        — Grupo:
                                        {{ $alumno->grupo->nombre
                                            ?? $alumno->grupo->grupo
                                            ?? '' }}

                                    @endif

                                </option>

                            @endforeach

                        </select>

                        @error('alumno_id')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- INFORMACIÓN DE LA INCIDENCIA --}}
        <div class="tarjeta">

            <div class="tarjeta-titulo">
                📋 Información de la incidencia
            </div>

            <div class="tarjeta-contenido">

                <div class="grid">


                    {{-- FECHA --}}
                    <div class="campo">

                        <label for="fecha">

                            Fecha
                            <span class="requerido">*</span>

                        </label>

                        <input
                            type="date"
                            name="fecha"
                            id="fecha"
                            value="{{ old('fecha', $incidencia->fecha) }}"
                            required
                        >

                        @error('fecha')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- TIPO --}}
                    <div class="campo">

                        <label for="tipo">

                            Tipo de incidencia
                            <span class="requerido">*</span>

                        </label>

                        <select
                            name="tipo"
                            id="tipo"
                            required
                        >

                            <option value="">
                                Selecciona un tipo
                            </option>

                            <option
                                value="Académica"
                                @selected(
                                    old('tipo', $incidencia->tipo)
                                    === 'Académica'
                                )
                            >
                                Académica
                            </option>

                            <option
                                value="Disciplinaria"
                                @selected(
                                    old('tipo', $incidencia->tipo)
                                    === 'Disciplinaria'
                                )
                            >
                                Disciplinaria
                            </option>

                            <option
                                value="Conductual"
                                @selected(
                                    old('tipo', $incidencia->tipo)
                                    === 'Conductual'
                                )
                            >
                                Conductual
                            </option>

                            <option
                                value="Asistencia"
                                @selected(
                                    old('tipo', $incidencia->tipo)
                                    === 'Asistencia'
                                )
                            >
                                Asistencia
                            </option>

                            <option
                                value="Otra"
                                @selected(
                                    old('tipo', $incidencia->tipo)
                                    === 'Otra'
                                )
                            >
                                Otra
                            </option>

                        </select>

                        @error('tipo')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- PRIORIDAD --}}
                    <div class="campo">

                        <label for="prioridad">

                            Prioridad
                            <span class="requerido">*</span>

                        </label>

                        <select
                            name="prioridad"
                            id="prioridad"
                            required
                        >

                            <option
                                value="Baja"
                                @selected(
                                    old(
                                        'prioridad',
                                        $incidencia->prioridad
                                    ) === 'Baja'
                                )
                            >
                                🟢 Baja
                            </option>

                            <option
                                value="Media"
                                @selected(
                                    old(
                                        'prioridad',
                                        $incidencia->prioridad
                                    ) === 'Media'
                                )
                            >
                                🟡 Media
                            </option>

                            <option
                                value="Alta"
                                @selected(
                                    old(
                                        'prioridad',
                                        $incidencia->prioridad
                                    ) === 'Alta'
                                )
                            >
                                🔴 Alta
                            </option>

                        </select>

                        @error('prioridad')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- ESTADO --}}
                    <div class="campo">

                        <label for="estado">

                            Estado
                            <span class="requerido">*</span>

                        </label>

                        <select
                            name="estado"
                            id="estado"
                            required
                        >

                            <option
                                value="Pendiente"
                                @selected(
                                    old(
                                        'estado',
                                        $incidencia->estado
                                    ) === 'Pendiente'
                                )
                            >
                                Pendiente
                            </option>

                            <option
                                value="En seguimiento"
                                @selected(
                                    old(
                                        'estado',
                                        $incidencia->estado
                                    ) === 'En seguimiento'
                                )
                            >
                                En seguimiento
                            </option>

                            <option
                                value="Atendida"
                                @selected(
                                    old(
                                        'estado',
                                        $incidencia->estado
                                    ) === 'Atendida'
                                )
                            >
                                Atendida
                            </option>

                            <option
                                value="Concluida"
                                @selected(
                                    old(
                                        'estado',
                                        $incidencia->estado
                                    ) === 'Concluida'
                                )
                            >
                                Concluida
                            </option>

                        </select>

                        @error('estado')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- LUGAR --}}
                    <div class="campo campo-completo">

                        <label for="lugar">
                            Lugar
                        </label>

                        <input
                            type="text"
                            name="lugar"
                            id="lugar"
                            maxlength="150"
                            value="{{ old('lugar', $incidencia->lugar) }}"
                            placeholder="Ejemplo: Aula 3, patio, laboratorio..."
                        >

                        @error('lugar')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- DESCRIPCIÓN --}}
                    <div class="campo campo-completo">

                        <label for="descripcion">

                            Descripción de la situación
                            <span class="requerido">*</span>

                        </label>

                        <textarea
                            name="descripcion"
                            id="descripcion"
                            required
                            placeholder="Describe de manera clara lo ocurrido..."
                        >{{ old('descripcion', $incidencia->descripcion) }}</textarea>

                        @error('descripcion')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- ACCIONES REALIZADAS --}}
                    <div class="campo campo-completo">

                        <label for="acciones_realizadas">

                            Acciones realizadas

                        </label>

                        <textarea
                            name="acciones_realizadas"
                            id="acciones_realizadas"
                            placeholder="Describe las acciones realizadas para atender la incidencia..."
                        >{{ old('acciones_realizadas', $incidencia->acciones_realizadas) }}</textarea>

                        @error('acciones_realizadas')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>


                    {{-- OBSERVACIONES --}}
                    <div class="campo campo-completo">

                        <label for="observaciones">

                            Observaciones

                        </label>

                        <textarea
                            name="observaciones"
                            id="observaciones"
                            placeholder="Agrega observaciones adicionales..."
                        >{{ old('observaciones', $incidencia->observaciones) }}</textarea>

                        @error('observaciones')

                            <span class="error">
                                {{ $message }}
                            </span>

                        @enderror

                    </div>

                </div>

            </div>

        </div>


        {{-- BOTONES --}}
        <div class="acciones-finales">

            <a
                href="{{ route('incidencias.show', $incidencia) }}"
                class="boton boton-regresar"
            >
                Cancelar
            </a>

            <button
                type="submit"
                class="boton boton-guardar"
            >
                💾 Guardar cambios
            </button>

        </div>

    </form>

</div>

</body>

</html>