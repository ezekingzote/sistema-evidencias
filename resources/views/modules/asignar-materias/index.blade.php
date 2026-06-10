@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">

        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

            <div>

                <h1 class="fw-bold text-primary mb-1">
                    Gestión de Asignaciones
                </h1>

                <nav>
                    <ol class="breadcrumb mb-0">

                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}"
                               class="text-decoration-none text-secondary">
                                Home
                            </a>
                        </li>

                        <li class="breadcrumb-item">
                            Asignaciones
                        </li>

                        <li class="breadcrumb-item active text-primary fw-semibold">
                            Asignar Materias
                        </li>

                    </ol>
                </nav>

            </div>

            <a href="{{ route('asignar-materias.create') }}"
               class="btn btn-primary rounded-pill px-4 shadow-sm">

                <i class="fa-solid fa-plus me-2"></i>
                Nueva Asignación

            </a>

        </div>

    </div>

    <section class="section mt-2">

        <div class="card border-0 shadow-lg asignaciones-card">

            {{-- HEADER --}}
            <div class="card-header asignaciones-header">

                <div class="d-flex align-items-center">

                    <div class="header-icon me-3">
                        <i class="bi bi-journal-check"></i>
                    </div>

                    <div>

                        <h4 class="fw-bold mb-1 text-dark">
                            Lista de Asignaciones
                        </h4>

                        <p class="text-muted mb-0">
                            Administración de materias asignadas a docentes
                        </p>

                    </div>

                </div>

            </div>

            {{-- BODY --}}
            <div class="card-body p-4">

                <div class="table-responsive">

                    <table
                        class="table table-hover align-middle text-center custom-table datatable"
                    >

                        <thead>
                            <tr>
                                <th class="text-center">SEMESTRE</th>
                                <th class="text-center">MATERIA</th>
                                <th class="text-center">DOCENTE</th>
                                <th class="text-center">GRUPO</th>
                                <th class="text-center">N. ALUMNOS</th>
                                <th class="text-center">ACTIVO</th>
                                <th class="text-center">ACCIONES</th>
                            </tr>
                        </thead>

                        <tbody id="tbody_asignaciones">
                            @include('modules.asignar-materias.tbody')
                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </section>

</main>

<style>

    .asignaciones-card {
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
    }

    .asignaciones-header {
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
        font-size: 0.95rem;
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

    .form-check-input {
        cursor: pointer;
        width: 2.5rem;
        height: 1.2rem;
    }

    .btn {
        transition: 0.25s;
        font-weight: 600;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

</style>

@endsection


@push('scripts')

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

@endpush