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
                                <form id="managefaskesform" enctype="multipart/form-data" action="{{route('submit.manage.faskes')}}" method="post" class="form-horizontal">
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
                                                <label for="exampleFormControlSelect1" class="ms-0">Foto Faskes</label>
                                                <input type="file" class="form-control" id="fotofaskes" name="fotofaskes" accept=".jpg,.jpeg,image/jpeg" required>
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
                  List Fasyankes
                </h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary btn-sm float-end btnmanagefaskes" data-jenis="add"><i class="fas fa-plus"></i> Faskes</button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                
                <table class="table table-striped" id="tabelfaskesmanage" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 10px">No</th>
                            <th style="display:none">ID FASKES</th>
                            <th>Nama Faskes</th>
                            <th>Alamat Faskes</th>
                            <th>Kecamatan Faskes</th>
                            <th>Kabupaten Faskes</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Aksi</th>  
                        </tr>
                    </thead>
                    <tbody id="pilihanfaskesmanage">
                    @foreach($allfaskes as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td style="display:none">{{$row->id_faskes}}
                            <td>{{$row->nama_faskes}}</td>
                            <td>{{$row->alamat_faskes}}</td>
                            <td>{{$row->kecamatan_faskes}}</td>
                            <td>{{$row->kabupaten_faskes}}</td>
                            <td>{{$row->latitude}}</td>
                            <td>{{$row->longitude}}</td>
                            <td>
                            <div class="btn-group">
                            <button type="button" class="btn btn-sm btn-primary btnmanagefaskes" data-jenis="edit" data-id="{{$row->id_faskes}}" data-nama="{{$row->nama_faskes}}" data-alamat="{{$row->alamat_faskes}}" data-kecamatan="{{$row->kecamatan_faskes}}" data-kabupaten="{{$row->kabupaten_faskes}}" data-latitude="{{$row->latitude}}" data-longitude="{{$row->longitude}}" data-remark="{{$row->remark}}" data-notelp ="{{$row->no_telp}}" data-jk="{{$row->jam_kerja}}">Edit</button> 
                            <button type="button" class="btn btn-sm btn-danger btnmanagefaskes" data-jenis="issue" data-id="{{$row->id_faskes}}" data-notelp ="{{$row->no_telp}}" data-jk="{{$row->jam_kerja}}">Issue</button>
                            <button type="button" class="btn btn-sm btn-success btnadduserfaskes" data-nama="{{$row->nama_faskes}}" data-id="{{$row->id_faskes}}" data-alamat="{{$row->alamat_faskes}}">User</button>
                            <button type="button" class="btn btn-sm btn-secondary btndetailfaskes" data-nama="{{$row->nama_faskes}}" data-id="{{$row->id_faskes}}" data-alamat="{{$row->alamat_faskes}}"><i class="fas fa-eye"></i></button>     
                            </div>      
                            
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

        $('#tabelfaskesmanage').on('click','.btnadduserfaskes', function(){
            var id_faskes = $(this).attr('data-id')
            var nama_faskes = $(this).attr('data-nama')
            var alamat_faskes = $(this).attr('data-alamat')

            $('#fNamaFaskes').val(nama_faskes)
            $('#fAlamatFaskes').val(alamat_faskes)
            $('#fIDFaskes').val(id_faskes)
            $('#fNamaUserFaskes').val('User '+nama_faskes)

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.user.faskes")}}',
                data: {'id_faskes': id_faskes,  _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function(data){
                    console.log(data)
                    if(data.success == true) {
                        if(data.result.length > 0) {
                            var username_faskes = data.result[0].username;
                            var nowa = data.result[0].photo_url;
                            var namauserfaskes = data.result[0].name;

                            $('#fNamaUserFaskes').val(namauserfaskes);
                            $('#fWAFaskes').val(nowa);
                            $('#fUsernameFaskes').val(username_faskes);
                            $('#fIsUbah').val('1')
                        }
                        

                        $.fancybox.open({
                            src: '#modal-userfaskes-content',
                            type: 'inline',
                            touch: false,
                            modal: true,
                            clickSlide: false,
                            afterShow: function() {
                                $('#close-userfaskes-modal').click(function() {
                                    $.fancybox.close();
                                });
                            }
                        });

                    } else {
                        alert(data.keterangan)
                    }
                },
                error: function(request, status, error){
                    //alert(request.responseText);
                }
            });
        })

        
    })
</script>
@endsection