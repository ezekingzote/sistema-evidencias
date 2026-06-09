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

        $evidencias = Evidencia::query()
            ->with([
                'materia',
                'revision',
                'asignacion'
            ])
            ->leftJoin(
                'asignacion_materias as am',
                'evidencias.asignacion_materia_id',
                '=',
                'am.id'
            )
            ->leftJoin('docentes as d', function ($join) {
                $join->on('d.id', '=', 'am.docente_id')
                    ->orOn('d.user_id', '=', 'am.docente_id');
            })
            ->leftJoin('users as u', function ($join) {
                $join->on('u.id', '=', 'd.user_id')
                    ->orOn('u.id', '=', 'am.docente_id');
            })
            ->select(
                'evidencias.*',
                'am.docente_id as asignacion_docente_id',
                'am.grupo as asignacion_grupo',
                'am.alumnos as asignacion_alumnos',
                'u.name as docente_nombre',
                'u.email as docente_email',
                'd.departamento as docente_departamento',
                'd.cargo as docente_cargo'
            )
            ->orderBy('u.name', 'asc')
            ->orderBy('evidencias.created_at', 'desc')
            ->get()
            ->map(function ($evidencia) {
                $evidencia->docente_nombre = $evidencia->docente_nombre ?: 'Sin docente asignado';
                return $evidencia;
            });

        $materias = Materia::query()
            ->join(
                'asignacion_materias as am',
                'materias.id',
                '=',
                'am.materia_id'
            )
            ->leftJoin('docentes as d', function ($join) {
                $join->on('d.id', '=', 'am.docente_id')
                    ->orOn('d.user_id', '=', 'am.docente_id');
            })
            ->leftJoin('users as u', function ($join) {
                $join->on('u.id', '=', 'd.user_id')
                    ->orOn('u.id', '=', 'am.docente_id');
            })
            ->with([
                'evidencias',
                'asignaciones',
            ])
            ->select(
                'materias.*',
                'am.id as asignacion_id',
                'am.docente_id as asignacion_docente_id',
                'am.grupo as asignacion_grupo',
                'am.alumnos as asignacion_alumnos',
                'am.semestre_id as asignacion_semestre_id',
                'am.activo as asignacion_activo',
                'u.name as docente_nombre',
                'u.email as docente_email',
                'd.departamento as docente_departamento',
                'd.cargo as docente_cargo'
            )
            ->orderBy('u.name', 'asc')
            ->orderBy('materias.nombre', 'asc')
            ->get()
            ->map(function ($materia) {
                $materia->docente_nombre = $materia->docente_nombre ?: 'Sin docente asignado';
                return $materia;
            });

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
            'asignacionMateria.semestre',
            'evaluador.docente'
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
                'admin' => $evidencia->admin,
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
            'asignacionMateria.semestre',
            'admin'
        ])->findOrFail($id);

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
                'admin' => $evidencia->admin,
            ]
        );

        return $pdf->stream('reporte-seguimiento.pdf');
    }
}
