<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->foreignId('aula_id')
                ->nullable()
                ->after('asignacion_materia_id')
                ->constrained('aulas')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('horarios', function (Blueprint $table) {
            $table->dropForeign(['aula_id']);
            $table->dropColumn('aula_id');
        });
    }
};
