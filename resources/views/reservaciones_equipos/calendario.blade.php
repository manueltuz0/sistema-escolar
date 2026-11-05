 @extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                Calendario de disponibilidad
            </h1>
            <p class="text-sm text-gray-500 mt-1">
                Consulta las reservaciones de los equipos tecnológicos.
            </p>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('reservaciones_equipos.index') }}"
               class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Volver
            </a>

            <a href="{{ route('reservaciones_equipos.create') }}"
               class="px-4 py-2 rounded-lg text-white hover:opacity-90"
               style="background-color: #7B1E3A;">
                Nueva reservación
            </a>
        </div>
    </div>

    {{-- Selector de fecha --}}
    <div class="bg-white rounded-xl shadow-sm border p-5 mb-6">
        <form action="{{ route('reservaciones_equipos.calendario') }}"
              method="GET"
              class="flex flex-col sm:flex-row sm:items-end gap-3">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Seleccionar fecha
                </label>

                <input type="date"
                       name="fecha"
                       value="{{ $fecha }}"
                       required
                       class="border border-gray-300 rounded-lg px-3 py-2 w-full">
            </div>

            <button type="submit"
                    class="px-5 py-2 rounded-lg text-white hover:opacity-90"
                    style="background-color: #7B1E3A;">
                Consultar
            </button>

            <a href="{{ route('reservaciones_equipos.calendario') }}"
               class="px-5 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 text-center">
                Hoy
            </a>
        </form>

        <p class="text-sm text-gray-500 mt-3">
            Fecha consultada:
            <strong>{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</strong>
        </p>
    </div>

    {{-- Resumen --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">

        <div class="bg-white border rounded-xl p-4 shadow-sm">
            <p class="text-sm text-gray-500">Equipos registrados</p>
            <p class="text-2xl font-bold text-gray-800">
                {{ $equipos->count() }}
            </p>
        </div>

        <div class="bg-white border rounded-xl p-4 shadow-sm">
            <p class="text-sm text-gray-500">Reservaciones del día</p>
            <p class="text-2xl font-bold text-gray-800">
                {{ $reservaciones->count() }}
            </p>
        </div>

        <div class="bg-white border rounded-xl p-4 shadow-sm">
            <p class="text-sm text-gray-500">Equipos con reservación</p>
            <p class="text-2xl font-bold text-gray-800">
                {{ $reservaciones->pluck('equipo_id')->unique()->count() }}
            </p>
        </div>

    </div>

    {{-- Calendario por equipo --}}
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">

        <div class="p-5 border-b">
            <h2 class="font-bold text-gray-800 text-lg">
                Disponibilidad por equipo
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Se muestran las reservaciones que coinciden con la fecha seleccionada.
            </p>
        </div>

        @if($equipos->isEmpty())
            <div class="p-8 text-center text-gray-500">
                No hay equipos disponibles para consultar.
            </div>
        @else

            <div class="divide-y">

                @foreach($equipos as $equipo)

                    @php
                        $reservacionesEquipo = $reservaciones
                            ->where('equipo_id', $equipo->id);
                    @endphp

                    <div class="p-5">

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-3">

                            <div>
                                <h3 class="font-bold text-gray-800">
                                    {{ $equipo->codigo }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    {{ $equipo->tipo }}
                                    @if($equipo->marca)
                                        · {{ $equipo->marca }}
                                    @endif
                                    @if($equipo->modelo)
                                        {{ $equipo->modelo }}
                                    @endif
                                </p>
                            </div>

                            @if($reservacionesEquipo->isEmpty())
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                                    Sin reservaciones
                                </span>
                            @else
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                                    {{ $reservacionesEquipo->count() }}
                                    reservación(es)
                                </span>
                            @endif

                        </div>

                        @if($reservacionesEquipo->isNotEmpty())

                            <div class="space-y-3">

                                @foreach($reservacionesEquipo as $reservacion)

                                    @php
                                        $nombreSolicitante = $reservacion->alumno
                                            ? $reservacion->alumno->nombres . ' ' . $reservacion->alumno->apellidos
                                            : ($reservacion->docente
                                                ? $reservacion->docente->nombres . ' ' . $reservacion->docente->apellidos
                                                : 'Sin solicitante');

                                        $aprobada = $reservacion->estado === 'Aprobada';
                                    @endphp

                                    <a href="{{ route('reservaciones_equipos.show', $reservacion->id) }}"
                                       class="block rounded-lg border-l-4 p-4 hover:shadow-sm transition"
                                       style="border-left-color: {{ $aprobada ? '#16A34A' : '#D97706' }}; background-color: {{ $aprobada ? '#F0FDF4' : '#FFFBEB' }};">

                                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                                            <div>
                                                <p class="font-semibold text-gray-800">
                                                    {{ $nombreSolicitante }}
                                                </p>

                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('H:i') }}
                                                    -
                                                    {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('H:i') }}
                                                </p>

                                                <p class="text-xs text-gray-500 mt-1">
                                                    Reservación #{{ $reservacion->id }}
                                                </p>
                                            </div>

                                            <span class="px-3 py-1 rounded-full text-xs font-bold
                                                {{ $aprobada
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ $reservacion->estado }}
                                            </span>

                                        </div>

                                    </a>

                                @endforeach

                            </div>

                        @else

                            <p class="text-sm text-green-700 bg-green-50 rounded-lg p-3">
                                Este equipo no tiene reservaciones pendientes o aprobadas para esta fecha.
                            </p>

                        @endif

                    </div>

                @endforeach

            </div>

        @endif

    </div>

    <div class="mt-5 flex flex-wrap gap-4 text-sm">
        <span class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-green-600"></span>
            Aprobada
        </span>

        <span class="flex items-center gap-2">
            <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
            Pendiente
        </span>
    </div>

</div>
@endsection