@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h1 class="fw-bold text-primary mb-1">
                    Gestión de Docentes
                </h1>

                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                                Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-primary fw-semibold">
                            Docentes
                        </li>
                    </ol>
                </nav>
            </div>

            <a href="{{ route('nuevo-docente') }}"
                class="btn btn-primary rounded-pill px-4 shadow-sm">

                <i class="fa-solid fa-user-plus me-2"></i>
                Nuevo Docente
            </a>

        </div>
    </div>

    <section class="section">

        <div class="row">
            <div class="col-lg-12">

                <div class="card border-0 shadow-lg docentes-card">

                    {{-- HEADER --}}
                    <div class="card-header docentes-header">

                        <div class="d-flex align-items-center">

                            <div class="header-icon me-3">
                                <i class="bi bi-people-fill"></i>
                            </div>

                            <div>
                                <h4 class="fw-bold mb-1 text-dark">
                                    Lista de Docentes
                                </h4>

                                <p class="text-muted mb-0">
                                    Administra usuarios docentes, accesos y estado del sistema
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4">

                        <div class="table-responsive">

                            <table
                                id="tablaDocentes"
                                class="table table-hover align-middle text-center custom-table">

                                <thead>
                                    <tr>
                                        <th class="text-center">ID</th>
                                        <th class="text-center">NOMBRE</th>
                                        <th class="text-center">CORREO</th>
                                        <th class="text-center">CELULAR</th>
                                        <th class="text-center">DEPARTAMENTO</th>
                                        <th class="text-center">ROL</th>
                                        <th class="text-center">CAMBIAR PASSWORD</th>
                                        <th class="text-center">ACTIVO</th>
                                        <th class="text-center">EDITAR</th>
                                    </tr>
                                </thead>

                                <tbody></tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </section>

</main>

<style>
    .docentes-card {
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
    }

    .docentes-header {
        background: linear-gradient(135deg, #f8fbff, #eef5ff);
        border-bottom: 1px solid #e8eef7;
        padding: 28px;
    }

    .header-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, #0d6efd, #4da3ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 26px;
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.18);
        flex-shrink: 0;
    }

    .custom-table {
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    .custom-table thead th {
        background: #f8fafc;
        border: none;
        font-size: 13px;
        font-weight: 700;
        color: #495057;
        padding: 16px 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .custom-table tbody tr {
        background: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        border-radius: 14px;
        transition: 0.25s;
    }

    .custom-table tbody tr:hover {
        transform: translateY(-2px);
    }

    .custom-table tbody td {
        vertical-align: middle;
        padding: 18px 12px;
        border-top: 1px solid #f1f3f7;
        border-bottom: 1px solid #f1f3f7;
        background: #fff;
    }

    .custom-table tbody tr td:first-child {
        border-left: 1px solid #f1f3f7;
        border-top-left-radius: 14px;
        border-bottom-left-radius: 14px;
    }

    .custom-table tbody tr td:last-child {
        border-right: 1px solid #f1f3f7;
        border-top-right-radius: 14px;
        border-bottom-right-radius: 14px;
    }

    .btn {
        transition: 0.25s;
        font-weight: 600;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 12px;
        border: 1px solid #dbe3ec;
        padding: 8px 14px;
        margin-left: 8px;
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: 10px;
        border: 1px solid #dbe3ec;
        padding: 6px 10px;
    }
</style>

@endsection


@push('scripts')

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
                    data: 'celular',
                    name: 'celular'
                },
                {
                    data: 'departamento',
                    name: 'departamento'
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

@endpush