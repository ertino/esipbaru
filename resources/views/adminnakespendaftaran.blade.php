@extends('layouts.minlte.back_master')
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
            <div id="modal-editfoto-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">

              <div class="card">
                <div class="card-header">
                    <div class="card-title" id="juduteditfoto">
                        Edit Foto :
                    </div>
                    <div class="card-tools">
                        <button type="button" class="btn btn-secondary btn-sm float-right tutupeditfoto">x</button>
                    </div>
                </div>
                <div class="card-body">

                  <div class="row mb-3" id="komperfoto">
                  </div>

                  <form enctype="multipart/form-data"  id="submiteditfoto" action="" method="post" class="form-horizontal">
                  @csrf
                    <div class="row">
                      <div class="form-group" style="display:none">
                          <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                          <div class="input-group input-group">
                              <input class="form-control" id="idusereditfoto" name="idusereditfoto">
                          </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">

                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="tFotoEdit" name="tFotoEdit" accept=".jpeg" required>
                            <label class="custom-file-label" for="customFile">Upload Foto Nakes (.jpeg)</label>
                          </div>
                        </div>
                      </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success" id="btnsubmiteditfoto">Update</button>
                  </form>
                </div>
                <div class="overlay" id="oveditfoto" style="display:none">
                    <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                </div>
              </div>
            </div>
            
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="col-lg-3 col-6">

                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{count($pendaftar)}}</h3>
                        <p>Pendaftar</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="#" class="small-box-footer">
                    More info <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- COLOR PALETTE -->

        <div class="row">

          <div id="modal-reset-content" style="display: none;">
            <div class="card">
                <div class="card-header">
                    <div class="card-title" id="judulreset">
                        <h2>Reset Password</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="resetpassform" action="" method="post" class="form-horizontal">
                            @csrf
                                <div class="row">

                                    <div class="col-md-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="resetnakes_id" name="resetnakes_id">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="resetnakes_nama" name="resetnakes_nama">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">No Telp</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="resetnakes_notelp" name="resetnakes_notelp">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Password Baru</label>
                                            <div class="input-group input-group">
                                                <input type="password" class="form-control" id="resetpasswordnakes" name="resetpasswordnakes">
                                                <span class="input-group-append">
                                                <button type="button" class="btn btn-default btn-flat intippass"><i class="fas fa-eye"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Konfirmasi Password Baru</label>
                                            <div class="input-group input-group">
                                                <input type="password" class="form-control" id="resetpasswordnakesc" name="resetpasswordnakesc">
                                                <span class="input-group-append">
                                                <button type="button" class="btn btn-default btn-flat intippass"><i class="fas fa-eye"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form> 
                            <button type="button" class="btn btn-success" id="submitresetpassnakes">Update</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary float-right" id="close-reset-modal">Close</button>
                </div>
            </div>
          </div>
        </div>

        <div class="row">

          <div id="modal-editnomor-content" style="display: none;">
            <div class="card">
                <div class="card-header">
                    <div class="card-title" id="judulubahdata">
                        <h2>Ubah Data</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="resetpassform" action="" method="post" class="form-horizontal">
                            @csrf
                                <div class="row">
                                    <div class="col-md-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="editIDPendaftar" name="editIDPendaftar">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="editUpdater" name="editUpdater">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-xs-12">
                                      <div class="form-group">
                                          <label for="exampleFormControlSelect1" class="ms-0">Email</label>
                                          <input type="text" id="editEmailNakes" name="editEmailNakes" class="form-control" required>
                                      </div>
                                    </div>
                                    <div class="col-md-12 col-xs-12">
                                      <div class="form-group">
                                          <label for="exampleFormControlSelect1" class="ms-0">No WA</label>
                                          <input type="text" id="editNomorNakes" name="editNomorNakes" class="form-control" required>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">

                                  <div class="col-md-12 col-xs-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Upload SIP LAMA</label>
                                        <select class="form-control" id="setsiplama" name="setsiplama" required>
                                          <option value="0">Tidak</option>
                                          <option value="1">Ya</option>
                                        </select>
                                    </div>
                                  </div>

                                </div>
                            </form> 
                            <button type="button" class="btn btn-success" id="submiteditnomor">Update</button>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-secondary float-right" id="close-editnomor-modal">Close</button>
                </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List Pendaftar
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">

                <table class="table table-striped dataTable dtr-inline" id="tblpendaftar">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama</th>
                            <th>No Reg STR</th>
                            <th>Salinan</th>
                            <th>Kompetensi</th>
                            <th>Valid Hingga</th>
                            <th>Email</th>
                            <th>No Hp</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach($pendaftar as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>
                                
                                @if($row->img_src != null && $row->foto_not_avail !== '1')
                                  <img src="{{$row->img_src}}" width="50px" alt="user image">
                                @elseif($row->foto_not_avail == '1')
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
                            @if ($row->status_str == 'TIDAK AKTIF')
                            &nbsp; &nbsp;<small class="badge badge-danger">TIDAK AKTIF</small>
                            @endif
                            </td>
                            <td>{{$row->salinan}}</td>
                            <td>{{$row->kompetensi}}</td>
                            <td>{{$row->str_hingga}}</td>
                            <td>{{$row->email}}</td>
                            <td>{{$row->notelp}}</td>
                            <td>
                            <div class="btn-group">
                            @if ($row->current_status == 0)
                            <button class="btn btn-xs btn-success activatenakes" id="{{$row->id}}" data-file="{{$row->origin_file}}" data-url="{{$row->url_qr}}" data-nama="{{$row->nama}}" data-str="{{$row->no_reg}}" data-email="{{$row->email}}" data-foto = "{{$row->img_src}}" data-salinan="{{$row->salinan}}" data-kompetensi="{{$row->kompetensi}}" data-profesi="{{$row->profesi}}" data-tglstr = "{{$row->tgl_keluar_str}}" data-univ="{{$row->universitas}}" data-toggle="tooltip" data-placement="top" title="Terima Pendaftar"><i class="fas fa-check"></i></button>

                            @else 
                            <button class="btn btn-xs btn-info intipnakes" id="{{$row->id}}" data-file="{{$row->origin_file}}" data-url="{{$row->url_qr}}" data-nama="{{$row->nama}}" data-str="{{$row->no_reg}}" data-email="{{$row->email}}" data-foto = "{{$row->img_src}}" data-pass="{{$row->default_pass}}" data-statdoc="{{$row->doc_status}}" data-salinan="{{$row->salinan}}" data-kompetensi="{{$row->kompetensi}}" data-profesi="{{$row->profesi}}" data-tglstr = "{{$row->tgl_keluar_str}}" data-univ="{{$row->universitas}}" data-toggle="tooltip" data-placement="top" title="Lihat Pendaftar"><i class="fas fa-eye"></i></button>

                            @endif
                             <button class="btn btn-xs btn-danger tolaknakes" id="{{$row->id}}" data-file="{{$row->origin_file}}" data-url="{{$row->url_qr}}" data-nama="{{$row->nama}}" data-str="{{$row->no_reg}}" data-email="{{$row->email}}" data-foto = "{{$row->img_src}}" data-pass="{{$row->default_pass}}" data-statdoc="{{$row->doc_status}}" data-salinan="{{$row->salinan}}" data-kompetensi="{{$row->kompetensi}}" data-profesi="{{$row->profesi}}" data-tglstr = "{{$row->tgl_keluar_str}}" data-univ="{{$row->universitas}}" data-updater="{{$user_id}}" data-toggle="tooltip" data-placement="top" title="Tolak Pendaftar"><i class="fas fa-window-close"></i></button>
                             <div class="btn-group">
                             </td>
                        </tr>
                    @endforeach
                    <tbody>
                    </tbody>
                </table>  
                
              </div>
              <!-- /.card-body -->
            </div>


            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List Pendaftar Disetujui
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="panel">
                  <form id="form-filter-dftr" class="form-label-left input_mask">
                      <div class="row">        
                          <div class="col-md-6 col-sm-6  form-group has-feedback">
                              <input type="text" class="form-control" id="searchnamanakesapp" name="searchnamanakesapp" placeholder="Nama Pemohon">
                          </div>
                          <div class="col-md-3 col-sm-3  form-group has-feedback">
                              <input type="text" class="form-control" id="searchkompetensi" name="searchkompetensi" placeholder="Kompetensi">
                          </div>
                          <div class="col-md-3 col-sm-3  form-group has-feedback">
                              <input type="text" class="form-control" id="searchSTRapp" name="searchSTRapp" placeholder="Nomor STR">
                          </div>
                      </div>
                      <div class="row">
                          <div class="col-md-3 col-sm-3  form-group has-feedback">
                            <input type="text" class="form-control" id="searchemail" name="searchemail" placeholder="Email">
                          </div>
                          <div class="col-md-3 col-sm-3  form-group has-feedback">
                            <input type="text" class="form-control" id="searchnohp" name="searchnohp" placeholder="Nomor Hp">
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
                              <button type="button" id="btn-filterdftr" class="btn btn-primary">Filter</button>
                              <button type="button" id="btn-resetdftr" class="btn btn-default">Reset</button>
                          </div>
                        </div>
                  </form>
                </div>
                <div class="table-responsive">
                  <table class="table table-striped" id="tblpendaftarhist">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama</th>
                              <th>Foto</th>
                              <th>No Reg STR</th>
                              <th>Salinan</th>
                              <th>Kompetensi</th>
                              <th>Valid Hingga</th>
                              <th>Email</th>
                              <th>No Hp</th>
                              <th>Status</th>
                              <th>Aksi</th>
                          </tr>
                      </thead>
                      <tbody id="bodyhistorikaldaftar">
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

      const origin = window.location.origin;
  
      $('#tblpendaftarhist').on('click','.changepp', function(){
        var id_user = $(this).attr('id')
        var nama = $(this).attr('data-nama')
        var url_photo = $(this).attr('data-imgsrc')
        var saved_photo = $(this).attr('data-imgusr')
        var html = `<div class="col-sm-6">
                      <div class="card mb-2 bg-gradient-dark">
                        <img class="card-img-top" src="${url_photo}" alt="Dist Photo 1">
                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                          <h5 class="card-title text-white">FOTO ASLI STR</h5>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="card mb-2 bg-gradient-dark">
                        <img class="card-img-top" src="${origin}/storagefoto/${saved_photo}" alt="Dist Photo 1">
                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                          <h5 class="card-title text-white">FOTO e-SIP</h5>
                        </div>
                      </div>
                    </div>`;

        $('#komperfoto').html(html)
        $('#juduteditfoto').text('Edit Foto Nakes: '+nama)
        $('#idusereditfoto').val(id_user)
        $.fancybox.open({
            src: '#modal-editfoto-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false,
            afterShow: function() {
                $('.tutupeditfoto').click(function() {
                    $.fancybox.close();
                });
            }
        });
        
      })
      
      $('#tblpendaftar').on('click','.tolaknakes', function(){

        var id_pendaftaran = $(this).attr('id')
        var updater = $(this).attr('data-updater')
        var nama_nakes = $(this).attr('data-nama')
        
        if (confirm("Apakah Anda Yakin Untuk Menolak Pengajuan Atas Nama: "+nama_nakes+"?") == true) {

          $.ajax({
            type: 'ajax',
            method: 'post',
            url: '{{ route("submit.tolak.nakes")}}',
            data: {'id_pendaftaran': id_pendaftaran, 'updater': updater,  _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){
              console.log(data)
              if(data.success == true) {
                
                location.reload()
                  
              } else {
                  alert(data.keterangan)
              }
            },
              error: function(request, status, error){
                //alert(request.responseText);
            }
          });
        }
      });

      $('#tblpendaftarhist').on('click','.editdetailnakes', function(){
    
        var id_pendaftaran = $(this).attr('id')
        var email = $(this).attr('data-email')
        var notelp = $(this).attr('data-notelp')
        var nama_nakes = $(this).attr('data-nama')
        var isverif = $(this).attr('data-verif')
        var siplama = $(this).attr('data-siplama')

        if (isverif == 0) {
          // set select to value 0 and disable option 1
          $("#setsiplama").val("0");
          //$("#setsiplama option[value='1']").prop("disabled", true);
        } else {
          if (siplama == 1) {
            // set select to value 1 and make sure all options are enabled
            $("#setsiplama").val("1");
            $("#setsiplama option").prop("disabled", false);
          } else {
            // reset to default (first option) and enable all options
            $("#setsiplama").prop("selectedIndex", 0);
            $("#setsiplama option").prop("disabled", false);
          }
        }

        $('#editIDPendaftar').val(id_pendaftaran)
        $('#editEmailNakes').val(email)
        $('#editNomorNakes').val(notelp)
        $('#judulubahdata').html('<h4>Ubah Data Nakes : '+nama_nakes+'</h4>')

        $.fancybox.open({
            src: '#modal-editnomor-content',
            type: 'inline',
            touch: false,
            modal: true,
            clickSlide: false,
            afterShow: function() {
                $('#close-editnomor-modal').click(function() {
                    $.fancybox.close();
                });
            }
        });
      });

      $('#tblpendaftarhist').on('click','.reaktifasi', function(){
        var id_pendaftaran = $(this).attr('id')
        var email = $(this).attr('data-email')
        var notelp = $(this).attr('data-notelp')
        var nama_nakes = $(this).attr('data-nama')
        var jenis = $(this).attr('data-aktifasi')
  
        let judul = '';
        let isActive = 0;
        if(jenis == 0) {
          judul = 'Apakah Anda Yakin Ingin Mengaktifkan Kembali User: '+nama_nakes+'?';
          isActive = 1;
          
        } else {
          judul = 'Apakah Anda Yakin Ingin Non-Aktifkan User: '+nama_nakes+'?';
        }

        Swal.fire({
          title: judul,
          showCancelButton: true,
          confirmButtonText: "Ya"
        }).then((result) => {
          if (result.value) {
            $.ajax({
              type: 'ajax',
              method: 'post',
              url: '{{ route("reaktifasi.nakes")}}',
              data: {'id_pendaftaran': id_pendaftaran, 'isActive': isActive,  _token: "{{ csrf_token() }}"},
              dataType: 'json',
              success: function(data){
                console.log(data)
                if(data.success == true) {
                  
                  gethistoriapproval();
                    
                } else {
                    alert(data.keterangan)
                }
              },
                error: function(request, status, error){
                  //alert(request.responseText);
              }
            });
          }
        });

        
      });

      

      $('#submiteditnomor').click(function(){
        var id_pendaftaran = $('#editIDPendaftar').val()
        var email = $('#editEmailNakes').val()
        var notelp = $('#editNomorNakes').val()
        var updater = $('#editUpdater').val()
        var setsiplama = $('#setsiplama').val()

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '{{ route("submit.edit.nomor")}}',
            data: {'id_pendaftaran': id_pendaftaran, 'setsiplama': setsiplama, 'email' : email, 'notelp' : notelp, 'updater': updater,  _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){
              console.log(data)
              if(data.success == true) {
                
                location.reload()
                  
              } else {
                  alert(data.keterangan)
              }
            },
              error: function(request, status, error){
                //alert(request.responseText);
            }
          });

      });

      $('#submiteditfoto').on('submit', function(e){
        e.preventDefault();
        let link = `{{ route('update.foto.nakes') }}`;
        let formData = new FormData($(this)[0])
        formData.append('_token', '{{ csrf_token() }}');
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

                $('#oveditfoto').show()
                
            },
            success: function (data) {
                $('#oveditfoto').hide()
                $.fancybox.close()
                if(data.success) {
                    Swal.fire(data.keterangan).then(function() {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.keterangan,
                    })
                }
            }
            ,
            error: function(request, status, error){
                $('#oveditfoto').hide()
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Error Submit Pengajuan Nakes',
                })
            }
          });          
      });

      var tablehistoriaju = $('#tblpendaftarhist').DataTable({
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
            { data: 'nama' },
            { data: 'foto' },
            { data: 'no_str' },
            { data: 'salinan' },
            { data: 'kompetensi' },
            { data: 'str_hingga' },
            { data: 'email' },
            { data: 'notelp' },
            { data: 'statusakun'},
            { data: 'aksi', orderable: false }
        ],
        //dom: '<"datatable-header dt-buttons-right"fB><"datatable-scroll"tS><"datatable-footer"i>',
        autoWidth: false,
        scrollY: 500,
        scrollCollapse: true
      })

      function gethistoriapproval(){
        let link = `{{route('get.histori.daftarapprove')}}`;
        let formData = new FormData($('#form-filter-dftr')[0])
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

                data.pendaftaran.forEach(function(pendaftaran) {
 
                  let addfile = '';
                  let foto = '';
                  let button_aksi = '';
                  let jenisaktifasi = '';
                  let statusakun = '<span class="badge bg-success">Aktif</span>';

                  if(pendaftaran.isActive == 0)
                  {
                     jenisaktifasi = '<i class="fas fa-unlock"></i>';
                     statusakun = '<span class="badge bg-danger">Terkunci</span>';
                    
                  } else {
                     jenisaktifasi = '<i class="fas fa-lock"></i>';
                     statusakun = '<span class="badge bg-success">Aktif</span>';
                  }

                  let aktifasi = `<button class="btn btn-xs btn-primary reaktifasi" data-toggle="tooltip" data-placement="top" title="Reaktifasi"
                                  id="${pendaftaran.id}" data-file="${pendaftaran.origin_file}" data-url="${pendaftaran.url_qr}"
                                  data-nama="${pendaftaran.nama}" data-str="${pendaftaran.no_reg}" data-email="${pendaftaran.email}"
                                  data-foto="${pendaftaran.img_src}" data-salinan="${pendaftaran.salinan}"
                                  data-kompetensi="${pendaftaran.kompetensi}" data-profesi="${pendaftaran.profesi}"
                                  data-tglstr="${pendaftaran.tgl_keluar_str}" data-aktifasi="${pendaftaran.isActive}">
                                  `+jenisaktifasi+`
                              </button>`;

                  // Determine the button actions based on current_status
                  if (pendaftaran.current_status == 0) {
                      button_aksi = `
                          <div class="btn-group">
                              <button class="btn btn-xs btn-success activatenakes" data-toggle="tooltip" data-placement="top" title="Lihat Pendaftar"
                                  id="${pendaftaran.id}" data-file="${pendaftaran.origin_file}" data-url="${pendaftaran.url_qr}"
                                  data-nama="${pendaftaran.nama}" data-str="${pendaftaran.no_reg}" data-email="${pendaftaran.email}"
                                  data-foto="${pendaftaran.img_src}" data-salinan="${pendaftaran.salinan}"
                                  data-kompetensi="${pendaftaran.kompetensi}" data-profesi="${pendaftaran.profesi}"
                                  data-tglstr="${pendaftaran.tgl_keluar_str}" data-univ="${pendaftaran.universitas}">
                                  <i class="fas fa-check"></i>
                              </button>
                              <button class="btn btn-xs btn-warning editdetailnakes" data-toggle="tooltip" data-placement="top" title="Edit Data"
                                  id="${pendaftaran.id}" data-email="${pendaftaran.email}" data-notelp="${pendaftaran.notelp}"
                                  data-nama="${pendaftaran.nama}" data-verif="${pendaftaran.isverdinkes}" data-siplama="${pendaftaran.class_op}">
                                  <i class="fas fa-edit"></i>
                              </button>
                              <button class="btn btn-xs btn-info resetnakespass" data-toggle="tooltip" data-placement="top" title="Reset Password"
                                  data-id="${pendaftaran.id_user}" data-nama="${pendaftaran.nama}" data-notelp="${pendaftaran.notelp}">
                                  <i class="fas fa-sync-alt"></i>
                              </button>`+aktifasi+`
                          </div>`;
                  } else {
                      button_aksi = `
                          <div class="btn-group">
                              <button class="btn btn-xs btn-success intipnakes" data-toggle="tooltip" data-placement="top" title="Lihat Pendaftar"
                                  id="${pendaftaran.id}" data-file="${pendaftaran.origin_file}" data-url="${pendaftaran.url_qr}"
                                  data-nama="${pendaftaran.nama}" data-str="${pendaftaran.no_reg}" data-email="${pendaftaran.email}"
                                  data-statdoc="${pendaftaran.doc_status}" data-foto="${pendaftaran.img_src}" data-salinan="${pendaftaran.salinan}"
                                  data-kompetensi="${pendaftaran.kompetensi}" data-profesi="${pendaftaran.profesi}"
                                  data-tglstr="${pendaftaran.tgl_keluar_str}" data-univ="${pendaftaran.universitas}">
                                  <i class="fas fa-eye"></i>
                              </button>
                              <button class="btn btn-xs btn-warning editdetailnakes" data-toggle="tooltip" data-placement="top" title="Edit Data"
                                  id="${pendaftaran.id}" data-email="${pendaftaran.email}" data-notelp="${pendaftaran.notelp}"
                                  data-nama="${pendaftaran.nama}" data-verif="${pendaftaran.isverdinkes}" data-siplama="${pendaftaran.class_op}">
                                  <i class="fas fa-edit"></i>
                              </button>
                              <button class="btn btn-xs btn-info resetnakespass" data-toggle="tooltip" data-placement="top" title="Reset Password"
                                  data-id="${pendaftaran.id_user}" data-nama="${pendaftaran.nama}" data-notelp="${pendaftaran.notelp}">
                                  <i class="fas fa-sync-alt"></i>
                              </button>`+aktifasi+`
                          </div>`;
                  }

                  // Add file link if origin_file is not 'scanned'
                  if (pendaftaran.origin_file !== 'scanned') {
                      addfile = `&nbsp; &nbsp;<a href="${origin}/getoriginstr/${pendaftaran.origin_file}.pdf" target="_blank">
                          <i class="fas fa-file"></i></a>`;
                  }

                  // Determine the correct image source
                  if (pendaftaran.img_src !== null && pendaftaran.foto_not_avail !== '1') {
                      foto = `<a href="#tblpendaftarhist" id="${pendaftaran.id}" class="changepp" data-nama="${pendaftaran.nama}" data-imgsrc = "${pendaftaran.img_src}" data-imgusr = "${pendaftaran.saved_photo}">
                          <img src="${pendaftaran.img_src}" width="50px" alt="user image"></a>`;
                  } else {
                      foto = `<a href="#tblpendaftarhist" id="${pendaftaran.id}" class="changepp" data-nama="${pendaftaran.nama}" data-imgsrc = "${pendaftaran.img_src}" data-imgusr = "${pendaftaran.saved_photo}">
                          <img src="${origin}/storagefoto/${pendaftaran.saved_photo}" width="50px" alt="user image"></a>`;
                  }

                  var nama_nakes = `<a href="#tblpendaftarhist" class="toprofilingnakes" data-id="${pendaftaran.id_user}">${pendaftaran.nama}</a>`

                  // Push the processed data into the array
                  processedData.push({
                      no: no++,
                      foto: foto,
                      nama: nama_nakes,
                      no_str: pendaftaran.no_reg + addfile,
                      salinan: pendaftaran.salinan,
                      kompetensi: pendaftaran.kompetensi,
                      str_hingga: pendaftaran.str_hingga,
                      email: pendaftaran.email,
                      notelp: pendaftaran.notelp,
                      aksi: button_aksi,
                      statusakun : statusakun
                  });
                });
              
                tablehistoriaju.clear();
                tablehistoriaju.rows.add(processedData).draw();

                $('#onloadhistory').hide()
                  
              } else {
                  $('#onloadhistory').hide()
                  $('#bodyhistorikaldaftar').empty();
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

      $('#btn-filterdftr').click(function(){
        gethistoriapproval();
      
      });
      $('#btn-resetdftr').click(function(){ //button reset event click
        $('#form-filter-dftr')[0].reset();
        //table.ajax.reload();  //just reload table
      });

      gethistoriapproval();
    })
</script>

@endsection