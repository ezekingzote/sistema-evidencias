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
        'documentos',
        'evidencias',
        'estado',
        'observaciones',
        'admin_id',
        'fecha_revision',
    ];

    protected $casts = [
        'documentos' => 'array',
        'evidencias' => 'array',
        'evaluacion' => 'array',
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
