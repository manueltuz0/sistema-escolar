<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Asignación</title>

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
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .botones {
            margin-top: 25px;
        }

        .boton {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .guardar {
            background-color: #198754;
            color: white;
        }

        .regresar {
            background-color: #6c757d;
            color: white;
            margin-left: 8px;
        }

        .errores {
            background-color: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .errores ul {
            margin: 0;
            padding-left: 20px;
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Editar Asignación</h1>

    @if($errors->any())
        <div class="errores">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('asignaciones_materias.update', $asignacion->id) }}"
        method="POST">

        @csrf
        @method('PUT')

        <label for="docente_id">Docente:</label>

        <select name="docente_id" id="docente_id" required>

            <option value="">Selecciona un docente</option>

            @foreach($docentes as $docente)

                <option
                    value="{{ $docente->id }}"
                    {{ $asignacion->docente_id == $docente->id ? 'selected' : '' }}>

                    {{ $docente->nombres }}
                    {{ $docente->apellidos }}

                </option>

            @endforeach

        </select>


        <label for="materia_id">Materia:</label>

        <select name="materia_id" id="materia_id" required>

            <option value="">Selecciona una materia</option>

            @foreach($materias as $materia)

                <option
                    value="{{ $materia->id }}"
                    {{ $asignacion->materia_id == $materia->id ? 'selected' : '' }}>

                    {{ $materia->clave }}
                    -
                    {{ $materia->nombre }}

                </option>

            @endforeach

        </select>


        <label for="grupo_id">Grupo:</label>

        <select name="grupo_id" id="grupo_id" required>

            <option value="">Selecciona un grupo</option>

            @foreach($grupos as $grupo)

                <option
                    value="{{ $grupo->id }}"
                    {{ $asignacion->grupo_id == $grupo->id ? 'selected' : '' }}>

                    {{ $grupo->grado }}°
                    {{ $grupo->nombre }}

                    @if($grupo->especialidad)
                        - {{ $grupo->especialidad }}
                    @endif

                </option>

            @endforeach

        </select>


        <label for="ciclo_escolar_id">Ciclo Escolar:</label>

        <select
            name="ciclo_escolar_id"
            id="ciclo_escolar_id"
            required>

            <option value="">Selecciona un ciclo escolar</option>

            @foreach($ciclosEscolares as $ciclo)

                <option
                    value="{{ $ciclo->id }}"
                    {{ $asignacion->ciclo_escolar_id == $ciclo->id ? 'selected' : '' }}>

                    {{ $ciclo->nombre }}

                    @if($ciclo->activo)
                        (Activo)
                    @endif

                </option>

            @endforeach

        </select>


        <div class="botones">

            <button type="submit" class="boton guardar">
                Actualizar Asignación
            </button>

            <a
                href="{{ route('asignaciones_materias.index') }}"
                class="boton regresar">

                Regresar

            </a>

        </div>

    </form>

</div>

</body>
</html>