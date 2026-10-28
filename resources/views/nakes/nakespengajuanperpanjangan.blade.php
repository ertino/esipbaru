@extends('layouts.minlte.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang Di eSIP</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div id="modal-scanperpanjangan-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Silahkan Scan QRCODE STR Terlebih Dahulu
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="updateqrperpanjangan" action="" method="post" class="form-horizontal">
                                        <div class="row">
                                            <div class="card card-widget overlay">
                                                <div class="card-header">
                                                    <div>
                                                    Scan QRCODE Pada STR Anda
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <div id="qr-perpanjangan-reader" style="width:500px"></div>
                                                            <div id="qr-perpanjangan-reader-results"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                Peta Lokasi Pengajuan
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="pengajuanmap" id="pengajuanmap" style="height:300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12" >
                    <div class="card card-primary" id="penambahanAjuanM">
                        <div class="card-body">
                            <form enctype="multipart/form-data" id="formPerubahanM" action="{{ route('nakes.submit.perpanjangan') }}" method="post" class="form-horizontal">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 col-xs-12">

                                        <div class="row">

                                            <div class="col-md-2" style="display:none">
                                                <div class="form-group">
                                                    <label for='exampleFormControlSelect1' class="ms-0">&nbsp;</label>
                                                    <input type="text" id="tidDocStr" nama="tidDocStr" class="form-control" value="{{$id_doc_str}}">
                                                </div>
                                            </div>

                                            <div class="col-md-4" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                    <input type="text" id="tUserPengajuan" name="tUserPengajuan" class="form-control" value="{{$user_id}}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">isTolak</label>
                                                    <input type="text" id="isTolakJadwal" name="isTolakJadwal" class="form-control" value="0">
                                                </div>
                                                <div class="form-group">
                                                    <input type="text" id="ismanualqr" name="ismanualqr" class="form-control" value="{{$ismanual}}">
                                                </div>
                                                
                                            </div>

                                            <div class="col-md-4" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                    <input type="text" id="tAjuanSalinan" name="tAjuanSalinan" value="{{$salinan}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    

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
                                                    <input type="text" id="tLat" name="tLat" class="form-control" value="{{$detail_pengajuan->latitude}}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Longitude</label>
                                                    <input type="text" id="tLong" name="tLong" class="form-control" value="{{$detail_pengajuan->longitude}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <hr />

                                        <div class="row">

                                            <div class="card">

                                                <div class="card-header">

                                                    Update File Satuan Kredit Profesi (SKP)

                                                </div>

                                                <div class="card-body">
                                                    <div class="row" style="display:none">

                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1" class="ms-0">File Rekomendasi Profesi</label>
                                                                <input type="file" id="tFileRekomP" name="tFileRekomP" class="form-control" accept=".pdf">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1" class="ms-0">Nomor Rekomendasi Profesi</label>
                                                                <input type="text" id="tNoRekomP" name="tNoRekomP" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1" class="ms-0">Tanggal Rekomendasi Profesi</label>
                                                                <input type="date" id="tTglRekomP" name="tTglRekomP" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">

                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1" class="ms-0">File Satuan Kredit Profesi (SKP)</label>
                                                                <input type="file" id="tFileSKSKP" name="tFileSKSKP" class="form-control" accept=".pdf" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1" class="ms-0">Nomor Dokumen</label>
                                                                <input type="text" id="tNoSKSKP" name="tNoSKSKP" class="form-control" value="-" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1" class="ms-0">Tanggal Dokumen</label>
                                                                <input type="date" id="tTglSKSKP" name="tTglSKSKP" class="form-control" value="{{date('Y-m-d')}}" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            

                                            
                                            </div>

                                        </div>

                                    </div>
                                    
                                    <div class="col-md-6 col-xs-12">  

                                        
                                    @if($isSementara != '1')
                                        <div class="row toevent">
                                            
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik</label>
                                                <div class="card card-warning">
                                                    <div class="card-body table-responsive p-0">
                                                        <table class="table table-striped" id="_jadwalpraktiknakes" style="width:100%">
                                                            <thead>
                                                                <tr>
                                                                    <th width="25%">Hari</th>
                                                                    <th width="60%" colspan="2">Dari - Hingga</th>
                                                                    <th width="15%">Shift</th>
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
                                                                        <th>Uraian</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($jadwalpraktikexisting as $jadual)
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
                                    </div>
                                </div>
                                
                                <hr />

                                <div class="row toevent" style="display:none">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                            <input type="text" id="tUserPengajuan" name="tUserPengajuan" class="form-control" value="{{$user_id}}">
                                        </div>
                                    </div>
                                    sturlqr

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">url qr</label>
                                            <input type="text" id="tperpanjanganurlqr" name="tperpanjanganurlqr" class="form-control" value="manual">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Tipe</label>
                                            @if($detail_pengajuan->isApproved == '4')
                                            <input type="text" id="tTypeAjuan" name="tTypeAjuan" class="form-control" 
                                            value="init">
                                            @else
                                            <input type="text" id="tTypeAjuan" name="tTypeAjuan" class="form-control" 
                                            value="perpanjangan">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">isSementara</label>
                                            <input type="text" id="tIsSementara" name="tIsSementara" class="form-control" value="{{$isSementara}}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Tipe</label>
                                            <input type="text" id="tIDPengajuan" name="tIDPengajuan" class="form-control" value="{{$detail_pengajuan->id}}">
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
                                <button type="button" id="editJadwalPraktik" style="display:none" class="btn btn-danger">Edit Jadwal</button>

                                <button type="submit" id="submitPerubahanM" style="display:none" class="btn btn-success submitPengajuanM">Submit</button>

                                @if($isSementara == '1')

                                <button type="submit" id="submitPerpanjanganSementara" class="btn btn-success submitPerpanjanganSementara">Submit</button>
                                @endif
                            </form>
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
@section('script')

<script>

    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete" || document.readyState === "interactive") {
            // call on next available tick
            setTimeout(fn, 1);
        } else {
            document.addEventListener("DOMContentLoaded", fn);
        }
    } 

    docReady(function() {
        var resultContainer = document.getElementById('qr-perpanjangan-reader-results');
        var lastResult, countResults = 0;
        //const fileInput = document.getElementById("#qr-reader__dashboard_section_swaplink");
        //fileInput.classList.add("hiddenopt");
        
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-perpanjangan-reader", { fps: 10, qrbox: 250 });
        
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                console.log(`Scan result = ${decodedText}`, decodedResult);
                $('#ismanualqr').val(decodedText)

                $.fancybox.close();
                // Optional: To close the QR code scannign after the result is found
                html5QrcodeScanner.clear();
            }
        }
        
        // Optional callback for error, can be ignored.
        function onScanError(qrCodeError) {
            // This callback would be called in case of qr code scan error or setup error.
            // You can avoid this callback completely, as it can be very verbose in nature.
        }
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    });

    
</script>

<script>

  $(document).ready(function() {

    var ismanual = $('#ismanualqr').val()
    console.log(ismanual)
    if(ismanual == 'manual') {
        $.fancybox.open({
            src: '#modal-scanperpanjangan-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false
        });
    }

  })

</script>


@endsection