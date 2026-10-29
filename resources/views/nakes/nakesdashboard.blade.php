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

                <div class="col-md-4">

                    <div class="card card-widget widget-user-2 shadow-sm">

                        <div class="widget-user-header bg-warning">
                            <div class="widget-user-image">
                                <img class="profile-user-img img-fluid rounded-circle" src="{{ URL::to('/storagefotot')}}/{{$detail_pengaju->saved_photo}}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="widget-user-username">{{ $nama_user }}</h3>
                            <h5 class="widget-user-desc">{{ $profesi }}</h5>
                        </div>
                        <div class="card-footer p-0">
                            
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a href="{{ route('nakes.documents') }}" class="btn btn-block btn-flat btn-outline-primary">
                                        Dokumen 
                                        @if ($dokumenissue > 0)<span class="float-end badge bg-danger">{{$dokumenissue}}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <button class="btn btn-block btn-flat btn-outline-primary" id="ajuanku" data-id="{{$user_id}}" data-dokter="{{$isdokter}}">
                                        Pengajuan 
                                        @if ($pengajuanditolak > 0)<span class="float-end badge bg-danger">{{$pengajuanditolak}}</span>
                                        @endif
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('nakes.perpanjangan', $user_id) }}" class="btn btn-block btn-flat btn-outline-primary" id="perpanjanganpermohonan">
                                        Perpanjangan 
                                        @if ($perpanjanganditolak > 0)<span class="float-end badge bg-danger">{{$perpanjanganditolak}}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('nakes.perubahan', $user_id) }}" class="btn btn-block btn-flat btn-outline-info" id="rubahpermohonan">
                                        Perubahan 
                                        @if ($perubahanditolak > 0)<span class="float-end badge bg-danger">{{$perubahanditolak}}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('nakes.pencabutan', $user_id) }}" class="btn btn-block btn-flat btn-outline-danger" id="cabutpermohonan">
                                        Pencabutan 
                                        @php
                                            $count = 0;
                                            foreach ($allsalinan as $all) {
                                                if($all->isApproved == '4') {
                                                    if($all->alasan_ditolak != null || $all->alasan_ditolak != '') {
                                                        $count++;
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if ($count > 0)
                                            <span class="float-end badge bg-danger"> {{ $count }} </span><!-- Display the count in the badge -->
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('nakes.historikal', $user_id) }}" class="btn btn-block btn-flat btn-outline-secondary" id="cabutpermohonan">
                                        Histori
                                    </a>
                                </li>
                                <li class="nav-item" @if ($issiplama == 0) style="display:none" @endif>
                                    <button class="btn btn-block btn-flat btn-outline-primary" id="sipmanual" data-id="{{$user_id}}" data-dokter="{{$isdokter}}">
                                        Upload SIP Manual 
                                        @if ($sipmanualditolak > 0)<span class="float-end badge bg-danger">{{$sipmanualditolak}}</span>
                                        @endif
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card bg-gradient-light">
                        <div class="card-header border-0 ui-sortable-handle">
                            <h3 class="card-title">
                                <i class="far fa-calendar-alt"></i>
                                Calendar
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-success btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>

                        </div>

                        <div class="card-body pt-0">

                            <div id="calendar" style="width: 100%">
                                
                            </div>
                            <hr />
                            <div class="row">
                                <p> Acara / Visitasi Bulan Ini: </p>
                                <!--<table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td>Update software</td>
                                            <td><span class="badge bg-danger">55%</span></td>
                                        </tr>
                                        <tr>
                                            <td>1.</td>
                                            <td>Update software</td>
                                            <td><span class="badge bg-danger">55%</span></td>
                                        </tr>
                                    </tbody>
                                </table>-->
                                
                                
                                <!--<div class="alert alert-info alert-dismissible">
                                    <h5><i class="icon fas fa-info"></i> Alert!</h5>
                                    Info alert preview. This alert is dismissable.
                                </div>-->
                                
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-xs-12">
                    <div class="card">
                        <div class="card-header">
                            STR Diajukan
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                     
                                        <th>Salinan</th>
                                        <th>Lokasi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($allsalinan as $rowi)
                                    <tr>
                                       
                                        <td>{{$rowi->salinan}}</td>
                                        @if($rowi->isDiajukan == 1)
                                            @if ($rowi->isFaskes == '1')
                                            <td>{{$rowi->nama_faskes}}</td>
                                            @else
                                            <td>{{$rowi->alamat_pengajuan}}</td>
                                            @endif
                                        @else
                                            <td>Belum Diajukan</td>
                                        @endif
                                        @if($rowi->isApproved == 'OP')
                                        <td>Review Org Profesi</td>
                                        @elseif ($rowi->isApproved == '0')
                                        <td>Review Dinkes</td>
                                        @elseif ($rowi->isApproved == 'E')
                                        <td>Belum Diperpanjang</td>
                                        @elseif ($rowi->isApproved == '1K')
                                        <td>Review Kepala Dinkes</td>
                                        @elseif ($rowi->isApproved == '2')
                                        <td>Review DPMPTSP</td>
                                        @elseif ($rowi->isApproved == '3')
                                        <td>Disetujui DPMPTSP</td>
                                        @elseif ($rowi->isApproved == '4')
                                            @if($rowi->alasan_ditolak != null || $rowi->alasan_ditolak != '')
                                            <td><span class="badge text-bg-danger">Pencabutan Ditolak</span></td>
                                            @else
                                            <td>Disetujui</td>
                                            @endif
                                        @elseif ($rowi->isApproved == '9')
                                        <td>Ditolak</td>
                                        @elseif ($rowi->isApproved == 'C')
                                        <td>Proses Pencabutan</td>
                                        @elseif ($rowi->isApproved == 'P2')
                                        <td>Review DPMPTSP</td>
                                        @else
                                        <td>Belum Diajukan</td>
                                        @endif

                                        @if($rowi->isDiajukan == 1)
                                            @if($rowi->isApproved == 'OP')
                                            <td><button class='btn btn-sm btn-info uploadrekomop' data-id="{{$rowi->id_pengajuan}}" data-bs-toggle="tooltip" data-bs-placement="right" title="SEGERA UPLOAD SURAT KETERANGAN ORGANISASI PROFESI" id="myTooltipButton{{$rowi->salinan}}">Upload Suket OP</td>
                                            @elseif ($rowi->isApproved == '9')
                                            <td><a class='btn btn-sm btn-danger' href="{{ route('nakes.pengajuan.edit', Auth::user()->id.'_'.$rowi->salinan.'_'.$rowi->id_pengajuan) }}">Ubah</a>
                                            <button class='btn btn-sm btn-danger batalkanpengajuan' data-id="{{$rowi->id_pengajuan}}" data-updater="{{$user_id}}" data-doc="{{$rowi->id_doc}}">Batal</button>
                                            @else
                                            <td>
                                                @if($rowi->isApproved == '4')
                                                    @if($rowi->alasan_ditolak == null || $rowi->alasan_ditolak == '')
                                                    <a class='btn btn-sm btn-success' href="{{ route('nakes.kedetail.pengajuan', Auth::user()->id.'_'.$rowi->salinan) }}">Detail</a>
                                                    @else
                                                    <a class='btn btn-sm btn-warning' href="{{ route('nakes.pencabutan', Auth::user()->id) }}">Detail</a>
                                                    @endif
                                                @elseif($rowi->isApproved == 'E')
                                                    <a class='btn btn-sm btn-success' href="{{ route('nakes.perpanjangan', $user_id) }}">Perpanjang</a>
                                                @else
                                                <a class='btn btn-sm btn-success' href="{{ route('nakes.kedetail.pengajuan', Auth::user()->id.'_'.$rowi->salinan) }}">Detail</a>
                                                @endif
                                            </td>
                                            @endif
                                        @else
                                            <td>Belum Diajukan</td>
                                        @endif
                                    </tr>
                                @endforeach
                                </tbody>
                                    
                            </table>
                        </div>
                                        
                    </div>

                    <div class="card">
                        <div class="card-header">
                            Hasil Scan QRCODE STR
                        </div>
                        @if($detail_pengaju->origin_file != 'scanned')
                            @if ($isKadaluarsa->kadaluarsa == '0')
                            <div class="card-body">
                                @if((int)$isKadaluarsa->expiring_count <= 20)
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="alert alert-danger alert-dismissible">
                                                <h5><i class="icon fas fa-exclamation-triangle"></i> STR Anda Kadaluarsa {{$isKadaluarsa->expiring_count}} Hari Lagi.</h5>
                                                Silahkan Update STR Anda Pada Menu Perpanjangan, Atau Ajukan Perpanjangan Sementara
                                            </div>
                                            <a href="{{ route('nakes.perpanjangan.sementara', $user_id) }}" class="btn btn-block btn-flat btn-primary" id="perpanjangansementara">Perpanjangan Sementara</a>
                                        </div>
                                    </div>
                                    <hr />
                                @endif

                                @if((int)$isKadaluarsa->expiring_count <= 60 && (int)$isKadaluarsa->expiring_count > 20)
                                    <div class="row">
                                        <div class="col-md-12 col-xs-12">
                                            <div class="alert alert-warning alert-dismissible">
                                                <h5><i class="icon fas fa-exclamation-triangle"></i> STR Anda Kadaluarsa {{$isKadaluarsa->expiring_count}} Hari Lagi.</h5>
                                                Silahkan Update STR Anda Pada Menu Perpanjangan.
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="embed-responsive embed-responsive-21by9">
                                    <iframe class="embed-responsive-item" id="provenID" src="{{$qr_url}}"></iframe>
                                </div> 
                            </div>
                            @else

                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible">
                                    <h5><i class="icon fas fa-ban"></i> KADALUARSA !</h5>
                                    STR Anda Telah Kadaluarsa Pada Tanggal {{$isKadaluarsa->tgl_doc}}. Silahkan Upload Kembali Dokumen STR yang sudah diperbaharui.
                                    </div>
                                </div>

                            @endif   
                        @endif                
                    </div>

                    <div class="card card-widget overlay dark">
                        <div class="card-header">
                            <h5>Informasi</h5>

                        </div>

                        <div class="card-body">

                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-head-fixed text-nowrap">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="timeline overflow-auto">
                                                    @foreach($informasis as $inf)
                                                    <div class="time-label">
                                                        <span @if($inf->jenis_informasi == '2') class="bg-red" @else class="bg-green" @endif>{{$inf->created_at}}</span>
                                                    </div>


                                                    <div>
                                                        @if($inf->jenis_informasi == '1')
                                                        <i class="fas fa-envelope bg-green"></i>
                                                        @elseif($inf->jenis_informasi == '2')
                                                        <i class="fas fa-exclamation-triangle bg-red"></i>
                                                        @else
                                                        <i class="fas fa-envelope bg-green"></i>
                                                        @endif
                                                        <div class="timeline-item">
                                                            <span class="time"><i class="fas fa-clock"></i></span>
                                                            <h3 class="timeline-header"><a href="#">{{$inf->updater}}</a> Memberi Pesan</h3>
                                                            <div class="timeline-body">
                                                                {{$inf->informasi}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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

        function showTooltip(buttonId) {
            $(buttonId).tooltip('show');
        }

        // Function to hide the tooltip
        function hideTooltip(buttonId) {
            $(buttonId).tooltip('hide');
        }

        // Initialize Bootstrap tooltips for all buttons
        $(document).ready(function(){
            $('[data-bs-toggle="tooltip"]').tooltip();

            // Add the color-change class to the tooltip element when shown
            $('[data-bs-toggle="tooltip"]').on('shown.bs.tooltip', function () {
                $('.tooltip').addClass('color-change');
            });

            // Show the tooltip for each button on page load
            showTooltip('#myTooltipButton1');
            showTooltip('#myTooltipButton2');
            showTooltip('#myTooltipButton3');

            // Hide the tooltip when the button is clicked
            $('[data-bs-toggle="tooltip"]').on('click', function () {
                hideTooltip(this);
            });
        });

        $('#sipmanual').click(function(){
            var id = $(this).attr('data-id');
        
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.data.strsalinan")}}',
                data: {'id_user': id , _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function(data){
                    console.log(data)

                    $('.liatdetilpengajuan').hide()

                    if (data.allsalinan[0].template_id == '1') {
                        $('#salinanketiga').hide()
                        
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
                                    var kode_id = user_id+'_'+salinan+'_1'
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
                                    var kode_id = user_id+'_'+salinan+'_1'
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
                            var kode_id = user_id+'_'+salinan+'_1'
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
    })

</script>
@endsection