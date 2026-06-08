<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Revision;
use App\Models\AsignacionMateria;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Evidencias extends Controller
{
    public function index()
    {
        $titulo = "Gestión de evidencias";
        $docente_id = Auth::id();

        $materias = Materia::with(['evidencias'])
            ->join('asignacion_materias', 'materias.id', '=', 'asignacion_materias.materia_id')
            ->where('asignacion_materias.docente_id', $docente_id)
            ->select('materias.*')
            ->distinct()
            ->get();

        $revisiones = Revision::orderBy('numero', 'asc')->get();

        return view('modules.evidencias.index', compact('materias', 'titulo', 'revisiones'));
    }

    public function create()
    {
        $docenteId = auth()->id();

        $materiasIds = AsignacionMateria::where('docente_id', $docenteId)
            ->where('activo', 1)
            ->pluck('materia_id');

        $materias = Materia::whereIn('id', $materiasIds)->get();
        $revisiones = Revision::where('activo', true)->get();

        $evidenciasSubidas = Evidencia::whereHas('asignacionMateria', function ($query) use ($docenteId) {
            $query->where('docente_id', $docenteId);
        })->get();

        $subidasArray = [];
        $unidadesUtilizadasPorMateria = [];

        foreach ($evidenciasSubidas as $ev) {
            $subidasArray[] = "{$ev->materia_id}-{$ev->revision_id}";

            $docs = $ev->documentos;
            $unidades = $docs['unidades'] ?? [];

            if (!isset($unidadesUtilizadasPorMateria[$ev->materia_id])) {
                $unidadesUtilizadasPorMateria[$ev->materia_id] = [];
            }

            $unidadesReales = array_filter($unidades, function ($unidad) {
                return (int)$unidad > 0;
            });

            $unidadesUtilizadasPorMateria[$ev->materia_id] = array_merge(
                $unidadesUtilizadasPorMateria[$ev->materia_id],
                $unidadesReales
            );

            $unidadesUtilizadasPorMateria[(string)$ev->materia_id] = array_values(
                array_unique($unidadesUtilizadasPorMateria[$ev->materia_id])
            );
        }

        return view('modules.evidencias.create', compact(
            'materias',
            'revisiones',
            'subidasArray',
            'unidadesUtilizadasPorMateria'
        ));
    }

    public function store(Request $request)
    {
        $unidadesInput = $request->input('unidades', []);
        $esNingunaUnidad = in_array(0, $unidadesInput);

        $request->validate([
            'materia_id' => 'required|exists:materias,id',
            'revision_id' => 'required|exists:revisiones,id',
            'unidades' => 'required|array',
            'unidades.*' => 'integer',
            'instrumentacion' => 'required|file|mimes:pdf',
            'reporte_inicio' => 'required|file|mimes:pdf',
            'acuerdos' => 'required|file|mimes:pdf',
            'calificaciones' => $esNingunaUnidad ? 'nullable|array' : 'required|array',
            'calificaciones.*' => 'file|mimes:pdf',
            'rac' => 'nullable|array',
            'rac.*' => 'file|mimes:pdf',
            'examen_diagnostico' => 'required|file|mimes:pdf',
            'analisis_diagnostico' => 'required|file|mimes:pdf',
            'rubricas' => $esNingunaUnidad ? 'nullable|array' : 'required|array',
            'rubricas.*' => 'file|mimes:pdf',
            'instrumentos' => 'nullable|array',
        ]);

        $materia = Materia::findOrFail($request->materia_id);
        $revision = Revision::findOrFail($request->revision_id);
        $asignacion = AsignacionMateria::where('materia_id', $materia->id)
            ->where('docente_id', Auth::id())
            ->firstOrFail();

        $semestreNombre = $this->limpiarNombre($asignacion->semestre->nombre ?? 'SIN_SEMESTRE');
        $materiaNombre = $this->limpiarNombre($materia->nombre);
        $revisionNombre = $this->limpiarNombre($revision->nombre);

        $basePath = "evidencias_pdf/{$semestreNombre}/{$materiaNombre}/{$revisionNombre}";

        $documentos = [];
        $evidencias = [];
        $instrumentosGrupales = [];

        $globalDocs = ['instrumentacion', 'reporte_inicio', 'acuerdos'];
        foreach ($globalDocs as $field) {
            $documentos[$field] = $request->file($field)->storeAs($basePath . '/documentos', $field . '.pdf', 'public');
        }

        $globalEvis = ['examen_diagnostico', 'analisis_diagnostico'];
        foreach ($globalEvis as $field) {
            $evidencias[$field] = $request->file($field)->storeAs($basePath . '/evidencias', $field . '.pdf', 'public');
        }

        if ($esNingunaUnidad) {
            $unidades = [0];
            $documentos['calificaciones'] = null;
            $documentos['rac'] = ['na' => true, 'archivo' => null];
            $evidencias['rubricas'] = null;
        } else {
            $unidades = $unidadesInput;
            foreach ($unidades as $index => $numUnidad) {
                if ($request->hasFile("calificaciones.{$numUnidad}")) {
                    $pathCal = $request->file("calificaciones.{$numUnidad}")->storeAs(
                        $basePath . '/documentos',
                        "calificaciones_u{$numUnidad}.pdf",
                        'public'
                    );
                    $documentos['calificaciones_detalladas']["u{$numUnidad}"] = $pathCal;
                    if ($index === 0) {
                        $documentos['calificaciones'] = $pathCal;
                    }
                }

                if ($request->has('rac_na')) {
                    $documentos['rac_detallado']["u{$numUnidad}"] = ['na' => true, 'archivo' => null];
                    if ($index === 0) {
                        $documentos['rac'] = ['na' => true, 'archivo' => null];
                    }
                } else {
                    if ($request->hasFile("rac.{$numUnidad}")) {
                        $pathRac = $request->file("rac.{$numUnidad}")->storeAs(
                            $basePath . '/documentos',
                            "RAC_u{$numUnidad}.pdf",
                            'public'
                        );
                        $documentos['rac_detallado']["u{$numUnidad}"] = ['na' => false, 'archivo' => $pathRac];
                        if ($index === 0) {
                            $documentos['rac'] = ['na' => false, 'archivo' => $pathRac];
                        }
                    }
                }

                if ($request->hasFile("rubricas.{$numUnidad}")) {
                    $pathRub = $request->file("rubricas.{$numUnidad}")->storeAs(
                        $basePath . '/evidencias',
                        "rubricas_u{$numUnidad}.pdf",
                        'public'
                    );
                    $evidencias['rubricas_detalladas']["u{$numUnidad}"] = $pathRub;
                    if ($index === 0) {
                        $evidencias['rubricas'] = $pathRub;
                    }
                }

                if ($request->hasFile("instrumentos.{$numUnidad}")) {
                    foreach ($request->file("instrumentos.{$numUnidad}") as $fileIndex => $file) {
                        if ($fileIndex >= 3) break;
                        $nombreInstrumento = "instrumento_u{$numUnidad}_" . ($fileIndex + 1) . ".pdf";
                        $instrumentosGrupales[] = $file->storeAs(
                            $basePath . '/instrumentos',
                            $nombreInstrumento,
                            'public'
                        );
                    }
                }
            }
        }

        $json = [
            'unidades' => $unidades,
            'documentos' => $documentos,
            'evidencias' => $evidencias,
            'instrumentos' => $instrumentosGrupales,
        ];

        Evidencia::updateOrCreate(
            [
                'asignacion_materia_id' => $asignacion->id,
                'revision_id' => $revision->id,
            ],
            [
                'materia_id' => $materia->id,
                'documentos' => $json,
                'estado' => 3,
            ]
        );

        return redirect()
            ->route('evidencias')
            ->with('success', 'Evidencia guardada correctamente');
    }

    public function edit($id)
    {
        $evidencia = Evidencia::with(['materia', 'revision'])->findOrFail($id);

        // Verificar que el docente sea el dueño de la evidencia
        $docenteId = Auth::id();
        $asignacion = AsignacionMateria::where('id', $evidencia->asignacion_materia_id)
            ->where('docente_id', $docenteId)
            ->firstOrFail();

        return view('modules.evidencias.edit', compact('evidencia'));
    }

    /**
     * Update the specified evidence in storage.
     */
    public function update(Request $request, $id)
    {
        $evidencia = Evidencia::findOrFail($id);
        $asignacion = AsignacionMateria::where('id', $evidencia->asignacion_materia_id)
            ->where('docente_id', Auth::id())
            ->firstOrFail();

        $materia = $evidencia->materia;
        $revision = $evidencia->revision;

        $unidadesSeleccionadas = $request->input('unidades', []);
        $esNingunaUnidad = in_array(0, $unidadesSeleccionadas);

        // Validación adaptada (no obligamos a subir todos los archivos, solo los que vienen nuevos)
        $request->validate([
            'instrumentacion' => 'nullable|file|mimes:pdf',
            'reporte_inicio' => 'nullable|file|mimes:pdf',
            'acuerdos' => 'nullable|file|mimes:pdf',
            'calificaciones' => 'nullable|array',
            'calificaciones.*' => 'file|mimes:pdf',
            'rac' => 'nullable|array',
            'rac.*' => 'file|mimes:pdf',
            'examen_diagnostico' => 'nullable|file|mimes:pdf',
            'analisis_diagnostico' => 'nullable|file|mimes:pdf',
            'rubricas' => 'nullable|array',
            'rubricas.*' => 'file|mimes:pdf',
            'instrumentos' => 'nullable|array',
            'eliminar_instrumentos' => 'nullable|array',
        ]);

        // Obtener los datos actuales
        $datosActuales = $evidencia->documentos;

        // Construir rutas base
        $semestreNombre = $this->limpiarNombre($asignacion->semestre->nombre ?? 'SIN_SEMESTRE');
        $materiaNombre = $this->limpiarNombre($materia->nombre);
        $revisionNombre = $this->limpiarNombre($revision->nombre);
        $basePath = "evidencias_pdf/{$semestreNombre}/{$materiaNombre}/{$revisionNombre}";

        // Función auxiliar para reemplazar o mantener archivos
        $actualizarArchivo = function ($campo, $subcarpeta, $nombreFijo = null) use ($request, $basePath, $datosActuales) {
            if ($request->hasFile($campo)) {
                // Eliminar anterior si existe
                if (isset($datosActuales[$subcarpeta][$campo])) {
                    Storage::disk('public')->delete($datosActuales[$subcarpeta][$campo]);
                }
                $nombre = $nombreFijo ?? $campo . '.pdf';
                return $request->file($campo)->storeAs($basePath . '/' . $subcarpeta, $nombre, 'public');
            }
            return $datosActuales[$subcarpeta][$campo] ?? null;
        };

        // Documentos generales
        $datosActuales['documentos']['instrumentacion'] = $actualizarArchivo('instrumentacion', 'documentos', 'instrumentacion.pdf');
        $datosActuales['documentos']['reporte_inicio'] = $actualizarArchivo('reporte_inicio', 'documentos', 'reporte_inicio.pdf');
        $datosActuales['documentos']['acuerdos'] = $actualizarArchivo('acuerdos', 'documentos', 'acuerdos.pdf');

        // Evidencias generales
        $datosActuales['evidencias']['examen_diagnostico'] = $actualizarArchivo('examen_diagnostico', 'evidencias', 'examen_diagnostico.pdf');
        $datosActuales['evidencias']['analisis_diagnostico'] = $actualizarArchivo('analisis_diagnostico', 'evidencias', 'analisis_diagnostico.pdf');

        // Manejo de archivos por unidad: calificaciones, rac, rubricas
        if ($esNingunaUnidad) {
            $datosActuales['unidades'] = [0];
            $datosActuales['documentos']['calificaciones'] = null;
            $datosActuales['documentos']['calificaciones_detalladas'] = [];
            $datosActuales['documentos']['rac'] = ['na' => true, 'archivo' => null];
            $datosActuales['documentos']['rac_detallado'] = [];
            $datosActuales['evidencias']['rubricas'] = null;
            $datosActuales['evidencias']['rubricas_detalladas'] = [];
        } else {
            $datosActuales['unidades'] = $unidadesSeleccionadas;

            // Calificaciones
            foreach ($unidadesSeleccionadas as $unidad) {
                if ($request->hasFile("calificaciones.{$unidad}")) {
                    if (isset($datosActuales['documentos']['calificaciones_detalladas']["u{$unidad}"])) {
                        Storage::disk('public')->delete($datosActuales['documentos']['calificaciones_detalladas']["u{$unidad}"]);
                    }
                    $path = $request->file("calificaciones.{$unidad}")->storeAs($basePath . '/documentos', "calificaciones_u{$unidad}.pdf", 'public');
                    $datosActuales['documentos']['calificaciones_detalladas']["u{$unidad}"] = $path;
                    // Mantener el primer archivo como 'calificaciones' general por compatibilidad
                    if ($unidad == $unidadesSeleccionadas[0]) {
                        $datosActuales['documentos']['calificaciones'] = $path;
                    }
                }
            }

            // RAC
            $racNa = $request->has('rac_na');
            $datosActuales['documentos']['rac'] = ['na' => $racNa, 'archivo' => null];
            foreach ($unidadesSeleccionadas as $unidad) {
                if ($racNa) {
                    // Si marcó "No aplica", eliminar archivos existentes y guardar estado
                    if (isset($datosActuales['documentos']['rac_detallado']["u{$unidad}"]['archivo'])) {
                        Storage::disk('public')->delete($datosActuales['documentos']['rac_detallado']["u{$unidad}"]['archivo']);
                    }
                    $datosActuales['documentos']['rac_detallado']["u{$unidad}"] = ['na' => true, 'archivo' => null];
                } else {
                    if ($request->hasFile("rac.{$unidad}")) {
                        if (isset($datosActuales['documentos']['rac_detallado']["u{$unidad}"]['archivo'])) {
                            Storage::disk('public')->delete($datosActuales['documentos']['rac_detallado']["u{$unidad}"]['archivo']);
                        }
                        $path = $request->file("rac.{$unidad}")->storeAs($basePath . '/documentos', "RAC_u{$unidad}.pdf", 'public');
                        $datosActuales['documentos']['rac_detallado']["u{$unidad}"] = ['na' => false, 'archivo' => $path];
                        if ($unidad == $unidadesSeleccionadas[0]) {
                            $datosActuales['documentos']['rac'] = ['na' => false, 'archivo' => $path];
                        }
                    }
                }
            }

            // Rúbricas
            foreach ($unidadesSeleccionadas as $unidad) {
                if ($request->hasFile("rubricas.{$unidad}")) {
                    if (isset($datosActuales['evidencias']['rubricas_detalladas']["u{$unidad}"])) {
                        Storage::disk('public')->delete($datosActuales['evidencias']['rubricas_detalladas']["u{$unidad}"]);
                    }
                    $path = $request->file("rubricas.{$unidad}")->storeAs($basePath . '/evidencias', "rubricas_u{$unidad}.pdf", 'public');
                    $datosActuales['evidencias']['rubricas_detalladas']["u{$unidad}"] = $path;
                    if ($unidad == $unidadesSeleccionadas[0]) {
                        $datosActuales['evidencias']['rubricas'] = $path;
                    }
                }
            }
        }

        // Instrumentos de evaluación individuales (dropzones)
        // 1. Eliminar los archivos marcados en eliminar_instrumentos
        if ($request->has('eliminar_instrumentos')) {
            foreach ($request->eliminar_instrumentos as $unidad => $rutas) {
                foreach ($rutas as $ruta) {
                    Storage::disk('public')->delete($ruta);
                    // Eliminar de la lista actual
                    if (isset($datosActuales['instrumentos'])) {
                        $datosActuales['instrumentos'] = array_values(array_filter($datosActuales['instrumentos'], function ($item) use ($ruta) {
                            return $item !== $ruta;
                        }));
                    }
                }
            }
        }

        // 2. Agregar los nuevos instrumentos subidos
        if ($request->hasFile('instrumentos')) {
            foreach ($request->file('instrumentos') as $unidad => $archivos) {
                foreach ($archivos as $idx => $file) {
                    if ($idx >= 3) break;
                    $nombre = "instrumento_u{$unidad}_" . (count($datosActuales['instrumentos'] ?? []) + $idx + 1) . ".pdf";
                    $path = $file->storeAs($basePath . '/instrumentos', $nombre, 'public');
                    $datosActuales['instrumentos'][] = $path;
                }
            }
        }

        // Actualizar el JSON en la base de datos
        $evidencia->documentos = $datosActuales;
        $evidencia->save();

        return redirect()->route('evidencias')->with('success', 'Evidencia actualizada correctamente');
    }

    public function destroy($id)
    {
        $evidencia = Evidencia::findOrFail($id);
        $data = $evidencia->documentos ?? [];

        if (!empty($data['documentos'])) {
            foreach ($data['documentos'] as $key => $path) {
                if ($key === 'rac' && is_array($path)) {
                    if (!empty($path['archivo'])) Storage::disk('public')->delete($path['archivo']);
                } elseif (is_string($path)) {
                    Storage::disk('public')->delete($path);
                } elseif (is_array($path)) {
                    foreach ($path as $subPath) {
                        if (is_string($subPath)) Storage::disk('public')->delete($subPath);
                    }
                }
            }
        }

        if (!empty($data['evidencias'])) {
            foreach ($data['evidencias'] as $path) {
                if (is_string($path)) Storage::disk('public')->delete($path);
                if (is_array($path)) {
                    foreach ($path as $subPath) {
                        if (is_string($subPath)) Storage::disk('public')->delete($subPath);
                    }
                }
            }
        }

        if (!empty($data['instrumentos'])) {
            foreach ($data['instrumentos'] as $path) {
                if (is_string($path)) Storage::disk('public')->delete($path);
            }
        }

        $evidencia->delete();

        return redirect()->route('evidencias')->with('success', 'Evidencia eliminada del sistema y sus archivos borrados.');
    }

    private function limpiarNombre($texto)
    {
        $texto = trim($texto);
        $texto = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '', $texto);
        return str_replace(' ', '_', $texto);
    }
}
