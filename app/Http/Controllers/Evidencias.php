<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Revision;
use App\Models\AsignacionMateria;
use App\Models\Materia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Evidencias extends Controller
{

    public function index()
    {
        $titulo = "Gestión de evidencias";
        $docente_id = Auth::id();
        $materias = Materia::with('evidencias')
            ->join('asignacion_materias', 'materias.id', '=', 'asignacion_materias.materia_id')
            ->where('asignacion_materias.docente_id', $docente_id)
            ->select('materias.*')
            ->distinct()
            ->get();
        return view('modules.evidencias.index', compact('materias', 'titulo'));
    }

    public function edit(Request $request, $materia_id)
    {
        $titulo = "Editar Evidencia";
        $materia = Materia::findOrFail($materia_id);
        $revisiones = Revision::where('activo', 1)->orderBy('nombre', 'asc')->get();
        $revision_id = $request->query('revision_id', $revisiones->first()->id);
        $revisionSeleccionada = Revision::findOrFail($revision_id);
        $evidencia = Evidencia::where('materia_id', $materia_id)
            ->where('revision_id', $revision_id)
            ->first();
        return view('modules.evidencias.edit', compact(
            'titulo',
            'materia',
            'revisiones',
            'revisionSeleccionada',
            'evidencia'
        ));
    }
    public function update(Request $request, $materia_id)
    {
        $request->validate([
            'revision_id' => 'required|integer',
            'doc_a'       => 'nullable|mimes:pdf|max:1024',
            'doc_b'       => 'nullable|mimes:pdf|max:1024',
            'doc_c'       => 'nullable|mimes:pdf|max:1024',
            'evi_a'       => 'nullable|mimes:pdf|max:1024',
            'evi_b'       => 'nullable|mimes:pdf|max:1024',
            'evi_c'       => 'nullable|mimes:pdf|max:1024',
        ], [
            'mimes' => 'Los archivos seleccionados deben estar estrictamente en formato PDF.',
            'max'   => 'Los archivos no deben superar el tamaño máximo de 1 MB.',
        ]);
        $evidencia = Evidencia::where('materia_id', $materia_id)
            ->where('revision_id', $request->revision_id)
            ->first();
        $data = [
            'materia_id'  => $materia_id,
            'revision_id' => $request->revision_id,
        ];
        $camposArchivos = ['doc_a', 'doc_b', 'doc_c', 'evi_a', 'evi_b', 'evi_c'];

        foreach ($camposArchivos as $campo) {
            if ($request->hasFile($campo)) {
                if ($evidencia && $evidencia->$campo) {
                    Storage::disk('public')->delete($evidencia->$campo);
                }
                $data[$campo] = $request->file($campo)->store('evidencias_pdfs', 'public');
            } else {
                if ($evidencia) {
                    $data[$campo] = $evidencia->$campo;
                }
            }
        }
        Evidencia::updateOrCreate(
            [
                'materia_id'  => $materia_id,
                'revision_id' => $request->revision_id
            ],
            $data
        );
        return redirect()->route('evidencias')->with('success', '¡Las evidencias de la asignatura se han actualizado con éxito en el sistema!');
    }

    public function show(Request $request, $id)
    {
        $titulo = "Detalle de Evidencias";
        $materia = Materia::findOrFail($id);
        $revisiones = Revision::where('activo', 1)->orderBy('nombre', 'asc')->get();
        $revision_id = $request->query('revision_id', $revisiones->first()->id);
        $revisionSeleccionada = Revision::findOrFail($revision_id);
        $evidencia = Evidencia::where('materia_id', $id)
            ->where('revision_id', $revision_id)
            ->first();
        return view('modules.evidencias.show', compact('titulo', 'materia', 'revisiones', 'revisionSeleccionada', 'evidencia'));
    }

    public function create()
    {
        $titulo = "Subir Evidencias";
        $docente_id = Auth::id();
        $materias = Materia::join('asignacion_materias', 'materias.id', '=', 'asignacion_materias.materia_id')
            ->where('asignacion_materias.docente_id', $docente_id)
            ->select('materias.*')
            ->orderBy('materias.nombre', 'asc')
            ->distinct()
            ->get();
        $revisiones = Revision::where('activo', 1)->orderBy('nombre', 'asc')->get();

        return view('modules.evidencias.create', compact('titulo', 'revisiones', 'materias'));
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
        ], [
            'mimes' => 'Todos los archivos deben ser estrictamente en formato PDF.',
            'max'   => 'Los archivos no deben pesar más de 1 MB.',
        ]);
        $data = [
            'materia_id'  => $request->materia_id,
            'revision_id' => $request->revision_id,
        ];
        $camposArchivos = ['doc_a', 'doc_b', 'doc_c', 'evi_a', 'evi_b', 'evi_c'];
        foreach ($camposArchivos as $campo) {
            if ($request->hasFile($campo)) {
                $rutaArchivo = $request->file($campo)->store('evidencias_pdfs', 'public');
                $data[$campo] = $rutaArchivo;
            }
        }
        Evidencia::updateOrCreate(
            [
                'materia_id'  => $request->materia_id,
                'revision_id' => $request->revision_id
            ],
            $data
        );
        return redirect()->route('modules.evidencias.index')->with('success', '¡Las evidencias se han subido correctamente!');
    }
}
