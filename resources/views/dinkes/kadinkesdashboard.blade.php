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
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List Pengajuan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-striped" id="tbllistpengajuan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>Salinan</th>
                            <th>Faskes / Tempat Praktik</th>
                            <th>Lokasi</th>
                            <th>Jenis</th>
                            <th>Tanggal Diajukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pengajuan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->salinan}}</td>
                            @if($row->isFaskes == '0')
                            <td>Praktik Mandiri</td>
                            @else
                            <td>{{$row->nama_faskes}}</td>
                            @endif
                            <td>{{$row->alamat_pengajuan}}</td>
                            <td>
                            @if ($row->perpanjangan == 0)
                              Pengajuan Awal
                            @else
                              Perpanjangan ke {{$row->perpanjangan}}
                            @endif
                            </td>
                            <td>{{$row->created_at}}</td>
                            <td><a class="btn btn-sm btn-primary" href="{{ route('get.detail.pengajuan', $row->id) }}">Detail</a></td>
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
                  List Pengajuan Telah Ditinjau
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="panel">
                <form id="form-filter" class="form-label-left input_mask">
                    <div class="row" style="display:none">
                      <input type="text" name="userrolesearch" value="{{Auth::user()->role;}}">
                    </div>
                    <div class="row">        
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchnamanakesd" name="searchnamanakes" placeholder="Nama Pemohon">
                        </div>
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchlokasid" name="searchlokasi" placeholder="Lokasi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchSTRd" name="searchSTR" placeholder="Nomor STR">
                        </div>
                        <div class="col-md-3 col-sm-3  form-group has-feedback">
                          <input type="date" class="form-control" id="searchstartdated" name="searchstartdate" placeholder="Dari Tanggal YYYY-MM-DD" value="{{date('Y-m')}}-01">
                        </div>
                        <div class="col-md-3 col-sm-3  form-group has-feedback">
                          <input type="date" class="form-control" id="searchenddated" name="searchenddate" placeholder="Sampai Tanggal YYYY-MM-DD" value="{{date('Y-m-d')}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filterx" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-resetx" class="btn btn-default">Reset</button>
                        </div>
                      </div>
                  </form>
                </div>
                <table class="table table-striped" id="historyapprovehdinkes">
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

    var tablehistori = $('#historyapprovehdinkes').DataTable({
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
      let formData = new FormData($('#form-filter')[0])
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
                    keterangan = '<br /><span class="badge badge-info">Pengajuan TTE</span>';
                } else if (pengajuan.isApproved == '4') {
                    keterangan = '<br /><span class="badge badge-success">TTE Selesai</span>';
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

    $('#btn-filterx').click(function(){
      gethistoriapproval();
    
    });
    $('#btn-resetx').click(function(){ //button reset event click
      $('#form-filter')[0].reset();
      //table.ajax.reload();  //just reload table
    });

    gethistoriapproval();
  })

</script>
@endsection