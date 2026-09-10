<!-- Modal del Manual de Usuario: Semestres (Versión Letra Grande) -->
<div class="modal fade" id="modalManualSemestres" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Encabezado -->
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2 align-items-start">
                <div class="d-flex align-items-center">
                    <!-- Ícono circular destacado -->
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; flex-shrink: 0;">
                        <i class="bi bi-journal-bookmark-fill fs-2"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="modalManualLabel">Manual de Usuario</h4>
                        <span class="text-muted fw-semibold fs-5">Gestión de Semestres</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body px-4 pb-4 pt-2">
                
                <!-- Alerta de Introducción -->
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-4 text-dark mb-4 fs-6 lh-base">
                    <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
                    Este módulo permite gestionar los periodos académicos del sistema. Aquí puedes crear nuevos ciclos, actualizar sus datos, cambiar su estado de disponibilidad o eliminarlos del registro.
                </div>

                <!-- Contenedor -->
                <div class="d-flex flex-column gap-3">

                    <!-- Tarjeta 1: Registrar -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-1-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Registrar un Nuevo Semestre</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Haz clic en el botón con borde azul <strong>+ Nuevo Semestre</strong>.</li>
                                    <li class="mb-2">Completa el formulario indicando el nombre, año, periodo y las fechas de inicio y fin.</li>
                                    <li>Haz clic en <strong>Registrar Semestre</strong> para guardar la información.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Seguridad / Activar -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-2-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Activar o Desactivar (Seguridad)</h5>
                                <p class="text-muted mb-3 fs-6 lh-base">Para proteger la integridad de los periodos, el sistema requiere confirmación:</p>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Haz clic en el <strong>interruptor</strong> en la esquina superior derecha de la tarjeta.</li>
                                    <li class="mb-2">Aparecerá una ventana de seguridad. Ingresa tu <strong>contraseña de acceso al sistema</strong> y haz clic en <strong>Validar y Cambiar</strong>.</li>
                                    <li>Si decides no hacerlo, simplemente presiona "Cancelar".</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3: Editar y Eliminar -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-3-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Editar o Eliminar</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-3"><strong>Editar:</strong> Haz clic en el botón amarillo dentro de la caja de Acciones. <br> <span class="text-warning-emphasis d-inline-block mt-1"><i class="bi bi-exclamation-triangle-fill me-1"></i> Nota: Solo puedes editar semestres que estén Inactivos.</span></li>
                                    <li><strong>Eliminar:</strong> Haz clic en el botón rojo para borrar el registro por completo.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 4: Ver Materias -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-4-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Ver Materias Asignadas</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">En la parte inferior de cada tarjeta encontrarás un botón azul llamado <strong>Ver Materias</strong>.</li>
                                    <li>Al presionarlo, se desplegará una lista rápida mostrándote todas las materias que ya han sido vinculadas a ese semestre específico.</li>
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