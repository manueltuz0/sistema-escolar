<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\ResponsableAlumno;
use App\Exports\AlumnosExport;
use App\Imports\AlumnosImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AlumnoController extends Controller
{
    /**
     * Mostrar todos los alumnos.
     */
    public function index()
    {
        $alumnos = Alumno::with('grupo')->get();

        return view('alumnos.index', compact('alumnos'));
    }

    /**
     * Mostrar el formulario para registrar un alumno.
     */
    public function create()
    {
        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        return view('alumnos.create', compact('grupos'));
    }

    /**
     * Guardar un nuevo alumno y su responsable.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'matricula' => 'required|string|max:20|unique:alumnos,matricula',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:alumnos,email',
            'grupo_id' => 'required|exists:grupos,id',

            // Datos opcionales del responsable
            'responsable_nombre' => 'nullable|string|max:150',
            'responsable_parentesco' => 'nullable|string|max:30',
            'responsable_email' => 'nullable|email|max:150',
            'responsable_telefono' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($datos) {

            $alumno = Alumno::create([
                'matricula' => $datos['matricula'],
                'nombres' => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'email' => $datos['email'],
                'grupo_id' => $datos['grupo_id'],
            ]);

            // Guardar responsable si se proporcionó su nombre.
            if (!empty($datos['responsable_nombre'])) {
                $alumno->responsables()->create([
                    'nombre' => $datos['responsable_nombre'],
                    'parentesco' => $datos['responsable_parentesco'] ?? 'Tutor',
                    'email' => $datos['responsable_email'] ?? null,
                    'telefono' => $datos['responsable_telefono'] ?? null,
                    'es_principal' => true,
                ]);
            }
        });

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno registrado correctamente.');
    }

    /**
     * Mostrar un alumno específico.
     */
    public function show(string $id)
    {
        $alumno = Alumno::with(['grupo', 'responsables'])
            ->findOrFail($id);

        return view('alumnos.show', compact('alumno'));
    }

    /**
     * Mostrar el formulario para editar un alumno.
     */
    public function edit(string $id)
    {
        $alumno = Alumno::with(['grupo', 'responsables'])
            ->findOrFail($id);

        $grupos = Grupo::orderBy('grado')
            ->orderBy('nombre')
            ->get();

        return view('alumnos.edit', compact('alumno', 'grupos'));
    }

    /**
     * Actualizar un alumno y sus datos de responsable.
     */
    public function update(Request $request, string $id)
    {
        $alumno = Alumno::findOrFail($id);

        $datos = $request->validate([
            'matricula' => 'required|string|max:20|unique:alumnos,matricula,' . $alumno->id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:alumnos,email,' . $alumno->id,
            'grupo_id' => 'required|exists:grupos,id',

            // Datos opcionales del responsable
            'responsable_nombre' => 'nullable|string|max:150',
            'responsable_parentesco' => 'nullable|string|max:30',
            'responsable_email' => 'nullable|email|max:150',
            'responsable_telefono' => 'nullable|string|max:20',
        ]);

        DB::transaction(function () use ($datos, $alumno) {

            $alumno->update([
                'matricula' => $datos['matricula'],
                'nombres' => $datos['nombres'],
                'apellidos' => $datos['apellidos'],
                'email' => $datos['email'],
                'grupo_id' => $datos['grupo_id'],
            ]);

            $responsable = $alumno->responsables()
                ->where('es_principal', true)
                ->first();

            if (!empty($datos['responsable_nombre'])) {

                $datosResponsable = [
                    'nombre' => $datos['responsable_nombre'],
                    'parentesco' => $datos['responsable_parentesco'] ?? 'Tutor',
                    'email' => $datos['responsable_email'] ?? null,
                    'telefono' => $datos['responsable_telefono'] ?? null,
                    'es_principal' => true,
                ];

                if ($responsable) {
                    $responsable->update($datosResponsable);
                } else {
                    $alumno->responsables()->create($datosResponsable);
                }

            } elseif ($responsable) {
                // Si se vacían los datos del responsable principal,
                // se elimina únicamente ese registro.
                $responsable->delete();
            }
        });

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno actualizado correctamente.');
    }

    /**
     * Eliminar un alumno.
     */
    public function destroy(string $id)
    {
        $alumno = Alumno::findOrFail($id);

        $alumno->delete();

        return redirect()
            ->route('alumnos.index')
            ->with('success', 'Alumno eliminado correctamente.');
    }

    /**
     * Exportar alumnos a Excel.
     */
    public function exportar()
    {
        return Excel::download(
            new AlumnosExport(),
            'alumnos_' . now()->format('Y-m-d_H-i-s') . '.xlsx'
        );
    }

    /**
     * Importar alumnos desde Excel.
     * Se conserva la importación actual sin exigir datos de responsables.
     */
    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);

        $importacion = new AlumnosImport();

        try {
            Excel::import($importacion, $request->file('archivo'));

            $mensaje = "Importación terminada. Alumnos registrados: {$importacion->importados}.";

            if (!empty($importacion->errores)) {
                session()->flash('errores_importacion', $importacion->errores);
                $mensaje .= ' Algunas filas se omitieron por errores o duplicados.';
            }

            return redirect()
                ->route('alumnos.index')
                ->with('success', $mensaje);

        } catch (\Throwable $e) {

            Log::error('Error al importar alumnos: ' . $e->getMessage());

            return redirect()
                ->route('alumnos.index')
                ->with('error', 'No se pudo importar el archivo. Revisa que sea un Excel válido con los encabezados correctos.');
        }
    }
}
