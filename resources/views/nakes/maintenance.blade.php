@extends('layouts.minlte.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content">
        <div class="container-fluid">
        <br />
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row mb-2">
                <div class="col-sm-12">
                    <center>
                    <a href="/">
                        <img src="{{asset('images/nakesmaintenance.png')}}" width="300px" alt="">
                    </a>      
                    </center>
                </div>
            
            </div>
            <br />

            <div class="row">
                <div class="col-md-4 col-xs-4">
                </div>
                <div class="col-md-4 col-xs-4">
                    <center>
                    <h2>Mohon Maaf!</h2>
                    </center>
                    <div class="alert alert-danger alert-dismissible">
                        
                        Aplikasi e-SIP Sedang Dalam Penyesuaian Alur Pengajuan Terbaru. Pengajuan, Pencabutan, Pembaharuan Serta Perubahan e-SIP Untuk Sementara Tidak Dapat Dilakukan Hingga Waktu Dekat.

                    </div>
                    <br />
                    
                </div>
                <div class="col-md-4 col-xs-4">
                </div>
            </div>
        </div>
    </section>
</div>
  


  

@endsection
@section('js')

@endsection