@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="text-dark">Gestión de Materias</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Materias</li>
                <li class="breadcrumb-item active text-danger">Confirmar Eliminación</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-11">

                <div class="card shadow border-0" style="border-radius: 15px; overflow: hidden;">
                    
                    <div class="card-header bg-white py-4 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-danger-light rounded-3 me-3">
                                <i class="bi bi-trash3-fill text-danger fs-3"></i>
                            </div>
                            <div>
                                <h4 class="mb-0 fw-bold text-danger">¿Confirmar eliminación definitiva?</h4>
                                <p class="text-muted mb-0">Esta acción borrará permanentemente el registro de la base de datos.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4 mt-2">
                        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
                            <i class="bi bi-exclamation-octagon-fill fs-4 me-3"></i>
                            <div>
                                Está a punto de eliminar la asignatura: <strong>{{ $items->nombre }}</strong>.
                            </div>
                        </div>

                        <div class="table-responsive rounded-3 border shadow-sm">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light">
                                    <tr class="text-secondary">
                                        <th class="py-3 px-4">NOMBRE DE MATERIA</th>
                                        <th class="text-center">CLAVE</th>
                                        <th class="text-center">UNIDADES</th>
                                        <th class="text-center">CARRERA</th>
                                        <th class="text-center">ESPECIALIDAD</th>
                                        <th class="text-center">SEMESTRE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="py-4 px-4">
                                            <span class="fw-bold text-dark fs-5">{{ $items->nombre }}</span>
                                        </td>
                                        <td class="text-center text-primary fw-bold">{{ $items->clave }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-secondary px-3 py-2">{{ $items->unidades }} Unidades</span>
                                        </td>
                                        <td class="text-center">
                                            <small class="text-muted fw-bold">{{ $items->carrera }}</small>
                                        </td>
                                        <td class="text-center">
                                            <small class="text-muted fw-bold">{{ $items->especialidad }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge outline-info-custom px-3 py-2 text-info border border-info">
                                                {{ $items->semestre }}° Semestre
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-end align-items-center mt-5 gap-3 border-top pt-4">
                            <a href="{{ route('materias') }}" class="btn btn-outline-info btn-lg px-4 shadow-sm" style="border-radius: 10px;">
                                <i class="bi bi-x-circle me-2"></i>Cancelar y Regresar
                            </a>
                            
                            <form action="{{ route('materias.destroy', $items->id) }}" method="POST" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-lg px-4 shadow-sm" style="border-radius: 10px;">
                                    <i class="bi bi-trash3 me-2"></i>Confirmar Eliminación
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    /* Estilos de respaldo en caso de que el CSS externo falle */
    .bg-danger-light {
        background-color: rgba(220, 53, 69, 0.1) !important;
    }
    .card {
        background: #fff;
        transition: all 0.3s ease;
    }
    .table thead th {
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545 !important;
        color: white !important;
    }
    .btn-outline-info:hover {
        background-color: #0dcaf0 !important;
        color: white !important;
    }
    /* Si las fuentes no cargan bien */
    body {
        font-family: 'Open Sans', sans-serif !important;
    }
</style>
@endsection