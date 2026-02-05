<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    protected $table = 'semestres';
    public function materias()
    {
        return $this->belongsToMany(Materia::class);
    }
    protected $fillable = [
        'nombre',
        'anio',
        'carrera'
    ];
}
