<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Alumnos</title>
</head>
<body>

    <h1>Gestión de Alumnos</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <a href="{{ route('alumnos.create') }}">Registrar Alumno</a>

    <br><br>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Matrícula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Grado</th>
                <th>Grupo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($alumnos as $alumno)
                <tr>
                    <td>{{ $alumno->id }}</td>
                    <td>{{ $alumno->matricula }}</td>
                    <td>{{ $alumno->nombres }}</td>
                    <td>{{ $alumno->apellidos }}</td>
                    <td>{{ $alumno->email }}</td>
                    <td>{{ $alumno->grupo->grado ?? 'Sin grado' }}</td>
                    <td>{{ $alumno->grupo->nombre ?? 'Sin grupo' }}</td>

                    <td>
                        <a href="{{ route('alumnos.edit', $alumno->id) }}">
                            Editar
                        </a>

                        <form
                            action="{{ route('alumnos.destroy', $alumno->id) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('¿Seguro que deseas eliminar este alumno?');"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay alumnos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>