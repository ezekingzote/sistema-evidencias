@extends('layouts.main')

@section('titulo', $titulo)

@section('contenido')

    <main id="main" class="main">

        <div class="pagetitle">

            <h1 class="fw-bold text-primary">
                Configuración de PDF
            </h1>

            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#">
                            Home
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Configuración PDF
                    </li>
                </ol>
            </nav>

        </div>

        <section class="section">

            <div class="row">

                <div class="col-lg-12">

                    @if (session('success'))
                        <div class="alert alert-success shadow-sm border-0">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="card border-0 shadow-lg">

                        <div class="card-header bg-primary text-white py-3">

                            <h4 class="mb-0 fw-bold">
                                Personalización de Reportes PDF
                            </h4>

                        </div>

                        <div class="card-body p-4">

                            <form action="{{ route('imagenes.update') }}" method="POST"
                                enctype="multipart/form-data">

                                @csrf

                                <div class="row g-4">

                                    {{-- HEADER --}}
                                    <div class="col-md-6">

                                        <div class="pdf-card">

                                            <h5 class="fw-bold mb-3">
                                                Encabezado PDF
                                            </h5>

                                            <img src="{{ asset('img/header-pdf-cb.png') }}" class="img-fluid previewPdf">

                                            <input type="file" name="header" class="form-control mt-3">

                                        </div>

                                    </div>

                                    {{-- FOOTER --}}
                                    <div class="col-md-6">

                                        <div class="pdf-card">

                                            <h5 class="fw-bold mb-3">
                                                Pie de Página PDF
                                            </h5>

                                            <img src="{{ asset('img/footer-pdf-cb.png') }}" class="img-fluid previewPdf">

                                            <input type="file" name="footer" class="form-control mt-3">

                                        </div>

                                    </div>

                                    {{-- FIRMA --}}
                                    <div class="col-md-6">

                                        <div class="pdf-card">

                                            <h5 class="fw-bold mb-3">
                                                Firma
                                            </h5>

                                            <img src="{{ asset('img/firma-cb.png') }}" class="img-fluid firmaPreview">

                                            <input type="file" name="firma" class="form-control mt-3">

                                        </div>

                                    </div>

                                    {{-- SELLO --}}
                                    <div class="col-md-6">

                                        <div class="pdf-card">

                                            <h5 class="fw-bold mb-3">
                                                Sello
                                            </h5>

                                            <img src="{{ asset('img/sello-cb.png') }}" class="img-fluid firmaPreview">

                                            <input type="file" name="sello" class="form-control mt-3">

                                        </div>

                                    </div>

                                </div>

                                <div class="text-end mt-4">

                                    <button type="submit" class="btn btn-primary px-5">

                                        <i class="bi bi-save-fill me-2"></i>
                                        Guardar Cambios

                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

    <style>
        .pdf-card {

            border: 1px solid #e5e7eb;
            border-radius: 20px;
            padding: 20px;
            background: white;
            height: 100%;

        }

        .previewPdf {

            width: 100%;
            min-height: 120px;
            object-fit: contain;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 10px;
            background: #fafafa;

        }

        .firmaPreview {

            width: 250px;
            max-height: 180px;
            object-fit: contain;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 10px;
            background: #fafafa;

        }
    </style>

@endsection
