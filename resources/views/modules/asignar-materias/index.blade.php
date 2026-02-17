@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

    <main id="main" class="main">

        <div class="pagetitle">
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


        <div class="d-flex justify-content-between align-items-center mb-3">

            <a href="{{ route('asignar-materias.create') }}" class="btn btn-outline-primary shadow-sm">
                <i class="fa-solid fa-plus me-1"></i> Nueva Asignación
            </a>

        </div>


        <section class="section mt-2">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">

                <div class="card-body p-4">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle text-center">

                            <thead class="table-light">
                                <tr>
                                    <th>SEMESTRE</th>
                                    <th>MATERIA</th>
                                    <th>DOCENTE</th>
                                    <th>GRUPO</th>
                                    <th>ACTIVO</th>
                                    <th>EDITAR</th>
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

@endsection


@push('scripts')
    <script>
        function recargar_tbody() {

            $('#tbody_asignaciones').html(
                '<tr><td colspan="6">Cargando...</td></tr>'
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
                            timer: 1500,
                            showConfirmButton: true
                        });

                        Swal.fire({
                            icon: 'success',
                            title: 'Atención',
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
