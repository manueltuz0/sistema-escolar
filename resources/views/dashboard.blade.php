<x-app-layout>

    <style>

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            color: white;
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.10);
        }

        .dashboard-header h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .dashboard-header p {
            margin: 0;
            opacity: 0.9;
            font-size: 16px;
        }

        .welcome {
            margin-top: 20px;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 18px;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
        }

        .module-card {
            background: white;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12);
        }

        .module-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #dbeafe;
            color: #1d4ed8;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .module-card h3 {
            font-size: 18px;
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .module-card p {
            color: #6b7280;
            font-size: 14px;
            line-height: 1.5;
            min-height: 65px;
        }

        .module-status {
            display: inline-block;
            margin-bottom: 15px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-ready {
            background: #dcfce7;
            color: #166534;
        }

        .status-development {
            background: #fef3c7;
            color: #92400e;
        }

        .module-button {
            display: inline-block;
            width: 100%;
            text-align: center;
            padding: 10px 15px;
            border-radius: 9px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }

        .module-button:hover {
            background: #1d4ed8;
        }

        .module-button.disabled {
            background: #9ca3af;
            cursor: not-allowed;
        }
        

        @media (max-width: 640px) {

            .dashboard-header h1 {
                font-size: 24px;
            }

            .modules-grid {
                grid-template-columns: 1fr;
            }

        }

    </style>


    <div class="dashboard-container">


        {{-- ENCABEZADO --}}

        <div class="dashboard-header">

            <h1>
                Sistema Integral de Gestión Escolar
            </h1>

            <p>
                COBAY Plantel Chichimilá
            </p>

            <div class="welcome">

                Bienvenido(a),

                <strong>
                    {{ Auth::user()->name }}
                </strong>

            </div>

        </div>


        {{-- MÓDULOS --}}

        <div>

            <div class="section-title">
                Módulos del Sistema
            </div>


            <div class="modules-grid">


                {{-- 1. HORARIOS --}}

                <div class="module-card">

                    <div class="module-number">
                        1
                    </div>

                    <h3>
                        Horarios y Asignación de Materias
                    </h3>

                    <span class="module-status status-ready">
                        Disponible
                    </span>

                    <p>
                        Organiza materias, docentes, grupos,
                        aulas, días y horarios.
                    </p>

                    <a href="{{ route('horarios.index') }}"
                       class="module-button">

                        Administrar horarios

                    </a>

                </div>


                {{-- 2. ALUMNOS --}}

                <div class="module-card">

                    <div class="module-number">
                        2
                    </div>

                    <h3>
                        Gestión de Alumnos
                    </h3>

                    <span class="module-status status-ready">
                        Disponible
                    </span>

                    <p>
                        Registra y administra la información
                        de los alumnos y sus grupos.
                    </p>

                    <a href="{{ route('alumnos.index') }}"
                       class="module-button">

                        Administrar alumnos

                    </a>

                </div>


                {{-- 3. DOCENTES --}}

                <div class="module-card">

                    <div class="module-number">
                        3
                    </div>

                    <h3>
                        Gestión de Docentes
                    </h3>

                    <span class="module-status status-ready">
                        Disponible
                    </span>

                    <p>
                        Registra y administra los datos
                        de los docentes del plantel.
                    </p>

                    <a href="{{ route('docentes.index') }}"
                       class="module-button">

                        Administrar docentes

                    </a>

                </div>


                {{-- 4. CALIFICACIONES --}}

<a href="{{ route('calificaciones.index') }}"
   class="module-card"
   style="text-decoration: none; color: inherit; cursor: pointer;">

    <div class="module-number">
        4
    </div>

    <h3>
        Captura de Calificaciones y Boletas
    </h3>

    <span class="module-status status-available">
        Disponible
    </span>

    <p>
        Permite capturar calificaciones de los alumnos,
        consultar parciales y generar boletas.
    </p>

    <span class="module-button">
        Entrar
    </span>

</a>

                {{-- 5. CENTROS DE CÓMPUTO --}}

                <div class="module-card">

                    <div class="module-number">
                        5
                    </div>

                    <h3>
                        Préstamos de Centros de Cómputo
                    </h3>

                    <span class="module-status status-development">
                        En desarrollo
                    </span>

                    <p>
                        Controlará la solicitud y préstamo
                        de los centros de cómputo.
                    </p>

                    <span class="module-button disabled">
                        Próximamente
                    </span>

                </div>


                {{-- 6. INCIDENCIAS --}}

<a href="{{ route('incidencias.index') }}"
   class="module-card"
   style="text-decoration: none; color: inherit; cursor: pointer;">

    <div class="module-number">
        6
    </div>

    <h3>
        Incidencias y Tutorías
    </h3>

    <span class="module-status status-development">
        Disponible
    </span>

    <p>
        Permite registrar incidencias,
        tutorías, observaciones y seguimiento
        de los alumnos.
    </p>

    <span class="module-button">
        Entrar
    </span>

</a>


                {{-- 7. GESTION DE GRUPO --}}

                {{-- ===================================================== --}}
{{-- 7. GESTIÓN DE GRUPOS --}}
{{-- ===================================================== --}}

{{-- ===================================================== --}}
{{-- 7. GESTIÓN DE GRUPOS --}}
{{-- ===================================================== --}}

<div class="module-card">

    <div class="module-number">
        7
    </div>

    <h3>
        Gestión de Grupos
    </h3>

    <span class="status available">
        Disponible
    </span>

    <p>
        Permite administrar los grupos escolares,
        consultar sus alumnos y organizar la información
        por grado y ciclo escolar.
    </p>

    <a
        href="{{ route('grupos.index') }}"
        style="
            display: inline-block;
            width: 100%;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            margin-top: 10px;
        "
    >
        Administrar grupos
    </a>

</div>


                {{-- 8. USUARIOS --}}

                <div class="module-card">

                    <div class="module-number">
                        8
                    </div>

                    <h3>
                        Control de Usuarios por Roles
                    </h3>

                    <span class="module-status status-development">
                        En desarrollo
                    </span>

                    <p>
                        Administrará usuarios, roles y permisos
                        del sistema.
                    </p>

                    <span class="module-button disabled">
                        Próximamente
                    </span>

                </div>


                {{-- 9. EVENTOS --}}

                <div class="module-card">

                    <div class="module-number">
                        9
                    </div>

                    <h3>
                        Eventos y Actividades Escolares
                    </h3>

                    <span class="module-status status-development">
                        En desarrollo
                    </span>

                    <p>
                        Permitirá organizar eventos,
                        actividades, fechas y participantes.
                    </p>

                    <span class="module-button disabled">
                        Próximamente
                    </span>

                </div>


                {{-- 10. EQUIPO TECNOLÓGICO --}}

                <div class="module-card">

                    <div class="module-number">
                        10
                    </div>

                    <h3>
                        Préstamo de Equipo Tecnológico
                    </h3>

                    <span class="module-status status-development">
                        En desarrollo
                    </span>

                    <p>
                        Controlará préstamos y devoluciones
                        de equipo tecnológico.
                    </p>

                    <span class="module-button disabled">
                        Próximamente
                    </span>

                </div>


            </div>

        </div>


    </div>

</x-app-layout>