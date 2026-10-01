@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main id="main" class="main">

    <div id="data-container"
        data-subidas='@json($subidasArray)'
        style="display:none;">
    </div>

    {{-- CABECERA CON BOTÓN DE AYUDA ALINEADO A LA DERECHA --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
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

        {{-- BOTÓN DE AYUDA --}}
        <div>
            <button type="button" class="btn btn-info text-white rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalManualMiUnidad">
                <i class="bi bi-question-circle me-1"></i> Ayuda
            </button>
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
                    {{-- IGNORAR CARPETAS OCULTAS --}}
                    @if(str_starts_with($carpeta['nombre'], '.'))
                        @continue
                    @endif

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
                    {{-- IGNORAR ARCHIVOS OCULTOS --}}
                    @if(str_starts_with($archivo['nombre'], '.'))
                        @continue
                    @endif

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

                                    {{-- BOTÓN CON DATA-ATTRIBUTES --}}
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
@include('modules.archivos.manual')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/custom-tables.css') }}">
@endpush

@push('scripts')
    @include('modules.archivos.scripts')
@endpush