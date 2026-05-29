<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Evaluaciones extends Controller
{
    /**
     * Mostrar evaluación
     */
    public function show($id)
    {
        $evidencia = Evidencia::with([
            'materia',
            'revision',
            'asignacionMateria.semestre',
            'asignacionMateria.docente'
        ])->findOrFail($id);

        $data = $evidencia->documentos ?? [];
        $documentos = $data['documentos'] ?? [];
        $evidencias = $data['evidencias'] ?? [];
        $instrumentos = $data['instrumentos'] ?? [];

        // =====================================
        // ITEMS VISUALES ESTRUCTURADOS
        // =====================================
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
                'instrumentos' => $instrumentos
            ],
            [
                'key' => 'rubricas',
                'nombre' => 'Rúbricas del semestre',
                'archivo' => $evidencias['rubricas'] ?? null,
            ],
            [
                'key' => 'calificaciones',
                'nombre' => 'Lista de calificaciones',
                'archivo' => $documentos['calificaciones'] ?? null,
            ],
            [
                'key' => 'rac',
                'nombre' => 'Actividades de regularización',
                'archivo' => $documentos['rac']['archivo'] ?? null,
                'na' => $documentos['rac']['na'] ?? false,
            ],
            [
                'key' => 'asiste_seguimiento',
                'nombre' => 'Asiste de seguimiento',
                'archivo' => $documentos['asiste_seguimiento'] ?? null,
            ],
        ];

        return view('modules.evaluacion.index', compact('evidencia', 'items'));
    }

    /**
     * Guardar evaluación
     */
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
}
