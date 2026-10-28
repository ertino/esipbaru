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
            <div class="row" style="display:none">
                
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header p-2">
                            Detail Pengajuan
                        </div>
                        <div class="card-body">
                            <form style="display:none">
                                <input id="id_pengajuanedit" value="{{$id_pengajuan}}">
                                <input id="mapidPengajuan" value="{{$id_pengajuan}}">
                                <input id="maplatitude" value="{{$detail_pengajuan->latitude}}">
                                <input id="maplongitude" value="{{$detail_pengajuan->longitude}}">
                                
                            </form> 

                            @if ($dokumenissue > 0)
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-danger alert-dismissible">
                                    <h5><i class="icon fas fa-ban"></i> DOKUMEN HARUS DIPERBAHARUI!</h5>
                                    Silahkan Update Dokumen Yang Harus Diperbaiki Terlebih Dahulu <a href="{{route('nakes.documents')}}">Disini</a>
                                    </div>
                                </div>
                            </div>     

                            @else

                            <div class="bs-stepper linear">
                                <div class="bs-stepper-header" role="tablist">
                                    <div class="step" data-target="#lokasiedit-part">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="lokasiedit-part" id="lokasiedit-part-trigger" aria-selected="true">
                                            <span class="bs-stepper-circle">1</span>
                                            <span class="bs-stepper-label">Lokasi</span>
                                        </button>
                                    </div>
                                    
                                    <div class="line"></div>
                                    <div class="step" data-target="#jadwaledit-part">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="jadwaledit-part" id="jadwaledit-part-trigger" aria-selected="true">
                                            <span class="bs-stepper-circle">2</span>
                                            <span class="bs-stepper-label">Jadwal Praktik</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="bs-stepper-content">
                                    <div id="lokasiedit-part" class="content" role="tabpanel" aria-labelledby="lokasiedit-part-trigger">

                                        

                                        <div class="card">
                                            <div class="card-body">
                                                <div class="pengajuanmap" id="pengajuanmap" style="height:300px;"></div>
                                            </div>
                                        </div>
                                    
                                        <form>

                                            @if($detail_pengajuan->tolak_template == '1')

                                                <div class="row" id="keterangantemplateditolak">
                                                    <div class="col-md-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i>Pengajuan Profesi Tidak Disetujui!</h5>
                                                        {{$detail_pengajuan->ket_tolak_template}}
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row toevent">
                                                    <div class="col-md-6">
                                                        <label for="exampleFormControlSelect1" class="ms-0" >Pengajuan Sebagai:</label>
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="templateprofesi" value="3"  @if($detail_pengajuan->template_id == '3') disabled @else checked @endif>
                                                                <label for="exampleFormControlSelect1" class="ms-0" >Apoteker / TTK</label>
                                                            </div>
                                                            <div class="form-check form-check-inline mt-2">
                                                                <input class="form-check-input" type="radio" name="templateprofesi" value="4" @if($detail_pengajuan->template_id == '4') disabled @else checked @endif>
                                                            <label for="exampleFormControlSelect1" class="ms-0">Apoteker / TTK Penanggung Jawab</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  


                                            @else

                                                @if($detail_pengajuan->template_id == '3')

                                                <div class="row">
                                                    <div class="col-md-12" >
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Pengajuan Sebagai</label>
                                                            <input type="text" id="tmpltprofesi" name="tmpltprofesi" class="form-control" value="Apoteker / TTK" readonly>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                @elseif($detail_pengajuan->template_id == '4')

                                                <div class="row">
                                                    <div class="col-md-12" >
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Pengajuan Sebagai</label>
                                                            <input type="text" id="tmpltprofesi" name="tmpltprofesi" class="form-control" value="Apoteker / TTK Penanggung Jawab" readonly>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                @elseif($detail_pengajuan->template_id == '2')

                                                    @if($detail_pengajuan->remark == '0' || $detail_pengajuan->remark == null)

                                                    <div class="row">
                                                    </div>

                                                    @else

                                                    <div class="row">
                                                        <div class="col-md-12" >
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1" class="ms-0">Pengajuan Sebagai</label>
                                                                <input type="text" id="tsubspesialis" name="tsubspesialis" class="form-control" value="{{$detail_pengajuan->remark}}" readonly>
                                                            </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    @endif

                                                @endif



                                            @endif

                                            <hr />

                                            <div class="row" style="display:none">
                                                <div class="col-md-12" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Is Faskes</label>
                                                        <input type="text" id="tidFaskesEdit" name="tidFaskesEdit" class="form-control" value="{{$detail_pengajuan->id_faskes}}">
                                                    </select>
                                                    </div>
                                                </div>
                                            </div>
                                        

                                            @if($detail_pengajuan->tolak_lokasi == '1')

                                                <div class="row" id="keteranganlokasiditolak">
                                                    <div class="col-md-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i>Lokasi Praktik Tidak Disetujui!</h5>
                                                        {{$detail_pengajuan->ket_tolak_lokasi}}
                                                        </div>
                                                    </div>
                                                </div>

                                                @if($detail_pengajuan->isFaskes == '1')

                                                <div class="row">
                                                    <div class="col-md-12" >
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Nama Faskes</label>
                                                            <select class="form-control" id="tselectedfaskesedit" name="tselectedfaskesedit">
                                                                
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" style="display:none">

                                                    <div class="col-md-6" >
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">ID FASKES</label>
                                                            <input type="text" id="tselectedfaskesc" name="tselectedfaskesc" class="form-control" value="{{$detail_pengajuan->id_faskes}}">
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @else
                                                <div class="row ubahlahjenislok">
                                                    <div class="col-md-12" >
                                                        <div class="form-group">
                                                            <button type="button" class="btn btn-info" id="ubahkefaskes" data-id="{{$user_id}}">Ubah Ke Faskes</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                @endif
                                                <div class="row" id="ketikaberubahkefaskes" style="display:none">
                                                    <div class="col-md-6" >
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0"></label>
                                                            <input type="text" id="tnamakefaskes" name="tnamakefaskes" class="form-control" value="" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6" >
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                                                            <input type="text" id="tAlamatPengajuanM" name="tAlamatPengajuanM" class="form-control tocekfis" value="{{$detail_pengajuan->alamat_pengajuan}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                                            <input type="text" id="tKabupatenM" name="tKabupatenM" class="form-control tocekfis" value="{{$detail_pengajuan->kabupaten}}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                            <input type="text" id="tKecamatanM" name="tKecamatanM" class="form-control tocekfis" value="{{$detail_pengajuan->kecamatan}}">
                                                        </div>
                                                    </div>
                                                </div>     

                                                <div class="row toevent">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Latitude</label>
                                                            <input type="text" id="tLat" name="tLat" class="form-control tocekfis" value="{{$detail_pengajuan->latitude}}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Longitude</label>
                                                            <input type="text" id="tLong" name="tLong" class="form-control tocekfis" value="{{$detail_pengajuan->longitude}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row toevent" style="display:none">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">isFASKES</label>
                                                            <input type="text" id="tisFaskes" name="tisFaskes" class="form-control" value="{{$detail_pengajuan->isFaskes}}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row" id="tombolupdatelokasi">
                                                    <div class="col-md-6">
                                                        <button type="button" class="btn btn-info" id="simpanlokasiedit" data-faskes = "{{$detail_pengajuan->id_faskes}}">Simpan</button>
                                                    </div>
                                                </div>
                                                
                                            
                                            @else
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
                                            @endif
                                        </form>
                                        
                                        <hr />
                                        <button type="button" id="nextedit2" data-pengajuan="{{$id_pengajuan}}" class="btn btn-primary">Berikutnya</button>
                                    </div>
                                    
                                </div>
                                
                                <div id="jadwaledit-part" class="content" role="tabpanel" aria-labelledby="jadwaledit-part-trigger">
                                    <form>
                                        @if($detail_pengajuan->tolak_jadwal == '1')

                                            <div class="row jadwaltaksetuju">
                                                <div class="col-md-12">
                                                <div class="alert alert-danger alert-dismissible">
                                                    <h5><i class="icon fas fa-ban"></i>Jadwal Praktik Tidak Disetujui!</h5>
                                                    {{$detail_pengajuan->ket_tolak_jadwal}}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row toevent">

                                            

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
                                                </div>

                                                <div class="col-md-4" style="display:none">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                        <input type="text" id="tAjuanSalinan" name="tAjuanSalinan" value="{{$salinan}}" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-4" style="display:none">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Is Ditolak</label>
                                                        <input type="text" id="isTolakJadwal" name="isTolakJadwal" value="{{$detail_pengajuan->tolak_jadwal}}" class="form-control">
                                                    </div>
                                                </div>
                                    
                                                
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik</label>
                                                    <div class="card card-warning">
                                                        <div class="card-body table-responsive p-0">
                                                            <table class="table table-striped" id="_jadwalpraktiknakes" style="width:100%">
                                                                <thead>
                                                                    <tr>
                                                                        <th width="25%">Hari</th>
                                                                        <th width="40%" colspan="2">Dari - Hingga</th>
                                                                        <th width="5%">Shift</th>
                                                                        <th width="25%">Uraian</th>
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
                                        @endif
                                    </form>
                                    <button type="button" id="prevedit" class="btn btn-primary" onclick="stepper.previous()">Kembali</button>
                                    @if($dokumenissue == 0)
                                    
                                        <button class="btn btn-sm btn-success" id="updatepengajuanedit" data-pengajuan = "{{$id_pengajuan}}" data-id="{{$user_id}}" data-salinan="{{$salinan}}" style="display:none">Update</button>
                                 
                                    @endif
                                </div>
                            </div>


                            @endif
                                

                            
                        </div>
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