<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvidenciaUnidad extends Model
{
    protected $table = 'evidencia_unidades';

    protected $fillable = [

        'evidencia_id',
        'unidad',

        'documentos',

        'evaluacion',

    ];

    protected $casts = [

        'documentos' => 'array',

        'evaluacion' => 'array',

    ];

    public function evidencia()
    {
        return $this->belongsTo(
            Evidencia::class,
            'evidencia_id'
        );
    }
}
