<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
    <div class="container-fluid">
        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
            <li class="nav-item topbar-icon dropdown hidden-caret">
                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <x-heroicon-o-printer style="width: 20px; height: 20px; color: gray;" class="me-1" />
                </a>
                <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li>
                        <div class="dropdown-title">
                            Herramientas
                        </div>
                    </li>
                    <li>
                        <div class="notif-scroll scrollbar-outer">
                            <div class="notif-center">
                                <a href="{{ route('formats.index') }}">
                                    <div class="notif-icon notif-primary">
                                        <x-heroicon-o-document-text style="width: 20px; height: 20px;" />
                                    </div>
                                    <div class="notif-content">
                                        <span class="block"> Formato de trabajo </span>
                                        <span class="text-xs opacity-50 text-muted">Ver formatos hechos en línea</span>
                                    </div>
                                </a>
                                <a href="{{ route('formats.work_format') }}">
                                    <div class="notif-icon notif-danger">
                                        <x-heroicon-o-document-text style="width: 20px; height: 20px;" />
                                    </div>
                                    <div class="notif-content">
                                        <span class="block"> Imprimir formato de trabajo </span>
                                        <span class="text-xs opacity-50 text-muted">Acceso directo a impresión</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                    <div class="avatar-sm">
                        <img src="{{ Storage::url('assets/img/profile.jpg') }}" alt="..."
                            class="avatar-img rounded-circle" />
                    </div>
                    <span class="profile-username">
                        <span class="op-7">Hola,</span>
                        <span class="fw-bold text-muted">Usuario (X)</span>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                    <div class="dropdown-user-scroll scrollbar-outer">
                        <li>
                            <div class="user-box">
                                <div class="avatar-lg">
                                    <img src="{{ Storage::url('assets/img/profile.jpg') }}" alt="image profile"
                                        class="avatar-img rounded" />
                                </div>
                                <div class="u-text">
                                    <h4>Usuario (X)</h4>
                                    <p class="text-muted">hello@example.com</p>
                                    <a href="/" class="btn btn-xs btn-secondary btn-sm">Ver perfil</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Cerrar sesión</a>
                        </li>
                    </div>
                </ul>
            </li>
        </ul>
    </div>
</nav>