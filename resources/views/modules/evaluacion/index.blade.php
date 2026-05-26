@extends('layouts.main')

@section('titulo', 'Evaluar Evidencia')

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">Evaluación de Evidencias</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('archivos') }}" class="text-decoration-none text-secondary">Evidencias</a></li>
                <li class="breadcrumb-item active text-primary fw-semibold">Evaluar Estructura</li>
            </ol>
        </nav>
    </div>

    @php
        // Creamos un mapeo estructurado con tus comentarios de migración
        $documentos = [
            'doc_a' => ['nombre' => 'Instrumentación didáctica', 'archivo' => $evidenciaActual->doc_a],
            'doc_b' => ['nombre' => 'Lista de calificaciones', 'archivo' => $evidenciaActual->doc_b],
            'doc_c' => ['nombre' => 'Reporte y acuerdos', 'archivo' => $evidenciaActual->doc_c],
            'evi_a' => ['nombre' => 'Muestra de tareas', 'archivo' => $evidenciaActual->evi_a],
            'evi_b' => ['nombre' => 'Rúbricas utilizadas', 'archivo' => $evidenciaActual->evi_b],
            'evi_c' => ['nombre' => 'Examen diagnóstico', 'archivo' => $evidenciaActual->evi_c],
        ];

        // Buscar el primer documento que sí tenga un archivo para ponerlo activo por defecto
        $primerDocumentoActivo = collect($documentos)->firstWhere('archivo', '!=', null);
    @endphp

    <section class="section">
        <div class="row g-4">
            
            {{-- PANEL IZQUIERDO: VISOR MULTI-DOCUMENTO (INTERACTIVO) --}}
            <div class="col-xl-8 col-lg-7">
                <div class="card border-0 shadow-lg h-100 evaluation-card">
                    
                    {{-- Pestañas de Navegación entre Archivos Adjuntos --}}
                    <div class="card-header bg-dark p-2">
                        <ul class="nav nav-pills card-header-pills custom-pills" id="pdfTabs" role="tablist">
                            @foreach($documentos as $key => $doc)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link @if($doc['archivo'] && $primerDocumentoActivo['archivo'] == $doc['archivo']) active @endif @if(!$doc['archivo']) disabled opacity-50 @endif" 
                                            id="tab-{{ $key }}" 
                                            data-bs-toggle="tab" 
                                            data-bs-target="#content-{{ $key }}" 
                                            type="button" 
                                            role="tab" 
                                            aria-selected="true">
                                        <i class="bi @if($doc['archivo']) bi-file-earmark-pdf-fill text-danger @else bi-file-earmark-x text-muted @endif me-1"></i>
                                        {{ $doc['nombre'] }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Contenedores de visualización --}}
                    <div class="card-body p-0 view-container tab-content" id="pdfTabsContent">
                        @foreach($documentos as $key => $doc)
                            <div class="tab-pane fade h-100 @if($doc['archivo'] && $primerDocumentoActivo['archivo'] == $doc['archivo']) show active @endif" 
                                 id="content-{{ $key }}" 
                                 role="tabpanel">
                                @if($doc['archivo'])
                                    {{-- Visor dinámico usando tu ruta base64_encode --}}
                                    <iframe src="{{ route('archivos.ver', ['ruta' => base64_encode($doc['archivo'])]) }}#toolbar=1" width="100%" height="100%" style="border: none;"></iframe>
                                @else
                                    <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted bg-light">
                                        <i class="bi bi-cloud-slash display-3 mb-2"></i>
                                        <p class="fw-semibold">Este documento no fue requerido o no se adjuntó</p>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- PANEL DERECHO: DICTAMEN DE EVALUACIÓN --}}
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow-lg evaluation-card h-100">
                    <div class="card-header bg-light border-bottom p-4">
                        <h5 class="fw-bold text-dark mb-1">Detalles del Envío</h5>
                        <p class="text-muted small mb-0">Control escolar e ingeniería de sistemas</p>
                    </div>
                    
                    <div class="card-body p-4">
                        {{-- Bloque Informativo --}}
                        <div class="mb-4 bg-light p-3 rounded-3 border">
                            <div class="mb-3">
                                <small class="text-uppercase text-secondary fw-bold d-block mb-1">Docente</small>
                                <span class="fw-semibold text-dark">{{ $materia->asignaciones->first()?->docente?->name ?? 'Profesor Asignado' }}</span>
                            </div>
                            <div class="mb-3">
                                <small class="text-uppercase text-secondary fw-bold d-block mb-1">Asignatura</small>
                                <span class="fw-semibold text-dark">{{ $materia->nombre }}</span>
                            </div>
                            <div class="mb-3">
                                <small class="text-uppercase text-secondary fw-bold d-block mb-1">Estructura / Revisión</small>
                                <span class="badge bg-primary text-white rounded-pill px-3 py-2 fw-semibold">{{ $revision->nombre }}</span>
                            </div>
                            <div class="mb-0">
                                <small class="text-uppercase text-secondary fw-bold d-block mb-1">Hora de Carga (Profesor)</small>
                                <span class="fw-semibold text-dark text-capitalize">
                                    <i class="bi bi-clock-history me-1 text-primary"></i>
                                    {{ \Carbon\Carbon::parse($evidenciaActual->created_at)->translatedFormat('d \d\e F, Y \a \l\a\s g:i A') }}
                                </span>
                            </div>
                        </div>

                        <hr class="text-muted my-4">

                        {{-- Formulario POST hacia guardar-evaluacion --}}
                        <form action="{{ route('evidencias-guardar-evaluacion', $evidenciaActual->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="form-label text-uppercase text-secondary fw-bold small mb-3">Dictamen Final</label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="estado" id="estado_aprobado" value="2" {{ $evidenciaActual->estado == 2 ? 'checked' : '' }} autocomplete="off">
                                        <label class="btn btn-outline-success w-100 py-3 rounded-3 d-flex flex-column align-items-center justify-content-center gap-2 option-selector" for="estado_aprobado">
                                            <i class="bi bi-check-circle-fill fs-4"></i>
                                            <span class="fw-bold small">Aprobar</span>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="estado" id="estado_rechazado" value="4" {{ $evidenciaActual->estado == 4 ? 'checked' : '' }} autocomplete="off">
                                        <label class="btn btn-outline-danger w-100 py-3 rounded-3 d-flex flex-column align-items-center justify-content-center gap-2 option-selector" for="estado_rechazado">
                                            <i class="bi bi-x-circle-fill fs-4"></i>
                                            <span class="fw-bold small">Rechazar</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="observaciones" class="form-label text-uppercase text-secondary fw-bold small">Observaciones / Correcciones</label>
                                <textarea class="form-control border-secondary-subtle" id="observaciones" name="observaciones" rows="5" placeholder="Escribe observaciones específicas sobre qué corregir si decides rechazar..." style="border-radius: 12px; resize: none;">{{ $evidenciaActual->observaciones }}</textarea>
                            </div>

                            <div class="d-grid gap-2 pt-2">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold shadow-sm py-2 fs-6">
                                    <i class="bi bi-check-all me-2"></i>Emitir Evaluación
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-light border rounded-pill fw-semibold py-2">
                                    Regresar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>

<style>
    .evaluation-card {
        border-radius: 20px;
        overflow: hidden;
        background: white;
    }

    .custom-pills .nav-link {
        color: #a0aec0;
        font-size: 12px;
        font-weight: 600;
        border-radius: 8px;
        padding: 8px 12px;
        margin: 2px;
    }

    .custom-pills .nav-link.active {
        background-color: rgba(255, 255, 255, 0.15) !important;
        color: #fff !important;
    }

    .view-container {
        height: calc(100vh - 240px);
        min-height: 580px;
        background: #f4f6f9;
    }

    .option-selector {
        border-width: 2px;
        transition: all 0.25s ease;
        background-color: #fff;
    }

    .btn-check:checked + .btn-outline-success {
        background: linear-gradient(135deg, #10b981, #059669) !important;
        color: white !important;
        border-color: transparent !important;
        box-shadow: 0 8px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-check:checked + .btn-outline-danger {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        color: white !important;
        border-color: transparent !important;
        box-shadow: 0 8px 15px rgba(239, 68, 68, 0.3);
    }

    .option-selector:hover {
        transform: translateY(-2px);
    }
</style>

@endsection