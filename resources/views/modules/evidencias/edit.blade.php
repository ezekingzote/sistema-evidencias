@extends('layouts.main')
@section('titulo', 'Editar Evidencia')
@section('contenido')

<main id="main" class="main">
    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">Editar Evidencia: {{ $evidencia->materia->nombre }}</h1>
    </div>
    <section class="section">
        <div class="card p-4 shadow-lg border-0" style="border-radius: 18px;">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                <h6 class="fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Por favor corrige los siguientes errores:</h6>
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <form action="{{ route('evidencias.update', $evidencia->id) }}" method="POST" enctype="multipart/form-data" id="form-evidencias">
                @csrf @method('PUT')

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="fw-bold small text-uppercase text-secondary mb-2 block">Materia</label>
                        <select id="materia_id" name="materia_id" class="form-select form-select-lg fs-6" required disabled>
                            <option value="{{ $evidencia->materia->id }}">{{ $evidencia->materia->nombre }}</option>
                        </select>
                        <input type="hidden" name="materia_id" value="{{ $evidencia->materia->id }}">
                    </div>

                    <div class="col-md-6">
                        <label class="fw-bold small text-uppercase text-secondary mb-2 block">Revisión</label>
                        <select id="revision_id" name="revision_id" class="form-select form-select-lg fs-6" required disabled>
                            <option value="{{ $evidencia->revision->id }}">{{ $evidencia->revision->nombre }}</option>
                        </select>
                        <input type="hidden" name="revision_id" value="{{ $evidencia->revision->id }}">
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="fw-bold text-primary mb-3">¿QUÉ UNIDADES EVALUASTE?</h5>
                <div class="row g-3 mb-4" id="contenedor_tarjetas_unidades">
                    @php
                    $unidadesSeleccionadas = $evidencia->documentos['unidades'] ?? [];
                    $totalUnidadesMateria = $evidencia->materia->unidades;
                    @endphp

                    @if(in_array(0, $unidadesSeleccionadas))
                    <div class="col-md-3">
                        <div class="card card-unidad-check p-3 text-center shadow-sm h-100 d-flex flex-column align-items-center justify-content-center active"
                            id="card_unidad_0">
                            <input type="checkbox" name="unidades[]" value="0" class="d-none" checked>
                            <i class="bi bi-dash-circle fs-3 text-secondary mb-2"></i>
                            <span class="fw-bold text-dark">Ninguna Unidad</span>
                        </div>
                    </div>
                    @else
                    @for($i = 1; $i <= $totalUnidadesMateria; $i++)
                        <div class="col-md-3">
                        <div class="card card-unidad-check p-3 text-center shadow-sm h-100 d-flex flex-column align-items-center justify-content-center {{ in_array($i, $unidadesSeleccionadas) ? 'active' : '' }}"
                            id="card_unidad_{{ $i }}" onclick="toggleUnidadTarjeta({{ $i }})">
                            <input type="checkbox" id="chk_unidad_{{ $i }}" name="unidades[]" value="{{ $i }}" class="d-none" {{ in_array($i, $unidadesSeleccionadas) ? 'checked' : '' }}>
                            <i class="bi bi-bookmark-check fs-3 text-primary mb-2"></i>
                            <span class="fw-bold text-dark">Unidad {{ $i }}</span>
                        </div>
                </div>
                @endfor
                @endif
        </div>

        <hr class="my-4">
        <h5 class="fw-bold text-primary mb-3">DOCUMENTOS</h5>
        <div class="row g-4">
            <!-- Instrumentación didáctica -->
            <div class="col-md-6">
                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2.5 rounded-3 bg-primary-subtle text-primary me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-book-half"></i>
                        </div>
                        <label class="form-label fw-bold text-dark fs-5 mb-0">Instrumentación didáctica</label>
                    </div>
                    @if($evidencia->documentos['documentos']['instrumentacion'] ?? false)
                    <div class="d-flex align-items-center bg-light p-2 rounded mb-2 border">
                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                        <a href="{{ asset('storage/' . $evidencia->documentos['documentos']['instrumentacion']) }}" target="_blank" class="text-decoration-none small text-truncate">Ver documento actual</a>
                    </div>
                    @endif
                    <input type="file" name="instrumentacion" class="form-control form-control-lg fs-6">
                    <small class="text-muted mt-1">Dejar vacío para mantener el actual.</small>
                </div>
            </div>

            <!-- Reporte de inicio -->
            <div class="col-md-6">
                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2.5 rounded-3 bg-info-subtle text-info me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <label class="form-label fw-bold text-dark fs-5 mb-0">Reporte de inicio de curso</label>
                    </div>
                    @if($evidencia->documentos['documentos']['reporte_inicio'] ?? false)
                    <div class="d-flex align-items-center bg-light p-2 rounded mb-2 border">
                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                        <a href="{{ asset('storage/' . $evidencia->documentos['documentos']['reporte_inicio']) }}" target="_blank" class="text-decoration-none small text-truncate">Ver documento actual</a>
                    </div>
                    @endif
                    <input type="file" name="reporte_inicio" class="form-control form-control-lg fs-6">
                    <small class="text-muted mt-1">Dejar vacío para mantener el actual.</small>
                </div>
            </div>

            <!-- Acuerdos de clase -->
            <div class="col-md-6">
                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2.5 rounded-3 bg-warning-subtle text-warning me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <label class="form-label fw-bold text-dark fs-5 mb-0">Acuerdos de clase</label>
                    </div>
                    @if($evidencia->documentos['documentos']['acuerdos'] ?? false)
                    <div class="d-flex align-items-center bg-light p-2 rounded mb-2 border">
                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                        <a href="{{ asset('storage/' . $evidencia->documentos['documentos']['acuerdos']) }}" target="_blank" class="text-decoration-none small text-truncate">Ver documento actual</a>
                    </div>
                    @endif
                    <input type="file" name="acuerdos" class="form-control form-control-lg fs-6">
                    <small class="text-muted mt-1">Dejar vacío para mantener el actual.</small>
                </div>
            </div>

            <!-- Lista de calificaciones (dinámico por unidad) -->
            <div class="col-md-6" id="contenedor_calificaciones">
                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2.5 rounded-3 bg-success-subtle text-success me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-card-checklist"></i>
                        </div>
                        <label class="form-label fw-bold text-dark fs-5 mb-0">Lista de calificaciones</label>
                    </div>
                    <div class="wrapper-inputs d-flex flex-column gap-2">
                        @if(in_array(0, $unidadesSeleccionadas))
                        <span class="text-muted small">No aplica para esta revisión</span>
                        <input type="hidden" name="unidades[]" value="0">
                        @else
                        @foreach($unidadesSeleccionadas as $unidad)
                        <div class="mb-2">
                            <span class="badge bg-secondary mb-1">U{{ $unidad }}</span>
                            @php
                            $rutaCal = $evidencia->documentos['documentos']['calificaciones_detalladas']["u{$unidad}"] ?? null;
                            @endphp
                            @if($rutaCal)
                            <div class="d-flex align-items-center bg-light p-1 rounded mb-1">
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                <a href="{{ asset('storage/' . $rutaCal) }}" target="_blank" class="text-decoration-none small">Actual</a>
                            </div>
                            @endif
                            <input type="file" name="calificaciones[{{ $unidad }}]" class="form-control form-control-sm fs-6">
                            <small class="text-muted">Dejar vacío para mantener</small>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actividades de Regularización (RAC) -->
            <div class="col-md-6" id="contenedor_rac">
                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white" id="rac_card">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="p-2.5 rounded-3 bg-secondary-subtle text-secondary me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                            <label class="form-label fw-bold text-dark fs-5 mb-0">Actividades de Regularización (RAC)</label>
                        </div>
                        <div class="form-check form-switch bg-light border rounded-pill px-3 py-1.5 d-flex align-items-center shadow-sm">
                            <input class="form-check-input me-2 mt-0" type="checkbox" id="rac_na" name="rac_na" style="cursor: pointer;" {{ ($evidencia->documentos['documentos']['rac']['na'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label small fw-semibold text-secondary" for="rac_na" style="cursor: pointer; user-select: none;">No aplica</label>
                        </div>
                    </div>
                    <div class="wrapper-inputs d-flex flex-column gap-2">
                        @if(in_array(0, $unidadesSeleccionadas))
                        <span class="text-muted small">No aplica para esta revisión</span>
                        @else
                        @foreach($unidadesSeleccionadas as $unidad)
                        <div class="mb-2">
                            <span class="badge bg-secondary mb-1">U{{ $unidad }}</span>
                            @php
                            $racData = $evidencia->documentos['documentos']['rac_detallado']["u{$unidad}"] ?? null;
                            $rutaRac = is_array($racData) ? ($racData['archivo'] ?? null) : null;
                            @endphp
                            @if($rutaRac && !($racData['na'] ?? false))
                            <div class="d-flex align-items-center bg-light p-1 rounded mb-1">
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                <a href="{{ asset('storage/' . $rutaRac) }}" target="_blank" class="text-decoration-none small">Actual</a>
                            </div>
                            @endif
                            <input type="file" name="rac[{{ $unidad }}]" class="form-control form-control-sm fs-6" {{ ($evidencia->documentos['documentos']['rac']['na'] ?? false) ? 'disabled' : '' }}>
                            <small class="text-muted">Dejar vacío para mantener</small>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">
        <h5 class="fw-bold text-success mb-3">EVIDENCIAS</h5>
        <div class="row g-4">
            <!-- Examen diagnóstico -->
            <div class="col-md-6">
                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2.5 rounded-3 bg-primary-subtle text-primary me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-file-earmark-medical"></i>
                        </div>
                        <label class="form-label fw-bold text-dark fs-5 mb-0">Examen diagnóstico</label>
                    </div>
                    @if($evidencia->documentos['evidencias']['examen_diagnostico'] ?? false)
                    <div class="d-flex align-items-center bg-light p-2 rounded mb-2 border">
                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                        <a href="{{ asset('storage/' . $evidencia->documentos['evidencias']['examen_diagnostico']) }}" target="_blank" class="text-decoration-none small text-truncate">Ver documento actual</a>
                    </div>
                    @endif
                    <input type="file" name="examen_diagnostico" class="form-control form-control-lg fs-6">
                    <small class="text-muted mt-1">Dejar vacío para mantener el actual.</small>
                </div>
            </div>

            <!-- Análisis del diagnóstico -->
            <div class="col-md-6">
                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2.5 rounded-3 bg-info-subtle text-info me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-bar-chart-line"></i>
                        </div>
                        <label class="form-label fw-bold text-dark fs-5 mb-0">Análisis del diagnóstico</label>
                    </div>
                    @if($evidencia->documentos['evidencias']['analisis_diagnostico'] ?? false)
                    <div class="d-flex align-items-center bg-light p-2 rounded mb-2 border">
                        <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                        <a href="{{ asset('storage/' . $evidencia->documentos['evidencias']['analisis_diagnostico']) }}" target="_blank" class="text-decoration-none small text-truncate">Ver documento actual</a>
                    </div>
                    @endif
                    <input type="file" name="analisis_diagnostico" class="form-control form-control-lg fs-6">
                    <small class="text-muted mt-1">Dejar vacío para mantener el actual.</small>
                </div>
            </div>

            <!-- Rúbricas del semestre (dinámico por unidad) -->
            <div class="col-md-6" id="contenedor_rubricas">
                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-2.5 rounded-3 bg-warning-subtle text-warning me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-table"></i>
                        </div>
                        <label class="form-label fw-bold text-dark fs-5 mb-0">Rúbricas del semestre</label>
                    </div>
                    <div class="wrapper-inputs d-flex flex-column gap-2">
                        @if(in_array(0, $unidadesSeleccionadas))
                        <span class="text-muted small">No aplica para esta revisión</span>
                        @else
                        @foreach($unidadesSeleccionadas as $unidad)
                        <div class="mb-2">
                            <span class="badge bg-secondary mb-1">U{{ $unidad }}</span>
                            @php
                            $rutaRub = $evidencia->documentos['evidencias']['rubricas_detalladas']["u{$unidad}"] ?? null;
                            @endphp
                            @if($rutaRub)
                            <div class="d-flex align-items-center bg-light p-1 rounded mb-1">
                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>
                                <a href="{{ asset('storage/' . $rutaRub) }}" target="_blank" class="text-decoration-none small">Actual</a>
                            </div>
                            @endif
                            <input type="file" name="rubricas[{{ $unidad }}]" class="form-control form-control-sm fs-6">
                            <small class="text-muted">Dejar vacío para mantener</small>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- INSTRUMENTOS DE EVALUACIÓN INDIVIDUALES (Dropzones por unidad) -->
        <hr class="my-4">
        <div id="seccion_dropzones_dinamicos">
            <h5 class="fw-bold text-success mb-3">INSTRUMENTOS DE EVALUACIÓN INDIVIDUALES</h5>
            @if(!in_array(0, $unidadesSeleccionadas))
            @foreach($unidadesSeleccionadas as $unidad)
            @php
            $instrumentosExistentes = $evidencia->documentos['instrumentos'] ?? [];
            $instrumentosUnidad = array_filter($instrumentosExistentes, function($path) use ($unidad) {
            return strpos($path, "instrumento_u{$unidad}_") !== false;
            });
            @endphp
            <div class="card border border-light-subtle rounded-3 shadow-sm p-4 bg-white style-dropzone mb-3" id="dropzone_u_{{ $unidad }}">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center">
                        <div class="p-2.5 rounded-3 bg-success-subtle text-success me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="bi bi-file-earmark-arrow-up"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark fs-5 mb-0">Instrumentos de Evaluación - <span class="text-success">Unidad {{ $unidad }}</span></h5>
                            <p class="text-muted small mb-0">Sube hasta 3 archivos PDF para esta unidad</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-light border-0 p-2 rounded-circle btn-minimizar" onclick="toggleMinimizarDropzone({{ $unidad }}, this)">
                        <i class="bi bi-chevron-down fs-5 text-secondary"></i>
                    </button>
                </div>

                <div class="dropzone-body-collapse mt-3" id="body_dropzone_u_{{ $unidad }}">
                    <div class="row align-items-center bg-light p-3 rounded-3 g-3">
                        <div class="col-md-4">
                            <input type="file" id="helper_file_u_{{ $unidad }}" accept="application/pdf" multiple onchange="agregarArchivosDropzone(this, {{ $unidad }})">
                            <button type="button" class="btn btn-outline-success rounded-pill fw-semibold small px-4 py-2.5 w-100 shadow-sm d-flex align-items-center justify-content-center gap-2" onclick="document.getElementById('helper_file_u_{{ $unidad }}').click()">
                                <i class="bi bi-folder2-open"></i> Archivos Unidad {{ $unidad }}
                            </button>
                        </div>
                        <div class="col-md-8">
                            <div id="lista_archivos_u_{{ $unidad }}" class="d-flex flex-column gap-2 text-start">
                                @foreach($instrumentosUnidad as $idx => $path)
                                <div class="archivo-cargado-item d-flex align-items-center justify-content-between p-2.5 bg-white border border-light-subtle rounded-3 shadow-sm">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 rounded-2 bg-danger-subtle text-danger me-2.5 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                            <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                                        </div>
                                        <span class="text-secondary fw-medium small">{{ basename($path) }}</span>
                                    </div>
                                    <button type="button" class="btn-eliminar-archivo btn border-0 p-2 text-muted rounded-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" onclick="eliminarArchivoExistente({{ $unidad }}, '{{ $path }}', this)">
                                        <i class="bi bi-trash3 fs-5"></i>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div id="hidden_inputs_u_{{ $unidad }}"></div>
            </div>
            @endforeach
            @endif
        </div>

        <div class="mt-4 d-flex gap-2">
            <a href="{{ route('evidencias') }}" class="btn btn-light border px-4 rounded-pill">
                <i class="bi bi-arrow-left me-1"></i> Regresar
            </a>
            <button type="submit" class="btn btn-primary px-4 rounded-pill">
                <i class="bi bi-floppy me-1"></i> Actualizar Evidencia
            </button>
        </div>
        </form>
        </div>
    </section>
</main>

<style>
    .style-dropzone input[type="file"] {
        display: none !important;
    }

    .style-dropzone .row.align-items-center {
        background-color: #f8f9fa;
        border: 1px dashed #dee2e6;
        border-radius: 0.5rem;
    }

    .card-unidad-check {
        cursor: pointer;
        transition: all 0.2s ease;
        border: 2px solid #dee2e6 !important;
    }

    .card-unidad-check:hover {
        border-color: #0d6efd !important;
        background-color: #f8f9fa;
    }

    .card-unidad-check.active {
        border-color: #198754 !important;
        background-color: #f0fdf4;
    }

    .dropzone-body-collapse {
        transition: max-height 0.35s ease, opacity 0.3s ease;
        max-height: 500px;
        opacity: 1;
        overflow: hidden;
    }

    .dropzone-body-collapse.collapsed {
        max-height: 0px !important;
        opacity: 0 !important;
        pointer-events: none;
    }

    .btn-minimizar {
        transition: transform 0.25s ease;
    }

    .btn-minimizar.rotated {
        transform: rotate(-180deg);
    }

    .archivo-cargado-item {
        animation: fadeInItem 0.25s ease-out forwards;
    }

    .btn-eliminar-archivo:hover {
        background-color: #fde8e8 !important;
        color: #dc3545 !important;
    }

    @keyframes fadeInItem {
        from {
            opacity: 0;
            transform: translateY(4px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    // Variables globales para manejar archivos nuevos por unidad (sustituye a archivosPorUnidad)
    let nuevosArchivosPorUnidad = {};
    let archivosExistentesAEliminar = []; // almacenará rutas a eliminar en el servidor

    // Inicializar estructura para unidades seleccionadas
    const unidadesSeleccionadas = @json($unidadesSeleccionadas);
    if (!unidadesSeleccionadas.includes(0)) {
        unidadesSeleccionadas.forEach(unidad => {
            nuevosArchivosPorUnidad[unidad] = [];
        });
    }

    // Función para agregar nuevos archivos a una unidad (desde el input)
    window.agregarArchivosDropzone = function(inputElement, unidad) {
        if (!nuevosArchivosPorUnidad[unidad]) nuevosArchivosPorUnidad[unidad] = [];
        for (let file of inputElement.files) {
            if (file.type !== 'application/pdf') continue;
            if (nuevosArchivosPorUnidad[unidad].length >= 3) break;
            nuevosArchivosPorUnidad[unidad].push(file);
        }
        renderizarDropzoneUnidad(unidad);
        inputElement.value = '';
    };

    // Eliminar archivo existente (marcar para borrar físicamente)
    window.eliminarArchivoExistente = function(unidad, ruta, boton) {
        if (confirm('¿Eliminar este archivo permanentemente?')) {
            archivosExistentesAEliminar.push(ruta);
            // Remover visualmente el elemento
            const item = boton.closest('.archivo-cargado-item');
            item.remove();
            // Agregar input oculto para notificar al servidor qué rutas eliminar
            const hiddenContainer = document.getElementById(`hidden_inputs_u_${unidad}`);
            const inputDel = document.createElement('input');
            inputDel.type = 'hidden';
            inputDel.name = `eliminar_instrumentos[${unidad}][]`;
            inputDel.value = ruta;
            hiddenContainer.appendChild(inputDel);
        }
    };

    // Renderizar los archivos nuevos (no los existentes) en la lista de cada dropzone
    function renderizarDropzoneUnidad(unidad) {
        const lista = document.getElementById(`lista_archivos_u_${unidad}`);
        const hiddenContainer = document.getElementById(`hidden_inputs_u_${unidad}`);
        const files = nuevosArchivosPorUnidad[unidad] || [];

        // Eliminar los elementos que representan archivos nuevos (para evitar duplicados)
        const nuevosItems = lista.querySelectorAll('.archivo-nuevo');
        nuevosItems.forEach(el => el.remove());

        files.forEach((file, index) => {
            const nuevoDiv = document.createElement('div');
            nuevoDiv.className = 'archivo-cargado-item archivo-nuevo d-flex align-items-center justify-content-between p-2.5 bg-white border border-light-subtle rounded-3 shadow-sm';
            nuevoDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="p-2 rounded-2 bg-danger-subtle text-danger me-2.5 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                        <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                    </div>
                    <span class="text-secondary fw-medium small">${file.name}</span>
                </div>
                <button type="button" class="btn-eliminar-archivo btn border-0 p-2 text-muted rounded-2 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;" onclick="eliminarArchivoNuevo(${unidad}, ${index})">
                    <i class="bi bi-trash3 fs-5"></i>
                </button>
            `;
            lista.appendChild(nuevoDiv);
        });

        // Crear input múltiple con los archivos nuevos
        const dt = new DataTransfer();
        files.forEach(f => dt.items.add(f));
        let realInput = hiddenContainer.querySelector('input[type="file"][name^="instrumentos"]');
        if (!realInput) {
            realInput = document.createElement('input');
            realInput.type = 'file';
            realInput.name = `instrumentos[${unidad}][]`;
            realInput.multiple = true;
            realInput.className = 'd-none';
            hiddenContainer.appendChild(realInput);
        }
        realInput.files = dt.files;
    }

    window.eliminarArchivoNuevo = function(unidad, index) {
        nuevosArchivosPorUnidad[unidad].splice(index, 1);
        renderizarDropzoneUnidad(unidad);
    };

    window.toggleMinimizarDropzone = function(unidad, boton) {
        const cuerpo = document.getElementById(`body_dropzone_u_${unidad}`);
        cuerpo.classList.toggle('collapsed');
        boton.classList.toggle('rotated');
    };

    // Manejo del switch RAC
    const racCheck = document.getElementById('rac_na');
    const racCard = document.getElementById('rac_card');

    function aplicarRacDisabled() {
        const inputsRac = document.querySelectorAll('#contenedor_rac .wrapper-inputs input[type="file"]');
        if (racCheck.checked) {
            inputsRac.forEach(input => {
                input.disabled = true;
                input.value = '';
            });
            racCard.style.opacity = '0.6';
        } else {
            inputsRac.forEach(input => {
                input.disabled = false;
            });
            racCard.style.opacity = '1';
        }
    }
    racCheck.addEventListener('change', aplicarRacDisabled);
    aplicarRacDisabled();

    // Unidades: como la materia y revisión están fijas, solo permitimos cambiar las unidades seleccionadas
    // pero hay que sincronizar los campos dinámicos al cambiar las tarjetas.
    // Para simplificar, no permitimos cambiar las unidades en edición (por coherencia con los archivos ya subidos).
    // Si quieres habilitarlo, necesitarías una lógica más compleja. Por ahora dejamos las tarjetas sin evento de toggle
    // y deshabilitamos los clicks para evitar inconsistencia.
    document.querySelectorAll('.card-unidad-check').forEach(card => {
        card.style.cursor = 'default';
        card.removeAttribute('onclick');
    });
</script>
@endsection