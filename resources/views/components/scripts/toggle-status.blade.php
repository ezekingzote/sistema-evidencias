<script>
    $('.toggle-status').on("change", function() {
        let $checkbox = $(this);
        let id = $checkbox.data("id");               
        let baseUrl = $checkbox.attr("data-base-url");
        let estadoOriginal = !$checkbox.is(":checked");

        $.ajax({
            type: "POST",
            url: `${baseUrl}/cambiar-estado/${id}`,
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                if (res.confirmar) {
                    Swal.fire({
                        title: '¿Confirmar cambio?',
                        text: res.message,
                        icon: 'warning',
                        input: 'password',
                        inputAttributes: {
                            placeholder: 'Ingresa tu contraseña'
                        },
                        showCancelButton: true,
                        confirmButtonText: 'Validar y Cambiar',
                        cancelButtonText: 'Cancelar',
                        showLoaderOnConfirm: true,
                        preConfirm: (password) => {
                            return fetch(`${baseUrl}/cambiar-estado-confirmar/${id}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ password: password })
                            })
                            .then(response => {
                                if (!response.ok) {
                                    return response.json().then(data => {
                                        throw new Error(data.error || 'Contraseña incorrecta');
                                    });
                                }
                                return response.json();
                            })
                            .catch(error => {
                                Swal.showValidationMessage(error.message);
                            });
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire('¡Éxito!', result.value.message || 'Estado actualizado.', 'success')
                                .then(() => location.reload());
                        } else {
                            $checkbox.prop('checked', estadoOriginal);
                        }
                    });
                }
            },
            error: function(err) {
                if (err.status === 400 && err.responseJSON?.error) {
                    Swal.fire('Error', err.responseJSON.error, 'error');
                } else {
                    Swal.fire('Error', 'No se pudo procesar la solicitud', 'error');
                }
                $checkbox.prop('checked', estadoOriginal);
            }
        });
    });
</script>