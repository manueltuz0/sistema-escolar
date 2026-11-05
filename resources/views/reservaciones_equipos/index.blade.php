
<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-8">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- ENCABEZADO --}}
            <div class="bg-white rounded-2xl shadow-sm border-l-4 border-[#7B1E3A] p-6 mb-6">

                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                    <div>
                        <h1 class="text-2xl font-bold text-[#5D142B]">
                            Reservaciones de equipo tecnológico
                        </h1>

                        <p class="text-gray-500 mt-2">
                            Consulta y administra las solicitudes de reservación de equipos.
                        </p>
                    </div>

                    {{-- BOTONES --}}
                    <div class="flex flex-wrap items-center gap-3">

                        <a href="{{ route('reservaciones_equipos.calendario') }}"
                           class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold transition">
                            📅 Ver calendario
                        </a>

                        <a href="{{ route('reservaciones_equipos.create') }}"
                           class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg bg-[#7B1E3A] hover:bg-[#5D142B] text-white font-semibold shadow-sm transition">
                            + Nueva reservación
                        </a>

                    </div>

                </div>
            </div>


            {{-- MENSAJES --}}
            @if(session('success'))
                <div class="mb-5 p-4 rounded-xl bg-green-100 border border-green-300 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-4 rounded-xl bg-red-100 border border-red-300 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-5 p-4 rounded-xl bg-red-100 border border-red-300 text-red-800">

                    <p class="font-semibold mb-2">
                        Se encontraron errores:
                    </p>

                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            {{-- CONTADORES --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

                {{-- TOTAL --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-[#7B1E3A]">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">
                                Total de reservaciones
                            </p>

                            <p class="text-3xl font-bold text-[#5D142B] mt-2">
                                {{ $reservaciones->total() }}
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-pink-50 flex items-center justify-center text-2xl">
                            📋
                        </div>
                    </div>
                </div>

                {{-- PENDIENTES --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">
                                Pendientes en esta página
                            </p>

                            <p class="text-3xl font-bold text-yellow-600 mt-2">
                                {{ $reservaciones->where('estado', 'Pendiente')->count() }}
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center text-2xl">
                            ⏳
                        </div>
                    </div>
                </div>

                {{-- APROBADAS --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">
                                Aprobadas en esta página
                            </p>

                            <p class="text-3xl font-bold text-green-600 mt-2">
                                {{ $reservaciones->where('estado', 'Aprobada')->count() }}
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-green-50 flex items-center justify-center text-2xl">
                            ✓
                        </div>
                    </div>
                </div>

                {{-- RECHAZADAS --}}
                <div class="bg-white rounded-xl shadow-sm p-5 border-t-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 font-medium">
                                Rechazadas en esta página
                            </p>

                            <p class="text-3xl font-bold text-red-600 mt-2">
                                {{ $reservaciones->where('estado', 'Rechazada')->count() }}
                            </p>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-2xl">
                            ✕
                        </div>
                    </div>
                </div>

            </div>


            {{-- HISTORIAL --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                {{-- TÍTULO --}}
                <div class="px-6 py-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">

                    <div>
                        <h2 class="text-lg font-bold text-[#5D142B]">
                            Historial de reservaciones
                        </h2>

                        <p class="text-sm text-gray-500 mt-1">
                            Registro de solicitudes de préstamo de equipo.
                        </p>
                    </div>

                    <span class="text-sm text-gray-500">
                        Total: {{ $reservaciones->total() }} registros
                    </span>

                </div>


                @if($reservaciones->count() > 0)

                    {{-- TABLA --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-[#5D142B] text-white">

                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Equipo
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Solicitante
                                    </th>

                                    <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider">
                                        Fecha y horario
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">
                                        Estado
                                    </th>

                                    <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wider">
                                        Acciones
                                    </th>
                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-100">

                                @foreach($reservaciones as $reservacion)

                                    <tr class="hover:bg-gray-50 transition">

                                        {{-- EQUIPO --}}
                                        <td class="px-6 py-5">

                                            <p class="font-bold text-gray-800">
                                                {{ $reservacion->equipo->codigo ?? 'Sin código' }}
                                            </p>

                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $reservacion->equipo->tipo ?? 'Equipo no disponible' }}
                                            </p>

                                        </td>


                                        {{-- SOLICITANTE --}}
                                        <td class="px-6 py-5">

                                            @if($reservacion->alumno)

                                                <p class="font-semibold text-gray-800">
                                                    {{ $reservacion->alumno->nombres }}
                                                    {{ $reservacion->alumno->apellidos }}
                                                </p>

                                                <p class="text-xs text-gray-500 mt-1">
                                                    Alumno

                                                    @if($reservacion->alumno->grupo)
                                                        · {{ $reservacion->alumno->grupo->nombre ?? $reservacion->alumno->grupo->clave ?? '' }}
                                                    @endif
                                                </p>

                                            @elseif($reservacion->docente)

                                                <p class="font-semibold text-gray-800">
                                                    {{ $reservacion->docente->nombres }}
                                                    {{ $reservacion->docente->apellidos }}
                                                </p>

                                                <p class="text-xs text-gray-500 mt-1">
                                                    Docente
                                                </p>

                                            @else

                                                <span class="text-gray-400">
                                                    Sin solicitante
                                                </span>

                                            @endif

                                        </td>


                                        {{-- FECHA Y HORARIO --}}
                                        <td class="px-6 py-5">

                                            <p class="font-semibold text-gray-800">
                                                {{ $reservacion->fecha_inicio->format('d/m/Y') }}
                                            </p>

                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ \Carbon\Carbon::parse($reservacion->hora_inicio)->format('H:i') }}
                                                -
                                                {{ \Carbon\Carbon::parse($reservacion->hora_fin)->format('H:i') }}
                                            </p>

                                            @if(!$reservacion->fecha_inicio->isSameDay($reservacion->fecha_fin))

                                                <p class="text-xs text-gray-500 mt-1">
                                                    Hasta {{ $reservacion->fecha_fin->format('d/m/Y') }}
                                                </p>

                                            @endif

                                        </td>


                                        {{-- ESTADO --}}
                                        <td class="px-6 py-5 text-center">

                                            @php
                                                $estados = [
                                                    'Pendiente' => 'bg-yellow-100 text-yellow-800',
                                                    'Aprobada' => 'bg-green-100 text-green-800',
                                                    'Rechazada' => 'bg-red-100 text-red-800',
                                                    'Cancelada' => 'bg-gray-200 text-gray-700',
                                                ];

                                                $claseEstado = $estados[$reservacion->estado] ?? 'bg-gray-100 text-gray-700';
                                            @endphp

                                            <span class="inline-flex items-center justify-center px-3 py-1.5 rounded-full text-xs font-bold {{ $claseEstado }}">
                                                {{ $reservacion->estado }}
                                            </span>

                                        </td>


                                        {{-- ACCIONES --}}
                                        <td class="px-6 py-5">

                                            <div class="flex flex-col gap-2 min-w-[140px]">

                                                {{-- VER DETALLES --}}
                                                <a href="{{ route('reservaciones_equipos.show', $reservacion) }}"
                                                   class="text-center px-3 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold transition">
                                                    Ver detalles
                                                </a>


                                                {{-- APROBAR Y RECHAZAR --}}
                                                @if($reservacion->estado === 'Pendiente')

                                                    <form action="{{ route('reservaciones_equipos.aprobar', $reservacion) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('¿Deseas aprobar esta reservación?')">

                                                        @csrf
                                                        @method('PATCH')

                                                        <button type="submit"
                                                                class="w-full px-3 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white text-sm font-semibold transition">
                                                            Aprobar
                                                        </button>

                                                    </form>


                                                    <form action="{{ route('reservaciones_equipos.rechazar', $reservacion) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('¿Deseas rechazar esta reservación?')">

                                                        @csrf
                                                        @method('PATCH')

                                                        <input type="hidden"
                                                               name="motivo_rechazo"
                                                               value="Solicitud rechazada desde el listado.">

                                                        <button type="submit"
                                                                class="w-full px-3 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-semibold transition">
                                                            Rechazar
                                                        </button>

                                                    </form>

                                                @endif


                                                {{-- CANCELAR --}}
                                                @if(in_array($reservacion->estado, ['Pendiente', 'Aprobada']))

                                                    <form action="{{ route('reservaciones_equipos.cancelar', $reservacion) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('¿Deseas cancelar esta reservación?')">

                                                        @csrf
                                                        @method('PATCH')

                                                        <input type="hidden"
                                                               name="motivo_cancelacion"
                                                               value="Cancelada desde el listado.">

                                                        <button type="submit"
                                                                class="w-full px-3 py-2 rounded-lg bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold transition">
                                                            Cancelar
                                                        </button>

                                                    </form>

                                                @endif

                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    {{-- ESTADO VACÍO CENTRADO --}}
                    <div class="min-h-[380px] flex flex-col items-center justify-center text-center px-6 py-12">

                        <div class="w-20 h-20 rounded-full bg-pink-50 flex items-center justify-center mb-5">
                            <span class="text-4xl">📋</span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-800">
                            No hay reservaciones registradas
                        </h3>

                        <p class="text-gray-500 mt-2 max-w-md">
                            Cuando registres una solicitud de reservación, aparecerá aquí para que puedas consultarla y administrarla.
                        </p>

                        <a href="{{ route('reservaciones_equipos.create') }}"
                           class="mt-6 inline-flex items-center justify-center px-6 py-3 bg-[#7B1E3A] hover:bg-[#5D142B] text-white rounded-lg font-semibold shadow-sm transition">
                            + Registrar reservación
                        </a>

                    </div>

                @endif


                {{-- PAGINACIÓN --}}
                @if($reservaciones->hasPages())

                    <div class="px-6 py-5 border-t border-gray-200">
                        {{ $reservaciones->links() }}
                    </div>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>