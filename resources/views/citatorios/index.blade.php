<x-app-layout>
    <style>
        .citatorios-page {
            --vino: #7B1E3A;
            --vino-oscuro: #5D142B;
            --texto: #33262B;
            --suave: #786A70;
            --borde: #E7D9DE;
            color: var(--texto);
            max-width: 1200px;
            margin: 0 auto;
            padding: 32px 20px 48px;
        }
        .citatorios-header, .citatorios-card {
            background: #fff;
            border: 1px solid var(--borde);
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(65, 25, 42, .05);
        }
        .citatorios-header {
            display:flex; align-items:center; justify-content:space-between;
            gap:20px; padding:26px 30px; margin-bottom:22px;
            background:linear-gradient(110deg,#fff 0%,#fbf5f7 100%);
        }
        .citatorios-header h1 { font-size:28px; font-weight:750; margin:0 0 5px; }
        .citatorios-header p { color:var(--suave); margin:0; }
        .btn-vino {
            display:inline-flex; align-items:center; justify-content:center;
            gap:8px; background:var(--vino); color:#fff; text-decoration:none;
            border:0; border-radius:10px; padding:11px 17px; font-weight:650;
            cursor:pointer;
        }
        .btn-vino:hover { background:var(--vino-oscuro); }
        .btn-light {
            display:inline-flex; align-items:center; justify-content:center;
            padding:8px 12px; border:1px solid var(--borde); border-radius:9px;
            color:var(--vino); background:#fff; text-decoration:none; font-weight:600;
        }
        .citatorios-card { padding:22px; }
        .alert-success {
            background:#edf8f0; border:1px solid #ccebd4; color:#216338;
            border-radius:10px; padding:12px 15px; margin-bottom:18px;
        }
        .search-row { display:flex; gap:10px; margin-bottom:18px; }
        .search-row input {
            width:100%; min-width:0; border:1px solid var(--borde);
            border-radius:10px; padding:11px 13px; outline:none;
        }
        .search-row input:focus { border-color:var(--vino); box-shadow:0 0 0 3px #7b1e3a18; }
        .table-wrap { overflow-x:auto; }
        table { width:100%; border-collapse:collapse; min-width:850px; }
        th { text-align:left; background:#fbf6f8; color:var(--vino-oscuro); font-size:13px; }
        th, td { padding:13px 12px; border-bottom:1px solid #f0e7eb; vertical-align:middle; }
        td { font-size:14px; }
        .estado {
            display:inline-block; border-radius:20px; padding:5px 10px;
            font-size:12px; font-weight:700; background:#fff4dc; color:#875d09;
        }
        .estado.atendido { background:#eaf7ee; color:#216338; }
        .estado.cancelado { background:#fceced; color:#9b2933; }
        .acciones { display:flex; gap:7px; align-items:center; flex-wrap:wrap; }
        .acciones form { margin:0; }
        .btn-delete {
            border:1px solid #f0cfd2; color:#a12b35; background:#fff;
            border-radius:9px; padding:8px 11px; cursor:pointer; font-weight:600;
        }
        .empty { text-align:center; color:var(--suave); padding:35px 12px; }
        .pagination { margin-top:18px; }
        @media(max-width:700px) {
            .citatorios-header { align-items:flex-start; flex-direction:column; padding:22px; }
            .citatorios-header h1 { font-size:23px; }
            .citatorios-card { padding:14px; }
            .search-row { flex-direction:column; }
        }
    </style>

    <div class="citatorios-page">
        <div class="citatorios-header">
            <div>
                <h1>Citatorios</h1>
                <p>Consulta y administra los citatorios registrados.</p>
            </div>
            <a href="{{ route('incidencias.index') }}" class="btn-light">← Regresar a incidencias</a>
        </div>

        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="citatorios-card">
            <form action="{{ route('citatorios.index') }}" method="GET" class="search-row">
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                    placeholder="Buscar por alumno, matrícula, responsable o estado...">
                <button type="submit" class="btn-vino">Buscar</button>
                @if(request('buscar'))
                    <a href="{{ route('citatorios.index') }}" class="btn-light">Limpiar</a>
                @endif
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Matrícula</th>
                            <th>Semestre / grupo</th>
                            <th>Responsable</th>
                            <th>Fecha de cita</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($citatorios as $citatorio)
                            <tr>
                                <td>{{ $citatorio->alumno?->nombres }} {{ $citatorio->alumno?->apellidos }}</td>
                                <td>{{ $citatorio->alumno?->matricula ?? '—' }}</td>
                                <td>
                                    @if($citatorio->alumno?->grupo)
                                        {{ $citatorio->alumno->grupo->grado }}.º semestre ·
                                        {{ $citatorio->alumno->grupo->nombre }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td>{{ $citatorio->responsable_nombre }}</td>
                                <td>{{ $citatorio->fecha_cita?->format('d/m/Y') ?? '—' }}</td>
                                <td>{{ $citatorio->hora_cita ? \Illuminate\Support\Str::substr($citatorio->hora_cita, 0, 5) : '—' }}</td>
                                <td>
                                    <span class="estado {{ strtolower($citatorio->estado) }}">
                                        {{ $citatorio->estado }}
                                    </span>
                                </td>
                                <td>
                                    <div class="acciones">
                                        <a class="btn-light" href="{{ route('citatorios.show', $citatorio) }}">Ver</a>
                                        <a class="btn-light" href="{{ route('citatorios.edit', $citatorio) }}">Editar</a>
                                        <form action="{{ route('citatorios.destroy', $citatorio) }}" method="POST"
                                            onsubmit="return confirm('¿Seguro que deseas eliminar este citatorio?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty">Todavía no hay citatorios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                {{ $citatorios->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
