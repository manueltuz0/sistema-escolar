<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;

class ExpedienteTutoriaController extends Controller
{
    /**
     * Mostrar el listado de alumnos para consultar sus expedientes.
     */
    public function index(Request $request)
    {
        $buscar = trim($request->input('buscar', ''));

        // No cargar alumnos hasta que el profesor escriba algo.
        $alumnos = collect();

        if (strlen($buscar) >= 2) {
            $alumnos = Alumno::with('grupo')
                ->where(function ($query) use ($buscar) {
                    $query->where('matricula', 'LIKE', $buscar . '%')
                        ->orWhere('nombres', 'LIKE', '%' . $buscar . '%')
                        ->orWhere('apellidos', 'LIKE', '%' . $buscar . '%');
                })
                ->orderBy('apellidos')
                ->orderBy('nombres')
                ->limit(10)
                ->get();
        }

        return view('tutorias.expedientes.index', compact('alumnos', 'buscar'));
    }

    /**
     * Mostrar el expediente individual de un alumno.
     */
    public function show(Alumno $alumno)
    {
        $alumno->load([
            'grupo',
            'tutorias' => function ($query) {
                $query->with([
                    'docente',
                    'seguimientos'
                ])->orderByDesc('fecha');
            },
            'actividadesTutorias' => function ($query) {
                $query->with('docente')
                    ->orderByDesc('fecha');
            }
        ]);

        return view('tutorias.expedientes.show', compact('alumno'));
    }
}