<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ver incidencia</title>

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
            color: #1f2937;
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
            text-decoration: none;
            border: none;
            border-radius: 7px;
            padding: 10px 16px;
            font-size: 14px;
            cursor: pointer;
        }

        .boton-regresar {
            background: #e5e7eb;
            color: #374151;
        }

        .boton-regresar:hover {
            background: #d1d5db;
        }

        .boton-editar {
            background: #2563eb;
            color: white;
        }

        .boton-editar:hover {
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
            color: #1f2937;
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
            gap: 6px;
        }

        .campo-completo {
            grid-column: 1 / -1;
        }

        .etiqueta {
            font-size: 13px;
            font-weight: 600;
            color: #6b7280;
        }

        .valor {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 7px;
            padding: 11px 13px;
            min-height: 40px;
            font-size: 14px;
        }

        .valor-texto {
            white-space: pre-line;
            line-height: 1.6;
        }

        .estado {
            display: inline-block;
            width: fit-content;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .estado-pendiente {
            background: #fef3c7;
            color: #92400e;
        }

        .estado-seguimiento {
            background: #dbeafe;
            color: #1e40af;
        }

        .estado-atendida {
            background: #dcfce7;
            color: #166534;
        }

        .estado-concluida {
            background: #e5e7eb;
            color: #374151;
        }

        .prioridad {
            display: inline-block;
            width: fit-content;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .prioridad-baja {
            background: #dcfce7;
            color: #166534;
        }

        .prioridad-media {
            background: #fef3c7;
            color: #92400e;
        }

        .prioridad-alta {
            background: #fee2e2;
            color: #991b1b;
        }

        .alumno-principal {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: #2563eb;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        .nombre-alumno {
            font-size: 17px;
            font-weight: 600;
            color: #111827;
        }

        .datos-alumno {
            margin-top: 4px;
            font-size: 13px;
            color: #6b7280;
        }

        .mensaje-vacio {
            color: #6b7280;
            font-size: 14px;
            font-style: italic;
        }

        .alerta {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 18px;
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

            .boton {
                text-align: center;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    {{-- ENCABEZADO --}}
    <div class="encabezado">

        <div>
            <h1 class="titulo">Ver incidencia</h1>

            <div class="subtitulo">
                Consulta toda la información registrada de la incidencia.
            </div>
        </div>

        <div class="botones">

            <a href="{{ route('incidencias.index') }}"
               class="boton boton-regresar">
                ← Regresar
            </a>

            <a href="{{ route('incidencias.edit', $incidencia) }}"
               class="boton boton-editar">
                ✎ Editar
            </a>

        </div>

    </div>


    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))

        <div class="alerta">
            {{ session('success') }}
        </div>

    @endif


    {{-- INFORMACIÓN DEL ALUMNO --}}
    <div class="tarjeta">

        <div class="tarjeta-titulo">
            👤 Información del alumno
        </div>

        <div class="tarjeta-contenido">

            <div class="alumno-principal">

                <div class="avatar">

                    {{ strtoupper(substr($incidencia->alumno->nombres ?? 'A', 0, 1)) }}

                </div>

                <div>

                    <div class="nombre-alumno">

                        {{ $incidencia->alumno->nombres ?? 'Sin nombre' }}

                        {{ $incidencia->alumno->apellidos ?? '' }}

                    </div>

                    <div class="datos-alumno">

                        Matrícula:
                        {{ $incidencia->alumno->matricula ?? 'No registrada' }}

                        @if($incidencia->alumno->grupo)

                            &nbsp; | &nbsp;

                            Grupo:
                            {{ $incidencia->alumno->grupo->nombre ?? $incidencia->alumno->grupo->grupo ?? 'Sin grupo' }}

                        @endif

                    </div>

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

                    <span class="etiqueta">
                        Fecha
                    </span>

                    <div class="valor">

                        {{ \Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y') }}

                    </div>

                </div>


                {{-- TIPO --}}
                <div class="campo">

                    <span class="etiqueta">
                        Tipo de incidencia
                    </span>

                    <div class="valor">

                        {{ $incidencia->tipo }}

                    </div>

                </div>

{{-- CLASIFICACIÓN --}}
<div class="campo">

    <span class="etiqueta">
        Clasificación
    </span>

    <div class="valor">

        @if(($incidencia->clasificacion ?? 'Normal') === 'Grave')

            <span class="prioridad prioridad-alta">
                🔴 Grave
            </span>

        @else

            <span class="prioridad prioridad-baja">
                🟢 Normal
            </span>

        @endif

    </div>

</div>

                {{-- ESTADO --}}
                <div class="campo">

                    <span class="etiqueta">
                        Estado
                    </span>

                    <div class="valor">

                        @if($incidencia->estado === 'Pendiente')

                            <span class="estado estado-pendiente">
                                Pendiente
                            </span>

                        @elseif($incidencia->estado === 'En seguimiento')

                            <span class="estado estado-seguimiento">
                                En seguimiento
                            </span>

                        @elseif($incidencia->estado === 'Atendida')

                            <span class="estado estado-atendida">
                                Atendida
                            </span>

                        @else

                            <span class="estado estado-concluida">
                                {{ $incidencia->estado }}
                            </span>

                        @endif

                    </div>

                </div>


                {{-- LUGAR --}}
                <div class="campo campo-completo">

                    <span class="etiqueta">
                        Lugar
                    </span>

                    <div class="valor">

                        {{ $incidencia->lugar ?: 'No especificado' }}

                    </div>

                </div>


                {{-- DESCRIPCIÓN --}}
                <div class="campo campo-completo">

                    <span class="etiqueta">
                        Descripción de la situación
                    </span>

                    <div class="valor valor-texto">

                        {{ $incidencia->descripcion }}

                    </div>

                </div>


                {{-- ACCIONES REALIZADAS --}}
                <div class="campo campo-completo">

                    <span class="etiqueta">
                        Acciones realizadas
                    </span>

                    <div class="valor valor-texto">

                        @if($incidencia->acciones_realizadas)

                            {{ $incidencia->acciones_realizadas }}

                        @else

                            <span class="mensaje-vacio">
                                No se han registrado acciones.
                            </span>

                        @endif

                    </div>

                </div>


                {{-- OBSERVACIONES --}}
                <div class="campo campo-completo">

                    <span class="etiqueta">
                        Observaciones
                    </span>

                    <div class="valor valor-texto">

                        @if($incidencia->observaciones)

                            {{ $incidencia->observaciones }}

                        @else

                            <span class="mensaje-vacio">
                                No hay observaciones registradas.
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

{{-- BOTONES INFERIORES --}}
<div style="display:flex; justify-content:flex-end; gap:10px; margin-top:20px;">

    <a href="{{ route('incidencias.index') }}"
       class="boton boton-regresar">
        ← Regresar a incidencias
    </a>

    <a href="{{ route('incidencias.edit', $incidencia) }}"
       class="boton boton-editar">
        ✎ Editar incidencia
    </a>

</div>

</div>

</body>
</html>