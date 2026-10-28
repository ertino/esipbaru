@include('layouts.templet.back_core')
@include('layouts.templet.back_header')

@yield('content')

@include('layouts.templet.back_footer_content')
@include('layouts.templet.back_corejs')

@if($role == 'programmer')
@include('layouts.templet.back_footer_prog')
@else
@include('layouts.templet.back_footer')
@endif

