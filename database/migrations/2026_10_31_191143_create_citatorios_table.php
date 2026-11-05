
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('citatorios', function (Blueprint $table) {
            $table->id();

            // Alumno al que pertenece el citatorio
            $table->foreignId('alumno_id')
                ->constrained('alumnos')
                ->cascadeOnDelete();

            // Responsable relacionado (referencia opcional)
            $table->foreignId('responsable_alumno_id')
                ->nullable()
                ->constrained('responsables_alumnos')
                ->nullOnDelete();

            // Copia de los datos del responsable
            $table->string('responsable_nombre', 150);
            $table->string('responsable_parentesco', 30);
            $table->string('responsable_email', 150)->nullable();
            $table->string('responsable_telefono', 20);

            // Información del citatorio
            $table->text('motivo');
            $table->date('fecha_emision');
            $table->date('fecha_cita');
            $table->time('hora_cita');
            $table->text('observaciones')->nullable();

            // Estado del citatorio
            $table->string('estado', 30)->default('Pendiente');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('citatorios');
    }
};
