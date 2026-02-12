<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Semestre;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Semestres extends Controller
{
    public function index()
    {
        $titulo = 'Semestres';
        $semestres = Semestre::all();
        return view('modules.semestres.index', compact(
            'titulo',
            'semestres'
        ));
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
            $semestre = new Semestre();
            $hayActivo = Semestre::where('activo', 1)->exists();
            $semestre->activo = $hayActivo ? 0 : 1;
            $semestre->save();

            if ($semestre->activo == 1) {
                $materiasIds = Materia::where('activo', 1)->pluck('id');
                $semestre->materias()->sync($materiasIds);

                $total = $materiasIds->count();
                $semestre->update([
                    'materias_activas' => $total,
                    'materias_por_asignar' => $total
                ]);
            }

            return redirect()->route('semestres')->with('success', 'Semestre guardado correctamente.');
        } catch (Exception $e) {
            return to_route('semestres')->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function cambiarEstado($id)
    {
        $semestre = Semestre::findOrFail($id);

        if ($semestre->activo) {
            $semestre->activo = 0;
        } else {
            $existe = Semestre::where('activo', 1)
                ->where('fecha_fin', '>=', now())
                ->exists();

            if ($existe) {
                return response()->json([
                    'error' => 'Ya hay un semestre activo vigente'
                ], 400);
            }

            $semestre->activo = 1;
            $materiasActivasIds = Materia::where('activo', 1)->pluck('id');
            $semestre->materias()->sync($materiasActivasIds);
            $total = $materiasActivasIds->count();
            $asignadas = \App\Models\AsignacionMateria::where('semestre_id', $semestre->id)->count();
            $semestre->materias_activas = $total;
            $semestre->materias_asignadas = $asignadas;
            $semestre->materias_por_asignar = max(0, $total - $asignadas);
        }

        $semestre->save();

        return response()->json(['success' => true]);
    }


    public function cards()
    {
        $items = Semestre::all();
        return view('modules.semestres.cards', compact('items'));
    }

    public function show(string $id)
    {
        $titulo = 'Eliminar Semestre';

        $item = Semestre::select(
            'semestres.*'
        )
            ->with([
                'materias:id,nombre,clave,unidades'
            ])
            ->where('semestres.id', $id)
            ->firstOrFail();

        return view('modules.semestres.show', compact('titulo', 'item'));
    }

    public function edit(string $id)
    {
        $titulo = 'Editar Semestre';

        $item = Semestre::with('materias')->findOrFail($id);
        $materias = Materia::where('activo', 1)->get();

        return view('modules.semestres.edit', compact(
            'titulo',
            'item',
            'materias'
        ));
    }

    public function update(Request $request, string $id)
    {
        try {
            DB::beginTransaction();

            $item = Semestre::findOrFail($id);

            $item->update([
                'nombre'  => $request->nombre,
                'anio'    => $request->anio,
                'periodo' => $request->periodo,
                'semestre' => $request->semestre,
            ]);

            if ($request->has('materias_select')) {
                $item->materias()->sync($request->materias_select);
            } else {
                $item->materias()->detach();
            }

            DB::commit();

            return to_route('semestres')
                ->with('success', 'Semestre actualizado correctamente');
        } catch (Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'No se pudo actualizar: ' . $e->getMessage());
        }
    }


    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $item = Semestre::findOrFail($id);

            if ($item->materias()->count() > 0) {
                $item->materias()->detach();
            }

            $item->delete();

            DB::commit();

            return to_route('semestres')
                ->with('success', 'Semestre eliminado correctamente');
        } catch (Exception $e) {
            DB::rollBack();

            return to_route('semestres')
                ->with('error', 'No se pudo eliminar el semestre: ' . $e->getMessage());
        }
    }

    public function listarMaterias($id)
    {

        $semestre = Semestre::with('materias')->findOrFail($id);

        return response()->json($semestre->materias);
    }
}
