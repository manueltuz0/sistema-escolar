<x-app-layout>
    <style>
        .alumnos-page {
            max-width: 1500px;
            margin: 0 auto;
            padding: 30px 24px;
            color: #35111d;
        }

        .alumnos-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 26px 30px;
            margin-bottom: 25px;
            border-radius: 16px;
            color: #fff;
            background: linear-gradient(135deg, #5b1729, #8b2942);
            box-shadow: 0 8px 24px rgba(91, 23, 41, .16);
        }

        .alumnos-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 750;
            line-height: 1.3;
        }

        .alumnos-header p {
            margin: 8px 0 0;
            color: #f7e8ed;
            font-size: 14px;
        }

        .alumnos-header-acciones {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-registrar,
        .btn-exportar {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px 18px;
            border: 1px solid rgba(255,255,255,.35);
            border-radius: 9px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            transition: .2s;
        }

        .btn-registrar {
            background: #fff;
            color: #751f35;
        }

        .btn-registrar:hover {
            background: #f8e9ee;
            transform: translateY(-1px);
        }

        .btn-exportar {
            background: #198754;
            color: #fff;
        }

        .btn-exportar:hover {
            background: #146c43;
            color: #fff;
            transform: translateY(-1px);
        }

        .mensaje {
            padding: 14px 18px;
            margin-bottom: 20px;
            border: 1px solid #b7e4c7;
            border-radius: 10px;
            background: #e7f7ed;
            color: #17643a;
        }

        .alumnos-card {
            overflow: hidden;
            border: 1px solid #eadde1;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(40,20,25,.06);
        }

        .alumnos-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 22px 24px;
            border-bottom: 1px solid #eadde1;
        }

        .alumnos-toolbar h2 {
            margin: 0;
            color: #35111d;
            font-size: 19px;
            font-weight: 700;
        }

        .subtitulo-tabla {
            margin: 5px 0 0;
            color: #82747a;
            font-size: 13px;
        }

        .buscador {
            position: relative;
            width: min(100%, 360px);
        }

        .buscador input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1px solid #ddcbd1;
            border-radius: 9px;
            background: #fff;
            color: #35111d;
            font-size: 14px;
            outline: none;
        }

        .buscador input:focus {
            border-color: #8b2942;
            box-shadow: 0 0 0 3px rgba(139,41,66,.12);
        }

        .icono-busqueda {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #8b2942;
            pointer-events: none;
        }

        .tabla-contenedor {
            width: 100%;
            overflow-x: auto;
        }

        .tabla-alumnos {
            width: 100%;
            border-collapse: collapse;
        }

        .tabla-alumnos thead {
            background: #751f35;
            color: #fff;
        }

        .tabla-alumnos th {
            padding: 15px 14px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .035em;
            white-space: nowrap;
        }

        .tabla-alumnos td {
            padding: 15px 14px;
            border-bottom: 1px solid #f0e7ea;
            color: #51464a;
            font-size: 13px;
            vertical-align: middle;
        }

        .tabla-alumnos tbody tr {
            transition: background .15s;
        }

        .tabla-alumnos tbody tr:hover {
            background: #fcf5f7;
        }

        .tabla-alumnos tbody tr:last-child td {
            border-bottom: none;
        }

        .id-alumno {
            color: #8b2942;
            font-weight: 700;
        }

        .matricula {
            display: inline-block;
            padding: 5px 8px;
            border-radius: 6px;
            background: #f7edf0;
            color: #751f35;
            font-weight: 700;
            white-space: nowrap;
        }

        .nombre-alumno {
            color: #35111d;
            font-weight: 700;
        }

        .correo {
            color: #6b6266;
        }

        .etiqueta {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .etiqueta-grado {
            background: #f5e5ea;
            color: #751f35;
        }

        .etiqueta-grupo {
            background: #f1f0f1;
            color: #51464a;
        }

        .acciones {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-accion {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 10px;
            border: none;
            border-radius: 6px;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        .btn-ver {
            background: #751f35;
        }

        .btn-ver:hover {
            background: #591527;
        }

        .btn-editar {
            background: #a76512;
        }

        .btn-editar:hover {
            background: #85500d;
        }

        .btn-eliminar {
            background: #b42336;
        }

        .btn-eliminar:hover {
            background: #8f1929;
        }

        .form-eliminar {
            display: inline;
            margin: 0;
        }

        .sin-resultados {
            display: none;
            padding: 35px 20px;
            text-align: center;
            color: #82747a;
        }

        .estado-vacio {
            padding: 40px 20px !important;
            text-align: center;
            color: #82747a !important;
        }

        .contador {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 15px 24px;
            border-top: 1px solid #eadde1;
            background: #fdfafb;
            color: #74666c;
            font-size: 13px;
        }

        .contador strong {
            color: #751f35;
        }

        @media (max-width: 850px) {
            .alumnos-page {
                padding: 20px 14px;
            }

            .alumnos-header {
                align-items: flex-start;
                flex-direction: column;
                padding: 22px;
            }

            .alumnos-header h1 {
                font-size: 24px;
            }

            .alumnos-header-acciones {
                justify-content: flex-start;
                width: 100%;
            }

            .alumnos-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .buscador {
                width: 100%;
            }
        }

        @media (max-width: 480px) {
            .alumnos-header-acciones {
                align-items: stretch;
                flex-direction: column;
            }

            .btn-registrar,
            .btn-exportar {
                width: 100%;
            }

            .contador {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="alumnos-page">

        {{-- ENCABEZADO --}}
        <header class="alumnos-header">
            <div>
                <h1>Gestión de Alumnos</h1>
                <p>Administra y consulta la información de los alumnos registrados.</p>
            </div>

            <div class="alumnos-header-acciones">
                <a href="{{ route('alumnos.exportar') }}"
                   class="btn-exportar">
                    <span aria-hidden="true">↓</span>
                    Exportar a Excel
                </a>
                
{{-- Formulario para importar alumnos desde Excel --}}
<div style="background:#fff; border:1px solid #eadde1; border-radius:12px; padding:18px; margin-bottom:20px;">
    <h3 style="color:#711b32; font-size:17px; font-weight:700; margin-bottom:8px;">
        Importar alumnos desde Excel
    </h3>

    <p style="color:#6b6064; font-size:13px; margin-bottom:14px;">
        Selecciona el archivo Excel con los alumnos de los seis semestres.
    </p>

    <form action="{{ route('alumnos.importar') }}"
          method="POST"
          enctype="multipart/form-data"
          style="display:flex; flex-wrap:wrap; align-items:center; gap:12px;">
        @csrf

        <input
            type="file"
            name="archivo"
            accept=".xlsx,.xls,.csv"
            required
            style="max-width:100%; border:1px solid #ddd; border-radius:7px; padding:8px;"
        >

        <button
            type="submit"
            style="background:#711b32; color:white; border:0; border-radius:7px; padding:10px 16px; font-weight:700; cursor:pointer;"
        >
            Importar Excel
        </button>
    </form>

    @error('archivo')
        <p style="color:#b42335; font-size:13px; margin-top:10px;">
            {{ $message }}
        </p>
    @enderror
</div>

@if (session('errores_importacion'))
    <div style="background:#fff8e8; border:1px solid #ead39a; border-radius:8px; padding:14px; margin-bottom:18px;">
        <strong style="color:#805500;">Filas que no se importaron:</strong>

        <ul style="margin:10px 0 0 20px; list-style:disc; color:#684d16;">
            @foreach (session('errores_importacion') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


                <a href="{{ route('alumnos.create') }}"
                   class="btn-registrar">
                    <span aria-hidden="true">＋</span>
                    Registrar alumno
                </a>
            </div>
        </header>

        {{-- MENSAJE DE ÉXITO --}}
        @if (session('success'))
            <div class="mensaje" role="status">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLA DE ALUMNOS --}}
        <section class="alumnos-card">
            <div class="alumnos-toolbar">
                <div>
                    <h2>Alumnos registrados</h2>
                    <p class="subtitulo-tabla">
                        Consulta y administra los registros del plantel.
                    </p>
                </div>

                <div class="buscador">
                    <span class="icono-busqueda" aria-hidden="true">⌕</span>
                    <input
                        type="search"
                        id="buscador"
                        placeholder="Buscar por nombre, matrícula, correo o grupo..."
                        autocomplete="off"
                        aria-label="Buscar alumnos"
                    >
                </div>
            </div>

            <div class="tabla-contenedor">
                <table class="tabla-alumnos" id="tablaAlumnos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Matrícula</th>
                            <th>Nombre completo</th>
                            <th>Correo</th>
                            <th>Grado</th>
                            <th>Grupo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="cuerpoAlumnos">
                        @forelse ($alumnos as $alumno)
                            <tr class="fila-alumno">
                                <td>
                                    <span class="id-alumno">{{ $alumno->id }}</span>
                                </td>

                                <td>
                                    <span class="matricula">
                                        {{ $alumno->matricula }}
                                    </span>
                                </td>

                                <td>
                                    <div class="nombre-alumno">
                                        {{ $alumno->nombres }} {{ $alumno->apellidos }}
                                    </div>
                                </td>

                                <td>
                                    <span class="correo">{{ $alumno->email }}</span>
                                </td>

                                <td>
                                    <span class="etiqueta etiqueta-grado">
                                        @if ($alumno->grupo)
                                            {{ $alumno->grupo->grado }}°
                                        @else
                                            —
                                        @endif
                                    </span>
                                </td>

                                <td>
                                    <span class="etiqueta etiqueta-grupo">
                                        {{ $alumno->grupo->nombre ?? 'Sin grupo' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="acciones">
                                        <a
                                            href="{{ route('alumnos.show', $alumno->id) }}"
                                            class="btn-accion btn-ver"
                                        >
                                            Ver
                                        </a>

                                        <a
                                            href="{{ route('alumnos.edit', $alumno->id) }}"
                                            class="btn-accion btn-editar"
                                        >
                                            Editar
                                        </a>

                                        <form
                                            action="{{ route('alumnos.destroy', $alumno->id) }}"
                                            method="POST"
                                            class="form-eliminar"
                                            onsubmit="return confirm('¿Estás seguro de eliminar este alumno?');"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn-accion btn-eliminar">
                                                Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="estado-vacio">
                                    No hay alumnos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div id="sinResultados" class="sin-resultados">
                    No se encontraron alumnos con esa búsqueda.
                </div>
            </div>

            <footer class="contador">
                <span>
                    Total de alumnos registrados:
                    <strong>{{ $alumnos->count() }}</strong>
                </span>

                <span>
                    Coincidencias visibles:
                    <strong id="contadorAlumnos">{{ $alumnos->count() }}</strong>
                </span>
            </footer>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buscador = document.getElementById('buscador');
            const filas = document.querySelectorAll('.fila-alumno');
            const sinResultados = document.getElementById('sinResultados');
            const contador = document.getElementById('contadorAlumnos');

            if (!buscador || !contador || !sinResultados) {
                return;
            }

            buscador.addEventListener('input', function () {
                const texto = this.value.toLocaleLowerCase('es').trim();
                let encontrados = 0;

                filas.forEach(function (fila) {
                    const contenido = fila.textContent.toLocaleLowerCase('es');
                    const coincide = contenido.includes(texto);

                    fila.style.display = coincide ? '' : 'none';

                    if (coincide) {
                        encontrados++;
                    }
                });

                contador.textContent = encontrados;

                sinResultados.style.display =
                    filas.length > 0 && encontrados === 0 ? 'block' : 'none';
            });
        });
    </script>
</x-app-layout>
