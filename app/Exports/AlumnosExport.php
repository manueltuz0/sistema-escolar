<?php

namespace App\Exports;

use App\Models\Alumno;
use Illuminate\Support\Enumerable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AlumnosExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Enumerable
    {
        return Alumno::with('grupo')
            ->orderBy('apellidos')
            ->orderBy('nombres')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Matricula',
            'Nombres',
            'Apellidos',
            'Email',
            'Grado',
            'Grupo',
        ];
    }

    public function map($alumno): array
    {
        return [
            $alumno->matricula,
            $alumno->nombres,
            $alumno->apellidos,
            $alumno->email,
            $alumno->grupo->grado ?? '',
            $alumno->grupo->nombre ?? '',
        ];
    }
}
