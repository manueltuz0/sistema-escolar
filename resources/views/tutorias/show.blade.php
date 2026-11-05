@extends('layouts.app')

@section('content')

<style>
    .detalle-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
    }

    .detalle-header {
        background: white;
        border-radius: 14px;
        padding: 24px;
        margin-bottom: 22px;
        box-shadow: 0 3px 12px rgba(0,0,0,.06);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .detalle-header h1 {
        margin: 0 0 7px;
        font-size: 27px;
        color: #1f2937;
    }

    .detalle-header p {
        margin: 0;
        color: #6b7280;
    }

    .botones {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-block;
        padding: 11px 17px;
        border-radius: 8px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-regresar {
        background: #e5e7eb;
        color: #374151;
    }

    .btn-principal {
        background: #7B1E3A;
        color: white;
    }

    .btn-principal:hover {
        background: #5D142B;
        color: white;
    }

    .alerta {
        padding: 13px 16px;
        border-radius: 9px;
        margin-bottom: 18px;
    }

    .alerta-exito {
        background: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alerta-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
    }

    .grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .card {
        background: white;
        border-radius: 13px;
        padding: 23px;
        box-shadow: 0 3px 12px rgba(0,0,0,.06);
    }

    .card-completa {
        grid-column: 1 / -1;
    }

    .card h2 {
        margin: 0 0 18px;
        font-size: 20px;
        color: #7B1E3A;
    }

    .datos {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 13px;
    }

    .dato {
        background: #f8fafc;
        border-radius: 9px;
        padding: 13px;
        min-width: 0;
    }

    .dato small {
        display: block;
        color: #6b7280;
        margin-bottom: 5px;
        font-size: 12px;
    }

    .dato strong {
        font-size: 14px;
        color: #1f2937;
        overflow-wrap: anywhere;
    }

    .estado {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .estado-pendiente {
        background: #fef3c7;
        color: #92400e;
    }

    .estado-seguimiento {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .estado-concluida {
        background: #dcfce7;
        color: #166534;
    }

    .texto {
        background: #f8fafc;
        border-radius: 9px;
        padding: 15px;
        margin-bottom: 13px;
    }

    .texto:last-child {
        margin-bottom: 0;
    }

    .texto h3 {
        margin: 0 0 8px;
        font-size: 14px;
        color: #374151;
    }

    .texto p {
        margin: 0;
        line-height: 1.6;
        color: #1f2937;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    .sin-datos {
        color: #9ca3af;
        font-style: italic;
    }

    .seguimiento-item {
        border-left: 4px solid #7B1E3A;
        background: #f8fafc;
        padding: 17px;
        border-radius: 9px;
        margin-bottom: 14px;
    }

    .seguimiento-superior {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .seguimiento-superior strong {
        color: #1f2937;
    }

    .formulario {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .campo {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .campo-completo {
        grid-column: 1 / -1;
    }

    .campo label {
        font-size: 13px;
        font-weight: 600;
        color: #374151;
    }

    .campo input,
    .campo select,
    .campo textarea {
        width: 100%;
        padding: 11px 12px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-family: inherit;
        box-sizing: border-box;
    }

    .campo textarea {
        min-height: 90px;
        resize: vertical;
    }

    .errores {
        background: #fee2e2;
        color: #991b1b;
        padding: 13px 18px;
        border-radius: 9px;
        margin-bottom: 18px;
    }

    @media(max-width: 800px) {
        .grid {
            grid-template-columns: 1fr;
        }

        .card-completa {
            grid-column: auto;
        }

        .detalle-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .datos,
        .formulario {
            grid-template-columns: 1fr;
        }

        .campo-completo {
            grid-column: auto;
        }
    }
</style>

<div class="detalle-container">

    {{-- ENCABEZADO --}}
    <div class="detalle-header">
        <div>
            <h1>Detalle de atención individual</h1>
            <p>Información y seguimiento de la atención del alumno.</p>
        </div>

        <div class="botones">
            <a href="{{ route('tutorias.index') }}" class="btn btn-regresar">
                ← Regresar
            </a>
        </div>
    </div>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alerta alerta-exito">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alerta alerta-error">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="errores">
            <strong>Revisa los siguientes datos:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid">

        {{-- DATOS DEL ALUMNO --}}
        <div class="card">
            <h2>Alumno</h2>

            <div class="datos">
                <div class="dato">
                    <small>Nombre completo</small>
                    <strong>
                        {{ $tutoria->alumno->nombres ?? 'No disponible' }}
                        {{ $tutoria->alumno->apellidos ?? '' }}
                    </strong>
                </div>

                <div class="dato">
                    <small>Matrícula</small>
                    <strong>
                        {{ $tutoria->alumno->matricula ?? 'Sin matrícula' }}
                    </strong>
                </div>

                <div class="dato">
                    <small>Grupo</small>
                    <strong>
                        {{ $tutoria->alumno->grupo->nombre ?? 'Sin grupo' }}
                    </strong>
                </div>

                <div class="dato">
                    <small>Fecha de atención</small>
                    <strong>
                        {{ $tutoria->fecha->format('d/m/Y') }}
                    </strong>
                </div>
            </div>
        </div>

        {{-- INFORMACIÓN DE LA ATENCIÓN --}}
        <div class="card">
            <h2>Información de la atención</h2>

            <div class="datos">
                <div class="dato">
                    <small>Categoría</small>
                    <strong>{{ $tutoria->tipo }}</strong>
                </div>

                <div class="dato">
                    <small>Estado</small>

                    @if($tutoria->estado === 'Pendiente')
                        <span class="estado estado-pendiente">Pendiente</span>
                    @elseif($tutoria->estado === 'En seguimiento')
                        <span class="estado estado-seguimiento">En seguimiento</span>
                    @else
                        <span class="estado estado-concluida">Concluida</span>
                    @endif
                </div>

                <div class="dato">
                    <small>Docente responsable</small>
                    <strong>
                        @if($tutoria->docente)
                            {{ $tutoria->docente->nombres }}
                            {{ $tutoria->docente->apellidos }}
                        @else
                            Sin asignar
                        @endif
                    </strong>
                </div>

                <div class="dato">
                    <small>Próxima fecha de seguimiento</small>
                    <strong>
                        {{ $tutoria->fecha_seguimiento
                            ? $tutoria->fecha_seguimiento->format('d/m/Y')
                            : 'No definida' }}
                    </strong>
                </div>

                <div class="dato">
                    <small>Registro creado</small>
                    <strong>
                        {{ $tutoria->created_at->format('d/m/Y H:i') }}
                    </strong>
                </div>
            </div>
        </div>

        {{-- MOTIVO Y SITUACIÓN --}}
        <div class="card card-completa">
            <h2>Motivo y situación presentada</h2>

            <div class="texto">
                <h3>Motivo de atención</h3>
                <p>{{ $tutoria->motivo }}</p>
            </div>

            <div class="texto">
                <h3>Situación compartida por el alumno</h3>
                <p>
                    {{ $tutoria->situacion ?: 'No se registró información.' }}
                </p>
            </div>
        </div>

        {{-- ACUERDOS Y COMPROMISOS --}}
        <div class="card">
            <h2>Acuerdos</h2>

            <div class="texto">
                <p>
                    {{ $tutoria->acuerdos ?: 'No se registraron acuerdos.' }}
                </p>
            </div>
        </div>

        <div class="card">
            <h2>Compromisos</h2>

            <div class="texto">
                <h3>Compromiso del alumno</h3>
                <p>
                    {{ $tutoria->compromisos_alumno ?: 'No registrado.' }}
                </p>
            </div>

            <div class="texto">
                <h3>Compromiso del tutor</h3>
                <p>
                    {{ $tutoria->compromisos_tutor ?: 'No registrado.' }}
                </p>
            </div>
        </div>

        {{-- OBSERVACIONES --}}
        <div class="card card-completa">
            <h2>Observaciones</h2>

            <div class="texto">
                <p>
                    {{ $tutoria->observaciones ?: 'No se registraron observaciones.' }}
                </p>
            </div>
        </div>

        {{-- HISTORIAL DE SEGUIMIENTOS --}}
        <div class="card card-completa">
            <h2>Historial de seguimientos</h2>

            @forelse($tutoria->seguimientos as $seguimiento)

                <div class="seguimiento-item">

                    <div class="seguimiento-superior">
                        <strong>
                            Seguimiento programado:
                            {{ $seguimiento->fecha_programada->format('d/m/Y') }}
                        </strong>

                        @if($seguimiento->estado === 'Pendiente')
                            <span class="estado estado-pendiente">Pendiente</span>
                        @elseif($seguimiento->estado === 'Realizado')
                            <span class="estado estado-concluida">Realizado</span>
                        @else
                            <span class="estado estado-seguimiento">Cancelado</span>
                        @endif
                    </div>

                    <div class="texto">
                        <h3>Fecha realizada</h3>
                        <p>
                            {{ $seguimiento->fecha_realizada
                                ? $seguimiento->fecha_realizada->format('d/m/Y')
                                : 'Todavía no realizado' }}
                        </p>
                    </div>

                    <div class="texto">
                        <h3>Resultado</h3>
                        <p>
                            {{ $seguimiento->resultado ?: 'Sin resultado registrado.' }}
                        </p>
                    </div>

                    <div class="texto">
                        <h3>Acuerdos</h3>
                        <p>
                            {{ $seguimiento->acuerdos ?: 'Sin acuerdos registrados.' }}
                        </p>
                    </div>

                    @if($seguimiento->observaciones)
                        <div class="texto">
                            <h3>Observaciones</h3>
                            <p>{{ $seguimiento->observaciones }}</p>
                        </div>
                    @endif

                </div>

            @empty

                <p class="sin-datos">
                    Todavía no hay seguimientos registrados para esta atención.
                </p>

            @endforelse
        </div>

        {{-- REGISTRAR NUEVO SEGUIMIENTO --}}
        <div class="card card-completa">
            <h2>Registrar nuevo seguimiento</h2>

            <form
                action="{{ route('tutorias.seguimientos.store', $tutoria) }}"
                method="POST"
            >
                @csrf

                <div class="formulario">

                    <div class="campo">
                        <label for="fecha_programada">Fecha programada *</label>
                        <input
                            type="date"
                            id="fecha_programada"
                            name="fecha_programada"
                            value="{{ old('fecha_programada') }}"
                            required
                        >
                    </div>

                    <div class="campo">
                        <label for="fecha_realizada">Fecha realizada</label>
                        <input
                            type="date"
                            id="fecha_realizada"
                            name="fecha_realizada"
                            value="{{ old('fecha_realizada') }}"
                        >
                    </div>

                    <div class="campo">
                        <label for="estado">Estado *</label>
                        <select id="estado" name="estado" required>
                            <option value="Pendiente"
                                {{ old('estado', 'Pendiente') === 'Pendiente' ? 'selected' : '' }}>
                                Pendiente
                            </option>
                            <option value="Realizado"
                                {{ old('estado') === 'Realizado' ? 'selected' : '' }}>
                                Realizado
                            </option>
                            <option value="Cancelado"
                                {{ old('estado') === 'Cancelado' ? 'selected' : '' }}>
                                Cancelado
                            </option>
                        </select>
                    </div>

                    <div class="campo campo-completo">
                        <label for="resultado">Resultado del seguimiento</label>
                        <textarea
                            id="resultado"
                            name="resultado"
                            placeholder="Describe el resultado de la reunión..."
                        >{{ old('resultado') }}</textarea>
                    </div>

                    <div class="campo campo-completo">
                        <label for="acuerdos">Nuevos acuerdos</label>
                        <textarea
                            id="acuerdos"
                            name="acuerdos"
                            placeholder="Registra los acuerdos establecidos..."
                        >{{ old('acuerdos') }}</textarea>
                    </div>

                    <div class="campo campo-completo">
                        <label for="observaciones">Observaciones</label>
                        <textarea
                            id="observaciones"
                            name="observaciones"
                            placeholder="Observaciones adicionales..."
                        >{{ old('observaciones') }}</textarea>
                    </div>

                    <div class="campo campo-completo">
                        <button type="submit" class="btn btn-principal">
                            Guardar seguimiento
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </div>
</div>

@endsection
