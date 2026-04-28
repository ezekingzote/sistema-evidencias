@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1>Asignar Materias</h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item active">
                    Asignar Materias
                </li>
            </ol>
        </nav>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('asignar-materias.create') }}"
            class="btn btn-outline-primary shadow-sm px-4"
            style="border-radius: 10px;">
            <i class="fa-solid fa-plus me-2"></i> Nueva Asignación
        </a>
    </div>

    <section class="section mt-2">
        <div class="card shadow-sm border-0" style="border-radius: 18px; overflow: hidden;">

            <div class="card-header bg-white py-4 border-bottom">
                <div class="d-flex align-items-center">
                    <div class="p-3 rounded-3 me-3 bg-primary-light">
                        <i class="bi bi-journal-check text-primary fs-4"></i>
                    </div>

                    <div>
                        <h5 class="card-title mb-0 p-0 fw-bold">
                            Lista de Asignaciones
                        </h5>
                        <small class="text-muted">
                            Administración de materias asignadas a docentes
                        </small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">

                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">

                        <thead class="table-light">
                            <tr>
                                <th>SEMESTRE</th>
                                <th>MATERIA</th>
                                <th>DOCENTE</th>
                                <th>GRUPO</th>
                                <th>N. ALUMNOS</th>
                                <th>ACTIVO</th>
                                <th>ACCIONES</th>
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
    .bg-primary-light {
        background-color: #e7f1ff;
    }

    .card {
        border-radius: 18px;
        transition: all 0.3s ease;
    }

    .table thead th {
        font-size: 0.82rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 700;
        color: #495057;
        vertical-align: middle;
    }

    .table tbody td {
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .form-check-input {
        cursor: pointer;
        width: 2.5rem;
        height: 1.2rem;
    }

    .btn {
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-outline-primary:hover {
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.15);
    }

    .btn-outline-warning:hover {
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.15);
    }

    .btn-outline-danger:hover {
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.15);
    }
</style>

@endsection


@push('scripts')
<script>
    function recargar_tbody() {

        $('#tbody_asignaciones').html(
            '<tr><td colspan="7" class="text-center py-4 fw-bold text-muted">Cargando información...</td></tr>'
        );

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