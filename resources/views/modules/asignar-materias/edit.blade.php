@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="card mt-4 mb-4">
            <div class="card-body">

                <div class="pagetitle">
                    <h1>Editar Asignación</h1>
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('asignar-materias') }}">Asignar Materias</a>
                            </li>
                            <li class="breadcrumb-item active">Editar</li>
                        </ol>
                    </nav>
                </div>

                <section class="section">
                    <form action="{{ route('asignar-materias.update', $item->id) }}" method="POST" id="formAsignacionEdit">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Semestre</label>
                                <input type="text" class="form-control bg-light" readonly
                                    value="{{ $item->semestre->nombre }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Materia</label>
                                <input type="text" class="form-control bg-light" readonly
                                    value="{{ $item->materia->nombre }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Grupo</label>
                                <input type="text" class="form-control bg-light" readonly value="{{ $item->grupo }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">Docente</label>
                                <select name="docente_id" class="form-select" required>
                                    <option value="" disabled>Seleccione docente...</option>
                                    @foreach ($docentes as $docente)
                                        <option value="{{ $docente->id }}"
                                            {{ $item->docente_id == $docente->id ? 'selected' : '' }}>
                                            {{ $docente->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mt-4 text-center">
                                <a href="{{ route('asignar-materias') }}" class="btn btn-outline-info me-2">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar
                                </a>

                                <button type="submit" class="btn btn-outline-dark px-5">
                                    <i class="fa-solid fa-floppy-disk me-1"></i>
                                    Guardar Cambios
                                </button>
                            </div>

                        </div>
                    </form>
                </section>

            </div>
        </div>
    </main>
@endsection
