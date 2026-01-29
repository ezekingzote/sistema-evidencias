<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Evidencias extends Controller
{
    ##Funciones para panel de admin
    public function index()
    {
        $titulo = 'Evidencias';

        return view('modules.evidencias.index', compact('titulo'));
    }


    public function review()
    {
        $titulo = 'Revisar Evidencia';

        return view('modules.evidencias.review', compact('titulo'));
    }

    ##Funciones para panel Docente
    public function indexDocente()
    {
        $titulo = 'Evidencias Docente';

        return view('modules.evidencias.indexDocente', compact('titulo'));
    }
    public function agregarEvidencia()
    {
        $titulo = 'Agregar Nueva Evidencia';

        return view('modules.evidencias.create', compact('titulo'));
    }
}
