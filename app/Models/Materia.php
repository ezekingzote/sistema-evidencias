<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'materias';

    public function semestres()
    {
        return $this->belongsToMany(Semestre::class, 'materias_semestres')
            ->withPivot('asignada')
            ->withTimestamps();
    }


    public function asignaciones()
    {
        return $this->hasMany(AsignacionMateria::class, 'materia_id');
    }
}
