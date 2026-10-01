<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Materia;
use App\Models\Semestre;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $item->activo = 0;
            $item->save();

            return to_route('materias')
                ->with('success', 'Materia guardada con éxito!');
        } catch (Exception $e) {

            return to_route('materias')
                ->with('error', $e->getMessage());
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

            return to_route('materias')
                ->with('success', 'Materia actualizada correctamente');
        } catch (Exception $e) {

            return to_route('materias')
                ->with('error', $e->getMessage());
        }
    }

    public function show(string $id)
    {
        $titulo = 'Eliminar Materia';
        $items = Materia::findOrFail($id);

        return view('modules.materias.show', compact('items', 'titulo'));
    }

    public function destroy(string $id)
    {
        try {

            $item = Materia::findOrFail($id);
            $item->semestres()->detach();
            $item->delete();

            return to_route('materias')
                ->with('success', 'Materia eliminada correctamente');
        } catch (Exception $e) {

            return to_route('materias')
                ->with('error', $e->getMessage());
        }
    }

    public function tbody()
    {
        $items = Materia::all();

        return view('modules.materias.tbody', compact('items'));
    }

    public function misMaterias()
    {
        $titulo = 'Mis Materias';

        $user = Auth::user();
        $materias = collect();

        $semestreActivo = Semestre::where('activo', 1)->first();

        if (!$semestreActivo) {
            return view('modules.materias.misMaterias', compact(
                'titulo',
                'materias',
                'semestreActivo'
            ));
        }

        $docente = $user->docente;

        if ($docente && $docente->activo) {
            $materias = $docente->materias()
                ->where('materias.activo', 1)
                ->wherePivot('semestre_id', $semestreActivo->id)
                ->wherePivot('activo', 1)
                ->orderBy('materias.nombre', 'asc')
                ->get();
        }

        return view('modules.materias.misMaterias', compact(
            'titulo',
            'materias',
            'semestreActivo'
        ));
    }

    public function estado(Request $request)
    {
        try {

            DB::beginTransaction();

            $materia = Materia::findOrFail($request->id);

            $semestreActivo = Semestre::where('activo', 1)->first();

            if (!$semestreActivo) {

                return response()->json([
                    'success' => false,
                    'mensaje' => 'No hay semestre activo'
                ]);
            }

            if ($request->estado == 1) {

                $materia->activo = 1;
                $materia->save();
                $semestreActivo
                    ->materias()
                    ->syncWithoutDetaching([$materia->id]);
            } else {

                $materia->activo = 0;
                $materia->save();
                $materia
                    ->semestres()
                    ->detach($semestreActivo->id);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'mensaje' =>
                $request->estado
                    ? 'Materia activada correctamente'
                    : 'Materia desactivada correctamente'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'mensaje' => $e->getMessage()
            ], 500);
        }
    }
}
