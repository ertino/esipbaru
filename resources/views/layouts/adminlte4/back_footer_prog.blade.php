{{--
    Global page script for the "programmer" role (dashboard + upload pages).

    Port of layouts/minlte/back_footer_prog.blade.php. Two differences:

      * The Bootstrap 4 attributes are rewritten to data-bs-*.
      * The two Chart.js blocks are null-safe: they used to read the
        #chart-bars / #chart-line canvases that were rendered by the Material
        dashboard modal. Those canvases no longer exist in the AdminLTE 4
        layout, so the blocks are skipped instead of throwing a TypeError and
        aborting the rest of this file.
--}}
@yield('js_code')
<script>
var chartBarsEl = document.getElementById("chart-bars");
var ctx = chartBarsEl ? chartBarsEl.getContext("2d") : null;

if (ctx) new Chart(ctx, {

  type: "bar",
  data: {
    labels: ["M", "T", "W", "T", "F", "S", "S"],
    datasets: [{
      label: "Sales",
      tension: 0.4,
      borderWidth: 0,
      borderRadius: 4,
      borderSkipped: false,
      backgroundColor: "rgba(255, 255, 255, .8)",
      data: [50, 20, 10, 22, 50, 10, 40],
      maxBarThickness: 6
    }, ],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      }
    },
    interaction: {
      intersect: false,
      mode: 'index',
    },
    scales: {
      y: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5],
          color: 'rgba(255, 255, 255, .2)'
        },
        ticks: {
          suggestedMin: 0,
          suggestedMax: 500,
          beginAtZero: true,
          padding: 10,
          font: {
            size: 14,
            weight: 300,
            family: "Roboto",
            style: 'normal',
            lineHeight: 2
          },
          color: "#fff"
        },
      },
      x: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5],
          color: 'rgba(255, 255, 255, .2)'
        },
        ticks: {
          display: true,
          color: '#f8f9fa',
          padding: 10,
          font: {
            size: 14,
            weight: 300,
            family: "Roboto",
            style: 'normal',
            lineHeight: 2
          },
        }
      },
    },
  },
});


var chartLineEl = document.getElementById("chart-line");
var ctx2 = chartLineEl ? chartLineEl.getContext("2d") : null;

if (ctx2) new Chart(ctx2, {
  type: "line",
  data: {
    labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: "Mobile apps",
      tension: 0,
      borderWidth: 0,
      pointRadius: 5,
      pointBackgroundColor: "rgba(255, 255, 255, .8)",
      pointBorderColor: "transparent",
      borderColor: "rgba(255, 255, 255, .8)",
      borderColor: "rgba(255, 255, 255, .8)",
      borderWidth: 4,
      backgroundColor: "transparent",
      fill: true,
      data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
      maxBarThickness: 6

    }],
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: false,
      }
    },
    interaction: {
      intersect: false,
      mode: 'index',
    },
    scales: {
      y: {
        grid: {
          drawBorder: false,
          display: true,
          drawOnChartArea: true,
          drawTicks: false,
          borderDash: [5, 5],
          color: 'rgba(255, 255, 255, .2)'
        },
        ticks: {
          display: true,
          color: '#f8f9fa',
          padding: 10,
          font: {
            size: 14,
            weight: 300,
            family: "Roboto",
            style: 'normal',
            lineHeight: 2
          },
        }
      },
      x: {
        grid: {
          drawBorder: false,
          display: false,
          drawOnChartArea: false,
          drawTicks: false,
          borderDash: [5, 5]
        },
        ticks: {
          display: true,
          color: '#f8f9fa',
          padding: 10,
          font: {
            size: 14,
            weight: 300,
            family: "Roboto",
            style: 'normal',
            lineHeight: 2
          },
        }
      },
    },
  },
});
</script>

<script>
  $( ".piaisi" ).click(function() {

    $('#profileModal').modal('show');
    
  });
  $( ".integrate" ).click(function() {

    $('#integrationModal').modal('show');

  });

  $( ".jenit" ).click(function() {

    var id = $(this).attr('data-id');
    var status_id = $(this).attr('data-status');
    
    //alert(status_id)
    $.ajax({
        type: 'ajax',
        method: 'post',
        url: '{{ route("approve.event.admin") }}',
        data: {'id': id, 'status_id' : status_id, _token: "{{ csrf_token() }}"},
        async: false,
        dataType: 'json',
        success: function(data){
            alert('Berhasil Mengupdate Data')
            location.reload();
        },
        error: function(request, status, error){
            alert(request.responseText);
        }
    });
  });

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"></script>


<script>
  $(function () {
    $(document).ready(function () {

      var user_id = {{$user_id}};
      function toISOLocal(d) {
        var z  = n =>  ('0' + n).slice(-2);
        var zz = n => ('00' + n).slice(-3);
        var off = d.getTimezoneOffset();
        var sign = off > 0? '-' : '+';
        off = Math.abs(off);

        return d.getFullYear() + '-'
              + z(d.getMonth()+1) + '-' +
              z(d.getDate()) + 'T' +
              z(d.getHours()) + ':'  + 
              z(d.getMinutes()) + ':' +
              z(d.getSeconds()) + '.' +
              zz(d.getMilliseconds()) +
              sign + z(off/60|0) + ':' + z(off%60); 
      }

      $('#kegiatanForm').ajaxForm({
          beforeSend: function () {
              var percentage = '0';
              $('.toshow').show()
          },
          uploadProgress: function (event, position, total, percentComplete) {
              var percentage = percentComplete;
              $('.progress .progress-bar').css("width", percentage+'%', function() {
                return $(this).attr("aria-valuenow", percentage) + "%";
              })
          },
          complete: function (xhr) {
            
              $('.toshow').hide()
              alert('File Terupload');
              $('#kegiatanForm')[0].reset();

          }
      });


      function getDataCalendar(jenis){
        if(jenis == 'event') {
          $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("get.event.admin") }}',
            data: {'detailnya': 'periode', 'user_id' : user_id, _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){
              
                obj = JSON.stringify(data);
                //console.log(obj)
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                  headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridDay,listMonth'
                  },
                  customButtons: {
                    addEventButton: {
                      text: 'event',
                      click: function() {
                        //calendar.addEventSource(getDataEvent())
                      }
                    },
                    taskButton: {
                      text: 'task',
                      click: function() {
                        // var eventSources = calendar.getEventSources(); 
                        //   var len = eventSources.length;
                        //   for (var i = 0; i < len; i++) { 
                        //       eventSources[i].remove(); 
                        //   } 
                      }
                    }
                  },

                  dayMaxEventRows: true, // for all non-TimeGrid views
                    views: {
                      timeGrid: {
                        dayMaxEventRows: 3 // adjust to 6 only for timeGridWeek/timeGridDay
                      },
                      dayGrid: {
                        dayMaxEventRows: 3
                      }
                    },  
                  initialDate: '{{$todays}}',
                  navLinks: true, // can click day/week names to navigate views
                  businessHours: true, // display business hours
                  editable: true,
                  selectable: true,
                  
                  events: JSON.parse(obj),
                  eventClick: function(info) {

                    //info.el.style.borderColor = 'red';
                    var id = info.event.id;
                    //alert(info.event.title + '\nWaktu : '+info.event.start);
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
                              $('#demail').val(data[0].email)
                              $('#dcontact_person').val(data[0].contact_person)
                              $('#dstatus_permohonan').val(data[0].status_permohonan)
                              $('#djadwal_rev').val(data[0].tgl_permohonan_rev)
                              $('.jenit').attr('data-id', id);
                              if (data[0].status_id == "1") {
                                $('#approvepermohonan').prop('disabled', true);
                              } else {
                                $('#approvepermohonan').prop('disabled', false);
                              }

                          },
                          error: function(request, status, error){
                              alert(request.responseText);
                          }
                      });
                    },

                    eventDrop:function(event)
                        {
                            var starto = toISOLocal(event.event.start);
                            var start = starto.slice(0,10);
                            var starttime = event.event.start.toTimeString().slice(0,8);
                            var startgame = start+'T'+starttime;
                            var enc = event.event.end;
                            
                            //
                            if (enc === null) {
                              //alert('Mulai :'+starto)
                              //alert('Mulai : '+toISOLocal(starto))
                            } else {
                              var endto = toISOLocal(event.event.end);
                              var end = endto.slice(0,10);
                              var endtime = event.event.end.toTimeString().slice(0,8);
                              var endgame = end+'T'+endtime;
                              
                              //alert('Mulai : '+startgame+'\nSelesai : '+endgame)
                            }
                            var id = event.event.id;

                            $.ajax({
                                type: 'ajax',
                                method: 'post',
                                url: '{{ route("update.event.admin") }}',
                                data: {'id': id, 'startgame' : startgame, 'endgame' : endgame, _token: "{{ csrf_token() }}"},
                                async: false,
                                dataType: 'json',
                                success: function(data){
                                    alert('Berhasil Mengupdate Data')
                                },
                                error: function(request, status, error){
                                    alert(request.responseText);
                                }
                            });
                            
                            
                        },

                    eventResize:function(event)
                    {
                        var id = event.event.id;
                        //
                        var starto = toISOLocal(event.event.start);
                        var start = starto.slice(0,10);
                        var starttime = event.event.start.toTimeString().slice(0,8);
                        var startgame = start+'T'+starttime;
                        //
                        var endto = toISOLocal(event.event.end);
                        var end = endto.slice(0,10);
                        var endtime = event.event.end.toTimeString().slice(0,8);
                        var endgame = end+'T'+endtime;
                        //alert('Mulai : '+startgame+'\nSelesai : '+endgame)
                        $.ajax({
                            type: 'ajax',
                            method: 'post',
                            url: '{{ route("update.event.admin") }}',
                            data: {'id': id, 'startgame' : startgame, 'endgame' : endgame, _token: "{{ csrf_token() }}"},
                            async: false,
                            dataType: 'json',
                            success: function(data){
                                alert('Berhasil Mengupdate Data')
                            },
                            error: function(request, status, error){
                                alert(request.responseText);
                            }
                        });
                    },
                    dateClick: function(info) {  
                        var tglnya = info.date;
                        var starto = toISOLocal(tglnya);
                        var start = starto.slice(0,10);
                        var starttime = tglnya.toTimeString().slice(0,8);
                        var startgame = start+'T'+starttime;
                        //alert(startgame)
                        $('#tambahModal').modal('show')
                        $('#etgl').val(startgame)
                        //document.getElementById('tgl_request').value = tglnya;
                    }
                });

                calendar.render();
            },
            error: function(request, status, error){
                alert(request.responseText);
            }
          });

        } else {

          $.ajax({
            type: 'ajax',
            method: 'get',
            url: '{{ route("get.data.task") }}',
            data: {'detailnya': 'periode', 'user_id' : user_id, _token: "{{ csrf_token() }}"},
            async: false,
            dataType: 'json',
            success: function(data){
              
                obj = JSON.stringify(data);
                //console.log(obj)
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                  headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridDay,listMonth'
                  },
                  customButtons: {
                    addEventButton: {
                      text: 'event',
                      click: function() {
                        //calendar.addEventSource(getDataEvent())
                      }
                    },
                    taskButton: {
                      text: 'task',
                      click: function() {
                        // var eventSources = calendar.getEventSources(); 
                        //   var len = eventSources.length;
                        //   for (var i = 0; i < len; i++) { 
                        //       eventSources[i].remove(); 
                        //   } 
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

                    //info.el.style.borderColor = 'red';
                    var id = info.event.id;
                    //alert(info.event.title + '\nWaktu : '+info.event.start);
                    $.ajax({
                          type: 'ajax',
                          method: 'get',
                          url: '{{ route("detail.event") }}',
                          data: {'id': id , _token: "{{ csrf_token() }}"},
                          async: false,
                          dataType: 'json',
                          success: function(data){
                              //console.log(data)
                              //$('#agendaModal').modal('show');
                              $('#dapp_name').val(data[0].nama_aplikasi)
                              $('#djenis_servis').val(data[0].nama_servis)
                              $('#dOPD').val(data[0].nama_opd)
                              $('#dtgl_permohonan').val(data[0].tgl_permohonan)
                              $('#dketerangan').val(data[0].keterangan)
                              $('#dlokasi').val(data[0].lokasi)
                              $('#demail').val(data[0].email)
                              $('#dcontact_person').val(data[0].contact_person)
                              $('#dstatus_permohonan').val(data[0].status_permohonan)
                              $('#djadwal_rev').val(data[0].tgl_permohonan_rev)
                              $('.jenit').attr('data-id', id);

                          },
                          error: function(request, status, error){
                              alert(request.responseText);
                          }
                      });
                    },

                    eventDrop:function(event)
                        {
                            var starto = toISOLocal(event.event.start);
                            var start = starto.slice(0,10);
                            var starttime = event.event.start.toTimeString().slice(0,8);
                            var startgame = start+'T'+starttime;
                            var enc = event.event.end;
                            
                            //
                            if (enc === null) {
                              //alert('Mulai :'+starto)
                              //alert('Mulai : '+toISOLocal(starto))
                            } else {
                              var endto = toISOLocal(event.event.end);
                              var end = endto.slice(0,10);
                              var endtime = event.event.end.toTimeString().slice(0,8);
                              var endgame = end+'T'+endtime;
                              
                              //alert('Mulai : '+startgame+'\nSelesai : '+endgame)
                            }
                            var id = event.event.id;

                            // $.ajax({
                            //     type: 'ajax',
                            //     method: 'post',
                            //     url: '{{ route("update.event.admin") }}',
                            //     data: {'id': id, 'startgame' : startgame, 'endgame' : endgame, _token: "{{ csrf_token() }}"},
                            //     async: false,
                            //     dataType: 'json',
                            //     success: function(data){
                            //         alert('Berhasil Mengupdate Data')
                            //     },
                            //     error: function(request, status, error){
                            //         alert(request.responseText);
                            //     }
                            // });
                            
                            
                        },

                    eventResize:function(event)
                    {
                        var id = event.event.id;
                        //
                        var starto = toISOLocal(event.event.start);
                        var start = starto.slice(0,10);
                        var starttime = event.event.start.toTimeString().slice(0,8);
                        var startgame = start+'T'+starttime;
                        //
                        var endto = toISOLocal(event.event.end);
                        var end = endto.slice(0,10);
                        var endtime = event.event.end.toTimeString().slice(0,8);
                        var endgame = end+'T'+endtime;
                        //alert('Mulai : '+startgame+'\nSelesai : '+endgame)

                        // $.ajax({
                        //     type: 'ajax',
                        //     method: 'post',
                        //     url: '{{ route("update.event.admin") }}',
                        //     data: {'id': id, 'startgame' : startgame, 'endgame' : endgame, _token: "{{ csrf_token() }}"},
                        //     async: false,
                        //     dataType: 'json',
                        //     success: function(data){
                        //         alert('Berhasil Mengupdate Data')
                        //     },
                        //     error: function(request, status, error){
                        //         alert(request.responseText);
                        //     }
                        // });

                        
                    },
                    dateClick: function(info) {  
                        var tglnya = info.date;
                        var starto = toISOLocal(tglnya);
                        var start = starto.slice(0,10);
                        var starttime = tglnya.toTimeString().slice(0,8);
                        var startgame = start+'T'+starttime;
                        //alert(startgame)
                        $('#tambahModal').modal('show')
                        $('#etgl').val(startgame)
                        //document.getElementById('tgl_request').value = tglnya;
                    }
                });

                calendar.render();
            },
            error: function(request, status, error){
                alert(request.responseText);
            }
          });

        }
        
      }

      getDataCalendar('event')

  
      $('#submitTask').click(function() {
      var url = $('#formTask').attr('action');
      var data = $('#formTask').serialize();
      var form = $('#formTask')[0];
      var dataform = new FormData(form);
      var thisUser = "{{$user_id}}";

      //validate form
      var modul = $('#tModul').val();
      var keterangan = $('#tKeterangan').val();
      var result = '';
      if (modul != '') {
        result += '1';
      } 
      if (keterangan != '') {
        result += '2';
      } 
      if ($('#tFileTask')[0].files.length !== 0) {
        result += '3';
      }

      if (result == '123') {

        $.ajax({
          type: 'ajax',
          method: 'post',
          url: url,
          data: dataform,
          cache: false,
          contentType: false,
          processData: false,
          enctype: 'multipart/form-data',
          async: false,
          //	dataType: 'json',
          success: function(response) {
            if (response.success = true) {
              $('#tambahModal').modal('hide');
              $('#formTask')[0].reset();
              if (response.type == 'add') {
                var type = 'added'
              } else if (response.type == 'update') {
                var type = "updated"
              }
            } else {
              alert('Error Penginputan Data');
            }
          },
          error: function(request, status, error) {
            alert(request.responseText);
          }
        });
      } else {
        'Pengisian Data Belum Lengkap';
      }
    });


    $('.tasking').click(function(){
      getDataCalendar('task')
    })

    $('.eventing').click(function(){
      getDataCalendar('event')
    })

        
    });

  });
</script>

