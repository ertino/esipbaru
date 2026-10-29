@extends('layouts.adminlte4.back_master')
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

            @if ($isedit == 1)
                
                <div class="col-md-6 col-xs-12">

                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <div>
                                Upload Dokumen STR (PDF ber QRCODE)
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
                                    <form enctype="multipart/form-data" id="formUploadSTRnonDokter" method="post" class="form-horizontal">
                                        @csrf
                                      
                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen STR</label>
                                                    <input type="file" id="tFileSTRnonDok" name="tFileSTRnonDok" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Dokumen STR</label>
                                                    <input type="text" id="tUserIdnonDokter" name="tUserIdnonDokter" class="form-control" value="{{$user_id}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Nama STR</label>
                                                    <input type="text" id="tcurrentNamaStrnonDok" name="tcurrentNamaStrnonDok" class="form-control" value="{{ $nama_user }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">STR Hingga</label>
                                                    <input type="text" id="tcurrenthingganonDok" name="tcurrenthingganonDok" class="form-control" value="{{$current_str->tgl_doc_origin}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Requested Salinan</label>
                                                    <input type="text" id="tRequestedSalinannonDok" name="tRequestedSalinannonDok" class="form-control" value="{{$salinan}}" required>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Kompetensi</label>
                                                    <input type="text" id="tcurrentkompetensinonDok" name="tcurrentkompetensinonDok" class="form-control" value="{{$current_str->kompetensi}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">No Reg</label>
                                                    <input type="text" id="tcurrentnostrnonDok" name="tcurrentnostrnonDok" class="form-control" value="{{$current_str->no_doc}}" required>
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
                                                    <label for="" class="ms-0">URL STR</label>
                                                    <input type="text" id="tcurrenurlstr" name="tcurrenurlstr" class="form-control" value="{{$current_str->url_qr}}" required>
                                                </div>
                                            </div>


                                        </div>
                                        
                                    </form>

                                    <button type="submit" id="updateSTRNonDokter" data-idnakes="{{$user_id}}" class="btn btn-success submitSTRDokter">Update</button>
                                    
                                    </center>

                                </div>
                                 

                            </div>
                        
                        </div>
                        <div class="overlay" id="cobali" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>


                    </div>

                

                </div>

                <div class="col-md-6">
                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <div>
                                Hasil Scan STR
                            </div>
                        </div>
                        <div class="card-body">

                            
                        </div>
                    </div>

                </div>


            @else

                <div class="col-md-12 col-xs-12">

                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <div>
                                Upload Dokumen STR (PDF ber QRCODE)
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
                                    <form enctype="multipart/form-data" id="formUploadSTRnonDokter" method="post" class="form-horizontal">
                                        @csrf
                                      
                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen STR</label>
                                                    <input type="file" id="tFileSTRnonDok" name="tFileSTRnonDok" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Dokumen STR</label>
                                                    <input type="text" id="tUserIdnonDokter" name="tUserIdnonDokter" class="form-control" value="{{$user_id}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Nama STR</label>
                                                    <input type="text" id="tcurrentNamaStrnonDok" name="tcurrentNamaStrnonDok" class="form-control" value="{{ $nama_user }}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">STR Hingga</label>
                                                    <input type="text" id="tcurrenthingganonDok" name="tcurrenthingganonDok" class="form-control" value="{{$current_str->tgl_doc_origin}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Requested Salinan</label>
                                                    <input type="text" id="tRequestedSalinannonDok" name="tRequestedSalinannonDok" class="form-control" value="{{$salinan}}" required>
                                                </div>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Kompetensi</label>
                                                    <input type="text" id="tcurrentkompetensinonDok" name="tcurrentkompetensinonDok" class="form-control" value="{{$current_str->kompetensi}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">No Reg</label>
                                                    <input type="text" id="tcurrentnostrnonDok" name="tcurrentnostrnonDok" class="form-control" value="{{$current_str->no_doc}}" required>
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

                                    <button type="submit" id="submitSTRNonDokter" class="btn btn-success submitSTRDokter">Submit</button>
                                    
                                    </center>

                                </div>
                                 

                            </div>
                        
                        </div>
                        <div class="overlay" id="cobali" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>


                    </div>

                

                </div>
            @endif

            </div>
        </div>
    </section>
</div>






@endsection
@section('js')

@endsection