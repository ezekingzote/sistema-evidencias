<div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0" style="border-radius:15px;">

            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-shield-lock-fill text-primary me-2"></i>
                    Cambiar Contraseña
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">

                    <!-- CONTRASEÑA ACTUAL -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small">
                            Contraseña actual
                        </label>

                        <input
                            type="password"
                            name="current_password"
                            class="form-control pass-input"
                            required>
                    </div>

                    <hr>

                    <!-- NUEVA -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small">
                            Nueva contraseña
                        </label>

                        <input
                            type="password"
                            name="password"
                            id="new_pass"
                            class="form-control pass-input"
                            minlength="8"
                            required>
                    </div>

                    <!-- CONFIRMAR -->
                    <div class="mb-3">
                        <label class="form-label fw-bold small">
                            Confirmar contraseña
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            id="confirm_pass"
                            class="form-control pass-input"
                            minlength="8"
                            required>

                        <div id="pass_match_msg" class="form-text small"></div>
                    </div>

                    <!-- MOSTRAR -->
                    <div class="form-check form-switch">
                        <input
                            class="form-check-input"
                            type="checkbox"
                            id="showPass">

                        <label class="form-check-label small">
                            Mostrar contraseñas
                        </label>
                    </div>

                </div>

                <div class="modal-footer border-0 pb-4 px-4">

                    <button
                        type="button"
                        class="btn btn-outline-info"
                        data-bs-dismiss="modal">
                        <i class="fa-regular fa-circle-xmark"></i>
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        id="btnSubmitPass"
                        class="btn btn-outline-primary fw-bold">
                        <i class="fa-solid fa-key"></i>
                        Actualizar contraseña
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function(){

    const showPass = document.getElementById('showPass');
    const inputs = document.querySelectorAll('.pass-input');

    const newPass = document.getElementById('new_pass');
    const confirmPass = document.getElementById('confirm_pass');
    const msg = document.getElementById('pass_match_msg');
    const btn = document.getElementById('btnSubmitPass');

    // Mostrar contraseña
    showPass.addEventListener('change', function(){
        inputs.forEach(input=>{
            input.type = this.checked ? 'text' : 'password';
        });
    });

    // Validar coincidencia
    function validate(){

        if(confirmPass.value.length === 0){
            msg.innerHTML = "";
            btn.disabled = false;
            return;
        }

        if(newPass.value === confirmPass.value){

            msg.innerHTML = "✓ Las contraseñas coinciden";
            msg.className = "form-text text-success small";
            btn.disabled = false;

        }else{

            msg.innerHTML = "✗ Las contraseñas no coinciden";
            msg.className = "form-text text-danger small";
            btn.disabled = true;

        }
    }

    newPass.addEventListener('input', validate);
    confirmPass.addEventListener('input', validate);

});
</script>
