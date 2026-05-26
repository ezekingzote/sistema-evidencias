<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

            if (!Hash::check($request->password, Auth::user()->password)) {

                return response()->json([
                    'success' => false,
                    'error' => 'Contraseña incorrecta'
                ], 400);
            }

            $revision = Revision::findOrFail($id);

            $nuevoEstado = $revision->activo ? 0 : 1;

            if ($nuevoEstado) {

                $semestreActivo = Semestre::where('activo', 1)->first();

                if (!$semestreActivo) {

                    return response()->json([
                        'success' => false,
                        'error' => 'No existe un semestre activo'
                    ], 400);
                }

                if (!$request->filled('fecha_limite')) {

                    return response()->json([
                        'success' => false,
                        'error' => 'Debes seleccionar una fecha límite'
                    ], 400);
                }

                if ($request->fecha_limite < now()->toDateString()) {

                    return response()->json([
                        'success' => false,
                        'error' => 'La fecha límite no puede ser anterior a hoy'
                    ], 400);
                }

                $revision->activo = true;
                $revision->semestre_id = $semestreActivo->id;
                $revision->fecha_limite = $request->fecha_limite;
            } else {

                $revision->activo = false;
                $revision->semestre_id = null;
                $revision->fecha_limite = null;
            }

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
