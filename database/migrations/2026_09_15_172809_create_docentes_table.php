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
    Schema::create('docentes', function (Blueprint $table) {
        $table->id();
        $table->string('numero_empleado', 20)->unique();
        $table->string('nombres', 100);
        $table->string('apellidos', 150);
        $table->string('email', 150)->unique();
        $table->string('telefono', 20)->nullable();
        $table->string('especialidad', 100)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
