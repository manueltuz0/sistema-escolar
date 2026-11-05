<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Materia;
use App\Models\Docente;
use App\Models\Grupo;
use App\Models\CicloEscolar;
use App\Models\AsignacionMateria;

class AsignacionMateriaSeeder extends Seeder
{
    public function run(): void
    {
        $ciclo = CicloEscolar::where('activo', true)->first();

        if (!$ciclo) {
            throw new \RuntimeException(
                'No existe un ciclo escolar activo.'
            );
        }

        // Docente responsable de cada materia.
        // Las claves son los nombres exactos del catálogo.
        $responsables = [
            'Matemáticas I' => 20,
            'Matemáticas II' => 20,
            'Matemáticas III' => 20,
            'Matemáticas IV' => 20,
            'Matemáticas V' => 20,

            'Química I' => 21,
            'Química II' => 21,
            'Biología I' => 21,
            'Biología II' => 21,
            'Ecología y Medio Ambiente' => 21,

            'Inglés I' => 22,
            'Inglés II' => 22,
            'Inglés III' => 22,
            'Inglés IV' => 22,

            'Informática I' => 23,
            'Informática II' => 23,
            'Gestión de Archivos de Texto' => 23,
            'Hoja de Cálculo Aplicado' => 23,
            'Comunidades Virtuales' => 23,
            'Mantenimiento y Redes de Cómputo' => 23,
            'Programación' => 23,
            'Sistemas de Información' => 23,
            'Páginas web' => 23,
            'Diseño Digital' => 23,

            'Física I' => 24,
            'Física II' => 24,

            'Historia de México I' => 25,
            'Historia de México II' => 25,
            'Geografía' => 25,
            'Historia Universal Contemporánea' => 25,

            'Taller de Lectura y Redacción I' => 26,
            'Taller de Lectura y Redacción II' => 26,
            'Literatura I' => 26,
            'Literatura II' => 26,

            'Ética I' => 27,
            'Ética II' => 27,
            'Filosofía' => 27,

            'Metodología de la Investigación' => 28,
            'Introducción a las Ciencias Sociales' => 28,
            'Estructura Socioeconómica de México' => 28,

            'Administración I' => 29,
            'Administración II' => 29,

            'Psicología I' => 30,
            'Psicología II' => 30,
            'Tutorías I' => 30,
            'Tutorías II' => 30,
            'Tutorías III' => 30,
            'Tutorías IV' => 30,
            'Tutorías V' => 30,
            'Tutorías VI' => 30,

            'Derecho I' => 31,
            'Derecho II' => 31,
            'Etimologías Grecolatinas I' => 31,
            'Etimologías Grecolatinas II' => 31,

            'Paraescolares I' => 32,
            'Paraescolares II' => 32,
            'Paraescolares III' => 32,
            'Paraescolares IV' => 33,
            'Paraescolares V' => 33,
            'Paraescolares VI' => 33,
        ];

        // Comprobar docentes y materias antes de insertar.
        foreach ($responsables as $nombreMateria => $docenteId) {
            $docente = Docente::find($docenteId);

            if (!$docente || !$docente->activo) {
                throw new \RuntimeException(
                    "El docente ID {$docenteId} no existe o está inactivo."
                );
            }

            $materiaExiste = Materia::where(
                'nombre',
                $nombreMateria
            )->exists();

            if (!$materiaExiste) {
                throw new \RuntimeException(
                    "No se encontró la materia: {$nombreMateria}"
                );
            }
        }

        // Comprobar que todas las materias tengan responsable.
        $materias = Materia::where('activa', true)->get();

        foreach ($materias as $materia) {
            if (!isset($responsables[$materia->nombre])) {
                throw new \RuntimeException(
                    "La materia {$materia->nombre} no tiene docente asignado."
                );
            }
        }

        // Crear las asignaciones para los grupos del ciclo activo.
        DB::transaction(function () use ($ciclo, $responsables) {
            $grupos = Grupo::where(
                'ciclo_escolar_id',
                $ciclo->id
            )->get();

            foreach ($grupos as $grupo) {
                foreach ($responsables as $nombreMateria => $docenteId) {
                    $materia = Materia::where(
                        'nombre',
                        $nombreMateria
                    )->first();

                    // El grado del grupo debe coincidir con
                    // el semestre de la materia.
                    if ((int) $grupo->grado !== (int) $materia->semestre) {
                        continue;
                    }

                    AsignacionMateria::firstOrCreate(
                        [
                            'docente_id' => $docenteId,
                            'materia_id' => $materia->id,
                            'grupo_id' => $grupo->id,
                            'ciclo_escolar_id' => $ciclo->id,
                        ]
                    );
                }
            }
        });

        $this->command->info(
            'Asignaciones de materias creadas correctamente.'
        );
    }
}
