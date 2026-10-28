@extends('layouts.minlte.back_master')
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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- COLOR PALETTE -->

        <div class="row">
            <div id="modal-listhistori-content" style="display: none;">
                <center>
                <i class="fas fa-hourglass"></i>
                <h5>Mohon Tunggu..</h5>
                </center>
            </div>
        </div>

        <div class="row">
          <div id="modal-revert-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">

            <div class="card">
              <div class="card-header">
                <div class="card-title" id="juduldraftsip">
                    Konfirmasi TTE Ulang
                </div>
                <div class="card-tools">
                    
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                        <i class="fas fa-expand"></i>
                    </button>
                    <button type="button" class="btn btn-secondary btn-sm float-right tutuprevert">x</button>
                </div>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <form>
                      <div class="row">
                        <div class="col-md-4 col-xs-4" >
                          <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Nama Nakes</label>
                              <input type="text" id="namarevert" name="namarevert" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="col-md-2 col-xs-2" >
                          <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                              <input type="text" id="salinanrevert" name="salinanrevert" class="form-control" readonly>
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-6" >
                          <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                              <input type="text" id="alamatrevert" name="alamatrevert" class="form-control" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 col-xs-12" >
                          <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Alasan TTE Ulang</label>
                              <input type="text" id="alasanrevert" name="alasanrevert" class="form-control" required>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <div class="alert alert-warning alert-dismissible">
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                            Mohon Untuk Periksa Dan Pastikan Data Pengajuan Yang Akan Diproses Terlebih Dahulu Sebelum Melakukan TTE Ulang.
                          </div>
                        </div>
                      </div>
                      
                    </form>
                    <div class="row">
                      <div class="col-md-12 col-xs-12">
                        <button id="revertesip" class="btn btn-block btn-outline-warning">Submit</button>
                      </div>
                    </div>
                  </div>
                </div>
                  
              </div>
              <div class="overlay" id="ovrevert" style="display:none">
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
                  List Pengajuan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
              
                <table class="table table-striped" id="tbllistpengajuan">
                  <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>Salinan</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th>Jenis</th>
                            <th>Tanggal Diajukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    
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
                  List Perubahan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
                <table class="table table-striped" id="tbllistperubahan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>Salinan</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th>Jenis</th>
                            <th>Tanggal Diajukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    
                    <tbody>
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
                  List Pengajuan Telah Ditinjau
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="panel">
                  <form id="form-filter-p" class="form-label-left input_mask">
                    <div class="row" style="display:none">
                      <input type="text" name="userrolesearch" value="{{Auth::user()->role;}}">
                    </div>
                    <div class="row">        
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchnamanakesp" name="searchnamanakes" placeholder="Nama Pemohon">
                        </div>
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchlokasip" name="searchlokasi" placeholder="Lokasi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchSTRp" name="searchSTR" placeholder="Nomor STR">
                        </div>
                        <div class="col-md-3 col-sm-3  form-group has-feedback">
                          <input type="date" class="form-control" id="searchstartdatep" name="searchstartdate" placeholder="Dari Tanggal YYYY-MM-DD" value="{{date('Y-m')}}-01">
                        </div>
                        <div class="col-md-3 col-sm-3  form-group has-feedback">
                          <input type="date" class="form-control" id="searchenddatep" name="searchenddate" placeholder="Sampai Tanggal YYYY-MM-DD" value="{{date('Y-m-d')}}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filterpx" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-resetpx" class="btn btn-default">Reset</button>
                        </div>
                      </div>
                  </form>
                </div>
                <div class="">
                  <table class="table table-striped" id="historyapprovepengajuan">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama Pemohon</th>
                              <th>Salinan</th>
                              <th>Nomor STR</th>
                              <th>Nama Faskes</th>
                              <th>Lokasi</th>
                              <th>Jenis</th>
                              <th>Tanggal Diajukan</th>
                              <th>Tanggal TTE</th>
                              <th>STR Ditahan</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody id="bodyhistorikal">
                      </tbody>
                  </table>
                </div>  
                
              </div>
              <div class="overlay" id="onloadhistory" style="display:none">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
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

    var tablehistori = $('#historyapprovepengajuan').DataTable({
      dom: 'Blfrtip',
      "lengthMenu": [
            [10, 25, 50, 100, 1000, -1], [10, 25, 50, 100, 1000, "All"]
        ],
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

      columns: [
          { data: 'no', orderable: false },
          { data: 'name' },
          { data: 'salinan' },
          { data: 'no_doc' },
          { data: 'nama_faskes' },
          { data: 'alamat_pengajuan' },
          { data: 'perubahan' },
          { data: 'created_at' },
          { data: 'tte_stat' },
          { data: 'ditahan' },
          { data: 'action', orderable: false }
      ],
      //dom: '<"datatable-header dt-buttons-right"fB><"datatable-scroll"tS><"datatable-footer"i>',
      //autoWidth: false,
      scrollX: true,
      scrollY: 450,
      scrollCollapse: true
    })

    function gethistoriapproval(){
      let link = `{{route('get.histori.pengajuan')}}`;
      let formData = new FormData($('#form-filter-p')[0])
      formData.append('_token', '{{ csrf_token() }}');
      tableLoading = true;
      $.ajax({
        url: link,
        data: formData,
        cache:false,
        dataType: 'JSON',
        contentType: false,
        processData: false,
        method: "POST",
        enctype: 'multipart/form-data',
        beforeSend: function() {

            $('#onloadhistory').show()
            
        },
        success: function (data) {
            
            $('#onloadhistory').hide()
            if (data.success === true) {
                
              var processedData = [];
              var no = 1;

              data.pengajuan.forEach(function(pengajuan) {
                var ditahan = '-';
                var jerapi = pengajuan.perubahan == 0 ? 'Pengajuan Awal' : 'Perubahan Ke ' + pengajuan.perubahan;
                var nama_faskes = pengajuan.isFaskes == 1 ? pengajuan.nama_faskes : 'Mandiri';
                var keterangan = '';
                var tte_stat = pengajuan.status_tte != 'Belum TTE' ? pengajuan.status_tte : pengajuan.status_tte;

                if (pengajuan.isApproved == '3') {
                    keterangan = '<br /><span class="badge badge-info">Direview Verifikator PTSP</span>';
                } else if(pengajuan.isApproved == '2') {
                    keterangan = '<br /><span class="badge badge-info">Direview Admin PTSP</span>';
                }else if(pengajuan.isApproved == '1') {
                    keterangan = '<br /><span class="badge badge-info">Disetujui Disetujui Dinkes</span>';
                }else if(pengajuan.isApproved == '0') {
                    keterangan = '<br /><span class="badge badge-info">Direview Dinkes</span>';
                }else if (pengajuan.isApproved == '4') {
                    keterangan = '<span class="badge badge-success">TTE Selesai</span>';
                } else if (pengajuan.isApproved == '9') {
                    keterangan = '<br /><span class="badge badge-danger">Ditolak</span>';
                } else if (pengajuan.isApproved == 'CF') {
                    keterangan = '<br /><span class="badge badge-danger">Dicabut</span>';
                }

                if (pengajuan.template_id == '2') {
                    ditahan = 'Belum Menyerahkan STR';
                    if (pengajuan.isApproved == '4' && pengajuan.ditahan == '1') {
                        ditahan = 'Sudah Diserahkan';
                    }
                }

                processedData.push({
                    no: no++,
                    name: '<a class="toprofilingnakes" href="#historyapprovedptsp" data-id="' + pengajuan.id_user + '">' + pengajuan.name + '</a>',
                    salinan: pengajuan.salinan,
                    no_doc: pengajuan.no_doc,
                    nama_faskes: nama_faskes,
                    alamat_pengajuan: pengajuan.alamat_pengajuan,
                    perubahan: jerapi,
                    created_at: pengajuan.created_at,
                    tte_stat: tte_stat,
                    ditahan: ditahan,
                    action: '<a class="btn btn-sm btn-primary viewdetailpengajuan" data-id="' + pengajuan.id + '" href="">Detail</a>' + keterangan
                });
              });
            
              tablehistori.clear();
              tablehistori.rows.add(processedData).draw();

              $('#onloadhistory').hide()
                
            } else {
                $('#onloadhistory').hide()
                $('#bodyhistorikal').empty();
                Swal.fire('Tidak Ada Data Yang Dapat Ditampilkan');
            }
            tableLoading = false;
        },
        error: function(request, status, error){
            $('#onloadhistory').hide()
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Error Menampilkan Data Pengajuan',
            })
        }
      });
    }

    $('#btn-filterpx').click(function(){
      gethistoriapproval();
    
    });
    $('#btn-resetpx').click(function(){ //button reset event click
      $('#form-filter-p')[0].reset();
      //table.ajax.reload();  //just reload table
    });

    $('#historyapprovepengajuan').on('click','.reverttte', function(){
      var id = $(this).attr('data-id')
      var nama = $(this).attr('data-nama')
      var salinan = $(this).attr('data-salinan')
      var alamat = $(this).attr('data-alamat')
      $('#salinanrevert').val(salinan)
      $('#namarevert').val(nama)
      $('#alamatrevert').val(alamat)
      $('#revertesip').attr('data-id', id)

      $.fancybox.open({
          src: '#modal-revert-content',
          type: 'inline',
          touch: false,
          modal: true,
          clickSlide: false,
          afterShow: function() {
              $('.tutuprevert').click(function() {
                  $.fancybox.close();
              });
          }
      });
    });
    

    $('#revertesip').click(function(){

      var id_pengajuan = $(this).attr('data-id')
      var alasan_revert = $('#alasanrevert').val()
      if(alasan_revert.trim() == '')
      {
        alert('Mohon Isikan Alasan TTE Ulang');

      } else {

        $.ajax({
          type: 'ajax',
          method: 'post',
          url: '{{ route("ptsp.revert.tte")}}',
          data: {'id_pengajuan': id_pengajuan, 'alasan_revert' : alasan_revert, _token: "{{ csrf_token() }}"},
          cache:false,
          dataType: 'json',
          beforeSend: function(){

              $('#ovrevert').show()
              
          },
          success: function(data){
              
              $('#ovrevert').hide()
              if(data.success == true) {
                  $.fancybox.close();
                  gethistoriapproval();
              } else {
                  alert(data.keterangan)
              }
          },
          error: function(request, status, error) {
              $('#ovrevert').hide()
              alert(request.responseText);
          }
        });

      }
      

      

    })

    gethistoriapproval();
  })

</script>
@endsection


