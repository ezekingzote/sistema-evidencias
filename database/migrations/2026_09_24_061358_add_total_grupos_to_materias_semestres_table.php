<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materias_semestres', function (Blueprint $table) {
            $table->unsignedTinyInteger('total_grupos')
                ->nullable()
                ->default(null)
                ->after('asignada')
                ->comment('Número total de grupos definidos para esta materia en el semestre. null = aún no definido.');
        });
    }

    public function down(): void
    {
        Schema::table('materias_semestres', function (Blueprint $table) {
            $table->dropColumn('total_grupos');
        });
    }
};
