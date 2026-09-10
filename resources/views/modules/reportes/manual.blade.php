<!-- Modal del Manual de Reportes -->
<div class="modal fade" id="modalManualReportes" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Encabezado -->
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2 align-items-start">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; flex-shrink: 0;">
                        <i class="bi bi-file-earmark-pdf-fill fs-2"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="modalManualLabel">Manual de Usuario</h4>
                        <span class="text-muted fw-semibold fs-5">Reportes de Seguimiento</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body px-4 pb-4 pt-2">
                
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-4 text-dark mb-4 fs-6 lh-base">
                    <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
                    Este módulo genera automáticamente los oficios oficiales en formato PDF con las calificaciones, porcentajes de cumplimiento y observaciones de cada docente, listos para firma.
                </div>

                <!-- Contenedor de Pasos -->
                <div class="d-flex flex-column gap-3">

                    <!-- Tarjeta 1: Semáforo de Reportes -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-1-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">El Semáforo de Estados</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2"><strong>Botón Naranja (Reloj de arena):</strong> Indica que el docente ya subió su evidencia, pero <em>tú aún no la has evaluado</em> en el módulo anterior. Por lo tanto, el reporte PDF todavía no se puede generar.</li>
                                    <li><strong>Botón Verde (PDF):</strong> ¡Listo! La evidencia ya fue evaluada (aprobada o rechazada) y el reporte oficial ya fue generado por el sistema.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Visualizar y Descargar -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-2-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Visualizar, Imprimir o Descargar</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Haz clic en cualquier <strong>botón verde</strong> de la tabla.</li>
                                    <li>Se abrirá una nueva pestaña en tu navegador mostrándote el documento oficial membretado del ITMA II.</li>
                                    <li>Desde ese visor podrás leerlo, mandarlo directamente a la <strong>impresora</strong>, descargarlo a tu computadora o guardarlo en tu Google Drive usando los botones de la barra superior.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3: Enviar por WhatsApp -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-3-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Enviar Reporte por WhatsApp</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">En la columna de <strong>Acciones</strong>, verás un menú desplegable que dice "Enviar PDF...".</li>
                                    <li>Al seleccionar la revisión deseada, el sistema abrirá automáticamente WhatsApp Web con un <strong>mensaje redactado de forma automática</strong> que incluye el enlace para que el docente pueda ver su reporte desde su celular.</li>
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