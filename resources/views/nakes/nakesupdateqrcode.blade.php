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
                <div id="modal-konfirmqr-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="judulupdateqr">
                                Update QRCODE Salinan 
                            </div>
                            <div class="card-tools">
                                
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="jikasalinantidaksama" style="display:none">

                                <div class="alert alert-danger alert-dismissible">
                                    <h5><i class="icon fas fa-ban"></i> STR Salinan Berbeda</h5>
                                    STR yang anda upload bukan merupakan salinan yang diharapkan secara sistem. Mohon periksa kembali, jika memang sudah benar silahkan ke proses berikutnya
                                </div>
                            </div>
                            <form id="formDaftar" method="post" class="form-horizontal" action="{{ route('simpan.update.qrcode') }}">
                                @csrf
                                <div class="row" style="display:none">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Dokumen STR</label>
                                            <input type="text" id="qrcurrentsalinan" name="qrcurrentsalinan" class="form-control" value="{{$salinan}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Dokumen STR</label>
                                            <input type="text" id="qrupdaterid" name="qrupdaterid" class="form-control" value="{{$user_id}}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">ID Dokumen</label>
                                            <input type="text" id="qriddocument" name="qriddocument" class="form-control" value="{{$current_str->id}}">
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Dokumen STR</label>
                                            <input type="text" id="qrcurrenturlqr" name="qrcurrenturlqr" class="form-control" value="{{$current_str->url_qr}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">ID Dokumen</label>
                                            <input type="text" id="qrupdatedurl" name="qrupdatedurl" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm" id="updateqrcodestrnakes">Update</button>
                            </form>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraft" id="close-konfirmqr-modal">Tutup</button>
                        </div>
                        <div class="overlay" id="editqrnya" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-xs-12">
                    <div class="alert alert-warning alert-dismissible">
                        <h5><i class="icon fas fa-exclamation-triangle"></i>Dokumen STR Harus Diupdate</h5>
                        Dikarenakan Sistem Gagal Mendapatkan Data QRCODE yang ada pada STR, Silahkan Scan QRCODE pada STR anda, sesuai dengan salinan yang ada yakni Salinan {{$salinan}}. Ini Diharuskan karena untuk mendapatkan File e-SIP, Anda harus meregistrasikan STR salinan yang sesuai ke DPMPTSP / MPP
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <div>
                                Scan QRCODE pada STR anda Sesuai Dengan Salinan
                            </div>
                        </div>

                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-12 col-xs-12 col-xs-12">
                                    <div class="card card-widget overlay dark">
                                        <div class="card-header">
                                            <div>
                                            Scan QRCODE Pada Salinan {{$salinan}}
                                            </div>

                                        </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div id="qr-reader-updok" style="width:500px"></div>
                                                    <div id="qr-reader-updok-results"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        </div>
                        <div class="overlay" id="updokloading" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="card">
                        <div class="card-body">
                            <embed src="{{ URL::to('/storage')}}/{{$current_str->namafile}}.pdf" width="100%" height="500px"></embed>
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
            var resultContainer = document.getElementById('qr-reader-updok-result');
            var lastResult, countResults = 0;
            
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader-updok", { fps: 10, qrbox: 250 });
            
            function onScanSuccess(decodedText, decodedResult) {
                console.log(decodedText)
                if (decodedText !== lastResult) {
                    ++countResults;
                    lastResult = decodedText;
                    html5QrcodeScanner.clear();
                    const qrcurrentsalinan = $('#qrcurrentsalinan').val()
                    const lastChar = decodedText.substring(decodedText.length - 1);
                    if(decodedText.includes('cekdokter')) {

                        if(qrcurrentsalinan != lastChar) {
                            $('#jikasalinantidaksama').show()
                        } else {
                            $('#jikasalinantidaksama').hide()
                        }
                        $('#judulupdateqr').html('Update QRCODE Salinan Ke: '+qrcurrentsalinan)
                        $('#qrupdatedurl').val(decodedText)

                        $.fancybox.open({
                            src: '#modal-konfirmqr-content',
                            type: 'inline',
                            touch: false,
                            modal: true,
                            clickSlide: false,
                            afterShow: function() {
                                $('#close-konfirmqr-modal').click(function() {
                                    $.fancybox.close();
                                });
                            }
                        });

                    } else {
                        alert('STR Yang Anda Scan Bukan STR Dokter')
                    }  
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
@endsection