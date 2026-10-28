@if($role != 'op')
@include('layouts.minlte.back_core')
@include('layouts.minlte.back_header')

@yield('content')

@include('layouts.minlte.back_footer_content')
@include('layouts.minlte.back_corejs')


@if($role == 'programmer')
@include('layouts.minlte.back_footer_prog')
@yield('script')
@else
@include('layouts.minlte.back_footer')
@yield('script')
@endif
@else

@include('layouts.tabler.back_core')
@include('layouts.tabler.back_header')

@yield('content')

@include('layouts.tabler.back_footer_content')
@include('layouts.tabler.back_corejs')

@include('layouts.tabler.back_footer')
@yield('script')

@endif

