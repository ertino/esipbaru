@extends('layouts.adminlte4.back_master')
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
                <span class="fw-bold ms-1">30 done</span> this month
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
                  <td class="align-middle text-center text-sm"><span class="text-xs fw-bold">{{$loop->iteration}}</span></td>
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
                    <span class="text-xs fw-bold"> {{$row->description}} </span>
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
                          <span class="text-xs fw-bold">60%</span>
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
    <div class="col-md-12 col-xs-12">
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
  </div>


  

@endsection
@section('js')

@endsection