<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropColumn([
                'horas_semana',
                'activa',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->unsignedTinyInteger('horas_semana')->nullable();
            $table->boolean('activa')->default(true);
        });
    }
};