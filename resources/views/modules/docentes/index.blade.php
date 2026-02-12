@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Docentes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Docentes
                    </li>
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('nuevo-docente') }}" class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-user-plus me-1"></i>
                Nuevo Docente
            </a>
        </div>

        <section class="section mt-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-4">

                        <div class="card-body p-4">

                            <div class="card shadow-sm border-0" style="border-radius: 15px;">

                                <div class="card-header bg-white py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-primary-light rounded-3 me-3">
                                            <i class="bi bi-people-fill text-primary fs-4"></i>
                                        </div>

                                        <h5 class="card-title mb-0 p-0">
                                            Lista de Docentes
                                        </h5>
                                    </div>
                                </div>


                                <div class="table-responsive">

                                    <table class="table table-hover align-middle text-center datatable">

                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>NOMBRE</th>
                                                <th>CORREO</th>
                                                <th>ROL</th>
                                                <th>CAMBIAR PASSWORD</th>
                                                <th>ACTIVO</th>
                                                <th>EDITAR</th>
                                            </tr>
                                        </thead>

                                        <tbody id="tbody_docentes">
                                            @include('modules.docentes.tbody')
                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>
@endsection


@push('scripts')
    <script>
        function recargar_tbody() {

            $('#tbody_docentes').html('<tr><td colspan="7">Cargando...</td></tr>');

            $.ajax({
                type: 'GET',
                url: "{{ route('docentes.tbody') }}",
                success: function(respuesta) {
                    $('#tbody_docentes').html(respuesta);
                }
            });
        }


        function cambiar_estado(id, estado) {

            $.ajax({
                type: 'GET',
                url: "{{ url('docentes/cambiar-estado') }}/" + id + "/" + estado,
                success: function(respuesta) {

                    if (respuesta == 1) {

                        Swal.fire({
                            title: 'Éxito',
                            text: 'Estado actualizado correctamente',
                            icon: 'success'
                        });

                        recargar_tbody();

                    } else {

                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo actualizar el estado',
                            icon: 'error'
                        });

                    }

                }
            });

        }


        $('#tbody_docentes').on("change", ".form-check-input", function() {

            let id = $(this).attr("id");

            let estado = $(this).is(":checked") ? 1 : 0;

            cambiar_estado(id, estado);

        });


        $('#tbody_docentes').on("click", ".reset-btn", function() {

            let userId = $(this).data("id");

            Swal.fire({

                title: 'Confirmar acción',
                text: 'Escribe tu contraseña de administrador',
                input: 'password',
                inputPlaceholder: 'Tu contraseña',
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',

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

                            if (!data.success) {

                                throw new Error(data.message);

                            }

                            return data;

                        })

                        .catch(error => {

                            Swal.showValidationMessage(error.message);

                        });

                }

            }).then((result) => {

                if (result.isConfirmed) {

                    Swal.fire({

                        title: 'Éxito',
                        text: result.value.message,
                        icon: 'success'

                    });

                    recargar_tbody();

                }

            });

        });
    </script>
@endpush
