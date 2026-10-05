<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de Docentes</title>

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

        /* Encabezado */
        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            gap: 20px;
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

        /* Botón registrar */
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

        /* Mensaje */
        .mensaje {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 13px 16px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        /* Tarjeta */
        .tarjeta {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        /* Barra superior */
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

        /* Buscador */
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
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.12);
        }

        .icono-busqueda {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            font-size: 16px;
        }

        /* Tabla */
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

        /* Nombre */
        .nombre-docente {
            font-weight: bold;
            color: #1f2937;
        }

        .correo {
            color: #4b5563;
        }

        /* Especialidad */
        .especialidad {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 5px 9px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 600;
        }

        /* Acciones */
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

        /* Sin resultados */
        .sin-resultados {
            display: none;
            text-align: center;
            padding: 35px;
            color: #6b7280;
        }

        /* Contador */
        .contador {
            padding: 14px 20px;
            color: #6b7280;
            font-size: 13px;
            border-top: 1px solid #e5e7eb;
        }

        /* Responsive */
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
            <h1>Gestión de Docentes</h1>

            <p>
                Administra y consulta la información de los docentes registrados.
            </p>
        </div>

        <a href="{{ route('docentes.create') }}" class="btn-registrar">
            + Registrar Docente
        </a>

    </div>


    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))

        <div class="mensaje">
            {{ session('success') }}
        </div>

    @endif


    {{-- TARJETA PRINCIPAL --}}
    <div class="tarjeta">

        {{-- BARRA --}}
        <div class="barra">

            <h2>Docentes registrados</h2>

            <div class="buscador">

                <span class="icono-busqueda">🔍</span>

                <input
                    type="text"
                    id="buscador"
                    placeholder="Buscar docente..."
                    autocomplete="off"
                >

            </div>

        </div>


        {{-- TABLA --}}
        <div class="tabla-contenedor">

            <table id="tablaDocentes">

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Número de empleado</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Especialidad</th>
                        <th>Acciones</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse($docentes as $docente)

                        <tr class="fila-docente">

                            {{-- ID --}}
                            <td>
                                {{ $docente->id }}
                            </td>


                            {{-- Número de empleado --}}
                            <td>
                                <strong>
                                    {{ $docente->numero_empleado }}
                                </strong>
                            </td>


                            {{-- Nombre --}}
                            <td>

                                <div class="nombre-docente">
                                    {{ $docente->nombres }}
                                    {{ $docente->apellidos }}
                                </div>

                            </td>


                            {{-- Correo --}}
                            <td>

                                <span class="correo">
                                    {{ $docente->email }}
                                </span>

                            </td>


                            {{-- Teléfono --}}
                            <td>
                                {{ $docente->telefono }}
                            </td>


                            {{-- Especialidad --}}
                            <td>

                                <span class="especialidad">
                                    {{ $docente->especialidad }}
                                </span>

                            </td>


                            {{-- Acciones --}}
                            <td>

                                <div class="acciones">

                                    <a
                                        href="{{ route('docentes.show', $docente->id) }}"
                                        class="btn btn-ver"
                                    >
                                        Ver
                                    </a>

                                    <a
                                        href="{{ route('docentes.edit', $docente->id) }}"
                                        class="btn btn-editar"
                                    >
                                        Editar
                                    </a>

                                    <form
                                        action="{{ route('docentes.destroy', $docente->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Estás seguro de eliminar este docente?');"
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

                            <td colspan="7" style="text-align:center; padding:40px;">

                                No hay docentes registrados.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>


            {{-- SIN RESULTADOS DE BÚSQUEDA --}}
            <div
                id="sinResultados"
                class="sin-resultados"
            >
                No se encontraron docentes con esa búsqueda.
            </div>

        </div>


        {{-- CONTADOR --}}
        <div class="contador">

            Total de docentes:
            <strong id="contadorDocentes">
                {{ $docentes->count() }}
            </strong>

        </div>

    </div>

</div>


{{-- BUSCADOR --}}
<script>

    const buscador = document.getElementById('buscador');

    const filas = document.querySelectorAll('.fila-docente');

    const sinResultados = document.getElementById('sinResultados');

    const contador = document.getElementById('contadorDocentes');


    buscador.addEventListener('input', function () {

        const texto = this.value.toLowerCase().trim();

        let encontrados = 0;


        filas.forEach(function (fila) {

            const contenido = fila.textContent.toLowerCase();

            if (contenido.includes(texto)) {

                fila.style.display = '';
                encontrados++;

            } else {

                fila.style.display = 'none';

            }

        });


        contador.textContent = encontrados;


        if (encontrados === 0 && texto !== '') {

            sinResultados.style.display = 'block';

        } else {

            sinResultados.style.display = 'none';

        }

    });

</script>

</body>
</html>