<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidencia_unidades', function (Blueprint $table) {

            $table->id();

            $table->foreignId('evidencia_id')
                ->constrained('evidencias')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('unidad');

            $table->json('documentos')->nullable();

            $table->json('evaluacion')->nullable();

            $table->timestamps();

            $table->unique(
                ['evidencia_id', 'unidad'],
                'evidencia_unidad_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidencia_unidades');
    }
};