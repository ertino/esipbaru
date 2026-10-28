@extends('layouts.minlte.back_master')
@section('content')

<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang di e-SIP</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="card card-primary card-outline" id="blockside">
                    <div class="card-header">
                        <h3 class="card-title">
                            Dokumen Pengajuan
                        </h3>
                        
                        <script>
                            function hideme(){
                                $('#jajalan').hide()
                            }
                        </script>

                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group">
                                <label for="name" class="label-control col-md-12"></label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="checkbox" id="showSTR" checked>&nbsp;STR&nbsp;&nbsp;|
                                    <input type="checkbox" id="showKTP" checked>&nbsp;KTP&nbsp;&nbsp;|
                                    <input type="checkbox" id="showREKOMP" checked>&nbsp;Rekom Profesi&nbsp;&nbsp;|
                                    <input type="checkbox" id="showSKS" checked>&nbsp;SKS&nbsp;&nbsp;|
                                    <input type="checkbox" id="showSPTP" checked>&nbsp;SPTP&nbsp;&nbsp;|
                                    <input type="checkbox" id="showIJAZAH" checked>&nbsp;IJAZAH&nbsp;&nbsp;|
                                    <input type="checkbox" id="showSKP" checked>&nbsp;SKP&nbsp;&nbsp;|
                                    <input type="checkbox" id="showBAV" checked>&nbsp;BA Visitasi&nbsp;&nbsp;|
                                </div>
                            </div>
                        </div>
                    
                    
                        <div class="kekanan">
                        @foreach ($doc_strused as $str)
                            <div class="card card-row card-success blogade" id="cardSTR">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        STR Salinan {{$str->salinan}}
                                    
                                    </h3>
 
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
                                    <embed src="{{ URL::to('/storage')}}/{{$str->namafile}}.pdf" width="100%" height="100%"></embed>
                                </div>
                            </div>
                            @if($str->url_qr != '0')
                                @if($str->url_qr != 'manual')

                                    <div class="card card-row card-secondary blogade" id="jajalan">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            
                                                Validasi STR Salinan {{$str->salinan}}
                                            
                                            </h3>
        
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
                                            <iframe class="embed-responsive-item" src="{{$str->url_qr}}" width="100%" height="450px"></iframe>
                                        </div>
                                    </div>
                                @else

                                    <div class="card card-row card-secondary blogade" id="jajalan">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            
                                                Validasi STR Salinan {{$str->salinan}}
                                            
                                            </h3>
        
                                        </div>
                                        <div class="card-body">
                                            <h1> Validasi STR Tidak Tersedia (Non-QRCODE)</h1>
                                        </div>
                                    </div>
                                @endif

                            @endif

                        @endforeach

                        @foreach($doc_ktp as $ktp)
                            <div class="card card-row card-info blogade" id="cardKTP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Dokumen KTP
                                    
                                    </h3>
 
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
                                    <img src="{{ URL::to('/storageup')}}/{{$ktp->namafile}}" width="100%" height="100%">
                                </div>
                            </div>
                        @endforeach

                        @foreach($doc_rekomp as $rekomp)
                            <div class="card card-row card-warning blogade" id="cardREKOMP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Dokumen Rekomendasi Profesi
                                    
                                    </h3>
 
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$rekomp->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                            

                        @foreach($doc_sptp as $sptp)
                            <div class="card card-row card-primary blogade" id="cardSPTP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Surat Persyaratan Tempat Praktik
                                    
                                    </h3>
 
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$sptp->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach



                        @foreach($doc_sks as $sks)
                            <div class="card card-row card-info blogade" id="cardSKS">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Surat Keterangan Sehat
                                    
                                    </h3>
 
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$sks->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                        @foreach($doc_ijazah as $ijazah)
                            <div class="card card-row card-warning blogade" id="cardIJAZAH">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        IJAZAH
                                    
                                    </h3>
 
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$ijazah->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                        @foreach($doc_skp as $skp)
                            <div class="card card-row card-info blogade" id="cardSKP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Surat Keterangan Pimpinan
                                    
                                    </h3>
 
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$skp->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach


                        @foreach($doc_rekomdk as $rekomdk)
                            <div class="card card-row card-success blogade" id="cardREKOMDK">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Surat Rekomendasi Dinas Kesehatan
                                    
                                    </h3>
 
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$rekomdk->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                        @foreach($doc_bav as $bav)
                            <div class="card card-row card-info blogade" id="cardBAV">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Dokumen Berita Acara Visitasi
                                    
                                    </h3>
 
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$bav->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                @if($detail_pengaju->foto_not_avail == '1')
                                <img class="profile-user-img img-fluid img-circle" src="{{ URL::to('/storagefoto')}}/{{$detail_pengaju->id_user}}.jpg"
                                    alt="User profile picture">
                                @else
                                <img class="profile-user-img img-fluid img-circle" src="{{$detail_pengaju->img_src}}"
                                    alt="User profile picture">
                                @endif
                            </div>
                            <h3 class="profile-username text-center">{{$detail_pengaju->nama}}</h3>
                            <p class="text-muted text-center">{{$detail_pengaju->kompetensi}}</p>
                            <hr />
                            <strong><i class="fas fa-book mr-1"></i> Pendidikan</strong>
                            <p class="text-muted">
                            @if($infonakes->universitas == '')

                            Silahkan Upload Dokumen Ijazah

                            @else
                            {{$infonakes->strata}}, Jurusan {{$infonakes->jurusan}}, {{$infonakes->universitas}}
                            @endif
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                            <p class="text-muted">
                            @if($infonakes->alamat_ktp == '')

                                Silahkan Upload Dokumen KTP

                            @else
                                {{$infonakes->alamat_ktp}}, {{$infonakes->kec_ktp}}, {{$infonakes->kab_ktp}}
                            @endif
                            
                            </p>
                            <hr>
                            @if($infonakes->isdomi == 'D')
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat Domisili</strong>
                            <p class="text-muted">
                            
                                {{$infonakes->alamat_domisili}}, {{$infonakes->kec_domisili}}, {{$infonakes->kab_domisili}}
                          
                            </p>
                            @endif
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Email</strong>
                            <p class="text-muted">{{$detail_pengaju->email}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Pengajuan</b> <a class="float-right">1</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Praktik</b> <a class="float-right">2</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Total Praktik</b> <a class="float-right">10</a>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-block"><b>Profile</b></a>
                        </div>

                    </div>


                </div>

                <div class="col-md-9">
                    
                    
                    <div class="card card-primary">
                        <div class="card-header p-2">
                            Lokasi
                        </div>
                        <div class="card-body">
                            <form style="display:none">
                                <input id="mapidPengajuan" value="{{$id_pengajuan}}">
                                <input id="maplatitude" value="{{$detail_pengajuan->latitude}}">
                                <input id="maplongitude" value="{{$detail_pengajuan->longitude}}">

                            </form>

                               
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <form>
                                        @if($detail_pengajuan->isFaskes == 1)
                                        <div class="row">

                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama Faskes</label>
                                                    <input type="text" id="tNamaFaskesM" name="tNamaFaskesM" class="form-control" value="{{$detail_pengajuan->nama_faskes}}" readonly>
                                                </div>
                                            </div>


                                        </div>

                                        @endif
                                        <div class="row">
                                
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                                                    <input type="text" id="tAlamatPengajuanM" name="tAlamatPengajuanM" class="form-control" value="{{$detail_pengajuan->alamat_pengajuan}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                                    <input type="text" id="tKabupatenM" name="tKabupatenM" class="form-control" value="{{$detail_pengajuan->kabupaten}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                    <input type="text" id="tKecamatanM" name="tKecamatanM" class="form-control" value="{{$detail_pengajuan->kecamatan}}" readonly>
                                                </div>
                                            </div>
                                        </div>     
                                        

                                        <div class="row toevent">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Latitude</label>
                                                    <input type="text" id="tLat" name="tLat" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Longitude</label>
                                                    <input type="text" id="tLong" name="tLong" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        @if($detail_pengajuan->isApproved == 'P2')


                                        <div class="row toevent">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik (Terakhir)</label>
                                                    <div class="card">
                                                        <div class="card-body p-0">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Hari</th>
                                                                        <th>Pukul - Hingga</th>
                                                                        <th>Shift</th>
                                                                        <th>Keterangan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($jadwalbefore as $jadbef)
                                                                    <tr>
                                                                        <td>{{$jadbef->hari}}</td>
                                                                        <td>{{$jadbef->pukul}}</td>
                                                                        <td>{{$jadbef->isShift}}</td>
                                                                        <td> - </td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik (Perubahan)</label>
                                                    <div class="card">
                                                        <div class="card-body p-0">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Hari</th>
                                                                        <th>Pukul - Hingga</th>
                                                                        <th>Shift</th>
                                                                        <th>Keterangan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($jadwalpraktik as $jadual)
                                                                    @if($jadual->levelwarning == 1)
                                                                    <tr style="background-color:orange; color:white">
                                                                    @elseif ($jadual->levelwarning == 2)
                                                                    <tr style="background-color:red; color:white">
                                                                    @else
                                                                    <tr>
                                                                    @endif

                                                                        <td>{{$jadual->hari}}</td>
                                                                        <td>Pukul <b>{{$jadual->mulai}}</b> - Hingga <b>{{$jadual->selesai}}</b></td>
                                                                        <td>
                                                                        @if ($jadual->is_shift == 1)
                                                                            Shift
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        </td>
                                                                        <td>
                                                                        @if ($jadual->iscompromised == 1)
                                                                            @if($jadual->levelwarning == 1)
                                                                            <i class="fas fa-exclamation-triangle"></i>&nbsp; Jarak Jadwal Terlalu Sempit
                                                                            @elseif ($jadual->levelwarning == 2)
                                                                            <i class="fas fa-exclamation-triangle"></i>&nbsp; Jadwal Berbenturan
                                                                            @endif
                                                                            
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        </td>
                                                                    </tr>
                                                                    @if($jadual->iscompromised == 1)
                                                                        @if($jadual->levelwarning == 1)
                                                                            @php
                                                                            $myarray = explode(",",$jadual->keterangan);
                                                                            @endphp
                                                                            @foreach($myarray as $ket)
                                                                                <tr>
                                                                                    <td width="100%" colspan="4"><div class="card"><div class="card-body"><div class="alert alert-warning alert-dismissible">{{$ket}}</div></div></div>
                                                                                    </td><hr>
                                                                                </tr>
                                                                            @endforeach
                                                                        @elseif($jadual->levelwarning == 2)
                                                                            @php
                                                                            $myarray = explode(",",$jadual->keterangan); 
                                                                            @endphp
                                                                            @foreach($myarray as $ket)
                                                                                <tr>
                                                                                    <td width="100%" colspan="4"><div class="card"><div class="card-body"><div class="alert alert-danger alert-dismissible">{{$ket}}</div></div></div>
                                                                                    </td><hr>
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
                                                                    @endif

                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        @else

                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik</label>
                                                    <div class="card">
                                                        <div class="card-body p-0">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Hari</th>
                                                                        <th>Pukul - Hingga</th>
                                                                        <th>Shift</th>
                                                                        <th>Keterangan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($jadwalpraktik as $jadual)
                                                                    @if($jadual->levelwarning == 1)
                                                                    <tr style="background-color:orange; color:white">
                                                                    @elseif ($jadual->levelwarning == 2)
                                                                    <tr style="background-color:red; color:white">
                                                                    @else
                                                                    <tr>
                                                                    @endif

                                                                        <td>{{$jadual->hari}}</td>
                                                                        <td>Pukul <b>{{$jadual->mulai}}</b> - Hingga <b>{{$jadual->selesai}}</b></td>
                                                                        <td>
                                                                        @if ($jadual->is_shift == 1)
                                                                            Shift
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        </td>
                                                                        <td>
                                                                        @if ($jadual->iscompromised == 1)
                                                                            @if($jadual->levelwarning == 1)
                                                                            <i class="fas fa-exclamation-triangle"></i>&nbsp; Jarak Jadwal Terlalu Sempit
                                                                            @elseif ($jadual->levelwarning == 2)
                                                                            <i class="fas fa-exclamation-triangle"></i>&nbsp; Jadwal Berbenturan
                                                                            @endif
                                                                            
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        </td>
                                                                    </tr>
                                                                    @if($jadual->iscompromised == 1)
                                                                        @if($jadual->levelwarning == 1)
                                                                            @php
                                                                            $myarray = explode(",",$jadual->keterangan);
                                                                            @endphp
                                                                            @foreach($myarray as $ket)
                                                                                <tr>
                                                                                    <td width="100%" colspan="4"><div class="card"><div class="card-body"><div class="alert alert-warning alert-dismissible">{{$ket}}</div></div></div>
                                                                                    </td><hr>
                                                                                </tr>
                                                                            @endforeach
                                                                        @elseif($jadual->levelwarning == 2)
                                                                            @php
                                                                            $myarray = explode(",",$jadual->keterangan); 
                                                                            @endphp
                                                                            @foreach($myarray as $ket)
                                                                                <tr>
                                                                                    <td width="100%" colspan="4"><div class="card"><div class="card-body"><div class="alert alert-danger alert-dismissible">{{$ket}}</div></div></div>
                                                                                    </td><hr>
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
                                                                    @endif

                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @endif

                                    </form>
                                </div>
                            </div>

                            <hr />
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="pengajuanmap" id="pengajuanmap" style="height:300px;"></div>
                                </div>
                            </div>

                                @if($detail_pengajuan->isApproved == 'C' || $detail_pengajuan->isApproved == 'CF')
                            
                                    @if ($detail_pengajuan->nama_alasan == '0')
                                        <div class="callout callout-danger">
                                            <h5>Alasan Pencabutan SIP</h5>
                                            <p>{{$detail_pengajuan->alasan}}</p>
                                        </div>
                                        
                                    @else
                                        <div class="callout callout-danger">
                                            <h5><b>Alasan Pencabutan SIP</b></h5>
                                            <p>{{$detail_pengajuan->nama_alasan}}</p>
                                        </div>
                                        
                                    @endif
                                        
                                @endif

                               
                          
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="formVisitasi">
                                        <div class="row">
                                            @if ($detail_pengajuan->isFaskes == 0 && $detail_pengajuan->isApproved != 'P2')
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Visitasi</label>
                                                    @if ($detail_pengajuan->isApproved == 0)
                                                    <input type="date" id="tVisitasi" name="tVisitasi" class="form-control">
                                                    @else
                                                    <input type="text" id="tVisitasiV" name="tVisitasiV" class="form-control" readonly value="{{$detail_pengajuan->tgl_visitasi}}">
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            @if($detail_pengajuan->isApproved == 2 || $detail_pengajuan->isApproved == 'P2')

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Template SIP</label>
                                                    <select class="form-control" id="tTemplateSIP" name="tTemplateSIP">
                                                        @if($detail_pengajuan->template_id == 1)
                                                        
                                                        <option value="1" selected>SIP & SIK Tenaga Kesehatan</option>
                                                        @elseif($detail_pengajuan->template_id == 2)
                                                        <option value="2" selected>SIP DOKTER</option>
                                                        

                                                        @elseif($detail_pengajuan->template_id == 3)
                                                        <option value="3" selected>SIP TTK</option>
                                                        

                                                        @else
                                                        <option value="4" selected>SIP Apoteker Penanggungjawab</option>

                                                        @endif
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                                

                                            @endif
                                        </div>
                                    </form>
                                    <!--<button id="getallin" class="btn btn-danger">testsing</div>-->
                                    <div class="row">
                                        <div class="col-md-12" id="buttonall">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        
                            <!-- @if ($detail_pengajuan->updated_by_op == '0')
                                
                            <div class="card-footer" id="updatebyop">
                                <button class="btn btn-success" id="setujubyop" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}">Setujui</button>
                            </div>
                            
                            @else
                            <div class="card-footer" id="setujudinkes">
                                <div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> e-SIP Sudah Di-review</h5>
                                </div>
                            </div>

                            @endif -->
                  
                        <div class="overlay" id="lagisubmitdraft" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
  


  

@endsection
@section('js')

@endsection