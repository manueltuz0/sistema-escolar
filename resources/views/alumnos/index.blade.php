<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de Alumnos</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }

        .contenedor {
            max-width: 1450px;
            margin: 0 auto;
            padding: 35px;
        }

        /* ENCABEZADO */
        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .titulo h1 {
            margin: 0;
            font-size: 32px;
            color: #1f2937;
        }

        .titulo p {
            margin: 7px 0 0;
            color: #6b7280;
            font-size: 15px;
        }

        /* BOTÓN REGISTRAR */
        .btn-registrar {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 7px;
            font-weight: bold;
            transition: 0.2s;
        }

        .btn-registrar:hover {
            background: #1d4ed8;
        }

        /* MENSAJE */
        .mensaje {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 13px 16px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        /* TARJETA */
        .tarjeta {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* BARRA */
        .barra {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 15px;
        }

        .barra h2 {
            margin: 0;
            font-size: 19px;
            color: #374151;
        }

        /* BUSCADOR */
        .buscador {
            position: relative;
            width: 350px;
        }

        .buscador input {
            width: 100%;

            padding: 11px 15px 11px 42px;

            border: 1px solid #d1d5db;
            border-radius: 7px;

            outline: none;

            font-size: 14px;
        }

        .buscador input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 2px rgba(37, 99, 235, 0.12);
        }

        .icono-busqueda {
            position: absolute;

            left: 14px;
            top: 50%;

            transform: translateY(-50%);

            color: #6b7280;

            font-size: 16px;
        }

        /* TABLA */
        .tabla-contenedor {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #2563eb;
            color: white;
        }

        th {
            padding: 14px 12px;

            text-align: left;

            font-size: 14px;

            white-space: nowrap;
        }

        td {
            padding: 14px 12px;

            border-bottom: 1px solid #e5e7eb;

            font-size: 14px;

            vertical-align: middle;
        }

        tbody tr:hover {
            background: #f8fafc;
        }

        /* NOMBRE */
        .nombre-alumno {
            font-weight: bold;
            color: #1f2937;
        }

        .correo {
            color: #4b5563;
        }

        /* MATRÍCULA */
        .matricula {
            font-weight: bold;
            color: #374151;
        }

        /* GRADO */
        .grado {
            display: inline-block;

            background: #eff6ff;
            color: #1d4ed8;

            padding: 5px 9px;

            border-radius: 5px;

            font-size: 13px;

            font-weight: 600;
        }

        /* GRUPO */
        .grupo {
            display: inline-block;

            background: #f3f4f6;
            color: #374151;

            padding: 5px 9px;

            border-radius: 5px;

            font-size: 13px;

            font-weight: 600;
        }

        /* ACCIONES */
        .acciones {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn {
            border: none;

            color: white;

            text-decoration: none;

            padding: 7px 11px;

            border-radius: 5px;

            font-size: 13px;

            cursor: pointer;

            display: inline-block;
        }

        .btn-ver {
            background: #16a34a;
        }

        .btn-ver:hover {
            background: #15803d;
        }

        .btn-editar {
            background: #f59e0b;
        }

        .btn-editar:hover {
            background: #d97706;
        }

        .btn-eliminar {
            background: #dc2626;
        }

        .btn-eliminar:hover {
            background: #b91c1c;
        }

        /* SIN RESULTADOS */
        .sin-resultados {
            display: none;

            text-align: center;

            padding: 35px;

            color: #6b7280;
        }

        /* CONTADOR */
        .contador {
            padding: 14px 20px;

            color: #6b7280;

            font-size: 13px;

            border-top: 1px solid #e5e7eb;
        }

        /* RESPONSIVE */
        @media (max-width: 800px) {

            .contenedor {
                padding: 20px;
            }

            .encabezado {
                flex-direction: column;

                align-items: flex-start;
            }

            .barra {
                flex-direction: column;

                align-items: stretch;
            }

            .buscador {
                width: 100%;
            }

            .titulo h1 {
                font-size: 27px;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    {{-- ENCABEZADO --}}
    <div class="encabezado">

        <div class="titulo">

            <h1>
                Gestión de Alumnos
            </h1>

            <p>
                Administra y consulta la información de los alumnos registrados.
            </p>

        </div>


        <a
            href="{{ route('alumnos.create') }}"
            class="btn-registrar"
        >
            + Registrar Alumno
        </a>

    </div>


    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))

        <div class="mensaje">
            {{ session('success') }}
        </div>

    @endif


    {{-- TARJETA --}}
    <div class="tarjeta">


        {{-- BARRA --}}
        <div class="barra">

            <h2>
                Alumnos registrados
            </h2>


            {{-- BUSCADOR --}}
            <div class="buscador">

                <span class="icono-busqueda">
                    🔍
                </span>

                <input
                    type="text"
                    id="buscador"
                    placeholder="Buscar alumno..."
                    autocomplete="off"
                >

            </div>

        </div>


        {{-- TABLA --}}
        <div class="tabla-contenedor">

            <table id="tablaAlumnos">

                <thead>

                    <tr>

                        <th>
                            ID
                        </th>

                        <th>
                            Matrícula
                        </th>

                        <th>
                            Nombre
                        </th>

                        <th>
                            Correo
                        </th>

                        <th>
                            Grado
                        </th>

                        <th>
                            Grupo
                        </th>

                        <th>
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($alumnos as $alumno)

                        <tr class="fila-alumno">


                            {{-- ID --}}
                            <td>
                                {{ $alumno->id }}
                            </td>


                            {{-- MATRÍCULA --}}
                            <td>

                                <span class="matricula">
                                    {{ $alumno->matricula }}
                                </span>

                            </td>


                            {{-- NOMBRE --}}
                            <td>

                                <div class="nombre-alumno">

                                    {{ $alumno->nombres }}
                                    {{ $alumno->apellidos }}

                                </div>

                            </td>


                            {{-- CORREO --}}
                            <td>

                                <span class="correo">
                                    {{ $alumno->email }}
                                </span>

                            </td>


                            {{-- GRADO --}}
                            <td>

                                <span class="grado">

                                    {{ $alumno->grupo->grado ?? '-' }}

                                   °

                                </span>

                            </td>


                            {{-- GRUPO --}}
                            <td>

                                <span class="grupo">

                                    {{ $alumno->grupo->nombre ?? '-' }}

                                </span>

                            </td>


                            {{-- ACCIONES --}}
                            <td>

                                <div class="acciones">


                                    <a
                                        href="{{ route('alumnos.show', $alumno->id) }}"
                                        class="btn btn-ver"
                                    >
                                        Ver
                                    </a>


                                    <a
                                        href="{{ route('alumnos.edit', $alumno->id) }}"
                                        class="btn btn-editar"
                                    >
                                        Editar
                                    </a>


                                    <form
                                        action="{{ route('alumnos.destroy', $alumno->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este alumno?');"
                                        style="display:inline;"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="btn btn-eliminar"
                                        >
                                            Eliminar
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                style="text-align:center; padding:40px;"
                            >
                                No hay alumnos registrados.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>


            {{-- SIN RESULTADOS --}}
            <div
                id="sinResultados"
                class="sin-resultados"
            >
                No se encontraron alumnos con esa búsqueda.
            </div>

        </div>


        {{-- CONTADOR --}}
        <div class="contador">

            Total de alumnos:

            <strong id="contadorAlumnos">
                {{ $alumnos->count() }}
            </strong>

        </div>

    </div>

</div>


{{-- BUSCADOR --}}
<script>

    const buscador =
        document.getElementById('buscador');

    const filas =
        document.querySelectorAll('.fila-alumno');

    const sinResultados =
        document.getElementById('sinResultados');

    const contador =
        document.getElementById('contadorAlumnos');


    buscador.addEventListener('input', function () {

        const texto =
            this.value
                .toLowerCase()
                .trim();

        let encontrados = 0;


        filas.forEach(function (fila) {

            const contenido =
                fila.textContent.toLowerCase();


            if (contenido.includes(texto)) {

                fila.style.display = '';

                encontrados++;

            } else {

                fila.style.display = 'none';

            }

        });


        contador.textContent =
            encontrados;


        if (
            encontrados === 0 &&
            texto !== ''
        ) {

            sinResultados.style.display =
                'block';

        } else {

            sinResultados.style.display =
                'none';

        }

    });

</script>

</body>

</html>