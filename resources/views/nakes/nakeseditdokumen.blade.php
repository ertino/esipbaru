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
    <section class="content" id="idpeng" data-id="{{$idpengajuan}}">
        <div class="container-fluid">
            <div class="row">
                <div id="modal-tunggusubmit-content" style="display: none;">
                    <center>
                    <i class="fas fa-hourglass"></i>
                    <h5>Mohon Tunggu..</h5>
                    </center>
                </div>
            </div>
            @if($pencabutan == 1)

            <div class="row">
                <div class="col-md-12">

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card card-widget overlay dark">
                                <div class="card-header">
                                    <div>
                                        Edit Dokumen Pencabutan
                                    </div>

                                </div>

                                <div class="card-body" id="dokpencabutan">

                                    <div class="row">
                                        <div class="col-md-7 col-xs-12">

                                            <div class="card-body">
                                            <div class="row" id="parentdokterkini">
                                            </div>
                                        
                                            </div>

                                        </div>
                                        <div class="col-md-5 col-xs-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form enctype="multipart/form-data" id="formEditDocCabut" action="" method="post" class="form-horizontal">
                                                        @csrf
                                                        
                                                        <div class="row ifdokterapot">

                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">Lampiran Dokumen Pendukung</label>
                                                                    <input type="file" id="tFileRekomdok" name="tFileRekomdok" class="form-control" accept=".pdf">
                                                                </div>
                                                            </div>
                                                        
                                                            
                                                        </div>
                                                        <div class="row ifdokterapot">

                                                            <div class="col-md-12" style="display:none">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">IDSIP</label>
                                                                    <input type="text" id="cabutidsip" name="cabutidsip" class="form-control" required>
                                                                </div>
                                                            </div>
                                                    
                                                        </div>

                                                        <div class="row ifdokterapot">

                                                            <div class="col-md-12" style="display:none">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">ID DOK</label>
                                                                    <input type="text" id="cabutiddok" name="cabutiddok" class="form-control" required>
                                                                </div>
                                                            </div>
                                                    
                                                        </div>

                                                        

                                                        <div class="row">

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">No. Dok. Pencabutan</label>
                                                                    <input type="text" id="tNoDocumentrekomdok" name="tNoDocumentrekomdok" class="form-control" required>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Dokumen</label>
                                                                    <input type="date" id="tTglRekomdok" name="tTglRekomdok" class="form-control" required>
                                                                </div>
                                                            </div>

                                                        </div>

                                                        <div class="row ifdokterapot">
                                                        
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">Perihal</label>
                                                                    <input type="text" id="tPerihalRekomdok" name="tPerihalRekomdok" class="form-control" required>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>

                                                        <div class="row ifdokterapot">


                                                        
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">Catatan</label>
                                                                    <input type="text" id="tCatatanRekom" name="tCatatanRekom" class="form-control" placeholder="Contoh: Update Dokumen Setelah Visitasi" required>
                                                                </div>
                                                            </div>
                                                        
                                                        </div>

                                                        <div class="row toevent">
                                                            
                                                            <div class="col-md-6" style="display:none">
                                                                <div class="input-group input-group-static mb-4">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                                    <input type="text" id="cabutnakes_id" name="cabutnakes_id" value="" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6" style="display:none">
                                                                <div class="input-group input-group-static mb-4">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                                    <input type="text" id="cabutIdPengajuan" name="cabutIdPengajuan" value="{{$idpengajuan}}" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6" style="display:none">
                                                                <div class="input-group input-group-static mb-4">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                                    <input type="text" id="cabutSalinan" name="cabutSalinan" class="form-control">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6" style="display:none">
                                                                <div class="input-group input-group-static mb-4">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                                    <input type="text" id="namaupdater" name="namaupdater" class="form-control" value="{{$nama_user}}">
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="col-md-6" style="display:none">
                                                                <div class="input-group input-group-static mb-4">
                                                                    <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                                    <input type="text" id="cabutfilename" name="cabutfilename" class="form-control">
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div id="btnaksicabut" style="display:none">
                                                        <button type="submit" id="submitDoc" class="btn btn-success submitDoc">Submit</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <hr />
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header border-0">
                                                            <h3 class="card-title">Histori</h3>
                                                            <div class="card-tools">
                                                            <a href="#" class="btn btn-tool btn-sm">
                                                                <i class="fas fa-bars"></i>
                                                            </a>
                                                            </div>
                                                        </div>
                                                        <div class="card-body table-responsive p-0" style="max-height: 250px; overflow-y: auto;">
                                                            <table class="table table-striped table-valign-middle" id="histdokcabut">
                                                                <thead>
                                                                <tr>
                                                                    <th>Updater</th>
                                                                    <th>Keterangan</th>
                                                                    <th>Waktu</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div class="overlay" id="tunggudokcabut" style="display:none">
                                    <i class="fas fa-2x fa-sync-alt"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            @else
            <div class="row">
                
                <div class="col-md-7" id="formdatadiri" @if($isedit == 0) style="display:none" @endif>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="card card-widget overlay dark">
                                <div class="card-header">
                                    <div>
                                        Form Dokumen {{$detail_dok->nama_doc}}
                                    </div>

                                </div>

                                <div class="card-body">
                                   

                                    <form enctype="multipart/form-data" id="formUploadDok" action="{{route('nakes.update.doc')}}" method="post" class="form-horizontal">
                                    @csrf
                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jenis Dok</label>
                                                    <input type="text" id="tjenisdoc" name="tjenisdoc" class="form-control" value="{{$detail_dok->jenis_doc}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID Dok</label>
                                                    <input type="text" id="tIDdokumen" name="tIDdokumen" class="form-control" value="{{$detail_dok->id}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                                    <input type="text" id="tUserDok" name="tUserDok" class="form-control" value="{{$user_id}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Is Edit</label>
                                                    <input type="text" id="tiseditdoc" name="tiseditdoc" class="form-control" value="{{$isedit}}" readonly>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                    <input type="text" id="tupdateSalinan" name="tupdateSalinan" class="form-control" value="{{$detail_dok->salinan}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama File</label>
                                                    <input type="text" id="texistingfilename" name="texistingfilename" class="form-control" value="{{$detail_dok->namafile}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            @if($detail_dok->jenis_doc == 'FOTO')
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">FOTO Sesuai STR</label>
                                                    <input type="file" id="tFileNakesDok" name="tFileNakesDok" class="form-control" accept="image/jpeg" onchange="validateFileSize(this)">
                                                </div>
                                            </div>

                                            @else
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen (Upload Terbaru Jika Diharuskan)</label>
                                                    <input type="file" id="tFileNakesDok" name="tFileNakesDok" class="form-control" accept="application/pdf">
                                                </div>
                                            </div>
                                            @endif
                                            
                                            
                                            <div class="col-md-3" style="display:none">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">ID</label>
                                                    <input type="text" id="dokUploader" name="dokUploader" value="{{$user_id}}" class="form-control" >
                                                </div>
                                            </div>
                                        </div>  

                                        <div class="row">

                                            <div class="col-md-6" @if($detail_dok->jenis_doc == 'FOTO') style="display:none" @endif>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No Dokumen {{$detail_dok->nama_doc}} *</label>
                                                    <input type="text" id="dokNOMOR" name="dokNOMOR" class="form-control" @if($isedit == 1) value="{{$detail_dok->no_doc}}" @endif required>
                                                </div>
                                            </div>

                                            <div class="col-md-6" @if($detail_dok->jenis_doc == 'FOTO') style="display:none" @endif>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Dokumen</label>
                                                    <input type="date" id="dokTGL" name="dokTGL" class="form-control" @if($isedit == 1) value="{{$detail_dok->tgl_doc_origin}}" @endif @if($detail_dok->jenis_doc != 'FOTO') required @endif>
                                                </div>
                                            </div>

                                        </div>  


                                        @if($detail_dok->jenis_doc == 'IJAZAH')


                                        <div class="row">
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Universitas *</label>
                                                    <input type="text" id="dokREMARK1" name="dokREMARK1" class="form-control" @if($isedit == 1) value="{{$detail_dok->remark1}}" @endif required>
                                                </div>
                                            </div>

                                            <div class="col-md-3" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Strata</label>
                                                    <input type="text" id="dokREMARK2" name="dokREMARK2" class="form-control" @if($isedit == 1) value="{{$detail_dok->remark2}}" @endif>
                                                </div>
                                            </div>

                                            <div class="col-md-3" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Prodi</label>
                                                    <input type="text" id="dokREMARK3" name="dokREMARK3" class="form-control" @if($isedit == 1) value="{{$detail_dok->remark3}}" @endif>
                                                </div>
                                            </div>

                                        </div> 

                                        @endif

                                        <hr />
                                        <p> Pastikan Data Diri Yang Anda Submit Sudah Sesuai Karena Akan Berpengaruh Pada SIP Yang Dicetak. Dengan Ini Saya Bertanggung Jawab Penuh Dengan Apa Yang Saya Unggah dan Submit.</p>
                                        <input type="checkbox" required /> Setuju
                                        <hr /> 

                                        <button type="submit" id="simpanUpdateDokumen" class="btn btn-success">@if($isedit == 1) Update @endif</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-5">

                    @if ($isedit == 1)

                    <div class="card card-row card-success" id="hasildoken" @if($detail_dok->jenis_doc == 'FOTO') style="display:none" @endif>
                        <div class="card-header">
                            <h3 class="card-title">
                                Dokumen Terakhir Diupload
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
                            <div class="row" id="parentdokterkini">
                            </div>
                        </div>
                    </div>

                    @endif

                </div>
            </div>
            @endif
        </div>
    </section>
</div>
  


  

@endsection
@section('js')

@endsection
@section('script')
<script>

    $(document).ready(function() {

        function getdokcabut(idpengajuan) {

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("getdetaildokpencabutan")}}',
                data: {'idpengajuan': idpengajuan, _token: "{{ csrf_token() }}"},
                dataType: 'json',
                beforeSend: function(data){

                    $('#tunggudokcabut').show()

                },
                success: function(hasil){

                    console.log(hasil)
                    
                    if(hasil.success == true)
                    {
                        let tbody = $("#histdokcabut tbody");
                        tbody.empty(); // clear old rows first

                        hasil.histori.forEach(function (row) {
                            let tr = `
                                <tr>
                                    <td>${row.name}</td>
                                    <td>${row.keterangan}</td>
                                    <td>${row.updated_at}</td>
                                </tr>
                            `;
                            tbody.append(tr);
                        });
                        

                        if(hasil.result.verifdinkes == 0)
                        {
                            $('#btnaksicabut').show()
                        }

                        $('#tunggudokcabut').hide()
                        var dokcab = `<div class="col-md-12 col-xs-12"><embed src="{{ URL::to('/storageup') }}/${hasil.result.namafile}" 
                                        style="width:100%;height:500px;"></div>`;
                        $('#parentdokterkini').html(dokcab);
                        $('input[name="tNoDocumentrekomdok"]').val(hasil.result.no_doc);
                        $('input[name="tTglRekomdok"]').val(hasil.result.tgl_doc_origin);
                        $('input[name="tPerihalRekomdok"]').val(hasil.result.nama_doc);
                        $('input[name="cabutSalinan"]').val(hasil.result.salinan);
                        $('input[name="cabutfilename"]').val(hasil.result.namafile);
                        $('input[name="cabutnakes_id"]').val(hasil.result.id_user);
                        $('input[name="cabutidsip"]').val(hasil.result.remark1);
                        $('input[name="cabutiddok"]').val(hasil.result.id);
                        
                        
                    } else {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Pengambilan Data Dokumen Pencabutan',
                        })

                    }
                    
                
                
                },
                error: function(request, status, error) {
                    alert(request.responseText);
                
                }
            });

        }

        if($('#dokpencabutan').length)
        {
            var idpengajuan = $('#idpeng').attr('data-id')
            getdokcabut(idpengajuan)
        }



        $('#formEditDocCabut').on('submit', function(e){
            e.preventDefault();

            let is_contain_file = $(this).attr('enctype')
            let formData = new FormData($(this)[0])

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("updatedokpencabutan")}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                //async: false,
                beforeSend: function() {

                    $.fancybox.open({
                        src: '#modal-tunggusubmit-content',
                        type: 'inline',
                        touch: false,
                        modal: true,
                        clickSlide: false
                    });
            

                },
                //	dataType: 'json',
                success: function(data) {

                    console.log(data)
                    $.fancybox.close();
                    if(data.success) {
                        Swal.fire(data.keterangan).then(function() {
                            
                            window.location.reload();
                            
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Submit Update Dokumen Pencabutan Nakes. Keterangan: '+data.keterangan,
                        })
                    }
                },
                error: function(request, status, error) {
                    $.fancybox.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error Submit Upload Dokumen SKSKP',
                    })
                }
            });
        });




    })

</script>

@endsection