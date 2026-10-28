@extends('layouts.minlte.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Selamat Datang Di Ijin Nakes</h1>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div id="modal-nonvalidates-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                STR DOKTER 
                            </div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm float-right tutupdokternv">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <embed id="hasilnvstr" src="" width="100%" height="100%"></embed>
                                </div>
                            </div>
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
                                                    <input type="text" id="stUserIDNakesDoknv" name="stUserIDNakesDoknv" class="form-control" value="{{$user_id}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Non Validate</label>
                                                    <input type="text" id="stnonvalidate" name="stnonvalidate" class="form-control" value="1" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID Request</label>
                                                    <input type="text" id="strequestnv" name="strequestnv" class="form-control" value="{{$idrequest}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Filename</label>
                                                    <input type="text" id="stWhichnvDok"  name="stWhichnvDok" class="form-control"  readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Profesi *</label>
                                                    <select class="form-control" id="stProfesinv" name="stProfesinv" required>
                                                        <option value="" selected disabled>--Pilih--</option>
                                                       
                                                        <option value="DOKTER UMUM">DOKTER UMUM</option>
                                                        <option value="DOKTER GIGI">DOKTER GIGI</option>
                                                        <option value="DOKTER SPESIALIS">DOKTER SPESIALIS</option>
                                                        <option value="DOKTER GIGI SPESIALIS">DOKTER GIGI SPESIALIS</option>
                                                        
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
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
                                                    <input type="date" id="stSTRtetapSIPnv" name="stSTRtetapSIPnv" class="form-control" value = "" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">STR Hingga</label>
                                                    <input type="checkbox" id="isseumurnv" name="isseumurnv">Seumur Hidup
                                                    <input type="date" id="stSTRHinggaSIPnv" name="stSTRHinggaSIPnv" class="form-control" value="" >
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                    <input type="text" id="stSalinannv" name="stSalinannv" value="{{$salinan}}" class="form-control" required>
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
                                    <form enctype="multipart/form-data" id="formPerpanjangan" method="post" class="form-horizontal">
                                        @csrf
                                      
                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen STR</label>
                                                    <input type="file" id="tFileSTR" name="tFileSTR" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Dokumen STR</label>
                                                    <input type="text" id="tUserIdPerpanjangan" name="tUserIdPerpanjangan" class="form-control" value="{{$user_id}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Nama STR</label>
                                                    <input type="text" id="tcurrentNamaStr" name="tcurrentNamaStr" class="form-control" value="{{ $nama_user }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">STR Hingga</label>
                                                    <input type="text" id="tcurrenthingga" name="tcurrenthingga" class="form-control" value="{{$current_str->tgl_doc_origin}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Current Salinan</label>
                                                    <input type="text" id="tCurrentSalinanP" name="tCurrentSalinanP" class="form-control" value="{{$salinan}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Current ID Pengajuan</label>
                                                    <input type="text" id="tCurrentIDPengajuan" name="tCurrentIDPengajuan" class="form-control" value="{{$currentidpengajuan}}">
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Kompetensi</label>
                                                    <input type="text" id="tcurrentkompetensi" name="tcurrentkompetensi" class="form-control" value="{{$current_str->kompetensi}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">No Reg</label>
                                                    <input type="text" id="tcurrentnostr" name="tcurrentnostr" class="form-control" value="{{$current_str->no_doc}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Current Template ID</label>
                                                    <input type="text" id="tCurrentTemplateID" name="tCurrentTemplateID" class="form-control" value="{{$current_str->template_id}}">
                                                </div>
                                            </div>


                                        </div>
                                        
                                    </form>

                                    <button type="submit" id="submitPerpanjangan" class="btn btn-success submitPerpanjangan" data-dokter="1">Submit</button>
                                    
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

        $('#isseumurnv').change(function() {
            if($(this).is(':checked')) {
                $('#stSTRHinggaSIPnv').prop('readonly', true);
            } else {
                $('#stSTRHinggaSIPnv').prop('readonly', false);
            }
        });


    })


</script>

@endsection