@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="row justify-content-center">
        <div class="col-lg-9">

            <div class="card border-0 shadow-lg semestre-card mt-4 mb-4">

                <div class="card-header semestre-header">

                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                        <div>
                            <h2 class="fw-bold text-danger mb-1">
                                Eliminar Semestre
                            </h2>

                            <p class="text-muted mb-0">
                                Confirma la eliminación definitiva del periodo académico
                            </p>
                        </div>

                        <div class="header-icon danger">
                            <i class="bi bi-trash-fill"></i>
                        </div>

                    </div>

                    <nav class="mt-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}"
                                   class="text-decoration-none text-secondary">
                                    Home
                                </a>
                            </li>

                            <li class="breadcrumb-item">
                                <a href="{{ route('semestres') }}"
                                   class="text-decoration-none text-secondary">
                                    Semestres
                                </a>
                            </li>

                            <li class="breadcrumb-item active text-danger fw-semibold">
                                Eliminar
                            </li>
                        </ol>
                    </nav>

                </div>

                <div class="card-body p-4 p-lg-5">

                    {{-- ALERTA --}}
                    <div class="delete-alert">

                        <div class="d-flex align-items-start gap-3">

                            <div class="alert-icon">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                            </div>

                            <div>

                                <h4 class="fw-bold text-danger mb-2">
                                    Advertencia importante
                                </h4>

                                <p class="mb-2">
                                    Vas a eliminar el semestre
                                    <strong class="text-dark">
                                        {{ $item->nombre }}
                                    </strong>.
                                    Esta acción no se puede deshacer.
                                </p>

                                <p class="mb-0">
                                    Si este semestre tiene materias asociadas,
                                    también dejarán de estar vinculadas al mismo.
                                </p>

                            </div>

                        </div>

                    </div>

                    {{-- RESUMEN --}}
                    <div class="info-box mt-4">

                        <h5 class="fw-bold mb-3 text-dark">
                            Información del semestre
                        </h5>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="label">Nombre:</span>
                                    <span class="value">{{ $item->nombre }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="label">Año:</span>
                                    <span class="value">{{ $item->anio }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="label">Periodo:</span>
                                    <span class="value">{{ $item->periodo }}</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-item">
                                    <span class="label">Estado:</span>
                                    <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                                        {{ $item->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>

                        </div>

                    </div>

                    {{-- BOTONES --}}
                    <div class="text-center mt-5">

                        <a href="{{ route('semestres') }}"
                           class="btn btn-outline-secondary px-4 rounded-pill me-2">

                            <i class="bi bi-x-circle me-2"></i>
                            Cancelar
                        </a>

                        <button
                            id="btnEliminar"
                            class="btn btn-danger px-5 rounded-pill shadow-sm"
                        >
                            <i class="bi bi-trash me-2"></i>
                            Eliminar Semestre
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </div>

</main>

@endsection


<style>
    .semestre-card {
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
    }

    .semestre-header {
        background: linear-gradient(135deg, #fff8f8, #fff1f1);
        border-bottom: 1px solid #f3dcdc;
        padding: 30px;
    }

    .header-icon {
        width: 68px;
        height: 68px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 28px;
    }

    .header-icon.danger {
        background: linear-gradient(135deg, #dc3545, #ff6b7a);
        box-shadow: 0 10px 25px rgba(220, 53, 69, 0.18);
    }

    .delete-alert {
        background: #fff8f8;
        border: 1px solid #ffd9dd;
        border-radius: 18px;
        padding: 25px;
    }

    .alert-icon {
        width: 55px;
        height: 55px;
        border-radius: 14px;
        background: rgba(220, 53, 69, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #dc3545;
        font-size: 24px;
        flex-shrink: 0;
    }

    .info-box {
        background: #fafbfd;
        border: 1px solid #edf0f5;
        border-radius: 18px;
        padding: 25px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .label {
        font-size: 13px;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .value {
        font-size: 15px;
        font-weight: 600;
        color: #212529;
    }

    .btn {
        transition: 0.25s;
        font-weight: 600;
    }

    .btn:hover {
        transform: translateY(-2px);
    }
</style>


@push('scripts')
<script>
document.getElementById('btnEliminar').addEventListener('click', function() {
    Swal.fire({
        title: 'Confirmar eliminación',
        text: 'Ingresa tu contraseña para eliminar este semestre',
        input: 'password',
        inputAttributes: {
            placeholder: 'Contraseña'
        },
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar',
        showLoaderOnConfirm: true,

        preConfirm: (password) => {
            return fetch("{{ route('semestres.destroy', $item->id) }}", {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    password: password
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(data => {
                        throw new Error(data.error || 'Contraseña incorrecta');
                    });
                }

                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(error.message);
            });
        }

    }).then((result) => {

        if (result.isConfirmed) {

            Swal.fire(
                '¡Eliminado!',
                'El semestre ha sido eliminado correctamente.',
                'success'
            ).then(() => {
                window.location.href = "{{ route('semestres') }}";
            });

        }

    });
});
</script>
@endpush