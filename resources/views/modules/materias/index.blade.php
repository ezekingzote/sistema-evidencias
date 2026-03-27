@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Materias</h1>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="breadcrumb-item active">
                        Materias
                    </li>
                </ol>
            </nav>

        </div>


        <div class="d-flex justify-content-between align-items-center mb-3">

            <a href="{{ route('nueva-materia') }}" class="btn btn-outline-primary shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Nueva Materia
            </a>

        </div>


        <section class="section mt-2">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm border-0" style="border-radius: 15px;">
                        <div class="card mt-2">
                            <div class="card-body p-4">
                                <div class="card-header bg-white py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 bg-primary-light rounded-3 me-3">
                                            <i class="bi bi-collection-fill text-primary fs-4"></i>
                                        </div>

                                        <h5 class="card-title mb-0 p-0">
                                            Lista de Materias
                                        </h5>
                                    </div>
                                </div>



                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle text-center datatable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="text-center">NOMBRE</th>
                                                    <th class="text-center">CLAVE</th>
                                                    <th class="text-center">UNIDADES</th>
                                                    <th class="text-center">CARRERA</th>
                                                    <th class="text-center">SEMESTRE</th>
                                                    <th class="text-center">ACTIVO</th>
                                                    <th class="text-center">EDITAR</th>
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
                </div>
            </div>
        </section>
    </main>
@endsection



@push('scripts')
<script>

    function recargar_tbody() {
        $('#tbody_materias').html('<tr><td colspan="7">Cargando...</td></tr>');

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
            body: JSON.stringify({ id: id, estado: estado })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
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
