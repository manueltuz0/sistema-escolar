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
    Schema::create('grupos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre', 20);
        $table->unsignedTinyInteger('grado');
        $table->string('especialidad', 100)->nullable();

        $table->foreignId('ciclo_escolar_id')
            ->constrained('ciclos_escolares')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
