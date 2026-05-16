@extends('layouts.main')

@section('titulo', 'Editar Evidencias')

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1 class="fw-bold text-warning">Editar Evidencias</h1>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('evidencias') }}">Evidencias</a></li>
                    <li class="breadcrumb-item active">Editar</li>
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
                                Modo Edición • Reemplaza solo los archivos necesarios
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">

                    <form action="{{ route('evidencias.update', $materia->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-uppercase text-secondary small">Revisión a editar</label>
                                <select name="revision_id" class="form-select border rounded shadow-sm" id="selectRevision"
                                    onchange="recargarRevision(this.value)">
                                    @foreach ($revisiones as $rev)
                                        <option value="{{ $rev->id }}"
                                            {{ $revisionSeleccionada->id == $rev->id ? 'selected' : '' }}>
                                            {{ $rev->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-4">

                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h5 class="fw-bold text-primary mb-4">
                                        Documentos
                                    </h5>

                                    <div class="mb-4">
                                        <label class="mb-1">a) Instrumentación didáctica</label>
                                        @if (optional($evidencia)->doc_a)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="badge bg-success text-white px-2 py-1">
                                                    <i class="bi bi-check-circle me-1"></i> Archivo actual guardado
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-ver-pdf"
                                                    data-pdf="{{ asset('storage/' . $evidencia->doc_a) }}"
                                                    data-titulo="a) Instrumentación didáctica">
                                                    <i class="bi bi-eye"></i> Ver
                                                </button>
                                            </div>
                                        @endif
                                        <input type="file" name="doc_a" class="form-control" accept=".pdf"
                                            {{ optional($evidencia)->doc_a ? '' : 'required' }}>
                                        <small class="text-muted"
                                            style="font-size: 12px;">{{ optional($evidencia)->doc_a ? 'Sube un archivo solo si deseas reemplazar el actual.' : 'Requerido.' }}</small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="mb-1">b) Lista de calificaciones</label>
                                        @if (optional($evidencia)->doc_b)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="badge bg-success text-white px-2 py-1">
                                                    <i class="bi bi-check-circle me-1"></i> Archivo actual guardado
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-ver-pdf"
                                                    data-pdf="{{ asset('storage/' . $evidencia->doc_b) }}"
                                                    data-titulo="b) Lista de calificaciones">
                                                    <i class="bi bi-eye"></i> Ver
                                                </button>
                                            </div>
                                        @endif
                                        <input type="file" name="doc_b" class="form-control" accept=".pdf"
                                            {{ optional($evidencia)->doc_b ? '' : 'required' }}>
                                        <small class="text-muted"
                                            style="font-size: 12px;">{{ optional($evidencia)->doc_b ? 'Sube un archivo solo si deseas reemplazar el actual.' : 'Requerido.' }}</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="mb-1">c) Reporte y acuerdos</label>
                                        @if (optional($evidencia)->doc_c)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="badge bg-success text-white px-2 py-1">
                                                    <i class="bi bi-check-circle me-1"></i> Archivo actual guardado
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-primary btn-ver-pdf"
                                                    data-pdf="{{ asset('storage/' . $evidencia->doc_c) }}"
                                                    data-titulo="c) Reporte y acuerdos">
                                                    <i class="bi bi-eye"></i> Ver
                                                </button>
                                            </div>
                                        @endif
                                        <input type="file" name="doc_c" class="form-control" accept=".pdf"
                                            {{ optional($evidencia)->doc_c ? '' : 'required' }}>
                                        <small class="text-muted"
                                            style="font-size: 12px;">{{ optional($evidencia)->doc_c ? 'Sube un archivo solo si deseas reemplazar el actual.' : 'Requerido.' }}</small>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="border rounded-4 p-4 h-100">
                                    <h5 class="fw-bold text-success mb-4">
                                        Evidencias
                                    </h5>

                                    <div class="mb-4">
                                        <label class="mb-1">a) Tareas complementarias</label>
                                        @if (optional($evidencia)->evi_a)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="badge bg-success text-white px-2 py-1">
                                                    <i class="bi bi-check-circle me-1"></i> Archivo actual guardado
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-success btn-ver-pdf"
                                                    data-pdf="{{ asset('storage/' . $evidencia->evi_a) }}"
                                                    data-titulo="a) Tareas complementarias">
                                                    <i class="bi bi-eye"></i> Ver
                                                </button>
                                            </div>
                                        @endif
                                        <input type="file" name="evi_a" class="form-control" accept=".pdf"
                                            {{ optional($evidencia)->evi_a ? '' : 'required' }}>
                                        <small class="text-muted"
                                            style="font-size: 12px;">{{ optional($evidencia)->evi_a ? 'Sube un archivo solo si deseas reemplazar el actual.' : 'Requerido.' }}</small>
                                    </div>

                                    <div class="mb-4">
                                        <label class="mb-1">b) Rúbricas</label>
                                        @if (optional($evidencia)->evi_b)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="badge bg-success text-white px-2 py-1">
                                                    <i class="bi bi-check-circle me-1"></i> Archivo actual guardado
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-success btn-ver-pdf"
                                                    data-pdf="{{ asset('storage/' . $evidencia->evi_b) }}"
                                                    data-titulo="b) Rúbricas">
                                                    <i class="bi bi-eye"></i> Ver
                                                </button>
                                            </div>
                                        @endif
                                        <input type="file" name="evi_b" class="form-control" accept=".pdf"
                                            {{ optional($evidencia)->evi_b ? '' : 'required' }}>
                                        <small class="text-muted"
                                            style="font-size: 12px;">{{ optional($evidencia)->evi_b ? 'Sube un archivo solo si deseas reemplazar el actual.' : 'Requerido.' }}</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="mb-1">c) Examen diagnóstico y análisis</label>
                                        @if (optional($evidencia)->evi_c)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="badge bg-success text-white px-2 py-1">
                                                    <i class="bi bi-check-circle me-1"></i> Archivo actual guardado
                                                </div>
                                                <button type="button" class="btn btn-sm btn-outline-success btn-ver-pdf"
                                                    data-pdf="{{ asset('storage/' . $evidencia->evi_c) }}"
                                                    data-titulo="c) Examen diagnóstico">
                                                    <i class="bi bi-eye"></i> Ver
                                                </button>
                                            </div>
                                        @endif
                                        <input type="file" name="evi_c" class="form-control" accept=".pdf"
                                            {{ optional($evidencia)->evi_c ? '' : 'required' }}>
                                        <small class="text-muted"
                                            style="font-size: 12px;">{{ optional($evidencia)->evi_c ? 'Sube un archivo solo si deseas reemplazar el actual.' : 'Requerido.' }}</small>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <div class="text-center mt-5 d-flex gap-3 justify-content-center">
                            <a href="{{ route('evidencias') }}" class="btn btn-secondary px-4">
                                <i class="bi bi-x-circle me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning px-5 shadow-sm fw-bold">
                                <i class="bi bi-save me-2"></i> Guardar Cambios
                            </button>
                        </div>

                    </form>

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
                        <iframe id="iframePdf" src="" width="100%" height="700px" style="border: none; display: block;">
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

                document.getElementById('modalPdf').addEventListener('hidden.bs.modal', function () {
                    iframePdf.src = '';
                });
            } else {
                console.error("Bootstrap no está cargado correctamente en la vista.");
            }
        });

        function recargarRevision(idRevisionSeleccionada) {
            let url = new URL("{{ route('evidencias.edit', $materia->id) }}");
            url.searchParams.set('revision_id', idRevisionSeleccionada);
            window.location.href = url.href;
        }
    </script>
@endpush