<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Captura de Calificaciones</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f6fa;
            color: #1f2937;
        }

        .contenedor {
            max-width: 1350px;
            margin: 0 auto;
            padding: 35px 25px;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .encabezado h1 {
            margin: 0;
            font-size: 34px;
            color: #1e293b;
        }

        .encabezado p {
            margin-top: 8px;
            color: #64748b;
            font-size: 16px;
        }

        .btn-regresar {
            background: #374151;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
        }

        .card {
            background: white;
            border-radius: 14px;
            padding: 28px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,.07);
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 25px;
            color: #1e293b;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .campo label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #334155;
        }

        .campo select,
        .campo input {
            width: 100%;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: white;
            font-size: 15px;
        }

        .btn-consultar {
            margin-top: 25px;
            background: #2563eb;
            border: none;
            color: white;
            padding: 13px 25px;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
        }

        .btn-consultar:hover {
            background: #1d4ed8;
        }

        .mensaje {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .vacio {
            text-align: center;
            color: #64748b;
            padding: 45px;
            font-size: 16px;
        }

        /*
        |--------------------------------------------------------------------------
        | MATERIAS
        |--------------------------------------------------------------------------
        */

        .materias-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 18px;
        }

        .materia-card {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            background: #f8fafc;
        }

        .materia-card h3 {
            margin: 0 0 10px 0;
            color: #1e293b;
        }

        .materia-card p {
            margin: 5px 0;
            color: #64748b;
        }

        .materia-acciones {
            margin-top: 18px;
        }

        .btn-capturar {
            display: inline-block;
            background: #16a34a;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn-capturar:hover {
            background: #15803d;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLA
        |--------------------------------------------------------------------------
        */

        .tabla-contenedor {
            overflow-x: auto;
        }

        .tabla {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla th {
            background: #2563eb;
            color: white;
            padding: 14px;
            text-align: left;
        }

        .tabla td {
            padding: 13px;
            border-bottom: 1px solid #e5e7eb;
        }

        .tabla tr:hover {
            background: #f8fafc;
        }

        .input-calificacion {
            width: 110px;
            padding: 9px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            text-align: center;
            font-size: 15px;
        }

        .btn-guardar {
            margin-top: 20px;
            background: #16a34a;
            color: white;
            border: none;
            padding: 13px 25px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }

        .btn-guardar:hover {
            background: #15803d;
        }

        /*
        |--------------------------------------------------------------------------
        | BOTÓN VOLVER
        |--------------------------------------------------------------------------
        */

        .btn-volver {
            display: inline-block;
            margin-top: 15px;
            background: #64748b;
            color: white;
            text-decoration: none;
            padding: 10px 18px;
            border-radius: 8px;
        }

        /*
        |--------------------------------------------------------------------------
        | BOLETA
        |--------------------------------------------------------------------------
        */

        .busqueda-grid {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 15px;
            align-items: end;
        }

        .tabla-resultados {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        .tabla-resultados th {
            background: #334155;
            color: white;
            padding: 12px;
            text-align: left;
        }

        .tabla-resultados td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }

        .btn-boleta {
            display: inline-block;
            background: #7c3aed;
            color: white;
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 7px;
        }

        .btn-boleta:hover {
            background: #6d28d9;
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media(max-width: 900px) {

            .form-grid {
                grid-template-columns: 1fr;
            }

            .materias-grid {
                grid-template-columns: 1fr;
            }

            .encabezado {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .busqueda-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>

<div class="contenedor">

    {{-- ========================================================= --}}
    {{-- ENCABEZADO --}}
    {{-- ========================================================= --}}

    <div class="encabezado">

        <div>

            <h1>
                Captura de Calificaciones
            </h1>

            <p>
                Registra las calificaciones de los alumnos y consulta sus evaluaciones.
            </p>

        </div>

        <a href="{{ route('dashboard') }}"
           class="btn-regresar">

            ← Regresar

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- MENSAJE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="mensaje">

            {{ session('success') }}

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- SELECCIÓN DE GRUPO Y PARCIAL --}}
    {{-- ========================================================= --}}

    <div class="card">

        <h2>
            Seleccionar grupo y parcial
        </h2>


        <form
            method="GET"
            action="{{ route('calificaciones.index') }}"
        >

            <div class="form-grid">

                {{-- GRUPO --}}

                <div class="campo">

                    <label for="grupo_id">
                        Grupo
                    </label>

                    <select
                        name="grupo_id"
                        id="grupo_id"
                        required
                    >

                        <option value="">
                            Selecciona un grupo
                        </option>

                        @foreach($grupos as $grupo)

                            <option
                                value="{{ $grupo->id }}"
                                {{ $grupoId == $grupo->id ? 'selected' : '' }}
                            >

                                {{ $grupo->grado }}° - {{ $grupo->nombre }}

                                @if($grupo->especialidad)
                                    - {{ $grupo->especialidad }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- PERIODO --}}

                <div class="campo">

                    <label for="periodo_evaluacion_id">
                        Parcial
                    </label>

                    <select
                        name="periodo_evaluacion_id"
                        id="periodo_evaluacion_id"
                        required
                    >

                        <option value="">
                            Selecciona un parcial
                        </option>

                        @foreach($periodos as $periodo)

                            <option
                                value="{{ $periodo->id }}"
                                {{ $periodoId == $periodo->id ? 'selected' : '' }}
                            >

                                {{ $periodo->nombre }}

                            </option>

                        @endforeach

                    </select>

                </div>

            </div>


            <button
                type="submit"
                class="btn-consultar"
            >

                Consultar materias

            </button>

        </form>

    </div>


    {{-- ========================================================= --}}
    {{-- MATERIAS DEL GRUPO --}}
    {{-- ========================================================= --}}

    @if($grupoId && $periodoId && !$asignacionId)

        <div class="card">

            <h2>
                Materias asignadas al grupo
            </h2>

            <p style="color:#64748b; margin-top:-10px;">

                Selecciona la materia que deseas utilizar para capturar
                las calificaciones del parcial seleccionado.

            </p>


            @if($asignaciones->count() > 0)

                <div class="materias-grid">

                    @foreach($asignaciones as $asignacion)

                        <div class="materia-card">

                            <h3>

                                {{ $asignacion->materia->nombre }}

                            </h3>


                            <p>

                                <strong>
                                    Clave:
                                </strong>

                                {{ $asignacion->materia->clave }}

                            </p>


                            @if($asignacion->docente)

                                <p>

                                    <strong>
                                        Docente:
                                    </strong>

                                    {{ $asignacion->docente->nombres }}
                                    {{ $asignacion->docente->apellidos }}

                                </p>

                            @endif


                            <p>

                                <strong>
                                    Grupo:
                                </strong>

                                {{ $asignacion->grupo->grado }}°
                                {{ $asignacion->grupo->nombre }}

                            </p>


                            <div class="materia-acciones">

                                <a
                                    href="{{ route('calificaciones.index', [
                                        'grupo_id' => $grupoId,
                                        'asignacion_materia_id' => $asignacion->id,
                                        'periodo_evaluacion_id' => $periodoId
                                    ]) }}"
                                    class="btn-capturar"
                                >

                                    Capturar calificaciones

                                </a>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="vacio">

                    No hay materias asignadas a este grupo.

                </div>

            @endif

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- TABLA DE ALUMNOS --}}
    {{-- ========================================================= --}}

    @if($grupoId && $asignacionId && $periodoId)

        <div class="card">

            <h2>

                @if($asignacion)

                    {{ $asignacion->materia->nombre }}

                    —

                    {{ $asignacion->grupo->grado }}°
                    {{ $asignacion->grupo->nombre }}

                @else

                    Alumnos y calificaciones

                @endif

            </h2>


            <p style="color:#64748b;">

                Periodo:

                <strong>

                    {{ optional($periodos->firstWhere('id', $periodoId))->nombre }}

                </strong>

            </p>


            @if($alumnos->count() > 0)

                <form
                    method="POST"
                    action="{{ route('calificaciones.store') }}"
                >

                    @csrf


                    <input
                        type="hidden"
                        name="asignacion_materia_id"
                        value="{{ $asignacionId }}"
                    >


                    <input
                        type="hidden"
                        name="periodo_evaluacion_id"
                        value="{{ $periodoId }}"
                    >


                    <div class="tabla-contenedor">

                        <table class="tabla">

                            <thead>

                                <tr>

                                    <th>
                                        #
                                    </th>

                                    <th>
                                        Matrícula
                                    </th>

                                    <th>
                                        Alumno
                                    </th>

                                    <th>
                                        Calificación
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($alumnos as $index => $alumno)

                                    @php

                                        $calificacionActual = null;

                                        if ($calificaciones->get($alumno->id)) {

                                            $calificacionActual =
                                                $calificaciones
                                                    ->get($alumno->id)
                                                    ->get($periodoId);

                                        }

                                    @endphp


                                    <tr>

                                        <td>
                                            {{ $index + 1 }}
                                        </td>


                                        <td>
                                            {{ $alumno->matricula }}
                                        </td>


                                        <td>

                                            <strong>

                                                {{ $alumno->apellidos }}
                                                {{ $alumno->nombres }}

                                            </strong>

                                        </td>


                                        <td>

                                            <input
                                                type="number"
                                                name="calificaciones[{{ $alumno->id }}][{{ $periodoId }}]"
                                                class="input-calificacion"
                                                min="0"
                                                max="100"
                                                step="0.01"
                                                value="{{ $calificacionActual?->calificacion }}"
                                                placeholder="0-100"
                                            >

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    <button
                        type="submit"
                        class="btn-guardar"
                    >

                        Guardar calificaciones

                    </button>


                    <br>


                    <a
                        href="{{ route('calificaciones.index', [
                            'grupo_id' => $grupoId,
                            'periodo_evaluacion_id' => $periodoId
                        ]) }}"
                        class="btn-volver"
                    >

                        ← Volver a materias

                    </a>

                </form>

            @else

                <div class="vacio">

                    No hay alumnos registrados en este grupo.

                </div>

            @endif

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- CONSULTAR BOLETA --}}
    {{-- ========================================================= --}}

    <div class="card">

        <h2>
            Consultar Boleta
        </h2>


        <p style="
            color:#64748b;
            margin-top:-10px;
            margin-bottom:25px;
        ">

            Busca un alumno por matrícula, nombre o apellido
            para consultar su boleta completa.

        </p>


        <form
            method="GET"
            action="{{ route('calificaciones.index') }}"
        >

            <div class="busqueda-grid">

                <div class="campo">

                    <label for="busqueda_alumno">
                        Buscar alumno
                    </label>

                    <input
                        type="text"
                        name="busqueda_alumno"
                        id="busqueda_alumno"
                        value="{{ $busquedaAlumno ?? '' }}"
                        placeholder="Ejemplo: 22080109, Bartolo o Tuz"
                    >

                </div>


                <button
                    type="submit"
                    class="btn-consultar"
                    style="margin-top:0;"
                >

                    🔎 Buscar alumno

                </button>

            </div>

        </form>


        {{-- RESULTADOS DE BÚSQUEDA --}}

        @if(
            isset($busquedaAlumno) &&
            $busquedaAlumno !== ''
        )

            @if($alumnosBusqueda->count() > 0)

                <table class="tabla-resultados">

                    <thead>

                        <tr>

                            <th>
                                Matrícula
                            </th>

                            <th>
                                Alumno
                            </th>

                            <th>
                                Grupo
                            </th>

                            <th>
                                Acción
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($alumnosBusqueda as $alumno)

                            <tr>

                                <td>

                                    {{ $alumno->matricula }}

                                </td>


                                <td>

                                    <strong>

                                        {{ $alumno->apellidos }}
                                        {{ $alumno->nombres }}

                                    </strong>

                                </td>


                                <td>

                                    @if($alumno->grupo)

                                        {{ $alumno->grupo->grado }}°
                                        {{ $alumno->grupo->nombre }}

                                    @else

                                        Sin grupo

                                    @endif

                                </td>


                                <td>

                                    <a
                                        href="{{ route('calificaciones.boleta', $alumno->id) }}"
                                        target="_blank"
                                        class="btn-boleta"
                                    >

                                        Ver boleta

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="vacio">

                    No se encontró ningún alumno con esa búsqueda.

                </div>

            @endif

        @endif

    </div>


</div>


</body>

</html>