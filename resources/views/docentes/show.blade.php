<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Docente</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 16px;
            font-family: Arial, sans-serif;
            background: #f8f4f5;
            color: #292329;
        }

        .contenedor {
            max-width: 1050px;
            margin: auto;
        }

        .tarjeta {
            margin-bottom: 25px;
            padding: 28px;
            background: #fff;
            border: 1px solid #eadfe3;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(75, 20, 40, 0.07);
        }

        h1 {
            margin: 0 0 8px;
            color: #7b1e3a;
            font-size: 28px;
        }

        h2 {
            margin: 0 0 18px;
            color: #7b1e3a;
            font-size: 20px;
        }

        .descripcion {
            margin: 0 0 20px;
            color: #6b6266;
            line-height: 1.5;
        }

        .identificador {
            display: inline-block;
            margin-bottom: 22px;
            padding: 7px 12px;
            border-radius: 20px;
            background: #f8e9ee;
            color: #7b1e3a;
            font-size: 13px;
            font-weight: bold;
        }

        .datos {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .dato {
            min-width: 0;
            padding: 15px;
            border: 1px solid #eadfe3;
            border-radius: 7px;
        }

        .dato-completo {
            grid-column: 1 / -1;
        }

        .etiqueta {
            display: block;
            margin-bottom: 7px;
            color: #766970;
            font-size: 13px;
            font-weight: bold;
        }

        .valor {
            overflow-wrap: anywhere;
            color: #292329;
            font-size: 15px;
            font-weight: 500;
        }

        .sin-dato {
            color: #9b9095;
            font-style: italic;
        }

        .tabla-contenedor {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #7b1e3a;
            color: #fff;
        }

        th {
            padding: 13px 12px;
            text-align: left;
            font-size: 13px;
            white-space: nowrap;
        }

        td {
            padding: 13px 12px;
            border-bottom: 1px solid #eee5e8;
            font-size: 13px;
            vertical-align: top;
        }

        tbody tr:hover {
            background: #fcf7f9;
        }

        .materia-nombre {
            color: #7b1e3a;
            font-weight: bold;
        }

        .sin-asignaciones {
            padding: 25px;
            border: 1px solid #eadfe3;
            border-radius: 7px;
            background: #fcf7f9;
            color: #6b6266;
            line-height: 1.6;
            text-align: center;
        }

        .contador {
            margin-top: 15px;
            color: #6b6266;
            font-size: 13px;
        }

        .contador strong {
            color: #7b1e3a;
        }

        .botones {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
        }

        .boton {
            display: inline-block;
            padding: 11px 16px;
            border-radius: 6px;
            color: #fff;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
        }

        .boton-regresar {
            background: #6b6266;
        }

        .boton-regresar:hover {
            background: #51494d;
        }

        .boton-editar {
            background: #7b1e3a;
        }

        .boton-editar:hover {
            background: #5e162c;
        }

        @media (max-width: 600px) {
            body {
                padding: 16px 10px;
            }

            .tarjeta {
                padding: 20px 15px;
            }

            h1 {
                font-size: 24px;
            }

            .datos {
                grid-template-columns: 1fr;
            }

            .dato-completo {
                grid-column: auto;
            }

            .botones {
                flex-direction: column;
            }

            .boton {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="contenedor">

    {{-- INFORMACIÓN DEL DOCENTE --}}
    <section class="tarjeta">
        <h1>Detalles del docente</h1>

        <p class="descripcion">
            Consulta la información personal y las asignaciones académicas registradas.
        </p>

        <span class="identificador">
            Registro #{{ $docente->id }}
        </span>

        <h2>Información personal y laboral</h2>

        <div class="datos">
            <div class="dato">
                <span class="etiqueta">Número de empleado</span>
                <span class="valor">{{ $docente->numero_empleado }}</span>
            </div>

            <div class="dato">
                <span class="etiqueta">Especialidad</span>
                <span class="valor {{ $docente->especialidad ? '' : 'sin-dato' }}">
                    {{ $docente->especialidad ?: 'No registrada' }}
                </span>
            </div>

            <div class="dato">
                <span class="etiqueta">Nombres</span>
                <span class="valor">{{ $docente->nombres }}</span>
            </div>

            <div class="dato">
                <span class="etiqueta">Apellidos</span>
                <span class="valor">{{ $docente->apellidos }}</span>
            </div>

            <div class="dato dato-completo">
                <span class="etiqueta">Correo electrónico</span>
                <span class="valor">{{ $docente->email }}</span>
            </div>

            <div class="dato dato-completo">
                <span class="etiqueta">Teléfono</span>
                <span class="valor {{ $docente->telefono ? '' : 'sin-dato' }}">
                    {{ $docente->telefono ?: 'No registrado' }}
                </span>
            </div>
        </div>
    </section>

    {{-- ASIGNACIONES ACADÉMICAS --}}
    <section class="tarjeta">
        <h2>Materias y grupos asignados</h2>

        <p class="descripcion">
            Consulta las materias, los grupos y los ciclos escolares asociados a este docente.
        </p>

        @if($docente->asignacionesMaterias->isNotEmpty())
            <div class="tabla-contenedor">
                <table>
                    <thead>
                        <tr>
                            <th>Materia</th>
                            <th>Clave</th>
                            <th>Semestre</th>
                            <th>Grupo</th>
                            <th>Grado</th>
                            <th>Ciclo escolar</th>
                            <th>Periodo</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($docente->asignacionesMaterias as $asignacion)
                            <tr>
                                <td class="materia-nombre">
                                    {{ $asignacion->materia?->nombre ?? 'Materia no disponible' }}
                                </td>

                                <td>
                                    {{ $asignacion->materia?->clave ?? '—' }}
                                </td>

                                <td>
                                    {{ $asignacion->materia?->semestre ?? '—' }}
                                </td>

                                <td>
                                    {{ $asignacion->grupo?->nombre ?? 'Grupo no disponible' }}
                                </td>

                                <td>
                                    {{ $asignacion->grupo?->grado ?? '—' }}
                                </td>

                                <td>
                                    {{ $asignacion->cicloEscolar?->nombre ?? 'Ciclo no disponible' }}
                                </td>

                                <td>
                                    @if($asignacion->cicloEscolar)
                                        {{ $asignacion->cicloEscolar->fecha_inicio ?: '—' }}
                                        al
                                        {{ $asignacion->cicloEscolar->fecha_fin ?: '—' }}
                                    @else
                                        —
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p class="contador">
                Total de asignaciones:
                <strong>{{ $docente->asignacionesMaterias->count() }}</strong>
            </p>
        @else
            <div class="sin-asignaciones">
                Este docente todavía no tiene asignaciones de materias registradas.
            </div>
        @endif
    </section>

    {{-- BOTONES --}}
    <div class="botones">
        <a
            href="{{ route('docentes.index') }}"
            class="boton boton-regresar"
        >
            Regresar a la lista
        </a>

        <a
            href="{{ route('docentes.edit', $docente->id) }}"
            class="boton boton-editar"
        >
            Editar docente
        </a>
    </div>

</div>
</body>
</html>