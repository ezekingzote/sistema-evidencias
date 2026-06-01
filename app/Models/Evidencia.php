<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    protected $table = 'evidencias';

    protected $fillable = [

        'asignacion_materia_id',
        'materia_id',
        'revision_id',

        'documentos',

        'estado',
        'observaciones',

        'admin_id',
        'fecha_revision',

        'evaluacion',

        'pdf_generado',

    ];

    protected $casts = [

        'documentos' => 'array',

        'evaluacion' => 'array',

    ];

    // =====================================
    // RELACIONES
    // =====================================

    public function materia()
    {
        return $this->belongsTo(Materia::class);
    }

    public function revision()
    {
        return $this->belongsTo(Revision::class);
    }

    public function asignacionMateria()
    {
        return $this->belongsTo(
            AsignacionMateria::class,
            'asignacion_materia_id'
        );
    }

    public function asignacion()
    {
        return $this->belongsTo(AsignacionMateria::class, 'asignacion_materia_id');
    }
}
