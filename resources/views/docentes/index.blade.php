
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Docentes</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f6f9;
        }

        h1 {
            color: #333;
        }

        .btn {
            display: inline-block;
            padding: 10px 15px;
            margin-bottom: 20px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        .success {
            background-color: #d1fae5;
            color: #065f46;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2563eb;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .acciones a,
        .acciones button {
            margin-right: 5px;
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .ver {
            background-color: #16a34a;
            color: white;
        }

        .editar {
            background-color: #f59e0b;
            color: white;
        }

        .eliminar {
            background-color: #dc2626;
            color: white;
        }

        .acciones form {
            display: inline;
        }
    </style>
</head>
<body>

    <h1>Gestión de Docentes</h1>

    <a href="{{ route('docentes.create') }}" class="btn">
        Registrar Docente
    </a>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if ($docentes->count() > 0)

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Número de empleado</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Especialidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($docentes as $docente)
                    <tr>
                        <td>{{ $docente->id }}</td>
                        <td>{{ $docente->numero_empleado }}</td>
                        <td>{{ $docente->nombres }}</td>
                        <td>{{ $docente->apellidos }}</td>
                        <td>{{ $docente->email }}</td>
                        <td>{{ $docente->telefono ?? 'No registrado' }}</td>
                        <td>{{ $docente->especialidad ?? 'No registrada' }}</td>

                        <td class="acciones">
                            <a href="{{ route('docentes.show', $docente->id) }}"
                               class="ver">
                                Ver
                            </a>

                            <a href="{{ route('docentes.edit', $docente->id) }}"
                               class="editar">
                                Editar
                            </a>

                            <form action="{{ route('docentes.destroy', $docente->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('¿Deseas eliminar este docente?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="eliminar">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @else

        <p>No hay docentes registrados todavía.</p>

    @endif

</body>
</html>