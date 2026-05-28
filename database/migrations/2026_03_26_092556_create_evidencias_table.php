<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidencias', function (Blueprint $table) {

            $table->id();

            // 🔗 RELACIONES
            $table->foreignId('asignacion_materia_id')
                ->constrained('asignacion_materias')
                ->onDelete('cascade');

            $table->foreignId('materia_id')
                ->constrained('materias')
                ->onDelete('cascade');

            $table->foreignId('revision_id')
                ->constrained('revisiones')
                ->onDelete('cascade');

            // 📦 NUEVO CAMPO CENTRAL
            $table->json('documentos')
                ->nullable()
                ->comment('Contiene documentos y evidencias organizadas en estructura JSON');

            // 📊 CONTROL DE ESTADO
            $table->tinyInteger('estado')
                ->default(3)
                ->comment('0=inactiva,1=asignada,2=aprobada,3=pendiente,4=rechazada');

            // 📝 OBSERVACIONES
            $table->text('observaciones')->nullable();

            // 👨‍💼 ADMIN
            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->dateTime('fecha_revision')->nullable();

            // 🔒 RESTRICCIÓN ÚNICA
            $table->unique(
                ['asignacion_materia_id', 'revision_id'],
                'evidencia_asignacion_revision_unique'
            );

            $table->json('evaluacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};
