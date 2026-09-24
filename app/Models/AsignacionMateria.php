<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionMateria extends Model
{
    use HasFactory;

    protected $table = 'asignacion_materias';

    protected $fillable = [
        'materia_id',
        'docente_id',
        'semestre_id',
        'grupo',
        'alumnos',
        'activo'
    ];

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'asignacion_materias', 'docente_id', 'materia_id');
    }

    // ✅ Ahora apunta a User, no a Docente
    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'semestre_id');
    }

    public function evidencias()
    {
        return $this->hasMany(Evidencia::class, 'asignacion_materia_id');
    }
}