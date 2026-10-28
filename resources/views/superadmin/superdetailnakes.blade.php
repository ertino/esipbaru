@extends('layouts.minlte.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang, Super Admin</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- COLOR PALETTE -->
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline" id="nakesmain" data-id="{{$id_nakes}}">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/user.png') }}" alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">Nina Mcintire</h3>

                <p class="text-muted text-center">Software Engineer</p>

                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
              </div>
              <div class="overlay beforeload">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

           
          </div>
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Dokumen</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Pengajuan</a></li>
                  <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">SIP</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="activity">
                    <h5> Act </h5>
                  </div>
                  <div class="tab-pane" id="timeline">
                    <h5> Time </h5>
                  </div>
                  <div class="tab-pane" id="settings">
                    <h5> Set </h5>
                  </div>
                </div>
              
                
              </div>
              <div class="overlay beforeload">
                  <i class="fas fa-3x fa-sync-alt fa-spin"></i>
              </div>
            </div>
          </div>
        </div>
        
        <!-- END TYPOGRAPHY -->
      </div><!-- /.container-fluid -->
      
    </section>
</div>
  


  

@endsection
@section('js')

@endsection

@section('script')
<script>
    $(document).ready(function() {

      const origin = window.location.origin;

      function getalldetail()
      {
        let id_nakes = $('#nakesmain').attr('data-id')

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("supernakesdetail")}}',
            data: {'id_nakes': id_nakes,  _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){
              console.log(data)
              if(data.success == true) {
                
                
                  
              } else {
                  alert(data.keterangan)
              }
            },
              error: function(request, status, error){
                //alert(request.responseText);
            }
          });
      }
      getalldetail()

    });
</script>
@endsection