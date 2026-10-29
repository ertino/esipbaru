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
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List Pengajuan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped" id="listpengajuannakes">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th>Status</th>
                            <th>Tanggal Diajukan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach($listperpanjangan as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->nama_faskes}}</td>
                            <td>{{$row->alamat_pengajuan}}</td>
                            <td>
                            @if ($row->isApproved == 'P')
                              <span class="badge text-bg-warning">Belum Diperpanjang</span>
                            @endif
                            </td>
                            <td>{{$row->created_at}}</td>
                            <td>
                            <div class="button-group">
                            <a class="btn btn-sm btn-primary" href="{{ route('get.detail.pengajuan', $row->id) }}">Detail</a>
                            @if ($row->isApproved == 'P' || $row->isApproved == 'E')
                              <a class="btn btn-sm btn-info" href="{{ route('nakes.perpanjangan.pengajuan', $user_id.'_'.$row->salinan.'_'.$row->id.'_0') }}" id="perpanjangpengajuan">Perpanjang</a>
                              @else
                                @if($klasifikasi == '1' || $klasifikasi == '3' || $klasifikasi == '4' || $klasifikasi == '6' || $klasifikasi == '7')
                                <a class="btn btn-sm btn-info" href="{{ route('nakes.perpanjangan.pengajuan', $user_id.'_'.$row->salinan.'_'.$row->id.'_0') }}" id="perpanjangpengajuan">Perpanjang</a>
                                @endif
                              <!--<a class="btn btn-sm btn-info" href="{{ route('nakes.perpanjangan.pengajuan', $user_id.'_'.$row->salinan.'_'.$row->id.'_1') }}" id="perpanjangpengajuan">Perpanjang Sementara</a>-->
                              @endif
                            @if ($template_id == '2')
                            
                              <!-- <a class="btn btn-sm btn-info" href="{{ route('nakes.perpanjangan.pengajuandokter', $user_id.'_'.$row->salinan.'_'.$row->id) }}" id="perpanjangpengajuan">Perpanjang</a> -->
                              <!--<a class="btn btn-sm btn-secondary" href="{{ route('nakes.perpanjangan.pengajuan', $user_id.'_'.$row->salinan.'_'.$row->id.'_1') }}" id="perpanjangpengajuan">Perpanjang Sementara</a>-->
                        
                            @endif

                            </div>
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