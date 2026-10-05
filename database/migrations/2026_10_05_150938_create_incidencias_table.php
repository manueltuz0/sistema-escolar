<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();

            // Alumno relacionado
            $table->foreignId('alumno_id')
                ->constrained('alumnos')
                ->cascadeOnDelete();

            // Información de la incidencia
            $table->date('fecha');

            $table->string('tipo', 100);

            $table->text('descripcion');

            $table->enum('prioridad', [
                'Baja',
                'Media',
                'Alta'
            ])->default('Media');

            $table->enum('estado', [
                'Pendiente',
                'En seguimiento',
                'Atendida',
                'Concluida'
            ])->default('Pendiente');

            $table->string('lugar', 150)->nullable();

            $table->text('acciones_realizadas')->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incidencias');
    }
};