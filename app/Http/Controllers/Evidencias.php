<?php

namespace App\Http\Controllers;

use App\Models\Evidencia;
use App\Models\Revision;
use App\Models\AsignacionMateria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Evidencias extends Controller
{

    public function index()
    {

        $titulo = "Subir Evidencias";

        $revisiones = Revision::where('activo', 1)->get();

        $materiasAsignadas = AsignacionMateria::with('materia')
            ->where('docente_id', Auth::id())
            ->where('activo', 1)
            ->get();

        return view('modules.evidencias.index', compact(
            'titulo',
            'revisiones',
            'materiasAsignadas'
        ));
    }


    public function store(Request $request)
    {

        $request->validate([
            'revision_id' => 'required|exists:revisiones,id',
            'documentos' => 'required|file|max:5120',
            'evidencias' => 'required|file|max:5120'
        ]);

        $docente = Auth::id();

        $rutaDocumentos = $request->file('documentos')
            ->store('evidencias/documentos');

        $rutaEvidencias = $request->file('evidencias')
            ->store('evidencias/evidencias');

        Evidencia::create([
            'docente_id' => $docente,
            'revision_id' => $request->revision_id,
            'carpeta_documentos' => $rutaDocumentos,
            'carpeta_evidencias' => $rutaEvidencias
        ]);

        return back()->with('success', 'Evidencias subidas correctamente');
    }
}