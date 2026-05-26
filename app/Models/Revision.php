<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Revision extends Model
{
    protected $table = 'revisiones';

    protected $fillable = [
        'nombre',
        'numero',
        'activo',
        'semestre_id',
        'fecha_limite'
    ];

    protected $casts = [
        'activo' => 'boolean',
        'fecha_limite' => 'date'
    ];

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function haExpirado(): bool
    {
        if (!$this->fecha_limite) {
            return false;
        }

        return Carbon::today()->gt($this->fecha_limite);
    }
}