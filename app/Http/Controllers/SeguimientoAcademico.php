<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Revision;
use Illuminate\Http\Request;

class SeguimientoAcademico extends Controller
{
    public function index()
    {
        $titulo = "Administración de Evidencias";

        $materias = Materia::with([
            'evidencias',
            'asignaciones.docente'
        ])
            ->join(
                'asignacion_materias',
                'materias.id',
                '=',
                'asignacion_materias.materia_id'
            )
            ->select(
                'materias.*',
                'asignacion_materias.docente_id'
            )
            ->distinct()
            ->get();

        $revisiones = Revision::orderBy('numero', 'asc')->get();

        return view(
            'modules.seguimiento-academico.index',
            compact(
                'materias',
                'revisiones',
                'titulo'
            )
        );
    }
}