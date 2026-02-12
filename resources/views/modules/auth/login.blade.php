@extends('layouts.login')

@section('titulo', $titulo)
@section('contenido')
    <main>
        <div class="container">

            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="#" class="logo d-flex align-items-center w-auto">
                                    <img src="assets/img/logo.png" alt="">
                                    <span class="d-none d-lg-block">SISTEMA DE EVIDENCIAS</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2 text-center">
                                        <h5
                                            class="card-title pb-0 fs-4 d-flex justify-content-center align-items-center gap-2">
                                            LOGIN DE USUARIOS

                                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-circle"
                                                data-bs-toggle="modal" data-bs-target="#manualLogin" title="Ver manual">
                                                ?
                                            </button>
                                        </h5>

                                        <p class="small">Ingresa tu correo y contraseña para acceder</p>
                                    </div>

                                    <form class="row g-3 needs-validation" novalidate method="POST"
                                        action="{{ route('logear') }}">
                                        @csrf
                                        <div class="col-12">
                                            <label for="email" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="email" class="form-control" id="email"
                                                    required>
                                                <div class="invalid-feedback">Ingresa tu correo</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="password"
                                                required>
                                            <div class="invalid-feedback">Escribe tu contraseña</div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>
                                    <!--validacion que viene de logear-->
                                    <div>
                                        @if ($errors->any())
                                        @endif
                                        <p>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        </p>

                                    </div>

                                </div>
                            </div>

                            <div class="credits">
                                Designed by <a target="_blank" href="https://github.com/ezekingzote">EZEQUIEL</a> WITH <a
                                    target="_blank" href="https://github.com/JuanDlc10">JUAN </a>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Modal Manual Login -->
                <div class="modal fade" id="manualLogin" tabindex="-1" aria-labelledby="manualLoginLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-body">

                            <div class="text-center mb-3">
                                <img src="{{ asset('Manual/login-step1.png') }}" class="img-fluid rounded shadow-sm"
                                    alt="Paso 1 Login">
                            </div>

                            <div class="alert alert-primary">
                                <strong>Paso 1:</strong> Escribe el correo asignado por el administrador.
                            </div>

                            <div class="text-center mb-3">
                                <img src="{{ asset('Manual/login-step2.png') }}" class="img-fluid rounded shadow-sm"
                                    alt="Paso 2 Login">
                            </div>

                            <div class="alert alert-primary">
                                <strong>Paso 2:</strong> Ingresa tu contraseña.
                            </div>

                            <div class="text-center">
                                <img src="{{ asset('Manual/login-step3.png') }}" class="img-fluid rounded shadow-sm"
                                    alt="Paso 3 Login">
                            </div>

                            <div class="alert alert-success mt-3">
                                <strong>Paso 3:</strong> Haz clic en el botón Login.
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main><!-- End #main -->

@endsection
