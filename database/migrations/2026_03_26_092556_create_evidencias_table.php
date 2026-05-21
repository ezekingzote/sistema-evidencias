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

            $table->foreignId('asignacion_materia_id')
                ->constrained('asignacion_materias')
                ->onDelete('cascade');

            $table->foreignId('materia_id')
                ->constrained('materias')
                ->onDelete('cascade');

            $table->foreignId('revision_id')
                ->constrained('revisiones')
                ->onDelete('cascade');

            $table->string('doc_a')->nullable()->comment('Instrumentación didáctica');
            $table->string('doc_b')->nullable()->comment('Lista de calificaciones');
            $table->string('doc_c')->nullable()->comment('Reporte y acuerdos');
            $table->string('evi_a')->nullable()->comment('Muestra de tareas');
            $table->string('evi_b')->nullable()->comment('Rúbricas utilizadas');
            $table->string('evi_c')->nullable()->comment('Examen diagnóstico');

            $table->tinyInteger('estado')
                ->default(3)
                ->comment('0=inactiva,1=asignada,2=aprobada,3=pendiente,4=rechazada');

            $table->text('observaciones')
                ->nullable()
                ->comment('Observaciones del administrador');

            $table->foreignId('admin_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete()
                ->comment('Administrador que revisó la evidencia');

            $table->dateTime('fecha_revision')
                ->nullable()
                ->comment('Fecha en que el administrador revisó la evidencia');

            $table->unique(
                ['asignacion_materia_id', 'revision_id'],
                'evidencia_asignacion_revision_unique'
            );

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
