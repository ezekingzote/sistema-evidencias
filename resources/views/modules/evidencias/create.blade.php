@extends('layouts.main')

@section('titulo', 'Crear Evidencia')

@section('contenido')

    @php
        $primeraRevision = $revisiones->firstWhere('id', 1) ?? $revisiones->first();
        $primeraRevisionId = $primeraRevision->id ?? 1;
    @endphp

    <main id="main" class="main">

        <div class="pagetitle mb-4">
            <h1 class="fw-bold text-primary">
                Crear Evidencia
            </h1>
        </div>

        <section class="section">

            <div class="card p-4 shadow-lg border-0" style="border-radius: 18px;">

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                        <h6 class="fw-bold">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            Por favor corrige los siguientes errores:
                        </h6>

                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('evidencias.store') }}" method="POST" enctype="multipart/form-data"
                    id="form-evidencias">
                    @csrf

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">
                            <label class="fw-bold small text-uppercase text-secondary mb-2 block">
                                Materia
                            </label>

                            <select id="materia_id" name="materia_id" class="form-select form-select-lg fs-6" required>
                                <option value="">Seleccione</option>

                                @foreach ($materias as $materia)
                                    <option value="{{ $materia->id }}" data-unidades="{{ $materia->unidades }}">
                                        {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="fw-bold small text-uppercase text-secondary mb-2 block">
                                Revisión
                            </label>

                            <select id="revision_id" name="revision_id" class="form-select form-select-lg fs-6" required
                                disabled>
                                <option value="">Seleccione</option>

                                @foreach ($revisiones as $revision)
                                    <option value="{{ $revision->id }}"
                                        data-es-primera="{{ $revision->id == $primeraRevisionId ? '1' : '0' }}"
                                        data-es-cuarta="{{ $revision->id == 4 ? '1' : '0' }}">
                                        {{ $revision->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold text-primary mb-3">
                        ¿QUÉ UNIDADES EVALUASTE?
                    </h5>

                    <div class="row g-3 mb-4" id="contenedor_tarjetas_unidades">
                        <div class="col-12">
                            <span class="text-muted small">
                                Selecciona una materia y revisión para cargar las unidades disponibles.
                            </span>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold text-primary mb-3">
                        DOCUMENTOS
                    </h5>

                    <div class="row g-4">

                        <div class="col-md-6 campo-solo-revision-1">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-2.5 rounded-3 bg-primary-subtle text-primary me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-book-half"></i>
                                    </div>

                                    <label class="form-label fw-bold text-dark fs-5 mb-0">
                                        Instrumentación didáctica
                                    </label>
                                </div>

                                <input type="file" name="instrumentacion"
                                    class="form-control form-control-lg fs-6 input-solo-revision-1 archivo-pdf-5mb"
                                    accept="application/pdf" required>

                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Solo PDF. Tamaño máximo permitido: 5 MB.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6 campo-solo-revision-1">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-2.5 rounded-3 bg-info-subtle text-info me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>

                                    <label class="form-label fw-bold text-dark fs-5 mb-0">
                                        Reporte de inicio de curso
                                    </label>
                                </div>

                                <input type="file" name="reporte_inicio"
                                    class="form-control form-control-lg fs-6 input-solo-revision-1 archivo-pdf-5mb"
                                    accept="application/pdf" required>

                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Solo PDF. Tamaño máximo permitido: 5 MB.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6 campo-solo-revision-1">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-2.5 rounded-3 bg-warning-subtle text-warning me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-person-workspace"></i>
                                    </div>

                                    <label class="form-label fw-bold text-dark fs-5 mb-0">
                                        Acuerdos de clase
                                    </label>
                                </div>

                                <input type="file" name="acuerdos"
                                    class="form-control form-control-lg fs-6 input-solo-revision-1 archivo-pdf-5mb"
                                    accept="application/pdf" required>

                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Solo PDF. Tamaño máximo permitido: 5 MB.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6" id="contenedor_calificaciones">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-2.5 rounded-3 bg-success-subtle text-success me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-card-checklist"></i>
                                    </div>

                                    <label class="form-label fw-bold text-dark fs-5 mb-0">
                                        Lista de calificaciones
                                    </label>
                                </div>

                                <div class="wrapper-inputs d-flex flex-column gap-2">
                                    <span class="text-muted small">
                                        Selecciona unidades primero
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6" id="contenedor_rac">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white"
                                id="rac_card" style="transition: all 0.3s ease;">

                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-2.5 rounded-3 bg-secondary-subtle text-secondary me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-arrow-repeat"></i>
                                    </div>

                                    <label class="form-label fw-bold text-dark fs-5 mb-0">
                                        Actividades de Regularización (RAC)
                                    </label>
                                </div>

                                <div class="wrapper-inputs d-flex flex-column gap-3" id="rac_inputs_wrapper">
                                    <span class="text-muted small">
                                        Selecciona unidades primero
                                    </span>
                                </div>

                            </div>
                        </div>

                    </div>

                    <hr class="my-4">

                    <h5 class="fw-bold text-success mb-3">
                        EVIDENCIAS
                    </h5>

                    <div class="row g-4">

                        <div class="col-md-6 campo-solo-revision-1">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-2.5 rounded-3 bg-primary-subtle text-primary me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-file-earmark-medical"></i>
                                    </div>

                                    <label class="form-label fw-bold text-dark fs-5 mb-0">
                                        Examen diagnóstico
                                    </label>
                                </div>

                                <input type="file" name="examen_diagnostico"
                                    class="form-control form-control-lg fs-6 input-solo-revision-1 archivo-pdf-5mb"
                                    accept="application/pdf" required>

                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Solo PDF. Tamaño máximo permitido: 5 MB.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6 campo-solo-revision-1">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-2.5 rounded-3 bg-info-subtle text-info me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-bar-chart-line"></i>
                                    </div>

                                    <label class="form-label fw-bold text-dark fs-5 mb-0">
                                        Análisis del diagnóstico
                                    </label>
                                </div>

                                <input type="file" name="analisis_diagnostico"
                                    class="form-control form-control-lg fs-6 input-solo-revision-1 archivo-pdf-5mb"
                                    accept="application/pdf" required>

                                <small class="text-muted d-block mt-2">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Solo PDF. Tamaño máximo permitido: 5 MB.
                                </small>
                            </div>
                        </div>

                        <div class="col-md-6" id="contenedor_rubricas">
                            <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="p-2.5 rounded-3 bg-warning-subtle text-warning me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                        style="width: 45px; height: 45px;">
                                        <i class="bi bi-table"></i>
                                    </div>

                                    <label class="form-label fw-bold text-dark fs-5 mb-0">
                                        Rúbricas del semestre
                                    </label>
                                </div>

                                <div class="wrapper-inputs d-flex flex-column gap-2">
                                    <span class="text-muted small">
                                        Selecciona unidades primero
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="mt-4" id="seccion_dropzones_dinamicos"></div>

                    <!-- CAMPOS PARA REVISIÓN 4 -->
                    <div id="campos_revision_4" class="d-none">
                        <hr class="my-4">

                        <h5 class="fw-bold text-warning mb-3">
                            <i class="bi bi-star-fill me-2"></i>
                            DOCUMENTOS DE REVISIÓN 4
                        </h5>

                        <div class="row g-4">
                            <!-- Acta -->
                            <div class="col-md-6">
                                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="p-2.5 rounded-3 bg-danger-subtle text-danger me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 45px;">
                                            <i class="bi bi-file-text-fill"></i>
                                        </div>

                                        <label class="form-label fw-bold text-dark fs-5 mb-0">
                                            Adjuntar Actas
                                            <span class="text-danger ms-1">*</span>
                                        </label>
                                    </div>

                                    <input type="file" name="actas" id="actas_file"
                                        class="form-control form-control-lg fs-6 archivo-pdf-5mb input-revision-4"
                                        accept="application/pdf">

                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Acta de la revisión. Solo PDF, máximo 5 MB.
                                    </small>
                                </div>
                            </div>

                            <!-- Evidencias de segunda oportunidad -->
                            <div class="col-md-6">
                                <div class="card h-100 border border-light-subtle rounded-3 shadow-sm p-4 bg-white">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="p-2.5 rounded-3 bg-warning-subtle text-warning me-3 fs-4 d-inline-flex align-items-center justify-content-center"
                                            style="width: 45px; height: 45px;">
                                            <i class="bi bi-clock-history"></i>
                                        </div>

                                        <label class="form-label fw-bold text-dark fs-5 mb-0">
                                            Evidencias de Segunda Oportunidad
                                            <span class="text-danger ms-1">*</span>
                                        </label>
                                    </div>

                                    <div id="contenedor_evidencias_segunda_oportunidad">
                                        <div class="row g-2 mb-2">
                                            <div class="col-8">
                                                <input type="file" name="evidencias_segunda_oportunidad[]"
                                                    class="form-control archivo-pdf-5mb input-revision-4"
                                                    accept="application/pdf">
                                            </div>
                                            <div class="col-4">
                                                <button type="button" class="btn btn-outline-success w-100"
                                                    onclick="agregarCampoEvidenciaSegundaOportunidad()">
                                                    <i class="bi bi-plus-circle"></i> Agregar
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <small class="text-muted d-block mt-2">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Sube al menos una evidencia. Solo PDF, máximo 5 MB por archivo.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex gap-2">
                        <a href="{{ route('evidencias') }}" class="btn btn-light border px-4 rounded-pill">
                            <i class="bi bi-arrow-left me-1"></i>
                            Regresar
                        </a>

                        <button type="submit" class="btn btn-primary px-4 rounded-pill">
                            <i class="bi bi-floppy me-1"></i>
                            Guardar Evidencia
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

        .rac-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            width: 100%;
        }

        .rac-row .unidad-badge {
            min-width: 38px;
            text-align: center;
            margin-top: 7px;
        }

        .rac-row .rac-file-wrapper {
            flex: 1;
        }

        .rac-row .rac-file {
            width: 100%;
        }

        .rac-na-box {
            min-width: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 999px;
            padding: 6px 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.04);
            margin-top: 1px;
        }

        .rac-na-box .form-check-input {
            margin-top: 0;
            cursor: pointer;
        }

        .rac-na-box .form-check-label {
            cursor: pointer;
            user-select: none;
            font-size: 13px;
            font-weight: 600;
            color: #6c757d;
        }

        .rac-file:disabled {
            background-color: #e9ecef !important;
            cursor: not-allowed;
            opacity: 0.75;
        }

        .motivo-no-unidad-box {
            background-color: #f8f9fa;
            border: 1px dashed #ced4da;
            border-radius: 12px;
            padding: 14px;
        }

        .motivo-no-unidad-box textarea {
            resize: vertical;
            min-height: 110px;
        }

        @media (max-width: 768px) {
            .rac-row {
                flex-direction: column;
                align-items: stretch;
            }

            .rac-na-box {
                width: 100%;
                justify-content: flex-start;
            }
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
        const combinacionesSubidas = @json($subidasArray);
        const revisionesOriginales = @json($revisiones);
        const unidadesUtilizadas = @json($unidadesUtilizadasPorMateria);
        const primeraRevisionId = @json($primeraRevisionId);
        const motivoNoEvaluoOld = @json(old('motivo_no_evaluo'));

        const selectMateria = document.getElementById('materia_id');
        const selectRevision = document.getElementById('revision_id');
        const contenedorUnidades = document.getElementById('contenedor_tarjetas_unidades');
        const seccionDropzones = document.getElementById('seccion_dropzones_dinamicos');

        const wrapperCalificaciones = document.querySelector('#contenedor_calificaciones .wrapper-inputs');
        const wrapperRac = document.querySelector('#contenedor_rac .wrapper-inputs');
        const wrapperRubricas = document.querySelector('#contenedor_rubricas .wrapper-inputs');

        let archivosPorUnidad = {};
        let totalUnidadesMateria = 0;

        function escaparHtml(texto) {
            if (texto === null || texto === undefined) {
                return '';
            }

            return String(texto)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function esPrimeraRevision() {
            const option = selectRevision.options[selectRevision.selectedIndex];

            if (!option || !selectRevision.value) {
                return false;
            }

            return option.dataset.esPrimera === '1' || parseInt(selectRevision.value) === parseInt(primeraRevisionId);
        }

        function esCuartaRevision() {
            const option = selectRevision.options[selectRevision.selectedIndex];

            if (!option || !selectRevision.value) {
                return false;
            }

            return option.dataset.esCuarta === '1' || parseInt(selectRevision.value) === 4;
        }

        function actualizarCamposSoloRevisionUno() {
            const primeraRevision = esPrimeraRevision();
            const cuartaRevision = esCuartaRevision();

            // Si es Revisión 4, ocultar campos de Revisión 1
            if (cuartaRevision) {
                document.querySelectorAll('.campo-solo-revision-1').forEach(function(campo) {
                    campo.classList.add('d-none');
                });

                document.querySelectorAll('.input-solo-revision-1').forEach(function(input) {
                    input.value = '';
                    input.disabled = true;
                    input.required = false;
                });
            } else {
                document.querySelectorAll('.campo-solo-revision-1').forEach(function(campo) {
                    if (primeraRevision) {
                        campo.classList.remove('d-none');
                    } else {
                        campo.classList.add('d-none');
                    }
                });

                document.querySelectorAll('.input-solo-revision-1').forEach(function(input) {
                    if (primeraRevision) {
                        input.disabled = false;
                        input.required = true;
                    } else {
                        input.value = '';
                        input.disabled = true;
                        input.required = false;
                    }
                });
            }
        }

        function actualizarCamposRevisionCuatro() {
            const camposRevision4 = document.getElementById('campos_revision_4');
            const inputsRevision4 = document.querySelectorAll('.input-revision-4');

            if (!camposRevision4) {
                return;
            }

            const cuartaRevision = esCuartaRevision();

            if (cuartaRevision) {
                camposRevision4.classList.remove('d-none');

                // Hacer obligatorios los campos
                inputsRevision4.forEach(input => {
                    if (input.type === 'file') {
                        input.required = true;
                    }
                });

                // Asegurar que al menos una evidencia de segunda oportunidad esté presente
                const evidenciasContainer = document.getElementById('contenedor_evidencias_segunda_oportunidad');
                if (evidenciasContainer) {
                    const inputs = evidenciasContainer.querySelectorAll('input[type="file"]');
                    if (inputs.length === 0) {
                        agregarCampoEvidenciaSegundaOportunidad();
                    }
                }
            } else {
                camposRevision4.classList.add('d-none');

                // Quitar obligatoriedad
                inputsRevision4.forEach(input => {
                    input.required = false;
                    input.value = ''; // Limpiar valores
                });
            }
        }

        function agregarCampoEvidenciaSegundaOportunidad() {
            const container = document.getElementById('contenedor_evidencias_segunda_oportunidad');
            const currentInputs = container.querySelectorAll('.row.g-2');

            if (currentInputs.length >= 5) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Límite alcanzado',
                    text: 'Solo puedes subir hasta 5 evidencias de segunda oportunidad.'
                });
                return;
            }

            const newRow = document.createElement('div');
            newRow.className = 'row g-2 mb-2';
            newRow.innerHTML = `
            <div class="col-8">
                <input type="file"
                    name="evidencias_segunda_oportunidad[]"
                    class="form-control archivo-pdf-5mb input-revision-4"
                    accept="application/pdf"
                    required>
            </div>
            <div class="col-4">
                <button type="button"
                    class="btn btn-outline-danger w-100"
                    onclick="eliminarCampoEvidenciaSegundaOportunidad(this)">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </div>
        `;

            container.appendChild(newRow);
        }

        function eliminarCampoEvidenciaSegundaOportunidad(button) {
            const row = button.closest('.row.g-2');
            const container = document.getElementById('contenedor_evidencias_segunda_oportunidad');
            const currentInputs = container.querySelectorAll('.row.g-2');

            if (currentInputs.length <= 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Campo requerido',
                    text: 'Debes mantener al menos una evidencia de segunda oportunidad.'
                });
                return;
            }

            row.remove();
        }

        function actualizarCamposSoloRevisionUno() {
            const primeraRevision = esPrimeraRevision();
            const cuartaRevision = esCuartaRevision();

            if (cuartaRevision) {
                document.querySelectorAll('.campo-solo-revision-1').forEach(function(campo) {
                    campo.classList.add('d-none');
                });

                document.querySelectorAll('.input-solo-revision-1').forEach(function(input) {
                    input.value = '';
                    input.disabled = true;
                    input.required = false;
                });
            } else {
                document.querySelectorAll('.campo-solo-revision-1').forEach(function(campo) {
                    if (primeraRevision) {
                        campo.classList.remove('d-none');
                    } else {
                        campo.classList.add('d-none');
                    }
                });

                document.querySelectorAll('.input-solo-revision-1').forEach(function(input) {
                    if (primeraRevision) {
                        input.disabled = false;
                        input.required = true;
                    } else {
                        input.value = '';
                        input.disabled = true;
                        input.required = false;
                    }
                });
            }
        }

        function validarArchivoPdf5Mb(input) {
            const maxSize = 5 * 1024 * 1024;

            if (!input.files || input.files.length === 0) {
                return true;
            }

            for (const file of input.files) {
                if (file.type !== 'application/pdf') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Archivo no permitido',
                        text: 'Solo se permiten archivos en formato PDF.'
                    });

                    input.value = '';
                    return false;
                }

                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Archivo demasiado pesado',
                        text: `El archivo "${file.name}" supera el límite de 5 MB.`
                    });

                    input.value = '';
                    return false;
                }
            }

            return true;
        }

        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('rac-na-toggle')) {
                aplicarEstadoRacUnidad(e.target);
            }

            if (e.target.classList.contains('archivo-pdf-5mb')) {
                validarArchivoPdf5Mb(e.target);
            }
        });

        function aplicarEstadoRacUnidad(checkbox) {
            const unidad = checkbox.dataset.unidad;
            const inputRac = document.getElementById(`rac_file_${unidad}`);

            if (!inputRac) {
                return;
            }

            if (checkbox.checked) {
                inputRac.value = '';
                inputRac.disabled = true;
                inputRac.required = false;
            } else {
                inputRac.disabled = false;
                inputRac.required = true;
            }
        }

        selectMateria.addEventListener('change', function() {
            const materiaId = this.value;
            const optionSeleccionada = this.options[this.selectedIndex];

            totalUnidadesMateria = optionSeleccionada ?
                parseInt(optionSeleccionada.getAttribute('data-unidades')) :
                0;

            selectRevision.innerHTML = `<option value="">Seleccione</option>`;
            limpiarTodoAEstadoBase();

            let disponibles = 0;

            revisionesOriginales.forEach(revision => {
                const key = `${materiaId}-${revision.id}`;

                if (!combinacionesSubidas.includes(key)) {
                    const option = document.createElement('option');
                    option.value = revision.id;
                    option.text = revision.nombre;
                    option.dataset.esPrimera = parseInt(revision.id) === parseInt(primeraRevisionId) ? '1' :
                        '0';
                    option.dataset.esCuarta = revision.id === 4 ? '1' : '0';
                    selectRevision.appendChild(option);
                    disponibles++;
                }
            });

            selectRevision.disabled = (disponibles === 0);
            actualizarCamposSoloRevisionUno();
            actualizarCamposRevisionCuatro();
        });

        selectRevision.addEventListener('change', function() {
            limpiarTodoAEstadoBase();
            actualizarCamposSoloRevisionUno();
            actualizarCamposRevisionCuatro();

            if (!this.value) {
                return;
            }

            const materiaId = String(selectMateria.value);

            const quemadas = (
                unidadesUtilizadas[materiaId] || []
            ).map(num => parseInt(num));

            contenedorUnidades.innerHTML = '';

            contenedorUnidades.innerHTML += `
            <div class="col-md-3">
                <div class="card card-unidad-check p-3 text-center shadow-sm h-100 d-flex flex-column align-items-center justify-content-center"
                     id="card_unidad_0"
                     onclick="toggleUnidadTarjeta(0)">

                    <input type="checkbox"
                           id="chk_unidad_0"
                           name="unidades[]"
                           value="0"
                           class="d-none">

                    <i class="bi bi-dash-circle fs-3 text-secondary mb-2"></i>

                    <span class="fw-bold text-dark">
                        Ninguna Unidad
                    </span>
                </div>
            </div>
        `;

            let unidadesDisponibles = 0;

            for (let i = 1; i <= totalUnidadesMateria; i++) {
                if (quemadas.includes(i)) {
                    continue;
                }

                unidadesDisponibles++;

                contenedorUnidades.innerHTML += `
                <div class="col-md-3">
                    <div class="card card-unidad-check p-3 text-center shadow-sm h-100 d-flex flex-column align-items-center justify-content-center"
                         id="card_unidad_${i}"
                         onclick="toggleUnidadTarjeta(${i})">

                        <input type="checkbox"
                               id="chk_unidad_${i}"
                               name="unidades[]"
                               value="${i}"
                               class="d-none">

                        <i class="bi bi-bookmark-check fs-3 text-primary mb-2"></i>

                        <span class="fw-bold text-dark">
                            Unidad ${i}
                        </span>
                    </div>
                </div>
            `;
            }

            if (unidadesDisponibles === 0) {
                contenedorUnidades.innerHTML += `
                <div class="col-12">
                    <div class="alert alert-warning">
                        Todas las unidades de esta materia ya fueron evaluadas.
                    </div>
                </div>
            `;
            }
        });

        window.toggleUnidadTarjeta = function(num) {
            const checkbox = document.getElementById(`chk_unidad_${num}`);
            const tarjeta = document.getElementById(`card_unidad_${num}`);

            if (!checkbox || !tarjeta) {
                return;
            }

            if (num === 0) {
                for (let i = 1; i <= totalUnidadesMateria; i++) {
                    const chk = document.getElementById(`chk_unidad_${i}`);
                    const crd = document.getElementById(`card_unidad_${i}`);

                    if (chk && chk.checked) {
                        chk.checked = false;
                        crd.classList.remove('active');
                    }
                }

                checkbox.checked = !checkbox.checked;
                tarjeta.classList.toggle('active', checkbox.checked);
            } else {
                const chk0 = document.getElementById('chk_unidad_0');
                const crd0 = document.getElementById('card_unidad_0');

                if (chk0 && chk0.checked) {
                    chk0.checked = false;
                    crd0.classList.remove('active');
                }

                checkbox.checked = !checkbox.checked;
                tarjeta.classList.toggle('active', checkbox.checked);
            }

            procesarCambioUnidades();
        };

        function procesarCambioUnidades() {
            let seleccionadas = [];

            for (let i = 1; i <= totalUnidadesMateria; i++) {
                const chk = document.getElementById(`chk_unidad_${i}`);

                if (chk && chk.checked) {
                    seleccionadas.push(i);
                }
            }

            const chkNinguna = document.getElementById('chk_unidad_0');
            const cuartaRevision = esCuartaRevision();

            if (chkNinguna && chkNinguna.checked) {
                // Si es Revisión 4, mostramos el motivo pero los campos de Revisión 4 siguen visibles
                wrapperCalificaciones.innerHTML = `
                <input type="hidden" name="unidades[]" value="0">

                <div class="motivo-no-unidad-box">
                    <label for="motivo_no_evaluo" class="form-label fw-bold text-dark mb-2">
                        Motivo por el que no se evaluó ninguna unidad
                    </label>

                    <textarea
                        name="motivo_no_evaluo"
                        id="motivo_no_evaluo"
                        class="form-control fs-6"
                        rows="4"
                        maxlength="1000"
                        required
                        placeholder="Escribe el motivo por el que no se evaluó ninguna unidad...">${escaparHtml(motivoNoEvaluoOld ?? '')}</textarea>

                    <small class="text-muted d-block mt-2">
                        <i class="bi bi-info-circle me-1"></i>
                        Este motivo quedará registrado junto con la evidencia.
                    </small>
                </div>
            `;

                wrapperRac.innerHTML = `<span class="text-muted small">No aplica para esta revisión</span>`;
                wrapperRubricas.innerHTML = `<span class="text-muted small">No aplica para esta revisión</span>`;
                seccionDropzones.innerHTML = '';
                archivosPorUnidad = {};

                // Si es Revisión 4, aseguramos que los campos de Revisión 4 sigan visibles
                if (cuartaRevision) {
                    actualizarCamposRevisionCuatro();
                }
                return;
            }

            if (seleccionadas.length === 0) {
                wrapperCalificaciones.innerHTML = `<span class="text-muted small">Selecciona unidades primero</span>`;
                wrapperRac.innerHTML = `<span class="text-muted small">Selecciona unidades primero</span>`;
                wrapperRubricas.innerHTML = `<span class="text-muted small">Selecciona unidades primero</span>`;
                seccionDropzones.innerHTML = '';
                archivosPorUnidad = {};
                return;
            }

            wrapperCalificaciones.innerHTML = '';
            wrapperRac.innerHTML = '';
            wrapperRubricas.innerHTML = '';

            seleccionadas.forEach((unidad) => {
                wrapperCalificaciones.innerHTML += `
                <div class="mb-2">
                    <span class="badge bg-secondary mb-1">U${unidad}</span>

                    <input type="file"
                           name="calificaciones[${unidad}]"
                           class="form-control form-control-sm fs-6 archivo-pdf-5mb"
                           accept="application/pdf"
                           required>

                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle me-1"></i>
                        Solo PDF. Máximo 5 MB.
                    </small>
                </div>
            `;

                wrapperRac.innerHTML += `
                <div class="rac-row mb-2">
                    <span class="badge bg-secondary unidad-badge">
                        U${unidad}
                    </span>

                    <div class="rac-file-wrapper">
                        <input type="file"
                               name="rac[${unidad}]"
                               id="rac_file_${unidad}"
                               class="form-control form-control-sm fs-6 rac-file archivo-pdf-5mb"
                               accept="application/pdf"
                               required>

                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-info-circle me-1"></i>
                            Solo PDF. Máximo 5 MB.
                        </small>
                    </div>

                    <div class="form-check form-switch rac-na-box">
                        <input class="form-check-input rac-na-toggle"
                               type="checkbox"
                               name="rac_na[${unidad}]"
                               value="1"
                               id="rac_na_${unidad}"
                               data-unidad="${unidad}">

                        <label class="form-check-label" for="rac_na_${unidad}">
                            No aplica
                        </label>
                    </div>
                </div>
            `;

                wrapperRubricas.innerHTML += `
                <div class="mb-2">
                    <span class="badge bg-secondary mb-1">U${unidad}</span>

                    <input type="file"
                           name="rubricas[${unidad}]"
                           class="form-control form-control-sm fs-6 archivo-pdf-5mb"
                           accept="application/pdf"
                           required>

                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle me-1"></i>
                        Solo PDF. Máximo 5 MB.
                    </small>
                </div>
            `;
            });

            let nuevoRegistroArchivos = {};

            seccionDropzones.innerHTML =
                '<h5 class="fw-bold text-success mb-3">INSTRUMENTOS DE EVALUACIÓN INDIVIDUALES</h5>';

            seleccionadas.forEach(unidad => {
                nuevoRegistroArchivos[unidad] = archivosPorUnidad[unidad] || [];

                seccionDropzones.innerHTML += `
                <div class="card border border-light-subtle rounded-3 shadow-sm p-4 bg-white style-dropzone mb-3" id="dropzone_u_${unidad}">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="p-2.5 rounded-3 bg-success-subtle text-success me-3 fs-4 d-inline-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                <i class="bi bi-file-earmark-arrow-up"></i>
                            </div>

                            <div>
                                <h5 class="fw-bold text-dark fs-5 mb-0">
                                    Instrumentos de Evaluación -
                                    <span class="text-success">Unidad ${unidad}</span>
                                </h5>

                                <p class="text-muted small mb-0">
                                    Sube hasta 3 archivos PDF para esta unidad. Máximo 5 MB por archivo.
                                </p>
                            </div>
                        </div>

                        <button type="button"
                                class="btn btn-light border-0 p-2 rounded-circle btn-minimizar"
                                onclick="toggleMinimizarDropzone(${unidad}, this)">
                            <i class="bi bi-chevron-down fs-5 text-secondary"></i>
                        </button>
                    </div>

                    <div class="dropzone-body-collapse mt-3" id="body_dropzone_u_${unidad}">
                        <div class="row align-items-center bg-light p-3 rounded-3 g-3">
                            <div class="col-md-4">
                                <input type="file"
                                       id="helper_file_u_${unidad}"
                                       class="archivo-pdf-5mb"
                                       accept="application/pdf"
                                       multiple
                                       onchange="agregarArchivosDropzone(this, ${unidad})">

                                <button type="button"
                                        class="btn btn-outline-success rounded-pill fw-semibold small px-4 py-2.5 w-100 shadow-sm d-flex align-items-center justify-content-center gap-2"
                                        onclick="document.getElementById('helper_file_u_${unidad}').click()">
                                    <i class="bi bi-folder2-open"></i>
                                    Archivos Unidad ${unidad}
                                </button>
                            </div>

                            <div class="col-md-8">
                                <div id="lista_archivos_u_${unidad}"
                                     class="d-flex flex-column gap-2 text-start"></div>
                            </div>
                        </div>
                    </div>

                    <div id="hidden_inputs_u_${unidad}"></div>
                </div>
            `;
            });

            archivosPorUnidad = nuevoRegistroArchivos;
            seleccionadas.forEach(unidad => renderizarDropzoneUnidad(unidad));
        }

        window.toggleMinimizarDropzone = function(unidad, boton) {
            const cuerpo = document.getElementById(`body_dropzone_u_${unidad}`);

            if (!cuerpo) {
                return;
            }

            cuerpo.classList.toggle('collapsed');
            boton.classList.toggle('rotated');
        };

        window.agregarArchivosDropzone = function(inputElement, unidad) {
            if (!archivosPorUnidad[unidad]) {
                archivosPorUnidad[unidad] = [];
            }

            const maxSize = 5 * 1024 * 1024;

            for (let file of inputElement.files) {
                if (file.type !== 'application/pdf') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Archivo no permitido',
                        text: 'Solo se permiten archivos en formato PDF.'
                    });

                    continue;
                }

                if (file.size > maxSize) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Archivo demasiado pesado',
                        text: `El archivo "${file.name}" supera el límite de 5 MB.`
                    });

                    continue;
                }

                if (archivosPorUnidad[unidad].length >= 3) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Límite alcanzado',
                        text: 'Solo puedes subir hasta 3 archivos PDF por unidad.'
                    });

                    break;
                }

                archivosPorUnidad[unidad].push(file);
            }

            renderizarDropzoneUnidad(unidad);
            inputElement.value = '';
        };

        function renderizarDropzoneUnidad(unidad) {
            const lista = document.getElementById(`lista_archivos_u_${unidad}`);
            const hiddenContainer = document.getElementById(`hidden_inputs_u_${unidad}`);
            const files = archivosPorUnidad[unidad] || [];

            if (!lista || !hiddenContainer) {
                return;
            }

            lista.innerHTML = '';
            hiddenContainer.innerHTML = '';

            if (files.length === 0) {
                lista.innerHTML =
                    `<span class="text-muted small"><i class="bi bi-files me-1"></i> Ningún archivo seleccionado para la Unidad ${unidad}</span>`;
                return;
            }

            files.forEach((file, index) => {
                lista.innerHTML += `
                <div class="archivo-cargado-item d-flex align-items-center justify-content-between p-2.5 bg-white border border-light-subtle rounded-3 shadow-sm">
                    <div class="d-flex align-items-center">
                        <div class="p-2 rounded-2 bg-danger-subtle text-danger me-2.5 d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-file-earmark-pdf-fill fs-5"></i>
                        </div>

                        <span class="text-secondary fw-medium small">
                            ${file.name}
                        </span>
                    </div>

                    <button type="button"
                            class="btn-eliminar-archivo btn border-0 p-2 text-muted rounded-2 d-inline-flex align-items-center justify-content-center"
                            style="width: 32px; height: 32px;"
                            onclick="eliminarArchivoDropzone(${unidad}, ${index})">
                        <i class="bi bi-trash3 fs-5"></i>
                    </button>
                </div>
            `;
            });

            const dt = new DataTransfer();

            files.forEach(f => dt.items.add(f));

            const realInput = document.createElement('input');
            realInput.type = 'file';
            realInput.name = `instrumentos[${unidad}][]`;
            realInput.multiple = true;
            realInput.className = 'd-none';
            realInput.files = dt.files;

            hiddenContainer.appendChild(realInput);
        }

        window.eliminarArchivoDropzone = function(unidad, index) {
            archivosPorUnidad[unidad].splice(index, 1);
            renderizarDropzoneUnidad(unidad);
        };

        function limpiarTodoAEstadoBase() {
            contenedorUnidades.innerHTML =
                '<div class="col-12"><span class="text-muted small">Selecciona una materia y revisión para cargar las unidades disponibles.</span></div>';
            seccionDropzones.innerHTML = '';
            wrapperCalificaciones.innerHTML = '<span class="text-muted small">Selecciona unidades primero</span>';
            wrapperRac.innerHTML = '<span class="text-muted small">Selecciona unidades primero</span>';
            wrapperRubricas.innerHTML = '<span class="text-muted small">Selecciona unidades primero</span>';
            archivosPorUnidad = {};
            actualizarCamposSoloRevisionUno();
            actualizarCamposRevisionCuatro();
        }

        actualizarCamposSoloRevisionUno();
        actualizarCamposRevisionCuatro();
    </script>

@endsection