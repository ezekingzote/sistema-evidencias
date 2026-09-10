<!-- Modal del Manual Evidencias Docente -->
<div class="modal fade" id="modalManualEvidenciasDocente" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Encabezado  -->
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2 align-items-start">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; flex-shrink: 0;">
                        <i class="bi bi-file-earmark-arrow-up-fill fs-2"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="modalManualLabel">Manual del Docente</h4>
                        <span class="text-muted fw-semibold fs-5">Registro y Subida de Evidencias</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body px-4 pb-4 pt-2">
                
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-4 text-dark mb-4 fs-6 lh-base">
                    <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
                    Este módulo te permite cargar tu documentación académica de manera organizada. El formulario se adaptará automáticamente mostrándote solo los campos que necesitas subir dependiendo de la revisión y las unidades evaluadas.
                </div>

                <!-- Contenedor de Pasos -->
                <div class="d-flex flex-column gap-3">
                    <!-- Tarjeta 1: Configuración Inicial -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-1-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Configuración de la Entrega</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Al crear una evidencia, primero debes seleccionar la <strong>Materia</strong> y el periodo de <strong>Revisión</strong> correspondiente.</li>
                                    <li>Luego, indica <strong>¿Qué unidades evaluaste?</strong> en el lapso de las últimas 4 semanas haciendo clic en los recuadros. Si no evaluaste ninguna unidad, selecciona "Ninguna Unidad" y el sistema te pedirá un breve motivo.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Primera Revisión -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-2-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Entregas de Primera Revisión</h5>
                                <p class="text-muted mb-0 fs-6 lh-base">
                                    Si seleccionas la <strong>Primera Revisión</strong>, el formulario te solicitará los documentos de apertura de curso: <em>Instrumentación didáctica, Reporte de inicio de curso, Acuerdos de clase, Examen diagnóstico y Análisis del diagnóstico</em>. Solo se admiten archivos en formato PDF (máximo 5 MB).
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3: Revisiones Posteriores -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-3-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Segunda Revisión en Adelante</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Para revisiones posteriores (o cuando seleccionas unidades específicas), la interfaz cambiará automáticamente.</li>
                                    <li>Solo se te pedirá cargar la documentación específica de esas unidades: <strong>Listas de calificaciones, Actividades de Regularización "RAC" (Si amerita), Rúbricas y hasta 3 Instrumentos de Evaluación</strong> por unidad marcada.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Pie del Modal -->
            <div class="modal-footer border-top-0 pt-0 px-4 pb-4 justify-content-center">
                <button type="button" class="btn btn-primary btn-lg rounded-pill px-5 fw-semibold shadow-sm" data-bs-dismiss="modal">
                    ¡Entendido!
                </button>
            </div>
            
        </div>
    </div>
</div>