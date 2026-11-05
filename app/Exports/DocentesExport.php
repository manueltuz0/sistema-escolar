<?php

namespace App\Exports;

use App\Models\Docente;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DocentesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Obtener todos los docentes registrados.
     */
    public function collection(): Collection
    {
        return Docente::query()
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();
    }

    /**
     * Encabezados del archivo Excel.
     */
    public function headings(): array
    {
        return [
            'Numero_Empleado',
            'Nombres',
            'Apellidos',
            'Email',
            'Telefono',
            'Especialidad',
        ];
    }

    /**
     * Datos de cada docente.
     */
    public function map($docente): array
    {
        return [
            $docente->numero_empleado,
            $docente->nombres,
            $docente->apellidos,
            $docente->email,
            $docente->telefono,
            $docente->especialidad,
        ];
    }
}