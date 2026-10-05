<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('calificaciones', function (Blueprint $table) {
            $table->id();

            // Alumno que recibe la calificación
            $table->foreignId('alumno_id')
                ->constrained('alumnos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Materia, docente y grupo asignados
            $table->foreignId('asignacion_materia_id')
                ->constrained('asignaciones_materias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Periodo de evaluación
            $table->foreignId('periodo_evaluacion_id')
                ->constrained('periodos_evaluacion')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Calificación obtenida
            $table->decimal('calificacion', 5, 2);

            $table->timestamps();

            // Evita registrar dos veces la misma calificación
            // para el mismo alumno, materia y periodo.
            $table->unique(
                [
                    'alumno_id',
                    'asignacion_materia_id',
                    'periodo_evaluacion_id'
                ],
                'calificacion_unica'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('calificaciones');
    }
};