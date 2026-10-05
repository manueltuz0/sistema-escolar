<x-app-layout>

    <div class="min-h-screen bg-gray-50 py-8">

        <div class="max-w-7xl mx-auto px-6">

            {{-- ===================================================== --}}
            {{-- ENCABEZADO --}}
            {{-- ===================================================== --}}

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-7">

                <div>

                    <h1 class="text-2xl font-bold text-gray-800">
                        Gestión de Grupos
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Administra los grupos escolares y consulta sus alumnos.
                    </p>

                </div>

                <div class="flex items-center gap-2">

                    <a
                        href="{{ route('dashboard') }}"
                        class="px-4 py-2 bg-white border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-100 text-sm"
                    >
                        ← Dashboard
                    </a>

                    <a
                        href="{{ route('grupos.create') }}"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-semibold shadow-sm"
                    >
                        + Registrar grupo
                    </a>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- MENSAJES --}}
            {{-- ===================================================== --}}

            @if(session('success'))

                <div class="mb-5 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm">
                    ✓ {{ session('success') }}
                </div>

            @endif


            @if(session('error'))

                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm">
                    ⚠ {{ session('error') }}
                </div>

            @endif


            {{-- ===================================================== --}}
            {{-- BUSCADOR --}}
            {{-- ===================================================== --}}

            <div class="mb-8">

                <div class="max-w-4xl mx-auto bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

                    <div class="flex items-center gap-3 mb-4">

                        <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                            🔎
                        </div>

                        <div>

                            <h2 class="font-semibold text-gray-800">
                                Buscar grupos
                            </h2>

                            <p class="text-xs text-gray-500">
                                Busca por grupo, especialidad o grado.
                            </p>

                        </div>

                    </div>


                    <form
                        action="{{ route('grupos.index') }}"
                        method="GET"
                    >

                        <div class="flex flex-col md:flex-row gap-3">

                            {{-- BUSCAR --}}

                            <div class="flex-1">

                                <label
                                    for="buscar"
                                    class="block text-xs font-semibold text-gray-600 mb-1.5"
                                >
                                    Nombre o especialidad
                                </label>

                                <input
                                    type="text"
                                    id="buscar"
                                    name="buscar"
                                    value="{{ $busqueda }}"
                                    placeholder="Ej. A, B, C o especialidad..."
                                    class="w-full h-10 rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                                >

                            </div>


                            {{-- GRADO --}}

                            <div class="w-full md:w-44">

                                <label
                                    for="grado"
                                    class="block text-xs font-semibold text-gray-600 mb-1.5"
                                >
                                    Grado
                                </label>

                                <select
                                    id="grado"
                                    name="grado"
                                    class="w-full h-10 rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500"
                                >

                                    <option value="">
                                        Todos
                                    </option>

                                    @foreach($grados as $gradoItem)

                                        <option
                                            value="{{ $gradoItem }}"
                                            {{ (string)$grado === (string)$gradoItem ? 'selected' : '' }}
                                        >
                                            {{ $gradoItem }}° grado
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- BOTÓN BUSCAR --}}

                            <div class="flex items-end">

                                <button
                                    type="submit"
                                    class="h-10 px-6 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold text-sm shadow-sm"
                                >
                                    🔎 Buscar
                                </button>

                            </div>

                        </div>


                        {{-- LIMPIAR --}}

                        @if(request()->has('buscar') || request()->has('grado'))

                            <div class="mt-3">

                                <a
                                    href="{{ route('grupos.index') }}"
                                    class="text-xs text-gray-500 hover:text-blue-600"
                                >
                                    ← Limpiar búsqueda
                                </a>

                            </div>

                        @endif

                    </form>

                </div>

            </div>


            {{-- ===================================================== --}}
            {{-- RESULTADOS --}}
            {{-- ===================================================== --}}

            @if(request()->has('buscar') || request()->has('grado'))

                <div class="flex items-center justify-between mb-4">

                    <div>

                        <h2 class="text-lg font-bold text-gray-800">
                            Grupos encontrados
                        </h2>

                        <p class="text-xs text-gray-500 mt-1">
                            Resultados de la búsqueda.
                        </p>

                    </div>


                    <div class="px-3 py-1.5 bg-white border border-gray-200 rounded-lg">

                        <span class="text-sm font-semibold text-gray-600">
                            {{ $grupos->total() }}
                        </span>

                        <span class="text-xs text-gray-400">
                            {{ $grupos->total() == 1 ? 'grupo' : 'grupos' }}
                        </span>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- SIN RESULTADOS --}}
                {{-- ================================================= --}}

                @if($grupos->count() === 0)

                    <div class="bg-white rounded-2xl border border-gray-200 p-14 text-center">

                        <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center text-3xl mb-4">
                            🔎
                        </div>

                        <h3 class="font-semibold text-gray-700">
                            No se encontraron grupos
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Intenta con otro nombre, especialidad o grado.
                        </p>

                    </div>


                @else


                    {{-- ================================================= --}}
                    {{-- TARJETAS --}}
                    {{-- ================================================= --}}

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">

                        @foreach($grupos as $grupo)

                            <div
                                class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden hover:shadow-md transition duration-200"
                            >


                                {{-- ===================================== --}}
                                {{-- CABECERA DE TARJETA --}}
                                {{-- ===================================== --}}

                                <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-5 py-4">

                                    <div class="flex items-center justify-between gap-4">


                                        <div>

                                            <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide">
                                                Grupo escolar
                                            </p>


                                            {{-- ================================= --}}
                                            {{-- GRADO Y LETRA DEL GRUPO --}}
                                            {{-- ================================= --}}

                                            <div class="flex items-center gap-2 mt-1">

                                                <h3 class="text-2xl font-bold text-white">
                                                    {{ $grupo->grado }}° grado
                                                </h3>

                                                <span class="text-blue-100 text-xl">
                                                    —
                                                </span>

                                                <span class="text-2xl font-bold text-white">
                                                    {{ strtoupper($grupo->nombre) }}
                                                </span>

                                            </div>


                                            <p class="text-blue-100 text-xs mt-1">
                                                Grupo {{ strtoupper($grupo->nombre) }}
                                            </p>

                                        </div>


                                        {{-- ================================= --}}
                                        {{-- IDENTIFICADOR --}}
                                        {{-- ================================= --}}

                                        <div
                                            class="w-14 h-14 flex-shrink-0 rounded-xl bg-white/20 border border-white/20 flex items-center justify-center"
                                        >

                                            <span class="text-white text-lg font-bold">
                                                {{ $grupo->grado }}°{{ strtoupper($grupo->nombre) }}
                                            </span>

                                        </div>

                                    </div>

                                </div>


                                {{-- ===================================== --}}
                                {{-- INFORMACIÓN --}}
                                {{-- ===================================== --}}

                                <div class="p-5">


                                    {{-- GRADO --}}

                                    <div class="flex items-center gap-3 mb-4">

                                        <div class="w-9 h-9 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                            🎓
                                        </div>

                                        <div>

                                            <p class="text-xs text-gray-400">
                                                Grado
                                            </p>

                                            <p class="text-sm font-semibold text-gray-700">
                                                {{ $grupo->grado }}° grado
                                            </p>

                                        </div>

                                    </div>


                                    {{-- ESPECIALIDAD --}}

                                    <div class="flex items-center gap-3 mb-4">

                                        <div class="w-9 h-9 rounded-lg bg-purple-50 flex items-center justify-center text-purple-600">
                                            📚
                                        </div>

                                        <div class="min-w-0">

                                            <p class="text-xs text-gray-400">
                                                Especialidad
                                            </p>

                                            <p class="text-sm font-semibold text-gray-700 truncate">
                                                {{ $grupo->especialidad ?: 'General' }}
                                            </p>

                                        </div>

                                    </div>


                                    {{-- CICLO ESCOLAR --}}

                                    <div class="flex items-center gap-3 mb-4">

                                        <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                                            📅
                                        </div>

                                        <div>

                                            <p class="text-xs text-gray-400">
                                                Ciclo escolar
                                            </p>

                                            <p class="text-sm font-semibold text-gray-700">
                                                {{ $grupo->cicloEscolar->nombre ?? 'Sin ciclo' }}
                                            </p>

                                        </div>

                                    </div>


                                    {{-- ALUMNOS --}}

                                    <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">

                                        <div class="flex items-center gap-3">

                                            <div class="w-9 h-9 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                                👥
                                            </div>

                                            <div>

                                                <p class="text-xs text-gray-400">
                                                    Alumnos
                                                </p>

                                                <p class="text-sm font-semibold text-gray-700">
                                                    {{ $grupo->alumnos_count }}
                                                </p>

                                            </div>

                                        </div>


                                        <span class="text-xs text-gray-400">
                                            registrados
                                        </span>

                                    </div>


                                    {{-- ===================================== --}}
                                    {{-- BOTONES --}}
                                    {{-- ===================================== --}}

                                    <div class="grid grid-cols-2 gap-2 mt-5">


                                        <a
                                            href="{{ route('grupos.show', $grupo) }}"
                                            class="flex items-center justify-center gap-1.5 px-3 py-2.5 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 text-sm font-semibold"
                                        >
                                            👁 Ver
                                        </a>


                                        <a
                                            href="{{ route('grupos.edit', $grupo) }}"
                                            class="flex items-center justify-center gap-1.5 px-3 py-2.5 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-semibold"
                                        >
                                            ✏ Editar
                                        </a>

                                    </div>


                                    {{-- ===================================== --}}
                                    {{-- ELIMINAR --}}
                                    {{-- ===================================== --}}

                                    <form
                                        action="{{ route('grupos.destroy', $grupo) }}"
                                        method="POST"
                                        class="mt-2"
                                        onsubmit="return confirm('¿Seguro que deseas eliminar este grupo?');"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="w-full flex items-center justify-center gap-1.5 px-3 py-2 text-red-600 hover:bg-red-50 rounded-lg text-xs font-medium"
                                        >
                                            🗑 Eliminar grupo
                                        </button>

                                    </form>


                                </div>

                            </div>

                        @endforeach

                    </div>


                    {{-- =============================================== --}}
                    {{-- PAGINACIÓN --}}
                    {{-- =============================================== --}}

                    @if($grupos->hasPages())

                        <div class="mt-6 bg-white rounded-xl border border-gray-200 p-4">

                            {{ $grupos->links() }}

                        </div>

                    @endif


                @endif


            @else


                {{-- ================================================= --}}
                {{-- ESTADO INICIAL --}}
                {{-- ================================================= --}}

                <div class="max-w-4xl mx-auto">

                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-14 text-center">

                        <div class="w-20 h-20 mx-auto rounded-2xl bg-blue-50 flex items-center justify-center text-4xl mb-5">
                            👥
                        </div>

                        <h2 class="text-xl font-bold text-gray-800">
                            Consulta tus grupos
                        </h2>

                        <p class="text-sm text-gray-500 mt-2 max-w-md mx-auto">
                            Utiliza el buscador para encontrar un grupo por nombre,
                            especialidad o grado.
                        </p>

                    </div>

                </div>

            @endif


        </div>

    </div>

</x-app-layout>