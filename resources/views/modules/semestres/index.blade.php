@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Semestres</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Semestres</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <a href="{{ route('semestre.create') }}" class="btn btn-outline-primary mb-3">
                <i class="fa-solid fa-plus"></i> Nuevo Semestre
            </a>

            <div class="card">
                <div class="card-body">
                    <div class="row g-4" id="contenedor-semestres">
                        @include('modules.semestres.cards')
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        $('.form-check-input').on("change", function() {
            let id = $(this).attr("id");
            let $checkbox = $(this);
            let estadoOriginal = !$(this).is(":checked");

            $.ajax({
                type: "POST",
                url: `/semestres/cambiar-estado/${id}`,
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
                                return fetch(
                                        `/semestres/cambiar-estado-confirmar/${res.semestre_id}`, {
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
                                                throw new Error(data.error ||
                                                    'Contraseña incorrecta')
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
                                Swal.fire('¡Éxito!', result.value.message ||
                                        'Estado actualizado.', 'success')
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
@endpush
