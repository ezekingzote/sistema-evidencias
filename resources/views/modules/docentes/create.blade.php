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

                        <div class="card-body p-4 p-lg-5">

                            @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Revisa los siguientes campos:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('docente.store') }}" method="POST">
                                @csrf

                                <div class="row g-4">

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            Nombre(s)
                                        </label>

                                        <input type="text" name="name" class="form-control custom-input"
                                            placeholder="NOMBRE" value="{{ old('name') }}"
                                            style="text-transform: uppercase;" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            Apellido Paterno
                                        </label>

                                        <input type="text" name="apellido_p" class="form-control custom-input"
                                            placeholder="APELLIDO PATERNO" value="{{ old('apellido_p') }}"
                                            style="text-transform: uppercase;" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-bold">
                                            Apellido Materno
                                        </label>

                                        <input type="text" name="apellido_m" class="form-control custom-input"
                                            placeholder="APELLIDO MATERNO" value="{{ old('apellido_m') }}"
                                            style="text-transform: uppercase;">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">
                                            Rol de Usuario
                                        </label>

                                        <select name="rol" id="rol_select" class="form-select custom-input" required>
                                            <option value="docente"
                                                {{ old('rol', 'docente') == 'docente' ? 'selected' : '' }}>
                                                DOCENTE
                                            </option>

                                            <option value="admin" {{ old('rol') == 'admin' ? 'selected' : '' }}>
                                                ADMINISTRADOR
                                            </option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 d-none" id="perfil_docente_container">
                                        <label class="form-label fw-bold">
                                            Perfil Docente
                                        </label>

                                        <div class="border rounded-3 px-3 py-2 bg-light perfil-docente-box">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="perfil_docente"
                                                    id="perfil_docente" value="1"
                                                    {{ old('perfil_docente') ? 'checked' : '' }}>

                                                <label class="form-check-label fw-semibold" for="perfil_docente">
                                                    Este administrador también es docente
                                                </label>
                                            </div>

                                            <small class="text-muted">
                                                Activa esta opción si el administrador también impartirá materias.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-md-6" id="cargo_container" style="display: none;">

                                        <label class="form-label fw-bold">
                                            Cargo del Administrador
                                        </label>

                                        <input type="text" name="cargo" id="cargo"
                                            class="form-control custom-input"
                                            placeholder="JEFE DEL DEPARTAMENTO DE CIENCIAS BÁSICAS"
                                            value="{{ old('cargo') }}" style="text-transform: uppercase;">

                                        <small class="text-muted">
                                            Este cargo se guardará en el perfil del administrador.
                                        </small>

                                    </div>

                                    <div class="col-md-6" id="correo_container">
                                        <label class="form-label fw-bold">
                                            Correo Electrónico (Usuario)
                                        </label>

                                        <input type="email" name="email" id="email_username"
                                            class="form-control custom-input" placeholder="usuario@itma.edu.mx"
                                            value="{{ old('email') }}" required>
                                    </div>

                                    <div class="col-12" id="datos_docente_container">
                                        <div class="row g-4">

                                            <div class="col-md-6">
                                                <label class="form-label fw-bold">
                                                    Departamento
                                                </label>

                                                <select name="dpto" id="dpto" class="form-select custom-input">
                                                    <option value="" selected disabled>
                                                        SELECCIONA UN DEPARTAMENTO
                                                    </option>

                                                    <option value="Ciencias Económico-Administrativas"
                                                        {{ old('dpto') == 'Ciencias Económico-Administrativas' ? 'selected' : '' }}>
                                                        CIENCIAS ECONÓMICO-ADMINISTRATIVAS
                                                    </option>

                                                    <option value="Ciencias Básicas y Sistemas"
                                                        {{ old('dpto') == 'Ciencias Básicas y Sistemas' ? 'selected' : '' }}>
                                                        CIENCIAS BÁSICAS Y SISTEMAS
                                                    </option>

                                                    <option value="Departamento de Ingenierías"
                                                        {{ old('dpto') == 'Departamento de Ingenierías' ? 'selected' : '' }}>
                                                        DEPARTAMENTO DE INGENIERÍAS
                                                    </option>
                                                </select>
                                            </div>

                                            <div class="col-md-6">

                                                <label class="form-label fw-bold">
                                                    Número de Celular
                                                </label>

                                                <div class="input-group">

                                                    <span class="input-group-text bg-white text-success fw-bold phone-prefix">
                                                        <i class="bi bi-whatsapp me-2"></i>
                                                        +52
                                                    </span>

                                                    <input type="text" name="celular" id="celular"
                                                        class="form-control custom-input phone-input"
                                                        placeholder="5512345678" maxlength="10" autocomplete="off"
                                                        value="{{ old('celular') }}">

                                                </div>

                                                <small class="text-muted">
                                                    Ingresa únicamente 10 dígitos.
                                                </small>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 mt-5">

                                        <div class="d-flex justify-content-end gap-3 flex-wrap">

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

        .perfil-docente-box {
            min-height: 76px;
        }

        .phone-prefix {
            border-radius: 12px 0 0 12px;
            border-right: none;
            min-height: 50px;
        }

        .phone-input {
            border-left: none;
            border-radius: 0 12px 12px 0 !important;
        }

        @media (max-width: 768px) {
            .usuario-header {
                padding: 24px;
            }

            .header-icon {
                width: 56px;
                height: 56px;
                font-size: 23px;
            }

            .card-body {
                padding: 24px !important;
            }
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const rolSelect = document.getElementById('rol_select');
                const perfilDocenteContainer = document.getElementById('perfil_docente_container');
                const perfilDocente = document.getElementById('perfil_docente');

                const datosDocenteContainer = document.getElementById('datos_docente_container');
                const cargoContainer = document.getElementById('cargo_container');

                const dpto = document.getElementById('dpto');
                const celular = document.getElementById('celular');
                const cargo = document.getElementById('cargo');

                function mostrarElemento(elemento) {
                    elemento.classList.remove('d-none');
                    elemento.style.display = '';
                }

                function ocultarElemento(elemento) {
                    elemento.classList.add('d-none');
                }

                function aplicarReglasFormulario() {
                    const rol = rolSelect.value.toLowerCase();
                    const esDocente = rol === 'docente';
                    const esAdmin = rol === 'admin';
                    const adminTambienDocente = perfilDocente.checked;

                    if (esDocente) {
                        perfilDocente.checked = false;
                        ocultarElemento(perfilDocenteContainer);

                        mostrarElemento(datosDocenteContainer);
                        cargoContainer.style.display = 'none';

                        dpto.setAttribute('required', 'required');
                        celular.setAttribute('required', 'required');

                        cargo.removeAttribute('required');
                        cargo.value = 'DOCENTE';

                        return;
                    }

                    if (esAdmin) {
                        mostrarElemento(perfilDocenteContainer);

                        cargoContainer.style.display = 'block';
                        cargo.setAttribute('required', 'required');

                        if (cargo.value === 'DOCENTE') {
                            cargo.value = '';
                        }

                        if (adminTambienDocente) {
                            mostrarElemento(datosDocenteContainer);

                            dpto.setAttribute('required', 'required');
                            celular.setAttribute('required', 'required');
                        } else {
                            ocultarElemento(datosDocenteContainer);

                            dpto.removeAttribute('required');
                            celular.removeAttribute('required');
                        }
                    }
                }

                rolSelect.addEventListener('change', aplicarReglasFormulario);
                perfilDocente.addEventListener('change', aplicarReglasFormulario);

                celular.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '').slice(0, 10);
                });

                cargo.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });

                aplicarReglasFormulario();
            });
        </script>
    @endpush

@endsection