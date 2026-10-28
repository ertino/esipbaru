@php
    /*
     |--------------------------------------------------------------------------
     | Document head (AdminLTE 4 + Vite)
     |--------------------------------------------------------------------------
     |
     | Same asset strategy as resources/views/auth/login.blade.php: the Vite
     | bundle is used whenever a dev server (public/hot) or a build manifest is
     | available, otherwise the page falls back to the AdminLTE 4 CDN so it is
     | never rendered unstyled.
     |
     | resources/css/app.css pulls Bootstrap 5, Bootstrap Icons and AdminLTE 4,
     | while resources/js/app.js exposes window.bootstrap and registers the
     | AdminLTE widgets (sidebar toggle, treeview, ...).
     |
     */
    $hasVite = file_exists(public_path('hot')) || file_exists(public_path('build/manifest.json'));
    $brandIcon = file_exists(public_path('images/nakesico.png')) ? asset('images/nakesico.png') : null;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if ($brandIcon)
        <link rel="icon" href="{{ $brandIcon }}" type="image/png">
    @endif

    <title>@yield('title', 'APLIKASI SURAT IZIN PRAKTIK TENAGA MEDIS & KESEHATAN DIGITAL')</title>

    <!-- Google Font: Source Sans 3 (AdminLTE 4 default) -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Source+Sans+3:ital,wght@0,300..700;1,300..700&display=swap">

    <!-- DataTables + Buttons, used by the jQuery driven tables of the dashboards -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">

    @if ($hasVite)
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        {{-- Fallback so the page is still styled before `npm run dev` or `npm run build` has been executed. --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.2/font/bootstrap-icons.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/css/adminlte.min.css">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.10.0/dist/js/adminlte.min.js"></script>
    @endif

    @yield('css')
</head>
