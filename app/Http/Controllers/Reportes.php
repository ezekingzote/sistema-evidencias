<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Materia;
use App\Models\Revision;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Reportes extends Controller
{
    public function index()
    {
        $titulo = "Reportes";

        // Para las tarjetas resumen
        $evidencias = Evidencia::with([
            'materia',
            'revision',
            'asignacion.docente'
        ])->get();

        // Para la tabla por revisiones
        $materias = Materia::with([
            'evidencias',
            'asignaciones.docente'
        ])
            ->join(
                'asignacion_materias',
                'materias.id',
                '=',
                'asignacion_materias.materia_id'
            )
            ->select(
                'materias.*',
                'asignacion_materias.docente_id'
            )
            ->distinct()
            ->get();

        $revisiones = Revision::orderBy('numero', 'asc')->get();

        return view(
            'modules.reportes.index',
            compact(
                'titulo',
                'materias',
                'revisiones',
                'evidencias'
            )
        );
    }

    public function reportePdf($id)
    {
        $evidencia = Evidencia::with([
            'materia',
            'revision',
            'asignacion.docente',
            'asignacionMateria.semestre'
        ])->findOrFail($id);

        $evaluacion = $evidencia->evaluacion ?? [];

        $criterios = [

            'instrumentacion'      => 'Instrumentación didáctica',
            'reporte_inicio'       => 'Reporte inicio de curso',
            'examen_diagnostico'   => 'Examen diagnóstico',
            'analisis_diagnostico' => 'Análisis del diagnóstico',
            'acuerdos'             => 'Acuerdos de clase',
            'avance_programatico'  => 'Avance programático',
            'instrumentos'         => 'Evidencia de instrumentos de evaluación (3 muestras)',
            'rubricas'             => 'Rúbricas del semestre',
            'calificaciones'       => 'Lista de calificaciones con índice de aprobación',
            'rac'                  => 'Actividades de regularización en caso de haber superado el 50% de índice de reprobación.',
            'asiste_seguimiento'   => 'Asiste al seguimiento',
        ];

        $promedio = 0;
        $contador = 0;

        foreach ($criterios as $key => $nombre) {

            $item = $evaluacion[$key] ?? [];

            $na = !empty($item['na']);

            $calificacion = $item['calificacion'] ?? null;

            if (!$na && $calificacion !== null && $calificacion !== '') {

                $promedio += floatval($calificacion);

                $contador++;
            }
        }

        $promedioFinal = $contador > 0
            ? round($promedio / $contador, 2)
            : 0;

        $pdf = Pdf::loadView(
            'modules.reportes.pdf',
            [
                'evidencia'      => $evidencia,
                'evaluacion'     => $evaluacion,
                'criterios'      => $criterios,
                'promedioFinal'  => $promedioFinal,
                'admin'          => Auth::user(),
            ]
        );

        $pdf->setPaper('letter');

        return $pdf->stream('reporte-seguimiento.pdf');
    }

    public function reporteVacio($materiaId, $revisionId)
    {
        $materia = Materia::findOrFail($materiaId);

        $revision = Revision::findOrFail($revisionId);

        $docente = $materia->asignaciones->first()?->docente;

        $semestre = $materia->asignaciones->first()?->semestre;

        $evidencia = (object)[

            'materia' => $materia,

            'revision' => $revision,

            'asignacion' => (object)[
                'docente' => $docente
            ],

            'asignacionMateria' => (object)[
                'semestre' => $semestre
            ]
        ];

        $criterios = [

            'instrumentacion'      => 'Instrumentación didáctica',
            'reporte_inicio'       => 'Reporte inicio de curso',
            'examen_diagnostico'   => 'Examen diagnóstico',
            'analisis_diagnostico' => 'Análisis del diagnóstico',
            'acuerdos'             => 'Acuerdos de clase',
            'avance_programatico'  => 'Avance programático',
            'instrumentos'         => 'Evidencia de instrumentos de evaluación (3 muestras)',
            'rubricas'             => 'Rúbricas del semestre',
            'calificaciones'       => 'Lista de calificaciones con índice de aprobación',
            'rac'                  => 'Actividades de regularización',
            'asiste_seguimiento'   => 'Asiste al seguimiento',
        ];

        $evaluacion = [];

        foreach ($criterios as $key => $nombre) {

            $evaluacion[$key] = [

                'calificacion' => 0,
                'observaciones' => 'SIN ENTREGAR EVIDENCIA',
                'na' => false

            ];
        }

        $pdf = Pdf::loadView(
            'modules.reportes.pdf',
            [
                'evidencia' => $evidencia,
                'evaluacion' => $evaluacion,
                'criterios' => $criterios,
                'promedioFinal' => 0,
                'admin' => Auth::user(),
            ]
        );

        return $pdf->stream('reporte-sin-evaluacion.pdf');
    }

    public function reportePdfDocente($id)
    {
        $evidencia = Evidencia::with([
            'materia',
            'revision',
            'asignacion.docente',
            'asignacionMateria.semestre'
        ])->findOrFail($id);

        // Seguridad:
        if (
            $evidencia->asignacionMateria->docente_id != Auth::id()
        ) {
            abort(403);
        }

        $evaluacion = $evidencia->evaluacion ?? [];

        $criterios = [

            'instrumentacion'      => 'Instrumentación didáctica',
            'reporte_inicio'       => 'Reporte inicio de curso',
            'examen_diagnostico'   => 'Examen diagnóstico',
            'analisis_diagnostico' => 'Análisis del diagnóstico',
            'acuerdos'             => 'Acuerdos de clase',
            'avance_programatico'  => 'Avance programático',
            'instrumentos'         => 'Evidencia de instrumentos de evaluación (3 muestras)',
            'rubricas'             => 'Rúbricas del semestre',
            'calificaciones'       => 'Lista de calificaciones',
            'rac'                  => 'Actividades de regularización',
            'asiste_seguimiento'   => 'Asiste al seguimiento',
        ];

        $promedio = 0;
        $contador = 0;

        foreach ($criterios as $key => $nombre) {

            $item = $evaluacion[$key] ?? [];

            $na = !empty($item['na']);

            $calificacion = $item['calificacion'] ?? null;

            if (!$na && $calificacion !== null && $calificacion !== '') {

                $promedio += floatval($calificacion);

                $contador++;
            }
        }

        $promedioFinal = $contador > 0
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

        return $pdf->stream('reporte-seguimiento.pdf');
    }
}
