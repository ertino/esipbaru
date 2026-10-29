@extends('layouts.adminlte4.back_master')
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
                                                    <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
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
                                    <form id="simpanstrdoktermanualform" action="{{route('simpan.strsubmanual.dokter')}}" method="post" class="form-horizontal">
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
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                                    <input type="text" id="stSTRtetapSIPManual" name="stSTRtetapSIPManual" class="form-control" value = "{{$current_str->kompetensi}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">STR Hingga</label>
                                                    <input type="text" id="stSTRHinggaSIPManual" name="stSTRHinggaSIPManual" class="form-control" value="{{$current_str->tgl_doc}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kompetensi Subspesialis</label>
                                                    <input type="text" id="stKomSub" name="stKomSub" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="col-md-12 col-xs-12" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kompetensi Subspesialis</label>
                                                    <input type="text" id="stjenissub" name="stjenissub" class="form-control" value="stsub">
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
                                Upload Dokumen STR Sub Spesialis
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
                                    <h3> Upload Dokumen STR Sub Spesialis (PDF)</h3>
                                    <form enctype="multipart/form-data" id="formUploadSTRSubDokter" method="post" class="form-horizontal">
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
                                                    <input type="text" id="tUserIdDokterSub" name="tUserIdDokterSub" class="form-control" value="{{$user_id}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Dokumen STR</label>
                                                    <input type="text" id="tIsSub" name="tIsSub" class="form-control" value="1" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Dokumen STR</label>
                                                    <input type="text" id="tcurrenturlqr" name="tcurrenturlqr" class="form-control" value="{{$current_str->url_qr}}" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Dokumen STR</label>
                                                    <input type="text" id="turlqrsubspesialis" name="turlqrsubspesialis" class="form-control" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Dokumen STR</label>
                                                    <input type="text" id="tmainSTRurl" name="tmainSTRurl" class="form-control" value="{{$allismanual}}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <button type="submit" id="submitSTRSubDokter" class="btn btn-success submitSTRSubDokter">Submit</button>
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
        var resultContainer = document.getElementById('qr-dokter-reader-results');
        var lastResult, countResults = 0;
        //const fileInput = document.getElementById("#qr-reader__dashboard_section_swaplink");
        //fileInput.classList.add("hiddenopt");
        
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-dokter-reader", { fps: 10, qrbox: 250 });
        
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                console.log(`Scan result = ${decodedText}`, decodedResult);
                var exisiting = $('#tcurrenturlqr').val();
                var issubstr = decodedText.charAt(decodedText.length - 1);
                $('#turlqrsubspesialis').val(decodedText)
                $.fancybox.close()
               
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
    
    $(document).ready(function() {

        $.fancybox.open({
            src: '#modal-scanfirst-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false,
        });


        $('#submitSTRSubDokter').click(function(){
        $('#cobali').show()

        var data = $('#formUploadSTRSubDokter').serialize();
        var form = $('#formUploadSTRSubDokter')[0];
        var dataform = new FormData(form);
        var existingurl_ = $('#tmainSTRurl').val();


        var result = '';

        if ($('#tFileSTRDok')[0].files.length === 0) {
            alert('Silahkan Attach File PDF');
        } else {
            result += '1';
        }

        if (result == '1') {

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("dokter.submit.strmanual")}}',
                data: dataform,
                cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                //async: false,
                beforeSend: function() {
            

                },
                //	dataType: 'json',
                success: function(response) {

                    console.log(response)
                    if (response.success == true) {

                        $('#tabularhasilmanual').show()
                        

                        var originfile = response.namafile;
                        var thelink = response.dataextraction.thelink;
                
                        $('#stWhichFManualDok').val(originfile);

                        var hasilsource = "";
                        var parent = $('#hasiluploadstrmanual').parent();
                        var newElement = "<embed src='{{ URL::to('/storage')}}/"+originfile+".pdf' id='hasiluploadstrmanual' width='100%' height='400px'>";
                        $('#hasiluploadstrmanual').remove();
                        parent.append(newElement);

                        if (response.success_extract == true) {
                            var subspesial = response.resultword.subspesialis
                            if(subspesial != '') {
                                $('#stKomSub').val(subspesial)
                            } else {
                                $('#stKomSub').val('')
                            }

                        }

                        $.fancybox.open({
                            src: '#modal-strmanual-content',
                            type: 'inline',
                            touch: false,
                            modal: true,
                            clickSlide: false,
                        });

                    } else {
                        alert(response.keterangan)
                    }
                    
                },
                complete: function(data) {

                    $('#cobali').hide()

                },
                error: function(request, status, error) {
                    alert(request.responseText);
                    $('#cobali').hide()
                }
            });
        }



        })
    })

</script>

@endsection