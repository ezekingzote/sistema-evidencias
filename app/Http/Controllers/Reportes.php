<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\AsignacionMateria;
use App\Models\Evidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Reportes extends Controller
{
    public function index()
    {
        $titulo = 'Reportes';

        $evidencias = Evidencia::with([
            'materia',
            'revision',
            'asignacion.docente'
        ])
            ->latest()
            ->get();

        return view(
            'modules.reportes.index',
            compact(
                'titulo',
                'evidencias'
            )
        );
    }

    public function reportePdf($id)
    {
        $evidencia = Evidencia::with([
            'materia',
            'revision',
            'asignacion.docente'
        ])->findOrFail($id);

        $evaluacion = $evidencia->evaluacion ?? [];

        $criterios = [

            'instrumentacion' => 'Instrumentación didáctica',
            'reporte_inicio' => 'Reporte inicio de curso',
            'examen_diagnostico' => 'Examen diagnóstico',
            'analisis_diagnostico' => 'Análisis del diagnóstico',
            'acuerdos' => 'Acuerdos de clase',
            'instrumentos' => 'Evidencia de instrumentos de evaluación',
            'rubricas' => 'Rúbricas del semestre',
            'calificaciones' => 'Lista de calificaciones',

            'rac' => 'Actividades de regularización',

        ];

        $promedio = 0;
        $contador = 0;

        foreach ($criterios as $key => $nombre) {

            $calificacion =
                $evaluacion[$key]['calificacion'] ?? null;

            $na =
                $evaluacion[$key]['na'] ?? false;

            if (!$na && $calificacion !== null) {

                $promedio += $calificacion;
                $contador++;
            }
        }

        $promedioFinal =
            $contador > 0
            ? round($promedio / $contador, 2)
            : 0;

        $pdf = Pdf::loadView(
            'modules.reportes.pdf',
            [
                'evidencia' => $evidencia,
                'evaluacion' => $evaluacion,
                'criterios' => $criterios,
                'promedioFinal' => $promedioFinal,
                'admin' => Auth::user(),
            ]
        );

        $pdf->setPaper('letter');

        return $pdf->stream(
            'reporte-seguimiento.pdf'
        );
    }
}
