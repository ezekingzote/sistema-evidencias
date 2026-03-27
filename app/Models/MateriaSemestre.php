<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $materia_id
 * @property int $semestre_id
 * @property int $asignada
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MateriaSemestre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MateriaSemestre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MateriaSemestre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MateriaSemestre whereAsignada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MateriaSemestre whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MateriaSemestre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MateriaSemestre whereMateriaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MateriaSemestre whereSemestreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MateriaSemestre whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MateriaSemestre extends Model
{
    use HasFactory;

    protected $table = 'materias_semestres';

    protected $fillable = [
        'materia_id',
        'semestre_id',
    ];
}
