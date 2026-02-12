<?php

namespace App\Http\Controllers;

use App\Models\AsignacionMateria;
use App\Models\Materia;
use App\Models\Semestre;
use App\Models\User;
use Illuminate\Http\Request;

class AsignarMaterias extends Controller
{
    public function index()
    {
        $titulo = 'Asignar Materias';

        return view('modules.asignar-materias.index', compact('titulo'));
    }

    public function create()
    {
        $titulo = "Asignar Materia";

        $docentes = User::where('rol', 'docente')
                        ->where('activo', 1)
                        ->orderBy('name', 'asc')
                        ->get();


        $materias = Materia::where('activo', 1)
                           ->orderBy('nombre', 'asc')
                           ->get(['id', 'nombre', 'carrera', 'semestre']);


        $semestreActivo = Semestre::where('activo', 1)->first();

        return view('modules.asignar-materias.create', compact('titulo', 'docentes', 'materias', 'semestreActivo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materia_id'  => 'required',
            'docente_id'  => 'required',
            'grupo'       => 'required',
            'semestre_id' => 'required'
        ]);

        $existe = Materia::where('materia_id', $request->materia_id)
                                    ->where('docente_id', $request->docente_id)
                                    ->where('semestre_id', $request->semestre_id)
                                    ->where('grupo', $request->grupo)
                                    ->exists();

        if ($existe) {
            return back()->withInput()->with('error', 'Esta asignación ya existe para el semestre actual.');
        }

        try {
            $asignacion = new AsignacionMateria();
            $asignacion->materia_id  = $request->materia_id;
            $asignacion->docente_id  = $request->docente_id;
            $asignacion->semestre_id = $request->semestre_id;
            $asignacion->grupo       = $request->grupo;
            $asignacion->activo      = 1;
            $asignacion->save();

            return redirect()->route('asignar-materias')->with('success', 'Materia asignada correctamente.');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error al guardar: ' . $e->getMessage());
        }
    }
}
