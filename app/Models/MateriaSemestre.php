<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MateriaSemestre extends Model
{
    use HasFactory;

    protected $table = 'materias_semestres';

    protected $fillable = [
        'materia_id',
        'semestre_id',
    ];
}
