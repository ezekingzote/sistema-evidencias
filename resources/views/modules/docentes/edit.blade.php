@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

<main id="main" class="main">

    <div class="pagetitle mb-4">
        <h1 class="fw-bold text-primary">
            Modificar Usuario
        </h1>

        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none text-secondary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('docentes') }}" class="text-decoration-none text-secondary">
                        Docentes
                    </a>
                </li>
                <li class="breadcrumb-item active text-primary fw-semibold">
                    Editar Registro
                </li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row justify-content-center">

            <div class="col-lg-10">

                <div class="card border-0 shadow-lg usuario-card">

                    {{-- HEADER --}}
                    <div class="card-header usuario-header">

                        <div class="d-flex align-items-center">

                            <div class="header-icon me-3">
                                <i class="bi bi-pencil-square"></i>
                            </div>

                            <div>
                                <h4 class="fw-bold mb-1 text-dark">
                                    Editor de Usuario
                                </h4>

                                <p class="text-muted mb-0">
                                    Editando a:
                                    <strong>
                                        {{ $item->name }} {{ $item->apellido_p }}
                                    </strong>
                                </p>
                            </div>

                        </div>

                    </div>

                    {{-- BODY --}}
                    <div class="card-body p-4 p-lg-5">

                        <form
                            action="{{ route('docentes.update', $item->id) }}"
                            id="formUsuario"
                            method="POST"
                            class="needs-validation">
                            @csrf
                            @method('PUT')

                            {{-- NOMBRE --}}
                            <div class="col-md-12">

                                <label class="form-label fw-bold">
                                    <i class="bi bi-person me-1"></i>
                                    Nombre(s)
                                </label>

                                <input
                                    name="name"
                                    type="text"
                                    class="form-control custom-input"
                                    oninput="this.value = this.value.toUpperCase();"
                                    value="{{ $item->name }}"
                                    required>

                            </div>

                            <div class="row g-4 mt-3">

                                {{-- ROL --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        <i class="bi bi-shield-lock me-1"></i>
                                        Rol de Sistema
                                    </label>

                                    <select
                                        name="rol"
                                        id="rol_select"
                                        class="form-select custom-input"
                                        required>
                                        <option
                                            value="docente"
                                            {{ $item->rol == 'docente' ? 'selected' : '' }}>
                                            DOCENTE
                                        </option>

                                        <option
                                            value="admin"
                                            {{ $item->rol == 'admin' ? 'selected' : '' }}>
                                            ADMINISTRADOR
                                        </option>

                                    </select>

                                </div>

                                {{-- DEPARTAMENTO --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        Departamento
                                    </label>

                                    <select
                                        name="dpto"
                                        id="dpto"
                                        class="form-select custom-input"
                                        required>

                                        <option value="" disabled>
                                            SELECCIONA UN DEPARTAMENTO
                                        </option>

                                        <option
                                            value="Ciencias Económico-Administrativas"
                                            {{ $item->departamento == 'Ciencias Económico-Administrativas' ? 'selected' : '' }}>
                                            CIENCIAS ECONÓMICO-ADMINISTRATIVAS
                                        </option>

                                        <option
                                            value="Ciencias Básicas y Sistemas"
                                            {{ $item->departamento == 'Ciencias Básicas y Sistemas' ? 'selected' : '' }}>
                                            CIENCIAS BÁSICAS Y SISTEMAS
                                        </option>

                                        <option
                                            value="Departamento de Ingenierías"
                                            {{ $item->departamento == 'Departamento de Ingenierías' ? 'selected' : '' }}>
                                            DEPARTAMENTO DE INGENIERÍAS
                                        </option>

                                    </select>

                                </div>

                                {{-- EMAIL --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        <i class="bi bi-envelope me-1"></i>
                                        Correo Usuario
                                    </label>

                                    <div class="input-group">

                                        <input
                                            name="email"
                                            id="email_username"
                                            type="text"
                                            class="form-control custom-input"
                                            autocomplete="off"
                                            value="{{ explode('@', $item->email)[0] }}"
                                            required>

                                        <span
                                            class="input-group-text fw-bold text-primary bg-white"
                                            id="email_domain">
                                            {{ str_contains($item->email, '@admin') ? '@admin.com' : '@docente.com' }}
                                        </span>

                                    </div>

                                    <small class="text-muted">
                                        El dominio cambia según el rol seleccionado.
                                    </small>

                                </div>

                                {{-- CELULAR --}}
                                <div class="col-md-6">

                                    <label class="form-label fw-bold">
                                        <i class="bi bi-phone me-1"></i>
                                        Celular
                                    </label>

                                    <input
                                        type="text"
                                        name="celular"
                                        id="celular"
                                        class="form-control custom-input"
                                        placeholder="5512345678"
                                        maxlength="10"
                                        autocomplete="off"
                                        value="{{ $item->celular }}"
                                        required>

                                </div>


                                {{-- BOTONES --}}
                                <div class="col-12 mt-5">

                                    <div class="d-flex justify-content-end gap-3">

                                        <a
                                            href="{{ route('docentes') }}"
                                            class="btn btn-outline-secondary px-4 rounded-pill">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Cancelar
                                        </a>

                                        <button
                                            type="submit"
                                            class="btn btn-warning px-5 rounded-pill shadow-sm fw-bold text-dark">
                                            <i class="bi bi-arrow-clockwise me-1"></i>
                                            Actualizar Registro
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
        background: linear-gradient(135deg, #fffdf5, #fff7db);
        border-bottom: 1px solid #f5ebc8;
        padding: 30px;
    }

    .header-icon {
        width: 64px;
        height: 64px;
        border-radius: 18px;
        background: linear-gradient(135deg, #ffc107, #ffd95e);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #212529;
        font-size: 26px;
        box-shadow: 0 10px 25px rgba(255, 193, 7, 0.18);
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
        border-color: #ffc107;
        box-shadow: 0 0 0 0.15rem rgba(255, 193, 7, 0.18);
    }

    .btn {
        transition: 0.25s;
        font-weight: 600;
    }

    .btn:hover {
        transform: translateY(-2px);
    }

    .btn-warning:hover {
        box-shadow: 0 10px 20px rgba(255, 193, 7, 0.20);
    }

    label {
        color: #495057;
        margin-bottom: 8px;
    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const rolSelect = document.getElementById('rol_select');
        const emailDomain = document.getElementById('email_domain');
        const emailInput = document.getElementById('email_username');

        rolSelect.addEventListener('change', function() {
            emailDomain.textContent =
                this.value === 'admin' ?
                '@admin.com' :
                '@docente.com';
        });

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

    const celular = document.getElementById('celular');

    celular.addEventListener('input', function() {

        this.value = this.value
            .replace(/\D/g, '')
            .substring(0, 10);

    });
</script>

@endsection