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
                                    <h3> Upload Dokumen KTP (JPEG)</h3>
                                    <form enctype="multipart/form-data" id="formUploadKTP" method="post" class="form-horizontal">
                                        @csrf
                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen KTP</label>
                                                    <input type="file" id="tFileNakesKTP" name="tFileNakesKTP" class="form-control" accept="image/jpeg" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                                    <input type="text" id="tUserKTP" name="tUserKTP" class="form-control" value="{{$user_id}}" readonly>
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
                                        
                                    </form>

                                    <button type="submit" id="submitUploadKTP" class="btn btn-success submitUploadKTP">Submit</button>
                                    
                                    </center>

                                </div>
                                 

                            </div>
                        
                        </div>
                        <div class="overlay" id="uploadktploader" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>


                    </div>

                    @if ($isedit == 1)

                    <div class="card card-row card-success" id="hasilktpen">
                        <div class="card-header">
                            <h3 class="card-title">
                                Foto KTP Terakhir
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
                        <div class="card-body" id="parentktpterkini">
                            <embed id="ktpterkini" width="100%" height="100%"></embed>
                        </div>
                    </div>

                    @endif


                    <div class="card card-widget overlay dark" style="display:none">
                        <div class="card-header">
                            <div>
                                <b>Hasil Scan</b>
                                <p> Silahkan Klik Tombol Dibawah Untuk Melakukan Salin-Tempel Ke Form Yang Sudah Disediakan</p>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12" id="hasilscanktp">
                                </div>
                            </div>
                        </div>
                        <div class="overlay" id="cobali" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>


                    </div>
                    
                </div>
                <div class="col-md-7" id="formdatadiri" @if($isedit == 0) style="display:none" @endif>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card card-widget overlay dark">
                                <div class="card-header">
                                    <div>
                                        Form Data Diri Sesuai KTP
                                    </div>

                                </div>

                                <div class="card-body">

                                    <div class="alert alert-info alert-dismissible">
                                        <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
                                        Nama yang Anda Submit Adalah Nama Yang Akan Muncul Pada e-SIP. Silahkan Isikan Sesuai Dengan Gelar Yang Anda Peroleh. Perhatikan Juga Huruf Kapital <i>(uppercase dan lowercase)</i>
                                    </div>

                                    <form id="ajukanKTP" @if($isedit == 1) action="{{ route('update.ktp.nakes') }}" @else action="{{ route('submit.ktp.nakes') }}" @endif  method="post" class="form-horizontal">
                                    @csrf
                                        <div class="row">
                                            
                                            <div class="col-md-3" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID</label>
                                                    <input type="text" id="ktpUploader" name="ktpUploader" value="{{$user_id}}" class="form-control" >
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Filename</label>
                                                    <input type="text" id="ktpFilename" name="ktpFilename"  class="form-control" @if($isedit == 1) value="{{$detail_ktp->namafile}}" @endif>
                                                </div>
                                            </div>

                                            <div class="col-md-3" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Filename</label>
                                                    <input type="text" id="ktpTemplateId" name="ktpTemplateId"  class="form-control" value="{{$template_id}}">
                                                </div>
                                            </div>

                                            

                                        </div>  

                                        <div class="row">
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <div class="autocomplete">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama *</label>
                                                    <input type="text" id="ktpNAMA" name="ktpNAMA" class="form-control"  @if($isedit == 1) value="{{$detail_ktp->nama_doc}}" @endif required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No KTP *</label>
                                                    <input type="text" id="ktpNOMOR" name="ktpNOMOR" class="form-control" @if($isedit == 1) value="{{$detail_ktp->no_doc}}" @endif required>
                                                </div>
                                            </div>

                                        </div>  

                                        <div class="row">
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tempat Lahir *</label>
                                                    <input type="text" id="ktpTTL" name="ktpTTL" class="form-control" @if($isedit == 1) value="{{$detail_ktp->remark4}}" @endif required placeholder="Cilacap">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Lahir</label>
                                                    <input type="date" id="ktpTanggalLahir" name="ktpTanggalLahir" @if($isedit == 1) value="{{$detail_ktp->tgl_doc_origin}}" @endif class="form-control">
                                                </div>
                                            </div>

                                        </div>  

                

                                        <div class="row">
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Alamat KTP *</label>
                                                    <textarea type="text" id="ktpALAMAT" name="ktpALAMAT" class="form-control" @if($isedit == 1) value="{{$detail_ktp->remark1}}" @endif required></textarea>
                                                </div>
                                            </div>

                                            <div class="col-md-3" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                                    <input type="text" id="ktpKabupaten" name="ktpKabupaten" class="form-control" @if($isedit == 1) value="{{$detail_ktp->remark3}}" @endif placeholder="Kabupaten Cilacap">
                                                </div>
                                            </div>

                                            <div class="col-md-3" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                    <input type="text" id="ktpKecamatan" name="ktpKecamatan" class="form-control" @if($isedit == 1) value="{{$detail_ktp->remark2}}" @endif placeholder ="Cilacap">
                                                </div>
                                            </div>
                                        </div> 

                                        <div class="row">
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Alamat Domisili</label>&nbsp; &nbsp;<input type="checkbox" id="ifdom" name="ifdom" value="1" @if($isedit == 1) @if ($detail_ktp->remark5 != NULL) checked @endif @endif/> (Sesuai KTP)
                                                    <input type="text" id="ktpALAMATDom" name="ktpALAMATDom" class="form-control domisilih" @if($isedit == 1) value="{{$detail_ktp->remark5}}" @endif required >
                                                </div>
                                            </div>

                                            <div class="col-md-3" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                    <input type="text" id="ktpKecamatanDom" name="ktpKecamatanDom" class="form-control domisilih" @if($isedit == 1) value="{{$detail_ktp->remark6}}" @endif>
                                                </div>
                                            </div>

                                            <div class="col-md-3" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                                    <input type="text" id="ktpKabupatenDom" name="ktpKabupatenDom" class="form-control domisilih" @if($isedit == 1) value="{{$detail_ktp->remark7}}" @endif>
                                                </div>
                                            </div>

                                        </div> 
                                        <hr />
                                        <p> Pastikan Data Diri Yang Anda Submit Sudah Sesuai Karena Akan Berpengaruh Pada SIP Yang Dicetak. Dengan Ini Saya Bertanggung Jawab Penuh Dengan Apa Yang Saya Unggah dan Submit.</p>
                                        <input type="checkbox" required /> Setuju
                                        <hr /> 

                                        <button type="submit" id="SimpanDataDiri" class="btn btn-success">@if($isedit == 1) Update @else Submit @endif</button>
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