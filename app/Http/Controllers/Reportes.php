<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AsignacionMateria;
use Illuminate\Http\Request;


class Reportes extends Controller
{
    public function index()
    {
        $titulo = 'Reportes';
        $asignaciones = AsignacionMateria::with(['docente', 'materia', 'evidencias'])->get();

        return view('modules.reportes.index', compact('titulo', 'asignaciones'));
    }

    public function pdf(Request $request)
    {
        $revisionId = $request->revision_id;

        $asignaciones = AsignacionMateria::with(['docente', 'materia', 'evidencias'])->get();

        $data = [];

        foreach ($asignaciones as $asignacion) {

            $ev = $asignacion->evidencias
                ->where('revision_id', $revisionId)
                ->first();

            $data[] = [
                'docente' => $asignacion->docente->name ?? 'Sin Asignar',
                'materia' => $asignacion->materia->nombre ?? 'Sin Materia',
                'calificacion' => $ev->calificacion ?? 0
            ];
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('modules.reportes.pdf', compact('data', 'revisionId'));

        return $pdf->download("reporte_revision_$revisionId.pdf");
    }
}
