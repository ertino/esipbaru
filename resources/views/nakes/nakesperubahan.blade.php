@extends('layouts.minlte.back_master')
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
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List SIP untuk Perubahan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-striped" id="listpengajuannakes">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No SIP</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Tanggal Diajukan</th>
                            <th>Tanggal Disetujui</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach($pengajuan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->no_surat}}</td>
                            <td>
                            @if ($row->nama_faskes == '0')
                              Mandiri
                            @else
                             {{$row->nama_faskes}}
                            @endif
                            </td>
                            
                            <td>{{$row->alamat_pengajuan}}</td>
                            <td>
                            @if ($row->isApproved == 'C')
                              <span class="badge badge-warning">Pengajuan Pencabutan</span>
                            @elseif ($row->isApproved == 4)
                              <span class="badge badge-success">Dokumen Sudah Disetujui</span>
                            @endif
                            </td>
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->signed_date}}</td>
                            <td><a class="btn btn-sm btn-primary" href="{{ route('get.detail.pengajuan', $row->id) }}">Detail</a>
                            @if ($row->isApproved == 4)
                            <a class="btn btn-sm btn-danger ubahpengajuan" id="ubahpengajuan" href="{{ route('nakes.pengajuan.perubahan', $user_id.'_'.$row->salinan.'_'.$row->id) }}">Ubah</a>
                            @endif
                            </td>
                        </tr>
                    @endforeach
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
                  List Pengajuan Perubahan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-striped" id="listpengajuannakes">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No SIP</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Tanggal Diajukan</th>
                            <th>Tanggal Disetujui</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach($dirubah as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->no_surat}}</td>
                            <td>
                            @if ($row->nama_faskes == '0')
                              Mandiri
                            @else
                             {{$row->nama_faskes}}
                            @endif
                            </td>
                            
                            <td>{{$row->alamat_pengajuan}}</td>
                            <td>
                            @if ($row->isApproved == 'C')
                              <span class="badge badge-warning">Pengajuan Pencabutan</span>
                            @elseif ($row->isApproved == 4)
                              <span class="badge badge-success">Dokumen Sudah Disetujui</span>
                            @elseif ($row->isApproved == 2)
                              <span class="badge badge-info">Direview Dinkes</span>
                            @elseif ($row->isApproved == 3)
                              <span class="badge badge-info">Direview DPMPTSP</span>
                            @endif
                            </td>
                            <td>{{$row->created_at}}</td>
                            <td>{{$row->signed_date}}</td>
                            <td><a class="btn btn-sm btn-primary" href="{{ route('get.detail.pengajuan', $row->id) }}">Detail</a>
                            @if ($row->isApproved == 4)
                            <a class="btn btn-sm btn-danger ubahpengajuan" id="ubahpengajuan" href="{{ route('nakes.pengajuan.perubahan', $user_id.'_'.$row->salinan.'_'.$row->id) }}">Ubah</a>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                    <tbody>
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