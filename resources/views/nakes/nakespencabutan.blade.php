@extends('layouts.adminlte4.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang Di eSIP</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- COLOR PALETTE -->

        <div class="row">
          <div id="modal-tunggudraftcabut-content" style="display: none;">
              <center>
              <i class="fas fa-hourglass"></i>
              <h5>Mohon Tunggu..</h5>
              </center>
          </div>
        </div>

        <div class="row">
          <div id="modal-lihatdraft-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
            <div class="card">
              <div class="card-header">
                <div class="card-title" id="juduldraftcabutsip">
                    Surat Pencabutan SIP
                </div>
                <div class="card-tools">
                  <a type="button" id="donlitdraftcabutsip" class="btn btn-outline-success btn-sm" target="_blank"><i class="fas fa-download"></i></a>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <iframe class="embed-responsive-item" id="lihatdraftcabutnya" width="100%" height="450px" src=""></iframe>
                    </div>
                </div>
                <!-- <div class="row">
                  <div class="alert alert-info alert-dismissible">
                    <h5 id="keterangancetakpencabutan"><i class="icon fas fa-info"></i> Alert!</h5>
                    
                  </div>
                </div> -->
              
              </div>
              <div class="card-footer">
                <div class="btn-group">
                  <button type="button" class="btn btn-secondary btn-sm float-end tutupintipdraftcabut" id="close-lihatdraft-modal">Tutup</button>
                </div>
              </div>
              <div class="overlay" id="sedangrevertdraftcabut" style="display:none">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
            </div>
          </div>
        </div>
        
        
        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List Pengajuan Pencabutan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-striped" id="listpengajuannakes">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis SIP</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Tanggal Diajukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pengajuan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            @if($row->siplama == '1')
                            <td>Non Elektronik</td>
                            @else
                            <td>Elektronik</td>
                            @endif
                            <td>{{$row->nama_faskes}}</td>
                            <td>{{$row->alamat_pengajuan}}</td>
                            <td>
                            @if ($row->isApproved == 'C')
                              <span class="badge text-bg-warning">Pengajuan Pencabutan</span>
                            @elseif ($row->isApproved == 4)
                              @if($row->alasan_ditolak != null || $row->alasan_ditolak != '')
                              <span class="badge text-bg-warning">DITOLAK</span>
                              <span class="badge text-bg-warning">{{$row->alasan_ditolak}}</span>
                              @else
                              <span class="badge text-bg-success">Dokumen Sudah Disetujui</span>
                              @endif
                            @endif
                            </td>
                            <td>{{$row->updated_at}}</td>
                            <td>
                            <div class="btn-group">
                            @if($row->siplama == '0')<a class="btn btn-sm btn-primary" href="{{ route('get.detail.pengajuan', $row->id) }}">Detail</a>
                            @endif
                            @if ($row->isApproved == 4)
                            <button class="btn btn-sm btn-danger cabutpengajuan" data-id="{{$row->id}}" data-user="{{$user_id}}" data-jenisprof="{{$row->jenis_profesi}}" data-salinan ="{{$row->salinan}}" data-sip="{{$row->id_sip}}" data-template="{{$row->template_id}}">Cabut</button>
                            </div>
                            @endif
                            @if ($row->verifdinkes != 1 && ($row->jenis_profesi == 'APJ' || ($row->template_id == '4' || $row->template_id == 'M')))
                            <a class="btn btn-sm btn-secondary" href="{{ route('dokpencabutan', $row->id) }}">Dokumen</a>
                            @endif
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>  
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  Histori Pengajuan Pencabutan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-striped" id="listpencabutanhistnakes">
                    <thead>
                        <tr>
                          <th>No</th>
                            <th>Jenis SIP</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Tanggal Diajukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody>

                    @foreach($pengajuanhist as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            @if($row->siplama == '1')
                            <td>Non Elektronik</td>
                            @else
                            <td>Elektronik</td>
                            @endif
                            <td>{{$row->nama_faskes}}</td>
                            <td>{{$row->alamat_pengajuan}}</td>
                            <td>
                            @if ($row->isApproved == 'C')
                              <span class="badge text-bg-warning">Pengajuan Pencabutan</span>
                            @elseif ($row->isApproved == 4)
                              @if($row->alasan_ditolak != null || $row->alasan_ditolak != '')
                              <span class="badge text-bg-warning">DITOLAK</span>
                              <span class="badge text-bg-warning">{{$row->alasan_ditolak}}</span>
                              @else
                              <span class="badge text-bg-success">Dokumen Sudah Disetujui</span>
                              @endif
                            @elseif ($row->isApproved == 'CF')
                              <span class="badge text-bg-success">Dokumen Sudah Disetujui</span>
                            @endif
                            </td>
                            <td>{{$row->updated_at}}</td>
                            <td>
                            <div class="btn-group">
                              <a class="btn btn-sm btn-primary" href="https://surat.cilacapkab.go.id/assets/uploads/maker/approved/{{$row->filename_pencabutan}}.pdf" target="_blank">Download</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>  
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
    $(document).ready(function() {

      
      $('#listpengajuannakes').on('click','.dokpencabutan', function(){

        var id_sip = $(this).attr('data-id')
        var id_nakes = $(this).attr('data-user')
        var salinan = $(this).attr('data-salinan')
        
      })

      $('#listpencabutanhistnakes').on('click','.nakescetakpencabutan', function(){

        var id_sip = $(this).attr('data-id')
        var status_csip = $(this).attr('data-info')
        var id_nakes = $(this).attr('data-nakes')
        var id_pengajuan = $(this).attr('data-aju')
        var perubahan = $(this).attr('data-peru')
        var nama_nakes = $(this).attr('data-nama')
        var hostsurat = $(this).attr('data-surat')
        var hostsuratdraft = $(this).attr('data-suratdraft')
        var filename_pencabutan = $(this).attr('data-file')
        if(status_csip == '1') {
          var surathost = hostsurat
        } else {
          var surathost = hostsuratdraft
        }

        
        if(status_csip == '0') {

          Swal.fire({
            title: 'Apakah Anda Yakin Untuk Request Surat Pencabutan SIP Berikut?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak',
            
          }).then((result) => {
            console.log(result)
            if (result.value) {
              
              $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("drafting.pencabutan.sip")}}',
                data: {'id_pengajuan': id_pengajuan, 'id_sip' : id_sip, 'perubahan': perubahan, 'status_csip': 'R', 'id_nakes': id_nakes, _token: "{{ csrf_token() }}"},
                //async: false,
                dataType: 'json',
                success: function(data){

                  if(data.success == true) {
                    Swal.fire({
                      icon: 'success',
                      title: 'Permintaan Diproses',
                      showConfirmButton: false,
                      timer: 1500,
                      onClose: () => {
                        location.reload();
                      }
                    });
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Permintaan Gagal! Silahkan Coba Kembali'
                      })
                  }
                },
                error: function(request, status, error){
                  alert('Terjadi Kesalahan Pada System')
                }
                
              });
            }
            
          });

          
        } else if (status_csip == 'R') {

          Swal.fire('Permintaan Sedang Diajukan, Mohon Ditunggu')

        } else {

          var randomis = Math.floor((Math.random()*1000000) + 1)
          urlsurat = surathost+filename_pencabutan+'.pdf'+ "?dummy="+ randomis;
          $('#lihatdraftcabutnya').attr('src', urlsurat)
          $('#donlitdraftcabutsip').attr('href', urlsurat)
          

          $.fancybox.open({
            src: '#modal-lihatdraft-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false,
            afterShow: function() {
              $('.tutupintipdraftcabut').click(function() {
                  $.fancybox.close();
              });
            }
          });
          

        }

      })

    });
</script>
@endsection