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
      <!-- COLOR PALETTE -->

      <div class="row">
        <div id="modal-petunjukmanual-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
          <div class="card">
            <div class="card-header">
              <div class="card-title">
                <h2>Petunjuk Penggunaan</h2>
              </div>
              <div class="card-tools">
                <button type="button" class="btn btn-secondary btn-sm float-right"
                  id="close-petunjukmanual-modal">Close</button>
              </div>
            </div>
            <div class="card-body">

              <div id="accordion">
                <div class="card card-danger">
                  <div class="card-header">
                    <h4 class="card-title w-100">
                      <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                        Khusus Untuk Pendaftaran STR Dokter Ber-QRCODE
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="collapse show" data-parent="#accordion">
                    <div class="card-body">
                      <div class="card mb-2 bg-gradient-dark">
                        <img class="card-img-top" src="{{asset('images/petunjukdokter.jpg')}}" alt="Dist Photo 1">
                        <div class="card-img-overlay d-flex flex-column justify-content-end">
                        </div>
                      </div>
                      <p>Pastikan STR yang diupload memiliki <strong> QRCODE </strong> dan <strong> Berposisi Landscape
                        </strong>. Setelah Proses Upload Berhasil, Pastikan <strong> Salinan, Tanggal Penetapan STR, dan
                          Tanggal Berlaku STR </strong> yang tertulis pada form <strong> Sesuai </strong>dengan yang
                        tertera pada STR. Jika Tidak, Maka Sesuaikan Kembali. Pastikan <strong> Kualitas </strong>
                        Terbaik untuk PDF yang akan diupload.</p>
                    </div>
                  </div>
                </div>
                <div class="card card-primary">
                  <div class="card-header">
                    <h4 class="card-title w-100">
                      <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                        STR Non Dokter Ber-QRCODE
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                      <p>Pastikan STR yang diupload memiliki <strong> QRCODE </strong> dan <strong> Berposisi Portrait
                        </strong>. Setelah Proses Upload Berhasil, Pastikan <strong> Salinan, Tanggal Penetapan STR, dan
                          Tanggal Berlaku STR </strong> yang tertulis pada form <strong> Sesuai </strong>dengan yang
                        tertera pada STR. Jika Tidak, Maka Sesuaikan Kembali. Pastikan <strong> Kualitas </strong>
                        Terbaik untuk PDF yang akan diupload.</p>
                    </div>
                  </div>
                </div>
                <div class="card card-secondary">
                  <div class="card-header">
                    <h4 class="card-title w-100">
                      <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">
                        STR tidak ber-QRCODE
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="collapse" data-parent="#accordion">
                    <div class="card-body">
                      <p>Pastikan STR yang diupload Berposisi Portrait </strong>. Pastikan <strong> Kualitas </strong>
                        Terbaik untuk PDF yang akan diupload.</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div id="modal-scanfirstptsp-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
          <div class="card">
            <div class="card-header">
              <div class="card-title">
                Silahkan Scan QRCODE STR (DOKTER) Terlebih Dahulu
              </div>
              <div class="card-tools">
                <button type="button" class="btn btn-secondary btn-sm float-right"
                  id="close-scanfirstptsp-modal">Lewati</button>
              </div>
            </div>
            <div class="card-body">

              <div class="row">
                <div class="col-md-12">
                  <form id="simpanstrdoktermanualform" action="" method="post" class="form-horizontal">
                    <div class="row">
                      <div class="card card-widget overlay">
                        <div class="card-header">
                          <div>
                            Scan QRCODE Pada STR Anda
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="row">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div id="qr-dokter-reader" style="width:500px"></div>
                              <div id="qr-dokter-reader-results"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


      <div class="row">
        <div class="col-md-5 col-xs-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">
                Upload Dokumen STR (PDF)
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <div class="row" id="formsubmitstrmanual">
                <div class="col-md-12 col-sm-12 col-xs-12">

                  <center>
                    <h3> Upload Dokumen STR (PDF) & Foto</h3>
                    <form enctype="multipart/form-data" id="formDaftarManual" method="post" class="form-horizontal">
                      @csrf


                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <div class="form-group">
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="tFileSTRManual" name="tFileSTRManual"
                                  accept=".pdf" required>
                                <label class="custom-file-label" for="exampleInputFile">File STR (PDF)</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>


                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <div class="form-group">
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="tFileFotoNakes" name="tFileFotoNakes"
                                  accept=".jpeg" onchange="validateFileSize(this)" required>
                                <label class="custom-file-label" for="exampleInputFile">Foto STR</label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </form>

                    <button type="submit" id="submitDaftarManual" class="btn btn-success submitDaftar">Submit</button>

                  </center>
                </div>
              </div>

              <button type="submit" id="reloadformnya" style="display:none" class="btn btn-sm btn-primary"><i
                  class="fas fa-sync-alt"></i> Upload Ulang</button>
              <hr />


              <div class="row" id="tabularhasil" style="display:none">
                <div class="col-md-12 col-xs-12">
                  <div class="card card-row card-success">
                    <div class="card-header">
                      <h3 class="card-title">
                        Hasil Upload Dokumen
                      </h3>

                      <div class="card-tools">

                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                          <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                          <i class="fas fa-expand"></i>
                        </button>
                      </div>
                    </div>
                    <div class="card-body">
                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <embed id="hasiluploadstrmanual" src="" width="100%" height="100%"></embed>
                        </div>
                      </div>

                      <div class="row">
                        <div class="col-md-12 col-xs-12">
                          <embed id="hasiluploadfotomanual" src="" width="100%" height="100%"></embed>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="overlay" id="uploadstrmanualloader" style="display:none">
              <i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
            <div class="overlay" id="aftermanualupload" style="display:none">
              <button id="buttonreloadmanual" class="btn btn-info"><i
                  class="fas fa-3x fa-sync-alt fa-spin"></i></button>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <div class="col-md-7 col-xs-12">
          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">
                Pengisian Form Data Diri Terkait STR
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

              <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">

                  <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                      <form id="lanjutuploadstrmanual" action="{{ route('simpan.str.manual') }}" method="post"
                        class="form-horizontal">
                        @csrf

                        <div class="row">
                          <div class="col-md-5 col-xs-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                              <input type="text" id="stNama" name="stNama" class="form-control" required>
                            </div>
                          </div>

                          <div class="col-md-5 col-xs-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                              <input type="text" id="stNoSTR" name="stNoSTR" class="form-control" required>
                            </div>
                          </div>

                          <div class="col-md-2 col-xs-12">

                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Jenis Kelamin</label>
                              <input type="radio" name="stJenisK" value="Laki-Laki" checked>L
                              <input type="radio" name="stJenisK" value="Perempuan">P

                            </div>
                          </div>

                        </div>


                        <div class="row" style="display:none">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">STR Hingga</label>
                              <input type="text" id="stDueOri" name="stDueOri" class="form-control">
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">STR Keluar</label>
                              <input type="text" id="stStrKeluarOri" name="stStrKeluarOri" class="form-control">
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Status Dokumen</label>
                              <input type="text" id="stStatDok" name="stStatDok" class="form-control">
                            </div>
                          </div>


                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">STR Hingga Conv</label>
                              <input type="text" id="stDueConv" name="stDueConv" class="form-control">
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">STR Tetapan Conv</label>
                              <input type="text" id="stStrKeluarConv" name="stStrKeluarConv" class="form-control">
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">URL QR</label>
                              <input type="text" id="sturlqr" name="sturlqr" value="manual" class="form-control">
                            </div>
                          </div>

                        </div>

                        <div class="row" style="display:none">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">img src</label>
                              <input type="text" id="stImg" name="stImg" class="form-control">
                            </div>
                          </div>


                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                              <input type="text" id="stUserIDNakes" name="stUserIDNakes" class="form-control"
                                value="{{$user_id}}">
                            </div>
                          </div>



                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">which file</label>
                              <input type="text" id="stWhichFManual" name="stWhichF" class="form-control">
                            </div>
                          </div>
                        </div>



                        <div class="row">

                          <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">TGL Penetapan STR *</label>
                              <input type="date" id="stSTRtetapSIPmanual" name="stSTRtetapSIPmanual"
                                class="form-control" required>
                            </div>
                          </div>

                          <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">STR Hingga *</label>
                              <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" name="seumurhidup" id="seumurhidup">
                                <label class="custom-control-label" for="seumurhidup">Seumur Hidup</label>
                              </div>
                              <input type="date" id="stSTRHinggaSIPmanual" name="stSTRHinggaSIPmanual"
                                class="form-control" min="{{date('Y-m-d')}}" required>
                            </div>
                          </div>

                          <div class="col-md-4 col-xs-12">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                              <input type="text" id="stKompetensi" name="stKompetensi" class="form-control" required>
                            </div>
                          </div>

                        </div>

                        <div class="row">

                          <div class="col-md-5" style="display:none">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Profesi *</label>
                              <div class="autocomplete">
                                <input type="text" id="stProfesi" name="stProfesi" class="form-control">
                              </div>
                            </div>
                          </div>

                          <div class="col-md-5">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Profesi *</label>
                              <select class="form-control" id="stProfesiDD" name="stProfesiDD" required>
                                <option value="" selected disabled>--Pilih--</option>
                                <option value="DU" selected>DOKTER UMUM</option>
                                <option value="DG">DOKTER GIGI</option>
                                <option value="DS">DOKTER SPESIALIS</option>
                                <option value="DGS">DOKTER GIGI SPESIALIS</option>
                                <option value="APT" selected>APOTEKER</option>
                                <option value="TTK" selected>TENAGA TEKNIS KEFARMASIAN</option>
                                @foreach($semuaprofesi as $profe)
                                <option value="{{$profe->alias_profesi}}">{{$profe->nama_profesi}}</option>
                                @endforeach
                              </select>
                            </div>
                          </div>

                          <div class="col-md-4" id="pilihtemplate">
                            <label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label>
                            <select class="form-control" id="stProfesiSIP" name="stProfesiSIP">
                              <option value="2">SIP DOKTER</option>
                              <option value="2" disabled>SIP DOKTER</option>
                              <option value="3">SIP APOTEKER</option>
                              <option value="4">SIP APOTEKER PENANGGUNG JAWAB</option>
                              <option value="1">SIP&SIK Tenaga Kesehatan</option>
                            </select>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Salinan *</label>
                              <div class="autocomplete">
                                <input type="text" id="stSalinan" name="stSalinan" value="1" class="form-control">
                              </div>
                            </div>
                          </div>
                        </div>

                        <hr />


                        <div class="row">

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Alamat Email *</label>
                              <input type="text" id="stEmail" name="stEmail" class="form-control" required>
                            </div>
                          </div>


                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Nomor Telpon *</label>
                              <input type="text" id="stNotelp" name="stNotelp" class="form-control" required>
                            </div>
                          </div>


                        </div>
                        <div class="row">

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="exampleFormControlSelect1" class="ms-0">Password *</label>
                              <input type="text" id="stPassword" name="stPassword" class="form-control" required>
                            </div>
                          </div>

                        </div>

                        <button type="submit" id="sumbitDaftarManual" class="btn btn-success">Lanjutkan</button>
                      </form>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <div class="overlay" id="overlaystrmanual">
              <h3> Upload STR Terlebih Dahulu </h3>
            </div>
            <!-- /.card-body -->
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

  function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
      // call on next available tick
      setTimeout(fn, 1);
    } else {
      document.addEventListener("DOMContentLoaded", fn);
    }
  }

  docReady(function () {
    var resultContainer = document.getElementById('qr-dokter-reader-results');
    var lastResult, countResults = 0;
    //const fileInput = document.getElementById("#qr-reader__dashboard_section_swaplink");
    //fileInput.classList.add("hiddenopt");

    var html5QrcodeScanner = new Html5QrcodeScanner(
      "qr-dokter-reader", { fps: 10, qrbox: 250 });

    function onScanSuccess(decodedText, decodedResult) {
      if (decodedText !== lastResult) {
        ++countResults;
        lastResult = decodedText;
        console.log(`Scan result = ${decodedText}`, decodedResult);
        var iscekdokter = decodedText.includes('cekdokter')
        if (iscekdokter == true) {
          $('#sturlqr').val(decodedText)
          $.fancybox.close();
        } else {
          alert('STR Yang Anda Scan Bukan STR Dokter, Mohon Scan Ulang Untuk Memastikan')
          $('#sturlqr').val(decodedText)
        }
        // Optional: To close the QR code scannign after the result is found
        html5QrcodeScanner.clear();
      }
    }

    // Optional callback for error, can be ignored.
    function onScanError(qrCodeError) {
      // This callback would be called in case of qr code scan error or setup error.
      // You can avoid this callback completely, as it can be very verbose in nature.
    }
    html5QrcodeScanner.render(onScanSuccess, onScanError);
  });

</script>
<script>

  $(document).ready(function () {

    $("#seumurhidup").change(function () {
      // Check if the checkbox is checked
      if ($(this).is(":checked")) {
        // If checked, hide the stSTRHinggaSIPmanual input
        $("#stSTRHinggaSIPmanual").hide().removeAttr('required')

      } else {
        // If not checked, show the stSTRHinggaSIPmanual input
        $("#stSTRHinggaSIPmanual").show().attr('required', 'required');
      }
    });

  })

</script>

@endsection