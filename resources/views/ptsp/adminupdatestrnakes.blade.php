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

        <div class="row">
            <div id="modal-userfaskes-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>Manage User Faskes</h5> 
                        </div>
                        <div class="card-tools">
                        <button type="button" class="btn btn-secondary btn-sm float-end" id="close-userfaskes-modal">Close</button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form enctype="multipart/form-data" id="formuserfaskes" action="{{ route('simpan.user.faskes') }}" method="post" class="form-horizontal">
                            @csrf

                            <div class="row">
                                <div class="col-md-12 col-xs-12" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Nama User Faskes</label>
                                        <input type="text" id="fNamaUserFaskes" name="fNamaUserFaskes" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-xs-12" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Username (email) </label>
                                        <input type="email" id="fUsernameFaskes" name="fUsernameFaskes" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Password</label>
                                        <div class="input-group input-group">
                                            <input type="password" class="form-control" id="fPassFaskes" name="fPassFaskes" required>
                                            <span class="input-group-append">
                                            <button type="button" class="btn btn-default btn-flat intippass"><i class="fas fa-eye"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">No WA</label>
                                        <input type="text" id="fWAFaskes" name="fWAFaskes" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Logo Faskes</label>
                                        <input type="file" id="fLogoFaskes" name="fLogoFaskes" class="form-control" accept="image/jpeg" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 col-xs-6" style="display:none">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">id Faskes</label>
                                        <input type="text" id="fIDFaskes" name="fIDFaskes" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Nama Faskes</label>
                                        <input type="text" id="fNamaFaskes" name="fNamaFaskes" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Alamat Faskes</label>
                                        <input type="text" id="fAlamatFaskes" name="fAlamatFaskes" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row" style="display:none">
                                <div class="col-md-4 col-xs-12" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Updater</label>
                                        <input type="text" id="ePengajuanFaskes" name="ePengajuanFaskes" class="form-control" value="{{$user_id}}">
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-12" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">is Edit</label>
                                        <input type="text" id="fIsUbah" name="fIsUbah" class="form-control" value="0">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" id="btnsubmituserfaskes" class="btn btn-success">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
       

        <div class="row">
            <div id="modal-faskes-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h4>Tambah Fasyankes</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="managefaskesform" action="{{route('submit.manage.faskes')}}" method="post" class="form-horizontal">
                                @csrf

                                    <div class="row" style="display:none">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Status Faskes</label>
                                                <input type="text" class="form-control" id="jenissubmitfasyankes" name="jenissubmitfasyankes" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">ID faskes</label>
                                                <input type="text" class="form-control" id="idfaskyankes" name="idfaskyankes" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Status Faskes</label>
                                                <select type="text" class="form-control" id="statusfasyankes" name="statusfasyankes">
                                                  <option value="1" selected>Aktif</option>
                                                  <option value="0">Tidak Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Nama Fasyankes</label>
                                                <input type="text" class="form-control" id="namafasyankes" name="namafasyankes" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Nomor Ijin</label>
                                                <input type="text" class="form-control" id="noijinfasyankes" name="noijinfasyankes" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Alamat Fasyankes</label>
                                                <textarea type="text" class="form-control" id="alamatfasyankes" name="alamatfasyankes" required></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                <input type="text" class="form-control" id="kecfasyankes" name="kecfasyankes" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                                <input type="text" class="form-control" id="kabfasyankes" name="kabfasyankes" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Latitude</label>
                                                <input type="text" class="form-control" id="latfasyankes" name="latfasyankes" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Longitude</label>
                                                <input type="text" class="form-control" id="longfasyankes" name="longfasyankes" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">No Telp</label>
                                                <input type="text" class="form-control" id="notelpfasyankes" name="notelpfasyankes" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Jam Kerja</label>
                                                <textarea class="form-control" id="jkfasyankes" name="jkfasyankes"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-success" id="submitfaskesbaru">Tambah</button>
                                    <button type="submit" class="btn btn-success" id="submitubahfaskes">Update</button>
                                </form> 
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-secondary float-end" id="close-faskes-modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List Nakes STR Belum Seumur Hidup
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
              <div class="card-body table-responsive">

                <table class="table table-striped dataTable dtr-inline" id="tblpendaftar">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>No Reg STR</th>
                            <th>Profesi</th>
                            <th>Valid Hingga</th>
                            <th>Total e-SIP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach($nonsu as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                
                                @if($row->foto_not_avail == '1')
                                <img src="{{ URL::to('/storagefotokosong')}}/{{$row->id}}.jpg" width="50px" alt="user image">
                                @else
                                <img src="{{ URL::to('/storagefoto')}}/{{$row->id_user}}.jpeg" width="50px" alt="user image">
                                @endif

                            </td>
                            <td>{{$row->nama}}</td>
                            <td>{{$row->no_reg}} 
                            @if ($row->origin_file != 'scanned')
                            &nbsp; &nbsp;<a href="{{ route('get.origin.str', $row->origin_file.'.pdf')}}" target="_blank"><i class="fas fa-file"></i></a>
                            @endif
                            </td>
                            <td>{{$row->profesi}}</td>
                            <td>{{$row->tgl_doc}}</td>
                            <td>{{$row->total_pengajuan}}</td>
                            <td>
                                <div class="btn-group">
                                    <button href="" class="btn btn-sm btn-info">Detail</button>
                                    <a href="{{ route('admin.update.str', $row->id_user)}}" class="btn btn-sm btn-success">Update</a>
                                </div>
                            
                            </td>
                        </tr>
                    @endforeach
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

        

        
    })
</script>
@endsection