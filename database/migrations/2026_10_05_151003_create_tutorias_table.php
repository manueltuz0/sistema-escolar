<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutorias', function (Blueprint $table) {
            $table->id();

            // Alumno atendido
            $table->foreignId('alumno_id')
                ->constrained('alumnos')
                ->cascadeOnDelete();

            // Puede estar relacionada con una incidencia
            $table->foreignId('incidencia_id')
                ->nullable()
                ->constrained('incidencias')
                ->nullOnDelete();

            // Información de la tutoría
            $table->date('fecha');

            $table->string('tipo', 100);

            $table->string('motivo', 255);

            $table->text('situacion')->nullable();

            $table->text('acuerdos')->nullable();

            $table->text('compromisos_alumno')->nullable();

            $table->text('compromisos_tutor')->nullable();

            $table->date('fecha_seguimiento')->nullable();

            $table->enum('estado', [
                'Pendiente',
                'En seguimiento',
                'Concluida'
            ])->default('Pendiente');

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutorias');
    }
};