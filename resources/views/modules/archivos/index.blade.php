@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main id="main" class="main">

    <div id="data-container"
        data-subidas='@json($subidasArray)'
        style="display:none;">
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">
                @if($rutaActual)
                <a href="{{ route('archivos') }}" class="text-decoration-none text-secondary">
                    <i class="bi bi-arrow-left-short"></i>
                </a>
                {{ basename($rutaActual) }}
                @else
                Mi Unidad
                @endif
            </h3>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('archivos') }}" class="text-decoration-none">
                            <i class="bi bi-cloud-fill me-1"></i> Raíz
                        </a>
                    </li>

                    @php $rutaAcumulada = ''; @endphp

                    @foreach($breadcrumbs as $crumb)
                    @php $rutaAcumulada .= ($rutaAcumulada ? '/' : '') . $crumb; @endphp

                    <li class="breadcrumb-item active">
                        <a href="{{ route('archivos', ['ruta' => $rutaAcumulada]) }}"
                            class="text-decoration-none text-capitalize">
                            {{ $crumb }}
                        </a>
                    </li>
                    @endforeach
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">

            {{-- SECCIÓN CARPETAS --}}
            <div class="mb-5">
                <h6 class="text-uppercase text-secondary fw-bold small mb-3 px-1">
                    Carpetas ({{ count($carpetas) }})
                </h6>

                @if(count($carpetas) > 0)
                <div class="row g-3">
                    @foreach($carpetas as $carpeta)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="card folder-card border-0 shadow-sm p-3 d-flex flex-row align-items-center justify-content-between folder-link"
                            data-url="{{ route('archivos', ['ruta' => $carpeta['ruta_completa']]) }}">

                            <div class="folder-main d-flex align-items-center truncate-box">
                                <div class="folder-icon-box me-3">
                                    <i class="bi bi-folder-fill"></i>
                                </div>

                                <div class="folder-text-box">
                                    <span class="fw-semibold text-dark text-truncate small d-block">
                                        {{ $carpeta['nombre'] }}
                                    </span>

                                    <span class="folder-hint">
                                        Abrir carpeta
                                    </span>
                                </div>
                            </div>

                            <a href="{{ route('carpetas.zip', ['ruta' => $carpeta['ruta_completa']]) }}"
                                class="btn btn-sm rounded-pill d-flex align-items-center justify-content-center download-zip-btn"
                                title="Descargar carpeta en ZIP"
                                aria-label="Descargar carpeta en ZIP"
                                onclick="event.stopPropagation();">
                                <i class="bi bi-file-earmark-zip-fill zip-icon"></i>
                                <span class="zip-label">ZIP</span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted small ps-1">No hay subcarpetas aquí.</p>
                @endif
            </div>

            {{-- SECCIÓN ARCHIVOS --}}
            <div class="mb-4">
                <h6 class="text-uppercase text-secondary fw-bold small mb-3 px-1">
                    Archivos ({{ count($archivos) }})
                </h6>

                @if(count($archivos) > 0)
                <div class="row g-4">
                    @foreach($archivos as $archivo)
                    @php
                    $rutaSegura = base64_encode($archivo['ruta_completa']);
                    $urlVerPdf = route('archivos.ver', ['ruta' => $rutaSegura]);
                    @endphp

                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card file-card border-0 shadow-sm">
                            <div class="file-preview">

                                {{-- IMÁGENES --}}
                                @if(in_array($archivo['extension'], ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <img src="{{ asset('storage/' . $archivo['ruta_completa']) }}"
                                    class="w-100 h-100 object-fit-cover"
                                    alt="">

                                {{-- PDF: VISTA PEQUEÑA DEL CONTENIDO REAL --}}
                                @elseif($archivo['extension'] === 'pdf')
                                <div class="w-100 h-100 position-relative iframe-container">
                                    <embed src="{{ $urlVerPdf }}#toolbar=0&navpanes=0&scrollbar=0"
                                        type="application/pdf"
                                        class="w-100 h-100 pointer-events-none">
                                    <div class="iframe-overlay"></div>
                                </div>

                                {{-- WORD --}}
                                @elseif(in_array($archivo['extension'], ['doc', 'docx']))
                                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                    <i class="bi bi-file-earmark-word text-primary display-4"></i>
                                    <span class="small text-muted mt-2">Documento Word</span>
                                </div>

                                {{-- EXCEL --}}
                                @elseif(in_array($archivo['extension'], ['xls', 'xlsx']))
                                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                    <i class="bi bi-file-earmark-excel text-success display-4"></i>
                                    <span class="small text-muted mt-2">Archivo Excel</span>
                                </div>

                                {{-- OTROS --}}
                                @else
                                <div class="d-flex flex-column align-items-center justify-content-center h-100">
                                    <i class="bi bi-file-earmark text-secondary display-4"></i>
                                    <span class="small text-muted mt-2">{{ strtoupper($archivo['extension']) }}</span>
                                </div>
                                @endif

                            </div>

                            <div class="p-3">
                                <p class="small fw-semibold text-truncate mb-1" title="{{ $archivo['nombre'] }}">
                                    {{ $archivo['nombre'] }}
                                </p>

                                <p class="text-muted x-small mb-3">
                                    {{ $archivo['tamano'] }} • {{ $archivo['fecha'] }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center">

                                    {{-- BOTÓN CON DATA-ATTRIBUTES (Cero conflictos de comillas en JS) --}}
                                    @if($archivo['extension'] === 'pdf')
                                    <button type="button"
                                        class="btn btn-sm btn-outline-primary rounded-pill px-3 btn-preview-pdf"
                                        data-url="{{ $urlVerPdf }}"
                                        data-name="{{ $archivo['nombre'] }}">
                                        <i class="fa-regular fa-eye"></i> Vista Previa
                                    </button>
                                    @else
                                    <a href="{{ asset('storage/' . $archivo['ruta_completa']) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-primary rounded-pill px-3">
                                        Abrir
                                    </a>
                                    @endif

                                    <a href="{{ route('archivos.descargar', ['ruta' => $rutaSegura]) }}"
                                        class="btn btn-sm btn-light border rounded-pill px-3">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted small ps-1">No hay archivos en esta carpeta.</p>
                @endif
            </div>

        </div>
    </div>
</main>

<script>
    // Manejo seguro del click para abrir SweetAlert2 sin romper comillas HTML
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

    // Redirección de carpetas
    document.querySelectorAll('.folder-link').forEach(folder => {
        folder.addEventListener('click', function() {
            window.location.href = this.getAttribute('data-url');
        });
    });
</script>

<style>
    .folder-card {
        border: 1px solid #e5e7eb !important;
        border-radius: 16px;
        transition: all .2s ease;
        cursor: pointer;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .folder-card::before {
        content: "";
        position: absolute;
        left: 0;
        top: 12px;
        bottom: 12px;
        width: 4px;
        border-radius: 0 8px 8px 0;
        background: #ffc107;
        opacity: .95;
    }

    .folder-card:hover {
        background: #fffdf6;
        border-color: #ffd76a !important;
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, .08) !important;
    }

    .folder-main {
        min-width: 0;
        flex: 1;
        padding-left: 4px;
    }

    .folder-icon-box {
        width: 44px;
        height: 44px;
        min-width: 44px;
        border-radius: 14px;
        background: #fff6d9;
        color: #f5b400;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.65rem;
    }

    .folder-text-box {
        min-width: 0;
    }

    .folder-hint {
        display: block;
        font-size: 11px;
        color: #6c757d;
        margin-top: 2px;
    }

    .download-zip-btn {
        min-width: 58px;
        height: 42px;
        padding: 6px 11px;
        gap: 5px;
        border: 2px solid #0d6efd !important;
        background: #eef5ff !important;
        color: #0d6efd !important;
        font-weight: 700;
        transition: all .2s ease;
        box-shadow: 0 4px 10px rgba(13, 110, 253, .10);
        z-index: 2;
    }

    .download-zip-btn:hover {
        background: #0d6efd !important;
        color: #ffffff !important;
        border-color: #0d6efd !important;
        transform: scale(1.05);
        box-shadow: 0 8px 18px rgba(13, 110, 253, .22);
    }

    .download-zip-btn .zip-icon {
        font-size: 1.1rem;
    }

    .download-zip-btn .zip-label {
        font-size: 11px;
        letter-spacing: .4px;
    }

    .file-card {
        border: 1px solid #dadce0 !important;
        border-radius: 14px;
        overflow: hidden;
        transition: all .2s ease;
        background: white;
    }

    .file-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, .08);
    }

    .file-preview {
        height: 160px;
        background: #f8f9fa;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        border-bottom: 1px solid #f1f3f4;
    }

    .iframe-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .iframe-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0);
        z-index: 10;
    }

    .pointer-events-none {
        pointer-events: none;
    }

    .object-fit-cover {
        object-fit: cover;
    }

    .truncate-box {
        min-width: 0;
    }

    .x-small {
        font-size: 11px;
    }

    @media (max-width: 576px) {
        .download-zip-btn {
            min-width: 42px;
            width: 42px;
            padding: 0;
            border-radius: 50% !important;
        }

        .download-zip-btn .zip-label {
            display: none;
        }
    }
</style>

@endsection