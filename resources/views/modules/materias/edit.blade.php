@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Eitar Materia</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Editar una materia</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->


        <nav>

        </nav>
        </div><!-- End Page Title -->
        <section class="section">
            <form action="{{ route('materias.update', $item->id) }}" id="formMateria" method="POST">
                @csrf
                @method('PUT')
                <div class="row g-3">

                    <div class="col-12">
                        <label class="form-label fw-bold" for="nombre">Nombre de la Materia</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="nombre" id="nombre" type="text"
                            class="form-control" value="{{ $item->nombre }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="clave">Clave Materia</label>
                        <input oninput="this.value = this.value.toUpperCase();" name="clave" id="clave" type="text"
                            class="form-control" value="{{ $item->clave }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="unidades">Número de Unidades</label>
                        <input name="unidades" id="unidades" type="number" class="form-control" min="1"
                            max="10" value="{{ $item->unidades }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-bold" for="carrera">Carrera correspondiente</label>
                        <select id="carrera" name="carrera" class="form-select" required>
                            <option value="INGENIERIA EN SISTEMAS COMPUTACIONALES"
                                {{ $item->carrera == 'INGENIERIA EN SISTEMAS COMPUTACIONALES' ? 'selected' : '' }}>
                                INGENIERIA EN SISTEMAS COMPUTACIONALES
                            </option>

                            <option value="INGENIERIA INDUSTRIAL"
                                {{ $item->carrera == 'INGENIERIA INDUSTRIAL' ? 'selected' : '' }}>
                                INGENIERIA INDUSTRIAL
                            </option>

                            <option value="INGENIERIA EN GESTIÓN EMPRESARIAL"
                                {{ $item->carrera == 'INGENIERIA EN GESTIÓN EMPRESARIAL' ? 'selected' : '' }}>
                                INGENIERIA EN GESTIÓN EMPRESARIAL
                            </option>

                            <option value="LICENCIATURA EN TURISMO"
                                {{ $item->carrera == 'LICENCIATURA EN TURISMO' ? 'selected' : '' }}>
                                LICENCIATURA EN TURISMO
                            </option>
                        </select>
                    </div>


                    <div class="col-md-6">
                        <label for="semestre" class="form-label fw-bold">Semestre de la asignatura</label>
                        <select id="semestre" name="semestre" class="form-select" required>
                            <option value="1" {{ $item->semestre == 1 ? 'selected' : '' }}>1er Semestre</option>
                            <option value="2" {{ $item->semestre == 2 ? 'selected' : '' }}>2do Semestre</option>
                            <option value="3" {{ $item->semestre == 3 ? 'selected' : '' }}>3er Semestre</option>
                            <option value="4" {{ $item->semestre == 4 ? 'selected' : '' }}>4to Semestre</option>
                            <option value="5" {{ $item->semestre == 5 ? 'selected' : '' }}>5to Semestre</option>
                            <option value="6" {{ $item->semestre == 6 ? 'selected' : '' }}>6to Semestre</option>
                            <option value="7" {{ $item->semestre == 7 ? 'selected' : '' }}>7mo Semestre</option>
                            <option value="8" {{ $item->semestre == 8 ? 'selected' : '' }}>8vo Semestre</option>
                            <option value="9" {{ $item->semestre == 9 ? 'selected' : '' }}>9no Semestre</option>
                        </select>
                    </div>


                    <div class="col-12">
                        <button type="submit" class="btn btn-outline-warning px-4">
                            Actualizar Materia
                        </button>
                        <a href="{{ route('materias') }}" class="btn btn-outline-info"></i>Regresar</a>
                    </div>

                </div>
            </form>
        </section>

    </main>
@endsection
