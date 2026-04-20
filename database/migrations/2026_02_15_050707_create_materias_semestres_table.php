<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('materias_semestres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('materia_id')->constrained('materias')->onDelete('cascade');
            $table->foreignId('semestre_id')->constrained('semestres')->onDelete('cascade');
            $table->boolean('asignada')->default(0);
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materias_semestres');
    }
};
