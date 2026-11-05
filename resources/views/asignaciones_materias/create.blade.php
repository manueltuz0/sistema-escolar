<x-app-layout>
    <style>
        :root {
            --vino: #7B1E3A;
            --vino-oscuro: #5D142B;
            --vino-claro: #F8F4F5;
            --borde: #E7D9DE;
            --texto: #33262B;
            --muted: #786A70;
        }

        .asignacion-container {
            max-width: 850px;
            margin: 0 auto;
            padding: 30px 20px 45px;
            color: var(--texto);
        }

        .encabezado {
            background: white;
            border: 1px solid var(--borde);
            border-top: 5px solid var(--vino);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .encabezado h1 {
            margin: 0;
            color: var(--vino);
            font-size: 25px;
            font-weight: 800;
        }

        .encabezado p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .tarjeta {
            background: white;
            border: 1px solid var(--borde);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 3px 12px rgba(65, 18, 36, .04);
        }

        .grupo-formulario {
            margin-bottom: 19px;
        }

        .grupo-formulario label {
            display: block;
            margin-bottom: 7px;
            color: var(--texto);
            font-size: 13px;
            font-weight: 800;
        }

        .grupo-formulario select {
            width: 100%;
            min-height: 43px;
            padding: 10px 12px;
            border: 1px solid #D8C8CE;
            border-radius: 7px;
            background: white;
            color: var(--texto);
            font-size: 13px;
        }

        .grupo-formulario select:focus {
            outline: 2px solid #E8C8D3;
            border-color: var(--vino);
        }

        .grupo-formulario select:disabled {
            background: #F5F1F2;
            color: #887A80;
            cursor: not-allowed;
        }

        .ayuda {
            display: block;
            margin-top: 6px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.5;
        }

        .errores {
            background: var(--vino-claro);
            border: 1px solid #DDBCC7;
            color: var(--vino-oscuro);
            padding: 14px 17px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .errores ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .nota {
            background: var(--vino-claro);
            border: 1px solid var(--borde);
            border-radius: 8px;
            padding: 13px 15px;
            margin-bottom: 22px;
            color: var(--texto);
            font-size: 12px;
            line-height: 1.6;
        }

        .nota strong {
            color: var(--vino);
        }

        .botones {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            padding-top: 18px;
            border-top: 1px solid var(--borde);
            margin-top: 25px;
        }

        .boton {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            padding: 11px 17px;
            border: 1px solid var(--vino);
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
            font-size: 12px;
            font-weight: 800;
            transition: .2s;
        }

        .guardar {
            background: var(--vino);
            color: white;
        }

        .guardar:hover {
            background: var(--vino-oscuro);
        }

        .regresar {
            background: white;
            color: var(--vino);
        }

        .regresar:hover {
            background: var(--vino-claro);
        }

        @media (max-width: 600px) {
            .asignacion-container {
                padding: 15px 10px 30px;
            }

            .encabezado,
            .tarjeta {
                padding: 17px;
            }

            .encabezado h1 {
                font-size: 21px;
            }

            .botones {
                flex-direction: column;
            }

            .boton {
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>

    <div class="asignacion-container">

        <header class="encabezado">
            <h1>Asignación de materias</h1>
            <p>
                Selecciona al docente, el semestre, la materia, el grupo
                y el ciclo escolar.
            </p>
        </header>

        <div class="tarjeta">

            @if($errors->any())
                <div class="errores">
                    <strong>No se pudo completar la asignación.</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="nota">
                <strong>Importante:</strong>
                cada materia se registra una sola vez en el catálogo.
                Después puede asignarse a diferentes grupos del mismo semestre,
                con el docente que corresponda.
            </div>

            <form
                action="{{ route('asignaciones_materias.store') }}"
                method="POST"
                id="formAsignacion"
            >
                @csrf

                {{-- 1. DOCENTE --}}
                <div class="grupo-formulario">
                    <label for="docente_id">1. Docente</label>

                    <select name="docente_id" id="docente_id" required>
                        <option value="">Selecciona un docente</option>

                        @foreach($docentes as $docente)
                            <option
                                value="{{ $docente->id }}"
                                @selected((string) old('docente_id') === (string) $docente->id)
                            >
                                {{ $docente->apellidos }}, {{ $docente->nombres }}
                            </option>
                        @endforeach
                    </select>

                    <small class="ayuda">
                        Selecciona quién impartirá la materia.
                    </small>
                </div>

                {{-- 2. SEMESTRE --}}
                <div class="grupo-formulario">
                    <label for="semestre">2. Semestre</label>

                    <select name="semestre" id="semestre" required>
                        <option value="">Selecciona un semestre</option>

                        @foreach($semestres as $semestreItem)
                            <option
                                value="{{ $semestreItem }}"
                                @selected((string) old('semestre') === (string) $semestreItem)
                            >
                                {{ $semestreItem }}° semestre
                            </option>
                        @endforeach
                    </select>

                    <small class="ayuda">
                        Elige del primero al sexto. Solo se mostrarán las materias
                        registradas para el semestre seleccionado.
                    </small>
                </div>

                {{-- 3. MATERIA --}}
                <div class="grupo-formulario">
                    <label for="materia_id">3. Materia</label>

                    <select
                        name="materia_id"
                        id="materia_id"
                        required
                        disabled
                    >
                        <option value="">Selecciona primero un semestre</option>

                        @foreach($materias as $materia)
                            <option
                                value="{{ $materia->id }}"
                                data-semestre="{{ $materia->semestre }}"
                                @selected((string) old('materia_id') === (string) $materia->id)
                            >
                                {{ $materia->clave ? $materia->clave . ' - ' : '' }}{{ $materia->nombre }}
                            </option>
                        @endforeach
                    </select>

                    <small class="ayuda" id="ayudaMateria">
                        Selecciona un semestre para consultar las materias disponibles.
                    </small>
                </div>

                {{-- 4. GRUPO --}}
                <div class="grupo-formulario">
                    <label for="grupo_id">4. Grupo</label>

                    <select
                        name="grupo_id"
                        id="grupo_id"
                        required
                        disabled
                    >
                        <option value="">Selecciona primero un semestre</option>

                        @foreach($grupos as $grupo)
                            <option
                                value="{{ $grupo->id }}"
                                data-grado="{{ $grupo->grado }}"
                                @selected((string) old('grupo_id') === (string) $grupo->id)
                            >
                                {{ $grupo->grado }}° {{ $grupo->nombre }}
                                @if($grupo->especialidad)
                                    - {{ $grupo->especialidad }}
                                @endif
                            </option>
                        @endforeach
                    </select>

                    <small class="ayuda" id="ayudaGrupo">
                        Se mostrarán los grupos del semestre seleccionado.
                    </small>
                </div>

                {{-- 5. CICLO ESCOLAR --}}
                <div class="grupo-formulario">
                    <label for="ciclo_escolar_id">5. Ciclo escolar</label>

                    <select name="ciclo_escolar_id" id="ciclo_escolar_id" required>
                        <option value="">Selecciona un ciclo escolar</option>

                        @foreach($ciclosEscolares as $ciclo)
                            <option
                                value="{{ $ciclo->id }}"
                                @selected((string) old('ciclo_escolar_id') === (string) $ciclo->id)
                            >
                                {{ $ciclo->nombre }}
                                @if($ciclo->activo)
                                    (Activo)
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- BOTONES --}}
                <div class="botones">
                    <button type="submit" class="boton guardar">
                        Guardar asignación
                    </button>

                    <a
                        href="{{ route('asignaciones_materias.index') }}"
                        class="boton regresar"
                    >
                        Regresar
                    </a>
                </div>

            </form>
        </div>
    </div>

    {{-- FILTRAR MATERIAS Y GRUPOS POR SEMESTRE --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const semestreSelect = document.getElementById('semestre');
            const materiaSelect = document.getElementById('materia_id');
            const grupoSelect = document.getElementById('grupo_id');
            const ayudaMateria = document.getElementById('ayudaMateria');
            const ayudaGrupo = document.getElementById('ayudaGrupo');

            const materiaAnterior = @json(old('materia_id', ''));
            const grupoAnterior = @json(old('grupo_id', ''));

            function actualizarOpciones() {
                const semestre = semestreSelect.value;

                const materias = Array.from(
                    materiaSelect.querySelectorAll('option[data-semestre]')
                );

                const grupos = Array.from(
                    grupoSelect.querySelectorAll('option[data-grado]')
                );

                materiaSelect.value = '';
                grupoSelect.value = '';

                if (!semestre) {
                    materiaSelect.disabled = true;
                    grupoSelect.disabled = true;

                    materiaSelect.options[0].text =
                        'Selecciona primero un semestre';

                    grupoSelect.options[0].text =
                        'Selecciona primero un semestre';

                    materias.forEach(opcion => opcion.hidden = true);
                    grupos.forEach(opcion => opcion.hidden = true);

                    ayudaMateria.textContent =
                        'Selecciona un semestre para consultar las materias disponibles.';

                    ayudaGrupo.textContent =
                        'Selecciona un semestre para consultar los grupos disponibles.';

                    return;
                }

                let cantidadMaterias = 0;
                let cantidadGrupos = 0;

                materias.forEach(function (opcion) {
                    const coincide = opcion.dataset.semestre === semestre;

                    opcion.hidden = !coincide;

                    if (coincide) {
                        cantidadMaterias++;
                    }
                });

                grupos.forEach(function (opcion) {
                    const coincide = opcion.dataset.grado === semestre;

                    opcion.hidden = !coincide;

                    if (coincide) {
                        cantidadGrupos++;
                    }
                });

                materiaSelect.disabled = cantidadMaterias === 0;
                grupoSelect.disabled = cantidadGrupos === 0;

                materiaSelect.options[0].text = cantidadMaterias
                    ? 'Selecciona una materia'
                    : 'No hay materias registradas para este semestre';

                grupoSelect.options[0].text = cantidadGrupos
                    ? 'Selecciona un grupo'
                    : 'No hay grupos registrados para este grado';

                ayudaMateria.textContent = cantidadMaterias
                    ? 'Hay ' + cantidadMaterias +
                      ' materia(s) registrada(s) para ' + semestre + '° semestre.'
                    : 'Todavía no hay materias registradas para ' +
                      semestre + '° semestre.';

                ayudaGrupo.textContent = cantidadGrupos
                    ? 'Selecciona uno de los grupos de ' + semestre + '° semestre.'
                    : 'No se encontraron grupos de ' + semestre + '° semestre.';

                if (materiaAnterior) {
                    const anterior = materias.find(function (opcion) {
                        return opcion.value === String(materiaAnterior) &&
                            opcion.dataset.semestre === semestre;
                    });

                    if (anterior) {
                        materiaSelect.value = anterior.value;
                    }
                }

                if (grupoAnterior) {
                    const anterior = grupos.find(function (opcion) {
                        return opcion.value === String(grupoAnterior) &&
                            opcion.dataset.grado === semestre;
                    });

                    if (anterior) {
                        grupoSelect.value = anterior.value;
                    }
                }
            }

            semestreSelect.addEventListener('change', actualizarOpciones);

            actualizarOpciones();
        });
    </script>
</x-app-layout>