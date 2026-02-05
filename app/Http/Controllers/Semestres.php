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
        $semestres = Semestre::withCount('materias')->get();
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

            DB::beginTransaction();
            $item = Semestre::create([
                'nombre'  => $request->nombre,
                'anio'    => $request->anio,
                'periodo' => $request->periodo,
            ]);
            if ($request->has('materias_select')) {
                $item->materias()->sync($request->materias_select);
            }
            DB::commit();
            return to_route('semestres')
                ->with('success', 'Semestre registrado con éxito!!!');
        } catch (Exception $e) {
            DB::rollBack();
            return to_route('semestres')
                ->with('error', 'No se pudo guardar!!! ' . $e->getMessage());
        }
    }

    public function estado($id, $estado)
    {
        $item = Semestre::find($id);
        $item->activo = $estado;
        return $item->save();
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
