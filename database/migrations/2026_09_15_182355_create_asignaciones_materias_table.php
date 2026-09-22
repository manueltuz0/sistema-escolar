<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('asignaciones_materias', function (Blueprint $table) {
        $table->id();

        $table->foreignId('docente_id')
            ->constrained('docentes')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->foreignId('materia_id')
            ->constrained('materias')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->foreignId('grupo_id')
            ->constrained('grupos')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->foreignId('ciclo_escolar_id')
            ->constrained('ciclos_escolares')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->timestamps();

$table->unique(
    [
        'docente_id',
        'materia_id',
        'grupo_id',
        'ciclo_escolar_id'
    ],
    'asig_mat_unica'
);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignaciones_materias');
    }
};
