@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">
        <div class="card mt-4 mb-4">
            <div class="card-body">

                <div class="pagetitle">
                    <h1><i class="bi bi-pencil-square me-2"></i>Editar Asignación</h1>
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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

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

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Grupo</label>
                                <input type="text" class="form-control bg-light" readonly value="{{ $item->grupo }}">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">Docente</label>
                                <select name="docente_id" class="form-select select2" required>
                                    <option value="" disabled>Seleccione docente...</option>
                                    @foreach ($docentes as $docente)
                                        <option value="{{ $docente->id }}"
                                            {{ $item->docente_id == $docente->id ? 'selected' : '' }}>
                                            {{ $docente->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold" for="alumnos">
                                    <i class="bi bi-people me-1"></i> Cantidad de Alumnos
                                </label>
                                <div class="input-group">
                                    <input name="alumnos" id="alumnos" type="number" class="form-control"
                                        min="1" max="100" value="{{ old('alumnos', $item->alumnos) }}" required>
                                    <span class="input-group-text">Alumnos</span>
                                </div>
                            </div>

                            <div class="col-12 mt-4 text-center">
                                <hr>
                                <a href="{{ route('asignar-materias') }}" class="btn btn-outline-secondary me-2">
                                    <i class="bi bi-x-circle me-1"></i> Cancelar
                                </a>

                                <button type="submit" class="btn btn-primary px-5">
                                    <i class="bi bi-check-circle me-1"></i>
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