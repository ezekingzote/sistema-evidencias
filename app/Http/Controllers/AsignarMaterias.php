<?php

namespace App\Http\Controllers;

use App\Models\AsignacionMateria;
use App\Models\Materia;
use App\Models\Semestre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Docente;

class AsignarMaterias extends Controller
{

    public function index()
    {
        $titulo = "Asignar Materias";

        $items = AsignacionMateria::with([
            'materia',
            'docente',
            'semestre',
            'docente.user'
        ])
            ->orderBy('id', 'desc')
            ->get();

        return view('modules.asignar-materias.index', compact(
            'titulo',
            'items'
        ));
    }

    public function create()
    {
        $titulo = "Asignar Materia";

        $docentes = Docente::with('user')
            ->join('users', 'docentes.user_id', '=', 'users.id')
            ->where('docentes.activo', 1)
            ->whereIn('users.rol', ['admin', 'docente'])
            ->select('docentes.*')
            ->orderBy('users.name', 'asc')
            ->get();

        $semestreActivo = Semestre::where('activo', 1)->first();

        if ($semestreActivo) {
            $materias = Materia::where('activo', 1)
                ->orderBy('nombre')
                ->get();
        } else {
            $materias = collect();
        }

        return view('modules.asignar-materias.create', compact(
            'titulo',
            'docentes',
            'materias',
            'semestreActivo'
        ));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'semestre_id' => 'required|exists:semestres,id',
                'materia_id'  => 'required|exists:materias,id',
                'docente_id'  => 'required|exists:users,id',
                'grupo'       => 'required',
                'alumnos'     => 'required|integer|min:1'
            ]);
            $asignacionesPrevias = AsignacionMateria::where('semestre_id', $request->semestre_id)
                ->where('materia_id', $request->materia_id)
                ->get();

            $cantidadExistentes = $asignacionesPrevias->count();
            $asignacionExistente = $asignacionesPrevias->where('grupo', $request->grupo)->first();

            if ($asignacionExistente) {
                if (!$asignacionExistente->activo) {
                    return back()->with('warning_existente', 'Existe una asignación inactiva para el grupo ' . $request->grupo . '. Por favor, actívela desde la lista principal.');
                }
                return back()->with('error', 'El grupo ' . $request->grupo . ' ya está asignado y activo en este semestre.');
            }

            if ($cantidadExistentes == 1) {
                $primeraAsignacion = $asignacionesPrevias->first();
                $primeraAsignacion->update([
                    'grupo' => $primeraAsignacion->grupo . 'A'
                ]);
            }
            AsignacionMateria::create([
                'semestre_id' => $request->semestre_id,
                'materia_id'  => $request->materia_id,
                'docente_id'  => $request->docente_id,
                'grupo'       => $request->grupo,
                'alumnos'     => $request->alumnos,
                'activo'      => 1
            ]);
            DB::table('materias_semestres')
                ->where('semestre_id', $request->semestre_id)
                ->where('materia_id', $request->materia_id)
                ->update([
                    'asignada' => 1,
                    'updated_at' => now()
                ]);

            DB::commit();

            return redirect()->route('asignar-materias')
                ->with('success', 'Grupo ' . $request->grupo . ' asignado correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function siguienteGrupo(Request $request)
    {
        $materia_id = $request->materia_id;
        $semestre_id = $request->semestre_id;
        $cantidadExistentes = AsignacionMateria::where('materia_id', $materia_id)
            ->where('semestre_id', $semestre_id)
            ->count();

        $abecedario = range('A', 'Z');

        if ($cantidadExistentes == 0) {
            $letraQueToca = '';
        } else {
            $letraQueToca = $abecedario[$cantidadExistentes] ?? 'Z';
        }

        return response()->json([
            'letra' => $letraQueToca
        ]);
    }

    public function edit($id)
    {
        $titulo = "Editar Asignación";
        $item = AsignacionMateria::findOrFail($id);
        $docentes = Docente::with('user')
            ->join('users', 'docentes.user_id', '=', 'users.id')
            ->where('docentes.activo', 1)
            ->whereIn('users.rol', ['admin', 'docente'])
            ->select('docentes.*')
            ->orderBy('users.name', 'asc')
            ->get();

        return view('modules.asignar-materias.edit', compact(
            'titulo',
            'item',
            'docentes'
        ));
    }

    public function update(Request $request, $id)
    {
        try {

            $request->validate([
                'docente_id' => 'required|exists:users,id'
            ]);
            $item = AsignacionMateria::findOrFail($id);
            $item->alumnos = $request->alumnos;
            $item->docente_id = $request->docente_id;
            $item->save();

            return redirect()->route('asignar-materias')
                ->with('success', 'Asignación actualizada correctamente');
        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $titulo = "Eliminar Asignación";

        $item = AsignacionMateria::with([
            'materia',
            'semestre'
        ])->findOrFail($id);

        return view('modules.asignar-materias.show', compact(
            'titulo',
            'item'
        ));
    }

    public function destroy(Request $request, $id)
    {
        try {

            if (!Hash::check($request->password, Auth::user()->password)) {

                return response()->json([
                    'error' => 'Contraseña incorrecta'
                ], 401);
            }


            DB::beginTransaction();

            $item = AsignacionMateria::findOrFail($id);

            DB::table('materias_semestres')
                ->where('semestre_id', $item->semestre_id)
                ->where('materia_id', $item->materia_id)
                ->update([
                    'asignada' => 0,
                    'updated_at' => now()
                ]);

            $item->delete();
            DB::commit();
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function estado(Request $request)
    {
        $item = AsignacionMateria::with(['materia', 'docente'])->findOrFail($request->id);

        if ($request->estado == 1) {

            if (!$item->materia || $item->materia->activo == 0) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se puede activar: La materia asociada está desactivada.'
                ]);
            }

            if (!$item->docente || $item->docente->activo == 0) {
                return response()->json([
                    'success' => false,
                    'mensaje' => 'No se puede activar: El docente asociado está desactivado.'
                ]);
            }
        }

        $item->activo = $request->estado;
        $item->save();

        return response()->json([
            'success' => true,
            'mensaje' => 'Estado actualizado correctamente'
        ]);
    }

    public function tbody()
    {
        $items = AsignacionMateria::with([
            'materia',
            'docente',
            'semestre'
        ])->get();

        return view('modules.asignar-materias.tbody', compact('items'));
    }
}
