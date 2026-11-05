<x-app-layout>
    <style>
        .grupos-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 28px 20px;
            color: #292329;
        }

        .grupos-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .grupos-titulo {
            margin: 0;
            color: #711b32;
            font-size: 27px;
            font-weight: 800;
        }

        .grupos-subtitulo {
            margin-top: 5px;
            color: #75666c;
            font-size: 13px;
        }

        .btn-vino {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            border: 1px solid #711b32;
            border-radius: 8px;
            background: #711b32;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s;
        }

        .btn-vino:hover {
            background: #531326;
        }

        .btn-blanco {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 9px 12px;
            border: 1px solid #d8c4ca;
            border-radius: 7px;
            background: #fff;
            color: #711b32;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-blanco:hover {
            background: #f8eef1;
        }

        .grupos-filtros {
            display: flex;
            align-items: end;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 20px;
            padding: 16px;
            border: 1px solid #eadde1;
            border-radius: 12px;
            background: #fff;
        }

        .grupo-campo {
            display: flex;
            flex: 1;
            min-width: 190px;
            flex-direction: column;
            gap: 6px;
        }

        .grupo-campo label {
            color: #5c2738;
            font-size: 12px;
            font-weight: 700;
        }

        .grupo-campo input,
        .grupo-campo select {
            width: 100%;
            min-height: 40px;
            border: 1px solid #dfd1d6;
            border-radius: 7px;
            padding: 8px 10px;
            background: #fff;
            font-size: 13px;
        }

        .grupos-resumen {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-bottom: 15px;
        }

        .resumen-item {
            padding: 9px 13px;
            border: 1px solid #eadde1;
            border-radius: 8px;
            background: #fff;
            color: #5b2638;
            font-size: 13px;
        }

        .grupos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(235px, 1fr));
            gap: 14px;
        }

        .grupo-card {
            overflow: hidden;
            border: 1px solid #eadde1;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 3px 10px rgba(70, 20, 38, .06);
        }

        .grupo-card-cabecera {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            padding: 12px 14px;
            background: #711b32;
            color: #fff;
        }

        .grupo-card-nombre {
            font-size: 17px;
            font-weight: 800;
        }

        .grupo-badge {
            flex-shrink: 0;
            padding: 4px 8px;
            border: 1px solid rgba(255,255,255,.45);
            border-radius: 20px;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
        }

        .grupo-card-cuerpo {
            padding: 13px 14px;
        }

        .grupo-dato {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding: 7px 0;
            border-bottom: 1px solid #f1e8eb;
            font-size: 12px;
        }

        .grupo-dato:last-child {
            border-bottom: none;
        }

        .grupo-dato span {
            color: #77676d;
        }

        .grupo-dato strong {
            color: #49202e;
            text-align: right;
            overflow-wrap: anywhere;
        }

        .grupo-card-acciones {
            display: flex;
            gap: 7px;
            flex-wrap: wrap;
            padding: 11px 14px;
            border-top: 1px solid #f0e4e8;
            background: #fffafb;
        }

        .grupo-card-acciones form {
            margin: 0;
        }

        .btn-eliminar {
            border-color: #b42335;
            color: #b42335;
        }

        .btn-eliminar:hover {
            background: #fff0f1;
        }

        .grupos-mensaje {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 13px;
        }

        .mensaje-exito {
            border: 1px solid #b8e2c5;
            background: #effaf2;
            color: #176534;
        }

        .mensaje-error {
            border: 1px solid #f0c2c6;
            background: #fff1f2;
            color: #a11d2c;
        }

        .grupos-vacio {
            padding: 35px 20px;
            border: 1px dashed #d8b9c3;
            border-radius: 12px;
            background: #fff;
            text-align: center;
        }

        .grupos-vacio h3 {
            margin-bottom: 6px;
            color: #711b32;
            font-size: 17px;
            font-weight: 800;
        }

        .grupos-vacio p {
            margin-bottom: 15px;
            color: #77676d;
            font-size: 13px;
        }

        @media (max-width: 600px) {
            .grupos-page {
                padding: 20px 12px;
            }

            .grupos-titulo {
                font-size: 23px;
            }

            .grupos-filtros {
                align-items: stretch;
            }

            .grupos-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="grupos-page">
        <div class="grupos-header">
            <div>
                <h1 class="grupos-titulo">Gestión de Grupos</h1>
                <p class="grupos-subtitulo">
                    Consulta y administra los grupos escolares.
                </p>
            </div>

            <a href="{{ route('grupos.create') }}" class="btn-vino">
                + Crear grupo
            </a>
        </div>

        @if (session('success'))
            <div class="grupos-mensaje mensaje-exito">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="grupos-mensaje mensaje-error">
                {{ session('error') }}
            </div>
        @endif

        <form method="GET" action="{{ route('grupos.index') }}"
              class="grupos-filtros">
            <div class="grupo-campo">
                <label for="buscar">Buscar grupo o especialidad</label>
                <input
                    id="buscar"
                    type="text"
                    name="buscar"
                    value="{{ $busqueda }}"
                    placeholder="Ej. A, B, C o especialidad"
                >
            </div>

            <div class="grupo-campo" style="max-width: 190px;">
                <label for="grado">Filtrar por grado</label>
                <select id="grado" name="grado">
                    <option value="">Todos los grados</option>
                    @foreach ($grados as $g)
                        <option value="{{ $g }}"
                            @selected((string) $grado === (string) $g)>
                            {{ $g }}.° semestre
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn-vino">
                Buscar
            </button>

            @if ($busqueda !== '' || ($grado !== null && $grado !== ''))
                <a href="{{ route('grupos.index') }}" class="btn-blanco">
                    Limpiar filtros
                </a>
            @endif
        </form>

        <div class="grupos-resumen">
            <div class="resumen-item">
                <strong>{{ $grupos->count() }}</strong>
                {{ $grupos->count() === 1 ? 'grupo encontrado' : 'grupos encontrados' }}
            </div>
        </div>

        @if ($grupos->isNotEmpty())
            <div class="grupos-grid">
                @foreach ($grupos as $grupo)
                    <article class="grupo-card">
                        <div class="grupo-card-cabecera">
                            <div class="grupo-card-nombre">
                                {{ $grupo->grado }}.° {{ $grupo->nombre }}
                            </div>

                            <span class="grupo-badge">
                                {{ $grupo->alumnos_count }}
                                {{ $grupo->alumnos_count === 1 ? 'alumno' : 'alumnos' }}
                            </span>
                        </div>

                        <div class="grupo-card-cuerpo">
                            <div class="grupo-dato">
                                <span>Grado</span>
                                <strong>{{ $grupo->grado }}.° semestre</strong>
                            </div>

                            <div class="grupo-dato">
                                <span>Especialidad</span>
                                <strong>{{ $grupo->especialidad ?: 'No especificada' }}</strong>
                            </div>

                            <div class="grupo-dato">
                                <span>Ciclo escolar</span>
                                <strong>
                                    @if ($grupo->cicloEscolar)
                                        {{ $grupo->cicloEscolar->nombre
                                            ?? $grupo->cicloEscolar->ciclo
                                            ?? 'Registrado' }}
                                    @else
                                        No asignado
                                    @endif
                                </strong>
                            </div>
                        </div>

                        <div class="grupo-card-acciones">
                            <a href="{{ route('grupos.show', $grupo) }}"
                               class="btn-blanco">
                                Ver
                            </a>

                            <a href="{{ route('grupos.edit', $grupo) }}"
                               class="btn-blanco">
                                Editar
                            </a>

                            @if ($grupo->alumnos_count == 0)
                                <form
                                    action="{{ route('grupos.destroy', $grupo) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este grupo?');"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="btn-blanco btn-eliminar">
                                        Eliminar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="grupos-vacio">
                <h3>No se encontraron grupos</h3>
                <p>
                    Prueba con otro nombre o grado, o registra un grupo nuevo.
                </p>
                <a href="{{ route('grupos.create') }}" class="btn-vino">
                    Crear grupo
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
