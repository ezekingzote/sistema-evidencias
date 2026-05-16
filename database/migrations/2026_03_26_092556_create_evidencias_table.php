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
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('revision_id')->constrained('revisiones')->onDelete('cascade');
            $table->string('doc_a')->nullable()->comment('Instrumentación didáctica');
            $table->string('doc_b')->nullable()->comment('Lista de calificaciones');
            $table->string('doc_c')->nullable()->comment('Reporte y acuerdos');
            $table->string('evi_a')->nullable()->comment('Muestra de tareas');
            $table->string('evi_b')->nullable()->comment('Rúbricas utilizadas');
            $table->string('evi_c')->nullable()->comment('Examen diagnóstico');
            $table->unique(['materia_id', 'revision_id'], 'evidencia_materia_revision_unique');
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};
