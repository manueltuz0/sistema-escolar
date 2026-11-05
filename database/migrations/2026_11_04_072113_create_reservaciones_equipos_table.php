<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservaciones_equipos', function (Blueprint $table) {
            $table->id();

            // Equipo solicitado
            $table->foreignId('equipo_id')
                ->constrained('equipos_tecnologicos')
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            // Solicitante: docente o alumno
            $table->foreignId('docente_id')
                ->nullable()
                ->constrained('docentes')
                ->nullOnDelete();

            $table->foreignId('alumno_id')
                ->nullable()
                ->constrained('alumnos')
                ->nullOnDelete();

            // Información académica
            $table->foreignId('materia_id')
                ->nullable()
                ->constrained('materias')
                ->nullOnDelete();

            $table->unsignedTinyInteger('semestre')->nullable();

            // Periodo solicitado
            $table->date('fecha_inicio');
            $table->time('hora_inicio');
            $table->date('fecha_fin');
            $table->time('hora_fin');

            // Estado de la reservación
            $table->string('estado', 20)->default('Pendiente');

            // Usuario que realizó la solicitud
            $table->foreignId('solicitado_por_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Usuario que autorizó o rechazó
            $table->foreignId('autorizado_por_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('autorizado_at')->nullable();

            // Cancelación
            $table->foreignId('cancelado_por_user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('cancelado_at')->nullable();

            // Enlace al préstamo cuando se entregue el equipo
            $table->foreignId('prestamo_equipo_id')
                ->nullable()
                ->unique()
                ->constrained('prestamos_equipos')
                ->nullOnDelete();

            $table->text('observaciones')->nullable();
            $table->text('motivo_rechazo')->nullable();
            $table->text('motivo_cancelacion')->nullable();

            $table->timestamps();

            // Índices para consultar disponibilidad
            $table->index(['equipo_id', 'fecha_inicio', 'fecha_fin']);
            $table->index(['estado', 'fecha_inicio']);
            $table->index(['alumno_id', 'fecha_inicio']);
            $table->index(['docente_id', 'fecha_inicio']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservaciones_equipos');
    }
};
