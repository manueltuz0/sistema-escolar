
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Docente</title>

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

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        .botones {
            margin-top: 20px;
        }

        button, a {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        button {
            background-color: #2563eb;
            color: white;
        }

        a {
            background-color: #6b7280;
            color: white;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <div class="contenedor">

        <h1>Registrar Docente</h1>

        @if ($errors->any())
            <div class="error">
                <strong>Corrige los siguientes errores:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('docentes.store') }}" method="POST">

            @csrf

            <label for="numero_empleado">
                Número de empleado:
            </label>

            <input
                type="text"
                id="numero_empleado"
                name="numero_empleado"
                value="{{ old('numero_empleado') }}"
                maxlength="20"
                required
            >

            <label for="nombres">
                Nombres:
            </label>

            <input
                type="text"
                id="nombres"
                name="nombres"
                value="{{ old('nombres') }}"
                maxlength="100"
                required
            >

            <label for="apellidos">
                Apellidos:
            </label>

            <input
                type="text"
                id="apellidos"
                name="apellidos"
                value="{{ old('apellidos') }}"
                maxlength="150"
                required
            >

            <label for="email">
                Correo electrónico:
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                maxlength="150"
                required
            >

            <label for="telefono">
                Teléfono (opcional):
            </label>

            <input
                type="text"
                id="telefono"
                name="telefono"
                value="{{ old('telefono') }}"
                maxlength="20"
            >

            <label for="especialidad">
                Especialidad (opcional):
            </label>

            <input
                type="text"
                id="especialidad"
                name="especialidad"
                value="{{ old('especialidad') }}"
                maxlength="100"
            >

            <div class="botones">
                <button type="submit">
                    Guardar Docente
                </button>

                <a href="{{ route('docentes.index') }}">
                    Cancelar
                </a>
            </div>

        </form>

    </div>

</body>
</html>