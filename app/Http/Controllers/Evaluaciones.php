<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
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

        $calificacionesNa = is_array($calificacionesArchivo)
            && !empty($calificacionesArchivo['na']);

        $items = [
            [
                'key' => 'instrumentacion',
                'nombre' => 'Instrumentación didáctica',
                'archivo' => $documentos['instrumentacion'] ?? null,
            ],
            [
                'key' => 'reporte_inicio',
                'nombre' => 'Reporte inicio de curso',
                'archivo' => $documentos['reporte_inicio'] ?? null,
            ],
            [
                'key' => 'examen_diagnostico',
                'nombre' => 'Examen diagnóstico',
                'archivo' => $evidencias['examen_diagnostico'] ?? null,
            ],
            [
                'key' => 'analisis_diagnostico',
                'nombre' => 'Análisis del diagnóstico',
                'archivo' => $evidencias['analisis_diagnostico'] ?? null,
            ],
            [
                'key' => 'acuerdos',
                'nombre' => 'Acuerdos de clase',
                'archivo' => $documentos['acuerdos'] ?? null,
            ],
            [
                'key' => 'avance_programatico',
                'nombre' => 'Avance programático',
                'archivo' => $documentos['avance_programatico'] ?? null,
            ],
            [
                'key' => 'instrumentos',
                'nombre' => 'Evidencias de instrumentos de evaluación',
                'archivo' => null,
                'archivos_multiples' => $instrumentos,
            ],
            [
                'key' => 'rubricas',
                'nombre' => 'Rúbricas del semestre',
                'archivo' => $evidencias['rubricas'] ?? null,
                'archivos_multiples' => isset($evidencias['rubricas_detalladas'])
                    ? array_values($evidencias['rubricas_detalladas'])
                    : [],
            ],
            [
                'key' => 'calificaciones',
                'nombre' => 'Lista de calificaciones',
                'archivo' => $calificacionesArchivo,
                'documento_na' => $calificacionesNa,
                'motivo_no_evaluo' => $motivoNoEvaluo,
                'archivos_multiples' => isset($documentos['calificaciones_detalladas'])
                    ? array_values($documentos['calificaciones_detalladas'])
                    : [],
            ],
            [
                'key' => 'rac',
                'nombre' => 'Actividades de regularización',
                'archivo' => is_array($documentos['rac'] ?? null)
                    ? ($documentos['rac']['archivo'] ?? null)
                    : ($documentos['rac'] ?? null),
                'na' => is_array($documentos['rac'] ?? null)
                    ? ($documentos['rac']['na'] ?? false)
                    : false,
            ],
            [
                'key' => 'asiste_seguimiento',
                'nombre' => 'Asiste de seguimiento',
                'archivo' => $documentos['asiste_seguimiento'] ?? null,
            ],
        ];

        return view('modules.evaluacion.index', compact('evidencia', 'items'));
    }
    public function update(Request $request, $id)
    {
        $evidencia = Evidencia::findOrFail($id);
        $evaluacion = $request->evaluaciones ?? [];

        // Variable de control de estado
        $todoAprobado = true;

        // Recorremos las evaluaciones enviadas desde el formulario
        foreach ($evaluacion as $key => $item) {
            $na = isset($item['na']);
            $calificacion = $item['calificacion'] ?? null;

            // Si se marcó como N/A limpiamos la calificación del payload y saltamos
            if ($na) {
                $evaluacion[$key]['calificacion'] = null;
                continue;
            }

            // Si no es N/A, validamos que cumpla el criterio de aprobación
            if (
                $calificacion === null ||
                $calificacion === '' ||
                $calificacion < 70
            ) {
                $todoAprobado = false;
            }
        }

        // Determinar estado de la evidencia (2 = Aprobada, 4 = Rechazada)
        $estadoFinal = $todoAprobado ? 2 : 4;

        // Guardar cambios directamente en el modelo
        $evidencia->update([
            'evaluacion'     => $evaluacion,
            'estado'         => $estadoFinal,
            'admin_id'       => Auth::id(),
            'fecha_revision' => now(),
        ]);

        return redirect()
            ->route('seguimiento-academico')->with(
            'success',
            $estadoFinal == 2
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