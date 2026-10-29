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
        <div class="row" style="display:none">
          <form>
            <input id="fFaskes_id" value="{{$id_faskes}}">
          </form>
        </div>
  
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">List Nakes Pada Faskes</h3>
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-end" placeholder="Search">
                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-striped table-head-fixed text-nowrap" id="listallnakesonfaskes">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Foto</th>
                      <th>Nama</th>
                      <th width="15%">Profesi</th>
                      <th>Status Pengajuan</th>
                      <th>Berlaku Hingga</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach($allnakesonfaskes as $nakes)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td><img src="{{ URL::to('/storagefoto')}}/{{$nakes->foto_nakes}}" width="50px" alt="User Image"></td>
                      <td>{{$nakes->nama_nakes}}</td>
                      <td width="15%">{{$nakes->profesi}}</td>
                      <td>@if($nakes->isApproved < 4) @if($nakes->isApproved == 'P2') Pengajuan Perubahan @else {{$nakes->status_terakhir}} @endif @else Disetujui @endif</td>
                      <td>{{$nakes->tgl_doc}}</td>
                  @endforeach
                  </tbody>
                </table>
              </div>

              </div>
          </div>
          <div class="col-md-6 col-xs-12" style="display:none">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Latest Members</h3>
                    <div class="card-tools">
                        <span class="badge text-bg-danger">8 New Members</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="users-list clearfix">
                        <li>
                            <img src="{{ URL::to('/storagefoto')}}/170_t.jpeg" alt="User Image">
                            <a class="users-list-name" href="#">Alexander Pierce</a>
                            <span class="users-list-date">Today</span>
                        </li>
                        <li>
                            <img src="{{ URL::to('/storagefoto')}}/170_t.jpeg" alt="User Image">
                            <a class="users-list-name" href="#">Norman</a>
                            <span class="users-list-date">Yesterday</span>
                        </li>
                        <li>
                            <img src="{{ URL::to('/storagefoto')}}/170.jpeg" alt="User Image">
                            <a class="users-list-name" href="#">Jane</a>
                            <span class="users-list-date">12 Jan</span>
                        </li>
                        <li>
                          <img src="{{ URL::to('/storagefoto')}}/170.jpeg" alt="User Image">
                          <a class="users-list-name" href="#">John</a>
                        <span class="users-list-date">12 Jan</span>
                        </li>
                        <li>
                        <img src="{{ URL::to('/storagefoto')}}/170.jpeg" alt="User Image">
                        <a class="users-list-name" href="#">Alexander</a>
                        <span class="users-list-date">13 Jan</span>
                        </li>
                        <li>
                        <img src="{{ URL::to('/storagefoto')}}/170.jpeg" alt="User Image">
                        <a class="users-list-name" href="#">Sarah</a>
                        <span class="users-list-date">14 Jan</span>
                        </li>
                        <li>
                        <img src="dist/img/user4-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nora</a>
                        <span class="users-list-date">15 Jan</span>
                        </li>
                        <li>
                        <img src="dist/img/user3-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nadia</a>
                        <span class="users-list-date">15 Jan</span>
                        </li>
                        <li>
                        <img src="dist/img/user3-128x128.jpg" alt="User Image">
                        <a class="users-list-name" href="#">Nadia</a>
                        <span class="users-list-date">15 Jan</span>
                        </li>
                    </ul>

                </div>

                <div class="card-footer text-center">
                <a href="javascript:">View All Users</a>
                </div>

                </div>
            <!-- /.card -->
          </div>

          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Rekapitulasi Nakes</h3>
              </div>
              <div class="card-body p-0">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Profesi</th>
                      <th>Berpraktik / Mendaftar</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($total_nakes as $total)
                    <tr>
                      <td>{{$loop->iteration}}</td>
                      <td>{{strtoupper($total->profesi)}}</td>
                      <td>{{$total->totala}} / {{$total->totalb}}</td> 
                    </tr>
                  @endforeach
              </tbody>
              </table>
              </div>

              </div>
          
          
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
      var id_faskes = $('#fFaskes_id').val()

      function getallnakes(id_faskes) {

        $.ajax({
              type: 'ajax',
              method: 'get',
              url: '{{ route("get.esip.before")}}',
              data: {'id_faskes': id_faskes, _token: "{{ csrf_token() }}"},
              async: false,
              dataType: 'json',
              success: function(data){
                  console.log(data)

                  if(data.success == true) {

                  }

                  
              },
              error: function(request, status, error){
                  alert(request.responseText);
              }
          });

      }

        
    });
</script>

@endsection


