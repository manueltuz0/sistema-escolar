<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Materia</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
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

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .campo-checkbox {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 20px;
        }

        .campo-checkbox input {
            width: auto;
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

        .actualizar {
            background-color: #2563eb;
            color: white;
        }

        .cancelar {
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

    <h1>Editar Materia</h1>

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
        action="{{ route('materias.update', $materia->id) }}"
        method="POST">

        @csrf
        @method('PUT')


        {{-- CLAVE --}}
        <label for="clave">
            Clave de la materia:
        </label>

        <input
            type="text"
            name="clave"
            id="clave"
            value="{{ old('clave', $materia->clave) }}"
            placeholder="Ejemplo: MAT001"
            required
            maxlength="50">


        {{-- NOMBRE --}}
        <label for="nombre">
            Nombre de la materia:
        </label>

        <input
            type="text"
            name="nombre"
            id="nombre"
            value="{{ old('nombre', $materia->nombre) }}"
            placeholder="Ejemplo: Matemáticas"
            required
            maxlength="150">


        {{-- HORAS POR SEMANA --}}
        <label for="horas_semana">
            Horas por semana:
        </label>

        <input
            type="number"
            name="horas_semana"
            id="horas_semana"
            value="{{ old('horas_semana', $materia->horas_semana) }}"
            min="1"
            max="20"
            required>


        {{-- DESCRIPCIÓN --}}
        <label for="descripcion">
            Descripción:
        </label>

        <textarea
            name="descripcion"
            id="descripcion"
            placeholder="Descripción de la materia">{{ old('descripcion', $materia->descripcion) }}</textarea>


        {{-- SEMESTRE --}}
        <label for="semestre">
            Semestre:
        </label>

        <select
            name="semestre"
            id="semestre"
            required>

            <option value="">
                Selecciona el semestre
            </option>

            @for($i = 1; $i <= 6; $i++)

                <option
                    value="{{ $i }}"
                    {{ old('semestre', $materia->semestre) == $i ? 'selected' : '' }}>

                    {{ $i }}° semestre

                </option>

            @endfor

        </select>


        {{-- MATERIA ACTIVA --}}
        <label class="campo-checkbox">

            <input
                type="checkbox"
                name="activa"
                value="1"
                {{ old('activa', $materia->activa) ? 'checked' : '' }}>

            Materia activa

        </label>


        {{-- BOTONES --}}
        <div class="botones">

            <button
                type="submit"
                class="boton actualizar">

                Actualizar Materia

            </button>

            <a
                href="{{ route('materias.index') }}"
                class="boton cancelar">

                Cancelar

            </a>

        </div>

    </form>

</div>

</body>
</html>