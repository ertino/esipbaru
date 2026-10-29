@extends('layouts.adminlte4.back_daftar')
@section('content')
<body class="sidebar-mini" style="height: auto;">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <center>
            <a href="/">
                <img src="{{asset('images/NAKES.png')}}" height="300px" alt="">
            </a>
                               
            </center>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-xs-4">
                </div>
                <div class="col-md-4 col-xs-4">

                    <div class="alert alert-danger alert-dismissible">
                        
                        <h5><i class="icon fas fa-check"></i> Mohon Maaf!</h5>
                        Pendaftaran Anda Gagal Diproses Oleh Sistem <br />
                        Silahkan Coba Beberapa Saat Lagi
                    </div>
                    <br />
                    <a class="btn btn-block btn-outline-danger btn-sm" href="{{route('login')}}">Kembali</a>
                </div>
                <div class="col-md-4 col-xs-4">
                </div>
            </div>
        </div>
    </section>

  



  

@endsection
@section('js')

@endsection