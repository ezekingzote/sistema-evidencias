@extends('layouts.main')

@section('titulo', 'Visualizar Evidencia')

@section('contenido')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-success">Consulta de Evidencia</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('evidencias') }}" class="text-decoration-none">Evidencias</a></li>
                <li class="breadcrumb-item active fw-semibold">Consultar</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                {{-- CUERPO DE DOCUMENTOS CONGELADOS --}}
                <div class="card border-0 shadow-lg p-4" style="border-radius: 20px; background: white;">
                    <div class="mb-4">
                        <h5 class="fw-bold text-secondary mb-1">Materia: <span class="text-dark">{{ $materia->nombre }}</span></h5>
                        <p class="text-muted small">Haga clic en cualquiera de los botones de previsualización para abrir los expedientes validados.</p>
                    </div>

                    @php
                    $documentos = [
                    'doc_a' => 'a) Instrumentación didáctica completa',
                    'doc_b' => 'b) Lista de calificaciones',
                    'doc_c' => 'c) Reporte y acuerdos'
                    ];

                    $evidenciasArchivos = [
                    'evi_a' => 'a) Muestra de tareas y trabajos complementarios',
                    'evi_b' => 'b) Rúbricas utilizadas para tareas y trabajos',
                    'evi_c' => 'c) Examen diagnóstico y análisis'
                    ];
                    @endphp

                    <div class="row g-4">

                        {{-- DOCUMENTOS --}}
                        <div class="col-md-6">

                            <div class="section-box">

                                <h4 class="section-title">
                                    <i class="bi bi-folder2-open me-2"></i>
                                    Documentos
                                </h4>

                                @foreach($documentos as $campo => $label)

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        {{ $label }}
                                    </label>

                                    @if($evidencia && $evidencia->$campo)

                                    @php
                                    $rutaSegura = base64_encode($evidencia->$campo);
                                    $urlVerPdf = route('archivos.ver', ['ruta' => $rutaSegura]);
                                    $nombreCorto = basename($evidencia->$campo);
                                    @endphp

                                    <div class="d-flex align-items-center justify-content-between bg-white border rounded p-2">

                                        <div class="text-truncate">
                                            <i class="bi bi-file-earmark-check-fill text-success me-2"></i>
                                            {{ $nombreCorto }}
                                        </div>

                                        <button
                                            type="button"
                                            class="btn btn-success btn-sm btn-preview-pdf"
                                            data-url="{{ $urlVerPdf }}"
                                            data-name="{{ $nombreCorto }}">
                                            Ver PDF
                                        </button>

                                    </div>

                                    @else

                                    <div class="alert alert-light border small mb-0">
                                        No se adjuntó este expediente.
                                    </div>

                                    @endif

                                </div>

                                @endforeach

                            </div>

                        </div>

                        {{-- EVIDENCIAS --}}
                        <div class="col-md-6">

                            <div class="section-box">

                                <h4 class="section-title">
                                    <i class="bi bi-journal-check me-2"></i>
                                    Evidencias
                                </h4>

                                @foreach($evidenciasArchivos as $campo => $label)

                                <div class="mb-4">

                                    <label class="form-label fw-semibold">
                                        {{ $label }}
                                    </label>

                                    @if($evidencia && $evidencia->$campo)

                                    @php
                                    $rutaSegura = base64_encode($evidencia->$campo);
                                    $urlVerPdf = route('archivos.ver', ['ruta' => $rutaSegura]);
                                    $nombreCorto = basename($evidencia->$campo);
                                    @endphp

                                    <div class="d-flex align-items-center justify-content-between bg-white border rounded p-2">

                                        <div class="text-truncate">
                                            <i class="bi bi-file-earmark-check-fill text-success me-2"></i>
                                            {{ $nombreCorto }}
                                        </div>

                                        <button
                                            type="button"
                                            class="btn btn-success btn-sm btn-preview-pdf"
                                            data-url="{{ $urlVerPdf }}"
                                            data-name="{{ $nombreCorto }}">
                                            Ver PDF
                                        </button>

                                    </div>

                                    @else

                                    <div class="alert alert-light border small mb-0">
                                        No se adjuntó este expediente.
                                    </div>

                                    @endif

                                </div>

                                @endforeach

                            </div>

                        </div>

                    </div>

                    <hr class="my-4 style-hr" style="opacity:0.1;">

                    <div>
                        <a href="{{ route('evidencias') }}" class="btn btn-light px-4 py-2 rounded-pill border fw-semibold small">
                            <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Volver a la Lista
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-preview-pdf').forEach(btn => {
            btn.addEventListener('click', function() {
                const pdfUrl = this.getAttribute('data-url');
                const pdfName = this.getAttribute('data-name');

                Swal.fire({
                    title: `<span class="fs-5 text-dark fw-bold text-truncate d-block px-3">${pdfName}</span>`,
                    html: `
                        <div style="width: 100%; height: 72vh; overflow: hidden; border-radius: 8px; border: 1px solid #dee2e6;">
                            <iframe src="${pdfUrl}#toolbar=1" width="100%" height="100%" style="border: none;"></iframe>
                        </div>
                    `,
                    width: '85%',
                    showCloseButton: true,
                    showConfirmButton: false,
                    focusConfirm: false,
                    customClass: {
                        popup: 'rounded-4 shadow-lg'
                    }
                });
            });
        });

        const selectRevision = document.getElementById('selectRevision');
        if (selectRevision) {
            selectRevision.addEventListener('change', function() {
                const revisionId = this.value;
                const materiaId = this.getAttribute('data-materia');
                if (revisionId && materiaId) {
                    window.location.href = `/evidencias/cambiar-revision/${revisionId}?materia_id=${materiaId}`;
                }
            });
        }
    });
</script>
<style>
    .section-box {
        background: #fafcff;
        border: 1px solid #e9f0fa;
        border-radius: 16px;
        padding: 25px;
        height: 100%;
    }

    .section-title {
        font-size: 20px;
        font-weight: 700;
        color: #0d6efd;
        margin-bottom: 25px;
    }
</style>
@endsection