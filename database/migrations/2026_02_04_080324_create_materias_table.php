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
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('clave', 50);
            $table->unsignedInteger('unidades');
            $table->unsignedInteger('semestre');
            $table->string('carrera', 100);
            $table->boolean('activo')->default(false);
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};
