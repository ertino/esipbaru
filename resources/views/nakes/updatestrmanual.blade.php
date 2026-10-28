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
                <div id="modal-scanfirstmanualptsp-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Silahkan Scan QRCODE STR Terlebih Dahulu (Jika STR Baru Anda Sudah Memiliki QRCODE)
                            </div>
                            <div class="card-tools">
                            </div>
                        </div>
                        <div class="card-body">
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="simpanstrmanualform" action="" method="post" class="form-horizontal">
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
                                                            <div id="qr-manual-reader" style="width:500px"></div>
                                                            <div id="qr-manual-reader-results"></div>
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
                                Upload Dokumen STR (NON QRCODE) Pembaharuan (PDF)
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
                                                    <input type="text" id="tCurrentSalinanP" name="tCurrentSalinanP" class="form-control" required>
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
                                                    <label for="" class="ms-0">Current ID Pengajuan</label>
                                                    <input type="text" id="sturlqr_perpanjangan" name="sturlqr_perpanjangan" class="form-control" value="manual">
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

                                    <button type="submit" id="submitPerpanjanganManual" class="btn btn-success submitPerpanjanganManual">Submit</button>
                                    
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
        var resultContainer = document.getElementById('qr-manual-reader-results');
        var lastResult, countResults = 0;
        //const fileInput = document.getElementById("#qr-reader__dashboard_section_swaplink");
        //fileInput.classList.add("hiddenopt");
        
        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-manual-reader", { fps: 10, qrbox: 250 });
        
        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText !== lastResult) {
                ++countResults;
                lastResult = decodedText;
                console.log(`Scan result = ${decodedText}`, decodedResult);
                $('#sturlqr_perpanjangan').val(decodedText)
                // Optional: To close the QR code scannign after the result is found
                $.fancybox.close();
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
    $('#submitPerpanjanganManual').click(function(){

    $('#cobali').show()


    var data = $('#formPerpanjangan').serialize();
    var form = $('#formPerpanjangan')[0];
    var dataform = new FormData(form);
    var currentTemplate = $('#tCurrentTemplateID').val()
    var currentSalinan = $('#tCurrentSalinanP').val()
    var ismanualnext = $('#sturlqr_perpanjangan').val()



    var result = '';

    if ($('#tFileSTR')[0].files.length === 0) {
        alert('Silahkan Attach File PDF');
    } else {
        result += '1';
    }

    if (result == '1') {

        $('#lanjutperpanjangan')[0].reset();

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '{{ route("perpanjangan.submit.str")}}',
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
                    var urlnye = response.dataextraction.thelink;
                    var originfile = response.dataextraction.thefilename;
                    var urlfix = urlnye.replace('http:', 'https:')
                    //var urlfix = urlnye;
                    $('#stURL').val(urlfix)
                    $('#hasilscanupload').show()
                    if (urlfix.includes('devcheck') == false) {
                        $('#hasilframed').attr('src', urlfix)
                    }
                    var iscekdokter = false;

                    var isCheckStr = urlfix.includes('cek_str')
                    var thelinker = 0;
                    if (isCheckStr == true) {
                        thelinker = 1;
                    } else {
                        iscekdokter = urlfix.includes('cekdokter')
                        if (iscekdokter == true) {
                            urlfix = urlnye;
                            thelinker = 2;
                        } else if (urlfix.includes('devcheck')) {
                            thelinker = 4;
                        } else {
                            thelinker = 0;
                        }
                        
                    }

                    //console.log(thelinker)

                    if (thelinker == 4) {

                        /// put something here
                        $.ajax({
                            type: 'ajax',
                            method: 'get',
                            url: '{{ route("get.data.strdftrdev")}}',
                            data: {'thename': urlnye, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
                            async: false,
                            dataType: 'json',
                            success: function(data){

                                var obj = jQuery.parseJSON(data)

                                var nama_existing = $('#tcurrentNamaStr').val()
                                var kompetensi_existing = $('#tcurrentkompetensi').val()
                                var tgldoc_existing = $('#tcurrenthingga').val()

                                var comparenama = similarity(obj.nama_nakes, nama_existing)
                                var comparekompetensi = similarity(obj.kompetensi, kompetensi_existing)
                                var hasilnama = Math.round(comparenama*100)
                                var hasilkompetensi = Math.round(comparekompetensi*100)

                                var htmlcocoknama = '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'+hasilnama+'" aria-valuemin="0" aria-valuemax="100" style="width: '+hasilnama+'%">'

                                $('#cocoknamabar').html(htmlcocoknama)
                                $('#cocoknamavalue').html(hasilnama+'% Kecocokan')

                                var htmlcocokkompetensi = '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'+hasilkompetensi+'" aria-valuemin="0" aria-valuemax="100" style="width: '+hasilkompetensi+'%">'

                                $('#cocokkompetensibar').html(htmlcocokkompetensi)
                                $('#cocokkompetensivalue').html(hasilkompetensi+'% Kecocokan')

                                if (tgldoc_existing == obj.str_hingga) {
                                    $('#validasimasaberlaku').val('Masa Berlaku Sama Dengan STR Sebelumnya')
                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                    $('#jikatanggalsama').show()
                                } else {
                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                    $('#jikatanggalsama').hide()
                                }

                                if(hasilnama < 90) {
                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                    $('#jikanama').show()
                                } else {
                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                    $('#jikanama').hide()
                                }

                                if(hasilkompetensi < 95) {
                                    $('#jikabedakompetensi').show()
                                    $('#stKompetensiBeda').val('1')
                                } else {
                                    $('#jikabedakompetensi').hide()
                                    $('#stKompetensiBeda').val('0')
                                }

                                $('#stNama').val(obj.nama_nakes);
                                $('#stNoSTR').val(obj.no_reg);
                                $('#stJenisK').val(obj.jenis_kelamin);
                                $('#stKompetensi').val(obj.kompetensi)
                                
                                $('#stStatDok').val(obj.doc_stat);
                                $('#stImg').val('devcheck');
                                $('#stWhichF').val(originfile);
                                $('#lodaing').hide();

                                $('#stProfesi').val(obj.profesi)
                                
                                if (obj.iscekdokter == 1) {
                                    var pilihhtml = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="'+obj.profesi_sip_singkatan+'">'+obj.profesi_sip_terbilang+' ('+obj.profesi_sip_singkatan+')</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';

                                    var finalprof = '<option value="'+obj.profesi_sip_singkatan+'" selected>'+obj.profesi_sip_terbilang+' ('+obj.profesi_sip_singkatan+') </option>'
                                    $('#stProfesiDD').html(finalprof);

                                    $('#pilihtemplate').html(pilihhtml)
                                    $('#stSTRtetapSIP').val(obj.str_keluar_sip)
                                    $('#stDueOri').val(obj.str_hingga)
                                    $('#stStrKeluarOri').val(obj.tgl_keluar_str)
                                    $('#stDueConv').val(obj.str_hingga)
                                    $('#stStrKeluarConv').val(obj.tgl_keluar_str)
                                    
                                    if(obj.salinan != '') {
                                        $('#stSalinan').val(obj.salinan)
                                        $('#stSalinan').attr('readonly', true)
                                        if (obj.salinan != currentSalinan) {
                                            alert('Salinan Yang Anda Upload Tidak Sama Dengan Salinan STR untuk Pengajuan Ini')
                                            $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                        } else {
                                            $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                            $('#stSalinanPerpanjangan').val(obj.salinan)
                                            $('#stTemplateIDPerpanjangan').val(currentTemplate)
                                        }
                                    }
                                    var current_id_pengajuan = $('#tCurrentIDPengajuan').val()
                                    $('#tIDPengajuanDokter').val(current_id_pengajuan)

                                } else if (obj.iscekdokter == 2) {
                                    var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                    $('#pilihtemplate').html(pilihapot)

                                    var finalprof = '<option value="APT" selected>APOTEKER</option>'
                                    $('#stProfesiDD').html(finalprof);
                                } else {

                                    var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="2" disabled>SIP DOKTER</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1">SIP&SIK Tenaga Kesehatan</option></select>';
                                    $('#pilihtemplate').html(pilihapot)


                                    $.ajax({
                                        type: 'ajax',
                                        method: 'get',
                                        url: '{{ route("get.data.profesi")}}',
                                        data: {'nama_profesi': bigprof,  _token: "{{ csrf_token() }}"},
                                        async: false,
                                        dataType: 'json',
                                        success: function(data){
                                            console.log(data)
                                            if(data.success == true) {

                                            
                                                var selectedprof = data.resultprofesi[0].alias_profesi
                                                var namaprof = data.resultprofesi[0].nama_profesi
                                                var finalprof = '<option value="'+selectedprof+'" selected>'+namaprof+'</option>'

                                                $('#stProfesiDD').html(finalprof);
                                                //$('#stProfesiDD').val(selectedprof);
                                            }
                                        },
                                        error: function(request, status, error){
                                            //alert(request.responseText);
                                        }
                                    });

                                }

                                $('#stSTRHinggaSIP').val(obj.str_hingga_sip)
                                $('#PerpanjangamnModal').modal('show')

                            },
                            error: function(request, status, error){
                                //alert(request.responseText);
                            }
                        });

                    } else {

                        if(currentTemplate == '2' && iscekdokter == false) {

                            alert('Profesi STR yang anda Upload Bukan Profesi Dokter')

                        } else {

                        $.ajax({
                            type: 'ajax',
                            method: 'get',
                            url: '{{ route("get.data.strdftr")}}',
                            data: {'thename': urlfix, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
                            async: false,
                            dataType: 'json',
                            success: function(data){

                                //alert('bisa')
                                
                                var obj = jQuery.parseJSON(data)

                                console.log(obj.profesi)

                                var nama_existing = $('#tcurrentNamaStr').val()
                                var kompetensi_existing = $('#tcurrentkompetensi').val()
                                var tgldoc_existing = $('#tcurrenthingga').val()

                                var comparenama = similarity(obj.nama_nakes, nama_existing)
                                var comparekompetensi = similarity(obj.kompetensi, kompetensi_existing)
                                var hasilnama = Math.round(comparenama*100)
                                var hasilkompetensi = Math.round(comparekompetensi*100)

                                console.log(obj.nama_nakes+'_'+nama_existing)

                                var htmlcocoknama = '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'+hasilnama+'" aria-valuemin="0" aria-valuemax="100" style="width: '+hasilnama+'%">'

                                $('#cocoknamabar').html(htmlcocoknama)
                                $('#cocoknamavalue').html(hasilnama+'% Kecocokan')

                                var htmlcocokkompetensi = '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'+hasilkompetensi+'" aria-valuemin="0" aria-valuemax="100" style="width: '+hasilkompetensi+'%">'

                                $('#cocokkompetensibar').html(htmlcocokkompetensi)
                                $('#cocokkompetensivalue').html(hasilkompetensi+'% Kecocokan')

                                if (tgldoc_existing == obj.str_hingga) {
                                    $('#validasimasaberlaku').val('Masa Berlaku Sama Dengan STR Sebelumnya')
                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                    $('#jikatanggalsama').show()
                                } else {
                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                    $('#jikatanggalsama').hide()
                                }

                                if(hasilnama < 90) {
                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                    $('#jikanama').show()
                                } else {
                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                    $('#jikanama').hide()
                                }

                                if(hasilkompetensi < 95) {
                                    $('#jikabedakompetensi').show()
                                    $('#stKompetensiBeda').val('1')
                                } else {
                                    $('#jikabedakompetensi').hide()
                                    $('#stKompetensiBeda').val('0')
                                }

                                $('#stNama').val(obj.nama_nakes);
                                $('#stNoSTR').val(obj.no_reg);
                                $('#stJenisK').val(obj.jenis_kelamin);
                                $('#stKompetensi').val(obj.kompetensi)
                                
                                $('#stStatDok').val(obj.doc_stat);
                                $('#stImg').val(obj.img_src);
                                $('#stWhichF').val(originfile);
                                $('#lodaing').hide();
                                if(obj.profesi != '') {

                                    $('#stProfesi').val(obj.profesi)
                                }
                                if (iscekdokter == true) {
                                    var pilihhtml = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="'+obj.profesi_sip_singkatan+'">'+obj.profesi_sip_terbilang+' ('+obj.profesi_sip_singkatan+')</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';

                                    var finalprof = '<option value="'+obj.profesi_sip_singkatan+'" selected>'+obj.profesi_sip_terbilang+' ('+obj.profesi_sip_singkatan+') </option>'
                                    $('#stProfesiDD').html(finalprof);

                                    $('#pilihtemplate').html(pilihhtml)
                                    $('#stSTRtetapSIP').val(obj.str_keluar_sip)
                                    $('#stDueOri').val(obj.str_hingga)
                                    $('#stStrKeluarOri').val(obj.tgl_keluar_str)
                                    $('#stDueConv').val(obj.str_hingga)
                                    $('#stStrKeluarConv').val(obj.tgl_keluar_str)
                                    
                                    if(obj.salinan != '') {
                                        $('#stSalinan').val(obj.salinan)
                                        $('#stSalinan').attr('readonly', true)
                                        if (obj.salinan != currentSalinan) {
                                            alert('Salinan Yang Anda Upload Tidak Sama Dengan Salinan STR untuk Pengajuan Ini')
                                            $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                        } else {
                                            $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                            $('#stSalinanPerpanjangan').val(obj.salinan)
                                            $('#stTemplateIDPerpanjangan').val(currentTemplate)
                                        }
                                    }
                                    var current_id_pengajuan = $('#tCurrentIDPengajuan').val()
                                    $('#tIDPengajuanDokter').val(current_id_pengajuan)
                                }

                                $('#stSTRHinggaSIP').val(obj.str_hingga_sip)
                                $('#PerpanjangamnModal').modal('show')


                                if (response.success_extract == true) {

                                                                
                                    if(response.resultword.profesi != '') {
                                        $('#stProfesi').val(response.resultword.profesi)
                                    }
                                    if(iscekdokter == false) {
                                        $('#stDueOri').val(obj.str_hingga);
                                        $('#stDueConv').val(obj.str_hingga);
                                        $('#stStrKeluarOri').val(response.resultword.tgl_str)
                                        $('#stStrKeluarConv').val(response.resultword.tgl_str)
                                        $('#stSTRtetapSIP').val(response.resultword.tgl_str)
                                        if (obj.profesi != '') {
                                            let bigprof = obj.profesi.toUpperCase();
                                            let isapot = bigprof.includes("APOTEKER")
                                            if (isapot == true) {

                                                var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                                $('#pilihtemplate').html(pilihapot)

                                                var finalprof = '<option value="APT" selected>APOTEKER</option>'
                                                $('#stProfesiDD').html(finalprof);

                                            } else {

                                                var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="2" disabled>SIP DOKTER</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1">SIP&SIK Tenaga Kesehatan</option></select>';
                                                $('#pilihtemplate').html(pilihapot)


                                                $.ajax({
                                                    type: 'ajax',
                                                    method: 'get',
                                                    url: '{{ route("get.data.profesi")}}',
                                                    data: {'nama_profesi': bigprof,  _token: "{{ csrf_token() }}"},
                                                    async: false,
                                                    dataType: 'json',
                                                    success: function(data){
                                                        console.log(data)
                                                        if(data.success == true) {

                                                        
                                                            var selectedprof = data.resultprofesi[0].alias_profesi
                                                            var namaprof = data.resultprofesi[0].nama_profesi
                                                            var finalprof = '<option value="'+selectedprof+'" selected>'+namaprof+'</option>'

                                                            $('#stProfesiDD').html(finalprof);
                                                            //$('#stProfesiDD').val(selectedprof);
                                                        }
                                                    },
                                                    error: function(request, status, error){
                                                        //alert(request.responseText);
                                                    }
                                                });

                                            }
                                            

                                        } else if (response.resultword.profesi != '') {

                                            let bigprof = response.resultword.profesi.toUpperCase();
                                            let isapot = bigprof.includes("APOTEKER")
                                            if (isapot == true) {

                                                var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                                $('#pilihtemplate').html(pilihapot)

                                                var finalprof = '<option value="APT" selected>APOTEKER</option>'
                                                $('#stProfesiDD').html(finalprof);

                                            } else {

                                                var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1">SIP&SIK Tenaga Kesehatan</option></select>';
                                                $('#pilihtemplate').html(pilihapot)


                                                $.ajax({
                                                    type: 'ajax',
                                                    method: 'get',
                                                    url: '{{ route("get.data.profesi")}}',
                                                    data: {'nama_profesi': bigprof,  _token: "{{ csrf_token() }}"},
                                                    async: false,
                                                    dataType: 'json',
                                                    success: function(data){
                                                        console.log(data)
                                                        if(data.success == true) {

                                                        
                                                            var selectedprof = data.resultprofesi[0].alias_profesi
                                                            var namaprof = data.resultprofesi[0].nama_profesi
                                                            var finalprof = '<option value="'+selectedprof+'" selected>'+namaprof+'</option>'

                                                            $('#stProfesiDD').html(finalprof);
                                                            //$('#stProfesiDD').val(selectedprof);
                                                        }
                                                    },
                                                    error: function(request, status, error){
                                                        //alert(request.responseText);
                                                    }
                                                });

                                            }

                                        } else if (response.resultword.profesi == '' && response.resultword.profesi == '') {


                                            let bigprof = obj.kompetensi.toUpperCase();
                                            let isapot = bigprof.includes("APOTEKER")
                                            if (isapot == true) {

                                                var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                                $('#pilihtemplate').html(pilihapot)

                                                var finalprof = '<option value="APT" selected>APOTEKER</option>'
                                                $('#stProfesiDD').html(finalprof);

                                            } else {

                                                var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1">SIP&SIK Tenaga Kesehatan</option></select>';
                                                $('#pilihtemplate').html(pilihapot)


                                                $.ajax({
                                                    type: 'ajax',
                                                    method: 'get',
                                                    url: '{{ route("get.data.profesi")}}',
                                                    data: {'nama_profesi': bigprof,  _token: "{{ csrf_token() }}"},
                                                    async: false,
                                                    dataType: 'json',
                                                    success: function(data){
                                                        console.log(data)
                                                        if(data.success == true) {

                                                        
                                                            var selectedprof = data.resultprofesi[0].alias_profesi
                                                            var namaprof = data.resultprofesi[0].nama_profesi
                                                            var finalprof = '<option value="'+selectedprof+'" selected>'+namaprof+'</option>'

                                                            $('#stProfesiDD').html(finalprof);
                                                            //$('#stProfesiDD').val(selectedprof);
                                                        }
                                                    },
                                                    error: function(request, status, error){
                                                        //alert(request.responseText);
                                                    }
                                                });

                                            }
                                        

                                        }
                                    }


                                    autocomplete(document.getElementById("stProfesi"), response.resultword.resultword);


                                    } else {

                                        var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" >SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1">SIP&SIK Tenaga Kesehatan</option></select>';
                                        $('#pilihtemplate').html(pilihapot)

                                    }
                                
                            },
                            error: function(request, status, error){
                                //alert(request.responseText);
                            }
                        });

                        }

                    }
                    
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