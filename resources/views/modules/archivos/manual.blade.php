<!-- Modal del Manual de Mi Unidad (Explorador) -->
<div class="modal fade" id="modalManualMiUnidad" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Encabezado -->
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2 align-items-start">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; flex-shrink: 0;">
                        <i class="bi bi-cloud-fill fs-2"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="modalManualLabel">Manual de Usuario</h4>
                        <span class="text-muted fw-semibold fs-5">Mi Unidad (Explorador de Archivos)</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body px-4 pb-4 pt-2">
                
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-4 text-dark mb-4 fs-6 lh-base">
                    <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
                    Este módulo es el repositorio central del sistema. Funciona como un disco duro virtual donde se respaldan automáticamente todas las evidencias subidas por los docentes, organizadas de forma impecable.
                </div>

                <!-- Contenedor de Pasos -->
                <div class="d-flex flex-column gap-3">

                    <!-- Tarjeta 1: Estructura -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-1-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Navegación y Estructura</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">El sistema organiza los archivos automáticamente en este orden: <strong>Semestre > Materia > Revisión > Tipo de documento</strong> (Documentos, Evidencias o Instrumentos).</li>
                                    <li class="mb-2">Haz clic sobre cualquier carpeta para entrar en ella.</li>
                                    <li>Usa la barra de navegación superior (migas de pan o "Raíz") para regresar fácilmente a carpetas anteriores sin perderte.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Descarga ZIP -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-2-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Descarga Masiva (Archivos ZIP)</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Dentro de cada tarjeta de carpeta, del lado derecho, verás un botón azul que dice <strong>ZIP</strong>.</li>
                                    <li>Al hacer clic en él, el sistema comprimirá toda la carpeta completa (con todos sus archivos y subcarpetas adentro) en un solo archivo descargable. ¡Ideal para respaldos rápidos!</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3: Visor PDF -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-3-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Vista Previa de Documentos</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Cuando llegues al nivel de los archivos PDF, verás una pequeña previsualización real de la primera página del documento.</li>
                                    <li>Haz clic en el botón <strong>Vista Previa</strong> (ícono de ojo) para abrir el documento en tamaño completo dentro del mismo sistema, sin necesidad de descargarlo.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 4: Descarga individual -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-4-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Descarga Individual</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Si solo necesitas un archivo en específico, ubícalo en la sección de "Archivos".</li>
                                    <li>Haz clic en el <strong>botón blanco con la flecha hacia abajo</strong> ubicado en la esquina inferior derecha de la tarjeta del documento para guardarlo en tu computadora.</li>
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