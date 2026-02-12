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
        'activo'
    ];

    /**
     * RELACIONES: Esto es lo más importante para mostrar nombres 
     * en lugar de solo IDs en tu lista (Index).
     */


    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function docente()
    {
        return $this->belongsTo(User::class, 'docente_id');
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class, 'semestre_id');
    }
}
