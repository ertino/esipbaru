@php
    /*
     |--------------------------------------------------------------------------
     | Brand assets
     |--------------------------------------------------------------------------
     |
     | The rest of the application references these files as asset('images/...'),
     | but the public/images directory is not part of this repository. Fall back
     | to the text logo when the file is missing so the page never shows a
     | broken image.
     |
     */
    $brandLogo = file_exists(public_path('images/NAKES.png')) ? asset('images/NAKES.png') : null;
    $announcement = file_exists(public_path('images/anounce.jpeg')) ? asset('images/anounce.jpeg') : null;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="{{ asset('images/nakesico.png') }}" type="image/png">

    <title>{{ __('Login') }} | APLIKASI SURAT IZIN PRAKTIK TENAGA MEDIS &amp; KESEHATAN DIGITAL</title>

    <!-- Google Font: Source Sans 3 (AdminLTE 4 default) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,300..700;1,300..700&display=swap">

    @if (file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json')))
        {{--
            Vite bundle: resources/css/app.css pulls Bootstrap 5, Bootstrap Icons
            and AdminLTE 4; resources/js/app.js exposes window.bootstrap.
        --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{--
            Fallback so the page is still styled before `npm run dev` or
            `npm run build` has been executed (AdminLTE 4 already bundles
            Bootstrap 5 in dist/css/adminlte.min.css).
        --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/css/adminlte.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/js/adminlte.min.js"></script>
    @endif
</head>
<body class="login-page bg-body-secondary">


    <div class="login-box">
        <!-- /.login-logo -->
        <div class="login-logo">
            <a href="{{ url('/') }}">
                @if ($brandLogo)
                    <img src="{{ $brandLogo }}" class="img-fluid" style="max-height: 72px;" alt="{{ __('Aplikasi URAT NADI') }}">
                @else
                    <i class="bi bi-heart-pulse-fill text-primary"></i>
                    <b>URAT</b>&nbsp;NADI
                @endif
            </a>
        </div>
        <!-- /.login-logo -->

        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('Masuk untuk memulai sesi Anda') }}</p>

                <!-- Session Status -->
                @if (session('status'))
                    <div class="alert alert-success py-2" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Username -->
                    <div class="input-group mb-3">
                        <input id="username"
                               type="text"
                               name="username"
                               value="{{ old('username') }}"
                               class="form-control @error('username') is-invalid @enderror"
                               placeholder="{{ __('Username') }}"
                               required
                               autofocus
                               autocomplete="username">
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group mb-3">
                        <input id="password"
                               type="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="{{ __('Password') }}"
                               required
                               autocomplete="current-password">
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>


                    <!-- CAPTCHA -->
                    <div class="input-group mb-3">
                        <input id="captcha"
                               type="text"
                               name="captcha"
                               class="form-control @error('captcha') is-invalid @enderror"
                               placeholder="{{ __('Captcha') }}"
                               required
                               autocomplete="off">
                        <div class="input-group-text p-0 overflow-hidden">
                            <img src="{{ captcha_src() }}"
                                 alt="{{ __('Captcha') }}"
                                 title="{{ __('Klik untuk mengganti kode') }}"
                                 style="height: 38px; cursor: pointer;"
                                 onclick="this.src='{{ captcha_src() }}?' + Math.random();">
                        </div>
                        @error('captcha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-7">
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="checkbox"
                                       name="remember"
                                       value="1"
                                       id="remember_me"
                                       {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember_me">{{ __('Remember me') }}</label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-5">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> {{ __('Log in') }}
                                </button>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
                </form>

                <div class="social-auth-links text-center mt-3 mb-3 d-grid gap-2">
                    <button type="button"
                            class="btn btn-outline-secondary"
                            data-bs-toggle="modal"
                            data-bs-target="#pengumumanModal">
                        <i class="bi bi-megaphone me-1"></i> {{ __('Pengumuman') }}
                    </button>
                </div>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="{{ route('lupa.password') }}">{{ __('Lupa Password') }}</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('daftar.nakes') }}" class="text-center">{{ __('Daftar Nakes Baru') }}</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->


    <!-- Pengumuman Modal (Bootstrap 5) -->
    <div class="modal fade"
         id="pengumumanModal"
         tabindex="-1"
         aria-labelledby="pengumumanModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pengumumanModalLabel">{{ __('Pengumuman') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Tutup') }}"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-3">
                        Mohon untuk memperhatikan pengumuman berikut sebelum Anda login ke aplikasi URAT NADI.
                    </p>
                    @if ($announcement)
                        <img src="{{ $announcement }}" class="img-fluid w-100" alt="{{ __('Pengumuman') }}">
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                        {{ __('Saya Mengerti') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Show the announcement automatically on page load, as the legacy
            // page did, and keep it reachable through the button above.
            var pengumumanModal = document.getElementById('pengumumanModal');

            if (pengumumanModal && window.bootstrap) {
                window.bootstrap.Modal.getOrCreateInstance(pengumumanModal).show();
            }
        });
    </script>
</body>
</html>

