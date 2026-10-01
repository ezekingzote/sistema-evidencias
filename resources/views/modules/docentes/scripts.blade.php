@if (session('pdf'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            window.open("{!! session('pdf') !!}", "_blank");
        }, 500);
    });
</script>
@endif

<script>
    $(document).ready(function() {

        let tabla = $('#tablaDocentes').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('docentes.data') }}",

            columns: [
                {
                    data: 'nombre',
                    name: 'nombre'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'celular',
                    name: 'celular'
                },
                {
                    data: 'departamento',
                    name: 'departamento'
                },
                {
                    data: 'cargo',
                    name: 'cargo'
                },
                {
                    data: 'rol',
                    name: 'rol'
                },
                {
                    data: 'password_btn',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'activo_switch',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'editar_btn',
                    orderable: false,
                    searchable: false
                }
            ],

            order: [
                [0, 'desc']
            ]
        });

    });

    $('#tablaDocentes').on('change', '.cambiar-estado', function() {

        let id = $(this).data('id');
        let estado = $(this).is(':checked') ? 1 : 0;

        $.get("{{ url('docentes/cambiar-estado') }}/" + id + "/" + estado, function(res) {

            if (res == 1) {
                $('#tablaDocentes').DataTable().ajax.reload(null, false);
                Swal.fire('Éxito', 'Estado actualizado', 'success');
            }

        });

    });

    $('#tablaDocentes').on("click", ".reset-btn", function() {

        let userId = $(this).data("id");

        Swal.fire({
            title: 'Confirmar Reset',
            text: 'Ingresa tu contraseña de administrador',
            input: 'password',
            showCancelButton: true,

            preConfirm: (password) => {

                return fetch("{{ url('docentes/reset-password') }}/" + userId, {

                        method: 'POST',

                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },

                        body: JSON.stringify({
                            password: password
                        })

                    })
                    .then(response => response.json())
                    .then(data => {

                        if (!data.success) throw new Error(data.message);

                        return data;

                    })
                    .catch(error => {

                        Swal.showValidationMessage(error.message);

                    });

            }

        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire('¡Éxito!', result.value.message, 'success');

                $('#tablaDocentes').DataTable().ajax.reload(null, false);

                if (result.value.pdf) {
                    window.open(result.value.pdf, "_blank");
                }

            }

        });

    });
</script>