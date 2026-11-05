<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividad_tutoria_alumno', function (Blueprint $table) {
            $table->id();

            // Actividad grupal a la que pertenece el alumno
            $table->foreignId('actividad_tutoria_id')
                ->constrained('actividades_tutorias')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Alumno participante
            $table->foreignId('alumno_id')
                ->constrained('alumnos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Control de asistencia
            $table->enum('asistencia', [
                'Presente',
                'Ausente',
                'Justificado'
            ])->default('Presente');

            // Observación particular del participante
            $table->text('observaciones')->nullable();

            $table->timestamps();

            // Evita registrar dos veces al mismo alumno
            // en una misma actividad
            $table->unique(
                ['actividad_tutoria_id', 'alumno_id'],
                'actividad_alumno_unica'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividad_tutoria_alumno');
    }
};
