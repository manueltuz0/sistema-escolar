<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Imports\DocentesImport;
use App\Exports\DocentesExport;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DocentesPlantillaExport;

class DocenteController extends Controller
{
    /**
     * Mostrar docentes con búsqueda y paginación.
     */
    public function index(Request $request)
    {
        $buscar = trim($request->input('buscar', ''));

        $docentes = Docente::query()
            ->when($buscar !== '', function ($query) use ($buscar) {
                $query->where(function ($subquery) use ($buscar) {
                    $subquery->where('numero_empleado', 'like', "%{$buscar}%")
                        ->orWhere('nombres', 'like', "%{$buscar}%")
                        ->orWhere('apellidos', 'like', "%{$buscar}%")
                        ->orWhere('email', 'like', "%{$buscar}%")
                        ->orWhere('telefono', 'like', "%{$buscar}%")
                        ->orWhere('especialidad', 'like', "%{$buscar}%");
                });
            })
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->paginate(15)
            ->withQueryString();

        return view('docentes.index', compact('docentes', 'buscar'));
    }

    /**
     * Mostrar formulario de registro.
     */
    public function create()
    {
        return view('docentes.create');
    }

    /**
     * Registrar un docente.
     */
    public function store(Request $request)
    {
        $datos = $request->validate([
            'numero_empleado' => 'required|string|max:20|unique:docentes,numero_empleado',
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:docentes,email',
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:100',
        ]);

        Docente::create($datos);

        return redirect()
            ->route('docentes.index')
            ->with('success', 'Docente registrado correctamente.');
    }

    /**
     * Mostrar información de un docente y sus asignaciones académicas.
     */
    public function show(string $id)
    {
        $docente = Docente::with([
            'asignacionesMaterias.materia',
            'asignacionesMaterias.grupo',
            'asignacionesMaterias.cicloEscolar',
        ])->findOrFail($id);

        return view('docentes.show', compact('docente'));
    }

    /**
     * Mostrar formulario de edición.
     */
    public function edit(string $id)
    {
        $docente = Docente::findOrFail($id);

        return view('docentes.edit', compact('docente'));
    }

    /**
     * Actualizar información de un docente.
     */
    public function update(Request $request, string $id)
    {
        $docente = Docente::findOrFail($id);

        $datos = $request->validate([
            'numero_empleado' => 'required|string|max:20|unique:docentes,numero_empleado,' . $docente->id,
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:150',
            'email' => 'required|email|max:150|unique:docentes,email,' . $docente->id,
            'telefono' => 'nullable|string|max:20',
            'especialidad' => 'nullable|string|max:100',
        ]);

        $docente->update($datos);

        return redirect()
            ->route('docentes.index')
            ->with('success', 'Docente actualizado correctamente.');
    }

    /**
     * Exportar docentes a un archivo Excel.
     */
    public function exportar()
    {
        return Excel::download(
            new DocentesExport(),
            'docentes.xlsx'
        );
    }

    /**
     * Descargar una plantilla Excel vacía para registrar docentes.
     */
    public function descargarPlantilla()
    {
        return Excel::download(
            new DocentesPlantillaExport(),
            'plantilla_docentes.xlsx'
        );
    }

    /**
     * Importar docentes desde un archivo Excel.
     */
    public function importar(Request $request)
    {
        $request->validate([
            'archivo' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:5120',
            ],
        ], [
            'archivo.required' => 'Selecciona un archivo Excel para importar.',
            'archivo.file' => 'El archivo seleccionado no es válido.',
            'archivo.mimes' => 'El archivo debe ser Excel (.xlsx, .xls) o CSV.',
            'archivo.max' => 'El archivo no debe superar los 5 MB.',
        ]);

        $importacion = new DocentesImport();

        try {
            Excel::import(
                $importacion,
                $request->file('archivo')
            );

            $mensaje = "Importación terminada. Docentes registrados: {$importacion->importados}.";

            if (count($importacion->errores) > 0) {
                return redirect()
                    ->route('docentes.index')
                    ->with('warning', $mensaje)
                    ->with('errores_importacion', $importacion->errores);
            }

            return redirect()
                ->route('docentes.index')
                ->with('success', $mensaje);

        } catch (\Throwable $e) {
            report($e);

            return redirect()
                ->route('docentes.index')
                ->with(
                    'error',
                    'No se pudo procesar el archivo Excel. Verifica que tenga las columnas correctas.'
                );
        }
    }

    /**
     * Eliminar un docente únicamente si no tiene asignaciones.
     */
    public function destroy(string $id)
    {
        $docente = Docente::findOrFail($id);

        // Comprobar si tiene asignaciones académicas.
        if ($docente->asignacionesMaterias()->exists()) {
            return redirect()
                ->route('docentes.index')
                ->with(
                    'error',
                    'No se puede eliminar este docente porque tiene materias o grupos asignados.'
                );
        }

        try {
            $docente->delete();
        } catch (QueryException $e) {
            // La base de datos puede impedir la eliminación
            // si existen otros registros relacionados.
            Log::warning('No se pudo eliminar un docente.', [
                'docente_id' => $docente->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('docentes.index')
                ->with(
                    'error',
                    'No se puede eliminar este docente porque tiene otros registros relacionados.'
                );
        }

        return redirect()
            ->route('docentes.index')
            ->with('success', 'Docente eliminado correctamente.');
    }
}