<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear tabla de préstamos de equipos.
     */
    public function up(): void
    {
        Schema::create('prestamos_equipos', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Equipo prestado
            |--------------------------------------------------------------------------
            */

            $table->foreignId('equipo_id')
                ->constrained('equipos_tecnologicos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Fecha y hora del préstamo
            |--------------------------------------------------------------------------
            */

            $table->date('fecha_prestamo');

            $table->time('hora_prestamo');


            /*
            |--------------------------------------------------------------------------
            | Persona que solicita
            |--------------------------------------------------------------------------
            */

            $table->foreignId('docente_id')
                ->nullable()
                ->constrained('docentes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('alumno_id')
                ->nullable()
                ->constrained('alumnos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();


            /*
            |--------------------------------------------------------------------------
            | Información académica
            |--------------------------------------------------------------------------
            */

            $table->foreignId('materia_id')
                ->nullable()
                ->constrained('materias')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->unsignedTinyInteger('semestre')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Devolución
            |--------------------------------------------------------------------------
            */

            $table->date('fecha_devolucion')
                ->nullable();

            $table->time('hora_devolucion')
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Estado del préstamo
            |--------------------------------------------------------------------------
            */

            $table->enum('estado', [
                'Prestado',
                'Devuelto',
                'Atrasado'
            ])->default('Prestado');


            /*
            |--------------------------------------------------------------------------
            | Condición del equipo
            |--------------------------------------------------------------------------
            */

            $table->string('condicion_entrega', 100)
                ->nullable();

            $table->string('condicion_devolucion', 100)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Responsables
            |--------------------------------------------------------------------------
            */

            $table->string('responsable_entrega', 150)
                ->nullable();

            $table->string('responsable_recepcion', 150)
                ->nullable();


            /*
            |--------------------------------------------------------------------------
            | Observaciones
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
        Schema::dropIfExists('prestamos_equipos');
    }
};