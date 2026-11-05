<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('actividades_tutorias', function (Blueprint $table) {
            $table->id();

            // Responsable de registrar la actividad
            $table->foreignId('docente_id')
                ->constrained('docentes')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Grupo al que se dirige la actividad
            $table->foreignId('grupo_id')
                ->constrained('grupos')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // Ciclo escolar correspondiente
            $table->foreignId('ciclo_escolar_id')
                ->constrained('ciclos_escolares')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('fecha');

            $table->string('tema', 150);

            $table->string('tipo', 100);

            $table->text('descripcion')->nullable();

            $table->text('observaciones')->nullable();

            $table->timestamps();

            // Facilita consultar actividades por grupo y fecha
            $table->index(
                ['grupo_id', 'fecha'],
                'act_tutorias_grupo_fecha'
            );

            // Facilita consultar actividades por docente y ciclo
            $table->index(
                ['docente_id', 'ciclo_escolar_id'],
                'act_tutorias_docente_ciclo'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('actividades_tutorias');
    }
};
