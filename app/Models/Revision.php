<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $nombre
 * @property int $numero
 * @property int $activo
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereActivo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereNumero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Revision whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Revision extends Model
{
    protected $table = 'revisiones';

    protected $fillable = [
        'nombre',
        'numero',
        'activo'
    ];

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }
}
