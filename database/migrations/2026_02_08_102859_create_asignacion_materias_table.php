<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asignacion_materias', function (Blueprint $table) {
            $table->id();

            // ─── Relaciones ────────────────────────────────────────────
            $table->foreignId('materia_id')
                ->constrained('materias')
                ->cascadeOnDelete();

            // ⚠️ Apunta a 'docentes' porque el modelo AsignacionMateria
            //    usa Docente::class y el controlador envía $docente->id
            $table->foreignId('docente_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('semestre_id')
                ->constrained('semestres')
                ->cascadeOnDelete();

            // ─── Datos del grupo ───────────────────────────────────────
            // Ej: "SIS-5"  (grupo único)  o  "SIS-5-A"  (varios grupos)
            $table->string('grupo', 20);

            $table->unsignedSmallInteger('alumnos')->default(1);

            // ─── Estado ────────────────────────────────────────────────
            $table->boolean('activo')->default(true);
            $table->boolean('asignada')->default(false);

            // ─── Timestamps estándar ───────────────────────────────────
            $table->timestamps();

            // ─── Restricciones e índices ───────────────────────────────
            $table->unique(
                ['materia_id', 'semestre_id', 'grupo'],
                'asignacion_unica_grupo'
            );

            $table->index('docente_id', 'idx_asig_docente');
            $table->index(
                ['semestre_id', 'materia_id', 'activo'],
                'idx_asig_sem_mat_act'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asignacion_materias');
    }
};
