<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Asignaciones de Materias</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            background-color: #198754;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .boton:hover {
            background-color: #146c43;
        }

        .mensaje {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #198754;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .accion {
            display: inline-block;
            padding: 6px 10px;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .ver {
            background-color: #0d6efd;
        }

        .editar {
            background-color: #ffc107;
            color: black;
        }

        .eliminar {
            background-color: #dc3545;
            border: none;
            cursor: pointer;
        }

        form {
            display: inline;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Asignaciones de Materias</h1>

    <a href="{{ route('asignaciones_materias.create') }}" class="boton">
        + Registrar Asignación
    </a>

    @if(session('success'))
        <div class="mensaje">
            {{ session('success') }}
        </div>
    @endif

    @if($asignaciones->count() > 0)

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Docente</th>
                    <th>Materia</th>
                    <th>Grupo</th>
                    <th>Grado</th>
                    <th>Ciclo Escolar</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($asignaciones as $asignacion)

                    <tr>
                        <td>{{ $asignacion->id }}</td>

                        <td>
                            {{ $asignacion->docente->nombres ?? 'Sin docente' }}
                            {{ $asignacion->docente->apellidos ?? '' }}
                        </td>

                        <td>
                            {{ $asignacion->materia->nombre ?? 'Sin materia' }}
                        </td>

                        <td>
                            {{ $asignacion->grupo->nombre ?? 'Sin grupo' }}
                        </td>

                        <td>
                            {{ $asignacion->grupo->grado ?? 'Sin grado' }}
                        </td>

                        <td>
                            {{ $asignacion->cicloEscolar->nombre ?? 'Sin ciclo' }}
                        </td>

                        <td>
                            <a
                                href="{{ route('asignaciones_materias.show', $asignacion->id) }}"
                                class="accion ver">
                                Ver
                            </a>

                            <a
                                href="{{ route('asignaciones_materias.edit', $asignacion->id) }}"
                                class="accion editar">
                                Editar
                            </a>

                            <form
                                action="{{ route('asignaciones_materias.destroy', $asignacion->id) }}"
                                method="POST"
                                onsubmit="return confirm('¿Deseas eliminar esta asignación?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="accion eliminar">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>

    @else

        <p>No hay asignaciones de materias registradas.</p>

    @endif

</div>

</body>
</html>