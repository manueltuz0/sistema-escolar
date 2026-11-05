<?php

namespace App\Http\Controllers;

use App\Models\EquipoTecnologico;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EquipoTecnologicoController extends Controller
{
    // ==========================================
    // LISTADO DE EQUIPOS
    // ==========================================
    public function index(Request $request)
    {
        $consulta = EquipoTecnologico::query();

        // BUSCADOR
        if ($request->filled('buscar')) {
            $buscar = $request->buscar;

            $consulta->where(function ($query) use ($buscar) {
                $query->where('codigo', 'LIKE', "%{$buscar}%")
                    ->orWhere('tipo', 'LIKE', "%{$buscar}%")
                    ->orWhere('marca', 'LIKE', "%{$buscar}%")
                    ->orWhere('modelo', 'LIKE', "%{$buscar}%")
                    ->orWhere('numero_serie', 'LIKE', "%{$buscar}%");
            });
        }

        // FILTRO POR ESTADO
        if ($request->filled('estado')) {
            $consulta->where('estado', $request->estado);
        }

        $equipos = $consulta->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('equipos_tecnologicos.index', compact('equipos'));
    }

    // ==========================================
    // FORMULARIO PARA REGISTRAR EQUIPO
    // ==========================================
    public function create()
    {
        return view('equipos_tecnologicos.create');
    }

    // ==========================================
    // GUARDAR NUEVO EQUIPO
    // ==========================================
    public function store(Request $request)
    {
        $datos = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:30',
                'unique:equipos_tecnologicos,codigo',
            ],

            'tipo' => [
                'required',
                'string',
                'max:50',
            ],

            'marca' => [
                'nullable',
                'string',
                'max:100',
            ],

            'modelo' => [
                'nullable',
                'string',
                'max:100',
            ],

            'numero_serie' => [
                'nullable',
                'string',
                'max:100',
                'unique:equipos_tecnologicos,numero_serie',
            ],

            'estado' => [
                'required',
                Rule::in([
                    'Disponible',
                    'Prestado',
                    'Mantenimiento',
                    'Baja',
                ]),
            ],

            'ubicacion' => [
                'nullable',
                'string',
                'max:100',
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],
        ]);

        EquipoTecnologico::create($datos);

        return redirect()
            ->route('equipos_tecnologicos.index')
            ->with('success', 'El equipo se registró correctamente.');
    }

    // ==========================================
    // MOSTRAR DETALLES DEL EQUIPO
    // ==========================================
    public function show(EquipoTecnologico $equipoTecnologico)
    {
        $equipoTecnologico->load([
            'prestamos',
            'reservaciones',
        ]);

        return view(
            'equipos_tecnologicos.show',
            compact('equipoTecnologico')
        );
    }

    // ==========================================
    // FORMULARIO PARA EDITAR EQUIPO
    // ==========================================
    public function edit(EquipoTecnologico $equipoTecnologico)
    {
        return view(
            'equipos_tecnologicos.edit',
            compact('equipoTecnologico')
        );
    }

    // ==========================================
    // ACTUALIZAR EQUIPO
    // ==========================================
    public function update(
        Request $request,
        EquipoTecnologico $equipoTecnologico
    ) {
        $datos = $request->validate([
            'codigo' => [
                'required',
                'string',
                'max:30',
                Rule::unique('equipos_tecnologicos', 'codigo')
                    ->ignore($equipoTecnologico->id),
            ],

            'tipo' => [
                'required',
                'string',
                'max:50',
            ],

            'marca' => [
                'nullable',
                'string',
                'max:100',
            ],

            'modelo' => [
                'nullable',
                'string',
                'max:100',
            ],

            'numero_serie' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('equipos_tecnologicos', 'numero_serie')
                    ->ignore($equipoTecnologico->id),
            ],

            'estado' => [
                'required',
                Rule::in([
                    'Disponible',
                    'Prestado',
                    'Mantenimiento',
                    'Baja',
                ]),
            ],

            'ubicacion' => [
                'nullable',
                'string',
                'max:100',
            ],

            'observaciones' => [
                'nullable',
                'string',
            ],
        ]);

        $equipoTecnologico->update($datos);

        return redirect()
            ->route('equipos_tecnologicos.index')
            ->with('success', 'El equipo se actualizó correctamente.');
    }

    // ==========================================
    // DAR DE BAJA EQUIPO
    // ==========================================
    public function destroy(EquipoTecnologico $equipoTecnologico)
    {
        if ($equipoTecnologico->estado === 'Prestado') {
            return back()->with(
                'error',
                'No puedes dar de baja un equipo que está prestado.'
            );
        }

        // Se conserva el registro y su historial.
        $equipoTecnologico->update([
            'estado' => 'Baja',
        ]);

        return redirect()
            ->route('equipos_tecnologicos.index')
            ->with('success', 'El equipo se dio de baja correctamente.');
    }
}
