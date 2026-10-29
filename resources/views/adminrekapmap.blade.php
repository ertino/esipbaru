@extends('layouts.adminlte4.back_master')
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
          <div class="col-md-12">
            <div class="card card-default">
              <div class="card-header">
                <h3 class="card-title">
                  Persebaran Nakes
                </h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body" id="mapsebarannakes">
                <div class="row">
                  <div class="col-md-12">
                    <form>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Area</label>
                            <select class="form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" id="pilihareamap">
                              <option value="all" selected>-- Semua --</option>
                              @foreach($kecamatan as $kec)
                                <option value="{{$kec['kode']}}">{{$kec['nama']}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Profesi</label>
                            <select class="select2 select2-hidden-accessible" multiple="" data-placeholder="Pilih Profesi (Kosongkan Untuk Melihat Semua Profesi)" style="width: 100%;" tabindex="-1" aria-hidden="true" id="pilihprofesimap">
                              @foreach($profesi as $prof)
                                <option value="{{strtoupper($prof->profesi)}}">{{strtoupper($prof->profesi)}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                    </form>
                    <button type="button" id="submitfiltermap" class="btn btn-success">Filter</button>
                  </div>
                </div>
                <hr />
                <div class="row">
                  <div class="col-md-9 col-xs-12">
                    <div class="pengajuanmap" id="pengajuanmap" style="height:600px;">
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-12">
                    <div class="card" style="height:600px;">
                      <div class="card-header">
                        <h3 class="card-title" id="judulnakesmap"></h3>
                      </div>
                      <div class="card-body table-responsive" >
                        <table class="table table-striped table-head-fixed p-0" id="sebelahmaplist">
                          <thead>
                            <tr>
                              <th style="width: 10px">#</th>
                              <th>Nakes</th>
                            </tr>
                          </thead>
                          <tbody id="listnakesmap">
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div> 
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="card" style="height:300px;">
                      <div class="card-header">
                        <h3 class="card-title" id="judulpersebaran"></h3>
                      </div>
                      <div class="card-body table-responsive" >
                        <table class="table table-striped table-head-fixed p-0">
                          <thead>
                            <tr>

                              <th>Profesi</th>
                              <th>Jumlah</th>
                            </tr>
                          </thead>
                          <tbody id="rekappersebaran">
                            
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="card" style="height:300px;">
                      <div class="card-header">
                        <h3 class="card-title" id="statkecamatan"> Persebaran Per Kecamatan</h3>
                      </div>
                      <div class="card-body" id="progressings" style="overflow-y: auto;">
        
                      </div>
                    </div>
                  </div>

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

