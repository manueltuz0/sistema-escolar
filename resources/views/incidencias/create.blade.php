<x-app-layout>

    <div class="min-h-screen bg-slate-100 py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ========================================================= --}}
            {{-- ENCABEZADO --}}
            {{-- ========================================================= --}}

            <div class="mb-8">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>

                        <div class="flex items-center gap-3">

                            <div class="w-12 h-12 rounded-2xl bg-indigo-600
                                        flex items-center justify-center
                                        text-white text-xl shadow-lg">

                                ⚠️

                            </div>

                            <div>

                                <h1 class="text-3xl font-bold text-slate-800">
                                    Registrar incidencia
                                </h1>

                                <p class="text-slate-500 mt-1">
                                    Registra una situación escolar y establece su seguimiento.
                                </p>

                            </div>

                        </div>

                    </div>

                    <a
                        href="{{ route('incidencias.index') }}"
                        class="inline-flex items-center justify-center
                               px-5 py-2.5 rounded-xl
                               bg-white border border-slate-200
                               text-slate-700 font-semibold
                               hover:bg-slate-50 transition"
                    >
                        ← Regresar
                    </a>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- ERRORES --}}
            {{-- ========================================================= --}}

            @if ($errors->any())

                <div class="mb-6 rounded-2xl border border-red-200
                            bg-red-50 p-5">

                    <div class="font-bold text-red-800 mb-2">
                        Revisa los siguientes datos:
                    </div>

                    <ul class="list-disc list-inside text-sm text-red-700">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                method="POST"
                action="{{ route('incidencias.store') }}"
                id="formIncidencia"
            >

                @csrf


                {{-- ===================================================== --}}
                {{-- SELECCIÓN DEL ALUMNO --}}
                {{-- ===================================================== --}}

                <div class="bg-white rounded-3xl shadow-sm
                            border border-slate-200 overflow-hidden mb-6">

                    <div class="px-6 py-5 border-b border-slate-200
                                bg-gradient-to-r from-indigo-50 to-white">

                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-xl bg-indigo-100
                                        flex items-center justify-center">

                                👤

                            </div>

                            <div>

                                <h2 class="font-bold text-lg text-slate-800">
                                    Alumno
                                </h2>

                                <p class="text-sm text-slate-500">
                                    Busca al alumno por nombre, apellido o matrícula.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="p-6">

                        <label
                            for="buscarAlumno"
                            class="block text-sm font-semibold text-slate-700 mb-2"
                        >
                            Buscar alumno
                        </label>


                        {{-- BUSCADOR --}}

                        <div class="relative">

                            <span
                                class="absolute left-4 top-1/2
                                       -translate-y-1/2 text-slate-400"
                            >
                                🔍
                            </span>

                            <input
                                type="text"
                                id="buscarAlumno"
                                autocomplete="off"
                                placeholder="Escribe nombre, apellido o matrícula..."
                                class="w-full pl-11 pr-4 py-3 rounded-xl
                                       border border-slate-300
                                       focus:border-indigo-500
                                       focus:ring-indigo-500"
                            >

                        </div>


                        {{-- RESULTADOS DE BÚSQUEDA --}}

                        <div
                            id="resultadosAlumnos"
                            class="mt-3 space-y-2 max-h-72
                                   overflow-y-auto hidden"
                        >

                            @foreach ($alumnos as $alumno)

                                <button
                                    type="button"
                                    class="resultado-alumno w-full text-left
                                           p-4 rounded-xl border border-slate-200
                                           bg-white hover:bg-indigo-50
                                           hover:border-indigo-300
                                           transition"
                                    data-id="{{ $alumno->id }}"
                                    data-nombre="{{ strtolower($alumno->nombres . ' ' . $alumno->apellidos) }}"
                                    data-apellidos="{{ strtolower($alumno->apellidos) }}"
                                    data-matricula="{{ strtolower($alumno->matricula) }}"
                                >

                                    <div class="flex items-center justify-between gap-4">

                                        <div>

                                            <div class="font-bold text-slate-800">

                                                {{ $alumno->apellidos }},
                                                {{ $alumno->nombres }}

                                            </div>

                                            <div class="text-sm text-slate-500 mt-1">

                                                Matrícula:
                                                <span class="font-semibold">
                                                    {{ $alumno->matricula }}
                                                </span>

                                                <span class="mx-2">
                                                    •
                                                </span>

                                                Grupo:

                                                <span class="font-semibold">

                                                    {{ $alumno->grupo->nombre ?? 'Sin grupo' }}

                                                </span>

                                            </div>

                                        </div>

                                        <span class="text-indigo-600">
                                            →
                                        </span>

                                    </div>

                                </button>

                            @endforeach

                        </div>


                        <div
                            id="sinResultados"
                            class="hidden mt-4 p-4 rounded-xl
                                   bg-amber-50 border border-amber-200
                                   text-amber-700 text-sm"
                        >
                            No se encontró ningún alumno con esa información.
                        </div>


                        {{-- ALUMNO SELECCIONADO --}}

                        <div
                            id="alumnoSeleccionado"
                            class="hidden mt-5"
                        >

                            <div class="rounded-2xl border-2 border-indigo-200
                                        bg-indigo-50 p-5">

                                <div class="flex items-start justify-between gap-4">

                                    <div class="flex items-start gap-4">

                                        <div class="w-12 h-12 rounded-xl
                                                    bg-indigo-600 text-white
                                                    flex items-center justify-center
                                                    text-xl">

                                            👤

                                        </div>

                                        <div>

                                            <div class="text-xs uppercase
                                                        tracking-wide
                                                        text-indigo-600
                                                        font-bold">

                                                Alumno seleccionado

                                            </div>

                                            <h3
                                                id="alumnoNombre"
                                                class="text-xl font-bold
                                                       text-slate-800 mt-1"
                                            >
                                            </h3>

                                            <div class="grid sm:grid-cols-2 gap-x-8 gap-y-1 mt-2
                                                        text-sm text-slate-600">

                                                <div>
                                                    <strong>Matrícula:</strong>
                                                    <span id="alumnoMatricula"></span>
                                                </div>

                                                <div>
                                                    <strong>Grupo:</strong>
                                                    <span id="alumnoGrupo"></span>
                                                </div>

                                                <div>
                                                    <strong>Correo:</strong>
                                                    <span id="alumnoEmail"></span>
                                                </div>

                                            </div>

                                        </div>

                                    </div>


                                    <button
                                        type="button"
                                        id="cambiarAlumno"
                                        class="text-sm font-semibold
                                               text-indigo-600
                                               hover:text-indigo-800"
                                    >
                                        Cambiar
                                    </button>

                                </div>

                            </div>

                        </div>


                        {{-- CAMPO OCULTO --}}

                        <input
                            type="hidden"
                            name="alumno_id"
                            id="alumno_id"
                            value="{{ old('alumno_id') }}"
                        >

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- INFORMACIÓN DE LA INCIDENCIA --}}
                {{-- ===================================================== --}}

                <div class="bg-white rounded-3xl shadow-sm
                            border border-slate-200 overflow-hidden mb-6">

                    <div class="px-6 py-5 border-b border-slate-200
                                bg-gradient-to-r from-amber-50 to-white">

                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-xl bg-amber-100
                                        flex items-center justify-center">

                                ⚠️

                            </div>

                            <div>

                                <h2 class="font-bold text-lg text-slate-800">
                                    Información de la incidencia
                                </h2>

                                <p class="text-sm text-slate-500">
                                    Describe claramente la situación presentada.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">


                        {{-- FECHA --}}

                        <div>

                            <label
                                for="fecha"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Fecha *
                            </label>

                            <input
                                type="date"
                                name="fecha"
                                id="fecha"
                                value="{{ old('fecha', date('Y-m-d')) }}"
                                required
                                class="w-full rounded-xl border-slate-300
                                       focus:border-indigo-500
                                       focus:ring-indigo-500"
                            >

                        </div>


                        {{-- TIPO --}}

                        <div>

                            <label
                                for="tipo"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Tipo de incidencia *
                            </label>

                            <select
                                name="tipo"
                                id="tipo"
                                required
                                class="w-full rounded-xl border-slate-300
                                       focus:border-indigo-500
                                       focus:ring-indigo-500"
                            >

                                <option value="">
                                    Selecciona un tipo
                                </option>

                                <option
                                    value="Académica"
                                    @selected(old('tipo') === 'Académica')
                                >
                                    Académica
                                </option>

                                <option
                                    value="Conducta"
                                    @selected(old('tipo') === 'Conducta')
                                >
                                    Conducta
                                </option>

                                <option
                                    value="Asistencia"
                                    @selected(old('tipo') === 'Asistencia')
                                >
                                    Asistencia
                                </option>

                                <option
                                    value="Convivencia"
                                    @selected(old('tipo') === 'Convivencia')
                                >
                                    Convivencia escolar
                                </option>

                                <option
                                    value="Disciplina"
                                    @selected(old('tipo') === 'Disciplina')
                                >
                                    Disciplina
                                </option>

                                <option
                                    value="Otro"
                                    @selected(old('tipo') === 'Otro')
                                >
                                    Otro
                                </option>

                            </select>

                        </div>


                        {{-- PRIORIDAD --}}

                        <div>

                            <label
                                for="prioridad"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Prioridad *
                            </label>

                            <select
                                name="prioridad"
                                id="prioridad"
                                required
                                class="w-full rounded-xl border-slate-300
                                       focus:border-indigo-500
                                       focus:ring-indigo-500"
                            >

                                <option
                                    value="Baja"
                                    @selected(old('prioridad') === 'Baja')
                                >
                                    🟢 Baja
                                </option>

                                <option
                                    value="Media"
                                    @selected(old('prioridad', 'Media') === 'Media')
                                >
                                    🟡 Media
                                </option>

                                <option
                                    value="Alta"
                                    @selected(old('prioridad') === 'Alta')
                                >
                                    🔴 Alta
                                </option>

                            </select>

                        </div>


                        {{-- ESTADO --}}

                        <div>

                            <label
                                for="estado"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Estado *
                            </label>

                            <select
                                name="estado"
                                id="estado"
                                required
                                class="w-full rounded-xl border-slate-300
                                       focus:border-indigo-500
                                       focus:ring-indigo-500"
                            >

                                <option
                                    value="Pendiente"
                                    @selected(old('estado', 'Pendiente') === 'Pendiente')
                                >
                                    Pendiente
                                </option>

                                <option
                                    value="En seguimiento"
                                    @selected(old('estado') === 'En seguimiento')
                                >
                                    En seguimiento
                                </option>

                                <option
                                    value="Atendida"
                                    @selected(old('estado') === 'Atendida')
                                >
                                    Atendida
                                </option>

                                <option
                                    value="Concluida"
                                    @selected(old('estado') === 'Concluida')
                                >
                                    Concluida
                                </option>

                            </select>

                        </div>


                        {{-- LUGAR --}}

                        <div class="md:col-span-2">

                            <label
                                for="lugar"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Lugar
                            </label>

                            <input
                                type="text"
                                name="lugar"
                                id="lugar"
                                value="{{ old('lugar') }}"
                                placeholder="Ejemplo: Aula 3, patio, laboratorio..."
                                class="w-full rounded-xl border-slate-300
                                       focus:border-indigo-500
                                       focus:ring-indigo-500"
                            >

                        </div>


                        {{-- DESCRIPCIÓN --}}

                        <div class="md:col-span-2">

                            <label
                                for="descripcion"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Descripción de la situación *
                            </label>

                            <textarea
                                name="descripcion"
                                id="descripcion"
                                rows="5"
                                required
                                placeholder="Describe de manera clara lo ocurrido..."
                                class="w-full rounded-xl border-slate-300
                                       focus:border-indigo-500
                                       focus:ring-indigo-500"
                            >{{ old('descripcion') }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- ATENCIÓN Y SEGUIMIENTO --}}
                {{-- ===================================================== --}}

                <div class="bg-white rounded-3xl shadow-sm
                            border border-slate-200 overflow-hidden mb-6">

                    <div class="px-6 py-5 border-b border-slate-200
                                bg-gradient-to-r from-emerald-50 to-white">

                        <div class="flex items-center gap-3">

                            <div class="w-10 h-10 rounded-xl bg-emerald-100
                                        flex items-center justify-center">

                                📋

                            </div>

                            <div>

                                <h2 class="font-bold text-lg text-slate-800">
                                    Atención y seguimiento
                                </h2>

                                <p class="text-sm text-slate-500">
                                    Registra las acciones realizadas y cualquier información adicional.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="p-6 space-y-6">


                        {{-- ACCIONES --}}

                        <div>

                            <label
                                for="acciones_realizadas"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Acciones realizadas
                            </label>

                            <textarea
                                name="acciones_realizadas"
                                id="acciones_realizadas"
                                rows="4"
                                placeholder="Describe las acciones realizadas con el alumno..."
                                class="w-full rounded-xl border-slate-300
                                       focus:border-indigo-500
                                       focus:ring-indigo-500"
                            >{{ old('acciones_realizadas') }}</textarea>

                        </div>


                        {{-- OBSERVACIONES --}}

                        <div>

                            <label
                                for="observaciones"
                                class="block text-sm font-semibold text-slate-700 mb-2"
                            >
                                Observaciones
                            </label>

                            <textarea
                                name="observaciones"
                                id="observaciones"
                                rows="4"
                                placeholder="Agrega observaciones importantes..."
                                class="w-full rounded-xl border-slate-300
                                       focus:border-indigo-500
                                       focus:ring-indigo-500"
                            >{{ old('observaciones') }}</textarea>

                        </div>

                    </div>

                </div>


                {{-- ===================================================== --}}
                {{-- BOTONES --}}
                {{-- ===================================================== --}}

                <div class="flex flex-col sm:flex-row
                            justify-end gap-3">

                    <a
                        href="{{ route('incidencias.index') }}"
                        class="px-6 py-3 rounded-xl
                               bg-white border border-slate-300
                               text-slate-700 font-semibold
                               text-center hover:bg-slate-50 transition"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="px-7 py-3 rounded-xl
                               bg-indigo-600 text-white
                               font-bold shadow-lg
                               hover:bg-indigo-700
                               transition"
                    >
                        Registrar incidencia
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- ================================================================ --}}
    {{-- JAVASCRIPT DEL BUSCADOR --}}
    {{-- ================================================================ --}}

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const buscador = document.getElementById('buscarAlumno');

            const resultados = document.getElementById('resultadosAlumnos');

            const sinResultados = document.getElementById('sinResultados');

            const alumnoId = document.getElementById('alumno_id');

            const alumnoSeleccionado =
                document.getElementById('alumnoSeleccionado');

            const alumnoNombre =
                document.getElementById('alumnoNombre');

            const alumnoMatricula =
                document.getElementById('alumnoMatricula');

            const alumnoGrupo =
                document.getElementById('alumnoGrupo');

            const alumnoEmail =
                document.getElementById('alumnoEmail');

            const cambiarAlumno =
                document.getElementById('cambiarAlumno');

            const botones =
                document.querySelectorAll('.resultado-alumno');


            /*
            |--------------------------------------------------------------------------
            | BUSCAR ALUMNO
            |--------------------------------------------------------------------------
            */

            buscador.addEventListener('input', function () {

                const texto =
                    this.value
                        .toLowerCase()
                        .trim();

                let encontrados = 0;


                if (texto.length === 0) {

                    resultados.classList.add('hidden');

                    sinResultados.classList.add('hidden');

                    return;
                }


                resultados.classList.remove('hidden');


                botones.forEach(function (boton) {

                    const nombre =
                        boton.dataset.nombre || '';

                    const apellidos =
                        boton.dataset.apellidos || '';

                    const matricula =
                        boton.dataset.matricula || '';


                    const coincide =
                        nombre.includes(texto) ||
                        apellidos.includes(texto) ||
                        matricula.includes(texto);


                    if (coincide) {

                        boton.classList.remove('hidden');

                        encontrados++;

                    } else {

                        boton.classList.add('hidden');

                    }

                });


                if (encontrados === 0) {

                    sinResultados.classList.remove('hidden');

                } else {

                    sinResultados.classList.add('hidden');

                }

            });


            /*
            |--------------------------------------------------------------------------
            | SELECCIONAR ALUMNO
            |--------------------------------------------------------------------------
            */

            botones.forEach(function (boton) {

                boton.addEventListener('click', function () {

                    const id =
                        this.dataset.id;


                    const nombre =
                        this.querySelector(
                            '.font-bold'
                        ).textContent.trim();


                    const informacion =
                        this.querySelector(
                            '.text-sm'
                        ).textContent;


                    alumnoId.value = id;


                    const partes =
                        informacion.split('•');


                    let matricula = '';

                    let grupo = '';


                    if (partes.length > 0) {

                        matricula =
                            partes[0]
                                .replace('Matrícula:', '')
                                .trim();

                    }


                    if (partes.length > 1) {

                        grupo =
                            partes[1]
                                .replace('Grupo:', '')
                                .trim();

                    }


                    alumnoNombre.textContent =
                        nombre;

                    alumnoMatricula.textContent =
                        matricula;

                    alumnoGrupo.textContent =
                        grupo;


                    /*
                    |--------------------------------------------------------------------------
                    | CORREO
                    |--------------------------------------------------------------------------
                    */

                    alumnoEmail.textContent =
    'Registrado en el sistema';


                    /*
                    |--------------------------------------------------------------------------
                    | MOSTRAR ALUMNO
                    |--------------------------------------------------------------------------
                    */

                    alumnoEmail.textContent =
                        'Registrado en el sistema';


                    alumnoSeleccionado.classList.remove(
                        'hidden'
                    );

                    resultados.classList.add(
                        'hidden'
                    );

                    sinResultados.classList.add(
                        'hidden'
                    );

                    buscador.value =
                        '';

                });

            });


            /*
            |--------------------------------------------------------------------------
            | CAMBIAR ALUMNO
            |--------------------------------------------------------------------------
            */

            cambiarAlumno.addEventListener('click', function () {

                alumnoId.value = '';

                alumnoSeleccionado.classList.add(
                    'hidden'
                );

                buscador.value = '';

                buscador.focus();

            });


            /*
            |--------------------------------------------------------------------------
            | VALIDAR AL ENVIAR
            |--------------------------------------------------------------------------
            */

            document
                .getElementById('formIncidencia')
                .addEventListener('submit', function (event) {

                    if (!alumnoId.value) {

                        event.preventDefault();

                        alert(
                            'Debes seleccionar un alumno antes de registrar la incidencia.'
                        );

                        buscador.focus();

                    }

                });

        });

    </script>

</x-app-layout>