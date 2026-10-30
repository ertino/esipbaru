@extends('layouts.adminlte4.back_master')

@section('title', 'Dashboard Tenaga Kesehatan')

@section('content')
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Selamat Datang Di e-SIP</h3>
                </div>
            </div>
        </div>
    </div>
    <!--end::App Content Header-->

    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">

                <!--begin::Kolom kiri: profil dan kalender-->
                <div class="col-lg-4">

                    <!--begin::Kartu profil-->
                    <div class="card card-widget widget-user-2 shadow-sm mb-4">
                        <div class="widget-user-header bg-warning">
                            <div class="widget-user-image">
                                <img class="rounded-circle"
                                     src="{{ URL::to('/storagefotot') }}/{{ $detail_pengaju->saved_photo }}"
                                     alt="Foto {{ $nama_user }}">
                            </div>
                            <div class="overflow-hidden">
                                <h3 class="widget-user-username text-truncate mb-0">{{ $nama_user }}</h3>
                                <h5 class="widget-user-desc text-truncate mb-0">{{ $profesi }}</h5>
                            </div>
                        </div>

                        <div class="card-footer p-0">
                            <ul class="nav flex-column gap-2 p-2">
                                <li class="nav-item">
                                    <a href="{{ route('nakes.documents') }}"
                                       class="btn btn-outline-primary w-100 d-flex justify-content-between align-items-center">
                                        Dokumen
                                        @if ($dokumenissue > 0)
                                            <span class="badge text-bg-danger">{{ $dokumenissue }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <button type="button"
                                            class="btn btn-outline-primary w-100 d-flex justify-content-between align-items-center"
                                            id="ajuanku" data-id="{{ $user_id }}" data-dokter="{{ $isdokter }}">
                                        Pengajuan
                                        @if ($pengajuanditolak > 0)
                                            <span class="badge text-bg-danger">{{ $pengajuanditolak }}</span>
                                        @endif
                                    </button>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('nakes.perpanjangan', $user_id) }}"
                                       class="btn btn-outline-primary w-100 d-flex justify-content-between align-items-center"
                                       id="perpanjanganpermohonan">
                                        Perpanjangan
                                        @if ($perpanjanganditolak > 0)
                                            <span class="badge text-bg-danger">{{ $perpanjanganditolak }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('nakes.perubahan', $user_id) }}"
                                       class="btn btn-outline-info w-100 d-flex justify-content-between align-items-center"
                                       id="rubahpermohonan">
                                        Perubahan
                                        @if ($perubahanditolak > 0)
                                            <span class="badge text-bg-danger">{{ $perubahanditolak }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('nakes.pencabutan', $user_id) }}"
                                       class="btn btn-outline-danger w-100 d-flex justify-content-between align-items-center"
                                       id="cabutpermohonan">
                                        Pencabutan
                                        @php
                                            $count = 0;
                                            foreach ($allsalinan as $all) {
                                                if ($all->isApproved == '4') {
                                                    if ($all->alasan_ditolak != null || $all->alasan_ditolak != '') {
                                                        $count++;
                                                    }
                                                }
                                            }
                                        @endphp
                                        @if ($count > 0)
                                            <span class="badge text-bg-danger">{{ $count }}</span>
                                        @endif
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('nakes.historikal', $user_id) }}"
                                       class="btn btn-outline-secondary w-100 d-flex justify-content-between align-items-center"
                                       id="historipermohonan">
                                        Histori
                                    </a>
                                </li>
                                <li class="nav-item" @if ($issiplama == 0) style="display:none" @endif>
                                    <button type="button"
                                            class="btn btn-outline-primary w-100 d-flex justify-content-between align-items-center"
                                            id="sipmanual" data-id="{{ $user_id }}" data-dokter="{{ $isdokter }}">
                                        Upload SIP Manual
                                        @if ($sipmanualditolak > 0)
                                            <span class="badge text-bg-danger">{{ $sipmanualditolak }}</span>
                                        @endif
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--end::Kartu profil-->

                    <!--begin::Kartu kalender-->
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="far fa-calendar-alt me-2"></i>Calendar
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse" title="Lipat">
                                    <i data-lte-icon="expand" class="fas fa-plus"></i>
                                    <i data-lte-icon="collapse" class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-lte-toggle="card-remove" title="Tutup">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <div id="calendar" class="w-100" data-id="{{ $user_id }}"></div>
                            <hr>
                            <p class="mb-0 text-body-secondary">Acara / Visitasi Bulan Ini:</p>
                        </div>
                    </div>
                    <!--end::Kartu kalender-->
                </div>
                <!--end::Kolom kiri-->

                <!--begin::Kolom kanan: pengajuan, QR STR dan informasi-->
                <div class="col-lg-8">

                    <!--begin::STR Diajukan-->
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">STR Diajukan</h3>
                        </div>

                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-striped align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th scope="col">Salinan</th>
                                            <th scope="col">Lokasi</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-end">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($allsalinan as $rowi)
                                        <tr>
                                            <td>{{ $rowi->salinan }}</td>

                                            <td>
                                                @if($rowi->isDiajukan == 1)
                                                    {{ $rowi->isFaskes == '1' ? $rowi->nama_faskes : $rowi->alamat_pengajuan }}
                                                @else
                                                    <span class="text-body-secondary">Belum Diajukan</span>
                                                @endif
                                            </td>

                                            <td>
                                                @if($rowi->isApproved == 'OP')
                                                    <span class="badge text-bg-info">Review Org Profesi</span>
                                                @elseif ($rowi->isApproved == '0')
                                                    <span class="badge text-bg-info">Review Dinkes</span>
                                                @elseif ($rowi->isApproved == 'E')
                                                    <span class="badge text-bg-warning">Belum Diperpanjang</span>
                                                @elseif ($rowi->isApproved == '1K')
                                                    <span class="badge text-bg-info">Review Kepala Dinkes</span>
                                                @elseif ($rowi->isApproved == '2')
                                                    <span class="badge text-bg-info">Review DPMPTSP</span>
                                                @elseif ($rowi->isApproved == '3')
                                                    <span class="badge text-bg-success">Disetujui DPMPTSP</span>
                                                @elseif ($rowi->isApproved == '4')
                                                    @if($rowi->alasan_ditolak != null || $rowi->alasan_ditolak != '')
                                                        <span class="badge text-bg-danger">Pencabutan Ditolak</span>
                                                    @else
                                                        <span class="badge text-bg-success">Disetujui</span>
                                                    @endif
                                                @elseif ($rowi->isApproved == '9')
                                                    <span class="badge text-bg-danger">Ditolak</span>
                                                @elseif ($rowi->isApproved == 'C')
                                                    <span class="badge text-bg-warning">Proses Pencabutan</span>
                                                @elseif ($rowi->isApproved == 'P2')
                                                    <span class="badge text-bg-info">Review DPMPTSP</span>
                                                @else
                                                    <span class="badge text-bg-secondary">Belum Diajukan</span>
                                                @endif
                                            </td>

                                            <td class="text-end">
                                                @if($rowi->isDiajukan != 1)
                                                    <span class="text-body-secondary">-</span>
                                                @elseif($rowi->isApproved == 'OP')
                                                    <button type="button" class="btn btn-sm btn-info uploadrekomop"
                                                            data-id="{{ $rowi->id_pengajuan }}"
                                                            data-bs-toggle="tooltip" data-bs-placement="left"
                                                            title="SEGERA UPLOAD SURAT KETERANGAN ORGANISASI PROFESI"
                                                            id="myTooltipButton{{ $rowi->salinan }}">Upload Suket OP</button>
                                                @elseif($rowi->isApproved == '9')
                                                    <a class="btn btn-sm btn-danger"
                                                       href="{{ route('nakes.pengajuan.edit', Auth::user()->id.'_'.$rowi->salinan.'_'.$rowi->id_pengajuan) }}">Ubah</a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger batalkanpengajuan"
                                                            data-id="{{ $rowi->id_pengajuan }}"
                                                            data-updater="{{ $user_id }}"
                                                            data-doc="{{ $rowi->id_doc }}">Batal</button>
                                                @elseif($rowi->isApproved == '4')
                                                    @if($rowi->alasan_ditolak == null || $rowi->alasan_ditolak == '')
                                                        <a class="btn btn-sm btn-success"
                                                           href="{{ route('nakes.kedetail.pengajuan', Auth::user()->id.'_'.$rowi->salinan) }}">Detail</a>
                                                    @else
                                                        <a class="btn btn-sm btn-warning"
                                                           href="{{ route('nakes.pencabutan', Auth::user()->id) }}">Detail</a>
                                                    @endif
                                                @elseif($rowi->isApproved == 'E')
                                                    <a class="btn btn-sm btn-success"
                                                       href="{{ route('nakes.perpanjangan', $user_id) }}">Perpanjang</a>
                                                @else
                                                    <a class="btn btn-sm btn-success"
                                                       href="{{ route('nakes.kedetail.pengajuan', Auth::user()->id.'_'.$rowi->salinan) }}">Detail</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--end::STR Diajukan-->

                    <!--begin::Hasil scan QR STR-->
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Hasil Scan QRCODE STR</h3>
                        </div>

                        @if($detail_pengaju->origin_file != 'scanned')
                            @if ($isKadaluarsa->kadaluarsa == '0')
                                <div class="card-body">
                                    @if((int)$isKadaluarsa->expiring_count <= 20)
                                        <div class="alert alert-danger alert-dismissible fade show">
                                            <h5 class="alert-heading">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                STR Anda Kadaluarsa {{ $isKadaluarsa->expiring_count }} Hari Lagi.
                                            </h5>
                                            Silahkan Update STR Anda Pada Menu Perpanjangan, Atau Ajukan Perpanjangan Sementara
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                                        </div>
                                        <a href="{{ route('nakes.perpanjangan.sementara', $user_id) }}"
                                           class="btn btn-primary w-100 mb-3" id="perpanjangansementara">Perpanjangan Sementara</a>
                                    @endif

                                    @if((int)$isKadaluarsa->expiring_count <= 60 && (int)$isKadaluarsa->expiring_count > 20)
                                        <div class="alert alert-warning alert-dismissible fade show">
                                            <h5 class="alert-heading">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                STR Anda Kadaluarsa {{ $isKadaluarsa->expiring_count }} Hari Lagi.
                                            </h5>
                                            Silahkan Update STR Anda Pada Menu Perpanjangan.
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                                        </div>
                                    @endif

                                    <div class="ratio ratio-21x9">
                                        <iframe id="provenID" src="{{ $qr_url }}" allowfullscreen></iframe>
                                    </div>
                                </div>
                            @else
                                <div class="card-body">
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <h5 class="alert-heading">
                                            <i class="fas fa-ban me-2"></i>KADALUARSA !
                                        </h5>
                                        STR Anda Telah Kadaluarsa Pada Tanggal {{ $isKadaluarsa->tgl_doc }}.
                                        Silahkan Upload Kembali Dokumen STR yang sudah diperbaharui.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>
                    <!--end::Hasil scan QR STR-->

                    <!--begin::Informasi-->
                    <div class="card card-primary card-outline mb-0">
                        <div class="card-header">
                            <h3 class="card-title">Informasi</h3>
                        </div>

                        <div class="card-body p-0">
                            <div class="timeline timeline-inverse p-3 mb-0 overflow-auto" style="max-height: 300px;">
                                @foreach($informasis as $inf)
                                    <div class="time-label">
                                        <span class="{{ $inf->jenis_informasi == '2' ? 'text-bg-danger' : 'text-bg-success' }}">{{ $inf->created_at }}</span>
                                    </div>

                                    <div>
                                        <i class="timeline-icon fas {{ $inf->jenis_informasi == '2' ? 'fa-exclamation-triangle text-bg-danger' : 'fa-envelope text-bg-success' }}"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i></span>
                                            <h3 class="timeline-header"><a href="#">{{ $inf->updater }}</a> Memberi Pesan</h3>
                                            <div class="timeline-body">
                                                {{ $inf->informasi }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!--end::Informasi-->
                </div>
                <!--end::Kolom kanan-->

            </div>
        </div>
    </div>
    <!--end::App Content-->
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