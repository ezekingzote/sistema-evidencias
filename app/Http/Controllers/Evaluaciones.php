<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Materia;
use App\Models\Revision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Evaluaciones extends Controller
{
    public function evaluar($id)
    {
        $evidenciaActual = Evidencia::findOrFail($id);

        $materia = Materia::with('asignaciones.docente')->findOrFail($evidenciaActual->materia_id);
        $revision = Revision::findOrFail($evidenciaActual->revision_id);

        if (!in_array($evidenciaActual->estado, [2, 3, 4])) {
            return back()->with('error', 'La evidencia seleccionada no se puede evaluar actualmente.');
        }

        return view('modules.evaluacion.index', compact('materia', 'revision', 'evidenciaActual'));
    }

    public function guardarEvaluacion(Request $request, $id)
    {
        // 1. Forzar la búsqueda estricta de la evidencia por su ID de la URL
        $evidencia = Evidencia::findOrFail($id);

        $items = $request->input('items');

        if (!$items || !is_array($items)) {
            return back()->with('error', 'No llegaron los datos de evaluación');
        }

        $rechazada = false;

        foreach ($items as $key => $data) {
            // Corrección: Validar si viene marcado el 'na' (ahora enviará 1 o 0)
            $na = isset($data['na']) && ($data['na'] == 1 || $data['na'] == 'on');
            $calificacion = $data['calificacion'] ?? null;

            if (!$na && $calificacion !== null && $calificacion < 70) {
                $rechazada = true;
            }
        }

        // 2. Guardamos asegurando los datos correctos
        $evidencia->evaluacion = $items;
        $evidencia->estado = $rechazada ? 4 : 2;
        $evidencia->admin_id = auth()->id();
        $evidencia->fecha_revision = now();

        $evidencia->save();

        return redirect()->route('seguimiento-academico')
            ->with('success', 'Evaluación guardada correctamente para la evidencia ID: ' . $evidencia->id);
    }
}
