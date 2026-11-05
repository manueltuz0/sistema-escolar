<x-app-layout>
    <style>
        .citatorio-page {
            --vino: #7B1E3A;
            --vino-oscuro: #5D142B;
            --texto: #33262B;
            --suave: #786A70;
            --borde: #E7D9DE;
            color: var(--texto);
            font-size: 15px;
            line-height: 1.55;
        }
        .citatorio-page .contenedor { width: min(100% - 2rem, 1120px); margin: 0 auto; }
        .citatorio-page .encabezado {
            display:flex; align-items:center; justify-content:space-between; gap:1.25rem;
            margin-bottom:1.5rem; padding:1.5rem 1.75rem;
            border:1px solid var(--borde); border-radius:1.25rem;
            background:linear-gradient(115deg,#fff 0%,#F8F1F4 100%);
            box-shadow:0 8px 24px rgba(76,28,46,.05);
        }
        .citatorio-page h1 { margin:0; font-size:clamp(1.55rem,2.5vw,2rem); line-height:1.2; font-weight:800; }
        .citatorio-page h2 { margin:0; font-size:1.08rem; line-height:1.35; font-weight:750; }
        .citatorio-page label { display:block; margin-bottom:.45rem; color:#4B3740; font-size:.9rem; font-weight:700; }
        .citatorio-page input:not([type="hidden"]), .citatorio-page select, .citatorio-page textarea {
            display:block; width:100%; min-width:0; padding:.78rem .9rem;
            border:1px solid #D8C5CC; border-radius:.7rem; background:#fff;
            color:var(--texto); font:inherit;
        }
        .citatorio-page input:not([type="hidden"]), .citatorio-page select { min-height:46px; }
        .citatorio-page textarea { min-height:115px; resize:vertical; }
        .citatorio-page input:focus, .citatorio-page select:focus, .citatorio-page textarea:focus {
            border-color:var(--vino)!important; outline:none; box-shadow:0 0 0 3px rgba(123,30,58,.12);
        }
        .citatorio-page .tarjeta {
            margin-bottom:1.25rem; overflow:hidden; border:1px solid var(--borde);
            border-radius:1.1rem; background:#fff; box-shadow:0 5px 18px rgba(76,28,46,.045);
        }
        .citatorio-page .tarjeta-cabecera {
            display:flex; align-items:center; gap:.85rem; padding:1rem 1.4rem;
            border-bottom:1px solid #F0E5E9; background:#FCF9FA;
        }
        .citatorio-page .tarjeta-contenido { padding:1.4rem; }
        .citatorio-page .grid-form { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:1.15rem 1.35rem; }
        .citatorio-page .ancho-completo { grid-column:1/-1; }
        .citatorio-page .resultado-alumno {
            display:block; width:100%; padding:.9rem 1rem; border:1px solid var(--borde);
            border-radius:.8rem; background:#fff; text-align:left;
        }
        .citatorio-page .resultado-alumno:hover { background:#FBF6F8; border-color:#C9AAB5; }
        /* Tailwind .hidden debe prevalecer sobre display:block del resultado */
        .citatorio-page .resultado-alumno.hidden { display:none !important; }
        .citatorio-page .botones { display:flex; justify-content:flex-end; gap:.75rem; padding:1rem 0 1.5rem; }
        .citatorio-page .btn-principal, .citatorio-page .btn-secundario {
            display:inline-flex; align-items:center; justify-content:center; min-height:46px;
            padding:.75rem 1.35rem; border-radius:.75rem; font-weight:750; text-decoration:none; cursor:pointer;
        }
        .citatorio-page .btn-principal { border:0; background:var(--vino); color:#fff; }
        .citatorio-page .btn-principal:hover { background:var(--vino-oscuro); }
        .citatorio-page .btn-secundario { border:1px solid var(--borde); background:#fff; color:#4B3740; }
        .citatorio-page .ayuda { color:var(--suave); font-size:.84rem; }
        .citatorio-page .seleccionado { padding:1rem; border:1px solid #C9AAB5; border-radius:.85rem; background:#F8F4F5; }
        @media(max-width:700px) {
            .citatorio-page .contenedor { width:min(100% - 1rem,1120px); }
            .citatorio-page .encabezado { align-items:flex-start; flex-direction:column; padding:1.1rem; }
            .citatorio-page .grid-form { grid-template-columns:1fr; gap:1rem; }
            .citatorio-page .ancho-completo { grid-column:auto; }
            .citatorio-page .tarjeta-contenido { padding:1rem; }
            .citatorio-page .botones { flex-direction:column-reverse; }
            .citatorio-page .botones a, .citatorio-page .botones button { width:100%; }
        }
    </style>

    <div class="citatorio-page min-h-screen bg-[#F8F4F5] py-8">
        <div class="contenedor">
            <div class="encabezado">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-[#7B1E3A] flex items-center justify-center text-white text-xl shadow-lg">📄</div>
                    <div>
                        <h1>Crear citatorio</h1>
                        <p class="text-[#786A70] mt-1">Registra una solicitud de asistencia para el responsable del alumno.</p>
                    </div>
                </div>
                <a href="{{ route('incidencias.index') }}" class="btn-secundario">← Regresar a incidencias</a>
            </div>

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5">
                    <div class="font-bold text-red-800 mb-2">Revisa los siguientes datos:</div>
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('citatorios.store') }}" id="formCitatorio">
                @csrf

                <section class="tarjeta">
                    <div class="tarjeta-cabecera">
                        <div class="w-10 h-10 rounded-xl bg-[#F2E7EB] flex items-center justify-center">👤</div>
                        <div>
                            <h2>Alumno</h2>
                            <p class="text-sm text-[#786A70]">Busca por nombre, apellido o matrícula.</p>
                        </div>
                    </div>
                    <div class="tarjeta-contenido">
                        <label for="buscarAlumno">Buscar alumno</label>
                        <input type="text" id="buscarAlumno" autocomplete="off" placeholder="Escribe nombre, apellido o matrícula...">
                        <div id="resultadosAlumnos" class="mt-3 space-y-2 max-h-72 overflow-y-auto hidden">
                            @foreach ($alumnos as $alumno)
                                <button
                                    type="button"
                                    class="resultado-alumno"
                                    data-id="{{ $alumno->id }}"
                                    data-nombre="{{ $alumno->nombres }} {{ $alumno->apellidos }}"
                                    data-matricula="{{ $alumno->matricula ?? '' }}"
                                    data-grupo="{{ $alumno->grupo->nombre ?? 'Sin grupo' }}"
                                    data-grado="{{ $alumno->grupo->grado ?? '' }}"
                                    data-email="{{ $alumno->email ?? '' }}"
                                    data-responsables="{{ $alumno->responsables->map(fn($r) => ['id' => $r->id, 'nombre' => $r->nombre, 'parentesco' => $r->parentesco, 'email' => $r->email, 'telefono' => $r->telefono])->values()->toJson() }}"
                                >
                                    <div class="flex items-center justify-between gap-4">
                                        <div>
                                            <div class="font-bold">{{ $alumno->apellidos }}, {{ $alumno->nombres }}</div>
                                            <div class="text-sm text-[#786A70] mt-1">
                                                Matrícula: {{ $alumno->matricula ?? 'Sin matrícula' }}
                                                <span class="mx-2">•</span>
                                                Semestre: {{ $alumno->grupo && $alumno->grupo->grado ? $alumno->grupo->grado . '°' : 'Sin semestre' }}
                                                <span class="mx-2">•</span>
                                                Grupo: {{ $alumno->grupo->nombre ?? 'Sin grupo' }}
                                            </div>
                                        </div>
                                        <span class="text-[#7B1E3A]">→</span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                        <div id="sinResultados" class="hidden mt-4 p-4 rounded-xl bg-[#F8F4F5] border border-amber-200 text-amber-700 text-sm">
                            No se encontró ningún alumno con esa información.
                        </div>

                        <div id="alumnoSeleccionado" class="seleccionado mt-5 hidden">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-xs uppercase tracking-wide text-[#7B1E3A] font-bold">Alumno seleccionado</div>
                                    <h3 id="alumnoNombre" class="text-xl font-bold mt-1"></h3>
                                    <div class="grid sm:grid-cols-2 gap-x-8 gap-y-1 mt-2 text-sm text-[#786A70]">
                                        <div><strong>Matrícula:</strong> <span id="alumnoMatricula"></span></div>
                                        <div><strong>Grupo:</strong> <span id="alumnoGrupo"></span></div>
                                        <div><strong>Semestre/grado:</strong> <span id="alumnoGrado"></span></div>
                                        <div><strong>Correo:</strong> <span id="alumnoEmail"></span></div>
                                    </div>
                                </div>
                                <button type="button" id="cambiarAlumno" class="text-sm font-semibold text-[#7B1E3A]">Cambiar</button>
                            </div>
                        </div>
                        <input type="hidden" name="alumno_id" id="alumno_id" value="{{ old('alumno_id') }}">
                    </div>
                </section>

                <section class="tarjeta">
                    <div class="tarjeta-cabecera">
                        <div class="w-10 h-10 rounded-xl bg-[#F2E7EB] flex items-center justify-center">👪</div>
                        <div>
                            <h2>Responsable</h2>
                            <p class="text-sm text-[#786A70]">Selecciona a la madre, padre o responsable registrado del alumno.</p>
                        </div>
                    </div>
                    <div class="tarjeta-contenido grid-form">
                        <div class="ancho-completo">
                            <label for="responsable_alumno_id">Seleccionar responsable *</label>
                            <select name="responsable_alumno_id" id="responsable_alumno_id" required disabled>
                                <option value="">Primero selecciona un alumno</option>
                            </select>
                            <p id="sinResponsables" class="ayuda mt-2 hidden">Este alumno no tiene responsables registrados. Registra primero sus datos en el apartado de responsables.</p>
                        </div>
                        <div>
                            <label for="responsable_nombre">Nombre del responsable *</label>
                            <input type="text" name="responsable_nombre" id="responsable_nombre" value="{{ old('responsable_nombre') }}" maxlength="150" required readonly>
                        </div>
                        <div>
                            <label for="responsable_parentesco">Parentesco *</label>
                            <input type="text" name="responsable_parentesco" id="responsable_parentesco" value="{{ old('responsable_parentesco') }}" maxlength="30" required readonly>
                        </div>
                        <div>
                            <label for="responsable_email">Correo electrónico</label>
                            <input type="email" name="responsable_email" id="responsable_email" value="{{ old('responsable_email') }}" maxlength="150" readonly>
                        </div>
                        <div>
                            <label for="responsable_telefono">Teléfono / WhatsApp *</label>
                            <input type="text" name="responsable_telefono" id="responsable_telefono" value="{{ old('responsable_telefono') }}" maxlength="20" required readonly>
                        </div>
                        <p class="ayuda ancho-completo">Al guardar el citatorio se conservará una copia de estos datos, aunque posteriormente se actualice el registro del responsable.</p>
                    </div>
                </section>

                <section class="tarjeta">
                    <div class="tarjeta-cabecera">
                        <div class="w-10 h-10 rounded-xl bg-[#F2E7EB] flex items-center justify-center">📅</div>
                        <div>
                            <h2>Información del citatorio</h2>
                            <p class="text-sm text-[#786A70]">Indica el motivo y cuándo debe presentarse el responsable.</p>
                        </div>
                    </div>
                    <div class="tarjeta-contenido grid-form">
                        <div>
                            <label for="fecha_emision">Fecha de emisión *</label>
                            <input type="date" name="fecha_emision" id="fecha_emision" value="{{ old('fecha_emision', now()->format('Y-m-d')) }}" required>
                        </div>
                        <div>
                            <label for="estado">Estado *</label>
                            <select name="estado" id="estado" required>
                                <option value="Pendiente" @selected(old('estado', 'Pendiente') === 'Pendiente')>Pendiente</option>
                                <option value="Atendido" @selected(old('estado') === 'Atendido')>Atendido</option>
                                <option value="Cancelado" @selected(old('estado') === 'Cancelado')>Cancelado</option>
                            </select>
                        </div>
                        <div>
                            <label for="fecha_cita">Fecha de asistencia *</label>
                            <input type="date" name="fecha_cita" id="fecha_cita" value="{{ old('fecha_cita') }}" required>
                        </div>
                        <div>
                            <label for="hora_cita">Hora de asistencia *</label>
                            <input type="time" name="hora_cita" id="hora_cita" value="{{ old('hora_cita') }}" required>
                        </div>
                        <div class="ancho-completo">
                            <label for="motivo">Motivo del citatorio *</label>
                            <textarea name="motivo" id="motivo" rows="4" required placeholder="Explica claramente el motivo por el que se solicita la presencia del responsable...">{{ old('motivo') }}</textarea>
                        </div>
                        <div class="ancho-completo">
                            <label for="observaciones">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" rows="3" placeholder="Información adicional (opcional)...">{{ old('observaciones') }}</textarea>
                        </div>
                    </div>
                </section>

                <div class="botones">
                    <a href="{{ route('incidencias.index') }}" class="btn-secundario">Cancelar</a>
                    <button type="submit" class="btn-principal">Guardar citatorio</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buscador = document.getElementById('buscarAlumno');
            const resultados = document.getElementById('resultadosAlumnos');
            const sinResultados = document.getElementById('sinResultados');
            const alumnoId = document.getElementById('alumno_id');
            const alumnoSeleccionado = document.getElementById('alumnoSeleccionado');
            const selectResponsable = document.getElementById('responsable_alumno_id');
            const sinResponsables = document.getElementById('sinResponsables');
            const botones = document.querySelectorAll('.resultado-alumno');

            const camposResponsable = {
                nombre: document.getElementById('responsable_nombre'),
                parentesco: document.getElementById('responsable_parentesco'),
                email: document.getElementById('responsable_email'),
                telefono: document.getElementById('responsable_telefono')
            };

            // Quita acentos y normaliza espacios para que la búsqueda sea flexible.
            function normalizarTexto(texto) {
                return (texto || '')
                    .toString()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .toLowerCase()
                    .trim()
                    .replace(/\s+/g, ' ');
            }

            function limpiarResponsable() {
                selectResponsable.innerHTML = '<option value="">Selecciona un responsable</option>';
                selectResponsable.disabled = true;
                Object.values(camposResponsable).forEach(campo => {
                    campo.value = '';
                    campo.readOnly = true;
                });
                sinResponsables.classList.add('hidden');
            }

            function cargarResponsables(responsables) {
                limpiarResponsable();

                if (!responsables.length) {
                    sinResponsables.classList.remove('hidden');
                    return;
                }

                selectResponsable.disabled = false;
                responsables.forEach(responsable => {
                    const opcion = document.createElement('option');
                    opcion.value = responsable.id;
                    opcion.textContent = `${responsable.nombre} (${responsable.parentesco})`;
                    opcion.dataset.nombre = responsable.nombre || '';
                    opcion.dataset.parentesco = responsable.parentesco || '';
                    opcion.dataset.email = responsable.email || '';
                    opcion.dataset.telefono = responsable.telefono || '';
                    selectResponsable.appendChild(opcion);
                });
            }

            selectResponsable.addEventListener('change', function () {
                const opcion = this.options[this.selectedIndex];

                camposResponsable.nombre.value = opcion.dataset.nombre || '';
                camposResponsable.parentesco.value = opcion.dataset.parentesco || '';
                camposResponsable.email.value = opcion.dataset.email || '';
                camposResponsable.telefono.value = opcion.dataset.telefono || '';
            });

            buscador.addEventListener('input', function () {
                const texto = normalizarTexto(this.value);
                const palabras = texto.split(' ').filter(Boolean);
                const LIMITE_RESULTADOS = 8;
                let encontrados = 0;
                let visibles = 0;

                if (!texto) {
                    botones.forEach(boton => boton.classList.add('hidden'));
                    resultados.classList.add('hidden');
                    sinResultados.classList.add('hidden');
                    return;
                }

                botones.forEach(boton => {
                    const nombre = normalizarTexto(boton.dataset.nombre);
                    const matricula = normalizarTexto(boton.dataset.matricula);
                    const grupo = normalizarTexto(boton.dataset.grupo);
                    const contenido = `${nombre} ${matricula} ${grupo}`;
                    // Todas las palabras escritas deben coincidir, sin importar el orden.
                    const coincide = palabras.every(palabra => contenido.includes(palabra));

                    if (coincide) {
                        encontrados++;
                        const mostrar = visibles < LIMITE_RESULTADOS;
                        boton.classList.toggle('hidden', !mostrar);
                        if (mostrar) visibles++;
                    } else {
                        boton.classList.add('hidden');
                    }
                });

                resultados.classList.toggle('hidden', visibles === 0);
                sinResultados.classList.toggle('hidden', encontrados !== 0);
                if (encontrados > LIMITE_RESULTADOS) {
                    sinResultados.textContent = `Se encontraron ${encontrados} coincidencias. Refina la búsqueda para ver resultados más precisos.`;
                } else {
                    sinResultados.textContent = 'No se encontró ningún alumno con esa información.';
                }
            });

            botones.forEach(boton => {
                boton.addEventListener('click', function () {
                    alumnoId.value = this.dataset.id;
                    document.getElementById('alumnoNombre').textContent = this.dataset.nombre;
                    document.getElementById('alumnoMatricula').textContent = this.dataset.matricula || 'Sin matrícula';
                    document.getElementById('alumnoGrupo').textContent = this.dataset.grupo || 'Sin grupo';
                    document.getElementById('alumnoGrado').textContent = this.dataset.grado ? `${this.dataset.grado}.º semestre` : 'No disponible';
                    document.getElementById('alumnoEmail').textContent = this.dataset.email || 'Sin correo registrado';

                    let responsables = [];
                    try {
                        responsables = JSON.parse(this.dataset.responsables || '[]');
                    } catch (error) {
                        console.error('No se pudieron cargar los responsables del alumno.', error);
                    }
                    cargarResponsables(responsables);

                    alumnoSeleccionado.classList.remove('hidden');
                    resultados.classList.add('hidden');
                    sinResultados.classList.add('hidden');
                    buscador.value = '';
                });
            });

            document.getElementById('cambiarAlumno')?.addEventListener('click', function () {
                alumnoId.value = '';
                alumnoSeleccionado.classList.add('hidden');
                limpiarResponsable();
                buscador.value = '';
                buscador.focus();
            });

            document.getElementById('formCitatorio').addEventListener('submit', function (event) {
                if (!alumnoId.value) {
                    event.preventDefault();
                    alert('Debes seleccionar un alumno antes de guardar el citatorio.');
                    buscador.focus();
                    return;
                }

                if (!selectResponsable.value) {
                    event.preventDefault();
                    alert('Debes seleccionar un responsable registrado del alumno.');
                    selectResponsable.focus();
                }
            });
        });
    </script>
</x-app-layout>
