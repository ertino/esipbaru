@extends('layouts.minlte.back_master')
@section('content')

<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang di e-SIP </h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div id="modal-tunggukadinkes-content" style="display: none;">
                    <center>
                    <i class="fas fa-hourglass"></i>
                    <h5>Mohon Tunggu..</h5>
                    </center>
                </div>
            </div>

            <div class="row">
                <div id="modal-ubahjadwal-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                Perbaikan Jadwal Nakes
                            </div>
                            <div class="card-tools">
                                
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm float-right tutupcekskp">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row" style="display:none">
                                <input type="text" name="jidpengajuan" id="jidpengajuan" value="{{$id_pengajuan}}">
                                <input type="text" name="jidnakes" id="jidnakes" value="{{$id_nakes}}">
                                <input type="text" name="jsalinan" id="jsalinan" value="{{$salinan}}">
                                <input type="text" name="jiddoc" id="jiddoc" value="{{$detail_pengajuan->id_doc}}">
                                
                            </div>

                            <div class="row toevent">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik</label>
                                    <div class="row" id="tosktp">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                            <label for="tprompt" class="ms-0">Coba Isikan Prompt *</label>
                                            <div class="input-group">
                                                <input type="text" id="tprompt" name="tprompt" class="form-control" placeholder="Senin sampai Kamis pukul 08:00 sampai 14:00, uraian: shift, Jumat pukul 09:00 sampai 15:00, uraian: shift">
                                                <button class="btn btn-primary" type="button" id="generateprompt">Generate</button>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-warning">
                                        <div class="card-body table-responsive p-0">
                                            
                                            <table class="table table-striped" id="_jadwalpraktiknakes" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th width="25%">Hari</th>
                                                        <th width="45%" colspan="2">Dari - Hingga</th>
                                                        <th width="15%">Shift</th>
                                                        <th width="15%">Uraian</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr id="larik_1">
                                                        <td width="25%"><input type="checkbox" name="phari_1" id="phari_1" class="ms-0 pilihhari" data="1"> Senin</td>
                                                        <td width="40%"><div id="jam_1" style="display:none"><input type="time" name="start_1" id="start_1" class="ms-0" value="08:00"> - <input type="time" name="end_1" id="end_1" class="ms-0" value="12:00"></div></td>
                                                        <td id="detailc1" class="details-control"><div id="1alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                        <td width="5%"><input type="checkbox" name="isshift_1" class="ms-0" id="isshift_1" style="display:none"></td>
                                                        <td width="25%"><textarea type="text" name="isuraian_1" class="ms-0" id="isuraian_1" style="display:none"></textarea></td>
                                                    </tr>
                                                    <tr id="cekresult_1" class="tampilnongol" style="display:none">
                                                    </tr>
                                                    <tr id="larik_2">
                                                        <td width="25%"><input type="checkbox" name="phari_2" id="phari_2" class="ms-0 pilihhari" data="2"> Selasa</td>
                                                        <td width="40%"><div id="jam_2" style="display:none"><input type="time" name="start_2" id="start_2" class="ms-0" value="08:00"> - <input type="time" name="end_2" id="end_2" class="ms-0" value="12:00"></div></td>
                                                        <td id="detailc2" class="details-control"><div id="2alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                        <td width="5%"><input type="checkbox" name="isshift_2" class="ms-0" id="isshift_2" style="display:none"></td>
                                                        <td width="25%"><textarea type="text" name="isuraian_2" class="ms-0" id="isuraian_2" style="display:none"></textarea></td>
                                                    </tr>
                                                    <tr id="cekresult_2" class="tampilnongol" style="display:none">
                                                    </tr>
                                                    <tr id="larik_3">
                                                        <td width="25%"><input type="checkbox" name="phari_3" id="phari_3" class="ms-0 pilihhari" data="3"> Rabu</td>
                                                        <td width="40%"><div id="jam_3" style="display:none"><input type="time" name="start_3" id="start_3" class="ms-0" value="08:00"> - <input type="time" name="end_3" id="end_3" class="ms-0" value="12:00"></div></td>
                                                        <td id="detailc3" class="details-control"><div id="3alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                        <td width="5%"><input type="checkbox" name="isshift_3" class="ms-0" id="isshift_3" style="display:none"></td>
                                                        <td width="25%"><textarea type="text" name="isuraian_3" class="ms-0" id="isuraian_3" style="display:none"></textarea></td>
                                                    </tr>
                                                    <tr id="cekresult_3" class="tampilnongol" style="display:none">
                                                    </tr>
                                                    <tr id="larik_4">
                                                        <td width="25%"><input type="checkbox" name="phari_4" id="phari_4" class="ms-0 pilihhari" data="4"> Kamis</td>
                                                        <td width="40%"><div id="jam_4" style="display:none"><input type="time" name="start_4" id="start_4" class="ms-0" value="08:00"> - <input type="time" name="end_4" id="end_4" class="ms-0" value="12:00"></div></td>
                                                        <td id="detailc4" class="details-control"><div id="4alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                        <td width="5%"><input type="checkbox" name="isshift_4" class="ms-0" id="isshift_4" style="display:none"></td>
                                                        <td width="25%"><textarea type="text" name="isuraian_4" class="ms-0" id="isuraian_4" style="display:none"></textarea></td>
                                                    </tr>
                                                    <tr id="cekresult_4" class="tampilnongol" style="display:none">
                                                    </tr>
                                                    <tr id="larik_5">
                                                        <td width="25%"><input type="checkbox" name="phari_5" id="phari_5" class="ms-0 pilihhari" data="5"> Jumat</td>
                                                        <td width="40%"><div id="jam_5" style="display:none"><input type="time" name="start_5" id="start_5" class="ms-0" value="08:00"> - <input type="time" name="end_5" id="end_5" class="ms-0" value="12:00"></div></td>
                                                        <td id="detailc5" class="details-control"><div id="5alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                        <td width="5%"><input type="checkbox" name="isshift_5" class="ms-0" id="isshift_5" style="display:none"></td>
                                                        <td width="25%"><textarea type="text" name="isuraian_5" class="ms-0" id="isuraian_5" style="display:none"></textarea></td>
                                                    </tr>
                                                    <tr id="cekresult_5" class="tampilnongol" style="display:none">
                                                    </tr>
                                                    <tr id="larik_6">
                                                        <td width="25%"><input type="checkbox" name="phari_6" id="phari_6" class="ms-0 pilihhari" data="6"> Sabtu</td>
                                                        <td width="40%"><div id="jam_6" style="display:none"><input type="time" name="start_6" id="start_6" class="ms-0" value="08:00"> - <input type="time" name="end_6" id="end_6" class="ms-0" value="12:00"></div></td>
                                                        <td id="detailc6" class="details-control"><div id="6alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                        <td width="5%"><input type="checkbox" name="isshift_6" class="ms-0" id="isshift_6" style="display:none"></td>
                                                        <td width="25%"><textarea type="text" name="isuraian_6" class="ms-0" id="isuraian_6" style="display:none"></textarea></td>
                                                    </tr>
                                                    <tr id="cekresult_6" class="tampilnongol" style="display:none">
                                                    </tr>
                                                    <tr id="larik_7">
                                                        <td width="25%"><input type="checkbox" name="phari_7" id="phari_7" class="ms-0 pilihhari" data="7"> Minggu</td>
                                                        <td width="40%"><div id="jam_7" style="display:none"><input type="time" name="start_7" id="start_7" class="ms-0" value="08:30"> - <input type="time" name="end_7" id="end_7" class="ms-0" value="12:00"></div></td>
                                                        <td id="detailc7" class="details-control"><div id="7alert" style="display:none"><button type="button" class="btn btn-block btn-outline-light"><i class="fas fa-exclamation-triangle"></i></button></div></td>
                                                        <td width="5%"><input type="checkbox" name="isshift_7" class="ms-0" id="isshift_7" style="display:none"></td>
                                                        <td width="25%"><textarea type="text" name="isuraian_7" class="ms-0" id="isuraian_7" style="display:none"></textarea></td>
                                                    </tr>
                                                    <tr id="cekresult_7" class="tampilnongol" style="display:none">
                                                        
                                                    </tr>
                                                </tbody>
                                            </table>
                                            
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-info" id="simpanjadwalnakesadmin">Simpan Jadwal</button>
                                        </div>
                                        <div class="overlay" id="tunggujadwal" style="display:none">
                                            <i class="fas fa-2x fa-sync-alt lagiloading" style="display:none"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="modal-cekskp-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">

                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                Pencarian Pada SKP
                            </div>
                            <div class="card-tools">
                                
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm float-right tutupcekskp">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <iframe class="embed-responsive-item" src="https://skp.kemkes.go.id" width="100%" height="450"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="modal-draftkadinkes-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                Draft Surat Keterangan Dinas Kesehatan
                            </div>
                            <div class="card-tools">
                                <a type="button" id="lihatdraftdinkes" class="btn btn-tool" href="" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraftdinkes">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <iframe id="viewdraftskdinkes" class="embed-responsive-item" src="" width="100%" height="400px"></iframe>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="alert alert-success alert-dismissible">
                                        Mohon Periksa Terlebih Dahulu Draft Surat Keterangan Dinas Kesehatan Sebelum Melakukan Proses Tanda Tangan Elektronik Dengan Menginputkan Passphrase Berikut Dibawah.
                                    </div>

                                    <form id="submitttekadinkes" action="" method="post" class="form-horizontal">
                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">Passphrase</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="nik_tte" name="nik_tte">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">filenamesip</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="filename_tte" name="filename_tte">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Passphrase</label>
                                            <div class="input-group input-group">
                                                <input type="password" class="form-control" id="passphrase" name="passphrase" placeholder="passphrase">
                                                <span class="input-group-append">
                                                <button type="button" class="btn btn-default btn-flat intippass"><i class="fas fa-eye"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success" id="btnsubmittte">Setujui</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraftdinkes" id="close-draftkadinkes-modal">Tutup</button>
                        </div>
                        <div class="overlay" id="sedangttekadinkes" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="modal-draftkadin-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                Draft e-SIP
                            </div>
                            <div class="card-tools">
                                <a type="button" id="lihatdraftkadin" class="btn btn-tool" href="" target="_blank">
                                    <i class="fas fa-download"></i>
                                </a>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraftkadin">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <iframe id="viewdraftkadin" class="embed-responsive-item" src="" width="100%" height="400px"></iframe>
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="alert alert-success alert-dismissible">
                                        Mohon Periksa Terlebih Dahulu Draft Surat Ijin Praktik (e-SIP) Sebelum Melakukan Proses Tanda Tangan Elektronik Dengan Menginputkan Passphrase Berikut Dibawah.
                                    </div>

                                    <form id="submitttekadin" action="" method="post" class="form-horizontal">

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">User ID</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="id_tte_kadin" name="id_tte">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">filenamesip</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="filename_tte_kadin" name="filename_tte">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">iscabut</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="iscabut_tte_kadin" name="iscabut_tte_kadin" value="0">
                                            </div>
                                        </div>

                                        <div class="form-group" style="display:none">
                                            <label for="exampleFormControlSelect1" class="ms-0">iscabut</label>
                                            <div class="input-group input-group">
                                                <input class="form-control" id="idpengajuan_tte_kadin" name="idpengajuan_tte_kadin" value="{{$detail_pengajuan->id}}">
                                            </div>
                                        </div>
                                        

                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Passphrase</label>
                                            <div class="input-group input-group">
                                                <input type="password" class="form-control" id="passphrase_kadin" name="passphrase" placeholder="passphrase">
                                                <span class="input-group-append">
                                                <button type="button" class="btn btn-default btn-flat intippass"><i class="fas fa-eye"></i></button>
                                                </span>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success" id="btnsubmitttekadin">Setujui</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraftkadin" id="close-draftkadinkes-modal">Tutup</button>
                        </div>
                        <div class="overlay" id="sedangttekadin" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="modal-sipsebelumesip-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                Upload SIP Sebelum Pendaftaran e-SIP
                            </div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm float-right tutupsipsebelumsip">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">

                                    <div class="alert alert-success alert-dismissible">
                                        Dengan Upload SIP Sebelum Pendaftaran e-SIP, Maka Masa berlaku e-SIP Pengajuan Ini Akan Disamakan Dengan Masa Berlaku SIP Sebelumnya.
                                    </div>

                                    @if($detail_pengajuan->isperpanjangan == '1')

                                    <div class="alert alert-warning alert-dismissible">
                                        Pengajuan Ini Merupakan Perpanjangan, Dengan Submit Dokumen SIP Sebelumnya, Masa Berlaku e-SIP akan tetap mengikuti dokumen yang diupload.
                                    </div>

                                    @endif

                                    <form enctype="multipart/form-data" id="submitsipsebelumesip" action="" method="post" class="form-horizontal">


                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Dokumen SIP</label>
                                                    <input type="file" id="tFileSipBeforeSip" name="tFileSipBeforeSip" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="ms-0"> No. Dokumen</label>
                                                    <input type="text" id="tNoDocBeforeSip" name="tNoDocBeforeSip" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="ms-0"> Tgl. Dokumen</label>
                                                    <input type="date" id="tTglBeforeSip" name="tTglBeforeSip" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="display:none">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="" class="ms-0"> User ID</label>
                                                    <input type="text" id="tUserIdBeforeSip" name="tUserIdBeforeSip" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-sm btn-success" id="btnsubmitsebelumsip">Submit</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraftdinkes" id="close-draftkadinkes-modal">Tutup</button>
                        </div>
                        <div class="overlay" id="sedangupdatebeforesip" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="modal-ubahpengaju-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h5>Ubah Data Pemohon SIP</h5> 
                            </div>
                            <div class="card-tools">
                            <button type="button" class="btn btn-secondary btn-sm float-right" id="close-ubahpengaju-modal">Close</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="lanjutuploadstrmanual" action="{{ route('simpan.str.manual') }}" method="post" class="form-horizontal">
                                @csrf

                                <div class="row">
                                    
                                    <div class="col-md-6 col-xs-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Tempat Lahir</label>
                                            <input type="text" id="ePengajuTmptLahir" name="ePengajuTmptLahir" class="form-control" value="{{$detail_pengaju->tmpt_lahir}}"required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Tanggal Lahir</label>
                                            <input type="text" id="ePengajuTglLahir" name="ePengajuTglLahir" class="form-control"  value="{{$detail_pengaju->tgl_lahir}}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-xs-6" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">is Faskes</label>
                                            <input type="text" id="eIsFaskes" name="eIsFaskes" class="form-control" value="{{$detail_pengajuan->isFaskes}}"required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-xs-6" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nama STR</label>
                                            <input type="text" id="ePengajuNamaSTR" name="ePengajuNamaSTR" class="form-control" value="{{$detail_pengaju->nama}}"required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-xs-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nama e-SIP</label>
                                            <input type="text" id="ePengajuNama" name="ePengajuNama" class="form-control" value="{{$detail_pengaju->nama_pengaju}}"required>
                                        </div>
                                    </div>

                                    
                                </div>

                                <div class="row">

                                    <div class="col-md-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Profesi e-SIP</label>
                                            <input type="text" id="ePengajuProfesi" name="ePengajuProfesi" class="form-control"  value="{{$detail_pengaju->profesi_pengaju}}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-xs-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                            <input type="text" id="ePengajuKompetensi" name="ePengajuKompetensi" class="form-control"  value="{{$detail_pengaju->kompetensi_pengaju}}" required>
                                           
                                        </div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-4 col-xs-12" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Alamat Nakes</label>
                                            <textarea type="text" id="ePengajuAlamat" name="ePengajuAlamat" class="form-control" value= required>{{$detail_pengaju->alamat_pengaju}}</textarea>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                            <input type="text" id="ePengajuAlamatKec" name="ePengajuAlamatKec" class="form-control" value="{{$detail_pengaju->kecamatan_pengaju}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                            <input type="text" id="ePengajuAlamatKab" name="ePengajuAlamatKab" class="form-control" value="{{$detail_pengaju->kabupaten_pengaju}}" required>
                                        </div>
                                    </div>
                                </div>  

                                <div class="row" style="display:none">
                                    <div class="col-md-4 col-xs-12" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">isFaskes</label>
                                            <input type="text" id="ePengajuanFaskes" name="ePengajuanFaskes" class="form-control" value="{{$detail_pengajuan->isFaskes}}" >
                                        </div>
                                    </div>
                                </div>


                                @if($detail_pengajuan->isFaskes == 0)
                                <hr />
                                <div class="row">
                                    <div class="col-md-4 col-xs-12" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                                            <textarea type="text" id="ePengajuanAlamat" name="ePengajuanAlamat" class="form-control" required>{{$detail_pengajuan->alamat_pengajuan}}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                                            <textarea type="text" id="ePengajuanAlamatBefore" name="ePengajuanAlamatBefore" class="form-control" required>{{$detail_pengajuan->alamat_pengajuan}}</textarea>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                            <input type="text" id="ePengajuanAlamatKec" name="ePengajuanAlamatKec" class="form-control" value="{{$detail_pengajuan->kecamatan}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                            <input type="text" id="ePengajuanAlamatKecBefore" name="ePengajuanAlamatKecBefore" class="form-control" value="{{$detail_pengajuan->kecamatan}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                            <input type="text" id="ePengajuanAlamatKab" name="ePengajuanAlamatKab" class="form-control" value="{{$detail_pengajuan->kabupaten}}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                            <input type="text" id="ePengajuanAlamatKabBefore" name="ePengajuanAlamatKabBefore" class="form-control" value="{{$detail_pengajuan->kabupaten}}" required>
                                        </div>
                                    </div>
                                </div>  


                                @endif
                                <div class="row" style="display:none">
       
                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                            <input type="text" id="eIDUpdater" name="eIDUpdater" class="form-control" value="{{$user_id}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                            <input type="text" id="eIdNakes" name="eIdNakes" class="form-control" value="{{$detail_pengajuan->id_user}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                            <input type="text" id="eSalinanNakes" name="eSalinanNakes" class="form-control" value="{{$detail_pengajuan->salinan}}">
                                        </div>
                                    </div>

                                    <div class="col-md-6" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                            <input type="text" id="eIdPengajuan" name="eIdPengajuan" class="form-control" value="{{$detail_pengajuan->id}}">
                                        </div>
                                    </div>

                                </div>  
                                <div class="row">
                                    <div class="col-md-5 col-xs-12" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nomor Depan Jika TTK</label>
                                            <input type="text" id="ePengajuNoTTK" name="ePengajuNoTTK" class="form-control" value="{{$detail_pengaju->no_ttk}}">
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nomor Depan Jika TTK</label>
                                            <input type="text" id="ePengajuNoTTKBefore" name="ePengajuNoTTKBefore" class="form-control" value="{{$detail_pengaju->no_ttk}}">
                                        </div>
                                    </div>
                                    <div class="col-md-5 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Nomor Depan Jika TTK</label>
                                            <input type="text" id="eTemplateBefore" name="eTemplateBefore" class="form-control" value="{{$detail_pengaju->template_id}}">
                                        </div>
                                    </div>
                                    
                                    @if($detail_pengajuan->template_id == '3' || $detail_pengajuan->template_id == '4')
                                    <div class="col-md-7 col-xs-12">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Jenis SIP</label><select class="form-control" id="ePengajuTemplateSIP" name="ePengajuTemplateSIP" ><option value="3">SIP APOTEKER / TTK</option><option value="4">SIP APOTEKER PENANGGUNG JAWAB</option></select>
                                        </div>
                                    </div>
                                    @else

                                    <div class="col-md-5 col-xs-12" style="display:none">
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Template ID</label>
                                            <input type="text" id="ePengajuTemplateSIP" name="ePengajuTemplateSIP" class="form-control" value="{{$detail_pengaju->template_id}}">
                                        </div>
                                    </div>

                                    @endif
                                </div>
                                @if (strpos($detail_pengajuan->tgl_doc_origin, 'interns') !== false)
                                <div class="row">
                                    <div class="col-md-5 col-xs-12" >
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect1" class="ms-0">Masa Berlaku Internsip</label>
                                            <input type="text" id="tgldocintern" name="tgldocintern" class="form-control" value="{{$detail_pengajuan->berlaku_sampai}}">
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </form>
                            <button id="updatedatapengaju" class="btn btn-success">Update</button>
                        </div>
                        <div class="overlay" id="ovdetailpengaju" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div id="modal-lihatdraft-content" style="display: none; width: 98vw; max-width: 98vw; max-height: 95vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                Draft SIP
                            </div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraft">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row" id="aksidraftptsp">
                                <div class="col-md-6 col-xs-12">
                                    <div class="alert alert-danger alert-dismissible">
                                        Untuk Membatalkan Proses Pengajuan TTE dikarenakan ada kesalahan data, silahkan Klik Tombol Dibawah <hr />
                                        <button class="btn btn-block bg-gradient-danger" id="bataldraftsip" data-filename="{{$detail_pengajuan->filename_sip}}" data-id="{{$id_pengajuan}}" data-updater="{{$user_id}}" data-perubahan="{{$detail_pengajuan->perubahan}}">Batalkan Draft</button>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12" style="display:none">
                                    <div class="alert alert-warning alert-dismissible">
                                        Untuk Memuat Ulang Draft SIP Setelah Perbaikan data nakes sebelum TTE, silahkan Klik Tombol Dibawah <br /> <hr />
                                        <button class="btn btn-block bg-gradient-warning" id="refreshdraftsip" data-filename="{{$detail_pengajuan->filename_sip}}" data-id="{{$id_pengajuan}}" data-updater="{{$user_id}}">Refresh Draft</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <iframe id="lihatdraftnya" src="" style="width:100%;height:100%; border:none; display:block;">
                                    </iframe>
                                </div>
                            </div>
                        
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-secondary btn-sm float-right tutupintipdraft" id="close-lihatdraft-modal">Tutup</button>
                        </div>
                        <div class="overlay" id="sedangrevertdraft" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="modal-lihatsatusehat-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                Data Satu Sehat
                            </div>
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
                            <iframe id="satusehat-iframe" src="" width="100%" height="400" frameborder="0"></iframe>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary btn-sm float-right me-2" id="oint">Buka Tab Baru</button>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div id="modal-lihatkecukupan-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title" id="juduldraftsip">
                                Data Kecukupan
                            </div>
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
                            <iframe id="kecukupan-iframe" src="" width="100%" height="400" frameborder="0"></iframe>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary btn-sm float-right me-2" id="skskpoint">Buka Tab Baru</button>
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="card card-primary card-outline" id="blockside">
                    <div class="card-header">
                        <h3 class="card-title">
                            Dokumen Pengajuan
                        </h3>
                        
                        <script>
                            function hideme(){
                                $('#jajalan').hide()
                            }
                        </script>

                    </div>
                    <div class="card-body">
                        <div class="row" style="display:none">
                            <div class="form-group">
                                <label for="name" class="label-control col-md-12"></label>
                                <div class="col-md-12 col-xs-12">
                                    <input type="checkbox" id="showSTR" checked>&nbsp;STR&nbsp;&nbsp;|
                                    <input type="checkbox" id="showKTP" checked>&nbsp;KTP&nbsp;&nbsp;|
                                    <input type="checkbox" id="showREKOMP" checked>&nbsp;Rekom Profesi&nbsp;&nbsp;|
                                    <input type="checkbox" id="showSKS" checked>&nbsp;SKS&nbsp;&nbsp;|
                                    <input type="checkbox" id="showSPTP" checked>&nbsp;SPTP&nbsp;&nbsp;|
                                    <input type="checkbox" id="showIJAZAH" checked>&nbsp;IJAZAH&nbsp;&nbsp;|
                                    <input type="checkbox" id="showSKP" checked>&nbsp;SKP&nbsp;&nbsp;|
                                    <input type="checkbox" id="showBAV" checked>&nbsp;BA Visitasi&nbsp;&nbsp;|
                                </div>
                            </div>
                        </div>
                    
                    
                        <div class="kekanan" id="kekanan" data-jenisprofesi = "{{$detail_pengajuan->jenis_profesi}}" data-isfaskes="{{$detail_pengajuan->isFaskes}}" data-idpeng = "{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-salinan= "{{$salinan}}" data-urlqr = "{{$detail_pengaju->url_qr}}" data-template="{{$detail_pengajuan->template_id}}">
                            <div class="card card-row card-success blogade" id="cardSIP" @if($detail_pengajuan->perubahan < 1) style="display:none" @endif>
                                <div class="card-header">
                                    <h3 class="card-title">
                                     e-SIP sebelumnya
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
                                    <div class="row" style="display:none">
                                        <input type="text" id="isPerubahanKe" value="{{$detail_pengajuan->perubahan}}"/>
                                        <input type="text" id="vIDPengajuan" value="{{$id_pengajuan}}" />
                                    </div>
                                    <embed id="esipsebelumnya" src="" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @foreach ($doc_strused as $str)
                            <div class="card card-row card-success blogade" id="cardSTR">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        STR Salinan {{$str->salinan}}
                                    
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
                                    @if($str->remark4 == '1')
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert alert-warning alert-dismissible">
                                                    STR Diupload Tanpa Melalui Verifikasi Dari Sistem, Mohon Untuk Di Periksa Terlebih Dahulu!
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="satusehatsearch" name="satusehatsearch" class="form-control" value="{{$str->no_doc}}" readonly>
                                                    <div class="input-group-append" >
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat" id="ceksatusehat">Satu Sehat</button>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <embed src="{{ URL::to('/storage')}}/{{$str->namafile}}.pdf" width="100%" height="100%"></embed>
                                </div>
                            </div>
                            @if($str->url_qr != '0')
                                @if($str->url_qr != 'manual')

                                    <div class="card card-row card-secondary blogade" id="jajalan">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            
                                                Validasi STR Salinan {{$str->salinan}}
                                            
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
                                            <a class="btn btn-primary btn-sm" href="{{ str_replace('http://', 'https://', $str->url_qr) }}" target="_blank">Lihat</a>
                                            <br />
                                            <iframe class="embed-responsive-item" id="framestrvalid" src="" width="100%" height="450px" style="border: none; background-color: #f3f3f3;">
                                                Loading...
                                            </iframe>
                                        </div>
                                    </div>
                                @else

                                    <div class="card card-row card-secondary blogade" id="jajalan">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                            
                                                Validasi STR Salinan {{$str->salinan}}
                                            
                                            </h3>
        
                                        </div>
                                        <div class="card-body">
                                            <h1> Validasi STR Tidak Tersedia (Non-QRCODE)</h1>
                                        </div>
                                    </div>
                                @endif

                            @endif

                        @endforeach

                        @foreach($doc_sub as $sub)
                            <div class="card card-row card-success blogade" id="cardSUB">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        STR SUB Spesialis
                                    
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
                                    @if ($detail_pengajuan->remark == '0' || $detail_pengajuan->remark == null)
                                    <div class="alert alert-info alert-dismissible">
                                    <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
                                        STR SUB SPESIALIS sudah diupload namun belum digunakan untuk pengajuan ini.
                                    </div>
                                    @else
                                    <embed src="{{ URL::to('/storage')}}/{{$sub->namafile}}.pdf" width="100%" height="100%"></embed>
                                    
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if($detail_pengajuan->isApproved == 'C' || $detail_pengajuan->isApproved == 'CF')
                            @foreach($doc_c as $dc)
                            <div class="card card-row card-warning blogade" id="cardREKOMPC">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Dokumen Pencabutan
                                    
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$dc->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                            @endforeach
                        @endif

                        @foreach($doc_ktp as $ktp)
                            <div class="card card-row card-info blogade" id="cardKTP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Dokumen KTP
                                    
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
                                    <form>
                                        <div class="row">        
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <div class="input-group mb-3">
                                                        <input type="text" id="niktosearch" name="niktosearch" class="form-control" value="{{$ktp->no_doc}}" readonly>
                                                        <div class="input-group-append" >
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-info btn-flat" id="cekskp">Cek SKP</button>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="row toevent">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Nama KTP</label>
                                                <input type="text" class="form-control" value="{{$ktp->nama_doc}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Tanggal Lahir</label>
                                                <input type="text" class="form-control" value="{{$ktp->tgl_doc}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row toevent">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Nama KTP</label>
                                                <textarea class="form-control">{{$ktp->remark1}}, {{$ktp->remark2}}, {{$ktp->remark3}}</textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach

                        @foreach($doc_rekomp as $rekomp)
                            <div class="card card-row card-warning blogade" id="cardREKOMP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Dokumen Rekomendasi Profesi
                                    
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$rekomp->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                            

                        @foreach($doc_sptp as $sptp)
                            <div class="card card-row card-primary blogade" id="cardSPTP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Surat Persyaratan Tempat Praktik
                                    
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$sptp->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach



                        @foreach($doc_sks as $sks)
                            <div class="card card-row card-info blogade" id="cardSKS">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Surat Keterangan Sehat
                                    
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$sks->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                        @foreach($doc_ijazah as $ijazah)
                            <div class="card card-row card-warning blogade" id="cardIJAZAH">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        IJAZAH
                                    
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
                                    <div class="row toevent">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Tanggal Ijazah</label>
                                                <input type="text" class="form-control" value="{{$ijazah->tgl_doc}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Nomor Ijazah</label>
                                                <input type="text" class="form-control" value="{{$ijazah->no_doc}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row toevent">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Universitas</label>
                                                <input type="text" class="form-control" value="{{$ijazah->remark1}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row toevent">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Jurusan</label>
                                                <input type="text" class="form-control" value="{{$ijazah->remark3}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Strata</label>
                                                <input type="text" class="form-control" value="{{$ijazah->remark2}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        @endforeach

                        @foreach($doc_skp as $skp)
                            <div class="card card-row card-info blogade" id="cardSKP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Surat Keterangan Pimpinan
                                    
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$skp->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                        @php
                        $skskp = $doc_skskp->first();
                        @endphp

                        @if ($skskp)
                            <div class="card card-row card-info blogade" id="cardSKSKP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        Dokumen Serkom / SKP
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
                                    @if($skskp->remark1 != '31 Desember 2024' && $skskp->remark1 != '')
                                    <form>
                                        <div class="row">        
                                            <div class="col-md-12 col-sm-12">
                                                <div class="form-group">
                                                    <div class="input-group mb-3">
                                                        <input id="checkskskp" type="text" class="form-control" value="{{$skskp->remark1}}" readonly>
                                                        <div class="input-group-append" >
                                                        <span class="input-group-append">
                                                            <a type="button" href="{{$skskp->remark1}}" class="btn btn-info btn-flat" target="_blank">Cek SKSKP</a>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    @else

                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div class="form-group">
                                                <div class="input-group mb-3">
                                                    <input type="text" id="kecukupansearch" name="kecukupansearch" class="form-control" value="{{$skskp->namafile}}" readonly>
                                                    <div class="input-group-append" >
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-info btn-flat" id="cekkecukupan">Cek Sertifikat</button>
                                                    </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                    <embed src="{{ URL::to('/storageup')}}/{{$skskp->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endif

                        @foreach($doc_sktp as $sktp)
                            <div class="card card-row card-info blogade" id="cardSKTP">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Dokumen Surat Keterangan Permohonan Tempat Praktik
                                    
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$sktp->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach


                        @foreach($doc_rekomdk as $rekomdk)
                            <div class="card card-row card-success blogade" id="cardREKOMDK">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Surat Rekomendasi Dinas Kesehatan
                                    
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$rekomdk->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                        @foreach($doc_rekdin as $rekdin)
                            @if($rekdin->perpanjangan == $detail_pengajuan->perpanjangan)
                            <div class="card card-row card-success blogade" id="cardREKDIN">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Surat Keterangan Tempat Praktik @if ($detail_pengajuan->perpanjangan > 0) (Perpanjangan {{$detail_pengajuan->perpanjangan}}) @endif
                                    
                                    </h3>
 
                                    <div class="card-tools">
                                        <a type="button" class="btn btn-tool" href="{{$surat_host}}assets/uploads/maker/approved/{{$rekdin->filename_sk}}.pdf" target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>

                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <embed src="{{$surat_host}}assets/uploads/maker/approved/{{$rekdin->filename_sk}}.pdf" width="100%" height="100%"></embed>
                                </div>
                            </div>
                            @endif
                        @endforeach

                        @foreach($doc_bav as $bav)
                            <div class="card card-row card-info blogade" id="cardBAV">
                                <div class="card-header">
                                    <h3 class="card-title">
                                    
                                        Dokumen Berita Acara Visitasi
                                    
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
                                    <embed src="{{ URL::to('/storageup')}}/{{$bav->namafile}}" width="100%" height="100%"></embed>
                                </div>
                            </div>
                        @endforeach

                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="kotakprofile">
                <div class="col-md-3">
                 <div class="sticky-top mb-3">

                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid custom-rounded" src="{{ URL::to('/storagefoto')}}/{{$detail_pengaju->saved_photo}}"
                                    alt="User profile picture">
                            </div>

                        @if(($role == 'adminptsp' || $role == 'verifptsp') && ($detail_pengajuan->isApproved == '2' || $detail_pengajuan->isApproved == '3'))
                            <h3 class="profile-username text-center" id="namapengaju"><a href="#kotakprofile" class="toprofilingnakes" data-id="{{$detail_pengajuan->id_user}}">{{$detail_pengaju->nama}}</a></h3>
                            <p class="text-muted text-center" id="kompetensipengaju">{{$detail_pengaju->kompetensi_pengaju}}</p>
                            <hr />
                            <a class="btn btn-light btn-block" id="editpengaju">Edit &nbsp; &nbsp;<i class="fas fa-edit"></i></a>
                            <br />
                            <strong><i class="fas fa-file mr-1"></i> Nama e-SIP</strong>
                            <p class="text-muted" id="namasippengaju">
                            @foreach ($doc_ktp as $ketktp) 
                                {{$ketktp->nama_doc}}
                            @endforeach
                            </p>
                            <hr />
                            <strong><i class="fas fa-book mr-1"></i> Pendidikan</strong>
                            <p class="text-muted" id="univpengaju">
                            @if($infonakes->universitas == '')

                            Silahkan Upload Dokumen Ijazah

                            @else
                            {{$infonakes->strata}}, Jurusan {{$infonakes->jurusan}}, {{$infonakes->universitas}}
                            @endif
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1" ></i> Alamat</strong>
                            <p class="text-muted" id="alamatpengaju">
                            @if($infonakes->alamat_ktp == '')

                                Silahkan Upload Dokumen KTP

                            @else
                                {{$infonakes->alamat_ktp}}, {{$infonakes->kec_ktp}}, {{$infonakes->kab_ktp}}
                            @endif
                            
                            </p>
                            <hr>
                            @if($infonakes->isdomi == 'D')
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat Domisili</strong>
                            <p class="text-muted">
                            
                                {{$infonakes->alamat_domisili}}, {{$infonakes->kec_domisili}}, {{$infonakes->kab_domisili}}
                          
                            </p>
                            <hr>
                            @endif
                            <strong><i class="far fa-file-alt mr-1"></i> Email</strong>
                            <p class="text-muted">{{$detail_pengaju->email}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Pengajuan</b> <a class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Histori Praktik</b> <a class="float-right"></a>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-block"><b>Profile</b></a>

                        @else
                            <h3 class="profile-username text-center">{{$detail_pengaju->nama}}</h3>
                            <p class="text-muted text-center">{{$detail_pengaju->kompetensi_pengaju}}</p>
                            <hr />
                            <strong><i class="fas fa-file mr-1"></i> Nama e-SIP</strong>
                            <p class="text-muted">
                            @foreach ($doc_ktp as $ketktp) 
                                {{$ketktp->nama_doc}}
                            @endforeach
                            </p>
                            <hr />
                            <strong><i class="fas fa-book mr-1"></i> Pendidikan</strong>
                            <p class="text-muted">
                            @if($infonakes->universitas == '')

                            Silahkan Upload Dokumen Ijazah

                            @else
                            {{$infonakes->strata}}, Jurusan {{$infonakes->jurusan}}, {{$infonakes->universitas}}
                            @endif
                            </p>
                            <hr>
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                            <p class="text-muted">
                            @if($infonakes->alamat_ktp == '')

                                Silahkan Upload Dokumen KTP

                            @else
                                {{$infonakes->alamat_ktp}}, {{$infonakes->kec_ktp}}, {{$infonakes->kab_ktp}}
                            @endif
                            
                            </p>
                            <hr>
                            @if($infonakes->isdomi == 'D')
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat Domisili</strong>
                            <p class="text-muted">
                            
                                {{$infonakes->alamat_domisili}}, {{$infonakes->kec_domisili}}, {{$infonakes->kab_domisili}}
                          
                            </p>
                            <hr>
                            @endif
                            <strong><i class="far fa-file-alt mr-1"></i> Email</strong>
                            <p class="text-muted">{{$detail_pengaju->email}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Pengajuan</b> <a class="float-right"></a>
                                </li>
                                <li class="list-group-item">
                                    <b>Histori Praktik</b> <a class="float-right"></a>
                                </li>
                            </ul>
                            <a href="#" class="btn btn-primary btn-block"><b>Profile</b></a>
                        @endif
                        </div>

                    </div>
                 </div>   
                </div>

                <div class="col-md-9">
                    <div class="card card-primary">
                        <div class="card-header p-2">
                            Detail Pengajuan @if ($detail_pengajuan->perpanjangan > 0) (Perpanjangan {{$detail_pengajuan->perpanjangan}}) @endif
                        </div>
                        <div class="card-body">
                            <form style="display:none">
                                <input id="mapidPengajuan" value="{{$id_pengajuan}}">
                                <input id="maplatitude" value="{{$detail_pengajuan->latitude}}">
                                <input id="maplongitude" value="{{$detail_pengajuan->longitude}}">

                            </form>

                               
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <form>

                                        @if($detail_pengajuan->template_id == '3')

                                        <div class="row">
                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Pengajuan Sebagai</label>
                                                    <input type="text" class="form-control" value="Apoteker" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                        @elseif($detail_pengajuan->template_id == '4')

                                        <div class="row">
                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Pengajuan Sebagai</label>
                                                    <input type="text" class="form-control" value="Apoteker Penanggung Jawab" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <hr />

                                        @elseif($detail_pengajuan->template_id == '2')

                                            @if($detail_pengajuan->remark == '0' || is_null($detail_pengajuan->remark))
                                                <div class="row">
                                                </div>
                                            @else
                                                <div class="row">
                                                    <div class="col-md-12" >
                                                        <div class="form-group">
                                                            <label for="exampleFormControlSelect1" class="ms-0">Pengajuan Sebagai</label>
                                                            <input type="text" class="form-control" value="{{$detail_pengajuan->remark}}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                            @endif

                                        @endif

                                        @if($detail_pengajuan->isFaskes == 1)

                                        <div class="row">
                                            <div class="col-md-12" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Nama Faskes @if(Auth::user()->role != 'nakes')<button type="button" class="btn btn-sm btn-primary" id="detailnakesonfaskes" data-id="{{$detail_pengajuan->id_faskes}}" data-nama="{{$detail_pengajuan->nama_faskes}}"><i class="fas fa-eye"></i></button>@endif</label>
                                                    <input type="text" id="tNamaFaskesM" name="tNamaFaskesM" class="form-control" value="{{$detail_pengajuan->nama_faskes}}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        @endif
                                        <div class="row">
                                
                                            <div class="col-md-6" >
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                                                    <input type="text" id="tAlamatPengajuanM" name="tAlamatPengajuanM" class="form-control" value="{{$detail_pengajuan->alamat_pengajuan}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                                    <input type="text" id="tKabupatenM" name="tKabupatenM" class="form-control" value="{{$detail_pengajuan->kabupaten}}" readonly>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                    <input type="text" id="tKecamatanM" name="tKecamatanM" class="form-control" value="{{$detail_pengajuan->kecamatan}}" readonly>
                                                </div>
                                            </div>
                                        </div>     
                                        

                                        <div class="row toevent">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Latitude</label>
                                                    <input type="text" id="tLat" name="tLat" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Longitude</label>
                                                    <input type="text" id="tLong" name="tLong" class="form-control" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        @if($detail_pengajuan->isApproved == 'P2')


                                        <div class="row toevent">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik (Terakhir)</label>
                                                    <div class="card">
                                                        <div class="card-body table-responsive p-0">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Hari</th>
                                                                        <th>Pukul - Hingga</th>
                                                                        <th>Shift</th>
                                                                        <th>Uraian</th>
                                                                        <th>Keterangan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @forelse($jadwalbefore as $jadbef)
                                                                    <tr>
                                                                        <td>{{ $jadbef->hari ?? '' }}</td>
                                                                        <td>{{ $jadbef->pukul ?? '' }}</td>
                                                                        <td>{{ $jadbef->isShift ?? '' }}</td>
                                                                        <td>{{ $jadbef->uraian ?? '' }}</td>
                                                                        <td>-</td>
                                                                    </tr>
                                                                @empty
                                                                    <tr>
                                                                        <td colspan="5" class="text-center">No data available</td>
                                                                    </tr>
                                                                @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik (Perubahan)</label>
                                                    <div class="card">
                                                        <div class="card-body table-responsive p-0">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Hari</th>
                                                                        <th>Pukul - Hingga</th>
                                                                        <th>Shift</th>
                                                                        <th>Uraian</th>
                                                                        <th>Keterangan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($jadwalpraktik as $jadual)
                                                                    @if($jadual->levelwarning == 1)
                                                                    <tr style="background-color:orange; color:white">
                                                                    @elseif ($jadual->levelwarning == 2)
                                                                    <tr style="background-color:red; color:white">
                                                                    @else
                                                                    <tr>
                                                                    @endif

                                                                        <td>{{$jadual->hari}}</td>
                                                                        <td>Pukul <b>{{$jadual->mulai}}</b> - Hingga <b>{{$jadual->selesai}}</b></td>
                                                                        <td>
                                                                        @if ($jadual->is_shift == 1)
                                                                            Shift
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        </td>
                                                                        <td>{{$jadual->uraian}}</td>
                                                                        <td>
                                                                        @if ($jadual->iscompromised == 1)
                                                                            @if($jadual->levelwarning == 1)
                                                                            <i class="fas fa-exclamation-triangle"></i>&nbsp; Jarak Jadwal Terlalu Sempit
                                                                            @elseif ($jadual->levelwarning == 2)
                                                                            <i class="fas fa-exclamation-triangle"></i>&nbsp; Jadwal Berbenturan
                                                                            @endif
                                                                            
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        </td>
                                                                    </tr>
                                                                    @if($jadual->iscompromised == 1)
                                                                        @if($jadual->levelwarning == 1)
                                                                            @php
                                                                            $myarray = explode(",",$jadual->keterangan);
                                                                            @endphp
                                                                            @foreach($myarray as $ket)
                                                                                <tr>
                                                                                    <td width="100%" colspan="4"><div class="card"><div class="card-body"><div class="alert alert-warning alert-dismissible">{{$ket}}</div></div></div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @elseif($jadual->levelwarning == 2)
                                                                            @php
                                                                            $myarray = explode(",",$jadual->keterangan); 
                                                                            @endphp
                                                                            @foreach($myarray as $ket)
                                                                                <tr>
                                                                                    <td width="100%" colspan="4"><div class="card"><div class="card-body"><div class="alert alert-danger alert-dismissible">{{$ket}}</div></div></div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @else
                                                                        
                                                                        @endif
                                                                    @endif

                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        @else

                                        <div class="row toevent">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Praktik</label>@if(count($jadwalpraktik) == 0)
                                                    <button type="button" class="btn btn-sm btn-info" data-id = "{{$id_pengajuan}}" data-nakes ="{{$id_nakes}}" data-salinan ="{{$salinan}}" data-doc="{{$detail_pengajuan->id_doc}}" id="addJadwalPraktik">
                                                        <i class="fa fa-edit"></i></button>
                                                    @endif
                                                    <div class="card">
                                                        <div class="card-body p-0">
                                                            <table class="table table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Hari</th>
                                                                        <th>Pukul - Hingga</th>
                                                                        <th>Shift</th>
                                                                        <th>Uraian</th>
                                                                        <th>Keterangan</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($jadwalpraktik as $jadual)
                                                                    @if($jadual->levelwarning == 1)
                                                                    <tr style="background-color:orange; color:white">
                                                                    @elseif ($jadual->levelwarning == 2)
                                                                    <tr style="background-color:red; color:white">
                                                                    @else
                                                                    <tr>
                                                                    @endif

                                                                        <td>{{$jadual->hari}}</td>
                                                                        <td>Pukul <b>{{$jadual->mulai}}</b> - Hingga <b>{{$jadual->selesai}}</b></td>
                                                                        <td>
                                                                        @if ($jadual->is_shift == 1)
                                                                            Shift
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        </td>
                                                                        <td>{{$jadual->uraian}}</td>
                                                                        <td>
                                                                        @if ($jadual->iscompromised == 1)
                                                                            @if($jadual->levelwarning == 1)
                                                                            <i class="fas fa-exclamation-triangle"></i>&nbsp; Jarak Jadwal Terlalu Sempit
                                                                            @elseif ($jadual->levelwarning == 2)
                                                                            <i class="fas fa-exclamation-triangle"></i>&nbsp; Jadwal Berbenturan
                                                                            @endif
                                                                            
                                                                        @else
                                                                            -
                                                                        @endif
                                                                        </td>
                                                                    </tr>
                                                                    @if($jadual->iscompromised == 1)
                                                                        @if($jadual->levelwarning == 1)
                                                                            @php
                                                                            $myarray = explode(",",$jadual->keterangan);
                                                                            @endphp
                                                                            @foreach($myarray as $ket)
                                                                                <tr>
                                                                                    <td width="100%" colspan="4"><div class="card"><div class="card-body"><div class="alert alert-warning alert-dismissible">{{$ket}}</div></div></div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @elseif($jadual->levelwarning == 2)
                                                                            @php
                                                                            $myarray = explode(",",$jadual->keterangan); 
                                                                            @endphp
                                                                            @foreach($myarray as $ket)
                                                                                <tr>
                                                                                    <td width="100%" colspan="4"><div class="card"><div class="card-body"><div class="alert alert-danger alert-dismissible">{{$ket}}</div></div></div>
                                                                                    </td>
                                                                                </tr>
                                                                            @endforeach
                                                                        @endif
                                                                    @endif

                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        @endif

                                    </form>
                                </div>
                            </div>

                            <hr />
                            
                            <div class="card">
                                <div class="card-body">
                                    <div class="pengajuanmap" id="pengajuanmap" style="height:300px;"></div>
                                </div>
                            </div>

                                @if($detail_pengajuan->isApproved == 'C' || $detail_pengajuan->isApproved == 'CF')
                            
                                    @if ($detail_pengajuan->nama_alasan == '0' || $detail_pengajuan->nama_alasan == null )
                                        <div class="callout callout-danger">
                                            <h5>Alasan Pencabutan SIP</h5>
                                            <p>{{$detail_pengajuan->alasan}}</p>
                                        </div>
                                        
                                    @else
                                        <div class="callout callout-danger">
                                            <h5><b>Alasan Pencabutan SIP</b></h5>
                                            <p>{{$detail_pengajuan->nama_alasan}}</p>
                                        </div>
                                        
                                    @endif
                                        
                                @endif
                            <div class="row">
                                <div class="col-md-6">
                                
                                    @if($role != 'nakes' && $role != 'op')
                                        @if($role == 'adminptsp' || $role == 'verifptsp')
                                            @if($pilihfixed == '1')
                                            <label for="exampleFormControlSelect1" class="ms-0">Berlaku Hingga</label>
                                            <select class="form-control" id="tfixedtgl" name="tfixedtgl">
                                                <option value="0" selected disabled>--Silahkan Pilih--</option>
                                                <option value="1" >Sesuai STR</option>
                                                <option value="2" >Sesuai Undang-Undang</option>
                                                <option value="31" class="cektigasatu">31 Desember 2024</option>
                    
                                            </select>
                                            @elseif($pilihfixed != '0')
                                            <label for="exampleFormControlSelect1" class="ms-0">Berlaku Hingga</label>
                                            <select class="form-control" id="tfixedtgl" name="tfixedtgl">
                                                <option value="1" selected>Sesuai STR</option>    
                                                <option value="2">Sesuai Undang-Undang</option>
                                                <option class="cektigasatu" value="31">31 Desember 2024</option>
                                            </select>
                                            @else
                                            <div class="row">
                                                <label for="exampleFormControlSelect1" class="ms-0">Berlaku Hingga</label>
                                                <select class="form-control" id="tfixedtgl" name="tfixedtgl">    
                                                    <option value="1" selected>Sesuai STR</option>
                                                    <option value="31" class="cektigasatu">31 Desember 2024</option>
                                                </select>
                                            </div>
                                            @endif
                                        @else

                                            @if($checkfix != '0')
                                            <div class="alert alert-info alert-dismissible" style="display:none">
                                            <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
                                            {{$checkfix}}
                                            </div>
                                            @else

                                            <label for="exampleFormControlSelect1" class="ms-0">Berlaku Hingga</label>
                                            <input type="text" id="tBelaku" name="tBelaku" class="form-control" value="{{$detail_pengajuan->berlaku_sampai}}" disabled>
                                            @endif

                                        @endif
                                    @else
                                        @if($checkfix != '0')
                                        <div class="alert alert-info alert-dismissible" style="display:none">
                                        <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
                                        {{$checkfix}}
                                        </div>
                                        @else

                                        <label for="exampleFormControlSelect1" class="ms-0">Berlaku Hingga</label>
                                        <input type="text" id="tBelaku" name="tBelaku" class="form-control" value="{{$detail_pengajuan->berlaku_sampai}}" disabled>
                                        @endif
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <form id="formVisitasi">
                                        <div class="row">
                                            @if ($detail_pengajuan->isFaskes == 0 && $detail_pengajuan->isApproved != 'P2')
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Jadwal Visitasi</label>
                                                    @if ($detail_pengajuan->isApproved == 0)
                                                        @if($role != 'nakes' && $role != 'op')
                                                            <!-- <input type="date" id="tVisitasi" name="tVisitasi" class="form-control" min="{{date('Y-m-d')}}"> -->
                                                            <input type="text" id="tVisitasi" name="tVisitasi" class="form-control" readonly value="{{$detail_pengajuan->tgl_visitasi}}">
                                                        @else
                                                            <!-- <input type="text" id="tVisitasi" name="tVisitasi" class="form-control" value="Belum Ditentukan" disabled> -->
                                                            <input type="text" id="tVisitasi" name="tVisitasi" class="form-control" readonly value="{{$detail_pengajuan->tgl_visitasi}}">
                                                        @endif
                                                    @elseif ($detail_pengajuan->isApproved == 1)
                                                        <!-- <div class="input-group input-group-sm" id="perubahvisit">
                                                            <input type="text" id="tVisitasiV" name="tVisitasiV" class="form-control" readonly value="{{$detail_pengajuan->tgl_visitasi}}">
                                                            <span class="input-group-append">
                                                                <button type="button" class="btn btn-info btn-flat" id="btnUbahVisit">Ubah</button>
                                                            </span>
                                                        </div>

                                                        <div id="ubahlah" style="display:none">
                                                            <input type="date" id="tVisitasiE" name="tVisitasiE" class="form-control" min="{{date('Y-m-d')}}" value="{{$detail_pengajuan->tgl_visitasi}}">
                                                        </div> -->
                                                        <input type="text" id="tVisitasi" name="tVisitasi" class="form-control" readonly value="{{$detail_pengajuan->tgl_visitasi}}">

                                                    @elseif ($detail_pengajuan->isApproved > 1)
                                                    
                                                        <input type="text" id="tVisitasi" name="tVisitasi" class="form-control" readonly value="{{$detail_pengajuan->tgl_visitasi}}">
                                                        
                                                    @endif
                                                </div>
                                            </div>
                                            @endif
                                            @if($detail_pengajuan->isApproved == 2 || $detail_pengajuan->isApproved == 'P2' || $detail_pengajuan->isApproved == 'E2' || $detail_pengajuan->isApproved == 3)

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Template SIP</label>
                                                    <select class="form-control" id="tTemplateSIP" name="tTemplateSIP">
                                                        @if($detail_pengajuan->template_id == 1)
                                                        
                                                        <option value="1" selected>SIP & SIK Tenaga Kesehatan</option>
                                                        @elseif($detail_pengajuan->template_id == 2)
                                                        <option value="2" selected>SIP DOKTER</option>
                                                        

                                                        @elseif($detail_pengajuan->template_id == 3)
                                                        <option value="3" selected>SIP APOTEKER / TTK</option>
                                                        

                                                        @else
                                                        <option value="4" selected>SIP Apoteker Penanggungjawab</option>

                                                        @endif
                                                        
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </form>
                                    <!--<button id="getallin" class="btn btn-danger">testsing</div>-->
                                    <div class="row">
                                        <div class="col-md-12" id="buttonall">
                                        </div>
                                    </div>
                                    @if($role == 'adminptsp')
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Ukuran Foto Tercetak (Pixels) (Default = 150px)</label>
                                                <input type="number" class="form-control" max="200" min="50" value="{{$detail_pengajuan->ukuran}}" id="ukuranfotopengajuan">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                
                            </div>
                            <div class="row checkmandirisekitar">
                                
                            </div>
                        </div>

                            @if ($detail_pengajuan->isApproved == '0')
                                @if($role != 'nakes' && $role != 'op')
                                <div class="card-footer" id="aturjadwaldinkes">
                                    @if($detail_pengajuan->id_faskes > 0)
                                        <button class="btn btn-info" id="setujupengajuandinkes" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-isfaskes = "{{$detail_pengajuan->isFaskes}}">Setujui</button>
                                    @else
                                        <!--<button class="btn btn-info" id="jadwalvisitasi" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-updater="{{$user_id}}">Jadwal Visitasi</button>-->
                                        <button class="btn btn-info" id="setujupengajuandinkes" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-isfaskes = "{{$detail_pengajuan->isFaskes}}">Setujui</button>
                                    @endif
                                        <button class="btn btn-danger" id="tolakpengajuan" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-salinan="{{$salinan}}" data-perubahan="{{$detail_pengajuan->perubahan}}" data-urlqr="{{$detail_pengaju->url_qr}}" data-template="{{$detail_pengajuan->template_id}}">Tolak</button>
                                    </div>
                                @else

                                    <div class="card-footer" id="setujudinkes">
                                        <div class="alert alert-success alert-dismissible">
                                            <h5><i class="icon fas fa-check"></i> e-SIP Sedang Dalam Proses Review Dinas Kesehatan</h5>
                                        </div>
                                    </div>

                                @endif
                            @elseif ($detail_pengajuan->isApproved == '2' || $detail_pengajuan->isApproved == 'P2' || $detail_pengajuan->isApproved == 'E2')
                                @if ($role != 'nakes' && $role != 'op' && $role != 'bidfarmasidinkes' && $role != 'admindinkes')
                                    <div class="card-footer" id="setujuptspnya">
                                        <button class="btn btn-info" id="setujuptsp" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-salinan="{{$salinan}}" data-perubahan="{{$detail_pengajuan->perubahan}}" data-verif="0">Setujui</button>

                                        <!--<a class="btn btn-info" href="{{ route ('draft.persetujuan.sip', $id_pengajuan) }}">Setujui</a>-->

                                        <button class="btn btn-danger" id="tolakpengajuan" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-salinan="{{$salinan}}" data-perubahan="{{$detail_pengajuan->perubahan}}" data-urlqr="{{$detail_pengaju->url_qr}}" data-template="{{$detail_pengajuan->template_id}}">Tolak</button>

                                        <button class="btn btn-secondary" id="sipsebelumesip" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-salinan="{{$salinan}}" data-perubahan="{{$detail_pengajuan->perubahan}}" data-urlqr="{{$detail_pengaju->url_qr}}" data-template="{{$detail_pengajuan->template_id}}">SIP Sebelumnya</button>
                                    </div>
                                @else

                                    <div class="card-footer" id="setujudinkes">
                                        <div class="alert alert-success alert-dismissible">
                                            <h5><i class="icon fas fa-check"></i> e-SIP Dalam Proses Review DPMPTSP</h5>
                                        </div>
                                    </div>
                                @endif
                            @elseif ($detail_pengajuan->isApproved == '1')
                                @if ($role != 'nakes' && $role != 'op' && $role != 'bidfarmasidinkes')
                                <div class="card-footer" id="setujudinkes">

                                    @if($detail_pengajuan->tgl_visitasi > date('Y-m-d'))

                                    <button class="btn btn-info" id="reschedulevisitasi" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-isfaskes = "{{$detail_pengajuan->isFaskes}}" style="display:none" data-updater="{{$user_id}}">Update</button>
                                    @else
                                    <button class="btn btn-info" id="setujupengajuandinkes" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-isfaskes = "{{$detail_pengajuan->isFaskes}}">Setujui</button>
                                    @endif
                                
                                    
                                    <button class="btn btn-danger" id="tolakpengajuan" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-salinan="{{$salinan}}" data-perubahan="{{$detail_pengajuan->perubahan}}" data-urlqr="{{$detail_pengaju->url_qr}}" data-template="{{$detail_pengajuan->template_id}}">Tolak</button>
                                </div>
                                @else 

                                    <div class="card-footer" id="setujudinkes">
                                        <div class="alert alert-success alert-dismissible">
                                            <h5><i class="icon fas fa-check"></i> e-SIP Dalam Proses Review Dinkes</h5>
                                        </div>
                                    </div>

                                @endif
                            @elseif ($detail_pengajuan->isApproved == '3')

                                @if($role != 'nakes' && $role != 'op' && $role != 'verifptsp' && $role != 'kaptsp' && $role != 'admindinkes')

                                    <button class="btn btn-info lihatsipasoka" id="lihatdraftsipasoka" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-file="{{$surat_host}}assets/uploads/maker/draft/{{$detail_pengajuan->filename_sip}}.pdf" data-nama="{{$detail_pengaju->nama}}" data-role="{{Auth::user()->role}}">Lihat Draft SIP</button>

                                @elseif ($role == 'verifptsp')

                                    @if ($detail_pengajuan->isverif == '0')

                                        <div class="card-footer" id="setujuptspnya">
                                            <button class="btn btn-info" id="setujuptsp" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-salinan="{{$salinan}}" data-perubahan="{{$detail_pengajuan->perubahan}}" data-verif="1">Setujui</button>

                                            <!--<a class="btn btn-info" href="{{ route ('draft.persetujuan.sip', $id_pengajuan) }}">Setujui</a>-->

                                            <button class="btn btn-danger" id="tolakpengajuan" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-salinan="{{$salinan}}" data-perubahan="{{$detail_pengajuan->perubahan}}" data-urlqr="{{$detail_pengaju->url_qr}}" data-template="{{$detail_pengajuan->template_id}}">Tolak</button>

                                        </div>
                                    @else

                                        <button class="btn btn-info lihatsipasoka" id="lihatdraftsipasoka" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-file="{{$surat_host}}assets/uploads/maker/draft/{{$detail_pengajuan->filename_sip}}.pdf" data-nama="{{$detail_pengaju->nama}}" data-role="{{Auth::user()->role}}">Lihat Draft SIP</button>

                                    @endif

                                @else

                                    @if($role != 'kaptsp')
                                        @if($detail_pengajuan->isverif == '1')

                                            <div class="card-footer" id="setujudinkes">
                                                <div class="alert alert-success alert-dismissible">
                                                    <h5><i class="icon fas fa-check"></i> e-SIP Dalam Proses Tanda Tangan</h5>
                                                    e-SIP yang anda ajukan sedang dalam proses Tanda Tangan Elektronik Oleh Kepala DPMPTSP
                                                </div>
                                            </div>
                                        @else

                                            <div class="card-footer" id="setujudinkes">
                                                <div class="alert alert-success alert-dismissible">
                                                    <h5><i class="icon fas fa-check"></i> e-SIP Dalam Proses Review Verifikator DPMPTSP</h5>
                                                    e-SIP yang anda ajukan sedang dalam proses Review Oleh Verifikator DPMPTSP
                                                </div>
                                            </div>

                                        @endif

                                    @endif

                                @endif

                            @elseif ($detail_pengajuan->isApproved == '4')

                                @if($detail_pengajuan->template_id == '2')

                                    @if($detail_pengajuan->ditahan == '0')


                                        @if($role == 'adminptsp')

                                        <div class="card-footer" id="setujudinkes">
                                        
                                            <a class="btn btn-success penyerahansip" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" href="{{route('kumpul.str.asli', $id_pengajuan)}}">Penyerahan STR Asli</a>
                                        
                                        
                                        </div>


                                        @elseif ($role == 'nakes')

                                        <div class="card-footer" id="setujudinkes">

                                            <div class="alert alert-success alert-dismissible">
                                                <h5><i class="icon fas fa-check"></i> e-SIP Sudah Disetujui!</h5>
                                                Silahkan Registrasikan STR Asli Anda Ke DPMPTSP Cilacap Untuk Proses Selanjutnya
                                            </div>

                                        </div>

                                        @endif
                                    
                                    @else

                                        <a class="btn btn-success lihatsipasoka" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" href="{{$surat_host}}assets/uploads/maker/approved/{{$detail_pengajuan->filename_sip}}.pdf" target="_blank">Lihat SIP</a>

                                    @endif

                                @else

                                    <a class="btn btn-success lihatsipasoka" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" href="{{$surat_host}}assets/uploads/maker/approved/{{$detail_pengajuan->filename_sip}}.pdf" target="_blank">Lihat SIP</a>

                                @endif

                            

                            @elseif ($detail_pengajuan->isApproved == 'C')
                                @if ($role != 'nakes' && $role != 'op' && $role != 'bidfarmasidinkes')
                                    <div class="card-footer" id="setujudinkes">
                                        <div class="btn-group" role="group" aria-label="Aksi Pencabutan">
                                            <button class="btn btn-success lihatsipasoka" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}"  href="{{$surat_host}}assets/uploads/maker/approved/{{$detail_pengajuan->filename_sip}}.pdf" target="_blank">Lihat SIP</button>

                                            <button class="btn btn-danger setujucabut" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-updater="{{$user_id}}" data-alasan="{{$detail_pengajuan->alasan}}">Setujui Pencabutan</button>

                                            <button class="btn btn-warning tolakcabut" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-updater="{{$user_id}}" data-alasan="{{$detail_pengajuan->alasan}}">Tolak</button>
                                        </div>
                                    </div>
                                @elseif ($role == 'bidfarmasidinkes')
                                    <div class="card-footer" id="setujubidfar">
                                        <div class="btn-group" role="group" aria-label="Aksi Pencabutan">
                                            <button class="btn btn-sm btn-danger aksibidfar" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-updater="{{$user_id}}" data-alasan="{{$detail_pengajuan->alasan}}" data-role="{{$role}}" data-jenis = "1">Setujui Pencabutan</button>
                                            <button class="btn btn-sm btn-warning aksibidfar" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-updater="{{$user_id}}" data-alasan="{{$detail_pengajuan->alasan}}" data-role="{{$role}}" data-jenis = "2">Tolak</button>
                                            <button class="btn btn-sm btn-primary aksibidfar" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-updater="{{$user_id}}" data-alasan="{{$detail_pengajuan->alasan}}" data-role="{{$role}}" data-jenis = "3">Ubah Dokumen</button>
                                        </div>
                                    </div>

                                @else
                                    <div class="card-footer" id="setujudinkes">
                                        <div class="alert alert-success alert-dismissible">
                                            <h5><i class="icon fas fa-check"></i> Pencabutan e-SIP Sedang Direview</h5>
                                        </div>
                                    </div>

                                @endif

                            @elseif ($detail_pengajuan->isApproved == 'CF')

                                @if($role == 'kaptsp')

                                <div class="card-footer">
                                    <button class="btn btn-info" id="setujukaptsp" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-isfaskes = "{{$detail_pengajuan->isFaskes}}" data-surat = "{{$surat_host}}" data-filename="{{$detail_pengajuan->filename_pencabutan}}" data-user="{{$user_id}}" data-cabut = '1'>Setujui</button>
                                    <button class="btn btn-success lihatsipasoka" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" href="{{$surat_host}}assets/uploads/maker/approved/{{$detail_pengajuan->filename_sip}}.pdf" target="_blank">Lihat SIP</button>
                                </div>

                                @else

                                <button class="btn btn-success lihatsipasoka" id="" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" href="{{$surat_host}}assets/uploads/maker/approved/{{$detail_pengajuan->filename_sip}}.pdf" target="_blank">Lihat SIP</button>
                                @endif


                            @endif

                            @if($detail_pengajuan->isApproved == '1K' && $role == 'kadinkes')
                                <div class="card-footer">
                                    <button class="btn btn-info" id="setujukadinkes" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-isfaskes = "{{$detail_pengajuan->isFaskes}}">Setujui</button>
                                    
                                    <button class="btn btn-danger" id="tolakpengajuan" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-salinan="{{$salinan}}" data-perubahan="{{$detail_pengajuan->perubahan}}" data-urlqr="{{$detail_pengaju->url_qr}}" data-template="{{$detail_pengajuan->template_id}}">Tolak</button>
                                </div>

                            @endif

                            @if($detail_pengajuan->isApproved == '3' && $role == 'kaptsp')
                                <div class="card-footer">
                                    <button class="btn btn-info" id="setujukaptsp" data-id="{{$id_pengajuan}}" data-nakes="{{$id_nakes}}" data-visitasi = "{{$detail_pengajuan->tgl_visitasi}}" data-today="{{date('Y-m-d')}}" data-salinan="{{$salinan}}" data-isfaskes = "{{$detail_pengajuan->isFaskes}}" data-surat = "{{$surat_host}}" data-filename="{{$detail_pengajuan->filename_sip}}" data-user="{{$user_id}}">Setujui</button>
                                </div>
                            @endif
                  
                        <div class="overlay" id="lagisubmitdraft" style="display:none">
                            <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                        </div>
                    </div>
                    @if($role == 'adminptsp' || $role == 'admindinkes' || $role == 'kadinkes' || $role == 'verifptsp' || $role == 'kaptsp')
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#histori" data-toggle="tab">Histori</a></li>
                            <li class="nav-item"><a class="nav-link" href="#sejawat" data-toggle="tab">Sejawat</a></li>
                            <li class="nav-item"><a class="nav-link" href="#nearby" data-toggle="tab">Nakes Sekitar</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="histori">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-body table-responsive p-0" style="height: 300px;">
                                                    <table class="table table-head-fixed text-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Updater</th>
                                                                <th>Tanggal</th>
                                                                <th>Nama Faskes</th>
                                                                <th>Keterangan</th>
                                                                <th>Alasan Ditolak</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($histori_pengajuan as $histori)
                                                            <tr>
                                                                <td>{{$histori->pelaku}}</td>
                                                                <td>{{$histori->updated_at}}</td>
                                                                <td>@if($histori->nama_faskes == '0') Mandiri @else {{$histori->nama_faskes}} @endif</td>
                                                                <td>@if($histori->isApproved == '9')
                                                                <div class="alert alert-danger alert-dismissible">
                                                                    {{$histori->tracker}}
                                                                </div>
                                                                @else
                                                                {{$histori->tracker}}
                                                                @endif</td>
                                                                <td>{{$histori->alasan_ditolak}}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane" id="sejawat">
                                    @if(count($sejawat) > 0)
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive p-0" style="height: 300px;">
                                                <table class="table table-head-fixed text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Foto</th>
                                                            <th>Nama Nakes</th>
                                                            <th>No Registrasi</th>
                                                            <th>Str Hingga</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($sejawat as $sj)
                                                        <tr>
                                                            <td>{{$loop->iteration}}</td>
                                                            <td><img src="{{ URL::to('/storagefoto')}}/{{$sj->saved_photo}}" width="50px" alt="user image"></td>
                                                            <td><a class="toprofilingnakes" href="#tbllistperubahan" data-id="{{$sj->id}}">{{$sj->nama}}</a></td>
                                                            <td>{{$sj->no_reg}}</td>
                                                            <td>{{$sj->str_hingga}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <div class="tab-pane" id="nearby">
                                    @if(count($sejawat) > 0)
                                    <div class="row">
                                        <div class="col-12">
                                            
                                            <div class="table-responsive" style="height: 300px;" id="nakessekitar">
                                                <table class="table table-head-fixed">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Foto</th>
                                                            <th>Nama Nakes</th>
                                                            <th>Profesi</th>
                                                            <th>Jarak</th>
                                                            <th>Nama Faskes</th>
                                                            <th>Alamat Pengajuan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="nakessekitarbody">
                                                    
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
@section('js')
@endsection

@section('script')
<script>
    $(document).ready(function() {

        var iframe = $('#framestrvalid');

        // Set the iframe source asynchronously
        iframe.on('load', function () {
            // Add custom behavior when the iframe loads, if needed
            console.log('Iframe content loaded.');
        });

        // Delay setting the src until the page loads
        iframe.attr('src', "{{ str_replace('http://', 'https://', $str->url_qr) }}");

        
        if($('#checkskskp').length) {
            var istigasatu = $('#checkskskp').val()
            if (istigasatu.indexOf('skp.kemkes') !== -1) {
                $('.cektigasatu').prop('disabled', true)
            } else {
                $('.cektigasatu').prop('disabled', false)
            }
        }
        

        $('#setujukadinkes').click(function(){
            var id_pengajuan = $(this).attr('data-id')
            var id_nakes = $(this).attr('data-nakes')
            var tgl_visitasi = $(this).attr('data-visitasi')
            var salinan = $(this).attr('data-salinan')

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '{{ route("submit.draft.kadinkes")}}',
                data: {'id_pengajuan': id_pengajuan, 'id_nakes': id_nakes, _token: "{{ csrf_token() }}"},
                dataType: 'json',
                beforeSend: function(){

                    $.fancybox.open({
                        src: '#modal-tunggukadinkes-content',
                        type: 'inline',
                        touch: false,
                        modal: true,
                        clickSlide: false
                    });

                },
                success: function(data){
                    console.log(data)
                    $.fancybox.close();
                    if(data.success == true) {
                        var url = data.surathost
                        var filename = data.filename
                        var nik = data.nik
                        let numdum = Math.floor(Math.random() * 10000) + 1;
                        $('#lihatdraftdinkes').attr('href', url+filename+'.pdf?dummy='+numdum)
                        $('#viewdraftskdinkes').attr('src',url+filename+'.pdf?dummy='+numdum)
                        $('#filename_tte').val(filename)
                        $('#nik_tte').val(nik)
                        $.fancybox.open({
                            src: '#modal-draftkadinkes-content',
                            type: 'inline',
                            touch: false,
                            modal: true,
                            clickSlide: false,
                            afterShow: function() {
                                $('.tutupintipdraftdinkes').click(function() {
                                    $.fancybox.close();
                                });
                            }
                        });
                    } else {
                        Swal.fire(data.hasilnya)
                    }
                },
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });

        })

        $('#setujukaptsp').click(function(){
            var id_pengajuan = $(this).attr('data-id')
            var id_nakes = $(this).attr('data-nakes')
            var tgl_visitasi = $(this).attr('data-visitasi')
            var salinan = $(this).attr('data-salinan')
            var url = $(this).attr('data-surat')
            var filename = $(this).attr('data-filename')
            var id_user = $(this).attr('data-user')
            var iscabut = $(this).attr('data-cabut')
            $('#lihatdraftkadin').attr('href', url+'assets/uploads/maker/draft/'+filename+'.pdf')
            $('#viewdraftkadin').attr('src', url+'assets/uploads/maker/draft/'+filename+'.pdf')
            $('#filename_tte_kadin').val(filename)
            $('#id_tte_kadin').val(id_user)
            if(iscabut == '1') {
                $('#iscabut_tte_kadin').val(iscabut)
            } else {
                $('#iscabut_tte_kadin').val('0')
            }

            $.fancybox.open({
                src: '#modal-draftkadin-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('.tutupintipdraftkadin').click(function() {
                        $.fancybox.close();
                    });
                }
            });

        })


        $('#submitttekadinkes').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route ('submit.tte.kadinkes') }}`;
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
                    //$('#btnsubmittte').attr('disabled', true)
                    $('#sedangttekadinkes').show()
                },
                success: function (data) {
                    console.log(data)
                    $('#sedangttekadinkes').hide()
                    //$('#btnsubmittte').attr('disabled', false)
                    if(data.success == true) {
                        $.fancybox.close();
                        Swal.fire(data.keterangan).then(function() {
                            window.location.href = "{{ route('kadinkes.main.dashboard')}}";
                        });
                        
                    } else {
                        $.fancybox.close();
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

        $('#submitttekadin').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route ('submit.tte.kadin') }}`;
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
                    //$('#btnsubmittte').attr('disabled', true)
                    $('#sedangttekadin').show()
                },
                success: function (data) {
                    console.log(data)
                    $('#sedangttekadin').hide()
                    //$('#btnsubmittte').attr('disabled', false)
                    if(data.success == true) {
                        $.fancybox.close();
                        Swal.fire(data.keterangan).then(function() {
                            window.location.href = "{{ route('kaptsp.main.dashboard')}}";
                            //window.location.reload();
                        });
                        
                    } else {
                        $.fancybox.close();
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

        var template_id = '{{$detail_pengajuan->template_id}}'
        if(template_id == 3 || template_id == 4) {
            $('#ePengajuTemplateSIP').val(template_id)
        }
        var isPerubahanKe = $('#isPerubahanKe').val()
        var id_pengajuan = $('#vIDPengajuan').val()
        if(isPerubahanKe > 0) {
            var perubahanbefore = isPerubahanKe - 1

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.esip.before")}}',
                data: {'id_pengajuan': id_pengajuan, 'perubahanbefore': perubahanbefore, _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function(data){
                    console.log(data)

                    if(data.success == true) {

                        var hasilsource = "";
                        var parent = $('#esipsebelumnya').parent();
                        var newElement = "<embed src='"+data.surat_url+"assets/uploads/maker/approved/"+data.sip_sebelumnya.filename_sip+".pdf' id='esipsebelumnya' width='100%' height='400px'>";
                        $('#esipsebelumnya').remove();
                        parent.append(newElement);

                    }

                    
                },
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });
        }

        $("#ePengajuNama").focusout(function(){
            var nama_sip = $(this).val().toUpperCase()
            var nama_str = $('#ePengajuNamaSTR').val().toUpperCase()
            if(nama_sip.includes(nama_str)) {
                $(this).removeClass("is-invalid");
                $(this).addClass("is-valid");
            } else {
                $(this).removeClass("is-valid");
                $(this).addClass("is-invalid");
            }
        });

        if($("#ePengajuNama").length) {

            var nama_sip = $('#ePengajuNama').val().toUpperCase()
            var nama_str = $('#ePengajuNamaSTR').val().toUpperCase()
            if(nama_sip.includes(nama_str)) {
                $('#ePengajuNama').removeClass("is-invalid");
                $('#ePengajuNama').addClass("is-valid");
            } else {
                $('#ePengajuNama').removeClass("is-valid");
                $('#ePengajuNama').addClass("is-invalid");
            }

        }

        if($('#nakessekitar').length && $('#tLat').val() != '' && $('#tLong').val() != '') {

            var lat = $('#tLat').val()
            var longi = $('#tLong').val()
            var isFaskes = $('#kekanan').attr('data-isfaskes')
            var jenis_profesi = $('#kekanan').attr('data-jenisprofesi')

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.nakes.sekitar")}}',
                data: {'longitude': longi, 'latitude': lat, 'distance' : 250, 'jenis_profesi' : jenis_profesi, 'isFaskes' : isFaskes, _token: "{{ csrf_token() }}"},
                async: false,
                dataType: 'json',
                success: function(data){
                    
                    if(data.success == true) {

                        var lokasialert = ''
                        html = ''
                        if(data.result.length > 0) {
                            for(i = 0; i < data.result.length; i++) {
                                if(data.result[i].nama_faskes == '0') {
                                    var nama_faskes = 'Mandiri'
                                } else {
                                    var nama_faskes = data.result[i].nama_faskes;
                                }
                                var fotoUrl = "{{ URL::to('/storagefoto')}}/" + data.result[i].saved_photo;
                                html += '<tr><td>'+(i + 1)+'</td><td><img src="'+fotoUrl+'" width="50px" alt="user image"></td><td><a class="toprofilingnakes" href="#nakessekitar" data-id="'+data.result[i].id_user+'">'+data.result[i].name+'</a></td><td>'+data.result[i].profesi+'</td><td>'+data.result[i].distance+' M</td><td>'+nama_faskes+'</td><td>'+data.result[i].alamat_pengajuan+'</td></tr>';
                                lokasialert +=`
                                    <li>Nakes : ${data.result[i].name} Berpraktik Mandiri Dengan Jarak : ${data.result[i].distance} meter dari lokasi pengajuan</li>
                                `
                            }
                            
                        }
                        $('#nakessekitarbody').html(html)
                        if(isFaskes == 0 && data.result.length > 0)
                        {

                            var id_pengajuan = $('#kekanan').attr('data-idpeng');
                            var id_nakes = $('#kekanan').attr('data-nakes');
                            var salinan = $('#kekanan').attr('data-salinan');
                            var url_qr = $('#kekanan').attr('data-urlqr');
                            var template_id = $('#kekanan').attr('data-template');
                            if(url_qr == 'manual') {
                                $('#isfotonakes').show();
                            } else {
                                $('#isfotonakes').hide();
                            }
                            if(template_id == '3' || template_id == '4') {
                                $('#istemplate').show()
                            } else {
                                $('#istemplate').hide()
                            }
                            $('#tolakModal').modal('show');
                            $('#btnSubmitSetujutolak').show()
                            $('#tid_pengajuant').val(id_pengajuan);
                            $('#tid_nakest').val(id_nakes);
                            $('#tolak_salinan').val(salinan);
                            $('#isRejLokasiF').prop('checked', true)
                            $('#rejKeteranganLokasi').val('Ada '+data.result.length+' Nakes Yang Berdekatan Membuka Praktik Mandiri Di Sekitar Lokasi Praktik')
                            $('.checkmandirisekitar').show()
                            $('.checkmandirisekitar').html('<div class="alert alert-danger alert-dismissible"><h5><i class="icon fas fa-ban"></i> Mohon Periksa!</h5>'+lokasialert+'</ul></div>')

                        }
                    }

                },
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });
        }

        $('#sipsebelumesip').click(function(){
            var id_pengajuan = $(this).attr('data-id')
            var id_nakes = $(this).attr('data-nakes')
            var salinan = $(this).attr('data-salinan')
            $('#tUserIdBeforeSip').val(id_nakes)

            $.fancybox.open({
                src: '#modal-sipsebelumesip-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('.tutupsipsebelumsip').click(function() {
                        $.fancybox.close();
                    });
                }
            });

        })

        $('#submitsipsebelumesip').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route ('submit.sipbefore.esip') }}`;
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
                    //$('#btnsubmittte').attr('disabled', true)
                    $('#sedangupdatebeforesip').show()
                },
                success: function (data) {
                    console.log(data)
                    $('#sedangupdatebeforesip').hide()
                    //$('#btnsubmittte').attr('disabled', false)
                    if(data.success == true) {
                        $.fancybox.close();
                        Swal.fire(data.keterangan).then(function() {
                            window.location.reload();
                        });
                        
                    } else {
                        $.fancybox.close();
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

        $('#cekskp').click(function(){
            var input = document.getElementById('niktosearch');
            input.select();
            document.execCommand('copy');
            $.fancybox.open({
                src: '#modal-cekskp-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('.tutupcekskp').click(function() {
                        $.fancybox.close();
                    });
                }
            });
        });

        $('#cekkecukupan').on('click', function () {
            let filename = $('#kecukupansearch').val()
            // Get the value from the input field
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("getcekkecukupan")}}',
                data: {'filename' : filename,  _token: "{{ csrf_token() }}"},
                //async: false,
                dataType: 'json',
                success: function(response){
                    if(response.success == true) {

                        var link = response.thelink
                        window.open(link, '_blank');
                        
                    } else {
                        Swal.fire('Gagal Cek Sertifikat');
                    }
                }
            });
        });


        $('#ceksatusehat').on('click', function () {
            // Get the value from the input field
            let id = $('#satusehatsearch').val();
            
            // Set the iframe src dynamically
            $('#satusehat-iframe').attr('src', `https://satusehat.kemkes.go.id/sdmk/nakes/${id}`);

            $('#oint').data('url', `https://satusehat.kemkes.go.id/sdmk/nakes/${id}`);

            
            // Open the modal using Fancybox
            $.fancybox.open({
                src: '#modal-lihatsatusehat-content', // Modal ID
                type: 'inline',
                touch: false,
                modal: false, // Allows closing the modal when clicking outside
                clickSlide: false, // Prevents closing on slide click
                clickOutside: true, // Enable closing when clicking outside
            });

            $('#oint').on('click', function () {
                let url = $(this).data('url');
                window.open(url, '_blank');
            });
        });

        $('#addJadwalPraktik').on('click', function(){
            var id_pengajuan = $(this).attr('data-id')
            var id_nakes = $(this).attr('data-nakes')
            var salinan = $(this).attr('data-salinan')
            var id_doc = $(this).attr('data-doc')
            
            $.fancybox.open({
                src: '#modal-ubahjadwal-content', // Modal ID
                type: 'inline',
                touch: false,
                modal: false, // Allows closing the modal when clicking outside
                clickSlide: false, // Prevents closing on slide click
                clickOutside: true, // Enable closing when clicking outside
            });
        })

        function applyScheduleFromAI(summary) {
            const hariMap = {
                "senin": 1,
                "selasa": 2,
                "rabu": 3,
                "kamis": 4,
                "jumat": 5,
                "sabtu": 6,
                "minggu": 7
            };

            for (let i = 1; i <= 7; i++) {
                $(`#phari_${i}`).prop('checked', false);
                $(`#jam_${i}`).hide();
                $(`#start_${i}`).val('');
                $(`#end_${i}`).val('');
                $(`#isuraian_${i}`).hide().val('');
                $(`#isshift_${i}`).hide().prop('checked', false);
            }

            summary.forEach(entry => {
                const index = hariMap[entry.day?.toLowerCase()];
                if (!index) return;

                $(`#phari_${index}`).prop('checked', true);
                $(`#jam_${index}`).show();
                $(`#start_${index}`).val(entry.start);
                $(`#end_${index}`).val(entry.end);
                $(`#isuraian_${index}`).show().val(entry.uraian || '');
                $(`#isshift_${index}`).show().prop('checked', !!entry.isshift);
            });
        }


        $('#generateprompt').on('click', function(){
            var prompt = $('#tprompt').val()

            $.ajax({
                method: 'POST',
                url: '{{ route("get.summaryjadwal") }}',
                data: JSON.stringify({
                    prompt: prompt, // <--- flatten the data structure
                    _token: "{{ csrf_token() }}"
                }),
                contentType: 'application/json', // Important: send as JSON
                processData: false,              // Don't process as form
                dataType: 'json',

                beforeSend: function() {

                    $('#tunggujadwal').show()
                    
                },

                success: function(data) {
                    $('#tunggujadwal').hide()

                    if (data.success && Array.isArray(data.summary)) {
                        applyScheduleFromAI(data.summary); // Pass the array directly
                    } else {
                        alert("Gagal memproses jadwal. Silahkan Isikan Secara Manual.");
                        console.log(data); // Optional: help debug
                    }
                    
            
                },

                error: function(request, status, error) {
                    $('#tunggujadwal').hide()
                    alert(request.responseText);
                }
            });

        })

        $('#simpanjadwalnakesadmin').click(function(){
            var id_pengajuan = $('#jidpengajuan').val()
            var id_doc = $('#jiddoc').val()
            var salinan = $('#jsalinan').val()
            var id_user = $('#jidnakes').val()
            var istolak = 0
            var countisset = 0;

            jadwaldata = []
            for (i=0; i < 7; i++) {

                var urutan = i+1;
                var isnextday = 0
                var isset_ = $('#phari_'+urutan).is(':checked')
                if(isset_ == true) {
                    var isset = 1
                    $('#isuraian_'+urutan).show()
                    countisset++
                }else{ var isset = 0}
                var mulai = $('#start_'+urutan).val()
                var selesai = $('#end_'+urutan).val()
                var isshift_ = $('#isshift_'+urutan).is(':checked')
                if(isshift_ == true){
                    var isshift = 1
                }else{ var isshift = 0}
                var waktumulai = mulai.split(":")
                var jammulai = parseInt(waktumulai[0])*60
                var menitmulai = parseInt(waktumulai[1])
                var rmulai = jammulai + menitmulai

                var waktuselesai = selesai.split(":")
                var jamselesai = parseInt(waktuselesai[0])*60;
                var menitselesai = parseInt(waktuselesai[1]);
                var rselesai = jamselesai + menitselesai;
                
                var uraian = $('#isuraian_'+urutan).val()

                if (rmulai > rselesai) {
                    isnextday = 1
                }

                var record = '{ "urutan" : "'+urutan+'", "isSet" : "'+isset+'", "mulai" : "'+mulai+'", "selesai" : "'+selesai+'", "rmulai" : "'+rmulai+'", "rselesai" : "'+rselesai+'", "is_shift" : "'+isshift+'", "isnextday" : "'+isnextday+'", "uraian" : "'+uraian+'"}'
                jadwaldata.push(record)
            }

            var submitdata = {};
                submitdata.isadmin = 1;
                submitdata.id_pengajuan = id_pengajuan;
                submitdata.id_user = id_user;
                submitdata.id_doc = id_doc;
                submitdata.salinan = salinan;
                submitdata.istolak = istolak;
                submitdata.jadwal = jadwaldata;


            if(countisset == 0) {
                Swal.fire('Anda Belum Mengisikan Jadwal')
            } else {

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: '{{ route("submit.jadwaldetailpraktek")}}',
                    data: {'submitdata' : submitdata,  _token: "{{ csrf_token() }}"},
                    //async: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#tunggujadwal').show()

                    },
                    success: function(response){
                        if(response.success == true) {
                            Swal.fire(response.keterangan).then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire(response.keterangan);
                        }
                        $.fancybox.close();
                    },
                    complete: function(){
                        $.fancybox.close()
                    },
                    error: function(request, status, error){
                        $.fancybox.close()
                        alert(request.responseText);
                    }
                });

            }
        })

        

    });
</script>

@endsection

