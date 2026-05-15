<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Revision;
use App\Models\AsignacionMateria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Evidencias extends Controller
{

    public function index()
    {
        $titulo = "Gestión de Evidencias";

        // Traemos exclusivamente las materias asignadas al docente logueado
        $materias = Auth::user()->materias;

        return view('modules.evidencias.index', compact('titulo', 'materias'));
    }

    public function edit()
    {
        $titulo = "Editar Evidencia";

        return view('modules.evidencias.edit', compact(
            'titulo'
        ));
    }

    public function show()
    {
        $titulo = "Mostrar Evidencia";

        return view('modules.evidencias.show', compact(
            'titulo'
        ));
    }

    public function create()
    {
        $titulo = "Subir Evidencias";
        $revisiones = Revision::where('activo', 1)->orderBy('nombre', 'asc')->get();
        return view('modules.evidencias.create', compact('titulo', 'revisiones'));
    }
}
