@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ========================================================= --}}
        {{-- ENCABEZADO --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>

                    <div class="flex items-center gap-3 mb-2">

                        <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M5.121 17.804A9 9 0 1118.879 6.196M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>

                            </svg>
                        </div>

                        <div>

                            <h1 class="text-2xl font-bold text-gray-800">
                                Historial del alumno
                            </h1>

                            <p class="text-sm text-gray-500">
                                Incidencias y tutorías
                            </p>

                        </div>

                    </div>

                </div>


                {{-- BOTONES --}}

                <div class="flex flex-wrap gap-2">

                    <a href="{{ route('incidencias.index') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                              bg-gray-100 text-gray-700 hover:bg-gray-200
                              transition font-medium">

                        ← Regresar

                    </a>


                    <a href="{{ route('incidencias.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg
                              bg-blue-600 text-white hover:bg-blue-700
                              transition font-medium">

                        + Registrar incidencia

                    </a>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- INFORMACIÓN DEL ALUMNO --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                {{-- ALUMNO --}}

                <div>

                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Alumno
                    </p>

                    <p class="mt-1 text-lg font-bold text-gray-800">

                        {{ $alumno->apellidos }},
                        {{ $alumno->nombres }}

                    </p>

                </div>


                {{-- MATRÍCULA --}}

                <div>

                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Matrícula
                    </p>

                    <p class="mt-1 text-lg font-semibold text-gray-800">

                        {{ $alumno->matricula }}

                    </p>

                </div>


                {{-- GRUPO --}}

                <div>

                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                        Grupo
                    </p>

                    <p class="mt-1 text-lg font-semibold text-gray-800">

                        {{ $alumno->grupo->nombre ?? 'Sin grupo' }}

                    </p>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- RESUMEN COMPACTO --}}
        {{-- ========================================================= --}}

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">

            {{-- INCIDENCIAS --}}

            <div class="bg-white border border-red-100 rounded-xl shadow-sm p-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500">
                            Incidencias registradas
                        </p>

                        <p class="text-3xl font-bold text-red-600 mt-1">
                            {{ $incidencias->count() }}
                        </p>

                    </div>

                    <div class="w-12 h-12 rounded-xl bg-red-50
                                flex items-center justify-center">

                        <span class="text-xl">
                            ⚠️
                        </span>

                    </div>

                </div>

            </div>


            {{-- TUTORÍAS --}}

            <div class="bg-white border border-blue-100 rounded-xl shadow-sm p-5">

                <div class="flex items-center justify-between">

                    <div>

                        <p class="text-sm font-medium text-gray-500">
                            Tutorías registradas
                        </p>

                        <p class="text-3xl font-bold text-blue-600 mt-1">
                            {{ $tutorias->count() }}
                        </p>

                    </div>

                    <div class="w-12 h-12 rounded-xl bg-blue-50
                                flex items-center justify-center">

                        <span class="text-xl">
                            👨‍🏫
                        </span>

                    </div>

                </div>

            </div>

        </div>


        {{-- ========================================================= --}}
        {{-- INCIDENCIAS --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">

            <div class="px-6 py-5 border-b border-gray-200">

                <h2 class="text-lg font-bold text-gray-800">
                    Historial de incidencias
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Registro de incidencias relacionadas con el alumno.
                </p>

            </div>


            @if($incidencias->count() > 0)

                <div class="divide-y divide-gray-100">

                    @foreach($incidencias as $incidencia)

                        <div class="p-5 hover:bg-gray-50 transition">

                            <div class="flex flex-col lg:flex-row
                                        lg:items-center lg:justify-between gap-4">

                                {{-- INFORMACIÓN --}}

                                <div class="flex-1">

                                    <div class="flex flex-wrap items-center gap-2 mb-2">

                                        <span class="font-bold text-gray-800">

                                            {{ $incidencia->tipo }}

                                        </span>


                                        {{-- PRIORIDAD --}}

                                        @if($incidencia->prioridad === 'Alta')

                                            <span class="px-2.5 py-1 text-xs font-semibold
                                                         rounded-full bg-red-100 text-red-700">

                                                Alta

                                            </span>

                                        @elseif($incidencia->prioridad === 'Media')

                                            <span class="px-2.5 py-1 text-xs font-semibold
                                                         rounded-full bg-yellow-100 text-yellow-700">

                                                Media

                                            </span>

                                        @else

                                            <span class="px-2.5 py-1 text-xs font-semibold
                                                         rounded-full bg-green-100 text-green-700">

                                                Baja

                                            </span>

                                        @endif


                                        {{-- ESTADO --}}

                                        <span class="px-2.5 py-1 text-xs font-semibold
                                                     rounded-full bg-gray-100 text-gray-700">

                                            {{ $incidencia->estado }}

                                        </span>

                                    </div>


                                    <p class="text-sm text-gray-600 mb-2">

                                        {{ $incidencia->descripcion }}

                                    </p>


                                    <div class="flex flex-wrap gap-x-5 gap-y-1
                                                text-xs text-gray-500">

                                        <span>

                                            📅
                                            {{ \Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y') }}

                                        </span>


                                        @if($incidencia->lugar)

                                            <span>

                                                📍
                                                {{ $incidencia->lugar }}

                                            </span>

                                        @endif

                                    </div>

                                </div>


                                {{-- BOTONES --}}

                                <div class="flex gap-2 shrink-0">

                                    <a href="{{ route('incidencias.show', $incidencia) }}"
                                       class="px-3 py-2 rounded-lg text-sm font-medium
                                              bg-blue-50 text-blue-700
                                              hover:bg-blue-100 transition">

                                        Ver

                                    </a>


                                    <a href="{{ route('incidencias.edit', $incidencia) }}"
                                       class="px-3 py-2 rounded-lg text-sm font-medium
                                              bg-yellow-50 text-yellow-700
                                              hover:bg-yellow-100 transition">

                                        Editar

                                    </a>

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="p-10 text-center">

                    <div class="text-4xl mb-3">
                        📋
                    </div>

                    <h3 class="font-semibold text-gray-700">
                        No hay incidencias registradas
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Este alumno todavía no tiene incidencias.
                    </p>

                </div>

            @endif

        </div>


        {{-- ========================================================= --}}
        {{-- TUTORÍAS --}}
        {{-- ========================================================= --}}

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-200">

                <h2 class="text-lg font-bold text-gray-800">
                    Historial de tutorías
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Seguimiento realizado mediante tutorías.
                </p>

            </div>


            @if($tutorias->count() > 0)

                <div class="divide-y divide-gray-100">

                    @foreach($tutorias as $tutoria)

                        <div class="p-5 hover:bg-gray-50 transition">

                            <div class="flex flex-col md:flex-row
                                        md:items-center md:justify-between gap-3">

                                <div>

                                    <h3 class="font-semibold text-gray-800">

                                        {{ $tutoria->motivo ?? 'Tutoría' }}

                                    </h3>


                                    @if(isset($tutoria->descripcion))

                                        <p class="text-sm text-gray-600 mt-1">

                                            {{ $tutoria->descripcion }}

                                        </p>

                                    @elseif(isset($tutoria->observaciones))

                                        <p class="text-sm text-gray-600 mt-1">

                                            {{ $tutoria->observaciones }}

                                        </p>

                                    @endif

                                </div>


                                <div class="text-sm text-gray-500">

                                    @if(isset($tutoria->fecha))

                                        📅
                                        {{ \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y') }}

                                    @elseif($tutoria->created_at)

                                        📅
                                        {{ $tutoria->created_at->format('d/m/Y') }}

                                    @endif

                                </div>

                            </div>

                        </div>

                    @endforeach

                </div>

            @else

                <div class="p-10 text-center">

                    <div class="text-4xl mb-3">
                        👨‍🏫
                    </div>

                    <h3 class="font-semibold text-gray-700">
                        No hay tutorías registradas
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Este alumno todavía no tiene registros de tutoría.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection