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
                    Editar préstamo
                </h2>

                <p style="
                    margin-top: 4px;
                    color: #6b7280;
                    font-size: 14px;
                ">
                    Actualiza los datos del préstamo o registra la devolución del equipo.
                </p>
            </div>

            <a
                href="{{ route('prestamos_equipos.show', $prestamoEquipo) }}"
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


            {{-- ERRORES --}}
            @if ($errors->any())

                <div style="
                    background: #fee2e2;
                    border: 1px solid #fca5a5;
                    color: #991b1b;
                    padding: 16px 20px;
                    border-radius: 10px;
                    margin-bottom: 20px;
                ">

                    <strong>
                        Revisa los siguientes datos:
                    </strong>

                    <ul style="margin: 10px 0 0 20px;">

                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <form
                action="{{ route('prestamos_equipos.update', $prestamoEquipo) }}"
                method="POST"
            >

                @csrf
                @method('PUT')


                {{-- INFORMACIÓN DEL EQUIPO --}}
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
                        1. Equipo tecnológico
                    </h3>


                    <div style="
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                        gap: 18px;
                    ">


                        <div>

                            <label
                                for="equipo_id"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Equipo *
                            </label>

                            <select
                                name="equipo_id"
                                id="equipo_id"
                                required
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                @foreach($equipos as $equipo)

                                    <option
                                        value="{{ $equipo->id }}"
                                        {{ old('equipo_id', $prestamoEquipo->equipo_id) == $equipo->id ? 'selected' : '' }}
                                    >
                                        {{ $equipo->codigo }}
                                        —
                                        {{ $equipo->tipo }}

                                        @if($equipo->marca)
                                            — {{ $equipo->marca }}
                                        @endif

                                        @if($equipo->modelo)
                                            {{ $equipo->modelo }}
                                        @endif
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div>

                            <label
                                for="condicion_entrega"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Condición de entrega
                            </label>

                            <select
                                name="condicion_entrega"
                                id="condicion_entrega"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar condición
                                </option>

                                <option value="Bueno"
                                    {{ old('condicion_entrega', $prestamoEquipo->condicion_entrega) === 'Bueno' ? 'selected' : '' }}>
                                    Bueno
                                </option>

                                <option value="Regular"
                                    {{ old('condicion_entrega', $prestamoEquipo->condicion_entrega) === 'Regular' ? 'selected' : '' }}>
                                    Regular
                                </option>

                                <option value="Con detalles"
                                    {{ old('condicion_entrega', $prestamoEquipo->condicion_entrega) === 'Con detalles' ? 'selected' : '' }}>
                                    Con detalles
                                </option>

                            </select>

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
                        2. Datos del solicitante
                    </h3>


                    <div style="
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                        gap: 18px;
                    ">


                        <div>

                            <label
                                for="docente_id"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Docente
                            </label>

                            <select
                                name="docente_id"
                                id="docente_id"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar docente
                                </option>

                                @foreach($docentes as $docente)

                                    <option
                                        value="{{ $docente->id }}"
                                        {{ old('docente_id', $prestamoEquipo->docente_id) == $docente->id ? 'selected' : '' }}
                                    >
                                        {{ $docente->apellidos }},
                                        {{ $docente->nombres }}

                                        @if($docente->numero_empleado)
                                            — {{ $docente->numero_empleado }}
                                        @endif
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div>

                            <label
                                for="alumno_id"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Alumno
                            </label>

                            <select
                                name="alumno_id"
                                id="alumno_id"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar alumno
                                </option>

                                @foreach($alumnos as $alumno)

                                    <option
                                        value="{{ $alumno->id }}"
                                        {{ old('alumno_id', $prestamoEquipo->alumno_id) == $alumno->id ? 'selected' : '' }}
                                    >

                                        {{ $alumno->apellidos }},
                                        {{ $alumno->nombres }}

                                        @if($alumno->matricula)
                                            — {{ $alumno->matricula }}
                                        @endif

                                        @if($alumno->grupo)
                                            — {{ $alumno->grupo->grado }}°{{ strtoupper($alumno->grupo->nombre) }}
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                        </div>

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
                        3. Información académica
                    </h3>


                    <div style="
                        display: grid;
                        grid-template-columns: 2fr 1fr;
                        gap: 18px;
                    ">


                        <div>

                            <label
                                for="materia_id"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Asignatura
                            </label>

                            <select
                                name="materia_id"
                                id="materia_id"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar asignatura
                                </option>

                                @foreach($materias as $materia)

                                    <option
                                        value="{{ $materia->id }}"
                                        {{ old('materia_id', $prestamoEquipo->materia_id) == $materia->id ? 'selected' : '' }}
                                    >

                                        @if($materia->clave)
                                            {{ $materia->clave }} —
                                        @endif

                                        {{ $materia->nombre }}

                                        @if($materia->semestre)
                                            — Semestre {{ $materia->semestre }}
                                        @endif

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div>

                            <label
                                for="semestre"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Semestre
                            </label>

                            <select
                                name="semestre"
                                id="semestre"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar
                                </option>

                                @for($i = 1; $i <= 12; $i++)

                                    <option
                                        value="{{ $i }}"
                                        {{ old('semestre', $prestamoEquipo->semestre) == $i ? 'selected' : '' }}
                                    >
                                        {{ $i }}°
                                    </option>

                                @endfor

                            </select>

                        </div>

                    </div>

                </div>


                {{-- FECHA Y HORA --}}
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
                        4. Préstamo
                    </h3>


                    <div style="
                        display: grid;
                        grid-template-columns: 1fr 1fr;
                        gap: 18px;
                    ">


                        <div>

                            <label
                                for="fecha_prestamo"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Fecha *
                            </label>

                            <input
                                type="date"
                                name="fecha_prestamo"
                                id="fecha_prestamo"
                                value="{{ old('fecha_prestamo', $prestamoEquipo->fecha_prestamo?->format('Y-m-d')) }}"
                                required
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                "
                            >

                        </div>


                        <div>

                            <label
                                for="hora_prestamo"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Hora *
                            </label>

                            <input
                                type="time"
                                name="hora_prestamo"
                                id="hora_prestamo"
                                value="{{ old('hora_prestamo', $prestamoEquipo->hora_prestamo) }}"
                                required
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                "
                            >

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
                    border-left: 5px solid #16a34a;
                ">

                    <h3 style="
                        margin: 0 0 8px;
                        font-size: 19px;
                        font-weight: 700;
                        color: #111827;
                    ">
                        5. Devolución del equipo
                    </h3>

                    <p style="
                        margin: 0 0 20px;
                        color: #6b7280;
                        font-size: 13px;
                    ">
                        Completa estos datos cuando el equipo sea devuelto.
                    </p>


                    <div style="
                        display: grid;
                        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
                        gap: 18px;
                    ">


                        {{-- ESTADO --}}
                        <div>

                            <label
                                for="estado"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Estado del préstamo *
                            </label>

                            <select
                                name="estado"
                                id="estado"
                                required
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option
                                    value="Prestado"
                                    {{ old('estado', $prestamoEquipo->estado) === 'Prestado' ? 'selected' : '' }}
                                >
                                    Prestado
                                </option>

                                <option
                                    value="Devuelto"
                                    {{ old('estado', $prestamoEquipo->estado) === 'Devuelto' ? 'selected' : '' }}
                                >
                                    Devuelto
                                </option>

                                <option
                                    value="Atrasado"
                                    {{ old('estado', $prestamoEquipo->estado) === 'Atrasado' ? 'selected' : '' }}
                                >
                                    Atrasado
                                </option>

                            </select>

                        </div>


                        {{-- FECHA DEVOLUCIÓN --}}
                        <div>

                            <label
                                for="fecha_devolucion"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Fecha de devolución
                            </label>

                            <input
                                type="date"
                                name="fecha_devolucion"
                                id="fecha_devolucion"
                                value="{{ old('fecha_devolucion', $prestamoEquipo->fecha_devolucion?->format('Y-m-d')) }}"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                "
                            >

                        </div>


                        {{-- HORA DEVOLUCIÓN --}}
                        <div>

                            <label
                                for="hora_devolucion"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Hora de devolución
                            </label>

                            <input
                                type="time"
                                name="hora_devolucion"
                                id="hora_devolucion"
                                value="{{ old('hora_devolucion', $prestamoEquipo->hora_devolucion) }}"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                "
                            >

                        </div>


                        {{-- CONDICIÓN DEVOLUCIÓN --}}
                        <div>

                            <label
                                for="condicion_devolucion"
                                style="
                                    display: block;
                                    margin-bottom: 7px;
                                    font-weight: 600;
                                    color: #374151;
                                "
                            >
                                Condición de devolución
                            </label>

                            <select
                                name="condicion_devolucion"
                                id="condicion_devolucion"
                                style="
                                    width: 100%;
                                    padding: 11px 12px;
                                    border: 1px solid #d1d5db;
                                    border-radius: 8px;
                                    background: white;
                                "
                            >

                                <option value="">
                                    Seleccionar condición
                                </option>

                                <option
                                    value="Bueno"
                                    {{ old('condicion_devolucion', $prestamoEquipo->condicion_devolucion) === 'Bueno' ? 'selected' : '' }}
                                >
                                    Bueno
                                </option>

                                <option
                                    value="Regular"
                                    {{ old('condicion_devolucion', $prestamoEquipo->condicion_devolucion) === 'Regular' ? 'selected' : '' }}
                                >
                                    Regular
                                </option>

                                <option
                                    value="Con detalles"
                                    {{ old('condicion_devolucion', $prestamoEquipo->condicion_devolucion) === 'Con detalles' ? 'selected' : '' }}
                                >
                                    Con detalles
                                </option>

                                <option
                                    value="Dañado"
                                    {{ old('condicion_devolucion', $prestamoEquipo->condicion_devolucion) === 'Dañado' ? 'selected' : '' }}
                                >
                                    Dañado
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- RESPONSABLE RECEPCIÓN --}}
                    <div style="margin-top: 18px;">

                        <label
                            for="responsable_recepcion"
                            style="
                                display: block;
                                margin-bottom: 7px;
                                font-weight: 600;
                                color: #374151;
                            "
                        >
                            Responsable de recepción
                        </label>

                        <input
                            type="text"
                            name="responsable_recepcion"
                            id="responsable_recepcion"
                            value="{{ old('responsable_recepcion', $prestamoEquipo->responsable_recepcion) }}"
                            maxlength="150"
                            placeholder="Nombre de la persona que recibe el equipo"
                            style="
                                width: 100%;
                                padding: 11px 12px;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                            "
                        >

                    </div>

                </div>


                {{-- RESPONSABLE DE ENTREGA Y OBSERVACIONES --}}
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
                        6. Observaciones
                    </h3>


                    <div style="margin-bottom: 18px;">

                        <label
                            for="responsable_entrega"
                            style="
                                display: block;
                                margin-bottom: 7px;
                                font-weight: 600;
                                color: #374151;
                            "
                        >
                            Responsable de entrega
                        </label>

                        <input
                            type="text"
                            name="responsable_entrega"
                            id="responsable_entrega"
                            value="{{ old('responsable_entrega', $prestamoEquipo->responsable_entrega) }}"
                            maxlength="150"
                            style="
                                width: 100%;
                                padding: 11px 12px;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                            "
                        >

                    </div>


                    <div>

                        <label
                            for="observaciones"
                            style="
                                display: block;
                                margin-bottom: 7px;
                                font-weight: 600;
                                color: #374151;
                            "
                        >
                            Observaciones
                        </label>

                        <textarea
                            name="observaciones"
                            id="observaciones"
                            rows="4"
                            placeholder="Escribe alguna observación..."
                            style="
                                width: 100%;
                                padding: 11px 12px;
                                border: 1px solid #d1d5db;
                                border-radius: 8px;
                                resize: vertical;
                            "
                        >{{ old('observaciones', $prestamoEquipo->observaciones) }}</textarea>

                    </div>

                </div>


                {{-- BOTONES --}}
                <div style="
                    background: white;
                    border-radius: 12px;
                    padding: 20px 25px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
                    display: flex;
                    justify-content: flex-end;
                    gap: 10px;
                    flex-wrap: wrap;
                ">

                    <a
                        href="{{ route('prestamos_equipos.show', $prestamoEquipo) }}"
                        style="
                            padding: 11px 20px;
                            background: #6b7280;
                            color: white;
                            text-decoration: none;
                            border-radius: 8px;
                            font-weight: 600;
                        "
                    >
                        Cancelar
                    </a>


                    <button
                        type="submit"
                        style="
                            padding: 11px 24px;
                            background: #2563eb;
                            color: white;
                            border: none;
                            border-radius: 8px;
                            font-weight: 700;
                            cursor: pointer;
                        "
                    >
                        Guardar cambios
                    </button>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>