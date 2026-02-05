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
            <a href="{{ route('crear-semestre') }}" class="btn btn-outline-primary"><i class="fa-solid fa-plus"></i> Nuevo
                Semestre</a>
            <hr>
            <div class="row g-4" id="contenedor-semestres">

                @include('modules.semestres.cards')

            </div>
        </section>

    </main>
@endsection


@push('scripts')
    <script>

        function cambiar_estado(id, estado) {
            $.ajax({
                type: "GET",
                url: "semestres/cambiar-estado/" + id + "/" + estado,
                success: function(respuesta) {
                    if (respuesta == 1) {
                        Swal.fire({
                            title: '¡Éxito!',
                            text: 'CAMBIO DE ESTADO EXITOSO!',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        }).then((result) => {

                            if (result.isConfirmed || result.isDismissed) {
                                location.reload();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'Fallo',
                            text: 'No se llevó a cabo el cambio!',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            location
                                .reload();
                        });
                    }
                },
                error: function() {
                    alert("Error de conexión con el servidor");
                    location.reload();
                }
            });
        }

        $(document).ready(function() {

            $('.form-check-input').on("change", function() {
                let id = $(this).attr("id");
                let estado = $(this).is(":checked") ? 1 : 0;
                cambiar_estado(id, estado);
            });
        });
    </script>
@endpush
