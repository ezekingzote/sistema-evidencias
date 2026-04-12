@extends('layouts.main')

@section('titulo', 'Listado de Evidencias')

@section('contenido')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Gestión de Evidencias</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Home</a></li>
                <li class="breadcrumb-item active">Evidencias</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0 p-0">Evidencias Registradas</h5>
                            <p class="text-muted small mb-0">Visualiza y gestiona los documentos cargados al sistema.</p>
                        </div>
                        <a href="{{ route('evidencias.create') }}" class="btn btn-outline-primary rounded-pill px-4 shadow-sm">
                            <i class="bi bi-plus-lg me-1"></i> Nueva Evidencia
                        </a>
                    </div>

                    <div class="card-body p-4">
                        
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="tablaEvidencias">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col" class="text-uppercase small fw-bold text-center">Asignatura</th>
                                        <th scope="col" class="text-uppercase small fw-bold text-center">Revisión</th>
                                        <th scope="col" class="text-uppercase small fw-bold text-center">Archivos</th>
                                        <th scope="col" class="text-uppercase small fw-bold text-center">Fecha de Carga</th>
                                        <th scope="col" class="text-uppercase small fw-bold text-center">Status</th>
                                        <th scope="col" class="text-uppercase small fw-bold text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($evidencias as $evidencia)
                                    <tr>
                                        <td class="fw-bold text-secondary">#{{ $evidencia->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="p-2 bg-info bg-opacity-10 rounded-circle me-2">
                                                    <i class="bi bi-journal-text text-info"></i>
                                                </div>
                                                <span>{{ $evidencia->revision->nombre }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match($evidencia->tipo_evidencia) {
                                                    'instrumentacion' => 'bg-primary',
                                                    'calificaciones' => 'bg-success',
                                                    'examen' => 'bg-warning text-dark',
                                                    default => 'bg-secondary',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} bg-opacity-10 text-{{ str_replace('bg-', '', explode(' ', $badgeClass)[0]) }} border border-{{ str_replace('bg-', '', explode(' ', $badgeClass)[0]) }} px-3 py-2">
                                                {{ ucfirst($evidencia->tipo_evidencia) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill bg-light text-dark border">
                                                <i class="bi bi-folder2-open me-1 text-primary"></i> 2 Carpetas
                                            </span>
                                        </td>
                                        <td class="small text-muted">
                                            {{ $evidencia->created_at->format('d/m/Y H:i') }}
                                        </td>
                                        <td class="text-end">
                                            <div class="dropdown">
                                                <button class="btn btn-light btn-sm rounded-circle" type="button" data-bs-toggle="dropdown">
                                                    <i class="bi bi-three-dots-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-eye me-2 text-info"></i> Ver Detalles</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="bi bi-download me-2 text-success"></i> Descargar ZIP</a></li>
                                                    <li><hr class="dropdown-divider"></li>
                                                    <li>
                                                        <form action="" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta evidencia?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bi bi-trash me-2"></i> Eliminar
                                                            </button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" alt="No data" style="width: 80px;" class="opacity-25 mb-3">
                                            <p class="text-muted">No se encontraron evidencias registradas.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        </div>
                </div>

            </div>
        </div>
    </section>

</main>
@endsection