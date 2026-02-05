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
                'carrera' => $request->carrera,
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
}
