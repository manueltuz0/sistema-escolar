@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header text-white py-3" style="background: #7B1E3A;">
            <h4 class="mb-0">
                <i class="fas fa-edit me-2"></i>
                Editar atención individual
            </h4>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('tutorias.update', $tutoria) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    {{-- ALUMNO --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Alumno *</label>

                        <select name="alumno_id" class="form-select" required>
                            <option value="">Seleccionar alumno</option>

                            @foreach($alumnos as $alumno)
                                <option value="{{ $alumno->id }}"
                                    {{ old('alumno_id', $tutoria->alumno_id) == $alumno->id ? 'selected' : '' }}>
                                    {{ $alumno->apellidos }}, {{ $alumno->nombres }}
                                    — {{ $alumno->matricula ?? 'Sin matrícula' }}

                                    @if($alumno->grupo)
                                        ({{ $alumno->grupo->grado }}.{{ $alumno->grupo->nombre }})
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        @error('alumno_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- DOCENTE --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Docente responsable</label>

                        <select name="docente_id" class="form-select">
                            <option value="">Sin asignar</option>

                            @foreach($docentes as $docente)
                                <option value="{{ $docente->id }}"
                                    {{ old('docente_id', $tutoria->docente_id) == $docente->id ? 'selected' : '' }}>
                                    {{ $docente->nombres }} {{ $docente->apellidos }}
                                </option>
                            @endforeach
                        </select>

                        @error('docente_id')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- FECHA --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Fecha de atención *</label>

                        <input
                            type="date"
                            name="fecha"
                            class="form-control"
                            value="{{ old('fecha', $tutoria->fecha?->format('Y-m-d')) }}"
                            required
                        >

                        @error('fecha')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- CATEGORÍA --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Categoría *</label>

                        @php
                            $categorias = [
                                'Académica',
                                'Inasistencias',
                                'Familiar',
                                'Emocional',
                                'Convivencia',
                                'Orientación personal',
                                'Prevención de adicciones',
                                'Seguimiento',
                                'Otra'
                            ];

                            $tipoActual = old('tipo', $tutoria->tipo);
                        @endphp

                        <select name="tipo" class="form-select" required>
                            <option value="">Seleccionar categoría</option>

                            @if($tipoActual && !in_array($tipoActual, $categorias))
                                <option value="{{ $tipoActual }}" selected>
                                    {{ $tipoActual }}
                                </option>
                            @endif

                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria }}"
                                    {{ $tipoActual == $categoria ? 'selected' : '' }}>
                                    {{ $categoria }}
                                </option>
                            @endforeach
                        </select>

                        @error('tipo')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ESTADO --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Estado *</label>

                        <select name="estado" class="form-select" required>
                            @foreach(['Pendiente', 'En seguimiento', 'Concluida'] as $estado)
                                <option value="{{ $estado }}"
                                    {{ old('estado', $tutoria->estado) == $estado ? 'selected' : '' }}>
                                    {{ $estado }}
                                </option>
                            @endforeach
                        </select>

                        @error('estado')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- MOTIVO --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">Motivo de la atención *</label>

                        <input
                            type="text"
                            name="motivo"
                            class="form-control"
                            value="{{ old('motivo', $tutoria->motivo) }}"
                            maxlength="255"
                            required
                        >

                        @error('motivo')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- SITUACIÓN --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Situación expresada por el alumno
                        </label>

                        <textarea name="situacion" class="form-control" rows="3">{{ old('situacion', $tutoria->situacion) }}</textarea>

                        @error('situacion')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- ACUERDOS --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Acuerdos y acciones realizadas
                        </label>

                        <textarea name="acuerdos" class="form-control" rows="3">{{ old('acuerdos', $tutoria->acuerdos) }}</textarea>

                        @error('acuerdos')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- COMPROMISOS --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Compromisos del alumno
                        </label>

                        <textarea name="compromisos_alumno" class="form-control" rows="3">{{ old('compromisos_alumno', $tutoria->compromisos_alumno) }}</textarea>

                        @error('compromisos_alumno')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Compromisos del tutor
                        </label>

                        <textarea name="compromisos_tutor" class="form-control" rows="3">{{ old('compromisos_tutor', $tutoria->compromisos_tutor) }}</textarea>

                        @error('compromisos_tutor')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- FECHA DE SEGUIMIENTO --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Fecha del próximo seguimiento
                        </label>

                        <input
                            type="date"
                            name="fecha_seguimiento"
                            class="form-control"
                            value="{{ old('fecha_seguimiento', $tutoria->fecha_seguimiento?->format('Y-m-d')) }}"
                        >

                        @error('fecha_seguimiento')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- OBSERVACIONES --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Observaciones adicionales
                        </label>

                        <textarea name="observaciones" class="form-control" rows="3">{{ old('observaciones', $tutoria->observaciones) }}</textarea>

                        @error('observaciones')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <hr class="my-4">

                {{-- BOTONES --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('tutorias.show', $tutoria) }}"
                       class="btn btn-outline-secondary">
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn text-white"
                        style="background: #7B1E3A;"
                    >
                        <i class="fas fa-save me-1"></i>
                        Guardar cambios
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
