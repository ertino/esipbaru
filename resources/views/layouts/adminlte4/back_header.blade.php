<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">

        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <div class="container-fluid">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button" aria-label="{{ __('Buka Menu') }}">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <li class="nav-item d-none d-md-block">
                        <span class="nav-link">{{ __('Bantuan') }}</span>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarUserDropdown" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>{{ $nama_user ?? Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserDropdown">
                            <li>
                                @if (Auth::user()->role !== 'nakes')
                                    <a href="{{ route('admin.profile') }}" class="dropdown-item">
                                        <i class="bi bi-person me-2"></i>{{ __('Profile') }}
                                    </a>
                                @else
                                    <a href="{{ route('nakes.profile') }}" class="dropdown-item">
                                        <i class="bi bi-person me-2"></i>{{ __('Profile') }}
                                    </a>
                                @endif
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-2"></i>{{ __('Logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!--end::Header-->

        @include('layouts.adminlte4.back_sidebar')

        <!--begin::Main-->
        <main class="app-main">
