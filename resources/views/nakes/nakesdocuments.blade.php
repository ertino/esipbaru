@extends('layouts.adminlte4.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang Di e-SIP Kabupaten Cilacap</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div id="modal-doctunggu-content" style="display: none;">
                    <center>
                    <i class="fas fa-hourglass"></i>
                    <h5>Mohon Tunggu..</h5>
                    </center>
                </div>
            </div>
            <div class="row">
                <div id="modal-tambahijazah-content" style="display: none; width: 800px; max-width: 90%; max-height: 80vh;">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                Form Tambah Data Pendidikan
                            </div>
                            <div class="card-tools">
                                <button class="btn btn-tools tutuptambahijazah">x</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                                     
                                    <form enctype="multipart/form-data" id="formtambahpendidikan" action="{{route('simpan.ijazahlain.nakes')}}" method="post" class="form-horizontal">
                                    @csrf
                                        <div class="row">
                  
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">No Dokumen</label>
                                                    <input type="text" id="tNoDocument" name="tNoDocument" class="form-control">
                                                </div>
                                            </div>
                        
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Dokumen</label>
                                                    <input type="date" id="tTglDocument" name="tTglDocument" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tanggal Berlaku</label>
                                                    <input type="date" id="tTglBerlaku" name="tTglBerlaku" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" id="untukijazah">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Universitas</label>
                                                    <input type="text" id="tUniversitas" name="tUniversitas" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Strata</label>
                                                    <input type="text" id="tStrata" name="tStrata" class="form-control" required>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="ms-0">Prodi</label>
                                                    <input type="text" id="tProdi" name="tProdi" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Tahun Lulus</label>
                                                    <input type="number" id="tthlulus" name="tthlulus" class="form-control" required>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row toevent">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect1" class="ms-0">Lampiran Dokumen</label>
                                                    <input type="file" id="tFileDoc" name="tFileDoc" class="form-control" accept=".pdf" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="display:none">
                                                <div class="input-group input-group-static mb-4">
                                                    <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                    <input type="text" id="tUser_id" name="tUser_id" value="{{$user_id}}" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success" id="btnsimpanijazahlain" data-id="{{$user_id}}">Simpan</button>
                                    </form> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="tambahKTPModal">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title" id="judultambahnya">Tambah Dokumen</h4>
                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                        <!-- Modal body -->
                            <div class="modal-body">
                                <div class="alert alert-info alert-dismissible">
                                    <h5><i class="icon fas fa-info"></i> Perhatian!</h5>
                                    Nama yang Anda Submit Adalah Nama Yang Akan Muncul Pada e-SIP. Silahkan Isikan Sesuai Dengan Gelar Yang Anda Peroleh. Perhatikan Juga Huruf Kapital <i>(uppercase dan lowercase)</i>
                                </div>
                                <form id="formtbhktp" class="form-horizontal">
                                @csrf
                                    <div class="row" style="display:none">
                                    
                                        <div class="col-md-6" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Jenis Doc</label>
                                                <input type="text" id="tJenisDoc" name="tJenisDoc" class="form-control" value="KTP" >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Judul Doc</label>
                                                <input type="text" id="ktpUploader" name="ktpUploader" value="{{$user_id}}" class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">isEdit</label>
                                                <input type="text" id="isEditKTP" name="isEditKTP" value="0" class="form-control" >
                                            </div>
                                        </div>

                                        <div class="col-md-3" style="display:none">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Filename</label>
                                                <input type="text" id="ktpTemplateId" name="ktpTemplateId"  class="form-control" value="{{$template_id}}">
                                            </div>
                                        </div>
                                        

                                    </div>     
                                    <div class="row">
                                        <div class="col-md-6" >
                                            <div class="form-group">
                                                <div class="autocomplete">
                                                <label for="exampleFormControlSelect1" class="ms-0">Nama *</label>
                                                <input type="text" id="ktpNAMA" name="ktpNAMA" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Nomor KTP *</label>
                                                <input type="text" id="ktpNOMOR" name="ktpNOMOR" class="form-control" placeholder="3312XXXXXXXXXXX" required>
                                            </div>
                                        </div>

                                    </div>  
                                    <div class="row">
                                        <div class="col-md-6" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Tempat Lahir *</label>
                                                <input type="text" id="ktpTTL" name="ktpTTL" class="form-control" required placeholder="Cilacap">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Tanggal Lahir</label>
                                                <input type="date" id="ktpTanggalLahir" name="ktpTanggalLahir" class="form-control" required>
                                            </div>
                                        </div>

                                    </div>  

                                    <div class="row">
                                        <div class="col-md-6" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Alamat KTP *</label>
                                                <textarea type="text" id="ktpALAMAT" name="ktpALAMAT" class="form-control" required></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Kabupaten / Kota</label>
                                                <input type="text" id="ktpKabupaten" name="ktpKabupaten" class="form-control" placeholder="Kabupaten Cilacap">
                                            </div>
                                        </div>

                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                <input type="text" id="ktpKecamatan" name="ktpKecamatan" class="form-control" placeholder ="Cilacap">
                                            </div>
                                        </div>
                                    </div> 


                                    <div class="row">
                                        <div class="col-md-6" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Alamat Domisili</label>&nbsp; &nbsp;<input type="checkbox" id="ifdom" name="ifdom" value="1"/> (Sesuai KTP)
                                                <input type="text" id="ktpALAMATDom" name="ktpALAMATDom" class="form-control domisilih"required >
                                            </div>
                                        </div>

                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                                                <input type="text" id="ktpKecamatanDom" name="ktpKecamatanDom" class="form-control domisilih">
                                            </div>
                                        </div>

                                        <div class="col-md-3" >
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                                                <input type="text" id="ktpKabupatenDom" name="ktpKabupatenDom" class="form-control domisilih">
                                            </div>
                                        </div>

                                    </div> 

                                    <hr />
                                    <p> Pastikan Data Diri Yang Anda Submit Sudah Sesuai Karena Akan Berpengaruh Pada SIP Yang Dicetak. Dengan Ini Saya Bertanggung Jawab Penuh Dengan Apa Yang Saya Unggah dan Submit.</p>
                                    <input type="checkbox" required /> Setuju
                                    <hr /> 

                                    <button type="submit" id="submitanktp" class="btn btn-success">Submit</button>

                                    
                                </form>

                                
                            </div>

                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h4 class="card-title">Dokumen Perizinan Nakes</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                            @if($detail_pengaju->origin_file != 'scanned')
                                @if($isKadaluarsa->kadaluarsa == '0')
                                    <div class="col-sm-4 col-xs-12">
                                    @if (count($doc_str1) == 0)
                                        <div class="thumbnail">
                                            <center><div class="position-relative">
                                            @if($detail_pengaju->template_id == '2')<a href='{{route("nakes.dokter.uploadstr", "$user_id")}}_1'>
                                            @else <a href='{{route("nakes.pakai.idlestr", "$user_id")}}_1'>
                                            @endif
                                            
                                                <i class="fa fa-plus" id="tambah_jenis1" style="font-size:150px" data-jenis="STR1"  data-judul="STR1" ></i>
                                            </a>
                                            </div></center>

                                            <div class="caption card-footer text-center">
                                                <ul class="list-inline">
                                                <li><i class="people lighter"></i>&nbsp;Silahkan Upload STR Lembar 1</li>
                                                <li></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        
                                        <div class="thumbnail">
                                            <div @if($doc_str1[0]->is_compromised == '1') class="card mb-2 bg-gradient-dark" @else class="image view view-first" @endif>
                                                <img style="width: 100%; display: block;" src="{{ asset('images/docs/STR1.png')}}" alt="image" @if($doc_str1[0]->is_compromised == '1') class="card-img-top border border-danger" @endif>
                                                @if($doc_str1[0]->is_compromised == '1')
                                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                    <h5 class="card-title text-danger text-white"><b>UPLOAD ULANG!</b></h5>
                                                    <p class="card-text text-white pb-2 pt-1">Keterangan : {{$doc_str1[0]->keterangan_tolak}}</p>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="mask">
                                                <p></p>
                                                @if($doc_str1[0]->url_qr == 'manual' && $doc_str1[0]->template_id == '2')

                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Scan QRCODE STR ANDA!</h5>
                                                        Untuk Dapat Mengunmpulkan STR Salinan Anda Dan Mendapatkan Akses Ke e-SIP yang telah disetujui, harap scan <a href="{{route('update.qrcode.nakes', 1)}}">DISINI!</a>
                                                    </div>

                                                @endif
                                                <div class="tools tools-bottom">
                                                    <p><a href="{{ route('get.origin.str', $doc_str1[0]->namafile.'.pdf') }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                    <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="str" data-namafile="{{$doc_str1[0]->namafile}}">Lihat</button>
                                                    @if($doc_str1[0]->is_compromised == '1')
                                                        <a class="btn btn-sm btn-primary editSTR" href="{{route('edit.dokumen.nakes' , $user_id)}}_STR_1">Edit</a>
                                                    @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    </div>

                                    <div class="col-sm-4 col-xs-12">
                                    @if (count($doc_str2) == 0)
                                        <div class="thumbnail">
                                            <center><div class="position-relative">
                                            @if($detail_pengaju->template_id == '2')<a href='{{route("nakes.dokter.uploadstr", "$user_id")}}_2'>
                                            @else <a href='{{route("nakes.pakai.idlestr", "$user_id")}}_2'>
                                            @endif
                                                <i class="fa fa-plus" id="tambah_jenis1" style="font-size:150px" data-jenis="STR2" data-judul="STR2"></i>
                                            </a>
                                            </div></center>

                                            <div class="caption card-footer text-center">
                                                <ul class="list-inline">
                                                <li><i class="people lighter"></i>&nbsp;Silahkan Upload STR Lembar 2</li>
                                                <li></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        <div class="thumbnail">
                                            <div @if($doc_str2[0]->is_compromised == '1') class="card mb-2 bg-gradient-dark" @else class="image view view-first" @endif>
                                                <img style="width: 100%; display: block;" src="{{ asset('images/docs/STR2.png')}}" alt="image" @if($doc_str2[0]->is_compromised == '1') class="card-img-top border border-danger" @endif>
                                                @if($doc_str2[0]->is_compromised == '1')
                                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                    <h5 class="card-title text-danger text-white"><b>UPLOAD ULANG!</b></h5>
                                                    <p class="card-text text-white pb-2 pt-1">Keterangan : {{$doc_str2[0]->keterangan_tolak}}</p>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="mask">
                                                <p></p>
                                                @if($doc_str2[0]->url_qr == 'manual' && $doc_str2[0]->template_id == '2')

                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Scan QRCODE STR ANDA!</h5>
                                                        Untuk Dapat Mengunmpulkan STR Salinan Anda Dan Mendapatkan Akses Ke e-SIP yang telah disetujui, harap scan <a href="{{route('update.qrcode.nakes', 2)}}">DISINI!</a>
                                                    </div>

                                                @endif
                                                <div class="tools tools-bottom">
                                                    <p><a href="{{ route('get.origin.str', $doc_str2[0]->namafile.'.pdf') }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                    <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="str"  data-namafile="{{$doc_str2[0]->namafile}}">Lihat</button>
                                                    @if($doc_str2[0]->is_compromised == '1')
                                                        <a class="btn btn-sm btn-primary editSTR" href="{{route('edit.dokumen.nakes' , $user_id)}}_STR_2">Edit</a>
                                                    @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    </div>

                                    <div class="col-sm-4 col-xs-12">
                                    @if($template_id != '1')
                                        @if (count($doc_str3) == 0)
                                            <div class="thumbnail">
                                                <center><div class="position-relative">
                                                @if($detail_pengaju->template_id == '2')<a href='{{route("nakes.dokter.uploadstr", "$user_id")}}_3'>
                                                @else <a href='{{route("nakes.pakai.idlestr", "$user_id")}}_3'>
                                                @endif
                                                    <i class="fa fa-plus" id="tambah_jenis1" style="font-size:150px" data-jenis="STR3" data-judul="STR3" ></i>
                                                </a>
                                                </div></center>

                                                <div class="caption card-footer text-center">
                                                    <ul class="list-inline">
                                                    <li><i class="people lighter"></i>&nbsp;Silahkan Upload STR Lembar 3</li>
                                                    <li></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @else
                                            <div class="thumbnail">
                                                <div @if($doc_str3[0]->is_compromised == '1') class="card mb-2 bg-gradient-dark" @else class="image view view-first" @endif>
                                                    <img style="width: 100%; display: block;" src="{{ asset('images/docs/STR3.png')}}" alt="image" @if($doc_str3[0]->is_compromised == '1') class="card-img-top border border-danger" @endif>
                                                    @if($doc_str3[0]->is_compromised == '1')
                                                    <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                        <h5 class="card-title text-danger text-white"><b>UPLOAD ULANG!</b></h5>
                                                        <p class="card-text text-white pb-2 pt-1">Keterangan : {{$doc_str3[0]->keterangan_tolak}}</p>
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="mask">
                                                    <p></p>
                                                    @if($doc_str3[0]->url_qr == 'manual' && $doc_str3[0]->template_id == '2')

                                                        <div class="alert alert-danger alert-dismissible">
                                                            <h5><i class="icon fas fa-ban"></i> Scan QRCODE STR ANDA!</h5>
                                                            Untuk Dapat Mengunmpulkan STR Salinan Anda Dan Mendapatkan Akses Ke e-SIP yang telah disetujui, harap scan <a href="{{route('update.qrcode.nakes', 3)}}">DISINI!</a>
                                                        </div>

                                                    @endif
                                                    <div class="tools tools-bottom">
                                                        <p><a href="{{ route('get.origin.str', $doc_str3[0]->namafile.'.pdf') }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                        <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="str" data-namafile="{{$doc_str3[0]->namafile}}">Lihat</button>
                                                        @if($doc_str3[0]->is_compromised == '1')
                                                            <a class="btn btn-sm btn-primary editSTR" href="{{route('edit.dokumen.nakes' , $user_id)}}_STR_3">Edit</a>
                                                        @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    </div>
                                @else

                                    <div class="col-sm-4 col-xs-12">
                                        <div class="thumbnail">
                                            <center><div class="position-relative">
                                            <i class="fa fa-plus" id="update_jenis1" style="font-size:150px" data-jenis="STR1" data-bs-toggle="modal" data-judul="STR1" data-bs-target="#tambahModal"></i>
                                            </div></center>

                                            <div class="caption card-footer text-center">
                                                <ul class="list-inline">
                                                <li><i class="people lighter"></i>&nbsp;Silahkan Upload STR Telah Diperbaharui</li>
                                                <li></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                @endif
                            @else
                                <div class="col-sm-4 col-xs-12">
                                @if (count($doc_str1) == 0)
                                    <div class="thumbnail">
                                        <center><div class="position-relative">
                                        @if($detail_pengaju->template_id == '2')<a href='{{route("nakes.dokter.uploadstr", "$user_id")}}_1'>
                                        @else <a href='{{route("nakes.nondokter.uploadstr", "$user_id")}}_1'>
                                        @endif
                                            <i class="fa fa-plus" id="tambah_jenis1" style="font-size:150px" data-jenis="STR1"></i>
                                        </a>
                                        </div></center>

                                        <div class="caption card-footer text-center">
                                            <ul class="list-inline">
                                            <li><i class="people lighter"></i>&nbsp;Silahkan Upload STR Lembar 1</li>
                                            <li></li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="thumbnail">
                                        <div @if($doc_str1[0]->is_compromised == '1') class="card mb-2 bg-gradient-dark" @else class="image view view-first" @endif>
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs/STR1.png')}}" alt="image" @if($doc_str1[0]->is_compromised == '1') class="card-img-top border border-danger" @endif>
                                            @if($doc_str1[0]->is_compromised == '1')
                                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-danger text-white"><b>UPLOAD ULANG!</b></h5>
                                                <p class="card-text text-white pb-2 pt-1">Keterangan : {{$doc_str1[0]->keterangan_tolak}}</p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="mask">
                                            <p></p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('get.origin.str', $doc_str1[0]->namafile.'.pdf') }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="str" data-namafile="{{$doc_str1[0]->namafile}}">Lihat</button>
                                                @if($doc_str1[0]->is_compromised == '1')
                                                    <a class="btn btn-sm btn-primary editSTR" href="{{route('edit.dokumen.nakes' , $user_id)}}_STR_1">Edit</a>
                                                @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>

                                <div class="col-sm-4 col-xs-12">
                                @if (count($doc_str2) == 0)
                                    <div class="thumbnail">
                                        <center><div class="position-relative">
                                        @if($detail_pengaju->template_id == '2')<a href='{{route("nakes.dokter.uploadstr", "$user_id")}}_2'>
                                        @else <a href='{{route("nakes.nondokter.uploadstr", "$user_id")}}_2'>
                                        @endif
                                            <i class="fa fa-plus" id="tambah_jenis1" style="font-size:150px" data-jenis="STR2" data-bs-toggle="modal" data-judul="STR2" data-bs-target="#tambahModal"></i>
                                        </a>
                                        </div></center>

                                        <div class="caption card-footer text-center">
                                            <ul class="list-inline">
                                            <li><i class="people lighter"></i>&nbsp;Silahkan Upload STR Lembar 2</li>
                                            <li></li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="thumbnail">
                                        <div @if($doc_str2[0]->is_compromised == '1') class="card mb-2 bg-gradient-dark" @else class="image view view-first" @endif>
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs/STR2.png')}}" alt="image" @if($doc_str2[0]->is_compromised == '1') class="card-img-top border border-danger" @endif>
                                            @if($doc_str2[0]->is_compromised == '1')
                                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-danger text-white"><b>UPLOAD ULANG!</b></h5>
                                                <p class="card-text text-white pb-2 pt-1">Keterangan : {{$doc_str2[0]->keterangan_tolak}}</p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="mask">
                                            <p></p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('get.origin.str', $doc_str2[0]->namafile.'.pdf') }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="str"  data-namafile="{{$doc_str2[0]->namafile}}">Lihat</button>
                                                @if($doc_str2[0]->is_compromised == '1')
                                                    <a class="btn btn-sm btn-primary editSTR" href="{{route('edit.dokumen.nakes' , $user_id)}}_STR_2">Edit</a>
                                                @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>

                                <div class="col-sm-4 col-xs-12">
                                @if($template_id != '1')
                                    @if (count($doc_str3) == 0)
                                        <div class="thumbnail">
                                            <center><div class="position-relative">
                                            @if($detail_pengaju->template_id == '2')<a href='{{route("nakes.dokter.uploadstr", "$user_id")}}_3'>
                                            @else <a href='{{route("nakes.pakai.idlestr", "$user_id")}}_3'>
                                            @endif
                                                <i class="fa fa-plus" id="tambah_jenis1" style="font-size:150px" data-jenis="STR3"  data-judul="STR3"></i>
                                            </a>
                                            </div></center>

                                            <div class="caption card-footer text-center">
                                                <ul class="list-inline">
                                                <li><i class="people lighter"></i>&nbsp;Silahkan Upload STR Lembar 3</li>
                                                <li></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        <div class="thumbnail">
                                            <div @if($doc_str3[0]->is_compromised == '1') class="card mb-2 bg-gradient-dark" @else class="image view view-first" @endif>
                                                <img style="width: 100%; display: block;" src="{{ asset('images/docs/STR1.png')}}" alt="image" @if($doc_str3[0]->is_compromised == '1') class="card-img-top border border-danger" @endif>
                                                @if($doc_str3[0]->is_compromised == '1')
                                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                    <h5 class="card-title text-danger text-white"><b>UPLOAD ULANG!</b></h5>
                                                    <p class="card-text text-white pb-2 pt-1">Keterangan : {{$doc_str3[0]->keterangan_tolak}}</p>
                                                </div>
                                                @endif>
                                            </div>
                                            <div class="mask">
                                                <p></p>
                                                <div class="tools tools-bottom">
                                                    <p><a href="{{ route('get.origin.str', $doc_str3[0]->namafile.'.pdf') }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                    <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="str" data-namafile="{{$doc_str3[0]->namafile}}">Lihat</button>
                                                    @if($doc_str3[0]->is_compromised == '1')
                                                        <a class="btn btn-sm btn-primary editSTR" href="{{route('edit.dokumen.nakes' , $user_id)}}_STR_3">Edit</a>
                                                    @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                </div>
                            @endif
                            </div>
                            <hr />
                            <!--@if($detail_pengaju->jenis_profesi == 'DS' || $detail_pengaju->jenis_profesi == 'DGS')@endif-->
                            @if($template_id == '2')
                                @if($allismanual == 1)
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                        <div class="alert alert-warning alert-dismissible">
                                        
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> STR Sub Belum Dapat Diupload!</h5>
                                        Silahkan Update STR Anda (Scan QRCODE) Terlebih Dahulu Untuk Mengupload STR Subspesialis.
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row">
                                    <div class="col-sm-4 col-xs-12">
                                    @if (count($doc_sub) == 0)
                                        <div class="thumbnail">
                                            <center><div class="position-relative">
                                            <a href='{{route("nakes.dokter.uploadstr", "$user_id")}}_K'>
                                                <i class="fa fa-plus" id="tambah_jenis1" style="font-size:150px" data-jenis="stsub"></i>
                                            </a>
                                            </div></center>

                                            <div class="caption card-footer text-center">
                                                <ul class="list-inline">
                                                <li><i class="people lighter"></i>&nbsp;Silahkan Upload STR Sub Spesialis</li>
                                                <li></li>
                                                </ul>
                                            </div>
                                        </div>
                                    @else
                                        <div class="thumbnail">
                                            <div @if($doc_sub[0]->is_compromised == '1') class="card mb-2 bg-gradient-dark" @else class="image view view-first" @endif>
                                                <img style="width: 100%; display: block;" src="{{ asset('images/docs/stsub.png')}}" alt="image" @if($doc_sub[0]->is_compromised == '1') class="card-img-top border border-danger" @endif>
                                                @if($doc_sub[0]->is_compromised == '1')
                                                <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                    <h5 class="card-title text-danger text-white"><b>UPLOAD ULANG!</b></h5>
                                                    <p class="card-text text-white pb-2 pt-1">Keterangan : {{$doc_sub[0]->keterangan_tolak}}</p>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="mask">
                                                <p></p>
                                                <div class="tools tools-bottom">
                                                    <p><a href="{{ route('get.origin.str', $doc_sub[0]->namafile.'.pdf') }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                    <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="str" data-namafile="{{$doc_sub[0]->namafile}}">Lihat</button>
                                                    @if($doc_str1[0]->is_compromised == '1')
                                                        <a class="btn btn-sm btn-primary editSTR" href="{{route('edit.dokumen.nakes' , $user_id)}}_stsub">Edit</a>
                                                    @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    </div>
                                </div>
                                @endif
                            <hr />
                            
                            @endif
                            <div class="row">
                                <div class="col-sm-4 col-xs-12">
                                @if (count($doc_ktp) == 0)
                                    <div class="thumbnail">
                                        <center><div class="position-relative">
                                       
                                        <i class="fa fa-plus" id="tambah_jenis4" style="font-size:150px" data-jenis="ktps" data-bs-toggle="modal" data-judul="ktps" data-bs-target="#tambahKTPModal"></i>
                                        </div></center>

                                        <div class="caption card-footer text-center">
                                            <ul class="list-inline">
                                            <li><i class="people lighter"></i>&nbsp;Silahkan Upload KTP</li>
                                            <li></li>
                                            </ul>
                                        </div>
                                     
                                    </div>
                                @else
                                    <div class="thumbnail">
                                        <div @if($doc_ktp[0]->is_compromised == '1') class="card mb-2 bg-gradient-dark" @else class="image view view-first" @endif> 
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs/ktp.png')}}" alt="image" @if($doc_ktp[0]->is_compromised == '1') class="card-img-top border border-danger" @endif>
                                            @if($doc_ktp[0]->is_compromised == '1')
                                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-danger text-white"><b>DOKUMEN DITOLAK</b></h5>
                                                <p class="card-text text-white pb-2 pt-1">Keterangan : {{$doc_ktp[0]->keterangan_tolak}}</p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="mask">
                                            <p>KTP</p>
                                            <div class="tools tools-bottom">
                                                <!--<p><a href="{{ route('download.the.ktp', $doc_ktp[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>-->
                                                <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-jenis="ktp" data-namafile="{{$doc_ktp[0]->namafile}}" data-user="{{$user_id}}" data-id="{{$doc_ktp[0]->id}}">Lihat</button>
                                                @if($doc_ktp[0]->is_compromised == '1')
                                                <button class="btn btn-sm btn-primary editmaindokumen" data-mode="e" data-id="{{$doc_ktp[0]->id}}" data-jenis="2" data-jenisdok="KTP" data-user="{{$user_id}}">Edit</button>
                                                @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>

                                <div class="col-sm-4 col-xs-12">
                                @if (count($doc_ijazah) == 0)
                                    <div class="thumbnail">
                                        <center><div class="position-relative">
                                        <i class="fa fa-plus" id="tambah_jenis4" style="font-size:150px" data-jenis="IJAZAH" data-bs-toggle="modal" data-judul="Ijazah" data-univ="{{$datapendaftaran->universitas}}" data-bs-target="#tambahModal"></i>
                                        </div></center>

                                        <div class="caption card-footer text-center">
                                            <ul class="list-inline">
                                            <li><i class="people lighter"></i>&nbsp;Silahkan Upload Ijazah</li>
                                            <li></li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="thumbnail">
                                        <div @if($doc_ijazah[0]->is_compromised == '1') class="card mb-2 bg-gradient-dark" @else class="image view view-first" @endif> 
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs/ijazah.png')}}" alt="image" @if($doc_ijazah[0]->is_compromised == '1') class="card-img-top border border-danger" @endif>
                                            @if($doc_ijazah[0]->is_compromised == '1')
                                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-danger text-white"><b>DOKUMEN DITOLAK</b></h5>
                                                <p class="card-text text-white pb-2 pt-1">Keterangan : {{$doc_ijazah[0]->keterangan_tolak}}</p>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="mask">
                                            <p>Ijazah</p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('download.the.file', $doc_ijazah[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="ijazah" data-namafile="{{$doc_ijazah[0]->namafile}}">Lihat</button>
                                                <button class="btn btn-sm btn-primary editmaindokumen" data-mode="e" data-id="{{$doc_ijazah[0]->id}}" data-jenis="2" data-jenisdok="IJAZAH" data-user="{{$user_id}}">Edit</button>
                                                <button class="btn btn-sm btn-secondary tambahIjazah" data-jenis="ijazah" data-namafile="">Tambah</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>

                                

                                <div class="col-sm-4 col-xs-12" style="display:none">
                                @if (count($doc_sptp) == 0)
                                    <div class="thumbnail">
                                        <center><div class="position-relative">
                                        <i class="fa fa-plus" id="tambah_jenis3" style="font-size:150px" data-jenis="SPTP" data-bs-toggle="modal" data-judul="Surat Pernyataaan Tempat Praktik" data-bs-target="#tambahModal"></i>
                                        </div></center>

                                        <div class="caption card-footer text-center">
                                            <ul class="list-inline">
                                            <li><i class="people lighter"></i>&nbsp;Silahkan Upload Surat Pernyataan Tempat Praktik</li>
                                            <li></li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="thumbnail">
                                        <div class="image view view-first">
                                        
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs/sptp.png')}}" alt="image">
                                        
                                        </div>
                                        <div class="mask">
                                            <p>Surat Pernyataan Tempat Praktik</p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('download.the.file', $doc_sptp[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>

                                <div class="col-sm-4 col-xs-12">
                                    @if (count($doc_skskp) == 0) 
                                    <div class="thumbnail">
                                        <center><div class="position-relative">
                                        <a href="{{ route ('nakes.upload.skskp', $user_id)}}">
                                        <i class="fa fa-plus" id="tambah_jenis3" style="font-size:150px"></i>
                                        </div></center>

                                        <div class="caption card-footer text-center">
                                            <ul class="list-inline">
                                            <li><i class="people lighter"></i>&nbsp;Silahkan Upload Dokumen Serkom / SKSKP</li>
                                            <li></li>
                                            </ul>
                                        </div>
                                        </a>
                                    </div>
                                    @else
                                    <div class="thumbnail">
                                        <div class="image view view-first">
                                        
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs/skskp.png')}}" alt="image">
                                        
                                        </div>
                                        <div class="mask">
                                            <p>Surat Pemenuhan Kompetensi</p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('download.the.file', $doc_skskp[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <a href="{{ route ('nakes.update.skskp', $user_id)}}" class="btn btn-sm btn-success">Update</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                            </div>
                            
                            <hr />
                            <div class="row">

                                <div class="col-sm-6 col-xs-12" style="display:none">
                                @if (count($doc_skp) == 0)
                                    <div class="thumbnail">
                                        <center><div class="position-relative">
                                        <i class="fa fa-plus" id="tambah_jenis5" style="font-size:150px" data-jenis="SKP" data-bs-toggle="modal" data-judul="Surat Keterangan Pimpinan" data-bs-target="#tambahModal"></i>
                                        </div></center>

                                        <div class="caption card-footer text-center">
                                            <ul class="list-inline">
                                            <li><i class="people lighter"></i>&nbsp;Silahkan Upload Surat Keterangan Pimpinan</li>
                                            <li></li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="thumbnail">
                                        <div class="image view view-first"> 
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs/skp.png')}}" alt="image">
                                        </div>
                                        <div class="mask">
                                            <p>Surat Keterangan Pimpinan</p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('download.the.file', $doc_skp[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>

                                <div class="col-sm-6 col-xs-12" style="display:none">
                                @if (count($doc_sks) == 0)
                                    <div class="thumbnail">
                                        <center><div class="position-relative">
                                        <i class="fa fa-plus" id="tambah_jenis2" style="font-size:150px" data-jenis="SKS" data-bs-toggle="modal" data-judul="Surat Keterangan Sehat" data-bs-target="#tambahModal"></i>
                                        </div></center>

                                        <div class="caption card-footer text-center">
                                            <ul class="list-inline">
                                            <li><i class="people lighter"></i>&nbsp;Silahkan Upload Surat Keterangan Sehat</li>
                                            <li></li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="thumbnail">
                                        <div class="image view view-first">
                                        
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs/sks.png')}}" alt="image">
                                        
                                        </div>
                                        <div class="mask">
                                            <p>Surat Keterangan Sehat</p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('download.the.file', $doc_sks[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>

                                <div class="col-sm-4 col-xs-12" style="display:none">
                                @if (count($doc_rekomp) == 0)
                                    <div class="thumbnail">
                                        <center><div class="position-relative">
                                        <i class="fa fa-plus" id="tambah_jenis8" style="font-size:150px" data-jenis="REKOMP" data-bs-toggle="modal" data-judul="Rekomendasi Organisasi Profesi" data-bs-target="#tambahModal"></i>
                                        </div></center>

                                        <div class="caption card-footer text-center">
                                            <ul class="list-inline">
                                            <li><i class="people lighter"></i>&nbsp;Silahkan Upload Rekomendasi Organisasi Profesi</li>
                                            <li></li>
                                            </ul>
                                        </div>
                                    </div>
                                @else
                                    <div class="thumbnail">
                                        <div class="image view view-first">
                                        
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs/rekomprofesi.png')}}" alt="image">

                                        </div>
                                        <div class="mask">
                                            <p>Rekomendasi Organisasi Profesi</p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('download.the.file', $doc_rekomp[0]->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDetail" data-mode="v" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Lihat</button>
                                                <button class="btn btn-sm btn-primary editDetail" data-mode="e" data-id="" data-jenis="2" data-bs-toggle="modal" data-bs-target="#tambahModal">Edit</button>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                </div>

                            </div>
                            @if($iscompro1->count() > 0)
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="alert alert-danger alert-dismissible">
                                        Dokumen Ditolak Untuk Pengajuan Salinan Pertama
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                @foreach ($iscompro1 as $com1)
                                <div class="col-sm-3 col-xs-12">
                                    <div class="thumbnail">
                                        <div class="card mb-2 bg-gradient-dark" > 
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs')}}/{{$com1->remark7}}.png" alt="image"class="card-img-top border border-danger">
                                           
                                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-danger text-white"><b>DOKUMEN DITOLAK</b></h5>
                                                <p class="card-text text-white pb-2 pt-1">Keterangan : {{$com1->keterangan_tolak}}</p>
                                            </div>
                                            
                                        </div>
                                        <div class="mask">
                                            <p>{{$com1->nama_doc}}</p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('download.the.file', $com1->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="ijazah" data-namafile="{{$com1->namafile}}">Lihat</button>
                                                <a class="btn btn-sm btn-primary editDetail" href="{{route('edit.dokumen.nakes' , $user_id)}}_{{$com1->jenis_doc}}_{{$com1->salinan}}">Edit</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                @endforeach
                            </div>
                            @endif

                            @if($iscompro2->count() > 0)
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="alert alert-danger alert-dismissible">
                                        Dokumen Ditolak Untuk Pengajuan Salinan Kedua
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                @foreach ($iscompro2 as $com2)
                                <div class="col-sm-3 col-xs-12">
                                    <div class="thumbnail">
                                        <div class="card mb-2 bg-gradient-dark" > 
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs')}}/{{$com2->remark7}}.png" alt="image"class="card-img-top border border-danger">
                                           
                                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-danger text-white"><b>DOKUMEN DITOLAK</b></h5>
                                                <p class="card-text text-white pb-2 pt-1">Keterangan : {{$com2->keterangan_tolak}}</p>
                                            </div>
                                            
                                        </div>
                                        <div class="mask">
                                            <p>{{$com2->nama_doc}}</p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('download.the.file', $com2->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="ijazah" data-namafile="{{$com2->namafile}}">Lihat</button>
                                                <a class="btn btn-sm btn-primary editDetail" href="{{route('edit.dokumen.nakes' , $user_id)}}_{{$com2->jenis_doc}}_{{$com2->salinan}}">Edit</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                @endforeach
                            </div>
                            @endif

                            @if($iscompro3->count() > 0)
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="alert alert-danger alert-dismissible">
                                        Dokumen Ditolak Untuk Pengajuan Salinan Ketiga
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                @foreach ($iscompro3 as $com3)
                                <div class="col-sm-3 col-xs-12">
                                    <div class="thumbnail">
                                        <div class="card mb-2 bg-gradient-dark" > 
                                            <img style="width: 100%; display: block;" src="{{ asset('images/docs')}}/{{$com3->remark7}}.png" alt="image"class="card-img-top border border-danger">
                                           
                                            <div class="card-img-overlay d-flex flex-column justify-content-end">
                                                <h5 class="card-title text-danger text-white"><b>DOKUMEN DITOLAK</b></h5>
                                                <p class="card-text text-white pb-2 pt-1">Keterangan : {{$com3->keterangan_tolak}}</p>
                                            </div>
                                            
                                        </div>
                                        <div class="mask">
                                            <p>{{$com3->nama_doc}}</p>
                                            <div class="tools tools-bottom">
                                                <p><a href="{{ route('download.the.file', $com3->namafile) }}" target="_blank" class="btn btn-sm btn-info" role="button">Download</a>
                                                <button class="btn btn-sm btn-success viewDocNakes" data-mode="v" data-id="" data-jenis="ijazah" data-namafile="{{$com3->namafile}}">Lihat</button>
                                                <a class="btn btn-sm btn-primary editDetail" href="{{route('edit.dokumen.nakes' , $user_id)}}_{{$com3->jenis_doc}}_{{$com3->salinan}}">Edit</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                @endforeach
                            </div>
                            @endif
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

@section('script')
<script>
    $(document).ready(function() {
        $('.tambahIjazah').click(function(){
            $.fancybox.open({
                src: '#modal-tambahijazah-content',
                type: 'inline',
                touch: false,
                modal: true,
                clickSlide: false,
                afterShow: function() {
                    $('.tutuptambahijazah').click(function() {
                        $.fancybox.close();
                    });
                }
            });
        });

        $('.editmaindokumen').on('click', function(){
            var jenis_doc = $(this).attr('data-jenisdok')
            var id_doc = $(this).attr('data-id')
            var id_nakes = $(this).attr('data-user')
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("get.maindok.nakes")}}',
                data: {'id_doc': id_doc, 'id_nakes' : id_nakes, 'jenis_doc' : jenis_doc, _token: "{{ csrf_token() }}"},
                dataType: 'json',
                success: function(data){
                    

                    if(data.success == true) {
                        if(jenis_doc == 'KTP')
                        {
                            var ifdom = data.result.url_qr
                            if(ifdom == 'K')
                            {
                                $('.domisilih').prop('readonly', true)
                                $('#ktpALAMATDom').prop('required', false)
                            } else {
                                $('.domisilih').prop('readonly', false)
                                $('#ktpALAMATDom').prop('required', true)
                                $('#ktpALAMATDom').val(data.result.remark5);
                                $('#ktpKecamatanDom').val(data.result.remark6);
                                $('#ktpKabupatenDom').val(data.result.remark7);
                            }
                            $('#isEditKTP').val('1')
                            $('#ktpNAMA').val(data.result.nama_doc)
                            $('#ktpNOMOR').val(data.result.no_doc)
                            $('#ktpTTL').val(data.result.remark4)
                            $('#ktpTanggalLahir').val(data.result.tgl_doc_origin)
                            $('#ktpALAMAT').val(data.result.remark1)
                            $('#ktpKabupaten').val(data.result.remark3)
                            $('#ktpKecamatan').val(data.result.remark2)

                            $('#tambahKTPModal').modal('show')
                        } else {
                            $('#tEditIjazah').val('1')
                            $('#tJenisDoc').val('IJAZAH')
                            $('#tNoDocument').val(data.result.no_doc)
                            $('#tTglDocument').val(data.result.tgl_doc_origin)
                            $('#tUniversitas').val(data.result.remark1)
                            $('#tStrata').val(data.result.remark2)
                            $('#tProdi').val(data.result.remark3)
                            //
                            $('#tambahModal').modal('show')
                            $('#judultambahnya').text('Edit Dokumen IJAZAH')
                            $('#tTglBerlaku').val('2022-01-01')
                            $('#nonijazah').hide()
                            $('#untukijazah').show()
                            $('.dokumendiupload').hide()
                        }
                    }
                    
                    
                },
                complete: function(){
                    
                },
                error: function(request, status, error){
                    alert(request.responseText);
                }
            });

            
        })

        $('#formtbhktp').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route('simpan.maindoc.nakes') }}`;
            let formData = new FormData($(this)[0])
            formData.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: link,
                data: formData,
                cache:false,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                method: "POST",
                enctype: 'multipart/form-data',
                beforeSend: function() {

                    $.fancybox.open({
                        src: '#modal-doctunggu-content',
                        type: 'inline',
                        touch: false,
                        modal: true,
                        clickSlide: false
                    });
                    
                },
                success: function (data) {
                    $.fancybox.close();
                    if(data.success) {
                        Swal.fire(data.keterangan).then(function() {
                            window.location.href = '{{ route("nakes.documents") }}';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Submit Pengajuan Nakes',
                        })
                    }
                }
                ,
                error: function(request, status, error){
                    $.fancybox.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error Submit Pengajuan Nakes',
                    })
                }
            });

            
        });


        $('#formtambahpendidikan').on('submit', function(e){
            e.preventDefault();
            let link = `{{ route('simpan.ijazahlain.nakes') }}`;
            let formData = new FormData($(this)[0])
            
            $.ajax({
                url: link,
                data: formData,
                cache:false,
                dataType: 'JSON',
                contentType: false,
                processData: false,
                method: "POST",
                enctype: 'multipart/form-data',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    
                },
                success: function (data) {
                    Swal.close();
                    if(data.success) {
                        Swal.fire(data.keterangan).then(function() {
                            window.location.href = '{{ route("nakes.dashboard") }}';
                            
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Error Submit Pengajuan Nakes',
                        })
                    }
                }
                ,
                error: function(request, status, error){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error Submit Pengajuan Nakes',
                    })
                }
            });

            
            
        });
    });
</script>
@endsection