<!-- Modal del Manual de Docentes -->
<div class="modal fade" id="modalManualDocentes" tabindex="-1" aria-labelledby="modalManualLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <!-- Encabezado Moderno -->
            <div class="modal-header border-bottom-0 pt-4 px-4 pb-2 align-items-start">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 55px; height: 55px; flex-shrink: 0;">
                        <i class="bi bi-people-fill fs-2"></i>
                    </div>
                    <div>
                        <h4 class="modal-title fw-bold text-dark mb-0" id="modalManualLabel">Manual de Usuario</h4>
                        <span class="text-muted fw-semibold fs-5">Gestión de Docentes</span>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Cuerpo del Modal -->
            <div class="modal-body px-4 pb-4 pt-2">
                
                <div class="alert alert-info bg-info bg-opacity-10 border-0 rounded-4 text-dark mb-4 fs-6 lh-base">
                    <i class="bi bi-info-circle-fill text-info me-2 fs-5"></i>
                    Este módulo centraliza la administración del personal docente. Por políticas de integridad y para mantener el historial de evidencias intacto, <strong>los registros de docentes no se pueden eliminar</strong>, únicamente se pueden desactivar.
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
                                <h5 class="fw-bold mb-3">Registrar un Nuevo Docente</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Haz clic en el botón azul <strong>+ Nuevo Docente</strong> en la parte superior derecha.</li>
                                    <li class="mb-2">Completa la información personal (Nombre y apellidos) y los datos institucionales (Rol, Correo, Departamento).</li>
                                    <li>Asegúrate de ingresar un número de celular válido de exactamente 10 dígitos y presiona <strong>Registrar Usuario</strong>.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 2: Editar Información -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-2-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Editar Información</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Busca al docente en la tabla principal utilizando la barra de búsqueda (Search).</li>
                                    <li>Haz clic en el botón amarillo con el ícono de lápiz en la columna <strong>EDITAR</strong> para corregir cualquier dato de su perfil.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 3: Activar o Desactivar -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-3-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-2">Activar o Desactivar (Dar de baja)</h5>
                                <p class="text-muted mb-3 fs-6 lh-base">Si un docente deja de laborar temporal o definitivamente, debes restringir su acceso:</p>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Localiza el interruptor en la columna <strong>ACTIVO</strong>.</li>
                                    <li>Al cambiarlo, el sistema bloqueará inmediatamente su capacidad de iniciar sesión, pero todas sus evidencias subidas previamente se conservarán intactas.</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Tarjeta 4: Restablecer Contraseña -->
                    <div class="card border-0 bg-light rounded-4 shadow-sm">
                        <div class="card-body p-4 d-flex align-items-start">
                            <div class="text-primary me-3 mt-1">
                                <i class="bi bi-4-circle-fill fs-2"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-3">Restablecer Contraseña</h5>
                                <ul class="text-muted mb-0 ps-3 fs-6 lh-base">
                                    <li class="mb-2">Si un maestro olvida su acceso, haz clic en el botón gris (ícono de candado) en la columna <strong>CAMBIAR PASSWORD</strong>.</li>
                                    <li>Por seguridad, el sistema te pedirá ingresar tu contraseña de administrador para autorizar el restablecimiento.</li>
                                    <li>Una vez confirmado, el sistema generará un PDF automático con las nuevas credenciales temporales.</li>
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