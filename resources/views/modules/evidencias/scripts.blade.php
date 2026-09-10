<script>
    const evidenciaAprobada = @json($evidenciaAprobada);
    const esPrimeraRevision = @json($esPrimeraRevision);
    const esCuartaRevision = @json($esCuartaRevision);
    const totalUnidadesMateria = @json($totalUnidadesMateria);
    const unidadesOcupadas = @json($unidadesOcupadas);
    const sinUnidadesDisponibles = @json($sinUnidadesDisponibles);

    const calificacionesAprobadas = @json($calificacionesAprobadas);
    const racAprobado = @json($racAprobado);
    const rubricasAprobadas = @json($rubricasAprobadas);
    const instrumentosAprobados = @json($instrumentosAprobados);

    const documentosData = @json($documentosData);
    const evidenciasData = @json($evidenciasData);
    const instrumentosExistentesOriginales = @json($instrumentosExistentes);
    const motivoNoEvaluoActual = @json($motivoNoEvaluo);

    let unidadesSeleccionadas = @json(array_values($unidadesSeleccionadas));
    let nuevosArchivosPorUnidad = {};
    let archivosExistentesAEliminar = [];
    let evidenciasSegundaOportunidadAEliminar = [];

    const wrapperCalificaciones = document.getElementById('wrapper_calificaciones');
    const wrapperRac = document.getElementById('wrapper_rac');
    const wrapperRubricas = document.getElementById('wrapper_rubricas');
    const seccionDropzones = document.getElementById('seccion_dropzones_dinamicos');

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

    function obtenerArchivo(valor) {
        if (valor && typeof valor === 'object' && !Array.isArray(valor)) {
            return valor.archivo ?? null;
        }

        if (typeof valor === 'string' && valor.trim() !== '') {
            return valor;
        }

        return null;
    }

    function confirmarEliminar(event) {
        event.preventDefault();

        Swal.fire({
            title: '¿Eliminar evidencia?',
            text: 'Esta acción eliminará la evidencia y TODOS sus archivos adjuntos. No podrás recuperarlos después.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-eliminar-evidencia').submit();
            }
        });
    }

    function obtenerNa(valor) {
        return !!(valor && typeof valor === 'object' && valor.na);
    }

    function assetStorage(path) {
        return `{{ asset('storage') }}/${path}`;
    }

    function limpiarNombreArchivo(path) {
        return path ? path.split('/').pop() : '';
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

    function actualizarListaUnidadesDesdeCheckboxes() {
        unidadesSeleccionadas = [];

        const chk0 = document.getElementById('chk_unidad_0');

        if (chk0 && chk0.checked) {
            unidadesSeleccionadas = [0];
            return;
        }

        for (let i = 1; i <= totalUnidadesMateria; i++) {
            const chk = document.getElementById(`chk_unidad_${i}`);

            if (chk && chk.checked && !chk.disabled) {
                unidadesSeleccionadas.push(i);
            }
        }
    }

    window.toggleUnidadTarjeta = function(num) {
        if (evidenciaAprobada) {
            return;
        }

        const checkbox = document.getElementById(`chk_unidad_${num}`);
        const tarjeta = document.getElementById(`card_unidad_${num}`);

        if (!checkbox || !tarjeta || checkbox.disabled) {
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

        actualizarListaUnidadesDesdeCheckboxes();
        procesarCambioUnidadesEdit();
    };

    function obtenerCalificacionUnidad(unidad) {
        return documentosData?.calificaciones_detalladas?.[`u${unidad}`] ?? null;
    }

    function obtenerRacUnidad(unidad) {
        return documentosData?.rac_detallado?.[`u${unidad}`] ?? null;
    }

    function obtenerRubricaUnidad(unidad) {
        return evidenciasData?.rubricas_detalladas?.[`u${unidad}`] ?? null;
    }

    function renderMotivoNoUnidad() {
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
                    ${evidenciaAprobada ? 'disabled' : ''}
                    placeholder="Escribe el motivo por el que no se evaluó ninguna unidad...">${escaparHtml(motivoNoEvaluoActual ?? '')}</textarea>

                <small class="text-muted d-block mt-2">
                    <i class="bi bi-info-circle me-1"></i>
                    Este motivo queda registrado porque no se subió lista de calificaciones.
                </small>
            </div>
        `;
    }

    function procesarCambioUnidadesEdit() {
        actualizarListaUnidadesDesdeCheckboxes();

        const esNingunaUnidad = unidadesSeleccionadas.includes(0);

        if (esNingunaUnidad) {
            renderMotivoNoUnidad();

            wrapperRac.innerHTML = `
                <div class="alert alert-secondary py-2 px-3 mb-0 small">
                    <i class="bi bi-ban me-1"></i>
                    No aplica para esta revisión.
                </div>
            `;

            wrapperRubricas.innerHTML = `
                <div class="alert alert-secondary py-2 px-3 mb-0 small">
                    <i class="bi bi-ban me-1"></i>
                    No aplica para esta revisión.
                </div>
            `;

            seccionDropzones.innerHTML = `
                <div class="alert alert-secondary">
                    <i class="bi bi-ban me-1"></i>
                    No aplica para esta revisión.
                </div>
            `;

            nuevosArchivosPorUnidad = {};
            return;
        }

        if (unidadesSeleccionadas.length === 0) {
            wrapperCalificaciones.innerHTML = `
                <span class="text-muted small">
                    Selecciona unidades primero
                </span>
            `;

            wrapperRac.innerHTML = `
                <span class="text-muted small">
                    Selecciona unidades primero
                </span>
            `;

            wrapperRubricas.innerHTML = `
                <span class="text-muted small">
                    Selecciona unidades primero
                </span>
            `;

            seccionDropzones.innerHTML = '';
            nuevosArchivosPorUnidad = {};
            return;
        }

        wrapperCalificaciones.innerHTML = '';
        wrapperRac.innerHTML = '';
        wrapperRubricas.innerHTML = '';

        if (calificacionesAprobadas) {
            wrapperCalificaciones.innerHTML = `
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Las calificaciones ya fueron aprobadas. No se pueden modificar.
                </div>
            `;
        } else {
            unidadesSeleccionadas.forEach(unidad => {
                const calData = obtenerCalificacionUnidad(unidad);
                const rutaCal = obtenerArchivo(calData);

                wrapperCalificaciones.innerHTML += `
                    <div class="mb-3">
                        <span class="badge bg-secondary mb-2">U${unidad}</span>

                        ${rutaCal ? `
                                <div class="border rounded-3 p-3 bg-light mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-3"></i>
                                            <div>
                                                <a href="${assetStorage(rutaCal)}"
                                                   target="_blank"
                                                   class="text-decoration-none fw-semibold">
                                                    Ver documento actual
                                                </a>
                                                <div class="small text-muted">Lista de calificaciones cargada - Unidad ${unidad}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ` : ''}

                        <input type="file"
                               name="calificaciones[${unidad}]"
                               class="form-control form-control-sm fs-6 archivo-pdf-5mb"
                               accept="application/pdf"
                               ${evidenciaAprobada ? 'disabled' : ''}>

                        <small class="text-muted">
                            ${rutaCal ? 'Dejar vacío para mantener. Solo PDF, máximo 5 MB.' : 'Archivo requerido. Solo PDF, máximo 5 MB.'}
                        </small>
                    </div>
                `;
            });
        }

        if (racAprobado) {
            wrapperRac.innerHTML = `
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Las actividades de regularización ya fueron aprobadas. No se pueden modificar.
                </div>
            `;
        } else {
            unidadesSeleccionadas.forEach(unidad => {
                const racData = obtenerRacUnidad(unidad);
                const racNa = obtenerNa(racData);
                const rutaRac = obtenerArchivo(racData);

                wrapperRac.innerHTML += `
                    <div class="rac-edit-row">
                        <span class="badge bg-secondary rac-edit-badge">
                            U${unidad}
                        </span>

                        <div class="rac-edit-file-box">
                            ${racNa ? `
                                    <div class="alert alert-secondary py-2 px-3 mb-2 small">
                                        <i class="bi bi-ban me-1"></i>
                                        Esta unidad está marcada como No aplica.
                                    </div>
                                ` : ''}

                            ${(!racNa && rutaRac) ? `
                                    <div class="border rounded-3 p-3 bg-light mb-2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-3"></i>
                                                <div>
                                                    <a href="${assetStorage(rutaRac)}"
                                                       target="_blank"
                                                       class="text-decoration-none fw-semibold">
                                                        Ver documento actual
                                                    </a>
                                                    <div class="small text-muted">Actividad de regularización cargada - Unidad ${unidad}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                ` : ''}

                            <input type="file"
                                   name="rac[${unidad}]"
                                   id="rac_file_${unidad}"
                                   class="form-control form-control-sm fs-6 rac-edit-file archivo-pdf-5mb"
                                   accept="application/pdf"
                                   ${racNa || evidenciaAprobada ? 'disabled' : ''}>

                            <small class="text-muted">
                                ${rutaRac ? 'Dejar vacío para mantener. Solo PDF, máximo 5 MB.' : 'Sube archivo o marca No aplica. Solo PDF, máximo 5 MB.'}
                            </small>
                        </div>

                        <div class="form-check form-switch rac-edit-na-box">
                            <input class="form-check-input rac-edit-na-toggle"
                                   type="checkbox"
                                   name="rac_na[${unidad}]"
                                   value="1"
                                   id="rac_na_${unidad}"
                                   data-unidad="${unidad}"
                                   ${racNa ? 'checked' : ''}
                                   ${evidenciaAprobada ? 'disabled' : ''}>

                            <label class="form-check-label" for="rac_na_${unidad}">
                                No aplica
                            </label>
                        </div>
                    </div>
                `;
            });
        }

        if (rubricasAprobadas) {
            wrapperRubricas.innerHTML = `
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Las rúbricas ya fueron aprobadas. No se pueden modificar.
                </div>
            `;
        } else {
            unidadesSeleccionadas.forEach(unidad => {
                const rubData = obtenerRubricaUnidad(unidad);
                const rutaRub = obtenerArchivo(rubData);

                wrapperRubricas.innerHTML += `
                    <div class="mb-3">
                        <span class="badge bg-secondary mb-2">U${unidad}</span>

                        ${rutaRub ? `
                                <div class="border rounded-3 p-3 bg-light mb-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-4 me-3"></i>
                                            <div>
                                                <a href="${assetStorage(rutaRub)}"
                                                   target="_blank"
                                                   class="text-decoration-none fw-semibold">
                                                    Ver documento actual
                                                </a>
                                                <div class="small text-muted">Rúbrica cargada - Unidad ${unidad}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            ` : ''}

                        <input type="file"
                               name="rubricas[${unidad}]"
                               class="form-control form-control-sm fs-6 archivo-pdf-5mb"
                               accept="application/pdf"
                               ${evidenciaAprobada ? 'disabled' : ''}>

                        <small class="text-muted">
                            ${rutaRub ? 'Dejar vacío para mantener. Solo PDF, máximo 5 MB.' : 'Archivo requerido. Solo PDF, máximo 5 MB.'}
                        </small>
                    </div>
                `;
            });
        }

        if (instrumentosAprobados) {
            seccionDropzones.innerHTML = `
                <div class="alert alert-success">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    Los instrumentos de evaluación ya fueron aprobados. No se pueden modificar.
                </div>
            `;
            nuevosArchivosPorUnidad = {};
            return;
        }

        seccionDropzones.innerHTML = '';

        unidadesSeleccionadas.forEach(unidad => {
            nuevosArchivosPorUnidad[unidad] = nuevosArchivosPorUnidad[unidad] || [];

            const instrumentosUnidad = instrumentosExistentesOriginales.filter(path =>
                typeof path === 'string' && path.includes(`instrumento_u${unidad}_`)
            );

            seccionDropzones.innerHTML += `
                <div class="card border border-light-subtle rounded-3 shadow-sm p-3 bg-white style-dropzone mb-3" id="dropzone_u_${unidad}">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                            <div class="p-2 rounded-3 bg-success-subtle text-success me-2 fs-5 d-inline-flex align-items-center justify-content-center"
                                 style="width: 40px; height: 40px;">
                                <i class="bi bi-file-earmark-arrow-up"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0">
                                    Instrumentos de Evaluación - Unidad ${unidad}
                                </h6>
                                <p class="text-muted small mb-0">Máximo 3 archivos PDF (5 MB c/u)</p>
                            </div>
                        </div>
                        <button type="button"
                                class="btn btn-light border-0 p-2 rounded-circle btn-minimizar"
                                onclick="toggleMinimizarDropzone(${unidad}, this)">
                            <i class="bi bi-chevron-down fs-5 text-secondary"></i>
                        </button>
                    </div>

                    <div class="dropzone-body-collapse mt-2" id="body_dropzone_u_${unidad}">
                        <div class="row align-items-center bg-light p-3 rounded-3 g-3">
                            <div class="col-md-4">
                                <input type="file"
                                       id="helper_file_u_${unidad}"
                                       class="archivo-pdf-5mb"
                                       accept="application/pdf"
                                       multiple
                                       onchange="agregarArchivosDropzone(this, ${unidad})"
                                       ${evidenciaAprobada ? 'disabled' : ''}>

                                <button type="button"
                                        class="btn btn-outline-success rounded-pill fw-semibold small px-3 py-2 w-100 shadow-sm d-flex align-items-center justify-content-center gap-2"
                                        onclick="document.getElementById('helper_file_u_${unidad}').click()"
                                        ${evidenciaAprobada ? 'disabled' : ''}>
                                    <i class="bi bi-folder2-open"></i>
                                    Seleccionar archivos
                                </button>
                            </div>

                            <div class="col-md-8">
                                <div id="lista_archivos_u_${unidad}" class="d-flex flex-column gap-2 text-start">
                                    ${instrumentosUnidad.map(path => `
                                            <div class="archivo-cargado-item d-flex align-items-center justify-content-between p-2 bg-white border border-light-subtle rounded-3 shadow-sm">
                                                <div class="d-flex align-items-center">
                                                    <div class="p-1 rounded-2 bg-danger-subtle text-danger me-2 d-inline-flex align-items-center justify-content-center"
                                                         style="width: 28px; height: 28px;">
                                                        <i class="bi bi-file-earmark-pdf-fill fs-6"></i>
                                                    </div>
                                                    <span class="text-secondary fw-medium small">${limpiarNombreArchivo(path)}</span>
                                                </div>
                                                ${!evidenciaAprobada ? `
                                                <button type="button"
                                                        class="btn-eliminar-archivo btn border-0 p-1 text-muted rounded-2 d-inline-flex align-items-center justify-content-center"
                                                        style="width: 28px; height: 28px;"
                                                        onclick="eliminarArchivoExistente(${unidad}, '${path}', this)">
                                                    <i class="bi bi-trash3 fs-6"></i>
                                                </button>
                                            ` : ''}
                                            </div>
                                        `).join('')}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="hidden_inputs_u_${unidad}"></div>
                </div>
            `;
        });

        unidadesSeleccionadas.forEach(unidad => renderizarDropzoneUnidad(unidad));
        aplicarListenersRac();
    }

    window.agregarArchivosDropzone = function(inputElement, unidad) {
        if (!validarArchivoPdf5Mb(inputElement)) return;

        if (!nuevosArchivosPorUnidad[unidad]) nuevosArchivosPorUnidad[unidad] = [];

        for (let file of inputElement.files) {
            if (file.type !== 'application/pdf') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Formato no permitido',
                    text: 'Solo PDF.'
                });
                continue;
            }
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Archivo muy pesado',
                    text: 'Máximo 5 MB.'
                });
                continue;
            }
            if (nuevosArchivosPorUnidad[unidad].length >= 3) {
                Swal.fire({
                    icon: 'info',
                    title: 'Límite alcanzado',
                    text: 'Solo 3 archivos por unidad.'
                });
                break;
            }
            nuevosArchivosPorUnidad[unidad].push(file);
        }

        renderizarDropzoneUnidad(unidad);
        inputElement.value = '';
    };

    window.eliminarArchivoExistente = function(unidad, ruta, boton) {
        if (evidenciaAprobada) return;

        Swal.fire({
            icon: 'warning',
            title: '¿Eliminar archivo?',
            text: 'Este archivo se eliminará al actualizar la evidencia.',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) return;

            archivosExistentesAEliminar.push(ruta);
            const item = boton.closest('.archivo-cargado-item');
            if (item) item.remove();

            const hiddenContainer = document.getElementById(`hidden_inputs_u_${unidad}`);
            const inputDel = document.createElement('input');
            inputDel.type = 'hidden';
            inputDel.name = `eliminar_instrumentos[${unidad}][]`;
            inputDel.value = ruta;
            hiddenContainer.appendChild(inputDel);
        });
    };

    function renderizarDropzoneUnidad(unidad) {
        const lista = document.getElementById(`lista_archivos_u_${unidad}`);
        const hiddenContainer = document.getElementById(`hidden_inputs_u_${unidad}`);
        const files = nuevosArchivosPorUnidad[unidad] || [];

        if (!lista || !hiddenContainer) return;

        const nuevosItems = lista.querySelectorAll('.archivo-nuevo');
        nuevosItems.forEach(el => el.remove());

        files.forEach((file, index) => {
            const nuevoDiv = document.createElement('div');
            nuevoDiv.className =
                'archivo-cargado-item archivo-nuevo d-flex align-items-center justify-content-between p-2 bg-white border border-light-subtle rounded-3 shadow-sm mb-1';
            nuevoDiv.innerHTML = `
                <div class="d-flex align-items-center">
                    <div class="p-1 rounded-2 bg-danger-subtle text-danger me-2 d-inline-flex align-items-center justify-content-center"
                         style="width: 28px; height: 28px;">
                        <i class="bi bi-file-earmark-pdf-fill fs-6"></i>
                    </div>
                    <span class="text-secondary fw-medium small">${file.name}</span>
                </div>
                <button type="button"
                        class="btn-eliminar-archivo btn border-0 p-1 text-muted rounded-2 d-inline-flex align-items-center justify-content-center"
                        style="width: 28px; height: 28px;"
                        onclick="eliminarArchivoNuevo(${unidad}, ${index})">
                    <i class="bi bi-trash3 fs-6"></i>
                </button>
            `;
            lista.appendChild(nuevoDiv);
        });

        let realInput = hiddenContainer.querySelector('input[type="file"][name^="instrumentos"]');
        if (!realInput) {
            realInput = document.createElement('input');
            realInput.type = 'file';
            realInput.name = `instrumentos[${unidad}][]`;
            realInput.multiple = true;
            realInput.className = 'd-none';
            hiddenContainer.appendChild(realInput);
        }

        const dt = new DataTransfer();
        files.forEach(f => dt.items.add(f));
        realInput.files = dt.files;
    }

    window.eliminarArchivoNuevo = function(unidad, index) {
        nuevosArchivosPorUnidad[unidad].splice(index, 1);
        renderizarDropzoneUnidad(unidad);
    };

    window.toggleMinimizarDropzone = function(unidad, boton) {
        const cuerpo = document.getElementById(`body_dropzone_u_${unidad}`);
        if (cuerpo) {
            cuerpo.classList.toggle('collapsed');
            boton.classList.toggle('rotated');
        }
    };

    function aplicarListenersRac() {
        document.querySelectorAll('.rac-edit-na-toggle').forEach(checkbox => {
            aplicarRacNoAplicaUnidad(checkbox);
            checkbox.addEventListener('change', function() {
                aplicarRacNoAplicaUnidad(this);
            });
        });
    }

    function aplicarRacNoAplicaUnidad(checkbox) {
        const unidad = checkbox.dataset.unidad;
        const inputFile = document.getElementById('rac_file_' + unidad);
        if (inputFile) {
            if (checkbox.checked) {
                inputFile.value = '';
                inputFile.disabled = true;
            } else {
                inputFile.disabled = evidenciaAprobada ? true : false;
            }
        }
    }

    function agregarCampoEvidenciaSegundaOportunidadEdit() {
        const container = document.getElementById('nuevas_evidencias_container_edit');
        if (!container) return;

        const currentInputs = container.querySelectorAll('.row.g-2');
        const existentes = document.querySelectorAll('.evidencia-existente');
        const totalActuales = existentes.length + currentInputs.length;

        if (totalActuales >= 10) {
            Swal.fire({
                icon: 'warning',
                title: 'Límite alcanzado',
                text: 'Solo puedes subir hasta 10 evidencias de segunda oportunidad en total.'
            });
            return;
        }

        const newRow = document.createElement('div');
        newRow.className = 'row g-2 mb-2';
        newRow.innerHTML = `
            <div class="col-8">
                <input type="file"
                    name="evidencias_segunda_oportunidad_nuevas[]"
                    class="form-control archivo-pdf-5mb"
                    accept="application/pdf"
                    required>
            </div>
            <div class="col-4">
                <button type="button"
                    class="btn btn-outline-danger w-100 btn-sm"
                    onclick="eliminarCampoEvidenciaSegundaOportunidadEdit(this)">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </div>
        `;
        container.appendChild(newRow);
    }

    function eliminarCampoEvidenciaSegundaOportunidadEdit(button) {
        const row = button.closest('.row.g-2');
        if (row) row.remove();
    }

    window.marcarEliminarEvidenciaSegundaOportunidad = function(button, ruta) {
        Swal.fire({
            icon: 'warning',
            title: '¿Eliminar evidencia?',
            text: 'Esta evidencia se eliminará al actualizar.',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (!result.isConfirmed) return;

            evidenciasSegundaOportunidadAEliminar.push(ruta);
            const row = button.closest('.row');
            row.classList.add('evidencia-eliminada');

            const hiddenContainer = document.getElementById('nuevas_evidencias_container_edit');
            if (hiddenContainer) {
                const inputDel = document.createElement('input');
                inputDel.type = 'hidden';
                inputDel.name = `eliminar_evidencias_segunda_oportunidad[]`;
                inputDel.value = ruta;
                hiddenContainer.appendChild(inputDel);
            }
        });
    };

    window.agregarCampoEvidenciaSegundaOportunidadEdit = agregarCampoEvidenciaSegundaOportunidadEdit;
    window.eliminarCampoEvidenciaSegundaOportunidadEdit = eliminarCampoEvidenciaSegundaOportunidadEdit;

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('archivo-pdf-5mb')) {
            validarArchivoPdf5Mb(e.target);
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        procesarCambioUnidadesEdit();
        aplicarListenersRac();
    });
</script>

