<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Materias extends Controller
{
    public function index()
    {
        $titulo = 'Materias';

        return view('modules.materias.index', compact('titulo'));
    }


    public function misMaterias()
    {
        $titulo = 'Agregar Docente';

        return view('modules.materias.misMaterias', compact('titulo'));
    }
}
