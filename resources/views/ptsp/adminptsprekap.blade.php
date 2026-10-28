@extends('layouts.minlte.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang e-SIP</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- COLOR PALETTE -->

        <div class="row">
            <div id="modal-tungguproses-content" style="display: none;">
                <center>
                <i class="fas fa-hourglass"></i>
                <h5>Mohon Tunggu..</h5>
                </center>
            </div>
        </div>
        
        
        <div class="row">
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  Chart Rekap Pelayanan
                </h3>
                <div class="card-tools">
                  <select id="periodasip">
                    @foreach($periode_sip as $per)
                    <option value="{{$per->yearly}}">{{$per->yearly}}</option>
                    @endforeach
                  </select>
                  <button class="btn btn-sm btn-primary" id="rekaplayanansum"><i class="far fa-star"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="chart">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class="">
                            </div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class="">
                            </div>
                        </div>
                    </div>
                    <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 532px;" width="1064" height="500" class="chartjs-render-monitor">
                    </canvas>
                </div>
              </div>
              <!-- /.card-body -->

              <div class="overlay" id="loadtblchartpelayanan" style="display:none">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
              <h3 class="card-title">Detail Pelayanan</h3>
              </div>

              <div class="card-body table-responsive" style="height: 500px;">
                <table class="table table-head-fixed" id="tbldtlpelayanan">
                  <thead>
                  <tr>
                    
                    <th>Periode</th>
                    <th>Total Pelayanan TW</th>
                    <th>Total Pelayanan Terlambat</th>
                    <th>Perubahan TW</th>
                    <th>Perubahan Terlambat</th>
                    <th>Pencabutan TW</th>
                    <th>Pencabutan Terlambat</th>
                    <th>Faskes TW</th>
                    <th>Faskes Terlambat</th>
                    <th>Mandiri TW</th>
                    <th>Mandiri Terlambat</th>
                  </tr>
                  </thead>
                  <tbody id="rekapanptspnya">
                  
                  </tbody>
                </table>
              </div>

            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
              <h3 class="card-title">Sip Per Profesi</h3>
              </div>

              <div class="card-body table-responsive" style="height: 500px;">
                <form id="form-filter-dftr" class="form-label-left input_mask">
                  <div class="row">        
                    <div class="col-md-6 col-sm-6  form-group has-feedback">
                      <div class="form-group">
                        <label for="exampleFormControlSelect1" class="ms-0">Faskes / Mandiri</label>
                        <select class="form-control" id="cariisfaskes" name="cariisfaskes" required>
                            <option value="2">Semua</option>
                            <option value="1" selected>Faskes</option>
                            <option value="0">Mandiri</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6 col-sm-6  form-group has-feedback">
                      <div class="form-group">
                        <label for="exampleFormControlSelect1" class="ms-0">Profesi</label>
                        <select class="form-control" id="carijenisprofesi" name="carijenisprofesi" required>
                                <option value="0" disabled selected> -- Pilih Profesi -- </option>
                                <option value="ALLP">Semua Profesi</option>
                                <option value="DALL">Semua Dokter</option>
                                <option value="DUALL">Dokter Umum & Spesialis</option>
                                <option value="DGALL">Semua Dokter Gigi</option>
                                <option value="DU">DOKTER UMUM</option>
                                <option value="DS">DOKTER SPESIALIS</option>
                                <option value="DG">DOKTER GIGI</option>
                                <option value="DGS">DOKTER GIGI SPESIALIS</option>
                                <option value="APJ">APOTEKER PENANGGUNG JAWAB</option>
                            @foreach($semuaprofesi as $profe)
                                <option value="{{$profe->alias_profesi}}">{{Str::upper($profe->nama_profesi)}}</option>
                            @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </form>
                <table class="table table-head-fixed" id="tblperprofesi">
                  <thead>
                  <tr>
                   
                    <th>Nama</th>
                    <th>No STR</th>
                    <th>No SIP</th>
                    <th>Kompetensi</th>
                    <th>Salinan</th>
                    <th>Nama Faskes</th>
                    <th>Alamat</th>
                    <th>Kecamatan</th>
                    <th>Tanggal TTE</th>
                    <th>Valid Hingga</th>
                    <th>No Telp</th>
                    <th>No Ijin</th>
                  </tr>
                  </thead>
                  <tbody id="perprofesi">
                  
                  </tbody>
                </table>
              </div>
              <div class="overlay" id="loadtblprofesi" style="display:none">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>

            </div>
            <!-- /.card -->
          </div>
        </div>

        <div class="row">
          <div class="col-md-6 col-xs-12">
            <div class="card">
              <div class="card-header">
              <h3 class="card-title">SIP Akan Kadaluarsa (< 100 Hari)</h3>
              </div>

              <div class="card-body table-responsive" style="height: 500px;">
                <table class="table table-head-fixed" id="tblsipakankadal">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama Nakes</th>
                    <th>Salinan</th>
                    <th>Tempat Praktik</th>
                    <th>Berlaku Hingga</th>
                    <th>Sisa Waktu</th>
                  </tr>
                  </thead>
                  <tbody id="rekapsipakankadal">
                    @foreach($sipakankadal as $sip)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><div class="user-block"><img class="img-circle img-bordered-sm" src="{{ URL::to('/storagefoto') }}/{{$sip->saved_photo}}"></td>
                        <td>{{$sip->nama_nakes}}</td>
                        <td>{{$sip->salinan}}</td>
                        <td>{{$sip->nama_faskes}} - {{$sip->nama_lokasi}}</td>
                        <td>{{$sip->valid_until}}</td>
                        <td>{{$sip->expiring_count}}</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
            <div class="card">
              <div class="card-header">
              <h3 class="card-title">STR Akan Kadaluarsa (< 100 Hari)</h3>
              </div>

              <div class="card-body table-responsive" style="height: 500px;">
                <table class="table table-head-fixed" id="tblstrakankadal">
                  <thead>
                  <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nama Nakes</th>
                    <th>Berlaku Hingga</th>
                    <th>Sisa Waktu</th>
                  </tr>
                  </thead>
                  <tbody id="rekapstrakankadal">
                    @foreach($strakankadal as $str)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td><div class="user-block"><img class="img-circle img-bordered-sm" src="{{ URL::to('/storagefoto') }}/{{$str->saved_photo}}"></td>
                        <td>{{$str->nama_nakes}}</td>
                        <td>{{$str->tgl_doc}}</td>
                        <td>{{$str->expiring_count}}</td>
                      </tr>
                    @endforeach
                  
                  </tbody>
                </table>
              </div>
            </div>
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

      let resultData = [];

      var tbls = $('#tbldtlpelayanan').DataTable({
        columns: [
          { data: 'periode' },
          { data: 'total' },
          { data: 'terlambat' },
          { data: 'total_perubahan'},
          { data: 'total_perubahan_terlambat'},
          { data: 'total_pencabutan'},
          { data: 'total_pencabutan_terlambat'},
          { data: 'total_faskes'},
          { data: 'total_faskes_terlambat'},
          { data: 'total_mandiri'},
          { data: 'total_mandiri_terlambat'}
        ],
        dom: 'Blfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
      })

      var tblsp = $('#tblperprofesi').DataTable({
        columns: [
          { data: 'nama_nakes' },
          { data: 'no_str' },
          { data: 'no_surat' },
          { data: 'kompetensi'},
          { data: 'salinan'},
          { data: 'nama_faskes'},
          { data: 'nama_lokasi'},
          { data: 'kec_lokasi'},
          { data: 'signed_date'},
          { data: 'valid_until'},
          { data: 'notelp'},
          { data: 'nomor_ijin'}
        ],
        dom: 'Blfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
      })

      var periodasip = $('#periodasip').val()
      initchartrekap(periodasip)

      $('#periodasip').change(function() {
  
        var year = $(this).val();
        initchartrekap(year)
      });

      function rekapperprofesi(){
        var carijenisprofesi = $('#carijenisprofesi').val()
        var cariisfaskes = $('#cariisfaskes').val()

        $.ajax({
          type: 'ajax',
          method: 'get',
          url: '{{ route("list.sip.perprofesi")}}',
          data: {'carijenisprofesi': carijenisprofesi, 'cariisfaskes' : cariisfaskes, _token: "{{ csrf_token() }}"},
          dataType: 'json',
          beforeSend: function(data){

            $('#loadtblprofesi').show()

          },
          success: function(data){

            //console.log(data)
            $('#loadtblprofesi').hide()
            tblsp.clear().draw();
            if (data.success == true) {
              if (data.result.length > 0) {
                tblsp.rows.add(data.result);
                tblsp.draw();
              }
            }
          },

          error: function(request, status, error) {
              alert(request.responseText);
              
          }
        });
      }

      function initchartrekap(year) {

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("get.chartpelayanan")}}',
            data: {'year': year, _token: "{{ csrf_token() }}"},
            dataType: 'json',
            beforeSend: function(data){

              $('#loadtblchartpelayanan').show()

            },
            success: function(data){
              
              $('#loadtblchartpelayanan').hide()
              var areaChartData = data.result
              var areaChartOptions = {
                maintainAspectRatio : false,
                responsive : true,
                legend: {
                  display: false
                },
                scales: {
                  xAxes: [{
                    gridLines : {
                      display : false,
                    }
                  }],
                  yAxes: [{
                    gridLines : {
                      display : false,
                    }
                  }]
                }
              }

              if (window.myBarChart) {
                window.myBarChart.destroy();
              }

              var barChartCanvas = $('#barChart').get(0).getContext('2d')
              var barChartData = $.extend(true, {}, areaChartData)
              var temp0 = areaChartData.datasets[0]
              var temp1 = areaChartData.datasets[1]
              barChartData.datasets[0] = temp1
              barChartData.datasets[1] = temp0

              var barChartOptions = {
                responsive              : true,
                maintainAspectRatio     : false,
                datasetFill             : false
              }

              window.myBarChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
              });
                
            },

            error: function(request, status, error) {
                alert(request.responseText);
               
            }
        });


        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("get.detailrekappelayanan")}}',
            data: {'year': year, _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){
              

              tbls.clear().draw();
              if (data.success == true) {
                if (data.result.length > 0) {
                  tbls.rows.add(data.result);
                  tbls.draw();
                  $('#rekaplayanansum').on('click', function(){
                  
                  })
                }

                resultData = data.result;
              }
            },

            error: function(request, status, error) {
                alert(request.responseText);
               
            }
        });

      }

      $('#carijenisprofesi, #cariisfaskes').change(function() {
          rekapperprofesi()
          //alert('OK')
      });

      $('#rekaplayanansum').on('click', function() {

        $.ajax({
            method: 'POST',
            url: '{{ route("get.summarylayanan") }}',
            data: JSON.stringify({
                result: resultData, // <--- flatten the data structure
                _token: "{{ csrf_token() }}"
            }),
            contentType: 'application/json', // Important: send as JSON
            processData: false,              // Don't process as form
            dataType: 'json',

            beforeSend: function() {
                $.fancybox.open({
                    src: '#modal-tungguproses-content',
                    type: 'inline',
                    touch: false,
                    modal: true,
                    clickSlide: false
                });
            },

            success: function(data) {
                $.fancybox.close();
                Swal.fire(data.summary);
            },

            error: function(request, status, error) {
                alert(request.responseText);
            }
        });
    });

    })

</script>

@endsection

