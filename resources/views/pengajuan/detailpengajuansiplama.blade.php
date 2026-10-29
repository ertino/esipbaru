@extends('layouts.adminlte4.back_master')
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
                <div id="modal-ubahpengaju-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h5>Ubah Data Pemohon SIP</h5> 
                            </div>
                            <div class="card-tools">
                            <button type="button" class="btn btn-secondary btn-sm float-end" id="close-ubahpengaju-modal">Close</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="lanjutuploadstrmanual" action="{{ route('simpan.str.manual') }}" method="post" class="form-horizontal">
                                @csrf

                                <div class="row">
                                    
                                    <div class="col-md-6 col-xs-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Tempat Lahir</label>
                                            <input type="text" id="ePengajuTmptLahir" name="ePengajuTmptLahir" class="form-control" value="{{$detail_pengaju->tmpt_lahir}}"required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Tanggal Lahir</label>
                                            <input type="text" id="ePengajuTglLahir" name="ePengajuTglLahir" class="form-control"  value="{{$detail_pengaju->tgl_lahir}}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-xs-6" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">is Faskes</label>
                                            <input type="text" id="eIsFaskes" name="eIsFaskes" class="form-control" value="{{$detail_pengajuan->isFaskes}}"required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-xs-6" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nama STR</label>
                                            <input type="text" id="ePengajuNamaSTR" name="ePengajuNamaSTR" class="form-control" value="{{$detail_pengaju->nama}}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nama e-SIP</label>
                                            <input type="text" id="ePengajuNama" name="ePengajuNama" class="form-control" value="{{$detail_pengaju->nama_pengaju}}"required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Profesi e-SIP</label>
                                            <input type="text" id="ePengajuProfesi" name="ePengajuProfesi" class="form-control"  value="{{$detail_pengaju->profesi_pengaju}}" required>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-4 col-xs-12" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Alamat Nakes</label>
                                            <textarea type="text" id="ePengajuAlamat" name="ePengajuAlamat" class="form-control" value= required>{{$detail_pengaju->alamat_pengaju}}</textarea>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                            <input type="text" id="ePengajuAlamatKec" name="ePengajuAlamatKec" class="form-control" value="{{$detail_pengaju->kecamatan_pengaju}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                            <input type="text" id="ePengajuAlamatKab" name="ePengajuAlamatKab" class="form-control" value="{{$detail_pengaju->kabupaten_pengaju}}" required>
                                        </div>
                                    </div>
                                </div>  

                                <div class="row" style="display:none">
                                    <div class="col-md-4 col-xs-12" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">isFaskes</label>
                                            <input type="text" id="ePengajuanFaskes" name="ePengajuanFaskes" class="form-control" value="{{$detail_pengajuan->isFaskes}}" >
                                        </div>
                                    </div>
                                </div>


                                @if($detail_pengajuan->isFaskes == 0)
                                <hr />
                                <div class="row">
                                    <div class="col-md-4 col-xs-12" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                                            <textarea type="text" id="ePengajuanAlamat" name="ePengajuanAlamat" class="form-control" required>{{$detail_pengajuan->alamat_pengajuan}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                                            <textarea type="text" id="ePengajuanAlamatBefore" name="ePengajuanAlamatBefore" class="form-control" required>{{$detail_pengajuan->alamat_pengajuan}}</textarea>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                            <input type="text" id="ePengajuanAlamatKec" name="ePengajuanAlamatKec" class="form-control" value="{{$detail_pengajuan->kecamatan}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                            <input type="text" id="ePengajuanAlamatKecBefore" name="ePengajuanAlamatKecBefore" class="form-control" value="{{$detail_pengajuan->kecamatan}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                            <input type="text" id="ePengajuanAlamatKab" name="ePengajuanAlamatKab" class="form-control" value="{{$detail_pengajuan->kabupaten}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                            <input type="text" id="ePengajuanAlamatKabBefore" name="ePengajuanAlamatKabBefore" class="form-control" value="{{$detail_pengajuan->kabupaten}}" required>
                                        </div>
                                    </div>
                                </div>  


                                @endif
                                <div class="row" style="display:none">
       
                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                            <input type="text" id="eIDUpdater" name="eIDUpdater" class="form-control" value="{{$user_id}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                            <input type="text" id="eIdNakes" name="eIdNakes" class="form-control" value="{{$detail_pengajuan->id_nakes}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                            <input type="text" id="eSalinanNakes" name="eSalinanNakes" class="form-control" value="{{$detail_pengajuan->salinan}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                            <input type="text" id="eIdPengajuan" name="eIdPengajuan" class="form-control" value="{{$detail_pengajuan->id}}">
                                        </div>
                                    </div>

                                </div>  
                                <div class="row">

                                    <div class="col-md-5 col-xs-12" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nomor Depan Jika TTK</label>
                                            <input type="text" id="ePengajuNoTTK" name="ePengajuNoTTK" class="form-control" value="{{$detail_pengaju->no_ttk}}">
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nomor Depan Jika TTK</label>
                                            <input type="text" id="ePengajuNoTTKBefore" name="ePengajuNoTTKBefore" class="form-control" value="{{$detail_pengaju->no_ttk}}">
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nomor Depan Jika TTK</label>
                                            <input type="text" id="eTemplateBefore" name="eTemplateBefore" class="form-control" value="{{$detail_pengaju->template_id}}">
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                            <button id="updatedatapengaju" class="btn btn-success">Update</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="modal-draftkadin-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                Draft Dokumen Pencabutan
                            </div>
                            <div class="card-tools">
                                <a type="button" id="lihatdraftkadin" class="btn btn-tool" href="" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm float-end tutupintipdraftkadin">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <iframe id="viewdraftkadin" class="embed-responsive-item" src="https://surat.cilacapkab.go.id/assets/uploads/maker/draft/{{$detail_pengajuan->filename_pencabutan}}.pdf?dummy=430791" width="100%" height="400px"></iframe>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="alert alert-success alert-dismissible">
                                        Mohon Periksa Terlebih Dahulu Draft Surat Ijin Praktik (e-SIP) Sebelum Melakukan Proses Tanda Tangan Elektronik Dengan Menginputkan Passphrase Berikut Dibawah.
                                    </div>

                                    <form id="submitttekadin" action="" method="post" class="form-horizontal">

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="id_tte_kadin" name="id_tte" value="{{$id_user}}">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">filenamesip</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="filename_tte_kadin" name="filename_tte" value="{{$detail_pengajuan->filename_pencabutan}}">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">iscabut</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="iscabut_tte_kadin" name="iscabut_tte_kadin" value="1">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">iscabut</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="issiplama_tte" name="issiplama_tte" value="1">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">iscabut</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="idpengajuan_tte_kadin" name="idpengajuan_tte_kadin" value="M_{{$detail_pengajuan->id}}">
                                            </div>
                                        </div>
                                        

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Passphrase</label>
                                            <div class="input-group input-group">
                                                <input type="password" class="form-control" id="passphrase_kadin" name="passphrase" placeholder="passphrase">
                                                <span class="input-group-append">
                                                <button type="button" class="btn btn-default btn-flat intippass"><i class="fas fa-eye"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success" id="btnsubmitttekadin">Setujui</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary btn-sm float-end tutupintipdraftkadin" id="close-draftkadinkes-modal">Tutup</button>
                        </div>
                        <div class="overlay" id="sedangttekadin" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

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

                            <div class="card card-row card-success blogade" id="cardSIPLama">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        SIP Manual
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
                                    
                                    <embed src="{{ URL::to('/storagesiplama')}}/{{$detail_pengajuan->namafile}}.pdf" width="100%" height="100%"></embed>
                                    
                                </div>
                            </div>
                            
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

                        @foreach($doc_sub as $sub)
                            <div class="card card-row card-success blogade" id="cardSUB">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        STR SUB Spesialis
                                    
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
                                    @if ($detail_pengajuan->remark == '0' || $detail_pengajuan->remark == null)
                                    <div class="alert alert-info alert-dismissible">
                                    <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
                                        STR SUB SPESIALIS sudah diupload namun belum digunakan untuk pengajuan ini.
                                    </div>
                                    @else
                                    <embed src="{{ URL::to('/storage')}}/{{$sub->namafile}}.pdf" width="100%" height="100%"></embed>
                                    
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if($detail_pengajuan->isApproved == 'C' || $detail_pengajuan->isApproved == 'CF')
                            @foreach($doc_c as $dc)
                            <div class="card card-row card-warning blogade" id="cardREKOMPC">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Dokumen Pencabutan
                                    
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$dc->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                            @endforeach
                        @endif

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
            <div class="row" id="kotakprofile">
                <div class="col-md-3">
                 <div class="sticky-top mb-3">

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid custom-rounded" src="{{ URL::to('/storagefoto')}}/{{$detail_pengaju->saved_photo}}"
                                    alt="User profile picture">
                            </div>

                        @if($role == 'adminptsp' && $detail_pengajuan->isApproved == '2')
                            <h3 class="profile-username text-center" id="namapengaju"><a href="#kotakprofile" class="toprofilingnakes" data-id="{{$detail_pengajuan->id_user}}">{{$detail_pengaju->nama}}</a></h3>
                            <p class="text-muted text-center" id="kompetensipengaju">{{$detail_pengaju->kompetensi}}</p>
                            <hr />
                            <a class="btn btn-light btn-block" id="editpengaju">Edit &nbsp; &nbsp;<i class="fas fa-edit"></i></a>
                            <br />
                            <strong><i class="fas fa-file me-1"></i> Nama e-SIP</strong>
                            <p class="text-muted" id="namasippengaju">
                            @foreach ($doc_ktp as $ketktp) 
                                {{$ketktp->nama_doc}}
                            @endforeach
                            </p>
                            <hr />
                            <strong><i class="fas fa-book me-1"></i> Pendidikan</strong>
                            <p class="text-muted" id="univpengaju">
                            @if($infonakes->universitas == '')

                            Silahkan Upload Dokumen Ijazah

                            @else
                            {{$infonakes->strata}}, Jurusan {{$infonakes->jurusan}}, {{$infonakes->universitas}}
                            @endif
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt me-1" ></i> Alamat</strong>
                            <p class="text-muted" id="alamatpengaju">
                            @if($infonakes->alamat_ktp == '')

                                Silahkan Upload Dokumen KTP

                            @else
                                {{$infonakes->alamat_ktp}}, {{$infonakes->kec_ktp}}, {{$infonakes->kab_ktp}}
                            @endif
                            
                            </p>
                            <hr>
                            @if($infonakes->isdomi == 'D')
                            <strong><i class="fas fa-map-marker-alt me-1"></i> Alamat Domisili</strong>
                            <p class="text-muted">
                            
                                {{$infonakes->alamat_domisili}}, {{$infonakes->kec_domisili}}, {{$infonakes->kab_domisili}}
                          
                            </p>
                            <hr>
                            @endif
                            <strong><i class="far fa-file-alt me-1"></i> Email</strong>
                            <p class="text-muted">{{$detail_pengaju->email}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Pengajuan</b> <a class="float-end"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Histori Praktik</b> <a class="float-end"></a>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-block"><b>Profile</b></a>

                        @else
                            <h3 class="profile-username text-center">{{$detail_pengaju->nama}}</h3>
                            <p class="text-muted text-center">{{$detail_pengaju->kompetensi}}</p>
                            <hr />
                            <strong><i class="fas fa-file me-1"></i> Nama e-SIP</strong>
                            <p class="text-muted">
                            @foreach ($doc_ktp as $ketktp) 
                                {{$ketktp->nama_doc}}
                            @endforeach
                            </p>
                            <hr />
                            <strong><i class="fas fa-book me-1"></i> Pendidikan</strong>
                            <p class="text-muted">
                            @if($infonakes->universitas == '')

                            Silahkan Upload Dokumen Ijazah

                            @else
                            {{$infonakes->strata}}, Jurusan {{$infonakes->jurusan}}, {{$infonakes->universitas}}
                            @endif
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt me-1"></i> Alamat</strong>
                            <p class="text-muted">
                            @if($infonakes->alamat_ktp == '')

                                Silahkan Upload Dokumen KTP

                            @else
                                {{$infonakes->alamat_ktp}}, {{$infonakes->kec_ktp}}, {{$infonakes->kab_ktp}}
                            @endif
                            
                            </p>
                            <hr>
                            @if($infonakes->isdomi == 'D')
                            <strong><i class="fas fa-map-marker-alt me-1"></i> Alamat Domisili</strong>
                            <p class="text-muted">
                            
                                {{$infonakes->alamat_domisili}}, {{$infonakes->kec_domisili}}, {{$infonakes->kab_domisili}}
                          
                            </p>
                            <hr>
                            @endif
                            <strong><i class="far fa-file-alt me-1"></i> Email</strong>
                            <p class="text-muted">{{$detail_pengaju->email}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Pengajuan</b> <a class="float-end"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Histori Praktik</b> <a class="float-end"></a>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-block"><b>Profile</b></a>
                        @endif
                        </div>

                    </div>
                 </div>   
                </div>

                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header p-2">
                            Detail Pengajuan
                        </div>
                        <div class="card-body">
                            <form style="display:none">
                                <input id="mapidPengajuan" value="{{$detail_pengajuan->id}}">
                                <input id="maplatitude" value="{{$detail_pengajuan->latitude}}">
                                <input id="maplongitude" value="{{$detail_pengajuan->longitude}}">

                            </form>

                               
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <form>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No SIP</label>
                                                    <input type="text" id="tNoSipLama" name="tNoSipLama" class="form-control" value="{{$detail_pengajuan->no_sip}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        @if($detail_pengajuan->isFaskes == 1)
                                        <div class="row">
                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama Faskes @if(Auth::user()->role != 'nakes')<button type="button" class="btn btn-sm btn-primary" id="detailnakesonfaskes" data-id="{{$detail_pengajuan->id_faskes}}" data-nama="{{$detail_pengajuan->nama_faskes}}"><i class="fas fa-eye"></i></button>@endif</label>
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
                                                                        <th>Uraian</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @php
                                                                    $jadwalArray = json_decode($detail_pengajuan->jadwal_praktik);
                                                                @endphp

                                                                @foreach($jadwalArray as $jadwalstring)

                                                                    @php
                                                                        $jadwal = json_decode($jadwalstring);
                                                                    @endphp
                                                                    @if($jadwal->isSet == '1')
                                                                    <tr>
                                                                        <td>@switch($jadwal->urutan)
                                                                                @case(1)
                                                                                    Senin
                                                                                    @break
                                                                                @case(2)
                                                                                    Selasa
                                                                                    @break
                                                                                @case(3)
                                                                                    Rabu
                                                                                    @break
                                                                                @case(4)
                                                                                    Kamis
                                                                                    @break
                                                                                @case(5)
                                                                                    Jumat
                                                                                    @break
                                                                                @case(6)
                                                                                    Sabtu
                                                                                    @break
                                                                                @case(7)
                                                                                    Minggu
                                                                                    @break
                                                                                @default
                                                                                    Unknown Day
                                                                            @endswitch</td>
                                                                        <td>{{$jadwal->mulai}} - {{$jadwal->selesai}}</td>
                                                                        <td>@if($jadwal->is_shift == '1') Shift @endif</td>
                                                                        <td>{{$jadwal->uraian}}</td>
                                                                    </tr>
                                                                    @endif
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <hr />
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="pengajuanmap" id="pengajuanmap" style="height:300px;"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    <label for="exampleFormControlSelect1" class="ms-0">Berlaku Hingga</label>
                                    <input type="text" id="tBelaku" name="tBelaku" class="form-control" value="{{$detail_pengajuan->berlaku_sampai}}" disabled>
                                    
                                </div>
                            </div>
                            
                        </div>
                        @if($role == 'adminptsp')
                            @if($detail_pengajuan->isApproved == '2')
                            <div class="card-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success" id="setujuisiplama" data-id="{{$id_pengajuan}}" data-updater = '{{$user_id}}'>Setujui</button>
                                    <button type="button" class="btn btn-warning" id="tolaksiplama" data-id="{{$id_pengajuan}}" data-updater = '{{$user_id}}' data-idnakes = "{{$detail_pengajuan->id_nakes}}" data-salinan = "{{$detail_pengajuan->salinan}}">Tolak</button>
                                    <button type="button" class="btn btn-danger" id="hapussiplama" data-id="{{$id_pengajuan}}" data-updater = '{{$user_id}}' data-idnakes = "{{$detail_pengajuan->id_nakes}}" data-salinan = "{{$detail_pengajuan->salinan}}">Hapus</button>
                                </div>    
                            </div>
                            @endif
                        @endif
                        @if($role == 'kaptsp')
                            @if($detail_pengajuan->isApproved == 'CF' && $detail_pengajuan->suratpencabutan == 'A')
                                <button type="button" class="btn btn-success" id="cetakpencabutanlama" data-id="{{$id_pengajuan}}" data-updater = '{{$user_id}}'>CETAK</button>
                            @endif
                        @endif
                        <div class="overlay" id="lagisubmitdraft" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                    @if($role == 'adminptsp' || $role == 'dinkes')
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#histori" data-bs-toggle="tab">Histori</a></li>
                            <li class="nav-item"><a class="nav-link" href="#sejawat" data-bs-toggle="tab">Sejawat</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="histori">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                                    <table class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Updater</th>
                                                                <th>Tanggal</th>
                                                                <th>Nama Faskes</th>
                                                                <th>Keterangan</th>
                                                                <th>Alasan Ditolak</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="sejawat">
                                    @if(count($sejawat) > 0)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                                    <table class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Foto</th>
                                                                <th>Nama Nakes</th>
                                                                <th>No Registrasi</th>
                                                                <th>Str Hingga</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($sejawat as $sj)
                                                            <tr>
                                                                <td>{{$loop->iteration}}</td>
                                                                <td><img src="{{ URL::to('/storagefoto')}}/{{$sj->saved_photo}}" width="50px" alt="user image"></td>
                                                                <td>{{$sj->nama}}</td>
                                                                <td>{{$sj->no_reg}}</td>
                                                                <td>{{$sj->str_hingga}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
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

        function updatesiplama(data){

            var id_pengajuan = data.id_pengajuan;
            var jenis = data.jenis;
            var updater = data.updater;
            var tolaklokasi = data.tolaklokasi;
            var alasanlokasi = data.alasanlokasi;
            var tolakjadwal = data.tolakjadwal;
            var alasanjadwal = data.alasanjadwal;
            var tolakfile = data.tolakfile;
            var alasanfile = data.alasanfile;

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("update.sip.manual")}}',
                data: {
                    'id_pengajuan' : id_pengajuan,  
                    'jenis' : jenis,
                    'tolaklokasi' : tolaklokasi,
                    'alasanlokasi' : alasanlokasi,
                    'tolakjadwal' : tolakjadwal,
                    'alasanjadwal' : alasanjadwal,
                    'tolakfile' : tolakfile,
                    'alasanfile' : alasanfile,
                    'updater' : updater,
                    _token: "{{ csrf_token() }}"},
                //async: false,
                dataType: 'json',
                success: function(response){
                    
                    if (response.success == true) {

                        Swal.fire({
                            title: 'Tersimpan!',
                            text: 'Pengajuan SIP Lama Telah Berhasil Disetujui!',
                            icon: 'success'
                        }).then((result) => {
                            window.location.href = "{{route('admin.pengajuansipmanual')}}";
                        });

                    } else {
                        Swal.fire({

                            title: 'Gagal!',
                            text: 'Pengajuan SIP Lama Gagal Disetujui!',
                            icon: 'success'

                        }).then((result) => {
                            window.location.reload();
                        });
                        
                    }

                },
                
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });


        }

        $('#setujuisiplama').click(function(){
            var id_pengajuan_ = $(this).attr('data-id');
            var id_pengajuan = id_pengajuan_.substring(1);
            var updater = $(this).attr('data-updater');
            var data = {
                id_pengajuan: id_pengajuan,
                jenis: "4",
                updater: updater,
                tolaklokasi: "",
                alasanlokasi: "",
                tolakjadwal: "",
                alasanjadwal: "",
                tolakfile: "",
                alasanfile: ""
            };

            if (confirm("Apakah Anda Yakin Untuk Menyetujui SIP Lama Berikut?") == true) {
                updatesiplama(data)
            }

        })

        $('#tolaksiplama').click(function(){
            var id_pengajuan = $(this).attr('data-id')
            var updater = $(this).attr('data-updater')
            var id_nakes = $(this).attr('data-idnakes')
            var salinan = $(this).attr('data-salinan')
            $('.nonmanual').hide()
            $('#tid_nakest').val(id_nakes)
            $('#tolak_salinan').val(salinan)
            $('#tolakModal').modal('show')
            
        })

        $('#hapussiplama').click(function(){
            var id_pengajuan = $(this).attr('data-id')
            var updater = $(this).attr('data-updater')
            var id_nakes = $(this).attr('data-idnakes')
            var salinan = $(this).attr('data-salinan')

            Swal.fire({
            title: 'Apakah Anda Yakin Untuk Menghapus Pengajuan Ini?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            }).then((result) => {

                if (result.value == true) {

                    $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '{{ route("hapus.sip.lama")}}',
                        data: {'id_pengajuan': id_pengajuan, 'id_nakes': id_nakes, 'salinan':salinan, _token: "{{ csrf_token() }}"},
                        dataType: 'json',
                        success: function(data){

                            if(data.success == true) {
                                Swal.fire('Sukses!', '', 'success')
                                window.location.href = "{{route('admin.pengajuansipmanual')}}";
                            } else {
                                Swal.fire(data.keterangan, '', 'info')
                            }

                        },
                        error: function(request, status, error){
                            alert(request.responseText);
                        }
                    });
                    
                    
                }
            });
            
        })

        $("#cetakpencabutanlama").on('click', function(){

            $.fancybox.open({
                src: '#modal-draftkadin-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('.tutupintipdraftkadin').click(function() {
                        $.fancybox.close();
                    });
                }
            });

        })

        $('#submitttekadin').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route ('submit.tte.kadin') }}`;
            let formData = new FormData($(this)[0])
            formData.append('_token', "{{ csrf_token() }}");
            
            $.ajax({
                url: link,
                data: formData,
                cache:false,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                method: "POST",
                beforeSend: function() {
                    //$('#btnsubmittte').attr('disabled', true)
                    $('#sedangttekadin').show()
                },
                success: function (data) {
                    console.log(data)
                    $('#sedangttekadin').hide()
                    //$('#btnsubmittte').attr('disabled', false)
                    if(data.success == true) {
                        $.fancybox.close();
                        Swal.fire(data.keterangan).then(function() {
                            window.location.href = "{{ route('kaptsp.main.dashboard')}}";
                            //window.location.reload();
                        });
                        
                    } else {
                        $.fancybox.close();
                        Swal.fire({
                            icon: "error",
                            title: "Terjadi Kesalahan",
                            text: data.keterangan
                        });
                        //$('#btnsubmittte').attr('disabled', false)
                    }
                }
            });
            
        });

       
    });
</script>

@endsection

