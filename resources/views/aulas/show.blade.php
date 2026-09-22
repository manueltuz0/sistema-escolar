<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ver Aula</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 30px;
        }

        .contenedor {
            max-width: 650px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            color: #333;
        }

        .dato {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .dato strong {
            display: inline-block;
            width: 160px;
        }

        .boton {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .regresar {
            background-color: #6c757d;
        }

        .editar {
            background-color: #ffc107;
            color: black;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Detalles del Aula</h1>

    <div class="dato">
        <strong>ID:</strong>
        {{ $aula->id }}
    </div>

    <div class="dato">
        <strong>Nombre:</strong>
        {{ $aula->nombre }}
    </div>

    <div class="dato">
        <strong>Ubicación:</strong>
        {{ $aula->ubicacion ?? 'Sin ubicación' }}
    </div>

    <div class="dato">
        <strong>Capacidad:</strong>
        {{ $aula->capacidad ?? 'No especificada' }}
    </div>

    <div class="dato">
        <strong>Disponible:</strong>
        {{ $aula->disponible ? 'Sí' : 'No' }}
    </div>

    <a
        href="{{ route('aulas.index') }}"
        class="boton regresar">
        Regresar
    </a>

    <a
        href="{{ route('aulas.edit', $aula->id) }}"
        class="boton editar">
        Editar
    </a>

</div>

</body>
</html>