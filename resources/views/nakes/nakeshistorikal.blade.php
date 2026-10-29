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
        
            <div class="row" id="historiid" data-id="{{$user_id}}" data-surat="{{$surathost}}">

                <div class="col-md-12 col-xs-12">
                    <div class="row">
                        <div class="col-12">
                            <!-- Custom Tabs -->
                            <div class="card">
                                <div class="card-header d-flex p-0">
                                    <h3 class="card-title p-3">Histori Pengajuan</h3>
                                    <ul class="nav nav-pills ms-auto p-2">
                                        <li class="nav-item"><a class="nav-link active" href="#sal_1" data-bs-toggle="tab">Sal 1</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#sal_2" data-bs-toggle="tab">Sal 2</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#sal_3" data-bs-toggle="tab">Sal 3</a></li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="sal_1">

                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="timeline" id="isi_salinan1">
                                                    
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    <!-- /.tab-pane -->
                                        <div class="tab-pane" id="sal_2">

                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="timeline" id="isi_salinan2">
                                                    
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    <!-- /.tab-pane -->
                                        <div class="tab-pane" id="sal_3">

                                            <div class="row">
                                                <div class="col-md-12">

                                                    <div class="timeline" id="isi_salinan3">
                                                    
                                                        
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                           
                                        </div>
                                    <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                                <div class="overlay" id="tungguhistorikal">
                                    <i class="fas fa-2x fa-sync-alt"></i>
                                </div>
                            </div>
                            <!-- ./card -->
                        </div>
                        <!-- /.col -->
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

        function renderSalinanTimeline(salinanArray, suffix) {

            const container = $(`#isi_salinan${suffix}`);
            container.empty();
            if (!Array.isArray(salinanArray) || salinanArray.length === 0) {
                container.append(`
                    <blockquote class="quote-secondary">
                        <p>Tidak Ada Data Yang Dapat Ditampilkan</p>
                    </blockquote>
                `);
                return;
            }
            $.each(salinanArray, function (index, item) {
                let html = `
                    <div class="time-label">
                        <span class="bg-red">${item.signed_date}</span>
                    </div>
                    <div>
                        <i class="fas fa-file bg-blue"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">e-SIP Salinan ${item.salinan_terbilang}</h3>
                            <div class="timeline-body">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="row">
                                            <div class="col-12">
                                                <embed src="${url}${item.filename_sip}.pdf" width="100%" height="300px"></embed>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-xs-12">
                                        <p class="lead">Detail e-SIP</p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:40%">Lokasi:</th>
                                                        <td>${item.nama_faskes || ''} ${item.nama_lokasi}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tanggal TTE:</th>
                                                        <td>${item.signed_date}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>TTE Oleh:</th>
                                                        <td>${item.nama_tte}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Berlaku Hingga:</th>
                                                        <td>${item.valid_until}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Status:</th>
                                                        <td>${item.status_sip_l || '-'}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-footer">
                                <a class="btn btn-primary btn-sm">Read more</a>
                            </div>
                        </div>
                    </div>
                `;
                container.append(html);
            });
        }
        var user_id = $('#historiid').data('id');
        var url = $('#historiid').attr('data-surat')

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("nakes.sip.historikal")}}',
            data: {'id_user': user_id , _token: "{{ csrf_token() }}"},
            dataType: 'json',
            beforeSend: function(){
                $('#tungguhistorikal').show()
            },
            success: function(data){
                $('#tungguhistorikal').hide()
                console.log(data.result)
                renderSalinanTimeline(data.result.salinan1, '1');
                renderSalinanTimeline(data.result.salinan2, '2');
                renderSalinanTimeline(data.result.salinan3, '3');
                
            },
            complete: function(data) {
                $('#tungguhistorikal').hide()
            },
            error: function(request, status, error){
                $('#tungguhistorikal').hide()
                alert(request.responseText);
            }
        });  





     })

</script>
@endsection