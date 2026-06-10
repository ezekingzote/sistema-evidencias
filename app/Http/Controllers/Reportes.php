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

    /**
     * Obtiene la evaluación completa para una evidencia, fusionando
     * los datos de la Revisión 1 cuando la revisión actual no es la 1.
     *
     * @param Evidencia $evidencia
     * @return array
     */
    private function obtenerEvaluacionCompleta($evidencia)
    {
        $evaluacionActual = $evidencia->evaluacion ?? [];
        $esRevision1 = (int) $evidencia->revision->id === 1;

        // Si es Revisión 1, devolvemos la evaluación tal cual
        if ($esRevision1) {
            return $evaluacionActual;
        }

        // Buscar la evidencia de Revisión 1 para esta misma materia/docente
        $revision1 = Revision::where('numero', 1)->first();
        if (!$revision1) {
            // Si no existe Revisión 1, devolvemos la actual (no hay datos anteriores)
            return $evaluacionActual;
        }

        $evidenciaRev1 = Evidencia::where('materia_id', $evidencia->materia_id)
            ->where('revision_id', $revision1->id)
            ->where('asignacion_materia_id', $evidencia->asignacion_materia_id)
            ->first();

        if (!$evidenciaRev1) {
            return $evaluacionActual;
        }

        $evaluacionRev1 = $evidenciaRev1->evaluacion ?? [];

        // Campos que vienen de Revisión 1 (los exclusivos)
        $camposAuto = ['instrumentacion', 'reporte_inicio', 'acuerdos', 'examen_diagnostico', 'analisis_diagnostico'];

        // Fusionar: los valores de Revisión 1 tienen prioridad sobre los actuales
        // porque en revisiones posteriores estos campos no se muestran ni se editan.
        foreach ($camposAuto as $campo) {
            if (isset($evaluacionRev1[$campo])) {
                $evaluacionActual[$campo] = $evaluacionRev1[$campo];
            } else {
                // Si no existe en Rev1, creamos un registro por defecto (0, sin N/A)
                $evaluacionActual[$campo] = [
                    'na' => false,
                    'calificacion' => 0,
                    'observaciones' => 'Sin evaluación en Revisión 1'
                ];
            }
        }

        return $evaluacionActual;
    }

    /**
     * Reporte para administrador (toda la evidencia)
     */
    public function reportePdf($id)
    {
        $evidencia = Evidencia::with([
            'materia',
            'revision',
            'asignacion.docente',
            'asignacionMateria.semestre',
            'evaluador.docente'
        ])->findOrFail($id);

        // Obtener evaluación completa (con datos de Revisión 1 si aplica)
        $evaluacion = $this->obtenerEvaluacionCompleta($evidencia);
        $esRevision4 = (int) $evidencia->revision->id === 4;

        // Criterios base (todos los posibles, el orden puede ser el mismo que en la evaluación)
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

        // Si es revisión 4, agregamos los dos criterios extra
        if ($esRevision4) {
            $criterios['acta'] = 'Acta de revisión';
            $criterios['segunda_oportunidad'] = 'Evidencias de segunda oportunidad';
        }

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

        $promedioFinal = $contador > 0 ? round($promedio / $contador, 2) : 0;

        $pdf = Pdf::loadView(
            'modules.reportes.pdf',
            [
                'evidencia'      => $evidencia,
                'evaluacion'     => $evaluacion,
                'criterios'      => $criterios,
                'promedioFinal'  => $promedioFinal,
                'admin'          => Auth::user(), // El administrador que genera el reporte
            ]
        );

        $pdf->setPaper('letter');
        return $pdf->stream('reporte-seguimiento.pdf');
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

        // Verificar que el docente sea el propietario
        if ($evidencia->asignacionMateria->docente_id != Auth::id()) {
            abort(403);
        }

        // Obtener evaluación completa (con datos de Revisión 1 si aplica)
        $evaluacion = $this->obtenerEvaluacionCompleta($evidencia);
        $esRevision4 = (int) $evidencia->revision->id === 4;

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

        if ($esRevision4) {
            $criterios['acta'] = 'Acta de revisión';
            $criterios['segunda_oportunidad'] = 'Evidencias de segunda oportunidad';
        }

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

        $promedioFinal = $contador > 0 ? round($promedio / $contador, 2) : 0;

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