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

        $materias = Materia::query()
            ->join(
                'asignacion_materias as am',
                'materias.id',
                '=',
                'am.materia_id'
            )
            ->leftJoin('docentes as d', function ($join) {
                $join->on('d.id', '=', 'am.docente_id')
                    ->orOn('d.user_id', '=', 'am.docente_id');
            })
            ->leftJoin('users as u', function ($join) {
                $join->on('u.id', '=', 'd.user_id')
                    ->orOn('u.id', '=', 'am.docente_id');
            })
            ->with([
                'evidencias',
                'asignaciones',
            ])
            ->select(
                'materias.*',
                'am.id as asignacion_id',
                'am.docente_id as asignacion_docente_id',
                'am.grupo as asignacion_grupo',
                'am.alumnos as asignacion_alumnos',
                'am.semestre_id as asignacion_semestre_id',
                'am.activo as asignacion_activo',
                'u.name as docente_nombre',
                'u.email as docente_email',
                'd.departamento as docente_departamento',
                'd.cargo as docente_cargo'
            )
            ->orderBy('u.name', 'asc')
            ->orderBy('materias.nombre', 'asc')
            ->get()
            ->map(function ($materia) {
                $materia->docente_nombre = $materia->docente_nombre ?: 'Sin docente asignado';
                return $materia;
            });

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