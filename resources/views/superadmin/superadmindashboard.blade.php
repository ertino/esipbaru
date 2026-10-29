@extends('layouts.adminlte4.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang Superadmin</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- COLOR PALETTE -->

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
                    <table class="table table-striped" id="tblpendaftarhistsa">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama</th>
                              <th>Foto</th>
                              <th>No Reg STR</th>
                              <th>Kompetensi</th>
                              <th>Email</th>
                              <th>No Hp</th>
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
        
        

        
       
        <!-- END TYPOGRAPHY -->
      </div><!-- /.container-fluid -->
    </section>
</div>
  
@endsection

@section('script')
<script>
    $(document).ready(function() {

      const origin = window.location.origin;
      

      $('#tblpendaftarhistsa').on('click','.editdetailnakes', function(){
    
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

      var tablehistoriajus = $('#tblpendaftarhistsa').DataTable({
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
            { data: 'kompetensi' },
            { data: 'email' },
            { data: 'notelp' },
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
              console.log(data)
              
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

                  let aktifasi = `<button class="btn btn-sm btn-primary reaktifasi" data-bs-toggle="tooltip" data-bs-placement="top" title="Reaktifasi"
                                  id="${pendaftaran.id}" data-file="${pendaftaran.origin_file}" data-url="${pendaftaran.url_qr}"
                                  data-nama="${pendaftaran.nama}" data-str="${pendaftaran.no_reg}" data-email="${pendaftaran.email}"
                                  data-foto="${pendaftaran.img_src}" data-salinan="${pendaftaran.salinan}"
                                  data-kompetensi="${pendaftaran.kompetensi}" data-profesi="${pendaftaran.profesi}"
                                  data-tglstr="${pendaftaran.tgl_keluar_str}" data-aktifasi="${pendaftaran.isActive}">
                                  `+jenisaktifasi+`
                              </button>`;

                  // Determine the button actions based on current_status
                  button_aksi = `
                          <div class="btn-group">
                              <a class="btn btn-sm btn-success detailingnakes" href="/superdetailnakes/${pendaftaran.id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Detail Nakes">
                                  DETAIL
                              </button>
                          </div>`;

                  // Add file link if origin_file is not 'scanned'
                  if (pendaftaran.origin_file !== 'scanned') {
                      addfile = `&nbsp; &nbsp;<a href="${origin}/getoriginstr/${pendaftaran.origin_file}.pdf" target="_blank">
                          <i class="fas fa-file"></i></a>`;
                  }

                  // Determine the correct image source
                  if (pendaftaran.img_src !== null && pendaftaran.foto_not_avail !== '1') {
                      foto = `<a href="#tblpendaftarhistsa" id="${pendaftaran.id}" class="changepp" data-nama="${pendaftaran.nama}" data-imgsrc = "${pendaftaran.img_src}" data-imgusr = "${pendaftaran.saved_photo}">
                          <img src="${pendaftaran.img_src}" width="50px" alt="user image"></a>`;
                  } else {
                      foto = `<a href="#tblpendaftarhistsa" id="${pendaftaran.id}" class="changepp" data-nama="${pendaftaran.nama}" data-imgsrc = "${pendaftaran.img_src}" data-imgusr = "${pendaftaran.saved_photo}">
                          <img src="${origin}/storagefoto/${pendaftaran.saved_photo}" width="50px" alt="user image"></a>`;
                  }

                  var nama_nakes = `<a href="#tblpendaftarhistsa" class="toprofilingnakes" data-id="${pendaftaran.id_user}">${pendaftaran.nama}</a>`

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
              
                tablehistoriajus.clear();
                tablehistoriajus.rows.add(processedData).draw();

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