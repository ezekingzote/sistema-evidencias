@extends('layouts.main')

@section('titulo', 'Registrar Usuario')

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">
            Gestión de Usuarios
        </h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    Usuarios
                </li>
                <li class="breadcrumb-item active text-primary fw-semibold">
                    Nuevo Registro
                </li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">

            <div class="col-lg-11">

                <div class="card border-0 shadow-lg usuario-card">

                    {{-- HEADER --}}
                    <div class="card-header usuario-header">

                        <div class="d-flex align-items-center">

                            <div class="header-icon me-3">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>

                            <div>
                                <h4 class="fw-bold mb-1 text-dark">
                                    Datos del Nuevo Usuario
                                </h4>

                                <p class="text-muted mb-0">
                                    Complete la información para registrar un nuevo docente o administrador
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4 p-lg-5">

                        <form action="{{ route('docente.store') }}" method="POST">
                            @csrf

                            <div class="row g-4">

                                {{-- NOMBRE --}}
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        Nombre(s)
                                    </label>

                                    <input type="text" name="name" class="form-control custom-input"
                                        placeholder="NOMBRE" style="text-transform: uppercase;" required>
                                </div>

                                {{-- APELLIDO PATERNO --}}
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        Apellido Paterno
                                    </label>

                                    <input type="text" name="apellido_p" class="form-control custom-input"
                                        placeholder="APELLIDO PATERNO" style="text-transform: uppercase;" required>
                                </div>

                                {{-- APELLIDO MATERNO --}}
                                <div class="col-md-4">
                                    <label class="form-label fw-bold">
                                        Apellido Materno
                                    </label>

                                    <input type="text" name="apellido_m" class="form-control custom-input"
                                        placeholder="APELLIDO MATERNO" style="text-transform: uppercase;">
                                </div>

                                {{-- ROL --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Rol de Usuario
                                    </label>

                                    <select name="rol" id="rol_select" class="form-select custom-input" required>
                                        <option value="docente" {{ old('rol') == 'docente' ? 'selected' : '' }}>
                                            DOCENTE
                                        </option>

                                        <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>
                                            ADMINISTRADOR
                                        </option>
                                    </select>
                                </div>

                                {{-- CARGO ADMIN --}}
                                <div class="col-md-6" id="cargo_container" style="display: none;">

                                    <label class="form-label fw-bold">
                                        Cargo del Administrador
                                    </label>

                                    <input type="text"
                                        name="cargo"
                                        id="cargo"
                                        class="form-control custom-input"
                                        placeholder="JEFE DEL DEPARTAMENTO DE CIENCIAS BÁSICAS"
                                        style="text-transform: uppercase;">

                                </div>

                                {{-- DEPARTAMENTO --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Departamento
                                    </label>

                                    <select name="dpto" id="dpto" class="form-select custom-input" required>
                                        <option value="" selected disabled>
                                            SELECCIONA UN DEPARTAMENTO
                                        </option>

                                        <option value="Ciencias Económico-Administrativas">
                                            CIENCIAS ECONÓMICO-ADMINISTRATIVAS
                                        </option>

                                        <option value="Ciencias Básicas y Sistemas">
                                            CIENCIAS BÁSICAS Y SISTEMAS
                                        </option>

                                        <option value="Departamento de Ingenierías">
                                            DEPARTAMENTO DE INGENIERÍAS
                                        </option>
                                    </select>
                                </div>

                                {{-- CORREO --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">
                                        Correo Electrónico (Usuario)
                                    </label>

                                    <div class="input-group">

                                        <input type="text" name="email" id="email_username"
                                            class="form-control custom-input" placeholder="ejemplo.usuario"
                                            autocomplete="off" required>

                                        <span class="input-group-text fw-bold text-primary bg-white" id="email_domain"
                                            style="min-width: 140px; justify-content: center;">
                                            @docente.com
                                        </span>

                                    </div>

                                    <small class="text-muted">
                                        El dominio cambia automáticamente según el rol seleccionado.
                                    </small>
                                </div>

                                {{-- CELULAR --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Número de Celular
                                    </label>

                                    <div class="input-group">

                                        <span class="input-group-text bg-white text-success fw-bold"
                                            style="
                                                border-radius: 12px 0 0 12px;
                                                border-right: none;
                                            ">
                                            <i class="bi bi-whatsapp me-2"></i>
                                            +52
                                        </span>

                                        <input type="text" name="celular" id="celular"
                                            class="form-control custom-input" placeholder="5512345678" maxlength="10"
                                            autocomplete="off" required
                                            style="
                border-left: none;
                border-radius: 0 12px 12px 0 !important;
            ">

                                    </div>

                                    <small class="text-muted">
                                        Ingresa únicamente 10 dígitos.
                                    </small>

                                </div>

                                {{-- BOTONES --}}
                                <div class="col-12 mt-5">

                                    <div class="d-flex justify-content-end gap-3">

                                        <a href="{{ route('docentes') }}"
                                            class="btn btn-outline-secondary px-4 rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Cancelar
                                        </a>

                                        <button type="submit"
                                            class="btn btn-primary px-5 rounded-pill shadow-sm fw-bold">
                                            <i class="bi bi-save me-1"></i>
                                            Registrar Usuario
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
    .usuario-card {
        border-radius: 22px;
        overflow: hidden;
        background: #ffffff;
    }

    .usuario-header {
        background: linear-gradient(135deg, #f8fbff, #eef5ff);
        border-bottom: 1px solid #e8eef7;
        padding: 30px;
    }

    .header-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, #0d6efd, #4da3ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 26px;
        box-shadow: 0 10px 25px rgba(13, 110, 253, 0.18);
        flex-shrink: 0;
    }

    .custom-input {
        min-height: 50px;
        border-radius: 12px !important;
        border: 1px solid #dee2e6;
        padding-left: 14px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.15);
    }

    .btn {
        transition: 0.25s;
        font-weight: 600;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-primary:hover {
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.20);
    }

    label {
        color: #495057;
        margin-bottom: 8px;
    }
</style>


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const rolSelect = document.getElementById('rol_select');
        const emailDomain = document.getElementById('email_domain');
        const emailInput = document.getElementById('email_username');

        const cargoContainer = document.getElementById('cargo_container');
        const cargoInput = document.getElementById('cargo');

        function actualizarRol() {

            if (rolSelect.value === 'admin') {

                emailDomain.textContent = '@admin.com';

                cargoContainer.style.display = 'block';

                cargoInput.required = true;

                cargoInput.value = '';

                cargoInput.placeholder = 'JEFE DEL DEPARTAMENTO DE CIENCIAS BÁSICAS';

            }else {

            emailDomain.textContent = '@docente.com';

            cargoContainer.style.display = 'none';

            cargoInput.required = false;

            cargoInput.value = 'DOCENTE';
        }
    }

    actualizarRol();

    rolSelect.addEventListener('change', actualizarRol);

    emailInput.addEventListener('input', function() {

        let valor = this.value
            .toLowerCase()
            .replace(/\s+/g, '');

        if (valor.includes('@')) {
            valor = valor.split('@')[0];
        }

        this.value = valor;
    });

    });
</script>
@endpush

@endsection