<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Aulas</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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

    <h1>Aulas</h1>

    <a href="{{ route('aulas.create') }}" class="boton">
        + Registrar Aula
    </a>

    @if(session('success'))
        <div class="mensaje">
            {{ session('success') }}
        </div>
    @endif

    @if($aulas->count() > 0)

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Ubicación</th>
                    <th>Capacidad</th>
                    <th>Disponible</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>

                @foreach($aulas as $aula)

                    <tr>

                        <td>{{ $aula->id }}</td>

                        <td>{{ $aula->nombre }}</td>

                        <td>
                            {{ $aula->ubicacion ?? 'Sin ubicación' }}
                        </td>

                        <td>
                            {{ $aula->capacidad ?? 'No especificada' }}
                        </td>

                        <td>
                            {{ $aula->disponible ? 'Sí' : 'No' }}
                        </td>

                        <td>

                            <a
                                href="{{ route('aulas.show', $aula->id) }}"
                                class="accion ver">
                                Ver
                            </a>

                            <a
                                href="{{ route('aulas.edit', $aula->id) }}"
                                class="accion editar">
                                Editar
                            </a>

                            <form
                                action="{{ route('aulas.destroy', $aula->id) }}"
                                method="POST"
                                onsubmit="return confirm('¿Deseas eliminar esta aula?');">

                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="accion eliminar">
                                    Eliminar
                                </button>

                            </form>

                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    @else

        <p>No hay aulas registradas.</p>

    @endif

</div>

</body>
</html>