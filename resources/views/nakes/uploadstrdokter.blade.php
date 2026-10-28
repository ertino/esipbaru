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
                <div id="modal-strmanual-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Submit STR DOKTER (Manual)
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row" id="tabularhasilmanual" style="display:none">
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
                                                <div class="alert alert-info alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                    <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
                                                    Pastikan PDF yang anda upload sudah sesuai dikarenakan sistem untuk saat ini belum dapat melakukan validasi pada website resmi KKI.
                                                </div>
                                                <div class="col-md-12 col-xs-12">
                                                <embed id="hasiluploadstrmanual" src="" width="100%" height="100%"></embed>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="simpanstrdoktermanualform" action="{{route('simpan.strmanual.dokter')}}" method="post" class="form-horizontal">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                                    <input type="text" id="stNama" name="stNama" class="form-control" value="{{ $nama_user }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                                    <input type="text" id="stNoSTR" name="stNoSTR" class="form-control" value="{{$current_str->no_doc}}" readonly>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="row" style="display:none">

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                                    <input type="text" id="sturlqrmanualdok" name="sturlqrmanualdok" class="form-control"  readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID NAKES</label>
                                                    <input type="text" id="stUserIDNakesDokmanual" name="stUserIDNakesDokmanual" class="form-control" value="{{$user_id}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Filename</label>
                                                    <input type="text" id="stWhichFManualDok" name="stWhichFManualDok" class="form-control"  readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                                    <input type="text" id="stSTRtetapSIPManual" name="stSTRtetapSIPManual" class="form-control" value = "{{$current_str->kompetensi}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">STR Hingga</label>
                                                    <input type="text" id="stSTRHinggaSIPManual" name="stSTRHinggaSIPManual" class="form-control" value="{{$current_str->tgl_doc}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                    <input type="text" id="stSalinanManual" name="stSalinanManual" class="form-control">
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-success" id="btnsimpanstrdoktermanual" data-id="{{$user_id}}">Simpan</button>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div id="modal-nonvalidate-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                STR DOKTER
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="simpanstrdoktermanualform" action="{{route('simpan.strnv.dokter')}}" method="post" class="form-horizontal">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                                    <input type="text" id="stNamanv" name="stNamanv" class="form-control" value="{{ $nama_user }}">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                                    <input type="text" id="stNoSTRnv" name="stNoSTRnv" class="form-control" value="" required>
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="row" style="display:none">

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID NAKES</label>
                                                    <input type="text" id="stUserIDNakesDokmanual" name="stUserIDNakesDokmanual" class="form-control" value="{{$user_id}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Filename</label>
                                                    <input type="text" id="stWhichnvDok" name="stWhichnvDok" class="form-control"  readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Profesi *</label>
                                                    <select class="form-control" id="stProfesinv" name="stProfesinv" required>
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
                                                    <input type="text" id="stKompetensinv" name="stKompetensinv" value="{{$current_str->kompetensi}}" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">STR Ditetapkan</label>
                                                    <input type="date" id="stSTRtetapSIPnv" name="stSTRtetapSIPnv" class="form-control" value = "" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">STR Hingga</label>
                                                    <input type="date" id="stSTRHinggaSIPnv" name="stSTRHinggaSIPnv" class="form-control" value="" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                    <input type="text" id="stSalinannv" name="stSalinannv" class="form-control">
                                                </div>
                                            </div>

                                        </div>
                                        <button type="submit" class="btn btn-success" id="btnsimpanstrdokternv" data-id="{{$user_id}}">Simpan</button>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="modal-scanfirst-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Silahkan Scan QRCODE STR Sub Spesialis Terlebih Dahulu
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="simpanstrdoktermanualform" action="" method="post" class="form-horizontal">
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
                                                            <div id="qr-dokter-reader" style="width:500px"></div>
                                                            <div id="qr-dokter-reader-results"></div>
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
                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <div>
                                Upload Dokumen STR Pembaharuan
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-warning alert-dismissible">
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian!</h5>
                                        Mohon Dipastikan Kembali STR yang Anda Akan Upload Sudah Sesuai.
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                
                                    <center>
                                    <h3> Upload Dokumen STR (PDF)</h3>
                                    <form enctype="multipart/form-data" id="formUploadSTRDokter" method="post" class="form-horizontal">
                                        @csrf
                                      
                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen STR</label>
                                                    <input type="file" id="tFileSTRDok" name="tFileSTRDok" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Dokumen STR</label>
                                                    <input type="text" id="tUserIdDokter" name="tUserIdDokter" class="form-control" value="{{$user_id}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Nama STR</label>
                                                    <input type="text" id="tcurrentNamaStrDok" name="tcurrentNamaStrDok" class="form-control" value="{{ $nama_user }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">STR Hingga</label>
                                                    <input type="text" id="tcurrenthinggaDok" name="tcurrenthinggaDok" class="form-control" value="{{$current_str->tgl_doc_origin}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Requested Salinan</label>
                                                    <input type="text" id="tRequestedSalinanDok" name="tRequestedSalinanDok" class="form-control" value="{{$salinan}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Kompetensi</label>
                                                    <input type="text" id="tcurrentkompetensiDok" name="tcurrentkompetensiDok" class="form-control" value="{{$current_str->kompetensi}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">No Reg</label>
                                                    <input type="text" id="tcurrentnostrDok" name="tcurrentnostrDok" class="form-control" value="{{$current_str->no_doc}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Current Template ID</label>
                                                    <input type="text" id="tCurrentTemplateID" name="tCurrentTemplateID" class="form-control" value="{{$current_str->template_id}}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">isManual</label>
                                                    <input type="text" id="tismanualstr" name="tismanualstr" class="form-control" value="{{$ismanual}}">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <button type="submit" id="submitSTRDokter" class="btn btn-success submitSTRDokter">Submit</button>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="overlay" id="cobali" style="display:none">
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

@section('script')

<script type="text/javascript">


    $(document).ready(function() {

        $('#form-submittalente').on('submit', function(e){
            e.preventDefault();
            let link = `{{ url('app/submittalentee') }}`;
            let formData = new FormData($(this)[0])
            

            $.ajax({
                url: link,
                data: formData,
                cache:false,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                method: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $('#btnsubmittalentee').attr('disabled', true)
                    Swal.fire({
                        allowEscapeKey: false,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading()
                        },
                        title: 'Tunggu Sebentar, <br /><small class="text-gray-500">Sistem sedang bekerja</small>',
                    })
                },
                success: function (data) {
                    $('#btnsubmittalentee').attr('disabled', false)
                    Swal.close();
                    if(data.success) {

                        Swal.fire(data.keterangan).then(function() {
                             
                            window.location.reload();
                            
                        });
                        
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Ambil Data Simpeg',
                        })
                        $('#btnsubmittalentee').attr('disabled', false)
                    }
                    console.log(data)
                    
                }
            });
            
        });

    });

</script>

@endsection