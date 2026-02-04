@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Materias</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Materias</li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('nueva-materia') }}" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i> Nueva
            Materia</a>
        <hr>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">

                            <table class="table datatable text-center">
                                <thead>
                                    <tr>
                                        <th class="text-center">NOMBRE</th>
                                        <th class="text-center">CLAVE</th>
                                        <th class="text-center">N UNIDADES</th>
                                        <th class="text-center">CARRERA</th>
                                        <th class="text-center">SEMESTRE</th>
                                        <th class="text-center">ACTIVO</th>
                                        <th class="text-center">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody-usuarios" class="text-center">
                                    @include('modules.materias.tbody')
                                </tbody>

                            </table>

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
            $.ajax({
                type: 'GET',
                url: "{{ route('materias.tbody') }}",
                success: function(respuesta) {
                    $('#tbody-usuarios').html(respuesta);
                }
            });
        }

        function cambiar_estado(id, estado) {
            $.ajax({
                type: 'GET',
                url: "{{ url('materias/cambiar-estado') }}/" + id + "/" + estado,
                success: function(respuesta) {
                    if (respuesta == 1) {
                        Swal.fire({
                            title: 'Éxito',
                            text: 'Cambio de estado exitoso',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                        recargar_tbody();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo cambiar el estado',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                }
            });
        }

        $(document).ready(function() {
            // Usamos delegación de eventos para que funcione tras recargar el tbody
            $('#tbody-usuarios').on("change", ".form-check-input", function() {
                let id = $(this).attr("id");
                let estado = $(this).is(":checked") ? 1 : 0;
                cambiar_estado(id, estado);
            });
        });
    </script>
@endpush
