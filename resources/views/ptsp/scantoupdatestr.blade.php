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
                <div id="modal-tungguproses-content" style="display: none;">
                    <center>
                    <i class="fas fa-hourglass"></i>
                    <h5>Mohon Tunggu..</h5>
                    </center>
                </div>
            </div>

            <div class="row">
                <div id="modal-intipsebelum-content" style="display: none; width: 800px; max-width: 90%; max-height: 100vh;">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                STR Sebelum Diupdate
                            </div>
                            <div class="card-tools">
                                
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm float-end tutupsebelum">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <embed src="{{ URL::to('/storage')}}/{{$detailnakes->namafile}}.pdf" id='strbefore' width='100%' height='100%'>
                        </div>
                    </div>
                   
                </div>
            </div>

                

            <div class="row d-flex" id="scannerstr">
                <div class="col-md-6 col-xs-12 d-flex">
                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <div>
                            Scan QRCode STR
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <div id="qr-reader-updater" style="width:500px"></div>
                                    <div id="qr-reader-updater-results"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 d-flex">
                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <div>
                                Upload STR Pembaharuan (PDF)
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
                            <div class="row" id="afterscanstr" style="display:none">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <center>
                                    <h3> Upload Dokumen STR (PDF)</h3>
                                    <form enctype="multipart/form-data" id="formstrbyadmin" method="post" class="form-horizontal">
                                        @csrf
                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen STR</label>
                                                    <input type="file" id="tFileSTR" name="tFileSTR" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <button type="submit" id="submitstrbyadmin" class="btn btn-success submitstrbyadmin">Submit</button>
                                    
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
            <div class="row" id="afterscanandupload" style="display:none">
                <div class="col-md-12 col-xs-12">
                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <div>
                                Hasil Scan Dan Upload STR
                            </div>
                        </div>
                        <div class="card-body">
                            <button class='btn btn-info' id='intipsebelum'>Lihat STR Sebelumnya</button>
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    
                                    <embed src='' id='strterkini' width='100%' height='100%'>
                                    
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <form id="submitperpanjanganbyadmin" method="post" class="form-horizontal">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama (Before)</label>
                                                    <input type="text" id="e_stNamanv" name="e_stNamanv" class="form-control" value="{{ $detailnakes->nama_nakes }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-xs-12" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                                    <input type="text" id="stNamanv" name="stNamanv" class="form-control" value="{{ $detailnakes->nama_nakes }}">
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="row">
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No STR (Before)</label>
                                                    <input type="text" id="e_stNoSTRnv" name="e_stNoSTRnv" class="form-control" value="{{ $detailnakes->no_doc }}" required readonly>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                                    <input type="text" id="stNoSTRnv" name="stNoSTRnv" class="form-control" value="{{ $detailnakes->no_doc }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID NAKES</label>
                                                    <input type="text" id="stUserIDNakesDokmanual" name="stUserIDNakesDokmanual" class="form-control" value="{{ $detailnakes->id_user }}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-4 col-xs-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID NAKES</label>
                                                    <input type="text" id="stUserIDNakesDoknv" name="stUserIDNakesDoknv" class="form-control" value="{{ $detailnakes->id_user }}" readonly>
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
                                                    <input type="text" id="stKompetensinv" name="stKompetensinv" value="{{ $detailnakes->kompetensi }}" class="form-control" required>
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
                                                    <input type="text" id="stSalinannv" name="stSalinannv" value="1" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <button type="submit" class="btn btn-success" id="processbyadmin">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
  


  

@endsection
@section('js')

@endsection
 
@section('script')
<script>

    $('#submitstrbyadmin').click(function(){

        function reloadstr(originfile){

            var parent = $('#strterkini').parent();
            var newElement = "<embed src='{{ URL::to('/storage')}}/"+originfile+".pdf' id='strterkini' width='100%' height='100%'>";
            $('#strterkini').remove();
            parent.append(newElement);
        }

        var data = $('#formstrbyadmin').serialize();
        var form = $('#formstrbyadmin')[0];
        var dataform = new FormData(form);

        var result = '';

        if ($('#tFileSTR')[0].files.length === 0) {
            Swal.fire('Silahkan Attach File PDF');
        } else {
            result += '1';
        }

        if (result == '1') {

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("nvupdate.str.byadmin")}}',
                data: dataform,
                cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                //async: false,
                beforeSend: function() {
            
                    $('#cobali').show()
                },
                //	dataType: 'json',
                success: function(response) {

                    console.log(response)
                    $('#cobali').hide()
                    if (response.success == true) {
                        Swal.fire(response.keterangan)
                        $('#stWhichnvDok').val(response.filenamestr)
                        reloadstr(response.filenamestr)
                        $('#afterscanandupload').show()
                    } else {
                        Swal.fire(response.keterangan+'. Error: '+response.keterangan)
                        $('#afterscanandupload').hide()
                    }
                    
                },
                error: function(request, status, error) {
                    alert(request.responseText);
                    $('#cobali').hide()
                    $('#afterscanandupload').hide()
                }
            });

        }

        $('#intipsebelum').on('click', function(){

            $.fancybox.open({
                src: '#modal-intipsebelum-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('.tutupsebelum').click(function() {
                        $.fancybox.close();
                    });
                }
            });

        })

        $('#submitperpanjanganbyadmin').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route('process.perpanjangan.byadmin') }}`;
            let formData = new FormData($(this)[0])
            
            $.ajax({
                url: link,
                data: formData,
                cache:false,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                method: "POST",
                enctype: 'multipart/form-data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $.fancybox.open({
                        src: '#modal-tungguproses-content',
                        type: 'inline',
                        touch: false,
                        modal: true,
                        clickSlide: false
                    });
                    $('#processbyadmin').attr('disabled', true)
                },
                success: function (data) {
                    //Swal.close();
                    $.fancybox.close();
                    if(data.success) {
                        Swal.fire(data.keterangan).then(function() {
                            
                            window.location.href = '{{ route("admin.updatestrnakes") }}';
                            
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Submit Pengajuan Nakes. Keterangan: '+data.keterangan,
                        })
                        $('#processbyadmin').attr('disabled', false)
                    }
                    console.log(data)
                    $('#processbyadmin').attr('disabled', false)
                }
                ,
                error: function(request, status, error){
                    $.fancybox.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error Submit Perpanjangan STR',
                    })
                    $('#processbyadmin').attr('disabled', false)
                }
            });

        });



    })
   

    function docReady(fn) {
        // see if DOM is already available
        if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
        } else {
        document.addEventListener("DOMContentLoaded", fn);
        }
    }

    function checkSimilarity(inputValue, compareString) {
        
        let similarity = getJaroWinklerSimilarity(inputValue, compareString.trim());
        let inputElement = $('#stNamanv')
        // Remove existing validation classes
        inputElement.removeClass("is-valid is-warning is-invalid");

        // Apply class based on similarity percentage
        if (similarity >= 0.7) {
            inputElement.addClass("is-valid");
        } else if (similarity >= 0.4) {
            inputElement.addClass("is-warning");
        } else {
            inputElement.addClass("is-invalid");
        }
    }

    function getJaroWinklerSimilarity(s1, s2) {
        if (!s1 || !s2) return 0.0;

        let m = 0; // Matching characters count
        let t = 0; // Transpositions count
        let s1Matches = new Array(s1.length).fill(false);
        let s2Matches = new Array(s2.length).fill(false);

        let matchDistance = Math.floor(Math.max(s1.length, s2.length) / 2) - 1;

        // Count matches
        for (let i = 0; i < s1.length; i++) {
            let start = Math.max(0, i - matchDistance);
            let end = Math.min(i + matchDistance + 1, s2.length);

            for (let j = start; j < end; j++) {
                if (s2Matches[j]) continue;
                if (s1[i] !== s2[j]) continue;
                s1Matches[i] = true;
                s2Matches[j] = true;
                m++;
                break;
            }
        }

        if (m === 0) return 0.0;

        // Count transpositions
        let k = 0;
        for (let i = 0; i < s1.length; i++) {
            if (!s1Matches[i]) continue;
            while (!s2Matches[k]) k++;
            if (s1[i] !== s2[k]) t++;
            k++;
        }

        t /= 2;

        let jaroSimilarity = (m / s1.length + m / s2.length + (m - t) / m) / 3;
        let prefixLength = 0;

        for (let i = 0; i < Math.min(4, s1.length, s2.length); i++) {
            if (s1[i] === s2[i]) prefixLength++;
            else break;
        }

        return jaroSimilarity + prefixLength * 0.1 * (1 - jaroSimilarity);
    }

    docReady(function () {
        var resultContainer = document.getElementById('qr-reader-updater-results');
        var lastResult, countResults = 0;
        //const fileInput = document.getElementById("#qr-reader__dashboard_section_swaplink");
        //fileInput.classList.add("hiddenopt");

        var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader-updater", { fps: 10, qrbox: 250 });

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

                        if(data.success == false) {
                            alert(data.keterangan);
                            $('#afterscanstr').hide()
                        } 

                        var urlnye = decodedText;
                        var urlfix = urlnye.replace('http:', 'https:')
                        
                        var obj = jQuery.parseJSON(data)
                        console.log(obj)
                        var existingstr = $('#e_stNoSTRnv').val()

                        

                        checkSimilarity($('#e_stNamanv').val(), (obj.nama_nakes))

                        $('#afterscanstr').show()
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
                        Swal.fire('Silahkan Upload File STR (PDF)')

                        
                        
                        
                    },
                    error: function(request, status, error){
                        //alert(request.responseText);
                        $('#afterscanstr').hide()
                    }
                });
                
                // Optional: To close the QR code scannign after the result is found
                html5QrcodeScanner.clear();
            }
        }

        // Optional callback for error, can be ignored.
        function onScanError(qrCodeError) {
            
        }
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    });
  

</script>

@endsection