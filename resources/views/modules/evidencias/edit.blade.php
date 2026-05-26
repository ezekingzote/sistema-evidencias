@extends('layouts.main')

@section('titulo', 'Editar Evidencia')

@section('contenido')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">Modificación de Entrega</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('evidencias') }}" class="text-decoration-none">Evidencias</a></li>
                <li class="breadcrumb-item active fw-semibold">Editar</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">


                {{-- PANEL DEL FORMULARIO --}}
                <div class="card border-0 shadow-lg p-4" style="border-radius: 20px; background: white;">
                    <div class="mb-4">
                        <h5 class="fw-bold text-secondary mb-1">Asignatura: <span class="text-dark">{{ $materia->nombre }}</span></h5>
                        <p class="text-muted small">Los archivos guardados previamente mantendrán su validez si decides no reemplazarlos.</p>
                    </div>

                    <form action="{{ route('evidencias.update', $evidencia->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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

                        {{-- DOCUMENTOS --}}
                        <div class="mb-4">
                            <h4 class="fw-bold text-primary border-bottom pb-2">
                                <i class="bi bi-folder-fill me-2"></i>
                                Documentos
                            </h4>
                            <p class="text-muted small mb-0">
                                Archivos administrativos y de seguimiento de la asignatura.
                            </p>
                        </div>

                        <div class="row g-4 mb-5">
                            @foreach($documentos as $campo => $label)
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100 d-flex flex-column justify-content-between row-file-card">

                                    <div>
                                        <label class="form-label fw-bold text-dark small text-uppercase mb-2 d-block">
                                            {{ $label }}
                                        </label>

                                        @if($evidencia->$campo)
                                        @php
                                        $rutaSegura = base64_encode($evidencia->$campo);
                                        $urlVerPdf = route('archivos.ver', ['ruta' => $rutaSegura]);
                                        $nombreCorto = basename($evidencia->$campo);
                                        @endphp

                                        <div class="d-flex align-items-center justify-content-between bg-white border rounded p-2 mb-3 shadow-sm">
                                            <div class="d-flex align-items-center text-truncate" style="min-width:0;">
                                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                                <span class="small fw-semibold text-muted text-truncate"
                                                    title="{{ $nombreCorto }}">
                                                    {{ $nombreCorto }}
                                                </span>
                                            </div>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-preview-pdf ms-2"
                                                data-url="{{ $urlVerPdf }}"
                                                data-name="{{ $nombreCorto }}">
                                                <i class="bi bi-eye"></i> Ver
                                            </button>
                                        </div>
                                        @else
                                        <div class="alert alert-light py-1 px-2 small mb-3 border text-center rounded-2 text-muted">
                                            <i class="bi bi-slash-circle me-1"></i>
                                            Inhabilitada para previsualización
                                        </div>
                                        @endif
                                    </div>

                                    <input
                                        type="file"
                                        class="form-control form-control-sm"
                                        name="{{ $campo }}"
                                        accept="application/pdf">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- EVIDENCIAS --}}
                        <div class="mb-4">
                            <h4 class="fw-bold text-success border-bottom pb-2">
                                <i class="bi bi-journal-check me-2"></i>
                                Evidencias
                            </h4>
                            <p class="text-muted small mb-0">
                                Evidencias académicas utilizadas durante el proceso de evaluación.
                            </p>
                        </div>

                        <div class="row g-4">
                            @foreach($evidenciasArchivos as $campo => $label)
                            <div class="col-md-4">
                                <div class="p-3 border rounded-3 bg-light-subtle h-100 d-flex flex-column justify-content-between row-file-card">

                                    <div>
                                        <label class="form-label fw-bold text-dark small text-uppercase mb-2 d-block">
                                            {{ $label }}
                                        </label>

                                        @if($evidencia->$campo)
                                        @php
                                        $rutaSegura = base64_encode($evidencia->$campo);
                                        $urlVerPdf = route('archivos.ver', ['ruta' => $rutaSegura]);
                                        $nombreCorto = basename($evidencia->$campo);
                                        @endphp

                                        <div class="d-flex align-items-center justify-content-between bg-white border rounded p-2 mb-3 shadow-sm">
                                            <div class="d-flex align-items-center text-truncate" style="min-width:0;">
                                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-2"></i>
                                                <span class="small fw-semibold text-muted text-truncate"
                                                    title="{{ $nombreCorto }}">
                                                    {{ $nombreCorto }}
                                                </span>
                                            </div>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-preview-pdf ms-2"
                                                data-url="{{ $urlVerPdf }}"
                                                data-name="{{ $nombreCorto }}">
                                                <i class="bi bi-eye"></i> Ver
                                            </button>
                                        </div>
                                        @else
                                        <div class="alert alert-light py-1 px-2 small mb-3 border text-center rounded-2 text-muted">
                                            <i class="bi bi-slash-circle me-1"></i>
                                            Inhabilitada para previsualización
                                        </div>
                                        @endif
                                    </div>

                                    <input
                                        type="file"
                                        class="form-control form-control-sm"
                                        name="{{ $campo }}"
                                        accept="application/pdf">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <hr class="my-4 style-hr">

                        <div class="d-flex gap-2">
                            <a href="{{ route('evidencias') }}"
                                class="btn btn-light px-4 py-2 rounded-pill border fw-semibold small">
                                <i class="bi bi-arrow-left-short fs-5 align-middle"></i>
                                Regresar
                            </a>

                            <button type="submit"
                                class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm fw-semibold small">
                                <i class="bi bi-check-lg me-1"></i>
                                Aplicar Correcciones
                            </button>
                        </div>
                    </form>
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
    .row-file-card {
        border: 1px solid #e2e8f0;
        transition: transform .2s ease;
    }

    .row-file-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    }

    .style-hr {
        opacity: 0.1;
    }
</style>

@endsection