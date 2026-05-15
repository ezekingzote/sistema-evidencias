<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlanesEstudio extends Controller
{
    public function index(){
        $titulo = 'Mis Planes de Estudio';
        return view('modules.planes-estudio.index', compact('titulo'));
    }
    public function agregar(){
        $titulo = 'Agregar Plande Estudio';
        return view('modules.planes-estudio.create', compact('titulo'));
    }
}
