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
        Schema::create('semestres', function (Blueprint $table) {

            $table->id();

            // nombre ejemplo: 2026-1
            $table->string('nombre');

            // año ejemplo: 2026
            $table->year('anio');

            // 1 = ENE-JUN
            // 2 = AGO-DIC
            $table->tinyInteger('periodo');

            // fechas del semestre
            $table->date('fecha_inicio');
            $table->date('fecha_fin');

            // estado del semestre
            $table->boolean('activo')->default(false);

            // contadores de materias
            $table->integer('materias_activas')->default(0);
            $table->integer('materias_asignadas')->default(0);
            $table->integer('materias_por_asignar')->default(0);

            $table->text('ids_materias_activas')->nullable()->after('materias_por_asignar');

            $table->timestamps();

            // solo permitir un periodo por año
            $table->unique(['anio', 'periodo']);

        });
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semestres');
    }
};
