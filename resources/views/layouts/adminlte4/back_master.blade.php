@include('layouts.adminlte4.back_core')
@include('layouts.adminlte4.back_header')

@yield('content')

@include('layouts.adminlte4.back_footer_content')
@include('layouts.adminlte4.back_modal')
@include('layouts.adminlte4.back_corejs')

@if (($role ?? Auth::user()->role) === 'programmer')
    @include('layouts.adminlte4.back_footer_prog')
@else
    @include('layouts.adminlte4.back_footer')
@endif

@yield('script')
</body>
</html>
