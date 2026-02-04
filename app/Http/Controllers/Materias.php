<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Exception;
use Illuminate\Http\Request;

class Materias extends Controller
{
    public function index()
    {
        $titulo = 'Materias';
        $items = Materia::all();

        return view('modules.materias.index', compact('titulo', 'items'));
    }

    public function create()
    {
        $titulo = 'Crear Materia';

        return view('modules.materias.create', compact('titulo'));
    }

    public function store(Request $request)
    {
        try {
            $item = new Materia();
            $item->nombre = $request->nombre;
            $item->clave = $request->clave;
            $item->unidades = $request->unidades;
            $item->carrera = $request->carrera;
            $item->semestre = $request->semestre;
            $item->save();
            return to_route('materias')->with('success', 'Materia guardada con éxito!');
        } catch (Exception $e) {
            return to_route('materias')->with('error', 'Error al guardar Materia!' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $titulo = 'Editar Materia';
        $item = Materia::find($id);
        return view('modules.materias.edit', compact('item', 'titulo'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $item = Materia::find($id);
            $item->nombre = $request->nombre;
            $item->clave = $request->clave;
            $item->unidades = $request->unidades;
            $item->carrera = $request->carrera;
            $item->semestre = $request->semestre;
            $item->save();
            return to_route('materias')->with('success', 'Materia Actualizada');
        } catch (Exception $e) {
            return to_route('materias')->with('error', 'No se pudo actualizar!' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $titulo = 'Eliminar Materia';
        $items = Materia::find($id);
        return view('modules.materias.show', compact('items', 'titulo'));
    }

    public function tbody()
    {
        $items = Materia::all();
        return view('modules.materias.tbody', compact('items'));
    }

    public function estado($id, $estado)
    {
        $item = Materia::find($id);
        if ($item) {
            $item->activo = $estado;
            $item->save();
            return 1;
        }
        return 0;
    }

    public function destroy(string $id)
    {
        try{
            $item = Materia::find($id);
            $item->delete();
            return to_route('materias')->with('success', 'Materia Eliminado');
        } catch (Exception $e) {
            return to_route('materias')->with('error', 'No se pudo eliminar!' . $e->getMessage());
        }
    }

    public function misMaterias()
    {
        $titulo = 'Agregar Docente';

        return view('modules.materias.misMaterias', compact('titulo'));
    }
}
