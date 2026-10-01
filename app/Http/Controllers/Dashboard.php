<?php

namespace App\Http\Controllers;

use App\Models\AsignacionMateria;
use App\Models\Evidencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function index()
    {
        $titulo = 'Dashboard';

        $totalEvidencias = Evidencia::count();

        $porRevisar = Evidencia::where('estado', 3)->count();

        $aprobadas = Evidencia::where('estado', 2)->count();

        $rechazadas = Evidencia::where('estado', 4)->count();

        $actividadReciente = Evidencia::with(['revision'])
            ->latest('updated_at')
            ->take(10)
            ->get();

        $avance = $totalEvidencias > 0
            ? round(($aprobadas / $totalEvidencias) * 100)
            : 0;

        return view(
            'modules.dashboard.home',
            compact(
                'titulo',
                'totalEvidencias',
                'porRevisar',
                'aprobadas',
                'rechazadas',
                'actividadReciente',
                'avance'
            )
        );
    }

    public function indexDocente()
    {
        // 1. FORZAMOS EL CAMBIO DE MODO EN LA SESIÓN
        session(['panel_activo' => 'docente']);

        $titulo = 'Dashboard';

        // Obtenemos el perfil docente del usuario autenticado
        $docente = Auth::user()->docente;

        // Validación de seguridad: si no tiene perfil docente, no puede ver este dashboard
        if (!$docente) {
            return redirect()->route('home')->with('error', 'No tienes un perfil docente configurado.');
        }

        // Usamos el ID de la tabla 'docentes' para filtrar todo lo académico
        $docenteId = $docente->id;

        $totalEvidencias = Evidencia::whereHas('asignacion', function ($q) use ($docenteId) {
            $q->where('docente_id', $docenteId);
        })->count();

        $porRevisar = Evidencia::where('estado', 3)
            ->whereHas('asignacion', function ($q) use ($docenteId) {
                $q->where('docente_id', $docenteId);
            })
            ->count();

        $aprobadas = Evidencia::where('estado', 2)
            ->whereHas('asignacion', function ($q) use ($docenteId) {
                $q->where('docente_id', $docenteId);
            })
            ->count();

        $rechazadas = Evidencia::where('estado', 4)
            ->whereHas('asignacion', function ($q) use ($docenteId) {
                $q->where('docente_id', $docenteId);
            })
            ->count();

        $materiasAsignadas = AsignacionMateria::where('docente_id', $docenteId)
            ->count();

        $avance = $totalEvidencias > 0
            ? round(($aprobadas * 100) / $totalEvidencias)
            : 0;

        $actividadReciente = Evidencia::with([
            'revision',
            'asignacion.materia'
        ])
            ->whereHas('asignacion', function ($q) use ($docenteId) {
                $q->where('docente_id', $docenteId);
            })
            ->latest('updated_at')
            ->take(10)
            ->get();

        return view(
            'modules.dashboard.indexDocente',
            compact(
                'titulo',
                'totalEvidencias',
                'porRevisar',
                'aprobadas',
                'rechazadas',
                'materiasAsignadas',
                'avance',
                'actividadReciente'
            )
        );
    }
}
