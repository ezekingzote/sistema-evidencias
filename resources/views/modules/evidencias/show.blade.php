@extends('layouts.main')

@section('titulo', 'Ver Evidencias')

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1 class="fw-bold text-primary">Detalle de Evidencias</h1>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">Evidencias</a></li>
                    <li class="breadcrumb-item active">Ver</li>
                </ol>
            </nav>
        </div>

        <section class="section">

            <div class="card shadow-lg border-0" style="border-radius:18px;">
                <div class="card-header bg-white p-4">

                    <div class="row align-items-center">
                        <div class="col-md-7">
                            <h4 class="mb-1 fw-bold">{{ $materia->nombre }}</h4>
                            <p class="text-muted mb-0">
                                Modo: Solo visualización
                            </p>
                        </div>
                        <div class="col-md-5 mt-3 mt-md-0">
                            <div class="input-group input-custom shadow-sm border rounded">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-journal-bookmark-fill text-primary"></i>
                                </span>
                                <select class="form-select border-0 bg-light fw-semibold" id="selectRevision"
                                    onchange="recargarRevision(this.value)">
                                    @foreach ($revisiones as $rev)
                                        <option value="{{ $rev->id }}"
                                            {{ $revisionSeleccionada->id == $rev->id ? 'selected' : '' }}>
                                            Ver {{ $rev->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-body p-4">

                    <div class="row g-4">

                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 h-100">

                                <h5 class="fw-bold text-primary mb-4">
                                    Documentos
                                </h5>

                                <div class="mb-3">
                                    <label class="mb-1">a) Instrumentación didáctica completa, por asignatura</label>
                                    <div class="d-flex gap-2">
                                        @if (optional($evidencia)->doc_a)
                                            <button type="button" class="btn btn-outline-primary w-100 btn-ver-pdf"
                                                data-pdf="{{ asset('storage/' . $evidencia->doc_a) }}"
                                                data-titulo="a) Instrumentación didáctica">
                                                <i class="bi bi-eye me-2"></i> Ver PDF
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary w-100" disabled>Sin archivo
                                                subido</button>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-1">b) Lista de calificaciones</label>
                                    <div class="d-flex gap-2">
                                        @if (optional($evidencia)->doc_b)
                                            <button type="button" class="btn btn-outline-primary w-100 btn-ver-pdf"
                                                data-pdf="{{ asset('storage/' . $evidencia->doc_b) }}"
                                                data-titulo="b) Lista de calificaciones">
                                                <i class="bi bi-eye me-2"></i> Ver PDF
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary w-100" disabled>Sin archivo
                                                subido</button>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-1">c) Reporte y acuerdos</label>
                                    <div class="d-flex gap-2">
                                        @if (optional($evidencia)->doc_c)
                                            <button type="button" class="btn btn-outline-primary w-100 btn-ver-pdf"
                                                data-pdf="{{ asset('storage/' . $evidencia->doc_c) }}"
                                                data-titulo="c) Reporte y acuerdos">
                                                <i class="bi bi-eye me-2"></i> Ver PDF
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary w-100" disabled>Sin archivo
                                                subido</button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded-4 p-4 h-100">

                                <h5 class="fw-bold text-success mb-4">
                                    Evidencias
                                </h5>

                                <div class="mb-3">
                                    <label class="mb-1">a) Muestra de tareas y/o trabajos complementarios</label>
                                    <div class="d-flex gap-2">
                                        @if (optional($evidencia)->evi_a)
                                            <button type="button" class="btn btn-outline-success w-100 btn-ver-pdf"
                                                data-pdf="{{ asset('storage/' . $evidencia->evi_a) }}"
                                                data-titulo="a) Tareas complementarias">
                                                <i class="bi bi-eye me-2"></i> Ver PDF
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary w-100" disabled>Sin archivo
                                                subido</button>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-1">b) Rúbricas utilizadas para tareas y trabajos por
                                        asignatura</label>
                                    <div class="d-flex gap-2">
                                        @if (optional($evidencia)->evi_b)
                                            <button type="button" class="btn btn-outline-success w-100 btn-ver-pdf"
                                                data-pdf="{{ asset('storage/' . $evidencia->evi_b) }}"
                                                data-titulo="b) Rúbricas">
                                                <i class="bi bi-eye me-2"></i> Ver PDF
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary w-100" disabled>Sin archivo
                                                subido</button>
                                        @endif
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="mb-1">c) Examen diagnóstico y análisis de este</label>
                                    <div class="d-flex gap-2">
                                        @if (optional($evidencia)->evi_c)
                                            <button type="button" class="btn btn-outline-success w-100 btn-ver-pdf"
                                                data-pdf="{{ asset('storage/' . $evidencia->evi_c) }}"
                                                data-titulo="c) Examen diagnóstico">
                                                <i class="bi bi-eye me-2"></i> Ver PDF
                                            </button>
                                        @else
                                            <button class="btn btn-outline-secondary w-100" disabled>Sin archivo
                                                subido</button>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('evidencias') }}" class="btn btn-secondary px-4 shadow-sm">
                            <i class="bi bi-arrow-left me-1"></i> Regresar a Gestión
                        </a>
                    </div>

                </div>
            </div>

        </section>

        <div class="modal fade" id="modalPdf" tabindex="-1" aria-labelledby="modalPdfLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-light border-bottom-0">
                        <h5 class="modal-title fw-bold text-primary" id="modalPdfLabel">
                            <i class="bi bi-file-earmark-pdf-fill me-2 text-danger"></i>
                            <span id="tituloPdfVisualizador">Documento</span>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0 bg-dark">
                        <iframe id="iframePdf" src="" width="100%" height="700px"
                            style="border: none; display: block;">
                            Este navegador no soporta visualización de PDFs. Intente descargarlo.
                        </iframe>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesVerPdf = document.querySelectorAll('.btn-ver-pdf');
            const iframePdf = document.getElementById('iframePdf');
            const tituloPdf = document.getElementById('tituloPdfVisualizador');

            if (typeof bootstrap !== 'undefined') {
                const modalVisualizador = new bootstrap.Modal(document.getElementById('modalPdf'));

                botonesVerPdf.forEach(boton => {
                    boton.addEventListener('click', function() {
                        const rutaArchivo = this.getAttribute('data-pdf');
                        const tituloAtributo = this.getAttribute('data-titulo');

                        iframePdf.src = rutaArchivo;
                        tituloPdf.textContent = tituloAtributo;

                        modalVisualizador.show();
                    });
                });

                document.getElementById('modalPdf').addEventListener('hidden.bs.modal', function() {
                    iframePdf.src = '';
                });
            } else {
                console.error("Bootstrap no está cargado correctamente en la vista.");
            }
        });
        function recargarRevision(idRevisionSeleccionada) {
            let url = new URL("{{ route('evidencias.show', $materia->id) }}");
            url.searchParams.set('revision_id', idRevisionSeleccionada);
            window.location.href = url.href;
        }
    </script>
@endpush
