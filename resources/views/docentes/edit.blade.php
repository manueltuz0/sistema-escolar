<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Docente</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px 16px;
            background-color: #f4f6f9;
            color: #1f2937;
        }

        .contenedor {
            max-width: 650px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        h1 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #111827;
            font-size: 28px;
        }

        .descripcion {
            margin-bottom: 25px;
            color: #6b7280;
            line-height: 1.5;
        }

        .grupo-campo {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
            color: #374151;
        }

        .requerido {
            color: #dc2626;
        }

        input {
            display: block;
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            background-color: #ffffff;
            color: #111827;
            font-size: 15px;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        input.invalido {
            border-color: #dc2626;
        }

        .ayuda {
            display: block;
            margin-top: 5px;
            color: #6b7280;
            font-size: 13px;
        }

        .error-campo {
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        .errores-generales {
            margin-bottom: 22px;
            padding: 14px 16px;
            border: 1px solid #fecaca;
            border-radius: 7px;
            background-color: #fef2f2;
            color: #991b1b;
        }

        .errores-generales strong {
            display: block;
            margin-bottom: 7px;
        }

        .errores-generales ul {
            margin: 0;
            padding-left: 20px;
        }

        .botones {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 28px;
        }

        .boton {
            display: inline-block;
            padding: 11px 17px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .boton-actualizar {
            background-color: #2563eb;
            color: #ffffff;
        }

        .boton-actualizar:hover {
            background-color: #1d4ed8;
        }

        .boton-cancelar {
            background-color: #6b7280;
            color: #ffffff;
        }

        .boton-cancelar:hover {
            background-color: #4b5563;
        }

        .nota {
            margin-top: 22px;
            color: #6b7280;
            font-size: 13px;
        }

        @media (max-width: 480px) {
            body {
                padding: 16px 10px;
            }

            .contenedor {
                padding: 20px 16px;
            }

            h1 {
                font-size: 24px;
            }

            .botones {
                flex-direction: column;
            }

            .boton {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <main class="contenedor">

        <h1>Editar docente</h1>

        <p class="descripcion">
            Modifica la información del docente y guarda los cambios.
            Los campos marcados con <span class="requerido">*</span> son obligatorios.
        </p>

        @if ($errors->any())
            <div class="errores-generales" role="alert">
                <strong>Revisa la información del formulario:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('docentes.update', $docente->id) }}"
            method="POST"
        >
            @csrf
            @method('PUT')

            <div class="grupo-campo">
                <label for="numero_empleado">
                    Número de empleado <span class="requerido">*</span>
                </label>

                <input
                    type="text"
                    id="numero_empleado"
                    name="numero_empleado"
                    value="{{ old('numero_empleado', $docente->numero_empleado) }}"
                    maxlength="20"
                    autocomplete="off"
                    required
                    aria-invalid="{{ $errors->has('numero_empleado') ? 'true' : 'false' }}"
                    aria-describedby="error-numero_empleado"
                    class="{{ $errors->has('numero_empleado') ? 'invalido' : '' }}"
                >

                @error('numero_empleado')
                    <div class="error-campo" id="error-numero_empleado">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="grupo-campo">
                <label for="nombres">
                    Nombres <span class="requerido">*</span>
                </label>

                <input
                    type="text"
                    id="nombres"
                    name="nombres"
                    value="{{ old('nombres', $docente->nombres) }}"
                    maxlength="100"
                    autocomplete="given-name"
                    required
                    aria-invalid="{{ $errors->has('nombres') ? 'true' : 'false' }}"
                    aria-describedby="error-nombres"
                    class="{{ $errors->has('nombres') ? 'invalido' : '' }}"
                >

                @error('nombres')
                    <div class="error-campo" id="error-nombres">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="grupo-campo">
                <label for="apellidos">
                    Apellidos <span class="requerido">*</span>
                </label>

                <input
                    type="text"
                    id="apellidos"
                    name="apellidos"
                    value="{{ old('apellidos', $docente->apellidos) }}"
                    maxlength="150"
                    autocomplete="family-name"
                    required
                    aria-invalid="{{ $errors->has('apellidos') ? 'true' : 'false' }}"
                    aria-describedby="error-apellidos"
                    class="{{ $errors->has('apellidos') ? 'invalido' : '' }}"
                >

                @error('apellidos')
                    <div class="error-campo" id="error-apellidos">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="grupo-campo">
                <label for="email">
                    Correo electrónico <span class="requerido">*</span>
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $docente->email) }}"
                    maxlength="150"
                    autocomplete="email"
                    required
                    aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                    aria-describedby="error-email"
                    class="{{ $errors->has('email') ? 'invalido' : '' }}"
                >

                @error('email')
                    <div class="error-campo" id="error-email">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="grupo-campo">
                <label for="telefono">Teléfono</label>

                <input
                    type="text"
                    id="telefono"
                    name="telefono"
                    value="{{ old('telefono', $docente->telefono) }}"
                    maxlength="20"
                    autocomplete="tel"
                    aria-invalid="{{ $errors->has('telefono') ? 'true' : 'false' }}"
                    aria-describedby="error-telefono"
                    class="{{ $errors->has('telefono') ? 'invalido' : '' }}"
                >

                <span class="ayuda">Campo opcional.</span>

                @error('telefono')
                    <div class="error-campo" id="error-telefono">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="grupo-campo">
                <label for="especialidad">Especialidad</label>

                <input
                    type="text"
                    id="especialidad"
                    name="especialidad"
                    value="{{ old('especialidad', $docente->especialidad) }}"
                    maxlength="100"
                    aria-invalid="{{ $errors->has('especialidad') ? 'true' : 'false' }}"
                    aria-describedby="error-especialidad"
                    class="{{ $errors->has('especialidad') ? 'invalido' : '' }}"
                >

                <span class="ayuda">Campo opcional.</span>

                @error('especialidad')
                    <div class="error-campo" id="error-especialidad">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="botones">
                <button type="submit" class="boton boton-actualizar">
                    Actualizar docente
                </button>

                <a href="{{ route('docentes.index') }}" class="boton boton-cancelar">
                    Cancelar
                </a>
            </div>

        </form>

        <p class="nota">
            El número de empleado y el correo electrónico deben ser únicos.
        </p>

    </main>

</body>
</html>