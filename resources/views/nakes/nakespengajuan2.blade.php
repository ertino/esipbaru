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
                <div id="modal-tunggujadwal-content" style="display: none;">
                    <center>
                    <i class="fas fa-hourglass"></i>
                    <h5>Mohon Tunggu..</h5>
                    </center>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">

                @if ($dokumenissue ?? '' > 0)
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Langkah Pengajuan</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible">
                                    <h5><i class="icon fas fa-ban"></i> DOKUMEN HARUS DIPERBAHARUI!</h5>
                                    Silahkan Update Dokumen Yang Harus Diperbaiki Terlebih Dahulu <a href="{{route('nakes.documents')}}">Disini</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>     
                @else
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">Langkah Pengajuan</h3>
                        </div>
                        <div class="card-body p-0">
                            <div class="bs-stepper linear">
                                <div class="bs-stepper-header" role="tablist">
                                    <div class="step" data-target="#lokasi-part">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="lokasi-part" id="lokasi-part-trigger" aria-selected="false" disabled="disabled">
                                            <span class="bs-stepper-circle">1</span>
                                            <span class="bs-stepper-label">Lokasi</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step active" data-target="#information-part">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="true">
                                            <span class="bs-stepper-circle">2</span>
                                            <span class="bs-stepper-label">Dokumen</span>
                                        </button>
                                    </div>
                                    <div class="line"></div>
                                    <div class="step" data-target="#jadwal-part">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="jadwal-part" id="jadwal-part-trigger" aria-selected="true">
                                            <span class="bs-stepper-circle">3</span>
                                            <span class="bs-stepper-label">Jadwal Praktik</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="bs-stepper-content">
                                    <div id="lokasi-part" class="content" role="tabpanel" aria-labelledby="lokasi-part-trigger">
                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            Peta Lokasi Pengajuan
                                                        </h3>
                                                        <div class="card-tools">
                                                            <div class="btn-group show">
                                                                <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">Tambah Pengajuan &nbsp; &nbsp<span class="sr-only">Toggle Dropdown</span></button>
                                                                <div class="dropdown-menu" role="menu" style="">
                                                                    <a class="dropdown-item" style="color:black;" id="addajumandiri" data-stp="{{count($doc_str)}}" data-sks="{{count($doc_sks)}}" data-sptp="{{count($doc_sptp)}}" data-ijazah="{{count($doc_ijazah)}}" data-skp="{{count($doc_skp)}}" data-rekomp="{{count($doc_rekomp)}}" data-ktp = "{{count($doc_ktp)}}" >Mandiri</a>
                                                                    <a class="dropdown-item" style="color:black;" id="addajufaskes" data-stp="{{count($doc_str)}}" data-sks="{{count($doc_sks)}}" data-sptp="{{count($doc_sptp)}}" data-ijazah="{{count($doc_ijazah)}}" data-skp="{{count($doc_skp)}}" data-rekomp="{{count($doc_rekomp)}}" data-ktp = "{{count($doc_ktp)}}" data-id="{{$user_id}}">Faskes</a>
                                                                </div>
                                                            </div>
                                                            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                                                <i class="fas fa-expand"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <p>Silahkan Klik Pada Peta Untuk Pointing Lokasi Pengajuan</p>
                                                        <div class="setelahpilih" id="pengajuanmap" style="height:300px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        
                                            <form enctype="multipart/form-data" id="formPengajuanM" action="{{ route('nakes.submit.pengajuanM') }}" method="post" class="form-horizontal">
                                            @csrf

                                            <div class="row" style="display:none">
                                                <div class="col-md-4" style="display:none">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">is Tolak</label>
                                                        <input type="text" id="isTolakJadwal" name="isTolakJadwal" class="form-control" value="0">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row setelahpilih" style="display:none">

                                                <div class="col-md-6 jikafaskes">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Nama Faskes</label>
                                                        <input type="text" id="tNamaFaskes" name="tNamaFaskes" class="form-control" value="0" readonly>
                                                    </div>
                                                </div>

                                            
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                                                        <input type="text" id="tAlamatPengajuanM" name="tAlamatPengajuanM" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row setelahpilih" style="display:none">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                                        <input type="text" id="tKabupatenM" name="tKabupatenM" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                        <input type="text" id="tKecamatanM" name="tKecamatanM" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row setelahpilih" style="display:none">
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Latitude</label>
                                                        <input type="text" id="tLat" name="tLat" class="form-control" placeholder="Klik Pada Peta">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Longitude</label>
                                                        <input type="text" id="tLong" name="tLong" class="form-control" placeholder="Klik Pada Peta">
                                                    </div>
                                                </div>
                                                <div class="col-md-2" style="display:none">
                                                    <div class="form-group">
                                                        <label for='exampleFormControlSelect1' class="ms-0">&nbsp;</label>
                                                        <input type="text" id="tidDocStr" nama="tidDocStr" class="form-control" value="{{$id_doc_str}}">
                                                    </div>
                                                </div>
                                            </div>  
                                       
                                        <button type="button" class="btn btn-primary" id="stepsatu" style="display:none" onclick="stepper.next()">Lanjut</button>
                                    </div>
                                    <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">

                                    <hr />

                                    <div class="row toevent" @if ($currentstrdetail[0]->template_id == '1' || $currentstrdetail[0]->template_id == '2') style="display:none" @endif>
                                        <div class="col-md-6">
                                        @if($currentstrdetail[0]->template_id == '1' || $currentstrdetail[0]->template_id == '2')

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="templateprofesi" value="{{$currentstrdetail[0]->template_id}}" checked>
                                                <label for="exampleFormControlSelect1" class="ms-0" >TID</label>
                                            </div>

                                        @else
                                            <label for="exampleFormControlSelect1" class="ms-0" >Pengajuan Sebagai:</label>
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="templateprofesi" value="3"  @if($currentstrdetail[0]->template_id == '3') checked @endif>
                                                    <label for="exampleFormControlSelect1" class="ms-0" >Apoteker / TTK</label>
                                                </div>
                                                <div class="form-check form-check-inline mt-2">
                                                    <input class="form-check-input" type="radio" name="templateprofesi" value="4" @if($currentstrdetail[0]->template_id == '4') checked @endif>
                                                <label for="exampleFormControlSelect1" class="ms-0">Apoteker / TTK Penanggung Jawab</label>
                                                </div>
                                            </div>
                                        @endif
                                        </div>
                                    </div>  

                                    @if($currentstrdetail[0]->template_id == '2' && $subspesialis != '0')

                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">

                                        <label for="exampleFormControlSelect1" class="ms-0" >Pengajuan Untuk Spesialis / Subspesialis:</label>
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="kompetensipilihan" value="0" checked>
                                                <label for="exampleFormControlSelect1" class="ms-0" >Spesialis</label>
                                            </div>
                                            <div class="form-check form-check-inline mt-2">
                                                <input class="form-check-input" type="radio" name="kompetensipilihan" value="{{$subspesialis}}">
                                            <label for="exampleFormControlSelect1" class="ms-0">{{$subspesialis}}</label>
                                            </div>
                                        </div>
                                        </div>

                                    </div>

                                    @endif
                                    <hr />
                                
                                    <div class="row" style="display:none">
                            
                                        <div class="col-md-4" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">File Surat Tempat Praktik</label>
                                                <input type="file" id="tFileSTP" name="tFileSTP" class="form-control" accept=".pdf">
                                            </div>
                                        </div>

                                        <div class="col-md-4" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Nomor Surat Tempat Praktik</label>
                                                <input type="text" id="tNoSTP" name="tNoSTP" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-4" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Tanggal Surat Tempat Praktik</label>
                                                <input type="date" id="tTglSTP" name="tTglSTP" class="form-control">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="row" id="keteranganpimp">
                                
                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">File Surat Keterangan Pimpinan</label>
                                                    <input type="file" id="tFileSKP" name="tFileSKP" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nomor Surat Keterangan Pimpinan</label>
                                                    <input type="text" id="tNoSKP" name="tNoSKP" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Surat Keterangan Pimpinan</label>
                                                    <input type="date" id="tTglSKP" name="tTglSKP" class="form-control" required>
                                                </div>
                                            </div>

                                        </div>  

                           
                                        <div class="row" id="tosktp">
                                
                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Permohonan Surat Keterangan Tempat Praktik (SKTP)</label>
                                                    <input type="file" id="tFileSKTP" name="tFileSKTP" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nomor SKTP (Jika Ada)</label>
                                                    <input type="text" id="tNoSKTP" name="tNoSKTP" class="form-control" value="-">
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Permohonan SKTP</label>
                                                    <input type="date" id="tTglSKTP" name="tTglSKTP" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="exampleFormControlSelect1" class="ms-0">Download & Contoh Format</label>
                                                <div class="btn-group form-control">
                                                <a class="btn btn-success btn-sm" type="button" target="_blank" href="{{ URL::to('/storageform')}}/{{$jenis_form}}.docx">Download</a>
                                                <a class="btn btn-info btn-sm" type="button" target="_blank" >Contoh</a>
                                                </div>

                                            </div>

                                        </div> 

                                        <div class="row" style="display:none">
                                            <div class="col-md-4" >
                                                <div class="form-group" >
                                                    <label for="exampleFormControlSelect1" class="ms-0">File Serkom / SKP (Satuan Kredit Profesi) <button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#contohskpmodal">?</button></label>
                                                    <input type="file" id="tFileSKSKP" name="tFileSKSKP" class="form-control" accept=".pdf">
                                                </div>
                                            </div>

                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nomor Serkom / SKP</label>
                                                    <input type="text" id="tNoSKSKP" name="tNoSKSKP" class="form-control" placeholder="Isikan Strip (-) Jika Tidak Ada Nomor">
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Serkom / SKP</label>
                                                    <input type="date" id="tTglSKSKP" name="tTglSKSKP" class="form-control" value="{{date('Y-m-d')}}">
                                                </div>
                                            </div>

                                        </div>

                                        <button type="button" class="btn btn-primary" type="button" onclick="stepper.previous()">Sebelumnya</button>
                                        <button type="button" class="btn btn-primary" onclick="stepper.next()">Lanjut</button>
                                    </div>
                                    <div id="jadwal-part" class="content" role="tabpanel" aria-labelledby="jadwal-part-trigger">

                                        <div class="row toevent">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik</label>
                                                <div class="row" id="tosktp">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                        <label for="tprompt" class="ms-0">Coba Isikan Prompt *</label>
                                                        <div class="input-group">
                                                            <input type="text" id="tprompt" name="tprompt" class="form-control" placeholder="Senin sampai Kamis pukul 08:00 sampai 14:00, uraian: shift, Jumat pukul 09:00 sampai 15:00, uraian: shift">
                                                            <button class="btn btn-primary" type="button" id="generateprompt">Generate</button>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card card-warning">
                                                    <div class="card-body table-responsive p-0">
                                                        
                                                        <table class="table table-striped" id="_jadwalpraktiknakes" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th width="25%">Hari</th>
                                                                    <th width="45%" colspan="2">Dari - Hingga</th>
                                                                    <th width="15%">Shift</th>
                                                                    <th width="15%">Uraian</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr id="larik_1">
                                                                    <td width="25%"><input type="checkbox" name="phari_1" id="phari_1" class="ms-0 pilihhari" data="1"> Senin</td>
                                                                    <td width="40%"><div id="jam_1" style="display:none"><input type="time" name="start_1" id="start_1" class="ms-0" value="08:00"> - <input type="time" name="end_1" id="end_1" class="ms-0" value="12:00"></div></td>
                                                                    <td id="detailc1" class="details-control"><div id="1alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                                    <td width="5%"><input type="checkbox" name="isshift_1" class="ms-0" id="isshift_1" style="display:none"></td>
                                                                    <td width="25%"><textarea type="text" name="isuraian_1" class="ms-0" id="isuraian_1" style="display:none"></textarea></td>
                                                                </tr>
                                                                <tr id="cekresult_1" class="tampilnongol" style="display:none">
                                                                </tr>
                                                                <tr id="larik_2">
                                                                    <td width="25%"><input type="checkbox" name="phari_2" id="phari_2" class="ms-0 pilihhari" data="2"> Selasa</td>
                                                                    <td width="40%"><div id="jam_2" style="display:none"><input type="time" name="start_2" id="start_2" class="ms-0" value="08:00"> - <input type="time" name="end_2" id="end_2" class="ms-0" value="12:00"></div></td>
                                                                    <td id="detailc2" class="details-control"><div id="2alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                                    <td width="5%"><input type="checkbox" name="isshift_2" class="ms-0" id="isshift_2" style="display:none"></td>
                                                                    <td width="25%"><textarea type="text" name="isuraian_2" class="ms-0" id="isuraian_2" style="display:none"></textarea></td>
                                                                </tr>
                                                                <tr id="cekresult_2" class="tampilnongol" style="display:none">
                                                                </tr>
                                                                <tr id="larik_3">
                                                                    <td width="25%"><input type="checkbox" name="phari_3" id="phari_3" class="ms-0 pilihhari" data="3"> Rabu</td>
                                                                    <td width="40%"><div id="jam_3" style="display:none"><input type="time" name="start_3" id="start_3" class="ms-0" value="08:00"> - <input type="time" name="end_3" id="end_3" class="ms-0" value="12:00"></div></td>
                                                                    <td id="detailc3" class="details-control"><div id="3alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                                    <td width="5%"><input type="checkbox" name="isshift_3" class="ms-0" id="isshift_3" style="display:none"></td>
                                                                    <td width="25%"><textarea type="text" name="isuraian_3" class="ms-0" id="isuraian_3" style="display:none"></textarea></td>
                                                                </tr>
                                                                <tr id="cekresult_3" class="tampilnongol" style="display:none">
                                                                </tr>
                                                                <tr id="larik_4">
                                                                    <td width="25%"><input type="checkbox" name="phari_4" id="phari_4" class="ms-0 pilihhari" data="4"> Kamis</td>
                                                                    <td width="40%"><div id="jam_4" style="display:none"><input type="time" name="start_4" id="start_4" class="ms-0" value="08:00"> - <input type="time" name="end_4" id="end_4" class="ms-0" value="12:00"></div></td>
                                                                    <td id="detailc4" class="details-control"><div id="4alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                                    <td width="5%"><input type="checkbox" name="isshift_4" class="ms-0" id="isshift_4" style="display:none"></td>
                                                                    <td width="25%"><textarea type="text" name="isuraian_4" class="ms-0" id="isuraian_4" style="display:none"></textarea></td>
                                                                </tr>
                                                                <tr id="cekresult_4" class="tampilnongol" style="display:none">
                                                                </tr>
                                                                <tr id="larik_5">
                                                                    <td width="25%"><input type="checkbox" name="phari_5" id="phari_5" class="ms-0 pilihhari" data="5"> Jumat</td>
                                                                    <td width="40%"><div id="jam_5" style="display:none"><input type="time" name="start_5" id="start_5" class="ms-0" value="08:00"> - <input type="time" name="end_5" id="end_5" class="ms-0" value="12:00"></div></td>
                                                                    <td id="detailc5" class="details-control"><div id="5alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                                    <td width="5%"><input type="checkbox" name="isshift_5" class="ms-0" id="isshift_5" style="display:none"></td>
                                                                    <td width="25%"><textarea type="text" name="isuraian_5" class="ms-0" id="isuraian_5" style="display:none"></textarea></td>
                                                                </tr>
                                                                <tr id="cekresult_5" class="tampilnongol" style="display:none">
                                                                </tr>
                                                                <tr id="larik_6">
                                                                    <td width="25%"><input type="checkbox" name="phari_6" id="phari_6" class="ms-0 pilihhari" data="6"> Sabtu</td>
                                                                    <td width="40%"><div id="jam_6" style="display:none"><input type="time" name="start_6" id="start_6" class="ms-0" value="08:00"> - <input type="time" name="end_6" id="end_6" class="ms-0" value="12:00"></div></td>
                                                                    <td id="detailc6" class="details-control"><div id="6alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                                    <td width="5%"><input type="checkbox" name="isshift_6" class="ms-0" id="isshift_6" style="display:none"></td>
                                                                    <td width="25%"><textarea type="text" name="isuraian_6" class="ms-0" id="isuraian_6" style="display:none"></textarea></td>
                                                                </tr>
                                                                <tr id="cekresult_6" class="tampilnongol" style="display:none">
                                                                </tr>
                                                                <tr id="larik_7">
                                                                    <td width="25%"><input type="checkbox" name="phari_7" id="phari_7" class="ms-0 pilihhari" data="7"> Minggu</td>
                                                                    <td width="40%"><div id="jam_7" style="display:none"><input type="time" name="start_7" id="start_7" class="ms-0" value="08:30"> - <input type="time" name="end_7" id="end_7" class="ms-0" value="12:00"></div></td>
                                                                    <td id="detailc7" class="details-control"><div id="7alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                                    <td width="5%"><input type="checkbox" name="isshift_7" class="ms-0" id="isshift_7" style="display:none"></td>
                                                                    <td width="25%"><textarea type="text" name="isuraian_7" class="ms-0" id="isuraian_7" style="display:none"></textarea></td>
                                                                </tr>
                                                                <tr id="cekresult_7" class="tampilnongol" style="display:none">
                                                                    
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        
                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="button" class="btn btn-info" id="simpanjadwalnakes">Simpan Jadwal</button>
                                                    </div>
                                                    <div class="overlay" id="tunggujadwal" style="display:none">
                                                        <i class="fas fa-2x fa-sync-alt lagiloading" style="display:none"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row toevent" style="display:none">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                    <input type="text" id="tUserPengajuan" name="tUserPengajuan" class="form-control" value="{{$user_id}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tipe</label>
                                                    <input type="text" id="tTypeAjuan" name="tTypeAjuan" class="form-control" value="add">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">is Faskes</label>
                                                    <input type="text" id="tIsFaskes" name="tIsFaskes" class="form-control" value="0">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID Faskes</label>
                                                    <input type="text" id="tidFaskes" name="tidFaskes" class="form-control" value="0">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama Faskes</label>
                                                    <input type="text" id="tNamaFaskes" name="tNamaFaskes" class="form-control" value="0">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID Ajuan</label>
                                                    <input type="text" id="tIdAjuan" name="tIdAjuan" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                    <input type="text" id="tAjuanSalinan" name="tAjuanSalinan" value="{{$salinan}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="stepper.previous()">Sebelumnya</button>
                                        <button type="button" id="editJadwalPraktik" style="display:none" class="btn btn-danger">Edit Jadwal</button>
                                        <button type="submit" id="submitPengajuanM" style="display:none" class="btn btn-success submitPengajuanM">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">

                        </div>
                    </div>
                @endif
                </div>
            </div>
            
        </div>
    </section>
</div>
  


  

@endsection
@section('js')

@endsection
@section('script')
<script>
    $(document).ready(function() {

        function applyScheduleFromAI(summary) {
            const hariMap = {
                "senin": 1,
                "selasa": 2,
                "rabu": 3,
                "kamis": 4,
                "jumat": 5,
                "sabtu": 6,
                "minggu": 7
            };

            for (let i = 1; i <= 7; i++) {
                $(`#phari_${i}`).prop('checked', false);
                $(`#jam_${i}`).hide();
                $(`#start_${i}`).val('');
                $(`#end_${i}`).val('');
                $(`#isuraian_${i}`).hide().val('');
                $(`#isshift_${i}`).hide().prop('checked', false);
            }

            summary.forEach(entry => {
                const index = hariMap[entry.day?.toLowerCase()];
                if (!index) return;

                $(`#phari_${index}`).prop('checked', true);
                $(`#jam_${index}`).show();
                $(`#start_${index}`).val(entry.start);
                $(`#end_${index}`).val(entry.end);
                $(`#isuraian_${index}`).show().val(entry.uraian || '');
                $(`#isshift_${index}`).show().prop('checked', !!entry.isshift);
            });
        }

        $('#generateprompt').on('click', function(){
            var prompt = $('#tprompt').val()

            $.ajax({
                method: 'POST',
                url: '{{ route("get.summaryjadwal") }}',
                data: JSON.stringify({
                    prompt: prompt, // <--- flatten the data structure
                    _token: "{{ csrf_token() }}"
                }),
                contentType: 'application/json', // Important: send as JSON
                processData: false,              // Don't process as form
                dataType: 'json',

                beforeSend: function() {
                    $.fancybox.open({
                        src: '#modal-tunggujadwal-content',
                        type: 'inline',
                        touch: false,
                        modal: true,
                        clickSlide: false
                    });
                },

                success: function(data) {
                    $.fancybox.close();
                    $.fancybox.close();

                    if (data.success && Array.isArray(data.summary)) {
                        applyScheduleFromAI(data.summary); // Pass the array directly
                    } else {
                        alert("Gagal memproses jadwal. Silahkan Isikan Secara Manual.");
                        console.log(data); // Optional: help debug
                    }
                    
            
                },

                error: function(request, status, error) {
                    alert(request.responseText);
                }
            });

        })

        $('#formPengajuanM').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route('nakes.submit.pengajuanM') }}`;
            let formData = new FormData($(this)[0])
            
            $.ajax({
                url: link,
                data: formData,
                cache:false,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                method: "POST",
                enctype: 'multipart/form-data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $.fancybox.open({
                        src: '#modal-tunggujadwal-content',
                        type: 'inline',
                        touch: false,
                        modal: true,
                        clickSlide: false
                    });
                    $('#submitPengajuanM').attr('disabled', true)
                },
                success: function (data) {
                    //Swal.close();
                    $.fancybox.close();
                    if(data.success) {
                        Swal.fire(data.keterangan).then(function() {
                            
                            window.location.href = '{{ route("nakes.dashboard") }}';
                            
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Submit Pengajuan Nakes. Keterangan: '+data.keterangan,
                        })
                        $('#submitPengajuanM').attr('disabled', false)
                    }
                    console.log(data)
                    $('#cariNamaAsn').val('');
                    $('#cariNipAsn').val('');
                    $('#submitPengajuanM').attr('disabled', false)
                }
                ,
                error: function(request, status, error){
                    $.fancybox.close();
                    let serverMsg = '';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        serverMsg = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        serverMsg = xhr.responseText;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: `
                            <strong>Error:</strong> ${errorThrown}<br>
                            <small>${serverMsg}</small>
                        `,
                        confirmButtonText: 'OK'
                    });
                    $('#submitPengajuanM').attr('disabled', false)
                }
            });

        });
    })

</script>
@endsection