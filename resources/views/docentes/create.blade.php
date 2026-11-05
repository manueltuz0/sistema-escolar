<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Docente</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background-color: #f4f6f9;
            color: #1f2937;
        }

        .contenedor {
            max-width: 600px;
            margin: auto;
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            color: #333;
            margin-top: 0;
        }

        .descripcion {
            color: #6b7280;
            line-height: 1.5;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            font-size: 15px;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.12);
        }

        input.invalido {
            border-color: #dc2626;
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }

        .resumen-errores {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            padding: 12px 16px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .resumen-errores ul {
            margin-bottom: 0;
            padding-left: 20px;
        }

        .ayuda {
            color: #6b7280;
            font-size: 12px;
            margin-top: 5px;
        }

        .botones {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 25px;
        }

        button,
        .btn-cancelar {
            display: inline-block;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        button {
            background-color: #2563eb;
            color: white;
        }

        button:hover {
            background-color: #1d4ed8;
        }

        .btn-cancelar {
            background-color: #6b7280;
            color: white;
        }

        .btn-cancelar:hover {
            background-color: #4b5563;
        }

        @media (max-width: 500px) {
            body {
                margin: 12px;
            }

            .contenedor {
                padding: 18px;
            }
        }
    </style>
</head>
<body>

    <div class="contenedor">

        <h1>Registrar Docente</h1>

        <p class="descripcion">
            Completa los datos del docente. Los campos marcados como obligatorios
            deben llenarse para poder guardar el registro.
        </p>

        @if ($errors->any())
            <div class="resumen-errores" role="alert">
                <strong>Revisa los siguientes errores:</strong>

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
                Número de empleado: *
            </label>

            <input
                type="text"
                id="numero_empleado"
                name="numero_empleado"
                value="{{ old('numero_empleado') }}"
                maxlength="20"
                required
                autocomplete="off"
                class="@error('numero_empleado') invalido @enderror"
                aria-invalid="{{ $errors->has('numero_empleado') ? 'true' : 'false' }}"
                aria-describedby="error_numero_empleado"
            >

            @error('numero_empleado')
                <div class="error" id="error_numero_empleado">{{ $message }}</div>
            @enderror

            <label for="nombres">
                Nombres: *
            </label>

            <input
                type="text"
                id="nombres"
                name="nombres"
                value="{{ old('nombres') }}"
                maxlength="100"
                required
                autocomplete="given-name"
                class="@error('nombres') invalido @enderror"
                aria-invalid="{{ $errors->has('nombres') ? 'true' : 'false' }}"
                aria-describedby="error_nombres"
            >

            @error('nombres')
                <div class="error" id="error_nombres">{{ $message }}</div>
            @enderror

            <label for="apellidos">
                Apellidos: *
            </label>

            <input
                type="text"
                id="apellidos"
                name="apellidos"
                value="{{ old('apellidos') }}"
                maxlength="150"
                required
                autocomplete="family-name"
                class="@error('apellidos') invalido @enderror"
                aria-invalid="{{ $errors->has('apellidos') ? 'true' : 'false' }}"
                aria-describedby="error_apellidos"
            >

            @error('apellidos')
                <div class="error" id="error_apellidos">{{ $message }}</div>
            @enderror

            <label for="email">
                Correo electrónico: *
            </label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                maxlength="150"
                required
                autocomplete="email"
                class="@error('email') invalido @enderror"
                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                aria-describedby="error_email"
            >

            @error('email')
                <div class="error" id="error_email">{{ $message }}</div>
            @enderror

            <label for="telefono">
                Teléfono (opcional):
            </label>

            <input
                type="tel"
                id="telefono"
                name="telefono"
                value="{{ old('telefono') }}"
                maxlength="20"
                autocomplete="tel"
                class="@error('telefono') invalido @enderror"
                aria-invalid="{{ $errors->has('telefono') ? 'true' : 'false' }}"
                aria-describedby="error_telefono"
            >

            @error('telefono')
                <div class="error" id="error_telefono">{{ $message }}</div>
            @enderror

            <label for="especialidad">
                Especialidad (opcional):
            </label>

            <input
                type="text"
                id="especialidad"
                name="especialidad"
                value="{{ old('especialidad') }}"
                maxlength="100"
                class="@error('especialidad') invalido @enderror"
                aria-invalid="{{ $errors->has('especialidad') ? 'true' : 'false' }}"
                aria-describedby="error_especialidad"
            >

            @error('especialidad')
                <div class="error" id="error_especialidad">{{ $message }}</div>
            @enderror

            <p class="ayuda">* Campos obligatorios.</p>

            <div class="botones">
                <button type="submit">
                    Guardar Docente
                </button>

                <a
                    href="{{ route('docentes.index') }}"
                    class="btn-cancelar"
                >
                    Cancelar
                </a>
            </div>

        </form>

    </div>

</body>
</html>