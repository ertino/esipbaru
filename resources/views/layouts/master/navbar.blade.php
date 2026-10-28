<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href=""><img src="{{asset('images/retribrusun.png')}}" class="d-inline-block" width="100px" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      
        @if(Auth::user())
          <span class="navbar-brand">{{Auth::user()->name}}</span>
          <!-- Authentication -->
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-success" onclick="event.preventDefault(); this.closest('form').submit();">logout</button>
          </form>
        @else
          <a href="{{route('login')}}"><button class="btn btn-outline-success"  type="button">Admin</button></a>
        @endif
    </div>
  </div>
</nav>