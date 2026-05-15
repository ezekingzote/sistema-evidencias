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
        Schema::create('revision_materia', function (Blueprint $table) {

            $table->id();

            $table->foreignId('revision_id')
                ->constrained('revisiones')
                ->cascadeOnDelete();

            $table->foreignId('materia_id')
                ->constrained('materias')
                ->cascadeOnDelete();

            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('revision_materia');
    }
};