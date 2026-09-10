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
                                <div class="alert alert-danger mt-3 rounded-3 shadow-sm">
                                    <ul class="mb-0 ps-3">
                                        @foreach ($errors->all() as $error)
                                            <li><small>{{ $error }}</small></li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="text-center pt-4 mt-2">
                                <a class="text-secondary text-decoration-none d-inline-flex align-items-center fw-semibold small" href="#" data-bs-toggle="modal" data-bs-target="#modalManualLogin">
                                    <i class="fa fa-question-circle me-1 fs-5 text-success"></i> 
                                    <span class="hover-text-success">¿Necesitas ayuda para ingresar?</span>
                                </a>
                            </div>
                            
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('modules.auth.manual') 
    <style>
        .hover-text-success { transition: color 0.3s ease; }
        a:hover .hover-text-success { color: #198754; /* success color en Bootstrap */ }
    </style>
@endsection