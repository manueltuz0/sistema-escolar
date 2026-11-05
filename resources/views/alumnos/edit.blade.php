<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            padding: 40px 20px;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f1f2;
            color: #33252a;
        }

        .pagina {
            min-height: calc(100vh - 80px);
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .contenedor {
            width: 100%;
            max-width: 720px;
            padding: 36px 40px;
            background: #fff;
            border: 1px solid #eadde1;
            border-radius: 14px;
            box-shadow: 0 8px 30px rgba(85, 18, 37, .09);
        }

        .encabezado {
            margin-bottom: 28px;
        }

        .encabezado h1 {
            margin: 0 0 8px;
            font-size: 28px;
            color: #551225;
        }

        .encabezado p {
            margin: 0;
            color: #765f67;
            font-size: 14px;
        }

        .seccion {
            margin-top: 28px;
            padding: 22px;
            border: 1px solid #eadde1;
            border-radius: 10px;
            background: #fdfafb;
        }

        .seccion h2 {
            margin: 0 0 6px;
            font-size: 18px;
            color: #741b32;
        }

        .seccion .descripcion {
            margin: 0 0 20px;
            color: #765f67;
            font-size: 13px;
            line-height: 1.5;
        }

        .campo {
            margin-bottom: 18px;
        }

        .campo:last-child {
            margin-bottom: 0;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #551225;
        }

        input, select {
            width: 100%;
            height: 46px;
            padding: 0 13px;
            border: 1px solid #d9c2ca;
            border-radius: 8px;
            background: #fff;
            color: #33252a;
            font-size: 15px;
            outline: none;
        }

        input:focus, select:focus {
            border-color: #741b32;
            box-shadow: 0 0 0 3px rgba(116, 27, 50, .12);
        }

        select:disabled {
            background: #f0e6e9;
            color: #9b858d;
            cursor: not-allowed;
        }

        .rejilla {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 16px;
        }

        .errores {
            margin-bottom: 22px;
            padding: 14px 16px;
            border: 1px solid #e7b8c4;
            border-radius: 8px;
            background: #fff3f5;
            color: #8b1735;
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
            gap: 12px;
            margin-top: 28px;
        }

        .btn-guardar, .btn-cancelar {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-guardar {
            border: 0;
            background: #741b32;
            color: #fff;
        }

        .btn-guardar:hover {
            background: #551225;
        }

        .btn-cancelar {
            border: 1px solid #d9c2ca;
            background: #f0e6e9;
            color: #551225;
        }

        .btn-cancelar:hover {
            background: #e6d5db;
        }

        .nota {
            margin-top: 22px;
            padding-top: 16px;
            border-top: 1px solid #eadde1;
            color: #765f67;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            body {
                padding: 20px 12px;
            }

            .contenedor {
                padding: 26px 20px;
            }

            .rejilla {
                grid-template-columns: 1fr;
            }

            .acciones {
                flex-direction: column;
            }

            .btn-guardar, .btn-cancelar {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="pagina">
    <div class="contenedor">

        <div class="encabezado">
            <h1>Editar Alumno</h1>
            <p>Actualiza los datos del alumno y, si lo deseas, los de su madre, padre o tutor.</p>
        </div>

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

        @php
            $responsablePrincipal = $alumno->responsables->firstWhere('es_principal', true)
                ?? $alumno->responsables->first();
        @endphp

        <form action="{{ route('alumnos.update', $alumno->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="seccion">
                <h2>Datos del alumno</h2>
                <p class="descripcion">Información personal y escolar del alumno.</p>

                <div class="campo">
                    <label for="matricula">Matrícula</label>
                    <input
                        type="text"
                        id="matricula"
                        name="matricula"
                        value="{{ old('matricula', $alumno->matricula) }}"
                        maxlength="20"
                        required
                    >
                </div>

                <div class="rejilla">
                    <div class="campo">
                        <label for="nombres">Nombres</label>
                        <input
                            type="text"
                            id="nombres"
                            name="nombres"
                            value="{{ old('nombres', $alumno->nombres) }}"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="apellidos">Apellidos</label>
                        <input
                            type="text"
                            id="apellidos"
                            name="apellidos"
                            value="{{ old('apellidos', $alumno->apellidos) }}"
                            maxlength="150"
                            required
                        >
                    </div>
                </div>

                <div class="campo">
                    <label for="email">Correo electrónico del alumno</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $alumno->email) }}"
                        maxlength="150"
                        required
                    >
                </div>

                <div class="rejilla">
                    <div class="campo">
                        <label for="grado">Grado</label>
                        <select id="grado" name="grado" required>
                            <option value="">Selecciona un grado</option>

                            @for ($grado = 1; $grado <= 5; $grado++)
                                <option
                                    value="{{ $grado }}"
                                    {{ old('grado', $alumno->grupo->grado ?? '') == $grado ? 'selected' : '' }}
                                >
                                    {{ $grado }}°
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="campo">
                        <label for="grupo_id">Grupo</label>
                        <select id="grupo_id" name="grupo_id" required>
                            <option value="">Selecciona un grupo</option>

                            @foreach ($grupos as $grupo)
                                <option
                                    value="{{ $grupo->id }}"
                                    data-grado="{{ $grupo->grado }}"
                                    {{ old('grupo_id', $alumno->grupo_id) == $grupo->id ? 'selected' : '' }}
                                >
                                    {{ $grupo->nombre }}@if ($grupo->especialidad) - {{ $grupo->especialidad }}@endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="seccion">
                <h2>Datos de madre, padre o tutor</h2>
                <p class="descripcion">
                    Estos datos son opcionales. Puedes dejarlos vacíos si todavía no cuentas con la información del responsable.
                </p>

                <div class="campo">
                    <label for="responsable_nombre">Nombre completo</label>
                    <input
                        type="text"
                        id="responsable_nombre"
                        name="responsable_nombre"
                        value="{{ old('responsable_nombre', $responsablePrincipal->nombre ?? '') }}"
                        maxlength="150"
                        placeholder="Nombre de la madre, padre o tutor"
                    >
                </div>

                <div class="rejilla">
                    <div class="campo">
                        <label for="responsable_parentesco">Parentesco</label>
                        <select id="responsable_parentesco" name="responsable_parentesco">
                            <option value="">Selecciona parentesco</option>

                            @foreach (['Madre', 'Padre', 'Tutor', 'Tutora', 'Otro'] as $parentesco)
                                <option
                                    value="{{ $parentesco }}"
                                    {{ old('responsable_parentesco', $responsablePrincipal->parentesco ?? '') == $parentesco ? 'selected' : '' }}
                                >
                                    {{ $parentesco }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="campo">
                        <label for="responsable_telefono">Teléfono</label>
                        <input
                            type="tel"
                            id="responsable_telefono"
                            name="responsable_telefono"
                            value="{{ old('responsable_telefono', $responsablePrincipal->telefono ?? '') }}"
                            maxlength="20"
                            placeholder="Número de contacto"
                        >
                    </div>
                </div>

                <div class="campo">
                    <label for="responsable_email">Correo electrónico del responsable</label>
                    <input
                        type="email"
                        id="responsable_email"
                        name="responsable_email"
                        value="{{ old('responsable_email', $responsablePrincipal->email ?? '') }}"
                        maxlength="150"
                        placeholder="correo@ejemplo.com"
                    >
                </div>
            </div>

            <div class="acciones">
                <button type="submit" class="btn-guardar">
                    Actualizar Alumno
                </button>

                <a href="{{ route('alumnos.index') }}" class="btn-cancelar">
                    Cancelar
                </a>
            </div>

        </form>

        <div class="nota">
            Los datos del responsable no son obligatorios. La información del alumno sí debe estar completa.
        </div>

    </div>
</div>

<script>
    const gradoSelect = document.getElementById('grado');
    const grupoSelect = document.getElementById('grupo_id');

    // Conservar las opciones originales para filtrar por grado.
    const todasLasOpciones = Array.from(
        grupoSelect.querySelectorAll('option[data-grado]')
    );

    let grupoSeleccionado = @json((string) old('grupo_id', $alumno->grupo_id));

    function filtrarGrupos() {
        const gradoSeleccionado = gradoSelect.value;

        grupoSelect.innerHTML = '';

        const opcionInicial = document.createElement('option');
        opcionInicial.value = '';
        opcionInicial.textContent = gradoSeleccionado
            ? 'Selecciona un grupo'
            : 'Selecciona primero un grado';

        grupoSelect.appendChild(opcionInicial);

        if (!gradoSeleccionado) {
            grupoSelect.disabled = true;
            return;
        }

        todasLasOpciones.forEach(function (opcion) {
            if (opcion.dataset.grado === gradoSeleccionado) {
                const nuevaOpcion = opcion.cloneNode(true);
                grupoSelect.appendChild(nuevaOpcion);
            }
        });

        grupoSelect.disabled = false;

        if (grupoSeleccionado) {
            grupoSelect.value = grupoSeleccionado;
        }

        if (grupoSelect.value !== grupoSeleccionado) {
            grupoSelect.value = '';
        }
    }

    gradoSelect.addEventListener('change', function () {
        grupoSeleccionado = '';
        filtrarGrupos();
    });

    filtrarGrupos();
</script>

</body>
</html>