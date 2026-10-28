@extends('layouts.templet.back_master')
@section('content')

<div class="container-fluid py-4">
  <div class="row mb-4">
    <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
      <div class="card">
        <div class="card-header pb-0">
          <div class="row">
            <div class="col-lg-6 col-7">
              <h6>Total Aplikasi dan Integrasi</h6>
              <p class="text-sm mb-0">
                <i class="fa fa-check text-info" aria-hidden="true"></i>
                <span class="font-weight-bold ms-1">{{$user_id}} done</span> this month
              </p>
            </div>
            <div class="col-lg-6 col-5 my-auto text-end">
              <div class="dropdown float-lg-end pe-4">
                <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa fa-ellipsis-v text-secondary" aria-hidden="true"></i>
                </a>
                <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                  <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a></li>
                  <li><a class="dropdown-item border-radius-md" href="javascript:;">Another action</a></li>
                  <li><a class="dropdown-item border-radius-md" href="javascript:;">Something else here</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Aplikasi</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">PIC</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Deskripsi</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Integrasi</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progres</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th> 
                </tr>
              </thead>
              <tbody>
              @foreach($listApp as $row)
                <tr>
                  <td class="align-middle text-center text-sm"><span class="text-xs font-weight-bold">{{$loop->iteration}}</span></td>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div>
                        <img src="{{$row->img_url}}" class="avatar avatar-sm me-3" alt="xd">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{$row->app_name}}</h6>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="avatar-group mt-2">
                    @foreach($listPIC as $pic)
                      @if($row->id == $pic->app_id )
                      <a href="javascript:;" class="avatar avatar-xs rounded-circle piaisi" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{$pic->name}}">
                        <img src="{{$pic->photo_url}}" alt="team1">
                      </a>
                      @endif
                    @endforeach
                    </div>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="text-xs font-weight-bold"> {{$row->description}} </span>
                  </td>
                  <td>
                    <div class="avatar-group mt-2">
                    @foreach($listIntegrasi as $int)
                      @if($row->id == $int->host_app )
                      <a href="javascript:;" class="avatar avatar-xs rounded-circle integrate" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{$int->client_name}}">
                        <img src="{{$int->client_img}}" alt="team1">
                      </a>
                      @endif

                      @if($row->id == $int->client_app )
                      <a href="javascript:;" class="avatar avatar-xs rounded-circle integrate" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{$int->host_name}}">
                        <img src="{{$int->host_img}}" alt="team1">
                      </a>
                      @endif
                    @endforeach
                    </div>
                  </td>
                  <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                      <div class="progress-info">
                        <div class="progress-percentage">
                          <span class="text-xs font-weight-bold">60%</span>
                        </div>
                      </div>
                      <div class="progress">
                        <div class="progress-bar bg-gradient-info w-60" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                      </div>
                    </div>
                  </td>
                  <td class="align-middle text-center text-sm">
                  @if($row->isApproved == '0')
                  <button class="btn btn-primary btn-sm" type="button">Review</button>
                  <br />
                  @endif
                  <button class="btn btn-info btn-sm" type="button" data-bs-target="#appModal" data-bs-toggle="modal">Detail</button>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
  </div>

  <div class="row mb-4">
    <div class="col-md-8 col-xs-12">
      <!-- start -->
      <div class="card">
        <div class="card-header">
            <div class="row">
              <div class="col-lg-6 col-7">
                <h6>Kaleidoskop Aplikasi</h6>
              </div>
              <div class="col-lg-6 col-5 my-auto text-end">
                <button class="btn btn-primary btn-sm eventing" >Event</button>
                <button class="btn btn-info btn-sm tasking">Task</button>
              </div>
            </div>
        </div>
        <hr />
        <div class="card-body">
          <div id="calendar"></div>
        </div>
        <div class="card-footer d-flex">
        </div>
      </div>

      <!-- end -->
    </div>
    <div class="col-lg-4 col-md-6">
      <div class="card h-100">
        <div class="card-header pb-0">
            <h6>Aktifitas Terakhir</h6>
        </div>
        <div class="card-body p-3">
          <div class="timeline timeline-one-side">
            <!-- for each -->
            @foreach($listActivity as $row)
              <div class="timeline-block mb-3">
                <span class="timeline-step">
                  @if($row->jenis == 'dev')
                  <i class="material-icons text-danger text-gradient">code</i>          
                  @elseif($row->jenis == 'imp')
                  <i class="material-icons text-success text-gradient">trending_up</i>
                  @else
                  <i class="material-icons text-danger text-gradient">bug_report</i>
                  @endif
                </span>
                <div class="timeline-content">
                  <div class="row">
                    <div class="col-2 col-md-2 col-xs-2">
                      <td class="align-top text-center text-sm">
                        <div class="avatar-group mt-2">
                          <a href="javascript:;" class="avatar avatar-xs rounded-circle piaisi" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="{{$row->name}}">
                            <img src="{{$row->photo_url}}" alt="team1">
                          </a>
                        </div>
                      </td>
                    </div>
                    <div class="col-10 col-md-10 col-xs-10">
                      <h6 class="text-dark text-sm font-weight-bold mb-0">{{$row->activity}}</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">{{$row->timestamp}}</p>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>


  

@endsection
@section('js')

@endsection