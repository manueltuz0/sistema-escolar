
<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ENCABEZADO --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-7">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#5D142B] text-white shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 8h6m-6 4h6" />
                            </svg>
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">
                                Nueva reservación
                            </h1>
                            <p class="text-sm text-gray-500 mt-1">
                                Solicita un equipo tecnológico para una fecha y horario determinados.
                            </p>
                        </div>
                    </div>
                </div>

                
<a href="{{ route('reservaciones_equipos.index') }}"
   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg
          bg-[#7B1E3A] text-white text-sm font-bold
          hover:bg-[#5D142B] transition duration-200 shadow-md
          hover:shadow-lg">

    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
         fill="none" viewBox="0 0 24 24"
         stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round"
              d="M10 19l-7-7m0 0l7-7m-7 7h18" />
    </svg>

    Volver al listado
</a>

            </div>

            {{-- ERRORES --}}
            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-5">
                    <div class="flex items-center gap-2 text-red-800 font-bold mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.7 2.58h16.96a2 2 0 001.7-2.58L13.7 3.86a2 2 0 00-3.4 0z" />
                        </svg>
                        Revisa los siguientes datos:
                    </div>

                    <ul class="list-disc pl-7 text-sm text-red-700 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('reservaciones_equipos.store') }}"
                  method="POST" class="space-y-6">
                @csrf

                {{-- 1. EQUIPO --}}
                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#5D142B] text-white font-bold">
                            1
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Equipo tecnológico</h2>
                            <p class="text-sm text-gray-500">Selecciona el equipo que necesitas.</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <label for="equipo_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Equipo solicitado <span class="text-red-500">*</span>
                        </label>

                        <select name="equipo_id" id="equipo_id" required
                                class="w-full rounded-xl border-gray-300 bg-white text-sm
                                       focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">
                            <option value="">Seleccionar equipo</option>

                            @foreach($equipos as $equipo)
                                <option value="{{ $equipo->id }}"
                                    @selected(old('equipo_id') == $equipo->id)>
                                    {{ $equipo->codigo }} - {{ $equipo->tipo }}
                                    @if($equipo->marca)
                                        ({{ $equipo->marca }})
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        @if($equipos->isEmpty())
                            <div class="mt-3 flex items-center gap-2 text-sm text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.7 2.58h16.96a2 2 0 001.7-2.58L13.7 3.86a2 2 0 00-3.4 0z" />
                                </svg>
                                No hay equipos disponibles actualmente.
                            </div>
                        @endif
                    </div>
                </section>

                {{-- 2. SOLICITANTE --}}
                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#5D142B] text-white font-bold">
                            2
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Datos del solicitante</h2>
                            <p class="text-sm text-gray-500">Indica quién realizará la reservación.</p>
                        </div>
                    </div>

                    <div class="p-6 space-y-5">

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <label for="tipo_docente"
                                   class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200
                                          cursor-pointer hover:border-[#7B1E3A] hover:bg-red-50/30 transition">
                                <input type="radio" name="tipo_solicitante" value="docente"
                                       id="tipo_docente"
                                       class="w-5 h-5 text-[#7B1E3A] focus:ring-[#7B1E3A]">

                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12.08 12.08 0 0118 16.5V19l-6 3-6-3v-2.5c0-2.2.59-4.3 1.84-5.92L12 14z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-bold text-gray-800">Soy docente</span>
                                        <span class="text-xs text-gray-500">Reservación como profesor</span>
                                    </div>
                                </div>
                            </label>

                            <label for="tipo_alumno"
                                   class="flex items-center gap-4 p-4 rounded-xl border-2 border-gray-200
                                          cursor-pointer hover:border-[#7B1E3A] hover:bg-red-50/30 transition">
                                <input type="radio" name="tipo_solicitante" value="alumno"
                                       id="tipo_alumno"
                                       class="w-5 h-5 text-[#7B1E3A] focus:ring-[#7B1E3A]">

                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M16 18a4 4 0 00-8 0m12 3H4a2 2 0 01-2-2v-1a6 6 0 0112 0v1m6 2v-1a6 6 0 00-4-5.66M12 7a4 4 0 11-8 0 4 4 0 018 0zm8 0a4 4 0 11-8 0" />
                                        </svg>
                                    </div>
                                    <div>
                                        <span class="block font-bold text-gray-800">Soy alumno</span>
                                        <span class="text-xs text-gray-500">Reservación como estudiante</span>
                                    </div>
                                </div>
                            </label>
                        </div>

                        {{-- DOCENTE --}}
                        <div id="panel_docente" class="hidden rounded-xl bg-gray-50 border border-gray-200 p-5">
                            <label for="docente_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Selecciona tu nombre
                            </label>

                            <select name="docente_id" id="docente_id" disabled
                                    class="w-full rounded-xl border-gray-300 bg-white text-sm
                                           focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">
                                <option value="">Seleccionar docente</option>

                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->id }}">
                                        {{ $docente->apellidos }}, {{ $docente->nombres }}
                                    </option>
                                @endforeach
                            </select>

                            <p class="text-xs text-gray-500 mt-2">
                                Al seleccionar tu nombre podrás consultar únicamente las materias que tienes asignadas.
                            </p>
                        </div>

                        {{-- ALUMNO --}}
                        <div id="panel_alumno" class="hidden rounded-xl bg-gray-50 border border-gray-200 p-5">
                            <label for="buscar_alumno" class="block text-sm font-semibold text-gray-700 mb-2">
                                Busca tu nombre, apellido o matrícula
                            </label>

                            <input type="text" id="buscar_alumno" autocomplete="off"
                                   placeholder="Escribe al menos 3 letras o números..."
                                   disabled
                                   class="w-full rounded-xl border-gray-300 bg-white text-sm
                                          focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">

                            <input type="hidden" name="alumno_id" id="alumno_id" value="">

                            <div id="resultados_alumnos"
                                 class="hidden border border-gray-200 rounded-xl mt-2 max-h-56
                                        overflow-y-auto bg-white shadow-sm"></div>

                            <div id="alumno_seleccionado"
                                 class="hidden mt-3 rounded-xl bg-green-50 border border-green-200
                                        p-3 text-green-800 text-sm"></div>
                        </div>
                    </div>
                </section>

                {{-- 3. INFORMACIÓN ACADÉMICA --}}
                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#5D142B] text-white font-bold">
                            3
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Información académica</h2>
                            <p class="text-sm text-gray-500">Selecciona el semestre y la materia correspondiente.</p>
                        </div>
                    </div>

                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label for="semestre" class="block text-sm font-semibold text-gray-700 mb-2">
                                Semestre
                            </label>

                            <select name="semestre" id="semestre" disabled
                                    class="w-full rounded-xl border-gray-300 bg-white text-sm
                                           focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">
                                <option value="">Primero selecciona al solicitante</option>

                                @for($i = 1; $i <= 6; $i++)
                                    <option value="{{ $i }}">{{ $i }}° semestre</option>
                                @endfor
                            </select>
                        </div>

                        <div>
                            <label for="materia_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Materia
                            </label>

                            <select name="materia_id" id="materia_id" disabled
                                    class="w-full rounded-xl border-gray-300 bg-white text-sm
                                           focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">
                                <option value="">Primero selecciona el semestre</option>
                            </select>
                        </div>
                    </div>
                </section>

                {{-- 4. FECHA Y HORARIO --}}
                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#5D142B] text-white font-bold">
                            4
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Fecha y horario</h2>
                            <p class="text-sm text-gray-500">Indica cuándo necesitas el equipo.</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                            <div>
                                <label for="fecha_inicio" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fecha de inicio <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('fecha_inicio') }}" required
                                       class="w-full rounded-xl border-gray-300 text-sm
                                              focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">
                            </div>

                            <div>
                                <label for="hora_inicio" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Hora de inicio <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="hora_inicio" id="hora_inicio"
                                       value="{{ old('hora_inicio') }}" required
                                       class="w-full rounded-xl border-gray-300 text-sm
                                              focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">
                            </div>

                            <div>
                                <label for="fecha_fin" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Fecha de finalización <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="fecha_fin" id="fecha_fin"
                                       min="{{ date('Y-m-d') }}"
                                       value="{{ old('fecha_fin') }}" required
                                       class="w-full rounded-xl border-gray-300 text-sm
                                              focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">
                            </div>

                            <div>
                                <label for="hora_fin" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Hora de finalización <span class="text-red-500">*</span>
                                </label>
                                <input type="time" name="hora_fin" id="hora_fin"
                                       value="{{ old('hora_fin') }}" required
                                       class="w-full rounded-xl border-gray-300 text-sm
                                              focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3 rounded-xl border border-amber-200 bg-amber-50 p-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 text-amber-600"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 9v4m0 4h.01M10.3 3.86L1.82 18a2 2 0 001.7 2.58h16.96a2 2 0 001.7-2.58L13.7 3.86a2 2 0 00-3.4 0z" />
                            </svg>

                            <p class="text-sm text-amber-800">
                                <strong>Importante:</strong> La solicitud quedará pendiente hasta que el responsable del módulo de préstamos la autorice. El equipo se entregará después de la aprobación y el registro de salida.
                            </p>
                        </div>
                    </div>
                </section>

                {{-- 5. OBSERVACIONES --}}
                <section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-100">
                        <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#5D142B] text-white font-bold">
                            5
                        </span>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">Observaciones</h2>
                            <p class="text-sm text-gray-500">Agrega información adicional si es necesario.</p>
                        </div>
                    </div>

                    <div class="p-6">
                        <label for="observaciones" class="block text-sm font-semibold text-gray-700 mb-2">
                            Comentarios adicionales
                        </label>

                        <textarea name="observaciones" id="observaciones" rows="4" maxlength="2000"
                                  placeholder="Escribe el motivo o los detalles de la reservación..."
                                  class="w-full rounded-xl border-gray-300 text-sm resize-y
                                         focus:border-[#7B1E3A] focus:ring-[#7B1E3A]">{{ old('observaciones') }}</textarea>
                    </div>
                </section>

                {{-- BOTONES --}}
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pb-8">
                    <a href="{{ route('reservaciones_equipos.index') }}"
                       class="inline-flex items-center justify-center px-6 py-3 rounded-xl
                              border border-gray-300 bg-white text-gray-700 font-semibold text-sm
                              hover:bg-gray-50 transition">
                        Cancelar
                    </a>

                    <button type="submit"
                            @if($equipos->isEmpty()) disabled @endif
                            class="inline-flex items-center justify-center gap-2 px-7 py-3 rounded-xl
                                   bg-[#7B1E3A] hover:bg-[#5D142B] text-white font-bold text-sm
                                   shadow-sm transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 13l4 4L19 7" />
                        </svg>
                        Registrar reservación
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- JAVASCRIPT --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        const tipoDocente = document.getElementById('tipo_docente');
        const tipoAlumno = document.getElementById('tipo_alumno');

        const panelDocente = document.getElementById('panel_docente');
        const panelAlumno = document.getElementById('panel_alumno');

        const docente = document.getElementById('docente_id');
        const alumno = document.getElementById('alumno_id');

        const buscarAlumno = document.getElementById('buscar_alumno');
        const resultados = document.getElementById('resultados_alumnos');
        const seleccionado = document.getElementById('alumno_seleccionado');

        const semestre = document.getElementById('semestre');
        const materia = document.getElementById('materia_id');

        let temporizador = null;
        let consultaActual = null;

        function limpiarAcademico() {
            semestre.value = '';
            semestre.disabled = true;

            materia.innerHTML = '<option value="">Primero selecciona el semestre</option>';
            materia.disabled = true;
        }

        function cambiarTipo(tipo) {

            panelDocente.classList.toggle('hidden', tipo !== 'docente');
            panelAlumno.classList.toggle('hidden', tipo !== 'alumno');

            docente.disabled = tipo !== 'docente';
            buscarAlumno.disabled = tipo !== 'alumno';

            docente.value = '';
            alumno.value = '';
            buscarAlumno.value = '';

            resultados.innerHTML = '';
            resultados.classList.add('hidden');

            seleccionado.textContent = '';
            seleccionado.classList.add('hidden');

            if (consultaActual) {
                consultaActual.abort();
                consultaActual = null;
            }

            limpiarAcademico();
        }

        tipoDocente.addEventListener('change', () => cambiarTipo('docente'));
        tipoAlumno.addEventListener('change', () => cambiarTipo('alumno'));

        // CAMBIO DE DOCENTE
        docente.addEventListener('change', () => {
            limpiarAcademico();

            if (docente.value) {
                semestre.disabled = false;
            }
        });

        // BÚSQUEDA DE ALUMNOS
        buscarAlumno.addEventListener('input', () => {

            clearTimeout(temporizador);

            if (consultaActual) {
                consultaActual.abort();
            }

            const texto = buscarAlumno.value.trim();

            alumno.value = '';
            seleccionado.classList.add('hidden');
            limpiarAcademico();

            if (texto.length < 3) {
                resultados.innerHTML = '';
                resultados.classList.add('hidden');
                return;
            }

            temporizador = setTimeout(async () => {

                consultaActual = new AbortController();

                try {
                    const url = new URL(
                        @json(route('reservaciones_equipos.buscar_alumnos')),
                        window.location.origin
                    );

                    url.searchParams.set('buscar', texto);

                    const respuesta = await fetch(url, {
                        headers: {
                            'Accept': 'application/json'
                        },
                        signal: consultaActual.signal
                    });

                    if (!respuesta.ok) {
                        throw new Error('No se pudo buscar alumnos.');
                    }

                    const alumnos = await respuesta.json();

                    resultados.innerHTML = '';

                    if (!alumnos.length) {

                        resultados.innerHTML = `
                            <p class="p-4 text-sm text-gray-500">
                                No se encontraron coincidencias.
                            </p>
                        `;

                    } else {

                        alumnos.forEach(item => {

                            const boton = document.createElement('button');

                            boton.type = 'button';
                            boton.className = 'block w-full text-left p-4 hover:bg-gray-50 border-b border-gray-100 text-sm transition';

                            boton.textContent =
                                `${item.apellidos}, ${item.nombres} — Matrícula: ${item.matricula ?? 'Sin matrícula'}`;

                            boton.addEventListener('click', () => {

                                alumno.value = item.id;

                                buscarAlumno.value =
                                    `${item.apellidos}, ${item.nombres}`;

                                seleccionado.textContent =
                                    `Alumno seleccionado: ${item.apellidos}, ${item.nombres}`;

                                seleccionado.classList.remove('hidden');
                                resultados.classList.add('hidden');

                                limpiarAcademico();
                                semestre.disabled = false;
                            });

                            resultados.appendChild(boton);
                        });
                    }

                    resultados.classList.remove('hidden');

                } catch (error) {

                    if (error.name !== 'AbortError') {
                        resultados.innerHTML = `
                            <p class="p-4 text-sm text-red-600">
                                Error al buscar alumnos.
                            </p>
                        `;

                        resultados.classList.remove('hidden');
                    }
                }

            }, 300);
        });

        // CARGAR MATERIAS POR SEMESTRE
        semestre.addEventListener('change', async () => {

            materia.innerHTML = '<option value="">Cargando materias...</option>';
            materia.disabled = true;

            if (!semestre.value) {
                materia.innerHTML = '<option value="">Primero selecciona el semestre</option>';
                return;
            }

            const url = new URL(
                @json(route('reservaciones_equipos.materias_por_semestre')),
                window.location.origin
            );

            url.searchParams.set('semestre', semestre.value);

            if (tipoDocente.checked && docente.value) {
                url.searchParams.set('docente_id', docente.value);
            }

            try {

                const respuesta = await fetch(url, {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                if (!respuesta.ok) {
                    throw new Error('No se pudieron cargar las materias.');
                }

                const materias = await respuesta.json();

                materia.innerHTML =
                    '<option value="">Seleccionar materia</option>';

                materias.forEach(item => {

                    const option = document.createElement('option');

                    option.value = item.id;
                    option.textContent = item.nombre;

                    materia.appendChild(option);
                });

                if (!materias.length) {

                    materia.innerHTML =
                        '<option value="">No hay materias para este semestre</option>';

                } else {

                    materia.disabled = false;
                }

            } catch (error) {

                materia.innerHTML =
                    '<option value="">Error al cargar materias</option>';
            }
        });

        // VALIDACIÓN VISUAL DE FECHAS
        const fechaInicio = document.getElementById('fecha_inicio');
        const fechaFin = document.getElementById('fecha_fin');

        fechaInicio.addEventListener('change', () => {

            fechaFin.min = fechaInicio.value;

            if (fechaFin.value && fechaFin.value < fechaInicio.value) {
                fechaFin.value = fechaInicio.value;
            }
        });

        // Si se vuelve a cargar la vista por un error, sincroniza el mínimo.
        if (fechaInicio.value) {
            fechaFin.min = fechaInicio.value;
        }

    });
    </script>
</x-app-layout>