@extends('layouts.ePAD.back_master')
@section('content')

<!-- page content -->
<div class="right_col" role="main">
  <a href="{{ route('index') }}">
    Dashboard
  </a>
  <div class="page-title">
    <div class="title_left">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <h3>RINGKASAN EKSEKUTIF</h3>
      </div>
    </div>
  </div>

  <div class="row tile_count">
        <div class="col-md-6 col-sm-12 col-xs-12 tile_stats_count" data-toggle="tooltip" data-placement="bottom" title data-original-title="RETRIBUSI">
            <span class="count_top" ><i class="fa fa-bank"></i> TOTAL PAJAK</span>
            <div class="count rt2" style="font-size: 20px;">Rp. {{$totalPajak}}</div>

        </div>
        <div class="col-md-6 col-sm-12 col-xs-12 tile_stats_count" data-toggle="tooltip" data-placement="bottom" title data-original-title="RETRIBUSI NONTUNAI">
            <span class="count_top" ><i class="fa fa-credit-card"></i> TOTAL RETRIBUSI</span>
            <div class="count rt4" style="font-size: 20px;">Rp. {{$totalRetribusi}}</div>

        </div>
  </div>

  <div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel tile">
        <div class="x_title">
          <h2>Statistik Pajak</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content" style="Min-height:308px">
          <h4>TOP 5 PAJAK</h4>
          @foreach($detailPajak as $row)
          <div class="widget_summary">
            <div class="w_left w_25">
              <span>{{$row->jenis_pajak}}</span>
            </div>
            <div class="w_center w_55">
              <div class="progress">
                <div class="progress-bar bg-green" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$row->persentase}};">
                  <span class="sr-only">{{$row->persentase}} Complete</span>
                </div>
              </div>
            </div>
            <div class="w_right w_20">
              <span>{{$row->persentase}}</span>
            </div>
            <div class="clearfix"></div>
          </div>
          @endforeach
        </div>
      </div>
    </div>

    <div class="col-md-6 col-sm-6 col-xs-12">
      <div class="x_panel tile">
        <div class="x_title">
          <h2>Statistik Retribusi</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content" style="Min-height:308px">
        <h4>TOP 5 Retribusi</h4>
          @foreach($detailRetribusi as $rowr)
          <div class="widget_summary">
            <div class="w_left w_25">
              <span>{{$rowr->nama_retribusi}}</span>
            </div>
            <div class="w_center w_55">
              <div class="progress">
                <div class="progress-bar bg-red" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: {{$rowr->persentase}};">
                  <span class="sr-only">{{$rowr->persentase}} Complete</span>
                </div>
              </div>
            </div>
            <div class="w_right w_20">
              <span>{{substr($rowr->persentase,0,5)}} %</span>
            </div>
            <div class="clearfix"></div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    
  </div>

  <div class="row">
    <div class="col-md-12 col-sm-6 col-xs-12">
      <div class="x_panel tile">
        <div class="x_title">
          <h2>Realisasi Pajak</h2>
          <div class="clearfix"></div>
        </div>
        <div class="x_content" >
          <div class="chart-pie pt-4 pb-2" style="min-height:500px;" id="creport">
										<canvas class="timeline" id="canvase"></canvas>
									
					</div>
        </div>
      </div>
    </div>
  </div>


</div>

  
<!-- /page content -->


@endsection
