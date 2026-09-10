<!-- Modal del Manual de Asignación de Materias -->
<div class="modal fade" id="modalManualAsignaciones" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Encabezado -->
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2 align-items-start">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; flex-shrink: 0;">
                        <i class="bi bi-card-checklist fs-2"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="modalManualLabel">Manual de Usuario</h4>
                        <span class="text-muted fw-semibold fs-5">Gestión de Asignaciones</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body px-4 pb-4 pt-2">
                
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-4 text-dark mb-4 fs-6 lh-base">
                    <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
                    Este módulo es el núcleo operativo del sistema. Aquí vincularás las materias del catálogo con los profesores que las impartirán en el semestre activo.
                </div>

                <!-- Contenedor de Pasos -->
                <div class="d-flex flex-column gap-3">

                    <!-- Tarjeta 1: Registrar -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-1-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Crear una Nueva Asignación</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Haz clic en el botón azul <strong>+ Nueva Asignación</strong>.</li>
                                    <li class="mb-2">El <strong>Semestre Académico</strong> y el <strong>Grupo Generado</strong> (Ej. SIS-6) se llenarán automáticamente según la configuración actual del sistema.</li>
                                    <li class="mb-2">Selecciona la <strong>Materia</strong>. <em class="text-primary-emphasis">Nota: Solo aparecerán las materias que estén activas y que no hayan sido asignadas todavía en este semestre.</em></li>
                                    <li class="mb-2">Elige al <strong>Docente</strong> responsable (Ej. Juan Alberto De la Cruz Cruz). Solo se muestran docentes con estatus activo.</li>
                                    <li>Ingresa el <strong>Número de Alumnos</strong> proyectado y haz clic en <strong>Registrar Asignación</strong>.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Activar / Desactivar -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-2-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Activar o Desactivar la Asignación</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">En la tabla principal, utiliza el interruptor de la columna <strong>ACTIVO</strong>.</li>
                                    <li>Si desactivas una asignación, el docente ya no podrá subir ni gestionar evidencias para ese grupo en específico, pero su historial previo quedará resguardado.</li>
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
                                <h5 class="fw-bold mb-2">Modificar o Eliminar Registros</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2"><strong>Editar:</strong> Usa el botón amarillo en la columna "Acciones" si necesitas cambiar al profesor asignado o ajustar la cantidad de alumnos del grupo.</li>
                                    <li><strong>Eliminar:</strong> Usa el botón rojo para borrar la asignación permanentemente. <em class="text-danger-emphasis">Precaución: Solo elimina asignaciones si fueron creadas por error y no tienen evidencias asociadas.</em></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 4: Exportar -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-4-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Generar Reportes (Exportar)</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Utiliza la barra de búsqueda superior para filtrar asignaciones por docente, materia o grupo.</li>
                                    <li>Haz clic en los botones de exportación (Copiar, CSV, Excel, PDF, Imprimir) para descargar las listas de carga académica tal cual se muestran en tu pantalla.</li>
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