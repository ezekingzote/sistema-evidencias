<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Semestre;
use Exception;
use Illuminate\Http\Request;

class Semestres extends Controller
{
    public function index()
    {
        $titulo = 'Semestres';

        return view('modules.semestres.index', compact('titulo'));
    }

    public function create()
    {
        $titulo = 'Semestres';
        $materias = Materia::all();
        return view('modules.semestres.create', compact('titulo', 'materias'));
    }

    public function store(Request $request)
    {
        try {
            $item = new Semestre();
            $item->nombre = $request->nombre;
            $item->anio = $request->anio;
            $item->carrera = $request->carrera;
            $item->materia_id = $request->materias_select;
            $item->save();
            return to_route('semestres')->with('success', 'Semestre registrado con éxito!!!');
        } catch (Exception $e) {
            return to_route('semestres')->with('error', 'No se pudo guardar!!!' . $e->getMessage());
        }
    }
}
