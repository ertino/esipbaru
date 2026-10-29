@extends('layouts.adminlte4.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang e-SIP</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5">
                    <div class="sticky-top mb-3">
                        <div class="card card-widget overlay dark">
                            <div class="card-header">
                                <div>
                                    Upload Dokumen
                                </div>

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                    
                                        <center>
                                        <h3> Upload Dokumen SIP Lama (Manual)</h3>
                                        <form enctype="multipart/form-data" id="formUploadManualSIP" method="post" class="form-horizontal">
                                            @csrf
                                            <div class="row toevent">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Dokumen SIP Lama</label>
                                                        <input type="file" id="tFileNakesSIPLama" name="tFileNakesSIPLama" class="form-control" accept=".pdf" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="display:none">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                                        <input type="text" id="tUserIDNakes" name="tUserIDNakes" class="form-control" value="{{$user_id}}" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="display:none">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Is Edit</label>
                                                        <input type="text" id="tiseditktp" name="tiseditktp" class="form-control" value="{{$isedit}}" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="display:none">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Is Edit</label>
                                                        <input type="text" id="tidpengajuanmanual" name="tidpengajuanmanual" class="form-control" @if($isedit == '1') value="{{$detail_pengajuan->id}}" @else value="0" @endif readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="display:none">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0"></label>
                                                        <input type="text" id="ttolaklokasi" name="ttolaklokasi" class="form-control" @if($isedit == '1') value="{{$detail_pengajuan->tolak_lokasi}}" @else value="0" @endif readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0"></label>
                                                        <input type="text" id="talasanlokasi" name="talasanlokasi" class="form-control" @if($isedit == '1') value="{{$detail_pengajuan->alasan_lokasi}}" @else value="0" @endif readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0"></label>
                                                        <input type="text" id="ttolakjadwal" name="ttolakjadwal" class="form-control" @if($isedit == '1') value="{{$detail_pengajuan->tolak_jadwal}}" @else value="0" @endif readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0"></label>
                                                        <input type="text" id="talasanjadwal" name="talasanjadwal" class="form-control" @if($isedit == '1') value="{{$detail_pengajuan->alasan_jadwal}}" @else value="0" @endif readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0"></label>
                                                        <input type="text" id="tcurrentjadwal" name="tcurrentjadwal" class="form-control" @if($isedit == '1') value="{{$detail_pengajuan->jadwal_praktik}}" @else value="0" @endif readonly>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            

                                        </form>

                                        <button type="submit" id="submitUploadSIPManual" class="btn btn-success submitUploadSIPManual">Submit</button>
                                        
                                        </center>

                                    </div>
                                    

                                </div>
                                <hr />

                                <div class="row" id="tabularhasilsipmanual" style="display:none">
                                    <div class="col-md-12 col-xs-12">
                                        <div class="card card-row card-success">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    Hasil Upload Dokumen
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
                                                <div class="row">
                                                    <div class="col-md-12 col-xs-12">
                                                    <embed id="hasiluploadsipmanual" src="" width="100%" height="100%"></embed>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                            </div>
                            <div class="overlay" id="uploadsipmanualloader" style="display:none">
                                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7" id="formsimpansipmanual">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card card-widget overlay dark">
                                <div class="card-header">
                                    <div>
                                        Form Data SIP Lama (Manual)
                                    </div>

                                </div>

                                <div class="card-body">

                                    <div class="alert alert-danger alert-dismissible">
                                        <h5><i class="icon fas fa-danger"></i> Perhatian!</h5>
                                        Upload Dokumen SIP Lama (Manual) Berarti SIP Anda Tidak Dapat Diganti Menjadi e-SIP (Ber QRCODE) Hingga Masa Berlaku STR / SIP Berakhir.
                                    </div>
                                    <form class="form-horizontal" style="display:none">
                                        <div class="row">
                                            
                                            <div class="col-md-3" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID</label>
                                                    <input type="text" id="useridsipmanual" name="useridsipmanual" value="{{$user_id}}" class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Filename</label>
                                                    <input type="text" id="stWhichSIPFManual" name="stWhichSIPFManual"  class="form-control" @if($isedit == 1) value="{{$detail_pengajuan->namafile}}" @endif>
                                                </div>
                                            </div>

                                            <div class="row" style="display:none">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">ID Doc STR</label>
                                                        <input type="text" id="tIdDocSTR" name="tIdDocSTR" class="form-control" value="{{$id_doc_str}}" readonly>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" style="display:none">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">ID Doc STR</label>
                                                        <input type="text" id="tSalinanSIPM" name="tSalinanSIPM" class="form-control" value="{{$salinan}}" readonly>
                                                    </div>
                                                </div>
                                            </div>
                        
                                        </div>
                                    </form>

                                    <form id="ajukanSIPManual" action="{{ route('submit.ktp.nakes') }}" method="post" class="form-horizontal">
                                    @csrf
                                        

                                        <div class="row">
                                            <div class="col-md-12 col-xs-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="card-title">
                                                            Peta Lokasi Pengajuan
                                                        </h3>
                                                        <div class="card-tools">
                                                            <div class="btn-group show" @if($isedit == 1) style="display:none" @endif>
                                                                <button type="button" class="btn btn-sm btn-info dropdown-toggle dropdown-icon" data-bs-toggle="dropdown" aria-expanded="false">Tambah Pengajuan &nbsp; &nbsp<span class="visually-hidden">Toggle Dropdown</span></button>
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

                                        <div class="row" style="display:none">
                                            <div class="col-md-4" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">is Tolak</label>
                                                    <input type="text" id="isTolakJadwal" name="isTolakJadwal" class="form-control" value="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-4" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">is Faskes</label>
                                                    <input type="text" id="tIsFaskes" name="tIsFaskes" class="form-control" @if($isedit == 1) value="{{$detail_pengajuan->isFaskes}}" @else value="0" @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-4" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID Faskes</label>
                                                    <input type="text" id="tidFaskes" name="tidFaskes" class="form-control" value="0">
                                                </div>
                                            </div>
                                        </div>
                                        

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nomor SIP</label>
                                                    <input type="text" id="tNomorSIP" name="tNomorSIP" class="form-control" @if($isedit == 1) value="{{$detail_pengajuan->no_sip}}" @endif required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row setelahpilih" @if($isedit == 0) style="display:none" @endif>

                                            <div class="col-md-6 jikafaskes">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama Faskes</label>
                                                    <input type="text" id="tNamaFaskes" name="tNamaFaskes" class="form-control" value="0" readonly>
                                                </div>
                                            </div>

                                        
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                                                    <input type="text" id="tAlamatPengajuanM" name="tAlamatPengajuanM" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row setelahpilih" @if($isedit == 0) style="display:none" @endif>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                                    <input type="text" id="tKabupatenM" name="tKabupatenM" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                    <input type="text" id="tKecamatanM" name="tKecamatanM" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row setelahpilih" @if($isedit == 0) style="display:none" @endif>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Latitude</label>
                                                    <input type="text" id="tLat" name="tLat" class="form-control" placeholder="Klik Pada Peta" required>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Longitude</label>
                                                    <input type="text" id="tLong" name="tLong" class="form-control" placeholder="Klik Pada Peta" required>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <hr />
                                        <div class="row" id="jikasipmanualjadwal">
                                        </div>
                                        <div class="row toevent setelahpilih">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik</label>
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
                                                    <!--<div class="card-footer">
                                                        <button type="button" class="btn btn-info" id="simpanjadwalnakes">Simpan Jadwal</button>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <button type="submit" id="simpanSIPManual" class="btn btn-success">@if($isedit == 1) Update @else Submit @endif
                                    </button>
                                </div>
                                @if(@isedit == 1)
                                <div class="overlay" id="overlaysipmanual">
                                    <h3> Upload SIP Terlebih Dahulu </h3>
                                </div>
                                @endif
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

@section('script')
<script>

    $(document).ready(function() {
        
        var istolaklokasi = $('#ttolaklokasi').val()
        var alasanditolak = $('#talasanlokasi').val()
        var istolakjadwal = $('#ttolakjadwal').val()
        var alasanjadwal = $('#talasanjadwal').val()

        if($('#tiseditktp').val() == '1') {
            var currentjadwal = $('#tcurrentjadwal').val()
            var dataArray = JSON.parse(currentjadwal);
            console.log(dataArray);
            dataArray.forEach(function(item) {
                var parsedItem = JSON.parse(item);
                if(parsedItem.isSet == '1') {
                    $('#phari_'+parsedItem.urutan).attr('checked', true)
                    $('#start_'+parsedItem.urutan).val(parsedItem.mulai)
                    $('#end_'+parsedItem.urutan).val(parsedItem.selesai)
                    if(parsedItem.is_shift == '1') {
                        $('#isshift_'+parsedItem.urutan).attr('checked', true)
                        $('#isshift_'+parsedItem.urutan).show()
                    }
                    $('#jam_'+parsedItem.urutan).show()
                    $('#isuraian_'+parsedItem.urutan).val(parsedItem.uraian)
                    $('#isuraian_'+parsedItem.urutan).show()
                }
                console.log(parsedItem);
            });
            if(istolakjadwal == '1') {
                var fhtml = '<div class="col-md-12"><div class="alert alert-danger alert-dismissible"><h5><i class="icon fas fa-ban"></i> Perhatian!</h5>Pengajuan Jadwal SIP Manual Ditolak, Alasan : '+alasanjadwal+'. Silahkan Lakukan Perbaikan</div></div>'
                $('#jikasipmanualjadwal').html(fhtml)
            }
        }


        if($('#tiseditktp').val() == '1' && $('#tIsFaskes').val() == '1' && istolaklokasi == '1') {
            var fhtml = '<div class="col-md-12"><div class="alert alert-danger alert-dismissible"><h5><i class="icon fas fa-ban"></i> Perhatian!</h5>Pengajuan Lokasi SIP Manual Ditolak, Alasan : '+alasanditolak+'. Silahkan Pilih Tempat Lain</div></div>'
            var id_user = {{$user_id}}
            $('#pilihfasyankes').modal('show');
            $('#jikasipmanualfaskes').html(fhtml)
            $('#footerpilihfaskes').hide()
            $('#pilihfasyankes').attr('data-backdrop', 'static');
            $('#pilihfasyankes').attr('data-keyboard', 'false');

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.all.faskes")}}',
                data: {'id_user' : id_user, _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function(data){
                    //console.log(data);
                    var html = ''

                    for (i=0; i < data.allfaskes.length; i++) {
                        var id_faskes = data.allfaskes[i].id_faskes;
                        var nama_faskes = data.allfaskes[i].nama_faskes;
                        var alamat_faskes = data.allfaskes[i].alamat_faskes;
                        var kab_faskes = data.allfaskes[i].kabupaten_faskes;
                        var kec_faskes = data.allfaskes[i].kecamatan_faskes;
                        var latitude = data.allfaskes[i].latitude;
                        var longitude = data.allfaskes[i].longitude;


                        html +='<tr><td>'+(i + 1)+'</td><td style="display:none">'+id_faskes+'</td><td>'+nama_faskes+'</td><td>'+alamat_faskes+'</td><td>'+kec_faskes+'</td><td>'+kab_faskes+'</td><td style="display:none">'+latitude+'</td><td style="display:none">'+longitude+'</td><td><button class="btn btn-info btn-sm faskespilihan" id="selectfaskes'+id_faskes+'" data-id="'+id_faskes+'" data-nama="'+nama_faskes+'" data-alamat="'+alamat_faskes+'" data-kec="'+kec_faskes+'" data-kab="'+kab_faskes+'" data-lat="'+latitude+'" data-longi="'+longitude+'">Pilih</button></td></tr>';
                    }

                    $('#praktikum').hide()
                    $('#tFileSTP').prop('required',false);
                    $('#tNoSTP').prop('required', false);
                    $('#tTglSTP').prop('required', false);

                    $('#keteranganpimp').show();
                    $('#tFileSKP').prop('required', true);
                    $('#tNoSKP').prop('required', true);
                    $('#tTglSKP').prop('required', true);

                    $('#pilihanfaskes').html(html);
                    $('#faskesloading').hide();
                    var datatablefaskes = $('#tabelfaskes').DataTable();

                    $('#tabelfaskes').on("click", ".faskespilihan", function() {

                        var id_faskes = $(this).attr('data-id')
                        var nama_faskes = $(this).attr('data-nama')
                        var alamat_faskes = $(this).attr('data-alamat')
                        var kec_faskes = $(this).attr('data-kec')
                        var kab_faskes = $(this).attr('data-kab')
                        var latitude = $(this).attr('data-lat')
                        var longitude = $(this).attr('data-longi')

                        $('#pilihfasyankes').modal('hide')
                        $('.jikafaskes').show()

                        $('#penambahanAjuanM').show()
                        $('#tNamaFaskesM').val(nama_faskes);
                        $('#tAlamatPengajuanM').val(alamat_faskes);
                        $('#tKabupatenM').val(kab_faskes);
                        $('#tKecamatanM').val(kec_faskes);
                        $('#tLat').val(latitude);
                        $('#tLong').val(longitude);
                        $('#tidFaskes').val(id_faskes);
                        $('#tNamaFaskes').val(nama_faskes);
                        $('#tIsFaskes').val('1')

                        $('#tAlamatPengajuanM').attr('readonly', true);
                        $('#tKabupatenM').attr('readonly', true);
                        $('#tKecamatanM').attr('readonly', true);
                        $('#tLat').attr('readonly', true);
                        $('#tLong').attr('readonly', true);
                        $('.setelahpilih').show()
                        $('#stepsatu').show()

                    })

                },
                error: function(request, status, error){
                    //alert(request.responseText);
                }

            })
        }

        $('#submitUploadSIPManual').click(function(){

            var data = $('#formUploadManualSIP').serialize();
            var form = $('#formUploadManualSIP')[0];
            var dataform = new FormData(form);

            var result = '';

            if ($('#tFileNakesSIPLama')[0].files.length === 0) {
                alert('Silahkan Attach File SIP Lama Anda');
            } else {
                result += '1';

            }

            if (result == '1') {

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("nakes.submit.sipmanual")}}',
                    data: dataform,
                    cache: false,
                    contentType: false,
                    processData: false,
                    enctype: 'multipart/form-data',
                    //async: false,
                    beforeSend: function() {
                
                        $('#uploadsipmanualloader').show()
                        $('#formsimpansipmanual').show()
                        $('#tabularhasilsipmanual').hide()
                        $('#overlaysipmanual').show()
            
                    },
                    //	dataType: 'json',
                    success: function(response) {

                        //console.log(response)
                        alert('Upload SIP Manual Berhasil');
                        $('#uploadstrmanualloader').hide()
                        $('#overlaystrmanual').hide();
                        var originfile = response.namafile;
                        $('#stWhichSIPFManual').val(originfile);
                        var hasilsource = "";
                        var parent = $('#hasiluploadsipmanual').parent();
                        var newElement = "<embed src='{{ URL::to('/storagesiplama')}}/"+originfile+".pdf' id='hasiluploadsipmanual' width='100%' height='400px'>";
                        $('#hasiluploadsipmanual').remove();
                        parent.append(newElement);
                        
                    },
                    complete: function(data) {

                        $('#uploadsipmanualloader').hide()
                        $('#tabularhasilsipmanual').show()
                        $('#reloadformnya').show()
                        $('#overlaysipmanual').hide()

                    },
                    error: function(request, status, error) {
                        alert(request.responseText);
                        //$('#cobali').hide()
                    }
                });
            }
        })

        $('#simpanSIPManual').click(function(){


            var countisset = 0;
            var jadwaldata = []
            var id_user = $('#tUserIDNakes').val()
            var ceki = '';
            var allFilled = true;
            for (i=0; i < 7; i++) {

                var urutan = i+1;
                var isnextday = 0
                var isset_ = $('#phari_'+urutan).is(':checked')
                if(isset_ == true) {
                    var isset = 1
                    $('#isuraian_'+urutan).show()
                    countisset++
                } else 
                { var isset = 0}
                var mulai = $('#start_'+urutan).val()
                var selesai = $('#end_'+urutan).val()
                var isshift_ = $('#isshift_'+urutan).is(':checked')
                if(isshift_ == true){
                    var isshift = 1
                }else{ var isshift = 0}
                var waktumulai = mulai.split(":")
                var jammulai = parseInt(waktumulai[0])*60
                var menitmulai = parseInt(waktumulai[1])
                var rmulai = jammulai + menitmulai

                var waktuselesai = selesai.split(":")
                var jamselesai = parseInt(waktuselesai[0])*60;
                var menitselesai = parseInt(waktuselesai[1]);
                var rselesai = jamselesai + menitselesai;
                
                var uraian = $('#isuraian_'+urutan).val()

                if (rmulai > rselesai) {
                    isnextday = 1
                }

                var record = '{ "urutan" : "'+urutan+'", "isSet" : "'+isset+'", "mulai" : "'+mulai+'", "selesai" : "'+selesai+'", "rmulai" : "'+rmulai+'", "rselesai" : "'+rselesai+'", "is_shift" : "'+isshift+'", "isnextday" : "'+isnextday+'", "uraian" : "'+uraian+'"}'
                jadwaldata.push(record)
            }

            var jadwaldataString = JSON.stringify(jadwaldata);
                
            if(countisset !== 0) {
                ceki += '1'
            }

            
            $("#ajukanSIPManual input[required]").each(function() {
                if ($(this).val() === "") {
                    allFilled = false;
                    return false; // Exit the loop early if an empty required field is found
                }
            });

            if (allFilled) {
                ceki += '2'
            } else {
                alert("Data Pada Form Belum Lengkap, Cek kembali!");
            }

            if(ceki == '12') {

                var id_nakes = $('#useridsipmanual').val();
                var namafile = $('#stWhichSIPFManual').val();
                var id_doc = $('#tIdDocSTR').val();
                var no_sip = $('#tNomorSIP').val();
                var nama_faskes = $('#tNamaFaskes').val();
                var alamat_praktik = $('#tAlamatPengajuanM').val();
                var kabupaten_praktik = $('#tKabupatenM').val();
                var kecamatan_praktik = $('#tKabupatenM').val();
                var lat = $('#tLat').val();
                var longi = $('#tLong').val();
                var isFaskes = $('#tIsFaskes').val();
                var id_faskes = $('#tidFaskes').val();
                var salinan = $('#tSalinanSIPM').val();
                var isedit = $('#tiseditktp').val();
                var id_pengajuanm = $('#tidpengajuanmanual').val()

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("nakes.simpan.sipmanual")}}',
                    data: {'id_nakes': id_nakes, 'namafile' : namafile, 'id_doc' : id_doc, 'no_sip' : no_sip, 'nama_faskes' : nama_faskes, 'alamat_pengajuan' : alamat_praktik, 'kabupaten' : kabupaten_praktik, 'kecamatan' : kecamatan_praktik, 'latitude' : lat, 'longitude' : longi, 'isFaskes' : isFaskes, 'id_faskes' : id_faskes, 'jadwal_praktik' : jadwaldataString, 'salinan' : salinan, 'isedit' : isedit, 'id_pengajuan' : id_pengajuanm,  _token: "{{ csrf_token() }}"},
                    async: false,
                    dataType: 'json',
                    beforeSend: function(){
                        $(this).hide();
                    },
                    success: function(data){

                        if(data.success == true) {
                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Pengajuan SIP Manual Berhasil Disimpan',
                                icon: 'success'
                            }).then((result) => {
                                window.location.href = "{{ route('nakes.dashboard') }}";
                            });
                        
                        } else {

                            Swal.fire({
                                title: 'Tersimpan!',
                                text: 'Pengajuan SIP Manual Gagal Disimpan',
                                icon: 'error'
                            }).then((result) => {
                                window.location.reload();
                            });
                            
                        }

                    },
                    complete: function(){
                        $(this).show();
                    },
                    error: function(request, status, error){
                        alert(request.responseText);
                    }
                });


            } else {
                alert("Data Belum Lengkap, Pastikan Jadwal Praktik dan Lokasi Pengajuan Telah Diisi")
            }
        })
    })
</script>
@endsection