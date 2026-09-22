
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

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        textarea {
            resize: vertical;
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
            display: flex;
            gap: 10px;
        }

        button,
        .cancelar {
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        button {
            background: #2563eb;
            color: white;
        }

        .cancelar {
            background: #6b7280;
            color: white;
        }

        .errores {
            background: #fee2e2;
            color: #991b1b;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<div class="contenedor">

    <h1>Editar Materia</h1>

    @if ($errors->any())
        <div class="errores">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('materias.update', $materia->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="clave">Clave de la materia</label>
        <input
            type="text"
            id="clave"
            name="clave"
            value="{{ old('clave', $materia->clave) }}"
            required
        >

        <label for="nombre">Nombre de la materia</label>
        <input
            type="text"
            id="nombre"
            name="nombre"
            value="{{ old('nombre', $materia->nombre) }}"
            required
        >

        <label for="horas_semana">Horas por semana</label>
        <input
            type="number"
            id="horas_semana"
            name="horas_semana"
            min="1"
            value="{{ old('horas_semana', $materia->horas_semana) }}"
            required
        >

        <label for="descripcion">Descripción</label>
        <textarea
            id="descripcion"
            name="descripcion"
            rows="4"
        >{{ old('descripcion', $materia->descripcion) }}</textarea>

        <label class="campo-checkbox">
            <input
                type="checkbox"
                name="activa"
                value="1"
                {{ old('activa', $materia->activa) ? 'checked' : '' }}
            >

            Materia activa
        </label>

        <div class="botones">
            <button type="submit">Actualizar materia</button>

            <a href="{{ route('materias.index') }}" class="cancelar">
                Cancelar
            </a>
        </div>
    </form>

</div>

</body>
</html>