<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notificaciones_citatorios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('citatorio_id')
                ->constrained('citatorios')
                ->cascadeOnDelete();

            $table->string('medio', 30)->default('WhatsApp');
            $table->string('telefono', 20);
            $table->text('mensaje');

            $table->string('estado', 30)->default('Preparado');

            $table->timestamp('fecha_intento')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notificaciones_citatorios');
    }
};
