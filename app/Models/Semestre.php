<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property string $anio
 * @property int $periodo
 * @property \Illuminate\Support\Carbon $fecha_inicio
 * @property \Illuminate\Support\Carbon $fecha_fin
 * @property bool $activo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Materia> $materias
 * @property-read int|null $materias_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereAnio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereFechaFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereFechaInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre wherePeriodo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Semestre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Semestre extends Model
{
    protected $table = 'semestres';

    protected $fillable = [
        'nombre',
        'anio',
        'periodo',
        'fecha_inicio',
        'fecha_fin',
        'activo',
        'materias_activas',
        'materias_asignadas',
        'materias_por_asignar',
        'ids_materias_activas'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean'
    ];

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'materias_semestres')
            ->withPivot('asignada')
            ->withTimestamps();
    }
    
    public function revisiones()
    {
        return $this->hasMany(Revision::class);
    }
}
