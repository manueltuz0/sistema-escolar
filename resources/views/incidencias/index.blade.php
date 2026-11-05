<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #F8F4F5;
            color: #33262B;
        }

        .contenedor {
            width: 94%;
            max-width: 1250px;
            margin: 0 auto;
            padding: 28px 0 40px;
        }

        /* ENCABEZADO */

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 15px;
        }

        .titulo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icono-titulo {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #7B1E3A;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .titulo-area h1 {
            margin: 0;
            font-size: 25px;
            font-weight: 700;
            color: #33262B;
        }

        .titulo-area p {
            margin: 4px 0 0;
            font-size: 13px;
            color: #786A70;
        }

        /* BOTONES */

        .acciones-superiores {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 11px 17px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: .2s;
        }

        .btn-vino {
            background: #7B1E3A;
            color: white;
        }

        .btn-vino:hover {
            background: #5D142B;
        }

        /* BUSCADOR */

        .buscador {
            background: white;
            border: 1px solid #E7D9DE;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 22px;
            box-shadow: 0 2px 6px rgba(76, 28, 46, .04);
        }

        .buscador-titulo {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 12px;
            color: #4B3740;
        }

        .form-busqueda {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .input-busqueda {
            flex: 1;
            min-width: 220px;
            height: 44px;
            border: 1px solid #D8C5CC;
            border-radius: 8px;
            padding: 0 14px;
            font-size: 14px;
            outline: none;
        }

        .input-busqueda:focus {
            border-color: #7B1E3A;
            box-shadow: 0 0 0 3px rgba(123, 30, 58, .12);
        }

        .btn-buscar {
            height: 44px;
            padding: 0 20px;
            border: none;
            border-radius: 8px;
            background: #7B1E3A;
            color: white;
            font-weight: 600;
            cursor: pointer;
        }

        .btn-buscar:hover {
            background: #5D142B;
        }

        .btn-limpiar {
            height: 44px;
            padding: 0 18px;
            display: flex;
            align-items: center;
            text-decoration: none;
            background: #F2E7EB;
            color: #551225;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        /* TABLA */

        .tabla-contenedor {
            background: white;
            border: 1px solid #E7D9DE;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(76, 28, 46, .04);
        }

        .tabla-header {
            padding: 20px;
            border-bottom: 1px solid #E7D9DE;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .tabla-header h2 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #4B3740;
        }

        .tabla-header p {
            margin: 5px 0 0;
            font-size: 12px;
            color: #786A70;
        }

        .cantidad-registros {
            font-size: 12px;
            color: #786A70;
        }

        .tabla-scroll {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 820px;
        }

        thead {
            background: #FBF8F9;
        }

        th {
            padding: 14px 12px;
            text-align: left;
            font-size: 11px;
            font-weight: 700;
            color: #786A70;
            border-bottom: 1px solid #E7D9DE;
            text-transform: uppercase;
        }

        td {
            padding: 15px 12px;
            font-size: 12px;
            color: #4B3740;
            border-bottom: 1px solid #F0E7EA;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #FCF9FA;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* ALUMNO */

        .alumno {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #F2E7EB;
            color: #7B1E3A;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .alumno-nombre {
            font-weight: 700;
            color: #33262B;
        }

        .matricula {
            margin-top: 3px;
            font-size: 10px;
            color: #A08F96;
        }

        /* GRUPO */

        .grupo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            padding: 6px 9px;
            border-radius: 6px;
            background: #F8F4F5;
            color: #4B3740;
            font-size: 11px;
            font-weight: 700;
        }

        /* TIPO */

        .tipo-principal {
            font-weight: 700;
            color: #4B3740;
        }

        .tipo-descripcion {
            display: block;
            max-width: 260px;
            margin-top: 4px;
            font-size: 10px;
            color: #A08F96;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ESTADO */

        .estado {
            display: inline-flex;
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .estado-atendida {
            background: #DCFCE7;
            color: #166534;
        }

        .estado-pendiente {
            background: #FEF3C7;
            color: #92400E;
        }

        .estado-seguimiento {
            background: #F2E7EB;
            color: #7B1E3A;
        }

        .estado-concluida {
            background: #E7D9DE;
            color: #4B3740;
        }

        /* ACCIONES */

        .acciones {
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .accion {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 7px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 10px;
            font-weight: 700;
            border: none;
            cursor: pointer;
        }

        .accion-ver {
            background: #F2E7EB;
            color: #7B1E3A;
        }

        .accion-ver:hover {
            background: #E8D6DD;
        }

        .accion-editar {
            background: #FFF5E5;
            color: #A16207;
        }

        .accion-editar:hover {
            background: #FDECC8;
        }

        .accion-eliminar {
            background: #FEF2F2;
            color: #DC2626;
        }

        .accion-eliminar:hover {
            background: #FEE2E2;
        }

        /* MENSAJES */

        .mensaje-exito {
            background: #DCFCE7;
            color: #166534;
            border: 1px solid #BBF7D0;
            padding: 13px 16px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        /* PAGINACIÓN */

        .paginacion {
            padding: 16px 20px;
            border-top: 1px solid #E7D9DE;
        }

        /* RESPONSIVE */

        @media (max-width: 800px) {
            .encabezado {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .acciones-superiores {
                width: 100%;
            }

            .btn {
                flex: 1;
            }

            .form-busqueda {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-buscar,
            .btn-limpiar {
                width: 100%;
                justify-content: center;
            }
        }


        @media (max-width: 520px) {
            .contenedor {
                width: 96%;
                padding-top: 18px;
            }

            .titulo-area h1 {
                font-size: 21px;
            }

            .tabla-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 8px;
            }

            .acciones {
                flex-wrap: wrap;
            }
        }

        .btn:focus-visible,
        .accion:focus-visible,
        .btn-buscar:focus-visible,
        .btn-limpiar:focus-visible,
        .input-busqueda:focus-visible,
        .select-filtro:focus-visible {
            outline: 2px solid #7B1E3A;
            outline-offset: 2px;
        }
    </style>
</head>

<body>

<div class="contenedor">

    {{-- ENCABEZADO --}}

    <div class="encabezado">

        <div class="titulo-area">

            <div class="icono-titulo">
                ⚠️
            </div>

            <div>
                <h1>Incidencias</h1>

                <p>
                    Registro de incidencias y consulta del historial de los alumnos
                </p>
            </div>

        </div>

        <div class="acciones-superiores">

            <a href="{{ route('incidencias.create') }}"
               class="btn btn-vino">
                ＋ Registrar incidencia
            </a>

            <a href="{{ route('citatorios.create') }}"
               class="btn btn-vino">
                ▤ Crear citatorio
            </a>

            <a href="{{ route('citatorios.index') }}"
               class="btn btn-vino">
                ☷ Ver citatorios
            </a>

        </div>

    </div>


    {{-- MENSAJE --}}

    @if(session('success'))
        <div class="mensaje-exito">
            {{ session('success') }}
        </div>
    @endif



    {{-- BUSCADOR --}}

    <div class="buscador">

        <div class="buscador-titulo">
            Buscar alumno
        </div>

        <form action="{{ route('incidencias.index') }}"
              method="GET"
              class="form-busqueda">

            <input
                type="text"
                name="buscar"
                value="{{ request('buscar') }}"
                class="input-busqueda"
                placeholder="Nombre, apellido o matrícula..."
            >
<button type="submit" class="btn-buscar">
                🔎 Buscar
            </button>

            @if(request('buscar'))
                <a href="{{ route('incidencias.index') }}" class="btn-limpiar">
                    Limpiar filtros
                </a>
            @endif

        </form>

    </div>


    {{-- TABLA DE INCIDENCIAS --}}

    <div class="tabla-contenedor">

        <div class="tabla-header">

            <div>
                <h2>Incidencias registradas</h2>

                <p>
                    Consulta las incidencias registradas de los alumnos.
                </p>
            </div>

            <span class="cantidad-registros">
                {{ $incidencias->total() }} registro(s)
            </span>

        </div>


        <div class="tabla-scroll">

            <table>

                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Grupo</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>


                <tbody>

                    @forelse($incidencias as $incidencia)

                        <tr>

                            {{-- ALUMNO --}}

                            <td>

                                <div class="alumno">

                                    <div class="avatar">
                                        {{ strtoupper(substr($incidencia->alumno->nombres ?? 'A', 0, 1)) }}
                                    </div>

                                    <div>

                                        <div class="alumno-nombre">
                                            {{ $incidencia->alumno->nombres ?? '' }}
                                            {{ $incidencia->alumno->apellidos ?? '' }}
                                        </div>

                                        <div class="matricula">
                                            Matrícula:
                                            {{ $incidencia->alumno->matricula ?? '—' }}
                                        </div>

                                    </div>

                                </div>

                            </td>


                            {{-- GRUPO --}}

                            <td>
                                <span class="grupo">
                                    {{ $incidencia->alumno->grupo->nombre ?? '—' }}
                                </span>
                            </td>


                            {{-- TIPO --}}

                            <td>

                                <span class="tipo-principal">
                                    {{ $incidencia->tipo }}
                                </span>

                                @if($incidencia->descripcion)
                                    <span class="tipo-descripcion">
                                        {{ $incidencia->descripcion }}
                                    </span>
                                @endif

                            </td>


                            {{-- FECHA --}}

                            <td>
                                {{ \Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y') }}
                            </td>


                            {{-- ESTADO --}}

                            <td>

                                @if($incidencia->estado === 'Atendida')

                                    <span class="estado estado-atendida">
                                        Atendida
                                    </span>

                                @elseif($incidencia->estado === 'Pendiente')

                                    <span class="estado estado-pendiente">
                                        Pendiente
                                    </span>

                                @elseif($incidencia->estado === 'En seguimiento')

                                    <span class="estado estado-seguimiento">
                                        En seguimiento
                                    </span>

                                @else

                                    <span class="estado estado-concluida">
                                        {{ $incidencia->estado }}
                                    </span>

                                @endif

                            </td>


                            {{-- ACCIONES --}}

                            <td>

                                <div class="acciones">

                                    <a href="{{ route('incidencias.historial', $incidencia->alumno_id) }}"
                                       class="accion accion-ver">
                                        📋 Historial
                                    </a>

                                    <a href="{{ route('incidencias.show', $incidencia) }}"
                                       class="accion accion-ver">
                                        👁 Ver
                                    </a>

                                    <a href="{{ route('incidencias.edit', $incidencia) }}"
                                       class="accion accion-editar">
                                        ✏ Editar
                                    </a>

                                    <form
                                        action="{{ route('incidencias.destroy', $incidencia) }}"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('¿Deseas eliminar esta incidencia?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="accion accion-eliminar">
                                            🗑 Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" style="text-align:center; padding:40px; color:#786A70;">
                                No hay incidencias registradas.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- PAGINACIÓN --}}

        @if($incidencias->hasPages())

            <div class="paginacion">
                {{ $incidencias->withQueryString()->links() }}
            </div>

        @endif

    </div>

</div>

</body>
</html>