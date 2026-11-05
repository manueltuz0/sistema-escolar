<?php

namespace App\Http\Controllers;

use App\Models\SeguimientoTutoria;
use App\Models\Tutoria;
use Illuminate\Http\Request;

class SeguimientoTutoriaController extends Controller
{
    /**
     * Registrar un seguimiento para una atención individual.
     */
    public function store(Request $request, Tutoria $tutoria)
    {
        $datos = $request->validate([
            'fecha_programada' => 'required|date',
            'fecha_realizada' => 'nullable|date|after_or_equal:fecha_programada',
            'resultado' => 'nullable|string',
            'acuerdos' => 'nullable|string',
            'estado' => 'required|in:Pendiente,Realizado,Cancelado',
            'observaciones' => 'nullable|string',
        ]);

        $tutoria->seguimientos()->create($datos);

        return back()->with(
            'success',
            'Seguimiento registrado correctamente.'
        );
    }

    /**
     * Actualizar un seguimiento existente.
     */
    public function update(Request $request, SeguimientoTutoria $seguimiento)
    {
        $datos = $request->validate([
            'fecha_programada' => 'required|date',
            'fecha_realizada' => 'nullable|date',
            'resultado' => 'nullable|string',
            'acuerdos' => 'nullable|string',
            'estado' => 'required|in:Pendiente,Realizado,Cancelado',
            'observaciones' => 'nullable|string',
        ]);

        $seguimiento->update($datos);

        return back()->with(
            'success',
            'Seguimiento actualizado correctamente.'
        );
    }
}