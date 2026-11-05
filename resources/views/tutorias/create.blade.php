@extends('layouts.app')

@section('content')

<style>
    .tutoria-container {
        max-width: 1100px;
        margin: 30px auto;
        padding: 0 20px;
        color: #35111d;
    }

    .tutoria-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 15px;
    }

    .tutoria-header h1 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
        color: #5d142b;
    }

    .btn-regresar {
        text-decoration: none;
        background: #7b1e3a;
        color: white;
        padding: 10px 18px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-regresar:hover {
        background: #5d142b;
        color: white;
    }

    .card {
        background: white;
        border-radius: 14px;
        padding: 25px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0,0,0,.07);
        border: 1px solid #eadde1;
    }

    .card h2 {
        margin-top: 0;
        color: #5d142b;
        font-size: 20px;
        font-weight: 700;
    }

    .card-subtitle {
        color: #6b7280;
        margin-bottom: 20px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        min-width: 0;
        position: relative;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-group label {
        margin-bottom: 7px;
        font-weight: 600;
        color: #5d142b;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 13px;
        border: 1px solid #d1c4c9;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        color: #35111d;
    }

    .form-group textarea {
        min-height: 100px;
        resize: vertical;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #7b1e3a;
        box-shadow: 0 0 0 2px rgba(123,30,58,.12);
    }

    /* BUSCADOR DE ALUMNOS */
    .buscador-alumnos {
        position: relative;
    }

    .resultados-alumnos {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #d8cbd0;
        border-radius: 8px;
        max-height: 280px;
        overflow-y: auto;
        z-index: 1000;
        box-shadow: 0 7px 18px rgba(0,0,0,.12);
    }

    .resultado-alumno {
        display: block;
        width: 100%;
        padding: 12px 14px;
        text-align: left;
        background: white;
        border: none;
        border-bottom: 1px solid #eee5e9;
        cursor: pointer;
        color: #35111d;
    }

    .resultado-alumno:hover,
    .resultado-alumno:focus {
        background: #f8eef1;
        outline: none;
    }

    .resultado-alumno strong {
        display: block;
        color: #5d142b;
        font-size: 14px;
    }

    .resultado-alumno small {
        display: block;
        color: #75636a;
        margin-top: 5px;
    }

    .sin-resultados {
        padding: 15px;
        color: #766b70;
        text-align: center;
    }

    .alumno-seleccionado {
        display: none;
        margin-top: 12px;
        padding: 14px;
        background: #f8eef1;
        border: 1px solid #eadde1;
        border-left: 5px solid #7b1e3a;
        border-radius: 8px;
    }

    .alumno-seleccionado strong {
        display: block;
        color: #5d142b;
        margin-bottom: 5px;
    }

    .alumno-seleccionado span {
        display: block;
        color: #604650;
        font-size: 13px;
        margin-top: 3px;
    }

    .quitar-alumno {
        display: none;
        margin-top: 8px;
        padding: 6px 10px;
        background: transparent;
        border: 1px solid #7b1e3a;
        border-radius: 6px;
        color: #7b1e3a;
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
    }

    .quitar-alumno:hover {
        background: #7b1e3a;
        color: white;
    }

    .acciones {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
    }

    .btn-cancelar {
        text-decoration: none;
        background: #eee5e9;
        color: #5d142b;
        padding: 11px 20px;
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-guardar {
        border: none;
        background: #7b1e3a;
        color: white;
        padding: 11px 22px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-guardar:hover {
        background: #5d142b;
    }

    .alerta {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #065f46;
        padding: 14px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .error {
        color: #dc2626;
        font-size: 13px;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .descripcion,
        .form-group.full {
            grid-column: auto;
        }

        .tutoria-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .acciones {
            flex-direction: column;
        }

        .acciones a,
        .acciones button {
            text-align: center;
        }
    }
</style>

<div class="tutoria-container">

    {{-- ENCABEZADO --}}
    <div class="tutoria-header">
        <div>
            <h1>Registrar atención individual</h1>
            <p style="color:#6b7280; margin-top:6px;">
                Seguimiento y atención individual del alumno.
            </p>
        </div>

        <a href="{{ route('tutorias.index') }}" class="btn-regresar">
            ← Regresar
        </a>
    </div>

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="alerta">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERRORES --}}
    @if($errors->any())
        <div style="background:#fef2f2; border:1px solid #fecaca; color:#991b1b; padding:15px; border-radius:8px; margin-bottom:20px;">
            <strong>Hay algunos errores:</strong>
            <ul style="margin-bottom:0;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO DE ATENCIÓN INDIVIDUAL --}}
    <form action="{{ route('tutorias.store') }}" method="POST">
        @csrf

        <div class="card">

            <h2>Información de la atención</h2>

            <p class="card-subtitle">
                Datos generales del alumno y del responsable de la tutoría.
            </p>

            <div class="form-grid">

                {{-- BUSCADOR DE ALUMNOS --}}
                <div class="form-group buscador-alumnos">

                    <label for="buscar_alumno">Alumno *</label>

                    <input
                        type="text"
                        id="buscar_alumno"
                        autocomplete="off"
                        placeholder="Escribe nombre, apellido o matrícula..."
                        value=""
                        required
                    >

                    <input
                        type="hidden"
                        name="alumno_id"
                        id="alumno_id"
                        value="{{ old('alumno_id', '') }}"
                        required
                    >

                    <div id="resultados_alumnos" class="resultados-alumnos"></div>

                    <div id="alumno_seleccionado" class="alumno-seleccionado"></div>

                    <button
                        type="button"
                        id="quitar_alumno"
                        class="quitar-alumno">
                        Cambiar alumno
                    </button>

                    @error('alumno_id')
                        <span class="error">{{ $message }}</span>
                    @enderror

                </div>

                {{-- FECHA --}}
                <div class="form-group">
                    <label for="fecha">Fecha de tutoría *</label>

                    <input
                        type="date"
                        name="fecha"
                        id="fecha"
                        value="{{ old('fecha', date('Y-m-d')) }}"
                        required
                    >

                    @error('fecha')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- DOCENTE --}}
                <div class="form-group">
                    <label for="docente_id">Docente responsable</label>

                    <select name="docente_id" id="docente_id">
                        <option value="">Seleccionar docente</option>

                        @foreach($docentes as $docente)
                            <option
                                value="{{ $docente->id }}"
                                {{ old('docente_id') == $docente->id ? 'selected' : '' }}>
                                {{ $docente->nombres }} {{ $docente->apellidos }}
                            </option>
                        @endforeach
                    </select>

                    @error('docente_id')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- TIPO --}}
                <div class="form-group">
                    <label for="tipo">Categoría de atención *</label>

                    <select name="tipo" id="tipo" required>
                        <option value="">Seleccionar categoría</option>

                        @foreach([
                            'Individual',
                            'Seguimiento',
                            'Conductual',
                            'Académica',
                            'Orientación',
                            'Familiar'
                        ] as $tipo)
                            <option
                                value="{{ $tipo }}"
                                {{ old('tipo') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>

                    @error('tipo')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- MOTIVO --}}
                <div class="form-group">
                    <label for="motivo">Motivo de la tutoría *</label>

                    <input
                        type="text"
                        name="motivo"
                        id="motivo"
                        value="{{ old('motivo') }}"
                        placeholder="¿Por qué se realiza la atención?"
                        required
                    >

                    @error('motivo')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- SITUACIÓN --}}
                <div class="form-group full">
                    <label for="situacion">Situación encontrada</label>

                    <textarea
                        name="situacion"
                        id="situacion"
                        placeholder="Describe la situación compartida por el alumno...">{{ old('situacion') }}</textarea>

                    @error('situacion')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ACUERDOS --}}
                <div class="form-group full">
                    <label for="acuerdos">Acuerdos establecidos</label>

                    <textarea
                        name="acuerdos"
                        id="acuerdos"
                        placeholder="Escribe los acuerdos establecidos...">{{ old('acuerdos') }}</textarea>

                    @error('acuerdos')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- COMPROMISOS DEL ALUMNO --}}
                <div class="form-group">
                    <label for="compromisos_alumno">Compromisos del alumno</label>

                    <textarea
                        name="compromisos_alumno"
                        id="compromisos_alumno"
                        placeholder="Compromisos que asumirá el alumno...">{{ old('compromisos_alumno') }}</textarea>

                    @error('compromisos_alumno')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- COMPROMISOS DEL TUTOR --}}
                <div class="form-group">
                    <label for="compromisos_tutor">Compromisos del tutor</label>

                    <textarea
                        name="compromisos_tutor"
                        id="compromisos_tutor"
                        placeholder="Compromisos que asumirá el tutor...">{{ old('compromisos_tutor') }}</textarea>

                    @error('compromisos_tutor')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- FECHA DE SEGUIMIENTO --}}
                <div class="form-group">
                    <label for="fecha_seguimiento">Próxima fecha de seguimiento</label>

                    <input
                        type="date"
                        name="fecha_seguimiento"
                        id="fecha_seguimiento"
                        value="{{ old('fecha_seguimiento') }}"
                    >

                    @error('fecha_seguimiento')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- ESTADO --}}
                <div class="form-group">
                    <label for="estado">Estado de la tutoría *</label>

                    <select name="estado" id="estado" required>
                        <option value="Pendiente"
                            {{ old('estado', 'Pendiente') == 'Pendiente' ? 'selected' : '' }}>
                            Pendiente
                        </option>

                        <option value="En seguimiento"
                            {{ old('estado') == 'En seguimiento' ? 'selected' : '' }}>
                            En seguimiento
                        </option>

                        <option value="Concluida"
                            {{ old('estado') == 'Concluida' ? 'selected' : '' }}>
                            Concluida
                        </option>
                    </select>

                    @error('estado')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- OBSERVACIONES --}}
                <div class="form-group full">
                    <label for="observaciones">Observaciones</label>

                    <textarea
                        name="observaciones"
                        id="observaciones"
                        placeholder="Observaciones adicionales...">{{ old('observaciones') }}</textarea>

                    @error('observaciones')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>

            </div>

            {{-- BOTONES --}}
            <div class="acciones">
                <a href="{{ route('tutorias.index') }}" class="btn-cancelar">
                    Cancelar
                </a>

                <button type="submit" class="btn-guardar">
                    Guardar tutoría
                </button>
            </div>

        </div>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

  const alumnos = {{ Illuminate\Support\Js::from(
    $alumnos->map(function ($alumno) {
        return [
            'id' => $alumno->id,
            'nombre' => $alumno->nombres,
            'apellidos' => $alumno->apellidos,
            'matricula' => $alumno->matricula ?? 'Sin matrícula',
            'grupo' => $alumno->grupo
                ? $alumno->grupo->grado . '.' . $alumno->grupo->nombre
                : 'Sin grupo',
        ];
    })->values()
) }};

    const buscador = document.getElementById('buscar_alumno');
    const campoId = document.getElementById('alumno_id');
    const resultados = document.getElementById('resultados_alumnos');
    const seleccionado = document.getElementById('alumno_seleccionado');
    const botonQuitar = document.getElementById('quitar_alumno');

    const alumnoInicialId = campoId.value;

    function mostrarAlumno(alumno) {
        buscador.value = alumno.apellidos + ', ' + alumno.nombre;
        campoId.value = alumno.id;

        seleccionado.replaceChildren();

        const nombre = document.createElement('strong');
        nombre.textContent = alumno.nombre + ' ' + alumno.apellidos;

        const matricula = document.createElement('span');
        matricula.textContent = 'Matrícula: ' + alumno.matricula;

        const grupo = document.createElement('span');
        grupo.textContent = 'Grado y grupo: ' + alumno.grupo;

        seleccionado.append(nombre, matricula, grupo);

        seleccionado.style.display = 'block';
        resultados.style.display = 'none';
        botonQuitar.style.display = 'inline-block';
    }

    function limpiarAlumno() {
        buscador.value = '';
        campoId.value = '';
        seleccionado.style.display = 'none';
        seleccionado.replaceChildren();
        resultados.style.display = 'none';
        botonQuitar.style.display = 'none';
        buscador.focus();
    }

    function crearResultado(alumno) {
        const boton = document.createElement('button');
        boton.type = 'button';
        boton.className = 'resultado-alumno';

        const nombre = document.createElement('strong');
        nombre.textContent = alumno.apellidos + ', ' + alumno.nombre;

        const detalles = document.createElement('small');
        detalles.textContent =
            'Matrícula: ' + alumno.matricula +
            ' | Grupo: ' + alumno.grupo;

        boton.append(nombre, detalles);

        boton.addEventListener('click', function () {
            mostrarAlumno(alumno);
        });

        return boton;
    }

    buscador.addEventListener('input', function () {

        const texto = this.value.toLowerCase().trim();

        campoId.value = '';
        seleccionado.style.display = 'none';
        botonQuitar.style.display = 'none';
        resultados.replaceChildren();

        if (texto.length < 1) {
            resultados.style.display = 'none';
            return;
        }

        const coincidencias = alumnos.filter(function (alumno) {
            const datos = [
                alumno.nombre,
                alumno.apellidos,
                alumno.matricula,
                alumno.grupo
            ].join(' ').toLowerCase();

            return datos.includes(texto);
        }).slice(0, 30);

        if (coincidencias.length === 0) {
            const mensaje = document.createElement('div');
            mensaje.className = 'sin-resultados';
            mensaje.textContent = 'No se encontraron alumnos.';
            resultados.appendChild(mensaje);
        } else {
            coincidencias.forEach(function (alumno) {
                resultados.appendChild(crearResultado(alumno));
            });
        }

        resultados.style.display = 'block';
    });

    botonQuitar.addEventListener('click', limpiarAlumno);

    document.addEventListener('click', function (evento) {
        if (
            !buscador.contains(evento.target) &&
            !resultados.contains(evento.target)
        ) {
            resultados.style.display = 'none';
        }
    });

    // Recuperar el alumno si el formulario vuelve con errores.
    if (alumnoInicialId) {
        const alumnoInicial = alumnos.find(function (alumno) {
            return String(alumno.id) === String(alumnoInicialId);
        });

        if (alumnoInicial) {
            mostrarAlumno(alumnoInicial);
        }
    }

    // Impedir el envío si no se seleccionó un resultado válido.
    buscador.addEventListener('change', function () {
        if (!campoId.value) {
            seleccionado.style.display = 'none';
        }
    });

    document.querySelector('form[action="{{ route('tutorias.store') }}"]')
        .addEventListener('submit', function (evento) {
            if (!campoId.value) {
                evento.preventDefault();
                buscador.setCustomValidity('Selecciona un alumno de la lista.');
                buscador.reportValidity();
                buscador.focus();
            } else {
                buscador.setCustomValidity('');
            }
        });

});
</script>

@endsection
