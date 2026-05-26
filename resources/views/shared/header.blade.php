<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('NiceAdmin/assets/img/logo.png') }}" alt="">
            <span class="d-none d-lg-block">Sistema Evidencias</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>

    </div><!-- End Logo -->

    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
        <i class="bi bi-bell"></i>
        @if(Auth::user()->unreadNotifications->count() > 0)
        <span class="badge bg-primary badge-number">{{ Auth::user()->unreadNotifications->count() }}</span>
        @endif
    </a>

    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
        <li class="dropdown-header">
            Tienes {{ Auth::user()->unreadNotifications->count() }} notificaciones nuevas
        </li>

        @foreach(Auth::user()->unreadNotifications as $notificacion)
        <li>
            <hr class="dropdown-divider">
        </li>
        <li class="notification-item">
            <i class="bi {{ $notificacion->data['icono'] }}"></i>
            <div>
                <h4>{{ $notificacion->data['mensaje'] }}</h4>
                <a href="{{ $notificacion->data['url'] }}">Ver detalles</a>
                <p>{{ $notificacion->created_at->diffForHumans() }}</p>
            </div>
        </li>
        @endforeach

        <li>
            <hr class="dropdown-divider">
        </li>
        <li class="dropdown-footer">
            <a href="{{ route('marcar-leidas') }}">Marcar todas como leídas</a>
        </li>
    </ul>



    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown">




            </li><!-- End Notification Nav -->

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        {{ Auth::user()->name }}
                    </span>

                    <img src="{{ asset('NiceAdmin/assets/img/profile-img.jpg') }}"
                        alt="Profile"
                        class="rounded-circle ms-2">
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ Auth::user()->name }}</h6>
                        <span>{{ Auth::user()->rol }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                            data-bs-target="#modalPassword">
                            <i class="bi bi-key"></i>
                            <span>Cambiar Contraseña</span>
                        </a>
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Cerrar Sesión</span>
                        </a>
                    </li>


                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->