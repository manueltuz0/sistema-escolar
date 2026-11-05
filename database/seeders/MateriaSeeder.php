<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Materia;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        $materias = [
            // PRIMER SEMESTRE
            ['nombre' => 'Matemáticas I', 'semestre' => 1],
            ['nombre' => 'Química I', 'semestre' => 1],
            ['nombre' => 'Ética I', 'semestre' => 1],
            ['nombre' => 'Metodología de la Investigación', 'semestre' => 1],
            ['nombre' => 'Taller de Lectura y Redacción I', 'semestre' => 1],
            ['nombre' => 'Inglés I', 'semestre' => 1],
            ['nombre' => 'Informática I', 'semestre' => 1],
            ['nombre' => 'Tutorías I', 'semestre' => 1],
            ['nombre' => 'Paraescolares I', 'semestre' => 1],

            // SEGUNDO SEMESTRE
            ['nombre' => 'Matemáticas II', 'semestre' => 2],
            ['nombre' => 'Química II', 'semestre' => 2],
            ['nombre' => 'Ética II', 'semestre' => 2],
            ['nombre' => 'Introducción a las Ciencias Sociales', 'semestre' => 2],
            ['nombre' => 'Taller de Lectura y Redacción II', 'semestre' => 2],
            ['nombre' => 'Inglés II', 'semestre' => 2],
            ['nombre' => 'Informática II', 'semestre' => 2],
            ['nombre' => 'Tutorías II', 'semestre' => 2],
            ['nombre' => 'Paraescolares II', 'semestre' => 2],

            // TERCER SEMESTRE
            ['nombre' => 'Matemáticas III', 'semestre' => 3],
            ['nombre' => 'Biología I', 'semestre' => 3],
            ['nombre' => 'Física I', 'semestre' => 3],
            ['nombre' => 'Historia de México I', 'semestre' => 3],
            ['nombre' => 'Literatura I', 'semestre' => 3],
            ['nombre' => 'Inglés III', 'semestre' => 3],
            ['nombre' => 'Gestión de Archivos de Texto', 'semestre' => 3],
            ['nombre' => 'Hoja de Cálculo Aplicado', 'semestre' => 3],
            ['nombre' => 'Tutorías III', 'semestre' => 3],
            ['nombre' => 'Paraescolares III', 'semestre' => 3],

            // CUARTO SEMESTRE
            ['nombre' => 'Matemáticas IV', 'semestre' => 4],
            ['nombre' => 'Biología II', 'semestre' => 4],
            ['nombre' => 'Física II', 'semestre' => 4],
            ['nombre' => 'Historia de México II', 'semestre' => 4],
            ['nombre' => 'Literatura II', 'semestre' => 4],
            ['nombre' => 'Inglés IV', 'semestre' => 4],
            ['nombre' => 'Comunidades Virtuales', 'semestre' => 4],
            ['nombre' => 'Mantenimiento y Redes de Cómputo', 'semestre' => 4],
            ['nombre' => 'Tutorías IV', 'semestre' => 4],
            ['nombre' => 'Paraescolares IV', 'semestre' => 4],

            // QUINTO SEMESTRE
            ['nombre' => 'Matemáticas V', 'semestre' => 5],
            ['nombre' => 'Geografía', 'semestre' => 5],
            ['nombre' => 'Historia Universal Contemporánea', 'semestre' => 5],
            ['nombre' => 'Administración I', 'semestre' => 5],
            ['nombre' => 'Psicología I', 'semestre' => 5],
            ['nombre' => 'Derecho I', 'semestre' => 5],
            ['nombre' => 'Etimologías Grecolatinas I', 'semestre' => 5],
            ['nombre' => 'Sistemas de Información', 'semestre' => 5],
            ['nombre' => 'Programación', 'semestre' => 5],
            ['nombre' => 'Tutorías V', 'semestre' => 5],
            ['nombre' => 'Paraescolares V', 'semestre' => 5],

            // SEXTO SEMESTRE
            ['nombre' => 'Filosofía', 'semestre' => 6],
            ['nombre' => 'Ecología y Medio Ambiente', 'semestre' => 6],
            ['nombre' => 'Estructura Socioeconómica de México', 'semestre' => 6],
            ['nombre' => 'Administración II', 'semestre' => 6],
            ['nombre' => 'Psicología II', 'semestre' => 6],
            ['nombre' => 'Derecho II', 'semestre' => 6],
            ['nombre' => 'Etimologías Grecolatinas II', 'semestre' => 6],
            ['nombre' => 'Páginas web', 'semestre' => 6],
            ['nombre' => 'Diseño Digital', 'semestre' => 6],
            ['nombre' => 'Tutorías VI', 'semestre' => 6],
            ['nombre' => 'Paraescolares VI', 'semestre' => 6],
        ];

   
     
foreach ($materias as $materia) {
    $registro = Materia::where('nombre', $materia['nombre'])
        ->where('semestre', $materia['semestre'])
        ->first();

    if ($registro) {
        // Si ya existe, no lo duplicamos ni sobrescribimos.
        continue;
    }

    $clave = 'COBAY-' . $materia['semestre'] . '-' .
        substr(
            sha1($materia['nombre']),
            0,
            8
        );
    Materia::create([
        'clave' => $clave,
        'nombre' => $materia['nombre'],
        'semestre' => $materia['semestre'],
        'horas_semana' => 0,
        'descripcion' => null,
        'activa' => true,
    ]);
}

}

}