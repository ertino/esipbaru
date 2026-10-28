@if($route->isNotEmpty())
  @foreach($route as $row)
  <a href="{{ route($row->route) }}">
    {{$row->nama_halaman}}
  </a>
  >>
  @endforeach
@endif
<a href="">
  {{$current_route->nama_halaman}}
</a>
