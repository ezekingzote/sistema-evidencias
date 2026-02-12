@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Modificar Asignatura</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Materias</li>
                    <li class="breadcrumb-item active">Editar Registro</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-warning-light me-3">
                                    <i class="bi bi-pencil-square text-warning fs-4"></i>
                                </div>
                                <div>
                                    <h5 class="card-title mb-0 p-0">Editor de Materia</h5>
                                    <small class="text-muted">Editando: <strong>{{ $item->nombre }}</strong></small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <form action="{{ route('materias.update', $item->id) }}" id="formMateria" method="POST"
                                class="needs-validation">
                                @csrf
                                @method('PUT')

                                <div class="row g-4">

                                    <div class="col-12">
                                        <label class="form-label fw-bold" for="nombre">
                                            <i class="bi bi-fonts me-1"></i> Nombre de la Materia
                                        </label>
                                        <input oninput="this.value = this.value.toUpperCase();" name="nombre"
                                            id="nombre" type="text" class="form-control form-control-lg bg-light"
                                            value="{{ $item->nombre }}" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold" for="clave">
                                            <i class="bi bi-key me-1"></i> Clave Materia
                                        </label>
                                        <input oninput="this.value = this.value.toUpperCase();" name="clave"
                                            id="clave" type="text" class="form-control" value="{{ $item->clave }}"
                                            required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold" for="unidades">
                                            <i class="bi bi-list-check me-1"></i> Número de Unidades
                                        </label>
                                        <div class="input-group">
                                            <input name="unidades" id="unidades" type="number" class="form-control"
                                                min="1" max="10" value="{{ $item->unidades }}" required>
                                            <span class="input-group-text">Unid.</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold" for="carrera">
                                            <i class="bi bi-mortarboard me-1"></i> Carrera Correspondiente
                                        </label>
                                        <select id="carrera" name="carrera" class="form-select shadow-none" required>
                                            @php
                                                $carreras = [
                                                    'INGENIERIA EN SISTEMAS COMPUTACIONALES',
                                                    'INGENIERIA INDUSTRIAL',
                                                    'INGENIERIA EN GESTIÓN EMPRESARIAL',
                                                    'LICENCIATURA EN TURISMO',
                                                ];
                                            @endphp
                                            @foreach ($carreras as $carrera)
                                                <option value="{{ $carrera }}"
                                                    {{ $item->carrera == $carrera ? 'selected' : '' }}>
                                                    {{ $carrera }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="especialidad" class="form-label fw-bold">
                                            <i class="bi bi-calendar3 me-1"></i> ¿ES DE ESPECIALIDAD LA MATERIA?
                                        </label>

                                        <select id="especialidad" name="especialidad" class="form-select" required>
                                            <option value="" disabled>Seleccione una respuesta</option>

                                            <option value="SÍ" {{ $item->especialidad == 'SÍ' ? 'selected' : '' }}>
                                                SÍ
                                            </option>

                                            <option value="NO" {{ $item->especialidad == 'NO' ? 'selected' : '' }}>
                                                NO
                                            </option>
                                        </select>
                                    </div>


                                    <div class="col-md-6">
                                        <label for="semestre" class="form-label fw-bold">
                                            <i class="bi bi-calendar3 me-1"></i> Semestre
                                        </label>
                                        <select id="semestre" name="semestre" class="form-select shadow-none" required>
                                            @for ($i = 1; $i <= 9; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $item->semestre == $i ? 'selected' : '' }}>
                                                    {{ $i }}° Semestre
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('materias') }}" class="btn btn-outline-info border px-4">
                                                <i class="bi bi-x-circle me-2"> </i>Cancelar
                                            </a>
                                            <button type="submit" class="btn btn-outline-warning px-5 shadow-sm fw-bold">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Cambios
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>

    </main>

    <style>
        /* Estilos personalizados para coherencia visual */
        .bg-warning-light {
            background-color: #fff3cd;
            padding: 10px;
            border-radius: 10px;
            display: inline-flex;
        }

        .card {
            border-radius: 15px;
        }

        .card-header {
            border-top-left-radius: 15px !important;
            border-top-right-radius: 15px !important;
            border-bottom: 1px solid #f8f9fa;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 0.6rem 1rem;
        }

        .btn {
            border-radius: 8px;
            transition: all 0.3s;
        }

        .btn-warning:hover {
            background-color: #ffca2c;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
        }
    </style>
@endsection
