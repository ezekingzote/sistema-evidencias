<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Ponderacion;
use App\Models\AsignacionMateria;
use App\Models\Docente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanesEstudio extends Controller
{
    public function index()
    {
        $titulo = 'Mis Planes de Estudio';

        $user = Auth::user();

        $docente = Docente::where('user_id', $user->id)->first();

        $asignaciones = AsignacionMateria::with([
                'materia',
                'semestre',
            ])
            ->where(function ($query) use ($user, $docente) {
                $query->where('docente_id', $user->id);

                if ($docente) {
                    $query->orWhere('docente_id', $docente->id);
                }
            })
            ->where('activo', 1)
            ->get();

        $materias = $asignaciones
            ->filter(function ($asignacion) {
                return $asignacion->materia !== null;
            })
            ->map(function ($asignacion) {
                $materia = $asignacion->materia;

                $materia->setRelation('pivot', (object) [
                    'id' => $asignacion->id,
                    'grupo' => $asignacion->grupo ?? 'Sin asignar',
                    'alumnos' => $asignacion->alumnos ?? null,
                    'semestre_id' => $asignacion->semestre_id ?? null,
                    'docente_id' => $asignacion->docente_id ?? null,
                    'activo' => $asignacion->activo ?? null,
                    'asignada' => $asignacion->asignada ?? null,
                ]);

                $materia->semestre_asignado = $asignacion->semestre ?? null;
                $materia->asignacion_id = $asignacion->id;

                return $materia;
            })
            ->values();

        return view('modules.planes-estudio.index', compact('titulo', 'materias'));
    }

    public function agregar($materia_id, $unidad)
    {
        $titulo = 'Crear Nueva Ponderación';

        $materia = Materia::findOrFail($materia_id);

        return view('modules.planes-estudio.create', compact(
            'titulo',
            'materia',
            'unidad'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|integer',
            'unidad' => 'required|integer',
            'actividades' => 'required|array',
            'porcentajes' => 'required|array',
            'instrumentos' => 'required|array',
        ]);

        $materia_id = $request->materia_id;
        $unidad = $request->unidad;

        Ponderacion::where('materia_id', $materia_id)
            ->where('unidad', $unidad)
            ->delete();

        foreach ($request->actividades as $index => $actividad) {
            Ponderacion::create([
                'materia_id'  => $materia_id,
                'unidad'      => $unidad,
                'actividad'   => $actividad,
                'porcentaje'  => $request->porcentajes[$index],
                'instrumento' => $request->instrumentos[$index],
            ]);
        }

        return redirect()
            ->route('planes-estudio')
            ->with('success', 'La ponderación de la Unidad ' . $unidad . ' se ha guardado correctamente.');
    }

    public function show($materia_id, $unidad)
    {
        $titulo = 'Visualizar Ponderación';

        $materia = Materia::findOrFail($materia_id);

        $ponderaciones = Ponderacion::where('materia_id', $materia_id)
            ->where('unidad', $unidad)
            ->get();

        $modo = 'ver';

        return view('modules.planes-estudio.show', compact(
            'titulo',
            'materia',
            'unidad',
            'ponderaciones',
            'modo'
        ));
    }

    public function edit($materia_id, $unidad)
    {
        $titulo = 'Editar Ponderación';

        $materia = Materia::findOrFail($materia_id);

        $ponderaciones = Ponderacion::where('materia_id', $materia_id)
            ->where('unidad', $unidad)
            ->get();

        $modo = 'editar';

        return view('modules.planes-estudio.edit', compact(
            'titulo',
            'materia',
            'unidad',
            'ponderaciones',
            'modo'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|integer',
            'unidad' => 'required|integer',
            'actividades' => 'required|array',
            'porcentajes' => 'required|array',
            'instrumentos' => 'required|array',
        ]);

        $materia_id = $request->materia_id;
        $unidad = $request->unidad;

        Ponderacion::where('materia_id', $materia_id)
            ->where('unidad', $unidad)
            ->delete();

        foreach ($request->actividades as $index => $actividad) {
            Ponderacion::create([
                'materia_id'  => $materia_id,
                'unidad'      => $unidad,
                'actividad'   => $actividad,
                'porcentaje'  => $request->porcentajes[$index],
                'instrumento' => $request->instrumentos[$index],
            ]);
        }

        return redirect()
            ->route('planes-estudio')
            ->with('success', 'La ponderación de la Unidad ' . $unidad . ' se ha actualizado exitosamente.');
    }
}