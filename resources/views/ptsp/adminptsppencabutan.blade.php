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
        <!-- COLOR PALETTE -->

        <div class="row">
          <div id="modal-tunggudraftcabut-content" style="display: none;">
              <center>
              <i class="fas fa-hourglass"></i>
              <h5>Mohon Tunggu..</h5>
              </center>
          </div>
        </div>

        <div class="row">
          <div id="modal-cabutsiplama-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
            <div class="card">
              <div class="card-header">
                <div class="card-title" id="juduldraftcabutsip">
                    Pencabutan SIP LAMA
                </div>
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                  <button type="button" class="btn btn-tool tutupintipdraftcabut">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row" id="result-container">
                    <!-- jQuery will fill this -->
                </div>
                
              
              </div>
              <div class="card-footer">
                <div class="btn-group">
                  <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraftcabut" id="close-lihatdraft-modal">Tutup</button>
                  <button type="button" class="btn btn-success btn-sm float-right" id="setujuisuratpencabutanlama">Setujui</button>
                </div>
              </div>
              <div class="overlay" id="sedangrevertdraftcabut" style="display:none">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div id="modal-lihatdraft-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
            <div class="card">
              <div class="card-header">
                <div class="card-title" id="juduldraftcabutsip">
                    Draft Pencabutan SIP
                </div>
                <div class="card-tools">
                  <a type="button" id="donlitdraftcabutsip" class="btn btn-outline-success btn-sm" target="_blank"><i class="fas fa-download"></i></a>
                  <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="row" id="aksidraftcabutptsp" style="display:none">
                  <div class="col-md-6 col-xs-12">
                    <div class="alert alert-danger alert-dismissible">
                        Untuk Membatalkan Proses Pengajuan TTE dikarenakan ada kesalahan data, silahkan Klik Tombol Dibawah <hr />
                        <button class="btn btn-block bg-gradient-danger" id="bataldraftsip" data-filename="" data-id="" data-updater="{{$user_id}}" data-perubahan="">Batalkan Draft</button>
                    </div>
                  </div>
                  <div class="col-md-6 col-xs-12" style="display:none">
                    <div class="alert alert-warning alert-dismissible">
                        Untuk Memuat Ulang Draft SIP Setelah Perbaikan data nakes sebelum TTE, silahkan Klik Tombol Dibawah <br /> <hr />
                        <button class="btn btn-block bg-gradient-warning" id="refreshdraftsip" data-filename="" data-id="" data-updater="{{$user_id}}">Refresh Draft</button>
                    </div>
                  </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <iframe class="embed-responsive-item" id="lihatdraftcabutnya" width="100%" height="450px" src=""></iframe>
                    </div>
                </div>
                <div class="row" id="pencabutandisubmitasoka">
                  <div class="alert alert-info alert-dismissible">
                    <h5 id="keterangancetakpencabutan"><i class="icon fas fa-info"></i> Alert!</h5>
                    
                  </div>
                </div>
              
              </div>
              <div class="card-footer">
                <div class="btn-group">
                  <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraftcabut" id="close-lihatdraft-modal">Tutup</button>
                  <button type="button" class="btn btn-success btn-sm float-right" id="setujuisuratpencabutan">Setujui</button>
                </div>
              </div>
              <div class="overlay" id="sedangrevertdraftcabut" style="display:none">
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
                  List Pencabutan
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped" id="tbllistpencabutanp">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th class="orderfirst">Urutan</th>
                            <th>Nama Pemohon</th>
                            <th>Profesi</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th class="filterable">Jenis</th>
                            <th >Status</th>
                            <th class="orderable">Tanggal Diajukan</th>
                            <th>Alasan</th>
                            <th>Status Cetak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bodylistpencabutan">
                    
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
                  List Pencabutan Telah Ditinjau
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="panel">
                  <form id="form-filter-p" class="form-label-left input_mask">
                    <div class="row" style="display:none">
                      <input type="text" name="userrolesearch" value="{{Auth::user()->role;}}">
                    </div>
                    <div class="row" style="display:none">
                      <input type="text" name="cabuttinjau" value="1">
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
                            <th>Profesi</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th class="filterable">Jenis</th>
                            <th class="orderable">Tanggal Disetujui</th>
                            <th>Alasan</th>
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


        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  List User Tidak Aktif (Pencabutan)
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-striped" id="tbllistuserinactive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>No STR</th>
                            <th>Kompetensi</th>
                            <th>Alasan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    @foreach($userinactive as $row)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$row->name}}</td>
                            <td>{{$row->no_doc}}</td>
                            <td>{{$row->kompetensi}}</td>
                            <td>{{$row->nama_alasan}}</td>
                            <td><button class="btn btn-sm btn-success reaktifasi" data-id="{{$row->id}}" data-nama="{{$row->name}}">Aktifkan</button></td>
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

@section('script')
<script>
    $(document).ready(function() {

      function lihatdokumenpencabutan(id_sip, nama_nakes) {

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("lihatdoc.pencabutan.sip")}}',
            data: {'id_sip' : id_sip, _token: "{{ csrf_token() }}"},
            //async: false,
            dataType: 'json',
            beforeSend: function() {
              $.fancybox.open({
                  src: '#modal-tunggudraftcabut-content',
                  type: 'inline',
                  touch: false,
                  modal: true,
                  clickSlide: false
                  
              });
                
            },
            success: function(data){

              $.fancybox.close();
              console.log(data)

              if(data.success == true) {
                var randomis = Math.floor((Math.random()*1000000) + 1)
                urlsurat = data.surathost+data.thefile+'.pdf'+ "?dummy="+ randomis;
                $('#lihatdraftcabutnya').attr('src', urlsurat)
                $('#donlitdraftcabutsip').attr('href', urlsurat)

                $('#juduldraftcabutsip').html('Draft Pencabutan SIP Atas Nama '+nama_nakes)
                $.fancybox.open({
                  src: '#modal-lihatdraft-content',
                  type: 'inline',
                  touch: false,
                  modal: true,
                  clickSlide: false,
                  afterShow: function() {
                    $('.tutupintipdraftcabut').click(function() {
                        $.fancybox.close();
                    });
                  }
                });
                  
              } else {
                Swal.fire({
                  icon: 'error',
                  title: data.keterangan,
                  showConfirmButton: false,
                  timer: 1500
                })
              }
            },
            error: function(request, status, error){
                Swal.fire({
                  icon: 'error',
                  title: request.responseText,
                  showConfirmButton: false,
                  timer: 1500
                })
            }
          });
      }

      $('#tbllistpencabutanp, #historyapprovepengajuan').on('click','.cetakpencabutan', function(){
        var id_sip = $(this).attr('data-id')
        var status_csip = $(this).attr('data-info')
        var id_nakes = $(this).attr('data-nakes')
        var id_pengajuan = $(this).attr('data-aju')
        var perubahan = $(this).attr('data-peru')
        var nama_nakes = $(this).attr('data-nama')
        var siplama = $(this).attr('data-siplama')

        if(status_csip == '0' || status_csip == 'R' || status_csip == 'D') {
          $('#setujuisuratpencabutan').show()
          $('#keterangancetakpencabutan').html('Mohon Periksa Kembali Dokumen Draft Pencabutan SIP Sebelum Submit Pada ASOKA Untuk di-TTE')

          $('#setujuisuratpencabutan').attr('data-id', id_sip)
          $('#setujuisuratpencabutan').attr('data-nakes', id_nakes)
          $('#setujuisuratpencabutan').attr('data-aju', id_pengajuan)
          $('#setujuisuratpencabutan').attr('data-peru', perubahan)
          $('#setujuisuratpencabutan').attr('data-info', status_csip)
          $('#setujuisuratpencabutan').attr('data-siplama', siplama)
          

          $.ajax({
            type: 'ajax',
            method: 'post',
            url: '{{ route("drafting.pencabutan.sip")}}',
            data: {'id_pengajuan': id_pengajuan, 'id_sip' : id_sip, 'perubahan': perubahan, 'status_csip': status_csip, 'id_nakes': id_nakes, 'siplama' : siplama, _token: "{{ csrf_token() }}"},
            //async: false,
            dataType: 'json',
            beforeSend: function() {
              $.fancybox.open({
                  src: '#modal-tunggudraftcabut-content',
                  type: 'inline',
                  touch: false,
                  modal: true,
                  clickSlide: false
                  
              });
                
            },
            success: function(data){

              $.fancybox.close();
              console.log(data)

              if(data.success == true) {
                var randomis = Math.floor((Math.random()*1000000) + 1)
                urlsurat = data.draftcabut.resultdraft.surathost+data.draftcabut.resultdraft.thefile+'.pdf'+ "?dummy="+ randomis;
                $('#lihatdraftcabutnya').attr('src', urlsurat)
                $('#donlitdraftcabutsip').attr('href', urlsurat)
                  
              } else {
                  alert('Gagal Memproses Draft SIP. Keterangan: '+data.hasilnya);
              }
            },
            error: function(request, status, error){
                //alert(request.responseText);
            },
            complete: function(data){
              $('#juduldraftcabutsip').html('Draft Pencabutan SIP Atas Nama '+nama_nakes)
              $.fancybox.open({
                    src: '#modal-lihatdraft-content',
                    type: 'inline',
                    touch: false,
                    modal: true,
                    clickSlide: false,
                    afterShow: function() {
                      $('.tutupintipdraftcabut').click(function() {
                          $.fancybox.close();
                      });
                  }
                });
            }
          });
        } else if (status_csip == '1') {

          $('#setujuisuratpencabutan').hide()
          $('#keterangancetakpencabutan').html('Surat Pencabutan SIP Telah Disetujui dan Di-TTE')
          lihatdokumenpencabutan(id_sip, nama_nakes)
          

        } else if (status_csip == 'A') {
          $('#setujuisuratpencabutan').hide()
          $('#keterangancetakpencabutan').html('Surat Pencabutan SIP Sudah Di-submit Untuk Di-TTE')
          lihatdokumenpencabutan(id_sip, nama_nakes)

        }

      })

      $('#setujuisuratpencabutan').click(function(){
        var id_sip = $(this).attr('data-id')
        var status_csip = $(this).attr('data-info')
        var id_nakes = $(this).attr('data-nakes')
        var id_pengajuan = $(this).attr('data-aju')
        var perubahan = $(this).attr('data-peru')
        var siplama = $(this).attr('data-siplama')

        $.ajax({
          type: 'ajax',
          method: 'post',
          url: '{{ route("submit.pencabutan.sip")}}',
          data: {'id_pengajuan': id_pengajuan, 'id_sip' : id_sip, 'perubahan': perubahan, 'status_csip': status_csip, 'id_nakes': id_nakes, 'siplama' : siplama, _token: "{{ csrf_token() }}"},
          //async: false,
          dataType: 'json',
          beforeSend: function() {
              $(this).hide()
          },
          success: function(data){

            console.log(data)
            if(data.success == true) {

              $.fancybox.close();
              Swal.fire({
                icon: 'success',
                title: 'Penolakan Pencabutan Berhasil',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                // This code will be executed after the Swal.fire() promise resolves
                location.reload();
              });
              
            } else {
              Swal.fire(data.keterangan)
            }
            
          },
          error: function(request, status, error){
              //alert(request.responseText);
          },
          complete: function(data){
            $(this).show()
          }
        });
      })


      $('#tbllistpencabutanp').on('click', '.setujucabutsiplama', function () {
          let id = $(this).data('id'); // cleaner than attr

          $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("detailsipuntukcabut")}}',
            data: {'id': id, _token: "{{ csrf_token() }}"},
            //async: false,
            dataType: 'json',
            beforeSend: function() {

              $.fancybox.open({
                  src: '#modal-tunggudraftcabut-content',
                  type: 'inline',
                  touch: false,
                  modal: true,
                  clickSlide: false 
                });
        
            },
            success: function(data){

              console.log(data)
              $.fancybox.close();
              if(data.success == true) {

                // assume data.result is your JSON
                let res = data.result;
                let surathost = data.surat_host;
                // build iframe from filename_sip
                let leftCol = `
                    <div class="col-md-6 col-xs-12">
                        <iframe href="${surathost}${res.filename_sip}.pdf" 
                                style="width:100%;height:500px;" frameborder="0"></iframe>
                    </div>
                `;

                // build form-like display for the other fields
                let rightCol = `
                    <div class="col-md-6 col-xs-12">
                        <dl class="row">
                            <dt class="col-sm-4">No. Dokumen</dt>
                            <dd class="col-sm-8">${res.no_doc}</dd>

                            <dt class="col-sm-4">Tracker</dt>
                            <dd class="col-sm-8">${res.tracker}</dd>

                            <dt class="col-sm-4">Nama Faskes</dt>
                            <dd class="col-sm-8">${res.nama_faskes}</dd>

                            <dt class="col-sm-4">Alamat</dt>
                            <dd class="col-sm-8">${res.alamat_pengajuan}</dd>

                            <dt class="col-sm-4">Alasan</dt>
                            <dd class="col-sm-8">${res.nama_alasan}</dd>

                            <dt class="col-sm-4">Berlaku Sampai</dt>
                            <dd class="col-sm-8">${res.berlaku_sampai}</dd>

                            <dt class="col-sm-4">Nama Nakes</dt>
                            <dd class="col-sm-8">${res.nama_nakes}</dd>

                            <dt class="col-sm-4">No. SIP</dt>
                            <dd class="col-sm-8">${res.no_str}</dd>
                        </dl>
                    </div>
                `;

                // inject into the container
                $('#result-container').html(leftCol + rightCol);
                $('#setujuisuratpencabutanlama').attr('data-id', res.id);
                $('#setujuisuratpencabutanlama').attr('data-siplama', res.siplama);
                $('#setujuisuratpencabutanlama').attr('data-admin','1');

                $.fancybox.open({
                  src: '#modal-cabutsiplama-content',
                  type: 'inline',
                  touch: false,
                  modal: true,
                  clickSlide: false 
                });
                
              } else {
                Swal.fire(data.keterangan)
              }
              
            },
            error: function(request, status, error){
                //alert(request.responseText);
            },
            complete: function(data){
              $(this).show()
            }
          });

          
      });

      $('#setujuisuratpencabutanlama').click(function(){
        var id_pengajuan = $(this).attr('data-id')
        var siplama = $(this).attr('data-siplama')
        var isadmin = "1"
   

        $.ajax({
          type: 'ajax',
          method: 'post',
          url: '{{ route("setujupencabutanbidfar")}}',
          data: {'id_pengajuan': id_pengajuan, 'siplama':siplama, 'isadmin' : isadmin, _token: "{{ csrf_token() }}"},
          dataType: 'json',
          beforeSend: function() {
              $(this).hide()
          },
          success: function(data){

            console.log(data)
            $.fancybox.close();
            if(data.success == true) {

              
              Swal.fire({
                icon: 'success',
                title: 'Penolakan Pencabutan Berhasil',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                window.location.reload()
              });
              
            } else {
              Swal.fire(data.keterangan)
            }
            
          },
          error: function(request, status, error){
             
          },
          complete: function(data){
            $(this).show()
          }
        });
      })

      $('#btn-filterpx').click(function(){
        gethistoriapproval();
      
      });
      $('#btn-resetpx').click(function(){ //button reset event click
        $('#form-filter-p')[0].reset();
        //table.ajax.reload();  //just reload table
      });

      gethistoriapproval();

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
            { data: 'jenis_profesi' },
            { data: 'nama_faskes' },
            { data: 'alamat_pengajuan' },
            { data: 'jenis' },
            { data: 'tgl_tte' },
            { data: 'alasan' },
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

                  var alasanFix = (pengajuan.nama_alasan == '0') ? pengajuaalasan : pengajuan.nama_alasan;

                  var btnCetak ='<button class="btn btn-sm btn-success cetakpencabutan" ' + 'data-id="' + pengajuan.id_sip + '" ' + 'data-info="' + pengajuan.suratpencabutan + '" ' + 'data-aju="' + pengajuan.id + '" ' + 'data-nakes="' + pengajuan.id_user + '" ' + 'data-peru="' + pengajuan.perubahan + '" ' + 'data-nama="' + pengajuan.name + '" ' + 'data-siplama="' + pengajuan.siplama + '"> Lihat </button>';



                  processedData.push({
                      no: no++,
                      name: '<a class="toprofilingnakes" href="#historyapprovedptsp" data-id="' + pengajuan.id_user + '">' + pengajuan.name + '</a>',
                      jenis_profesi: pengajuan.jenis_profesi,
                      nama_faskes : pengajuan.nama_faskes,
                      alamat_pengajuan : pengajuan.alamat_pengajuan,
                      jenis : pengajuan.jenis,
                      tgl_tte : pengajuan.tgl_tte_pencabutan,
                      alasan : alasanFix,
                      action: '<div class="btn-group"><a class="btn btn-sm btn-primary viewdetailpengajuan" data-id="' + pengajuan.id + '" href="">Detail</a>' + btnCetak +'</div>'
                      
                  });
                });
                console.log(processedData)
              
                tablehistori.clear();
                tablehistori.rows.add(processedData).draw();
                  
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

      var tableCabut = $('#tbllistpencabutanp').DataTable({
        scrollY: true,
        scrollCollapse: true,
        paging: true,
        scrollX: true,
        fixedHeader: false,
        columns: [
            { data: 'no' },
            { data: 'order_col' },
            { data: 'name' },
            { data: 'jenis_profesi' },
            { data: 'nama_faskes' },
            { data: 'alamat_pengajuan' },
            { data: 'jenis' },
            { data: 'status_badge',    orderable: false },
            { data: 'updated_at' },
            { data: 'alasan' },
            { data: 'surat_label' },
            { data: null, orderable: false, render: function(data, type, row) {
                var actionHtml = '<div class="btn-group">';

                var detailBtn = '<a class="btn btn-sm btn-primary" href="/pengajuan/detail/' + row.id + '">Detail</a>';

                if (parseInt(row.isverdinkes) === 0) {
                    actionHtml += detailBtn;
                } else {
                    if (parseInt(row.verifdinkes) === 0) {
                        actionHtml += '<span class="badge badge-warning">Belum Disetujui Dinkes</span>';
                    } else {
                        if (parseInt(row.siplama) === 0) {
                            actionHtml += detailBtn;
                        } else {
                            if (row.isApproved != 'CF') {
                                actionHtml += '<button type="button" class="btn btn-sm btn-primary setujucabutsiplama" data-id="' + row.id + '">Setujui</button>';
                            }
                        }
                    }
                }

                if (row.isApproved == 'CF') {
                    var cetakLabel = (row.suratpencabutan == '0' || row.suratpencabutan == 'R') ? 'Cetak' : 'Lihat';
                    actionHtml += '<button class="btn btn-sm btn-success cetakpencabutan"'
                        + ' data-id="'      + row.id_sip          + '"'
                        + ' data-info="'    + row.suratpencabutan  + '"'
                        + ' data-aju="'     + row.id               + '"'
                        + ' data-nakes="'   + row.id_user          + '"'
                        + ' data-peru="'    + row.perubahan        + '"'
                        + ' data-nama="'    + row.name             + '"'
                        + ' data-siplama="' + row.siplama          + '">'
                        + cetakLabel + '</button>';
                }

                actionHtml += '</div>';

                if (row.isApproved == 3) {
                    actionHtml += '<br /><span class="badge badge-info">Pengajuan TTE</span>';
                } else if (row.isApproved == 4) {
                    actionHtml += '<br /><span class="badge badge-success">TTE Selesai</span>';
                }

                return actionHtml;
            }}
        ],
        columnDefs: [
            { targets: 'orderfirst', visible: false, searchable: false }
        ],
        initComplete: function () {
            var api = this.api();
            api.columns('.filterable').every(function () {
                var column = this;
                var select = $('<select><option value="">All</option></select>')
                    .appendTo($(column.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });
                column.data().unique().sort().each(function (d) {
                    select.append('<option value="' + d + '">' + d + '</option>');
                });
            });
        },
        order: (function () {
            var orderableIndex = $('#tbllistpencabutanp thead th.orderable').first().index();
            return orderableIndex >= 0 ? [[orderableIndex, 'desc']] : [];
        })()
    });

      function getlistcabuten()
      {

        $.ajax({
          type: 'ajax',
          method: 'get',
          url: '{{ route("ambilistcabut")}}',
          data: {'jenis' : 'cabut', _token: "{{ csrf_token() }}"},
          //async: false,
          dataType: 'json',
          beforeSend: function() {
            
              
          },
          success: function (data) {
            var suratMap = { '0': 'Belum', 'R': 'Diminta', 'D': 'Draft', 'A': 'Asoka' };

            var rows = data.pencabutan.map(function (row, i) {
                // Order column value
                var orderVal = 99;
                if (row.verifdinkes == 1) {
                    if (row.isApproved == 'C') {
                        orderVal = 1;
                    } else if (row.isApproved == 'CF') {
                        if (row.suratpencabutan == 'R')      orderVal = 2;
                        else if (row.suratpencabutan == '0') orderVal = 3;
                        else                                 orderVal = 4;
                    }
                }

                return {
                    no:               i + 1,
                    order_col:        orderVal,
                    name:             row.name        || '',
                    jenis_profesi:    row.jenis_profesi || '',
                    nama_faskes:      row.isFaskes == 1 ? (row.nama_faskes || '-') : '-',
                    alamat_pengajuan: row.alamat_pengajuan || '',
                    jenis:            row.jenis        || '',
                    status_badge:     row.isApproved == 'C'  ? '<span class="badge badge-warning">Pengajuan Pencabutan</span>'
                                    : row.isApproved == 'CF' ? '<span class="badge badge-danger">SIP Dicabut</span>'
                                    : '',
                    updated_at:       row.updated_at   || '',
                    alasan:           row.nama_alasan == '0' ? row.alasan : row.nama_alasan,
                    surat_label:      suratMap[row.suratpencabutan] !== undefined
                                        ? suratMap[row.suratpencabutan]
                                        : 'TTE',
                    // Keep raw fields for the action column renderer
                    id:               row.id,
                    id_sip:           row.id_sip,
                    id_user:          row.id_user,
                    isApproved:       row.isApproved,
                    isverdinkes:      row.isverdinkes,
                    verifdinkes:      row.verifdinkes,
                    siplama:          row.siplama,
                    suratpencabutan:  row.suratpencabutan,
                    perubahan:        row.perubahan
                };
            });

            tableCabut.clear();
            tableCabut.rows.add(rows).draw();
        },
          error: function(request, status, error){
              Swal.fire({
                icon: 'error',
                title: request.responseText,
                showConfirmButton: false,
                timer: 1500
              })
          }
        });

      }
      getlistcabuten()


    });
</script>
@endsection