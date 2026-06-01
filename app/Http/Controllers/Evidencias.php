<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Revision;
use App\Models\AsignacionMateria;
use App\Models\Materia;
use App\Models\User;
use App\Notifications\EvidenciaNotificacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Semestre;

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
        $docente_id = Auth::id();

        $evidenciasSubidas = DB::table('evidencias')
            ->join('asignacion_materias', 'evidencias.asignacion_materia_id', '=', 'asignacion_materias.id')
            ->where('asignacion_materias.docente_id', $docente_id)
            ->select('evidencias.materia_id', 'evidencias.revision_id')
            ->get();

        $subidasArray = $evidenciasSubidas->map(function ($item) {
            return $item->materia_id . '-' . $item->revision_id;
        })->toArray();

        $materias = Materia::whereIn('id', function ($query) use ($docente_id) {
            $query->select('materia_id')
                ->from('asignacion_materias')
                ->where('docente_id', $docente_id);
        })->get();

        $revisiones = Revision::where('activo', 1)
            ->orderBy('numero', 'asc')
            ->get();

        return view('modules.evidencias.create', compact(
            'materias',
            'revisiones',
            'subidasArray'
        ));
    }

    private function cleanFolderName($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/i', '_', $text);
        return trim($text, '_');
    }

    public function store(Request $request)
    {
        $request->validate([

            'materia_id' => 'required|exists:materias,id',
            'revision_id' => 'required|exists:revisiones,id',

            'instrumentacion' => 'required|file|mimes:pdf',
            'reporte_inicio' => 'required|file|mimes:pdf',
            'acuerdos' => 'required|file|mimes:pdf',
            'calificaciones' => 'required|file|mimes:pdf',

            'examen_diagnostico' => 'required|file|mimes:pdf',
            'analisis_diagnostico' => 'required|file|mimes:pdf',
            'rubricas' => 'required|file|mimes:pdf',

            'instrumentos.*' => 'nullable|file|mimes:pdf',

        ]);

        // =========================
        // RELACIONES
        // =========================

        $materia = Materia::findOrFail($request->materia_id);

        $revision = Revision::findOrFail($request->revision_id);

        $asignacion = AsignacionMateria::where('materia_id', $materia->id)
            ->where('docente_id', Auth::id())
            ->firstOrFail();

        // =========================
        // NOMBRES LIMPIOS
        // =========================

        $semestreNombre = $asignacion->semestre->nombre ?? 'SIN_SEMESTRE';

        $semestreNombre = $this->limpiarNombre($semestreNombre);

        $materiaNombre = $this->limpiarNombre($materia->nombre);

        $revisionNombre = $this->limpiarNombre($revision->nombre);

        // =========================
        // BASE PATH
        // =========================

        $basePath = "evidencias_pdf/{$semestreNombre}/{$materiaNombre}/{$revisionNombre}";

        // =========================
        // ARRAYS
        // =========================

        $documentos = [];

        $evidencias = [];

        $instrumentos = [];

        // =========================
        // DOCUMENTOS
        // =========================

        $docFields = [

            'instrumentacion',
            'reporte_inicio',
            'acuerdos',
            'calificaciones',

        ];

        foreach ($docFields as $field) {

            $path = $request->file($field)->storeAs(
                $basePath . '/documentos',
                $field . '.pdf',
                'public'
            );

            $documentos[$field] = $path;
        }

        // =========================
        // RAC
        // =========================

        if ($request->has('rac_na')) {

            $documentos['rac'] = [
                'na' => true,
                'archivo' => null
            ];
        } else {

            $path = $request->file('rac')->storeAs(
                $basePath . '/documentos',
                'rac.pdf',
                'public'
            );

            $documentos['rac'] = [
                'na' => false,
                'archivo' => $path
            ];
        }

        // =========================
        // EVIDENCIAS
        // =========================

        $eviFields = [

            'examen_diagnostico',
            'analisis_diagnostico',
            'rubricas',

        ];

        foreach ($eviFields as $field) {

            $path = $request->file($field)->storeAs(
                $basePath . '/evidencias',
                $field . '.pdf',
                'public'
            );

            $evidencias[$field] = $path;
        }

        // =========================
        // INSTRUMENTOS (MAX 3)
        // =========================

        if ($request->hasFile('instrumentos')) {

            foreach ($request->file('instrumentos') as $index => $file) {

                if ($index >= 3) {
                    break;
                }

                $nombre = 'instrumento_' . ($index + 1) . '.pdf';

                $path = $file->storeAs(
                    $basePath . '/instrumentos',
                    $nombre,
                    'public'
                );

                $instrumentos[] = $path;
            }
        }

        // =========================
        // JSON FINAL
        // =========================

        $json = [

            'documentos' => $documentos,

            'evidencias' => $evidencias,

            'instrumentos' => $instrumentos,

        ];

        // =========================
        // GUARDAR
        // =========================

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
        $evidencia = Evidencia::findOrFail($id);

        // Todo vive dentro de la columna 'documentos' según el volcado de datos
        $datosContenedor = is_array($evidencia->documentos) ? $evidencia->documentos : (json_decode($evidencia->documentos, true) ?? []);

        // Extraemos los sub-bloques del JSON
        $docsJson = $datosContenedor['documentos'] ?? [];
        $evisJson = $datosContenedor['evidencias'] ?? [];
        $instJson = $datosContenedor['instrumentos'] ?? [];

        // Las calificaciones siguen viviendo en su columna independiente
        $evalJson = is_array($evidencia->evaluacion) ? $evidencia->evaluacion : (json_decode($evidencia->evaluacion, true) ?? []);

        // Helper sencillo para limpiar el prefijo 'public/' si existiera y validar archivo real
        $procesarRuta = function ($rutaCruda) {
            if (!$rutaCruda) return null;
            $rutaLimpia = str_replace('public/', '', $rutaCruda);
            return Storage::disk('public')->exists($rutaLimpia) ? $rutaLimpia : null;
        };

        // 1. Procesamiento de DOCUMENTOS
        $documentosCampos = [
            'instrumentacion' => 'Instrumentación didáctica',
            'reporte_inicio'  => 'Reporte de inicio de curso',
            'acuerdos'        => 'Acuerdos de clase',
            'calificaciones'  => 'Lista de calificaciones',
        ];

        $documentos = [];
        foreach ($documentosCampos as $key => $nombre) {
            $rutaDetectada = $procesarRuta($docsJson[$key] ?? null);
            $calificacion = $evalJson[$key]['calificacion'] ?? 0;

            $documentos[] = [
                'key'      => $key,
                'nombre'   => $nombre,
                'ruta'     => $rutaDetectada,
                'aprobado' => $calificacion >= 70,
                'existe'   => !is_null($rutaDetectada)
            ];
        }

        // Caso Especial: RAC (Actividades de Regularización)
        $racNoAplica = $docsJson['rac']['na'] ?? false;
        $rutaRacCruda = $docsJson['rac']['archivo'] ?? null;
        $rutaRacDetectada = $racNoAplica ? null : $procesarRuta($rutaRacCruda);
        $califRac = $evalJson['rac']['calificacion'] ?? 0;

        $racData = [
            'key'      => 'rac',
            'nombre'   => 'Actividades de regularización (RAC)',
            'ruta'     => $rutaRacDetectada,
            'aprobado' => $califRac >= 70,
            'na'       => $racNoAplica,
            'existe'   => !is_null($rutaRacDetectada)
        ];

        // 2. Procesamiento de EVIDENCIAS
        $evidenciasCampos = [
            'examen_diagnostico'   => 'Examen diagnóstico',
            'analisis_diagnostico' => 'Análisis diagnóstico',
            'rubricas'             => 'Rúbricas del semestre'
        ];

        $evidencias = [];
        foreach ($evidenciasCampos as $key => $nombre) {
            $rutaDetectada = $procesarRuta($evisJson[$key] ?? null);
            $calificacion = $evalJson[$key]['calificacion'] ?? 0;

            $evidencias[] = [
                'key'      => $key,
                'nombre'   => $nombre,
                'ruta'     => $rutaDetectada,
                'aprobado' => $calificacion >= 70,
                'existe'   => !is_null($rutaDetectada)
            ];
        }

        // 3. Procesamiento de INSTRUMENTOS MÚLTIPLES
        $instrumentos = [];
        foreach ($instJson as $inst) {
            $rutaLimpia = str_replace('public/', '', $inst);
            $instrumentos[] = [
                'ruta_original' => $inst,
                'ruta_limpia'   => $rutaLimpia,
                'existe'        => Storage::disk('public')->exists($rutaLimpia)
            ];
        }
        $instAprobados = ($evalJson['instrumentos']['calificacion'] ?? 0) >= 70;

        return view('modules.evidencias.edit', compact(
            'evidencia',
            'documentos',
            'racData',
            'evidencias',
            'instrumentos',
            'instAprobados'
        ));
    }

    public function update(Request $request, $id)
    {
        $evidencia = Evidencia::findOrFail($id);

        $data = $evidencia->documentos ?? [];

        $documentos = $data['documentos'] ?? [];

        $evidencias = $data['evidencias'] ?? [];

        $instrumentos = $data['instrumentos'] ?? [];

        $evaluacion = $evidencia->evaluacion ?? [];

        $materia = Materia::findOrFail($evidencia->materia_id);

        $revision = Revision::findOrFail($evidencia->revision_id);

        $asignacion = AsignacionMateria::findOrFail(
            $evidencia->asignacion_materia_id
        );

        $semestreNombre = $asignacion->semestre->nombre ?? 'SIN_SEMESTRE';

        $semestreNombre = $this->limpiarNombre($semestreNombre);

        $materiaNombre = $this->limpiarNombre($materia->nombre);

        $revisionNombre = $this->limpiarNombre($revision->nombre);

        $basePath = "evidencias_pdf/{$semestreNombre}/{$materiaNombre}/{$revisionNombre}";

        // =====================================
        // DOCUMENTOS
        // =====================================

        $camposDocumentos = [

            'instrumentacion',
            'reporte_inicio',
            'acuerdos',
            'calificaciones',

        ];

        foreach ($camposDocumentos as $campo) {

            $calificacion = $evaluacion[$campo]['calificacion'] ?? 0;

            if ($calificacion >= 70) {
                continue;
            }

            if ($request->hasFile($campo)) {

                if (!empty($documentos[$campo])) {

                    Storage::disk('public')->delete(
                        $documentos[$campo]
                    );
                }

                $path = $request->file($campo)->storeAs(
                    $basePath . '/documentos',
                    $campo . '.pdf',
                    'public'
                );

                $documentos[$campo] = $path;
            }
        }

        // =====================================
        // RAC
        // =====================================

        $calificacionRac = $evaluacion['rac']['calificacion'] ?? 0;

        if ($calificacionRac < 70) {

            if ($request->has('rac_na')) {

                if (!empty($documentos['rac']['archivo'])) {

                    Storage::disk('public')->delete(
                        $documentos['rac']['archivo']
                    );
                }

                $documentos['rac'] = [

                    'na' => true,
                    'archivo' => null

                ];
            } elseif ($request->hasFile('rac')) {

                if (!empty($documentos['rac']['archivo'])) {

                    Storage::disk('public')->delete(
                        $documentos['rac']['archivo']
                    );
                }

                $path = $request->file('rac')->storeAs(
                    $basePath . '/documentos',
                    'rac.pdf',
                    'public'
                );

                $documentos['rac'] = [

                    'na' => false,
                    'archivo' => $path

                ];
            }
        }

        // =====================================
        // EVIDENCIAS
        // =====================================

        $camposEvidencias = [

            'examen_diagnostico',
            'analisis_diagnostico',
            'rubricas',

        ];

        foreach ($camposEvidencias as $campo) {

            $calificacion = $evaluacion[$campo]['calificacion'] ?? 0;

            if ($calificacion >= 70) {
                continue;
            }

            if ($request->hasFile($campo)) {

                if (!empty($evidencias[$campo])) {

                    Storage::disk('public')->delete(
                        $evidencias[$campo]
                    );
                }

                $path = $request->file($campo)->storeAs(
                    $basePath . '/evidencias',
                    $campo . '.pdf',
                    'public'
                );

                $evidencias[$campo] = $path;
            }
        }

        // =====================================
        // INSTRUMENTOS
        // =====================================

        $calificacionInstrumentos = $evaluacion['instrumentos']['calificacion'] ?? 0;

        if (
            $calificacionInstrumentos < 70
            &&
            $request->hasFile('instrumentos')
        ) {

            foreach ($instrumentos as $archivo) {

                Storage::disk('public')->delete($archivo);
            }

            $instrumentos = [];

            foreach ($request->file('instrumentos') as $index => $file) {

                if ($index >= 3) {
                    break;
                }

                $nombre = 'instrumento_' . ($index + 1) . '.pdf';

                $path = $file->storeAs(
                    $basePath . '/instrumentos',
                    $nombre,
                    'public'
                );

                $instrumentos[] = $path;
            }
        }

        // =====================================
        // JSON FINAL
        // =====================================

        $json = [

            'documentos' => $documentos,

            'evidencias' => $evidencias,

            'instrumentos' => $instrumentos,

        ];

        $evidencia->update([

            'documentos' => $json,

            'estado' => 3,

        ]);

        return redirect()
            ->route('evidencias')
            ->with(
                'success',
                'Evidencia actualizada correctamente'
            );
    }




    private function limpiarNombre($texto)
    {
        $texto = trim($texto);

        $texto = str_replace(
            ['/', '\\', ':', '*', '?', '"', '<', '>', '|'],
            '',
            $texto
        );

        $texto = str_replace(' ', '_', $texto);

        return $texto;
    }
}
