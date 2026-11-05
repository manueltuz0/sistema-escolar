<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias | Sistema Escolar</title>

    <style>
        :root {
            --vino: #721c32;
            --vino-oscuro: #501224;
            --vino-claro: #f8edf0;
            --blanco: #ffffff;
            --fondo: #f5f5f7;
            --texto: #29252a;
            --borde: #e5dce0;
            --verde: #176b45;
            --rojo: #b42332;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: var(--fondo);
            color: var(--texto);
        }

        .contenedor {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 28px;
            background: var(--blanco);
            border: 1px solid var(--borde);
            border-radius: 14px;
            box-shadow: 0 5px 20px rgba(80, 18, 36, 0.07);
        }

        .encabezado {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 18px;
            margin-bottom: 25px;
            padding-bottom: 20px;
            border-bottom: 2px solid var(--vino-claro);
        }

        .encabezado h1 {
            margin: 0 0 7px;
            color: var(--vino);
            font-size: 28px;
        }

        .subtitulo {
            margin: 0;
            color: #777078;
            font-size: 14px;
        }

        .boton {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px 17px;
            border: none;
            border-radius: 7px;
            background: var(--vino);
            color: var(--blanco);
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, transform 0.2s;
        }

        .boton:hover {
            background: var(--vino-oscuro);
            transform: translateY(-1px);
        }

        .mensaje {
            margin-bottom: 20px;
            padding: 14px 16px;
            border: 1px solid #b8dfc9;
            border-radius: 8px;
            background: #edf8f1;
            color: #176b45;
        }

        .resumen {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 16px;
            color: #69616a;
            font-size: 14px;
        }

        .contador {
            padding: 7px 12px;
            border-radius: 20px;
            background: var(--vino-claro);
            color: var(--vino);
            font-weight: bold;
        }

        .tabla-contenedor {
            width: 100%;
            overflow-x: auto;
            border: 1px solid var(--borde);
            border-radius: 9px;
        }

        table {
            width: 100%;
            min-width: 750px;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px 12px;
            border-bottom: 1px solid var(--borde);
            text-align: left;
            vertical-align: middle;
        }

        th {
            background: var(--vino);
            color: var(--blanco);
            font-size: 13px;
            font-weight: bold;
            white-space: nowrap;
        }

        td {
            font-size: 14px;
            line-height: 1.5;
        }

        tbody tr:nth-child(even) {
            background: #fcf9fa;
        }

        tbody tr:hover {
            background: var(--vino-claro);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        .nombre-materia {
            color: var(--vino);
            font-weight: bold;
        }

        .semestre {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: var(--vino-claro);
            color: var(--vino);
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .acciones {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .accion {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 10px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
        }

        .ver {
            background: var(--vino);
        }

        .editar {
            background: #eee4e8;
            color: var(--vino);
        }

        .eliminar {
            background: var(--rojo);
        }

        .ver:hover {
            background: var(--vino-oscuro);
        }

        .editar:hover {
            background: #dfcbd3;
        }

        .eliminar:hover {
            background: #8f1725;
        }

        .form-eliminar {
            display: inline;
            margin: 0;
        }

        .vacio {
            padding: 35px 15px;
            text-align: center;
            color: #777078;
        }

        .vacio strong {
            display: block;
            margin-bottom: 8px;
            color: var(--vino);
            font-size: 17px;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }

            .contenedor {
                padding: 17px;
            }

            .encabezado h1 {
                font-size: 23px;
            }

            .boton {
                width: 100%;
            }
        }
    </style>
</head>

<body>
<div class="contenedor">

    <header class="encabezado">
        <div>
            <h1>Materias</h1>
            <p class="subtitulo">
                Consulta y administra las materias del sistema escolar.
            </p>
        </div>

        <a href="{{ route('materias.create') }}" class="boton">
            + Registrar materia
        </a>
    </header>

    @if(session('success'))
        <div class="mensaje" role="status">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mensaje" role="alert"
             style="background:#fff0f0;color:#a11b2b;border-color:#efc3c7;">
            {{ session('error') }}
        </div>
    @endif

    <div class="resumen">
        <span>Listado de materias registradas</span>
        <span class="contador">
            Total: {{ $materias->count() }}
        </span>
    </div>

    @if($materias->count() > 0)

        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Clave</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Semestre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($materias as $materia)
                        <tr>
                            <td>{{ $materia->id }}</td>

                            <td>
                                {{ $materia->clave ?: 'Sin clave' }}
                            </td>

                            <td class="nombre-materia">
                                {{ $materia->nombre }}
                            </td>

                            <td>
                                {{ $materia->descripcion ?: 'Sin descripción' }}
                            </td>

                            <td>
                                <span class="semestre">
                                    {{ $materia->semestre }}° semestre
                                </span>
                            </td>

                            <td>
                                <div class="acciones">
                                    <a
                                        href="{{ route('materias.show', $materia->id) }}"
                                        class="accion ver">
                                        Ver
                                    </a>

                                    <a
                                        href="{{ route('materias.edit', $materia->id) }}"
                                        class="accion editar">
                                        Editar
                                    </a>

                                    <form
                                        class="form-eliminar"
                                        action="{{ route('materias.destroy', $materia->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Deseas eliminar esta materia? Si tiene asignaciones registradas, el sistema impedirá eliminarla.');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="accion eliminar">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @else
        <div class="vacio">
            <strong>No hay materias registradas</strong>
            Utiliza el botón «Registrar materia» para agregar la primera.
        </div>
    @endif

</div>
</body>
</html>