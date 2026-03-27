<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{

    protected $fillable = [
        'docente_id',
        'revision_id',
        'carpeta_documentos',
        'carpeta_evidencias'
    ];

}
