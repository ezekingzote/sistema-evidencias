<script>
    $('.cambiarEstado').on("change", function() {

        let id = $(this).data("id");
        let $checkbox = $(this);
        let estadoOriginal = !$(this).is(":checked");
        let activando = $checkbox.is(":checked");

        $.ajax({
            type: "POST",
            url: `/revisiones/cambiar-estado/${id}`,
            data: {
                _token: '{{ csrf_token() }}'
            },

            success: function(res) {

                if (res.confirmar) {

                    let html = `
                        <div class="text-start mb-3">
                            <label class="form-label fw-bold">
                                Contraseña
                            </label>
                            <input
                                type="password"
                                id="password"
                                class="form-control"
                                placeholder="Ingresa tu contraseña">
                        </div>
                    `;

                    if (activando) {

                        html += `
                            <div class="text-start">
                                <label class="form-label fw-bold">
                                    Fecha límite de entrega
                                </label>
                                <input
                                    type="date"
                                    id="fecha_limite"
                                    class="form-control"
                                    min="${new Date().toISOString().split('T')[0]}">
                            </div>
                        `;
                    }

                    Swal.fire({
                        title: activando ?
                            'Activar revisión' :
                            'Desactivar revisión',

                        icon: 'warning',

                        html: html,

                        showCancelButton: true,
                        confirmButtonText: 'Confirmar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,

                        preConfirm: () => {

                            const password =
                                document.getElementById('password').value;

                            const fechaLimite =
                                document.getElementById('fecha_limite') ?
                                document.getElementById('fecha_limite').value :
                                null;

                            if (!password) {

                                Swal.showValidationMessage(
                                    'Debes ingresar tu contraseña'
                                );

                                return false;
                            }

                            if (activando && !fechaLimite) {

                                Swal.showValidationMessage(
                                    'Debes seleccionar una fecha límite'
                                );

                                return false;
                            }

                            return fetch(
                                    `/revisiones/cambiar-estado-confirmar/${res.revision_id}`, {
                                        method: 'POST',

                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },

                                        body: JSON.stringify({
                                            password: password,
                                            fecha_limite: fechaLimite
                                        })
                                    }
                                )
                                .then(response => {

                                    return response.json().then(data => {

                                        if (!response.ok) {
                                            throw new Error(
                                                data.error ||
                                                'Error al procesar'
                                            );
                                        }

                                        return data;
                                    });

                                })
                                .catch(error => {

                                    Swal.showValidationMessage(
                                        error.message
                                    );

                                });
                        }

                    }).then((result) => {

                        if (result.isConfirmed) {

                            Swal.fire(
                                '¡Éxito!',
                                result.value.message ||
                                'Estado actualizado correctamente',
                                'success'
                            ).then(() => location.reload());

                        } else {

                            $checkbox.prop(
                                'checked',
                                estadoOriginal
                            );

                        }

                    });

                }

            },

            error: function(err) {

                if (err.status === 400 && err.responseJSON?.error) {

                    Swal.fire(
                        'Error',
                        err.responseJSON.error,
                        'error'
                    );

                } else {

                    Swal.fire(
                        'Error',
                        'No se pudo procesar la solicitud',
                        'error'
                    );

                }

                $checkbox.prop(
                    'checked',
                    estadoOriginal
                );

            }

        });

    });
</script>