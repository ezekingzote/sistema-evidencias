@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div id="data-container"
         data-subidas='@json($subidasArray)'
         style="display:none;">
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold text-dark mb-1">

                @if($rutaActual)

                    <a href="{{ route('archivos') }}"
                       class="text-decoration-none text-secondary">

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

                        <a href="{{ route('archivos') }}"
                           class="text-decoration-none">

                            <i class="bi bi-cloud-fill me-1"></i>
                            Raíz

                        </a>

                    </li>

                    @php
                        $rutaAcumulada = '';
                    @endphp

                    @foreach($breadcrumbs as $crumb)

                        @php
                            $rutaAcumulada .= ($rutaAcumulada ? '/' : '') . $crumb;
                        @endphp

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

            {{-- CARPETAS --}}
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

                                    <div class="d-flex align-items-center truncate-box">

                                        <i class="bi bi-folder-fill text-warning fs-3 me-3"></i>

                                        <span class="fw-semibold text-dark text-truncate small">

                                            {{ $carpeta['nombre'] }}

                                        </span>

                                    </div>

                                    <i class="bi bi-chevron-right text-muted x-small"></i>

                                </div>

                            </div>

                        @endforeach

                    </div>

                @else

                    <p class="text-muted small ps-1">

                        No hay subcarpetas aquí.

                    </p>

                @endif

            </div>

            {{-- ARCHIVOS --}}
            <div class="mb-4">

                <h6 class="text-uppercase text-secondary fw-bold small mb-3 px-1">

                    Archivos ({{ count($archivos) }})

                </h6>

                @if(count($archivos) > 0)

                    <div class="row g-4">

                        @foreach($archivos as $archivo)

                            @php

                                $extension = strtolower(
                                    pathinfo($archivo['nombre'], PATHINFO_EXTENSION)
                                );

                                $rutaArchivo = 'evidencias_pdfs/' .
                                    (
                                        $archivo['ruta']
                                        ?? $archivo['ruta_completa']
                                        ?? $archivo['path']
                                        ?? $archivo['nombre']
                                    );

                            @endphp

                            <div class="col-xl-3 col-lg-4 col-md-6">

                                <div class="card file-card border-0 shadow-sm">

                                    <div class="file-preview">

                                        {{-- IMÁGENES --}}
                                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))

                                            <img src="{{ asset('storage/' . $rutaArchivo) }}"
                                                 class="w-100 h-100 object-fit-cover"
                                                 alt="">

                                        {{-- PDF --}}
                                        @elseif($extension === 'pdf')

                                            <iframe
                                                src="{{ asset('storage/' . $rutaArchivo) }}#toolbar=0"
                                                width="100%"
                                                height="100%"
                                                style="border:none;">
                                            </iframe>

                                        {{-- WORD --}}
                                        @elseif(in_array($extension, ['doc', 'docx']))

                                            <div class="d-flex flex-column align-items-center justify-content-center h-100">

                                                <i class="bi bi-file-earmark-word text-primary display-4"></i>

                                                <span class="small text-muted mt-2">
                                                    Documento Word
                                                </span>

                                            </div>

                                        {{-- EXCEL --}}
                                        @elseif(in_array($extension, ['xls', 'xlsx']))

                                            <div class="d-flex flex-column align-items-center justify-content-center h-100">

                                                <i class="bi bi-file-earmark-excel text-success display-4"></i>

                                                <span class="small text-muted mt-2">
                                                    Archivo Excel
                                                </span>

                                            </div>

                                        {{-- POWERPOINT --}}
                                        @elseif(in_array($extension, ['ppt', 'pptx']))

                                            <div class="d-flex flex-column align-items-center justify-content-center h-100">

                                                <i class="bi bi-file-earmark-ppt text-danger display-4"></i>

                                                <span class="small text-muted mt-2">
                                                    Presentación
                                                </span>

                                            </div>

                                        {{-- OTROS --}}
                                        @else

                                            <div class="d-flex flex-column align-items-center justify-content-center h-100">

                                                <i class="bi bi-file-earmark text-secondary display-4"></i>

                                                <span class="small text-muted mt-2">

                                                    {{ strtoupper($extension) }}

                                                </span>

                                            </div>

                                        @endif

                                    </div>

                                    <div class="p-3">

                                        <p class="small fw-semibold text-truncate mb-3">

                                            {{ $archivo['nombre'] }}

                                        </p>

                                        <div class="d-flex justify-content-between align-items-center">

                                            <a href="{{ asset('storage/' . $rutaArchivo) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-primary rounded-pill px-3">

                                                Abrir

                                            </a>

                                            <a href="{{ asset('storage/' . $rutaArchivo) }}"
                                               download
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

                    <p class="text-muted small ps-1">

                        No hay archivos en esta carpeta.

                    </p>

                @endif

            </div>

        </div>

    </div>

</main>

<script>

    document.querySelectorAll('.folder-link').forEach(folder => {

        folder.addEventListener('click', function () {

            window.location.href = this.getAttribute('data-url');

        });

    });

</script>

<style>

    .folder-card{
        border:1px solid #dadce0 !important;
        border-radius:14px;
        transition:all .2s ease;
        cursor:pointer;
        background:white;
    }

    .folder-card:hover{
        background:#f1f3f4;
        transform:translateY(-2px);
    }

    .file-card{
        border:1px solid #dadce0 !important;
        border-radius:14px;
        overflow:hidden;
        transition:all .2s ease;
        background:white;
    }

    .file-card:hover{
        transform:translateY(-3px);
        box-shadow:0 10px 25px rgba(0,0,0,.08);
    }

    .file-preview{
        height:220px;
        background:#f8f9fa;
        overflow:hidden;
        display:flex;
        align-items:center;
        justify-content:center;
    }

    .object-fit-cover{
        object-fit:cover;
    }

    .truncate-box{
        min-width:0;
    }

    .x-small{
        font-size:11px;
    }

    iframe{
        background:white;
    }

</style>

@endsection