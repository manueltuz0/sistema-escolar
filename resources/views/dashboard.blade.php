
<x-app-layout>
    <style>
        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px 20px;
            color: #35111d;
        }

        .dashboard-header {
            background: linear-gradient(135deg, #5b1729, #8b2942);
            color: #fff;
            border-radius: 18px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(91, 23, 41, 0.18);
        }

        .dashboard-header h1 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 8px;
            line-height: 1.3;
        }

        .dashboard-header p {
            margin: 0;
            opacity: 0.92;
            font-size: 16px;
        }

        .welcome {
            margin-top: 20px;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.14);
            border: 1px solid rgba(255, 255, 255, 0.20);
            border-radius: 12px;
        }

        .section-title {
            font-size: 22px;
            font-weight: 700;
            color: #35111d;
            margin-bottom: 18px;
        }

        .modules-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
            align-items: stretch;
        }

        .module-card {
            display: flex;
            flex-direction: column;
            min-width: 0;
            background: #fff;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 5px 18px rgba(40, 20, 25, 0.08);
            border: 1px solid #eadde1;
            text-decoration: none;
            color: inherit;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(91, 23, 41, 0.14);
        }

        .module-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 10px;
            background: #f5e5ea;
            color: #751f35;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .module-card h3 {
            font-size: 17px;
            font-weight: 700;
            color: #35111d;
            line-height: 1.4;
            margin: 0 0 10px;
        }

        .module-status {
            display: inline-block;
            align-self: flex-start;
            margin-bottom: 14px;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-ready,
        .status-available {
            background: #e1f5e8;
            color: #17643a;
        }

        .status-development {
            background: #fff0c2;
            color: #875313;
        }

        .module-card p {
            color: #6b6266;
            font-size: 14px;
            line-height: 1.55;
            flex-grow: 1;
            margin: 0 0 18px;
        }

        .module-button {
            display: block;
            width: 100%;
            box-sizing: border-box;
            text-align: center;
            padding: 11px 15px;
            border-radius: 9px;
            background: #751f35;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            border: none;
            margin-top: auto;
            transition: background 0.2s;
        }

        .module-button:hover {
            background: #591527;
            color: #fff;
        }

        .module-button.disabled {
            background: #a6a0a2;
            color: #fff;
            cursor: not-allowed;
        }

        .module-card:focus-visible,
        .module-button:focus-visible {
            outline: 3px solid #c78b9b;
            outline-offset: 3px;
        }

        @media (max-width: 1100px) {
            .modules-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 640px) {
            .dashboard-container {
                padding: 20px 14px;
            }

            .dashboard-header {
                padding: 22px;
            }

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
        <header class="dashboard-header">
            <h1>Sistema Integral de Gestión Escolar</h1>
            <p>COBAY Plantel Chichimilá</p>

            <div class="welcome">
                Bienvenido(a),
                <strong>{{ Auth::user()->name }}</strong>
            </div>
        </header>

        {{-- MÓDULOS --}}
        <section>
            <h2 class="section-title">Módulos del Sistema</h2>

            <div class="modules-grid">

                {{-- 1. HORARIOS --}}
                <div class="module-card">
                    <div class="module-number">1</div>
                    <h3>Horarios y Asignación de Materias</h3>
                    <span class="module-status status-ready">Disponible</span>
                    <p>Organiza materias, docentes, grupos, aulas, días y horarios.</p>
                    <a href="{{ route('horarios.index') }}" class="module-button">
                        Administrar horarios
                    </a>
                </div>

                {{-- 2. ALUMNOS --}}
                <div class="module-card">
                    <div class="module-number">2</div>
                    <h3>Gestión de Alumnos</h3>
                    <span class="module-status status-ready">Disponible</span>
                    <p>Registra y administra la información de los alumnos y sus grupos.</p>
                    <a href="{{ route('alumnos.index') }}" class="module-button">
                        Administrar alumnos
                    </a>
                </div>

                {{-- 3. DOCENTES --}}
                <div class="module-card">
                    <div class="module-number">3</div>
                    <h3>Gestión de Docentes</h3>
                    <span class="module-status status-ready">Disponible</span>
                    <p>Registra y administra los datos de los docentes del plantel.</p>
                    <a href="{{ route('docentes.index') }}" class="module-button">
                        Administrar docentes
                    </a>
                </div>

                {{-- 4. CALIFICACIONES --}}
                <a href="{{ route('calificaciones.index') }}" class="module-card">
                    <div class="module-number">4</div>
                    <h3>Captura de Calificaciones y Boletas</h3>
                    <span class="module-status status-ready">Disponible</span>
                    <p>Permite capturar calificaciones de los alumnos, consultar parciales y generar boletas.</p>
                    <span class="module-button">Entrar</span>
                </a>

                {{-- 5. CENTROS DE CÓMPUTO --}}
                <div class="module-card">
                    <div class="module-number">5</div>
                    <h3>Recuperacion Y Ordinario</h3>
                    <span class="module-status status-development">En desarrollo</span>
                    <p>Controlará la la recuperacion y ordinario de sgunta oprtunidades.</p>
                    <span class="module-button disabled">Próximamente</span>
                </div>

                {{-- 6. INCIDENCIAS Y TUTORÍAS --}}
                <a href="{{ route('incidencias.index') }}" class="module-card">
                    <div class="module-number">6</div>
                    <h3>Incidencias y Citatorios</h3>
                    <span class="module-status status-ready">Disponible</span>
                    <p>Permite registrar incidencias, citatorios, observaciones y seguimiento de los alumnos.</p>
                    <span class="module-button">Entrar</span>
                </a>

                {{-- 7. GRUPOS --}}
                <div class="module-card">
                    <div class="module-number">7</div>
                    <h3>Gestión de Grupos</h3>
                    <span class="module-status status-ready">Disponible</span>
                    <p>Permite administrar los grupos escolares, consultar sus alumnos y organizar la información por grado y ciclo escolar.</p>
                    <a href="{{ route('grupos.index') }}" class="module-button">
                        Administrar grupos
                    </a>
                </div>

                {{-- 8. USUARIOS --}}
                <div class="module-card">
                    <div class="module-number">8</div>
                    <h3>Control de Usuarios por Roles</h3>
                    <span class="module-status status-development">En desarrollo</span>
                    <p>Administrará usuarios, roles y permisos del sistema.</p>
                    <span class="module-button disabled">Próximamente</span>
                </div>

                {{-- 9. EVENTOS --}}
                <div class="module-card">
                    <div class="module-number">9</div>
                    <h3>Eventos y Actividades Escolares</h3>
                    <span class="module-status status-development">En desarrollo</span>
                    <p>Permitirá organizar eventos, actividades, fechas y participantes.</p>
                    <span class="module-button disabled">Próximamente</span>
                </div>

                {{-- 10. EQUIPO TECNOLÓGICO --}}
<div class="module-card">
    <div class="module-number">10</div>

    <h3>Préstamo de Equipo Tecnológico</h3>

    <span class="module-status status-ready">Disponible</span>

    <p>
        Control de préstamos, devoluciones, inventario y reservaciones
        de equipo tecnológico.
    </p>

    <a href="{{ route('prestamos_equipos.index') }}"
       class="module-button">
        Entrar al módulo
    </a>
</div>

        
                {{-- 11. TUTORÍAS --}}
<a href="{{ route('tutorias.index') }}" class="module-card">
    <div class="module-number">11</div>
    <h3>Tutorías</h3>
    <span class="module-status status-ready">Disponible</span>
    <p>Permite registrar actividades grupales, atenciones individuales y dar seguimiento a los alumnos.</p>
    <span class="module-button">Entrar</span>
</a>

            </div>
        </section>
    </div>
</x-app-layout>
