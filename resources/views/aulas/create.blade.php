<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar Aula</title>

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

        input,
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

    <h1>Registrar Aula</h1>

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
        action="{{ route('aulas.store') }}"
        method="POST">

        @csrf

        <label for="nombre">
            Nombre del Aula:
        </label>

        <input
            type="text"
            name="nombre"
            id="nombre"
            value="{{ old('nombre') }}"
            placeholder="Ejemplo: Aula 1"
            required
            maxlength="50">


        <label for="ubicacion">
            Ubicación:
        </label>

        <input
            type="text"
            name="ubicacion"
            id="ubicacion"
            value="{{ old('ubicacion') }}"
            placeholder="Ejemplo: Edificio A - Planta baja"
            maxlength="100">


        <label for="capacidad">
            Capacidad:
        </label>

        <input
            type="number"
            name="capacidad"
            id="capacidad"
            value="{{ old('capacidad') }}"
            placeholder="Ejemplo: 40"
            min="1">


        <label for="disponible">
            ¿Está disponible?
        </label>

        <select
            name="disponible"
            id="disponible"
            required>

            <option value="1"
                {{ old('disponible', '1') == '1' ? 'selected' : '' }}>
                Sí
            </option>

            <option value="0"
                {{ old('disponible') == '0' ? 'selected' : '' }}>
                No
            </option>

        </select>


        <div class="botones">

            <button
                type="submit"
                class="boton guardar">

                Guardar Aula

            </button>

            <a
                href="{{ route('aulas.index') }}"
                class="boton regresar">

                Regresar

            </a>

        </div>

    </form>

</div>

</body>
</html>