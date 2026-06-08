@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    {{-- PAGE TITLE --}}
    <div class="pagetitle mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>
                <h1 class="fw-bold text-primary mb-1">
                    Gestión de Materias
                </h1>

                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                                Home
                            </a>
                        </li>

                        <li class="breadcrumb-item active text-primary fw-semibold">
                            Materias
                        </li>
                    </ol>
                </nav>
            </div>

            <a
                href="{{ route('nueva-materia') }}"
                class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="fa-solid fa-plus me-2"></i>
                Nueva Materia
            </a>

        </div>

    </div>


    <section class="section mt-2">

        <div class="row">
            <div class="col-lg-12">

                <div class="card border-0 shadow-lg materias-card">

                    {{-- HEADER --}}
                    <div class="card-header materias-header">

                        <div class="d-flex align-items-center">

                            <div class="header-icon me-3">
                                <i class="bi bi-collection-fill"></i>
                            </div>

                            <div>
                                <h4 class="fw-bold mb-1 text-dark">
                                    Lista de Materias
                                </h4>

                                <p class="text-muted mb-0">
                                    Administra las materias registradas dentro del sistema
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4">

                        <div class="table-responsive">

                            <table
                                class="table table-hover align-middle text-center datatable custom-table">

                                <thead>
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>CLAVE</th>
                                        <th>SEMESTRE</th>
                                        <th>CARRERA</th>
                                        <th>UNIDADES</th>
                                        <th>ACTIVO</th>
                                        <th>EDITAR</th>
                                    </tr>
                                </thead>

                                <tbody id="tbody_materias">

                                    @include('modules.materias.tbody')

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </section>

</main>


<style>
    .materias-card {
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
    }

    .materias-header {
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

    .btn-primary:hover {
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.20);
    }

    .form-check-input {
        width: 2.7rem;
        height: 1.4rem;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .datatable-top {
        margin-bottom: 20px;
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

@endpush