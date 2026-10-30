{{--
    Global page script for every authenticated page (AdminLTE 4).

    Port of layouts/minlte/back_footer.blade.php. The only change is the
    Bootstrap 4 -> 5 attribute rewrite (data-toggle -> data-bs-toggle,
    data-target -> data-bs-target, data-dismiss -> data-bs-dismiss); the
    jQuery plugin calls ($('#x').modal('show')) are served by
    public/js/bootstrap4-bridge.js, so the logic is unchanged.
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
            var resultContainer = document.getElementById('qr-reader-results2');
            var lastResult, countResults = 0;
            
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader-str", { fps: 10, qrbox: 250 });
            
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

                    var result = '';
                    var urlfix = decodedText.replace('http:', 'https:')
                    var existingurl = $('#stUrlCode').val().replace('http:', 'https:')
                    var existingsalinan = $('#stSalinanKumpul').val()

                    if (existingurl != urlfix) {
                        Swal.fire('STR yang diserhakan tidak sama dengan STR yang digunakan untuk e-SIP')
                    } else {

                        result += '1';

                        $.ajax({
                            type: 'ajax',
                            method: 'get',
                            url: '{{ route("verif.str.serahan")}}',
                            data: {'thename': urlfix, 'salinan': existingsalinan, _token: "{{ csrf_token() }}"},
                            async: false,
                            dataType: 'json',
                            success: function(data){

                                console.log(data)

                                // var existingsalinan = $('#stSalinanKumpul').val()
                                // var tgldocorigin = $('#stTglDocOrigin').val()

                                // var obj = jQuery.parseJSON(data)
                                // console.log(obj)

                                // var str_hingga = obj.str_hingga
                                // var salinannya = obj.salinan

                                // if(str_hingga == tgldocorigin) {
                                //     result += '2'
                                // }

                                // if(existingsalinan == salinannya) {
                                //     result += '3'
                                // }

                                if(result == '1') {

                                    $('#overlaypenyerahan').hide()
                                    //$('#stNamaKumpul').val(obj.nama_nakes)
                                    //$('#stNoSTRKumpul').val(obj.no_reg)

                                } else {
                                    Swal.fire('Dokumen STR yang diserahkan Berbeda Dengan yang digunakan untuk pengajuan e-SIP ini')
                                    $('#overlaypenyerahan').show()
                                }
                            
                                
                            },
                            error: function(request, status, error){
                                //alert(request.responseText);
                            }
                        });

                    }
        
                    
                    
                    // Optional: To close the QR code scannign after the result is found
                    html5QrcodeScanner.clear();
                }
            }
            
            // Optional callback for error, can be ignored.
            function onScanError(qrCodeError) {
                // This callback would be called in case of qr code scan error or setup error.
                // You can avoid this callback completely, as it can be very verbose in nature.
            }
            //const fileInput = document.querySelector(".qr-reader__dashboard_section_swaplink #id");
            //fileInput.classList.add("hiddenopt");
            
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        });

    
    </script>

<script>
    $(function(){

        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        var notif = "{{session()->get('alert')}}"
        if (notif != '') {
            var bekgron = 'bg-success'
            var judul = 'Berhasil'
            var jenis = notif.substring(0, 1)
            if (jenis == '1') {
                bekgron = 'bg-success'
                judul = 'Berhasil'
                
            } else if (jenis == '9') {
                bekgron = 'bg-danger'
                judul = 'Gagal'
            } else if (jenis == '2') {
                bekgron = 'bg-info'
                judul = 'Informasi'
            } else {
                bekgron = 'bg-warning'
                judul = 'Perhatian'
            }
            var pesannya = notif.substring(1)
            console.log(pesannya)

            $(document).Toasts('create', {
                class: bekgron,
                title: judul,
                autohide: true,
                delay: 5000,
                body: pesannya
            })
            
        }


        
        $('.toastsDefaultDefault').click(function() {
            toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
        });

        $('.toastsDefaultDefaults').click(function() {
            $(document).Toasts('create', {
                title: 'Toast Title',
                body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
            })
        });

        $('.toastsDefaultSuccess').click(function() {
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Toast Title',
                subtitle: 'Subtitle',
                body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
            })
        });
        //$('#tbllistpengajuan').DataTable();
        var datatablefaskesmanage = $('#tabelfaskesmanage').DataTable();

        function getdetailing(keterangan, levelwarning) {

            var html = '';
            const myArray = keterangan.split(",");
            if(levelwarning == 1) {
                var jenis = 'warning'
            } else {
                var jenis = 'danger'
            }
            
            for (i = 0; i < myArray.length; i++) {
                html += '<div class="alert alert-'+jenis+' alert-dismissible">'+myArray[i]+'</div>';

            }

            // `d` is the original data object for the row
            return '<td width="100%" colspan="4"><div class="card"><div class="card-body">' + html +'</div></div></td><hr>';
        }

        function getcurrentjadwal(id_user, salinan, id_doc){

            $('.tampilnongol').hide()
            

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.all.jadwal")}}',
                data: {'id_user': id_user, 'salinan' : salinan, 'id_doc' : id_doc,  _token: "{{ csrf_token() }}"},
                //async: false,
                dataType: 'json',
                success: function(data){

                    for (i=0; i < data.alljadwal.length; i++) {
                        

                        var urutan = data.alljadwal[i].urutan;
                        var isset = data.alljadwal[i].isSet;
                        var isshift = data.alljadwal[i].is_shift;
                        var mulai = data.alljadwal[i].mulai;
                        var selesai = data.alljadwal[i].selesai;
                        var iscompromised = data.alljadwal[i].iscompromised;
                        var levelwarning = data.alljadwal[i].levelwarning;
                        var keterangan = data.alljadwal[i].keterangan;
                        var uraian = data.alljadwal[i].uraian;
                        
                        if(isset == 1) {
                            $('#jam_'+urutan).show();
                            $('#isshift_'+urutan).show();
                            $('#phari_'+urutan).prop('checked', true);
                            if(isshift == 1){
                                $('#isshift_'+urutan).prop('checked', true);
                            } else {
                                $('#isshift_'+urutan).prop('checked', false);
                            }
                            $('#start_'+urutan).val(mulai);
                            $('#end_'+urutan).val(selesai);
                            $('#isuraian_'+urutan).show();
                            $('#isuraian_'+urutan).val(uraian);

                            if(iscompromised == 1) {
            
                                $('#'+urutan+'alert').show();
                                
                                if(levelwarning == 1) {
                                    $('#'+urutan+'alert').css("color", "white")
                                    $('#larik_'+urutan).css("color", "white")
                                    $('#larik_'+urutan).css("background-color", "orange")
                                } else if (levelwarning == 2) {
                                    $('#'+urutan+'alert').css("color", "white")
                                    $('#larik_'+urutan).css("color", "white")
                                    $('#larik_'+urutan).css("background-color", "red")
                                }


                                $('#detailc'+urutan).attr('data-ket', keterangan)
                                $('#detailc'+urutan).attr('data-urutan', urutan)
                                $('#detailc'+urutan).attr('data-level', levelwarning)

                                var isiresult = '';
                                const myArray = keterangan.split(",");
                                if(levelwarning == 1) {
                                    var jenis = 'warning'
                                } else {
                                    var jenis = 'danger'
                                }
                                
                                for (x = 0; x < myArray.length; x++) {
                                    isiresult += '<div class="alert alert-'+jenis+' alert-dismissible">'+myArray[x]+'</div>';

                                }

                                // `d` is the original data object for the row
                                var jugaga = '<td width="100%" colspan="4"><div class="card"><div class="card-body">' + isiresult +'</div></div></td><hr>';
                                $('#cekresult_'+urutan).html(jugaga)
                                
                            } else {

                                $('#detailc'+urutan).attr('data-ket', '')
                                $('#detailc'+urutan).attr('data-urutan', '')
                                $('#detailc'+urutan).attr('data-level', '')
                                $('#'+urutan+'alert').css("color", "")
                                $('#larik_'+urutan).css("color", "")
                                $('#larik_'+urutan).css("background-color", "")
                                $('#'+urutan+'alert').hide();

                            }
                            $('#detailc'+urutan).attr('data-compromised', iscompromised)

                            
                        } else {
                            $('#phari_'+urutan).prop('checked', false);
                            $('#detailc'+urutan).attr('data-ket', '')
                            $('#detailc'+urutan).attr('data-urutan', '')
                            $('#detailc'+urutan).attr('data-level', '')
                            $('#'+urutan+'alert').css("color", "")
                            $('#larik_'+urutan).css("color", "")
                            $('#larik_'+urutan).css("background-color", "")
                            $('#'+urutan+'alert').hide();
                            $('#cekresult_'+urutan).show();
                            $('#cekresult_'+urutan).html('')
                        }
                        
                    }
                    $('.tampilnongol').show();
                

                    
                    
                },
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });


        }

        $('#_jadwalpraktiknakes').on('click', '.details-control', function() {

            var urutan = $(this).attr('data-urutan');
            var levelwarning = $(this).attr('data-level');
            //var tr = $(this).parent();
            var tr = $('.details-control').closest('tr');
            var keterangan = $(this).attr('data-ket');
            var iscompromised = $(this).attr('data-compromised')
            if (iscompromised == 1) {
                var html = getdetailing(keterangan, levelwarning);
                var isshow = $('#cekresult_'+urutan).is(':visible')
                if(isshow) {
                    $('#cekresult_'+urutan).hide();
                    $('#cekresult_'+urutan).html('')
                } else {
                    $('#cekresult_'+urutan).show();
                    $('#cekresult_'+urutan).html(html)
                }

            }



        });

        if($('#id_pengajuanedit').length) {
            var id_pengajuan = $('#id_pengajuanedit').val();
            checktoupdate(id_pengajuan)
        }

        function reloadktpimage(originfile){

            var parent = $('#ktpterkini').parent();
            var newElement = "<embed src='{{ URL::to('/storageup')}}/"+originfile+"' id='ktpterkini' width='100%' height='100%'>";
            $('#ktpterkini').remove();
            parent.append(newElement);
        }

        function reloadfileterakhir(originfile){

            var parent = $('#dokterkini').parent();
            var newElement = "<embed src='{{ URL::to('/storageup')}}/"+originfile+"' id='dokterkini' width='100%' height='450px'>";
            $('#dokterkini').remove();
            parent.append(newElement);
        }

        if($('#ktpterkini').length) {

            var originfile = $('#ktpFilename').val();
            var isedit = $('#tiseditktp').val();
            if(isedit == 1) {

                reloadktpimage(originfile)

            }
            
        }

        
        if($('#dokterkini').length) {

                        
            var originfile = $('#texistingfilename').val();
            console.log(originfile)
            var isedit = $('#tiseditdoc').val();
            if(isedit == 1) {

                reloadfileterakhir(originfile)

            }


        }

        

        if($('#tselectedfaskesedit').length) {

            function filterByProperty(array, prop, value){
                var filtered = [];
                for(var i = 0; i < array.length; i++){

                    var obj = array[i];

                    for(var key in obj){
                        if(typeof(obj[key] == "object")){
                            var item = obj[key];
                            if(item[prop] == value){
                                filtered.push(item);
                            }
                        }
                    }

                }    

                return filtered;

            }
            
            var id_pengajuan = $('#id_pengajuanedit').val();
            var current_selected = $('#tselectedfaskesc').val()

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ route("get.selected.faskesedit")}}',
                    data: {'id_pengajuan' : id_pengajuan,  _token: "{{ csrf_token() }}"},
                    //async: false,
                    dataType: 'json',
                    success: function(response){
                        
                        
                        if (response.success == true) {
                            var html = '';
                            var selected = '';
                            var disabled = '';
                            var muArray = [];
                            for(i=0; i < response.result.length; i++) {
                                muArray.push(response.result[i]);
                                if(response.result[i].selectedfaskes == '0') {
                                    selected = ''
                                    disabled = ''
                                } else {
                                    selected = 'selected'
                                    disabled = 'disabled'
                                }
                                html += '<option value="'+response.result[i].id_faskes+'" '+selected+' '+disabled+'>'+response.result[i].nama_faskes+'</option>'

                            }
                            $('#tselectedfaskesedit').html(html)
                            //console.log(muArray)

                            $('#tselectedfaskesedit').on('change', function() {
                                var id_faskes = parseInt(this.value);
                                const output = muArray.filter(item => item.id_faskes === id_faskes)

                                $('#tAlamatPengajuanM').val(output[0].alamat_faskes)
                                $('#tKabupatenM').val(output[0].kabupaten_faskes)
                                $('#tKecamatanM').val(output[0].kecamatan_faskes)
                                $('#tLat').val(output[0].latitude)
                                $('#tLong').val(output[0].longitude)
                                
                            
                            });

                            $('.tocekfis').prop('readonly', true)
                        }

                    },
                    
                    error: function(request, status, error){
                        alert(request.responseText);
                    }
                });
            
            
        }

        function checktoupdate(id_pengajuan) {

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.toupdate.pengajuan")}}',
                data: {'id_pengajuan' : id_pengajuan,  _token: "{{ csrf_token() }}"},
                //async: false,
                dataType: 'json',
                success: function(response){
                    if (response.success == true) {
                        if(response.result == '0') {
                            //$('#resubmitpengajuan').show()
                            $('#updatepengajuanedit').show()
                            
                        } else {
                            //$('#resubmitpengajuan').show()
                            $('#updatepengajuanedit').show()
                            
                        }
                    }

                },
                
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });

        }

        $('#simpanlokasiedit').click(function(){

            var isFaskes = $('#tisFaskes').val();
            if($('#tselectedfaskesedit').length) {
                var selectedfaskes = $('#tselectedfaskesedit').val();
                
            } else {
                var selectedfaskes = $('#tidFaskesEdit').val();
            }
            
            var currentidfaskes = $('#tselectedfaskesc').val();
            var alamatpengajuan = $('#tAlamatPengajuanM').val();
            var kabpengajuan = $('#tKabupatenM').val();
            var kecpengajuan = $('#tKecamatanM').val();
            var latpengajuan = $('#tLat').val();
            var longpengajuan = $('#tLong').val();
            var id_pengajuan = $('#id_pengajuanedit').val()
            var idFaskesEdit = $('#tidFaskesEdit').val()
        

            if (parseInt(currentidfaskes) == parseInt(selectedfaskes)) {
                alert('Faskes yang anda pilih tidak berubah')
            } else {

                if (confirm("Apakah Anda Yakin Untuk Perubahan Lokasi Ini?") == true) {

                    $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '{{ route("update.lokasi.pengajuan")}}',
                        data: {
                            'id_pengajuan' : id_pengajuan,  
                            'isFaskes' : isFaskes,
                            'currentidfaskes' : currentidfaskes,
                            'selectedfaskes' : selectedfaskes,
                            'alamatpengajuan' : alamatpengajuan,
                            'kabpengajuan' : kabpengajuan,
                            'kecpengajuan' : kecpengajuan,
                            'latpengajuan' : latpengajuan,
                            'longpengajuan' : longpengajuan,
                            'idFaskesEdit' : idFaskesEdit,
                            _token: "{{ csrf_token() }}"},
                        //async: false,
                        dataType: 'json',
                        success: function(response){
                            
                            if (response.success == true) {

                                alert('Sukses Update Lokasi Pengajuan')
                                $('#tombolupdatelokasi').hide()
                                $('#keteranganlokasiditolak').hide()
                                $('.ubahlahjenislok').hide()
                                checktoupdate(id_pengajuan)
                                if($('#tselectedfaskesedit').length) {
                                    $('#tselectedfaskesedit').hide()
                                }
                                
                            } else {
                                alert(response.keterangan)
                                
                            }

                        },
                        
                        error: function(request, status, error){
                            alert(request.responseText);
                        }
                    });
                    
                }                 
            }

            })

        $('#nextedit2').click(function(){
            var id_pengajuan = $(this).attr('data-pengajuan');
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.toupdate.pengajuanlokasi")}}',
                data: {'id_pengajuan' : id_pengajuan,  _token: "{{ csrf_token() }}"},
                //async: false,
                dataType: 'json',
                success: function(response){
                    if (response.success == true) {
                        if(response.result == '0') {
                            $('#updatepengajuanedit').show()
                            var stepper = new Stepper(document.querySelector('.bs-stepper'))
                            stepper.next()
                            
                        } else {
                            Swal.fire("Data Belum Diperbaharui")
                            $('#updatepengajuanedit').hide()
                            
                        }
                    }

                },
                
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });
            
        })

       

        if($('#_jadwalpraktiknakes').length) {

            var id_pengajuan = $('#id_pengajuanedit').val()
            var id_doc = $('#tidDocStr').val()
            var id_user = $('#tUserPengajuan').val()
            var salinan = $('#tAjuanSalinan').val()
            $('#simpanjadwalnakes').show();
            $('#editJadwalPraktik').hide();
            $('#submitPengajuanM').hide();
            getcurrentjadwal(id_user, salinan, id_doc)
            var istolak = $('#isTolakJadwal').val()
            var countisset = 0;
            $('#simpanjadwalnakes').click(function(){

                jadwaldata = []
                for (i=0; i < 7; i++) {

                    var urutan = i+1;
                    var isnextday = 0
                    var isset_ = $('#phari_'+urutan).is(':checked')
                    if(isset_ == true) {
                        var isset = 1
                        $('#isuraian_'+urutan).show()
                        countisset++
                    }else{ var isset = 0}
                    var mulai = $('#start_'+urutan).val()
                    var selesai = $('#end_'+urutan).val()
                    var isshift_ = $('#isshift_'+urutan).is(':checked')
                    if(isshift_ == true){
                        var isshift = 1
                    }else{ var isshift = 0}
                    var waktumulai = mulai.split(":")
                    var jammulai = parseInt(waktumulai[0])*60
                    var menitmulai = parseInt(waktumulai[1])
                    var rmulai = jammulai + menitmulai

                    var waktuselesai = selesai.split(":")
                    var jamselesai = parseInt(waktuselesai[0])*60;
                    var menitselesai = parseInt(waktuselesai[1]);
                    var rselesai = jamselesai + menitselesai;
                    
                    var uraian = $('#isuraian_'+urutan).val()

                    if (rmulai > rselesai) {
                        isnextday = 1
                    }

                    var record = '{ "urutan" : "'+urutan+'", "isSet" : "'+isset+'", "mulai" : "'+mulai+'", "selesai" : "'+selesai+'", "rmulai" : "'+rmulai+'", "rselesai" : "'+rselesai+'", "is_shift" : "'+isshift+'", "isnextday" : "'+isnextday+'", "uraian" : "'+uraian+'"}'
                    jadwaldata.push(record)
                }

                var submitdata = {};
                    submitdata.isadmin = 0;
                    submitdata.id_pengajuan = 0;
                    submitdata.id_user = id_user;
                    submitdata.id_doc = id_doc;
                    submitdata.salinan = salinan;
                    submitdata.istolak = istolak;
                    submitdata.jadwal = jadwaldata;

                
                if(countisset == 0) {
                    Swal.fire('Anda Belum Mengisikan Jadwal')
                } else {

                    $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '{{ route("submit.jadwaldetailpraktek")}}',
                        data: {'submitdata' : submitdata,  _token: "{{ csrf_token() }}"},
                        //async: false,
                        dataType: 'json',
                        beforeSend: function() {
                            $.fancybox.open({
                                    src: '#modal-tunggujadwal-content',
                                    type: 'inline',
                                    touch: false,
                                    modal: true,
                                    clickSlide: false,
                                    afterShow: function() {
                                        $('#close-ubahpengaju-modal').click(function() {
                                            $.fancybox.close();
                                        });
                                    }
                                });

                        },
                        success: function(response){
                            if(response.success == true) {
                                Swal.fire(response.keterangan);
                                if(istolak == '1') {
                                    $('.jadwaltaksetuju').hide()
                                    checktoupdate(id_pengajuan)
                                }
                            } else {
                                Swal.fire(response.keterangan);
                            }
                            getcurrentjadwal(id_user, salinan, id_doc)
                            $('#tunggujadwal').show()
                        },
                        complete: function(){
                            $('#simpanjadwalnakes').hide()
                            $('#editJadwalPraktik').show()
                            $('#submitPengajuanM').show()
                            $('#submitPerubahanM').show()
                            $.fancybox.close()
                        },
                        error: function(request, status, error){
                            $.fancybox.close()
                            alert(request.responseText);
                        }
                    });

                }
            })
        }


        $('#editJadwalPraktik').click(function(){
            $('#submitPerubahanM').hide()
            $('#submitPengajuanM').hide();
            $('#tunggujadwal').hide()
            $('#simpanjadwalnakes').show();
            $(this).hide();

        });

        $('#updatepengajuanedit').click(function(){
            var id_pengajuan = $(this).attr('data-pengajuan')
            var updater = $(this).attr('data-id')
            var salinan = $(this).attr('data-salinan')
            var templateupdate = 0
            if ($('input[name="templateprofesi"]').length > 0) {
                templateupdate = $('input[name="templateprofesi"]:checked').val();
            }

            if (confirm('Apakah Anda Yakin Untuk Re-Submit Pengajuan Berikut?')) {

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("resubmit.pengajuan")}}',
                    data: {
                        'id_pengajuan' : id_pengajuan,
                        'salinan' : salinan,
                        'updater' : updater,  
                        'templateupdate' : templateupdate,
                        _token: "{{ csrf_token() }}"},
                    //async: false,
                    dataType: 'json',
                    success: function(response){

                        if(response.success == true) {
                            window.location.href = "{{ route('nakes.dashboard')}}";
                        } else {
                            Swal.fire('Gagal Submit Ulang Pengajuan, Silahkan Coba Kembali')
                        }        
                        
                    },
                    error: function(request, status, error){
                        alert(request.responseText);
                    }
                });

            }
            
        })

        $(document).ready(function () {

            var stepperElement = document.querySelector('.bs-stepper');
            if (stepperElement && typeof Stepper !== 'undefined') {
                window.stepper = new Stepper(stepperElement)
            }
        })
        
    });


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


    $('#tambah_jenis1, #tambah_jenis2, #tambah_jenis3, #tambah_jenis4, #tambah_jenis5, #tambah_jenis6, #tambah_jenis7, #tambah_jenis8').click(function(){
        var jenis = $(this).attr('data-jenis');
        var judul = $(this).attr('data-judul');
        var universitas = $(this).attr('data-univ');
        $('#judultambahnya').html('Tambah Dokumen ' +judul);
        $('#tJudulDoc').val(judul);
        $('#tJenisDoc').val(jenis);
        if(jenis == 'IJAZAH') {
            $('#tTglBerlaku').val('2022-01-01')
            $('#nonijazah').hide()
            $('#untukijazah').show()
            $('#tUniversitas').val(universitas)
            $('.dokumendiupload').hide()
        } else {
            $('#nonijazah').show()
            $('#untukijazah').hide()
            $('.dokumendiupload').show()
        }
    });

    $('#ifdom').change(function(){
        if( $(this).is(':checked')) {
            $('.domisilih').prop('readonly', true)
            $('#ktpALAMATDom').prop('required', false)
        } else {
            $('.domisilih').prop('readonly', false)
            $('#ktpALAMATDom').prop('required', true)
        }
        

    })

    $('#ifdomprof').change(function(){

        if( $(this).is(':checked')) {
            $('.domprof').prop('readonly', true) 
            $('#nakes_aldom').prop('required', false)
            $('.domprof').hide()
        } else {
            $('.domprof').prop('readonly', false)
            $('#nakes_aldom').prop('required', true)
            $('.domprof').show()
        }

    })

    ///for jadwal///
    $('.pilihhari').click(function(){
        var urutan = $(this).attr('data');
        if ($('#phari_'+urutan).is(':checked')) {
            $('#jam_'+urutan).show()
            $('#isshift_'+urutan).show()
            $('#isuraian_'+urutan).show()
        } else {
            $('#jam_'+urutan).hide()
            $('#isshift_'+urutan).hide()
            $('#isuraian_'+urutan).hide()
            $('#isuraian_'+urutan).val('')
        }

    })

    
    $('.activatenakes').click(function(){
        
        var id = $(this).attr('id')
        var filename = $(this).attr('data-file')
        var nama = $(this).attr('data-nama')
        var url_qr = $(this).attr('data-url')
        var no_reg = $(this).attr('data-str')
        var email = $(this).attr('data-email')
        var foto = $(this).attr('data-foto')
        var salinan = $(this).attr('data-salinan')
        var kompetensi = $(this).attr('data-kompetensi')
        var profesi = $(this).attr('data-profesi')
        var tgl_str = $(this).attr('data-tglstr')
        var universitas = $(this).attr('data-univ')
        var originfile = $(this).attr('data-file')+'.pdf'

        $('#arpUrlQR').attr('src', url_qr);
        $('#aprID').val(id)
        $('#aprNama').val(nama)
        $('#aprNoSTR').val(no_reg)
        $('#aprEmail').val(email)
        $('#aprFoto').val(foto)
        $('#aprSalinan').val(salinan);
        $('#aprKompetensi').val(kompetensi);
        $('#aprProfesi').val(profesi);
        $('#aprTglStr').val(tgl_str);
        $('#aprUniversitas').val(universitas)
    
        if(filename == 'scanned') {
            $('#aprStatusFile').html('<option value="1" selected>Upload Ulang</option>');
            var parent = $('#lihatoriginstrpendaftar').parent();
            parent.hide();
            var newElement = "<embed src='' id='lihatoriginstrpendaftar' width='100%'>";
            $('#lihatoriginstrpendaftar').remove();
            parent.append(newElement);
        } else {
            var parent = $('#lihatoriginstrpendaftar').parent();
            parent.show();
            var newElement = "<embed src='{{ URL::to('/getoriginstr')}}/"+originfile+"' id='lihatoriginstrpendaftar' width='100%'>";
            $('#lihatoriginstrpendaftar').remove();
            parent.append(newElement);

        }


        $('#aktivasiNakes').modal('show')

    })

    $('#tblpendaftarhist').on('click','.intipnakes', function(){
        var filenamenya = $(this).attr('data-file')
        var filenamenya_ = filenamenya+'.pdf'

        var id = $(this).attr('id')
        var filename = $(this).attr('data-file')
        var nama = $(this).attr('data-nama')
        var url_qr = $(this).attr('data-url')
        var no_reg = $(this).attr('data-str')
        var email = $(this).attr('data-email')
        var foto = $(this).attr('data-foto')
        var passw = $(this).attr('data-pass')
        var doc_stat =$(this).attr('data-statdoc')
        var salinan = $(this).attr('data-salinan')
        var kompetensi = $(this).attr('data-kompetensi')
        var profesi = $(this).attr('data-profesi')
        var tgl_str = $(this).attr('data-tglstr')
        var universitas = $(this).attr('data-univ')
        var originfile = $(this).attr('data-file')+'.pdf'
        


        $('#arpUrlQRV').attr('src', url_qr);
        $('#aprIDV').val(id)
        $('#aprNamaV').val(nama)
        $('#aprNoSTRV').val(no_reg)
        $('#aprEmailV').val(email)
        $('#aprFotoV').val(foto)
        $('#aprPasswV').val(passw);
        $('#aprStatusFileV').val(doc_stat);
        $('#aprSalinanV').val(salinan);
        $('#aprStatusFileV').attr('disabled', 'disabled');
        $('#aprKompetensiV').val(kompetensi);
        $('#aprProfesiV').val(profesi);
        $('#aprTglStrV').val(tgl_str);
        $('#aprUniversitasV').val(universitas)

        
        if(filename != 'scanned') {
            var parent = $('#lihatoriginstrpendaftarV').parent();
            parent.show();
            var newElement = "<embed src='{{ URL::to('/getoriginstr')}}/"+originfile+"' id='lihatoriginstrpendaftarV' width='100%'>";
            $('#lihatoriginstrpendaftarV').remove();
            parent.append(newElement);
        } else {
            var parent = $('#lihatoriginstrpendaftarV').parent();
            parent.hide();
            var newElement = "<embed src='' id='lihatoriginstrpendaftarV' width='100%'>";
            $('#lihatoriginstrpendaftarV').remove();
            parent.append(newElement);
        }
        



        $('#aktivasiNakesView').modal('show')

        
    })

    $('#addajumandiri').click(function(){

        
        var sks = $(this).attr('data-sks');
        var sptp = $(this).attr('data-sptp');
        var ijazah = $(this).attr('data-ijazah');
        var skp = $(this).attr('data-skp');
        var rekomp = $(this).attr('data-rekomp');
        var ktp = $(this).attr('data-ktp');
        $('.jikafaskes').hide()
        $('#tosktp').show()
        $('#tAlamatPengajuanM').attr('readonly', false);
        $('#tKabupatenM').attr('readonly', false);
        $('#tKecamatanM').attr('readonly', false);
        $('#tLat').attr('readonly', false);
        $('#tLong').attr('readonly', false);
        $('#tNamaFaskesM').val('0');
        $('#tIsFaskes').val('0')
        $('#praktikum').show()
        //$('#tFileSTP').prop('required',true);
        //$('#tNoSTP').prop('required', true);
        //$('#tTglSTP').prop('required', true);

        $('#keteranganpimp').hide()
        $('#tFileSKP').prop('required', false);
        $('#tNoSKP').prop('required', false);
        $('#tTglSKP').prop('required', false);
        $('#jikamandara').show()

        $('#tFileSKTP').prop('required', true);
        $('#tNoSKTP').prop('required', true);
        $('#tTglSKTP').prop('required', true);
        

        var isAvail = 1

        if ( ijazah == 0 || ktp == 0 || sptp == 0) {
            isAvail = 0
        }

        if (isAvail == 0) {
            Swal.fire('Dokumen Belum Lengkap, Silahkan Lengkapi Dokumen Terlebih Dahulu');
        } else {

            $('#penambahanAjuanM').show();
            if ($("#formPengajuanM").length > 0) {
                $('#formPengajuanM')[0].reset();
            } else {
                $('#ajukanSIPManual')[0].reset();
            }
            $('#tTypeAjuan').val('add');
            $('.setelahpilih').show()
            $('#stepsatu').show()

        }

        
    })

    ///ketika berganti ke faskes
    
    $('#ubahkefaskes').click(function(){

        var id_user = $(this).attr('data-id')

        $('#pilihfasyankes').modal('show');
        $.ajax({

            type: 'ajax',
            method: 'get',
            url: '{{ route("get.all.faskes")}}',
            data: {'id_user': id_user,_token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){
                //console.log(data);
                var html = ''

                for (i=0; i < data.allfaskes.length; i++) {
                    var id_faskes = data.allfaskes[i].id_faskes;
                    var nama_faskes = data.allfaskes[i].nama_faskes;
                    var alamat_faskes = data.allfaskes[i].alamat_faskes;
                    var kab_faskes = data.allfaskes[i].kabupaten_faskes;
                    var kec_faskes = data.allfaskes[i].kecamatan_faskes;
                    var latitude = data.allfaskes[i].latitude;
                    var longitude = data.allfaskes[i].longitude;


                    html +='<tr><td>'+(i + 1)+'</td><td style="display:none">'+id_faskes+'</td><td>'+nama_faskes+'</td><td>'+alamat_faskes+'</td><td>'+kec_faskes+'</td><td>'+kab_faskes+'</td><td style="display:none">'+latitude+'</td><td style="display:none">'+longitude+'</td><td><button class="btn btn-info btn-sm faskespilihan" id="selectfaskes'+id_faskes+'" data-id="'+id_faskes+'" data-nama="'+nama_faskes+'" data-alamat="'+alamat_faskes+'" data-kec="'+kec_faskes+'" data-kab="'+kab_faskes+'" data-lat="'+latitude+'" data-longi="'+longitude+'">Pilih</button></td></tr>';

                    
                    
                }

                $('#praktikum').hide()
                $('#tFileSTP').prop('required',false);
                $('#tNoSTP').prop('required', false);
                $('#tTglSTP').prop('required', false);

                $('#keteranganpimp').show();
                $('#tFileSKP').prop('required', true);
                $('#tNoSKP').prop('required', true);
                $('#tTglSKP').prop('required', true);

                $('#pilihanfaskes').html(html);
                $('#faskesloading').hide();
                var datatablefaskes = $('#tabelfaskes').DataTable();

                $('#tabelfaskes').on("click", ".faskespilihan", function() {

                    var id_faskes = $(this).attr('data-id')
                    var nama_faskes = $(this).attr('data-nama')
                    var alamat_faskes = $(this).attr('data-alamat')
                    var kec_faskes = $(this).attr('data-kec')
                    var kab_faskes = $(this).attr('data-kab')
                    var latitude = $(this).attr('data-lat')
                    var longitude = $(this).attr('data-longi')

                    $('#pilihfasyankes').modal('hide')
                    $('.jikafaskes').show()

                    $('#penambahanAjuanM').show()
                    $('#tNamaFaskesM').val(nama_faskes);
                    $('#tAlamatPengajuanM').val(alamat_faskes);
                    $('#tKabupatenM').val(kab_faskes);
                    $('#tKecamatanM').val(kec_faskes);
                    $('#tLat').val(latitude);
                    $('#tLong').val(longitude);
                    $('#tidFaskes').val(id_faskes);
                    $('#tNamaFaskes').val(nama_faskes);
                    $('#tisFaskes').val('1')
                    $('#tisFaskesEdit').val('1')

                    $('#tAlamatPengajuanM').attr('readonly', true);
                    $('#tKabupatenM').attr('readonly', true);
                    $('#tKecamatanM').attr('readonly', true);
                    $('#tLat').attr('readonly', true);
                    $('#tLong').attr('readonly', true);
                    $('#ketikaberubahkefaskes').show();
                    $('#tnamakefaskes').val(nama_faskes)
                    $('#tidFaskesEdit').val(id_faskes);

                })

            },
            error: function(request, status, error){
                //alert(request.responseText);
            }

        })

    });

    $('#setrndmpass').click(function(){
        var randomstring = Math.random().toString(36).slice(-8);
        $('#aprPassw').val(randomstring);

    })

    $('#addajufaskes').click(function(){

        var sks = $(this).attr('data-sks');
        var sptp = $(this).attr('data-sptp');
        var ijazah = $(this).attr('data-ijazah');
        var skp = $(this).attr('data-skp');
        var rekomp = $(this).attr('data-rekomp');
        var ktp = $(this).attr('data-ktp');
        var id_user = $(this).attr('data-id');
        $('#jikamandara').hide()
        $('#tosktp').hide()
       

        var isAvail = 1

        if (ijazah == 0 || ktp == 0 || sptp == 0) {
            isAvail = 0
        }

        if (isAvail == 0) {
            Swal.fire('Dokumen Belum Lengkap, Silahkan Lengkapi Dokumen Terlebih Dahulu');
        } else {
            $('#pilihfasyankes').modal('show');
            $.ajax({

                type: 'ajax',
                method: 'get',
                url: '{{ route("get.all.faskes")}}',
                data: {'id_user' : id_user, _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function(data){
                    //console.log(data);
                    var html = ''

                    for (i=0; i < data.allfaskes.length; i++) {
                        var id_faskes = data.allfaskes[i].id_faskes;
                        var nama_faskes = data.allfaskes[i].nama_faskes;
                        var alamat_faskes = data.allfaskes[i].alamat_faskes;
                        var kab_faskes = data.allfaskes[i].kabupaten_faskes;
                        var kec_faskes = data.allfaskes[i].kecamatan_faskes;
                        var latitude = data.allfaskes[i].latitude;
                        var longitude = data.allfaskes[i].longitude;


                        html +='<tr><td>'+(i + 1)+'</td><td style="display:none">'+id_faskes+'</td><td>'+nama_faskes+'</td><td>'+alamat_faskes+'</td><td>'+kec_faskes+'</td><td>'+kab_faskes+'</td><td style="display:none">'+latitude+'</td><td style="display:none">'+longitude+'</td><td><button class="btn btn-info btn-sm faskespilihan" id="selectfaskes'+id_faskes+'" data-id="'+id_faskes+'" data-nama="'+nama_faskes+'" data-alamat="'+alamat_faskes+'" data-kec="'+kec_faskes+'" data-kab="'+kab_faskes+'" data-lat="'+latitude+'" data-longi="'+longitude+'">Pilih</button></td></tr>';

                        
                        
                    }

                    $('#praktikum').hide()
                    $('#tFileSTP').prop('required',false);
                    $('#tNoSTP').prop('required', false);
                    $('#tTglSTP').prop('required', false);

                    $('#keteranganpimp').show();
                    $('#tFileSKP').prop('required', true);
                    $('#tNoSKP').prop('required', true);
                    $('#tTglSKP').prop('required', true);

                    $('#tFileSKTP').prop('required', false);
                    $('#tNoSKTP').prop('required', false);
                    $('#tTglSKTP').prop('required', false);

                    $('#pilihanfaskes').html(html);
                    $('#faskesloading').hide();
                    var datatablefaskes = $('#tabelfaskes').DataTable();

                    $('#tabelfaskes').on("click", ".faskespilihan", function() {

                        var id_faskes = $(this).attr('data-id')
                        var nama_faskes = $(this).attr('data-nama')
                        var alamat_faskes = $(this).attr('data-alamat')
                        var kec_faskes = $(this).attr('data-kec')
                        var kab_faskes = $(this).attr('data-kab')
                        var latitude = $(this).attr('data-lat')
                        var longitude = $(this).attr('data-longi')

                        $('#pilihfasyankes').modal('hide')
                        $('.jikafaskes').show()

                        $('#penambahanAjuanM').show()
                        $('#tNamaFaskesM').val(nama_faskes);
                        $('#tAlamatPengajuanM').val(alamat_faskes);
                        $('#tKabupatenM').val(kab_faskes);
                        $('#tKecamatanM').val(kec_faskes);
                        $('#tLat').val(latitude);
                        $('#tLong').val(longitude);
                        $('#tidFaskes').val(id_faskes);
                        $('#tNamaFaskes').val(nama_faskes);
                        $('#tIsFaskes').val('1')

                        $('#tAlamatPengajuanM').attr('readonly', true);
                        $('#tKabupatenM').attr('readonly', true);
                        $('#tKecamatanM').attr('readonly', true);
                        $('#tLat').attr('readonly', true);
                        $('#tLong').attr('readonly', true);
                        $('.setelahpilih').show()
                        $('#stepsatu').show()

                    })

                },
                error: function(request, status, error){
                    //alert(request.responseText);
                }

            })

        }

    })

    $('#setujupengajuandinkes').click(function(){
        var id_pengajuan = $(this).attr('data-id');
        var id_nakes = $(this).attr('data-nakes');
        var tgl_visitasi = $(this).attr('data-visitasi');
        var todays = $(this).attr('data-today');
        var salinan = $(this).attr('data-salinan');
        var isFaskes = $(this).attr('data-isfaskes')

        if( todays < tgl_visitasi) {
            //alert('Belum Melampaui Tanggal Visitasi!')
        } else {

            $('#approveModal').modal('show');
            $('#setujuDPMPTSPDoc').hide()
            $('#tSetStatus').val('2');
            $('#tid_pengajuan').val(id_pengajuan);
            $('#tid_nakes').val(id_nakes);
            $('#tSalinanKe').val(salinan)
            //$('#tFileDocDinkes').prop('required',true);
            $('#tFileDocDPMPTSP').prop('required',false);
            if (isFaskes == 1) {
                $('#setujuDinkesDoc2').hide()
                $('#setujuDinkesDoc').hide()

            } else {
                $('#tSetStatus').val('1K');
            }
            //else {
            //     $('#setujuDinkesDoc2').show()
            //     $('#setujuDinkesDoc').hide()
            //     $('#tFileVisitasi').prop('required',true);
                
            // }

        }
        
    })

    $('#setujuptsp').click(function(){
        var id_pengajuan = $(this).attr('data-id');
        var id_nakes = $(this).attr('data-nakes');
        var template_id = $('#tTemplateSIP').val();
        var selectedtgl = $('#tfixedtgl').val();
        var perubahan = $(this).attr('data-perubahan');
        var isverif = $(this).attr('data-verif')
        

        
        if (template_id == null || selectedtgl == null) {

            Swal.fire('Silahkan Pilih Template SIP dan Tanggal Berlaku SIP');

        } else {

            $('#draftid_persetujuan').val(id_pengajuan);
            $('#draftid_nakes').val(id_pengajuan);
            $('#draftid_verif').val(isverif)

            if($('#ukuranfotopengajuan').length) {

                const value = parseInt($('#ukuranfotopengajuan').val(), 10);
                if (isNaN(value) || value < 50 || value > 250) {
                    alert('Input Yang Anda Masukkan Tidak Sesuai, Mohon Isikan Angka Antara 50 - 250');
                    // Reset the input value to its default or empty
                    $('#ukuranfotopengajuan').val(150);
                } else {

                    $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '{{ route("ubah.ukuran.fotosip")}}',
                        data: {'id_pengajuan': id_pengajuan, 'ukuran' : value, _token: "{{ csrf_token() }}"},
                        async: false,
                        dataType: 'json',
                        success: function(data){
                            
                            if(data.success == false) {
                               console.log(data.keterangan);
                            }

                        },
                        error: function(request, status, error){
                            alert(request.responseText);
                        }
                    });

                }
                
            }

            
            $('#lagisubmitdraft').show();

            $.ajax({
            type: 'ajax',
            method: 'post',
            url: '{{ route("drafting.data.sip")}}',
            data: {'id_pengajuan': id_pengajuan, 'selectedfixed' : selectedtgl, 'perubahan': perubahan, 'template_id' : template_id, 'id_nakes': id_nakes, _token: "{{ csrf_token() }}"},
            //async: false,
            dataType: 'json',
            beforeSend: function() {
               
                $('#waitingdraft').show();
                
            },
            success: function(data){

                $('#approvetodraft').modal('show');
                $('#lagisubmitdraft').hide();
                console.log(data)

                if(data.success == true) {
                    $('#waitingdraft').hide();
                    if (data.isExist == 1) {
                        var namafilesurat = data.namafilesurat;
                        var randomis = Math.floor((Math.random()*1000000) + 1)
                        urlsurat = data.surathost+namafilesurat+'.pdf'+ "?dummy="+ randomis;
                        $('#hasildraftsip').attr('src', urlsurat)
                        $('#donlitdraftsip').attr('href',urlsurat)
                        $('#waitpdfsip').hide()

                    } else {

                        $.ajax({
                            type: 'ajax',
                            method: 'post',
                            url: '{{ route("generate.draft.sip")}}',
                            data: {'id_pengajuan': id_pengajuan, 'perubahan' : perubahan, 'id_nakes' : id_nakes, _token: "{{ csrf_token() }}"},
                            async: false,
                            dataType: 'json',
                            beforeSend: function() {
                                $('#waitpdfsip').show()
                            },
                            success: function(data){
                                console.log(data)

                                $('#waitpdfsip').hide()
                                
                                if(data.success_draft == true) {
                                    var randomis = Math.floor((Math.random()*1000000) + 1)
                                    urlsurat = data.resultdraft.surathost+data.resultdraft.thefile+'.pdf'+ "?dummy="+ randomis;
                                    $('#hasildraftsip').attr('src', urlsurat)
                                    $('#donlitdraftsip').attr('href',urlsurat)

                                } else {
                                    Swal.fire('Gagal Memproses Draft SIP');
                                    gagalhtml = '<h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Something went wrong.</h3>';
                                    $('#fordraftsip').html(gagalhtml)
                                }
                            },
                            error: function(request, status, error){
                                alert(request.responseText);
                            }
                        });

                    }
                } else {
                    alert('Gagal Memproses Draft SIP');
                }
            },
            error: function(request, status, error){
                //alert(request.responseText);
            }
        });

        }

        //$('#setujuDinkesDoc').hide()
        //$('#setujuDinkesDoc2').hide()
        //$('#tSetStatus').val('3');
        //$('#tid_pengajuan').val(id_pengajuan);
        //$('#tid_nakes').val(id_nakes);
        $('#tFileDocDinkes').prop('required',false);
        $('#tFileDocDPMPTSP').prop('required',true);

    })

    $('#kirimdraftkeasoka').click(function(){
        var id_pengajuan = $('#draftid_persetujuan').val();
        var isverif = $('#draftid_verif').val();
        var updater = $('#draftUpdater').val()
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("draft.sip.asoka")}}',
                data: {'id_pengajuan': id_pengajuan, 'updater' : updater, 'isverif' : isverif, _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#kirimdraftkeasoka').attr('disabled', 'disabled')
                },
                success: function(data){
                    console.log(data)

                    $('#waitpdfsip').hide()
                    $('#kirimdraftkeasoka').attr('disabled', false)
                    
                    if(data.success == true) {

                        if(isverif == '0') {

                            Swal.fire('Draft SIP Akan Direview Oleh Verifikator DPMPTSP')
                            window.location.replace("{{route('adminptsp.main.dashboard')}}");

                        } else {

                            Swal.fire('Draft SIP berhasil dikirimkan ke ASOKA dan Dapat Direview Oleh Kepala Dinas PTSP');
                            window.location.replace("{{route('verif.main.dashboard')}}");
                        }

                    } else {
                        alert(data.keterangan);
                    }
                },
                error: function(request, status, error){
                    
                    alert('Error Pada Sistem: '+error)
                   
                }
            });

            $('#kirimdraftkeasoka').attr('disabled', false)

    })

    $('.batalkanpengajuan').click(function(){

        var id_pengajuan = $(this).attr('data-id')
        var id_doc = $(this).attr('data-doc')
        var updater = $(this).attr('data-updater')

        if (confirm("Apakah Anda Yakin Menghapus Pengajuan Ini?") == true) {

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("batal.pengajuan.nakes")}}',
                data: {'id_pengajuan': id_pengajuan, 'updater' : updater, 'id_doc': id_doc, _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function(data){
                    
                    if(data.success == true) {
                        Swal.fire('Pengajuan Berhasil Dihapus');
                        location.reload()
                        
                    } else {
                        Swal.fire(data.keterangan);
                    }
                },
                error: function(request, status, error){
                    
                    alert('Error Pada Sistem: '+error)
                    
                }
            });
        }
    })

    $('#bataldraftasoka').click(function(){
        var id_pengajuan = $('#draftid_persetujuan').val();
        var updater = $('#draftUpdater').val()
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("cancel.draft.sip")}}',
                data: {'id_pengajuan': id_pengajuan, 'updater' : updater, _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#kirimdraftkeasoka').attr('disabled', 'disabled')
                    $('#bataldraftasoka').attr('disabled', 'disabled')
                },
                success: function(data){

                    $('#approvetodraft').modal('hide')
                    
                },
                error: function(request, status, error){
                    
                    alert('Error Pada Sistem: '+error)
                   
                }
            });

    })

    $('#tolakpengajuan').click(function(){

        var id_pengajuan = $(this).attr('data-id');
        var id_nakes = $(this).attr('data-nakes');
        var salinan = $(this).attr('data-salinan');
        var url_qr = $(this).attr('data-urlqr');
        var template_id = $(this).attr('data-template');
        if(url_qr == 'manual') {
            $('#isfotonakes').show();
        } else {
            $('#isfotonakes').hide();
        }
        if(template_id == '3' || template_id == '4') {
            $('#istemplate').show()
        } else {
            $('#istemplate').hide()
        }
        $('#tolakModal').modal('show');
        $('#tid_pengajuant').val(id_pengajuan);
        $('#tid_nakest').val(id_nakes);
        $('#tolak_salinan').val(salinan);

    })


    $('.checktolak').click(function() {
        var numChecked = $('input[type="checkbox"].checktolak:checked').length;
        var nextInputId = $(this).closest('div').nextAll('div').first().find('input').attr('id');
        if (numChecked > 0 ) {
            $('#btnSubmitSetujutolak').show()
        } else {
            $('#btnSubmitSetujutolak').hide()
        }
        if ($(this).prop('checked')) {
            $('#'+nextInputId).prop('required', true); 
        } else {
            $('#'+nextInputId).prop('required', false); 
        }
    });

    

    $('#testingan').click(function(){

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("get.data.testing")}}',
            data: {'thename': 'apaantuh', _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){

                console.log(data)
                //resultContainer.innerHTML += `<div>Nomor Registrasi - `+data.no_reg+`</div><br /><div>Nama Nakes - `+data.nama_nakes+`</div>`;
            },
            error: function(request, status, error){
                alert(request.responseText);
            }
        });

    })


    $('#ajuanku').click(function(){
        var id = $(this).attr('data-id');
       
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("get.data.strsalinan")}}',
            data: {'id_user': id , _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){
                //console.log(data)

                $('.liatdetilpengajuan').hide()

                if (data.allsalinan[0].template_id == '1') {
                    if (data.allsalinan[0].kompetensi && data.allsalinan[0].kompetensi.toUpperCase().includes('FISIKAWAN')) {
                        $('#salinanketiga').show()
                        $('#headsal3').show()
                    } else {
                        $('#salinanketiga').hide()
                        $('#headsal3').hide()
                    }
                    
                    
                } else {
                    $('#salinanketiga').show()
                    $('#headsal3').show()
                }

                var user_id = $('#kepengajuan1').attr('data-id');
                var kddtl_1 = user_id+'_1';
                var kddtl_2 = user_id+'_2';
                var kddtl_3 = user_id+'_3';

                var urlkddtl1 = '{{ route("nakes.kedetail.pengajuan", ":id1") }}';
                var urlkddtl2 = '{{ route("nakes.kedetail.pengajuan", ":id2") }}';
                var urlkddtl3 = '{{ route("nakes.kedetail.pengajuan", ":id3") }}';

                urlkddtl1 = urlkddtl1.replace(':id1', kddtl_1);
                urlkddtl2 = urlkddtl2.replace(':id2', kddtl_2);
                urlkddtl3 = urlkddtl3.replace(':id3', kddtl_3);

                $('#liatkepengajuan1').attr('href', urlkddtl1)
                $('#liatkepengajuan2').attr('href', urlkddtl2)
                $('#liatkepengajuan3').attr('href', urlkddtl3)

                if (data.allsalinan[0].template_id == '2') {
                    $('#kepengajuan1').html('Upload Salinan 1');
                    $('#kepengajuan2').html('Upload Salinan 2');
                    $('#kepengajuan3').html('Upload Salinan 3');
                    $('.kepengajuan').attr('data-template', '2');

                    var kode_id1 = user_id+'_1';
                    var kode_id2 = user_id+'_2';
                    var kode_id3 = user_id+'_3';
                    var urled1 = '{{ route("nakes.dokter.uploadstr", ":id1") }}';
                    var urled2 = '{{ route("nakes.dokter.uploadstr", ":id2") }}';
                    var urled3 = '{{ route("nakes.dokter.uploadstr", ":id3") }}';
                    urled1 = urled1.replace(':id1', kode_id1);
                    urled2 = urled2.replace(':id2', kode_id2);
                    urled3 = urled3.replace(':id3', kode_id3);
                    $('#kepengajuan1').attr('href', urled1);
                    $('#kepengajuan2').attr('href', urled2);
                    $('#kepengajuan3').attr('href', urled3);
                } else {
                    $('#kepengajuan1').html('Gunakan Salinan 1');
                    $('#kepengajuan2').html('Gunakan Salinan 2');
                    $('#kepengajuan3').html('Gunakan Salinan 3');
                    $('.kepengajuan').attr('data-template', data.allsalinan[0].template_id);
                    var user_id = $('#kepengajuan1').attr('data-id');
                    var kode_id1 = user_id+'_1';
                    var kode_id2 = user_id+'_2';
                    var kode_id3 = user_id+'_3';
                    var urled1 = '{{ route("nakes.pakai.idlestr", ":id1") }}';
                    var urled2 = '{{ route("nakes.pakai.idlestr", ":id2") }}';
                    var urled3 = '{{ route("nakes.pakai.idlestr", ":id3") }}';
                    urled1 = urled1.replace(':id1', kode_id1);
                    urled2 = urled2.replace(':id2', kode_id2);
                    urled3 = urled3.replace(':id3', kode_id3);
                    $('#kepengajuan1').attr('href', urled1);
                    $('#kepengajuan2').attr('href', urled2);
                    $('#kepengajuan3').attr('href', urled3);
                }

                


                for (i=0; i < data.allsalinan.length; i++) {
                    var salinan = data.allsalinan[i].salinan;
                    var isDiajukan = data.allsalinan[i].isDiajukan;
                    var templet = data.allsalinan[i].template_id;
                    var isproblem = data.allsalinan[i].isApproved;
                    console.log(data.allsalinan)
                    
                    

                    if(isDiajukan == '1') {

                        if(isproblem == '9' || isproblem == 'P9' || isproblem == 'C9') {

                            var id_pengajuan = data.allsalinan[i].id_pengajuan
                            $('#headsal'+salinan).prop('class', 'card card-danger');
                            $('#iconsal'+salinan).prop('class', 'fa fa-file');
                            $('#liatkepengajuan'+salinan).text('Edit Pengajuan');
                            var user_id = $('#kepengajuan'+salinan).attr('data-id');
                            var kode_id = user_id+'_'+salinan+'_'+id_pengajuan
                            var urled = '{{ route("nakes.pengajuan.edit", ":id") }}';
                            urled = urled.replace(':id', kode_id);
                            $('#kepengajuan'+salinan).hide();
                            $('#liatkepengajuan'+salinan).show();
                            $('#liatkepengajuan'+salinan).attr('href', urled);
                            $('#titlesal'+salinan).text('Salinan '+salinan+' (Ditolak)')
                            $('#liatkepengajuan'+salinan).prop('class', 'btn btn-block btn-outline-danger');

                        } else {

                            if(data.allsalinan[i].isApproved == 'CF') {
                                $('#headsal'+salinan).prop('class', 'card card-success');
                                $('#iconsal'+salinan).prop('class', 'fa fa-file');
                                $('#kepengajuan'+salinan).text('Pilih Salinan '+salinan);
                                var user_id = $('#kepengajuan'+salinan).attr('data-id');
                                var kode_id = user_id+'_'+salinan
                                var urled = '{{ route("nakes.pengajuan.new", ":id") }}';
                                urled = urled.replace(':id', kode_id);
                                $('#kepengajuan'+salinan).attr('href', urled);
                                $('#kepengajuan'+salinan).prop('class', 'btn btn-block btn-success');
                                $('#liatkepengajuan'+salinan).hide();
                            } else {

                                $('#headsal'+salinan).prop('class', 'card card-success');
                                $('#iconsal'+salinan).prop('class', 'fa fa-file');
                                $('#kepengajuan'+salinan).text('Salinan '+salinan+ ' Diajukan');
                                var user_id = $('#kepengajuan'+salinan).attr('data-id');
                                var kode_id = user_id+'_'+salinan
                                var urled = '{{ route("nakes.pengajuan.new", ":id") }}';
                                urled = urled.replace(':id', kode_id);
                                $('#kepengajuan'+salinan).hide();
                                $('#liatkepengajuan'+salinan).show();
                                $('#titlesal'+salinan).text('Salinan '+salinan+' (Diajukan)')
                                $('#liatkepengajuan'+salinan).prop('class', 'btn btn-block btn-outline-primary');

                            }

                            
                        }

                        
                        

                    } else {

                        $('#headsal'+salinan).prop('class', 'card card-success');
                        $('#iconsal'+salinan).prop('class', 'fa fa-file');
                        $('#kepengajuan'+salinan).text('Pilih Salinan '+salinan);
                        var user_id = $('#kepengajuan'+salinan).attr('data-id');
                        var kode_id = user_id+'_'+salinan
                        var urled = '{{ route("nakes.pengajuan.new", ":id") }}';
                        urled = urled.replace(':id', kode_id);
                        $('#kepengajuan'+salinan).attr('href', urled);
                        $('#kepengajuan'+salinan).prop('class', 'btn btn-block btn-success');
                        $('#liatkepengajuan'+salinan).hide();
                        
                        

                    }
                    
                    
                }
                
            },
            complete: function(data) {
                $('#pakaiSTRModal').modal('show');
            },
            error: function(request, status, error){
                alert(request.responseText);
            }
        });
        
    })

    $('.uploadrekomop').click(function(){
        var id_pengajuan = $(this).attr('data-id');
        $('#recIdPengajuan').val(id_pengajuan)
        $('#uploadrecopModal').modal('show')
    })

    $('#setujubyop').click(function(){
        var id_pengajuan = $(this).attr('data-id')
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '{{ route("submit.setuju.op")}}',
            data: {'id_pengajuan': id_pengajuan, _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){

                //alert('bisa')
                
                if(data.success == true) {
                    Swal.fire(data.message);
                    location.reload();
                } else {
                    Swal.fire(data.message);
                }
            },
            error: function(request, status, error){
                //alert(request.responseText);
            }
        });
    })

    $('#historyapprovehdinkes').on('click','.viewdetailpengajuan', function(){

        var id_pengajuan = $(this).attr('data-id');
        var urled = '{{ route("get.detail.pengajuan", ":id") }}';
        urled = urled.replace(':id', id_pengajuan);
        $(this).attr('href', urled);

    })

    $('#historyapprovepengajuan').on('click','.viewdetailpengajuan', function(){

        var id_pengajuan = $(this).attr('data-id');
        var urled = '{{ route("get.detail.pengajuan", ":id") }}';
        urled = urled.replace(':id', id_pengajuan);
        $(this).attr('href', urled);

    })

    

    $('#jadwalvisitasi').click(function(){
        var id_pengajuan = $(this).attr('data-id');
        var id_nakes = $(this).attr('data-nakes');
        var tgl_visitasi = $('#tVisitasi').val();
        var updater = $(this).attr('data-updater');

        console.log(tgl_visitasi)
        if (tgl_visitasi == '') {
            Swal.fire('Silahkan Pilih Tanggal Visitasi Terlebih Dahulu')
        } else {

            if (confirm("Apakah Anda Yakin Untuk Melakukan Visitasi Pada Tanggal: "+tgl_visitasi+" ?") == true) {

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("submit.tgl.visitasi")}}',
                    data: {'id_pengajuan': id_pengajuan, 'id_nakes': id_nakes, 'tgl_visitasi' : tgl_visitasi, 'updater' : updater, _token: "{{ csrf_token() }}"},
                    async: false,
                    dataType: 'json',
                    success: function(data){

                        //alert('bisa')
                        
                        if(data.success == true) {
                            Swal.fire(data.message);
                            location.reload();
                        } else {
                            Swal.fire(data.message);
                        }
                    },
                    error: function(request, status, error){
                        //alert(request.responseText);
                    }
                });
            }
            
        }
        
        // 
        
    })

    $('#btnUbahVisit').click(function(){

        $('#perubahvisit').hide()
        $('#ubahlah').show()
        $('#reschedulevisitasi').show()

    })

    $('#reschedulevisitasi').click(function(){
        var current_visit = $('#tVisitasiV').val()
        var updated_visit = $('#tVisitasiE').val()
        var id_pengajuan = $(this).attr('data-id')
        var id_nakes = $(this).attr('data-nakes')
        var updater = $(this).attr('data-updater');
        if (current_visit == updated_visit) {
            Swal.fire('Tidak Ada Perubahan Tanggal Visitasi, Tanggal Visitasi Sebelumnya : '+current_visit)
        } else {

            if (confirm("Apakah Anda Yakin Untuk Melakukan Pembaharuan Visitasi Pada Tanggal: "+updated_visit+" ?") == true) {

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("update.tgl.visitasi")}}',
                    data: {'id_pengajuan': id_pengajuan, 'id_nakes': id_nakes, 'tgl_visitasi' : updated_visit, 'updater' : updater, _token: "{{ csrf_token() }}"},
                    async: false,
                    dataType: 'json',
                    success: function(data){

                        //alert('bisa')
                        
                        if(data.success == true) {
                            Swal.fire(data.message);
                            location.reload();
                        } else {
                            Swal.fire(data.message);
                        }
                    },
                    error: function(request, status, error){
                        //alert(request.responseText);
                    }
                });
            }

        }
    })

    


    
    $('#downloadfotonya').click(function(){
       
        var filename = $('#fotokan').val();

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '{{ route("test.download.foto")}}',
            data: {'filenamenya': filename, _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){

                //alert('bisa')
                
                if(data.success == true) {
                    Swal.fire(data.message);
                    location.reload();
                } else {
                    Swal.fire(data.message);
                }
            },
            error: function(request, status, error){
                //alert(request.responseText);
            }
        });
        
    })

    
    $('#testkirimkirim').click(function(){
       
       var filename = $('#fotokan').val();

       $.ajax({
           type: 'ajax',
           method: 'post',
           url: '{{ route("test.dl.fotourl")}}',
           data: {'filenamenya': filename, _token: "{{ csrf_token() }}"},
           async: false,
           dataType: 'json',
           success: function(data){

               //alert('bisa')
               
               if(data.success == true) {
                   
                   Swal.fire(data.message+' ext: '+data.ext);
                   location.reload();
               } else {
                   Swal.fire(data.message);
               }
           },
           error: function(request, status, error){
               //alert(request.responseText);
           }
       });
       
   })

   
   $('#getallin').click(function(){
       
    var filename = 'apaaja'
       $.ajax({
           type: 'ajax',
           method: 'post',
           url: '{{ route("test.sending.file")}}',
           data: {'filenamenya': filename, _token: "{{ csrf_token() }}"},
           async: false,
           dataType: 'json',
           success: function(data){

               console.log(data);
            //    var html = ''

            //    for (i=0; i < data.dataextraction.resultword.length; i++) {
            //        var wording = data.dataextraction.resultword[i]
            //        if (wording.trim() !== '') {
            //             html += '<button class="btn btn-sm btn-info">'+wording+'</button>&nbsp;'
            //        }
                    
            //    }

            //    $('#buttonall').html(html)
               
           },
           error: function(request, status, error){
               //alert(request.responseText);
           }
       });
       
   })


   $('#getallin2').click(function(){
       
       var filenamec = 'apaaja'
          $.ajax({
              type: 'ajax',
              method: 'post',
              url: '{{ route("test.get.allin")}}',
              data: {'filenamenya': filenamec, _token: "{{ csrf_token() }}"},
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


    $('#submitUploadKTP').click(function(){

        function reloadktpimage(originfile){

            var parent = $('#ktpterkini').parent();
            var newElement = "<embed src='{{ URL::to('/storageup')}}/"+originfile+"' id='ktpterkini' width='100%' height='100%'>";
            $('#ktpterkini').remove();
            parent.append(newElement);
        }

        var data = $('#formUploadKTP').serialize();
        var form = $('#formUploadKTP')[0];
        var dataform = new FormData(form);

        var result = '';

        if ($('#tFileNakesKTP')[0].files.length === 0) {
            Swal.fire('Silahkan Attach File PDF');
        } else {
            result += '1';

        }

        if (result == '1') {

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("nakes.submit.ktp")}}',
                data: dataform,
                cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                //async: false,
                beforeSend: function() {
            
                    $('#uploadktploader').show()
                },
                //	dataType: 'json',
                success: function(response) {

                    //console.log(response)
                    $('#ktpFilename').val(response.ktpfilename)
                    Swal.fire('Upload KTP Berhasil');
                    
                    if (response.success == true) {

                           $('#formdatadiri').show()
                           var html = ''
                           for (i=0; i < response.dataextraction.resultword.length; i++) {
                               var wording = response.dataextraction.resultword[i]
                               if (wording.trim() !== '') {
                                    html += '<button class="btn btn-outline-info hasilscaning" data-bs-toggle="tooltip" data-bs-placement="top" title="Copied!">'+wording+'</button>&nbsp;'
                               }
                                
                           }

                           var originfile = response.ktpfilename;
                           reloadktpimage(originfile)

                           autocomplete(document.getElementById("ktpNAMA"), response.dataextraction.resultword);

                           $('#hasilscanktp').html(html)
                           $('[data-bs-toggle="tooltip"]').tooltip({ trigger: 'click' });
                           $('.hasilscaning').click(function(e){
                               e.preventDefault();
                                var copyText = $(this).text();

                                var textarea = document.createElement("textarea");
                                textarea.textContent = copyText;
                                textarea.style.position = "fixed"; // Prevent scrolling to bottom of page in MS Edge.
                                document.body.appendChild(textarea);
                                textarea.select();
                                document.execCommand("copy"); 
                                document.body.removeChild(textarea);
                                hideTooltip()
                               
                           })

                        function hideTooltip() {
                            setTimeout(function() {
                                $('.hasilscaning').tooltip('hide');
                            }, 1000);
                        }
                        
                    } else {
                        Swal.fire('Gagal Upload Dokumen KTP')
                    }

                    $('#uploadktploader').hide()
                    
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


    $('#submitEditDok').click(function(){

        function reloaddoc(originfile){

            var parent = $('#dokterkini').parent();
            var newElement = "<embed src='{{ URL::to('/storageup')}}/"+originfile+"' id='dokterkini' width='100%' height='100%'>";
            $('#dokterkini').remove();
            parent.append(newElement);
        }

        var data = $('#formUploadDok').serialize();
        var form = $('#formUploadDok')[0];
        var dataform = new FormData(form);

        var result = '';

        if ($('#tFileNakesDok')[0].files.length === 0) {
            Swal.fire('Silahkan Attach File PDF');
        } else {
            result += '1';

        }

        if (result == '1') {

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("nakes.update.doc")}}',
                data: dataform,
                cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                //async: false,
                beforeSend: function() {
            
                    $('#uploadktploader').show()
                },
                //	dataType: 'json',
                success: function(response) {

                    //console.log(response)
                    $('#ktpFilename').val(response.ktpfilename)
                    Swal.fire('Upload KTP Berhasil');
                    
                    if (response.success == true) {

                        var html = ''
                        var originfile = response.ktpfilename;
                        reloaddoc(originfile)
                        
                    } else {
                        Swal.fire('Gagal Upload Dokumen')
                    }

                    $('#uploadktploader').hide()
                    
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

    if($('#modal-petunjukmanual-content').length){

        $.fancybox.open({
            src: '#modal-petunjukmanual-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false,
            afterShow: function() {
                $('#close-petunjukmanual-modal').click(function() {
                    $.fancybox.close();
                    $.fancybox.open({
                        src: '#modal-scanfirstptsp-content',
                        type: 'inline',
                        touch: false,
                        modal: true,
                        clickSlide: false,
                        afterShow: function() {
                            $('#close-scanfirstptsp-modal').click(function() {
                                $.fancybox.close();
                            });
                        }
                    });
                });
            }
        });
        
    }


    if($('#modal-scanfirstmanualptsp-content').length){

        $.fancybox.open({
            src: '#modal-scanfirstmanualptsp-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false,
            afterShow: function() {
                $('#close-scanmanual-modal').click(function() {
                    $.fancybox.close();
                });
            }
        });

    }

    if($('#lihatdraftsipasoka').length) {

        $('#lihatdraftsipasoka').click(function(){

            var draftfile = $(this).attr('data-file')
            var namanakes = $(this).attr('data-nama')
            var roleuser = $(this).attr('data-role')

            if(roleuser == 'adminptsp') {
                $('#aksidraftptsp').show()
            } else {
                $('#aksidraftptsp').hide()
            }
            var randomis = Math.floor((Math.random()*1000000) + 1)
            urlsurat = draftfile+ "?dummy="+ randomis;
            $('#lihatdraftnya').attr('src', urlsurat)
            $('#juduldraftsip').html('Draft SIP atas Nama: '+namanakes)

            
            $.fancybox.open({
                src: '#modal-lihatdraft-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('.tutupintipdraft').click(function() {
                        $.fancybox.close();
                    });
                }
            });
        })
        
    }

    $('#bataldraftsip').click(function(){
        var id_pengajuan = $(this).attr('data-id')
        var filename_sip = $(this).attr('data-filename')
        var updater = $(this).attr('data-updater')
        var perubahan = $(this).attr('data-perubahan')

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '{{ route("revert.draft.sip")}}',
            data: {'id_pengajuan': id_pengajuan, 'filename_sip' : filename_sip, 'updater' : updater, 'perubahan' : perubahan, _token: "{{ csrf_token() }}"},
            dataType: 'json',
            beforeSend: function() {
        
                $('#sedangrevertdraft').show()
            },
            //	dataType: 'json',
            success: function(response) {

                $.fancybox.close();
                
                if (response.success == true) {
                    location.reload();
                } else {
                    $('#sedangrevertdraft').hide()
                    alert(response.keterangan);
                } 
                
            },
            complete: function(data) {

                $('#sedangrevertdraft').hide()

            },
            error: function(request, status, error) {
                alert(request.responseText);
            }
        });


    })


  
    $('#submitDaftarManual').click(function(){

        var data = $('#formDaftarManual').serialize();
        var form = $('#formDaftarManual')[0];
        var dataform = new FormData(form);

        var result = '';

        if ($('#tFileSTRManual')[0].files.length === 0 || $('#tFileFotoNakes')[0].files.length === 0) {
            alert('Silahkan Attach File STR (PDF) dan Foto STR');
        } else {
            result += '1';

        }

        if (result == '1') {

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("admin.submit.strmanual")}}',
                data: dataform,
                cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                //async: false,
                beforeSend: function() {
            
                    $('#uploadstrmanualloader').show()
                    $('#formsubmitstrmanual').show()
                    $('#tabularhasil').hide()
                    $('#reloadformnya').hide()
                },
                //	dataType: 'json',
                success: function(response) {

                    console.log(response.resultword.str_hingga)

                    alert('Upload STR Berhasil');

                    $('#uploadstrmanualloader').hide()
                    $('#overlaystrmanual').hide();
                    var originfile = response.namafile;
                    var thelink = response.dataextraction.thelink;
                    
                    var hasilsource = "";
                    var parent = $('#hasiluploadstrmanual').parent();
                    var newElement = "<embed src='{{ URL::to('/storage')}}/"+originfile+".pdf' id='hasiluploadstrmanual' width='100%' height='400px'>";
                    $('#hasiluploadstrmanual').remove();
                    parent.append(newElement);
                    

                    var hasilfoto = '';
                    var parentfoto = $('#hasiluploadfotomanual').parent();
                    var newElementFoto = "<embed src='{{ URL::to('/storagefoto')}}/"+originfile+".jpeg' id='hasiluploadfotomanual' height='400px'>";
                    $('#hasiluploadfotomanual').remove();
                    parent.append(newElementFoto);

                    if (response.dataextraction.hasOwnProperty("message")) {
                    // The JSON object contains the key "message"
                        var cekekstrak = response.dataextraction.message.includes('Gagal Membaca QRCODE')
                        
                    } else {
                        var cekekstrak = false;
                    }

                    console.log(cekekstrak)
                    
                    if(thelink != '') {
                        if (cekekstrak == false) {
                            $('#sturlqr').val(thelink)
                        }
                    }
             
                    $('#stWhichFManual').val(originfile);

                    


                    if (response.success_extract == true) {
                        var issttk = response.resultword.strttk
                        var isapoteker = response.resultword.isapoteker
                        var isdokter = response.resultword.isdokter
                        var issalinan = response.resultword.salinan
                        var str_hingga = response.resultword.str_hingga
                        var tgl_str = response.resultword.tgl_str


                        if(issalinan != '') {
                            $('#stSalinan').val(issalinan)
                        }

                        if(str_hingga != '') {
                            $('#stSTRHinggaSIPmanual').val(str_hingga)
                        }

                        if(tgl_str != '') {
                            $('#stSTRtetapSIPmanual').val(tgl_str)
                        }

                        if (issttk != '' && isapoteker == '' && isdokter == '') {

                            var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3" selected>SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK Tenaga Kesehatan</option></select>';
                            $('#pilihtemplate').html(pilihapot)

                            var finalprof = '<option value="TTK" selected>Tenaga Teknis Kefarmasian</option>'
                            $('#stProfesiDD').html(finalprof);

                            $('#stProfesi').val('Tenaga Teknis Kefarmasian')

                        } else if (isapoteker != '' && issttk == '' && isdokter == '') {

                            var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" disabled>SIP DOKTER</option><option value="3" selected>SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK Tenaga Kesehatan</option></select>';
                            $('#pilihtemplate').html(pilihapot)

                            var finalprof = '<option value="APT" selected>APOTEKER</option>'
                            $('#stProfesiDD').html(finalprof);

                        } else if (isdokter != '' && issttk == '' && isapoteker == '') {

                            var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2" selected>SIP DOKTER</option><option value="3" disabled>SIP APOTEKER / TTK</option><option value="4" disabled>SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" disabled>SIP&SIK Tenaga Kesehatan</option></select>';
                            $('#pilihtemplate').html(pilihapot)

                            

                            var finalprof = '<option value="DU" selected>DOKTER UMUM</option><option value="DG">DOKTER GIGI</option><option value="DS">DOKTER SPESIALIS</option><option value="DGS">DOKTER GIGI SPESIALIS</option>'
                            $('#stProfesiDD').html(finalprof);

                        } else {

                            var pilihapot = '<label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="stProfesiSIP" name="stProfesiSIP" ><option value="2">SIP DOKTER</option><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option><option value="1" selected>SIP&SIK Tenaga Kesehatan</option></select>';
                            $('#pilihtemplate').html(pilihapot)

                        }

                    }
                    
                },
                complete: function(data) {

                    $('#formsubmitstrmanual').hide()
                    $('#tabularhasil').show()
                    $('#reloadformnya').show()

                },
                error: function(request, status, error) {
                    alert(request.responseText);
                    //$('#cobali').hide()
                }
            });
        }
    })

    $('#reloadformnya').click(function(){

        $('#formsubmitstrmanual').show()
        $('#formDaftarManual')[0].reset();
        $('#tabularhasil').hide()
        $('#submitDaftarManual').show()
        $('#overlaystrmanual').show()
        $('#reloadformnya').hide()


    })

    function validateFileSize(input) {
        var maxFileSize = 1 * 1024 * 1024; // 1 MB in bytes
        var file = input.files[0];

        if (file && file.size > maxFileSize) {
            // Reset the file input and display an error message
            $(input).val(null);
            //$('.custom-file-label').html('Choose file (Max 1MB)');
            alert('Maksimum File Foto 1MB.');
        }
    }


    $('#showSTR').click(function() {
        if ($(this).is(":checked")) {
            $('#cardSTR').show()

        } else {
            $('#cardSTR').hide()
            
        }
    });

    $('#showKTP').click(function() {
        if ($(this).is(":checked")) {
            $('#cardKTP').show()

        } else {
            $('#cardKTP').hide()
            
        }
    });

    $('#showREKOMP').click(function() {
        if ($(this).is(":checked")) {
            $('#cardREKOMP').show()

        } else {
            $('#cardREKOMP').hide()
            
        }
    });

    $('#showSKS').click(function() {
        if ($(this).is(":checked")) {
            $('#cardSKS').show()

        } else {
            $('#cardSKS').hide()
            
        }
    });

    $('#showSPTP').click(function() {
        if ($(this).is(":checked")) {
            $('#cardSPTP').show()

        } else {
            $('#cardSPTP').hide()
            
        }
    });

    $('#showIJAZAH').click(function() {
        if ($(this).is(":checked")) {
            $('#cardIJAZAH').show()

        } else {
            $('#cardIJAZAH').hide()
            
        }
    });

    $('#showSKP').click(function() {
        if ($(this).is(":checked")) {
            $('#cardSKP').show()

        } else {
            $('#cardSKP').hide()
            
        }
    });

    $('#showBAV').click(function(){
        if ($(this).is(":checked")) {
            $('#cardBAV').show()

        } else {
            $('#cardBAV').hide()
            
        }

    })

    $('#listpengajuannakes').on('click','.cabutpengajuan',function(){
        var id_user = $(this).attr('data-user')
        var jenis_profesi = $(this).attr('data-jenisprof')
        var id_pengajuan = $(this).attr('data-id')
        var salinan = $(this).attr('data-salinan');
        var id_sip = $(this).attr('data-sip');
        var template_id = $(this).attr('data-template')

        $('#cabutIdPengajuan').val(id_pengajuan)
        $('#cabutSalinan').val(salinan)
        $('#cabutIdSip').val(id_sip)
        //alert(jenis_profesi)

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("nakes.getalasan")}}',
            data: {'thename': 'apaantuh', _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){

                console.log(data)
                var html = '<option value="" selected disabled>--Pilih--</option>';
                for (i=0; i < data.getalasan.length; i++) {
                    var id_alasan = data.getalasan[i].kd_alasan;
                    var nama_alasan = data.getalasan[i].nama_alasan;
                    html += '<option value='+id_alasan+'>'+nama_alasan+'</option>';

                }
                $('#tAlasanCabut').html(html)
            },
            error: function(request, status, error){
                alert(request.responseText);
            }
        });



        $('#cabutmodal').modal('show')
        if(jenis_profesi == 'DS' || jenis_profesi == 'DGS' || jenis_profesi == 'DU' || jenis_profesi == 'DG' || jenis_profesi == 'APJ') {
            
            
            
        } else {

            if(template_id == '4')
            {
                $('.ifdokterapot').show()
                $('#tFileRekomdok').prop('required',true);

            } else {

                $('.ifdokterapot').hide()
                $('#tFileRekomdok').prop('required',false);

            }
            
        }
    })

    $('.setujucabut').click(function(){

        var id_pengajuan = $(this).attr('data-id')
        var id_nakes = $(this).attr('data-nakes')
        var salinan = $(this).attr('data-salinan')
        var updater = $(this).attr('data-updater')
        var id_alasan = $(this).attr('data-alasan')

        if (confirm('Apakah Anda Yakin Untuk Menyetujui Pencabutan SIP Berikut?')) {

            $.ajax({
              type: 'ajax',
              method: 'post',
              url: '{{ route("approve.pencabutan")}}',
              data: {'id_pengajuan': id_pengajuan, 'id_nakes' : id_nakes, 'salinan' : salinan, 'updater': updater, 'id_alasan' : id_alasan, 'kode' : '1', _token: "{{ csrf_token() }}"},
              async: false,
              dataType: 'json',
              success: function(data){

                  if (data.success == true) {
                    alert('Sukses Update Data Pencabutan');
                    location.reload();
                  } else {
                      alert('Gagal Mengupdate Data Pencabutan');
                  }
                
              },
              error: function(request, status, error){
                  alert('Error Penyetujuan Pencabutan')
              }
          });
            
        }

    })


    $('.tolakcabut').click(function(){

        var id_pengajuan = $(this).attr('data-id')
        var id_nakes = $(this).attr('data-nakes')
        var salinan = $(this).attr('data-salinan')
        var updater = $(this).attr('data-updater')
        var id_alasan = $(this).attr('data-alasan')


        Swal.fire({
            title: 'Apakah Anda Yakin Untuk Menolak Pencabutan SIP Berikut?',
            icon: 'question',
            input: 'text', // Adding an input field
            inputPlaceholder: 'Masukkan Alasan Penolakan...',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            preConfirm: (alasanTolak) => {
                if (!alasanTolak) {
                    Swal.showValidationMessage('Alasan penolakan tidak boleh kosong');
                }
                return alasanTolak;
            }
        }).then((result) => {
            if (result.value !== undefined) {
                const alasanTolak = result.value; // Get the entered value
                console.log(result)
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("approve.pencabutan")}}',
                    data: {
                        'id_pengajuan': id_pengajuan,
                        'id_nakes': id_nakes,
                        'salinan': salinan,
                        'updater': updater,
                        'id_alasan': id_alasan,
                        'kode': '9',
                        'alasan_tolak': alasanTolak, // Include the entered value here
                        _token: "{{ csrf_token() }}"
                    },
                    async: false,
                    dataType: 'json',
                    success: function(data) {
                        console.log(data)
                        if(data.success == true) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Penolakan Pencabutan Berhasil',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Penolakan Pencabutan Gagal!'
                            })
                        }
                    },
                    error: function(request, status, error) {
                        alert('Error Penyetujuan Pencabutan')
                    }
                });
            }
        });

    });

    if($('#menupencabutan').length) {

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("admin.count.menu")}}',
            data: {
                'jenis' : 'admincabut',
                'role' : role,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(data) {
              
                if(data.success == true) {
                    if(data.totalcabut > 0) {
                        $('#hitungpendingcabut').html(data.totalcabut)
                    }
                   
                }
            },
            error: function(request, status, error) {
                alert('Error Penyetujuan Pencabutan')
            }
        });
    }

    if($('#hitungpendingdaftar').length) {
        var role = '{{Auth::user()->role}}'
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("admin.count.menu")}}',
            data: {
                'jenis' : 'pendaftaran',
                'role' : role,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(data) {
    
                if(data.success == true) {
                    if(data.result.length > 0) {
                        $('#hitungpendingdaftar').html(data.result.length)
                    }
                   
                }
            },
            error: function(request, status, error) {
                alert('Error Penyetujuan Pencabutan')
            }
        });
    }



    if($('#hitungpendingaju').length) {
        var role = '{{Auth::user()->role}}'
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("admin.count.menu")}}',
            data: {
                'role' : role,
                'jenis' : 'pengajuan',
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(data) {
                if(data.success == true) {
                    if(data.result.length > 0) {
                        $('#hitungpendingaju').html(data.result.length + data.result2.length)
                    }
                   
                }
            },
            error: function(request, status, error) {
                alert('Error Penyetujuan Pencabutan')
            }
        });
    }



    $('#caridigugel').click(function(){
        var lat = $('#tLat').val()
        var longi = $('#tLong').val()
        if (lat == '' || longi == '') {
            alert('Latitude dan Longitude Belum Diinput');
        } else {
            //var urel = "https://www.google.com/maps/place/7°42'17.1%22S+109°01'21.7%22E/@-7.7047348,109.020507,17z/data=!3m1!4b1!4m5!3m4!1s0x0:0x8dabc2dafa39bb92!8m2!3d-7.7047348!4d109.0226957?hl=id"
            //var html = '<div class="mapouter"><div class="gmap_canvas"><iframe width="600" height="500" id="gmap_canvas" src="https://maps.google.com/maps?q=Klinik%20Edsa&t=&z=13&ie=UTF8&iwloc=&output=embed" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe><a href="https://fmovies-online.net"></a><br><style>.mapouter{position:relative;text-align:right;height:500px;width:600px;}</style><a href="https://www.embedgooglemap.net">google maps on webpage</a><style>.gmap_canvas {overflow:hidden;background:none!important;height:500px;width:600px;}</style></div></div>'
            //var urel = 'https://maps.google.com/maps?z=12&t=m&q=loc:'+lat+'+'+longi;  
            //$('#gogelhasil').attr('src', urel);   
            //$('#cobadarigenerator').html(html)
            $('#hasilgoogle').modal('show')       
        }
    })


    function similarity(s1, s2) {
        var longer = s1;
        var shorter = s2;
        if (s1.length < s2.length) {
            longer = s2;
            shorter = s1;
        }
        var longerLength = longer.length;
        if (longerLength == 0) {
            return 1.0;
        }
        return (longerLength - editDistance(longer, shorter)) / parseFloat(longerLength);
    }

    function editDistance(s1, s2) {
        s1 = s1.toString().toLowerCase();
        s2 = s2.toString().toLowerCase();

        var costs = new Array();
        for (var i = 0; i <= s1.length; i++) {
            var lastValue = i;
            for (var j = 0; j <= s2.length; j++) {
            if (i == 0)
                costs[j] = j;
            else {
                if (j > 0) {
                var newValue = costs[j - 1];
                if (s1.charAt(i - 1) != s2.charAt(j - 1))
                    newValue = Math.min(Math.min(newValue, lastValue),
                    costs[j]) + 1;
                costs[j - 1] = lastValue;
                lastValue = newValue;
                }
            }
            }
            if (i > 0)
            costs[s2.length] = lastValue;
        }
        return costs[s2.length];
    }


    $('#submitPerpanjangan').click(function(){

        $('#cobali').show()


        var data = $('#formPerpanjangan').serialize();
        var form = $('#formPerpanjangan')[0];
        var dataform = new FormData(form);
        var currentTemplate = $('#tCurrentTemplateID').val()
        var currentSalinan = $('#tCurrentSalinanP').val()
        var isDokter = $(this).attr('data-dokter');
        var tanpasalinan = $('#tTanpaSalinan').val();
        console.log(currentSalinan+'_'+tanpasalinan)

        
 
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

                                    if (tgldoc_existing == obj.str_hingga & tgldoc_existing !== 'Seumur Hidup') {
                                        $('#validasimasaberlaku').val('Masa Berlaku Sama Dengan STR Sebelumnya')
                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                        $('#jikatanggalsama').show()
                                    } else {
                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                        $('#jikatanggalsama').hide()
                                    }

                                    if(hasilnama < 40) {
                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                        $('#jikanama').show()
                                    } else {
                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                        $('#jikanama').hide()
                                    }

                                    if(hasilkompetensi < 70) {
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
                                            if(tanpasalinan == '1') {
                                                $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                                $('#stSalinanPerpanjangan').val(obj.salinan)
                                                $('#stTemplateIDPerpanjangan').val(currentTemplate)
                                            } else {

                                                if(hasilnama > 40 && tgldoc_existing == 'Seumur Hidup') {

                                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                                    $('#stSalinanPerpanjangan').val(obj.salinan)
                                                    $('#stTemplateIDPerpanjangan').val(currentTemplate)

                                                } else {

                                                    if (obj.salinan != currentSalinan) {
                                                        alert('Salinan Yang Anda Upload Tidak Sama Dengan Salinan STR untuk Pengajuan Ini')
                                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                                    } else {
                                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                                        $('#stSalinanPerpanjangan').val(obj.salinan)
                                                        $('#stTemplateIDPerpanjangan').val(currentTemplate)
                                                    }

                                                }

                                            
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

                                Swal.fire('Profesi STR yang anda Upload Bukan Profesi Dokter')

                            } else {

                            $.ajax({
                                type: 'ajax',
                                method: 'get',
                                url: '{{ route("get.data.strdftr")}}',
                                data: {'thename': urlfix, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
                                async: false,
                                dataType: 'json',
                                success: function(data){

                                    

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

                                    if (tgldoc_existing == obj.str_hingga && tgldoc_existing != 'Seumur Hidup') {
                                        $('#validasimasaberlaku').val('Masa Berlaku Sama Dengan STR Sebelumnya')
                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                        $('#jikatanggalsama').show()
                                    } else {
                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                        $('#jikatanggalsama').hide()
                                    }

                                    if(hasilnama < 40) {
                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                        $('#jikanama').show()
                                    } else {
                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                        $('#jikanama').hide()
                                    }

                                    if(hasilkompetensi < 70) {
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
                                            if(tanpasalinan == '1') {
                                                $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                                $('#stSalinanPerpanjangan').val(obj.salinan)
                                                $('#stTemplateIDPerpanjangan').val(currentTemplate)
                                            } else {

                                                if(hasilnama > 40 && tgldoc_existing == 'Seumur Hidup') {

                                                    $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                                    $('#stSalinanPerpanjangan').val(obj.salinan)
                                                    $('#stTemplateIDPerpanjangan').val(currentTemplate)

                                                } else {

                                                    if (obj.salinan != currentSalinan) {
                                                        Swal.fire('Salinan Yang Anda Upload Tidak Sama Dengan Salinan STR untuk Pengajuan Ini')
                                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', true)
                                                    } else {
                                                        $('#SubmitPerpanjanganAfterValidation').attr('disabled', false)
                                                        $('#stSalinanPerpanjangan').val(obj.salinan)
                                                        $('#stTemplateIDPerpanjangan').val(currentTemplate)
                                                    }

                                                }

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

                                    

                                    //alert('bisa')
                                    
                                    
                                    
                                },
                                error: function(request, status, error){
                                    //alert(request.responseText);
                                }
                            });

                            }

                        }
                        
                    } else {

                        var filestr = response.filenamestr;
                            
                        var parent = $('#hasilnvstr').parent();
                        var newElement = "<embed src='{{ URL::to('/storageperpanjangan')}}/"+filestr+".pdf' id='hasilnvstr' width='100%' height='400px'>";
                        $('#hasilnvstr').remove();
                        parent.append(newElement);

                        var filenamestr = response.filenamestr
                        $('#stWhichnvDok').val(filenamestr)
                        if(isDokter == '1') {

                            Swal.fire({
                                title: 'STR Tidak Dapat Divalidasi Secara Otomatis, Apakah Anda Tetap Ingin Melanjutkan?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak',
                            }).then((result) => {
                                if (result.value == true) {
                                    $.fancybox.open({
                                        src: '#modal-nonvalidates-content',
                                        type: 'inline',
                                        touch: false,
                                        modal: true,
                                        clickSlide: false,
                                        afterShow: function() {
                                            $('.tutupdokternv').click(function() {
                                                $.fancybox.close();
                                            });
                                        }
                                    });
                                }
                            });

                        } else {

                            Swal.fire({
                                title: 'STR Tidak Dapat Divalidasi Secara Otomatis, Apakah Anda Tetap Ingin Melanjutkan?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak',
                            }).then((result) => {
                                if (result.value == true) {
                                    $.fancybox.open({
                                        src: '#modal-nonvalidatesnd-content',
                                        type: 'inline',
                                        touch: false,
                                        modal: true,
                                        clickSlide: false
                                    });
                                }
                            });
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

    
    $('#submitSTRDokter').click(function(){

        $('#cobali').show()
        var data = $('#formUploadSTRDokter').serialize();
        var form = $('#formUploadSTRDokter')[0];
        var dataform = new FormData(form);
        var reqsalinan = $('#tRequestedSalinanDok').val()
        var kompetensi_existing = $('#tcurrentkompetensiDok').val()
        var existingnoreg = $('#tcurrentnostrDok').val()
        var nama_existing = $('#tcurrentNamaStrDok').val()
        var ismanual = $('#tismanualstr').val()
        
        var result = '';

        if ($('#tFileSTRDok')[0].files.length === 0) {
            alert('Silahkan Attach File PDF');
        } else {
            result += '1';

        }

        if (result == '1') {

            if(ismanual == 0) {

                $('#lanjutuploaddokter')[0].reset();
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("dokter.submit.str")}}', 
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
                            $('#stSalinanDok').val(reqsalinan)
                            var urlnye = response.dataextraction.thelink;
                            var originfile = response.dataextraction.thefilename;
                            var urlfix = urlnye.replace('http:', 'https:')
                            //var urlfix = urlnye;
                            $('#stURL').val(urlfix)
                            $('#hasilscanuploaddokter').show()
                            $('#hasilframeddokter').attr('src', urlfix)
                            var iscekdokter = false;

                            var isCheckStr = urlfix.includes('cek_str')
                            var thelinker = 0;
                            
                            iscekdokter = urlfix.includes('cekdokter')
                            if (iscekdokter == true) {
                                urlfix = urlnye;
                                thelinker = 2;

                                $.ajax({
                                    type: 'ajax',
                                    method: 'get',
                                    url: '{{ route("get.data.strdftr")}}',
                                    data: {'thename': urlfix, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
                                    async: false,
                                    dataType: 'json',
                                    success: function(data){

                                        var urlfixed = urlfix.replace('http:', 'https:')

                                        var obj = jQuery.parseJSON(data)

                                        console.log(obj.no_reg)

                                        var nama_existing = $('#tcurrentNamaStrDok').val()
                                        var kompetensi_existing = $('#tcurrentkompetensiDok').val()
                                        var tgldoc_existing = $('#tcurrenthinggaDok').val()

                                        if(obj.salinan == '') {
                                            alert('Tidak Dapat Memvalidasi STR (Salinan Tidak Terbaca)')
                                        } else if(obj.salinan != reqsalinan) {

                                            alert('Salinan STR yang diupload tidak sesuai dengan Direquest (Salinan '+reqsalinan+')')

                                        } else {

                                            var comparenama = similarity(obj.nama_nakes, nama_existing)
                                            var comparekompetensi = similarity(obj.kompetensi, kompetensi_existing)
                                            var comparenoreg = similarity(obj.no_reg, existingnoreg)
                                            var hasilnoreg = Math.round(comparenoreg*100)
                                            var hasilkompetensi = Math.round(comparekompetensi*100)
                                            var hasilnama = Math.round(comparenama*100)

                            

                                            var htmlcocoknama = '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'+hasilnama+'" aria-valuemin="0" aria-valuemax="100" style="width: '+hasilnama+'%">'

                                            $('#cocoknamabardok').html(htmlcocoknama)
                                            $('#cocoknamavaluedok').html(hasilnama+'% Kecocokan')

                                            var htmlcocokkompetensi = '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'+hasilkompetensi+'" aria-valuemin="0" aria-valuemax="100" style="width: '+hasilkompetensi+'%">'

                                            $('#cocokkompetensibardok').html(htmlcocokkompetensi)
                                            $('#cocokkompetensivaluedok').html(hasilkompetensi+'% Kecocokan')

                                            
                                            if(hasilnama < 40) {
                                                $('#SubmitDokterAfterValidation').attr('disabled', true)
                                                $('#jikanamadok').show()
                                            } else {
                                                $('#SubmitDokterAfterValidation').attr('disabled', false)
                                                $('#jikanamadok').hide()
                                            }

                                            if(hasilkompetensi < 95) {
                                                $('#jikabedakompetensidok').show()
                                                $('#stKompetensiBedadok').val('1')
                                            } else {
                                                $('#jikabedakompetensidok').hide()
                                                $('#stKompetensiBeda').val('0')
                                            }

                                            $('#stWhichFDok').val(originfile);
                                            $('#stNamaDok').val(obj.nama_nakes)
                                            $('#stNoSTRDok').val(obj.no_reg)
                                            $('#stSTRtetapSIPDok').val(obj.str_keluar_sip)
                                            $('#stSTRHinggaSIPDok').val(obj.str_hingga_sip)
                                            $('#stKompetensiDok').val(obj.kompetensi)
                                            $('#lodaing').hide();
                                            $('#stUrlCodeDok').val(urlfixed)
                                            $('#DokterStrModal').modal('show')

                                        }

                                    
                                        
                                    },
                                    error: function(request, status, error){
                                        //alert(request.responseText);
                                    }
                                });
                            } else {
                                thelinker = 0;
                                alert('STR yang anda upload Bukan STR Profesi DOKTER! Mohon Dicek Kembali')
                            }
                
                            
                        } else { 


                            

                            //alert(response.keterangan)
                            Swal.fire({
                                title: 'STR Tidak Dapat Divalidasi Secara Otomatis, Apakah Anda Tetap Ingin Melanjutkan?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Ya',
                                cancelButtonText: 'Tidak',
                            }).then((result) => {
                                if (result.value == true) {
                                    $.ajax({
                                        type: 'ajax',
                                        method: 'post',
                                        url: '{{ route("nakes.skip.validasistr")}}',
                                        data: {'id_nakes': id_nakes, 'salinan' : reqsalinan, 'filenamestr' : filenamestr,  _token: "{{ csrf_token() }}"},
                                        dataType: 'json',
                                        success: function(data){

                                            if(data.success == true) {
                                                
                                                $.fancybox.open({
                                                    src: '#modal-nonvalidate-content',
                                                    type: 'inline',
                                                    touch: false,
                                                    modal: true,
                                                    clickSlide: false
                                                });

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

            } else {

                //$('#lanjutuploaddokter')[0].reset();

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
                            if(thelink != '') {
                                $('#sturlqrmanualdok').val(thelink)
                            }
                            $('#stWhichFManualDok').val(originfile);

                            var hasilsource = "";
                            var parent = $('#hasiluploadstrmanual').parent();
                            var newElement = "<embed src='{{ URL::to('/storage')}}/"+originfile+".pdf' id='hasiluploadstrmanual' width='100%' height='400px'>";
                            $('#hasiluploadstrmanual').remove();
                            parent.append(newElement);

                            if (response.success_extract == true) {
                                var issalinan = response.resultword.salinan
                                issalinan = String(issalinan.replace(/\D/g, '').split(''));
                                if(issalinan != '') {
                                    if(issalinan != reqsalinan) {
                                        alert('STR Salinan Yang diupload tidak sesuai dengan permintaan. Salinan Yang diminta: ' +reqsalinan+', STR Salinan Diupload: '+issalinan)
                                    } else {
                                        $('#stSalinanManual').val(issalinan)
                                        $.fancybox.open({
                                            src: '#modal-strmanual-content',
                                            type: 'inline',
                                            touch: false,
                                            modal: true,
                                            clickSlide: false
                                        });
                                    }
                                } else {

                                    alert('Sistem Tidak Dapat Mendeteksi Nomor Salinan Pada STR yang diupload')

                                    $.fancybox.open({
                                        src: '#modal-strmanual-content',
                                        type: 'inline',
                                        touch: false,
                                        modal: true,
                                        clickSlide: false
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

            

        }



    })


    $('#submitSTRNonDokter').click(function(){

        $('#cobali').show()


        var data = $('#formUploadSTRnonDokter').serialize();
        var form = $('#formUploadSTRnonDokter')[0];
        var dataform = new FormData(form);
        var reqsalinan = $('#tRequestedSalinannonDok').val()
        var kompetensi_existing = $('#tcurrentkompetensinonDok').val()
        var existingnoreg = $('#tcurrentnostrnonDok').val()
        var nama_existing = $('#tcurrentNamaStrnonDok').val()

        var result = '';

        if ($('#tFileSTRnonDok')[0].files.length === 0) {
            alert('Silahkan Attach File PDF');
        } else {
            result += '1';

        }

        if (result == '1') {

            $('#lanjutuploadnondokter')[0].reset();

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("nondokter.submit.str")}}',
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

                    //console.log(response)
                
                    
                    if (response.success == true) {
                        $('#stSalinannonDok').val(reqsalinan)
                        var urlnye = response.dataextraction.thelink;
                        var originfile = response.dataextraction.thefilename;
                        var urlfix = urlnye.replace('http:', 'https:')
                        //var urlfix = urlnye;
                        $('#stURLnondok').val(urlfix)
                        $('#hasilscanuploadnondokter').show()
                        $('#hasilframednondokter').attr('src', urlfix)
                        var iscekdokter = false;

                        var isCheckStr = urlfix.includes('cek_str')
                        var thelinker = 0;
                        if (isCheckStr == true) {
                            thelinker = 1;
                        }
                        
                        $.ajax({
                            type: 'ajax',
                            method: 'get',
                            url: '{{ route("get.data.strdftr")}}',
                            data: {'thename': urlfix, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
                            async: false,
                            dataType: 'json',
                            success: function(data){

                                var urlfixed = urlfix.replace('http:', 'https:')

                                var obj = jQuery.parseJSON(data)

                                console.log(obj)

                                var nama_existing = $('#tcurrentNamaStrnonDok').val()
                                var kompetensi_existing = $('#tcurrentkompetensinonDok').val()
                                var tgldoc_existing = $('#stDueOrinonDok').val()

                                

                                var comparenama = similarity(obj.nama_nakes, nama_existing)
                                var comparekompetensi = similarity(obj.kompetensi, kompetensi_existing)
                                var comparenoreg = similarity(obj.no_reg, existingnoreg)
                                var hasilnoreg = Math.round(comparenoreg*100)
                                var hasilkompetensi = Math.round(comparekompetensi*100)
                                var hasilnama = Math.round(comparenama*100)

                                console.log(hasilnama)

                                var htmlcocoknama = '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'+hasilnama+'" aria-valuemin="0" aria-valuemax="100" style="width: '+hasilnama+'%">'

                                $('#cocoknamabarnondok').html(htmlcocoknama)
                                $('#cocoknamavaluenondok').html(hasilnama+'% Kecocokan')

                                var htmlcocokkompetensi = '<div class="progress-bar bg-green" role="progressbar" aria-valuenow="'+hasilkompetensi+'" aria-valuemin="0" aria-valuemax="100" style="width: '+hasilkompetensi+'%">'

                                $('#cocokkompetensibarnondok').html(htmlcocokkompetensi)
                                $('#cocokkompetensivaluenondok').html(hasilkompetensi+'% Kecocokan')

                                

                                if(hasilnama < 40) {
                                    $('#SubmitnonDokterAfterValidation').attr('disabled', true)
                                    $('#jikanamanondok').show()
                                } else {
                                    $('#SubmitnonDokterAfterValidation').attr('disabled', false)
                                    $('#jikanamanondok').hide()
                                }

                                if(hasilkompetensi < 95) {
                                    $('#jikabedakompetensinondok').show()
                                    $('#stKompetensiBedanondok').val('1')
                                } else {
                                    $('#jikabedakompetensinondok').hide()
                                    $('#stKompetensiBedanondok').val('0')
                                }

                                
                                $('#stWhichFnonDok').val(originfile);
                                $('#stNamanonDok').val(obj.nama_nakes)
                                $('#stNoSTRnonDok').val(obj.no_reg)
                                $('#stSTRtetapSIPnonDok').val(obj.str_keluar_sip)
                                $('#stSTRHinggaSIPnonDok').val(obj.str_hingga_sip)
                                $('#stKompetensinonDok').val(obj.kompetensi)
                                $('#lodaing').hide();
                                $('#stUrlCodenonDok').val(urlfixed)
                                $('#nonDokterStrModal').modal('show')
                                
                            },
                            error: function(request, status, error){
                                //alert(request.responseText);
                            }
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


    $('#updateSTRNonDokter').click(function(){

        $('#cobali').show()


        var data = $('#formUploadSTRnonDokter').serialize();
        var form = $('#formUploadSTRnonDokter')[0];
        var dataform = new FormData(form);
        var reqsalinan = $('#tRequestedSalinannonDok').val()
        var kompetensi_existing = $('#tcurrentkompetensinonDok').val()
        var existingnoreg = $('#tcurrentnostrnonDok').val()
        var nama_existing = $('#tcurrentNamaStrnonDok').val()
        var exiting_url_ = $('#tcurrenurlstr').val()
        var exiting_url = exiting_url_.replace('http:', 'https:')
        var id_nakes = $(this).attr('data-idnakes')
        $('#stUserIDNakesnonDokU').val(id_nakes)
        $('#stSalinannonDokU').val(reqsalinan)

        

        var result = '';

        if ($('#tFileSTRnonDok')[0].files.length === 0) {
            Swal.fire('Silahkan Attach File PDF');
        } else {
            result += '1';

        }

        if (result == '1') {

            $('#lanjutuploadnondokter')[0].reset();

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("nondokter.update.str")}}',
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
                    var filenamestr = response.filenamestr;
                    if (response.success == true) {
                        $('#stSalinannonDok').val(reqsalinan)
                        var urlnye = response.dataextraction.thelink;
                        var originfile = response.dataextraction.thefilename;
                        var urlfix = urlnye.replace('http:', 'https:')
                        //var urlfix = urlnye;
                        $('#stURLnondok').val(urlfix)
                        $('#hasilframeupdate').attr('src', urlfix)
                        var iscekdokter = false;

                        var isCheckStr = urlfix.includes('cek_str')
                        var thelinker = 0;
                        if (isCheckStr == true) {
                            thelinker = 1;
                        }

                        if(exiting_url != urlfix) {
                            Swal.fire('STR yang anda Upload Tidak Sama Dengan Sebelumnya')
                        } else {

                            $('#lodaing').hide();
                            $('#updateNakesStrModal').modal('show')
                            $('#stNewFilename').val(response.newfilename)
                            $('#hasilscanupdateSTR').show()

                            var filebaru = response.newfilename;
                            var parent = $('#lihatupdatedSTR').parent();
                            var newElement = "<embed src='{{ URL::to('/storage')}}/"+filebaru+".pdf' id='lihatupdatedSTR' width='100%' height='500px'>";
                            $('#lihatupdatedSTR').remove();
                            parent.append(newElement);
                        

                        }
                        
                    } else {
                        //alert(response.keterangan)
                        Swal.fire({
                            title: 'STR Tidak Dapat Divalidasi Secara Otomatis, Apakah Anda Tetap Ingin Melanjutkan?',
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Ya',
                            cancelButtonText: 'Tidak',
                        }).then((result) => {
                            if (result.value == true) {

                                $.ajax({
                                    type: 'ajax',
                                    method: 'post',
                                    url: '{{ route("nakes.skip.validasistr")}}',
                                    data: {'id_nakes': id_nakes, 'salinan' : reqsalinan, 'filenamestr' : filenamestr,  _token: "{{ csrf_token() }}"},
                                    dataType: 'json',
                                    success: function(data){
                                        console.log(data)
                                        if(data.success == true) {
                                            Swal.fire('Sukses!', '', 'success')
                                            window.location.href = "{{route('nakes.dashboard')}}";
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

    $('.viewDocNakes').click(function(){
        
        var originfile = $(this).attr('data-namafile');
        var jenisdoc = $(this).attr('data-jenis');
        var parent = $('#lihatDokumentNakes').parent();

        if(jenisdoc == 'ktp')
        {
            var id_nakes = $(this).attr('data-user')
            var id_doc = $(this).attr('data-id')
            console.log(id_doc)

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.maindok.nakes")}}',
                data: {'id_doc': id_doc, 'id_nakes' : id_nakes, 'jenis_doc' : jenisdoc, _token: "{{ csrf_token() }}"},
                dataType: 'json',
                success: function(data){
                    console.log(data)
                    if(data.success == true) {
                        var nama_doc = data.result.nama_doc
                        var no_doc = data.result.no_doc
                        var ttl = data.result.remark4
                        var tlahir = data.result.tgl_doc
                        var alamat = data.result.remark1
                        var kecamatan = data.result.remark2 
                        var kabupaten = data.result.remark3
                        var alamatdom = data.result.remark5
                        var kecamatandom = data.result.remark6 
                        var kabupatendom = data.result.remark7
                        var domi = ''
                        if(data.result.url_qr == 'K')
                        {
                            domi += `<strong>Alamat Domisili Sesuai KTP</strong>`
                        } else {
                            domi += `<div class="row">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Alamat KTP *</label>
                                        <textarea type="text" class="form-control" readonly>${alamatdom}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                        <input type="text" class="form-control" value="${kabupatendom}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                        <input type="text" class="form-control" value="${kecamatandom}" readonly>
                                    </div>
                                </div>
                            </div> `

                        }
                        var html = `
                            <div class="row">
                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <div class="autocomplete">
                                        <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                        <input type="text" value="${nama_doc}" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Nomor KTP *</label>
                                        <input type="text" class="form-control" value="${no_doc}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Tempat Lahir *</label>
                                        <input type="text" class="form-control" value="${ttl}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Tanggal Lahir</label>
                                        <input type="text" class="form-control" value="${tlahir}" readonly>
                                    </div>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-12" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Alamat KTP *</label>
                                        <textarea type="text" class="form-control" readonly>${alamat}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                        <input type="text" class="form-control" value="${kabupaten}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                        <input type="text" class="form-control" value="${kecamatan}" readonly>
                                    </div>
                                </div>
                            </div> 
                            `+domi
                        Swal.fire({
                            title: "<strong>Data KTP</strong>",
                            html: html,
                            showCloseButton: true,
                            focusConfirm: false
                        });
                        
                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal Mendapatkan Data KTP Anda',
                        })

                    }
                    
                    
                },
                complete: function(){
                    
                },
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });

        } else {

            if (jenisdoc == 'str') {
                var newElement = "<embed src='{{ URL::to('/storage')}}/"+originfile+".pdf' id='lihatDokumentNakes' width='100%' height='400px'>";
            } else {
                var newElement = "<embed src='{{ URL::to('/storageup')}}/"+originfile+"' id='lihatDokumentNakes' width='100%' height='400px'>";
            }
            $('#lihatDokumentNakes').remove();
            parent.append(newElement);
            $('#lihatdocModal').modal('show');

        }
        
    })


    tabled = $('#historyapprovedinkes').DataTable({ 
      
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "searching": false,
      scrollResize: true,
      scrollY: 500,
      scrollCollapse: true,
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "{{route('get.histori.tinjauajuan')}}",
          "type": "POST",
          "data": function ( data ) {
              data.nama_nakes = $('#searchnamanakesd').val();
              data.lokasi = $('#searchlokasid').val();
              data.nostr = $('#searchSTRd').val();
              data.startdate = $('#searchstartdated').val();
              data.enddate = $('#searchenddated').val();
              data._token = "{{ csrf_token() }}";
          }
      },

      "lengthMenu": [
            [10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, "All"]
        ],

      dom: 'Blfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],

      //Set column definition initialisation properties.
      "columnDefs": [
      { 
          "targets": [ 0 ], //first column / numbering column
          "orderable": false, //set not orderable
      },
      ],

      });


      tableop = $('#historyapprovedop').DataTable({ 
      
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "searching": false,
      scrollResize: true,
      scrollY: 500,
      scrollCollapse: true,
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "{{route('get.histori.tinjauajuanop')}}",
          "type": "POST",
          "data": function ( data ) {
              data.nama_nakes = $('#searchnamanakes').val();
              data.lokasi = $('#searchlokasi').val();
              data.nostr = $('#searchSTR').val();
              data.startdate = $('#searchstartdate').val();
              data.enddate = $('#searchenddate').val();
              data._token = "{{ csrf_token() }}";
          }
      },

      "lengthMenu": [
            [10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, "All"]
        ],

      dom: 'Blfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],

      //Set column definition initialisation properties.
      "columnDefs": [
      { 
          "targets": [ 0 ], //first column / numbering column
          "orderable": false, //set not orderable
      },
      ],

      });

      $('#btn-filter').click(function(){
        var nama_nakes = $('#searchnamanakes').val();
        var lokasi = $('#searchlokasi').val();
        var nostr = $('#searchSTR').val();
        var startdate = $('#searchstartdate').val();
        var enddate = $('#searchenddate').val();

        if ($.trim(nama_nakes) == '' && $.trim(lokasi) == '' && $.trim(enddate) == '' && $.trim(startdate) == '' && nostr == ''){
            Swal.fire('Mohon Isikan Salah Satu Kategori Pencarian');
        } else {
            tabled.ajax.reload();
            
        }
      
      });

      $('#btn-reset').click(function(){ //button reset event click
        $('#form-filter')[0].reset();
        tabled.ajax.reload();  //just reload table
      });


      
      table = $('#historyapprovedptsp').DataTable({ 
      
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "searching": false,
      scrollResize: true,
      scrollY: 500,
      scrollCollapse: true,
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "{{route('get.histori.tinjauajuan')}}",
          "type": "POST",
          "data": function ( data ) {
              data.nama_nakes = $('#searchnamanakesp').val();
              data.lokasi = $('#searchlokasip').val();
              data.nostr = $('#searchSTRp').val();
              data.startdate = $('#searchstartdatep').val();
              data.enddate = $('#searchenddatep').val();
              data._token = "{{ csrf_token() }}";
          }
      },

      "lengthMenu": [
            [10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, "All"]
        ],

      dom: 'Blfrtip',
        buttons: [
            //'csv', 'excel', 'pdf'
            {
                extend: 'csv',
                text: 'CSV',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            },
            {
                extend: 'pdf',
                text: 'PDF',
                exportOptions: {
                    modifier: {
                        page: 'all'
                    }
                }
            }
        ],

        

      //Set column definition initialisation properties.
      "columnDefs": [
      { 
          "targets": [ 0 ], //first column / numbering column
          "orderable": false, //set not orderable
      },
      ],

    });


      tableapp = $('#tblpendaftarhistx').DataTable({ 
      
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "searching": false,
      scrollResize: true,
      scrollY: 500,
      scrollCollapse: true,
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "{{route('get.histori.approvenakes')}}",
          "type": "POST",
          "data": function ( data ) {
              data.nama_nakes = $('#searchnamanakesapp').val();
              data.kompetensi = $('#searchkompetensi').val();
              data.nostr = $('#searchSTRapp').val();
              data.email = $('#searchemail').val();
              data.notelp = $('#searchnohp').val();
              data._token = "{{ csrf_token() }}";
          }
      },

      "lengthMenu": [
            [10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, "All"]
        ],

      dom: 'Blfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],

        

      //Set column definition initialisation properties.
      "columnDefs": [
      { 
          "targets": [ 0 ], //first column / numbering column
          "orderable": false, //set not orderable
      },
      ],

    });

      $('#btn-filterp').click(function(){
        var nama_nakes = $('#searchnamanakes').val();
        var lokasi = $('#searchlokasi').val();
        var nostr = $('#searchSTR').val();
        var startdate = $('#searchstartdate').val();
        var enddate = $('#searchenddate').val();

        if ($.trim(nama_nakes) == '' && $.trim(lokasi) == '' && $.trim(enddate) == '' && $.trim(startdate) == '' && nostr == ''){
            Swal.fire('Mohon Isikan Salah Satu Kategori Pencarian');
        } else {
            table.ajax.reload();
            
        }
      
      });

      $('#btn-filterdftr').click(function(){
        var nama_nakes = $('#searchnamanakesapp').val();
        var kompetensi = $('#searchkompetensi').val();
        var nostr = $('#searchSTRapp').val();
        var email = $('#searchemail').val();
        var notelp = $('#searchnohp').val();

        if ($.trim(nama_nakes) == '' && $.trim(kompetensi) == '' && $.trim(notelp) == '' && $.trim(email) == '' && nostr == ''){
            Swal.fire('Mohon Isikan Salah Satu Kategori Pencarian');
        } else {
            tableapp.ajax.reload();
            
        }
      
      });

      $('#btn-resetp').click(function(){ //button reset event click
        $('#form-filter-p')[0].reset();
        table.ajax.reload();  //just reload table
      });

      $('#btn-resetdftr').click(function(){ //button reset event click
        $('#form-filter-dftr')[0].reset();
        tableapp.ajax.reload();  //just reload table
      });

      

      $('#btnUbahPass').click(function(){
        $.fancybox.open({
            src: '#modal-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false,
            afterShow: function() {
                $('#close-modal').click(function() {
                    $.fancybox.close();
                });
            }
        });
      })

      $('.btnmanagefaskes').click(function(){
          var jenis = $(this).attr('data-jenis');
          var id_faskes = $(this).attr('data-id');
          var nama_faskes = $(this).attr('data-nama')
          var alamat_faskes = $(this).attr('data-alamat')
          var kecamatan_faskes = $(this).attr('data-kecamatan')
          var kabupaten_faskes = $(this).attr('data-kabupaten')
          var latitude = $(this).attr('data-latitude')
          var longitude = $(this).attr('data-longitude')
          var remark = $(this).attr('data-remark')
          var notelp = $(this).attr('data-notelp')
          var jamkerja = $(this).attr('data-jk')

          $('#jenissubmitfasyankes').val(jenis)

          if(jenis == 'add') {
              $('#submitfaskesbaru').show()
              $('#submitubahfaskes').hide()
          } else {
            $('#submitfaskesbaru').hide()
            $('#submitubahfaskes').show()
            $('#idfaskyankes').val(id_faskes)
            $('#namafasyankes').val(nama_faskes)
            $('#noijinfasyankes').val(remark)
            $('#alamatfasyankes').val(alamat_faskes)
            $('#kecfasyankes').val(kecamatan_faskes)
            $('#kabfasyankes').val(kabupaten_faskes)
            $('#latfasyankes').val(latitude)
            $('#longfasyankes').val(longitude)
            $('#notelpfasyankes').val(notelp)
            $('#jkfasyankes').val(jamkerja)

          }
            $.fancybox.open({
                src: '#modal-faskes-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('#close-faskes-modal').click(function() {
                        $.fancybox.close();
                    });
                }
            });
    })


    $('#tblpendaftarhist').on('click','.resetnakespass', function(){
          var nakes_id = $(this).attr('data-id')
          var nama_nakes = $(this).attr('data-nama')
          var notelp = $(this).attr('data-notelp')
          $('#judulreset').html('<h4>Reset Password Nakes : '+nama_nakes+'</h4>')
          $('#resetnakes_id').val(nakes_id)
          $('#resetnakes_nama').val(nama_nakes)
          $('#resetnakes_notelp').val(notelp)
          console.log(notelp)
        $.fancybox.open({
            src: '#modal-reset-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false,
            afterShow: function() {
                $('#close-reset-modal').click(function() {
                    $.fancybox.close();
                });
            }
        });
      })

      $('.intippass').click(function() {
        var parentDiv = $(this).parent();
        var siblingDiv = parentDiv.prev();
        var siblingId = siblingDiv.attr('id');
        var passwordInput = $('#'+siblingId);
        var icon = $(this).children();

        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('fas fa-eye');
            icon.addClass('fas fa-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('fas fa-eye-slash');
            icon.addClass('fas fa-eye');
        }
    });

    $('#submitubahpassnakes').click(function(){
        var newpass = $('#newpassword').val()
        var newpassc = $('#newpasswordc').val()
        var id_user = $(this).attr('data-id')
        if(newpass != newpassc) {
            Swal.fire('Password Yang Diinputkan Tidak Sama!')
        } else {
            if (newpass.length < 8) {
                Swal.fire('Password Minimal 8 Karakter!')
            } else {
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("nakes.update.pass")}}',
                    data: {'newpass': newpass, 'id_user': id_user, _token: "{{ csrf_token() }}"},
                    async: false,
                    dataType: 'json',
                    success: function(data){

                        if(data.success == true) {
                            $.fancybox.close();
                            Swal.fire(data.keterangan)
                        } else {
                            Swal.fire(data.keterangan)
                        }
                    },
                    error: function(request, status, error) {
                        alert(request.responseText);
                        $('#cobali').hide()
                    }
                });



            }
        }
    })

    $('#submitresetpassnakes').click(function(){

        var newpass = $('#resetpasswordnakes').val()
        var newpassc = $('#resetpasswordnakesc').val()
        var id_user = $('#resetnakes_id').val()
        var nama = $('#resetnakes_nama').val()
        var nomor = $('#resetnakes_notelp').val()
        if(newpass != newpassc) {
            Swal.fire('Password Yang Diinputkan Tidak Sama!')
        } else {
            if (newpass.length < 8) {
                Swal.fire('Password Minimal 8 Karakter!')
            } else {
                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("nakes.reset.pass")}}',
                    data: {'newpass': newpass, 'id_user': id_user, 'nama' : nama, 'nomor' : nomor,  _token: "{{ csrf_token() }}"},
                    async: false,
                    dataType: 'json',
                    success: function(data){

                        if(data.success == true) {
                            $.fancybox.close();
                            alert(data.keterangan)
                        } else {
                            alert(data.keterangan)
                        }
                    },
                    error: function(request, status, error) {
                        alert(request.responseText);
                        $('#cobali').hide()
                    }
                });



            }
        }

    })

    ///calendar
    if($('#calendar').length){

        var id_nakes = $('#calendar').attr('data-id');
        function addeventnakes(date){
            $("td[data-day='"+date+"']").addClass('visitasi');
        }

        // $.ajax({
        //     type: 'ajax',
        //     method: 'get',
        //     url: '{{ route("get.all.visitasi")}}',
        //     data: {'id_nakes': id_nakes, _token: "{{ csrf_token() }}"},
        //     async: false,
        //     dataType: 'json',
        //     success: function(data){

        //         var html = '';
        //         if(data.visitasi.length < 1) {
        //             html = 'Tidak Ada Data Visitasi'
        //         }

        //         if(data.success == true) {
        //             for (i = 0; i < data.visitasi.length; i++) {
        //                 var isvisitasi = data.visitasi[i].tgl_visitasi
        //                 var parts = isvisitasi.split("-");
        //                 var formattedDate = parts[2] + "/" + parts[1] + "/" + parts[0];
        //                 addeventnakes(formattedDate)

        //                 html +=''
        //             }
                    
        //         } else {
                    
        //         }
        //     },
        //     error: function(request, status, error) {
        //         alert(request.responseText);
        //         $('#cobali').hide()
        //     }
        // });
       
        $('#calendar').datetimepicker({
            format: 'L',
            inline: true
            });

        $('#calendar').on('change.datetimepicker', function (e) {
            
            console.log(e.date.format('YYYY-MM-DD'));
            addeventnakes('05/29/2023')
            
        });

        addeventnakes('05/29/2023')
        
    }



    $('#editpengaju').click(function(){

        $.fancybox.open({
            src: '#modal-ubahpengaju-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false,
            afterShow: function() {
                $('#close-ubahpengaju-modal').click(function() {
                    $.fancybox.close();
                });
            }
        });
    })


    $('#updatedatapengaju').click(function(){


        var id_nakes = $('#eIdNakes').val()
        var id_pengajuan = $('#eIdPengajuan').val()
        var alamatpengaju = $('#ePengajuAlamat').val()
        var kecamatanpengaju = $('#ePengajuAlamatKec').val()
        var kabupatenpengaju = $('#ePengajuAlamatKab').val()
        var alamatpengajuanbefore = $('#ePengajuanAlamatBefore').val()
        var kecamatanpengajuanbefore = $('#ePengajuanAlamatKecBefore').val()
        var kabupatenpengajuanbefore = $('#ePengajuanAlamatKabBefore').val()
        var updater = $('#eIDUpdater').val()
        var salinan = $('#eSalinanNakes').val()
        var namaesip = $('#ePengajuNama').val()
        var profesiesip = $('#ePengajuProfesi').val()
        var alamatpengajuanafter = $('#ePengajuanAlamat').val()
        var kecamatanpengajuanafter = $('#ePengajuanAlamatKec').val()
        var kabupatenpengajuanafter = $('#ePengajuanAlamatKab').val()
        var nottkafter = $('#ePengajuNoTTK').val()
        var nottkbefore = $('#ePengajuNoTTKBefore').val()
        var template_id = $('#ePengajuTemplateSIP').val()
        var templatebefore = $('#eTemplateBefore').val()
        var ispengajuanfaskes = $('#ePengajuanFaskes').val()
        var tempat_lahir = $('#ePengajuTmptLahir').val()
        var isintern = '0';
        var tgldocintern = '0';
        var kompetensi = $('#ePengajuKompetensi').val()

        if($('#tgldocintern').length) {
            isintern = '1';
            tgldocintern = $('#tgldocintern').val()
        }
        
        
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '{{ route("ptsp.update.pengaju")}}',
            data: {'id_nakes': id_nakes, 'id_pengajuan': id_pengajuan,
            'alamatpengaju' : alamatpengaju, 'kecamatanpengaju' : kecamatanpengaju, 'kabupatenpengaju' : kabupatenpengaju, 'alamatpengajuanbefore': alamatpengajuanbefore, 'kecamatanpengajuanbefore': kecamatanpengajuanbefore, 'kabupatenpengajuanbefore' : kabupatenpengajuanbefore, 'nottkbefore' : nottkbefore, 'templatebefore': templatebefore, 'updater':updater, 'salinan':salinan, 'namaesip' : namaesip, 'profesiesip': profesiesip, 'alamatpengajuanafter' : alamatpengajuanafter, 'kecamatanpengajuanafter' : kecamatanpengajuanafter, 'kabupatenpengajuanafter' : kabupatenpengajuanafter,  'nottkafter' : nottkafter, 'template_id' : template_id, 'ispengajuanfaskes' : ispengajuanfaskes, 'tempat_lahir' : tempat_lahir, 'isintern' : isintern, 'tgldocintern': tgldocintern, 'kompetensi' : kompetensi, _token: "{{ csrf_token() }}"},
            cache:false,
            dataType: 'json',
            beforeSend: function(){

                $('#ovdetailpengaju').show()
                
            },
            success: function(data){
                
                $('#ovdetailpengaju').hide()
                if(data.success == true) {
                    $.fancybox.close();
                    $('#namasippengaju').html(namaesip)
                    $('#alamatpengaju').html(alamatpengaju+', '+kecamatanpengaju+', '+kabupatenpengaju)
                    var isfas = $('#eIsFaskes').val()
                    if(isfas == '0') {
                        $('#tAlamatPengajuanM').val(alamatpengajuanafter)
                        $('#tKabupatenM').val(kabupatenpengajuanafter)
                        $('#tKecamatanM').val(kecamatanpengajuanafter)
                    }
                    alert(data.keterangan)
                    location.reload()
                } else {
                    alert(data.keterangan)
                }
            },
            error: function(request, status, error) {
                $('#ovdetailpengaju').hide()
                alert(request.responseText);
                $('#cobali').hide()
            }
        });

    })

    if($('#tbllistperubahan').length) {
        var datatableperubahan = $('#tbllistperubahan').DataTable();
    }
    if($('#tblpendaftar').length) {
        var datatablependaftaran = $('#tblpendaftar').DataTable();
    }
    if($('#tbllistpengajuan').length) {
        var datatablependaftaran = $('#tbllistpengajuan').DataTable();
    }

    $('#hapuspengajuannakes').click(function(){

        var id_pengajuan = $(this).attr('data-id');

        if (confirm("Apakah Anda Yakin Menghapus Pengajuan Ini?") == true) {

            

        }
        
        
    })
    var tabularnakesonfaskes = $('#mlistallnakesonfaskes').DataTable();
    var tabularrekapnakesfaskes = $('#mpersebaranprofesinakesfaskes').DataTable();

    function rekapnakesfaskes(id_faskes) {

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("get.rekapnakesfaskes")}}',
            data: {'id_faskes': id_faskes, _token: "{{ csrf_token() }}"},
            dataType: 'json',
            beforeSend: function(){

                
                $.fancybox.open({
                    src: '#modal-tunggukadinkes-content',
                    type: 'inline',
                    touch: false,
                    clickSlide: false, // Prevent closing by sliding on touch devices
                    clickOutside: 'close', // Enables closing the modal when clicking outside
                });

                
                $('#loaddetailnakesfaskes').show()

            },
            success: function(data){
                console.log(data)
                $.fancybox.close()
                $('#loaddetailnakesfaskes').hide()
                $('#detailnakespadafaskes').modal('show')
                if(data.success == true) {
                    $('#juduldetailfaskes').html()
                    tabularnakesonfaskes.clear().draw();
                    tabularnakesonfaskes.rows.add(data.result2.map(function(row,index) {
                        var fotoUrl = "{{ URL::to('/storagefoto')}}/" + row.foto_nakes;
                        row.foto_url = '<img src="' + fotoUrl + '" alt="Image" width="50px">';
                        return [
                            index + 1, 
                            row.foto_url,
                            row.nama_nakes,
                            row.profesi,
                            row.status_terakhir,
                            row.tgl_doc,
                        ];
                    })).draw();

                    tabularrekapnakesfaskes.clear().draw();
                    tabularrekapnakesfaskes.rows.add(data.result1.map(function(row,index) {
                        var pembagian = row.totala+' / '+row.totalb;
                        row.pembagian = pembagian;
                        return [
                            index + 1, 
                            row.profesi,
                            row.pembagian,
                        ];
                    })).draw();


                }
            },
            error: function(request, status, error){
                $.fancybox.close()
                alert(request.responseText);
            }
        });

    }

    $('#tabelfaskesmanage').on('click','.btndetailfaskes', function(){

        var id_faskes = $(this).attr('data-id');
        var nama_faskes = $(this).attr('data-nama')
        rekapnakesfaskes(id_faskes)
        $('#juduldetailfaskes').html('Detail Nakes Pada Faskes : '+nama_faskes)

    })

    $('#detailnakesonfaskes').click(function(){

        var id_faskes = $(this).attr('data-id');
        var nama_faskes = $(this).attr('data-nama')
        rekapnakesfaskes(id_faskes)
        $('#juduldetailfaskes').html('Detail Nakes Pada Faskes : '+nama_faskes)

    })

    function writejadwalpraktik(data, detail, kompetensi, sip_manual){

        var jadwalpraktik = ''
        var detailpraktik = ''
        var salinan = detail.salinan
        var shifting = ''
        var sebagai = kompetensi
        var status_p = '<span class="badge bg-info">Proses Pengajuan</span>'
        var isFaskes = detail.isFaskes
        var alamat_pengajuan = detail.alamat_pengajuan+', '+detail.kecamatan+', '+detail.kabupaten

        console.log(detail)
        if(sip_manual == '0') {

            if(detail.template_id == '4') {
                sebagai = 'Apoteker Penanggung Jawab'
            } else if(detail.template_id == '3') {
                sebagai = 'Apoteker'
            } else if(detail.tempate_id == '2') {
                if(detail.remark != '0' || detail.remark != null) {
                    sebagai = detail.remark
                } else {
                    sebagai = kompetensi
                }
            }

        }
        var treker = detail.tracker;
        
        if(detail.isApproved == '4') {
            status_p = '<span class="badge bg-success">Disetujui</span>'
        } else if (detail.isApproved == '9') {
            status_p = '<span class="badge bg-danger">Ditolak</span>'
            treker = treker+' ('+detail.alasan_ditolak+')';
        } else if (detail.isApproved == 'CF') {
            status_p = '<span class="badge bg-secondary">Dicabut</span>'
            treker = treker+' ('+detail.nama_alasan+')';
        }

        if(isFaskes == '1') {
            alamat_pengajuan = detail.nama_faskes+', '+detail.alamat_pengajuan+', '+detail.kecamatan+', '+detail.kabupaten
        }


        var detailaju = '<div class="table-responsive"><table class="table"><tbody><tr><td style="width:50%"><strong><i class="fas fa-user-alt me-1"></i> Pengajuan Sebagai</strong><p class="text-muted">'+sebagai+'</p><hr /><strong><i class="far fa-file-alt me-1"></i> Status Pengajuan</strong><p class="text-muted">'+status_p+'</p></td><td><strong><i class="fas fa-map-marker-alt me-1"></i> Alamat Pengajuan </strong><p class="text-muted">'+alamat_pengajuan+'</p><hr /><strong><i class="fas fa-info-circle me-1"></i>Keterangan Status</strong><p class="text-muted">'+treker+'</p></td></tr></tbody></table></div>';


        if(sip_manual == '1') {
            var iter = 0
            for (i = 0; i < data.length; i++) {
                var hari = ''
                
                if(data[i].isSet == '1') {
                    iter++;
                    if(data[i].is_shift == '1') {
                    shifting = 'Shift';
                    }

                    switch (data[i].urutan) {
                        case '1':
                            hari = 'Senin'
                            break;
                        case '2':
                            hari = 'Selasa'
                            break;
                        case '3':
                            hari = 'Rabu'
                            break;
                        case '4':
                            hari = 'Kamis'
                            break;
                        case '5':
                            hari = 'Jumat'
                            break;
                        case '6':
                            hari = 'Sabtu'
                            break;
                        default:
                            hari = 'Minggu'
                    }

                    detailpraktik += '<tr><td>'+iter+'</td><td>'+hari+'</td><td>'+data[i].mulai+' - '+data[i].selesai+'</td><td>'+shifting+'</td><td>'+data[i].uraian+'</td></tr>';
                }
            }

        } else {

            for (i = 0; i < data.length; i++) {

            if(data[i].is_shift == '1') {
                shifting = 'Shift';
            }

            detailpraktik += '<tr><td>'+(i + 1)+'</td><td>'+data[i].hari+'</td><td>'+data[i].mulai+' - '+data[i].selesai+'</td><td>'+shifting+'</td><td>'+data[i].uraian+'</td></tr>';

            }

        }
        


        jadwalpraktik = '<div class="row"><div class="col-md-12">'+detailaju+'<div class="table-responsive"><table class="table table-striped"><thead><tr><th>#</th><th>Hari</th><th>Pukul</th><th>Shift</th><th>Uraian</th></tr></thead><tbody>'+detailpraktik+'</tbody></table></div></div></div>'
        $('#isi-salinan'+salinan).html(jadwalpraktik)

    }

    function writesejawat(data) {
        var temansejawat = '';
        
        for (i = 0; i < data.length; i++) {

            var fotoUrl = "{{ URL::to('/storagefoto')}}/" + data[i].saved_photo;

            temansejawat += '<tr><td>'+(i + 1)+'</td><td><img src="'+fotoUrl+'" width="50px" alt="user image"></td><td>'+data[i].nama+'</td><td>'+data[i].no_reg+'</td><td>'+data[i].str_hingga+'</td></tr>';

        }

        sejawatan = '<div class="col-md-12"><div class="table-responsive" style="height: 300px;"><table class="table table-striped table-head-fixed"><thead><tr><th>#</th><th>Foto</th><th>Nama</th><th>No Registrasi</th><th>STR Hingga</th></tr></thead><tbody>'+temansejawat+'</tbody></table></div></div>'
        $('#listsejawat').html(sejawatan)


    }

    function writesejarah(data) {
        var sejarahnya = '';
        var salinan = data[0].salinan;
        $('#histori-salinan'+salinan).show()

        for (i = 0; i < data.length; i++) {
            var nama_faskes = '';

            if(data[i].isFaskes == 1) {
                nama_faskes = data[i].nama_faskes

            } else {
                nama_faskes = 'Mandiri'
            }

            sejarahnya += '<tr><td>'+(i + 1)+'</td><td>'+nama_faskes+'</td><td>'+data[i].alamat_pengajuan+', '+data[i].kecamatan+', '+data[i].kabupaten+'</td><td>'+data[i].signed_date+'</td><td>'+data[i].updated_at+'</td><td>'+data[i].nama_alasan+'</td></tr>';

        }
        $('#histori-isi-salinan'+salinan).html(sejarahnya)

    }

    function showprofilingnakes(id_nakes) {

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("profiling.nakes")}}',
            data: {'id_nakes': id_nakes, _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            beforeSend: function(data){

                $('#histori-salinan1').hide()
                $('#histori-salinan2').hide()
                $('#histori-salinan3').hide()

            },
            success: function(data){
                
                var default_note = '<blockquote class="quote-secondary"><p>Tidak Ada Data Yang Dapat Ditampilkan</p></blockquote>';
                if(data.success == true) {
                    console.log(data)

                    if(data.sejawat.length > 0) {
                        writesejawat(data.sejawat)
                    } else {
                        $('#listsejawat').html(default_note)
                    }

                    if(data.jadwal1.length > 0) {
                        writejadwalpraktik(data.jadwal1, data.salinan1, data.detail_pengaju.kompetensi, data.salinan1.sip_manual)
                    } else {
                        $('#isi-salinan1').html(default_note)
                    }
                    if(data.jadwal2.length > 0) {
                        writejadwalpraktik(data.jadwal2, data.salinan2, data.detail_pengaju.kompetensi, data.salinan2.sip_manual)
                    } else {
                        $('#isi-salinan2').html(default_note)
                    }
                    if(data.jadwal3.length > 0) {
                        writejadwalpraktik(data.jadwal3, data.salinan3, data.detail_pengaju.kompetensi, data.salinan3.sip_manual)
                    } else {
                        $('#isi-salinan3').html(default_note)
                    }


                    if(data.sejarah1.length > 0) {
                        writesejarah(data.sejarah1)
                        
                    }
                    if(data.sejarah2.length > 0) {
                        writesejarah(data.sejarah2)
                        
                    }
                    if(data.sejarah3.length > 0) {
                        writesejarah(data.sejarah3)
                    }

        
                    if(data.infonakes.universitas == '') {
                        var pendidikan = 'Belum Ada Data Pendidikan'
                    } else {
                        var pendidikan = data.infonakes.strata+', Jurusan '+data.infonakes.jurusan+', '+data.infonakes.universitas
                    }

                    if(data.infonakes.alamat_ktp == '') {
                        var alamat = 'Belum Ada Data Alamat'
                    } else {
                        var alamat = data.infonakes.alamat_ktp+', '+data.infonakes.kec_ktp+', '+data.infonakes.kab_ktp
                    }

                    if(data.infonakes.isdomi == 'D') {
                        var alamat_domisili = data.infonakes.alamat_domisili+', '+data.infonakes.kec_domisili+', '+data.infonakes.kab_domisili
                    } else {
                        var alamat_domisili = 'Sesuai KTP'
                    }

                    var htmlprofile = '<tr><td style="width:50%"><strong><i class="fas fa-book me-1"></i> Pendidikan</strong><p class="text-muted">'+pendidikan+'</p><hr /><strong><i class="far fa-file-alt me-1"></i> Email</strong><p class="text-muted">'+data.detail_pengaju.email+'</p></td><td><strong><i class="fas fa-map-marker-alt me-1"></i> Alamat</strong><p class="text-muted">'+alamat+'</p><hr /><strong><i class="fas fa-map-marker-alt me-1"></i> Alamat Domisili</strong><p class="text-muted">'+alamat_domisili+'</p></td></tr>';

                    
                    $('#profileNakesModal').modal('show');
                    var fotoUrl = "{{ URL::to('/storagefoto')}}/" + data.detail_pengaju.saved_photo;
                    $('#fotodetailnakes').attr('src', fotoUrl)
                    $('#namadetailnakes').html(data.detail_pengaju.nama)
                    $('#profesidetailnakes').html(data.detail_pengaju.kompetensi)
                    $('#isiprofilnakes').html(htmlprofile)

                }
            },
            error: function(request, status, error){
                alert(request.responseText);
            }
        });


    }

    $('.toprofilingnakes').click(function(){
        var id_nakes = $(this).attr('data-id')
        showprofilingnakes(id_nakes)
    })

    $('#historyapprovedptsp').on('click','.toprofilingnakes', function(){
        var id_nakes = $(this).attr('data-id')
        showprofilingnakes(id_nakes)
    })

    $('#historyapprovepengajuan').on('click','.toprofilingnakes', function(){
        var id_nakes = $(this).attr('data-id')
        showprofilingnakes(id_nakes)
    })

    $('#historyapprovedptspsipmanual').on('click','.toprofilingnakes', function(){
        var id_nakes = $(this).attr('data-id')
        showprofilingnakes(id_nakes)
    })

    $('#nakessekitar').on('click','.toprofilingnakes', function(){
        var id_nakes = $(this).attr('data-id')
        showprofilingnakes(id_nakes)
    })

    $('#sebelahmaplist').on('click', '.toprofilingnakes', function(){
        var id_nakes = $(this).attr('data-id')
        showprofilingnakes(id_nakes)
    })

    $('#tblpendaftarhist').on('click', '.toprofilingnakes', function(){
        var id_nakes = $(this).attr('data-id')
        showprofilingnakes(id_nakes)
    })

    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
    $('#tbllistuserinactive').DataTable()
    $('#tbllistpencabutan').DataTable({
        scrollY: true,       // make it scrollable
        scrollCollapse: true,
        paging: true,
        scrollX: true,   // allow horizontal scroll
        fixedHeader: false, // make sure it doesn’t freeze
        columnDefs: [
            {
                targets: 'orderfirst',   // match the class in <th>
                visible: false,          // hide the column
                searchable: false        // optional: remove from search
            }
        ],
        order: [
            ['orderfirst', 'asc']        // default ASC order by that column
        ],
        initComplete: function () {
            let api = this.api();

            // Add select filter for filterable columns
            api.columns('.filterable').every(function () {
                let column = this;
                let select = $('<select><option value="">All</option></select>')
                    .appendTo($(column.header()).empty())
                    .on('change', function () {
                        let val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                column.data().unique().sort().each(function (d) {
                    select.append('<option value="' + d + '">' + d + '</option>');
                });
            });
        },
        order: (function () {
            // Find the first "orderable" header and set it as default desc
            let orderableIndex = $('#tbllistpencabutan thead th.orderable').first().index();
            return orderableIndex >= 0 ? [[orderableIndex, 'desc']] : [];
        })()
    });

    $('#tbllistuserinactive').on('click', '.reaktifasi', function (){
        var id_user = $(this).attr('data-id');
        var nama = $(this).attr('data-nama');

        Swal.fire({
            title: 'Apakah Anda Yakin Untuk Mengaktifkan Kembali User: '+nama+'?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
        }).then((result) => {
            console.log(result)
            if (result.value == true) {

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("ptsp.reaktifasiuser")}}',
                    data: {'id_user': id_user, _token: "{{ csrf_token() }}"},
                    dataType: 'json',
                    success: function(data){

                        if(data.success == true) {
                            Swal.fire('Sukses!', '', 'success')
                            location.reload()
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

    function getcontentappcabut(jenis, id_pengajuan, id_nakes, salinan) {

        return new Promise((resolve, reject) => {
            if (jenis == '1') {
                let html = `
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="alert alert-info alert-dismissible">
                            <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
                            Anda Akan Menyetujui Pencabutan Berikut.
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success" id="submitaksibidfar">Submit</button>
                    </div> 
                </div>`;
                resolve(html);

            } else if (jenis == '2') {
                let html = `
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Alasan Penolakan</label>
                            <textarea type="text" id="tAlasanTolakCabut" name="tAlasanTolakCabut" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-success" id="submitaksibidfar">Submit</button>
                    </div> 
                </div>
                `;
                resolve(html);

            } else {
                $.ajax({
                    method: 'get',
                    url: '{{ route("getdetailrekomc")}}',
                    data: { 
                        id_pengajuan: id_pengajuan,
                        id_nakes: id_nakes,
                        salinan: salinan,
                        _token: "{{ csrf_token() }}" 
                    },
                    dataType: 'json',
                    success: function (data) {
                        html = `<div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-success" id="submitaksibidfar">Submit</button>
                                </div> 
                            </div>`
                        resolve(html);
                    },
                    error: function (request, status, error) {
                        reject(request.responseText);
                    }
                });
            }
        });
    }

    $('.aksibidfar').click(function(){

        var id_pengajuan = $(this).attr('data-id')
        var id_nakes = $(this).attr('data-nakes')
        var salinan = $(this).attr('data-salinan')
        var updater = $(this).attr('data-updater')
        var id_alasan = $(this).attr('data-alasan')
        var jenis = $(this).attr('data-jenis')
        var html = getcontentappcabut(jenis)

        getcontentappcabut(jenis, id_pengajuan, id_nakes, salinan).then(function (html) {
            $('#kontentappcabut').html(html);
            $('#approvalpencabutanmod').modal('show');
        }).catch(function (err) {
            alert("Error: " + err);
        });


    });

    $(document).on('click', '#submitaksibidfar', function () {
    // get extra data if needed
        alert('OK')
    })

    
    

</script>



<!-- Leaflet is loaded once in back_corejs (vendored copy + CDN fallback) -->
<script>
		(function() {

			/*
			 | Leaflet bootstrap shared by every map page (#pengajuanmap).
			 | Pages without a map skip this block instead of throwing on the
			 | missing container, which used to break every handler below it.
			 */
			if (typeof L === 'undefined') {
				console.error('[map] Leaflet belum dimuat (public/vendor/leaflet/leaflet.js).');
				return;
			}

			var mapContainer = document.getElementById('pengajuanmap');

			if (!mapContainer || mapContainer._leaflet_id) {
				return;
			}

			var mapboxToken = @json(config('services.mapbox.token'));
			var mymap = L.map('pengajuanmap').setView([-7.708699, 109.013433], 13);

			if (mapboxToken) {
				L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
					attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
					maxZoom: 20,
					id: 'mapbox/streets-v11',
					tileSize: 512,
					zoomOffset: -1,
					accessToken: mapboxToken
				}).addTo(mymap);
			} else {
				/* No MAPBOX_TOKEN in .env: fall back to OpenStreetMap so the map
					   still renders instead of showing an empty grey canvas. */
				L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
					attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
					maxZoom: 19
				}).addTo(mymap);
			}

			/* Exposed so the form wizard can refresh the map after a step
			   change (the container is 0x0 while its panel is hidden). */
			window.pengajuanMap = mymap;
			window.pengajuanMapInvalidate = function () {
				mymap.invalidateSize();
			};

            var theMarker = {};

            function addMarker(e){
                // Add marker to map at click location; add popup window
                var newMarker = new L.marker(e.latlng).addTo(mymap);
            }

            mymap.on('click', function(e){
                var isEditor = @json($role ?? '');
                if (theMarker != undefined && isEditor != 'admindinkes' && isEditor != 'adminptsp' ) {
                    mymap.removeLayer(theMarker);
                };

                theMarker = new L.marker(e.latlng).addTo(mymap);
                $('#tLat').val(e.latlng.lat);
                $('#tLong').val(e.latlng.lng);
            });

			/* bs-stepper pages (detail pengajuan): Leaflet has to recalculate
			   the map size every time the Lokasi step becomes visible again.
			   Guarded because most pages do not render a stepper at all. */
			var stepperElement = document.querySelector('.bs-stepper');

			if (stepperElement) {
				stepperElement.addEventListener('shown.bs-stepper', function (event) {
					// Check whether the Lokasi step is active
					if (event.detail && event.detail.indexStep === 0) {
						// Allow the step content to become visible first
						setTimeout(function () {
							mymap.invalidateSize();
						}, 100);
					}
				});
			}

           function bukakanpeta(){
                var id = $('#mapidPengajuan').val();
                var latitude = $('#maplatitude').val();
                var longitude = $('#maplongitude').val();

                if($('#maplatitude').val() == '') {
                    var lat = '-7.708699'
                    var longi = '109.013433'
                } else {
                    var lat = $('#maplatitude').val()
                    var longi = $('#maplongitude').val()
                }
                //$('.editpengajuan').show()

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ route("get.nakes.sekitar")}}',
                    data: {'longitude': longi, 'latitude': lat, _token: "{{ csrf_token() }}"},
                    async: false,
                    dataType: 'json',
                    success: function(data){

                        if(data.success == true) {

                            const redIcon = L.icon({
                                className: 'circular-map-icon'
                            });
    
                            data.result.forEach(data => {
                                const fotoUrl = "{{ URL::to('/storagefoto') }}/" + data.saved_photo;
                                redIcon.options.iconUrl = fotoUrl;
                                const marker = L.marker([parseFloat(data.latitude), parseFloat(data.longitude)],{ icon: redIcon }).addTo(mymap);
                                marker.bindPopup(`Nama : ${data.name}<br>Profesi: ${data.profesi}<br>Alamat Pengajuan: ${data.alamat_pengajuan}`);
                            });
                        }

                        
                    },
                    error: function(request, status, error){
                        alert(request.responseText);
                    }
                });

                if (theMarker != undefined) {
                    mymap.removeLayer(theMarker);
                };

                L.marker([latitude, longitude]).addTo(mymap)
                mymap.panTo(new L.LatLng(latitude, longitude));

                $('#tLat').val(latitude);
                $('#tLong').val(longitude);

                $('#ajuan_'+id).hide();
                $('#cajuan_'+id).show();
                $('#penambahanAjuanM').show();
                $('#tTypeAjuan').val('edit');
                $('#tIdAjuan').val(id);
            }

            function bukanakespeta(selarea, selprofesi) {

                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ route("get.nakes.inmap")}}',
                    data: {'longitude': '0', 'latitude': '0', 'area' : selarea, 'profesi' : selprofesi, _token: "{{ csrf_token() }}"},
                    async: false,
                    dataType: 'json',
                    success: function(data){
                        console.log(data)
                        if(data.success == true) {
                            var htlist = '';
                            var polygonkec = data.kecamatan_polygon;
                            //console.log(polygonkec)

                            function isPointInPolygon(latitude, longitude, polygonCoordinates) {
                                var isInside = false;
                                var numPoints = polygonCoordinates.length;

                                for (var i = 0, j = numPoints - 1; i < numPoints; j = i++) {
                                    var xi = polygonCoordinates[i][0];
                                    var yi = polygonCoordinates[i][1];
                                    var xj = polygonCoordinates[j][0];
                                    var yj = polygonCoordinates[j][1];

                                    var intersect = ((yi > latitude) !== (yj > latitude)) &&
                                        (longitude < ((xj - xi) * (latitude - yi)) / (yj - yi) + xi);

                                    if (intersect) {
                                        isInside = !isInside;
                                    }
                                }
                                
                                return isInside;
                            }

                            function calculateTotal(arr, lat, long) {
                                var totalObj = {};

                                arr.forEach(function(polygonkec) {
                                    //console.log(polygonkec.properties.nama)
                                    if (isPointInPolygon(lat, long, polygonkec.geometry.coordinates[0])) {
                                        var nama = polygonkec.properties.nama;
                                        if (!totalObj[nama]) {
                                            totalObj[nama] = 1;
                                        } else {
                                            totalObj[nama]++;
                                        }
                                    }
                                });
                                return totalObj;
                            }

                            if(data.polygon == '0') {
                                var polygonCoordinates = '0';
                            } else {
                                var polygonCoordinates = data.polygon.coordinates[0];
                            }

                            mymap.eachLayer(function (layer) {
                                if (layer instanceof L.Marker) {
                                    mymap.removeLayer(layer);
                                }
                            });
                            var datamar = [];
                            var resulting = {};
                            
                            data.result.forEach((data, index) => {

                                var totalObj = calculateTotal(polygonkec, parseFloat(data.latitude), parseFloat(data.longitude));

                                    for (var nama in totalObj) {
                                        if (!resulting[nama]) {
                                            resulting[nama] = totalObj[nama];
                                        } else {
                                            resulting[nama] += totalObj[nama];
                                        }
                                    }
                                
                                var redIcon = L.icon({
                                    className: 'circular-map-icon'
                                });
                                const fotoUrl = "{{ URL::to('/storagefoto') }}/" + data.saved_photo;
                                redIcon.options.iconUrl = fotoUrl;
                                const marker = L.marker([parseFloat(data.latitude), parseFloat(data.longitude)],{ icon: redIcon })

                                if(polygonCoordinates != '0') {

                                    if (isPointInPolygon(parseFloat(data.latitude), parseFloat(data.longitude), polygonCoordinates)) {
                                        marker.bindPopup(`Nama : ${data.name}<br>Profesi: ${data.profesi}<br>Alamat Pengajuan: ${data.alamat_pengajuan}`).addTo(mymap);
                                        var iterat = index + 1;
                                        htlist += '<tr><td>'+iterat+'</td><td><div class="user-block"><img class="rounded-circle img-bordered-sm" src="'+fotoUrl+'" alt="user image"><span class="username"><a href="#" data-id="'+data.id_user+'" class="toprofilingnakes">'+data.name+'</a></span><span class="description">'+data.profesi+'</span></div></td></tr>';

                                        datamar.push({ "profesi": data.profesi });

                                    }

                                } else {

                                    
       
                                    //console.log(totalObj)
                                    marker.bindPopup(`Nama : ${data.name}<br>Profesi: ${data.profesi}<br>Alamat Pengajuan: ${data.alamat_pengajuan}`).addTo(mymap);
                                    var iterat = index + 1;
                                    htlist += '<tr><td>'+iterat+'</td><td><div class="user-block"><img class="rounded-circle img-bordered-sm" src="'+fotoUrl+'" alt="user image"><span class="username"><a href="#" data-id="'+data.id_user+'" class="toprofilingnakes">'+data.name+'</a></span><span class="description">'+data.profesi+'</span></div></td></tr>';

                                    datamar.push({ "profesi": data.profesi });

                                }
                                
                            });

                            console.log(resulting)
                            var totalSum = 0;

                            for (var nama in resulting) {
                                totalSum += resulting[nama];
                            }
                            
                            var progressBarContainer = $("#progressings");
                            htmproc = ''

                            for (var nama in resulting) {
                                var total = resulting[nama];
                                var percentage = Math.floor((total / totalSum) * 100);

                                htmproc += '<div class="row"><div class="col-md-12"><p>'+nama+' ('+total+')</p><div class="progress progress-xxs"><div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="'+percentage+'" aria-valuemin="0" aria-valuemax="100" style="width: '+percentage+'%"><span class="visually-hidden">'+percentage+'% Complete (warning)</span></div></div><hr /></div></div>'
                            }
                            
                            progressBarContainer.html(htmproc)
                            

                            data.faskes.forEach((data, index) => {
                                var customIcon = L.divIcon({
                                    html: '<i class="fas fa-hospital"></i>'
                                });
                        
                                const marker = L.marker([parseFloat(data.latitude), parseFloat(data.longitude)],{ icon: customIcon })

                                if(polygonCoordinates != '0') {

                                    if (isPointInPolygon(parseFloat(data.latitude), parseFloat(data.longitude), polygonCoordinates)) {
                                        marker.bindPopup(`Nama Faskes : ${data.nama_faskes}<br>Alamat Faskes: ${data.alamat_faskes}`).addTo(mymap);
                                    }

                                } else {

                                    marker.bindPopup(`Nama : ${data.nama_faskes}<br>Alamat Faskes: ${data.alamat_faskes}`).addTo(mymap);

                                }
                                
                            });

                            var totals = {};
            
                            $.each(datamar, function(index, entry) {
                                var profesi = entry.profesi;
                                if (totals.hasOwnProperty(profesi)) {
                                    totals[profesi]++;
                                } else {
                                    totals[profesi] = 1;
                                }
                            });

                            var totalall = 0;
                            var htperse = '';
    
                            var professionCounts = {};
                            datamar.forEach(function(item) {
                                var profession = item.profesi.toUpperCase(); // Convert to uppercase to handle case variations
                                professionCounts[profession] = (professionCounts[profession] || 0) + 1;
                            });

                            var sortedProfessions = Object.keys(professionCounts).sort(function(a, b) {
                                return professionCounts[b] - professionCounts[a];
                            });

                            sortedProfessions.forEach(function(profession) {
                                var total = professionCounts[profession];
                                htperse += '<tr><td>'+profession+'</td><td>'+total+'</td></tr>'
                                totalall = totalall + total;
                            });
                            
                            //console.log(resulti)
                            $('#judulnakesmap').html('Nakes Pada '+data.nama_kec)
                            $('#judulpersebaran').html('Persebaran Pada '+data.nama_kec+' ('+totalall+')')
                            $('#rekappersebaran').html(htperse)
                            $('#listnakesmap').html(htlist)

                        }

                        
                    },
                    error: function(request, status, error){
                        alert(request.responseText);
                    }
                });
                
            }

            if($('#mapidPengajuan').length) {
                bukakanpeta()
            }

            if($('#mapsebarannakes').length) {
                var area = 'all'
                var profesi = []
                bukanakespeta(area,profesi)
            }

            $('#submitfiltermap').click(function(){
                var lokasi = $('#pilihareamap').val()
                var profesi = $('#pilihprofesimap').val()
                bukanakespeta(lokasi, profesi)
            })
            


            $('.ceditpengajuan').click(function(){
                var id = $(this).attr('data-id');
                //$('.ceditpengajuan').show()

                if (theMarker != undefined) {
                    mymap.removeLayer(theMarker);
                };

                $('#ajuan_'+id).show();
                $('#cajuan_'+id).hide();
                $('#penambahanAjuanM').hide();
                $('#tTypeAjuan').val('add');
            })


		}());
</script>

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
                        url: '{{ route("get.data.str")}}',
                        data: {'thename': decodedText, 'thelinker': thelinker, _token: "{{ csrf_token() }}"},
                        async: false,
                        dataType: 'json',
                        success: function(data){

                            //alert('bisa')
                            
                            var obj = jQuery.parseJSON(data)

                            //console.log(data)
                            resultContainer.innerHTML += `<div>Nomor Registrasi - `+obj.no_reg+`</div><br /><div>Nama Nakes - `+obj.nama_nakes+`</div>`;
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

