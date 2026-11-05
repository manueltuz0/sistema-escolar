<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimientos_prestamos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('prestamo_equipo_id')
                ->nullable()
                ->constrained('prestamos_equipos')
                ->nullOnDelete();

            $table->foreignId('reservacion_equipo_id')
                ->nullable()
                ->constrained('reservaciones_equipos')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('tipo_movimiento', 50);
            $table->string('estado_anterior', 30)->nullable();
            $table->string('estado_nuevo', 30)->nullable();

            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index(['tipo_movimiento', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_prestamos');
    }
};
