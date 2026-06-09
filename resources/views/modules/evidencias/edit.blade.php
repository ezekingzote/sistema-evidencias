@extends('layouts.main')

@section('titulo', 'Editar Evidencia')

@section('contenido')

@php
$datosEvidencia = is_array($evidencia->documentos)
    ? $evidencia->documentos
    : json_decode($evidencia->documentos ?? '[]', true);

if (!is_array($datosEvidencia)) {
    $datosEvidencia = [];
}

$unidadesSeleccionadas = $unidades ?? ($datosEvidencia['unidades'] ?? []);
$documentosData = $documentos ?? ($datosEvidencia['documentos'] ?? []);
$evidenciasData = $evidencias ?? ($datosEvidencia['evidencias'] ?? []);
$instrumentosExistentes = $datosEvidencia['instrumentos'] ?? [];

$totalUnidadesMateria = (int) ($evidencia->materia->unidades ?? 0);

$primeraRevisionId = 1;
$esPrimeraRevision = (int) ($evidencia->revision->id ?? 0) === $primeraRevisionId;

$estadoActual = strtolower((string) ($evidencia->estado ?? ''));
$evidenciaAprobada = in_array($estadoActual, ['1', 'aprobado', 'aprobada'], true);

$unidadesOcupadas = array_values(array_unique(array_map('intval', $unidadesOcupadas ?? [])));
$unidadesSeleccionadas = array_values(array_map('intval', $unidadesSeleccionadas ?? []));

$unidadesActualesSinCero = array_values(array_filter($unidadesSeleccionadas, function ($unidad) {
    return (int) $unidad !== 0;
}));

$unidadesDisponiblesParaEditar = [];

for ($i = 1; $i <= $totalUnidadesMateria; $i++) {
    $unidadEstaOcupada = in_array($i, $unidadesOcupadas);
    $unidadEsActual = in_array($i, $unidadesActualesSinCero);

    if (!$unidadEstaOcupada || $unidadEsActual) {
        $unidadesDisponiblesParaEditar[] = $i;
    }
}

$sinUnidadesDisponibles = count($unidadesDisponiblesParaEditar) === 0;

if ($sinUnidadesDisponibles && count($unidadesActualesSinCero) === 0) {
    $unidadesSeleccionadas = [0];
}

$permitirNingunaUnidad = $esPrimeraRevision || $sinUnidadesDisponibles;

$obtenerArchivo = function ($valor) {
    if (is_array($valor)) {
        return $valor['archivo'] ?? null;
    }
    if (is_string($valor)) {
        return $valor;
    }
    return null;
};

$obtenerNa = function ($valor) {
    return is_array($valor) && !empty($valor['na']);
};

$instrumentacionActual = $obtenerArchivo($documentosData['instrumentacion'] ?? null);
$reporteInicioActual   = $obtenerArchivo($documentosData['reporte_inicio'] ?? null);
$acuerdosActual        = $obtenerArchivo($documentosData['acuerdos'] ?? null);

$examenDiagnosticoActual   = $obtenerArchivo($evidenciasData['examen_diagnostico'] ?? null);
$analisisDiagnosticoActual = $obtenerArchivo($evidenciasData['analisis_diagnostico'] ?? null);

// -------------------------------------------------------------------
// 1. Obtener evaluaciones guardadas (calificaciones del administrador)
// -------------------------------------------------------------------
$evaluaciones = $evidencia->evaluacion ?? [];

/**
 * Determina si un documento específico ya fue aprobado (calificación >= 70 y no NA)
 */
function documentoAprobado($evaluaciones, $key) {
    if (!isset($evaluaciones[$key])) {
        return false;
    }
    $item = $evaluaciones[$key];
    // Si está marcado como "No aplica" no se considera aprobado
    if (!empty($item['na'])) {
        return false;
    }
    $calif = $item['calificacion'] ?? null;
    return is_numeric($calif) && $calif >= 70;
}

// Evaluación individual por cada tipo de documento
$instrumentacionAprobada   = documentoAprobado($evaluaciones, 'instrumentacion');
$reporteInicioAprobado     = documentoAprobado($evaluaciones, 'reporte_inicio');
$acuerdosAprobado          = documentoAprobado($evaluaciones, 'acuerdos');
$examenDiagnosticoAprobado = documentoAprobado($evaluaciones, 'examen_diagnostico');
$analisisDiagnosticoAprobado = documentoAprobado($evaluaciones, 'analisis_diagnostico');
$calificacionesAprobadas   = documentoAprobado($evaluaciones, 'calificaciones');
$racAprobado               = documentoAprobado($evaluaciones, 'rac');
$rubricasAprobadas         = documentoAprobado($evaluaciones, 'rubricas');
$instrumentosAprobados     = documentoAprobado($evaluaciones, 'instrumentos');

// -------------------------------------------------------------------
@endphp

<main id="main" class="main">

    <div class="card border-0 shadow-sm mb-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-primary px-3 py-2">
                            <i class="bi bi-journal-bookmark-fill me-1"></i>
                            Evidencia
                        </span>
                        <span class="badge bg-light text-dark border px-3 py-2">
                            {{ $evidencia->revision->nombre }}
                        </span>
                    </div>

                    <h2 class="fw-bold text-primary mb-1">
                        {{ $evidencia->materia->nombre }}
                    </h2>

                    <div class="text-muted">
                        <i class="bi bi-person-fill me-1"></i>
                        {{ $evidencia->asignacionMateria->docente->name ?? 'Sin docente' }}
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('mis-reportes', $evidencia->id) }}"
                       target="_blank"
                       class="btn btn-outline-success shadow-sm px-4">
                        <i class="bi bi-file-earmark-pdf-fill me-2"></i>
                        Imprimir Reporte
                    </a>

                    @if(!in_array(strtolower((string)$evidencia->estado), ['1','aprobado','aprobada']))
                    <form action="{{ route('evidencias.destroy', $evidencia->id) }}"
                          method="POST"
                          onsubmit="return confirm('¿Deseas eliminar esta evidencia y todos sus archivos?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger shadow-sm px-4">
                            <i class="bi bi-trash-fill me-2"></i>
                            Eliminar Evidencia
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card p-4 shadow-lg border-0" style="border-radius: 18px;">

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <h6 class="fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    Por favor corrige los siguientes errores:
                </h6>
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if($evidenciaAprobada)
            <div class="card border-0 shadow-sm mb-4 overflow-hidden">
                <div class="card-body text-center py-4">
                    <div class="mb-3">
                        <i class="bi bi-patch-check-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h3 class="fw-bold text-success mb-2">DOCUMENTO VALIDADO</h3>
                    <p class="text-muted mb-0">
                        Esta evidencia ha sido revisada y aprobada. No se permiten modificaciones.
                    </p>
                </div>
            </div>
            @endif

            <form action="{{ route('evidencias.update', $evidencia->id) }}" method="POST" enctype="multipart/form-data" id="form-evidencias">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold small text-uppercase text-secondary mb-2 block">Materia</label>
                        <select id="materia_id" name="materia_id" class="form-select form-select-lg fs-6" required disabled>
                            <option value="{{ $evidencia->materia->id }}">
                                {{ $evidencia->materia->nombre }}
                            </option>
                        </select>
                        <input type="hidden" name="materia_id" value="{{ $evidencia->materia->id }}">
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold small text-uppercase text-secondary mb-2 block">Revisión</label>
                        <select id="revision_id" name="revision_id" class="form-select form-select-lg fs-6" required disabled>
                            <option value="{{ $evidencia->revision->id }}">
                                {{ $evidencia->revision->nombre }}
                            </option>
                        </select>
                        <input type="hidden" name="revision_id" value="{{ $evidencia->revision->id }}">
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-primary mb-3">¿QUÉ UNIDADES EVALUASTE?</h5>

                <div class="row g-3 mb-4" id="contenedor_tarjetas_unidades">
                    @if($permitirNingunaUnidad)
                    <div class="col-md-3">
                        <div class="card card-unidad-check p-3 text-center shadow-sm h-100 d-flex flex-column align-items-center justify-content-center {{ in_array(0, $unidadesSeleccionadas) ? 'active' : '' }} {{ $evidenciaAprobada ? 'unidad-bloqueada' : '' }}"
                             id="card_unidad_0"
                             @if(!$evidenciaAprobada) onclick="toggleUnidadTarjeta(0)" @endif>
                            <input type="checkbox" id="chk_unidad_0" name="unidades[]" value="0" class="d-none" {{ in_array(0, $unidadesSeleccionadas) ? 'checked' : '' }}>
                            <i class="bi bi-dash-circle fs-3 text-secondary mb-2"></i>
                            <span class="fw-bold text-dark">Ninguna Unidad</span>
                            @if($sinUnidadesDisponibles)
                            <span class="badge bg-secondary mt-2">Sin unidades disponibles</span>
                            @endif
                        </div>
                    </div>
                    @endif

                    @for($i = 1; $i <= $totalUnidadesMateria; $i++)
                        @php
                        $unidadEstaOcupada = in_array($i, $unidadesOcupadas);
                        $unidadEsActual = in_array($i, $unidadesActualesSinCero);
                        $unidadBloqueada = $unidadEstaOcupada && !$unidadEsActual;
                        $unidadActiva = in_array($i, $unidadesSeleccionadas);
                        @endphp
                        <div class="col-md-3">
                            <div class="card card-unidad-check p-3 text-center shadow-sm h-100 d-flex flex-column align-items-center justify-content-center {{ $unidadActiva ? 'active' : '' }} {{ ($unidadBloqueada || $evidenciaAprobada) ? 'unidad-bloqueada' : '' }}"
                                 id="card_unidad_{{ $i }}"
                                 @if(!$unidadBloqueada && !$evidenciaAprobada) onclick="toggleUnidadTarjeta({{ $i }})" @endif>
                                <input type="checkbox" id="chk_unidad_{{ $i }}" name="unidades[]" value="{{ $i }}" class="d-none" {{ $unidadActiva ? 'checked' : '' }} {{ $unidadBloqueada ? 'disabled' : '' }}>
                                <i class="bi bi-bookmark-check fs-3 {{ $unidadBloqueada ? 'text-muted' : 'text-primary' }} mb-2"></i>
                                <span class="fw-bold text-dark">Unidad {{ $i }}</span>
                                @if($unidadBloqueada)
                                <span class="badge bg-danger-subtle text-danger mt-2">Ya evaluada</span>
                                @elseif($unidadEsActual)
                                <span class="badge bg-success-subtle text-success mt-2">Actual</span>
                                @else
                                <span class="badge bg-primary-subtle text-primary mt-2">Disponible</span>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-primary mb-3">DOCUMENTOS</h5>

                <div class="row g-4">
                    @if($esPrimeraRevision)
                    <!-- Instrumentación didáctica -->
                    <div class="col-md-6 campo-solo-revision-1">
                        <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-2.5 rounded-3 bg-primary-subtle text-primary me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <label class="form-label fw-bold text-dark fs-5 mb-0">Instrumentación didáctica</label>
                            </div>

                            @if($instrumentacionActual)
                            <div class="border rounded-3 p-3 bg-light mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-3"></i>
                                        <div>
                                            <a href="{{ asset('storage/' . $instrumentacionActual) }}" target="_blank" class="text-decoration-none fw-semibold">
                                                Ver documento actual
                                            </a>
                                            <div class="small text-muted">Instrumentación didáctica cargada</div>
                                        </div>
                                    </div>
                                    @if($instrumentacionAprobada)
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="bi bi-check-circle-fill me-1"></i> Aprobado (≥70)
                                    </span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if(!$evidenciaAprobada && !$instrumentacionAprobada)
                                <input type="file" name="instrumentacion" class="form-control form-control-lg fs-6 archivo-pdf-5mb mt-2" accept="application/pdf">
                                <small class="text-muted mt-1 d-block">Dejar vacío para mantener el actual. Solo PDF, máximo 5 MB.</small>
                            @elseif($instrumentacionAprobada)
                                <div class="alert alert-success mt-3 mb-0">
                                    <i class="bi bi-check-circle-fill me-2"></i> Este documento ya fue aprobado (calificación ≥70) y no puede ser modificado.
                                </div>
                            @else
                                <div class="alert alert-secondary mt-3 mb-0">
                                    <i class="bi bi-lock-fill me-2"></i> La evidencia general está aprobada, no se permiten cambios.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Reporte de inicio de curso -->
                    <div class="col-md-6 campo-solo-revision-1">
                        <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-2.5 rounded-3 bg-info-subtle text-info me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-calendar-check"></i>
                                </div>
                                <label class="form-label fw-bold text-dark fs-5 mb-0">Reporte de inicio de curso</label>
                            </div>

                            @if($reporteInicioActual)
                            <div class="d-flex align-items-center bg-light p-2 rounded mb-2 border">
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                <a href="{{ asset('storage/' . $reporteInicioActual) }}" target="_blank" class="text-decoration-none small text-truncate">
                                    Ver documento actual
                                </a>
                                @if($reporteInicioAprobado)
                                <span class="badge bg-success ms-2">Aprobado</span>
                                @endif
                            </div>
                            @endif

                            @if(!$evidenciaAprobada && !$reporteInicioAprobado)
                                <input type="file" name="reporte_inicio" class="form-control form-control-lg fs-6 archivo-pdf-5mb" accept="application/pdf">
                                <small class="text-muted mt-1 d-block">Dejar vacío para mantener el actual. Solo PDF, máximo 5 MB.</small>
                            @elseif($reporteInicioAprobado)
                                <div class="alert alert-success mt-3 mb-0">
                                    <i class="bi bi-check-circle-fill me-2"></i> Este documento ya fue aprobado y no puede ser modificado.
                                </div>
                            @else
                                <div class="alert alert-secondary mt-3 mb-0">
                                    <i class="bi bi-lock-fill me-2"></i> No se permiten cambios.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acuerdos de clase -->
                    <div class="col-md-6 campo-solo-revision-1">
                        <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-2.5 rounded-3 bg-warning-subtle text-warning me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-person-workspace"></i>
                                </div>
                                <label class="form-label fw-bold text-dark fs-5 mb-0">Acuerdos de clase</label>
                            </div>

                            @if($acuerdosActual)
                            <div class="d-flex align-items-center bg-light p-2 rounded mb-2 border">
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                <a href="{{ asset('storage/' . $acuerdosActual) }}" target="_blank" class="text-decoration-none small text-truncate">
                                    Ver documento actual
                                </a>
                                @if($acuerdosAprobado)
                                <span class="badge bg-success ms-2">Aprobado</span>
                                @endif
                            </div>
                            @endif

                            @if(!$evidenciaAprobada && !$acuerdosAprobado)
                                <input type="file" name="acuerdos" class="form-control form-control-lg fs-6 archivo-pdf-5mb" accept="application/pdf">
                                <small class="text-muted mt-1 d-block">Dejar vacío para mantener el actual. Solo PDF, máximo 5 MB.</small>
                            @elseif($acuerdosAprobado)
                                <div class="alert alert-success mt-3 mb-0">
                                    <i class="bi bi-check-circle-fill me-2"></i> Este documento ya fue aprobado y no puede ser modificado.
                                </div>
                            @else
                                <div class="alert alert-secondary mt-3 mb-0">
                                    <i class="bi bi-lock-fill me-2"></i> No se permiten cambios.
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif  {{-- fin esPrimeraRevision --}}

                    <!-- Lista de calificaciones (siempre visible) -->
                    <div class="col-md-6" id="contenedor_calificaciones">
                        <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-2.5 rounded-3 bg-success-subtle text-success me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-card-checklist"></i>
                                </div>
                                <label class="form-label fw-bold text-dark fs-5 mb-0">Lista de calificaciones</label>
                            </div>
                            <div class="wrapper-inputs d-flex flex-column gap-2" id="wrapper_calificaciones"></div>
                        </div>
                    </div>

                    <!-- RAC -->
                    <div class="col-md-6" id="contenedor_rac">
                        <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white" id="rac_card">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-2.5 rounded-3 bg-secondary-subtle text-secondary me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-arrow-repeat"></i>
                                </div>
                                <label class="form-label fw-bold text-dark fs-5 mb-0">Actividades de Regularización (RAC)</label>
                            </div>
                            <div class="wrapper-inputs d-flex flex-column gap-3" id="wrapper_rac"></div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h5 class="fw-bold text-success mb-3">EVIDENCIAS</h5>

                <div class="row g-4">
                    @if($esPrimeraRevision)
                    <!-- Examen diagnóstico -->
                    <div class="col-md-6 campo-solo-revision-1">
                        <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-2.5 rounded-3 bg-primary-subtle text-primary me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-file-earmark-medical"></i>
                                </div>
                                <label class="form-label fw-bold text-dark fs-5 mb-0">Examen diagnóstico</label>
                            </div>

                            @if($examenDiagnosticoActual)
                            <div class="d-flex align-items-center bg-light p-2 rounded mb-2 border">
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                <a href="{{ asset('storage/' . $examenDiagnosticoActual) }}" target="_blank" class="text-decoration-none small text-truncate">
                                    Ver documento actual
                                </a>
                                @if($examenDiagnosticoAprobado)
                                <span class="badge bg-success ms-2">Aprobado</span>
                                @endif
                            </div>
                            @endif

                            @if(!$evidenciaAprobada && !$examenDiagnosticoAprobado)
                                <input type="file" name="examen_diagnostico" class="form-control form-control-lg fs-6 archivo-pdf-5mb" accept="application/pdf">
                                <small class="text-muted mt-1 d-block">Dejar vacío para mantener el actual. Solo PDF, máximo 5 MB.</small>
                            @elseif($examenDiagnosticoAprobado)
                                <div class="alert alert-success mt-3 mb-0">
                                    <i class="bi bi-check-circle-fill me-2"></i> Este documento ya fue aprobado y no puede ser modificado.
                                </div>
                            @else
                                <div class="alert alert-secondary mt-3 mb-0">
                                    <i class="bi bi-lock-fill me-2"></i> No se permiten cambios.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Análisis del diagnóstico -->
                    <div class="col-md-6 campo-solo-revision-1">
                        <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-2.5 rounded-3 bg-info-subtle text-info me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-bar-chart-line"></i>
                                </div>
                                <label class="form-label fw-bold text-dark fs-5 mb-0">Análisis del diagnóstico</label>
                            </div>

                            @if($analisisDiagnosticoActual)
                            <div class="d-flex align-items-center bg-light p-2 rounded mb-2 border">
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                <a href="{{ asset('storage/' . $analisisDiagnosticoActual) }}" target="_blank" class="text-decoration-none small text-truncate">
                                    Ver documento actual
                                </a>
                                @if($analisisDiagnosticoAprobado)
                                <span class="badge bg-success ms-2">Aprobado</span>
                                @endif
                            </div>
                            @endif

                            @if(!$evidenciaAprobada && !$analisisDiagnosticoAprobado)
                                <input type="file" name="analisis_diagnostico" class="form-control form-control-lg fs-6 archivo-pdf-5mb" accept="application/pdf">
                                <small class="text-muted mt-1 d-block">Dejar vacío para mantener el actual. Solo PDF, máximo 5 MB.</small>
                            @elseif($analisisDiagnosticoAprobado)
                                <div class="alert alert-success mt-3 mb-0">
                                    <i class="bi bi-check-circle-fill me-2"></i> Este documento ya fue aprobado y no puede ser modificado.
                                </div>
                            @else
                                <div class="alert alert-secondary mt-3 mb-0">
                                    <i class="bi bi-lock-fill me-2"></i> No se permiten cambios.
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Rúbricas del semestre -->
                    <div class="col-md-6" id="contenedor_rubricas">
                        <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="p-2.5 rounded-3 bg-warning-subtle text-warning me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="bi bi-table"></i>
                                </div>
                                <label class="form-label fw-bold text-dark fs-5 mb-0">Rúbricas del semestre</label>
                            </div>
                            <div class="wrapper-inputs d-flex flex-column gap-2" id="wrapper_rubricas"></div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div id="seccion_dropzones_dinamicos"></div>

                <div class="mt-4 d-flex gap-2">
                    <a href="{{ route('evidencias') }}" class="btn btn-light border px-4 rounded-pill">
                        <i class="bi bi-arrow-left me-1"></i> Regresar
                    </a>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill" {{ $evidenciaAprobada ? 'disabled' : '' }}>
                        <i class="bi bi-floppy me-1"></i> Actualizar Evidencia
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

<style>
    /* Tus estilos existentes se mantienen */
    .archivo-aprobado { border: 2px solid #198754; background: #f0fdf4; border-radius: 14px; padding: 15px; }
    .badge-aprobado { background: linear-gradient(135deg, #22c55e, #16a34a); color: white; font-weight: 600; padding: 8px 14px; border-radius: 999px; box-shadow: 0 4px 12px rgba(34, 197, 94, .25); }
    .card-header-evidencia { background: linear-gradient(135deg, #f8fbff, #eef5ff); }
    .btn-danger, .btn-outline-danger { border-radius: 12px; font-weight: 600; }
    .badge { border-radius: 10px; }
    .card { border-radius: 20px; }
    .style-dropzone input[type="file"] { display: none !important; }
    .style-dropzone .row.align-items-center { background-color: #f8f9fa; border: 1px dashed #dee2e6; border-radius: 0.5rem; }
    .card-unidad-check { cursor: pointer; transition: all 0.2s ease; border: 2px solid #dee2e6 !important; }
    .card-unidad-check:hover { border-color: #0d6efd !important; background-color: #f8f9fa; }
    .card-unidad-check.active { border-color: #198754 !important; background-color: #f0fdf4; }
    .unidad-bloqueada { cursor: not-allowed !important; opacity: 0.75; background-color: #f8f9fa !important; }
    .unidad-bloqueada:hover { border-color: #dee2e6 !important; background-color: #f8f9fa !important; }
    .dropzone-body-collapse { transition: max-height 0.35s ease, opacity 0.3s ease; max-height: 500px; opacity: 1; overflow: hidden; }
    .dropzone-body-collapse.collapsed { max-height: 0px !important; opacity: 0 !important; pointer-events: none; }
    .btn-minimizar { transition: transform 0.25s ease; }
    .btn-minimizar.rotated { transform: rotate(-180deg); }
    .archivo-cargado-item { animation: fadeInItem 0.25s ease-out forwards; }
    .btn-eliminar-archivo:hover { background-color: #fde8e8 !important; color: #dc3545 !important; }
    .rac-edit-row { display: flex; align-items: flex-start; gap: 10px; width: 100%; }
    .rac-edit-badge { min-width: 38px; text-align: center; margin-top: 7px; }
    .rac-edit-file-box { flex: 1; }
    .rac-edit-na-box { min-width: 120px; display: flex; justify-content: center; align-items: center; gap: 6px; background-color: #f8f9fa; border: 1px solid #dee2e6; border-radius: 999px; padding: 6px 12px; margin-top: 2px; box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04); }
    .rac-edit-na-box .form-check-input { margin-top: 0; cursor: pointer; }
    .rac-edit-na-box .form-check-label { cursor: pointer; user-select: none; font-size: 13px; font-weight: 600; color: #6c757d; }
    .rac-edit-file:disabled { background-color: #e9ecef !important; cursor: not-allowed; opacity: 0.75; }
    @media (max-width: 768px) {
        .rac-edit-row { flex-direction: column; align-items: stretch; }
        .rac-edit-na-box { width: 100%; justify-content: flex-start; }
    }
    @keyframes fadeInItem { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
</style>

<script>
    // Variables desde Laravel
    const evidenciaAprobada = @json($evidenciaAprobada);
    const esPrimeraRevision = @json($esPrimeraRevision);
    const totalUnidadesMateria = @json($totalUnidadesMateria);
    const unidadesOcupadas = @json($unidadesOcupadas);
    const sinUnidadesDisponibles = @json($sinUnidadesDisponibles);

    // Estados de aprobación individual por categoría (desde PHP)
    const calificacionesAprobadas = @json($calificacionesAprobadas);
    const racAprobado = @json($racAprobado);
    const rubricasAprobadas = @json($rubricasAprobadas);
    const instrumentosAprobados = @json($instrumentosAprobados);

    const documentosData = @json($documentosData);
    const evidenciasData = @json($evidenciasData);
    const instrumentosExistentesOriginales = @json($instrumentosExistentes);

    let unidadesSeleccionadas = @json(array_values($unidadesSeleccionadas));
    let nuevosArchivosPorUnidad = {};
    let archivosExistentesAEliminar = [];

    const wrapperCalificaciones = document.getElementById('wrapper_calificaciones');
    const wrapperRac = document.getElementById('wrapper_rac');
    const wrapperRubricas = document.getElementById('wrapper_rubricas');
    const seccionDropzones = document.getElementById('seccion_dropzones_dinamicos');

    // Utilidades
    function obtenerArchivo(valor) {
        if (valor && typeof valor === 'object' && !Array.isArray(valor)) return valor.archivo ?? null;
        if (typeof valor === 'string' && valor.trim() !== '') return valor;
        return null;
    }

    function obtenerNa(valor) {
        return !!(valor && typeof valor === 'object' && valor.na);
    }

    function assetStorage(path) {
        return `{{ asset('storage') }}/${path}`;
    }

    function limpiarNombreArchivo(path) {
        return path ? path.split('/').pop() : '';
    }

    function validarArchivoPdf5Mb(input) {
        const maxSize = 5 * 1024 * 1024;
        if (!input.files || input.files.length === 0) return true;
        for (const file of input.files) {
            if (file.type !== 'application/pdf') {
                Swal.fire({ icon: 'warning', title: 'Archivo no permitido', text: 'Solo se permiten archivos en formato PDF.' });
                input.value = '';
                return false;
            }
            if (file.size > maxSize) {
                Swal.fire({ icon: 'warning', title: 'Archivo demasiado pesado', text: `El archivo "${file.name}" supera el límite de 5 MB.` });
                input.value = '';
                return false;
            }
        }
        return true;
    }

    // Gestión de selección de unidades
    function actualizarListaUnidadesDesdeCheckboxes() {
        unidadesSeleccionadas = [];
        const chk0 = document.getElementById('chk_unidad_0');
        if (chk0 && chk0.checked) {
            unidadesSeleccionadas = [0];
            return;
        }
        for (let i = 1; i <= totalUnidadesMateria; i++) {
            const chk = document.getElementById(`chk_unidad_${i}`);
            if (chk && chk.checked && !chk.disabled) unidadesSeleccionadas.push(i);
        }
    }

    window.toggleUnidadTarjeta = function(num) {
        if (evidenciaAprobada) return;
        const checkbox = document.getElementById(`chk_unidad_${num}`);
        const tarjeta = document.getElementById(`card_unidad_${num}`);
        if (!checkbox || !tarjeta || checkbox.disabled) return;
        if (num === 0) {
            for (let i = 1; i <= totalUnidadesMateria; i++) {
                const chk = document.getElementById(`chk_unidad_${i}`);
                const crd = document.getElementById(`card_unidad_${i}`);
                if (chk && chk.checked) { chk.checked = false; crd.classList.remove('active'); }
            }
            checkbox.checked = !checkbox.checked;
            tarjeta.classList.toggle('active', checkbox.checked);
        } else {
            const chk0 = document.getElementById('chk_unidad_0');
            const crd0 = document.getElementById('card_unidad_0');
            if (chk0 && chk0.checked) { chk0.checked = false; crd0.classList.remove('active'); }
            checkbox.checked = !checkbox.checked;
            tarjeta.classList.toggle('active', checkbox.checked);
        }
        actualizarListaUnidadesDesdeCheckboxes();
        procesarCambioUnidadesEdit();
    };

    // Obtener datos guardados por unidad
    function obtenerCalificacionUnidad(unidad) {
        return documentosData?.calificaciones_detalladas?.[`u${unidad}`] ?? null;
    }
    function obtenerRacUnidad(unidad) {
        return documentosData?.rac_detallado?.[`u${unidad}`] ?? null;
    }
    function obtenerRubricaUnidad(unidad) {
        return evidenciasData?.rubricas_detalladas?.[`u${unidad}`] ?? null;
    }

    // Procesamiento central (renderiza dinámicamente según unidades seleccionadas y aprobaciones)
    function procesarCambioUnidadesEdit() {
        actualizarListaUnidadesDesdeCheckboxes();
        const esNingunaUnidad = unidadesSeleccionadas.includes(0);

        if (esNingunaUnidad) {
            wrapperCalificaciones.innerHTML = `<span class="text-muted small">No aplica para esta revisión</span><input type="hidden" name="unidades[]" value="0">`;
            wrapperRac.innerHTML = `<span class="text-muted small">No aplica para esta revisión</span>`;
            wrapperRubricas.innerHTML = `<span class="text-muted small">No aplica para esta revisión</span>`;
            seccionDropzones.innerHTML = `<h5 class="fw-bold text-success mb-3">INSTRUMENTOS DE EVALUACIÓN INDIVIDUALES</h5><div class="alert alert-secondary"><i class="bi bi-ban me-1"></i>No aplica para esta revisión.</div>`;
            nuevosArchivosPorUnidad = {};
            return;
        }

        if (unidadesSeleccionadas.length === 0) {
            wrapperCalificaciones.innerHTML = `<span class="text-muted small">Selecciona unidades primero</span>`;
            wrapperRac.innerHTML = `<span class="text-muted small">Selecciona unidades primero</span>`;
            wrapperRubricas.innerHTML = `<span class="text-muted small">Selecciona unidades primero</span>`;
            seccionDropzones.innerHTML = '';
            nuevosArchivosPorUnidad = {};
            return;
        }

        // Limpiar contenedores
        wrapperCalificaciones.innerHTML = '';
        wrapperRac.innerHTML = '';
        wrapperRubricas.innerHTML = '';

        // -------------------- CALIFICACIONES --------------------
        if (calificacionesAprobadas) {
            wrapperCalificaciones.innerHTML = `<div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Las calificaciones ya fueron aprobadas. No se pueden modificar.</div>`;
        } else {
            unidadesSeleccionadas.forEach(unidad => {
                const calData = obtenerCalificacionUnidad(unidad);
                const rutaCal = obtenerArchivo(calData);
                wrapperCalificaciones.innerHTML += `
                    <div class="mb-2">
                        <span class="badge bg-secondary mb-1">U${unidad}</span>
                        ${rutaCal ? `<div class="d-flex align-items-center bg-light p-1 rounded mb-1"><i class="bi bi-file-earmark-pdf text-danger me-2"></i><a href="${assetStorage(rutaCal)}" target="_blank" class="text-decoration-none small">Actual</a></div>` : ''}
                        <input type="file" name="calificaciones[${unidad}]" class="form-control form-control-sm fs-6 archivo-pdf-5mb" accept="application/pdf" ${evidenciaAprobada ? 'disabled' : ''}>
                        <small class="text-muted">${rutaCal ? 'Dejar vacío para mantener. Solo PDF, máximo 5 MB.' : 'Archivo requerido. Solo PDF, máximo 5 MB.'}</small>
                    </div>
                `;
            });
        }

        // -------------------- RAC --------------------
        if (racAprobado) {
            wrapperRac.innerHTML = `<div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Las actividades de regularización ya fueron aprobadas. No se pueden modificar.</div>`;
        } else {
            unidadesSeleccionadas.forEach(unidad => {
                const racData = obtenerRacUnidad(unidad);
                const racNa = obtenerNa(racData);
                const rutaRac = obtenerArchivo(racData);
                wrapperRac.innerHTML += `
                    <div class="rac-edit-row">
                        <span class="badge bg-secondary rac-edit-badge">U${unidad}</span>
                        <div class="rac-edit-file-box">
                            ${racNa ? `<div class="alert alert-secondary py-2 px-3 mb-2 small"><i class="bi bi-ban me-1"></i>Esta unidad está marcada como No aplica.</div>` : ''}
                            ${(!racNa && rutaRac) ? `<div class="d-flex align-items-center bg-light p-1 rounded mb-1"><i class="bi bi-file-earmark-pdf text-danger me-2"></i><a href="${assetStorage(rutaRac)}" target="_blank" class="text-decoration-none small">Actual</a></div>` : ''}
                            <input type="file" name="rac[${unidad}]" id="rac_file_${unidad}" class="form-control form-control-sm fs-6 rac-edit-file archivo-pdf-5mb" accept="application/pdf" ${racNa || evidenciaAprobada ? 'disabled' : ''}>
                            <small class="text-muted">${rutaRac ? 'Dejar vacío para mantener. Solo PDF, máximo 5 MB.' : 'Sube archivo o marca No aplica. Solo PDF, máximo 5 MB.'}</small>
                        </div>
                        <div class="form-check form-switch rac-edit-na-box">
                            <input class="form-check-input rac-edit-na-toggle" type="checkbox" name="rac_na[${unidad}]" value="1" id="rac_na_${unidad}" data-unidad="${unidad}" ${racNa ? 'checked' : ''} ${evidenciaAprobada ? 'disabled' : ''}>
                            <label class="form-check-label" for="rac_na_${unidad}">No aplica</label>
                        </div>
                    </div>
                `;
            });
        }

        // -------------------- RÚBRICAS --------------------
        if (rubricasAprobadas) {
            wrapperRubricas.innerHTML = `<div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i> Las rúbricas ya fueron aprobadas. No se pueden modificar.</div>`;
        } else {
            unidadesSeleccionadas.forEach(unidad => {
                const rubData = obtenerRubricaUnidad(unidad);
                const rutaRub = obtenerArchivo(rubData);
                wrapperRubricas.innerHTML += `
                    <div class="mb-2">
                        <span class="badge bg-secondary mb-1">U${unidad}</span>
                        ${rutaRub ? `<div class="d-flex align-items-center bg-light p-1 rounded mb-1"><i class="bi bi-file-earmark-pdf text-danger me-2"></i><a href="${assetStorage(rutaRub)}" target="_blank" class="text-decoration-none small">Actual</a></div>` : ''}
                        <input type="file" name="rubricas[${unidad}]" class="form-control form-control-sm fs-6 archivo-pdf-5mb" accept="application/pdf" ${evidenciaAprobada ? 'disabled' : ''}>
                        <small class="text-muted">${rutaRub ? 'Dejar vacío para mantener. Solo PDF, máximo 5 MB.' : 'Archivo requerido. Solo PDF, máximo 5 MB.'}</small>
                    </div>
                `;
            });
        }

        // -------------------- INSTRUMENTOS INDIVIDUALES (DROPZONES) --------------------
        if (instrumentosAprobados) {
            seccionDropzones.innerHTML = `
                <h5 class="fw-bold text-success mb-3">INSTRUMENTOS DE EVALUACIÓN INDIVIDUALES</h5>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i> Los instrumentos de evaluación ya fueron aprobados. No se pueden modificar.
                </div>
            `;
            nuevosArchivosPorUnidad = {};
            return;
        }

        // Construir dropzones normalmente
        seccionDropzones.innerHTML = `<h5 class="fw-bold text-success mb-3">INSTRUMENTOS DE EVALUACIÓN INDIVIDUALES</h5>`;
        unidadesSeleccionadas.forEach(unidad => {
            nuevosArchivosPorUnidad[unidad] = nuevosArchivosPorUnidad[unidad] || [];
            const instrumentosUnidad = instrumentosExistentesOriginales.filter(path => typeof path === 'string' && path.includes(`instrumento_u${unidad}_`));

            seccionDropzones.innerHTML += `
                <div class="card border border-light-subtle rounded-3 shadow-sm p-4 bg-white style-dropzone mb-3" id="dropzone_u_${unidad}">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="p-2.5 rounded-3 bg-success-subtle text-success me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="bi bi-file-earmark-arrow-up"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark fs-5 mb-0">Instrumentos de Evaluación - <span class="text-success">Unidad ${unidad}</span></h5>
                                <p class="text-muted small mb-0">Sube hasta 3 archivos PDF para esta unidad. Máximo 5 MB por archivo.</p>
                            </div>
                        </div>
                        <button type="button" class="btn btn-light border-0 p-2 rounded-circle btn-minimizar" onclick="toggleMinimizarDropzone(${unidad}, this)">
                            <i class="bi bi-chevron-down fs-5 text-secondary"></i>
                        </button>
                    </div>
                    <div class="dropzone-body-collapse mt-3" id="body_dropzone_u_${unidad}">
                        <div class="row align-items-center bg-light p-3 rounded-3 g-3">
                            <div class="col-md-4">
                                <input type="file" id="helper_file_u_${unidad}" class="archivo-pdf-5mb" accept="application/pdf" multiple onchange="agregarArchivosDropzone(this, ${unidad})" ${evidenciaAprobada ? 'disabled' : ''}>
                                <button type="button" class="btn btn-outline-success rounded-pill fw-semibold small px-4 py-2.5 w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" onclick="document.getElementById('helper_file_u_${unidad}').click()" ${evidenciaAprobada ? 'disabled' : ''}>
                                    <i class="bi bi-folder2-open"></i> Archivos Unidad ${unidad}
                                </button>
                            </div>
                            <div class="col-md-8">
                                <div id="lista_archivos_u_${unidad}" class="d-flex flex-column gap-2 text-start">
                                    ${instrumentosUnidad.map(path => `
                                        <div class="archivo-cargado-item d-flex align-items-center justify-content-between p-2.5 bg-white border border-light-subtle rounded-3 shadow-sm">
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 rounded-2 bg-danger-subtle text-danger me-2.5 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                    <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                                                </div>
                                                <span class="text-secondary fw-medium small">${limpiarNombreArchivo(path)}</span>
                                            </div>
                                            ${!evidenciaAprobada ? `<button type="button" class="btn-eliminar-archivo btn border-0 p-2 text-muted rounded-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" onclick="eliminarArchivoExistente(${unidad}, '${path}', this)"><i class="bi bi-trash3 fs-5"></i></button>` : ''}
                                        </div>
                                    `).join('')}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="hidden_inputs_u_${unidad}"></div>
                </div>
            `;
        });

        unidadesSeleccionadas.forEach(unidad => renderizarDropzoneUnidad(unidad));
        aplicarListenersRac();
    }

    // Funciones para dropzones
    window.agregarArchivosDropzone = function(inputElement, unidad) {
        if (!validarArchivoPdf5Mb(inputElement)) return;
        if (!nuevosArchivosPorUnidad[unidad]) nuevosArchivosPorUnidad[unidad] = [];
        for (let file of inputElement.files) {
            if (file.type !== 'application/pdf') continue;
            if (file.size > 5 * 1024 * 1024) continue;
            if (nuevosArchivosPorUnidad[unidad].length >= 3) {
                Swal.fire({ icon: 'info', title: 'Límite alcanzado', text: 'Solo puedes subir hasta 3 archivos PDF por unidad.' });
                break;
            }
            nuevosArchivosPorUnidad[unidad].push(file);
        }
        renderizarDropzoneUnidad(unidad);
        inputElement.value = '';
    };

    window.eliminarArchivoExistente = function(unidad, ruta, boton) {
        if (evidenciaAprobada) return;
        Swal.fire({
            icon: 'warning', title: '¿Eliminar archivo?', text: 'Este archivo se eliminará al actualizar la evidencia.',
            showCancelButton: true, confirmButtonText: 'Sí, eliminar', cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) return;
            archivosExistentesAEliminar.push(ruta);
            const item = boton.closest('.archivo-cargado-item');
            if (item) item.remove();
            const hiddenContainer = document.getElementById(`hidden_inputs_u_${unidad}`);
            const inputDel = document.createElement('input');
            inputDel.type = 'hidden';
            inputDel.name = `eliminar_instrumentos[${unidad}][]`;
            inputDel.value = ruta;
            hiddenContainer.appendChild(inputDel);
        });
    };

    function renderizarDropzoneUnidad(unidad) {
        const lista = document.getElementById(`lista_archivos_u_${unidad}`);
        const hiddenContainer = document.getElementById(`hidden_inputs_u_${unidad}`);
        const files = nuevosArchivosPorUnidad[unidad] || [];
        if (!lista || !hiddenContainer) return;
        const nuevosItems = lista.querySelectorAll('.archivo-nuevo');
        nuevosItems.forEach(el => el.remove());
        files.forEach((file, index) => {
            const nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'archivo-cargado-item archivo-nuevo d-flex align-items-center justify-content-between p-2.5 bg-white border border-light-subtle rounded-3 shadow-sm';
            nuevoDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded-2 bg-danger-subtle text-danger me-2.5 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;"><i class="bi bi-file-earmark-pdf-fill fs-5"></i></div>
                    <span class="text-secondary fw-medium small">${file.name}</span>
                </div>
                <button type="button" class="btn-eliminar-archivo btn border-0 p-2 text-muted rounded-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" onclick="eliminarArchivoNuevo(${unidad}, ${index})"><i class="bi bi-trash3 fs-5"></i></button>
            `;
            lista.appendChild(nuevoDiv);
        });
        const dt = new DataTransfer();
        files.forEach(f => dt.items.add(f));
        let realInput = hiddenContainer.querySelector('input[type="file"][name^="instrumentos"]');
        if (!realInput) {
            realInput = document.createElement('input');
            realInput.type = 'file';
            realInput.name = `instrumentos[${unidad}][]`;
            realInput.multiple = true;
            realInput.className = 'd-none';
            hiddenContainer.appendChild(realInput);
        }
        realInput.files = dt.files;
    }

    window.eliminarArchivoNuevo = function(unidad, index) {
        nuevosArchivosPorUnidad[unidad].splice(index, 1);
        renderizarDropzoneUnidad(unidad);
    };

    window.toggleMinimizarDropzone = function(unidad, boton) {
        const cuerpo = document.getElementById(`body_dropzone_u_${unidad}`);
        if (!cuerpo) return;
        cuerpo.classList.toggle('collapsed');
        boton.classList.toggle('rotated');
    };

    function aplicarListenersRac() {
        document.querySelectorAll('.rac-edit-na-toggle').forEach(checkbox => {
            aplicarRacNoAplicaUnidad(checkbox);
            checkbox.addEventListener('change', function() { aplicarRacNoAplicaUnidad(this); });
        });
    }

    function aplicarRacNoAplicaUnidad(checkbox) {
        const unidad = checkbox.dataset.unidad;
        const inputFile = document.getElementById('rac_file_' + unidad);
        if (!inputFile) return;
        if (checkbox.checked) {
            inputFile.value = '';
            inputFile.disabled = true;
        } else {
            inputFile.disabled = evidenciaAprobada ? true : false;
        }
    }

    // Validación global para archivos PDF
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('archivo-pdf-5mb')) validarArchivoPdf5Mb(e.target);
    });

    // Inicialización
    document.addEventListener('DOMContentLoaded', function() {
        procesarCambioUnidadesEdit();
        aplicarListenersRac();
    });
</script>

@endsection