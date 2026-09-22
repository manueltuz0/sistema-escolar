
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Alumno</title>

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

        button:hover {
            background-color: #1d4ed8;
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

        <h1>Registrar Alumno</h1>

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

        <form action="{{ route('alumnos.store') }}" method="POST">
            @csrf

            <div class="campo">
                <label for="matricula">Matrícula:</label>

                <input
                    type="text"
                    id="matricula"
                    name="matricula"
                    value="{{ old('matricula') }}"
                    required
                >
            </div>

            <div class="campo">
                <label for="nombres">Nombres:</label>

                <input
                    type="text"
                    id="nombres"
                    name="nombres"
                    value="{{ old('nombres') }}"
                    required
                >
            </div>

            <div class="campo">
                <label for="apellidos">Apellidos:</label>

                <input
                    type="text"
                    id="apellidos"
                    name="apellidos"
                    value="{{ old('apellidos') }}"
                    required
                >
            </div>

            <div class="campo">
                <label for="email">Correo electrónico:</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

            <div class="campo">
                <label for="grado">Grado:</label>

                <select id="grado" name="grado" required>
                    <option value="">Selecciona un grado</option>

                    @for ($grado = 1; $grado <= 5; $grado++)
                        <option value="{{ $grado }}">
                            {{ $grado }}
                        </option>
                    @endfor
                </select>
            </div>

            <div class="campo">
                <label for="grupo_id">Grupo:</label>

                <select id="grupo_id" name="grupo_id" required disabled>
                    <option value="">Selecciona primero un grado</option>

                    @foreach ($grupos as $grupo)
                        <option
                            value="{{ $grupo->id }}"
                            data-grado="{{ $grupo->grado }}"
                        >
                            {{ $grupo->nombre }} - {{ $grupo->especialidad }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit">Guardar Alumno</button>

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

        gradoSelect.addEventListener('change', function () {

            const gradoSeleccionado = this.value;

            grupoSelect.innerHTML = '';

            const opcionInicial = document.createElement('option');

            opcionInicial.value = '';
            opcionInicial.textContent = 'Selecciona un grupo';

            grupoSelect.appendChild(opcionInicial);

            if (gradoSeleccionado === '') {
                grupoSelect.disabled = true;
                return;
            }

            todasLasOpciones.forEach(function (opcion) {

                if (opcion.dataset.grado === gradoSeleccionado) {
                    grupoSelect.appendChild(opcion.cloneNode(true));
                }

            });

            grupoSelect.disabled = false;
        });
    </script>

</body>
</html>