@php
    /*
     |--------------------------------------------------------------------------
     | Document head (AdminLTE 4)
     |--------------------------------------------------------------------------
     |
     | Every asset is served from public/vendor, so a fresh clone renders the
     | same way on every machine without running `npm install` / `npm run build`.
     | When a vendored file is missing the matching CDN build is used instead,
     | which keeps the layout usable while a deployment catches up.
     |
     | AdminLTE 4's adminlte.min.css already contains Bootstrap 5, so
     | bootstrap.min.css is intentionally not loaded a second time.
     |
     */
    $local = function (string $path) {
        return file_exists(public_path($path)) ? asset($path) : null;
    };
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--
        Apply the stored light / dark choice before any stylesheet paints, so a
        user who picked dark mode never sees a white flash. The button that
        flips the value lives in layouts/adminlte4/back_header and the click
        handling lives in js/theme-toggle.js. Keep the storage key in sync with
        that file ("sipbaru-theme").
    --}}
    <script>
        (function () {
            try {
                var stored = window.localStorage.getItem('sipbaru-theme');
                var theme = stored === 'dark' || stored === 'light'
                    ? stored
                    : (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');

                document.documentElement.setAttribute('data-bs-theme', theme);
            } catch (error) {
                /* localStorage blocked (private mode): keep the light default. */
            }
        })();
    </script>

    @if ($local('images/nakesico.png'))
        <link rel="icon" href="{{ $local('images/nakesico.png') }}" type="image/png">
    @endif

    <title>@yield('title', 'APLIKASI SURAT IZIN PRAKTIK TENAGA MEDIS & KESEHATAN DIGITAL')</title>

    <!-- Google Font: Source Sans 3 (AdminLTE 4 default) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,300..700;1,300..700&display=swap">

    <!-- AdminLTE 4 (bundles Bootstrap 5) + Bootstrap Icons -->
    <link rel="stylesheet" href="{{ $local('vendor/adminlte4/css/adminlte.min.css') ?? 'https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/css/adminlte.min.css' }}">
    <link rel="stylesheet" href="{{ $local('vendor/bootstrap-icons/bootstrap-icons.min.css') ?? 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css' }}">

    <!-- Icon fonts still referenced by the migrated views -->
    <link rel="stylesheet" href="{{ $local('vendor/fontawesome-free/css/all.min.css') ?? 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css' }}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ $local('vendor/overlayScrollbars/OverlayScrollbars.min.css') ?? 'https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css' }}">
    <link rel="stylesheet" href="{{ $local('vendor/fancybox/jquery.fancybox.min.css') ?? 'https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css' }}">
    <link rel="stylesheet" href="{{ $local('vendor/daterangepicker/daterangepicker.css') ?? 'https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.css' }}">
    <link rel="stylesheet" href="{{ $local('vendor/tempusdominus-bootstrap-4/tempusdominus-bootstrap-4.css') ?? 'https://cdn.jsdelivr.net/npm/tempusdominus-bootstrap-4@5.39.0/css/tempusdominus-bootstrap-4.min.css' }}">
    <link rel="stylesheet" href="{{ $local('vendor/chart.js/Chart.min.css') ?? 'https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.css' }}">
    <link rel="stylesheet" href="{{ $local('vendor/sweetalert2/sweetalert2.min.css') ?? 'https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css' }}">
    <link rel="stylesheet" href="{{ $local('vendor/toastr/toastr.min.css') ?? 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css' }}">
    <link rel="stylesheet" href="{{ $local('vendor/select2/select2.min.css') ?? 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' }}">
    <link rel="stylesheet" href="{{ $local('vendor/select2/select2-bootstrap4.min.css') ?? 'https://cdn.jsdelivr.net/npm/select2-bootstrap4-theme@1.0.0/dist/select2-bootstrap4.min.css' }}">

    <!-- DataTables + Buttons (CSV/Excel/PDF export) -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    <!-- Stepper -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css">

    <!-- Leaflet (map pages): vendored copy first, CDN fallback -->
    @if ($local('vendor/leaflet/leaflet.css'))
        <link rel="stylesheet" href="{{ $local('vendor/leaflet/leaflet.css') }}">
    @else
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
              integrity="sha512-Zcn6bjR/8RZbLEpLIeOwNtzREBAJnUKESxces60Mpoj+2okopSAcSUIUOseddDm0cxnGQzxIR7vJgsLZbdLE3w=="
              crossorigin="">
    @endif

    <!-- AdminLTE 4 compatibility layer (legacy helpers + Bootstrap 4 class names) -->
    <link rel="stylesheet" href="{{ asset('css/adminlte4-compat.css') }}">

    <!-- Light / dark switch (button lives in the navbar) -->
    <script src="{{ asset('js/theme-toggle.js') }}" defer></script>

    @yield('css')
</head>
