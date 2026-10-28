@extends('layouts.minlte.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang Di e-SIP</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div id="modal-content" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Rubah Password</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="changepassnakes" action="" method="post" class="form-horizontal">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Password Baru</label>
                                                    <div class="input-group input-group">
                                                        <input type="password" class="form-control" id="newpassword" name="newpassword">
                                                        <span class="input-group-append">
                                                        <button type="button" class="btn btn-default btn-flat intippass"><i class="fas fa-eye"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Konfirmasi Password Baru</label>
                                                    <div class="input-group input-group">
                                                        <input type="password" class="form-control" id="newpasswordc" name="newpasswordc">
                                                        <span class="input-group-append">
                                                        <button type="button" class="btn btn-default btn-flat intippass"><i class="fas fa-eye"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form> 
                                    <button type="button" class="btn btn-success" id="submitubahpassnakes" data-id="{{$user_id}}">Update</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary float-right" id="close-modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid custom-rounded" src="{{ URL::to('/storagefoto')}}/{{$detail_pengaju->saved_photo}}"
                                    alt="User profile picture">
                            </div>
                            <hr />
                            <h3 class="profile-username text-center">{{Auth::user()->name;}}</h3>
                            <p class="text-muted text-center">{{$profesi}}</p>
                        
                        </div>

                    </div>


                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Tentang Saya</h3>
                        </div>

                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i> Pendidikan</strong>
                            <p class="text-muted">
                            @if($infonakes->universitas == '')

                                Silahkan Upload Dokumen Ijazah

                            @else
                                {{$infonakes->strata}}, Jurusan {{$infonakes->jurusan}}, {{$infonakes->universitas}}
                            @endif
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat KTP</strong>
                            <p class="text-muted">
                            @if($infonakes->alamat_ktp == '')

                                Silahkan Upload Dokumen KTP

                            @else
                                {{$infonakes->alamat_ktp}}, {{$infonakes->kec_ktp}}, {{$infonakes->kab_ktp}}
                            @endif
                            </p>

                            @if($infonakes->isdomi == 'D')
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat Domisili</strong>
                            <p class="text-muted">
                            
                                {{$infonakes->alamat_domisili}}, {{$infonakes->kec_domisili}}, {{$infonakes->kab_domisili}}
                          
                            </p>
                            @endif
                            <hr>
                            <strong><i class="far fa-file-alt mr-1"></i> Email</strong>
                            <p class="text-muted">{{$email}}</p>
                        </div>

                    </div>

                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <ul class="nav nav-pills">
                                    <li class="nav-item" style="display:none"><a class="nav-link" href="#activity"
                                            data-toggle="tab">Personal Info</a></li>
                                    <li class="nav-item"><a class="nav-link active" href="#timeline" data-toggle="tab">Jadwal Praktik</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Personal Info</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary float-right" id="btnUbahPass">Ubah Password</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane" id="activity">

                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg"
                                                alt="user image">
                                            <span class="username">
                                                <a href="#">Jonathan Burke Jr.</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            <span class="description">Shared publicly - 7:30 PM today</span>
                                        </div>

                                        <p>
                                            Lorem ipsum represents a long-held tradition for designers,
                                            typographers and the like. Some people hate it and argue for
                                            its demise, but others ignore the hate as they create awesome
                                            tools to help create filler text for everyone from bacon lovers
                                            to Charlie Sheen fans.
                                        </p>
                                        <p>
                                            <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>
                                                Share</a>
                                            <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
                                                Like</a>
                                            <span class="float-right">
                                                <a href="#" class="link-black text-sm">
                                                    <i class="far fa-comments mr-1"></i> Comments (5)
                                                </a>
                                            </span>
                                        </p>
                                        <input class="form-control form-control-sm" type="text"
                                            placeholder="Type a comment">
                                    </div>


                                    <div class="post clearfix">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="../../dist/img/user7-128x128.jpg"
                                                alt="User Image">
                                            <span class="username">
                                                <a href="#">Sarah Ross</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            <span class="description">Sent you a message - 3 days ago</span>
                                        </div>

                                        <p>
                                            Lorem ipsum represents a long-held tradition for designers,
                                            typographers and the like. Some people hate it and argue for
                                            its demise, but others ignore the hate as they create awesome
                                            tools to help create filler text for everyone from bacon lovers
                                            to Charlie Sheen fans.
                                        </p>
                                        <form class="form-horizontal">
                                            <div class="input-group input-group-sm mb-0">
                                                <input class="form-control form-control-sm" placeholder="Response">
                                                <div class="input-group-append">
                                                    <button type="submit" class="btn btn-danger">Send</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                    <div class="post">
                                        <div class="user-block">
                                            <img class="img-circle img-bordered-sm" src="../../dist/img/user6-128x128.jpg"
                                                alt="User Image">
                                            <span class="username">
                                                <a href="#">Adam Jones</a>
                                                <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                                            </span>
                                            <span class="description">Posted 5 photos - 5 days ago</span>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-sm-6">
                                                <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <img class="img-fluid mb-3" src="../../dist/img/photo2.png"
                                                            alt="Photo">
                                                        <img class="img-fluid" src="../../dist/img/photo3.jpg" alt="Photo">
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <img class="img-fluid mb-3" src="../../dist/img/photo4.jpg"
                                                            alt="Photo">
                                                        <img class="img-fluid" src="../../dist/img/photo1.png" alt="Photo">
                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                        <p>
                                            <a href="#" class="link-black text-sm mr-2"><i class="fas fa-share mr-1"></i>
                                                Share</a>
                                            <a href="#" class="link-black text-sm"><i class="far fa-thumbs-up mr-1"></i>
                                                Like</a>
                                            <span class="float-right">
                                                <a href="#" class="link-black text-sm">
                                                    <i class="far fa-comments mr-1"></i> Comments (5)
                                                </a>
                                            </span>
                                        </p>
                                        <input class="form-control form-control-sm" type="text"
                                            placeholder="Type a comment">
                                    </div>

                                </div>

                                <div class="tab-pane active" id="timeline">

                                    @foreach($approvedsip as $detail_pengajuan)

                                    <div class="invoice p-3 mb-3">

                                        <div class="row">
                                            <div class="col-12">
                                            @if($detail_pengajuan->nama_faskes != '')
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
                                                            <input type="text" id="tAlamatPengajuanM" name="tAlamatPengajuanM" class="form-control" value="{{$detail_pengajuan->nama_lokasi}}" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                                            <input type="text" id="tKabupatenM" name="tKabupatenM" class="form-control" value="{{$detail_pengajuan->kab_lokasi}}" readonly>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                            <input type="text" id="tKecamatanM" name="tKecamatanM" class="form-control" value="{{$detail_pengajuan->kec_lokasi}}" readonly>
                                                        </div>
                                                    </div>
                                                </div>     
                                        
                                            </div>

                                        </div>


                                        <div class="row">
                                            <div class="col-12 table-responsive">
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
                                                    @foreach($semuajadwal as $jad)
                                                        @if($jad->id_pengajuan == $detail_pengajuan->id_pengajuan)
                                                            <tr>
                                                                <td>{{$jad->hari}}</td>
                                                                <td>Pukul {{$jad->mulai}} Hingga {{$jad->selesai}}</td>
                                                                <td>{{$jad->is_shift}}</td>
                                                                <td>{{$jad->keterangan}}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                    @endforeach
                                    
                                </div>

                                <div class="tab-pane" id="settings">
                                    <form id="editprofilenakes" action="{{ route('submit.personalinfo.nakes') }}" method="post" class="form-horizontal">
                                    @csrf
                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                                    <input type="text" id="useridprof" name="useridprof" value="{{$user_id}}" class="form-control domprof" >
                                                </div>
                                            </div>
                                        </div>
                                    

                                        @if($infonakes->isdomi == 'D')

                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Alamat Domisili</label>
                                                    <input type="checkbox" id="ifdomprof" name="ifdomprof" value="1"/> (Sesuai KTP)
                                                    <input type="text" id="nakes_aldom" name="nakes_aldom" value="{{$infonakes->alamat_domisili}}" class="form-control domprof" >
                                                </div>
                                            </div>

                                            <div class="col-md-3" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kecamatan Domisili</label>
                                                    <input type="text" id="nakes_kecdom" name="nakes_kecdom" value="{{$infonakes->kec_domisili}}"  class="form-control domprof" >
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kabupaten Domisili</label>
                                                    <input type="text" id="nakes_kabdom" name="nakes_kabdom"  class="form-control domprof" value="{{$infonakes->kab_domisili}}">
                                                </div>
                                            </div>

                                            

                                        </div>  
                                        <hr>
                                        @endif
                                        

                                        @if(!empty($personal_info->id_user))
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Golongan Darah</label>
                                                    <input type="text" id="nakes_goldar" name="nakes_goldar" value="{{$personal_info->gol_darah}}" class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Riwayat Penyakit</label>
                                                    <input type="text" id="nakes_riwayatsk" name="nakes_riwayatsk" value="{{$personal_info->riwayat_penyakit}}"  class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No BPJS</label>
                                                    <input type="text" id="nakes_nobpjs" name="nakes_nobpjs"  class="form-control" value="{{$personal_info->no_bpjs}}">
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="row">

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Pendidikan SD</label>
                                                    <input type="text" id="nakes_sd" name="nakes_sd" value="{{$personal_info->pendidikan_sd}}"  class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Pendidikan SMP</label>
                                                    <input type="text" id="nakes_smp" name="nakes_smp" value="{{$personal_info->pendidikan_smp}}" class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Pendidikan SMA</label>
                                                    <input type="text" id="nakes_sma" name="nakes_sma" value="{{$personal_info->pendidikan_sma}}" class="form-control" >
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row">

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Sertifikasi (Jika Ada)</label>
                                                    <input type="text" id="nakes_sertifikasi1" name="nakes_sertifikasi1" value="{{$personal_info->remark}}"  class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Sertifikasi (Jika Ada)</label>
                                                    <input type="text" id="nakes_sertifikasi2" name="nakes_sertifikasi2" value="{{$personal_info->remark2}}"  class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Sertifikasi (Jika Ada)</label>
                                                    <input type="text" id="nakes_sertifikasi3" name="nakes_sertifikasi3" value="{{$personal_info->remark3}}"  class="form-control" >
                                                </div>
                                            </div>
                                        </div>  
                                        @else

                                        <div class="row">

                                            <div class="col-md-5" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Riwayat Penyakit</label>
                                                    <input type="text" id="nakes_riwayatsk" name="nakes_riwayatsk" value=""  class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Golongan Darah</label>
                                                    <input type="text" id="nakes_goldar" name="nakes_goldar" value="" class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No BPJS</label>
                                                    <input type="text" id="nakes_nobpjs" name="nakes_nobpjs"  class="form-control" value="">
                                                </div>
                                            </div>
                                        </div>  

                                        <hr>

                                        <div class="row">

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Pendidikan SD</label>
                                                    <input type="text" id="nakes_sd" name="nakes_sd" value=""  class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Pendidikan SMP</label>
                                                    <input type="text" id="nakes_smp" name="nakes_smp" value="" class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Pendidikan SMA</label>
                                                    <input type="text" id="nakes_sma" name="nakes_sma" value="" class="form-control" >
                                                </div>
                                            </div>

                                        </div>


                                        <div class="row">

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Sertifikasi (Jika Ada)</label>
                                                    <input type="text" id="nakes_sertifikasi1" name="nakes_sertifikasi1" value=""  class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Sertifikasi (Jika Ada)</label>
                                                    <input type="text" id="nakes_sertifikasi2" name="nakes_sertifikasi2" value=""  class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Sertifikasi (Jika Ada)</label>
                                                    <input type="text" id="nakes_sertifikasi3" name="nakes_sertifikasi3" value=""  class="form-control" >
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <div class="form-group">
                                            
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                            
                                        </div>
                                    </form>
                                </div>
                            </div>
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