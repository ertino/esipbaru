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
            <div class="row">
                <div class="card card-primary card-outline">
                    <div class="card-header card-header d-flex p-0">
                        <h3 class="card-title">
                            Dokumen Pengajuan
                        </h3>
                        <div class="nav nav-pills ms-auto p-2">
                            <input type="checkbox" onchange="hideme()">Ya
                        </div>
                        <script>
                            function hideme(){
                                $('#jajalan').hide()
                            }
                        </script>

                    </div>
                    <div class="card-body">
                    
                        <div class="kekanan">
                            <div class="card card-row card-secondary blogade" style="width: 25rem;" id="jajalan">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Backlog
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="card card-info card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title">Create Labels</h5>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-tool btn-link">#3</a>
                                                <a href="#" class="btn btn-tool">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheckbox1" disabled="">
                                                <label for="customCheckbox1" class="form-check-label">Bug</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheckbox2" disabled="">
                                                <label for="customCheckbox2" class="form-check-label">Feature</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheckbox3" disabled="">
                                                <label for="customCheckbox3" class="form-check-label">Enhancement</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheckbox4" disabled="">
                                                <label for="customCheckbox4" class="form-check-label">Documentation</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="customCheckbox5" disabled="">
                                                <label for="customCheckbox5" class="form-check-label">Examples</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="card card-row card-primary blogade" style="width: 25rem;">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        To Do
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title">Create first milestone</h5>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-tool btn-link">#5</a>
                                                <a href="#" class="btn btn-tool">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-row card-default blogade" style="width: 25rem;">
                                <div class="card-header bg-info">
                                    <h3 class="card-title">
                                        In Progress
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="card card-light card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title">Update Readme</h5>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-tool btn-link">#2</a>
                                                <a href="#" class="btn btn-tool">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
                                                Aenean commodo ligula eget dolor. Aenean massa.
                                                Cum sociis natoque penatibus et magnis dis parturient montes,
                                                nascetur ridiculus mus.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-row card-success blogade" style="width: 25rem;">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Done
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title">Create repo</h5>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-tool btn-link">#1</a>
                                                <a href="#" class="btn btn-tool">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                
                            
                        </div>
                    </div>
                </div>
            <div>
            <div class="row">
                <div class="col-md-3">

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid rounded-circle" src="{{ asset('imguser/').'/'.$fotopengaju }}"
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">Nina Mcintire</h3>
                            <p class="text-muted text-center">Software Engineer</p>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Followers</b> <a class="float-end">1,322</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Following</b> <a class="float-end">543</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Friends</b> <a class="float-end">13,287</a>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
                        </div>

                    </div>


                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>

                        <div class="card-body">
                            <strong><i class="fas fa-book me-1"></i> Education</strong>
                            <p class="text-muted">
                                B.S. in Computer Science from the University of Tennessee at Knoxville
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt me-1"></i> Location</strong>
                            <p class="text-muted">Malibu, California</p>
                            <hr>
                            <strong><i class="fas fa-pencil-alt me-1"></i> Skills</strong>
                            <p class="text-muted">
                                <span class="tag tag-danger">UI Design</span>
                                <span class="tag tag-success">Coding</span>
                                <span class="tag tag-info">Javascript</span>
                                <span class="tag tag-warning">PHP</span>
                                <span class="tag tag-primary">Node.js</span>
                            </p>
                            <hr>
                            <strong><i class="far fa-file-alt me-1"></i> Notes</strong>
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum
                                enim neque.</p>
                        </div>

                    </div>

                </div>

                <div class="col-md-9">
                    
                    
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item" style="display:none"><a class="nav-link active" href="#activity"
                                        data-bs-toggle="tab">Dokumen</a></li>
                                <li class="nav-item"><a class="nav-link bukapeta" data-id="{{$id_pengajuan}}" data-lat="{{$detail_pengajuan->latitude}}" data-long="{{$detail_pengajuan->longitude}}" href="#timeline" data-bs-toggle="tab">Lokasi</a>
                                </li>
                                <!--<li class="nav-item"><a class="nav-link" href="#settings" data-bs-toggle="tab">Settings</a>
                                </li> -->
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">

                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                        @if (count($doc_stp) == 0)
                                            <div class="thumbnail">
                                                <center><div class="position-relative">
                                                <i class="fa fa-ban" style="font-size:150px" data-jenis="STP" data-judul="STP" ></i>
                                                </div></center>

                                                <div class="caption card-footer text-center">
                                                    <ul class="list-inline">
                                                    <li><i class="people lighter"></i>&nbsp;Silahkan Upload STP</li>
                                                    <li></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                    <img style="width: 100%; display: block;" src="{{ asset('images/docs/STP.png')}}" alt="image">
                                                </div>
                                                <div class="mask">
                                                    <p>STP</p>
                                                    <div class="tools tools-bottom">
                                                        <p><a href="{{ route('download.the.file', $doc_stp[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                        <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                        <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>

                                        <div class="col-sm-4 col-xs-12">
                                        @if (count($doc_sks) == 0)
                                            <div class="thumbnail">
                                                <center><div class="position-relative">
                                                <i class="fa fa-ban" style="font-size:150px" data-jenis="SKS" data-judul="Surat Keterangan Sehat"></i>
                                                </div></center>

                                                <div class="caption card-footer text-center">
                                                    <ul class="list-inline">
                                                    <li><i class="people lighter"></i>&nbsp;Silahkan Upload Surat Keterangan Sehat</li>
                                                    <li></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                
                                                    <img style="width: 100%; display: block;" src="{{ asset('images/docs/sks.png')}}" alt="image">
                                                
                                                </div>
                                                <div class="mask">
                                                    <p>Surat Keterangan Sehat</p>
                                                    <div class="tools tools-bottom">
                                                        <p><a href="{{ route('download.the.file', $doc_sks[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                        <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                        <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>

                                        <div class="col-sm-4 col-xs-12">
                                        @if (count($doc_sptp) == 0)
                                            <div class="thumbnail">
                                                <center><div class="position-relative">
                                                <i class="fa fa-ban" style="font-size:150px" data-jenis="SPTP" data-judul="Surat Pernyataaan Tempat Praktik" ></i>
                                                </div></center>

                                                <div class="caption card-footer text-center">
                                                    <ul class="list-inline">
                                                    <li><i class="people lighter"></i>&nbsp;Silahkan Upload Surat Pernyataan Tempat Praktik</li>
                                                    <li></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                
                                                    <img style="width: 100%; display: block;" src="{{ asset('images/docs/sptp.png')}}" alt="image">
                                                
                                                </div>
                                                <div class="mask">
                                                    <p>Surat Pernyataan Tempat Praktik</p>
                                                    <div class="tools tools-bottom">
                                                        <p><a href="{{ route('download.the.file', $doc_sptp[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                        <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                        <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>
                                        
                                    </div>
                                    <hr />
                                    <div class="row">

                                        <div class="col-sm-4 col-xs-12">
                                        @if (count($doc_ijazah) == 0)
                                            <div class="thumbnail">
                                                <center><div class="position-relative">
                                                <i class="fa fa-ban" style="font-size:150px" data-jenis="IJAZAH" data-judul="Ijazah"></i>
                                                </div></center>

                                                <div class="caption card-footer text-center">
                                                    <ul class="list-inline">
                                                    <li><i class="people lighter"></i>&nbsp;Silahkan Upload Ijazah</li>
                                                    <li></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="thumbnail">
                                                <div class="image view view-first"> 
                                                    <img style="width: 100%; display: block;" src="{{ asset('images/docs/ijazah.png')}}" alt="image">
                                                </div>
                                                <div class="mask">
                                                    <p>Ijazah</p>
                                                    <div class="tools tools-bottom">
                                                        <p><a href="{{ route('download.the.file', $doc_ijazah[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                        <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                        <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>

                                        <div class="col-sm-4 col-xs-12">
                                        @if (count($doc_skp) == 0)
                                            <div class="thumbnail">
                                                <center><div class="position-relative">
                                                <i class="fa fa-ban" style="font-size:150px" data-jenis="SKP" data-judul="Surat Keterangan Pimpinan"></i>
                                                </div></center>

                                                <div class="caption card-footer text-center">
                                                    <ul class="list-inline">
                                                    <li><i class="people lighter"></i>&nbsp;Silahkan Upload Surat Keterangan Pimpinan</li>
                                                    <li></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="thumbnail">
                                                <div class="image view view-first"> 
                                                    <img style="width: 100%; display: block;" src="{{ asset('images/docs/skp.png')}}" alt="image">
                                                </div>
                                                <div class="mask">
                                                    <p>Surat Keterangan Pimpinan</p>
                                                    <div class="tools tools-bottom">
                                                        <p><a href="{{ route('download.the.file', $doc_skp[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                        <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                        <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>

                                        <div class="col-sm-4 col-xs-12">
                                        @if (count($doc_foto) == 0)
                                            <div class="thumbnail">
                                                <center><div class="position-relative">
                                                <i class="fa fa-ban" style="font-size:150px" data-jenis="FOTO" data-judul="Foto" ></i>
                                                </div></center>

                                                <div class="caption card-footer text-center">
                                                    <ul class="list-inline">
                                                    <li><i class="people lighter"></i>&nbsp;Silahkan Upload Foto</li>
                                                    <li></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                
                                                    <img style="width: 100%; display: block;" src="" alt="image">
                                                
                                                </div>
                                                <div class="mask">
                                                    <p>Pas Foto</p>
                                                    <div class="tools tools-bottom">
                                                        <p><a href="" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                        <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                        <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>

                                    </div>
                                    <hr />
                                    <div class="row">

                                        <div class="col-sm-6 col-xs-12">
                                        @if (count($doc_rekomdk) == 0)
                                            <div class="thumbnail">
                                                <center><div class="position-relative">
                                                <i class="fa fa-ban" style="font-size:150px" data-jenis="REKOMDK"  data-judul="Rekomendasi Dinas Kesehatan"></i>
                                                </div></center>

                                                <div class="caption card-footer text-center">
                                                    <ul class="list-inline">
                                                    <li><i class="people lighter"></i>&nbsp;Silahkan Upload Rekomendasi Dinas Kesehatan</li>
                                                    <li></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                
                                                    <img style="width: 100%; display: block;" src="{{ asset('images/docs/rekomdinkes.png')}}" alt="image">
                                                
                                                </div>
                                                <div class="mask">
                                                    <p>Rekomendasi Kepala Dinas Kesehatan</p>
                                                    <div class="tools tools-bottom">
                                                        <p><a href="{{ route('download.the.file', $doc_rekomdk[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                        <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                        <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>

                                        <div class="col-sm-6 col-xs-12">
                                        @if (count($doc_rekomp) == 0)
                                            <div class="thumbnail">
                                                <center><div class="position-relative">
                                                <i class="fa fa-ban" style="font-size:150px" data-jenis="REKOMP" data-judul="Rekomendasi Organisasi Profesi"></i>
                                                </div></center>

                                                <div class="caption card-footer text-center">
                                                    <ul class="list-inline">
                                                    <li><i class="people lighter"></i>&nbsp;Silahkan Upload Rekomendasi Organisasi Profesi</li>
                                                    <li></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="thumbnail">
                                                <div class="image view view-first">
                                                
                                                    <img style="width: 100%; display: block;" src="{{ asset('images/docs/rekomprofesi.png')}}" alt="image">
                                                
                                                </div>
                                                <div class="mask">
                                                    <p>Rekomendasi Organisasi Profesi</p>
                                                    <div class="tools tools-bottom">
                                                        <p><a href="{{ route('download.the.file', $doc_rekomp[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                        <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                        <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        </div>

                                    </div>
                                    

                                </div>

                                <div class="tab-pane" id="timeline">

                                    <div class="row">
                                        <form>
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
                                        </form>
                                    </div>

                                    <hr />
                                    
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="pengajuanmap" id="pengajuanmap" style="height:300px;"></div>
                                        </div>
                                    </div>
                                
                                </div>

                                <div class="tab-pane" id="settings">
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputName" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" id="inputEmail"
                                                    placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputName2" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputName2" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputExperience" class="col-sm-2 col-form-label">Experience</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="inputExperience"
                                                    placeholder="Experience"></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="inputSkills" class="col-sm-2 col-form-label">Skills</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="inputSkills"
                                                    placeholder="Skills">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox"> I agree to the <a href="#">terms and
                                                            conditions</a>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button type="submit" class="btn btn-danger">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if ($detail_pengajuan->isApproved == 0)
                        <div class="card-footer" id="setujudinkes">
                            <button class="btn btn-info" id="setujupengajuandinkes" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}">Setujui</button>
                            <button class="btn btn-danger" id="tolakpengajuan" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}">Tolak</button>
                        </div>
                        @elseif ($detail_pengajuan->isApproved == 1)
                        <div class="card-footer" id="setujuptspnya">
                            <button class="btn btn-info" id="setujuptsp" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}">Setujui</button>
                            <button class="btn btn-danger" id="tolakpengajuan" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}">Tolak</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
  


  

@endsection
@section('js')

@endsection