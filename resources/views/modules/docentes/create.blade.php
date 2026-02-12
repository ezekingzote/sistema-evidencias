@extends('layouts.main')

@section('titulo', 'Registrar Usuario')

@section('contenido')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Gestión de Usuarios</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item">Usuarios</li>
                    <li class="breadcrumb-item active">Nuevo Registro</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-11">

                    <div class="card shadow-sm border-0" style="border-radius: 15px;">
                        <div class="card-header bg-white py-3">
                            <div class="d-flex align-items-center">
                                <div class="p-2 bg-primary-light rounded-3 me-3">
                                    <i class="bi bi-person-plus-fill text-primary fs-4"></i>
                                </div>
                                <h5 class="card-title mb-0 p-0">Datos del Nuevo Usuario</h5>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <form action="{{ route('docente.store') }}" method="POST">
                                @csrf
                                <div class="row g-4">

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Nombre(s)</label>
                                        <input type="text" name="name" class="form-control bg-light"
                                            placeholder="NOMBRE" style="text-transform: uppercase;" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Apellido Paterno</label>
                                        <input type="text" name="apellido_p" class="form-control bg-light"
                                            placeholder="APELLIDO PATERNO" style="text-transform: uppercase;" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">Apellido Materno</label>
                                        <input type="text" name="apellido_m" class="form-control bg-light"
                                            placeholder="APELLIDO MATERNO" style="text-transform: uppercase;">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Rol de Usuario</label>
                                        <select name="rol" id="rol_select" class="form-select" style="border-left: 5px solid #0d6efd;" required>
                                            <option value="docente" {{ old('rol') == 'docente' ? 'selected' : '' }}>DOCENTE</option>
                                            <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>ADMINISTRADOR</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Correo Electrónico (Usuario)</label>
                                        <div class="input-group">
                                            <input type="text" name="email" id="email_username" class="form-control"
                                                placeholder="ejemplo.usuario" autocomplete="off" required>
                                            <span class="input-group-text bg-light fw-bold text-primary" id="email_domain" style="min-width: 130px; justify-content: center;">
                                                @docente.com
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="alert alert-info border-0 shadow-sm mb-0">
                                            <i class="bi bi-info-circle me-2"></i>
                                            La contraseña se generará automáticamente con el formato: <strong>SistemaNombreCompletoDelUsuario!</strong>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4 border-top pt-4 d-flex justify-content-end gap-3">
                                        <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4">Cancelar</a>
                                        <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                            <i class="bi bi-save me-1"></i> Registrar Usuario
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rolSelect = document.getElementById('rol_select');
            const emailDomain = document.getElementById('email_domain');
            const emailInput = document.getElementById('email_username');

            rolSelect.addEventListener('change', function() {
                emailDomain.textContent = (this.value === 'admin') ? '@admin.com' : '@docente.com';
            });

            emailInput.addEventListener('input', function() {
                let valor = this.value.toLowerCase().replace(/\s+/g, '');
                if (valor.includes('@')) valor = valor.split('@')[0];
                this.value = valor;
            });
        });
    </script>
@endsection