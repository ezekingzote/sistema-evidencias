<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Semestre;
use App\Models\AsignacionMateria;
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
            $item->especialidad = $request->especialidad;
            $item->semestre = $request->semestre;
            $item->activo = 1;
            $item->save();

            return to_route('materias')->with('success', 'Materia guardada con éxito!');
        } catch (Exception $e) {
            return to_route('materias')->with('error', 'Error al guardar Materia! ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $titulo = 'Editar Materia';
        $item = Materia::findOrFail($id);
        return view('modules.materias.edit', compact('item', 'titulo'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $item = Materia::findOrFail($id);
            $item->nombre = $request->nombre;
            $item->clave = $request->clave;
            $item->unidades = $request->unidades;
            $item->carrera = $request->carrera;
            $item->especialidad = $request->especialidad;
            $item->semestre = $request->semestre;
            $item->save();

            return to_route('materias')->with('success', 'Materia actualizada con éxito!');
        } catch (Exception $e) {
            return to_route('materias')->with('error', 'No se pudo actualizar! ' . $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $titulo = 'Eliminar Materia';
        $item = Materia::findOrFail($id);
        return view('modules.materias.show', compact('item', 'titulo'));
    }

    public function destroy(string $id)
    {
        try {
            $item = Materia::findOrFail($id);
            $item->delete();
            return to_route('materias')->with('success', 'Materia eliminada con éxito!');
        } catch (Exception $e) {
            return to_route('materias')->with('error', 'No se pudo eliminar! ' . $e->getMessage());
        }
    }

    public function tbody()
    {
        $items = Materia::all();
        return view('modules.materias.tbody', compact('items'));
    }

    public function misMaterias()
    {
        $titulo = 'Agregar Docente';
        return view('modules.materias.misMaterias', compact('titulo'));
    }

    public function estado(Request $request)
    {
        $id = $request->id;
        $estado = $request->estado;

        $materia = Materia::find($id);

        // Cambié 'message' por 'mensaje' para ser consistentes
        if (!$materia) {
            return response()->json(['success' => false, 'mensaje' => 'Materia no encontrada']);
        }

        try {
            $materia->activo = $estado;
            $materia->save();

            $semestreActivo = Semestre::where('activo', 1)->first();
            if (!$semestreActivo) {
                return response()->json(['success' => false, 'mensaje' => 'No hay semestre activo']);
            }

            if ($estado == 1) {
                $semestreActivo->materias()->syncWithoutDetaching([$materia->id]);
            } else {
                $semestreActivo->materias()->detach($materia->id);
            }

            $idsMateriasActivas = $semestreActivo->materias()->pluck('materias.id')->toArray();
            $totalActivas = count($idsMateriasActivas);
            $asignadas = AsignacionMateria::where('semestre_id', $semestreActivo->id)->count();

            $semestreActivo->update([
                'materias_activas' => $totalActivas,
                'materias_asignadas' => $asignadas,
                'materias_por_asignar' => max(0, $totalActivas - $asignadas),
                'ids_materias_activas' => json_encode($idsMateriasActivas)
            ]);

            return response()->json([
                'success' => true,
                'mensaje' => $estado ? 'Materia activada correctamente' : 'Materia desactivada correctamente',
                'total' => $totalActivas
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'mensaje' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
