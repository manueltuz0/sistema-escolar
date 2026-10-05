<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Registrar Alumno</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, Helvetica, sans-serif;
            background: #f3f4f6;
            color: #1f2937;
        }

        .pagina {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .contenedor {
            width: 100%;
            max-width: 620px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
            padding: 36px 40px;
        }

        .encabezado {
            margin-bottom: 30px;
        }

        .encabezado h1 {
            margin: 0 0 8px;
            font-size: 30px;
            color: #111827;
        }

        .encabezado p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .campo {
            margin-bottom: 20px;
        }

        .campo label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .campo input,
        .campo select {
            width: 100%;
            height: 48px;
            padding: 0 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #1f2937;
            font-size: 15px;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .campo input:focus,
        .campo select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .campo select:disabled {
            background: #f3f4f6;
            color: #9ca3af;
            cursor: not-allowed;
        }

        .errores {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
            border-radius: 8px;
            padding: 14px 16px;
            margin-bottom: 24px;
            font-size: 14px;
        }

        .errores strong {
            display: block;
            margin-bottom: 8px;
        }

        .errores ul {
            margin: 0;
            padding-left: 20px;
        }

        .acciones {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
        }

        .btn-guardar {
            border: none;
            background: #2563eb;
            color: white;
            padding: 12px 22px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
        }

        .btn-guardar:hover {
            background: #1d4ed8;
        }

        .btn-guardar:active {
            transform: translateY(1px);
        }

        .btn-cancelar {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            background: #ffffff;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-cancelar:hover {
            background: #f3f4f6;
        }

        .nota {
            margin-top: 24px;
            padding-top: 18px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            .pagina {
                padding: 20px 12px;
            }

            .contenedor {
                padding: 28px 22px;
            }

            .encabezado h1 {
                font-size: 25px;
            }

            .acciones {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-guardar,
            .btn-cancelar {
                text-align: center;
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="pagina">

    <div class="contenedor">

        <div class="encabezado">
            <h1>Registrar Alumno</h1>
            <p>Ingresa los datos del alumno para registrarlo en el sistema escolar.</p>
        </div>

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="errores">
                <strong>Se encontraron los siguientes errores:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('alumnos.store') }}" method="POST">
            @csrf

            {{-- Matrícula --}}
            <div class="campo">
                <label for="matricula">
                    Matrícula
                </label>

                <input
                    type="text"
                    id="matricula"
                    name="matricula"
                    value="{{ old('matricula') }}"
                    placeholder="Ej. 22080109"
                    required
                >
            </div>

            {{-- Nombres --}}
            <div class="campo">
                <label for="nombres">
                    Nombres
                </label>

                <input
                    type="text"
                    id="nombres"
                    name="nombres"
                    value="{{ old('nombres') }}"
                    placeholder="Ingresa los nombres"
                    required
                >
            </div>

            {{-- Apellidos --}}
            <div class="campo">
                <label for="apellidos">
                    Apellidos
                </label>

                <input
                    type="text"
                    id="apellidos"
                    name="apellidos"
                    value="{{ old('apellidos') }}"
                    placeholder="Ingresa los apellidos"
                    required
                >
            </div>

            {{-- Correo --}}
            <div class="campo">
                <label for="email">
                    Correo electrónico
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="ejemplo@correo.com"
                    required
                >
            </div>

            {{-- Grado --}}
            <div class="campo">
                <label for="grado">
                    Grado
                </label>

                <select id="grado" name="grado" required>
                    <option value="">
                        Selecciona un grado
                    </option>

                    @for ($grado = 1; $grado <= 5; $grado++)
                        <option
                            value="{{ $grado }}"
                            {{ old('grado') == $grado ? 'selected' : '' }}
                        >
                            {{ $grado }}°
                        </option>
                    @endfor
                </select>
            </div>

            {{-- Grupo --}}
            <div class="campo">
                <label for="grupo_id">
                    Grupo
                </label>

                <select
                    id="grupo_id"
                    name="grupo_id"
                    required
                    disabled
                >
                    <option value="">
                        Selecciona primero un grado
                    </option>

                    @foreach ($grupos as $grupo)
                        <option
                            value="{{ $grupo->id }}"
                            data-grado="{{ $grupo->grado }}"
                            {{ old('grupo_id') == $grupo->id ? 'selected' : '' }}
                        >
                            {{ $grupo->nombre }}
                            @if ($grupo->especialidad)
                                - {{ $grupo->especialidad }}
                            @endif
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Botones --}}
            <div class="acciones">

                <button
                    type="submit"
                    class="btn-guardar"
                >
                    Guardar Alumno
                </button>

                <a
                    href="{{ route('alumnos.index') }}"
                    class="btn-cancelar"
                >
                    Cancelar
                </a>

            </div>

        </form>

        <div class="nota">
            Los campos marcados son necesarios para registrar correctamente al alumno.
        </div>

    </div>

</div>


<script>

    const gradoSelect = document.getElementById('grado');
    const grupoSelect = document.getElementById('grupo_id');

    // Guardamos todas las opciones originales
    const todasLasOpciones = Array.from(
        grupoSelect.querySelectorAll('option[data-grado]')
    );

    function actualizarGrupos() {

        const gradoSeleccionado = gradoSelect.value;

        // Limpiar grupos
        grupoSelect.innerHTML = '';

        // Opción inicial
        const opcionInicial = document.createElement('option');

        opcionInicial.value = '';
        opcionInicial.textContent = gradoSeleccionado
            ? 'Selecciona un grupo'
            : 'Selecciona primero un grado';

        grupoSelect.appendChild(opcionInicial);

        // Si no hay grado seleccionado
        if (gradoSeleccionado === '') {
            grupoSelect.disabled = true;
            return;
        }

        // Agregar solamente los grupos del grado seleccionado
        todasLasOpciones.forEach(function (opcion) {

            if (opcion.dataset.grado === gradoSeleccionado) {

                grupoSelect.appendChild(
                    opcion.cloneNode(true)
                );

            }

        });

        grupoSelect.disabled = false;

        // Recuperar grupo seleccionado anteriormente
        const grupoAnterior = "{{ old('grupo_id') }}";

        if (grupoAnterior !== '') {
            grupoSelect.value = grupoAnterior;
        }
    }

    gradoSelect.addEventListener(
        'change',
        actualizarGrupos
    );

    // Ejecutar al cargar la página si existe un grado anterior
    if (gradoSelect.value !== '') {
        actualizarGrupos();
    }

</script>

</body>
</html>