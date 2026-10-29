{{--
    Page script for the guest / public pages (AdminLTE 4).

    Port of layouts/minlte/back_footer_daftar.blade.php with the Bootstrap 4
    -> 5 attribute rewrite applied.
--}}
@yield('js_code')
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
            var resultContainer = document.getElementById('qr-reader-results');
            var lastResult, countResults = 0;
            //const fileInput = document.getElementById("#qr-reader__dashboard_section_swaplink");
            //fileInput.classList.add("hiddenopt");
            
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", { fps: 10, qrbox: 250 });
            
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
                         
                            $('#stURL').val(urlfix)
                            $('#hasilscanupload').show()
                            $('#hasilframed').attr('src', urlfix)

                            $('#stNama').val(obj.nama_nakes);
                            $('#stNoSTR').val(obj.no_reg);
                            $('#stJenisK').val(obj.jenis_kelamin);
                            $('#stKompetensi').val(obj.kompetensi)
                            $('#stDue').val(obj.str_hingga);
                            $('#stStatDok').val(obj.doc_stat);
                            $('#stImg').val(obj.img_src);
                            $('#stWhichF').val('scanned');
                            $('#lodaing').hide();
                            $('#lanjutanModal').modal('show')
                            if(obj.doc_stat == 'Tidak Valid')
                            {
                                $('.strnonvalid').show()
                                $('#SubmitAfterValidation').hide()
                                $('.strtidakluarsa').hide()
                            }

                            let isfarma = false;
                            isfarma = obj.kompetensi.toUpperCase().includes("FARMASI")

                            if(obj.profesi != '') {
                                $('#stProfesi').val(obj.profesi)
                            }

                            if(obj.img_src == 'https://registrasi.kki.go.id/idxcrd/no.jpg') {
                                $('#SubmitAfterValidation').prop('disable', true)
                                alert('Foto Anda Tidak Tersedia Pada Situs Resmi KKI, Silahkan Upload Foto Sesuai STR');
                                $('#stFotoJika').prop('required', true);
                                $('.jikafototidak').show()
                            } else {
                                $('#SubmitAfterValidation').prop('disable', false)
                                $('#stFotoJika').prop('required', false);
                                $('.jikafototidak').hide()
                            }

                            if(obj.selisihtanggal <= 0) {
                                $('.strkadaluarsa').show()
                                $('.strmepet').hide()
                                $('.strtidakluarsa').hide()
                                $('#SubmitAfterValidation').hide()
                            } else if (obj.selisihtanggal > 0 && obj.selisihtanggal < 30) {
                                $('.strkadaluarsa').hide()
                                $('.strtidakluarsa').hide()
                                $('.strmepet').show()
                                $('#SubmitAfterValidation').show()
                            } else {
                                $('.strkadaluarsa').hide()
                                $('.strtidakluarsa').show()
                                $('.strmepet').hide()
                                $('#SubmitAfterValidation').show()
                            }

                            $('#stSTRHinggaSIP').val(obj.str_hingga_sip)

                            if (iscekdokter == true) {
                                var pilihhtml = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="'+obj.profesi_sip_singkatan+'">'+obj.profesi_sip_terbilang+' ('+obj.profesi_sip_singkatan+')</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                $('#pilihtemplate').html(pilihhtml)
                                $('#stSTRtetapSIP').val(obj.str_keluar_sip)
                                $('#stDueOri').val(obj.str_hingga)
                                $('#stStrKeluarOri').val(obj.tgl_keluar_str)
                                $('#stDueConv').val(obj.str_hingga)
                                $('#stStrKeluarConv').val(obj.tgl_keluar_str)

                                var finalprof = '<option value="'+obj.profesi_sip_singkatan+'" selected>'+obj.profesi_sip_terbilang+' ('+obj.profesi_sip_singkatan+') </option>'
                                $('#stProfesiDD').html(finalprof);

                                $('#pilihtemplate').html(pilihhtml)
                                $('#stSTRtetapSIP').val(obj.str_keluar_sip)
                                $('#stDueOri').val(obj.str_hingga)
                                $('#stStrKeluarOri').val(obj.tgl_keluar_str)
                                $('#stDueConv').val(obj.str_hingga)
                                $('#stStrKeluarConv').val(obj.tgl_keluar_str)
                                
                                if(obj.salinan != '') {
                                    if (obj.salinan.toUpperCase().includes('ASLI') || obj.salinan.toUpperCase().includes('ARSIP')) {
                                        $('#stSalinan').val(1)
                                        $('#stSalinan').attr('readonly', true)
                                    } else {
                                        $('#stSalinan').val(obj.salinan)
                                        $('#stSalinan').attr('readonly', true)
                                    }
                                } 

                                

                            } else {

                                //$('#stSTRtetapSIP').val(obj.str_hingga)
                                if (obj.profesi != '') {
                                    let bigprof = obj.profesi.toUpperCase();
                                    let isapot = bigprof.includes("APOTEKER")
                                    let isfarma = obj.kompetensi.includes("FARMASI")
                                    if (isapot == true || isfarma == true) {

                                        var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                        $('#pilihtemplate').html(pilihapot)

                                    } else {

                                        var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="2" disabled>SIP DOKTER</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1">SIP&SIK Tenaga Kesehatan</option></select>';
                                        $('#pilihtemplate').html(pilihapot)

                                    }
                                    

                                } else if (obj.kompetensi != '') {

                                    let bigprof = obj.kompetensi.toUpperCase();
                                    let isapot = bigprof.includes("APOTEKER")
                                    if (isapot == true || isfarma == true) {

                                        var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                        $('#pilihtemplate').html(pilihapot)

                                    } else {

                                        var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1">SIP&SIK Tenaga Kesehatan</option></select>';
                                        $('#pilihtemplate').html(pilihapot)

                                    }

                                }

                            }

                            $('#stSTRHinggaSIP').val(obj.str_hingga_sip)
                            $('#lanjutanModal').modal('show')
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

function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
            /*check if the item starts with the same letters as the text field value:*/
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            b = document.createElement("DIV");
            /*make the matching letters bold:*/
            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
            b.innerHTML += arr[i].substr(val.length);
            /*insert a input field that will hold the current array item's value:*/
            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
            /*execute a function when someone clicks on the item value (DIV element):*/
            b.addEventListener("click", function(e) {
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
                closeAllLists();
            });
            a.appendChild(b);
            }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
            increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
            decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
            /*and simulate a click on the "active" item:*/
            if (x) x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x) return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length) currentFocus = 0;
        if (currentFocus < 0) currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
        }
    }
    function closeAllLists(elmnt) {
        /*close all autocomplete lists in the document,
        except the one passed as an argument:*/
        var x = document.getElementsByClassName("autocomplete-items");
        for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
            x[i].parentNode.removeChild(x[i]);
        }
        }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
    }


    $('#jajalanbae').click(function(){
        var urlnye = 'http://ktki.kemkes.go.id/cek_str/84d46e4a-f967-11e9-ba7c-005056865e27'
        var thelinker = 1
        // $.ajax({
        //     type: 'ajax',
        //     method: 'get',
        //     url: '{{ route("get.data.strdftr")}}',
        //     data: {'thename': urlnye, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
        //     async: false,
        //     dataType: 'json',
        //     success: function(data){
        //         console.log(data);
        //     },
        //     error: function(request, status, error){
        //         //alert(request.responseText);
        //     }
        // });

        var id_user = '153'

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("readQrCodeFromPdf")}}',
            data: {'id_user': id_user, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){
                console.log(data);
            },
            error: function(request, status, error){
                //alert(request.responseText);
            }
        });
    })

    
    $('#submitDaftar').click(function(){

        $('#cobali').show()

        
        var data = $('#formDaftar').serialize();
        var form = $('#formDaftar')[0];
        var dataform = new FormData(form);

        var result = '';

        if ($('#tFileSTR')[0].files.length === 0) {
            alert('Silahkan Attach File PDF');
        } else {
            result += '1';

        }

        if (result == '1') {

            $('#lanjutdaftar')[0].reset();

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("daftar.submit.str")}}',
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
                            } else if (urlfix.includes('devcheck')){
                                thelinker = 4;
                            } else if (urlfix.includes('ktki')){
                                //thelinker = 5;
                                thelinker = 0;
                            } else {
                                thelinker = 0;
                            }
                            
                        }

                        if(thelinker == 4) {
                            //$('#hasilframed').attr('src', urlnye)

                            $.ajax({
                                type: 'ajax',
                                method: 'get',
                                url: '{{ route("get.data.strdftrdev")}}',
                                data: {'thename': urlnye, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
                                async: false,
                                dataType: 'json',
                                success: function(data){
                                    
                                    var obj = jQuery.parseJSON(data)
                                    //console.log(obj)
                                    if(obj.selisihtanggal <= 0) {
                                        $('.strkadaluarsa').show()
                                        $('.strmepet').hide()
                                        $('.strtidakluarsa').hide()
                                        $('#SubmitAfterValidation').hide()
                                    } else if (obj.selisihtanggal > 0 && obj.selisihtanggal < 30) {
                                        $('.strkadaluarsa').hide()
                                        $('.strtidakluarsa').hide()
                                        $('.strmepet').show()
                                        $('#SubmitAfterValidation').show()
                                    } else {
                                        $('.strkadaluarsa').hide()
                                        $('.strtidakluarsa').show()
                                        $('.strmepet').hide()
                                        $('#SubmitAfterValidation').show()
                                    }
                                    $('#stNama').val(obj.nama_nakes);
                                    $('#stNoSTR').val(obj.no_reg);
                                    $('#stJenisK').val(obj.jenis_kelamin);
                                    $('#stKompetensi').val(obj.kompetensi)
                                    
                                    $('#stStatDok').val(obj.doc_stat);
                                    $('#stImg').val(obj.img_src);
                                    $('#stWhichF').val(originfile);
                                    $('#lodaing').hide();
                                    $('#stUniversitas').val(obj.universitas)
                                    $('#stProfesi').val(obj.profesi)
                                    let bigprof = obj.profesi.toUpperCase();
                                    $('#stSTRHinggaSIP').val(obj.str_hingga_sip)
                                    $('#stSTRtetapSIP').val(obj.str_keluar_sip)
                                    $('#stStrKeluarOri').val(obj.tgl_keluar_str)
                                    $('#lanjutanModal').modal('show')

                                    if(obj.doc_stat == 'Tidak Valid')
                                    {
                                        $('.strnonvalid').show()
                                        $('#SubmitAfterValidation').hide()
                                        $('.strtidakluarsa').hide()
                                    }

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
                                        } else {
                                            $('#stSalinan').val('1')
                                            $('#stSalinan').attr('readonly', true)

                                        }
                                        
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

                                },
                                error: function(request, status, error){
                                    //alert(request.responseText);
                                }
                            });

                        } else if(thelinker == 5){

                            var obj = response.resultword

                            $('#stNama').prop('readonly', false)
                            $('#stNoSTR').prop('readonly', false)
                            $('#stKompetensi').prop('readonly', false)
                            $('#stSTRHinggaSIP').prop('readonly', false)

                            $('#stNama').val(obj.nama_nakes);
                            $('#stNoSTR').val(obj.no_reg);
                            $('#stJenisK').val(obj.jenis_kelamin);
                            $('#stKompetensi').val(obj.kompetensi)
                            
                            $('#stStatDok').val(obj.doc_stat);
                            $('#stImg').val(obj.img_src);
                            $('#stWhichF').val(originfile);
                            $('#lodaing').hide();
                            $('#stUniversitas').val(obj.universitas)
                            let isfarma = false;
                            isfarma = obj.kompetensi.toUpperCase().includes("FARMASI")
                            if(obj.doc_stat == 'Tidak Valid')
                            {
                                $('.strnonvalid').show()
                                $('#SubmitAfterValidation').hide()
                                $('.strtidakluarsa').hide()
                            }

                            if(obj.img_src == 'https://registrasi.kki.go.id/idxcrd/no.jpg') {
                                $('#SubmitAfterValidation').prop('disable', true)
                                alert('Foto Anda Tidak Tersedia Pada Situs Resmi KTKI, Silahkan Upload Foto Sesuai STR');
                                $('#stFotoJika').prop('required', true);
                                $('.jikafototidak').show()
                            } else {
                                $('#SubmitAfterValidation').prop('disable', false)
                                $('#stFotoJika').prop('required', false);
                                $('.jikafototidak').hide()
                            }

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

                                    if (obj.salinan.toUpperCase().includes('ASLI') || obj.salinan.toUpperCase().includes('ARSIP')) {
                                        $('#stSalinan').val(1)
                                        $('#stSalinan').attr('readonly', true)
                                    } else {
                                        $('#stSalinan').val(obj.salinan)
                                        $('#stSalinan').attr('readonly', true)
                                    }
                                    
                                }
                            }

                            if(obj.selisihtanggal <= 0) {
                                $('.strkadaluarsa').show()
                                $('.strmepet').hide()
                                $('.strtidakluarsa').hide()
                                $('#SubmitAfterValidation').hide()
                            } else if (obj.selisihtanggal > 0 && obj.selisihtanggal < 30) {
                                $('.strkadaluarsa').hide()
                                $('.strtidakluarsa').hide()
                                $('.strmepet').show()
                                $('#SubmitAfterValidation').show()
                            } else {
                                $('.strkadaluarsa').hide()
                                $('.strtidakluarsa').show()
                                $('.strmepet').hide()
                                $('#SubmitAfterValidation').show()
                            }

                            $('#stSTRHinggaSIP').val(obj.str_hingga_sip)
                            $('#lanjutanModal').modal('show')


                            if (response.success_extract == true) {

                                                            
                                if(response.resultword.profesi != '') {
                                    if(obj.profesi == '') {
                                        $('#stProfesi').val(response.resultword.profesi)
                                    }
                                    
                                }

                                if(obj.universitas == '') {
                                    if(response.resultword.universitas != '') {
                                        $('#stUniversitas').val(response.resultword.universitas)
                                    }
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
                                        
                                        if (isapot == true || isfarma == true) {

                                            var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                            $('#pilihtemplate').html(pilihapot)

                                            var finalprof = '<option value="APT" selected>APOTEKER</option><option value="TTK" selected>TENAGA TEKNIS KEFARMASIAN</option>'
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
                                        if (isapot == true || isfarma == true) {

                                            var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                            $('#pilihtemplate').html(pilihapot)

                                            var finalprof = '<option value="APT" selected>APOTEKER</option><option value="TTK" selected>TENAGA TEKNIS KEFARMASIAN</option>'
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
                                        if (isapot == true || isfarma == true) {

                                            var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                            $('#pilihtemplate').html(pilihapot)

                                            var finalprof = '<option value="APT" selected>APOTEKER</option><option value="TTK" selected>TENAGA TEKNIS KEFARMASIAN</option>'
                                            $('#stProfesiDD').html(finalprof);

                                        } else {

                                            var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1">SIP&SIK Tenaga Kesehatan</option></select>';
                                            $('#pilihtemplate').html(pilihapot)

                                            console.log(bigprof)
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

                        } else {
                            $('#hasilframed').attr('src', urlfix)

                            $.ajax({
                                type: 'ajax',
                                method: 'get',
                                url: '{{ route("get.data.strdftr")}}',
                                data: {'thename': urlfix, 'thelinker': thelinker, 'skipped': '1', _token: "{{ csrf_token() }}"},
                                async: false,
                                dataType: 'json',
                                success: function(data){

                                    if(data.success == false) {
                                        alert(data.keterangan);
                                    }
                                
                                    var obj = jQuery.parseJSON(data)
                                    console.log(obj)

                                    $('#stNama').val(obj.nama_nakes);
                                    $('#stNoSTR').val(obj.no_reg);
                                    $('#stJenisK').val(obj.jenis_kelamin);
                                    $('#stKompetensi').val(obj.kompetensi)
                                    
                                    $('#stStatDok').val(obj.doc_stat);
                                    $('#stImg').val(obj.img_src);
                                    $('#stWhichF').val(originfile);
                                    $('#lodaing').hide();
                                    $('#stUniversitas').val(obj.universitas)
                                    let isfarma = false;
                                    isfarma = obj.kompetensi.toUpperCase().includes("FARMASI")
                                    if(obj.doc_stat == 'Tidak Valid')
                                    {
                                        $('.strnonvalid').show()
                                        $('#SubmitAfterValidation').hide()
                                        $('.strtidakluarsa').hide()
                                    }

                                    if(obj.img_src == 'https://registrasi.kki.go.id/idxcrd/no.jpg') {
                                        $('#SubmitAfterValidation').prop('disable', true)
                                        alert('Foto Anda Tidak Tersedia Pada Situs Resmi KKI, Silahkan Upload Foto Sesuai STR');
                                        $('#stFotoJika').prop('required', true);
                                        $('.jikafototidak').show()
                                    } else {
                                        $('#SubmitAfterValidation').prop('disable', false)
                                        $('#stFotoJika').prop('required', false);
                                        $('.jikafototidak').hide()
                                    }

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

                                            if (obj.salinan.toUpperCase().includes('ASLI') || obj.salinan.toUpperCase().includes('ARSIP')) {
                                                $('#stSalinan').val(1)
                                                $('#stSalinan').attr('readonly', true)
                                            } else {
                                                $('#stSalinan').val(obj.salinan)
                                                $('#stSalinan').attr('readonly', true)
                                            }
                                            
                                        }
                                    }

                                    if(obj.selisihtanggal <= 0) {
                                        $('.strkadaluarsa').show()
                                        $('.strmepet').hide()
                                        $('.strtidakluarsa').hide()
                                        $('#SubmitAfterValidation').hide()
                                    } else if (obj.selisihtanggal > 0 && obj.selisihtanggal < 30) {
                                        $('.strkadaluarsa').hide()
                                        $('.strtidakluarsa').hide()
                                        $('.strmepet').show()
                                        $('#SubmitAfterValidation').show()
                                    } else {
                                        $('.strkadaluarsa').hide()
                                        $('.strtidakluarsa').show()
                                        $('.strmepet').hide()
                                        $('#SubmitAfterValidation').show()
                                    }

                                    $('#stSTRHinggaSIP').val(obj.str_hingga_sip)
                                    $('#lanjutanModal').modal('show')


                                    if (response.success_extract == true) {

                                                                    
                                        if(response.resultword.profesi != '') {
                                            if(obj.profesi == '') {
                                                $('#stProfesi').val(response.resultword.profesi)
                                            }
                                            
                                        }

                                        if(obj.universitas == '') {
                                            if(response.resultword.universitas != '') {
                                                $('#stUniversitas').val(response.resultword.universitas)
                                            }
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
                                                
                                                if (isapot == true || isfarma == true) {

                                                    var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                                    $('#pilihtemplate').html(pilihapot)

                                                    var finalprof = '<option value="APT" selected>APOTEKER</option><option value="TTK" selected>TENAGA TEKNIS KEFARMASIAN</option>'
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
                                                if (isapot == true || isfarma == true) {

                                                    var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                                    $('#pilihtemplate').html(pilihapot)

                                                    var finalprof = '<option value="APT" selected>APOTEKER</option><option value="TTK" selected>TENAGA TEKNIS KEFARMASIAN</option>'
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
                                                if (isapot == true || isfarma == true) {

                                                    var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK TENAGA KESEHATAN</option></select>';
                                                    $('#pilihtemplate').html(pilihapot)

                                                    var finalprof = '<option value="APT" selected>APOTEKER</option><option value="TTK" selected>TENAGA TEKNIS KEFARMASIAN</option>'
                                                    $('#stProfesiDD').html(finalprof);

                                                } else {

                                                    var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1">SIP&SIK Tenaga Kesehatan</option></select>';
                                                    $('#pilihtemplate').html(pilihapot)

                                                    console.log(bigprof)
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
            
                        
                    } else {
                        var cekno = $('#tNoStr').val()
                        if(cekno !== '')
                        {
                            var pattern = /^[A-Z]{2}.*[0-9]{2}$/;
                            if (!pattern.test(cekno)) {
                                // Tidak Seumur Hidup
                                $('#stDueOri').val('')
                                $('#stDueConv').val('')
                                
                            } else {
                                // Seumur Hidup
                                $('#stDueOri').val('Seumur Hidup')
                                $('#stDueConv').val('Seumur Hidup')
                            }

                            sdmkbase(cekno)


                        } else {
                            alert(response.keterangan+'. Silahkan Coba Masukkan Nomor STR Anda')
                        }
                        
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

    function sdmkbase(nostr)
    {
        alert('ini loh')

    }

    $('#tambah_jenis1, #tambah_jenis2, #tambah_jenis3, #tambah_jenis4, #tambah_jenis5, #tambah_jenis6, #tambah_jenis7, #tambah_jenis8').click(function(){
        var jenis = $(this).attr('data-jenis');
        var judul = $(this).attr('data-judul');
        $('#judultambahnya').html('Tambah Dokumen ' +judul);
        $('#tJudulDoc').val(judul);
        $('#tJenisDoc').val(jenis);
    });
</script>
