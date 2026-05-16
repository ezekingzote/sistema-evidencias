<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ponderacion extends Model
{
    use HasFactory;
    protected $table = 'ponderaciones';
    protected $fillable = [
        'materia_id',
        'unidad',
        'actividad',
        'porcentaje',
        'instrumento'
    ];
    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }
}