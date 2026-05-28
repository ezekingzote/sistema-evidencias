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
    /*
    |-----------------------------------
    | 📄 INDEX (RESTAURADO)
    |-----------------------------------
    */
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

    /*
    |-----------------------------------
    | 🧠 CREATE
    |-----------------------------------
    */
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

    /*
    |-----------------------------------
    | 🧠 HELPERS
    |-----------------------------------
    */
    private function cleanFolderName($text)
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9]+/i', '_', $text);
        return trim($text, '_');
    }

    /*
    |-----------------------------------
    | 💾 STORE (NUEVO JSON)
    |-----------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'materia_id' => 'required|integer',
            'revision_id' => 'required|integer',
        ]);

        $materia = Materia::findOrFail($request->materia_id);
        $revision = Revision::findOrFail($request->revision_id);

        $asignacion = AsignacionMateria::where('materia_id', $materia->id)
            ->where('docente_id', Auth::id())
            ->first();

        if (!$asignacion) {
            return back()->withErrors(['error' => 'Materia no asignada']);
        }

        $semestre = $materia->semestre->nombre ?? 'SIN_SEMESTRE';

        // LIMPIAR STRINGS (IMPORTANTE)
        $semestre = str_replace([' ', '/', '\\', ':'], '_', $semestre);
        $materiaNombre = str_replace([' ', '/', '\\', ':'], '_', $materia->nombre);
        $revisionNombre = str_replace([' ', '/', '\\', ':'], '_', $revision->nombre);

        $basePath = "evidencias_pdf/{$semestre}/{$materiaNombre}/{$revisionNombre}";

        $documentos = [];
        $evidencias = [];

        $docFields = ['instrumentacion', 'reporte_inicio', 'acuerdos', 'calificaciones', 'rac'];
        $eviFields = ['examen_diagnostico', 'analisis_diagnostico', 'rubricas'];

        foreach ($docFields as $field) {
            if ($request->hasFile($field)) {
                $documentos[$field] = $request->file($field)
                    ->storeAs($basePath . '/documentos', $field . '.pdf', 'public');
            } else {
                $documentos[$field] = null;
            }
        }

        foreach ($eviFields as $field) {
            if ($request->hasFile($field)) {
                $evidencias[$field] = $request->file($field)
                    ->storeAs($basePath . '/evidencias', $field . '.pdf', 'public');
            } else {
                $evidencias[$field] = null;
            }
        }

        Evidencia::updateOrCreate(
            [
                'asignacion_materia_id' => $asignacion->id,
                'revision_id' => $revision->id,
            ],
            [
                'materia_id' => $materia->id,
                'documentos' => $documentos,
                'evidencias' => $evidencias,
                'estado' => 3,
            ]
        );

        return redirect()->route('evidencias')->with('success', 'Guardado correctamente');
    }

    
}
