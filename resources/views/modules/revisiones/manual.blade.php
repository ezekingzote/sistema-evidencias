<!-- Modal del Manual de Revisiones -->
<div class="modal fade" id="modalManualRevisiones" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Encabezado -->
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2 align-items-start">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; flex-shrink: 0;">
                        <i class="bi bi-journal-check fs-2"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="modalManualLabel">Manual de Usuario</h4>
                        <span class="text-muted fw-semibold fs-5">Control de Revisiones</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body px-4 pb-4 pt-2">
                
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-4 text-dark mb-4 fs-6 lh-base">
                    <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
                    Este módulo actúa como el "interruptor principal" para las entregas. El sistema contempla exactamente <strong>4 revisiones</strong> por semestre. Desde aquí decides en qué momento los docentes pueden subir sus evidencias y accedes a los reportes de progreso.
                </div>

                <!-- Contenedor de Pasos -->
                <div class="d-flex flex-column gap-3">

                    <!-- Tarjeta 1: Habilitar Entregas -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-1-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Habilitar / Deshabilitar Entregas</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Cada tarjeta representa una etapa del semestre (Primera, Segunda, Tercera y Cuarta Revisión).</li>
                                    <li class="mb-2">Para "abrir" el sistema y permitir que los maestros suban sus archivos, haz clic en el <strong>interruptor superior derecho</strong> de la tarjeta correspondiente.</li>
                                    <li>Cuando termine el plazo de entrega, simplemente vuelve a apagar el interruptor. Esto bloqueará la subida de nuevos archivos para esa etapa, protegiendo las evidencias ya entregadas.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Lectura de Datos -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-2-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Lectura de Estatus</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Cada tarjeta te muestra un resumen rápido del periodo: el <strong>semestre activo</strong> al que pertenece, cuántas <strong>materias activas</strong> existen en el catálogo y cuántas de ellas ya están <strong>asignadas</strong>.</li>
                                    <li>La etiqueta de <strong>Estado actual</strong> cambiará de "Inactiva" (Gris) a "Activa" (Verde) dependiendo de si el interruptor está encendido o apagado.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3: Ir a Seguimiento -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-3-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Ir a Seguimiento Académico</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">En la parte inferior de cada tarjeta hay un botón con el texto <strong>Ir a Seguimiento Académico</strong>.</li>
                                    <li>Al presionarlo, el sistema te redirigirá a un panel detallado exclusivo de esa revisión. En ese módulo podrás ver exactamente qué docentes ya entregaron sus evidencias, quiénes faltan, y podrás validar o rechazar los documentos enviados.</li>
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