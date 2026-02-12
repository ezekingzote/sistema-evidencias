@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Modificar Usuario</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Usuarios</li>
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
                                    <h5 class="card-title mb-0 p-0">Editor de Usuario</h5>
                                    <small class="text-muted">Editando a: <strong>{{ $item->name }}
                                            {{ $item->apellido_p }}</strong></small>
                                </div>
                            </div>
                        </div>

                        <div class="card-body mt-4">
                            <form action="{{ route('docentes.update', $item->id) }}" id="formUsuario" method="POST"
                                class="needs-validation">
                                @csrf
                                @method('PUT')


                                <div class="col-md-12">
                                    <label class="form-label fw-bold">
                                        <i class="bi bi-person me-1"></i> Nombre(s)
                                    </label>
                                    <input name="name" type="text" class="form-control bg-light"
                                        oninput="this.value = this.value.toUpperCase();" value="{{ $item->name }}"
                                        required>
                                </div>

                                <div class="row g-4 mt-4">


                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-shield-lock me-1"></i> Rol de Sistema
                                        </label>
                                        <select name="rol" id="rol_select" class="form-select shadow-none" required>
                                            <option value="docente" {{ $item->rol == 'docente' ? 'selected' : '' }}>DOCENTE
                                            </option>
                                            <option value="admin" {{ $item->rol == 'admin' ? 'selected' : '' }}>
                                                ADMINISTRADOR</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            <i class="bi bi-envelope me-1"></i> Correo Usuario
                                        </label>
                                        <div class="input-group">
                                            <input name="email" id="email_username" type="text" class="form-control"
                                                autocomplete="off" value="{{ explode('@', $item->email)[0] }}" required>
                                            <span class="input-group-text fw-bold text-primary bg-white" id="email_domain">
                                                {{ str_contains($item->email, '@admin') ? '@admin.com' : '@docente.com' }}
                                            </span>
                                        </div>
                                        <small class="text-muted">El dominio cambia según el rol seleccionado.</small>
                                    </div>

                                    <div class="col-12 mt-5">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="{{ route('docentes') }}" class="btn btn-outline-info px-4">
                                                <i class="bi bi-x-circle me-1"></i> Cancelar
                                            </a>
                                            <button type="submit"
                                                class="btn btn-outline-warning px-5 shadow-sm fw-bold text-dark">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Registro
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rolSelect = document.getElementById('rol_select');
            const emailDomain = document.getElementById('email_domain');
            const emailInput = document.getElementById('email_username');

            // Cambiar el dominio visualmente al cambiar el rol
            rolSelect.addEventListener('change', function() {
                emailDomain.textContent = this.value === 'admin' ? '@admin.com' : '@docente.com';
            });

            // Limpiar el input de correo (sin espacios, sin @)
            emailInput.addEventListener('input', function() {
                let valor = this.value.toLowerCase().replace(/\s+/g, '');
                if (valor.includes('@')) {
                    valor = valor.split('@')[0];
                }
                this.value = valor;
            });
        });
    </script>
@endsection
