<x-app-layout>

    <div class="min-h-screen bg-gray-100 py-8">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            @php
                $estados = [
                    'Pendiente' => 'bg-yellow-100 text-yellow-800',
                    'Aprobada' => 'bg-green-100 text-green-800',
                    'Rechazada' => 'bg-red-100 text-red-800',
                    'Cancelada' => 'bg-gray-200 text-gray-700',
                ];

                $claseEstado = $estados[$reservacionEquipo->estado] ?? 'bg-gray-100 text-gray-700';
            @endphp

            {{-- ENCABEZADO --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border-l-4 border-[#7B1E3A]">

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

                    <div>
                        <p class="text-sm text-gray-500 font-semibold">
                            RESERVACIÓN #{{ $reservacionEquipo->id }}
                        </p>

                        <h1 class="text-2xl font-bold text-[#5D142B] mt-1">
                            Detalle de reservación
                        </h1>

                        <p class="text-gray-500 mt-1">
                            Consulta la información y el historial de esta solicitud.
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">

                        <span class="px-4 py-2 rounded-full text-sm font-bold {{ $claseEstado }}">
                            {{ $reservacionEquipo->estado }}
                        </span>

                        <a href="{{ route('reservaciones_equipos.index') }}"
                           class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold">
                            Volver
                        </a>

                    </div>

                </div>

            </div>

            {{-- MENSAJES --}}
            @if(session('success'))
                <div class="mb-5 p-4 rounded-lg bg-green-100 border border-green-300 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-5 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            {{-- INFORMACIÓN PRINCIPAL --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- EQUIPO --}}
                <div class="bg-white rounded-xl shadow-sm p-6">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-11 h-11 rounded-lg bg-[#7B1E3A] text-white flex items-center justify-center text-xl">
                            💻
                        </div>

                        <h2 class="font-bold text-lg text-[#5D142B]">
                            Equipo reservado
                        </h2>
                    </div>

                    <div class="space-y-4">

                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Código</p>
                            <p class="font-bold text-gray-800">
                                {{ $reservacionEquipo->equipo->codigo ?? 'No disponible' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Tipo de equipo</p>
                            <p class="text-gray-800">
                                {{ $reservacionEquipo->equipo->tipo ?? 'No disponible' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Marca</p>
                            <p class="text-gray-800">
                                {{ $reservacionEquipo->equipo->marca ?? 'No especificada' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Modelo</p>
                            <p class="text-gray-800">
                                {{ $reservacionEquipo->equipo->modelo ?? 'No especificado' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Estado físico actual</p>
                            <p class="text-gray-800">
                                {{ $reservacionEquipo->equipo->estado ?? 'No disponible' }}
                            </p>
                        </div>

                    </div>

                </div>

                {{-- SOLICITANTE --}}
                <div class="bg-white rounded-xl shadow-sm p-6">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-11 h-11 rounded-lg bg-[#7B1E3A] text-white flex items-center justify-center text-xl">
                            👤
                        </div>

                        <h2 class="font-bold text-lg text-[#5D142B]">
                            Solicitante
                        </h2>
                    </div>

                    <div class="space-y-4">

                        @if($reservacionEquipo->alumno)

                            <div>
                                <p class="text-xs uppercase text-gray-500 font-semibold">Nombre del alumno</p>
                                <p class="font-bold text-gray-800">
                                    {{ $reservacionEquipo->alumno->nombres }}
                                    {{ $reservacionEquipo->alumno->apellidos }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase text-gray-500 font-semibold">Matrícula</p>
                                <p class="text-gray-800">
                                    {{ $reservacionEquipo->alumno->matricula }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase text-gray-500 font-semibold">Grupo</p>
                                <p class="text-gray-800">
                                    {{ $reservacionEquipo->alumno->grupo->nombre ?? $reservacionEquipo->alumno->grupo->clave ?? 'No especificado' }}
                                </p>
                            </div>

                            <span class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold">
                                Alumno
                            </span>

                        @elseif($reservacionEquipo->docente)

                            <div>
                                <p class="text-xs uppercase text-gray-500 font-semibold">Nombre del docente</p>
                                <p class="font-bold text-gray-800">
                                    {{ $reservacionEquipo->docente->nombres }}
                                    {{ $reservacionEquipo->docente->apellidos }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase text-gray-500 font-semibold">Número de empleado</p>
                                <p class="text-gray-800">
                                    {{ $reservacionEquipo->docente->numero_empleado ?? 'No especificado' }}
                                </p>
                            </div>

                            <span class="inline-block px-3 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-bold">
                                Docente
                            </span>

                        @else

                            <p class="text-gray-500">
                                No se encontró información del solicitante.
                            </p>

                        @endif

                    </div>

                </div>

                {{-- INFORMACIÓN ACADÉMICA --}}
                <div class="bg-white rounded-xl shadow-sm p-6">

                    <div class="flex items-center gap-3 mb-5">
                        <div class="w-11 h-11 rounded-lg bg-[#7B1E3A] text-white flex items-center justify-center text-xl">
                            📚
                        </div>

                        <h2 class="font-bold text-lg text-[#5D142B]">
                            Información académica
                        </h2>
                    </div>

                    <div class="space-y-4">

                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Materia</p>
                            <p class="text-gray-800">
                                {{ $reservacionEquipo->materia->nombre ?? 'No especificada' }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs uppercase text-gray-500 font-semibold">Semestre</p>
                            <p class="text-gray-800">
                                {{ $reservacionEquipo->semestre ? $reservacionEquipo->semestre . '° semestre' : 'No especificado' }}
                            </p>
                        </div>

                    </div>

                </div>

            </div>

            {{-- FECHA Y HORARIO --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mt-6">

                <h2 class="text-lg font-bold text-[#5D142B] mb-5">
                    Fecha y horario reservado
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Fecha de inicio</p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ $reservacionEquipo->fecha_inicio->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Hora de inicio</p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ \Carbon\Carbon::parse($reservacionEquipo->hora_inicio)->format('H:i') }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Fecha de finalización</p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ $reservacionEquipo->fecha_fin->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Hora de finalización</p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ \Carbon\Carbon::parse($reservacionEquipo->hora_fin)->format('H:i') }}
                        </p>
                    </div>

                </div>

            </div>

            {{-- AUTORIZACIÓN --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mt-6">

                <h2 class="text-lg font-bold text-[#5D142B] mb-5">
                    Información de autorización
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div>
                        <p class="text-sm text-gray-500">Solicitado por</p>
                        <p class="font-semibold text-gray-800">
                            {{ $reservacionEquipo->solicitadoPor->name ?? 'No registrado' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Fecha de solicitud</p>
                        <p class="font-semibold text-gray-800">
                            {{ $reservacionEquipo->created_at?->format('d/m/Y H:i') ?? 'No registrada' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Autorizado por</p>
                        <p class="font-semibold text-gray-800">
                            {{ $reservacionEquipo->autorizadoPor->name ?? 'Sin autorización registrada' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500">Fecha de autorización</p>
                        <p class="font-semibold text-gray-800">
                            {{ $reservacionEquipo->autorizado_at?->format('d/m/Y H:i') ?? 'No autorizada' }}
                        </p>
                    </div>

                </div>

                @if($reservacionEquipo->motivo_rechazo)
                    <div class="mt-5 p-4 rounded-lg bg-red-50 border border-red-200">
                        <p class="font-bold text-red-800 mb-1">
                            Motivo del rechazo
                        </p>

                        <p class="text-red-700">
                            {{ $reservacionEquipo->motivo_rechazo }}
                        </p>
                    </div>
                @endif

                @if($reservacionEquipo->motivo_cancelacion)
                    <div class="mt-5 p-4 rounded-lg bg-gray-100 border border-gray-300">
                        <p class="font-bold text-gray-800 mb-1">
                            Motivo de cancelación
                        </p>

                        <p class="text-gray-700">
                            {{ $reservacionEquipo->motivo_cancelacion }}
                        </p>
                    </div>
                @endif

            </div>

            {{-- OBSERVACIONES --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mt-6">

                <h2 class="text-lg font-bold text-[#5D142B] mb-3">
                    Observaciones
                </h2>

                <p class="text-gray-700 whitespace-pre-line">
                    {{ $reservacionEquipo->observaciones ?: 'Sin observaciones adicionales.' }}
                </p>

            </div>

            {{-- PRÉSTAMO RELACIONADO --}}
            @if($reservacionEquipo->prestamo)

                <div class="bg-white rounded-xl shadow-sm p-6 mt-6">

                    <h2 class="text-lg font-bold text-[#5D142B] mb-3">
                        Préstamo generado
                    </h2>

                    <p class="text-gray-700">
                        Esta reservación está relacionada con el préstamo
                        <strong>#{{ $reservacionEquipo->prestamo->id }}</strong>.
                    </p>

                    <p class="text-sm text-gray-500 mt-1">
                        Estado del préstamo: {{ $reservacionEquipo->prestamo->estado }}
                    </p>

                </div>

            @endif

            {{-- HISTORIAL DE MOVIMIENTOS --}}
            <div class="bg-white rounded-xl shadow-sm p-6 mt-6">

                <h2 class="text-lg font-bold text-[#5D142B] mb-6">
                    Historial de movimientos
                </h2>

                @if($reservacionEquipo->movimientos->isNotEmpty())

                    <div class="relative border-l-2 border-[#7B1E3A] ml-3 space-y-7">

                        @foreach($reservacionEquipo->movimientos->sortByDesc('created_at') as $movimiento)

                            <div class="relative pl-7">

                                <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full bg-[#7B1E3A] border-2 border-white"></div>

                                <div class="bg-gray-50 rounded-lg p-4">

                                    <div class="flex flex-col sm:flex-row sm:justify-between gap-2">

                                        <p class="font-bold text-gray-800">
                                            {{ $movimiento->tipo_movimiento }}
                                        </p>

                                        <span class="text-xs text-gray-500">
                                            {{ $movimiento->created_at?->format('d/m/Y H:i') }}
                                        </span>

                                    </div>

                                    <p class="text-sm text-gray-600 mt-2">
                                        {{ $movimiento->descripcion ?? 'Sin descripción.' }}
                                    </p>

                                    @if($movimiento->estado_anterior || $movimiento->estado_nuevo)
                                        <p class="text-xs text-gray-500 mt-2">
                                            Estado:
                                            {{ $movimiento->estado_anterior ?? 'Inicial' }}
                                            →
                                            {{ $movimiento->estado_nuevo ?? 'Sin cambio' }}
                                        </p>
                                    @endif

                                    <p class="text-xs text-gray-500 mt-2">
                                        Responsable:
                                        {{ $movimiento->usuario->name ?? 'No identificado' }}
                                    </p>

                                    @if($movimiento->observaciones)
                                        <p class="text-sm text-gray-600 mt-2">
                                            Observaciones: {{ $movimiento->observaciones }}
                                        </p>
                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="bg-gray-50 rounded-lg p-6 text-center">
                        <p class="text-gray-500">
                            Todavía no existen movimientos registrados para esta reservación.
                        </p>
                    </div>

                @endif

            </div>

            {{-- ACCIONES --}}
            <div class="flex flex-wrap justify-end gap-3 mt-6">

                @if($reservacionEquipo->estado === 'Pendiente')

                    <form action="{{ route('reservaciones_equipos.aprobar', $reservacionEquipo) }}"
                          method="POST"
                          onsubmit="return confirm('¿Deseas aprobar esta reservación?')">
                        @csrf
                        @method('PATCH')

                        <button type="submit"
                                class="px-6 py-3 rounded-lg bg-green-600 hover:bg-green-700 text-white font-bold">
                            Aprobar reservación
                        </button>
                    </form>

                    <form action="{{ route('reservaciones_equipos.rechazar', $reservacionEquipo) }}"
                          method="POST"
                          onsubmit="return confirm('¿Deseas rechazar esta reservación?')">
                        @csrf
                        @method('PATCH')

                        <input type="hidden"
                               name="motivo_rechazo"
                               value="Solicitud rechazada desde el detalle.">

                        <button type="submit"
                                class="px-6 py-3 rounded-lg bg-red-600 hover:bg-red-700 text-white font-bold">
                            Rechazar
                        </button>
                    </form>

                @endif

                @if(in_array($reservacionEquipo->estado, ['Pendiente', 'Aprobada']))

                    <form action="{{ route('reservaciones_equipos.cancelar', $reservacionEquipo) }}"
                          method="POST"
                          onsubmit="return confirm('¿Deseas cancelar esta reservación?')">
                        @csrf
                        @method('PATCH')

                        <input type="hidden"
                               name="motivo_cancelacion"
                               value="Cancelada desde el detalle.">

                        <button type="submit"
                                class="px-6 py-3 rounded-lg bg-gray-600 hover:bg-gray-700 text-white font-bold">
                            Cancelar reservación
                        </button>
                    </form>

                @endif

            </div>

        </div>

    </div>

</x-app-layout>
