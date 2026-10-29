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

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- COLOR PALETTE -->
        
        
        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List Pengajuan SIP Manual
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
              
                <table class="table table-striped" id="tbllistpengajuansipmanual">
                  <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>Salinan</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th>Tanggal Diajukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($pengajuan as $row)
                        @php $id_pengajuan = 'M'.$row->id;
                        @endphp
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td><a class="toprofilingnakes" data-id="{{$row->id_nakes}}" href="#tbllistpengajuansipmanual">{{$row->name}}</a></td>
                            <td>{{$row->salinan}}</td>
                            @if($row->isFaskes == '0')
                            <td>(Mandiri)</td>
                            @else
                            <td>{{$row->nama_faskes}}</td>
                            @endif
                            <td>{{$row->alamat_pengajuan}}</td>
                            <td>{{$row->created_at}}</td>
                            <td><a class="btn btn-sm btn-primary" href="{{ route('get.detail.pengajuan', $id_pengajuan) }}">Detail</a></td>
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
                  List Pengajuan SIP Manual Telah Ditinjau
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="panel">
                  <form id="form-filter-p" class="form-label-left input_mask">
                    <div class="row">        
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchnamanakespm" name="searchnamanakes" placeholder="Nama Pemohon">
                        </div>
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchlokasipm" name="searchlokasi" placeholder="Lokasi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchSTRpm" name="searchSTR" placeholder="Nomor SIP">
                        </div>
                        <div class="col-md-3 col-sm-3  form-group has-feedback">
                          <input type="text" class="form-control" id="searchstartdatepm" name="searchstartdate" placeholder="Dari Tanggal YYYY-MM-DD">
                        </div>
                        <div class="col-md-3 col-sm-3  form-group has-feedback">
                          <input type="text" class="form-control" id="searchenddatepm" name="searchenddate" placeholder="Sampai Tanggal YYYY-MM-DD">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filterpm" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-resetpm" class="btn btn-default">Reset</button>
                        </div>
                      </div>
                  </form>
                </div>
                <div class="">
                  <table class="table table-striped" id="historyapprovedptspsipmanual">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama Pemohon</th>
                              <th>Salinan</th>
                              <th>Nomor SIP</th>
                              <th>Nama Faskes</th>
                              <th>Lokasi</th>
                              <th>Tanggal Diajukan</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody>
                      </tbody>
                  </table>
                </div>  
                
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

    $('#historyapprovedptspsipmanual').on('click','.viewdetailpengajuan', function(){

      var id_pengajuan = $(this).attr('data-id');
      var urled = '{{ route("get.detail.pengajuan", ":id") }}';
      urled = urled.replace(':id', id_pengajuan);
      $(this).attr('href', urled);

    })

    tablesm = $('#historyapprovedptspsipmanual').DataTable({ 
      
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "searching": false,
      scrollResize: true,
      scrollY: 500,
      scrollCollapse: true,
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
          "url": "{{route('get.histori.tinjauajuanmanual')}}",
          "type": "POST",
          "data": function ( data ) {
              data.nama_nakes = $('#searchnamanakespm').val();
              data.lokasi = $('#searchlokasipm').val();
              data.nostr = $('#searchSTRpm').val();
              data.startdate = $('#searchstartdatepm').val();
              data.enddate = $('#searchenddatepm').val();
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


      $('#btn-filterpm').click(function(){
        var nama_nakes = $('#searchnamanakespm').val();
        var lokasi = $('#searchlokasipm').val();
        var nostr = $('#searchSTRpm').val();
        var startdate = $('#searchstartdatepm').val();
        var enddate = $('#searchenddatepm').val();

        if ($.trim(nama_nakes) == '' && $.trim(lokasi) == '' && $.trim(enddate) == '' && $.trim(startdate) == '' && nostr == ''){
            alert('Mohon Isikan Salah Satu Kategori Pencarian');
        } else {
            tablesm.ajax.reload();
            
        }
      
      });

      $('#btn-resetp').click(function(){ //button reset event click
        $('#form-filter-p')[0].reset();
        tablesm.ajax.reload();  //just reload table
      });



  })

</script>
@endsection


