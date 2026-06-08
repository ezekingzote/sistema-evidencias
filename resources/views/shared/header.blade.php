<header id="header" class="header fixed-top d-flex align-items-center">

    @php
        $user = Auth::user();
        $rolUsuario = strtolower($user->rol);

        $tienePerfilDocente = $user->docente && (int) $user->docente->activo === 1;

        $panelActivo = session(
            'panel_activo',
            $rolUsuario === 'admin' ? 'admin' : 'docente'
        );

        if ($panelActivo === 'docente' && !$tienePerfilDocente) {
            $panelActivo = 'admin';
        }

        $rutaInicio = $panelActivo === 'admin' ? 'home' : 'dashboard';
    @endphp

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route($rutaInicio) }}" class="logo d-flex align-items-center">
            <img src="{{ asset('NiceAdmin/assets/img/logo.png') }}" alt="">
            <span class="d-none d-lg-block">Sistema Evidencias</span>
        </a>

        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-bell"></i>

                    @if ($user->unreadNotifications->count() > 0)
                        <span class="badge bg-primary badge-number">
                            {{ $user->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">

                    <li class="dropdown-header">
                        Tienes {{ $user->unreadNotifications->count() }} notificaciones nuevas
                    </li>

                    @forelse ($user->unreadNotifications as $notificacion)
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi {{ $notificacion->data['icono'] ?? 'bi-info-circle' }}"></i>

                            <div>
                                <h4>{{ $notificacion->data['mensaje'] ?? 'Nueva notificación' }}</h4>

                                @if (isset($notificacion->data['url']))
                                    <a href="{{ $notificacion->data['url'] }}">Ver detalles</a>
                                @endif

                                <p>{{ $notificacion->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @empty
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li class="notification-item">
                            <i class="bi bi-check-circle text-success"></i>

                            <div>
                                <h4>Sin notificaciones</h4>
                                <p>No tienes notificaciones nuevas</p>
                            </div>
                        </li>
                    @endforelse

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li class="dropdown-footer">
                        <a href="{{ route('marcar-leidas') }}">Marcar todas como leídas</a>
                    </li>

                </ul>
            </li>

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        {{ $user->name }}
                    </span>

                    <img src="{{ asset('NiceAdmin/assets/img/user.png') }}" alt="Profile" class="rounded-circle ms-2">
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                    <li class="dropdown-header">
                        <h6>{{ $user->name }}</h6>

                        @if ($rolUsuario === 'admin')
                            <span>
                                ADMINISTRADOR
                                @if ($tienePerfilDocente)
                                    /
                                    {{ $panelActivo === 'admin' ? 'PANEL ADMIN' : 'PANEL DOCENTE' }}
                                @endif
                            </span>
                        @else
                            <span>DOCENTE</span>
                        @endif
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    @if ($rolUsuario === 'admin')

                        @if ($panelActivo !== 'admin')
                            <li>
                                <form method="POST" action="{{ route('cambiar.panel', 'admin') }}">
                                    @csrf

                                    <button type="submit"
                                        class="dropdown-item d-flex align-items-center text-danger fw-bold">
                                        <i class="bi bi-shield-lock"></i>
                                        <span>Modo Administrador</span>
                                    </button>
                                </form>
                            </li>
                        @endif

                        @if ($tienePerfilDocente && $panelActivo !== 'docente')
                            <li>
                                <form method="POST" action="{{ route('cambiar.panel', 'docente') }}">
                                    @csrf

                                    <button type="submit"
                                        class="dropdown-item d-flex align-items-center text-primary fw-bold">
                                        <i class="bi bi-person-badge"></i>
                                        <span>Modo Docente</span>
                                    </button>
                                </form>
                            </li>
                        @endif

                        @if ($tienePerfilDocente || $panelActivo !== 'admin')
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endif

                    @endif

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal"
                            data-bs-target="#modalPassword">
                            <i class="bi bi-key"></i>
                            <span>Cambiar Contraseña</span>
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Cerrar Sesión</span>
                        </a>
                    </li>

                </ul>
            </li>

        </ul>
    </nav>

</header>