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

            $table->foreignId('materia_id')->constrained()->cascadeOnDelete();
            $table->foreignId('docente_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('semestre_id')->constrained()->cascadeOnDelete();

            $table->string('grupo', 20);
            $table->string('alumnos', 20);

            $table->boolean('activo')->default(1);
            $table->boolean('asignada')->default(0);

            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    public function down()
    {
        Schema::table('asignacion_materias', function (Blueprint $table) {
            $table->dropForeign(['docente_id']);
            $table->dropColumn('docente_id');
        });
    }
};
