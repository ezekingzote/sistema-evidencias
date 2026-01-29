<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Docentes extends Controller
{
    public function index(){
        $titulo = 'Docentes';

        return view('modules.docentes.index', compact('titulo'));
    }

    public function create(){
        $titulo = 'Crear Docente';

        return view('modules.docentes.create', compact('titulo'));
    }
}
