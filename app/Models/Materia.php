<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'materias';
    public function semestres()
    {
        return $this->belongsToMany(\App\Models\Semestre::class, 'semestre_materia', 'materia_id', 'semestre_id');
    }
}
