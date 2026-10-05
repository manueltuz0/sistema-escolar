@extends('layouts.app')

@section('content')

<style>

    .tutorias-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    /* ENCABEZADO */

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

    .btn-nueva-tutoria {
        background: #2563eb;
        color: white;
        text-decoration: none;
        padding: 12px 20px;
        border-radius: 9px;
        font-weight: 600;
        transition: .2s;
        white-space: nowrap;
    }

    .btn-nueva-tutoria:hover {
        background: #1d4ed8;
        color: white;
    }

    /* BUSCADOR */

    .busqueda-box {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,.06);
        margin-bottom: 25px;
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

    .campo-busqueda input {
        width: 100%;
        padding: 11px 14px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        outline: none;
        box-sizing: border-box;
    }

    .campo-busqueda input:focus {
        border-color: #2563eb;
    }

    .btn-buscar {
        border: none;
        background: #374151;
        color: white;
        padding: 11px 22px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-limpiar {
        background: #e5e7eb;
        color: #374151;
        padding: 11px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    /* MENSAJE */

    .mensaje-exito {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 20px;
    }

    /* TARJETAS */

    .tutorias-lista {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .tutoria-card {
        background: white;
        border-radius: 13px;
        box-shadow: 0 3px 12px rgba(0,0,0,.07);
        padding: 20px;
        border-left: 5px solid #2563eb;
    }

    .tutoria-superior {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 15px;
    }

    .alumno-info h3 {
        margin: 0 0 5px;
        font-size: 19px;
        color: #111827;
    }

    .alumno-info span {
        font-size: 13px;
        color: #6b7280;
    }

    /* ESTADO */

    .estado {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
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

    /* INCIDENCIA RELACIONADA */

    .incidencia-relacionada {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px;
        margin-bottom: 15px;
    }

    .incidencia-titulo {
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        text-transform: uppercase;
        margin-bottom: 7px;
    }

    .incidencia-contenido {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .incidencia-tipo {
        font-weight: 700;
        color: #1f2937;
    }

    .incidencia-fecha {
        color: #6b7280;
        font-size: 13px;
    }

    .sin-incidencia {
        color: #9ca3af;
        font-size: 13px;
        font-style: italic;
    }

    /* INFORMACIÓN */

    .tutoria-datos {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 15px;
        margin-bottom: 16px;
    }

    .dato {
        background: #f9fafb;
        padding: 12px;
        border-radius: 8px;
    }

    .dato strong {
        display: block;
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 4px;
    }

    .dato span {
        font-size: 14px;
        color: #1f2937;
    }

    /* BOTONES */

    .acciones {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        border-top: 1px solid #e5e7eb;
        padding-top: 14px;
    }

    .btn-accion {
        padding: 8px 13px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .btn-ver {
        background: #e0f2fe;
        color: #0369a1;
    }

    .btn-editar {
        background: #fef3c7;
        color: #92400e;
    }

    .btn-eliminar {
        background: #fee2e2;
        color: #b91c1c;
    }

    .form-eliminar {
        display: inline;
    }

    /* SIN RESULTADOS */

    .sin-resultados {
        background: white;
        text-align: center;
        padding: 50px 20px;
        border-radius: 12px;
        color: #6b7280;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
    }

    /* PAGINACIÓN */

    .paginacion {
        margin-top: 25px;
    }

    /* RESPONSIVE */

    @media (max-width: 750px) {

        .tutorias-header {
            flex-direction: column;
            align-items: stretch;
        }

        .busqueda-box form {
            flex-direction: column;
            align-items: stretch;
        }

        .tutoria-superior {
            flex-direction: column;
        }

        .tutoria-datos {
            grid-template-columns: 1fr;
        }

        .acciones {
            justify-content: flex-start;
            flex-wrap: wrap;
        }
    }

</style>


<div class="tutorias-container">

    {{-- ENCABEZADO --}}

    <div class="tutorias-header">

        <div class="tutorias-title">

            <h1>
                Tutorías
            </h1>

            <p>
                Seguimiento y atención de alumnos relacionados con incidencias escolares.
            </p>

        </div>

        <a
            href="{{ route('tutorias.create') }}"
            class="btn-nueva-tutoria"
        >
            + Registrar tutoría
        </a>

    </div>
    <div class="container">

    {{-- BOTÓN REGRESAR A INCIDENCIAS --}}
    <div style="margin-bottom: 20px;">
        <a href="{{ route('incidencias.index') }}"
           style="
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 10px 18px;
                background: #6c757d;
                color: white;
                text-decoration: none;
                border-radius: 8px;
                font-weight: 600;
                transition: 0.2s;
           ">
            ← Regresar a Incidencias
        </a>
    </div>


    {{-- MENSAJE DE ÉXITO --}}

    @if(session('success'))

        <div class="mensaje-exito">
            {{ session('success') }}
        </div>

    @endif


    {{-- BUSCADOR --}}

    <div class="busqueda-box">

        <form
            method="GET"
            action="{{ route('tutorias.index') }}"
        >

            <div class="campo-busqueda">

                <label>
                    Buscar alumno
                </label>

                <input
                    type="text"
                    name="buscar"
                    value="{{ request('buscar') }}"
                    placeholder="Matrícula, nombre o apellido..."
                >

            </div>

            <button
                type="submit"
                class="btn-buscar"
            >
                Buscar
            </button>

            @if(request('buscar'))

                <a
                    href="{{ route('tutorias.index') }}"
                    class="btn-limpiar"
                >
                    Limpiar
                </a>

            @endif

        </form>

    </div>


    {{-- LISTA DE TUTORÍAS --}}

    @if($tutorias->count())

        <div class="tutorias-lista">

            @foreach($tutorias as $tutoria)

                <div class="tutoria-card">

                    {{-- PARTE SUPERIOR --}}

                    <div class="tutoria-superior">

                        <div class="alumno-info">

                            <h3>

                                {{ $tutoria->alumno->nombres ?? 'Alumno no disponible' }}

                                {{ $tutoria->alumno->apellidos ?? '' }}

                            </h3>

                            <span>

                                Matrícula:

                                {{ $tutoria->alumno->matricula ?? 'Sin matrícula' }}

                            </span>

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


                    {{-- INCIDENCIA RELACIONADA --}}

                    <div class="incidencia-relacionada">

                        <div class="incidencia-titulo">
                            Incidencia relacionada
                        </div>


                        @if($tutoria->incidencia)

                            <div class="incidencia-contenido">

                                <span class="incidencia-tipo">

                                    {{ $tutoria->incidencia->tipo }}

                                </span>

                                <span class="incidencia-fecha">

                                    {{ \Carbon\Carbon::parse($tutoria->incidencia->fecha)->format('d/m/Y') }}

                                </span>

                                <span class="incidencia-fecha">

                                    {{ Str::limit($tutoria->incidencia->descripcion, 100) }}

                                </span>

                            </div>

                        @else

                            <span class="sin-incidencia">

                                Esta tutoría no está relacionada con una incidencia.

                            </span>

                        @endif

                    </div>


                    {{-- DATOS DE LA TUTORÍA --}}

                    <div class="tutoria-datos">

                        <div class="dato">

                            <strong>
                                Fecha de tutoría
                            </strong>

                            <span>

                                {{ \Carbon\Carbon::parse($tutoria->fecha)->format('d/m/Y') }}

                            </span>

                        </div>


                        <div class="dato">

                            <strong>
                                Tipo de tutoría
                            </strong>

                            <span>
                                {{ $tutoria->tipo }}
                            </span>

                        </div>


                        <div class="dato">

                            <strong>
                                Motivo
                            </strong>

                            <span>
                                {{ $tutoria->motivo }}
                            </span>

                        </div>

                    </div>


                    {{-- BOTONES --}}

                    <div class="acciones">

                        <a
                            href="{{ route('tutorias.show', $tutoria) }}"
                            class="btn-accion btn-ver"
                        >
                            Ver
                        </a>


                        <a
                            href="{{ route('tutorias.edit', $tutoria) }}"
                            class="btn-accion btn-editar"
                        >
                            Editar
                        </a>


                        <form
                            action="{{ route('tutorias.destroy', $tutoria) }}"
                            method="POST"
                            class="form-eliminar"
                            onsubmit="return confirm('¿Seguro que deseas eliminar esta tutoría?');"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn-accion btn-eliminar"
                            >
                                Eliminar
                            </button>

                        </form>

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
                No hay tutorías registradas
            </h3>

            <p>
                Cuando registres una tutoría aparecerá aquí junto con la incidencia relacionada.
            </p>

        </div>

    @endif

</div>

@endsection