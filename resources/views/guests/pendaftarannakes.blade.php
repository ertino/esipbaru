@extends('layouts.minlte.back_daftar')
@section('content')
<body class="sidebar-mini" style="height: auto;">

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="lanjutanModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Hasil Pengecheckan STR</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row" id="hasilscanupload" style="display:none">
                    <div class="col-md-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body">
                                <div class="embed-responsive embed-responsive-21by9">
                                    <iframe class="embed-responsive-item" id="hasilframed" src=""></iframe>
                                </div>
                                <br />
                                <div class="alert alert-success alert-dismissible strtidakluarsa">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Valid!</h5>
                                    Jika Data Sudah Benar, Silahkan Lengkapi Form Berikut untuk melanjutkan pendaftaran. Pastikan Data Yang Anda Input <b>BENAR</b> dan <b>Dapat Dipertanggungjawabkan</b>
                                </div>
                                <div class="alert alert-danger alert-dismissible strkadaluarsa">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> KADALUARSA!</h5>
                                    STR Yang Anda Upload Sudah Kadaluarsa, Silahkan Periksa Kembali Tanggal Masa Berlaku STR Anda
                                </div>
                                <div class="alert alert-danger alert-dismissible strnonvalid">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> TIDAK VALID!</h5>
                                    STR Yang Anda Upload Berstatus "TIDAK VALID" pada web KTKI, Silahkan Check Kembali!
                                </div>
                                <div class="alert alert-warning alert-dismissible strmepet">
                                    <h5><i class="icon fas fa-exclamation-triangle"></i> VALID!</h5>
                                    STR Yang Anda Upload Akan Segera Kadaluarsa, Segera Perbaharui STR Anda Untuk Dapat Melakukan Pengajuan SIP
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form enctype="multipart/form-data" id="lanjutdaftar" action="{{ route('simpan.pendaftaran') }}" method="post" class="form-horizontal">
                                        @csrf

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">URL e</label>
                                                        <input type="text" id="stURL" name="stURL" class="form-control" >
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                                        <input type="text" id="stNama" name="stNama" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                                        <input type="text" id="stNoSTR" name="stNoSTR" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Jenis Kelamin</label>
                                                        <input type="text" id="stJenisK" name="stJenisK" class="form-control" >
                                                    </div>
                                                </div>

                                                

                                            </div>  


                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga</label>
                                                        <input type="text" id="stDueOri" name="stDueOri" class="form-control">
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Keluar</label>
                                                        <input type="text" id="stStrKeluarOri" name="stStrKeluarOri" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Status Dokumen</label>
                                                        <input type="text" id="stStatDok" name="stStatDok" class="form-control" >
                                                    </div>
                                                </div>


                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga Conv</label>
                                                        <input type="text" id="stDueConv" name="stDueConv" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Tetapan Conv</label>
                                                        <input type="text" id="stStrKeluarConv" name="stStrKeluarConv" class="form-control" >
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">img src</label>
                                                        <input type="text" id="stImg" name="stImg" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">which file</label>
                                                        <input type="text" id="stWhichF" name="stWhichF" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">which file</label>
                                                        <input type="text" id="stUniv" name="stUniv" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="row">
                                                <div class="col-md-4" id="pilihtemplate">
  
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">TGL Penetapan STR *</label>
                                                        <input type="text" id="stSTRtetapSIP" name="stSTRtetapSIP" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga *</label>
                                                        <input type="text" id="stSTRHinggaSIP" name="stSTRHinggaSIP" class="form-control" required readonly>
                                                    </div>
                                                </div>

                                            </div> 


                                            <div class="row">
                                                <div class="col-md-5" style="display:none">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Profesi *</label>
                                                        <div class="autocomplete">
                                                        <input type="text" id="stProfesi" name="stProfesi" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Profesi *</label>
                                                        <select class="form-control" id="stProfesiDD" name="stProfesiDD" required>
                                                            <option value="" selected disabled>--Pilih--</option>
                                                            @foreach($semuaprofesi as $profe)
                                                                <option value="{{$profe->alias_profesi}}">{{$profe->nama_profesi}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                                        <input type="text" id="stKompetensi" name="stKompetensi" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                        <input type="number" id="stSalinan" name="stSalinan" class="form-control" value ="1" required>
                                                    </div>
                                                </div>

                                            </div>  
                                            <hr />
                                            
                                            <div class="alert alert-info alert-dismissible">
                                                Silahkan Inputkan Alamat Email (untuk username) dan Nomor Whatsapp Valid Untuk Pertukaran Informasi Penting
                                            </div>
                                            <div class="row">

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Alamat Email *</label>
                                                        <input type="email" id="stEmail" name="stEmail" class="form-control" required placeholder="esip@gmail.com">
                                                    </div>
                                                </div>
                                          

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Nomor Telpon WhatsApp*</label>
                                                        <input type="text" id="stNotelp" name="stNotelp" class="form-control" required placeholder="08123456778899">
                                                    </div>
                                                </div>
                                            </div>  
                                            <div class="row jikafototidak" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Foto Sesuai STR *</label>
                                                    <input type="file" id="stFotoJika" name="stFotoJika" class="form-control" accept="image/jpeg, image/jpg">
                                                </div>

                                            </div>

                                            <div class="row" style="display:none">

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">which file</label>
                                                        <input type="text" id="stUniversitas" name="stUniversitas" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" id="SubmitAfterValidation" class="btn btn-success">Lanjutkan</button>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="overlay" id="lodaing">
                                <i class="fas fa-2x fa-sync-alt"></i>
                            </div> -->
                        </div>
                        
                    </div>
                </div>
              
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <center>
            <a href="/">
                <img src="{{asset('images/NAKES.png')}}" height="120px" alt="">
            </a>
            <br />
        
                <p>Silahkan Upload STR Ber-QRCODE anda</p>
                <p>Jika Belum Memiliki STR Ber-QRCODE, silahkan Datang Ke DPMPTSP / MPP Untuk Pengajuan Akun e-SIP</p>
                               
            </center>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 col-xs-6">
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
                                    <h3> Upload Dokumen STR (PDF)</h3>
                                    <form enctype="multipart/form-data" id="formDaftar" method="post" class="form-horizontal">
                                        @csrf
                                      
                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen STR</label>
                                                    <input type="file" id="tFileSTR" name="tFileSTR" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nomor STR</label>
                                                    <input type="text" id="tNoStr" name="tNoStr" class="form-control"style="text-transform: uppercase;">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <button type="submit" id="submitDaftar" class="btn btn-success submitDaftar">Submit</button>
                                    <!--<button type="submit" id="jajalanbae" class="btn btn-success jajalanbae">Jajals</button>-->
                                    
                                    </center>
                                </div>
                            </div>
                            
                        </div>
                        <div class="overlay" id="cobali" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-6">
                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <div>
                            Atau Scan QRCode STR
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="qr-reader" style="width:500px"></div>
                                    <div id="qr-reader-results"></div>

                                </div>

                            </div>
                        
                        </div>
                    </div>

                    
                </div>
            
            </div>

            
        </div>
    </section>

@endsection
@section('js')

@endsection