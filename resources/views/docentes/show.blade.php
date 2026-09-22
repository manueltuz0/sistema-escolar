
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Docente</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f6f9;
        }

        .contenedor {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
        }

        h1 {
            color: #333;
        }

        .dato {
            margin: 15px 0;
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .dato strong {
            display: inline-block;
            width: 190px;
        }

        a {
            display: inline-block;
            padding: 10px 15px;
            margin-top: 20px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>

    <div class="contenedor">

        <h1>Detalles del Docente</h1>

        <div class="dato">
            <strong>ID:</strong>
            {{ $docente->id }}
        </div>

        <div class="dato">
            <strong>Número de empleado:</strong>
            {{ $docente->numero_empleado }}
        </div>

        <div class="dato">
            <strong>Nombres:</strong>
            {{ $docente->nombres }}
        </div>

        <div class="dato">
            <strong>Apellidos:</strong>
            {{ $docente->apellidos }}
        </div>

        <div class="dato">
            <strong>Correo electrónico:</strong>
            {{ $docente->email }}
        </div>

        <div class="dato">
            <strong>Teléfono:</strong>
            {{ $docente->telefono ?? 'No registrado' }}
        </div>

        <div class="dato">
            <strong>Especialidad:</strong>
            {{ $docente->especialidad ?? 'No registrada' }}
        </div>

        <a href="{{ route('docentes.index') }}">
            Regresar a la lista
        </a>

        <a href="{{ route('docentes.edit', $docente->id) }}">
            Editar docente
        </a>

    </div>

</body>
</html>