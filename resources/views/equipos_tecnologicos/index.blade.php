
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- ENCABEZADO --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Inventario de equipos tecnológicos
            </h1>

            <p class="text-gray-500 text-sm mt-1">
                Administración y control de equipos del plantel.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">

            <a href="{{ route('prestamos_equipos.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2.5 rounded-lg font-semibold text-sm transition">
                ← Regresar al principal
            </a>

            <a href="{{ route('equipos_tecnologicos.create') }}"
               class="bg-[#7B1E3A] hover:bg-[#5D142B] text-white px-4 py-2.5 rounded-lg font-semibold text-sm shadow transition">
                + Registrar equipo
            </a>

        </div>
    </div>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 p-3 rounded-lg mb-4 text-sm">
            {{ session('error') }}
        </div>
    @endif

    
{{-- CONTADORES --}}
@php
    $total = $equipos->total();
    $disponibles = \App\Models\EquipoTecnologico::where('estado', 'Disponible')->count();
    $prestados = \App\Models\EquipoTecnologico::where('estado', 'Prestado')->count();
    $mantenimiento = \App\Models\EquipoTecnologico::where('estado', 'Mantenimiento')->count();
    $bajas = \App\Models\EquipoTecnologico::where('estado', 'Baja')->count();
@endphp

<style>
    .inventario-contadores {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 20px;
    }

    .inventario-card {
        background: white;
        border-radius: 10px;
        padding: 12px 15px;
        min-height: 75px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        border-left: 4px solid #9ca3af;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .inventario-card p {
        font-size: 12px;
        color: #6b7280;
        margin: 0;
    }

    .inventario-card h3 {
        font-size: 22px;
        font-weight: 700;
        margin: 3px 0 0;
    }

    @media (max-width: 700px) {
        .inventario-contadores {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }
</style>

<div class="inventario-contadores">

    <div class="inventario-card" style="border-color: #6b7280;">
        <p>Total de equipos</p>
        <h3 class="text-gray-800">{{ $total }}</h3>
    </div>

    <div class="inventario-card" style="border-color: #22c55e;">
        <p>Disponibles</p>
        <h3 class="text-green-600">{{ $disponibles }}</h3>
    </div>

    <div class="inventario-card" style="border-color: #3b82f6;">
        <p>Prestados</p>
        <h3 class="text-blue-600">{{ $prestados }}</h3>
    </div>

    <div class="inventario-card" style="border-color: #eab308;">
        <p>Mantenimiento</p>
        <h3 class="text-yellow-600">{{ $mantenimiento }}</h3>
    </div>

    <div class="inventario-card" style="border-color: #ef4444;">
        <p>Baja</p>
        <h3 class="text-red-600">{{ $bajas }}</h3>
    </div>

</div>

    {{-- TABLA DE INVENTARIO --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">

        {{-- BUSCADOR Y FILTROS --}}
        <div class="p-4 border-b">

            <form method="GET"
                  action="{{ route('equipos_tecnologicos.index') }}"
                  class="flex flex-col md:flex-row gap-3">

                <input
                    type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Buscar por código, tipo, marca o modelo..."
                    class="flex-1 border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#7B1E3A] focus:outline-none"
                >

                <select
                    name="estado"
                    class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm"
                >
                    <option value="">Todos los estados</option>

                    @foreach(['Disponible', 'Prestado', 'Mantenimiento', 'Baja'] as $estado)
                        <option value="{{ $estado }}"
                            @selected(request('estado') == $estado)>
                            {{ $estado }}
                        </option>
                    @endforeach
                </select>

                <button
                    type="submit"
                    class="bg-[#7B1E3A] hover:bg-[#5D142B] text-white px-5 py-2.5 rounded-lg font-semibold text-sm"
                >
                    Buscar
                </button>

                <a
                    href="{{ route('equipos_tecnologicos.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2.5 rounded-lg text-center text-sm"
                >
                    Limpiar
                </a>

            </form>
        </div>

        {{-- TABLA --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm text-left">

                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-5 py-3">Código</th>
                        <th class="px-5 py-3">Equipo</th>
                        <th class="px-5 py-3">Marca / Modelo</th>
                        <th class="px-5 py-3">Ubicación</th>
                        <th class="px-5 py-3">Estado</th>
                        <th class="px-5 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">

                    @forelse($equipos as $equipo)

                        <tr class="hover:bg-gray-50">

                            <td class="px-5 py-4 font-bold text-gray-800">
                                {{ $equipo->codigo }}
                            </td>

                            <td class="px-5 py-4">
                                {{ $equipo->tipo }}
                            </td>

                            <td class="px-5 py-4">
                                <div>
                                    {{ $equipo->marca ?: 'Sin marca' }}
                                </div>

                                <div class="text-gray-400 text-xs">
                                    {{ $equipo->modelo ?: 'Sin modelo' }}
                                </div>
                            </td>

                            <td class="px-5 py-4">
                                {{ $equipo->ubicacion ?: 'No especificada' }}
                            </td>

                            <td class="px-5 py-4">

                                @php
                                    $colores = [
                                        'Disponible' => 'bg-green-100 text-green-700',
                                        'Prestado' => 'bg-blue-100 text-blue-700',
                                        'Mantenimiento' => 'bg-yellow-100 text-yellow-700',
                                        'Baja' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colores[$equipo->estado] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $equipo->estado }}
                                </span>

                            </td>

                            <td class="px-5 py-4">

                                <div class="flex items-center justify-center gap-3">

                                    <a
                                        href="{{ route('equipos_tecnologicos.show', $equipo) }}"
                                        class="text-blue-600 hover:text-blue-800 font-semibold"
                                    >
                                        Ver
                                    </a>

                                    <a
                                        href="{{ route('equipos_tecnologicos.edit', $equipo) }}"
                                        class="text-[#7B1E3A] hover:text-[#5D142B] font-semibold"
                                    >
                                        Editar
                                    </a>

                                    @if($equipo->estado !== 'Baja')

                                        <form
                                            action="{{ route('equipos_tecnologicos.destroy', $equipo) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Deseas dar de baja este equipo?')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="text-red-600 hover:text-red-800 font-semibold"
                                            >
                                                Baja
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-gray-500">

                                <div class="text-lg font-semibold">
                                    No hay equipos registrados.
                                </div>

                                <p class="mt-1">
                                    Utiliza el botón Registrar equipo para comenzar.
                                </p>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- PAGINACIÓN --}}
        <div class="p-4">
            {{ $equipos->withQueryString()->links() }}
        </div>

    </div>

</div>
@endsection
