@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Docentes</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Docentes</li>
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('nuevo-docente') }}" class="btn btn-outline-primary shadow-sm">
                <i class="fa-solid fa-user-plus me-1"></i> Nuevo Docente
            </a>
        </div>

        <section class="section mt-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mt-4">
                        <div class="card-body p-4">
                            <div class="card shadow-sm border-0" style="border-radius:15px;">
                                <div class="card-header bg-white py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-primary-light rounded-3 me-3">
                                            <i class="bi bi-people-fill text-primary fs-4"></i>
                                        </div>
                                        <h5 class="card-title mb-0 p-0">Lista de Docentes</h5>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="tablaDocentes" class="table table-hover align-middle text-center">
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
                                        <tbody></tbody>
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
    @if (session('pdf'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    window.open("{!! session('pdf') !!}", "_blank"); // Abre el PDF automáticamente
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
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'nombre',
                        name: 'nombre'
                    },
                    {
                        data: 'email',
                        name: 'email'
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
        /*
        $('#tbody_docentes').on("click", ".reset-btn", function() {
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
                    recargar_tbody();
                    if (result.value.pdf) {
                        window.open(result.value.pdf, "_blank");
                    }
                }
            });
        });
        */
    </script>
@endpush
