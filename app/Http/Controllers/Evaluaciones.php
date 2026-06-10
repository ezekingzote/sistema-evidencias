<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Revision;           // ← Agrega esta línea
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Evaluaciones extends Controller
{
    public function show($id)
{
    $evidencia = Evidencia::with([
        'materia',
        'revision',
        'asignacionMateria.semestre',
        'asignacionMateria.docente'
    ])->findOrFail($id);

    $data = is_array($evidencia->documentos)
        ? $evidencia->documentos
        : json_decode($evidencia->documentos ?? '[]', true);

    if (!is_array($data)) {
        $data = [];
    }

    $documentos = $data['documentos'] ?? [];
    $evidencias = $data['evidencias'] ?? [];
    $instrumentos = $data['instrumentos'] ?? [];

    $motivoNoEvaluo = $data['motivo_no_evaluo']
        ?? ($documentos['calificaciones']['motivo'] ?? null)
        ?? ($documentos['calificaciones_detalladas']['u0']['motivo'] ?? null)
        ?? null;

    $calificacionesArchivo = $documentos['calificaciones'] ?? null;
    $calificacionesNa = is_array($calificacionesArchivo) && !empty($calificacionesArchivo['na']);

    $esRevision4 = (int) $evidencia->revision->id === 4;
    $automaticas = [];
    $archivosAuto = []; // Guardará las rutas reales de los PDFs de Revisión 1

    if ($esRevision4) {
        $revision1 = Revision::where('numero', 1)->first();
        if ($revision1) {
            $evidenciaRev1 = Evidencia::where('materia_id', $evidencia->materia_id)
                ->where('revision_id', $revision1->id)
                ->where('asignacion_materia_id', $evidencia->asignacion_materia_id)
                ->first();

            $camposAuto = ['instrumentacion', 'reporte_inicio', 'acuerdos', 'examen_diagnostico', 'analisis_diagnostico'];

            // Mapeo de dónde se guarda cada archivo en la estructura de la evidencia
            $mapaArchivos = [
                'instrumentacion'      => ['tipo' => 'documentos', 'campo' => 'instrumentacion'],
                'reporte_inicio'       => ['tipo' => 'documentos', 'campo' => 'reporte_inicio'],
                'acuerdos'             => ['tipo' => 'documentos', 'campo' => 'acuerdos'],
                'examen_diagnostico'   => ['tipo' => 'evidencias', 'campo' => 'examen_diagnostico'],
                'analisis_diagnostico' => ['tipo' => 'evidencias', 'campo' => 'analisis_diagnostico'],
            ];

            foreach ($camposAuto as $campo) {
                // Calificación automática
                if ($evidenciaRev1 && isset($evidenciaRev1->evaluacion[$campo])) {
                    $automaticas[$campo] = $evidenciaRev1->evaluacion[$campo];
                } else {
                    $automaticas[$campo] = ['calificacion' => 0, 'na' => false, 'observaciones' => 'Sin evaluación previa'];
                }

                // Obtener el archivo real de la Revisión 1
                $rutaArchivo = null;
                if ($evidenciaRev1) {
                    $datosRev1 = is_array($evidenciaRev1->documentos) ? $evidenciaRev1->documentos : json_decode($evidenciaRev1->documentos ?? '[]', true);
                    if (is_array($datosRev1)) {
                        $tipo = $mapaArchivos[$campo]['tipo'];
                        $campoNombre = $mapaArchivos[$campo]['campo'];
                        $archivoData = $datosRev1[$tipo][$campoNombre] ?? null;
                        // Extraer la ruta real (puede ser string o array con 'archivo')
                        if (is_array($archivoData)) {
                            $rutaArchivo = $archivoData['archivo'] ?? null;
                        } elseif (is_string($archivoData)) {
                            $rutaArchivo = $archivoData;
                        }
                    }
                }
                $archivosAuto[$campo] = $rutaArchivo;
            }
        } else {
            // No existe Revisión 1
            $camposAuto = ['instrumentacion', 'reporte_inicio', 'acuerdos', 'examen_diagnostico', 'analisis_diagnostico'];
            foreach ($camposAuto as $campo) {
                $automaticas[$campo] = ['calificacion' => 0, 'na' => false, 'observaciones' => 'No existe Revisión 1'];
                $archivosAuto[$campo] = null;
            }
        }
    }

    // Construcción de items...
    $items = [
        [
            'key' => 'instrumentacion',
            'nombre' => 'Instrumentación didáctica',
            'archivo' => $archivosAuto['instrumentacion'] ?? ($documentos['instrumentacion'] ?? null),
            'automatico' => $esRevision4,
            'calificacion_auto' => $automaticas['instrumentacion']['calificacion'] ?? 0,
        ],
        [
            'key' => 'reporte_inicio',
            'nombre' => 'Reporte inicio de curso',
            'archivo' => $archivosAuto['reporte_inicio'] ?? ($documentos['reporte_inicio'] ?? null),
            'automatico' => $esRevision4,
            'calificacion_auto' => $automaticas['reporte_inicio']['calificacion'] ?? 0,
        ],
        [
            'key' => 'examen_diagnostico',
            'nombre' => 'Examen diagnóstico',
            'archivo' => $archivosAuto['examen_diagnostico'] ?? ($evidencias['examen_diagnostico'] ?? null),
            'automatico' => $esRevision4,
            'calificacion_auto' => $automaticas['examen_diagnostico']['calificacion'] ?? 0,
        ],
        [
            'key' => 'analisis_diagnostico',
            'nombre' => 'Análisis del diagnóstico',
            'archivo' => $archivosAuto['analisis_diagnostico'] ?? ($evidencias['analisis_diagnostico'] ?? null),
            'automatico' => $esRevision4,
            'calificacion_auto' => $automaticas['analisis_diagnostico']['calificacion'] ?? 0,
        ],
        [
            'key' => 'acuerdos',
            'nombre' => 'Acuerdos de clase',
            'archivo' => $archivosAuto['acuerdos'] ?? ($documentos['acuerdos'] ?? null),
            'automatico' => $esRevision4,
            'calificacion_auto' => $automaticas['acuerdos']['calificacion'] ?? 0,
        ],
        // ... resto de items (avance_programatico, instrumentos, rubricas, calificaciones, rac, asiste_seguimiento)
    ];

    // Si es Revisión 4, agregar acta y segunda oportunidad
    if ($esRevision4) {
        $items[] = [
            'key' => 'acta',
            'nombre' => 'Acta de revisión',
            'archivo' => $documentos['acta'] ?? null,
        ];
        $items[] = [
            'key' => 'segunda_oportunidad',
            'nombre' => 'Evidencias de segunda oportunidad',
            'archivo' => null,
            'archivos_multiples' => $evidencias['segunda_oportunidad'] ?? [],
        ];
    }

    return view('modules.evaluacion.index', compact('evidencia', 'items'));
}
    public function update(Request $request, $id)
    {
        $evidencia = Evidencia::findOrFail($id);
        $evaluacion = $request->evaluaciones ?? [];

        $esRevision4 = (int) $evidencia->revision->id === 4;

        if ($esRevision4) {
            $camposAuto = ['instrumentacion', 'reporte_inicio', 'acuerdos', 'examen_diagnostico', 'analisis_diagnostico'];
            $revision1 = Revision::where('numero', 1)->first();
            if ($revision1) {
                $evidenciaRev1 = Evidencia::where('materia_id', $evidencia->materia_id)
                    ->where('revision_id', $revision1->id)
                    ->where('asignacion_materia_id', $evidencia->asignacion_materia_id)
                    ->first();
                if ($evidenciaRev1 && is_array($evidenciaRev1->evaluacion)) {
                    foreach ($camposAuto as $campo) {
                        if (isset($evidenciaRev1->evaluacion[$campo])) {
                            $evaluacion[$campo] = $evidenciaRev1->evaluacion[$campo];
                        } else {
                            $evaluacion[$campo] = ['calificacion' => 0, 'na' => false, 'observaciones' => 'Automático desde Revisión 1'];
                        }
                    }
                } else {
                    foreach ($camposAuto as $campo) {
                        $evaluacion[$campo] = ['calificacion' => 0, 'na' => false, 'observaciones' => 'Sin evaluación previa'];
                    }
                }
            } else {
                foreach ($camposAuto as $campo) {
                    $evaluacion[$campo] = ['calificacion' => 0, 'na' => false, 'observaciones' => 'No existe Revisión 1'];
                }
            }
        }

        $todoAprobado = true;

        foreach ($evaluacion as $key => $item) {
            $na = isset($item['na']);
            $calificacion = $item['calificacion'] ?? null;

            if ($na) {
                $evaluacion[$key]['calificacion'] = null;
                continue;
            }

            if ($calificacion === null || $calificacion === '' || $calificacion < 70) {
                $todoAprobado = false;
            }
        }

        $estadoFinal = $todoAprobado ? 2 : 4;

        $evidencia->update([
            'evaluacion'     => $evaluacion,
            'estado'         => $estadoFinal,
            'admin_id'       => Auth::id(),
            'fecha_revision' => now(),
        ]);

        return redirect()
            ->route('seguimiento-academico')
            ->with('success', $estadoFinal == 2
                ? 'Evidencia aprobada correctamente'
                : 'Evidencia rechazada por documentos con calificación menor a 70'
            );
    }

    public function autoSave(Request $request, $id)
    {
        $evidencia = Evidencia::findOrFail($id);
        $key = $request->input('key');
        $evaluacionActual = $evidencia->evaluacion ?? [];
        $evaluacionActual[$key] = [
            'na' => $request->input('na'),
            'calificacion' => $request->input('calificacion'),
            'observaciones' => $request->input('observaciones')
        ];

        $evidencia->update([
            'evaluacion' => $evaluacionActual
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Guardado automático exitoso'
        ]);
    }
}