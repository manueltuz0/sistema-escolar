
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Alumno</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
            background-color: #f4f6f9;
        }

        .contenedor {
            max-width: 500px;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .campo {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 6px;
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

        button {
            background-color: #2563eb;
            color: white;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            display: inline-block;
            margin-top: 15px;
        }

        .errores {
            color: #b91c1c;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="contenedor">

        <h1>Editar Alumno</h1>

        @if ($errors->any())
            <div class="errores">
                <strong>Se encontraron errores:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('alumnos.update', $alumno->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="campo">
                <label for="matricula">Matrícula:</label>

                <input
                    type="text"
                    id="matricula"
                    name="matricula"
                    value="{{ old('matricula', $alumno->matricula) }}"
                    required
                >
            </div>

            <div class="campo">
                <label for="nombres">Nombres:</label>

                <input
                    type="text"
                    id="nombres"
                    name="nombres"
                    value="{{ old('nombres', $alumno->nombres) }}"
                    required
                >
            </div>

            <div class="campo">
                <label for="apellidos">Apellidos:</label>

                <input
                    type="text"
                    id="apellidos"
                    name="apellidos"
                    value="{{ old('apellidos', $alumno->apellidos) }}"
                    required
                >
            </div>

            <div class="campo">
                <label for="email">Correo electrónico:</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $alumno->email) }}"
                    required
                >
            </div>

            <div class="campo">
                <label for="grado">Grado:</label>

                <select id="grado" name="grado" required>
                    <option value="">Selecciona un grado</option>

                    @for ($grado = 1; $grado <= 5; $grado++)
                        <option
                            value="{{ $grado }}"
                            {{ old('grado', $alumno->grupo->grado ?? '') == $grado ? 'selected' : '' }}
                        >
                            {{ $grado }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="campo">
                <label for="grupo_id">Grupo:</label>

                <select id="grupo_id" name="grupo_id" required>
                    <option value="">Selecciona un grupo</option>

                    @foreach ($grupos as $grupo)
                        <option
                            value="{{ $grupo->id }}"
                            data-grado="{{ $grupo->grado }}"
                            {{ old('grupo_id', $alumno->grupo_id) == $grupo->id ? 'selected' : '' }}
                        >
                            {{ $grupo->nombre }} - {{ $grupo->especialidad }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit">Actualizar Alumno</button>

        </form>

        <a href="{{ route('alumnos.index') }}">
            Regresar a alumnos
        </a>

    </div>

    <script>
        const gradoSelect = document.getElementById('grado');
        const grupoSelect = document.getElementById('grupo_id');

        const todasLasOpciones = Array.from(
            grupoSelect.querySelectorAll('option[data-grado]')
        );

        const grupoSeleccionadoInicial = "{{ old('grupo_id', $alumno->grupo_id) }}";

        function filtrarGrupos() {
            const gradoSeleccionado = gradoSelect.value;

            grupoSelect.innerHTML = '';

            const opcionInicial = document.createElement('option');
            opcionInicial.value = '';
            opcionInicial.textContent = 'Selecciona un grupo';
            grupoSelect.appendChild(opcionInicial);

            todasLasOpciones.forEach(function (opcion) {
                if (opcion.dataset.grado === gradoSeleccionado) {
                    const nuevaOpcion = opcion.cloneNode(true);

                    if (nuevaOpcion.value === grupoSeleccionadoInicial) {
                        nuevaOpcion.selected = true;
                    }

                    grupoSelect.appendChild(nuevaOpcion);
                }
            });

            grupoSelect.disabled = gradoSeleccionado === '';
        }

        gradoSelect.addEventListener('change', function () {
            grupoSeleccionadoInicial = '';
            filtrarGrupos();
        });

        filtrarGrupos();
    </script>

</body>
</html>