@extends('layouts.app')

@section('content')

<style>
    .equipo-form-page {
        max-width: 1050px;
        width: calc(100% - 32px);
        margin: 0 auto;
        padding: 30px 0 45px;
    }

    .equipo-form-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .07);
        border: 1px solid #e5e7eb;
    }

    .equipo-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px 24px;
    }

    .equipo-form-group label {
        display: block;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .equipo-form-group input,
    .equipo-form-group select,
    .equipo-form-group textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 14px;
        color: #374151;
        background: #fff;
        outline: none;
        transition: border-color .2s, box-shadow .2s;
    }

    .equipo-form-group input,
    .equipo-form-group select {
        min-height: 45px;
    }

    .equipo-form-group textarea {
        min-height: 115px;
        resize: vertical;
    }

    .equipo-form-group input:focus,
    .equipo-form-group select:focus,
    .equipo-form-group textarea:focus {
        border-color: #7B1E3A;
        box-shadow: 0 0 0 3px rgba(123, 30, 58, .10);
    }

    .equipo-form-group input::placeholder,
    .equipo-form-group textarea::placeholder {
        color: #9ca3af;
    }

    .equipo-form-help {
        display: block;
        margin-top: 6px;
        color: #9ca3af;
        font-size: 11px;
    }

    .equipo-form-full {
        grid-column: 1 / -1;
    }

    @media (max-width: 650px) {
        .equipo-form-grid {
            grid-template-columns: 1fr;
            gap: 17px;
        }

        .equipo-form-full {
            grid-column: auto;
        }

        .equipo-form-page {
            width: calc(100% - 20px);
            padding-top: 20px;
        }
    }
</style>

<div class="equipo-form-page">

    {{-- ENCABEZADO --}}
    <div style="margin-bottom: 22px;">

        <a href="{{ route('equipos_tecnologicos.index') }}"
           style="color:#7B1E3A; font-size:13px; font-weight:600; text-decoration:none;">
            ← Volver al inventario
        </a>

        <h1 style="font-size:25px; font-weight:700; color:#1f2937; margin-top:16px;">
            Registrar equipo tecnológico
        </h1>

        <p style="font-size:14px; color:#6b7280; margin-top:5px;">
            Ingresa los datos del equipo que se agregará al inventario.
        </p>

    </div>

    {{-- ERRORES --}}
    @if($errors->any())
        <div style="background:#fee2e2; color:#991b1b; border:1px solid #fecaca; border-radius:9px; padding:14px 18px; margin-bottom:18px; font-size:13px;">

            <strong>Revisa los siguientes campos:</strong>

            <ul style="list-style:disc; padding-left:22px; margin-top:8px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>
    @endif

    {{-- FORMULARIO --}}
    <form action="{{ route('equipos_tecnologicos.store') }}"
          method="POST"
          class="equipo-form-card">

        @csrf

        {{-- ENCABEZADO DEL FORMULARIO --}}
        <div style="background:#7B1E3A; color:white; padding:19px 25px;">

            <h2 style="font-size:17px; font-weight:700;">
                Información del equipo
            </h2>

            <p style="font-size:12px; color:rgba(255,255,255,.85); margin-top:4px;">
                Los campos marcados con * son obligatorios.
            </p>

        </div>

        {{-- CAMPOS --}}
        <div style="padding:26px 28px;">

            <div class="equipo-form-grid">

                {{-- CÓDIGO --}}
                <div class="equipo-form-group">

                    <label>Código del equipo *</label>

                    <input
                        type="text"
                        name="codigo"
                        value="{{ old('codigo') }}"
                        maxlength="30"
                        placeholder="Ej. LAP-001"
                        required
                    >

                    <span class="equipo-form-help">
                        Código único para identificar el equipo.
                    </span>

                </div>

                {{-- TIPO --}}
                <div class="equipo-form-group">

                    <label>Tipo de equipo *</label>

                    <select name="tipo" required>

                        <option value="">Selecciona el tipo</option>

                        @foreach(['Laptop', 'Proyector', 'Computadora', 'Tablet', 'Bocina', 'Otro'] as $tipo)
                            <option value="{{ $tipo }}" @selected(old('tipo') == $tipo)>
                                {{ $tipo }}
                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- MARCA --}}
                <div class="equipo-form-group">

                    <label>Marca</label>

                    <input
                        type="text"
                        name="marca"
                        value="{{ old('marca') }}"
                        maxlength="100"
                        placeholder="Ej. HP, Dell, Epson..."
                    >

                </div>

                {{-- MODELO --}}
                <div class="equipo-form-group">

                    <label>Modelo</label>

                    <input
                        type="text"
                        name="modelo"
                        value="{{ old('modelo') }}"
                        maxlength="100"
                        placeholder="Modelo del equipo"
                    >

                </div>

                {{-- NÚMERO DE SERIE --}}
                <div class="equipo-form-group">

                    <label>Número de serie</label>

                    <input
                        type="text"
                        name="numero_serie"
                        value="{{ old('numero_serie') }}"
                        maxlength="100"
                        placeholder="Número de serie del fabricante"
                    >

                </div>

                {{-- ESTADO --}}
                <div class="equipo-form-group">

                    <label>Estado *</label>

                    <select name="estado" required>

                        @foreach(['Disponible', 'Prestado', 'Mantenimiento', 'Baja'] as $estado)
                            <option value="{{ $estado }}"
                                @selected(old('estado', 'Disponible') == $estado)>
                                {{ $estado }}
                            </option>
                        @endforeach

                    </select>

                </div>

                {{-- UBICACIÓN --}}
                <div class="equipo-form-group equipo-form-full">

                    <label>Ubicación</label>

                    <input
                        type="text"
                        name="ubicacion"
                        value="{{ old('ubicacion') }}"
                        maxlength="100"
                        placeholder="Ej. Dirección, laboratorio, sala de maestros..."
                    >

                </div>

                {{-- OBSERVACIONES --}}
                <div class="equipo-form-group equipo-form-full">

                    <label>Observaciones</label>

                    <textarea
                        name="observaciones"
                        rows="4"
                        placeholder="Describe las características o condiciones del equipo..."
                    >{{ old('observaciones') }}</textarea>

                </div>

            </div>

        </div>

        {{-- BOTONES --}}
        <div style="
            background:#f9fafb;
            border-top:1px solid #e5e7eb;
            padding:17px 25px;
            display:flex;
            justify-content:flex-end;
            align-items:center;
            gap:12px;
            flex-wrap:wrap;
        ">

            <a href="{{ route('equipos_tecnologicos.index') }}"
               style="
                   display:inline-block;
                   padding:11px 22px;
                   border:1px solid #d1d5db;
                   border-radius:8px;
                   color:#374151;
                   font-size:13px;
                   font-weight:600;
                   text-decoration:none;
                   background:white;
               ">
                Cancelar
            </a>

            <button type="submit"
                    style="
                        padding:11px 24px;
                        border:0;
                        border-radius:8px;
                        color:white;
                        background:#7B1E3A;
                        font-size:13px;
                        font-weight:700;
                        cursor:pointer;
                        box-shadow:0 2px 5px rgba(0,0,0,.12);
                    ">
                Guardar equipo
            </button>

        </div>

    </form>

</div>

@endsection
