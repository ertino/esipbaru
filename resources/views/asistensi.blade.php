<!--
=========================================================
* Material Dashboard 2 - v3.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <!-- Meta, title, CSS, favicons, etc. -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('dashbor/images/favicon.ico') }}" type="image/ico" />

      <title>Halaman Permohonan Untuk Diskominfo</title>

      <!---- starts here ---->
      <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
      <link href="{{ asset('templet/css/nucleo-icons.css') }}" rel="stylesheet" />
      <link href="{{ asset('templet/css/nucleo-svg.css') }}" rel="stylesheet" />
    <!-- Font Awesome Icons -->
      <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
      <link id="pagestyle" href="{{ asset('templet/css/material-dashboard.css?v=3.0.0') }}" rel="stylesheet" />

      <link href="{{ asset('js/fullcalendar5/lib/main.css') }}" rel='stylesheet' />

      
  </head>

  <body class="g-sidenav-show  bg-gray-200">
    
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
      <!-- Navbar -->
      
      <!-- End Navbar -->
      <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="ratingModal" >
        <div class="modal-dialog">
          <div class="modal-content">
            <!-- Modal Header -->
              <div class="modal-header">
                  <h4 class="modal-title">Penilaian Kepuasan</h4>
              </div>
            <!-- Modal body -->
              <div class="modal-body">
                <div class="row mt-4">
                  <div class="col-lg-6 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2 ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="row gx-4 mb-2">
                          <div class="col-5">
                            <div class="avatar avatar-xl position-relative">
                              <img src="https://surat.cilacapkab.go.id/assets/uploads/userphoto/profil.jpg" alt="profile_image" class="w-100 border-radius-lg shadow-sm"><span></span>
                            </div>
                          </div>
                          <div class="col-7">
                            <div class="h-100">
                                <h6 class="mb-1">
                                    Eddo Ertino
                                </h6>
                                <p class="mb-0 font-weight-normal text-sm">
                                    Programmer
                                </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <center><div id="reviewUser"></div></center>
                        <div style="display:none">
                          <input type="text" id="idUserNilai" name="idUserNilai" class="form-control" value="2" readonly>
                          <input type="text" id="nilaiUser" name="nilaiUser" class="form-control" value="0" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-6 col-md-6 mt-4 mb-4">
                    <div class="card z-index-2 ">
                      <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2 bg-transparent">
                        <div class="row gx-4 mb-2">
                          <div class="col-5">
                            <div class="avatar avatar-xl position-relative">
                              <img src="https://surat.cilacapkab.go.id/assets/assets_login/img/icon/logoasoka.png" alt="profile_image" class="w-100 border-radius-lg shadow-sm"><span></span>
                            </div>
                          </div>
                          <div class="col-7">
                            <div class="h-100">
                                <h6 class="mb-1">
                                    ASOKA
                                </h6>
                                <p class="mb-0 font-weight-normal text-sm">
                                    Aplikasi
                                </p>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <center><div id="reviewApp"></div></center>
                        <div style="display:none">
                          <input type="text" id="idAppNilai" name="idAppNilai" class="form-control" value="1" readonly>
                          <input type="text" id="nilaiApp" name="nilaiApp" class="form-control" value="0" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-6">
                    <div class="input-group input-group-static mb-4">
                      <textarea placeholder="Review Tentang Pembicara.." id="ttguser"></textarea>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="input-group input-group-static mb-4">
                      <textarea placeholder="Review Tentang Aplikasi.." id="ttgapp"></textarea>
                    </div>
                  </div>
                </div>          
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                  <button type="button" class="btn btn-primary" id="submitReview">Submit</button>
              </div>

          </div>
        </div>
      </div>

      <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="agendaModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <!-- Modal Header -->
              <div class="modal-header">
                  <h4 class="modal-title">Informasi Agenda</h4>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
            <!-- Modal body -->
              <div class="modal-body">
                  <div class="row mb-4">
                      <form>     
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="input-group input-group-static mb-4">
                                      <label for="exampleFormControlSelect1" class="ms-0">Aplikasi</label>
                                      <input type="text" id="dapp_name" name="dapp_name" class="form-control" readonly>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="input-group input-group-static mb-4">
                                      <label for="exampleFormControlSelect1" class="ms-0">Jenis Servis</label>
                                      <input type="text" id="djenis_servis" name="djenis_servis" class="form-control" readonly>
                                  </div>

                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="input-group input-group-static mb-4">
                                      <label for="exampleFormControlSelect1" class="ms-0">OPD</label>
                                      <input type="text" id="dOPD" name="dOPD" class="form-control" readonly>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="input-group input-group-static mb-4">
                                      <label for="exampleFormControlSelect1" class="ms-0">Tanggal</label>
                                      <input type="text" id="dtgl_permohonan" name="dtgl_permohonan" class="form-control" readonly>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-6">
                                  <div class="input-group input-group-static mb-4">
                                      <label class="ms-0">Keterangan</label>
                                      <input type="text" id="dketerangan" name="dketerangan" class="form-control" onchange="checkAll(this.value,'ket')">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="input-group input-group-static mb-4">
                                      <label for="exampleFormControlSelect1" class="ms-0">Lokasi</label>
                                      <input type="text" id="dlokasi" name="dlokasi" class="form-control" readonly>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-md-6">
                                  <div class="input-group input-group-static mb-4">
                                      <label class="ms-0">Status Permohonan</label>
                                      <input type="email" id="dstatus_permohonan" name="dstatus_permohonan" class="form-control">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="input-group input-group-static mb-4">
                                      <label class="ms-0">Jadwal Terubah</label>
                                      <input type="text" id="djadwal_rev" name="djadwal_rev" class="form-control">
                                  </div>
                              </div>
                          </div>
                      </form>
                  </div>            
              </div>

              <!-- Modal footer -->
              <div class="modal-footer">
                  <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
              </div>

          </div>
        </div>
      </div>
      
      
      <div class="container-fluid py-4">
          <div class="row mb-4">
              <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
                  <div class="card card-frame">
                      <div class="card-header pb-0">
                          <center><h5>Silahkan Isi Form Permohonan Berikut</h5></center>
                      </div>
                      <hr />
                      <div class="card-body">
                          <form method="POST" action="{{route('submit.asistensi')}}">
                              @csrf
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="input-group input-group-static mb-4">
                                          <label for="exampleFormControlSelect1" class="ms-0">Pilih Aplikasi</label>
                                          <select class="form-control" name="aplikasi" id="selAplikasi">
                                          @foreach($listApp as $row)
                                              <option value="{{$row->id}}">{{$row->app_name}}</option>
                                          @endforeach
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="input-group input-group-static mb-4">
                                          <label for="exampleFormControlSelect1" class="ms-0">Jenis Servis</label>
                                          <select class="form-control" name="jenis_servis" id="selServis">
                                          <option value="1">Asistensi</option>
                                          <option value="2" disabled>Laporan Bug / Error</option>
                                          </select>
                                      </div>

                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="input-group input-group-static mb-4">
                                          <label for="exampleFormControlSelect1" class="ms-0">Pilih OPD (pilih lainnya jika tidak ada pada list dan berikan nama opd pada keterangan)</label>
                                          <select class="form-control" name="opd_requester" id="selOPD" onchange="checkAll(this.value, 'OPD')">
                                              <option value="0" disabled selected>Pilih OPD</option>
                                          @foreach($listOPD as $row)
                                              <option value="{{$row->kodes}}">{{$row->nama}}</option>
                                          @endforeach
                                              <option value="9">LAINNYA</option>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="input-group input-group-static mb-4">
                                          <label for="exampleFormControlSelect1" class="ms-0">Pilih Tanggal (klik pada kalender)</label>
                                          <input type="text" id="tgl_request" name="tgl_permohonan" class="form-control" value="{{$todays}}" readonly>
                                      </div>
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="input-group input-group-outline my-3">
                                          <label class="form-label">Keterangan</label>
                                          <input type="text" id="pketerangan" name="keterangan" class="form-control" onchange="checkAll(this.value,'ket')">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="input-group input-group-static mb-4">
                                          <label for="exampleFormControlSelect1" class="ms-0">Pilih Lokasi</label>
                                          <select class="form-control" name="lokasi" id="plokasi">
                                              <option value="1">Diskominfo</option>
                                              <option value="0">OPD Pemohon</option>
                                          </select>
                                      </div>
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="input-group input-group-outline my-3">
                                          <label class="form-label">email pemohon</label>
                                          <input type="email" id="pemail" name="email" class="form-control" onchange="checkAll(this.value,'email')">
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="input-group input-group-outline my-3">
                                          <label class="form-label">no telp / nama pemohon</label>
                                          <input type="text" id="cp" name="contact_person" class="form-control">
                                      </div>
                                  </div>
                              </div>
                              <hr />
                              <button type="submit" id="submitpermohonan" class="btn btn-primary" data-id="" disabled>Submit</button>  

                          </form>
                      </div>
                  </div>
              </div>
              <div class="col-lg-6 col-md-6 mb-md-0 mb-4">
                  <div class="card" data-animation="true">
                      <div class="card-body">
                          <div id="calendar"></div>
                      </div>
                  </div>
              </div>     
          </div>
      </div>


      <footer class="footer pt-5">
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                Diskominfo Cilacap
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="" class="nav-link text-muted" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link text-muted" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="" class="nav-link pe-0 text-muted" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
          
        </div>
      </footer>
    </div>
    </main>
    <!--   Core JS Files   -->
    <script src="{{ asset('templet/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('templet/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('templet/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('templet/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('templet/js/plugins/chartjs.min.js') }}"></script>
    <script src="{{ asset('dashbor/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script>
      var win = navigator.platform.indexOf('Win') > -1;
      if (win && document.querySelector('#sidenav-scrollbar')) {
        var options = {
          damping: '0.5'
        }
        Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
      }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('templet/js/material-dashboard.min.js?v=3.0.0 ') }}"></script>
    <script src="{{ asset('js/fullcalendar5/lib/main.js') }}"></script>

    <script src="{{ asset('js/ratings/dist/rating.js') }}"></script>
    
    <script>
    function checkAll(val, jenis){
        var selOPD = $('#selOPD').val();
        var tgl_request = $('#tgl_request').val();
        var pemail = $('#pemail').val();

        if (selOPD != null && tgl_request != '' && pemail != '') {
              $('#submitpermohonan').prop('disabled', false);
        } else {
              $('#submitpermohonan').prop('disabled', true);
        }
        //alert(selOPD)


    }
    
    </script>

    <script>

        $(document).ready(function(){
          //$('#ratingModal').modal('show');
          //$('#ratingModal').modal({backdrop: 'static', keyboard: false})
        })

        $("#reviewUser").rating({
          "click": function (e) {
            console.log(e); // {stars: 3, event: E.Event}
            //alert(e.stars); // 3
            $('#nilaiUser').val(e.stars)
          }
        });
        $("#reviewApp").rating({
          "click": function (e) {
            console.log(e); // {stars: 3, event: E.Event}
            //alert(e.stars); // 3
            $('#nilaiApp').val(e.stars)
          }
        });

        $('#submitReview').click(function(){

          var nilaiApp = $('#nilaiApp').val()
          var nilaiUser = $('#nilaiUser').val()
          var idUserNilai = $('#idUserNilai').val()
          var idAppNilai = $('#idAppNilai').val()
          var ttguser = $('#ttguser').val()
          var ttgapp = $('#ttgapp').val()

          $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("submit.review") }}',
                data: {'nilaiApp': nilaiApp, 'nilaiUser' : nilaiUser,
                'idUserNilai' : idUserNilai, 'idAppNilai' : idAppNilai,
                'ttguser' : ttguser, 'ttgapp' : ttgapp
                 , _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function(data){
                    alert('Terima Kasih Atas Reviewnya')
                    //location.reload();
                    $('#ratingModal').modal('hide');
                    $('#ttguser').val('')
                    $('#ttgapp').val('')
                },
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });

        });

        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.event") }}',
                data: {'detailnya': 'periode' , _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function(data){
                    obj = JSON.stringify(data);
                },
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {


          dayMaxEventRows: true, // for all non-TimeGrid views
            views: {
              timeGrid: {
                dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
              },
              dayGrid: {
                dayMaxEventRows: 3
              }
            },
          
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridDay,listMonth'
          },
          customButtons: {
            addEventButton: {
              text: '+',
              click: function() {
                var dateStr = prompt('Masukkan Tanggal YYYY-MM-DD format');
                var jamStr = prompt('Masukkan Waktu');
                var date = new Date(dateStr + 'T14:00:00'); // will be in local time

                if (!isNaN(date.valueOf())) { // valid?
                  calendar.addEvent({
                    title: 'dynamic event',
                    start: date,
                    //allDay: true
                  });
                  alert('Great. Now, update your database...');
                } else {
                  alert('Invalid date.');
                }
              }
            }
          },
          initialDate: '{{$todays}}',
          navLinks: true, // can click day/week names to navigate views
          businessHours: true, // display business hours
          editable: true,
          selectable: true,
          events: JSON.parse(obj),
          eventClick: function(info) {
            
            // change the border color just for fun
            //info.el.style.borderColor = 'red';
            //alert(info.event.title + '\nWaktu : '+info.event.start);
            var id = info.event.id;
            $.ajax({
                  type: 'ajax',
                  method: 'get',
                  url: '{{ route("detail.event") }}',
                  data: {'id': id , _token: "{{ csrf_token() }}"},
                  async: false,
                  dataType: 'json',
                  success: function(data){
                      //console.log(data)
                      $('#agendaModal').modal('show');
                      $('#dapp_name').val(data[0].nama_aplikasi)
                      $('#djenis_servis').val(data[0].nama_servis)
                      $('#dOPD').val(data[0].nama_opd)
                      $('#dtgl_permohonan').val(data[0].tgl_permohonan)
                      $('#dketerangan').val(data[0].keterangan)
                      $('#dlokasi').val(data[0].lokasi)
                      $('#dstatus_permohonan').val(data[0].status_permohonan)
                      $('#djadwal_rev').val(data[0].tgl_permohonan_rev)

                  },
                  error: function(request, status, error){
                      alert(request.responseText);
                  }
              });
            
            },

            dateClick: function(info) {
                var tglnya = info.dateStr;
                //document.getElementById('tgl_request').value = tglnya;
                $('#tgl_request').val(tglnya)
            }


        });

        calendar.render();

      });

    </script>
  </body>

</html>