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
        $request->validate([
            'estado' => 'required|in:2,4',
            'observaciones' => 'nullable|string|max:2000',
        ]);

        $evidencia = Evidencia::findOrFail($id);

        $evidencia->estado = $request->input('estado');
        $evidencia->observaciones = $request->input('observaciones');
        $evidencia->admin_id = Auth::id();
        $evidencia->fecha_revision = now();
        $evidencia->save();
        $docente = $evidencia->asignacion->docente;

        if ($docente) {
            $estadoTexto = ($request->estado == 2) ? "ACEPTADA" : "RECHAZADA";
            $mensaje = "Tu evidencia ha sido " . $estadoTexto . ".";
            $url = route('evidencias.edit', $evidencia->id);
            $icono = ($request->estado == 2) ? 'bi-check-circle text-success' : 'bi-x-circle text-danger';

            $docente->notify(new \App\Notifications\EvidenciaNotificacion($mensaje, $url, $icono));
        }

        return redirect()->route('seguimiento-academico')
            ->with('success', 'La evaluación del registro ha sido guardada con éxito.');
    }
}
