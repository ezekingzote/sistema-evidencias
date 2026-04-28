@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="fw-bold" style="color:#012970;">
                    <i class="bi bi-trash3-fill me-2 text-danger"></i>
                    Eliminar Materia
                </h1>

                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            Materias
                        </li>
                        <li class="breadcrumb-item active text-danger">
                            Confirmar Eliminación
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-11">

                <div class="card border-0 shadow-lg"
                    style="border-radius:20px; overflow:hidden;">

                    <div class="card-header border-0 py-4 px-4"
                        style="background: linear-gradient(135deg, #fff5f5 0%, #ffe5e5 100%);">

                        <div class="d-flex align-items-center">

                            <div class="me-3 d-flex align-items-center justify-content-center"
                                style="width:60px; height:60px; border-radius:16px; background:rgba(220,53,69,.12);">

                                <i class="bi bi-exclamation-triangle-fill text-danger fs-3"></i>

                            </div>

                            <div>
                                <h4 class="mb-1 fw-bold text-danger">
                                    Confirmar eliminación definitiva
                                </h4>

                                <p class="mb-0 text-muted">
                                    Esta acción eliminará permanentemente esta asignatura del sistema.
                                </p>
                            </div>

                        </div>
                    </div>

                    <div class="card-body p-4 p-lg-5">

                        <div class="alert border-0 shadow-sm mb-4"
                            style="background:#fff4f4; border-left:5px solid #dc3545 !important; border-radius:14px;">

                            <div class="d-flex align-items-center">
                                <i class="bi bi-shield-exclamation text-danger fs-3 me-3"></i>

                                <div>
                                    <h6 class="fw-bold mb-1 text-danger">
                                        Atención importante
                                    </h6>

                                    <p class="mb-0 text-dark">
                                        Está a punto de eliminar la asignatura:
                                        <strong>{{ $items->nombre }}</strong>
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="table-responsive rounded-4 border shadow-sm overflow-hidden">

                            <table class="table table-hover align-middle mb-0">

                                <thead style="background:#f8fafc;">
                                    <tr>
                                        <th class="py-3 px-4 text-uppercase small fw-bold">
                                            Nombre
                                        </th>

                                        <th class="text-center text-uppercase small fw-bold">
                                            Clave
                                        </th>

                                        <th class="text-center text-uppercase small fw-bold">
                                            Unidades
                                        </th>

                                        <th class="text-center text-uppercase small fw-bold">
                                            Carrera
                                        </th>

                                        <th class="text-center text-uppercase small fw-bold">
                                            Semestre
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>

                                        <td class="py-4 px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 d-flex align-items-center justify-content-center"
                                                    style="width:45px; height:45px; border-radius:12px; background:#eef4ff;">
                                                    <i class="bi bi-journal-bookmark-fill text-primary"></i>
                                                </div>

                                                <div>
                                                    <h6 class="mb-0 fw-bold">
                                                        {{ $items->nombre }}
                                                    </h6>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                                {{ $items->clave }}
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge bg-secondary-subtle text-dark px-3 py-2 rounded-pill">
                                                {{ $items->unidades }} Unidades
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <small class="fw-semibold text-muted">
                                                {{ $items->carrera }}
                                            </small>
                                        </td>

                                        <td class="text-center">
                                            <span class="badge border border-info text-info px-3 py-2 rounded-pill">
                                                {{ $items->semestre }}° Semestre
                                            </span>
                                        </td>

                                    </tr>
                                </tbody>

                            </table>
                        </div>

                        <div class="mt-5 pt-4 border-top">
                            <div class="d-flex justify-content-end flex-wrap gap-3">

                                <a href="{{ route('materias') }}"
                                    class="btn btn-light px-4 py-2 shadow-sm">

                                    <i class="bi bi-arrow-left-circle me-2"></i>
                                    Cancelar
                                </a>

                                <form action="{{ route('materias.destroy', $items->id) }}"
                                    method="POST"
                                    class="m-0">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="btn px-4 py-2 fw-bold shadow-sm"
                                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
                                               border:none;
                                               color:white;
                                               border-radius:10px;">

                                        <i class="bi bi-trash3-fill me-2"></i>
                                        Confirmar Eliminación
                                    </button>

                                </form>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</main>

<style>
    .card {
        border-radius: 20px;
    }

    .table thead th {
        letter-spacing: .5px;
        color: #495057;
        border-bottom: 1px solid #edf2f7;
    }

    .table tbody td {
        vertical-align: middle;
    }

    .btn {
        border-radius: 10px;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .breadcrumb {
        font-size: 14px;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }
    }
</style>

@endsection