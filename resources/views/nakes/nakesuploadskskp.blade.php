@extends('layouts.adminlte4.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang e-SIP</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <div class="row">
        <div id="modal-skskp-content" style="display: none;">
            <center>
            <i class="fas fa-hourglass"></i>
            <h5>Mohon Tunggu..</h5>
            </center>
        </div>
    </div>

    <div class="row">
        <div id="modal-petunjukskskp-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                    <h4>Petunjuk Penggunaan</h4>
                    </div>
                    <div class="card-tools">
                    <button type="button" class="btn btn-secondary btn-sm float-end"
                        id="close-petunjukskskp-modal">Close</button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="accordion">
                        <div class="card card-danger">
                            <div class="card-header">
                            <h4 class="card-title w-100">
                                <a class="d-block w-100" data-bs-toggle="collapse" href="#collapseOne">
                                Khusus Untuk Upload Dokumen SK/SKP Ber-QRCODE
                                </a>
                            </h4>
                            </div>
                            <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                                <div class="card-body">
                                <div class="card mb-2 bg-gradient-dark">
                                    <img class="card-img-top" src="{{asset('images/petunjukskskp.jpg')}}" alt="Dist Photo 1">
                                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                                    </div>
                                </div>
                                <p>Pastikan <strong>Jika</strong> Dokumen SK/SKP yang Anda Upload Memiliki <strong> QRCODE </strong> dan <strong> Berada Pada Halaman Pertama (1)</strong>. Dan Pastikan Anda Dapat Melakukan Scan QRCODE Secara Mandiri Dengan Device Yang Anda Miliki dan Hasil Scan Tersebut Mengarah Ke Web skp.kemkes.go.id</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <h3> @if($isedit == '1') Update @else Upload @endif SKSKP</h3><button id="bacapetunjuk" class="btn btn-sm btn-primary">Baca Petunjuk</button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    @if($isedit == '1')
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <embed src="{{ URL::to('/storageup')}}/{{$detailskskp->namafile}}" width="100%" height="300px"></embed>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            @if (Str::contains($detailskskp->remark1, 'skp.kemkes.go.id'))
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <input id="checkskskp" type="text" class="form-control" value="{{$detailskskp->remark1}}" readonly>
                                                    <div class="input-group-append" >
                                                    <span class="input-group-append">
                                                        <a type="button" href="{{$detailskskp->remark1}}" class="btn btn-info btn-flat" target="_blank">Cek SKSKP</a>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Nomor Dokumen</b> <a class="float-end">{{$detailskskp->no_doc}}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Tanggal Dokumen</b> <a class="float-end">{{$detailskskp->tgl_doc}}</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <hr />
                                    @endif

                                    <form enctype="multipart/form-data" id="formUploadSKSP" method="post" class="form-horizontal">
                                        @csrf
                                        <div class="row toevent">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen SKSKP (PDF)</label>
                                                    <input type="file" id="tFileNakesSKSKP" name="tFileNakesSKSKP" class="form-control" accept="application/pdf" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nomor Serkom / SKP</label>
                                                    <input type="text" id="tNoSKSKP" name="tNoSKSKP" class="form-control" placeholder="Isikan Strip (-) Jika Tidak Ada Nomor" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Serkom / SKP</label>
                                                    <input type="date" id="tTglSKSKP" name="tTglSKSKP" class="form-control" value="{{date('Y-m-d')}}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                                    <input type="text" id="tUserPengajuan" name="tUserPengajuan" class="form-control" value="{{$user_id}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Is Edit</label>
                                                    <input type="text" id="tiseditskskp" name="tiseditskskp" class="form-control" value="{{$isedit}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="display:none">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Is Edit</label>
                                                    <input type="text" id="filenameskskp" name="filenameskskp" class="form-control" @if($isedit == "1") value="{{$detailskskp->namafile}}" @else value="" @endif readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" id="submitSKSKP" class="btn btn-success submitSKSKP">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="overlay" id="uploadktploader" style="display:none">
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
    $(document).ready(function() {

        if($('#modal-petunjukskskp-content').length){

            $.fancybox.open({
                src: '#modal-petunjukskskp-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('#close-petunjukskskp-modal').click(function() {
                        $.fancybox.close();
                    });
                }
            });

        }

        $('#bacapetunjuk').on('click', function(){
            $.fancybox.open({
                src: '#modal-petunjukskskp-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('#close-petunjukskskp-modal').click(function() {
                        $.fancybox.close();
                    });
                }
            });
        })

        $('#formUploadSKSP').on('submit', function(e){
            e.preventDefault();

            let is_contain_file = $(this).attr('enctype')
            let formData = new FormData($(this)[0])

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("submit.skskp")}}',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                enctype: 'multipart/form-data',
                //async: false,
                beforeSend: function() {

                    $.fancybox.open({
                        src: '#modal-skskp-content',
                        type: 'inline',
                        touch: false,
                        modal: true,
                        clickSlide: false
                    });
                    $('#submitPengajuanM').attr('disabled', true)
            

                },
                //	dataType: 'json',
                success: function(data) {

                    console.log(data)
                    $.fancybox.close();
                    if(data.success) {
                        Swal.fire(data.keterangan).then(function() {
                            
                            window.location.href = '{{ route("nakes.dashboard") }}';
                            
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Submit Pengajuan Nakes. Keterangan: '+data.keterangan,
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

    });
</script>
@endsection