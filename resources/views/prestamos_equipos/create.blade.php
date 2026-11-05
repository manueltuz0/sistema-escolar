<x-app-layout>

    <x-slot name="header">
        <div style="
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        ">

            <div>
                <h2 style="
                    font-size: 24px;
                    font-weight: 700;
                    color: #1f2937;
                ">
                    Registrar préstamo de equipo
                </h2>

                <p style="
                    margin-top: 4px;
                    color: #6b7280;
                    font-size: 14px;
                ">
                    Registra quién solicita el equipo, qué equipo se presta y los datos del préstamo.
                </p>
            </div>

            <a href="{{ route('prestamos_equipos.index') }}"
               style="
                    display: inline-block;
                    padding: 10px 18px;
                    background: #6b7280;
                    color: white;
                    text-decoration: none;
                    border-radius: 8px;
                    font-weight: 600;
                    font-size: 14px;
               ">
                ← Volver
            </a>

        </div>
    </x-slot>


    <div style="
        padding: 26px 20px;
        background: #f3f4f6;
        min-height: calc(100vh - 80px);
    ">

        <div style="
            max-width: 1050px;
            margin: 0 auto;
        ">


            {{-- ERRORES DE VALIDACIÓN --}}
            @if ($errors->any())

                <div style="
                    background: #fee2e2;
                    border: 1px solid #fca5a5;
                    color: #991b1b;
                    padding: 16px 20px;
                    border-radius: 10px;
                    margin-bottom: 20px;
                ">

                    <strong>
                        Revisa los siguientes datos:
                    </strong>

                    <ul style="
                        margin: 10px 0 0 20px;
                    ">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- FORMULARIO --}}
            <form
                action="{{ route('prestamos_equipos.store') }}"
                method="POST"
            >

                @csrf


                {{-- DATOS DEL EQUIPO --}}
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 25px;
                    margin-bottom: 20px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                ">

                    <h3 style="
                        margin: 0 0 20px;
                        font-size: 19px;
                        font-weight: 700;
                        color: #7B1E3A;
                        border-bottom: 1px solid #e5e7eb;
                        padding-bottom: 12px;
                    ">
                        1. Equipo tecnológico
                    </h3>


                    <div style="
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                        gap: 18px;
                    ">

                        <div>

                            <label
                                for="equipo_id"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Equipo *
                            </label>

                            <select
                                name="equipo_id"
                                id="equipo_id"
                                required
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                    color: #111827;
                                "
                            >

                                <option value="">
                                    Selecciona un equipo
                                </option>

                                @forelse($equipos as $equipo)

                                    <option
                                        value="{{ $equipo->id }}"
                                        {{ old('equipo_id') == $equipo->id ? 'selected' : '' }}
                                    >
                                        {{ $equipo->codigo }}
                                        —
                                        {{ $equipo->tipo }}

                                        @if($equipo->marca)
                                            — {{ $equipo->marca }}
                                        @endif

                                        @if($equipo->modelo)
                                            {{ $equipo->modelo }}
                                        @endif
                                    </option>

                                @empty

                                    <option value="" disabled>
                                        No hay equipos disponibles
                                    </option>

                                @endforelse

                            </select>

                            <p style="
                                margin-top: 6px;
                                font-size: 12px;
                                color: #6b7280;
                            ">
                                Solo aparecen equipos que actualmente están disponibles.
                            </p>

                        </div>


                        <div>

                            <label
                                for="condicion_entrega"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Condición de entrega
                            </label>

                            <select
                                name="condicion_entrega"
                                id="condicion_entrega"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar condición
                                </option>

                                <option value="Bueno"
                                    {{ old('condicion_entrega') == 'Bueno' ? 'selected' : '' }}>
                                    Bueno
                                </option>

                                <option value="Regular"
                                    {{ old('condicion_entrega') == 'Regular' ? 'selected' : '' }}>
                                    Regular
                                </option>

                                <option value="Con detalles"
                                    {{ old('condicion_entrega') == 'Con detalles' ? 'selected' : '' }}>
                                    Con detalles
                                </option>

                            </select>

                        </div>

                    </div>

                </div>


                {{-- DATOS DEL SOLICITANTE --}}
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 25px;
                    margin-bottom: 20px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                ">

                    <h3 style="
                        margin: 0 0 20px;
                        font-size: 19px;
                        font-weight: 700;
                        color: #7B1E3A;
                        border-bottom: 1px solid #e5e7eb;
                        padding-bottom: 12px;
                    ">
                        2. Datos del solicitante
                    </h3>


                    <div style="
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                        gap: 18px;
                    ">


                        {{-- DOCENTE --}}
                        <div>

                            <label
                                for="docente_id"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Docente
                            </label>

                            <select
                                name="docente_id"
                                id="docente_id"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar docente
                                </option>

                                @foreach($docentes as $docente)

                                    <option
                                        value="{{ $docente->id }}"
                                        {{ old('docente_id') == $docente->id ? 'selected' : '' }}
                                    >
                                        {{ $docente->apellidos }},
                                        {{ $docente->nombres }}

                                        @if($docente->numero_empleado)
                                            — {{ $docente->numero_empleado }}
                                        @endif
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- ALUMNO: BUSCADOR --}}
                        <div>
                            <label for="buscar_alumno" style="display:block;margin-bottom:7px;font-weight:600;color:#374151;">
                                Alumno
                            </label>

                            <input
                                type="text"
                                id="buscar_alumno"
                                autocomplete="off"
                                placeholder="Escribe nombre, apellido o matrícula..."
                                {{ old('docente_id') ? 'disabled' : '' }}
                                style="width:100%;padding:11px 12px;border:1px solid #d1d5db;border-radius:8px;background:white;"
                            >

                            <input type="hidden" name="alumno_id" id="alumno_id" value="{{ old('alumno_id') }}">

                            <div id="resultados_alumnos" style="display:none;margin-top:5px;max-height:260px;overflow-y:auto;border:1px solid #d1d5db;border-radius:8px;background:white;box-shadow:0 4px 10px rgba(0,0,0,.08);"></div>

                            <div id="alumno_seleccionado" style="display:none;margin-top:9px;padding:10px 12px;border:1px solid #86efac;background:#f0fdf4;color:#166534;border-radius:8px;font-size:13px;"></div>

                            <button type="button" id="quitar_alumno" style="display:none;margin-top:7px;padding:5px 9px;border:0;border-radius:6px;background:#fee2e2;color:#991b1b;font-size:12px;cursor:pointer;">
                                Quitar alumno
                            </button>

                            <p style="margin-top:6px;font-size:12px;color:#6b7280;">
                                Escribe al menos 2 caracteres. Se mostrarán máximo 10 coincidencias.
                            </p>
                        </div>

                    </div>

                    <div id="solicitante_ayuda" style="margin-top:15px;padding:12px 15px;background:#fdf2f5;border:1px solid #f3d5df;border-radius:8px;color:#7B1E3A;font-size:13px;">
                        Selecciona un docente o busca un alumno. Solo puedes elegir uno.
                    </div>

                </div>


                {{-- DATOS ACADÉMICOS --}}
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 25px;
                    margin-bottom: 20px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                ">

                    <h3 style="
                        margin: 0 0 20px;
                        font-size: 19px;
                        font-weight: 700;
                        color: #7B1E3A;
                        border-bottom: 1px solid #e5e7eb;
                        padding-bottom: 12px;
                    ">
                        3. Información académica
                    </h3>


                    <div style="
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                        gap: 18px;
                    ">


                        {{-- MATERIA --}}
                        <div>

                            <label
                                for="materia_id"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Asignatura
                            </label>

                            <select
                                name="materia_id"
                                id="materia_id"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar asignatura
                                </option>

                                @foreach($materias as $materia)

                                    <option
                                        value="{{ $materia->id }}"
                                        data-semestre="{{ $materia->semestre }}"
                                        data-clave="{{ $materia->clave }}"
                                        {{ old('materia_id') == $materia->id ? 'selected' : '' }}
                                    >
                                        @if($materia->clave)
                                            {{ $materia->clave }} —
                                        @endif

                                        {{ $materia->nombre }}

                                        @if($materia->semestre)
                                            — Semestre {{ $materia->semestre }}
                                        @endif
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- SEMESTRE --}}
                        <div>

                            <label
                                for="semestre"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Semestre
                            </label>

                            <select
                                name="semestre"
                                id="semestre"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar
                                </option>

                                @for($i = 1; $i <= 12; $i++)

                                    <option
                                        value="{{ $i }}"
                                        {{ old('semestre') == $i ? 'selected' : '' }}
                                    >
                                        {{ $i }}°
                                    </option>

                                @endfor

                            </select>

                        </div>

                    </div>

                </div>


                {{-- FECHA Y HORA --}}
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 25px;
                    margin-bottom: 20px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                ">

                    <h3 style="
                        margin: 0 0 20px;
                        font-size: 19px;
                        font-weight: 700;
                        color: #7B1E3A;
                        border-bottom: 1px solid #e5e7eb;
                        padding-bottom: 12px;
                    ">
                        4. Fecha y hora del préstamo
                    </h3>


                    <div style="
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
                        gap: 18px;
                    ">


                        <div>

                            <label
                                for="fecha_prestamo"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Fecha *
                            </label>

                            <input
                                type="date"
                                name="fecha_prestamo"
                                id="fecha_prestamo"
                                value="{{ old('fecha_prestamo', now()->format('Y-m-d')) }}"
                                required
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                "
                            >

                        </div>


                        <div>

                            <label
                                for="hora_prestamo"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Hora *
                            </label>

                            <input
                                type="time"
                                name="hora_prestamo"
                                id="hora_prestamo"
                                value="{{ old('hora_prestamo', now()->format('H:i')) }}"
                                required
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                "
                            >

                        </div>

                    </div>

                </div>


                {{-- RESPONSABLE --}}
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 25px;
                    margin-bottom: 20px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                ">

                    <h3 style="
                        margin: 0 0 20px;
                        font-size: 19px;
                        font-weight: 700;
                        color: #7B1E3A;
                        border-bottom: 1px solid #e5e7eb;
                        padding-bottom: 12px;
                    ">
                        5. Responsable y observaciones
                    </h3>


                    <div style="margin-bottom: 18px;">

                        <label
                            for="responsable_entrega"
                            style="
                                display: block;
                                margin-bottom: 7px;
                                font-weight: 600;
                                color: #374151;
                            "
                        >
                            Responsable de entrega
                        </label>

                        <input
                            type="text"
                            name="responsable_entrega"
                            id="responsable_entrega"
                            value="{{ old('responsable_entrega') }}"
                            maxlength="150"
                            placeholder="Nombre de la persona que entrega el equipo"
                            style="
                                width: 100%;
                                padding: 11px 12px;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                            "
                        >

                    </div>


                    <div>

                        <label
                            for="observaciones"
                            style="
                                display: block;
                                margin-bottom: 7px;
                                font-weight: 600;
                                color: #374151;
                            "
                        >
                            Observaciones
                        </label>

                        <textarea
                            name="observaciones"
                            id="observaciones"
                            rows="4"
                            placeholder="Escribe alguna observación sobre el préstamo..."
                            style="
                                width: 100%;
                                padding: 11px 12px;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                                resize: vertical;
                            "
                        >{{ old('observaciones') }}</textarea>

                    </div>

                </div>


                {{-- BOTONES --}}
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 20px 25px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                    flex-wrap: wrap;
                ">

                    <a
                        href="{{ route('prestamos_equipos.index') }}"
                        style="
                            padding: 11px 20px;
                            background: #6b7280;
                            color: white;
                            text-decoration: none;
                            border-radius: 8px;
                            font-weight: 600;
                        "
                    >
                        Cancelar
                    </a>


                    <button
                        type="submit"
                        style="
                            padding: 11px 24px;
                            background: #7B1E3A;
                            color: white;
                            border: none;
                            border-radius: 8px;
                            font-weight: 700;
                            cursor: pointer;
                        "
                    >
                        Guardar préstamo
                    </button>

                </div>

            </form>

        </div>

    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const docente = document.getElementById('docente_id');
        const buscador = document.getElementById('buscar_alumno');
        const alumnoId = document.getElementById('alumno_id');
        const resultados = document.getElementById('resultados_alumnos');
        const seleccionado = document.getElementById('alumno_seleccionado');
        const quitar = document.getElementById('quitar_alumno');
        const ayuda = document.getElementById('solicitante_ayuda');
        const materiaSelect = document.getElementById('materia_id');
        const semestreSelect = document.getElementById('semestre');
        const urlBusqueda = @json(route('prestamos_equipos.buscar_alumnos'));
        const urlMateriasDocente = @json(url('/prestamos_equipos/materias-por-docente'));
        const materiasOriginales = Array.from(materiaSelect.options)
            .filter(opcion => opcion.value !== '')
            .map(opcion => ({
                id: opcion.value,
                nombre: opcion.textContent.trim(),
                semestre: opcion.dataset.semestre || '',
                clave: opcion.dataset.clave || ''
            }));
        const semestreOriginal = @json(old('semestre', ''));
        const materiaOriginal = @json(old('materia_id', ''));
        let materiasDocente = [];
        let temporizador = null;
        let consultaActual = 0;
        let consultaMateriasActual = 0;

        function limpiarAlumno() {
            alumnoId.value = '';
            buscador.value = '';
            seleccionado.textContent = '';
            seleccionado.style.display = 'none';
            quitar.style.display = 'none';
            resultados.innerHTML = '';
            resultados.style.display = 'none';
        }

        function actualizarEstado() {
            const hayDocente = docente.value !== '';
            const hayAlumno = alumnoId.value !== '';

            buscador.disabled = hayDocente;
            docente.disabled = hayAlumno;

            if (hayDocente) {
                buscador.placeholder = 'No disponible: ya seleccionaste un docente';
                ayuda.textContent = 'Has seleccionado un docente. Para elegir un alumno, primero quita el docente.';
            } else if (hayAlumno) {
                ayuda.textContent = 'Has seleccionado un alumno. Para elegir un docente, primero quita el alumno.';
            } else {
                buscador.placeholder = 'Escribe nombre, apellido o matrícula...';
                ayuda.textContent = 'Selecciona un docente o busca un alumno. Solo puedes elegir uno.';
            }
        }

        function elegirAlumno(alumno) {
            alumnoId.value = alumno.id;
            buscador.value = '';
            seleccionado.textContent = alumno.nombre_completo + ' — Matrícula: ' + (alumno.matricula || 'Sin matrícula') + ' — Grupo: ' + (alumno.grupo || 'Sin grupo');
            seleccionado.style.display = 'block';
            quitar.style.display = 'inline-block';
            resultados.innerHTML = '';
            resultados.style.display = 'none';
            actualizarEstado();
        }

        function limpiarSelect(select, texto) {
            select.innerHTML = '';
            const opcion = document.createElement('option');
            opcion.value = '';
            opcion.textContent = texto;
            select.appendChild(opcion);
        }

        function llenarSemestres(semestres, valorSeleccionado = '') {
            limpiarSelect(semestreSelect, 'Seleccionar semestre');

            semestres.forEach(function (semestre) {
                const opcion = document.createElement('option');
                opcion.value = String(semestre);
                opcion.textContent = semestre + '°';
                if (String(semestre) === String(valorSeleccionado)) {
                    opcion.selected = true;
                }
                semestreSelect.appendChild(opcion);
            });
        }

        function llenarMaterias(materias, semestre = '', valorSeleccionado = '') {
            limpiarSelect(materiaSelect, 'Seleccionar asignatura');

            materias
                .filter(materia => !semestre || String(materia.semestre) === String(semestre))
                .forEach(function (materia) {
                    const opcion = document.createElement('option');
                    opcion.value = materia.id;
                    opcion.textContent =
                        (materia.clave ? materia.clave + ' — ' : '') +
                        materia.nombre +
                        (materia.semestre ? ' — Semestre ' + materia.semestre : '');

                    if (String(materia.id) === String(valorSeleccionado)) {
                        opcion.selected = true;
                    }

                    materiaSelect.appendChild(opcion);
                });
        }

        function restaurarCatalogoGeneral() {
            materiasDocente = [];
            llenarSemestres(
                Array.from({ length: 12 }, (_, indice) => indice + 1),
                semestreOriginal
            );
            llenarMaterias(materiasOriginales, semestreOriginal, materiaOriginal);
        }

        async function cargarMateriasDocente(docenteId, conservarSeleccion = false) {
            const numeroConsulta = ++consultaMateriasActual;

            if (!docenteId) {
                restaurarCatalogoGeneral();
                return;
            }

            limpiarSelect(semestreSelect, 'Cargando semestres...');
            limpiarSelect(materiaSelect, 'Cargando asignaturas...');

            try {
                const respuesta = await fetch(
                    urlMateriasDocente + '/' + encodeURIComponent(docenteId),
                    {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    }
                );

                if (!respuesta.ok) {
                    throw new Error('No se pudieron cargar las materias del docente.');
                }

                const materias = await respuesta.json();

                if (numeroConsulta !== consultaMateriasActual) return;

                materiasDocente = materias.map(materia => ({
                    id: materia.id,
                    nombre: materia.nombre,
                    semestre: materia.semestre,
                    clave: materia.clave || ''
                }));

                const semestres = [...new Set(
                    materiasDocente
                        .map(materia => Number(materia.semestre))
                        .filter(semestre => Number.isFinite(semestre) && semestre > 0)
                )].sort((a, b) => a - b);

                llenarSemestres(semestres, conservarSeleccion ? semestreOriginal : '');

                const semestreActual = semestreSelect.value;
                llenarMaterias(
                    materiasDocente,
                    semestreActual,
                    conservarSeleccion ? materiaOriginal : ''
                );

                if (semestres.length === 0) {
                    limpiarSelect(semestreSelect, 'Este docente no tiene semestres asignados');
                    limpiarSelect(materiaSelect, 'No hay asignaturas disponibles');
                }
            } catch (error) {
                if (numeroConsulta !== consultaMateriasActual) return;
                limpiarSelect(semestreSelect, 'Error al cargar semestres');
                limpiarSelect(materiaSelect, 'No se pudieron cargar asignaturas');
                ayuda.textContent = 'No fue posible consultar las materias del docente. Verifica sus asignaciones e intenta nuevamente.';
            }
        }

        function mostrarMensaje(mensaje) {
            resultados.innerHTML = '';
            const fila = document.createElement('div');
            fila.textContent = mensaje;
            fila.style.cssText = 'padding:11px 12px;color:#6b7280;font-size:13px;';
            resultados.appendChild(fila);
            resultados.style.display = 'block';
        }

        buscador.addEventListener('input', function () {
            const termino = this.value.trim();
            clearTimeout(temporizador);
            const numeroConsulta = ++consultaActual;

            if (termino.length < 2) {
                resultados.innerHTML = '';
                resultados.style.display = 'none';
                return;
            }

            temporizador = setTimeout(async function () {
                mostrarMensaje('Buscando alumnos...');
                try {
                    const respuesta = await fetch(urlBusqueda + '?q=' + encodeURIComponent(termino), {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    if (!respuesta.ok) throw new Error('No se pudo realizar la búsqueda.');
                    const alumnos = await respuesta.json();
                    if (numeroConsulta !== consultaActual) return;

                    resultados.innerHTML = '';
                    if (!alumnos.length) {
                        mostrarMensaje('No se encontraron alumnos.');
                        return;
                    }

                    alumnos.slice(0, 10).forEach(function (alumno) {
                        const opcion = document.createElement('button');
                        opcion.type = 'button';
                        opcion.style.cssText = 'display:block;width:100%;padding:11px 12px;text-align:left;background:white;border:0;border-bottom:1px solid #e5e7eb;cursor:pointer;color:#1f2937;font-size:13px;';

                        const nombre = document.createElement('strong');
                        nombre.textContent = alumno.nombre_completo;
                        nombre.style.display = 'block';
                        const detalle = document.createElement('span');
                        detalle.textContent = 'Matrícula: ' + (alumno.matricula || 'Sin matrícula') + ' · Grupo: ' + (alumno.grupo || 'Sin grupo');
                        detalle.style.cssText = 'display:block;margin-top:4px;color:#6b7280;font-size:12px;';
                        opcion.appendChild(nombre);
                        opcion.appendChild(detalle);
                        opcion.addEventListener('click', function () { elegirAlumno(alumno); });
                        opcion.addEventListener('mouseenter', function () { this.style.background = '#fdf2f5'; });
                        opcion.addEventListener('mouseleave', function () { this.style.background = 'white'; });
                        resultados.appendChild(opcion);
                    });
                    resultados.style.display = 'block';
                } catch (error) {
                    if (numeroConsulta === consultaActual) mostrarMensaje('Ocurrió un error al buscar. Intenta nuevamente.');
                }
            }, 300);
        });

        docente.addEventListener('change', function () {
            if (this.value) {
                limpiarAlumno();
                cargarMateriasDocente(this.value);
            } else {
                restaurarCatalogoGeneral();
            }
            actualizarEstado();
        });

        semestreSelect.addEventListener('change', function () {
            if (docente.value) {
                llenarMaterias(materiasDocente, this.value);
            } else {
                llenarMaterias(materiasOriginales, this.value);
            }
        });

        quitar.addEventListener('click', function () {
            limpiarAlumno();
            actualizarEstado();
            buscador.focus();
        });

        document.addEventListener('click', function (event) {
            if (!resultados.contains(event.target) && event.target !== buscador) {
                resultados.style.display = 'none';
            }
        });

        actualizarEstado();

        // Si el formulario regresó con errores, recuperar las materias del docente.
        if (docente.value) {
            cargarMateriasDocente(docente.value, true);
        } else {
            restaurarCatalogoGeneral();
        }

        // Recuperar el alumno seleccionado si el formulario regresó con errores.
        if (alumnoId.value) {
            fetch(urlBusqueda + '?id=' + encodeURIComponent(alumnoId.value), {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.ok ? response.json() : [])
            .then(alumnos => {
                if (alumnos.length) elegirAlumno(alumnos[0]);
                else {
                    seleccionado.textContent = 'Alumno seleccionado (ID ' + alumnoId.value + ').';
                    seleccionado.style.display = 'block';
                    quitar.style.display = 'inline-block';
                    actualizarEstado();
                }
            })
            .catch(() => {});
        }
    });
    </script>

</x-app-layout>