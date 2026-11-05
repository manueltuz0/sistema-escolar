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
            background: #f8f4f5;
            color: #292329;
        }

        .contenedor {
            max-width: 1450px;
            margin: 0 auto;
            padding: 30px;
        }

        .encabezado {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 25px;
        }

        .titulo h1 {
            margin: 0;
            color: #7b1e3a;
            font-size: 30px;
        }

        .titulo p {
            margin: 8px 0 0;
            color: #6b6266;
            font-size: 14px;
            line-height: 1.5;
        }

        .btn-registrar {
            display: inline-block;
            padding: 12px 18px;
            border-radius: 7px;
            background: #7b1e3a;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            white-space: nowrap;
        }

        .btn-registrar:hover {
            background: #5e162c;
        }

        .mensaje {
            padding: 14px 16px;
            margin-bottom: 18px;
            border-radius: 7px;
            line-height: 1.5;
        }

        .mensaje-exito {
            background: #f0f8f1;
            color: #245b32;
            border: 1px solid #c6e4cc;
        }

        .mensaje-error {
            background: #fff0f2;
            color: #8b1e35;
            border: 1px solid #edc2cb;
        }

        .mensaje-advertencia {
            background: #fff8eb;
            color: #744b0b;
            border: 1px solid #ead4a8;
        }

        .herramientas-excel {
            display: flex;
            flex-wrap: wrap;
            align-items: stretch;
            gap: 14px;
            padding: 20px;
            border-bottom: 1px solid #eadfe3;
            background: #fff;
        }

        .excel-panel {
            flex: 1 1 320px;
            min-width: 0;
            padding: 16px;
            border: 1px solid #eadfe3;
            border-radius: 8px;
            background: #fcf9fa;
        }

        .excel-panel h3 {
            margin: 0 0 7px;
            color: #7b1e3a;
            font-size: 15px;
        }

        .excel-panel p {
            margin: 0 0 13px;
            color: #6b6266;
            font-size: 13px;
            line-height: 1.5;
        }

        .form-importar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 10px;
        }

        .form-importar input[type="file"] {
            flex: 1 1 190px;
            min-width: 0;
            max-width: 100%;
            padding: 8px;
            border: 1px solid #d8c8ce;
            border-radius: 5px;
            background: #fff;
            color: #292329;
            font-size: 12px;
        }

        .btn-excel {
            display: inline-block;
            padding: 10px 14px;
            border: 0;
            border-radius: 5px;
            background: #7b1e3a;
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            text-align: center;
        }

        .btn-excel:hover {
            background: #5e162c;
        }

        .nota-excel {
            display: block;
            margin-top: 9px;
            color: #7a7075;
            font-size: 12px;
            line-height: 1.45;
        }

        .errores-importacion {
            margin: 8px 0 0;
            padding-left: 22px;
        }

        .errores-importacion li + li {
            margin-top: 5px;
        }

        .mensaje ul {
            margin-bottom: 0;
        }

        .tarjeta {
            overflow: hidden;
            background: #fff;
            border: 1px solid #eadfe3;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(75, 20, 40, 0.07);
        }

        .barra {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 18px;
            padding: 20px;
            border-bottom: 1px solid #eadfe3;
        }

        .barra h2 {
            margin: 0;
            color: #7b1e3a;
            font-size: 19px;
        }

        .buscador {
            display: flex;
            align-items: center;
            gap: 9px;
            width: 510px;
            max-width: 100%;
        }

        .campo-busqueda {
            flex: 1;
            min-width: 0;
        }

        .campo-busqueda input {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #d8c8ce;
            border-radius: 6px;
            outline: none;
            font-size: 14px;
        }

        .campo-busqueda input:focus {
            border-color: #7b1e3a;
            box-shadow: 0 0 0 3px rgba(123, 30, 58, 0.10);
        }

        .btn-buscar,
        .btn {
            display: inline-block;
            padding: 9px 12px;
            border: none;
            border-radius: 5px;
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
            text-align: center;
        }

        .btn-buscar {
            padding: 11px 15px;
            background: #7b1e3a;
            font-size: 14px;
        }

        .btn-buscar:hover {
            background: #5e162c;
        }

        .btn-limpiar {
            color: #7b1e3a;
            text-decoration: none;
            font-size: 13px;
            white-space: nowrap;
        }

        .btn-limpiar:hover {
            text-decoration: underline;
        }

        .tabla-contenedor {
            width: 100%;
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
            padding: 14px 12px;
            text-align: left;
            font-size: 13px;
            white-space: nowrap;
        }

        td {
            padding: 14px 12px;
            border-bottom: 1px solid #eee5e8;
            font-size: 13px;
            vertical-align: middle;
        }

        tbody tr:hover {
            background: #fcf7f9;
        }

        .nombre-docente {
            color: #512033;
            font-weight: bold;
        }

        .correo {
            overflow-wrap: anywhere;
            color: #5f555a;
        }

        .especialidad {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 5px;
            background: #f8e9ee;
            color: #7b1e3a;
            font-size: 12px;
            font-weight: bold;
        }

        .acciones {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .btn-ver {
            background: #7b1e3a;
        }

        .btn-ver:hover {
            background: #5e162c;
        }

        .btn-editar {
            background: #a34b68;
        }

        .btn-editar:hover {
            background: #873650;
        }

        .btn-eliminar {
            background: #4b4145;
        }

        .btn-eliminar:hover {
            background: #30292c;
        }

        .sin-resultados {
            padding: 35px;
            color: #6b6266;
            text-align: center;
        }

        .contador {
            padding: 14px 20px;
            border-top: 1px solid #eadfe3;
            color: #6b6266;
            font-size: 13px;
        }

        .contador strong {
            color: #7b1e3a;
        }

        .paginacion {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            padding: 18px 20px;
        }

        .paginacion-info {
            color: #6b6266;
            font-size: 13px;
        }

        .paginacion-enlaces nav > div:first-child {
            display: none;
        }

        .paginacion-enlaces nav > div:last-child {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 4px;
        }

        .paginacion-enlaces a,
        .paginacion-enlaces span[aria-current="page"] span,
        .paginacion-enlaces span[aria-disabled="true"] span {
            display: inline-block;
            padding: 8px 12px;
            border: 1px solid #eadfe3;
            border-radius: 5px;
            text-decoration: none;
            font-size: 13px;
        }

        .paginacion-enlaces a {
            background: #fff;
            color: #7b1e3a;
        }

        .paginacion-enlaces a:hover {
            background: #f8e9ee;
        }

        .paginacion-enlaces span[aria-current="page"] span {
            background: #7b1e3a;
            border-color: #7b1e3a;
            color: #fff;
        }

        .paginacion-enlaces span[aria-disabled="true"] span {
            background: #faf7f8;
            color: #aaa0a4;
        }

        @media (max-width: 850px) {
            .contenedor {
                padding: 18px;
            }

            .encabezado,
            .barra {
                align-items: stretch;
                flex-direction: column;
            }

            .buscador {
                width: 100%;
            }
        }

        @media (max-width: 500px) {
            .contenedor {
                padding: 12px;
            }

            .titulo h1 {
                font-size: 25px;
            }

            .buscador {
                flex-wrap: wrap;
            }

            .campo-busqueda {
                flex-basis: 100%;
            }

            .btn-registrar {
                text-align: center;
            }
        }
    </style>
</head>

<body>
<div class="contenedor">

    <header class="encabezado">
        <div class="titulo">
            <h1>Gestión de Docentes</h1>
            <p>Administra y consulta la información de los docentes registrados.</p>
        </div>

        <a href="{{ route('docentes.create') }}" class="btn-registrar">
            + Registrar docente
        </a>
    </header>

    {{-- HERRAMIENTAS DE IMPORTACIÓN Y EXPORTACIÓN --}}
    <section class="tarjeta" style="margin-bottom: 22px;">
        <div class="herramientas-excel">
            <div class="excel-panel">
                <h3>Importar docentes desde Excel</h3>
                <p>Selecciona un archivo con los datos de los docentes que deseas registrar.</p>

                <form
                    action="{{ route('docentes.importar') }}"
                    method="POST"
                    enctype="multipart/form-data"
                    class="form-importar"
                >
                    @csrf

                    <input
                        type="file"
                        name="archivo"
                        accept=".xlsx,.xls,.csv"
                        required
                        aria-label="Seleccionar archivo Excel de docentes"
                    >

                    <button type="submit" class="btn-excel">
                        Importar Excel
                    </button>
                </form>

                <span class="nota-excel">
                    Formatos permitidos: XLSX, XLS o CSV. Tamaño máximo: 5 MB.
                    Las filas con número de empleado o correo duplicado se omitirán.
                </span>
            </div>

            <div class="excel-panel">
                <h3>Exportar docentes</h3>
                <p>Descarga el listado completo de docentes registrados en un archivo Excel.</p>

                <a href="{{ route('docentes.exportar') }}" class="btn-excel">
                    
                    Exportar a Excel
                </a>
                
<a href="{{ route('docentes.plantilla') }}" class="btn-excel" style="margin-top: 10px;">
    Descargar plantilla vacía
</a>

                <span class="nota-excel">
                    Se exportan todos los docentes, no solamente los resultados de la búsqueda actual.
                </span>
            </div>
        </div>
    </section>

    {{-- MENSAJES DE OPERACIONES --}}
    @if(session('success'))
        <div class="mensaje mensaje-exito" role="status">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mensaje mensaje-error" role="alert">
            <strong>No se pudo completar la operación.</strong>
            <div>{{ session('error') }}</div>
        </div>
    @endif

    @if(session('warning'))
        <div class="mensaje mensaje-advertencia" role="alert">
            <strong>{{ session('warning') }}</strong>

            @if(session('errores_importacion'))
                <ul class="errores-importacion">
                    @foreach(session('errores_importacion') as $errorImportacion)
                        <li>{{ $errorImportacion }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    @endif

    {{-- ERRORES DE VALIDACIÓN --}}
    @if($errors->any())
        <div class="mensaje mensaje-error" role="alert">
            <strong>Se encontraron errores:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TABLA DE DOCENTES --}}
    <section class="tarjeta">

        <div class="barra">
            <h2>Docentes registrados</h2>

            <form
                action="{{ route('docentes.index') }}"
                method="GET"
                class="buscador"
            >
                <div class="campo-busqueda">
                    <input
                        type="text"
                        id="buscador"
                        name="buscar"
                        value="{{ $buscar }}"
                        placeholder="Buscar por nombre, empleado, correo..."
                        autocomplete="off"
                        aria-label="Buscar docentes"
                    >
                </div>

                <button type="submit" class="btn-buscar">
                    Buscar
                </button>

                @if($buscar !== '')
                    <a
                        href="{{ route('docentes.index') }}"
                        class="btn-limpiar"
                    >
                        Limpiar
                    </a>
                @endif
            </form>
        </div>

        <div class="tabla-contenedor">
            <table>
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
                        <tr>
                            <td>{{ $docente->id }}</td>

                            <td>
                                <strong>{{ $docente->numero_empleado }}</strong>
                            </td>

                            <td>
                                <div class="nombre-docente">
                                    {{ $docente->nombres }}
                                    {{ $docente->apellidos }}
                                </div>
                            </td>

                            <td>
                                <span class="correo">{{ $docente->email }}</span>
                            </td>

                            <td>
                                {{ $docente->telefono ?: 'No registrado' }}
                            </td>

                            <td>
                                @if($docente->especialidad)
                                    <span class="especialidad">
                                        {{ $docente->especialidad }}
                                    </span>
                                @else
                                    <span style="color: #9b9095;">
                                        No especificada
                                    </span>
                                @endif
                            </td>

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
                                        onsubmit="return confirm('¿Estás seguro de eliminar este docente? Esta operación no se puede deshacer.');"
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
                            <td colspan="7" class="sin-resultados">
                                @if($buscar !== '')
                                    No se encontraron docentes con esa búsqueda.
                                @else
                                    No hay docentes registrados.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="contador">
            @if($buscar !== '')
                Resultados encontrados:
            @else
                Total de docentes registrados:
            @endif

            <strong>{{ $docentes->total() }}</strong>
        </div>

        @if($docentes->hasPages())
            <div class="paginacion">
                <div class="paginacion-info">
                    Mostrando {{ $docentes->firstItem() }}
                    a {{ $docentes->lastItem() }}
                    de {{ $docentes->total() }} docentes.
                </div>

                <div class="paginacion-enlaces">
                    {{ $docentes->links() }}
                </div>
            </div>
        @endif

    </section>
</div>
</body>
</html>