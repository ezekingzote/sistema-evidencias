<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeguimientoAcademico extends Controller
{
    public function index()
    {
        $titulo = 'Seguimiento Academico';

        return view('modules.seguimiento-academico.index', compact('titulo'));
    }
}