<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detalle de Tutoría</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f4f6f9;
            color: #1f2937;
        }

        .contenedor {
            width: 92%;
            max-width: 1200px;
            margin: 35px auto;
        }

        /* ENCABEZADO */

        .encabezado {
            background: white;
            border-radius: 16px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,.06);

            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .encabezado h1 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .encabezado p {
            margin: 0;
            color: #6b7280;
        }

        .botones {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 9px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-regresar {
            background: #e5e7eb;
            color: #374151;
        }

        .btn-editar {
            background: #2563eb;
            color: white;
        }

        /* ALERTA */

        .alerta {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        /* GRID PRINCIPAL */

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,.06);
        }

        .card-completa {
            grid-column: 1 / -1;
        }

        .card h2 {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 21px;
        }

        /* DATOS */

        .datos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .dato {
            background: #f8fafc;
            border-radius: 10px;
            padding: 14px;
        }

        .dato small {
            display: block;
            color: #6b7280;
            margin-bottom: 5px;
            font-size: 12px;
        }

        .dato strong {
            font-size: 15px;
        }

        /* ESTADO */

        .estado {
            display: inline-block;
            padding: 7px 13px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
        }

        .estado-pendiente {
            background: #fef3c7;
            color: #92400e;
        }

        .estado-seguimiento {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .estado-concluida {
            background: #dcfce7;
            color: #166534;
        }

        /* INCIDENCIA */

        .incidencia {
            border-left: 5px solid #f59e0b;
            background: #fffbeb;
            padding: 18px;
            border-radius: 10px;
        }

        .incidencia h3 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .incidencia p {
            margin: 8px 0;
            line-height: 1.5;
        }

        .incidencia-datos {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 15px;
        }

        .incidencia-dato {
            background: white;
            padding: 12px;
            border-radius: 8px;
        }

        .incidencia-dato small {
            display: block;
            color: #6b7280;
            margin-bottom: 4px;
        }

        /* SECCIONES DE TEXTO */

        .texto {
            background: #f8fafc;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 15px;
        }

        .texto:last-child {
            margin-bottom: 0;
        }

        .texto h3 {
            margin: 0 0 8px;
            font-size: 15px;
        }

        .texto p {
            margin: 0;
            line-height: 1.6;
            white-space: pre-line;
        }

        .sin-datos {
            color: #9ca3af;
            font-style: italic;
        }

        /* RESPONSIVE */

        @media (max-width: 800px) {

            .grid {
                grid-template-columns: 1fr;
            }

            .card-completa {
                grid-column: auto;
            }

            .datos,
            .incidencia-datos {
                grid-template-columns: 1fr;
            }

            .encabezado {
                flex-direction: column;
                align-items: flex-start;
            }

        }

    </style>
</head>

<body>

<div class="contenedor">

    {{-- ENCABEZADO --}}

    <div class="encabezado">

        <div>

            <h1>
                Detalle de Tutoría
            </h1>

            <p>
                Seguimiento de atención del alumno
            </p>

        </div>

        <div class="botones">

            <a
                href="{{ route('tutorias.index') }}"
                class="btn btn-regresar"
            >
                ← Regresar
            </a>

            <a
                href="{{ route('tutorias.edit', $tutoria) }}"
                class="btn btn-editar"
            >
                Editar tutoría
            </a>

        </div>

    </div>


    {{-- MENSAJE --}}

    @if(session('success'))

        <div class="alerta">
            {{ session('success') }}
        </div>

    @endif


    <div class="grid">


        {{-- ========================================== --}}
        {{-- DATOS DEL ALUMNO --}}
        {{-- ========================================== --}}

        <div class="card">

            <h2>
                👤 Alumno
            </h2>

            <div class="datos">

                <div class="dato">

                    <small>
                        Nombre
                    </small>

                    <strong>
                        {{ $tutoria->alumno->nombres }}
                        {{ $tutoria->alumno->apellidos }}
                    </strong>

                </div>


                <div class="dato">

                    <small>
                        Matrícula
                    </small>

                    <strong>
                        {{ $tutoria->alumno->matricula }}
                    </strong>

                </div>


                <div class="dato">

                    <small>
                        Grupo
                    </small>

                    <strong>
                        {{ $tutoria->alumno->grupo->nombre ?? 'Sin grupo' }}
                    </strong>

                </div>


                <div class="dato">

                    <small>
                        Fecha de tutoría
                    </small>

                    <strong>
                        {{ \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y') }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- ========================================== --}}
        {{-- DATOS DE LA TUTORÍA --}}
        {{-- ========================================== --}}

        <div class="card">

            <h2>
                🧑‍🏫 Información de la Tutoría
            </h2>

            <div class="datos">

                <div class="dato">

                    <small>
                        Tipo
                    </small>

                    <strong>
                        {{ $tutoria->tipo }}
                    </strong>

                </div>


                <div class="dato">

                    <small>
                        Estado
                    </small>

                    @if($tutoria->estado === 'Pendiente')

                        <span class="estado estado-pendiente">
                            Pendiente
                        </span>

                    @elseif($tutoria->estado === 'En seguimiento')

                        <span class="estado estado-seguimiento">
                            En seguimiento
                        </span>

                    @else

                        <span class="estado estado-concluida">
                            Concluida
                        </span>

                    @endif

                </div>


                <div class="dato">

                    <small>
                        Fecha de seguimiento
                    </small>

                    <strong>

                        @if($tutoria->fecha_seguimiento)

                            {{ \Carbon\Carbon::parse($tutoria->fecha_seguimiento)->format('d/m/Y') }}

                        @else

                            No definida

                        @endif

                    </strong>

                </div>


                <div class="dato">

                    <small>
                        Registrada
                    </small>

                    <strong>
                        {{ $tutoria->created_at->format('d/m/Y H:i') }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- ========================================== --}}
        {{-- INCIDENCIA RELACIONADA --}}
        {{-- ========================================== --}}

        <div class="card card-completa">

            <h2>
                ⚠️ Incidencia que originó la tutoría
            </h2>


            @if($tutoria->incidencia)

                <div class="incidencia">

                    <h3>
                        Incidencia #{{ $tutoria->incidencia->id }}
                    </h3>

                    <p>
                        <strong>Tipo:</strong>
                        {{ $tutoria->incidencia->tipo }}
                    </p>

                    <p>
                        <strong>Descripción:</strong>
                        {{ $tutoria->incidencia->descripcion }}
                    </p>


                    <div class="incidencia-datos">

                        <div class="incidencia-dato">

                            <small>
                                Fecha
                            </small>

                            <strong>
                                {{ \Carbon\Carbon::parse($tutoria->incidencia->fecha)->format('d/m/Y') }}
                            </strong>

                        </div>


                        <div class="incidencia-dato">

                            <small>
                                Prioridad
                            </small>

                            <strong>
                                {{ $tutoria->incidencia->prioridad }}
                            </strong>

                        </div>


                        <div class="incidencia-dato">

                            <small>
                                Estado actual
                            </small>

                            <strong>
                                {{ $tutoria->incidencia->estado }}
                            </strong>

                        </div>


                        <div class="incidencia-dato">

                            <small>
                                Lugar
                            </small>

                            <strong>
                                {{ $tutoria->incidencia->lugar ?? 'No especificado' }}
                            </strong>

                        </div>

                    </div>

                </div>

            @else

                <p class="sin-datos">
                    Esta tutoría no está relacionada con una incidencia.
                </p>

            @endif

        </div>


        {{-- ========================================== --}}
        {{-- MOTIVO --}}
        {{-- ========================================== --}}

        <div class="card card-completa">

            <h2>
                📋 Motivo y situación
            </h2>

            <div class="texto">

                <h3>
                    Motivo de la tutoría
                </h3>

                <p>
                    {{ $tutoria->motivo }}
                </p>

            </div>


            <div class="texto">

                <h3>
                    Situación presentada
                </h3>

                <p>

                    @if($tutoria->situacion)

                        {{ $tutoria->situacion }}

                    @else

                        <span class="sin-datos">
                            No se registró información.

                        </span>

                    @endif

                </p>

            </div>

        </div>


        {{-- ========================================== --}}
        {{-- ACUERDOS Y COMPROMISOS --}}
        {{-- ========================================== --}}

        <div class="card">

            <h2>
                🤝 Acuerdos
            </h2>

            <div class="texto">

                <p>

                    @if($tutoria->acuerdos)

                        {{ $tutoria->acuerdos }}

                    @else

                        <span class="sin-datos">
                            No se registraron acuerdos.
                        </span>

                    @endif

                </p>

            </div>

        </div>


        <div class="card">

            <h2>
                🎯 Compromisos
            </h2>


            <div class="texto">

                <h3>
                    Compromiso del alumno
                </h3>

                <p>

                    @if($tutoria->compromisos_alumno)

                        {{ $tutoria->compromisos_alumno }}

                    @else

                        <span class="sin-datos">
                            No registrado.
                        </span>

                    @endif

                </p>

            </div>


            <div class="texto">

                <h3>
                    Compromiso del tutor
                </h3>

                <p>

                    @if($tutoria->compromisos_tutor)

                        {{ $tutoria->compromisos_tutor }}

                    @else

                        <span class="sin-datos">
                            No registrado.
                        </span>

                    @endif

                </p>

            </div>

        </div>


        {{-- ========================================== --}}
        {{-- OBSERVACIONES --}}
        {{-- ========================================== --}}

        <div class="card card-completa">

            <h2>
                📝 Observaciones
            </h2>

            <div class="texto">

                <p>

                    @if($tutoria->observaciones)

                        {{ $tutoria->observaciones }}

                    @else

                        <span class="sin-datos">
                            No se registraron observaciones.
                        </span>

                    @endif

                </p>

            </div>

        </div>


    </div>

</div>

</body>
</html>