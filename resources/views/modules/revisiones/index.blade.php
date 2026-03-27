@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Revisiones</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    Revisiones
                </li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="card">
            <div class="card-body">

                {{-- Si no hay semestre activo --}}
                @if(!$semestreActivo)

                <div class="alert alert-warning text-center mt-3">
                    No hay semestre activo.
                    Debes activar uno para habilitar las revisiones.
                </div>

                @endif

                <div class="row g-4">

                    @include('modules.revisiones.cards')

                </div>

            </div>
        </div>

    </section>

</main>
@endsection

@push('scripts')
<script>
    $('.cambiarEstado').on("change", function() {

        let id = $(this).data("id");
        let $checkbox = $(this);
        let estadoOriginal = !$(this).is(":checked");

        $.ajax({
            type: "POST",
            url: `/revisiones/cambiar-estado/${id}`,
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

                            return fetch(`/revisiones/cambiar-estado-confirmar/${res.revision_id}`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        password: password
                                    })
                                })
                                .then(response => {

                                    if (!response.ok) {

                                        return response.json().then(data => {
                                            throw new Error(data.error || 'Contraseña incorrecta')
                                        });

                                    }

                                    return response.json();

                                })
                                .catch(error => {
                                    Swal.showValidationMessage(error.message)
                                });

                        }

                    }).then((result) => {

                        if (result.isConfirmed) {

                            Swal.fire(
                                '¡Éxito!',
                                result.value.message || 'Estado actualizado.',
                                'success'
                            ).then(() => location.reload());

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
@endpush