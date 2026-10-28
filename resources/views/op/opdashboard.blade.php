@extends('layouts.minlte.back_master')
@section('content')
<div class="page-wrapper" >
    <!-- Content Header (Page header) -->
    <div class="page-header d-print-none" aria-label="Page header">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">Overview</div>
            <h2 class="page-title">Combo layout</h2>
          </div>
          <!-- Page title actions -->
          <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
              <span class="d-none d-sm-inline">
                <a href="#" class="btn btn-1"> New view </a>
              </span>
              <a href="#" class="btn btn-primary btn-5 d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                  <path d="M12 5l0 14"></path>
                  <path d="M5 12l14 0"></path>
                </svg>
                Create new report
              </a>
              <a href="#" class="btn btn-primary btn-6 d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-2">
                  <path d="M12 5l0 14"></path>
                  <path d="M5 12l14 0"></path>
                </svg>
              </a>
            </div>
            <!-- BEGIN MODAL -->
            <!-- END MODAL -->
          </div>
        </div>
      </div>
    </div>

    <!-- Main content -->
    <div class="page-body">
      <div class="container-xl">
        <div class="row row-deck row-cards">

          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List Pengajuan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
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
                    @foreach($pengajuan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->jenis_profesi}}</td>
                            @if($row->isFaskes == '0')
                            <td>{{$row->nama_faskes}} (Mandiri)</td>
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
                            <td><a class="btn btn-sm btn-primary" href="{{ route('get.detail.pengajuanop', $row->id) }}">Detail</a></td>
                        </tr>
                    @endforeach
                    
                    </tbody>
                </table>  
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

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
                    <div class="row">        
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchnamanakes" name="searchnamanakes" placeholder="Nama Pemohon">
                        </div>
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchlokasi" name="searchlokasi" placeholder="Lokasi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6  form-group has-feedback">
                            <input type="text" class="form-control" id="searchSTR" name="searchSTR" placeholder="Nomor STR">
                        </div>
                        <div class="col-md-3 col-sm-3  form-group has-feedback">
                          <input type="text" class="form-control" id="searchstartdate" name="searchstartdate" placeholder="Dari Tanggal YYYY-MM-DD">
                        </div>
                        <div class="col-md-3 col-sm-3  form-group has-feedback">
                          <input type="text" class="form-control" id="searchenddate" name="searchenddate" placeholder="Sampai Tanggal YYYY-MM-DD">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="LastName" class="col-sm-2 control-label"></label>
                        <div class="col-sm-4">
                            <button type="button" id="btn-filter" class="btn btn-primary">Filter</button>
                            <button type="button" id="btn-reset" class="btn btn-default">Reset</button>
                        </div>
                      </div>
                  </form>
                </div>
                <table class="table table-striped" id="historyapprovedop">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>Nomor STR</th>
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


        

        
      </div>
    </div>
</div>
  


  

@endsection
@section('js')

@endsection