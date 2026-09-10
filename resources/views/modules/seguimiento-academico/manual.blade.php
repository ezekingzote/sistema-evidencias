<!-- Modal del Manual de Administración de Evidencias -->
<div class="modal fade" id="modalManualEvidencias" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Encabezado Moderno -->
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2 align-items-start">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; flex-shrink: 0;">
                        <i class="bi bi-file-earmark-check-fill fs-2"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="modalManualLabel">Manual de Usuario</h4>
                        <span class="text-muted fw-semibold fs-5">Administración de Evidencias</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body px-4 pb-4 pt-2">
                
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-4 text-dark mb-4 fs-6 lh-base">
                    <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
                    En este módulo se concentran todas las entregas realizadas por los docentes. Aquí podrás revisar los documentos PDF, asignar calificaciones, dejar retroalimentación y determinar si la evidencia se aprueba o se rechaza.
                </div>

                <!-- Contenedor de Pasos -->
                <div class="d-flex flex-column gap-3">

                    <!-- Tarjeta 1: Acceder a la evaluación -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-1-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Acceder a la Evaluación</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">En la tabla principal verás el listado de docentes, la asignatura que imparten y el estatus de sus revisiones.</li>
                                    <li>Haz clic en el <strong>botón amarillo con el ícono de reloj</strong> en la columna de Acciones para ingresar al panel de evaluación de ese docente en específico.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Navegación y Visor -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-2-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Navegación y Visor de PDF</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">A tu izquierda encontrarás el menú de <strong>Secciones</strong> (Instrumentación didáctica, Examen diagnóstico, etc.).</li>
                                    <li>Al hacer clic en cualquier sección, el documento correspondiente se cargará automáticamente en el <strong>visor de PDF central</strong> para que puedas leerlo sin salir del sistema.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3: Calificación y Autoguardado -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-3-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Calificación y Autoguardado</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Debajo del visor de PDF se encuentra el panel de calificación. Aquí puedes ingresar una <strong>calificación (0-100)</strong> y escribir <strong>observaciones</strong>.</li>
                                    <li class="mb-2">Si un documento no es requerido para esa materia, simplemente enciende el interruptor de <strong>No aplica (N/A)</strong>.</li>
                                    <li><strong class="text-success">¡Importante!</strong> El sistema cuenta con <strong>autoguardado</strong>. No necesitas presionar ningún botón para guardar la calificación de un archivo; simplemente califica y haz clic en la siguiente sección en el menú izquierdo. Tus avances se guardarán solos.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 4: Finalizar -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-4-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Finalizar Evaluación</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Una vez que hayas terminado de revisar y calificar todos los apartados, dirígete a la parte inferior derecha y haz clic en el botón azul <strong>Finalizar y Aprobar/Rechazar Evidencia</strong>.</li>
                                    <li>Esto cerrará el proceso de revisión y le notificará al docente sobre su resultado. <em class="text-danger-emphasis">(Nota: También dispones de un botón rojo superior por si necesitas eliminar la evidencia completa por alguna anomalía grave).</em></li>
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