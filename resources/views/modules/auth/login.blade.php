@extends('layouts.login')

@section('titulo', $titulo)

@section('contenido')
    <main>
        <section class="min-vh-100 d-flex align-items-center justify-content-center">
            <div class="limiter w-100">
                <div class="container-login100">
                    <div class="wrap-login100 d-flex align-items-center justify-content-center">
                        <div class="login100-pic js-tilt" data-tilt>
                            <img src="{{ asset('Login/img-01.png') }}" alt="Login Image">
                        </div>
                        <form class="login100-form validate-form" method="POST" action="{{ route('logear') }}">
                            @csrf

                            <span class="login100-form-title">
                                LOGIN DE USUARIO
                            </span>
                            <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                                <input class="input100" type="text" name="email" placeholder="Email"
                                    value="{{ old('email') }}">
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                </span>
                            </div>
                            <div class="wrap-input100 validate-input" data-validate="Password is required">
                                <input class="input100" type="password" name="password" placeholder="Password">
                                <span class="focus-input100"></span>
                                <span class="symbol-input100">
                                    <i class="fa fa-lock" aria-hidden="true"></i>
                                </span>
                            </div>

                            <!-- Botón -->
                            <div class="container-login100-form-btn">
                                <button class="login100-form-btn" type="submit">
                                    Login
                                </button>
                            </div>

                            <!-- Errores -->
                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="mt-4">
                                <div class="alert alert-primary d-flex align-items-center rounded-3 shadow-sm py-1 px-2 mb-0"
                                    style="font-size: 12px;">

                                    <div class="me-2 d-flex align-items-center justify-content-center bg-primary text-white rounded-circle"
                                        style="width:22px; height:22px; font-size:11px;">
                                        <i class="fa fa-question"></i>
                                    </div>

                                    <div class="flex-grow-1">
                                        ¿Necesitas ayuda?
                                        <a href="#" data-bs-toggle="modal" data-bs-target="#manualLogin"
                                            class="fw-semibold text-decoration-underline">
                                            Ver manual de inicio de sesión
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </main>
    <div class="modal fade" id="manualLogin" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content rounded-4 shadow-lg">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">
                        Manual de Inicio de Sesión
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body px-4 pb-4" style="max-height: 75vh; overflow-y: auto;">
                    <div class="mb-4">
                        <img src="{{ asset('Manual/login-step1.png') }}" class="img-fluid rounded shadow-sm w-100"
                            alt="Paso 1 Login">
                        <div class="alert alert-primary mt-3 text-center">
                            <strong>Paso 1:</strong> Escribe tu correo electrónico.
                        </div>
                    </div>
                    <div class="mb-4">
                        <img src="{{ asset('Manual/login-step2.png') }}" class="img-fluid rounded shadow-sm w-100"
                            alt="Paso 2 Login">
                        <div class="alert alert-primary mt-3 text-center">
                            <strong>Paso 2:</strong> Ingresa tu contraseña.
                        </div>
                    </div>
                    <div class="mb-2">
                        <img src="{{ asset('Manual/login-step3.png') }}" class="img-fluid rounded shadow-sm w-100"
                            alt="Paso 3 Login">
                        <div class="alert alert-success mt-3 text-center">
                            <strong>Paso 3:</strong> Haz clic en el botón Login.
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

@endsection
