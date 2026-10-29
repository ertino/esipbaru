{{--
    Guest / public layout (AdminLTE 4).

    Port of layouts/minlte/back_daftar: the self-service pages (registration,
    QR check-in, assistance form, ...) render their own full page markup, so no
    header, sidebar or footer wrapper is included here - only the document
    head, the scripts and the guest footer script.
--}}
@include('layouts.adminlte4.back_core')

@yield('content')

@include('layouts.adminlte4.back_corejs')
@include('layouts.adminlte4.back_footer_daftar')

@yield('script')
</body>
</html>
