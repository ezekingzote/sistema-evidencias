<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $table = 'docentes';
    protected $fillable = [
        'user_id',
        'celular',
        'departamento',
        'cargo',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'integer',
        ];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'asignacion_materias', 'docente_id', 'materia_id')
            ->withPivot('grupo', 'alumnos', 'activo');
    }
}