<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AsignarMaterias extends Controller
{
    public function index(){
        $titulo = 'Asignar Materias';

        return view('modules.asignar-materias.index', compact('titulo'));
    }

    public function create(){
        $titulo = 'Asignar Docente';

        return view('modules.asignar-materias.create', compact('titulo'));
    }
}
