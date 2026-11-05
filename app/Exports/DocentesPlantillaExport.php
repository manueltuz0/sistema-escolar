<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DocentesPlantillaExport implements FromArray, WithHeadings
{
    /**
     * La plantilla se descarga sin docentes de ejemplo.
     */
    public function array(): array
    {
        return [];
    }

    /**
     * Encabezados reconocidos por DocentesImport.
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
}