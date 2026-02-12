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
        Schema::create('semestre_materia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('semestre_id');
            $table->unsignedBigInteger('materia_id');
            $table->timestamps();

            $table->unique(['semestre_id', 'materia_id']); // evita duplicados
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semestre_materia');
    }
};
