<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Revision;
use App\Models\AsignacionMateria;
use App\Models\Materia;
use App\Models\User;
use App\Notifications\EvidenciaNotificacion;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function edit(Request $request, $id)
    {
        $evidencia = Evidencia::findOrFail($id);
        $materia = Materia::findOrFail($evidencia->materia_id);
        $revisiones = Revision::where('activo', 1)->orderBy('numero', 'asc')->get();
        $revisionSeleccionada = Revision::findOrFail($evidencia->revision_id);

        return view('modules.evidencias.edit', compact('evidencia', 'materia', 'revisiones', 'revisionSeleccionada'));
    }

    public function show(Request $request, $materia_id)
    {
        $titulo = "Detalle de Evidencias Aceptadas";
        $materia = Materia::findOrFail($materia_id);
        $revisiones = Revision::where('activo', 1)->orderBy('numero', 'asc')->get();
        $revision_id = $request->query('revision_id', $revisiones->first()->id);
        $revisionSeleccionada = Revision::findOrFail($revision_id);

        $evidencia = Evidencia::where('materia_id', $materia_id)
            ->where('revision_id', $revision_id)
            ->first();

        return view('modules.evidencias.show', compact('titulo', 'materia', 'revisiones', 'revisionSeleccionada', 'evidencia'));
    }

    public function create()
    {
        $docente_id = Auth::id();

        $evidenciasSubidas = DB::table('evidencias')
            ->join('asignacion_materias', 'evidencias.asignacion_materia_id', '=', 'asignacion_materias.id')
            ->where('asignacion_materias.docente_id', $docente_id)
            ->select('evidencias.materia_id', 'evidencias.revision_id')
            ->get();

        $materias = Materia::whereIn('id', function ($query) use ($docente_id) {
            $query->select('materia_id')->from('asignacion_materias')->where('docente_id', $docente_id);
        })->get();

        $revisiones = Revision::where('activo', 1)->orderBy('numero', 'asc')->get();

        $subidasArray = $evidenciasSubidas->map(function ($item) {
            return $item->materia_id . '-' . $item->revision_id;
        })->toArray();

        return view('modules.evidencias.create', compact('materias', 'revisiones', 'subidasArray'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'materia_id'  => 'required|integer',
            'revision_id' => 'required|integer',
            'doc_a'       => 'required|mimes:pdf|max:1024',
            'doc_b'       => 'required|mimes:pdf|max:1024',
            'doc_c'       => 'required|mimes:pdf|max:1024',
            'evi_a'       => 'required|mimes:pdf|max:1024',
            'evi_b'       => 'required|mimes:pdf|max:1024',
            'evi_c'       => 'required|mimes:pdf|max:1024',
        ]);

        $materia = Materia::findOrFail($request->materia_id);
        $revision = Revision::findOrFail($request->revision_id);
        $asignacion = AsignacionMateria::where('materia_id', $request->materia_id)
            ->where('docente_id', Auth::id())
            ->first();

        if (!$asignacion) return redirect()->back()->withErrors(['error' => 'No tienes asignada esta materia.']);

        $mes = Carbon::now()->month;
        $anio = Carbon::now()->year;
        $nombreSemestre = ($mes >= 1 && $mes <= 6) ? "ENERO - JUNIO {$anio}" : "AGOSTO - DICIEMBRE {$anio}";
        $rutaDestino = "evidencias_pdfs/{$nombreSemestre}/" . str_replace(['/', '\\', ':'], '', $revision->nombre) . "/" . str_replace(['/', '\\', ':'], '', $materia->nombre);

        $data = ['asignacion_materia_id' => $asignacion->id, 'materia_id' => $request->materia_id, 'revision_id' => $request->revision_id, 'estado' => 3];
        $camposArchivos = ['doc_a', 'doc_b', 'doc_c', 'evi_a', 'evi_b', 'evi_c'];
        $nombresArchivos = ['doc_a' => 'a) Instrumentacion didactica completa.pdf', 'doc_b' => 'b) Lista de calificaciones.pdf', 'doc_c' => 'c) Reporte y acuerdos.pdf', 'evi_a' => 'a) Muestra de tareas y trabajos complementarios.pdf', 'evi_b' => 'b) Rubricas utilizadas para tareas y trabajos.pdf', 'evi_c' => 'c) Examen diagnostico y analisis.pdf'];

        foreach ($camposArchivos as $campo) {
            if (!$request->hasFile($campo)) continue;
            $data[$campo] = $request->file($campo)->storeAs($rutaDestino . '/' . (str_starts_with($campo, 'doc_') ? 'Archivos' : 'Evidencias'), $nombresArchivos[$campo], 'public');
        }

        $evidencia = Evidencia::updateOrCreate(['asignacion_materia_id' => $asignacion->id, 'revision_id' => $request->revision_id], $data);

        $admin = User::where('rol', 'Administrador')->first();
        if ($admin) {
            $admin->notify(new EvidenciaNotificacion("Nueva evidencia de " . Auth::user()->name, route('evaluaciones.evaluar', $evidencia->id), 'bi-file-earmark-plus text-primary'));
        }

        return redirect()->route('evidencias')->with('success', '¡Las evidencias se han subido correctamente!');
    }

    public function update(Request $request, $id)
    {
        $evidencia = Evidencia::findOrFail($id);
        if ($evidencia->estado == 2) abort(403);

        $materia = Materia::findOrFail($evidencia->materia_id);
        $revision = Revision::findOrFail($evidencia->revision_id);
        $rutaDestino = "evidencias_pdfs/" . (Carbon::now()->month <= 6 ? "ENERO - JUNIO " : "AGOSTO - DICIEMBRE ") . Carbon::now()->year . "/" . str_replace(['/', '\\', ':'], '', $revision->nombre) . "/" . str_replace(['/', '\\', ':'], '', $materia->nombre);
        
        $camposArchivos = ['doc_a', 'doc_b', 'doc_c', 'evi_a', 'evi_b', 'evi_c'];
        $nombresArchivos = ['doc_a' => 'a_instrumentacion_didactica.pdf', 'doc_b' => 'b_lista_calificaciones.pdf', 'doc_c' => 'c_reporte_y_acuerdos.pdf', 'evi_a' => 'a_muestra_tareas.pdf', 'evi_b' => 'b_rubricas_utilizadas.pdf', 'evi_c' => 'c_examen_diagnostico.pdf'];

        foreach ($camposArchivos as $campo) {
            if ($request->hasFile($campo)) {
                if ($evidencia->$campo && Storage::disk('public')->exists($evidencia->$campo)) Storage::disk('public')->delete($evidencia->$campo);
                $evidencia->$campo = $request->file($campo)->storeAs($rutaDestino . '/' . (str_starts_with($campo, 'doc_') ? 'Documentos' : 'Evidencias'), $nombresArchivos[$campo], 'public');
            }
        }

        $evidencia->estado = 3;
        $evidencia->save();

        $admin = User::where('rol', 'Administrador')->first();
        if ($admin) {
            $admin->notify(new EvidenciaNotificacion("Evidencia modificada por " . Auth::user()->name, route('evaluaciones.evaluar', $evidencia->id), 'bi-pencil-square text-warning'));
        }

        return redirect()->route('evidencias')->with('success', 'Evidencia corregida con éxito.');
    }

    public function cambiarRevision(Request $request, $revisionId)
    {
        $asignacion = AsignacionMateria::where('materia_id', $request->query('materia_id'))->where('docente_id', Auth::id())->first();
        if (!$asignacion) return redirect()->route('evidencias')->with('error', 'No tienes asignada esta materia.');
        $evidencia = Evidencia::where('asignacion_materia_id', $asignacion->id)->where('revision_id', $revisionId)->first();
        return $evidencia ? redirect()->route('evidencias.edit', $evidencia->id) : redirect()->route('evidencias.create', ['materia_id' => $request->query('materia_id'), 'revision_id' => $revisionId]);
    }
}