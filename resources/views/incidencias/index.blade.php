<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Incidencias y Tutorías</title>

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

        /* =========================================================
           CONTENEDOR PRINCIPAL
        ========================================================= */

        .contenedor {
            width: 94%;
            max-width: 1250px;
            margin: 0 auto;
            padding: 28px 0 40px;
        }


        /* =========================================================
           ENCABEZADO
        ========================================================= */

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .titulo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .icono-titulo {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #2563eb;
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 18px;
        }

        .titulo-area h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: #1f2937;
        }

        .titulo-area p {
            margin: 3px 0 0;
            font-size: 12px;
            color: #6b7280;
        }


        /* =========================================================
           BOTONES SUPERIORES
        ========================================================= */

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

            padding: 10px 16px;

            border-radius: 7px;

            text-decoration: none;

            font-size: 13px;
            font-weight: 600;

            border: none;

            cursor: pointer;

            transition: .2s;
        }

        .btn-azul {
            background: #2563eb;
            color: white;
        }

        .btn-azul:hover {
            background: #1d4ed8;
        }

        .btn-tutoria {
            background: white;
            color: #2563eb;
            border: 1px solid #dbe2ea;
        }

        .btn-tutoria:hover {
            background: #eff6ff;
        }


        /* =========================================================
           TARJETAS DE ESTADÍSTICAS
        ========================================================= */

        .estadisticas {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0, 1fr));

            gap: 18px;

            margin-bottom: 22px;
        }

        .tarjeta-estadistica {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            min-height: 115px;

            padding: 20px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, .04);
        }

        .estadistica-texto {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .estadistica-titulo {
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;

            text-transform: uppercase;
        }

        .estadistica-numero {
            font-size: 28px;
            font-weight: 600;
            color: #111827;
        }

        .estadistica-icono {
            width: 42px;
            height: 42px;

            border-radius: 9px;

            background: #eff6ff;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 19px;
        }


        /* =========================================================
           BUSCADOR
        ========================================================= */

        .buscador {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            padding: 20px;

            margin-bottom: 22px;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, .04);
        }

        .buscador-titulo {
            font-size: 14px;
            font-weight: 600;

            margin-bottom: 12px;

            color: #374151;
        }

        .form-busqueda {
            display: flex;

            gap: 10px;

            align-items: center;
        }

        .input-busqueda {
            flex: 1;

            height: 42px;

            border: 1px solid #d1d5db;

            border-radius: 7px;

            padding: 0 14px;

            font-size: 13px;

            outline: none;
        }

        .input-busqueda:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 2px rgba(37, 99, 235, .10);
        }

        .btn-buscar {
            height: 42px;

            padding: 0 20px;

            border: none;

            border-radius: 7px;

            background: #2563eb;

            color: white;

            font-weight: 600;

            cursor: pointer;
        }

        .btn-buscar:hover {
            background: #1d4ed8;
        }

        .btn-limpiar {
            height: 42px;

            padding: 0 18px;

            display: flex;

            align-items: center;

            text-decoration: none;

            background: #f3f4f6;

            color: #374151;

            border-radius: 7px;

            font-size: 13px;

            font-weight: 600;
        }


        /* =========================================================
           TABLA
        ========================================================= */

        .tabla-contenedor {
            background: white;

            border: 1px solid #e5e7eb;

            border-radius: 10px;

            overflow: hidden;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, .04);
        }

        .tabla-header {
            padding: 18px 20px;

            border-bottom: 1px solid #e5e7eb;

            display: flex;

            justify-content: space-between;

            align-items: center;
        }

        .tabla-header h2 {
            margin: 0;

            font-size: 15px;

            font-weight: 600;

            color: #374151;
        }

        .tabla-header p {
            margin: 4px 0 0;

            font-size: 11px;

            color: #6b7280;
        }

        .cantidad-registros {
            font-size: 11px;

            color: #6b7280;
        }

        .tabla-scroll {
            width: 100%;

            overflow-x: auto;
        }

        table {
            width: 100%;

            border-collapse: collapse;

            min-width: 850px;
        }

        thead {
            background: #f9fafb;
        }

        th {
            padding: 12px 10px;

            text-align: left;

            font-size: 11px;

            font-weight: 600;

            color: #6b7280;

            border-bottom: 1px solid #e5e7eb;

            text-transform: uppercase;
        }

        td {
            padding: 13px 10px;

            font-size: 12px;

            color: #374151;

            border-bottom: 1px solid #f0f1f3;

            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fafafa;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }


        /* =========================================================
           ALUMNO
        ========================================================= */

        .alumno {
            display: flex;

            align-items: center;

            gap: 9px;
        }

        .avatar {
            width: 30px;
            height: 30px;

            border-radius: 50%;

            background: #eff6ff;

            color: #2563eb;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 11px;

            font-weight: 700;
        }

        .alumno-nombre {
            font-weight: 600;

            color: #1f2937;
        }

        .matricula {
            margin-top: 2px;

            font-size: 10px;

            color: #9ca3af;
        }


        /* =========================================================
           GRUPO
        ========================================================= */

        .grupo {
            display: inline-flex;

            align-items: center;

            justify-content: center;

            min-width: 28px;

            height: 25px;

            padding: 0 7px;

            border-radius: 6px;

            background: #f3f4f6;

            color: #374151;

            font-size: 11px;

            font-weight: 600;
        }


        /* =========================================================
           TIPO
        ========================================================= */

        .tipo-principal {
            font-weight: 600;

            color: #374151;
        }

        .tipo-descripcion {
            display: block;

            max-width: 260px;

            margin-top: 3px;

            font-size: 10px;

            color: #9ca3af;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;
        }


        /* =========================================================
           ESTADO
        ========================================================= */

        .estado {
            display: inline-flex;

            padding: 5px 9px;

            border-radius: 20px;

            font-size: 10px;

            font-weight: 600;
        }

        .estado-atendida {
            background: #dcfce7;

            color: #166534;
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
            background: #e5e7eb;

            color: #374151;
        }


        /* =========================================================
           PRIORIDAD
        ========================================================= */

        .prioridad {
            font-size: 11px;

            font-weight: 600;
        }

        .prioridad-alta {
            color: #dc2626;
        }

        .prioridad-media {
            color: #d97706;
        }

        .prioridad-baja {
            color: #16a34a;
        }


        /* =========================================================
           ACCIONES
        ========================================================= */

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

            padding: 6px 9px;

            border-radius: 6px;

            text-decoration: none;

            font-size: 10px;

            font-weight: 600;

            border: none;

            cursor: pointer;
        }

        .accion-ver {
            background: #f3f4f6;

            color: #374151;
        }

        .accion-editar {
            background: #eff6ff;

            color: #2563eb;
        }

        .accion-eliminar {
            background: #fef2f2;

            color: #dc2626;
        }


        /* =========================================================
           MENSAJE
        ========================================================= */

        .mensaje-exito {
            background: #dcfce7;

            color: #166534;

            border: 1px solid #bbf7d0;

            padding: 12px 15px;

            border-radius: 7px;

            margin-bottom: 18px;

            font-size: 13px;
        }


        /* =========================================================
           PAGINACIÓN
        ========================================================= */

        .paginacion {
            padding: 15px 20px;

            border-top: 1px solid #e5e7eb;
        }


        /* =========================================================
           RESPONSIVE
        ========================================================= */

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

            .estadisticas {
                grid-template-columns: 1fr;
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

    </style>

</head>


<body>

<div class="contenedor">


    {{-- =========================================================
         ENCABEZADO
    ========================================================== --}}

    <div class="encabezado">

        <div class="titulo-area">

            <div class="icono-titulo">
                ⚠️
            </div>

            <div>

                <h1>
                    Incidencias
                </h1>

                <p>
                    Registro y seguimiento de incidencias de los alumnos
                </p>

            </div>

        </div>


        <div class="acciones-superiores">

            <a
                href="{{ route('incidencias.create') }}"
                class="btn btn-azul"
            >
                ＋ Registrar incidencia
            </a>


            <a
                href="{{ route('tutorias.index') }}"
                class="btn btn-tutoria"
            >
                📋 Tutorías
            </a>

        </div>

    </div>



    {{-- =========================================================
         MENSAJE
    ========================================================== --}}

    @if(session('success'))

        <div class="mensaje-exito">

            {{ session('success') }}

        </div>

    @endif



    {{-- =========================================================
         ESTADÍSTICAS
    ========================================================== --}}

    <div class="estadisticas">


        {{-- TOTAL --}}

        <div class="tarjeta-estadistica">

            <div class="estadistica-texto">

                <span class="estadistica-titulo">
                    Total de incidencias
                </span>

                <span class="estadistica-numero">
                    {{ $totalIncidencias }}
                </span>

            </div>

            <div class="estadistica-icono">
                📋
            </div>

        </div>


        {{-- EN SEGUIMIENTO --}}

        <div class="tarjeta-estadistica">

            <div class="estadistica-texto">

                <span class="estadistica-titulo">
                    En seguimiento
                </span>

                <span class="estadistica-numero">
                    {{ $enSeguimiento }}
                </span>

            </div>

            <div class="estadistica-icono">
                🔎
            </div>

        </div>


        {{-- PENDIENTES --}}

        <div class="tarjeta-estadistica">

            <div class="estadistica-texto">

                <span class="estadistica-titulo">
                    Pendientes
                </span>

                <span class="estadistica-numero">
                    {{ $pendientes }}
                </span>

            </div>

            <div class="estadistica-icono">
                ⏳
            </div>

        </div>


    </div>



    {{-- =========================================================
         BUSCADOR
    ========================================================== --}}

    <div class="buscador">

        <div class="buscador-titulo">
            Buscar alumno
        </div>


        <form
            action="{{ route('incidencias.index') }}"
            method="GET"
            class="form-busqueda"
        >

            <input
                type="text"
                name="buscar"
                value="{{ request('buscar') }}"
                class="input-busqueda"
                placeholder="Nombre, apellido o matrícula..."
            >


            <button
                type="submit"
                class="btn-buscar"
            >
                🔎 Buscar
            </button>


            @if(request('buscar'))

                <a
                    href="{{ route('incidencias.index') }}"
                    class="btn-limpiar"
                >
                    Limpiar
                </a>

            @endif

        </form>

    </div>



    {{-- =========================================================
         TABLA
    ========================================================== --}}

    <div class="tabla-contenedor">


        <div class="tabla-header">

            <div>

                <h2>
                    Incidencias registradas
                </h2>

                <p>
                    Consulta y administra las incidencias de los alumnos.
                </p>

            </div>


            <span class="cantidad-registros">

                {{ $incidencias->total() }}

                registro(s)

            </span>

        </div>



        <div class="tabla-scroll">

            <table>

                <thead>

                    <tr>

                        <th>
                            Alumno
                        </th>

                        <th>
                            Grupo
                        </th>

                        <th>
                            Tipo
                        </th>

                        <th>
                            Fecha
                        </th>

                        <th>
                            Prioridad
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Acciones
                        </th>

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



                        {{-- PRIORIDAD --}}

                        <td>

                            @if($incidencia->prioridad === 'Alta')

                                <span class="prioridad prioridad-alta">
                                    ● Alta
                                </span>

                            @elseif($incidencia->prioridad === 'Media')

                                <span class="prioridad prioridad-media">
                                    ● Media
                                </span>

                            @else

                                <span class="prioridad prioridad-baja">
                                    ● Baja
                                </span>

                            @endif

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


                                {{-- VER --}}

                                <a
                                    href="{{ route('incidencias.show', $incidencia) }}"
                                    class="accion accion-ver"
                                >
                                    👁 Ver
                                </a>


                                {{-- EDITAR --}}

                                <a
                                    href="{{ route('incidencias.edit', $incidencia) }}"
                                    class="accion accion-editar"
                                >
                                    ✏ Editar
                                </a>
                                <a href="{{ route('tutorias.create', ['incidencia' => $incidencia->id]) }}"
   class="btn-tutoria">
    📋 Tutoría
</a>

                                {{-- ELIMINAR --}}

                                <form
                                    action="{{ route('incidencias.destroy', $incidencia) }}"
                                    method="POST"
                                    style="display:inline;"
                                    onsubmit="return confirm('¿Deseas eliminar esta incidencia?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="accion accion-eliminar"
                                    >
                                        🗑 Eliminar
                                    </button>

                                </form>


                            </div>

                        </td>


                    </tr>


                @empty

                    <tr>

                        <td
                            colspan="7"
                            style="
                                text-align:center;
                                padding:40px;
                                color:#6b7280;
                            "
                        >

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

                {{ $incidencias->links() }}

            </div>

        @endif


    </div>


</div>

</body>

</html>