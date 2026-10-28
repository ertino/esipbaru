@php
    /*
     |--------------------------------------------------------------------------
     | Sidebar (AdminLTE 4)
     |--------------------------------------------------------------------------
     |
     | Port of layouts/minlte/back_sidebar.blade.php: same routes and the same
     | role conditionals, expressed with the AdminLTE 4 markup
     | (.app-sidebar > .sidebar-brand + .sidebar-wrapper > .sidebar-menu).
     |
     */
    $role = Auth::user()->role;
    $brandLogo = file_exists(public_path('images/nakesico.png')) ? asset('images/nakesico.png') : null;
@endphp
<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <a href="{{ url('/') }}" class="brand-link">
            @if ($brandLogo)
                <img src="{{ $brandLogo }}" alt="{{ __('URAT NADI') }}" class="brand-image opacity-75 shadow">
            @else
                <i class="bi bi-heart-pulse-fill fs-4 me-2"></i>
            @endif
            <span class="brand-text fw-light">URAT NADI</span>
        </a>
    </div>
    <!--end::Sidebar Brand-->

    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                @if ($role == 'kadinkes')
                    <li class="nav-item">
                        <a href="{{ route('kadinkes.main.dashboard') }}"
                           class="nav-link {{ request()->routeIs('kadinkes.main.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>{{ __('Dashboard') }}</p>
                        </a>
                    </li>
                @elseif ($role == 'kaptsp')
                    <li class="nav-item">
                        <a href="{{ route('kaptsp.main.dashboard') }}"
                           class="nav-link {{ request()->routeIs('kaptsp.main.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>{{ __('Dashboard') }}</p>
                        </a>
                    </li>
                @elseif ($role == 'superadmin')
                    <li class="nav-item">
                        <a href="{{ route('superadmin.dashboard') }}"
                           class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-person"></i>
                            <p>{{ __('Cari User') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('superadmin.pengajuan') }}"
                           class="nav-link {{ request()->routeIs('superadmin.pengajuan') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-grid"></i>
                            <p>{{ __('Cari Pengajuan') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('superadmin.notifikasi') }}"
                           class="nav-link {{ request()->routeIs('superadmin.notifikasi') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-bell"></i>
                            <p>{{ __('Notifikasi') }}</p>
                        </a>
                    </li>
                @elseif ($role == 'verifptsp')
                    <li class="nav-item">
                        <a href="{{ route('verif.main.dashboard') }}"
                           class="nav-link {{ request()->routeIs('verif.main.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>{{ __('Dashboard') }}</p>
                        </a>
                    </li>
                @elseif ($role == 'bidfarmasidinkes')
                    <li class="nav-item" id="menupencabutan">
                        <a href="{{ route('bidfar.main.dashboard') }}"
                           class="nav-link {{ request()->routeIs('bidfar.main.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-x-circle"></i>
                            <p>
                                {{ __('List Pencabutan') }}
                                <span class="nav-badge badge text-bg-danger" id="hitungpendingcabut"></span>
                            </p>
                        </a>
                    </li>
                @endif

                @if ($role == 'nakes')
                    <li class="nav-item">
                        <a href="{{ route('nakes.dashboard') }}"
                           class="nav-link {{ request()->routeIs('nakes.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-house"></i>
                            <p>{{ __('Beranda') }}</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('nakes.documents') }}"
                           class="nav-link {{ request()->routeIs('nakes.documents') ? 'active' : '' }}">
                            <i class="nav-icon bi bi-file-earmark"></i>
                            <p>{{ __('Dokumen') }}</p>
                        </a>
                    </li>
                @else
                    <li class="nav-item d-none">
                        <a href="{{ route('adminnakes.main.dashboard') }}" class="nav-link">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>{{ __('Dashboard') }}</p>
                        </a>
                    </li>

                    @if ($role == 'admindinkes')
                        <li class="nav-item">
                            <a href="{{ route('get.rekapmapnakes') }}"
                               class="nav-link {{ request()->routeIs('get.rekapmapnakes') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-layers"></i>
                                <p>{{ __('Map Nakes') }}</p>
                            </a>
                        </li>
                    @endif

                    @if ($role != 'faskes' && $role != 'kadinkes' && $role != 'kaptsp' && $role != 'verifptsp' && $role != 'bidfarmasidinkes' && $role != 'superadmin')
                        <li class="nav-item">
                            <a href="{{ route('adminnakes.pemohon') }}"
                               class="nav-link {{ request()->routeIs('adminnakes.pemohon') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person"></i>
                                <p id="menudaftaran">
                                    {{ __('List Pendaftar') }}
                                    <span class="nav-badge badge text-bg-danger" id="hitungpendingdaftar"></span>
                                </p>
                            </a>
                        </li>
                    @endif

                    <li class="nav-item">
                        @if ($role == 'admindinkes')
                            <a href="{{ route('admindinkes.main.dashboard') }}"
                               class="nav-link {{ request()->routeIs('admindinkes.main.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-grid"></i>
                                <p>
                                    {{ __('List Pengajuan') }}
                                    <span class="nav-badge badge text-bg-danger" id="hitungpendingaju"></span>
                                </p>
                            </a>
                        @elseif ($role == 'adminptsp')
                            <a href="{{ route('adminptsp.main.dashboard') }}"
                               class="nav-link {{ request()->routeIs('adminptsp.main.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-grid"></i>
                                <p>
                                    {{ __('List Pengajuan') }}
                                    <span class="nav-badge badge text-bg-danger" id="hitungpendingaju"></span>
                                </p>
                            </a>
                        @elseif ($role == 'op')
                            <a href="{{ route('op.testing.dashboard') }}"
                               class="nav-link {{ request()->routeIs('op.testing.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-grid"></i>
                                <p>
                                    {{ __('List Pengajuan') }}
                                    <span class="nav-badge badge text-bg-danger" id="hitungpendingaju"></span>
                                </p>
                            </a>
                        @elseif ($role == 'faskes')
                            <a href="{{ route('faskes.main.dashboard') }}"
                               class="nav-link {{ request()->routeIs('faskes.main.dashboard') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-grid"></i>
                                <p>{{ __('Rekapitulasi') }}</p>
                            </a>
                        @endif
                    </li>


                    @if ($role == 'adminptsp')
                        <li class="nav-item">
                            <a href="{{ route('admin.pengajuansipmanual') }}"
                               class="nav-link {{ request()->routeIs('admin.pengajuansipmanual') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-archive"></i>
                                <p>{{ __('Pengajuan SIP Manual') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.updatestrnakes') }}"
                               class="nav-link {{ request()->routeIs('admin.updatestrnakes') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-files"></i>
                                <p>{{ __('Update STR Nakes') }}</p>
                            </a>
                        </li>
                        <li class="nav-item" id="menupencabutan">
                            <a href="{{ route('ptsp.manage.pencabutan') }}"
                               class="nav-link {{ request()->routeIs('ptsp.manage.pencabutan') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-x-circle"></i>
                                <p>
                                    {{ __('List Pencabutan') }}
                                    <span class="nav-badge badge text-bg-danger" id="hitungpendingcabut"></span>
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ptsp.manage.faskes') }}"
                               class="nav-link {{ request()->routeIs('ptsp.manage.faskes') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-building"></i>
                                <p>{{ __('List Fasyankes') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ptsp.daftar.nonqr') }}"
                               class="nav-link {{ request()->routeIs('ptsp.daftar.nonqr') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-person-badge"></i>
                                <p>{{ __('Pendaftaran Non QR') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.rekappelayanan') }}"
                               class="nav-link {{ request()->routeIs('get.rekappelayanan') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-list-ul"></i>
                                <p>{{ __('Rekap') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('get.rekapmapnakes') }}"
                               class="nav-link {{ request()->routeIs('get.rekapmapnakes') ? 'active' : '' }}">
                                <i class="nav-icon bi bi-layers"></i>
                                <p>{{ __('Map Nakes') }}</p>
                            </a>
                        </li>
                    @endif
                @endif

            </ul>
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>

