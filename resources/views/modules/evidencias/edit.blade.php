@extends('layouts.main')

@section('titulo', 'Editar Evidencia')

@section('contenido')

    <main id="main" class="main">

        <div class="pagetitle mb-4">
            <h1 class="fw-bold text-primary">Editar Evidencia</h1>
        </div>

        <section class="section">
            <div class="card border-0 shadow-lg p-4" style="border-radius:20px;">

                {{-- Alerta de evaluación --}}
                @if ($evidencia->evaluacion)
                    <div
                        class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold mb-1">Dictamen de Evaluación Disponible</h5>
                            <small class="text-secondary">Los documentos aprobados no pueden ser editados.</small>
                        </div>
                        <a href="{{ route('mis-reportes.pdf', $evidencia->id) }}" target="_blank"
                            class="btn btn-danger rounded-pill shadow-sm px-4">
                            <i class="fa-solid fa-file-pdf me-2"></i>Descargar Dictamen PDF
                        </a>
                    </div>
                @endif

                <form action="{{ route('evidencias.update', $evidencia->id) }}" method="POST" enctype="multipart/form-data"
                    id="form-edit-evidencias">
                    @csrf
                    @method('PUT')

                    {{-- SECCIÓN I: DOCUMENTOS --}}
                    <h4 class="fw-bold text-primary mb-4">DOCUMENTOS</h4>
                    <div class="row g-4 mb-5">
                        @foreach ($documentos as $doc)
                            <div class="col-md-4">
                                <div
                                    class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 border-top border-4 {{ $doc['aprobado'] ? 'border-success' : 'border-danger' }}">
                                    <div class="p-3 bg-white d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark text-truncate" style="max-width: 190px;">
                                                {{ $doc['nombre'] }}</h6>
                                            <small class="{{ $doc['aprobado'] ? 'text-success' : 'text-danger' }} fw-bold">
                                                <i
                                                    class="fa-solid {{ $doc['aprobado'] ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>
                                                {{ $doc['aprobado'] ? 'Aprobado' : 'Rechazado' }}
                                            </small>
                                        </div>
                                        @if ($doc['existe'])
                                            <a href="{{ asset('storage/' . $doc['ruta']) }}" target="_blank"
                                                class="btn btn-light btn-sm rounded-circle shadow-sm text-primary"
                                                style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>
                                        @endif
                                    </div>

                                    <div style="height:340px; background:#f8f9fa;">
                                        @if ($doc['existe'])
                                            <iframe src="{{ asset('storage/' . $doc['ruta']) }}#toolbar=0" width="100%"
                                                height="100%" style="border:none;"></iframe>
                                            @ fittings
                                        @else
                                            <div
                                                class="h-100 d-flex flex-column align-items-center justify-content-center p-4 text-center">
                                                <i class="fa-regular fa-file-pdf fa-3x text-danger opacity-25 mb-2"></i>
                                                <div class="fw-semibold text-secondary small">Documento no cargado en
                                                    servidor</div>
                                                <span class="text-muted mt-1" style="font-size: 11px;">Pendiente de subir
                                                    archivo PDF.</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-3 bg-white border-top">
                                        <input type="file" name="{{ $doc['key'] }}"
                                            class="form-control form-control-sm" {{ $doc['aprobado'] ? 'disabled' : '' }}
                                            accept="application/pdf">
                                        @if ($doc['aprobado'])
                                            <small class="text-success d-block mt-1 fw-semibold"
                                                style="font-size:11px;">Edición deshabilitada por aprobación</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        {{-- Campo Especial: RAC --}}
                        <div class="col-md-4">
                            <div
                                class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 border-top border-4 {{ $racData['aprobado'] ? 'border-success' : 'border-danger' }}">
                                <div class="p-3 bg-white d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">{{ $racData['nombre'] }}</h6>
                                        <small class="{{ $racData['aprobado'] ? 'text-success' : 'text-danger' }} fw-bold">
                                            <i
                                                class="fa-solid {{ $racData['aprobado'] ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>
                                            {{ $racData['aprobado'] ? 'Aprobado' : 'Rechazado' }}
                                        </small>
                                    </div>
                                    @if ($racData['existe'])
                                        <a href="{{ asset('storage/' . $racData['ruta']) }}" target="_blank"
                                            class="btn btn-light btn-sm rounded-circle shadow-sm text-primary"
                                            style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                        </a>
                                    @endif
                                </div>

                                <div style="height:340px; background:#f8f9fa;">
                                    @if ($racData['na'])
                                        <div
                                            class="h-100 d-flex flex-column align-items-center justify-content-center p-4 bg-light text-muted text-center">
                                            <i class="fa-solid fa-ban fa-2x mb-2 opacity-50"></i>
                                            <span class="fw-bold small">NO APLICA PARA ESTE CURSO</span>
                                        </div>
                                    @elseif ($racData['existe'])
                                        <iframe src="{{ asset('storage/' . $racData['ruta']) }}#toolbar=0" width="100%"
                                            height="100%" style="border:none;"></iframe>
                                    @else
                                        <div
                                            class="h-100 d-flex flex-column align-items-center justify-content-center p-4 text-center">
                                            <i class="fa-regular fa-file-pdf fa-3x text-danger opacity-25 mb-2"></i>
                                            <div class="fw-semibold text-secondary small">Sin archivo de regularización
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-3 bg-white border-top">
                                    @if (!$racData['aprobado'])
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" id="rac_na" name="rac_na"
                                                {{ $racData['na'] ? 'checked' : '' }}>
                                            <label class="form-check-label small text-secondary fw-semibold"
                                                for="rac_na">No aplica</label>
                                        </div>
                                        <input type="file" name="rac" id="rac"
                                            class="form-control form-control-sm" {{ $racData['na'] ? 'disabled' : '' }}
                                            accept="application/pdf">
                                    @else
                                        <input type="file" class="form-control form-control-sm" disabled>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECCIÓN II: EVIDENCIAS --}}
                    <h4 class="fw-bold text-success mb-4">EVIDENCIAS</h4>
                    <div class="row g-4 mb-5">
                        @foreach ($evidencias as $evi)
                            <div class="col-md-4">
                                <div
                                    class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 border-top border-4 {{ $evi['aprobado'] ? 'border-success' : 'border-danger' }}">
                                    <div class="p-3 bg-white d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="fw-bold mb-0 text-dark text-truncate" style="max-width: 190px;">
                                                {{ $evi['nombre'] }}</h6>
                                            <small class="{{ $evi['aprobado'] ? 'text-success' : 'text-danger' }} fw-bold">
                                                <i
                                                    class="fa-solid {{ $evi['aprobado'] ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>
                                                {{ $evi['aprobado'] ? 'Aprobado' : 'Rechazado' }}
                                            </small>
                                        </div>
                                        @if ($evi['existe'])
                                            <a href="{{ asset('storage/' . $evi['ruta']) }}" target="_blank"
                                                class="btn btn-light btn-sm rounded-circle shadow-sm text-success"
                                                style="width:36px; height:36px; display:flex; align-items:center; justify-content:center;">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                            </a>
                                        @endif
                                    </div>

                                    <div style="height:340px; background:#f8f9fa;">
                                        @if ($evi['existe'])
                                            <iframe src="{{ asset('storage/' . $evi['ruta']) }}#toolbar=0" width="100%"
                                                height="100%" style="border:none;"></iframe>
                                        @else
                                            <div
                                                class="h-100 d-flex flex-column align-items-center justify-content-center p-4 text-center">
                                                <i class="fa-regular fa-file-pdf fa-3x text-muted opacity-25 mb-2"></i>
                                                <div class="fw-semibold text-secondary small">Archivo no localizado</div>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="p-3 bg-white border-top">
                                        <input type="file" name="{{ $evi['key'] }}"
                                            class="form-control form-control-sm" {{ $evi['aprobado'] ? 'disabled' : '' }}
                                            accept="application/pdf">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- SECCIÓN III: INSTRUMENTOS MULTIPLES --}}
                    <div class="card border-0 shadow-sm rounded-4 mt-5">
                        <div class="card-body p-4">
                            <h4 class="fw-bold text-success mb-1">Evidencias de Instrumentos de Evaluación</h4>
                            <small class="{{ $instAprobados ? 'text-success' : 'text-danger' }} fw-bold mb-4 d-block">
                                <i class="fa-solid {{ $instAprobados ? 'fa-circle-check' : 'fa-circle-xmark' }} me-1"></i>
                                {{ $instAprobados ? 'Instrumentos Aprobados' : 'Instrumentos Rechazados / Modificables' }}
                            </small>

                            <div class="row g-4 mb-4">
                                @forelse($instrumentos as $i => $inst)
                                    <div class="col-md-4" id="pdf-old-{{ $i }}">
                                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                                            <div class="p-2 bg-light d-flex justify-content-between align-items-center">
                                                <small class="fw-bold text-secondary ps-2">Instrumento
                                                    {{ $i + 1 }}</small>
                                                <div class="d-flex gap-1">
                                                    @if ($inst['existe'])
                                                        <a href="{{ asset('storage/' . $inst['ruta_limpia']) }}"
                                                            target="_blank"
                                                            class="btn btn-white btn-sm rounded-circle border text-dark shadow-sm d-flex align-items-center justify-content-center"
                                                            style="width:32px; height:32px;">
                                                            <i class="fa-solid fa-expand" style="font-size:12px;"></i>
                                                        </a>
                                                    @endif
                                                    @if (!$instAprobados)
                                                        <button type="button"
                                                            class="btn btn-danger btn-sm rounded-circle shadow-sm d-flex align-items-center justify-content-center"
                                                            style="width:32px; height:32px;"
                                                            onclick="eliminarViejo({{ $i }}, '{{ $inst['ruta_original'] }}')">
                                                            <i class="fa-solid fa-trash-can" style="font-size:12px;"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                            <div style="height:300px; background:#f8f9fa;">
                                                @if ($inst['existe'])
                                                    <iframe src="{{ asset('storage/' . $inst['ruta_limpia']) }}#toolbar=0"
                                                        width="100%" height="100%" style="border:none;"></iframe>
                                                @else
                                                    <div
                                                        class="h-100 d-flex align-items-center justify-content-center text-muted small">
                                                        No se encuentra el archivo físico</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-light border text-center text-muted rounded-4 py-4">No hay
                                            instrumentos guardados.</div>
                                    </div>
                                @endforelse
                            </div>

                            <div id="contenedor-eliminados"></div>

                            @if (!$instAprobados)
                                <div class="p-4 rounded-4 border bg-light mt-4">
                                    <h6 class="fw-bold text-success mb-1">Subir nuevos instrumentos</h6>
                                    <p class="text-muted small mb-3">Máximo 3 archivos de instrumentos en total.</p>
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <input type="file" id="file-input-helper" class="d-none"
                                                accept="application/pdf" multiple>
                                            <button type="button" class="btn btn-success w-100 rounded-pill fw-bold"
                                                id="btn-seleccionar">Adjuntar PDFs</button>
                                        </div>
                                        <div class="col-md-8">
                                            <div id="lista-archivos" class="d-flex flex-column gap-2 mt-2 mt-md-0">
                                                <span class="text-muted small italic">Ningún elemento nuevo
                                                    seleccionado</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="hidden-inputs-container"></div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-5 justify-content-end">
                        <a href="{{ route('evidencias') }}" class="btn btn-light border px-4 rounded-pill"><i class="fa-solid fa-angle-left"></i>Cancelar</a>
                        <button type="submit" class="btn btn-primary px-5 rounded-pill shadow"><i class="fa-solid fa-floppy-disk"></i>Guardar Cambios</button>
                    </div>
                </form>

            </div>
        </section>
    </main>

    <script>
        const racCheck = document.getElementById('rac_na');
        const racInput = document.getElementById('rac');
        if (racCheck && racInput) {
            racCheck.addEventListener('change', function() {
                racInput.disabled = this.checked;
                if (this.checked) racInput.value = '';
            });
        }

        const helperInput = document.getElementById('file-input-helper');
        const btnSeleccionar = document.getElementById('btn-seleccionar');
        const listaArchivos = document.getElementById('lista-archivos');
        const hiddenContainer = document.getElementById('hidden-inputs-container');
        const contenedorEliminados = document.getElementById('contenedor-eliminados');

        let cantidadExistentes = {{ count($instrumentos) }};
        let archivosNuevos = [];

        if (btnSeleccionar && helperInput) {
            btnSeleccionar.addEventListener('click', () => helperInput.click());
            helperInput.addEventListener('change', function() {
                for (let file of this.files) {
                    if (file.type !== 'application/pdf') continue;
                    if ((cantidadExistentes + archivosNuevos.length) >= 3) {
                        alert('Límite rebasado: Solo se permite una colección máxima de 3 instrumentos.');
                        break;
                    }
                    archivosNuevos.push(file);
                }
                renderNuevos();
                this.value = '';
            });
        }

        function renderNuevos() {
            if (!listaArchivos || !hiddenContainer) return;
            listaArchivos.innerHTML = archivosNuevos.length === 0 ?
                '<span class="text-muted small italic">Ningún elemento nuevo seleccionado</span>' : '';

            archivosNuevos.forEach((file, i) => {
                listaArchivos.innerHTML += `
                <div class="d-flex justify-content-between align-items-center border px-3 py-2 rounded-3 bg-white shadow-sm small">
                    <span class="text-truncate text-secondary"><i class="fa-regular fa-file-pdf text-danger me-2"></i>${file.name}</span>
                    <button type="button" class="btn-close small" style="font-size:10px;" onclick="removeNuevoFile(${i})"></button>
                </div>`;
            });

            const dt = new DataTransfer();
            archivosNuevos.forEach(f => dt.items.add(f));

            hiddenContainer.innerHTML = '';
            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'instrumentos[]';
            input.multiple = true;
            input.files = dt.files;
            input.className = 'd-none';
            hiddenContainer.appendChild(input);
        }

        function removeNuevoFile(index) {
            archivosNuevos.splice(index, 1);
            renderNuevos();
        }

        function eliminarViejo(index, rutaOriginal) {
            if (confirm('¿Confirmas la remoción de este archivo?')) {
                document.getElementById(`pdf-old-${index}`)?.remove();
                cantidadExistentes--;

                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'instrumentos_eliminados[]';
                hidden.value = rutaOriginal;
                contenedorEliminados.appendChild(hidden);
            }
        }
    </script>

@endsection
