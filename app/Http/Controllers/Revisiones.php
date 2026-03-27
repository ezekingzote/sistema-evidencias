<?php

namespace App\Http\Controllers;

use App\Models\Revision;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Revisiones extends Controller
{

    public function index()
    {
        $titulo = 'Revisiones';

        $revisiones = Revision::orderBy('numero', 'asc')->get();

        $semestreActivo = Semestre::where('activo', 1)->first();

        return view('modules.revisiones.index', compact(
            'titulo',
            'revisiones',
            'semestreActivo'
        ));
    }


    public function cambiarEstado($id)
    {
        $revision = Revision::findOrFail($id);

        return response()->json([
            'success' => false,
            'confirmar' => true,
            'revision_id' => $revision->id,
            'message' => 'Se requiere confirmación para cambiar el estado de esta revisión.'
        ]);
    }


    public function cambiarEstadoConfirmar(Request $request, $id)
    {
        try {

            DB::beginTransaction();

            $revision = Revision::findOrFail($id);

            $revision->activo = $revision->activo ? 0 : 1;

            $revision->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Estado de la revisión actualizado correctamente'
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
