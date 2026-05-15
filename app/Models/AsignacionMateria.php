<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $materia_id
 * @property int $docente_id
 * @property int $semestre_id
 * @property string $grupo
 * @property string $alumnos
 * @property int $activo
 * @property int $asignada
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $docente
 * @property-read \App\Models\Materia $materia
 * @property-read \App\Models\Semestre $semestre
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereAlumnos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereAsignada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereDocenteId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereGrupo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereMateriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereSemestreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionMateria whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AsignacionMateria extends Model
{
    use HasFactory;

    protected $table = 'asignacion_materias';

    protected $fillable = [
        'materia_id',
        'docente_id',
        'semestre_id',
        'grupo',
        'alumnos',
        'activo'
    ];



    public function materia()
    {
        return $this->belongsTo(Materia::class, 'materia_id');
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'asignacion_materias', 'docente_id', 'materia_id');
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
