<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('responsables_alumnos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumno_id')
                ->constrained('alumnos')
                ->cascadeOnDelete();

            $table->string('nombre', 150);
            $table->string('parentesco', 30);
            $table->string('email', 150)->nullable();
            $table->string('telefono', 20);
            $table->boolean('es_principal')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('responsables_alumnos');
    }
};
