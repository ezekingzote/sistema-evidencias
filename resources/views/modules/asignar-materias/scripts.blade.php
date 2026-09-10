
<script>

    function recargar_tbody() {

        $.ajax({

            type: 'GET',

            url: "{{ route('asignar-materias.tbody') }}",

            success: function(respuesta) {

                $('#tbody_asignaciones').html(respuesta);

            }

        });

    }

    function cambiar_estado(id, estado) {

        fetch("{{ route('asignar-materias.estado') }}", {

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
                    icon: 'success',
                    title: '¡Logrado!',
                    text: data.mensaje,
                    confirmButtonText: 'Entendido'
                });

            }

            recargar_tbody();

        })

        .catch(error => {

            console.error('Error:', error);

            recargar_tbody();

        });

    }

    $('#tbody_asignaciones').on("change", ".chkToggle", function() {

        let id = $(this).data("id");

        let estado = $(this).is(":checked") ? 1 : 0;

        cambiar_estado(id, estado);

    });

</script>