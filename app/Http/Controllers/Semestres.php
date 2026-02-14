<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Semestre;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $titulo = 'Crear Semestre';
        $semestres = Semestre::all();
        return view('modules.semestres.create', compact('titulo', 'semestres'));
    }


    public function verificar(Request $request)
    {

        $existe = Semestre::where('anio', $request->anio)
            ->where('periodo', $request->periodo)
            ->exists();

        return response()->json([
            'existe' => $existe
        ]);
    }


    public function store(Request $request)
    {
        try {


            $request->validate([
                'anio' => 'required|integer',
                'periodo' => 'required|in:1,2',
            ]);


            $existe = Semestre::where('anio', $request->anio)
                ->where('periodo', $request->periodo)
                ->exists();

            if ($existe) {
                return back()->with('error', 'Ya existe un semestre con ese año y periodo');
            }


            $periodoTexto = $request->periodo == 1 ? 'ENE - JUN' : 'JUL - DIC';
            $nombre = $request->anio . '-' . $request->periodo . ' ' . $periodoTexto;


            if ($request->periodo == 1) {
                $fecha_inicio = $request->anio . '-01-01';
                $fecha_fin    = $request->anio . '-06-30';
            } else {
                $fecha_inicio = $request->anio . '-07-01';
                $fecha_fin    = $request->anio . '-12-31';
            }

            Semestre::create([
                'nombre'       => $nombre,
                'anio'         => $request->anio,
                'periodo'      => $request->periodo,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin'    => $fecha_fin,
            ]);

            return redirect()->route('semestres')->with('success', 'Semestre creado correctamente');
        } catch (Exception $e) {
            return back()->with('error', 'Error al crear el semestre: ' . $e->getMessage());
        }
    }


    public function cambiarEstado($id)
    {
        $semestre = Semestre::findOrFail($id);

        return response()->json([
            'success' => false,
            'confirmar' => true,
            'semestre_id' => $semestre->id,
            'message' => 'Se requiere contraseña para cambiar el estado de este semestre.'
        ]);
    }



    public function cambiarEstadoConfirmar(Request $request, $id)
    {
        $semestre = Semestre::findOrFail($id);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json([
                'success' => false,
                'error' => 'La contraseña es incorrecta'
            ], 401);
        }

        if (!$semestre->activo) {
            $otroActivo = Semestre::where('activo', 1)
                ->where('id', '!=', $semestre->id)
                ->exists();

            if ($otroActivo) {
                return response()->json([
                    'success' => false,
                    'error' => 'Ya hay un semestre activo. Solo se puede activar uno a la vez.'
                ], 400);
            }
        }

        $semestre->activo = !$semestre->activo;
        $semestre->save();

        return response()->json([
            'success' => true,
            'message' => 'El estado del semestre ha sido modificado.'
        ]);
    }




    public function cards()
    {
        $items = Semestre::all();
        return view('modules.semestres.cards', compact('items'));
    }

    public function show(string $id)
    {
        $titulo = 'Eliminar Semestre';

        $item = Semestre::select('id', 'nombre', 'anio', 'periodo', 'fecha_inicio', 'fecha_fin', 'activo')
            ->where('id', $id)
            ->firstOrFail();

        return view('modules.semestres.show', compact('titulo', 'item'));
    }

    public function edit(string $id)
    {
        $titulo = 'Editar Semestre';
        $item = Semestre::findOrFail($id);
        $semestres = Semestre::all(); // Para verificar duplicados en JS

        return view('modules.semestres.edit', compact('titulo', 'item', 'semestres'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'anio' => 'required|integer',
            'periodo' => 'required|in:1,2',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $existe = Semestre::where('anio', $request->anio)
            ->where('periodo', $request->periodo)
            ->where('id', '!=', $id)
            ->exists();

        if ($existe) {
            return back()->with('error', 'Ya existe un semestre con ese año y periodo');
        }

        $semestre = Semestre::findOrFail($id);
        $periodoTexto = $request->periodo == 1 ? 'ENE - JUN' : 'JUL - DIC';
        $nombre = $request->anio . '-' . $request->periodo . ' ' . $periodoTexto;

        $semestre->update([
            'nombre' => $nombre,
            'anio' => $request->anio,
            'periodo' => $request->periodo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);

        return redirect()->route('semestres')->with('success', 'Semestre actualizado correctamente');
    }


    public function destroy(Request $request, string $id)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'La contraseña es incorrecta'], 401);
        }

        try {
            $semestre = Semestre::findOrFail($id);

            $semestre->delete();

            return response()->json([
                'success' => true,
                'message' => 'El semestre ha sido eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo eliminar el semestre: ' . $e->getMessage()
            ], 500);
        }
    }



    public function listarMaterias($id)
    {

        $semestre = Semestre::with('materias')->findOrFail($id);

        return response()->json($semestre->materias);
    }
}
