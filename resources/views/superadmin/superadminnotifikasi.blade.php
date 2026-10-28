@extends('layouts.minlte.back_master')
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
                    Testing Notifikasi
                </h3>
            </div>
            <!-- /.card-header -->
            <form id="formTestWA">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nama Nakes</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="text" class="form-control" id="namaNakes" name="namaNakes" placeholder="Nama Nakes">
                            </div>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-secondary" id="carinakes">Cari</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>No. WA</label>
                        <input type="text" class="form-control" id="nomorWA" name="nomorWA" placeholder="Nomor WA">
                    
                    </div>

                    <div class="form-group">
                        <label>Pesan</label>
                        <textarea class="form-control" id="pesannya" name="pesannya" placeholder="Tuliskan Pesan..."></textarea>
                    </div>
                    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="button" class="btn btn-primary" id="testkirim">Test</button>
                  <button type="button" class="btn btn-success" id="submitkirim">Kirim</button>
                </div>
            </form>
            <div class="overlay" id="onloadhistory" style="display:none">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
            <!-- /.card-body -->
        </div>

        <div class="row">
            <div id="modal-hasilcari" style="display: none; width: 1200px; max-width: 90%; max-height: 80vh;">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>Hasil Pencarian Nakes</h5> 
                        </div>

                        <div class="card-tools">
                        <button type="button" class="btn btn-secondary btn-sm float-right" id="close-modalcari">Close</button>
                        </div>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-row-bordered table-hover align-middle">
                                <thead>
                                    <tr class="fw-bold text-muted">
                                        <th>Nama</th>
                                        <th>Kompetensi</th>
                                        <th>No. WA</th>
                                        <th>Pesan</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody id="tabel-hasilcari">
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            Belum ada data
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-muted fs-7 mt-2">
                            Klik salah satu baris untuk memilih nomor WhatsApp dan pesan.
                        </div>
                    
                    </div>
                </div>
            </div>
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

        $('#testkirim').on('click', function(e){
            e.preventDefault;
            let link = `{{route('testkoneksiwa')}}`;
            let formData = new FormData($('#formTestWA')[0])
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
                success: function (res) {
                    $('#onloadhistory').hide()
                    const detail = typeof res.message === 'string'
                        ? res.message
                        : JSON.stringify(res.message);

                    Swal.fire({
                        icon: res.success ? 'success' : 'error',
                        title: res.success ? 'Berhasil!' : 'Gagal!',
                        html: `
                            <div style="text-align: left;">
                                <p><strong>HTTP Status:</strong> ${res.http_status}</p>
                                <p><strong>Pesan:</strong> ${$('<div>').text(detail || '-').html()}</p>
                                <p><strong>Status:</strong> ${res.success ? 'Sukses' : 'Gagal'}</p>
                            </div>
                        `,
                        confirmButtonText: 'OK'
                    });
                    tableLoading = false;
                },
                error: function (xhr) {
                    $('#onloadhistory').hide()
                    const status = xhr.status || 0;
                    const response = xhr.responseJSON || {};
                    const message = response.message || 'Terjadi kesalahan saat menghubungi server.';

                    Swal.fire({
                        icon: 'error',
                        title: 'Request Gagal!',
                        html: `
                            <div style="text-align: left;">
                                <p><strong>HTTP Status:</strong> ${status}</p>
                                <p><strong>Pesan:</strong> ${$('<div>').text(message).html()}</p>
                            </div>
                        `,
                        confirmButtonText: 'Tutup'
                    });
                    tableLoading = false;
                }
                
            });

        })

        $('#carinakes').on('click', function(e){
            e.PreventDefault;
            var namanakes = $('#namaNakes').val()
            if(namanakes != '')
            {
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '{{ route("getlogwabyname")}}',
                    data: {'nama': namanakes, _token: "{{ csrf_token() }}"},
                    cache:false,
                    dataType: 'json',
                    beforeSend: function(){

                        $('#tabel-hasilcari').html(`
                            <tr>
                                <td colspan="5" class="text-center">
                                    Memuat data...
                                </td>
                            </tr>
                        `);
                        
                    },
                    success: function(data){
                        
                        
                        if(data.success == true) {

                            let rows = '';

                            if (data.result && data.result.length > 0) {

                                data.result.forEach(function (item) {

                                    const escapeHtml = function (value) {
                                        return $('<div>')
                                            .text(value ?? '')
                                            .html();
                                    };

                                    rows += `
                                        <tr class="baris-hasilcari"
                                            data-nomor="${escapeHtml(item.nomor)}"
                                            data-pesan="${escapeHtml(item.pesan)}"
                                            style="cursor: pointer;">

                                            <td>${escapeHtml(item.nama)}</td>
                                            <td>${escapeHtml(item.kompetensi)}</td>
                                            <td>${escapeHtml(item.nomor)}</td>
                                            <td>${escapeHtml(item.pesan)}</td>
                                            <td>${escapeHtml(item.created_at)}</td>

                                        </tr>
                                    `;
                                });

                            } else {

                                rows = `
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            Tidak ada data ditemukan.
                                        </td>
                                    </tr>
                                `;
                            }

                            $('#tabel-hasilcari').html(rows);



                            $.fancybox.open({
                                src: '#modal-hasilcari',
                                type: 'inline',
                                touch: false,
                                modal: true,
                                clickSlide: false,
                                afterShow: function() {
                                    $('#close-modalcari').click(function() {
                                        $.fancybox.close();
                                    });
                                }
                            });

                            
                        } else {

                            
                        }
                    },
                    error: function (xhr) {

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan saat mengambil data.'
                        });

                    }
                });


            } else {

                Swal.fire({
                        icon: 'error',
                        title: 'Isikan Nama Nakes!'
                    });

            }

        })

        $(document).on('click', '.baris-hasilcari', function () {

            const nomor = $(this).attr('data-nomor') || '';
            const pesan = $(this).attr('data-pesan') || '';

            // Fill the WhatsApp form
            $('#nomorWA').val(nomor);
            $('#pesannya').val(pesan);

            // Close the Fancybox modal
            $.fancybox.close();

            // Optional: show confirmation
            Swal.fire({
                icon: 'success',
                title: 'Data Dipilih',
                text: 'Nomor WhatsApp dan pesan berhasil dimasukkan.',
                timer: 1200,
                showConfirmButton: false
            });
        });


    })

        
</script>

@endsection