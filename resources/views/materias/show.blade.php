
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Materia</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 25px;
        }

        .dato {
            margin-bottom: 18px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .dato strong {
            display: block;
            color: #555;
            margin-bottom: 5px;
        }

        .boton {
            display: inline-block;
            padding: 10px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }

        .volver {
            background: #6b7280;
            margin-left: 8px;
        }
    </style>
</head>
<body>

<div class="contenedor">

    <h1>Detalles de la Materia</h1>

    <div class="dato">
        <strong>ID:</strong>
        {{ $materia->id }}
    </div>

    <div class="dato">
        <strong>Clave:</strong>
        {{ $materia->clave }}
    </div>

    <div class="dato">
        <strong>Nombre:</strong>
        {{ $materia->nombre }}
    </div>

    <div class="dato">
        <strong>Horas por semana:</strong>
        {{ $materia->horas_semana }}
    </div>

    <div class="dato">
        <strong>Descripción:</strong>
        {{ $materia->descripcion ?: 'Sin descripción' }}
    </div>

    <div class="dato">
        <strong>Estado:</strong>
        {{ $materia->activa ? 'Activa' : 'Inactiva' }}
    </div>

    <a href="{{ route('materias.edit', $materia->id) }}" class="boton">
        Editar materia
    </a>

    <a href="{{ route('materias.index') }}" class="boton volver">
        Regresar
    </a>

</div>

</body>
</html>