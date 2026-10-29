@extends('layouts.adminlte4.back_daftar')
@section('content')

<!-- Content Header (Page header) -->
<nav class="navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <div class="container">
            <li class="nav-item">
                <a href="/" class="navbar-brand">
                    <img src="{{ asset('images/nakes-th.png') }}" height="80px" alt="">
                </a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="/" class="navbar-brand">
                    <img src="{{ asset('images/logo-clp.png') }}" height="80px" alt="">
                </a>
            </li>
            
        </div>
    </ul>
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Informasi</a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="#">Lowongan</a>
                <a class="dropdown-item" href="#">Petunjuk</a>
                <a class="dropdown-item" href="#">Faskes</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Pendaftaran</a>
            </div>
        </li>
        <li class="nav-item">
            <a href="#" class="nav-link">Kontak</a>
        </li>
        <li class="nav-item">
            <a type="button" class="btn btn-sm btn-danger" href="{{route('login')}}" class="nav-link">Masuk / Daftar</a>
        </li>
        
      
    </ul>


    <!-- Right navbar links -->

  </nav>

<body class="sidebar-mini" style="height: auto;">

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <ol class="carousel-indicators">
                        <li data-bs-target="#carouselExampleIndicators" data-slide-to="0" class=""></li>
                        <li data-bs-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
                        <li data-bs-target="#carouselExampleIndicators" data-slide-to="2" class="active"></li>
                        </ol>
                        <div class="carousel-inner">
                        <div class="carousel-item">
                        <img class="d-block w-100" src="{{asset('images/c1.png')}}" alt="First slide">
                        </div>
                        <div class="carousel-item">
                        <img class="d-block w-100" src="{{asset('images/c2.png')}}" alt="Second slide">
                        </div>
                        <div class="carousel-item active">
                        <img class="d-block w-100" src="{{asset('images/c1.png')}}" alt="Third slide">
                        </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                        <span class="carousel-control-custom-icon" aria-hidden="true">
                        <i class="fas fa-chevron-left"></i>
                        </span>
                        <span class="visually-hidden">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                        <span class="carousel-control-custom-icon" aria-hidden="true">
                        <i class="fas fa-chevron-right"></i>
                        </span>
                        <span class="visually-hidden">Next</span>
                        </a>
                        </div>
                </div>
            </div>
        </div>
    </section>
    <hr />
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6">

                <div class="small-box bg-info">
                <div class="inner">
                <h3>PANDUAN</h3>
                </div>
                <div class="icon">
                <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">Lihat Panduan <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>

                <div class="col-lg-4 col-6">

                <div class="small-box bg-success">
                <div class="inner">
                <h3>PENDAFTARAN</h3>
                </div>
                <div class="icon">
                <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">Pendaftaran Nakes <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>

                <div class="col-lg-4 col-6">

                <div class="small-box bg-danger">
                <div class="inner">
                <h3>SARAN / PERTANYAAN</h3>
                </div>
                <div class="icon">
                <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Lebih Lanjut <i class="fas fa-arrow-circle-right"></i></a>
                </div>
                </div>

            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header border-0">
                        <h2 class="card-title"><b>Pengumuman</b></h2>
                        <div class="card-tools">
                        <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-download"></i>
                        </a>
                        <a href="#" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i>
                        </a>
                        </div>
                        </div>
                        <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                        <tbody>
                        <tr>
                        <td>
                            <h5>Perpanjangan Masa Berlaku Surat Izin Praktik</h5>
                            <small>2024-01-23</small>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <h5>Pengumuman Revisi Prosedur Permohonan Izin Praktik</h5>
                            <small>2024-01-10</small>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <h5>Pelatihan Wajib Untuk Perolehan Izin Khusus</h5>
                            <small>2024-01-09</small>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <h5>Perubahan Ketentuan Terkait Standar Praktik Profesi Kesehat</h5>
                            <small>2024-01-05</small>
                        </td>
                        </tr>
                        <tr>
                        <td>
                            <h5>Pentingnya Mematuhi Etika dan Kode Etik Profesi</h5>
                            <small>2024-01-01</small>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">Nakes Terdaftar</h3>
                        <div class="card-tools">
                        <span class="badge text-bg-danger">1k Nakes</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                        </button>
                        </div>
                        </div>

                        <div class="card-body p-0">
                        <ul class="users-list clearfix ">
                        <li>
                        <img src="{{ URL::to('/storagefotopublic')}}/210_t.jpeg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander Pierce</a>
                        <span class="users-list-date">Today</span>
                        </li>
                        <li>
                        <img src="{{ URL::to('/storagefotopublic')}}/211_t.jpeg" alt="User Image">
                        <a class="users-list-name" href="#">Norman</a>
                        <span class="users-list-date">Yesterday</span>
                        </li>
                        <li>
                        <img src="{{ URL::to('/storagefotopublic')}}/212_t.jpeg" alt="User Image">
                        <a class="users-list-name" href="#">Jane</a>
                        <span class="users-list-date">12 Jan</span>
                        </li>
                        <li>
                        <img src="{{ URL::to('/storagefotopublic')}}/213_t.jpeg" alt="User Image">
                        <a class="users-list-name" href="#">John</a>
                        <span class="users-list-date">12 Jan</span>
                        </li>
                        </ul>

                        </div>

                        <div class="card-footer text-center">
                        </div>

                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Faskes Sekitar</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="landingmap" id="landingmap" style="height:300px;"></div>
                        </div>
                            
                    </div>
                    
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="invoice p-3 mb-3">

            <div class="row">
            <div class="col-12">
            <h4>
            <i class="fas fa-globe"></i> AdminLTE, Inc.
            <small class="float-end">Date: 2/10/2014</small>
            </h4>
            </div>

            </div>

            <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
            From
            <address>
            <strong>Admin, Inc.</strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (804) 123-5432<br>
            Email: info@almasaeedstudio.com
            </address>
            </div>

            <div class="col-sm-4 invoice-col">
            To
            <address>
            <strong>John Doe</strong><br>
            795 Folsom Ave, Suite 600<br>
            San Francisco, CA 94107<br>
            Phone: (555) 539-1037<br>
            Email: john.doe@example.com
            </address>
            </div>

            <div class="col-sm-4 invoice-col">
            <b>Invoice #007612</b><br>
            <br>
            <b>Order ID:</b> 4F3S8J<br>
            <b>Payment Due:</b> 2/22/2014<br>
            <b>Account:</b> 968-34567
            </div>

            </div>


            <div class="row">
            <div class="col-12 table-responsive">
            <table class="table table-striped">
            <thead>
            <tr>
            <th>Qty</th>
            <th>Product</th>
            <th>Serial #</th>
            <th>Description</th>
            <th>Subtotal</th>
            </tr>
            </thead>
            <tbody>
            <tr>
            <td>1</td>
            <td>Call of Duty</td>
            <td>455-981-221</td>
            <td>El snort testosterone trophy driving gloves handsome</td>
            <td>$64.50</td>
            </tr>
            <tr>
            <td>1</td>
            <td>Need for Speed IV</td>
            <td>247-925-726</td>
            <td>Wes Anderson umami biodiesel</td>
            <td>$50.00</td>
            </tr>
            <tr>
            <td>1</td>
            <td>Monsters DVD</td>
            <td>735-845-642</td>
            <td>Terry Richardson helvetica tousled street art master</td>
            <td>$10.70</td>
            </tr>
            <tr>
            <td>1</td>
            <td>Grown Ups Blue Ray</td>
            <td>422-568-642</td>
            <td>Tousled lomo letterpress</td>
            <td>$25.99</td>
            </tr>
            </tbody>
            </table>
            </div>

            </div>

            <div class="row">

            <div class="col-6">
            <p class="lead">Payment Methods:</p>
            <img src="../../dist/img/credit/visa.png" alt="Visa">
            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
            <img src="../../dist/img/credit/american-express.png" alt="American Express">
            <img src="../../dist/img/credit/paypal2.png" alt="Paypal">
            <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
            plugg
            dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
            </p>
            </div>

            <div class="col-6">
            <p class="lead">Amount Due 2/22/2014</p>
            <div class="table-responsive">
            <table class="table">
            <tbody><tr>
            <th style="width:50%">Subtotal:</th>
            <td>$250.30</td>
            </tr>
            <tr>
            <th>Tax (9.3%)</th>
            <td>$10.34</td>
            </tr>
            <tr>
            <th>Shipping:</th>
            <td>$5.80</td>
            </tr>
            <tr>
            <th>Total:</th>
            <td>$265.24</td>
            </tr>
            </tbody></table>
            </div>
            </div>

            </div>


            <div class="row no-print">
            <div class="col-12">
            <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
            <button type="button" class="btn btn-success float-end"><i class="far fa-credit-card"></i> Submit
            Payment
            </button>
            <button type="button" class="btn btn-primary float-end" style="margin-right: 5px;">
            <i class="fas fa-download"></i> Generate PDF
            </button>
            </div>
            </div>
            </div>
        </div>
    </section>

  



  

@endsection
@section('js')
@endsection
@section('script')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
<script>

    var mymap = L.map('landingmap').setView([-7.708699, 109.013433], 13);

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 20,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: "{{ config('services.mapbox.token') }}"
    }).addTo(mymap);
</script>

@endsection