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
                    Detalle del préstamo
                </h2>

                <p style="
                    margin-top: 4px;
                    color: #6b7280;
                    font-size: 14px;
                ">
                    Consulta toda la información del préstamo y del equipo.
                </p>

            </div>


            <div style="
                display: flex;
                gap: 10px;
                flex-wrap: wrap;
            ">

                <a
                    href="{{ route('prestamos_equipos.index') }}"
                    style="
                        display: inline-block;
                        padding: 10px 18px;
                        background: #6b7280;
                        color: white;
                        text-decoration: none;
                        border-radius: 8px;
                        font-weight: 600;
                        font-size: 14px;
                    "
                >
                    ← Volver
                </a>


               <a
    href="{{ route('prestamos_equipos.edit', ['prestamoEquipo' => $prestamoEquipo->id]) }}"
    style="
        display: inline-block;
        padding: 10px 18px;
        background: #f59e0b;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
    "
>
    Editar
</a>

            </div>

        </div>

    </x-slot>


    <div style="
        padding: 30px;
        background: #f3f4f6;
        min-height: calc(100vh - 80px);
    ">

        <div style="
            max-width: 1000px;
            margin: 0 auto;
        ">


            {{-- MENSAJE --}}
            @if(session('success'))

                <div style="
                    background: #dcfce7;
                    border: 1px solid #86efac;
                    color: #166534;
                    padding: 14px 18px;
                    border-radius: 10px;
                    margin-bottom: 20px;
                    font-weight: 600;
                ">
                    {{ session('success') }}
                </div>

            @endif


            {{-- ESTADO DEL PRÉSTAMO --}}
            <div style="
                background: white;
                border-radius: 12px;
                padding: 22px 25px;
                margin-bottom: 20px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            ">

                <div style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    gap: 15px;
                    flex-wrap: wrap;
                ">

                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 13px;
                            margin-bottom: 5px;
                        ">
                            Estado del préstamo
                        </div>

                        <div style="
                            font-size: 22px;
                            font-weight: 700;
                            color: #111827;
                        ">
                            {{ $prestamoEquipo->estado }}
                        </div>

                    </div>


                    @if($prestamoEquipo->estado === 'Prestado')

                        <span style="
                            padding: 9px 16px;
                            background: #fef3c7;
                            color: #92400e;
                            border-radius: 999px;
                            font-size: 13px;
                            font-weight: 700;
                        ">
                            EQUIPO PRESTADO
                        </span>

                    @elseif($prestamoEquipo->estado === 'Devuelto')

                        <span style="
                            padding: 9px 16px;
                            background: #dcfce7;
                            color: #166534;
                            border-radius: 999px;
                            font-size: 13px;
                            font-weight: 700;
                        ">
                            EQUIPO DEVUELTO
                        </span>

                    @elseif($prestamoEquipo->estado === 'Atrasado')

                        <span style="
                            padding: 9px 16px;
                            background: #fee2e2;
                            color: #991b1b;
                            border-radius: 999px;
                            font-size: 13px;
                            font-weight: 700;
                        ">
                            PRÉSTAMO ATRASADO
                        </span>

                    @endif

                </div>

            </div>


            {{-- EQUIPO --}}
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
                    color: #111827;
                    border-bottom: 1px solid #e5e7eb;
                    padding-bottom: 12px;
                ">
                    Equipo tecnológico
                </h3>


                <div style="
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                    gap: 18px;
                ">


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Código
                        </div>

                        <div style="
                            font-weight: 700;
                            color: #111827;
                            font-size: 18px;
                        ">
                            {{ $prestamoEquipo->equipo?->codigo ?? 'No disponible' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Tipo
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->equipo?->tipo ?? '—' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Marca
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->equipo?->marca ?? '—' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Modelo
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->equipo?->modelo ?? '—' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Número de serie
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->equipo?->numero_serie ?? '—' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Ubicación
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->equipo?->ubicacion ?? '—' }}
                        </div>

                    </div>

                </div>

            </div>


            {{-- SOLICITANTE --}}
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
                    color: #111827;
                    border-bottom: 1px solid #e5e7eb;
                    padding-bottom: 12px;
                ">
                    Datos del solicitante
                </h3>


                <div style="
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                    gap: 18px;
                ">


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Docente
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            @if($prestamoEquipo->docente)

                                {{ $prestamoEquipo->docente->nombres }}
                                {{ $prestamoEquipo->docente->apellidos }}

                            @else

                                No especificado

                            @endif
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Alumno
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            @if($prestamoEquipo->alumno)

                                {{ $prestamoEquipo->alumno->nombres }}
                                {{ $prestamoEquipo->alumno->apellidos }}

                            @else

                                No especificado

                            @endif
                        </div>

                    </div>


                    @if($prestamoEquipo->alumno)

                        <div>

                            <div style="
                                color: #6b7280;
                                font-size: 12px;
                                margin-bottom: 5px;
                            ">
                                Matrícula
                            </div>

                            <div style="
                                font-weight: 600;
                                color: #374151;
                            ">
                                {{ $prestamoEquipo->alumno->matricula ?? '—' }}
                            </div>

                        </div>


                        <div>

                            <div style="
                                color: #6b7280;
                                font-size: 12px;
                                margin-bottom: 5px;
                            ">
                                Grupo
                            </div>

                            <div style="
                                font-weight: 600;
                                color: #374151;
                            ">

                                @if($prestamoEquipo->alumno->grupo)

                                    {{ $prestamoEquipo->alumno->grupo->grado }}°{{ strtoupper($prestamoEquipo->alumno->grupo->nombre) }}

                                @else

                                    —

                                @endif

                            </div>

                        </div>

                    @endif

                </div>

            </div>


            {{-- INFORMACIÓN ACADÉMICA --}}
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
                    color: #111827;
                    border-bottom: 1px solid #e5e7eb;
                    padding-bottom: 12px;
                ">
                    Información académica
                </h3>


                <div style="
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                    gap: 18px;
                ">


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Asignatura
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->materia?->nombre ?? 'No especificada' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Semestre
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->semestre ? $prestamoEquipo->semestre . '°' : '—' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Fecha del préstamo
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->fecha_prestamo?->format('d/m/Y') ?? '—' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Hora del préstamo
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->hora_prestamo
                                ? \Carbon\Carbon::parse($prestamoEquipo->hora_prestamo)->format('H:i')
                                : '—'
                            }}
                        </div>

                    </div>

                </div>

            </div>


            {{-- DEVOLUCIÓN --}}
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
                    color: #111827;
                    border-bottom: 1px solid #e5e7eb;
                    padding-bottom: 12px;
                ">
                    Información de devolución
                </h3>


                <div style="
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                    gap: 18px;
                ">


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Fecha de devolución
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->fecha_devolucion?->format('d/m/Y') ?? 'Pendiente' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Hora de devolución
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->hora_devolucion
                                ? \Carbon\Carbon::parse($prestamoEquipo->hora_devolucion)->format('H:i')
                                : 'Pendiente'
                            }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Condición de entrega
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->condicion_entrega ?? '—' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Condición de devolución
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->condicion_devolucion ?? 'Pendiente' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Responsable de entrega
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->responsable_entrega ?? '—' }}
                        </div>

                    </div>


                    <div>

                        <div style="
                            color: #6b7280;
                            font-size: 12px;
                            margin-bottom: 5px;
                        ">
                            Responsable de recepción
                        </div>

                        <div style="
                            font-weight: 600;
                            color: #374151;
                        ">
                            {{ $prestamoEquipo->responsable_recepcion ?? 'Pendiente' }}
                        </div>

                    </div>

                </div>

            </div>


            {{-- OBSERVACIONES --}}
            <div style="
                background: white;
                border-radius: 12px;
                padding: 25px;
                margin-bottom: 20px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            ">

                <h3 style="
                    margin: 0 0 15px;
                    font-size: 19px;
                    font-weight: 700;
                    color: #111827;
                ">
                    Observaciones
                </h3>

                <div style="
                    padding: 15px;
                    background: #f9fafb;
                    border-radius: 8px;
                    color: #374151;
                    line-height: 1.6;
                ">
                    {{ $prestamoEquipo->observaciones ?? 'Sin observaciones.' }}
                </div>

            </div>


            {{-- ELIMINAR --}}
            <div style="
                background: white;
                border-radius: 12px;
                padding: 20px 25px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                display: flex;
                justify-content: flex-end;
            ">

                <form
    action="{{ route('prestamos_equipos.destroy', ['prestamoEquipo' => $prestamoEquipo->id]) }}"
    method="POST"
    onsubmit="return confirm('¿Seguro que deseas eliminar este préstamo?');"
>

                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        style="
                            padding: 10px 18px;
                            background: #dc2626;
                            color: white;
                            border: none;
                            border-radius: 8px;
                            font-weight: 600;
                            cursor: pointer;
                        "
                    >
                        Eliminar préstamo
                    </button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>