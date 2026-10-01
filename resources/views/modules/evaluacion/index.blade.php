@extends('layouts.main')

@section('titulo', 'Evaluar Evidencia')

@section('contenido')

@php
$datosEvidencia = is_array($evidencia->documentos)
? $evidencia->documentos
: json_decode($evidencia->documentos ?? '[]', true);

if (!is_array($datosEvidencia)) {
$datosEvidencia = [];
}

$documentosEvidencia = $datosEvidencia['documentos'] ?? [];

$motivoNoEvaluoGeneral = $datosEvidencia['motivo_no_evaluo']
?? ($documentosEvidencia['calificaciones']['motivo'] ?? null)
?? ($documentosEvidencia['calificaciones_detalladas']['u0']['motivo'] ?? null)
?? null;

// Obtener evaluaciones existentes para avance_programatico y asiste_seguimiento
$evaluacionAvance = $evidencia->evaluacion['avance_programatico'] ?? [];
$evaluacionSeguimiento = $evidencia->evaluacion['asiste_seguimiento'] ?? [];

$avanceNa = !empty($evaluacionAvance['na']);
$avanceCalif = $evaluacionAvance['calificacion'] ?? '';
$avanceObs = $evaluacionAvance['observaciones'] ?? '';

$seguimientoNa = !empty($evaluacionSeguimiento['na']);
$seguimientoCalif = $evaluacionSeguimiento['calificacion'] ?? '';
$seguimientoObs = $evaluacionSeguimiento['observaciones'] ?? '';
@endphp

<main id="main" class="main">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary">
            <i class="bi bi-clipboard-check me-2"></i>
            Evaluación de Evidencias
        </h1>

        <form action="{{ route('evaluaciones.destroy', $evidencia->id) }}"
            method="POST"
            id="form-eliminar-evaluacion">
            @csrf
            @method('DELETE')
            <button type="button" class="btn btn-outline-danger" onclick="confirmarEliminarEvidencia(event)">
                <i class="fa-solid fa-trash-can"></i>
                Eliminar Evidencia
            </button>
        </form>
    </div>

    {{-- Información de la evidencia --}}
    <div class="card bg-light border-0 shadow-sm mb-4">
        <div class="card-body py-3 px-4">
            <div class="row text-center text-md-start">
                <div class="col-md-4 mb-2 mb-md-0">
                    <i class="bi bi-arrow-repeat me-1 text-primary"></i>
                    <strong>Revisión:</strong> {{ $evidencia->revision->nombre }}
                </div>
                <div class="col-md-4 mb-2 mb-md-0">
                    <i class="bi bi-book me-1 text-primary"></i>
                    <strong>Materia:</strong> {{ $evidencia->materia->nombre }}
                </div>
                <div class="col-md-4">
                    <i class="bi bi-person-circle me-1 text-primary"></i>
                    <strong>Docente:</strong> {{ $evidencia->asignacionMateria->docente->user->name ?? 'No asignado' }}
                </div>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="card border-0 shadow-lg p-4" style="border-radius: 18px;">
            <form  id="form-evaluacion" method="POST" action="{{ route('evaluaciones.update', $evidencia->id) }}">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <div class="list-group list-group-flush border rounded-4 p-2 bg-light sticky-top"
                            style="top: 80px;">

                            <h6 class="px-3 py-2 text-uppercase text-muted small fw-bold">
                                Secciones
                            </h6>

                            @foreach ($items as $i => $doc)
                            @php
                            $evaluacion = $evidencia->evaluacion[$doc['key']] ?? [];

                            $documentoNaLista = !empty($doc['documento_na']);

                            $archivoLista = $doc['archivo'] ?? null;

                            if (is_array($archivoLista)) {
                            $documentoNaLista = $documentoNaLista || !empty($archivoLista['na']);
                            }

                            $archivosMultiplesLista = $doc['archivos_multiples'] ?? [];
                            $hayArchivoMultipleLista = false;
                            $hayNaMultipleLista = false;

                            foreach ($archivosMultiplesLista as $pdfLista) {
                            if (is_array($pdfLista)) {
                            if (!empty($pdfLista['archivo'])) {
                            $hayArchivoMultipleLista = true;
                            }

                            if (!empty($pdfLista['na'])) {
                            $hayNaMultipleLista = true;
                            }
                            } elseif (is_string($pdfLista) && trim($pdfLista) !== '') {
                            $hayArchivoMultipleLista = true;
                            }
                            }

                            if (!$hayArchivoMultipleLista && $hayNaMultipleLista) {
                            $documentoNaLista = true;
                            }

                            $esNA = !empty($evaluacion['na']) || $documentoNaLista;
                            $calificacion = $evaluacion['calificacion'] ?? null;
                            @endphp

                            <button type="button"
                                class="list-group-item list-group-item-action border-0 rounded-pill mb-1 documento-btn d-flex justify-content-between align-items-center {{ $i == 0 ? 'active text-white bg-primary' : '' }}"
                                data-target="doc-{{ $doc['key'] }}">

                                <span>
                                    <i class="bi bi-file-earmark-text me-2"></i>
                                    {{ $doc['nombre'] }}
                                </span>

                                @if ($esNA)
                                <span class="badge bg-secondary">
                                    N/A
                                </span>
                                @elseif($calificacion !== null && $calificacion !== '')
                                @if ($calificacion >= 70)
                                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                @else
                                <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                @endif
                                @endif

                            </button>
                            @endforeach

                        </div>
                    </div>

                    <div class="col-md-8">
                        @foreach ($items as $i => $doc)
                        <div class="documento-panel {{ $i == 0 ? '' : 'd-none' }}" id="doc-{{ $doc['key'] }}">
                            <div class="card border border-light-subtle shadow-sm mb-4">
                                <div class="card-body p-4">

                                    <h4 class="fw-bold text-primary mb-4">
                                        {{ $doc['nombre'] }}
                                    </h4>

                                    <div class="mb-4 bg-light border rounded overflow-hidden" style="height: 60vh;">
                                        @php
                                        $archivosMultiplesOriginales = $doc['archivos_multiples'] ?? [];
                                        $archivosMultiples = [];

                                        $hayArchivoMultiple = false;
                                        $hayNaMultiple = false;

                                        foreach ($archivosMultiplesOriginales as $pdf) {
                                        if (is_array($pdf)) {
                                        if (!empty($pdf['archivo'])) {
                                        $archivosMultiples[] = $pdf['archivo'];
                                        $hayArchivoMultiple = true;
                                        }

                                        if (!empty($pdf['na'])) {
                                        $hayNaMultiple = true;
                                        }
                                        } elseif (is_string($pdf) && trim($pdf) !== '') {
                                        $archivosMultiples[] = $pdf;
                                        $hayArchivoMultiple = true;
                                        }
                                        }

                                        $archivoPrincipal = $doc['archivo'] ?? null;
                                        $documentoNa = !empty($doc['documento_na']);

                                        if (is_array($archivoPrincipal)) {
                                        $documentoNa = $documentoNa || !empty($archivoPrincipal['na']);
                                        $archivoPrincipal = $archivoPrincipal['archivo'] ?? null;
                                        }

                                        if (!is_string($archivoPrincipal)) {
                                        $archivoPrincipal = null;
                                        }

                                        if (!$hayArchivoMultiple && $hayNaMultiple) {
                                        $documentoNa = true;
                                        }

                                        $motivoItem = $doc['motivo_no_evaluo'] ?? null;
                                        @endphp

                                        @if ($documentoNa)
                                        <div class="d-flex align-items-center justify-content-center h-100 bg-light">
                                            <div class="text-center px-4" style="max-width: 650px;">
                                                <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-secondary-subtle text-secondary mb-3"
                                                    style="width: 72px; height: 72px;">
                                                    <i class="bi bi-dash-circle fs-1"></i>
                                                </div>

                                                <h5 class="fw-bold text-secondary mb-2">
                                                    No aplica (N/A)
                                                </h5>

                                                @if (!empty($motivoItem))
                                                <div class="alert alert-warning text-start border-0 shadow-sm rounded-3 mt-3 mb-0">
                                                    <h6 class="fw-bold mb-2 text-dark">
                                                        <i class="bi bi-exclamation-circle-fill me-1 text-warning"></i>
                                                        Motivo por el que no se evaluó ninguna unidad
                                                    </h6>
                                                    <p class="mb-0 text-dark">
                                                        {{ $motivoItem }}
                                                    </p>
                                                </div>
                                                @else
                                                <p class="mb-0 text-muted">
                                                    Este apartado fue marcado como no aplicable por el docente.
                                                </p>
                                                @endif
                                            </div>
                                        </div>
                                        @elseif (count($archivosMultiples) > 1)
                                        <div class="d-flex flex-column h-100 w-100">

                                            <div
                                                class="d-flex justify-content-between align-items-center mb-2 bg-white p-2 rounded border shadow-sm">

                                                <ul class="nav nav-pills gap-2 flex-wrap"
                                                    id="pills-{{ $doc['key'] }}"
                                                    role="tablist">

                                                    @foreach ($archivosMultiples as $index => $pdf)
                                                    @php
                                                    $nombreArchivo = basename($pdf);
                                                    $nombreArchivoCorto = \Illuminate\Support\Str::limit($nombreArchivo, 28);
                                                    @endphp

                                                    <li class="nav-item" role="presentation">
                                                        <button
                                                            class="nav-link btn-sm archivo-tab-btn {{ $index == 0 ? 'active text-white bg-primary' : 'bg-light text-dark border' }}"
                                                            id="btn-{{ $doc['key'] }}-{{ $index }}"
                                                            type="button"
                                                            title="{{ $nombreArchivo }}"
                                                            onclick="cambiarPdfMultiple('{{ asset('storage/' . $pdf) }}', 'iframe-{{ $doc['key'] }}', this, 'btn-{{ $doc['key'] }}')">

                                                            <i class="bi bi-file-earmark-pdf me-1"></i>

                                                            <span class="archivo-tab-name">
                                                                {{ $nombreArchivoCorto }}
                                                            </span>
                                                        </button>
                                                    </li>
                                                    @endforeach

                                                </ul>

                                                <a href="{{ asset('storage/' . $archivosMultiples[0]) }}"
                                                    target="_blank"
                                                    id="link-exterior-{{ $doc['key'] }}"
                                                    class="btn btn-outline-secondary btn-sm"
                                                    title="Abrir en pantalla completa">
                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            </div>

                                            <div class="flex-grow-1 w-100 border rounded"
                                                style="background-color: #525659;">

                                                <iframe id="iframe-{{ $doc['key'] }}"
                                                    src="{{ asset('storage/' . $archivosMultiples[0]) }}"
                                                    width="100%"
                                                    height="100%"
                                                    style="border:none; border-radius: 4px;">
                                                </iframe>

                                            </div>
                                        </div>
                                        @elseif(count($archivosMultiples) == 1)
                                        <iframe src="{{ asset('storage/' . $archivosMultiples[0]) }}"
                                            width="100%"
                                            height="100%"
                                            style="border:none;">
                                        </iframe>
                                        @elseif(!empty($archivoPrincipal))
                                        <iframe src="{{ asset('storage/' . $archivoPrincipal) }}"
                                            width="100%"
                                            height="100%"
                                            style="border:none;">
                                        </iframe>
                                        @else
                                        <div
                                            class="d-flex align-items-center justify-content-center text-muted h-100 bg-secondary-subtle">
                                            <div class="text-center">
                                                <i class="bi bi-file-earmark-x fs-1 mb-2 d-block"></i>
                                                <p class="mb-0">
                                                    El docente no adjuntó este documento.
                                                </p>
                                            </div>
                                        </div>
                                        @endif
                                    </div>

                                    @php
                                    $evaluacionActual = $evidencia->evaluacion[$doc['key']] ?? [];
                                    $checkNa = !empty($evaluacionActual['na']) || $documentoNa;
                                    @endphp

                                    <div class="bg-primary-subtle p-3 rounded-3 form-evaluacion" data-key="{{ $doc['key'] }}">

                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="fw-bold text-primary mb-0">
                                                <i class="bi bi-pencil-square me-2"></i>
                                                Calificación del panel
                                            </h6>

                                            <span
                                                class="badge rounded-pill bg-success d-none status-badge shadow-sm transition-all"
                                                id="status-{{ $doc['key'] }}">
                                                Guardado ✓
                                            </span>
                                        </div>

                                        <div class="form-check form-switch mb-3">
                                            <input class="form-check-input auto-save-input na-toggle"
                                                type="checkbox"
                                                name="evaluaciones[{{ $doc['key'] }}][na]"
                                                value="1"
                                                id="na-{{ $doc['key'] }}"
                                                data-key="{{ $doc['key'] }}"
                                                {{ $checkNa ? 'checked' : '' }}>

                                            <label class="form-check-label fw-semibold text-secondary"
                                                for="na-{{ $doc['key'] }}">
                                                No aplica (N/A)
                                            </label>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <input type="number"
                                                    class="form-control auto-save-input calificacion-input"
                                                    placeholder="Calificación (0-100)"
                                                    name="evaluaciones[{{ $doc['key'] }}][calificacion]"
                                                    id="calificacion-{{ $doc['key'] }}"
                                                    value="{{ $evidencia->evaluacion[$doc['key']]['calificacion'] ?? '' }}"
                                                    min="0"
                                                    max="100">
                                            </div>

                                            <div class="col-md-9">
                                                <textarea rows="2"
                                                    class="form-control auto-save-input"
                                                    placeholder="Escribe tus observaciones aquí..."
                                                    name="evaluaciones[{{ $doc['key'] }}][observaciones]">{{ $evidencia->evaluacion[$doc['key']]['observaciones'] ?? '' }}</textarea>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-4 text-end border-top pt-4">
                    <a href="{{ route('seguimiento-academico') }}"
                        class="btn btn-light border rounded-pill px-4 me-2">
                        Cancelar
                    </a>

                    <button type="button"
                        class="btn btn-primary rounded-pill px-5 shadow"
                        id="btnFinalizar">
                        <i class="bi bi-check2-all me-1"></i>
                        Finalizar y Aprobar/Rechazar Evidencia
                    </button>

                    <p class="small text-muted mt-2 mb-0">
                        *(Los avances de calificación individuales ya están guardados)
                    </p>
                </div>
            </form>
        </div>
    </section>
</main>
@push('scripts')
    @include('modules.evaluacion.scripts')
@endpush
<style>
    .documento-panel {
        animation: fadeIn 0.4s ease;
    }

    .transition-all {
        transition: all 0.3s ease;
    }

    .input-disabled-na {
        background-color: #e9ecef !important;
        cursor: not-allowed;
        opacity: 0.75;
    }

    .archivo-tab-btn {
        max-width: 220px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
    }

    .archivo-tab-name {
        display: inline-block;
        max-width: 175px;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        vertical-align: middle;
    }

    @media (max-width: 768px) {
        .archivo-tab-btn {
            max-width: 100%;
        }

        .archivo-tab-name {
            max-width: 230px;
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

@endsection