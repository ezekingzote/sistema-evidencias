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
        </div>
        <nav>
        </nav>
        </div>
        <section class="section">
            <form action="#" id="formMateria" method="POST">
                @csrf
                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label fw-bold" for="nombre">Nombre del semestre</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="nombre" id="nombre" type="text"
                            class="form-control" placeholder="Ej. 2026-1" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="anio">Año del semestre</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="anio" id="anio" type="text"
                            class="form-control" placeholder="2026" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="carrera">Seleccione la carrera</label>
                        <select id="carrera" name="carrera" class="form-select" required>
                            <option value="" selected disabled>Seleccione la carrera correspondiente...</option>
                            <option value="INGENIERIA EN SISTEMAS COMPUTACIONALES">INGENIERIA EN SISTEMAS COMPUTACIONALES
                            </option>
                            <option value="INGENIERIA INDUSTRIAL">INGENIERIA INDUSTRIAL</option>
                            <option value="INGENIERIA EN GESTION EMPRESARIAL">INGENIERIA EN GESTION EMPRESARIAL</option>
                            <option value="LICENCIATURA EN TURISMO">LICENCIATURA EN TURISMO</option>
                        </select>
                    </div>

                    <div class="col-4">
                        <label class="form-label fw-bold" for="semestre">Seleccione el Semestre</label>
                        <select id="semestre" name="semestre" class="form-select" required>
                            <option value="" selected disabled>Seleccione el semestre</option>
                            @for ($i = 1; $i <= 9; $i++)
                                <option value="{{ $i }}">
                                    {{ $i }}{{ $i == 1 ? 'er' : ($i == 2 ? 'do' : ($i == 3 ? 'er' : 'to')) }}
                                    Semestre</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-8">
                        <label class="form-label fw-bold" for="materias_select">Materias</label>
                        <select id="materias_select" class="js-example-basic-multiple form-select" name="materias[]"
                            multiple required>
                            @foreach ($materias as $materia)
                                @if ($materia->activo == 1)
                                    <option value="{{ $materia->id }}" data-semestre="{{ $materia->semestre }}">
                                        {{ $materia->clave }} - {{ $materia->nombre }}
                                    </option>
                                @endif
                            @endforeach
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
            const $materias = $('.js-example-basic-multiple');
            const opcionesOriginales = $materias.find('option').clone();

            $materias.select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            $('#semestre').on('change', function() {
                const semestreSeleccionado = $(this).val();
                const seleccionadas = $materias.val() || [];
                $materias.empty();
                opcionesOriginales.each(function() {
                    const semestreMateria = $(this).data('semestre');
                    const idMateria = $(this).val();
                    if (
                        semestreMateria == semestreSeleccionado ||
                        seleccionadas.includes(idMateria)
                    ) {
                        $materias.append($(this));
                    }
                });

                $materias.val(seleccionadas);
                $materias.trigger('change');
            });

        });
    </script>

@endpush
