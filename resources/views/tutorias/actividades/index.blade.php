@extends('layouts.app')

@section('content')

<style>
    .actividades-container {
        max-width: 1450px;
        margin: 0 auto;
        padding: 28px 24px;
        color: #35111d;
    }

    /* ENCABEZADO */
    .actividades-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        padding: 28px;
        margin-bottom: 25px;
        border-radius: 15px;
        color: white;
        background: linear-gradient(135deg, #5b1729, #8b2942);
        box-shadow: 0 5px 18px rgba(40,20,25,.10);
    }

    .actividades-header h2 {
        margin: 0 0 8px;
        font-size: 25px;
        font-weight: 700;
    }

    .actividades-header p {
        margin: 0;
        color: #f8e9ee;
    }

    .encabezado-acciones {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn-nueva,
    .btn-regresar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 18px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        transition: .2s;
        white-space: nowrap;
    }

    .btn-nueva {
        background: white;
        color: #7b1e3a;
        border: 1px solid white;
    }

    .btn-nueva:hover {
        background: #f8e9ee;
        color: #5d142b;
    }

    .btn-regresar {
        background: transparent;
        color: white;
        border: 1px solid rgba(255,255,255,.75);
    }

    .btn-regresar:hover {
        background: rgba(255,255,255,.15);
        color: white;
    }

    /* MENSAJES */
    .mensaje {
        padding: 14px 18px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: 600;
    }

    .mensaje-exito {
        background: #e4f5e9;
        color: #17643a;
        border: 1px solid #bce5c9;
    }

    .mensaje-error {
        background: #fde8e8;
        color: #a12626;
        border: 1px solid #f5c2c2;
    }

    /* TARJETAS */
    .actividad-card {
        background: white;
        border: 1px solid #eadde1;
        border-radius: 13px;
        margin-bottom: 24px;
        overflow: hidden;
        box-shadow: 0 5px 18px rgba(40,20,25,.06);
    }

    .actividad-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        padding: 18px 22px;
        background: #f8eef1;
        border-bottom: 1px solid #eadde1;
    }

    .actividad-card-header h3 {
        margin: 0;
        color: #7b1e3a;
        font-size: 17px;
        font-weight: 700;
    }

    .total-registros {
        color: #77656c;
        font-size: 13px;
    }

    /* BUSCADOR */
    .buscador-body {
        padding: 22px;
    }

    .buscador-form {
        display: grid;
        grid-template-columns: minmax(250px, 1fr) auto;
        gap: 15px;
        align-items: end;
    }

    .buscador-campo label {
        display: block;
        margin-bottom: 7px;
        color: #603443;
        font-weight: 600;
    }

    .buscador-campo input {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 14px;
        border: 1px solid #d8cbd0;
        border-radius: 8px;
        font-size: 14px;
        outline: none;
    }

    .buscador-campo input:focus {
        border-color: #7b1e3a;
        box-shadow: 0 0 0 3px rgba(123,30,58,.10);
    }

    .buscador-acciones {
        display: flex;
        gap: 9px;
    }

    .btn-buscar,
    .btn-limpiar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 17px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .btn-buscar {
        background: #7b1e3a;
        color: white;
    }

    .btn-buscar:hover {
        background: #5d142b;
    }

    .btn-limpiar {
        background: white;
        color: #603443;
        border-color: #d8cbd0;
    }

    .btn-limpiar:hover {
        background: #f8eef1;
    }

    /* TABLA */
    .tabla-contenedor {
        width: 100%;
        overflow-x: auto;
    }

    .tabla-actividades {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        text-align: left;
    }

    .tabla-actividades thead th {
        padding: 15px 13px;
        background: #7b1e3a;
        color: white;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .tabla-actividades tbody td {
        padding: 15px 13px;
        border-bottom: 1px solid #eee5e9;
        font-size: 13px;
        vertical-align: middle;
    }

    .tabla-actividades tbody tr:hover {
        background: #fcf7f9;
    }

    .tabla-actividades tbody tr:last-child td {
        border-bottom: none;
    }

    .tema-actividad {
        font-weight: 700;
        color: #603443;
        min-width: 170px;
    }

    .grupo-etiqueta {
        display: inline-block;
        padding: 7px 13px;
        border-radius: 7px;
        background: #f8e6ec;
        color: #7b1e3a;
        font-weight: 700;
        white-space: nowrap;
    }

    .docente-nombre {
        min-width: 170px;
    }

    .participantes-numero {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 30px;
        padding: 0 8px;
        border-radius: 20px;
        background: #e9f2ff;
        color: #24558a;
        font-weight: 700;
    }

    /* ACCIONES DE TABLA */
    .acciones-tabla {
        display: flex;
        gap: 8px;
    }

    .btn-accion {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 11px;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .btn-ver {
        background: #e8f1ff;
        color: #24558a;
    }

    .btn-ver:hover {
        background: #d5e6ff;
        color: #24558a;
    }

    .btn-editar {
        background: #fff1d6;
        color: #875313;
    }

    .btn-editar:hover {
        background: #ffe5ae;
        color: #875313;
    }

    /* SIN REGISTROS */
    .estado-vacio {
        padding: 50px 20px;
        text-align: center;
        color: #766b70;
    }

    .estado-vacio h3 {
        color: #603443;
        font-weight: 700;
        font-size: 19px;
    }

    .estado-vacio p {
        margin-bottom: 20px;
    }

    /* PAGINACIÓN */
    .paginacion {
        padding: 18px 22px;
        border-top: 1px solid #eee5e9;
    }

    @media(max-width: 700px) {
        .actividades-container {
            padding: 18px 12px;
        }

        .actividades-header {
            padding: 22px;
        }

        .actividades-header h2 {
            font-size: 21px;
        }

        .encabezado-acciones {
            width: 100%;
        }

        .encabezado-acciones a {
            flex: 1;
        }

        .buscador-form {
            grid-template-columns: 1fr;
        }

        .buscador-acciones {
            width: 100%;
        }

        .btn-buscar,
        .btn-limpiar {
            flex: 1;
        }
    }
</style>

<div class="actividades-container">

    {{-- ENCABEZADO --}}
    <div class="actividades-header">

        <div>
            <h2>Actividades grupales de tutoría</h2>

            <p>
                Registro y seguimiento de actividades realizadas con los grupos escolares.
            </p>
        </div>

        {{-- BOTONES SUPERIORES --}}
        <div class="encabezado-acciones">

            <a href="{{ route('tutorias.index') }}"
               class="btn-regresar">
                ← Regresar a Tutorías
            </a>

            <a href="{{ route('tutorias.actividades.create') }}"
               class="btn-nueva">
                ＋ Nueva actividad
            </a>

        </div>

    </div>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="mensaje mensaje-exito">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="mensaje mensaje-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- BUSCADOR --}}
    <div class="actividad-card">

        <div class="actividad-card-header">
            <h3>Buscar actividades</h3>
        </div>

        <div class="buscador-body">

            <form method="GET"
                  action="{{ route('tutorias.actividades.index') }}"
                  class="buscador-form">

                <div class="buscador-campo">

                    <label for="buscar">Buscar actividad</label>

                    <input
                        type="text"
                        id="buscar"
                        name="buscar"
                        value="{{ request('buscar') }}"
                        placeholder="Buscar por tema, grupo o docente..."
                    >

                </div>

                <div class="buscador-acciones">

                    <button type="submit" class="btn-buscar">
                        Buscar
                    </button>

                    <a href="{{ route('tutorias.actividades.index') }}"
                       class="btn-limpiar">
                        Limpiar
                    </a>

                </div>

            </form>

        </div>

    </div>

    {{-- ACTIVIDADES REGISTRADAS --}}
    <div class="actividad-card">

        <div class="actividad-card-header">

            <h3>Actividades registradas</h3>

            <span class="total-registros">
                {{ $actividades->total() }} registro(s)
            </span>

        </div>

        @if($actividades->count())

            <div class="tabla-contenedor">

                <table class="tabla-actividades">

                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Tema</th>
                            <th>Tipo</th>
                            <th>Grupo</th>
                            <th>Docente responsable</th>
                            <th>Participantes</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($actividades as $actividad)

                            <tr>

                                <td>
                                    {{ $actividad->fecha?->format('d/m/Y') }}
                                </td>

                                <td class="tema-actividad">
                                    {{ $actividad->tema }}
                                </td>

                                <td>
                                    {{ $actividad->tipo }}
                                </td>

                                <td>
                                    @if($actividad->grupo)
                                        <span class="grupo-etiqueta">
                                            {{ $actividad->grupo->grado }}.{{ $actividad->grupo->nombre }}
                                        </span>
                                    @else
                                        <span>Sin grupo</span>
                                    @endif
                                </td>

                                <td class="docente-nombre">
                                    @if($actividad->docente)
                                        {{ $actividad->docente->nombres }}
                                        {{ $actividad->docente->apellidos }}
                                    @else
                                        Sin docente
                                    @endif
                                </td>

                                <td>
                                    <span class="participantes-numero">
                                        {{ $actividad->alumnos->count() }}
                                    </span>
                                </td>

                                <td>
                                    <div class="acciones-tabla">

                                        <a
                                            href="{{ route('tutorias.actividades.show', $actividad) }}"
                                            class="btn-accion btn-ver"
                                            title="Consultar actividad"
                                        >
                                            Ver
                                        </a>

                                        <a
                                            href="{{ route('tutorias.actividades.edit', $actividad) }}"
                                            class="btn-accion btn-editar"
                                            title="Editar actividad"
                                        >
                                            Editar
                                        </a>

                                    </div>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <div class="paginacion">
                {{ $actividades->links() }}
            </div>

        @else

            <div class="estado-vacio">

                <h3>No hay actividades registradas</h3>

                <p>
                    Todavía no se han registrado actividades grupales de tutoría.
                </p>

                <a href="{{ route('tutorias.actividades.create') }}"
                   class="btn-nueva"
                   style="background:#7b1e3a; color:white;">
                    ＋ Nueva actividad
                </a>

            </div>

        @endif

    </div>

</div>

@endsection
