
<script>
    function recargar_tbody() {
        $('#tbody_materias').html(
            '<tr><td colspan="7" class="text-center py-4">Cargando información...</td></tr>'
        );

        $.ajax({
            type: 'GET',
            url: "{{ route('materias.tbody') }}",

            success: function(respuesta) {
                $('#tbody_materias').html(respuesta);
            },

            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo cargar la información de materias.'
                });
            }
        });
    }


    function cambiar_estado(id, estado) {

        fetch("{{ route('materias.estado.ajax') }}", {
                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },

                body: JSON.stringify({
                    id: id,
                    estado: estado
                })
            })

            .then(res => res.json())

            .then(data => {

                if (data.success) {

                    Swal.fire({
                        title: 'Éxito',
                        text: data.mensaje,
                        icon: 'success'
                    });

                    recargar_tbody();

                } else {

                    Swal.fire({
                        title: 'Error',
                        text: data.mensaje,
                        icon: 'error'
                    });

                    recargar_tbody();
                }

            })

            .catch(err => {

                Swal.fire({
                    title: 'Error',
                    text: 'Error de conexión con el servidor.',
                    icon: 'error'
                });

            });

    }


    $('#tbody_materias').on("change", ".chkToggle", function() {

        let id = $(this).data("id");
        let estado = $(this).is(":checked") ? 1 : 0;

        cambiar_estado(id, estado);

    });
</script>