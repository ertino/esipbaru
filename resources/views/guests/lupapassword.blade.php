@extends('layouts.minlte.back_daftar')
@section('content')
<body class="sidebar-mini" style="height: auto;">

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-12">
            <center>
            <a href="/">
                <img src="{{asset('images/NAKES.png')}}" height="300px" alt="">
            </a>
                               
            </center>
          </div>
          
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row" id="formlupa">
                <div class="col-md-4 col-xs-4">
                </div>
                <div class="col-md-4 col-xs-4" >
                    <form id="submitcredential" action="{{ route('guest.submit.cred') }}" method="post" class="form-horizontal">
                    @csrf

                        <div class="row">
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1" class="ms-0">Email</label>
                                    <input type="text" id="lpemail" name="lpemail" class="form-control">
                                </div>
                            </div>
                        </div>  

                        <div class="row">
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1" class="ms-0">no Handphone</label>
                                    <input type="text" id="lpnohp" name="lpnohp" class="form-control">
                                </div>
                            </div>
                        </div>  
                        <button type="submit" id="SubmitAfterValidation" class="btn btn-success">Lanjutkan</button>
                    </form>
                </div>
            </div>

            <div class="row" id="kodereset" style="display:none">
                <div class="col-md-4 col-xs-4">
                </div>
                <div class="col-md-4 col-xs-4" >
                    <form id="submitresetcode" action="{{ route('guest.reset.pass') }}" method="post" class="form-horizontal">
                    @csrf

                        <div class="row">
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1" class="ms-0">Kode Reset Password</label>
                                    <input type="text" id="lpkodereset" name="lpkodereset" class="form-control">
                                </div>
                            </div>
                        </div>  

                        <div class="row" style="display:none">
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1" class="ms-0">email</label>
                                    <input type="text" id="lpemailtoreset" name="lpemailtoreset" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1" class="ms-0">nowa</label>
                                    <input type="text" id="lpnohporeset" name="lpnohporeset" class="form-control">
                                </div>
                            </div>
                        </div>  

                        <div class="row">
                            <div class="col-md-12" >
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1" class="ms-0" id="countdown">Masukkan kode sebelum hitungan mundur selesai:</label>
                                </div>
                            </div>
                        </div>  
                        <button type="submit" class="btn btn-success" id="kirimkode">Kirim</button>
                        <button type="button" class="btn btn-primary" id="muatulang" style="display:none">Muat Ulang</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('js')

@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script>

    $(document).ready(function() {

        $('#lpkodereset').inputmask('99999');

        $('#submitcredential').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route ('guest.submit.cred') }}`;
            let formData = new FormData($(this)[0])
            formData.append('_token', "{{ csrf_token() }}");
            
            $.ajax({
                url: link,
                data: formData,
                cache:false,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                method: "POST",
                beforeSend: function() {
             
                },
                success: function (data) {
                    console.log(data)
                    if(data.success == true) {
                        $('#kodereset').show()
                        $('#formlupa').hide()
                        $('#lpemailtoreset').val(data.email)
                        $('#lpnohporeset').val(data.nohp)
                        var countdown = 60; // Set the initial countdown value in seconds
                        function updateCountdown() {
                            $('#countdown').text('Masukkan kode sebelum hitungan mundur selesai: '+countdown); // Update the countdown display
                            
                            if (countdown <= 0) {
                                $('#countdown').hide()
                                $("#kirimkode").hide()
                                $('#muatulang').show()
                                clearInterval(timer); // Stop the countdown timer
                            } else {
                                countdown--; // Decrease countdown by 1 second
                            }
                        }
                        
                        // Call the updateCountdown function every second
                        var timer = setInterval(updateCountdown, 1000);
                        
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Terjadi Kesalahan",
                            text: data.keterangan
                        });
                        //$('#btnsubmittte').attr('disabled', false)
                    }
                }
            });
            
        });


        $('#submitresetcode').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route ('guest.reset.pass') }}`;
            let formData = new FormData($(this)[0])
            formData.append('_token', "{{ csrf_token() }}");
            
            $.ajax({
                url: link,
                data: formData,
                cache:false,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                method: "POST",
                beforeSend: function() {
             
                },
                success: function (data) {
                    console.log(data)
                    if(data.success == true) {
                        Swal.fire(data.keterangan).then(function() {
                            
                            window.location.href = '{{ route("login") }}';
                            
                        });
                        
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Terjadi Kesalahan",
                            text: data.keterangan
                        });
                        //$('#btnsubmittte').attr('disabled', false)
                    }
                }
            });
            
        });

        $('#muatulang').click(function(){
            window.location.reload();
        });
    });

</script>
@endsection