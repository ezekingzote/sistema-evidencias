<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'materia_id',
        'revision_id',
        'doc_a',
        'doc_b',
        'doc_c',
        'evi_a',
        'evi_b',
        'evi_c',
    ];
}