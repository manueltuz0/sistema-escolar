<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seguimientos_tutorias', function (Blueprint $table) {
            $table->id();

            // Atención individual a la que pertenece el seguimiento
            $table->foreignId('tutoria_id')
                ->constrained('tutorias')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // Fecha programada para revisar el caso
            $table->date('fecha_programada');

            // Fecha en que se realizó realmente
            $table->date('fecha_realizada')->nullable();

            // Resultado de la revisión
            $table->text('resultado')->nullable();

            // Acuerdos o acciones posteriores
            $table->text('acuerdos')->nullable();

            // Estado del seguimiento
            $table->enum('estado', [
                'Pendiente',
                'Realizado',
                'Cancelado'
            ])->default('Pendiente');

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(
                ['tutoria_id', 'estado'],
                'seguimientos_tutoria_estado'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seguimientos_tutorias');
    }
};
