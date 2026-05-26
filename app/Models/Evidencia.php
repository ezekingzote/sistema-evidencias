<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'asignacion_materia_id',
        'materia_id',
        'revision_id',
        'doc_a',
        'doc_b',
        'doc_c',
        'evi_a',
        'evi_b',
        'evi_c',
        'estado',
        'observaciones',
        'admin_id',
        'fecha_revision',
    ];

    public function revision()
    {
        return $this->belongsTo(Revision::class);
    }

    public function asignacion()
    {
        return $this->belongsTo(AsignacionMateria::class, 'asignacion_materia_id');
    }
}