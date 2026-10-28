<body class="g-sidenav-show  bg-gray-200">
    <!-- Navbar -->
        @include('layouts.templet.back_sidebar')
    <!-- End Navbar -->
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Template</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Template</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)">
            </div>
          </div>
          
          <div class="dropdown">
            <a href="#" data-bs-toggle="dropdown" id="navbarDropdownMenuLink2">
              <i class="fa fa-user me-sm-1" aria-hidden="true"></i>{{ Auth::user()->name }}
                <span class="d-sm-inline d-none"></span>
            </a>
            <ul class="dropdown-menu justify-content-end" aria-labelledby="navbarDropdownMenuLink2">
              <li>
                <form method="POST" action="{{ route('logout') }}">
                @csrf
                  <a onclick="event.preventDefault(); this.closest('form').submit();">logout
                  </a>
                </form>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    @include('layouts.templet.back_modal')