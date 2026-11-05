<?php

namespace App\Http\Controllers;

use App\Models\PrestamoEquipo;
use App\Models\EquipoTecnologico;
use App\Models\Docente;
use App\Models\Alumno;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PrestamoEquipoController extends Controller
{
    /**
     * Mostrar lista de préstamos y resumen del inventario.
     */
    public function index(Request $request)
    {
        // Consulta base del historial, con sus relaciones.
        $consulta = PrestamoEquipo::with([
            'equipo',
            'docente',
            'alumno',
            'materia'
        ]);

        // Buscar por código de equipo, nombre, apellido o matrícula.
        if ($request->filled('buscar')) {
            $buscar = trim($request->input('buscar'));

            $consulta->where(function ($query) use ($buscar) {
                $query->whereHas('equipo', function ($q) use ($buscar) {
                    $q->where('codigo', 'LIKE', "%{$buscar}%");
                });

                $query->orWhereHas('alumno', function ($q) use ($buscar) {
                    $q->where('nombres', 'LIKE', "%{$buscar}%")
                        ->orWhere('apellidos', 'LIKE', "%{$buscar}%")
                        ->orWhere('matricula', 'LIKE', "%{$buscar}%")
                        ->orWhereRaw(
                            "CONCAT(nombres, ' ', apellidos) LIKE ?",
                            ["%{$buscar}%"]
                        );
                });

                $query->orWhereHas('docente', function ($q) use ($buscar) {
                    $q->where('nombres', 'LIKE', "%{$buscar}%")
                        ->orWhere('apellidos', 'LIKE', "%{$buscar}%")
                        ->orWhereRaw(
                            "CONCAT(nombres, ' ', apellidos) LIKE ?",
                            ["%{$buscar}%"]
                        );
                });
            });
        }

        // Filtros de fecha.
        if ($request->filled('fecha_desde')) {
            $consulta->whereDate(
                'fecha_prestamo',
                '>=',
                $request->input('fecha_desde')
            );
        }

        if ($request->filled('fecha_hasta')) {
            $consulta->whereDate(
                'fecha_prestamo',
                '<=',
                $request->input('fecha_hasta')
            );
        }

        // Filtro de estado.
        if ($request->filled('estado')) {
            $consulta->where('estado', $request->input('estado'));
        }

        // Historial completo: solo se consulta al entrar a la vista historial.
        $prestamos = (clone $consulta)
            ->orderByDesc('fecha_prestamo')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Página principal: últimos cinco préstamos, sin aplicar filtros del historial.
        $prestamosRecientes = PrestamoEquipo::with([
            'equipo',
            'docente',
            'alumno',
            'materia'
        ])
            ->orderByDesc('fecha_prestamo')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        // Resumen del inventario.
        $totalEquipos = EquipoTecnologico::count();

        $disponibles = EquipoTecnologico::where(
            'estado',
            'Disponible'
        )->count();

        $prestados = EquipoTecnologico::where(
            'estado',
            'Prestado'
        )->count();

        $mantenimiento = EquipoTecnologico::where(
            'estado',
            'Mantenimiento'
        )->count();

        $bajas = EquipoTecnologico::where(
            'estado',
            'Baja'
        )->count();

        $totalPrestamos = PrestamoEquipo::count();

        return view('prestamos_equipos.index', compact(
            'prestamos',
            'prestamosRecientes',
            'totalEquipos',
            'disponibles',
            'prestados',
            'mantenimiento',
            'bajas',
            'totalPrestamos'
        ));
    }


    /**
     * Mostrar formulario para registrar un préstamo.
     */
    public function create()
    {
        $equipos = EquipoTecnologico::where('estado', 'Disponible')
            ->orderBy('codigo')
            ->get();

        $docentes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        // Ya no cargamos todos los alumnos.
        // Se consultarán mediante el buscador AJAX.

        $materias = Materia::orderBy('semestre')
            ->orderBy('nombre')
            ->get();

        return view(
            'prestamos_equipos.create',
            compact(
                'equipos',
                'docentes',
                'materias'
            )
        );
    }
   
  public function materiasPorDocente(int $id): \Illuminate\Http\JsonResponse
{
    $docente = Docente::with('asignacionesMaterias.materia')
        ->findOrFail($id);

    $materias = $docente->asignacionesMaterias
        ->pluck('materia')
        ->filter()
        ->unique('id')
        ->sortBy('semestre')
        ->values()
        ->map(function ($materia) {
            return [
                'id' => $materia->id,
                'nombre' => $materia->nombre,
                'semestre' => $materia->semestre,
            ];
        });

    return response()->json($materias);
}

    /**
     * Buscar alumnos por nombre, apellido o matrícula.
     * Devuelve máximo 10 resultados.
     */
    public function buscarAlumnos(Request $request)
{
    $consulta = Alumno::with('grupo');

    if ($request->filled('id')) {
        $consulta->where('id', $request->id);
    } else {
        $busqueda = trim($request->input('q', ''));

        if (mb_strlen($busqueda) < 2) {
            return response()->json([]);
        }

        $consulta->where(function ($query) use ($busqueda) {
            $query->where('nombres', 'LIKE', "%{$busqueda}%")
                ->orWhere('apellidos', 'LIKE', "%{$busqueda}%")
                ->orWhere('matricula', 'LIKE', "%{$busqueda}%")
                ->orWhereRaw(
                    "CONCAT(nombres, ' ', apellidos) LIKE ?",
                    ["%{$busqueda}%"]
                )
                ->orWhereRaw(
                    "CONCAT(apellidos, ' ', nombres) LIKE ?",
                    ["%{$busqueda}%"]
                );
        });
    }

    $alumnos = $consulta
        ->orderBy('apellidos')
        ->orderBy('nombres')
        ->limit(10)
        ->get();

    return response()->json($alumnos->map(function ($alumno) {
        $grupo = $alumno->grupo;

        $nombreGrupo = 'Sin grupo';

        if ($grupo) {
            $nombreGrupo = $grupo->getAttribute('grado')
                && $grupo->getAttribute('grupo')
                ? $grupo->getAttribute('grado') . '°' .
                    strtoupper($grupo->getAttribute('grupo'))
                : ($grupo->getAttribute('nombre') ?? 'Grupo asignado');
        }

        return [
            'id' => $alumno->id,
            'nombre_completo' => trim($alumno->nombres . ' ' . $alumno->apellidos),
            'matricula' => $alumno->matricula,
            'grupo' => $nombreGrupo,
        ];
    }));
}

    /**
     * Guardar un nuevo préstamo.
     */
   public function store(Request $request)
{
    // No permitir que se seleccione docente y alumno al mismo tiempo.
    if ($request->filled('docente_id') && $request->filled('alumno_id')) {
        return back()
            ->withInput()
            ->withErrors([
                'docente_id' => 'Debes seleccionar solamente un docente o un alumno, no ambos.',
            ]);
    }

    $datos = $request->validate([

        'equipo_id' => [
            'required',
            'exists:equipos_tecnologicos,id'
        ],

        'fecha_prestamo' => [
            'required',
            'date'
        ],

        'hora_prestamo' => [
            'required'
        ],

        'docente_id' => [
            'nullable',
            'required_without:alumno_id',
            'exists:docentes,id'
        ],

        'alumno_id' => [
            'nullable',
            'required_without:docente_id',
            'exists:alumnos,id'
        ],

        'materia_id' => [
            'nullable',
            'exists:materias,id'
        ],

        'semestre' => [
            'nullable',
            'integer',
            'min:1',
            'max:12'
        ],

        'condicion_entrega' => [
            'nullable',
            'string',
            'max:100'
        ],

        'responsable_entrega' => [
            'nullable',
            'string',
            'max:150'
        ],

        'observaciones' => [
            'nullable',
            'string'
        ],

    ]);

    $equipo = EquipoTecnologico::findOrFail(
        $datos['equipo_id']
    );

    if ($equipo->estado !== 'Disponible') {
        return back()
            ->withInput()
            ->with('error', 'El equipo seleccionado no está disponible.');
    }

    $datos['estado'] = 'Prestado';

    $prestamo = PrestamoEquipo::create($datos);

    $equipo->update([
        'estado' => 'Prestado'
    ]);

    return redirect()
        ->route('prestamos_equipos.index')
        ->with(
            'success',
            'El préstamo se registró correctamente.'
        );
}
    /**
     * Mostrar información de un préstamo.
     */
    public function show(PrestamoEquipo $prestamoEquipo)
    {
        $prestamoEquipo->load([
            'equipo',
            'docente',
            'alumno.grupo',
            'materia'
        ]);

        return view(
            'prestamos_equipos.show',
            compact('prestamoEquipo')
        );
    }


    /**
     * Mostrar formulario para editar un préstamo.
     */
    public function edit(PrestamoEquipo $prestamoEquipo)
    {
        $equipos = EquipoTecnologico::orderBy('codigo')
            ->get();

        $docentes = Docente::orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        $alumnos = Alumno::with('grupo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        $materias = Materia::orderBy('semestre')
            ->orderBy('nombre')
            ->get();

        return view(
            'prestamos_equipos.edit',
            compact(
                'prestamoEquipo',
                'equipos',
                'docentes',
                'alumnos',
                'materias'
            )
        );
    }


    /**
     * Actualizar un préstamo.
     */
    public function update(
        Request $request,
        PrestamoEquipo $prestamoEquipo
    ) {
        $datos = $request->validate([

            'equipo_id' => [
                'required',
                'exists:equipos_tecnologicos,id'
            ],

            'fecha_prestamo' => [
                'required',
                'date'
            ],

            'hora_prestamo' => [
                'required'
            ],

            'docente_id' => [
                'nullable',
                'exists:docentes,id'
            ],

            'alumno_id' => [
                'nullable',
                'exists:alumnos,id'
            ],

            'materia_id' => [
                'nullable',
                'exists:materias,id'
            ],

            'semestre' => [
                'nullable',
                'integer',
                'min:1',
                'max:12'
            ],

            'fecha_devolucion' => [
                'nullable',
                'date'
            ],

            'hora_devolucion' => [
                'nullable'
            ],

            'estado' => [
                'required',
                'in:Prestado,Devuelto,Atrasado'
            ],

            'condicion_entrega' => [
                'nullable',
                'string',
                'max:100'
            ],

            'condicion_devolucion' => [
                'nullable',
                'string',
                'max:100'
            ],

            'responsable_entrega' => [
                'nullable',
                'string',
                'max:150'
            ],

            'responsable_recepcion' => [
                'nullable',
                'string',
                'max:150'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ],
        ]);

        $equipoAnterior = $prestamoEquipo->equipo;

        $equipoNuevo = EquipoTecnologico::findOrFail(
            $datos['equipo_id']
        );

        if ($datos['estado'] === 'Devuelto') {
            $equipoNuevo->update([
                'estado' => 'Disponible'
            ]);
        } else {
            $equipoNuevo->update([
                'estado' => 'Prestado'
            ]);
        }

        if (
            $equipoAnterior &&
            $equipoAnterior->id !== $equipoNuevo->id
        ) {
            $equipoAnterior->update([
                'estado' => 'Disponible'
            ]);
        }

        $prestamoEquipo->update($datos);

        return redirect()
            ->route(
                'prestamos_equipos.show',
                $prestamoEquipo
            )
            ->with(
                'success',
                'El préstamo se actualizó correctamente.'
            );
    }


    /**
     * Eliminar un préstamo.
     */
    public function destroy(
        PrestamoEquipo $prestamoEquipo
    ) {
        $equipo = $prestamoEquipo->equipo;

        $prestamoEquipo->delete();

        if ($equipo) {
            $equipo->update([
                'estado' => 'Disponible'
            ]);
        }

        return redirect()
            ->route('prestamos_equipos.index')
            ->with(
                'success',
                'El préstamo se eliminó correctamente.'
            );
    }
}
