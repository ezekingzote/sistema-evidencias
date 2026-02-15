<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $table = 'semestres';

    protected $fillable = [
        'nombre',
        'anio',
        'periodo',
        'fecha_inicio',
        'fecha_fin',
        'activo',
        'materias_activas',
        'materias_asignadas',
        'materias_por_asignar',
        'ids_materias_activas'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean'
    ];

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'materias_semestres')
            ->withPivot('asignada')
            ->withTimestamps();
    }
}
