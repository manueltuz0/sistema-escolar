<?php

namespace App\Http\Controllers;

use App\Models\ReservacionEquipo;
use App\Models\EquipoTecnologico;
use App\Models\PrestamoEquipo;
use App\Models\MovimientoPrestamo;
use App\Models\Docente;
use App\Models\Alumno;
use App\Models\Materia;
use App\Models\AsignacionMateria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ReservacionEquipoController extends Controller
{
    /**
     * Listar reservaciones.
     */
    public function index()
    {
        $reservaciones = ReservacionEquipo::with([
            'equipo',
            'docente',
            'alumno.grupo',
            'materia',
            'solicitadoPor',
            'autorizadoPor'
        ])
        ->orderByDesc('id')
        ->paginate(15);

        return view(
            'reservaciones_equipos.index',
            compact('reservaciones')
        );
    }

    /**
     * Mostrar formulario de reservación.
     */
   
public function create()
{
    $equipos = EquipoTecnologico::where('estado', 'Disponible')
        ->orderBy('codigo')
        ->get();

    $docentes = Docente::where('activo', true)
        ->orderBy('apellidos')
        ->orderBy('nombres')
        ->get();

    return view(
        'reservaciones_equipos.create',
        compact('equipos', 'docentes')
    );
}

    /**
     * Registrar una nueva reservación.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([

            'equipo_id' => [
                'required',
                'exists:equipos_tecnologicos,id'
            ],

            'docente_id' => [
                'nullable',
                'required_without:alumno_id',
                'prohibited_with:alumno_id',
                'exists:docentes,id'
            ],

            'alumno_id' => [
                'nullable',
                'required_without:docente_id',
                'prohibited_with:docente_id',
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

            'fecha_inicio' => [
                'required',
                'date',
                'after_or_equal:today'
            ],

            'hora_inicio' => [
                'required',
                'date_format:H:i'
            ],

            'fecha_fin' => [
                'required',
                'date',
                'after_or_equal:fecha_inicio'
            ],

            'hora_fin' => [
                'required',
                'date_format:H:i'
            ],

            'observaciones' => [
                'nullable',
                'string'
            ],
        ]);

        $inicio = Carbon::parse(
            $datos['fecha_inicio'] . ' ' . $datos['hora_inicio']
        );

        $fin = Carbon::parse(
            $datos['fecha_fin'] . ' ' . $datos['hora_fin']
        );

        if ($fin->lessThanOrEqualTo($inicio)) {
            throw ValidationException::withMessages([
                'hora_fin' => 'La fecha y hora de finalización deben ser posteriores al inicio.'
            ]);
        }

        return DB::transaction(function () use ($datos, $inicio, $fin) {

            $equipo = EquipoTecnologico::whereKey($datos['equipo_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($equipo->estado !== 'Disponible') {
                throw ValidationException::withMessages([
                    'equipo_id' => 'El equipo no se encuentra disponible para reservar.'
                ]);
            }

            /*
             * Verificar reservaciones que se cruzan.
             * Se consideran las pendientes y aprobadas.
             */
            $conflicto = ReservacionEquipo::where(
                'equipo_id',
                $equipo->id
            )
            ->whereIn('estado', ['Pendiente', 'Aprobada'])
            ->whereRaw(
                'TIMESTAMP(fecha_inicio, hora_inicio) < ?',
                [$fin->format('Y-m-d H:i:s')]
            )
            ->whereRaw(
                'TIMESTAMP(fecha_fin, hora_fin) > ?',
                [$inicio->format('Y-m-d H:i:s')]
            )
            ->exists();

            if ($conflicto) {
                throw ValidationException::withMessages([
                    'equipo_id' => 'El equipo ya tiene una reservación en ese horario.'
                ]);
            }

            $datos['estado'] = 'Pendiente';

            $datos['solicitado_por_user_id'] = auth()->id;

            $reservacion = ReservacionEquipo::create($datos);

            /*
             * Registrar movimiento histórico.
             */
            MovimientoPrestamo::create([
                'reservacion_equipo_id' => $reservacion->id,
                'user_id' => auth()->id,
                'tipo_movimiento' => 'Solicitud creada',
                'estado_anterior' => null,
                'estado_nuevo' => 'Pendiente',
                'descripcion' => 'Se registró una nueva solicitud de reservación.',
            ]);

            return redirect()
                ->route('reservaciones_equipos.index')
                ->with(
                    'success',
                    'La reservación se registró correctamente y está pendiente de autorización.'
                );
        });
    }

public function calendario(Request $request)
{
    $fecha = $request->input('fecha', now()->format('Y-m-d'));

    $reservaciones = ReservacionEquipo::with([
        'equipo',
        'docente',
        'alumno',
    ])
    ->whereIn('estado', ['Pendiente', 'Aprobada'])
    ->whereDate('fecha_inicio', '<=', $fecha)
    ->whereDate('fecha_fin', '>=', $fecha)
    ->orderBy('hora_inicio')
    ->get();

    $equipos = EquipoTecnologico::whereNotIn('estado', [
        'Mantenimiento',
        'Baja',
    ])
    ->orderBy('codigo')
    ->get();

    return view('reservaciones_equipos.calendario', compact(
        'fecha',
        'reservaciones',
        'equipos'
    ));
}
/**
 * Buscar alumnos mediante nombre, apellido o matrícula.
 */
public function buscarAlumnos(Request $request)
{
    $termino = trim($request->get('buscar', ''));

    if (mb_strlen($termino) < 3) {
        return response()->json([]);
    }

    $alumnos = Alumno::query()
        ->where(function ($query) use ($termino) {
            $query->where('nombres', 'LIKE', "%{$termino}%")
                ->orWhere('apellidos', 'LIKE', "%{$termino}%")
                ->orWhere('matricula', 'LIKE', "%{$termino}%");
        })
        ->orderBy('apellidos')
        ->orderBy('nombres')
        ->limit(10)
        ->get([
            'id',
            'nombres',
            'apellidos',
            'matricula'
        ]);

    return response()->json($alumnos);
}

/**
 * Obtener materias según semestre y, si corresponde,
 * según las asignaciones del docente.
 */
public function materiasPorSemestre(Request $request)
{
    $datos = $request->validate([
        'semestre' => ['required', 'integer', 'min:1', 'max:6'],
        'docente_id' => ['nullable', 'exists:docentes,id'],
    ]);

    if (!empty($datos['docente_id'])) {

        $cicloActivo = DB::table('ciclos_escolares')
            ->where('activo', 1)
            ->value('id');

        if (!$cicloActivo) {
            return response()->json([
                'mensaje' => 'No hay un ciclo escolar activo.'
            ], 422);
        }

        $materias = DB::table('asignaciones_materias as am')
            ->join('materias as m', 'm.id', '=', 'am.materia_id')
            ->where('am.docente_id', $datos['docente_id'])
            ->where('am.ciclo_escolar_id', $cicloActivo)
            ->where('m.semestre', $datos['semestre'])
            ->where('m.activa', 1)
            ->select('m.id', 'm.nombre', 'm.semestre')
            ->distinct()
            ->orderBy('m.nombre')
            ->get();

    } else {

        $materias = Materia::where('semestre', $datos['semestre'])
            ->where('activa', 1)
            ->orderBy('nombre')
            ->get(['id', 'nombre', 'semestre']);
    }

    return response()->json($materias);
}
    /**
     * Mostrar detalles de una reservación.
     */
    public function show(ReservacionEquipo $reservacionEquipo)
    {
        $reservacionEquipo->load([
            'equipo',
            'docente',
            'alumno.grupo',
            'materia',
            'solicitadoPor',
            'autorizadoPor',
            'canceladoPor',
            'prestamo',
            'movimientos.usuario'
        ]);

        return view(
            'reservaciones_equipos.show',
            compact('reservacionEquipo')
        );
    }

    /**
     * Aprobar una reservación.
     */
    public function aprobar(ReservacionEquipo $reservacionEquipo)
    {
        return DB::transaction(function () use ($reservacionEquipo) {

            $reservacion = ReservacionEquipo::whereKey(
                $reservacionEquipo->id
            )
            ->lockForUpdate()
            ->firstOrFail();

            if ($reservacion->estado !== 'Pendiente') {
                return back()->with(
                    'error',
                    'Esta reservación ya fue procesada.'
                );
            }

            $equipo = EquipoTecnologico::whereKey(
                $reservacion->equipo_id
            )
            ->lockForUpdate()
            ->firstOrFail();

            if ($equipo->estado !== 'Disponible') {
                return back()->with(
                    'error',
                    'El equipo ya no se encuentra disponible.'
                );
            }

            $inicio = Carbon::parse(
                $reservacion->fecha_inicio->format('Y-m-d')
                . ' ' . $reservacion->hora_inicio
            );

            $fin = Carbon::parse(
                $reservacion->fecha_fin->format('Y-m-d')
                . ' ' . $reservacion->hora_fin
            );

            $conflicto = ReservacionEquipo::where(
                'equipo_id',
                $equipo->id
            )
            ->where('id', '!=', $reservacion->id)
            ->whereIn('estado', ['Pendiente', 'Aprobada'])
            ->whereRaw(
                'TIMESTAMP(fecha_inicio, hora_inicio) < ?',
                [$fin->format('Y-m-d H:i:s')]
            )
            ->whereRaw(
                'TIMESTAMP(fecha_fin, hora_fin) > ?',
                [$inicio->format('Y-m-d H:i:s')]
            )
            ->exists();

            if ($conflicto) {
                return back()->with(
                    'error',
                    'Existe otra reservación que se cruza con este horario.'
                );
            }

            $prestamoActivo = PrestamoEquipo::where(
                'equipo_id',
                $equipo->id
            )
            ->whereIn('estado', ['Prestado', 'Atrasado'])
            ->exists();

            if ($prestamoActivo) {
                return back()->with(
                    'error',
                    'El equipo tiene un préstamo activo.'
                );
            }

            $reservacion->update([
                'estado' => 'Aprobada',
                'autorizado_por_user_id' => auth()->id,
                'autorizado_at' => now(),
            ]);

            MovimientoPrestamo::create([
                'reservacion_equipo_id' => $reservacion->id,
                'user_id' => auth()->id,
                'tipo_movimiento' => 'Reservación aprobada',
                'estado_anterior' => 'Pendiente',
                'estado_nuevo' => 'Aprobada',
                'descripcion' => 'La reservación fue autorizada.',
            ]);

            return back()->with(
                'success',
                'La reservación fue aprobada correctamente.'
            );
        });
    }

    /**
     * Rechazar una reservación.
     */
    public function rechazar(
        Request $request,
        ReservacionEquipo $reservacionEquipo
    ) {
        $datos = $request->validate([
            'motivo_rechazo' => [
                'required',
                'string',
                'max:2000'
            ],
        ]);

        return DB::transaction(function () use ($reservacionEquipo, $datos) {

            $reservacion = ReservacionEquipo::whereKey(
                $reservacionEquipo->id
            )
            ->lockForUpdate()
            ->firstOrFail();

            if ($reservacion->estado !== 'Pendiente') {
                return back()->with(
                    'error',
                    'Esta reservación ya fue procesada.'
                );
            }

            $reservacion->update([
                'estado' => 'Rechazada',
                'autorizado_por_user_id' => auth()->id,
                'autorizado_at' => now(),
                'motivo_rechazo' => $datos['motivo_rechazo'],
            ]);

            MovimientoPrestamo::create([
                'reservacion_equipo_id' => $reservacion->id,
                'user_id' => auth()->id,
                'tipo_movimiento' => 'Reservación rechazada',
                'estado_anterior' => 'Pendiente',
                'estado_nuevo' => 'Rechazada',
                'descripcion' => $datos['motivo_rechazo'],
            ]);

            return back()->with(
                'success',
                'La reservación fue rechazada.'
            );
        });
    }

    /**
     * Cancelar una reservación.
     */
    public function cancelar(
        Request $request,
        ReservacionEquipo $reservacionEquipo
    ) {
        $datos = $request->validate([
            'motivo_cancelacion' => [
                'nullable',
                'string',
                'max:2000'
            ],
        ]);

        return DB::transaction(function () use ($reservacionEquipo, $datos) {

            $reservacion = ReservacionEquipo::whereKey(
                $reservacionEquipo->id
            )
            ->lockForUpdate()
            ->firstOrFail();

            if (!in_array($reservacion->estado, ['Pendiente', 'Aprobada'])) {
                return back()->with(
                    'error',
                    'Esta reservación no se puede cancelar.'
                );
            }

            $estadoAnterior = $reservacion->estado;

            $reservacion->update([
                'estado' => 'Cancelada',
                'cancelado_por_user_id' => auth()->id,
                'cancelado_at' => now(),
                'motivo_cancelacion' => $datos['motivo_cancelacion'] ?? null,
            ]);

            MovimientoPrestamo::create([
                'reservacion_equipo_id' => $reservacion->id,
                'user_id' => auth()->id,
                'tipo_movimiento' => 'Reservación cancelada',
                'estado_anterior' => $estadoAnterior,
                'estado_nuevo' => 'Cancelada',
                'descripcion' => $datos['motivo_cancelacion']
                    ?? 'La reservación fue cancelada.',
            ]);

            return back()->with(
                'success',
                'La reservación fue cancelada correctamente.'
            );
        });
    }
}
