<x-app-layout>

    <div style="
        background: #f3f4f6;
        min-height: calc(100vh - 65px);
        padding: 25px 30px;
    ">

        <div style="
            max-width: 1450px;
            width: 100%;
            margin: 0 auto;
        ">

            {{-- ===================================== --}}
            {{-- ENCABEZADO --}}
            {{-- ===================================== --}}

            <div style="
                display: flex;
                justify-content: space-between;
                align-items: center;
                flex-wrap: wrap;
                gap: 15px;
                padding: 5px 0 22px;
            ">

                <div>
                    <h2 style="
                        font-size: 24px;
                        font-weight: 700;
                        color: #7B1E3A;
                        margin: 0;
                    ">
                        Préstamo de Equipo Tecnológico
                    </h2>

                    <p style="
                        margin-top: 5px;
                        color: #6b7280;
                        font-size: 14px;
                    ">
                        Administración de inventario, préstamos y reservaciones.
                    </p>
                </div>
                
                <div style="
                    display: flex;
                    align-items: center;
                    justify-content: flex-end;
                    gap: 10px;
                    flex-wrap: wrap;
                ">
                    @if(request('vista') !== 'historial')
                        <a href="{{ route('prestamos_equipos.index', ['vista' => 'historial']) }}"
                           style="
                               display: inline-block;
                               padding: 10px 18px;
                               background: #7B1E3A;
                               color: white;
                               text-decoration: none;
                               border-radius: 8px;
                               font-weight: 600;
                               font-size: 14px;
                           ">
                            📋 Historial de préstamos
                        </a>
                    @endif

                    <a href="{{ route('dashboard') }}"
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
                        ← Dashboard
                    </a>
                </div>

            </div>


            {{-- MENSAJE DE ÉXITO --}}
            @if(session('success'))
                <div style="
                    padding: 14px 18px;
                    background: #dcfce7;
                    color: #166534;
                    border: 1px solid #86efac;
                    border-radius: 10px;
                    margin-bottom: 20px;
                    font-weight: 600;
                ">
                    {{ session('success') }}
                </div>
            @endif


            {{-- MENSAJE DE ERROR --}}
            @if(session('error'))
                <div style="
                    padding: 14px 18px;
                    background: #fee2e2;
                    color: #991b1b;
                    border: 1px solid #fca5a5;
                    border-radius: 10px;
                    margin-bottom: 20px;
                    font-weight: 600;
                ">
                    {{ session('error') }}
                </div>
            @endif

            @if(request('vista') !== 'historial')

            {{-- ===================================== --}}
            {{-- TARJETAS DE RESUMEN --}}
            {{-- ===================================== --}}

            <div style="
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 12px;
                margin-bottom: 22px;
            ">

                {{-- TOTAL DE EQUIPOS --}}
                <div style="
                    background: white;
                    border-left: 4px solid #7B1E3A;
                    border-radius: 10px;
                    padding: 16px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                ">

                    <p style="font-size: 12px; color: #6b7280;">
                        Total de equipos
                    </p>

                    <h3 style="
                        font-size: 23px;
                        font-weight: 700;
                        color: #7B1E3A;
                        margin-top: 5px;
                    ">
                        {{ $totalEquipos }}
                    </h3>

                    <p style="font-size: 11px; color: #9ca3af;">
                        Registrados en inventario
                    </p>

                </div>


                {{-- DISPONIBLES --}}
                <div style="
                    background: white;
                    border-left: 4px solid #16a34a;
                    border-radius: 10px;
                    padding: 16px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                ">

                    <p style="font-size: 12px; color: #6b7280;">
                        Disponibles
                    </p>

                    <h3 style="
                        font-size: 23px;
                        font-weight: 700;
                        color: #16a34a;
                        margin-top: 5px;
                    ">
                        {{ $disponibles }}
                    </h3>

                    <p style="font-size: 11px; color: #9ca3af;">
                        Listos para préstamo
                    </p>

                </div>


                {{-- PRESTADOS --}}
                <div style="
                    background: white;
                    border-left: 4px solid #f97316;
                    border-radius: 10px;
                    padding: 16px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                ">

                    <p style="font-size: 12px; color: #6b7280;">
                        Prestados
                    </p>

                    <h3 style="
                        font-size: 23px;
                        font-weight: 700;
                        color: #f97316;
                        margin-top: 5px;
                    ">
                        {{ $prestados }}
                    </h3>

                    <p style="font-size: 11px; color: #9ca3af;">
                        Actualmente en préstamo
                    </p>

                </div>


                {{-- MANTENIMIENTO --}}
                <div style="
                    background: white;
                    border-left: 4px solid #3b82f6;
                    border-radius: 10px;
                    padding: 16px;
                    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                ">

                    <p style="font-size: 12px; color: #6b7280;">
                        Mantenimiento
                    </p>

                    <h3 style="
                        font-size: 23px;
                        font-weight: 700;
                        color: #3b82f6;
                        margin-top: 5px;
                    ">
                        {{ $mantenimiento }}
                    </h3>

                    <p style="font-size: 11px; color: #9ca3af;">
                        Equipos en revisión
                    </p>

                </div>

            </div>


            {{-- ===================================== --}}
            {{-- ACCESOS DEL MÓDULO --}}
            {{-- ===================================== --}}

            <div style="margin-bottom: 22px;">

                <h3 style="
                    font-size: 17px;
                    font-weight: 700;
                    color: #1f2937;
                    margin-bottom: 4px;
                ">
                    Administración del módulo
                </h3>

                <p style="
                    font-size: 12px;
                    color: #6b7280;
                    margin-bottom: 15px;
                ">
                    Selecciona el apartado que deseas administrar.
                </p>


                <div style="
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                    gap: 15px;
                ">


                    {{-- INVENTARIO --}}
                    <a href="{{ route('equipos_tecnologicos.index') }}"
                       style="
                            display: block;
                            background: white;
                            padding: 20px;
                            border-radius: 10px;
                            text-decoration: none;
                            color: #1f2937;
                            box-shadow: 0 2px 7px rgba(0,0,0,0.07);
                            border: 1px solid #e5e7eb;
                            transition: 0.2s;
                       ">

                        <div style="font-size: 22px; margin-bottom: 10px;">
                            📦
                        </div>

                        <h4 style="
                            font-size: 14px;
                            font-weight: 700;
                            margin-bottom: 5px;
                        ">
                            Inventario de equipos
                        </h4>

                        <p style="
                            font-size: 12px;
                            color: #6b7280;
                            margin-bottom: 12px;
                        ">
                            Registrar, consultar, editar y dar de baja equipos tecnológicos.
                        </p>

                        <span style="
                            color: #7B1E3A;
                            font-size: 12px;
                            font-weight: 700;
                        ">
                            Administrar inventario →
                        </span>

                    </a>


                    {{-- REGISTRAR PRÉSTAMO --}}
                    <a href="{{ route('prestamos_equipos.create') }}"
                       style="
                            display: block;
                            background: white;
                            padding: 20px;
                            border-radius: 10px;
                            text-decoration: none;
                            color: #1f2937;
                            box-shadow: 0 2px 7px rgba(0,0,0,0.07);
                            border: 1px solid #e5e7eb;
                            transition: 0.2s;
                       ">

                        <div style="font-size: 22px; margin-bottom: 10px;">
                            📋
                        </div>

                        <h4 style="
                            font-size: 14px;
                            font-weight: 700;
                            margin-bottom: 5px;
                        ">
                            Registrar préstamo
                        </h4>

                        <p style="
                            font-size: 12px;
                            color: #6b7280;
                            margin-bottom: 12px;
                        ">
                            Registrar la entrega de laptops, proyectores y otros equipos.
                        </p>

                        <span style="
                            color: #7B1E3A;
                            font-size: 12px;
                            font-weight: 700;
                        ">
                            Nuevo préstamo →
                        </span>

                    </a>


                    {{-- RESERVACIONES --}}
                    <a href="{{ route('reservaciones_equipos.index') }}"
                       style="
                            display: block;
                            background: white;
                            padding: 20px;
                            border-radius: 10px;
                            text-decoration: none;
                            color: #1f2937;
                            box-shadow: 0 2px 7px rgba(0,0,0,0.07);
                            border: 1px solid #e5e7eb;
                            transition: 0.2s;
                       ">

                        <div style="font-size: 22px; margin-bottom: 10px;">
                            🗓️
                        </div>

                        <h4 style="
                            font-size: 14px;
                            font-weight: 700;
                            margin-bottom: 5px;
                        ">
                            Reservaciones
                        </h4>

                        <p style="
                            font-size: 12px;
                            color: #6b7280;
                            margin-bottom: 12px;
                        ">
                            Consultar y administrar las reservaciones de equipos.
                        </p>

                        <span style="
                            color: #7B1E3A;
                            font-size: 12px;
                            font-weight: 700;
                        ">
                            Administrar reservaciones →
                        </span>

                    </a>

                </div>

            </div>



            {{-- ===================================== --}}
            {{-- PRÉSTAMOS RECIENTES DE LA PÁGINA PRINCIPAL --}}
            {{-- ===================================== --}}

            <div style="
                background: white;
                border-radius: 12px;
                overflow: hidden;
                margin-top: 22px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                border: 1px solid #e5e7eb;
            ">
                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    flex-wrap: wrap;
                    gap: 12px;
                    padding: 18px 20px;
                    border-bottom: 1px solid #e5e7eb;
                ">
                    <div>
                        <h3 style="
                            margin: 0;
                            color: #1f2937;
                            font-size: 17px;
                            font-weight: 700;
                        ">
                            Préstamos recientes
                        </h3>
                        <p style="
                            margin: 5px 0 0;
                            color: #6b7280;
                            font-size: 12px;
                        ">
                            Últimos cinco préstamos registrados.
                        </p>
                    </div>

                    <a href="{{ route('prestamos_equipos.index', ['vista' => 'historial']) }}"
                       style="
                            display: inline-block;
                            padding: 9px 14px;
                            background: #7B1E3A;
                            color: white;
                            text-decoration: none;
                            border-radius: 7px;
                            font-size: 12px;
                            font-weight: 700;
                       ">
                        Consultar historial completo →
                    </a>
                </div>

                @if(isset($prestamosRecientes) && $prestamosRecientes->count() > 0)
                    <div style="overflow-x: auto;">
                        <table style="
                            width: 100%;
                            border-collapse: collapse;
                            min-width: 850px;
                        ">
                            <thead>
                                <tr style="background: #7B1E3A; color: white;">
                                    <th style="padding: 12px; text-align: left; font-size: 12px;">Equipo</th>
                                    <th style="padding: 12px; text-align: left; font-size: 12px;">Solicitante</th>
                                    <th style="padding: 12px; text-align: left; font-size: 12px;">Materia</th>
                                    <th style="padding: 12px; text-align: left; font-size: 12px;">Fecha</th>
                                    <th style="padding: 12px; text-align: left; font-size: 12px;">Hora</th>
                                    <th style="padding: 12px; text-align: center; font-size: 12px;">Estado</th>
                                    <th style="padding: 12px; text-align: center; font-size: 12px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($prestamosRecientes as $prestamo)
                                    <tr style="border-bottom: 1px solid #e5e7eb;">
                                        <td style="padding: 11px 12px;">
                                            @if($prestamo->equipo)
                                                <div style="font-weight: 700; color: #111827;">
                                                    {{ $prestamo->equipo->codigo }}
                                                </div>
                                                <div style="font-size: 11px; color: #6b7280;">
                                                    {{ $prestamo->equipo->tipo }}
                                                </div>
                                            @else
                                                <span style="color: #9ca3af;">Equipo no disponible</span>
                                            @endif
                                        </td>

                                        <td style="padding: 11px 12px;">
                                            @if($prestamo->docente)
                                                <div style="font-weight: 600; color: #111827;">
                                                    {{ $prestamo->docente->nombres }} {{ $prestamo->docente->apellidos }}
                                                </div>
                                                <div style="font-size: 11px; color: #6b7280;">Docente</div>
                                            @elseif($prestamo->alumno)
                                                <div style="font-weight: 600; color: #111827;">
                                                    {{ $prestamo->alumno->nombres }} {{ $prestamo->alumno->apellidos }}
                                                </div>
                                                <div style="font-size: 11px; color: #6b7280;">Alumno</div>
                                            @else
                                                <span style="color: #9ca3af;">No especificado</span>
                                            @endif
                                        </td>

                                        <td style="padding: 11px 12px;">
                                            @if($prestamo->materia)
                                                <div style="font-weight: 600;">{{ $prestamo->materia->nombre }}</div>
                                                <div style="font-size: 11px; color: #6b7280;">
                                                    Semestre {{ $prestamo->semestre ?? '—' }}
                                                </div>
                                            @else
                                                <span style="color: #9ca3af;">No especificada</span>
                                            @endif
                                        </td>

                                        <td style="padding: 11px 12px; font-size: 12px; color: #374151;">
                                            {{ $prestamo->fecha_prestamo ? \Carbon\Carbon::parse($prestamo->fecha_prestamo)->format('d/m/Y') : '—' }}
                                        </td>

                                        <td style="padding: 11px 12px; font-size: 12px; color: #374151;">
                                            {{ $prestamo->hora_prestamo ? \Carbon\Carbon::parse($prestamo->hora_prestamo)->format('H:i') : '—' }}
                                        </td>

                                        <td style="padding: 11px 12px; text-align: center;">
                                            @php
                                                $colorEstado = $prestamo->estado === 'Prestado'
                                                    ? ['#fef3c7', '#92400e']
                                                    : ($prestamo->estado === 'Devuelto'
                                                        ? ['#dcfce7', '#166534']
                                                        : ($prestamo->estado === 'Atrasado'
                                                            ? ['#fee2e2', '#991b1b']
                                                            : ['#e5e7eb', '#374151']));
                                            @endphp
                                            <span style="
                                                display: inline-block;
                                                padding: 5px 9px;
                                                background: {{ $colorEstado[0] }};
                                                color: {{ $colorEstado[1] }};
                                                border-radius: 999px;
                                                font-size: 10px;
                                                font-weight: 700;
                                            ">
                                                {{ $prestamo->estado ?? 'Sin estado' }}
                                            </span>
                                        </td>

                                        <td style="padding: 11px 12px; text-align: center;">
                                            <div style="display: flex; justify-content: center; gap: 5px;">
                                                <a href="{{ route('prestamos_equipos.show', $prestamo) }}"
                                                   style="padding: 6px 9px; background: #2563eb; color: white; text-decoration: none; border-radius: 5px; font-size: 11px; font-weight: 600;">
                                                    Ver
                                                </a>
                                                <a href="{{ route('prestamos_equipos.edit', $prestamo) }}"
                                                   style="padding: 6px 9px; background: #f59e0b; color: white; text-decoration: none; border-radius: 5px; font-size: 11px; font-weight: 600;">
                                                    Editar
                                                </a>
                                                <form action="{{ route('prestamos_equipos.destroy', $prestamo) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('¿Seguro que deseas eliminar este préstamo? Esta acción no se puede deshacer.');"
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            style="padding: 6px 9px; background: #dc2626; color: white; border: none; border-radius: 5px; font-size: 11px; font-weight: 600; cursor: pointer;">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div style="padding: 35px 20px; text-align: center;">
                        <div style="font-size: 30px; margin-bottom: 8px;">💻</div>
                        <h4 style="margin: 0; color: #111827; font-size: 15px; font-weight: 700;">
                            No hay préstamos registrados
                        </h4>
                        <p style="margin: 6px 0 15px; color: #6b7280; font-size: 12px;">
                            Cuando registres un préstamo aparecerá aquí.
                        </p>
                        <a href="{{ route('prestamos_equipos.create') }}"
                           style="display: inline-block; padding: 9px 15px; background: #7B1E3A; color: white; text-decoration: none; border-radius: 7px; font-size: 12px; font-weight: 700;">
                            + Registrar primer préstamo
                        </a>
                    </div>
                @endif
            </div>

            @endif

            @if(request('vista') === 'historial')
            {{-- ===================================== --}}
            {{-- HISTORIAL DE PRÉSTAMOS --}}
            {{-- ===================================== --}}

            <div style="
                background: white;
                border-radius: 12px;
                padding: 18px;
                margin-bottom: 12px;
                box-shadow: 0 2px 7px rgba(0,0,0,0.06);
            ">

                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 15px;
                    flex-wrap: wrap;
                ">

                    <div>
                        
                        <a href="{{ route('prestamos_equipos.index') }}"
   style="
       display: inline-block;
       padding: 9px 15px;
       background: #6b7280;
       color: white;
       text-decoration: none;
       border-radius: 7px;
       font-size: 13px;
       font-weight: 600;
   ">
    ← Regresar
</a>

                        <h3 style="
                            font-size: 19px;
                            font-weight: 700;
                            color: #1f2937;
                            margin: 0;
                        ">
                            Historial de préstamos
                        </h3>

                        <p style="
                            margin-top: 5px;
                            color: #6b7280;
                            font-size: 13px;
                        ">
                            Consulta los equipos prestados y su estado actual.
                        </p>

                    </div>

                    <div style="
                        padding: 8px 14px;
                        background: #fce7f3;
                        color: #7B1E3A;
                        border-radius: 8px;
                        font-size: 13px;
                        font-weight: 700;
                    ">
                        Total: {{ $prestamos->total() }}
                    </div>

                </div>

            </div>
            
            {{-- ===================================== --}}
{{-- FILTROS DEL HISTORIAL --}}
{{-- ===================================== --}}

<div style="
    background: white;
    padding: 18px;
    border-radius: 12px;
    margin-bottom: 15px;
    box-shadow: 0 2px 7px rgba(0,0,0,0.06);
">

    <h3 style="
        font-size: 16px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 15px;
    ">
        🔎 Buscar en el historial
    </h3>

    <form method="GET"
          action="{{ route('prestamos_equipos.index') }}">

        <input type="hidden" name="vista" value="historial">

        <div style="
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr));
            gap: 12px;
        ">

            <div>
                <label style="font-size: 12px; font-weight: 600;">
                    Alumno, docente o equipo
                </label>

                <input
                    type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Nombre, matrícula o código..."
                    style="
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #d1d5db;
                        border-radius: 7px;
                        margin-top: 5px;
                    "
                >
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 600;">
                    Desde
                </label>

                <input
                    type="date"
                    name="fecha_desde"
                    value="{{ request('fecha_desde') }}"
                    style="
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #d1d5db;
                        border-radius: 7px;
                        margin-top: 5px;
                    "
                >
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 600;">
                    Hasta
                </label>

                <input
                    type="date"
                    name="fecha_hasta"
                    value="{{ request('fecha_hasta') }}"
                    style="
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #d1d5db;
                        border-radius: 7px;
                        margin-top: 5px;
                    "
                >
            </div>

            <div>
                <label style="font-size: 12px; font-weight: 600;">
                    Estado
                </label>

                <select
                    name="estado"
                    style="
                        width: 100%;
                        padding: 10px;
                        border: 1px solid #d1d5db;
                        border-radius: 7px;
                        margin-top: 5px;
                    "
                >
                    <option value="">Todos los estados</option>

                    <option value="Prestado"
                        {{ request('estado') == 'Prestado' ? 'selected' : '' }}>
                        Prestado
                    </option>

                    <option value="Devuelto"
                        {{ request('estado') == 'Devuelto' ? 'selected' : '' }}>
                        Devuelto
                    </option>

                    <option value="Atrasado"
                        {{ request('estado') == 'Atrasado' ? 'selected' : '' }}>
                        Atrasado
                    </option>
                </select>
            </div>

        </div>

        <div style="
            display: flex;
            gap: 10px;
            margin-top: 15px;
            flex-wrap: wrap;
        ">

            <button type="submit" style="
                background: #7B1E3A;
                color: white;
                border: none;
                padding: 10px 18px;
                border-radius: 7px;
                font-weight: 600;
                cursor: pointer;
            ">
                Buscar
            </button>

            <a href="{{ route('prestamos_equipos.index', ['vista' => 'historial']) }}"
               style="
                   background: #e5e7eb;
                   color: #374151;
                   padding: 10px 18px;
                   border-radius: 7px;
                   text-decoration: none;
                   font-weight: 600;
               ">
                Limpiar filtros
            </a>

        </div>

    </form>
</div>
            
            {{-- ===================================== --}}
            {{-- TABLA DE PRÉSTAMOS --}}
            {{-- ===================================== --}}

            <div style="
                background: white;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            ">

                @if($prestamos->count() > 0)

                    <div style="overflow-x: auto;">

                        <table style="
                            width: 100%;
                            border-collapse: collapse;
                            min-width: 950px;
                        ">

                            <thead>

                                <tr style="
                                    background: #7B1E3A;
                                    color: white;
                                ">

                                    <th style="padding: 13px; text-align: left; font-size: 13px;">
                                        Equipo
                                    </th>

                                    <th style="padding: 13px; text-align: left; font-size: 13px;">
                                        Solicitante
                                    </th>

                                    <th style="padding: 13px; text-align: left; font-size: 13px;">
                                        Materia
                                    </th>

                                    <th style="padding: 13px; text-align: left; font-size: 13px;">
                                        Fecha
                                    </th>

                                    <th style="padding: 13px; text-align: left; font-size: 13px;">
                                        Hora
                                    </th>

                                    <th style="padding: 13px; text-align: center; font-size: 13px;">
                                        Estado
                                    </th>

                                    <th style="padding: 13px; text-align: center; font-size: 13px;">
                                        Acciones
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($prestamos as $prestamo)

                                    <tr style="
                                        border-bottom: 1px solid #e5e7eb;
                                    ">


                                        {{-- EQUIPO --}}
                                        <td style="padding: 12px;">

                                            @if($prestamo->equipo)

                                                <div style="
                                                    font-weight: 700;
                                                    color: #111827;
                                                ">
                                                    {{ $prestamo->equipo->codigo }}
                                                </div>

                                                <div style="
                                                    margin-top: 3px;
                                                    color: #6b7280;
                                                    font-size: 12px;
                                                ">
                                                    {{ $prestamo->equipo->tipo }}
                                                </div>

                                            @else

                                                <span style="color: #9ca3af;">
                                                    Equipo no disponible
                                                </span>

                                            @endif

                                        </td>


                                        {{-- SOLICITANTE --}}
                                        <td style="padding: 12px;">

                                            @if($prestamo->docente)

                                                <div style="
                                                    font-weight: 600;
                                                    color: #111827;
                                                ">
                                                    {{ $prestamo->docente->nombres }}
                                                    {{ $prestamo->docente->apellidos }}
                                                </div>

                                                <div style="
                                                    color: #6b7280;
                                                    font-size: 12px;
                                                ">
                                                    Docente
                                                </div>

                                            @elseif($prestamo->alumno)

                                                <div style="
                                                    font-weight: 600;
                                                    color: #111827;
                                                ">
                                                    {{ $prestamo->alumno->nombres }}
                                                    {{ $prestamo->alumno->apellidos }}
                                                </div>

                                                <div style="
                                                    color: #6b7280;
                                                    font-size: 12px;
                                                ">
                                                    Alumno
                                                </div>

                                            @else

                                                <span style="color: #9ca3af;">
                                                    No especificado
                                                </span>

                                            @endif

                                        </td>


                                        {{-- MATERIA --}}
                                        <td style="padding: 12px;">

                                            @if($prestamo->materia)

                                                <div style="
                                                    font-weight: 600;
                                                    color: #111827;
                                                ">
                                                    {{ $prestamo->materia->nombre }}
                                                </div>

                                                <div style="
                                                    color: #6b7280;
                                                    font-size: 12px;
                                                ">
                                                    Semestre {{ $prestamo->semestre ?? '—' }}
                                                </div>

                                            @else

                                                <span style="color: #9ca3af;">
                                                    No especificada
                                                </span>

                                            @endif

                                        </td>


                                        {{-- FECHA --}}
                                        <td style="
                                            padding: 12px;
                                            color: #374151;
                                            font-size: 13px;
                                        ">

                                            {{ $prestamo->fecha_prestamo
                                                ? $prestamo->fecha_prestamo->format('d/m/Y')
                                                : '—'
                                            }}

                                        </td>


                                        {{-- HORA --}}
                                        <td style="
                                            padding: 12px;
                                            color: #374151;
                                            font-size: 13px;
                                        ">

                                            {{ $prestamo->hora_prestamo
                                                ? \Carbon\Carbon::parse($prestamo->hora_prestamo)->format('H:i')
                                                : '—'
                                            }}

                                        </td>


                                        {{-- ESTADO --}}
                                        <td style="
                                            padding: 12px;
                                            text-align: center;
                                        ">

                                            @if($prestamo->estado === 'Prestado')

                                                <span style="
                                                    display: inline-block;
                                                    padding: 6px 10px;
                                                    background: #fef3c7;
                                                    color: #92400e;
                                                    border-radius: 999px;
                                                    font-size: 11px;
                                                    font-weight: 700;
                                                ">
                                                    Prestado
                                                </span>

                                            @elseif($prestamo->estado === 'Devuelto')

                                                <span style="
                                                    display: inline-block;
                                                    padding: 6px 10px;
                                                    background: #dcfce7;
                                                    color: #166534;
                                                    border-radius: 999px;
                                                    font-size: 11px;
                                                    font-weight: 700;
                                                ">
                                                    Devuelto
                                                </span>

                                            @elseif($prestamo->estado === 'Atrasado')

                                                <span style="
                                                    display: inline-block;
                                                    padding: 6px 10px;
                                                    background: #fee2e2;
                                                    color: #991b1b;
                                                    border-radius: 999px;
                                                    font-size: 11px;
                                                    font-weight: 700;
                                                ">
                                                    Atrasado
                                                </span>

                                            @else

                                                <span style="
                                                    display: inline-block;
                                                    padding: 6px 10px;
                                                    background: #e5e7eb;
                                                    color: #374151;
                                                    border-radius: 999px;
                                                    font-size: 11px;
                                                    font-weight: 700;
                                                ">
                                                    {{ $prestamo->estado ?? 'Sin estado' }}
                                                </span>

                                            @endif

                                        </td>


                                        {{-- ACCIONES --}}
                                        <td style="
                                            padding: 12px;
                                            text-align: center;
                                        ">

                                            <div style="
                                                display: flex;
                                                justify-content: center;
                                                gap: 5px;
                                                flex-wrap: wrap;
                                            ">

                                                <a href="{{ route('prestamos_equipos.show', $prestamo) }}"
                                                   style="
                                                        padding: 7px 10px;
                                                        background: #2563eb;
                                                        color: white;
                                                        text-decoration: none;
                                                        border-radius: 6px;
                                                        font-size: 11px;
                                                        font-weight: 600;
                                                   ">
                                                    Ver
                                                </a>

                                                <a href="{{ route('prestamos_equipos.edit', $prestamo) }}"
                                                   style="
                                                        padding: 7px 10px;
                                                        background: #f59e0b;
                                                        color: white;
                                                        text-decoration: none;
                                                        border-radius: 6px;
                                                        font-size: 11px;
                                                        font-weight: 600;
                                                   ">
                                                    Editar
                                                </a>
                                                <form action="{{ route('prestamos_equipos.destroy', $prestamo) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('¿Seguro que deseas eliminar este préstamo? Esta acción no se puede deshacer.');"
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            style="
                                                                padding: 7px 10px;
                                                                background: #dc2626;
                                                                color: white;
                                                                border: none;
                                                                border-radius: 6px;
                                                                font-size: 11px;
                                                                font-weight: 600;
                                                                cursor: pointer;
                                                            ">
                                                        Eliminar
                                                    </button>
                                                </form>


                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- PAGINACIÓN --}}
                    <div style="
                        padding: 18px;
                        border-top: 1px solid #e5e7eb;
                    ">
                        {{ $prestamos->appends(request()->query())->links() }}
                    </div>


                @else

                    {{-- SIN PRÉSTAMOS --}}
                    <div style="
                        padding: 60px 25px;
                        text-align: center;
                    ">

                        <div style="
                            font-size: 38px;
                            margin-bottom: 15px;
                        ">
                            💻
                        </div>

                        <h3 style="
                            margin: 0;
                            color: #111827;
                            font-size: 19px;
                            font-weight: 700;
                        ">
                            No hay préstamos registrados
                        </h3>

                        <p style="
                            margin: 8px 0 20px;
                            color: #6b7280;
                            font-size: 13px;
                        ">
                            Cuando registres un préstamo aparecerá aquí.
                        </p>

                        <a href="{{ route('prestamos_equipos.create') }}"
                           style="
                                display: inline-block;
                                padding: 11px 20px;
                                background: #7B1E3A;
                                color: white;
                                text-decoration: none;
                                border-radius: 8px;
                                font-weight: 600;
                           ">
                            + Registrar primer préstamo
                        </a>

                    </div>

                @endif

            </div>
            @endif {{-- Fin de la vista de historial --}}

        </div>

    </div>

</x-app-layout>