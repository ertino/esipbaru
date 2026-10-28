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
                <div id="modal-content" style="display: none;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>Rubah Password</h2>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <form id="changepassnakes" action="" method="post" class="form-horizontal">
                                    @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Password Baru</label>
                                                    <div class="input-group input-group">
                                                        <input type="password" class="form-control" id="newpassword" name="newpassword">
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
                                                        <input type="password" class="form-control" id="newpasswordc" name="newpasswordc">
                                                        <span class="input-group-append">
                                                        <button type="button" class="btn btn-default btn-flat intippass"><i class="fas fa-eye"></i></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form> 
                                    <button type="button" class="btn btn-success" id="submitubahpassnakes" data-id="{{$user_id}}">Update</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary float-right" id="close-modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid custom-rounded" src="{{ URL::to('/storagefoto')}}/admin.png"
                                    alt="User profile picture">
                            </div>
                            <hr />
                            <h3 class="profile-username text-center">{{Auth::user()->name;}}</h3>
                            <p class="text-muted text-center">Admin</p>
                        
                        </div>

                    </div>

                </div>

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Personal Info</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-primary float-right" id="btnUbahPass">Ubah Password</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">

                            
                                <div class="tab-pane" id="settings">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('js')
@endsection