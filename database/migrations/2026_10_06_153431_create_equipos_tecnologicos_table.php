<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear tabla de equipos tecnológicos.
     */
    public function up(): void
    {
        Schema::create('equipos_tecnologicos', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Identificación del equipo
            |--------------------------------------------------------------------------
            */

            $table->string('codigo', 30)
                ->unique();

            $table->string('tipo', 50);

            $table->string('marca', 100)
                ->nullable();

            $table->string('modelo', 100)
                ->nullable();

            $table->string('numero_serie', 100)
                ->nullable()
                ->unique();


            /*
            |--------------------------------------------------------------------------
            | Estado y ubicación
            |--------------------------------------------------------------------------
            */

            $table->enum('estado', [
                'Disponible',
                'Prestado',
                'Mantenimiento',
                'Baja'
            ])->default('Disponible');

            $table->string('ubicacion', 100)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Información adicional
            |--------------------------------------------------------------------------
            */

            $table->text('observaciones')
                ->nullable();

            $table->timestamps();

        });
    }


    /**
     * Eliminar tabla.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos_tecnologicos');
    }
};