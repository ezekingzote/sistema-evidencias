@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1>Gestión de Revisiones</h1>
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

        <div class="card shadow-sm border-0" style="border-radius: 16px;">
            <div class="card-header bg-white py-4 border-bottom">
                <div class="d-flex align-items-center">
                    <div class="p-3 bg-primary-light rounded-3 me-3">
                        <i class="bi bi-journal-check text-primary fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">Control de Revisiones</h4>
                        <p class="text-muted mb-0">
                            Administra el estado de cada revisión académica del semestre activo.
                        </p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                @if(!$semestreActivo)
                <div class="alert alert-warning text-center shadow-sm border-0">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    No hay semestre activo configurado.
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

<style>
    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.10);
    }

    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.10);
    }

    .card {
        border-radius: 16px;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .btn {
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn-outline-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(25, 135, 84, 0.15);
    }

    .btn-outline-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(13, 110, 253, 0.15);
    }
</style>
@endsection


@push('scripts')
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
@endpush