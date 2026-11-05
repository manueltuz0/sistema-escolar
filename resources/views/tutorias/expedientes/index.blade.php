 @extends('layouts.app')

@section('content')

<style>
    .expedientes-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 28px 20px;
    }

    .expedientes-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 24px;
    }

    .expedientes-title {
        font-size: 25px;
        font-weight: 800;
        color: #252525;
        margin: 0;
    }

    .expedientes-subtitle {
        color: #777;
        font-size: 13px;
        margin-top: 5px;
    }

    .btn-volver {
        background: #7B1E3A;
        color: white;
        padding: 10px 17px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
        transition: .2s;
        white-space: nowrap;
    }

    .btn-volver:hover {
        background: #5D142B;
        color: white;
    }

    .buscador-card {
        background: white;
        padding: 22px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
        margin-bottom: 20px;
    }

    .buscador-label {
        display: block;
        font-size: 14px;
        font-weight: 700;
        color: #333;
        margin-bottom: 10px;
    }

    .buscador-form {
        display: flex;
        gap: 10px;
    }

    .buscador-input {
        flex: 1;
        min-width: 0;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 13px 15px;
        font-size: 14px;
        outline: none;
        transition: .2s;
    }

    .buscador-input:focus {
        border-color: #7B1E3A;
        box-shadow: 0 0 0 3px rgba(123,30,58,.10);
    }

    .btn-buscar {
        background: #7B1E3A;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0 24px;
        font-weight: 700;
        cursor: pointer;
        transition: .2s;
    }

    .btn-buscar:hover {
        background: #5D142B;
    }

    .btn-limpiar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: #eeeeee;
        color: #555;
        padding: 0 18px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .resultados-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
        overflow: hidden;
    }

    .resultados-header {
        padding: 18px 22px;
        border-bottom: 1px solid #eeeeee;
    }

    .resultados-header h2 {
        font-size: 16px;
        font-weight: 800;
        color: #333;
        margin: 0;
    }

    .resultados-header p {
        color: #888;
        font-size: 12px;
        margin-top: 5px;
    }

    .alumno-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 17px 22px;
        border-bottom: 1px solid #eeeeee;
        transition: background .2s;
    }

    .alumno-item:hover {
        background: #fcf8f9;
    }

    .alumno-nombre {
        font-size: 14px;
        font-weight: 800;
        color: #333;
        margin: 0 0 6px;
    }

    .alumno-dato {
        color: #777;
        font-size: 12px;
        margin: 3px 0;
    }

    .btn-expediente {
        background: #7B1E3A;
        color: white;
        text-decoration: none;
        padding: 9px 16px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        transition: .2s;
    }

    .btn-expediente:hover {
        background: #5D142B;
        color: white;
    }

    .estado-vacio {
        padding: 45px 20px;
        text-align: center;
    }

    .estado-icono {
        font-size: 35px;
        margin-bottom: 12px;
    }

    .estado-titulo {
        color: #444;
        font-size: 15px;
        font-weight: 800;
    }

    .estado-descripcion {
        color: #888;
        font-size: 13px;
        margin-top: 7px;
    }

    .contador-resultados {
        color: #777;
        font-size: 12px;
        padding: 12px 22px;
        background: #fafafa;
    }

    @media(max-width: 600px) {
        .expedientes-container {
            padding: 20px 12px;
        }

        .expedientes-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .buscador-form {
            flex-direction: column;
        }

        .buscador-input,
        .btn-buscar,
        .btn-limpiar {
            width: 100%;
            min-height: 43px;
        }

        .alumno-item {
            align-items: flex-start;
            flex-direction: column;
        }

        .btn-expediente {
            width: 100%;
            text-align: center;
        }
    }
</style>

<div class="min-h-screen bg-gray-100">

    <div class="expedientes-container">

        {{-- ENCABEZADO --}}
        <div class="expedientes-header">

            <div>
                <h1 class="expedientes-title">
                    Expedientes de alumnos
                </h1>

                <p class="expedientes-subtitle">
                    Consulta el historial de tutorías de cada alumno.
                </p>
            </div>

            <a href="{{ route('tutorias.index') }}" class="btn-volver">
                ← Volver a Tutorías
            </a>

        </div>

        {{-- BUSCADOR --}}
        <div class="buscador-card">

            <form action="{{ route('tutorias.expedientes.index') }}"
                  method="GET"
                  class="buscador-form">

                <input
                    type="text"
                    name="buscar"
                    value="{{ $buscar }}"
                    class="buscador-input"
                    placeholder="Buscar por matrícula, nombre o apellido..."
                    autocomplete="off"
                    autofocus
                >

                <button type="submit" class="btn-buscar">
                    Buscar
                </button>

                @if($buscar)
                    <a href="{{ route('tutorias.expedientes.index') }}"
                       class="btn-limpiar">
                        Limpiar
                    </a>
                @endif

            </form>

        </div>

        {{-- RESULTADOS --}}
        <div class="resultados-card">

            <div class="resultados-header">
                <h2>Resultados de búsqueda</h2>

                <p>
                    Escribe al menos 2 caracteres para localizar un alumno.
                </p>
            </div>

            @if(strlen($buscar) < 2)

                <div class="estado-vacio">

                    <div class="estado-icono">🔎</div>

                    <div class="estado-titulo">
                        Buscar expediente de alumno
                    </div>

                    <p class="estado-descripcion">
                        Ingresa la matrícula, nombre o apellido del alumno.
                    </p>

                </div>

            @elseif($alumnos->isEmpty())

                <div class="estado-vacio">

                    <div class="estado-icono">📋</div>

                    <div class="estado-titulo">
                        No se encontraron alumnos
                    </div>

                    <p class="estado-descripcion">
                        Verifica los datos e intenta con otra búsqueda.
                    </p>

                </div>

            @else

                <div class="contador-resultados">
                    Se encontraron {{ $alumnos->count() }} coincidencias.
                </div>

                @foreach($alumnos as $alumno)

                    <div class="alumno-item">

                        <div>

                            <h3 class="alumno-nombre">
                                {{ $alumno->nombres }}
                                {{ $alumno->apellidos }}
                            </h3>

                            <p class="alumno-dato">
                                Matrícula:
                                {{ $alumno->matricula ?? $alumno->idmatricula ?? 'Sin matrícula' }}
                            </p>

                            <p class="alumno-dato">
                                Grupo:
                                {{ $alumno->grupo
                                    ? $alumno->grupo->grado . ' ' . $alumno->grupo->nombre
                                    : 'Sin grupo' }}
                            </p>

                        </div>

                        <a href="{{ route('tutorias.expedientes.show', $alumno) }}"
                           class="btn-expediente">
                            Ver expediente →
                        </a>

                    </div>

                @endforeach

                @if($alumnos->count() === 10)

                    <div class="contador-resultados">
                        Se muestran las primeras 10 coincidencias.
                        Escribe más caracteres para precisar la búsqueda.
                    </div>

                @endif

            @endif

        </div>

    </div>

</div>

@endsection