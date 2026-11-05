<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Alumno</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 15px;
            font-family: Arial, sans-serif;
            background: #f5f1f2;
            color: #33252a;
        }

        .contenedor {
            max-width: 850px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 14px;
            border: 1px solid #eadde1;
            box-shadow: 0 6px 22px rgba(85, 18, 37, .09);
        }

        h1 {
            margin: 0;
            color: #551225;
            font-size: 27px;
        }

        .seccion {
            margin-top: 28px;
            padding: 22px;
            background: #fff;
            border: 1px solid #eadde1;
            border-radius: 11px;
        }

        .seccion h2 {
            margin: 0 0 18px;
            font-size: 19px;
            color: #741b32;
        }

        .datos {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .dato {
            min-width: 0;
            padding: 13px;
            background: #faf7f8;
            border: 1px solid #f0e6e9;
            border-radius: 8px;
        }

        .dato strong {
            display: block;
            margin-bottom: 6px;
            color: #7b626a;
            font-size: 13px;
        }

        .dato span {
            overflow-wrap: anywhere;
            color: #33252a;
        }

        .responsable {
            margin-bottom: 15px;
            padding: 16px;
            background: #fdfafb;
            border-radius: 9px;
            border: 1px solid #eadde1;
        }

        .principal {
            display: inline-block;
            margin-bottom: 12px;
            padding: 6px 10px;
            color: #ffffff;
            background: #741b32;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: .4px;
        }

        .acciones {
            display: flex;
            gap: 12px;
            margin-top: 25px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 11px 18px;
            border-radius: 7px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: background .2s ease, transform .2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn-editar {
            background: #741b32;
            color: #ffffff;
        }

        .btn-editar:hover {
            background: #551225;
        }

        .btn-regresar {
            background: #f0e6e9;
            color: #551225;
        }

        .btn-regresar:hover {
            background: #e6d5db;
        }

        .vacio {
            margin: 0;
            padding: 14px;
            color: #765f67;
            background: #faf7f8;
            border: 1px dashed #d9c2ca;
            border-radius: 8px;
            font-size: 14px;
        }

        @media (max-width: 600px) {
            body {
                padding: 18px 10px;
            }

            .datos {
                grid-template-columns: 1fr;
            }

            .contenedor {
                padding: 20px;
            }

            .seccion {
                padding: 16px;
            }

            h1 {
                font-size: 23px;
            }
        }
    </style>
</head>

<body>

<div class="contenedor">

    <h1>Información del Alumno</h1>

    <div class="seccion">
        <h2>Datos del alumno</h2>

        <div class="datos">

            <div class="dato">
                <strong>Matrícula</strong>
                <span>{{ $alumno->matricula }}</span>
            </div>

            <div class="dato">
                <strong>Nombre completo</strong>
                <span>{{ $alumno->nombres }} {{ $alumno->apellidos }}</span>
            </div>

            <div class="dato">
                <strong>Correo electrónico</strong>
                <span>{{ $alumno->email }}</span>
            </div>

            <div class="dato">
                <strong>Grado</strong>
                <span>{{ $alumno->grupo->grado ?? 'Sin asignar' }}</span>
            </div>

            <div class="dato">
                <strong>Grupo</strong>
                <span>{{ $alumno->grupo->nombre ?? 'Sin asignar' }}</span>
            </div>

        </div>
    </div>

    <div class="seccion">
        <h2>Datos de madre, padre o tutor</h2>

        @forelse ($alumno->responsables as $responsable)

            <div class="responsable">

                @if ($responsable->es_principal)
                    <div class="principal">CONTACTO PRINCIPAL</div>
                @endif

                <div class="datos">

                    <div class="dato">
                        <strong>Nombre</strong>
                        <span>{{ $responsable->nombre }}</span>
                    </div>

                    <div class="dato">
                        <strong>Parentesco</strong>
                        <span>{{ $responsable->parentesco }}</span>
                    </div>

                    <div class="dato">
                        <strong>Correo electrónico</strong>
                        <span>{{ $responsable->email ?: 'No registrado' }}</span>
                    </div>

                    <div class="dato">
                        <strong>Teléfono</strong>
                        <span>{{ $responsable->telefono ?: 'No registrado' }}</span>
                    </div>

                </div>
            </div>

        @empty
            <p class="vacio">
                Este alumno todavía no tiene datos de madre, padre o tutor registrados.
            </p>
        @endforelse

    </div>

    <div class="acciones">

        <a href="{{ route('alumnos.edit', $alumno->id) }}"
           class="btn btn-editar">
            Editar alumno
        </a>

        <a href="{{ route('alumnos.index') }}"
           class="btn btn-regresar">
            Regresar a alumnos
        </a>

    </div>

</div>

</body>
</html>