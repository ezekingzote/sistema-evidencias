<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property string $clave
 * @property int $unidades
 * @property int $semestre
 * @property string $carrera
 * @property int $activo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AsignacionMateria> $asignaciones
 * @property-read int|null $asignaciones_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Semestre> $semestres
 * @property-read int|null $semestres_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereCarrera($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereClave($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereSemestre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereUnidades($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Materia whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Materia extends Model
{
    protected $table = 'materias';

    public function semestres()
    {
        return $this->belongsToMany(Semestre::class, 'materias_semestres')
            ->withPivot('asignada')
            ->withTimestamps();
    }


    public function asignaciones()
    {
        return $this->hasMany(AsignacionMateria::class, 'materia_id');
    }
}
