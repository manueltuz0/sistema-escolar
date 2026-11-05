<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Citatorio;
use App\Models\NotificacionCitatorio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CitatorioController extends Controller
{
    /**
     * Mostrar todos los citatorios.
     */
    public function index(Request $request)
    {
        $citatorios = Citatorio::with('alumno.grupo')
            ->when($request->filled('buscar'), function ($query) use ($request) {
                $buscar = $request->buscar;

                $query->where(function ($q) use ($buscar) {
                    $q->where('responsable_nombre', 'like', "%{$buscar}%")
                        ->orWhere('estado', 'like', "%{$buscar}%")
                        ->orWhereHas('alumno', function ($alumno) use ($buscar) {
                            $alumno->where('nombres', 'like', "%{$buscar}%")
                                ->orWhere('apellidos', 'like', "%{$buscar}%")
                                ->orWhere('matricula', 'like', "%{$buscar}%");
                        });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('citatorios.index', compact('citatorios'));
    }

    /**
     * Mostrar formulario para registrar citatorio.
     */
    public function create()
    {
        $alumnos = Alumno::with(['grupo', 'responsables'])
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        return view('citatorios.create', compact('alumnos'));
    }

    /**
     * Guardar un nuevo citatorio.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'alumno_id' => [
                'required',
                'exists:alumnos,id',
            ],
            'responsable_alumno_id' => [
                'nullable',
                Rule::exists('responsables_alumnos', 'id')
                    ->where('alumno_id', $request->alumno_id),
            ],
            'responsable_nombre' => [
                'required',
                'string',
                'max:150',
            ],
            'responsable_parentesco' => [
                'required',
                'string',
                'max:30',
            ],
            'responsable_email' => [
                'nullable',
                'email',
                'max:150',
            ],
            'responsable_telefono' => [
                'required',
                'string',
                'max:20',
            ],
            'motivo' => [
                'required',
                'string',
            ],
            'fecha_emision' => [
                'required',
                'date',
            ],
            'fecha_cita' => [
                'required',
                'date',
                'after_or_equal:fecha_emision',
            ],
            'hora_cita' => [
                'required',
                'date_format:H:i',
            ],
            'observaciones' => [
                'nullable',
                'string',
            ],
            'estado' => [
                'required',
                Rule::in(['Pendiente', 'Atendido', 'Cancelado']),
            ],
        ]);

        Citatorio::create($datos);

        return redirect()
            ->route('citatorios.index')
            ->with('success', 'El citatorio se registró correctamente.');
    }

    /**
     * Mostrar un citatorio y el historial completo del alumno.
     */
    public function show(Citatorio $citatorio)
    {
        $citatorio->load(['alumno.grupo', 'responsable', 'notificaciones']);

        $historial = Citatorio::where('alumno_id', $citatorio->alumno_id)
            ->orderByDesc('fecha_emision')
            ->orderByDesc('id')
            ->get();

        return view('citatorios.show', compact('citatorio', 'historial'));
    }

    /**
     * Preparar una notificación por WhatsApp.
     */
    public function notificar(Citatorio $citatorio)
    {
        $citatorio->load('alumno');

        // Limpiar el teléfono y conservar únicamente los números.
        $telefono = preg_replace('/\D+/', '', $citatorio->responsable_telefono);

        // Agregar el prefijo de México cuando el teléfono tiene 10 dígitos.
        if (strlen($telefono) === 10) {
            $telefono = '52' . $telefono;
        }

        // Validar que el número tenga un formato utilizable.
        if (
            strlen($telefono) < 12 ||
            strlen($telefono) > 13 ||
            !str_starts_with($telefono, '52')
        ) {
            return back()->with(
                'error',
                'El teléfono del responsable no tiene un formato válido para WhatsApp. Verifica el número.'
            );
        }

        $nombreAlumno = trim(
            $citatorio->alumno->nombres . ' ' .
            $citatorio->alumno->apellidos
        );

        $fechaCita = $citatorio->fecha_cita->format('d/m/Y');

        $horaCita = substr($citatorio->hora_cita, 0, 5);

        $mensaje = "COBAY - CITATORIO ESCOLAR\n\n"
            . "Estimado(a) {$citatorio->responsable_nombre}:\n\n"
            . "Por medio del presente se le informa que se ha emitido un citatorio relacionado con el alumno:\n\n"
            . "Alumno: {$nombreAlumno}\n"
            . "Motivo: {$citatorio->motivo}\n"
            . "Fecha de asistencia: {$fechaCita}\n"
            . "Hora: {$horaCita}\n\n"
            . "Le solicitamos acudir al plantel en la fecha y hora indicadas.\n\n"
            . "Atentamente,\n"
            . "COBAY Plantel Chichimilá";

        // Registrar la preparación de la notificación.
        NotificacionCitatorio::create([
            'citatorio_id' => $citatorio->id,
            'medio' => 'WhatsApp',
            'telefono' => $telefono,
            'mensaje' => $mensaje,
            'estado' => 'Preparado',
            'fecha_intento' => now(),
            'observaciones' => 'Mensaje preparado. Pendiente de confirmación de envío en WhatsApp.',
        ]);

        // Abrir WhatsApp con el mensaje preparado.
        $urlWhatsApp = 'https://wa.me/' . $telefono
            . '?text=' . urlencode($mensaje);

        return redirect()->away($urlWhatsApp);
    }

    /**
     * Mostrar formulario para editar.
     */
    public function edit(Citatorio $citatorio)
    {
        $alumnos = Alumno::with(['grupo', 'responsables'])
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();

        return view('citatorios.edit', compact('citatorio', 'alumnos'));
    }

    /**
     * Actualizar un citatorio.
     */
    public function update(Request $request, Citatorio $citatorio)
    {
        $datos = $request->validate([
            'alumno_id' => [
                'required',
                'exists:alumnos,id',
            ],
            'responsable_alumno_id' => [
                'nullable',
                Rule::exists('responsables_alumnos', 'id')
                    ->where('alumno_id', $request->alumno_id),
            ],
            'responsable_nombre' => [
                'required',
                'string',
                'max:150',
            ],
            'responsable_parentesco' => [
                'required',
                'string',
                'max:30',
            ],
            'responsable_email' => [
                'nullable',
                'email',
                'max:150',
            ],
            'responsable_telefono' => [
                'required',
                'string',
                'max:20',
            ],
            'motivo' => [
                'required',
                'string',
            ],
            'fecha_emision' => [
                'required',
                'date',
            ],
            'fecha_cita' => [
                'required',
                'date',
                'after_or_equal:fecha_emision',
            ],
            'hora_cita' => [
                'required',
                'date_format:H:i',
            ],
            'observaciones' => [
                'nullable',
                'string',
            ],
            'estado' => [
                'required',
                Rule::in(['Pendiente', 'Atendido', 'Cancelado']),
            ],
        ]);

        $citatorio->update($datos);

        return redirect()
            ->route('citatorios.index')
            ->with('success', 'El citatorio se actualizó correctamente.');
    }

    /**
     * Eliminar un citatorio.
     */
    public function destroy(Citatorio $citatorio)
    {
        $citatorio->delete();

        return redirect()
            ->route('citatorios.index')
            ->with('success', 'El citatorio se eliminó correctamente.');
    }
}
