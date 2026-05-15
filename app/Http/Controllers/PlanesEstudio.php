<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanesEstudio extends Controller
{
    public function index()
    {
        $titulo = 'Mis Planes de Estudio';
        $materias = Auth::user()->materias;
        return view('modules.planes-estudio.index', compact('titulo', 'materias'));
    }
    public function agregar($materia_id, $unidad)
    {
        $titulo = 'Crear Nueva Ponderación';
        $materia = Materia::findOrFail($materia_id);
        return view('modules.planes-estudio.create', compact('titulo', 'materia', 'unidad'));
    }
}
