<!-- Modal del Manual de Materias -->
<div class="modal fade" id="modalManualMaterias" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Encabezado -->
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2 align-items-start">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; flex-shrink: 0;">
                        <i class="bi bi-journal-text fs-2"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="modalManualLabel">Manual de Usuario</h4>
                        <span class="text-muted fw-semibold fs-5">Gestión de Materias</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body px-4 pb-4 pt-2">
                
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-4 text-dark mb-4 fs-6 lh-base">
                    <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
                    El sistema ya cuenta precargado con el catálogo oficial de materias del plantel. Sin embargo, este módulo te permite administrar en su totalidad las asignaturas: puedes darlas de alta, modificarlas, desactivarlas o exportar el catálogo completo.
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
                                <h5 class="fw-bold mb-3">Registrar una Nueva Materia</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Haz clic en el botón azul <strong>+ Nueva Materia</strong>.</li>
                                    <li class="mb-2">Llena el formulario con los detalles: Nombre, Clave (Ej. AED-128), Número de Unidades, Carrera, Semestre y si es de especialidad.</li>
                                    <li>Presiona <strong>Guardar Materia</strong> para añadirla al catálogo oficial.</li>
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
                                <h5 class="fw-bold mb-3">Activar o Desactivar Asignaturas</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">En la columna <strong>ACTIVO</strong> encontrarás un interruptor.</li>
                                    <li>Si una materia deja de impartirse temporalmente, puedes apagarla. Esto evitará que aparezca en los menús de asignación, pero mantendrá su historial guardado en el sistema.</li>
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
                                <h5 class="fw-bold mb-2">Editar o Eliminar</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2"><strong>Editar:</strong> Usa el botón amarillo para corregir errores en el nombre, clave o unidades de la materia.</li>
                                    <li><strong>Eliminar:</strong> Usa el botón rojo con el ícono de bote de basura si la asignatura se registró por duplicado o ya no debe existir en la base de datos.</li>
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
                                <h5 class="fw-bold mb-3">Exportar y Buscar</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Puedes utilizar el buscador superior derecho para encontrar materias específicas por nombre o clave rápidamente.</li>
                                    <li>Utiliza los botones grises (Copiar, CSV, Excel, PDF, Imprimir) para descargar o imprimir un reporte completo del catálogo de asignaturas visible en la tabla.</li>
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