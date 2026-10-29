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
          <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="cthcth" data-backdrop="static" data-keyboard="false">
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Pencabutan SIP</h4>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                <!-- Modal body -->
                    <div class="modal-body">

                      <div class="row" id="result-container">
                      <!-- jQuery will fill this -->
                      </div>
                        
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">

                      <div class="btn-group">
                        <button type="button" class="btn btn-warning btn-sm float-end" id="visitasipencabutan">Visitasi</button>
                        <button type="button" class="btn btn-success btn-sm float-end" id="setujuisuratpencabutan">Setujui</button>
                        <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Tutup</button>
                      </div>
                        
                    </div>
                </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div id="modal-lihatdraft-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
            <div class="card">
              <div class="card-header">
                <div class="card-title" id="juduldraftcabutsip">
                    Pencabutan SIP 
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
                <div class="row" >
                    <!-- jQuery will fill this -->
                </div>
                
              
              </div>
              <div class="card-footer">
                
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
                <table class="table table-striped" id="tbllistpencabutanbidfar" data-user="{{Auth::user()->id}}">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemohon</th>
                            <th>Nama Faskes</th>
                            <th>Lokasi</th>
                            <th class="orderable">Tanggal Diajukan</th>
                            <th>Alasan</th>
                            <th class="filterable">Jenis</th>
                            <th>Status</th>
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
      </div><!-- /.container-fluid -->
    </section>
</div>
  


  

@endsection
@section('js')

@endsection

@section('script')
<script>
    $(document).ready(function() {


      var table = $('#tbllistpencabutanbidfar').DataTable({

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
            { data: 'no'},
            { data: 'nama_nakes' },
            { data: 'nama_faskes' },
            { data: 'alamat_pengajuan' },
            { data: 'tgl_pencabutan' },
            { data: 'nama_alasan' },
            { data: 'jece'},
            { data: 'jenis' },
            {
              data: null,
              orderable: false,
              render: function(data, type, row) {
                  let cleanId = row.id.replace(/_/g, '');
                  if (row.verifdinkes == 1) {
                      return `<span class="badge bg-success">Sudah Disetujui</span>`;
                  } else {
                      return `
                          <div class="btn-group">
                            <button class="btn btn-sm btn-info detilpencabutan" data-id="${row.id}" data-file="${row.fileba}" data-nakes="${row.id_nakes}">
                                Proses
                            </button>
                          </div>
                      `;
                  }
              }
            }
        ],
        initComplete: function () {
            let api = this.api();

            // Add select filter for filterable columns
            api.columns('.filterable').every(function () {
                let column = this;
                let select = $('<select><option value="">All</option></select>')
                    .appendTo($(column.header()).empty())
                    .on('change', function () {
                        let val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? '^' + val + '$' : '', true, false).draw();
                    });

                column.data().unique().sort().each(function (d) {
                    select.append('<option value="' + d + '">' + d + '</option>');
                });
            });
        },
        order: (function () {
            // Find the first "orderable" header and set it as default desc
            let orderableIndex = $('#tbllistpencabutanbidfar thead th.orderable').first().index();
            return orderableIndex >= 0 ? [[orderableIndex, 'desc']] : [];
        })()
    
      });


      function getlistforbidfar()
      {

        $.ajax({
          type: 'ajax',
          method: 'get',
          url: '{{ route("getlistforbidfar")}}',
          data: {_token: "{{ csrf_token() }}"},
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

            let rows = data.map((peg, i) => ({
                no: i + 1, // index starts from 0, so add 1
                nama_nakes: peg.name,
                nama_faskes: peg.nama_faskes,
                alamat_pengajuan: peg.alamat_pengajuan,
                jenis: peg.jenis,
                tgl_pencabutan: peg.updated_at,
                nama_alasan: peg.nama_alasan,
                id: peg.id,
                verifdinkes: peg.verifdinkes,
                jece : peg.jece,
                fileba : peg.fileba,
                id_nakes : peg.id_nakes
            }));

            table.clear();
            table.rows.add(rows).draw();

            
          },
          error: function(request, status, error){
              $.fancybox.close();
              Swal.fire({
                icon: 'error',
                title: request.responseText,
                showConfirmButton: false,
                timer: 1500
              })
          }
        });

      }

      getlistforbidfar()

      $('#tbllistpencabutanbidfar').on('click', '.detilpencabutan', function () {
          let id = $(this).data('id'); // cleaner than attr
          let fileba = $(this).attr('data-file')
          let id_nakes = $(this).attr('data-nakes')
          let id_user = $('#tbllistpencabutanbidfar').attr('data-user');

          $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("detailsipuntukcabut")}}',
            data: {'id': id, 'fileba' : fileba, _token: "{{ csrf_token() }}"},
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

               
                let res = data.result;
                let surathost = data.surat_host;
                
                let leftCol = `
                  <div class="col-md-6 col-xs-12">
                    <div class="row">
                      <div class="col-md-12">
                        <embed src="{{ URL::to('/storageup') }}/${fileba}" 
                            style="width:100%;height:500px;">
                      </div>
                    </div>
                    <div class="row mt-3">
                      <div class="col-md-12">
                        <div class="input-group">
                          <input type="text" name="pesencabut" id="pesencabut" placeholder="Pesan ..." class="form-control">
                          <span class="input-group-append">
                            <button type="button" class="btn btn-primary" id="kirimpesencabut" data-user="${id_user}" data-nakes="${id_nakes}">Kirim</button>
                          </span>
                        </div>
                      </div>
                    </div>
                  </div>
                `;

                // Build log_cabut table if available
                let logRows = '';
                if (data.log_cabut && data.log_cabut.length > 0) {
                  logRows = data.log_cabut.map(log => `
                    <tr>
                      <td>${log.updated_at}</td>
                      <td>${log.name}</td>
                      <td>${log.keterangan}</td>
                    </tr>
                  `).join('');
                } else {
                  logRows = `<tr><td colspan="3" class="text-center text-muted">Tidak ada riwayat pencabutan</td></tr>`;
                }

                // Build right column content
                let rightCol = `
                  <div class="col-md-6 col-xs-12">
                    <dl class="row">
                      <dt class="col-sm-4">No. Dokumen</dt>
                      <dd class="col-sm-8">${res.no_surat}</dd>

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

                      <dt class="col-sm-4">No. STR</dt>
                      <dd class="col-sm-8">
                        <a class="btn btn-info btn-flat" href="https://satusehat.kemkes.go.id/sdmk/nakes/${res.no_str}" target="_blank">${res.no_str}</a>
                      </dd>
                    </dl>
                    <hr />

                    <h5 class="mt-4">Riwayat Pencabutan</h5>
                    <div class="card-body table-responsive p-0" style="max-height: 250px; ">
                      <table class="table table-striped table-valign-middle" id="histdokcabut">
                        <thead class="thead-light">
                          <tr>
                            <th style="width: 30%;">Tanggal</th>
                            <th style="width: 30%;">Nama</th>
                            <th style="width: 40%;">Keterangan</th>
                          </tr>
                        </thead>
                        <tbody style="overflow-y: auto;" id="bodyriwayat">
                          ${logRows}
                        </tbody>
                      </table>
                    </div>
                  </div>
                `;

                // inject both columns
                $('#result-container').html(leftCol + rightCol);

                $('#result-container').html(leftCol + rightCol);
                $('#setujuisuratpencabutan').attr('data-id', res.id);
                $('#setujuisuratpencabutan').attr('data-siplama', res.siplama);

                // $.fancybox.open({
                //   src: '#modal-lihatdraft-content',
                //   type: 'inline',
                //   touch: false,
                //   modal: true,
                //   clickSlide: false 
                // });

                $('#cthcth').modal('show')

                $('#kirimpesencabut').on('click', function(){
                  const btn = $(this);
                  var id_user = $(this).attr('data-user')
                  var id_nakes = $(this).attr('data-nakes')
                  var pesan = $('#pesencabut').val()
                  $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("setujupencabutanbidfar")}}',
                    data: {'id': id, 'fileba' : fileba, 'pesan' : pesan, 'id_user' : id_user, 'id_nakes' : id_nakes, _token: "{{ csrf_token() }}"},
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
                          title: 'Pesan Terkirim',
                          showConfirmButton: false,
                          timer: 1500
                        }).then(() => {

                          const updated_at = data.updated_at || new Date().toISOString().slice(0,19).replace('T',' ');
                          const admin = data.name || 'Admin Bidang Farmasi';
                          const keterangan = data.pesan || pesan;

                          // Build HTML row
                          const newRow = `
                              <tr>
                                  <td>${updated_at}</td>
                                  <td>${admin}</td>
                                  <td>${keterangan}</td>
                              </tr>
                          `;

                          // Append to table body
                          $('#bodyriwayat').prepend(newRow);

                          // Optional: clear input field
                          $('#pesencabut').val('');

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

      

      $(document).on('click', '.tutupintipdraftcabut', function () {
          $.fancybox.close();
      });

      

      $('#setujuisuratpencabutan').click(function(){
        var id_pengajuan = $(this).attr('data-id')
        var siplama = $(this).attr('data-siplama')
        var isadmin = 0
   

        $.ajax({
          type: 'ajax',
          method: 'post',
          url: '{{ route("setujupencabutanbidfar")}}',
          data: {'id_pengajuan': id_pengajuan, 'isadmin' : isadmin, 'siplama':siplama, _token: "{{ csrf_token() }}"},
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
                title: 'Persetujuan Pencabutan Berhasil',
                showConfirmButton: false,
                timer: 1500
              }).then(() => {
                $('#cthcth').modal('hide')
                getlistforbidfar()
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

    });
</script>
@endsection