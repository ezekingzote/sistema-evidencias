<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Evidencias extends Controller
{
    public function index(){
        $titulo = 'Evidencias';

        return view('modules.evidencias.index', compact('titulo'));
    }

    public function indexDocente(){
        $titulo = 'Evidencias';

        return view('modules.evidencias.indexDocente', compact('titulo'));
    }

    public function review(){
        $titulo = 'Revisar Evidencia';

        return view('modules.evidencias.review', compact('titulo'));
    }
}
