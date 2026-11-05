 @extends('layouts.app')

@section('content')

<style>
    .tutorias-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .tutorias-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 25px;
    }

    .tutorias-title h1 {
        margin: 0;
        font-size: 30px;
        font-weight: 700;
        color: #1f2937;
    }

    .tutorias-title p {
        margin: 6px 0 0;
        color: #6b7280;
        font-size: 14px;
    }

    .btn-principal {
        background: #7B1E3A;
        color: white;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 9px;
        font-weight: 600;
        white-space: nowrap;
    }

    .btn-principal:hover {
        background: #5D142B;
        color: white;
    }

    /* ACCESOS PRINCIPALES */
    .accesos-tutoria {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 28px;
    }

    .acceso-card {
        display: block;
        background: white;
        border-radius: 12px;
        padding: 22px;
        text-decoration: none;
        box-shadow: 0 3px 12px rgba(0,0,0,.06);
        border-top: 4px solid #7B1E3A;
        transition: .2s;
        cursor: pointer;
        color: inherit;
    }

    .acceso-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 16px rgba(0,0,0,.10);
        text-decoration: none;
    }

    .acceso-card h3 {
        margin: 0 0 8px;
        color: #1f2937;
        font-size: 17px;
    }

    .acceso-card p {
        margin: 0;
        color: #6b7280;
        font-size: 13px;
        line-height: 1.5;
    }

    .seccion-titulo {
        font-size: 21px;
        color: #1f2937;
        font-weight: 700;
        margin: 30px 0 16px;
    }

    /* BUSCADOR */
    .busqueda-box {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,.06);
        margin-bottom: 18px;
    }

    .busqueda-box form {
        display: flex;
        gap: 12px;
        align-items: end;
    }

    .campo-busqueda {
        flex: 1;
    }

    .campo-busqueda label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 7px;
    }

    .campo-busqueda input,
    .campo-busqueda select {
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        box-sizing: border-box;
    }

    .btn-buscar {
        border: none;
        background: #7B1E3A;
        color: white;
        padding: 11px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-buscar:hover {
        background: #5D142B;
    }

    .btn-limpiar {
        background: #e5e7eb;
        color: #374151;
        padding: 11px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    .mensaje-exito {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 20px;
    }

    .mensaje-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 20px;
    }

    /* LISTADO COMPACTO */
    .tutorias-lista {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .tutoria-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,.05);
        padding: 13px 17px;
        border-left: 4px solid #7B1E3A;
    }

    .tutoria-superior {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .alumno-info {
        min-width: 0;
    }

    .alumno-info h3 {
        margin: 0 0 5px;
        font-size: 15px;
        font-weight: 700;
        color: #111827;
    }

    .alumno-info span {
        font-size: 12px;
        color: #6b7280;
    }

    .tutoria-resumen {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
        margin-top: 9px;
        color: #6b7280;
        font-size: 12px;
    }

    .tutoria-resumen span {
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    /* ESTADOS */
    .estado {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .estado-pendiente {
        background: #fef3c7;
        color: #92400e;
    }

    .estado-seguimiento {
        background: #dbeafe;
        color: #1e40af;
    }

    .estado-concluida {
        background: #dcfce7;
        color: #166534;
    }

    /* INFORMACIÓN DESPLEGABLE */
    .tutoria-detalle {
        margin-top: 10px;
        border-top: 1px solid #eeeeee;
        padding-top: 9px;
    }

    .tutoria-detalle summary {
        color: #7B1E3A;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        list-style: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .tutoria-detalle summary::-webkit-details-marker {
        display: none;
    }

    .tutoria-detalle summary::before {
        content: '+';
        font-size: 16px;
        font-weight: 800;
    }

    .tutoria-detalle[open] summary::before {
        content: '−';
    }

    .detalle-contenido {
        background: #f9fafb;
        border-radius: 8px;
        padding: 12px;
        margin-top: 10px;
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .detalle-item strong {
        display: block;
        font-size: 11px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .detalle-item span {
        display: block;
        font-size: 13px;
        color: #1f2937;
        overflow-wrap: anywhere;
    }

    .detalle-completo {
        grid-column: 1 / -1;
    }

    /* ACCIONES */
    .acciones {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 10px;
    }

    .btn-accion {
        display: inline-block;
        padding: 7px 12px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    .btn-ver {
        background: #f3e8ed;
        color: #7B1E3A;
    }

    .btn-ver:hover {
        background: #ead5dd;
        color: #5D142B;
    }

    .btn-expediente {
        background: #e0f2fe;
        color: #0369a1;
    }

    .btn-expediente:hover {
        background: #cce9fa;
        color: #075985;
    }

    .sin-resultados {
        background: white;
        text-align: center;
        padding: 50px 20px;
        border-radius: 12px;
        color: #6b7280;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
    }

    .paginacion {
        margin-top: 20px;
    }

    /* RESPONSIVE */
    @media (max-width: 750px) {
        .tutorias-header {
            flex-direction: column;
            align-items: stretch;
        }

        .accesos-tutoria {
            grid-template-columns: 1fr;
        }

        .busqueda-box form {
            flex-direction: column;
            align-items: stretch;
        }

        .tutoria-superior {
            align-items: flex-start;
            flex-direction: column;
        }

        .tutoria-resumen {
            gap: 9px 15px;
        }

        .acciones {
            justify-content: flex-start;
        }

        .detalle-contenido {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="tutorias-container">

    {{-- ENCABEZADO --}}
    <div class="tutorias-header">

        <div class="tutorias-title">
            <h1>Tutorías</h1>

            <p>
                Atención individual, actividades grupales y seguimiento de alumnos.
            </p>
        </div>

        <a href="{{ route('tutorias.create') }}" class="btn-principal">
            + Nueva atención individual
        </a>

    </div>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="mensaje-exito">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mensaje-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- ACCESOS PRINCIPALES --}}
    <div class="accesos-tutoria">

        <a href="{{ route('tutorias.actividades.index') }}"
           class="acceso-card">

            <h3>Actividades grupales</h3>

            <p>
                Registrar actividades de tutoría por grupo, temas,
                asistencia y observaciones de los alumnos.
            </p>

        </a>

        <a href="{{ route('tutorias.create') }}"
           class="acceso-card">

            <h3>Atención individual</h3>

            <p>
                Registrar conversaciones privadas, situaciones,
                acuerdos y compromisos con los alumnos.
            </p>

        </a>

        <a href="{{ route('tutorias.expedientes.index') }}"
           class="acceso-card">

            <h3>Expedientes de alumnos</h3>

            <p>
                Consultar los alumnos y acceder a sus expedientes individuales de tutoría.
            </p>

        </a>

    </div>

    {{-- LISTADO --}}
    <h2 class="seccion-titulo">
        Atenciones individuales registradas
    </h2>

    {{-- BUSCADOR --}}
    <div class="busqueda-box">

        <form method="GET" action="{{ route('tutorias.index') }}">

            <div class="campo-busqueda">

                <label for="buscar">
                    Buscar alumno
                </label>

                <input
                    type="text"
                    id="buscar"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Matrícula, nombre o apellido..."
                >

            </div>

            <div class="campo-busqueda">

                <label for="estado">
                    Estado
                </label>

                <select name="estado" id="estado">

                    <option value="">
                        Todos los estados
                    </option>

                    <option value="Pendiente"
                        {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>
                        Pendiente
                    </option>

                    <option value="En seguimiento"
                        {{ request('estado') == 'En seguimiento' ? 'selected' : '' }}>
                        En seguimiento
                    </option>

                    <option value="Concluida"
                        {{ request('estado') == 'Concluida' ? 'selected' : '' }}>
                        Concluida
                    </option>

                </select>

            </div>

            <button type="submit" class="btn-buscar">
                Buscar
            </button>

            @if(request()->hasAny(['buscar', 'estado']))
                <a href="{{ route('tutorias.index') }}" class="btn-limpiar">
                    Limpiar
                </a>
            @endif

        </form>

    </div>

    {{-- TARJETAS COMPACTAS DE ATENCIONES --}}
    @if($tutorias->count())

        <div class="tutorias-lista">

            @foreach($tutorias as $tutoria)

                <div class="tutoria-card">

                    {{-- INFORMACIÓN PRINCIPAL --}}
                    <div class="tutoria-superior">

                        <div class="alumno-info">

                            <h3>
                                {{ $tutoria->alumno->nombres ?? 'Alumno no disponible' }}
                                {{ $tutoria->alumno->apellidos ?? '' }}
                            </h3>

                            <span>
                                Matrícula:
                                {{ $tutoria->alumno->matricula ?? 'Sin matrícula' }}

                                @if($tutoria->alumno && $tutoria->alumno->grupo)
                                    | Grupo: {{ $tutoria->alumno->grupo->nombre }}
                                @endif
                            </span>

                            {{-- RESUMEN --}}
                            <div class="tutoria-resumen">

                                <span>
                                    📅
                                    {{ $tutoria->fecha->format('d/m/Y') }}
                                </span>

                                <span>
                                    📁
                                    {{ $tutoria->tipo }}
                                </span>

                            </div>

                        </div>

                        {{-- ESTADO --}}
                        @if($tutoria->estado === 'Pendiente')

                            <span class="estado estado-pendiente">
                                Pendiente
                            </span>

                        @elseif($tutoria->estado === 'En seguimiento')

                            <span class="estado estado-seguimiento">
                                En seguimiento
                            </span>

                        @else

                            <span class="estado estado-concluida">
                                Concluida
                            </span>

                        @endif

                    </div>

                    {{-- INFORMACIÓN ADICIONAL DESPLEGABLE --}}
                    <details class="tutoria-detalle">

                        <summary>
                            Más información
                        </summary>

                        <div class="detalle-contenido">

                            <div class="detalle-item">
                                <strong>Docente responsable</strong>

                                <span>
                                    @if($tutoria->docente)
                                        {{ $tutoria->docente->nombres }}
                                        {{ $tutoria->docente->apellidos }}
                                    @else
                                        Sin asignar
                                    @endif
                                </span>
                            </div>

                            <div class="detalle-item">
                                <strong>Fecha de atención</strong>

                                <span>
                                    {{ $tutoria->fecha->format('d/m/Y') }}
                                </span>
                            </div>

                            <div class="detalle-item detalle-completo">
                                <strong>Motivo de atención</strong>

                                <span>
                                    {{ $tutoria->motivo ?: 'Sin motivo registrado' }}
                                </span>
                            </div>

                        </div>

                    </details>

                    {{-- ACCIONES --}}
                    <div class="acciones">

                        <a href="{{ route('tutorias.show', $tutoria) }}"
                           class="btn-accion btn-ver">
                            Ver atención
                        </a>

                        @if($tutoria->alumno)

                            <a href="{{ route('tutorias.expedientes.show', $tutoria->alumno) }}"
                               class="btn-accion btn-expediente">
                                Expediente del alumno
                            </a>

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

        {{-- PAGINACIÓN --}}
        <div class="paginacion">
            {{ $tutorias->links() }}
        </div>

    @else

        <div class="sin-resultados">

            <h3>
                No hay atenciones individuales registradas
            </h3>

            <p>
                Cuando registres una atención individual aparecerá aquí.
            </p>

            <a href="{{ route('tutorias.create') }}"
               class="btn-principal"
               style="display:inline-block; margin-top:12px;">

                Registrar primera atención

            </a>

        </div>

    @endif

</div>

@endsection