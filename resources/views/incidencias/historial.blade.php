@extends('layouts.app')

@section('content')

<style>
    .historial-page {
        color: #33262B;
    }

    .historial-page .tarjeta {
        background: #ffffff;
        border: 1px solid #E7D9DE;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(76, 28, 46, .05);
    }

    .historial-page .texto-vino {
        color: #7B1E3A;
    }

    .historial-page .boton-vino {
        background: #7B1E3A;
        color: #ffffff;
    }

    .historial-page .boton-vino:hover {
        background: #5D142B;
    }

    .historial-page .boton-secundario {
        background: #F2E7EB;
        color: #5D142B;
    }

    .historial-page .boton-secundario:hover {
        background: #E8D6DD;
    }
</style>

<div class="historial-page min-h-screen bg-[#F8F4F5] py-8">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ENCABEZADO --}}

        <div class="tarjeta p-6 mb-6">

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                <div>
                    <h1 class="text-2xl font-bold text-[#33262B]">
                        Historial de incidencias
                    </h1>

                    <p class="text-sm text-[#786A70] mt-1">
                        Registro de todas las incidencias del alumno.
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">

                    <a href="{{ route('incidencias.index') }}"
                       class="boton-secundario px-4 py-2 rounded-lg font-semibold transition">
                        ← Regresar
                    </a>

                    <a href="{{ route('incidencias.create') }}"
                       class="boton-vino px-4 py-2 rounded-lg font-semibold transition">
                        + Registrar incidencia
                    </a>

                </div>

            </div>

        </div>

        {{-- INFORMACIÓN DEL ALUMNO --}}

        <div class="tarjeta p-6 mb-6">

            <h2 class="text-lg font-bold text-[#33262B] mb-5">
                Datos del alumno
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

                <div>
                    <p class="text-xs font-semibold text-[#786A70] uppercase">
                        Nombre completo
                    </p>

                    <p class="mt-1 font-bold text-[#33262B]">
                        {{ $alumno->nombres }} {{ $alumno->apellidos }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-[#786A70] uppercase">
                        Matrícula
                    </p>

                    <p class="mt-1 font-semibold text-[#33262B]">
                        {{ $alumno->matricula ?? '—' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-semibold text-[#786A70] uppercase">
                        Grupo
                    </p>

                    <p class="mt-1 font-semibold text-[#33262B]">
                        {{ $alumno->grupo->nombre ?? 'Sin grupo' }}
                    </p>
                </div>

            </div>

        </div>

        {{-- LISTADO DE INCIDENCIAS --}}

        <div class="tarjeta overflow-hidden">

            <div class="px-6 py-5 border-b border-[#E7D9DE] flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">

                <div>
                    <h2 class="text-lg font-bold text-[#33262B]">
                        Incidencias registradas
                    </h2>

                    <p class="text-sm text-[#786A70] mt-1">
                        Historial cronológico del alumno.
                    </p>
                </div>

                <span class="text-sm font-semibold texto-vino">
                    {{ $totalIncidencias }} registro(s)
                </span>

            </div>

            @if($incidencias->count() > 0)

                <div class="divide-y divide-[#F0E6E9]">

                    @foreach($incidencias as $incidencia)

                        <div class="p-5 hover:bg-[#FDF9FA] transition">

                            <div class="flex flex-col lg:flex-row lg:justify-between gap-4">

                                <div class="flex-1">

                                    <div class="flex flex-wrap items-center gap-2 mb-3">

                                        <span class="font-bold text-[#33262B] text-base">
                                            {{ $incidencia->tipo }}
                                        </span>

                                        <span class="px-3 py-1 text-xs font-semibold rounded-full bg-[#F2E7EB] text-[#7B1E3A]">
                                            {{ $incidencia->estado }}
                                        </span>

                                    </div>

                                    <p class="text-sm text-[#4B3740] mb-3">
                                        {{ $incidencia->descripcion }}
                                    </p>

                                    <div class="flex flex-wrap gap-x-5 gap-y-2 text-xs text-[#786A70]">

                                        <span>
                                            📅
                                            {{ \Carbon\Carbon::parse($incidencia->fecha)->format('d/m/Y') }}
                                        </span>

                                        @if($incidencia->lugar)
                                            <span>
                                                📍 {{ $incidencia->lugar }}
                                            </span>
                                        @endif

                                    </div>

                                    @if($incidencia->acciones_realizadas)
                                        <div class="mt-3 text-sm">
                                            <strong class="text-[#4B3740]">
                                                Acciones realizadas:
                                            </strong>

                                            <p class="text-[#786A70] mt-1">
                                                {{ $incidencia->acciones_realizadas }}
                                            </p>
                                        </div>
                                    @endif

                                    @if($incidencia->observaciones)
                                        <div class="mt-2 text-sm">
                                            <strong class="text-[#4B3740]">
                                                Observaciones:
                                            </strong>

                                            <p class="text-[#786A70] mt-1">
                                                {{ $incidencia->observaciones }}
                                            </p>
                                        </div>
                                    @endif

                                </div>

                                {{-- ACCIONES --}}

                                <div class="flex gap-2 shrink-0">

                                    <a href="{{ route('incidencias.show', $incidencia) }}"
                                       class="px-4 py-2 rounded-lg text-sm font-semibold bg-[#F2E7EB] text-[#7B1E3A] hover:bg-[#E8D6DD] transition">
                                        Ver
                                    </a>

                                    <a href="{{ route('incidencias.edit', $incidencia) }}"
                                       class="px-4 py-2 rounded-lg text-sm font-semibold bg-amber-50 text-amber-700 hover:bg-amber-100 transition">
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

                    <h3 class="font-semibold text-[#33262B]">
                        No hay incidencias registradas
                    </h3>

                    <p class="text-sm text-[#786A70] mt-1">
                        Este alumno todavía no tiene incidencias.
                    </p>

                </div>

            @endif

        </div>

    </div>

</div>

@endsection