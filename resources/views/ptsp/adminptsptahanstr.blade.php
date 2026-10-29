@extends('layouts.adminlte4.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang Di Sini</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- COLOR PALETTE -->
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  STR Scanner
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row" id="formsubmitstrmanual">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                  
                      <center>
                      <h3> Scan STR Yang Akan Dikumpulkan</h3>
                      <form enctype="multipart/form-data" id="formDaftarManual" method="post" class="form-horizontal">
                          @csrf
                        

                          <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="card card-widget overlay">
                                    <div class="card-header">

                                    </div>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div id="qr-reader-str" style="width:500px"></div>
                                                <div id="qr-reader-results2"></div>

                                            </div>

                                        </div>
                                    
                                    </div>
                                </div>
                            </div>
                          </div>
                          
                      </form>
                      
                    </center>
                  </div>
                </div>
              </div>
              <div class="overlay" id="uploadstrmanualloader" style="display:none">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
              <div class="overlay" id="aftermanualupload" style="display:none">
                <button id="buttonreloadmanual" class="btn btn-info"><i class="fas fa-3x fa-sync-alt fa-spin"></i></button>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

          <div class="col-md-6 col-xs-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  Form Penyerahan STR
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <div class="row">
                  <div class="col-md-12 col-sm-12 col-xs-12">

                    <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                          <form id="lanjutuploadstrmanual" action="{{ route('simpan.pengumpulan.str') }}" method="post" class="form-horizontal">
                          @csrf

                            <div class="row">
                                <div class="col-md-6 col-xs-6" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                        <input type="text" id="stNamaKumpul" name="stNamaKumpul" class="form-control" value="{{$detail_pengajuan->nama_nakes}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                        <input type="text" id="stNoSTRKumpul" name="stNoSTRKumpul" class="form-control" value="{{$detail_pengajuan->no_str}}" readonly>
                                    </div>
                                </div>

                            </div>  

                            <div class="row" style="display:none">
                                


                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                        <input type="text" id="UpdaterKumpul" name="UpdaterKumpul" class="form-control" value="{{$user_id}}">
                                    </div>
                                </div>

                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">ID Pengajuan</label>
                                        <input type="text" id="stIDPengajuanKumpul" name="stIDPengajuanKumpul" class="form-control" value="{{$id_pengajuan}}">
                                    </div>
                                </div>

                            </div>  

                            <div class="row">

                                <div class="col-md-8 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Lokasi Penyimpanan</label>
                                        <input type="text" id="stPenyimpanan" name="stPenyimpanan" class="form-control" required>
                                    </div>
                                </div>


                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan Ke</label>
                                        <input type="text" id="stSalinanKumpul" name="stSalinanKumpul" class="form-control" value="{{$detail_pengajuan->salinan}}">
                                    </div>
                                </div>

                            </div>


                            <div class="row">

                                <div class="col-md-8 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">URL QRCODE</label>
                                        <input type="text" id="stUrlCode" name="stUrlCode" class="form-control" value="{{$detail_pengajuan->url_qr}}" required>
                                    </div>
                                </div>


                                <div class="col-md-4 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Tgl Doc Origin</label>
                                        <input type="text" id="stTglDocOrigin" name="stTglDocOrigin" class="form-control" value="{{$detail_pengajuan->tgl_doc_origin}}">
                                    </div>
                                </div>

                            </div>


                            <hr />

                            <button type="submit" id="simpanpenyerahanstr" class="btn btn-success">Simpan</button>
                          </form>
                      </div>
                  </div>

                  </div>
                </div>
              </div>
              <div class="overlay" id="overlaypenyerahan">
                <h3> Scan STR Terlebih Dahulu </h3>
              </div>
              <!-- /.card-body -->
            </div>

          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>
</div>
  


  

@endsection
@section('js')

@endsection