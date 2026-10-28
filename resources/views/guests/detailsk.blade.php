@extends('layouts.minlte.back_daftar')
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
              <div class="col-md-3 col-xs-12">
                <div class="card card-primary card-outline">
                  <div class="card-body box-profile">
                    <center><img class="profile-user-img img-fluid custom-rounded" src="{{ URL::to('/storagefotopublic')}}/{{$alldetail->saved_photo}}" alt="User profile picture"></center>

                    <hr>

                    <strong><i class="fas fa-user"></i> Nama</strong>
                    <p class="text-muted">
                    {{$alldetail->nama_nakes}}
                    </p>

                    <strong><i class="fas fa-flask"></i> Kompetensi</strong>
                    <p class="text-muted">
                    {{$alldetail->kompetensi}}
                    </p>

                    @if($alldetail->url_qr != 'scanned')
                      <strong><i class="fas fa-id-card"></i> STR</strong>
                      <p class="text-muted">
                      <a href="{{$alldetail->url_qr}}" target="_blank">Lihat STR</a>
                      </p>
                    @endif

                  </div>
                </div>
              </div>
              <div class="col-md-9 col-xs-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">
                      Detail Dokumen Surat Keterangan Tempat Praktik
                    </div>
                  </div>
                  <div class="card-body">

                    <div class="row">
                      <div class="col-md-12">

                      @if($alldetail->status_sk != '1')

                        <div class="alert alert-danger alert-dismissible">
                          
                          <h5><i class="icon fas fa-ban"></i> Tidak Aktif!</h5>
                          Status Dokumen Tidak Aktif
                        </div>

                      @else($alldetail->status_sip == '1')

                        <div class="alert alert-success alert-dismissible">
                          
                          <h5><i class="icon fas fa-success"></i> AKTIF!</h5>
              
                        </div>

                      @endif

                        <form>
                          <div class="row">

                              <div class="col-md-4" >
                                  <div class="form-group">
                                      <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                      <input type="text" id="tNamaFaskesM" name="tNamaFaskesM" class="form-control" value="{{$alldetail->no_str}}" readonly>
                                  </div>
                              </div>

                              <div class="col-md-4" >
                                  <div class="form-group">
                                      <label for="exampleFormControlSelect1" class="ms-0">Nomor Surat Keterangan Tempat Praktik</label>
                                      <input type="text" id="tNamaFaskesM" name="tNamaFaskesM" class="form-control" value="{{$alldetail->no_surat}}" readonly>
                                  </div>
                              </div>

                              <div class="col-md-4" >
                                  <div class="form-group">
                                      <label for="exampleFormControlSelect1" class="ms-0">Berlaku Hingga</label>
                                      <input type="text" id="tNamaFaskesM" name="tNamaFaskesM" class="form-control" value="{{$alldetail->valid_until}}" readonly>
                                  </div>
                              </div>


                          </div>
                          <div class="row">

                              <div class="col-md-12" >
                                  <div class="form-group">
                                      <label for="exampleFormControlSelect1" class="ms-0">Alamat Praktik / Faskes</label>
                                      <input type="text" id="tNamaFaskesM" name="tNamaFaskesM" class="form-control" value="{{$alldetail->nama_lokasi}}" readonly>
                                  </div>
                              </div>


                          </div>
                          <div class="row">
                  

                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                      <input type="text" id="tKabupatenM" name="tKabupatenM" class="form-control" value="{{$alldetail->kec_lokasi}}" readonly>
                                  </div>
                              </div>

                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                      <input type="text" id="tKecamatanM" name="tKecamatanM" class="form-control" value="{{$alldetail->kab_lokasi}}" readonly>
                                  </div>
                              </div>
                          </div> 
                        </form>   
                      </div>
                    </div>
                    <hr>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </section>

  



  

@endsection
@section('js')

@endsection