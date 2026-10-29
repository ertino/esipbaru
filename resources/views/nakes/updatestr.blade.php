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
                <div id="modal-nonvalidatesnd-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Form Perpanjangan STR
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row" id="scanperpanjanganstr">
                                        <div class="col-md-12">
                                            <form id="updateqrperpanjangan" action="" method="post" class="form-horizontal">
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
                                                                    <div id="qr-perpanjanganstr-reader" style="width:500px"></div>
                                                                    <div id="qr-perpanjanganstr-reader-results"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </form> 
                                        </div>
                                    </div>
                                    <div class="row" id="framednv" style="display:none">
                                        <embed id="hasilframednv" width="100%" src="">
                                        </embed>
                                    </div>                       
                                    <form id="simpanstrdoktermanualform" action="{{route('simpan.strnv.dokter')}}" method="post" class="form-horizontal" style="display:none">
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
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID NAKES</label>
                                                    <input type="text" id="stUserIDNakesDoknv" name="stUserIDNakesDoknv" class="form-control" value="{{$user_id}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID NAKES</label>
                                                    <input type="text" id="strequestnv" name="strequestnv" class="form-control" value="{{$user_id}}_{{$current_str->salinan}}" readonly>
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
                                                    <label for="exampleFormControlSelect1" class="ms-0">Filename</label>
                                                    <input type="text" id="stWhichnvDok"  name="stWhichnvDok" class="form-control"  readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">urlqr</label>
                                                    <input type="text" id="stURLnv"  name="stURLnv" class="form-control"  readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Profesi *</label>
                                                    <select class="form-control" id="stProfesinv" name="stProfesinv" required>
                                                    @foreach($semuaprofesi as $profe)
                                                        <option value="{{$profe->alias_profesi}}">{{$profe->nama_profesi}}</option>
                                                    @endforeach
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
                                                    <input type="text" id="stSalinannv" name="stSalinannv" value="{{$current_str->salinan}}" class="form-control" required>
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
                <div class="col-md-12 col-xs-12">
                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <h3 class="card-title">
                                Upload STR Pembaharuan
                            </h3>
                            <div class="card-tools">
                                <a type="button" class="btn btn-primary" id="lanjutklasifikasi" style="display:none" href="{{route('nakes.lanjut.perpanjangan', $user_id)}}">
                                    Update e-SIP <i class="fas fa-arrow-right"></i> 
                                </a>
                            </div>

                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="alert alert-warning alert-dismissible" id="keteranganklasifikasi">
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian!</h5>
                                        Upload STR Anda Dibawah Ini Jika Anda Memiliki STR yang Terbaru (Berbeda Dengan Yang Ada Pada Sistem e-SIP). Klik Tombol "Update SIP <i class="fas fa-arrow-right"></i>" Jika Tidak Ada Perubahan Pada STR Anda.
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

                                        @if($klasifikasi == '4' || $klasifikasi == '6')

                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                    <select type="file" id="tpicksalinan" name="tpicksalinan" class="form-control" required>
                                                        <option value="1" selected>1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="row" style="display:none">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Dokumen STR</label>
                                                    <input type="text" id="tUserIdPerpanjangan" name="tUserIdPerpanjangan" class="form-control" value="{{$user_id}}" required>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">tanpa salinan</label>
                                                    <input type="text" id="tTanpaSalinan" name="tTanpaSalinan" class="form-control" value="{{$current_str->remark3}}">
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
                                                    <label for="" class="ms-0">Current Salinan</label>
                                                    <input type="text" id="tCurrentSalinanP" name="tCurrentSalinanP" class="form-control" value="{{$current_str->salinan}}">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Current ID Pengajuan</label>
                                                    <input type="text" id="tCurrentIDPengajuan" name="tCurrentIDPengajuan" class="form-control">
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="ms-0">Current Template ID</label>
                                                    <input type="text" id="tCurrentTemplateID" name="tCurrentTemplateID" class="form-control" value="{{$current_str->template_id}}">
                                                </div>
                                            </div>
                                            <div class="row" id="klasifikan" style="display:none">
                                                <div class="form-group">
                                                    <input type="text" id="tklasifikasi" name="tklasifikasi" class="form-control" value="{{$klasifikasi}}">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <button type="submit" id="submitPerpanjangan" class="btn btn-success submitPerpanjangan" data-dokter="0">Submit</button>
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
        var resultContainer = document.getElementById('qr-perpanjanganstr-reader-results');
        var lastResult, countResults = 0;
        //const fileInput = document.getElementById("#qr-reader__dashboard_section_swaplink");
        //fileInput.classList.add("hiddenopt");
        
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-perpanjanganstr-reader", { fps: 10, qrbox: 250 });
        
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                console.log(`Scan result = ${decodedText}`, decodedResult);
                var isCheckStr = decodedText.includes('cek_str')
                var thelinker = 0;
                if (isCheckStr == true) {
                    thelinker = 1;
                } else {
                    var iscekdokter = decodedText.includes('cekdokter')
                    if (iscekdokter == true) {
                        thelinker = 2;
                    } else {

                        thelinker = 0;

                    }
                    
                }
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ route("get.data.strdftr")}}',
                    data: {'thename': decodedText, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
                    async: false,
                    dataType: 'json',
                    success: function(data){

                        console.log(data)
                        if(data.success == false) {
                            alert(data.keterangan);
                        }

                        var urlnye = decodedText;
                        var urlfix = urlnye.replace('http:', 'https:')
                        
                        var obj = jQuery.parseJSON(data)
                        console.log(obj)
                        
                        $('#stURLnv').val(urlfix)
                        $('#hasilframednv').attr('src', urlfix)
                        $('#framednv').show()

                        $('#stNamanv').val(obj.nama_nakes);
                        $('#stNoSTRnv').val(obj.no_reg);
                       
                        $('#stKompetensi').val(obj.kompetensi)
                        if(obj.str_hingga == 'Seumur Hidup') {
                            $('#isseumurnv').attr('checked', true)
                        }
                

                        let isfarma = false;
                        isfarma = obj.kompetensi.toUpperCase().includes("FARMASI")

                        if (iscekdokter == true) {
                            
                            var finalprof = '<option value="'+obj.profesi_sip_singkatan+'" selected>'+obj.profesi_sip_terbilang+' ('+obj.profesi_sip_singkatan+') </option>'
                            $('#stProfesinv').html(finalprof);
                            
                    
                        }
                        $('#scanperpanjanganstr').hide()
                        $('#simpanstrdoktermanualform').show()
                    },
                    error: function(request, status, error){
                        //alert(request.responseText);
                    }
                });
                
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

    

</script>

<script>
$(document).ready(function() {

    var klasifikasi = $('#tklasifikasi').val()
    console.log(klasifikasi)
    if(klasifikasi == '1' || klasifikasi == '3' || klasifikasi == '4' || klasifikasi == '6' || klasifikasi == '7') {
        $('#lanjutklasifikasi').show()
        $('#keteranganklasifikasi').html('<h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian!</h5>Upload STR Anda Dibawah Ini Jika Anda Memiliki STR yang Terbaru (Berbeda Dengan Yang Ada Pada Sistem e-SIP). Klik Tombol "Update SIP <i class="fas fa-arrow-right"></i>" Jika Tidak Ada Perubahan Pada STR Anda.')
    } else {
        $('#lanjutklasifikasi').hide()
        $('#keteranganklasifikasi').html('<h5><i class="icon fas fa-exclamation-triangle"></i> Perhatian!</h5>Upload STR Anda Dibawah Ini Jika Anda Memiliki STR yang Terbaru (Berbeda Dengan Yang Ada Pada Sistem e-SIP) Karena STR Anda Sudah Hampir Kadaluarsa. Setelah Proses Update STR tervalidasi, Anda Dapat Melanjutkan Untuk Memperpanjang e-SIP.')
    }

});

</script>


@endsection