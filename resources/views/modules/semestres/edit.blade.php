@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Editar Semestre</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('semestres') }}">Semestres</a></li>
                    <li class="breadcrumb-item active">Editar semestre</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <form action="{{ route('semestres.update', $item->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label fw-bold" for="nombre">Nombre del semestre</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="nombre" id="nombre" type="text"
                            class="form-control" value="{{ old('nombre', $item->nombre) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="anio">Año del semestre</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="anio" id="anio" type="text"
                            class="form-control" value="{{ old('anio', $item->anio) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="periodo">Periodo del semestre</label>
                        <select id="periodo" name="periodo" class="form-select" required>
                            <option disabled>Seleccione el periodo...</option>
                            <option value="1" {{ $item->periodo == 1 ? 'selected' : '' }}>
                                ENERO - JUNIO
                            </option>
                            <option value="2" {{ $item->periodo == 2 ? 'selected' : '' }}>
                                AGOSTO - DICIEMBRE
                            </option>
                        </select>
                    </div>

                    <div class="col-4">
                        <label class="form-label fw-bold" for="semestre">Semestre</label>
                        <select id="semestre" name="semestre" class="form-select" required>
                            @for ($i = 1; $i <= 9; $i++)
                                <option value="{{ $i }}" {{ $item->semestre == $i ? 'selected' : '' }}>
                                    {{ $i }}{{ $i == 1 ? 'er' : ($i == 2 ? 'do' : ($i == 3 ? 'er' : 'to')) }}
                                    Semestre
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-8">
                        <label class="form-label fw-bold" for="materias_select">Materias</label>
                        <select id="materias_select" class="js-example-basic-multiple form-select" name="materias_select[]"
                            multiple required>

                            @foreach ($materias as $materia)
                                @if ($materia->activo)
                                    <option value="{{ $materia->id }}" data-semestre="{{ $materia->semestre }}"
                                        {{ $item->materias->contains($materia->id) ? 'selected' : '' }}>
                                        {{ $materia->clave }} - {{ $materia->nombre }}
                                    </option>
                                @endif
                            @endforeach

                        </select>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-dark px-4">
                            Actualizar Semestre
                        </button>
                        <a href="{{ route('semestres') }}" class="btn btn-outline-info">
                            Regresar
                        </a>
                    </div>

                </div>
            </form>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            const $materias = $('#materias_select');

            const opcionesOriginales = $materias.find('option').clone();

            $materias.select2({
                theme: 'bootstrap-5',
                width: '100%'
            });

            function filtrarMaterias() {

                const semestreSeleccionado = $('#semestre').val();
                const seleccionadas = $materias.val() || [];

                $materias.empty();

                opcionesOriginales.each(function() {

                    const semestreMateria = $(this).data('semestre');
                    const idMateria = $(this).val();

                    if (
                        semestreMateria == semestreSeleccionado ||
                        seleccionadas.includes(idMateria)
                    ) {
                        $materias.append($(this).clone());
                    }

                });

                $materias.val(seleccionadas).trigger('change');

            }

            $('#semestre').on('change', filtrarMaterias);

            filtrarMaterias();

        });
    </script>
@endpush
