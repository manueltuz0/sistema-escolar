<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Ver Asignación</title>

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

    <h1>Detalles de la Asignación</h1>

    <div class="dato">
        <strong>ID:</strong>
        {{ $asignacion->id }}
    </div>

    <div class="dato">
        <strong>Docente:</strong>
        {{ $asignacion->docente->nombres ?? 'Sin docente' }}
        {{ $asignacion->docente->apellidos ?? '' }}
    </div>

    <div class="dato">
        <strong>Materia:</strong>
        {{ $asignacion->materia->clave ?? '' }}
        -
        {{ $asignacion->materia->nombre ?? 'Sin materia' }}
    </div>

    <div class="dato">
        <strong>Grupo:</strong>
        {{ $asignacion->grupo->nombre ?? 'Sin grupo' }}
    </div>

    <div class="dato">
        <strong>Grado:</strong>
        {{ $asignacion->grupo->grado ?? 'Sin grado' }}
    </div>

    <div class="dato">
        <strong>Especialidad:</strong>
        {{ $asignacion->grupo->especialidad ?? 'Sin especialidad' }}
    </div>

    <div class="dato">
        <strong>Ciclo Escolar:</strong>
        {{ $asignacion->cicloEscolar->nombre ?? 'Sin ciclo' }}
    </div>

    <a
        href="{{ route('asignaciones_materias.index') }}"
        class="boton regresar">
        Regresar
    </a>

    <a
        href="{{ route('asignaciones_materias.edit', $asignacion->id) }}"
        class="boton editar">
        Editar
    </a>

</div>

</body>
</html>