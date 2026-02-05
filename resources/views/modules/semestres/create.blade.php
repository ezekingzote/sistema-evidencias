@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Crear Nuevo semestre</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Registrar nuevo semestre</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        <nav>
        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <form action="#" id="formMateria" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label fw-bold" for="nombre">Nombre del semestre</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="nombre" id="nombre" type="text"
                            class="form-control" placeholder="Ej. Estructura de Datos" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="clave">Año del semestre</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="clave" id="clave" type="text"
                            class="form-control" placeholder="AED-128" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="carrera" for="carrera">Seleccione el Año ciclo
                            escolar</label>
                        <select id="carrera" name="carrera" class="form-select" required>
                            <option value="" selected disabled>Seleccione la carrera correspondiente...</option>
                            <option value="INGENIERIA EN SISTEMAS COMPUTACIONALES">INGENIERIA EN SISTEMAS COMPUTACIONALES
                            </option>
                            <option value="INGENIERIA INDUSTRIAL">INGENIERIA INDUSTRIAL</option>
                            <option value="INGENIERIA EN GESTION EMPRESARIAL">INGENIERIA EN GESTION EMPRESARIAL</option>
                            <option value="LICENCIATURA EN TURISMO">LICENCIATURA EN TURISMO</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Estados</label>
                        <select class="js-example-basic-multiple form-select" name="states[]" multiple>
                            <option value="AL">Alabama</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-dark px-4">
                            Crear Materia
                        </button>
                        <a href="{{ route('materias') }}" class="btn btn-outline-info">Regresar</a>
                    </div>

                </div>
            </form>
        </section>
    </main>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                theme: 'bootstrap-5',
                width: '100%'
            });
        });
    </script>
@endpush
