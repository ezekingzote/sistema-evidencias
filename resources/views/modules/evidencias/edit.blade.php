@extends('layouts.main')

@section('titulo', 'Editar Evidencia')

@section('contenido')

    <main id="main" class="main">

        <div class="pagetitle mb-4">
            <h1 class="fw-bold text-primary">
                Editar Evidencia
            </h1>
        </div>

        <section class="section">

            <div class="card border-0 shadow-lg p-4" style="border-radius:20px;">

                <form action="{{ route('evidencias.update', $evidencia->id) }}" method="POST" enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    @php

                        $documentos = $evidencia->documentos ?? [];
                        $evidencias = $evidencia->evidencias ?? [];
                        $evaluacion = $evidencia->evaluacion ?? [];
                        $instrumentos = $documentos['instrumentos'] ?? [];
                        $racNoAplica = false;

                        if (
                            isset($documentos['rac']) &&
                            is_array($documentos['rac']) &&
                            ($documentos['rac']['na'] ?? false)
                        ) {
                            $racNoAplica = true;
                        }

                        $documentosCampos = [
                            [
                                'key' => 'instrumentacion',
                                'nombre' => 'Instrumentación didáctica',
                            ],

                            [
                                'key' => 'reporte_inicio',
                                'nombre' => 'Reporte de inicio de curso',
                            ],

                            [
                                'key' => 'acuerdos',
                                'nombre' => 'Acuerdos de clase',
                            ],

                            [
                                'key' => 'calificaciones',
                                'nombre' => 'Lista de calificaciones',
                            ],

                            [
                                'key' => 'rac',
                                'nombre' => 'Actividades de regularización',
                            ],
                        ];

                        $evidenciasCampos = [
                            [
                                'key' => 'examen_diagnostico',
                                'nombre' => 'Examen diagnóstico',
                            ],

                            [
                                'key' => 'analisis_diagnostico',
                                'nombre' => 'Análisis diagnóstico',
                            ],

                            [
                                'key' => 'rubricas',
                                'nombre' => 'Rúbricas del semestre',
                            ],
                        ];
                    @endphp

                    {{-- =========================================== --}}
                    {{-- DOCUMENTOS --}}
                    {{-- =========================================== --}}

                    <h4 class="fw-bold text-primary mb-4">

                        DOCUMENTOS

                    </h4>

                    <div class="row g-4 mb-5">

                        @foreach ($documentosCampos as $campo)
                            @php

                                $key = $campo['key'];

                                if ($key == 'rac') {
                                    $ruta = $documentos['rac']['archivo'] ?? null;
                                } else {
                                    $ruta = $documentos[$key] ?? null;
                                }

                                $calificacion = $evaluacion[$key]['calificacion'] ?? 0;

                                $aprobado = $calificacion >= 70;

                            @endphp

                            <div class="col-md-4">

                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">

                                    {{-- HEADER --}}
                                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">

                                        <div>

                                            <h6 class="fw-bold mb-1">
                                                {{ $campo['nombre'] }}
                                            </h6>

                                            @if ($aprobado)
                                                <small class="text-success fw-bold">

                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Aprobado

                                                </small>
                                            @else
                                                <small class="text-danger fw-bold">

                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                    Rechazado

                                                </small>
                                            @endif

                                        </div>

                                        @if ($ruta)
                                            <a href="{{ asset('storage/' . $ruta) }}" target="_blank"
                                                class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                                style="width:42px;height:42px;">

                                                <i class="fa-solid fa-up-right-from-square"></i>

                                            </a>
                                        @endif

                                    </div>

                                    {{-- PDF --}}
                                    <div style="height:350px;background:#f8f9fa;">

                                        @if ($ruta)
                                            <iframe src="{{ asset('storage/' . $ruta) }}#toolbar=0" width="100%"
                                                height="100%" style="border:none;">
                                            </iframe>
                                        @else
                                            <div class="h-100 d-flex align-items-center justify-content-center bg-light">

                                                <div class="text-center text-muted">

                                                    <i class="fa-regular fa-file-pdf fa-3x mb-2 opacity-50"></i>

                                                    <div>
                                                        No existe documento
                                                    </div>

                                                </div>

                                            </div>
                                        @endif

                                    </div>

                                    {{-- FOOTER --}}
                                    <div class="p-3">

                                        @if (!$aprobado)
                                            @if ($key == 'rac')
                                                <div class="form-check form-switch mb-3">

                                                    <input class="form-check-input" type="checkbox" id="rac_na"
                                                        name="rac_na" {{ $racNoAplica ? 'checked' : '' }}>

                                                    <label class="form-check-label">

                                                        No aplica

                                                    </label>

                                                </div>
                                            @endif

                                            <input type="file" name="{{ $key }}" id="{{ $key }}"
                                                class="form-control" {{ $key == 'rac' && $racNoAplica ? 'disabled' : '' }}>

                                            <small class="text-muted">

                                                Puedes reemplazar este documento

                                            </small>
                                        @else
                                            <input type="file" class="form-control" disabled>

                                            <small class="text-success fw-bold">

                                                Documento bloqueado porque fue aprobado

                                            </small>
                                        @endif

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                    {{-- =========================================== --}}
                    {{-- EVIDENCIAS --}}
                    {{-- =========================================== --}}

                    <h4 class="fw-bold text-success mb-4">

                        EVIDENCIAS

                    </h4>

                    <div class="row g-4">

                        @foreach ($evidenciasCampos as $campo)
                            @php

                                $key = $campo['key'];

                                $ruta = $evidencias[$key] ?? null;

                                $calificacion = $evaluacion[$key]['calificacion'] ?? 0;

                                $aprobado = $calificacion >= 70;

                            @endphp

                            <div class="col-md-4">

                                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">

                                    {{-- HEADER --}}
                                    <div class="p-3 border-bottom d-flex justify-content-between align-items-center">

                                        <div>

                                            <h6 class="fw-bold mb-1">
                                                {{ $campo['nombre'] }}
                                            </h6>

                                            @if ($aprobado)
                                                <small class="text-success fw-bold">

                                                    <i class="fa-solid fa-circle-check"></i>
                                                    Aprobado

                                                </small>
                                            @else
                                                <small class="text-danger fw-bold">

                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                    Rechazado

                                                </small>
                                            @endif

                                        </div>

                                        @if ($ruta)
                                            <a href="{{ asset('storage/' . $ruta) }}" target="_blank"
                                                class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                                style="width:42px;height:42px;">

                                                <i class="fa-solid fa-up-right-from-square"></i>

                                            </a>
                                        @endif

                                    </div>

                                    {{-- PDF --}}
                                    <div style="height:350px;background:#f8f9fa;">

                                        @if ($ruta)
                                            <iframe src="{{ asset('storage/' . $ruta) }}#toolbar=0" width="100%"
                                                height="100%" style="border:none;">
                                            </iframe>
                                        @else
                                            <div class="h-100 d-flex align-items-center justify-content-center bg-light">

                                                <div class="text-center text-muted">

                                                    <i class="fa-regular fa-file-pdf fa-3x mb-2 opacity-50"></i>

                                                    <div>
                                                        No existe documento
                                                    </div>

                                                </div>

                                            </div>
                                        @endif

                                    </div>

                                    {{-- FOOTER --}}
                                    <div class="p-3">

                                        @if (!$aprobado)
                                            <input type="file" name="{{ $key }}" class="form-control">

                                            <small class="text-muted">

                                                Puedes reemplazar este documento

                                            </small>
                                        @else
                                            <input type="file" class="form-control" disabled>

                                            <small class="text-success fw-bold">

                                                Documento bloqueado porque fue aprobado

                                            </small>
                                        @endif

                                    </div>

                                </div>

                            </div>
                        @endforeach

                    </div>

                    {{-- =========================================== --}}
                    {{-- INSTRUMENTOS --}}
                    {{-- =========================================== --}}

                    @php

                        $calificacionInstrumentos = $evaluacion['instrumentos']['calificacion'] ?? 0;

                        $instrumentosAprobados = $calificacionInstrumentos >= 70;

                    @endphp

                    <div class="card border-0 shadow-sm rounded-4 mt-5">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div>

                                    <h4 class="fw-bold text-success mb-1">

                                        Evidencias de instrumentos de evaluación

                                    </h4>

                                    @if ($instrumentosAprobados)
                                        <small class="text-success fw-bold">

                                            <i class="fa-solid fa-circle-check"></i>
                                            Instrumentos aprobados

                                        </small>
                                    @else
                                        <small class="text-danger fw-bold">

                                            <i class="fa-solid fa-circle-xmark"></i>
                                            Instrumentos rechazados

                                        </small>
                                    @endif

                                </div>

                            </div>

                            {{-- GRID --}}
                            <div class="row g-4 mb-4">

                                @forelse($instrumentos as $i => $pdf)
                                    <div class="col-md-4" id="pdf-old-{{ $i }}">

                                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">

                                            {{-- HEADER --}}
                                            <div
                                                class="p-2 border-bottom d-flex justify-content-between align-items-center">

                                                <small class="fw-bold text-muted">

                                                    Instrumento {{ $i + 1 }}

                                                </small>

                                                <div class="d-flex gap-2">

                                                    <a href="{{ asset('storage/' . $pdf) }}" target="_blank"
                                                        class="btn btn-dark btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                                        style="width:38px;height:38px;">

                                                        <i class="fa-solid fa-up-right-from-square"></i>

                                                    </a>

                                                    @if (!$instrumentosAprobados)
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center"
                                                            style="width:38px;height:38px;"
                                                            onclick="eliminarViejo({{ $i }})">

                                                            <i class="fa-solid fa-xmark"></i>

                                                        </button>
                                                    @endif

                                                </div>

                                            </div>

                                            {{-- PDF --}}
                                            <div style="height:320px;">

                                                <iframe src="{{ asset('storage/' . $pdf) }}#toolbar=0" width="100%"
                                                    height="100%" style="border:none;">
                                                </iframe>

                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <div class="col-12">

                                        <div class="alert alert-light border text-center">

                                            No existen instrumentos cargados

                                        </div>

                                    </div>
                                @endforelse

                            </div>

                            <div id="contenedor-eliminados"></div>

                            {{-- DROPZONE --}}
                            @if (!$instrumentosAprobados)
                                <div class="mt-4">

                                    <div class="row-file-card p-4 rounded-4 border bg-light">

                                        <h6 class="fw-bold text-success mb-1">

                                            Reemplazar instrumentos

                                        </h6>

                                        <p class="text-muted small mb-3">

                                            Deben existir máximo 3 PDFs en total

                                        </p>

                                        <div class="row align-items-center text-center">

                                            <div class="col-md-5">

                                                <input type="file" id="file-input-helper" class="d-none"
                                                    accept="application/pdf" multiple>

                                                <button type="button"
                                                    class="btn btn-outline-success rounded-pill fw-semibold px-4 py-2 w-100"
                                                    id="btn-seleccionar">

                                                    Seleccionar archivos

                                                </button>

                                            </div>

                                            <div class="col-md-7">

                                                <div id="lista-archivos" class="d-flex flex-column gap-2">

                                                    <span class="text-muted small">

                                                        Ningún archivo seleccionado

                                                    </span>

                                                </div>

                                            </div>

                                        </div>

                                        <div id="hidden-inputs-container"></div>

                                    </div>

                                </div>
                            @endif

                        </div>

                    </div>

                    {{-- BOTONES --}}
                    <div class="d-flex gap-2 mt-4">

                        <a href="{{ route('evidencias') }}" class="btn btn-light border rounded-pill px-4">

                            <i class="fa-solid fa-arrow-left"></i>
                            Regresar

                        </a>

                        <button class="btn btn-primary rounded-pill px-4">

                            <i class="fa-solid fa-floppy-disk"></i>
                            Guardar cambios

                        </button>

                    </div>

                </form>

            </div>

        </section>

    </main>

    <script>
        const racCheck =
            document.getElementById('rac_na');

        const racInput =
            document.getElementById('rac');

        if (racCheck) {

            racCheck.addEventListener('change', function() {

                if (this.checked) {

                    racInput.disabled = true;

                    racInput.value = '';

                } else {

                    racInput.disabled = false;

                }

            });

        }

        const helperInput =
            document.getElementById('file-input-helper');

        const btnSeleccionar =
            document.getElementById('btn-seleccionar');

        const listaArchivos =
            document.getElementById('lista-archivos');

        const hiddenContainer =
            document.getElementById('hidden-inputs-container');

        const contenedorEliminados =
            document.getElementById('contenedor-eliminados');

        let archivos = [];

        let viejos = @json($instrumentos);

        if (btnSeleccionar) {

            btnSeleccionar.addEventListener('click', () => {

                helperInput.click();

            });

        }

        if (helperInput) {

            helperInput.addEventListener('change', function() {

                for (let file of this.files) {

                    if (file.type !== 'application/pdf') continue;

                    if ((viejos.length + archivos.length) >= 3) break;

                    archivos.push(file);

                }

                render();

                this.value = '';

            });

        }

        function render() {

            listaArchivos.innerHTML = '';

            hiddenContainer.innerHTML = '';

            if (archivos.length === 0) {

                listaArchivos.innerHTML = `

                <span class="text-muted small">

                    Ningún archivo nuevo seleccionado

                </span>

            `;

                return;
            }

            archivos.forEach((file, i) => {

                listaArchivos.innerHTML += `

                <div class="d-flex justify-content-between align-items-center border rounded p-2 bg-white small">

                    <span class="text-truncate">

                        ${file.name}

                    </span>

                    <button
                        type="button"
                        class="btn btn-sm btn-danger"
                        onclick="removeFile(${i})">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

            `;

            });

            const dt = new DataTransfer();

            archivos.forEach(f => dt.items.add(f));

            const input = document.createElement('input');

            input.type = 'file';

            input.name = 'instrumentos[]';

            input.multiple = true;

            input.files = dt.files;

            hiddenContainer.appendChild(input);

        }

        function removeFile(index) {

            archivos.splice(index, 1);

            render();

        }

        function eliminarViejo(index) {

            viejos.splice(index, 1);

            document.getElementById('pdf-old-' + index).remove();

            const input = document.createElement('input');

            input.type = 'hidden';

            input.name = 'eliminar_instrumentos[]';

            input.value = index;

            contenedorEliminados.appendChild(input);

        }
    </script>

@endsection
