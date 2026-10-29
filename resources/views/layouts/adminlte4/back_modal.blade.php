{{--
    Shared modals (AdminLTE 4).

    Port of layouts/minlte/back_modal.blade.php: the same modal ids and the same
    forms, with the Bootstrap 4 -> 5 attribute rewrite (data-bs-toggle,
    data-bs-target, data-bs-dismiss). The dismiss buttons keep the legacy
    .close class, which public/css/adminlte4-compat.css styles like the
    Bootstrap 5 .btn-close.
--}}
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="tambahModal">

    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Tambah Dokumen</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
              <form enctype="multipart/form-data" id="formTask" action="{{ route('nakes.submit.dokumen') }}" method="post" class="form-horizontal">
                @csrf
                <div class="row" style="display:none">
                  
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Jenis Doc</label>
                            <input type="text" id="tJenisDoc" name="tJenisDoc" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Judul Doc</label>
                            <input type="text" id="tJudulDoc" name="tJudulDoc" class="form-control" >
                        </div>
                    </div>
                    

                </div>     
                <div class="row">
                  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">No Dokumen</label>
                            <input type="text" id="tNoDocument" name="tNoDocument" class="form-control">
                        </div>
                    </div>
 
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Tanggal Dokumen</label>
                            <input type="date" id="tTglDocument" name="tTglDocument" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="row" id="nonijazah">
                  <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Tanggal Berlaku</label>
                            <input type="date" id="tTglBerlaku" name="tTglBerlaku" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="ms-0">Keterangan</label>
                            <textarea class="form-control" id="tKeterangan" name="tKeterangan"></textarea>
                        </div>
                    </div>
                    
                </div>


                <div class="row" id="untukijazah">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Universitas</label>
                            <input type="text" id="tUniversitas" name="tUniversitas" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Strata</label>
                            <input type="text" id="tStrata" name="tStrata" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="ms-0">Prodi</label>
                            <input type="text" id="tProdi" name="tProdi" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-4" style="display:none">
                        <div class="form-group">
                            <label class="ms-0">Prodi</label>
                            <input type="text" id="tEditIjazah" name="tEditIjazah" value="0" class="form-control">
                        </div>
                    </div>
                    
                </div>

                <div class="row toevent dokumendiupload">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Lampiran Dokumen</label>
                            <input type="file" id="tFileDoc" name="tFileDoc" class="form-control" accept=".pdf">
                        </div>
                    </div>
                    <div class="col-md-6" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">User</label>
                            <input type="text" id="tUser_id" name="tUser_id" value="{{$user_id}}" class="form-control">
                        </div>
                    </div>
                </div>
                <button type="submit" id="submitDoc" class="btn btn-success submitDoc">Submit</button>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="tambahPengajuanMModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Tambah Pengajuan</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
              <form enctype="multipart/form-data" id="formTask" action="{{ route('nakes.submit.dokumen') }}" method="post" class="form-horizontal">
                @csrf
                <div class="row">
                  
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Alamat Pengajuan</label>
                            <input type="text" id="tJenisDoc" name="tJenisDoc" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Kabupaten</label>
                            <input type="text" id="tJudulDoc" name="tJudulDoc" class="form-control" >
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Kecamatan</label>
                            <input type="text" id="tJudulDoc" name="tJudulDoc" class="form-control" >
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
                <button type="submit" id="submitDoc" class="btn btn-success submitDoc">Submit</button>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="approveModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Persetujuan Pengajuan</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="card">
                <div class="card-body">
                    
                    <h1>Dengan Ini Anda Menyetujui Permohonan SIP Berikut Dan Mendelegasikan Kepada DPMPTSP Untuk Proses Selanjutnya</h1>
                </div>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
              <form enctype="multipart/form-data" id="formApprovalPersetujuan" action="{{ route('approve.persetujuan') }}" method="post" class="form-horizontal">
                @csrf
                <div class="row">
                  

                    <div class="col-md-6" id="setujuDinkesDoc" style="display:none">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Lampiran Dokumen Persetujuan Dinkes</label>
                            <input type="file" id="tFileDocDinkes" name="tFileDocDinkes" class="form-control" accept=".pdf">
                        </div>
                    </div>

                    <div class="col-md-6" id="setujuDinkesDoc2" style="display:none">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Lampiran Dokumen Berita Acara Visitasi / Rekom Visitasi</label>
                            <input type="file" id="tFileVisitasi" name="tFileVisitasi" class="form-control" accept=".pdf" >
                        </div>
                    </div>
                    

                    <div class="col-md-6" id="setujuDPMPTSPDoc">
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Lampiran Dokumen Persetujuan DPMPTSP</label>
                            <input type="file" id="tFileDocDPMPTSP" name="tFileDocDPMPTSP" class="form-control" accept=".pdf" required>
                        </div>
                    </div>
                    

                </div>     


                <div class="row" style="display:none">
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">No Dokumen</label>
                            <input type="text" id="stNoDocDinkes" name="stNoDocDinkes" class="form-control">
                        </div>
                    </div>
                </div>  

                <div class="row" style="display:none">
                    <div class="col-md-6" >
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="ms-0">Tanggal Dokumen</label>
                            <input type="date" id="stTglDocDinkes" name="stTglDocDinkes" class="form-control">
                        </div>
                    </div>
                </div>  
                
                <div class="row toevent">
                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">User</label>
                            <input type="text" id="tUser_id" name="tUser_id" value="{{$user_id}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Jenis</label>
                            <input type="text" id="tSetStatus" name="tSetStatus" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">ID Pengajuan</label>
                            <input type="text" id="tid_pengajuan" name="tid_pengajuan" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">ID Nakes</label>
                            <input type="text" id="tid_nakes" name="tid_nakes" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                            <input type="text" id="tSalinanKe" name="tSalinanKe" class="form-control">
                        </div>
                    </div>

                    
                </div>
                <button type="submit" id="btnSubmitSetuju" class="btn btn-success">Submit</button>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="tolakModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Tolak Pengajuan</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
            <p>Anda Akan Menolak Pengajuan Berikut. Silahkan Inputkan Alasan Penolakan</p>
              <form enctype="multipart/form-data" id="formApprovalPersetujuan" action="{{ route('tolak.pengajuan') }}" method="post" class="form-horizontal">
                @csrf  

                <div class="row nonmanual">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejKTP" name="isRejKTP" data-nama="KTP" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue KTP</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganKTP" name="rejKeteranganKTP" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejSTR" name="isRejSTR" data-nama="STR" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue STR</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganSTR" name="rejKeteranganSTR" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejIJAZAH" name="isRejIJAZAH" data-nama="IJAZAH" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue Ijazah</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganIjazah" name="rejKeteranganIjazah" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual" id="isfotonakes">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejFOTO" name="isRejFOTO" data-nama="FOTO" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue Foto</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganFoto" name="rejKeteranganFoto" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual" id="istemplate" style="display:none">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejTemplate" name="isRejTemplate" data-nama="FOTO" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue Pengajuan Sebagai</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganTemplate" name="rejKeteranganTemplate" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejSKP" name="isRejSKP" data-nama="SKP" value="1" class="checktolak">
                        <label for="y" class="ms-0">Dokumen Keterangan Pimpinan</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganSKP" name="rejKeteranganSKP" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual" style="display:none">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejSKS" name="isRejSKS" data-nama="SKP" value="1" class="checktolak">
                        <label for="y" class="ms-0">Dokumen Keterangan Sehat</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganSKS" name="rejKeteranganSKS" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual" style="display:none">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejRPROF" name="isRejRPROF" data-nama="SKP" value="1" class="checktolak">
                        <label for="y" class="ms-0">Dokumen Rekom Profesi</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganRekomProv" name="rejKeteranganRekomProv" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual" style="display:none">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejSTP" name="isRejSTP" data-nama="STP" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue Dokumen Tempat Praktik</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganSTP" name="rejKeteranganSTP" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejSKSKP" name="isRejSKSKP" data-nama="STP" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue Dokumen Surat Serkom / SKP</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganSKSKP" name="rejKeteranganSKSKP" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="row nonmanual">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejSKTP" name="isRejSKTP" data-nama="STP" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue Dokumen Surat SKTP</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganSKTP" name="rejKeteranganSKTP" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejjadwalF" name="isRejjadwalF" data-nama="jadwalpraktik" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue Jadwal Praktik</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganJadwal" name="rejKeteranganJadwal" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejLokasiF" name="isRejLokasiF" data-nama="jadwalpraktik" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue Lokasi Pengajuan</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganLokasi" name="rejKeteranganLokasi" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>


                <div class="row nonmanual" style="display:none">
                    <div class="col-md-4">
                        <input type="checkbox" id="isRejLainnyaF" name="isRejLainnyaF" data-nama="isRejLainnyaF" value="1" class="checktolak">
                        <label for="y" class="ms-0">Issue Lainnya</label>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-check mb-4">
                            <input type="text" id="rejKeteranganLainnya" name="rejKeteranganLainnya" value="" placeholder="Keterangan / Alasan" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row checkmandirisekitar">
                                
                </div>
                <div class="row toevent">
                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="x" class="ms-0">User</label>
                            <input type="text" id="tUser_id" name="tUser_id" value="{{$user_id}}" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Jenis</label>
                            <input type="text" id="tSetStatus" name="tSetStatus" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">ID Pengajuan</label>
                            <input type="text" id="tid_pengajuant" name="tid_pengajuan" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">ID Nakes</label>
                            <input type="text" id="tid_nakest" name="tid_nakes" class="form-control">
                        </div>
                    </div>

                    <div class="col-md-3" style="display:none">
                        <div class="input-group input-group-static mb-4">
                            <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                            <input type="text" id="tolak_salinan" name="tolak_salinan" class="form-control">
                        </div>
                    </div>  
                </div>
                <button type="submit" id="btnSubmitSetujutolak" class="btn btn-danger" style="display:none">Tolak</button>
              </form>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="aktivasiNakes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Aktifasi Pendaftaran</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body">
                                <div class="embed-responsive embed-responsive-21by9">
                                    <iframe class="embed-responsive-item" id="lihatoriginstrpendaftar" src=""></iframe>
                                </div>
                                <div class="embed-responsive embed-responsive-21by9">
                                    <iframe class="embed-responsive-item" id="arpUrlQR" src=""></iframe>
                                </div>
                                <br />
                                <div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> Valid!</h5>
                                    Silahkan Set Password Untuk Mengapprove Pendaftaran Nakes Ini
                                </div> 
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form id="lanjutdaftar" action="{{ route('approve.pendaftar') }}" method="post" class="form-horizontal">
                                        @csrf

                                            <div class="row" style="display:none">
                                                <div class="col-md-3" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">ID</label>
                                                        <input type="text" id="aprID" name="aprID" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">ID</label>
                                                        <input type="text" id="aprIDUpdater" name="aprIDUpdater" value="{{$user_id}}" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">username</label>
                                                        <input type="text" id="aprEmail" name="aprEmail" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">photo</label>
                                                        <input type="text" id="aprFoto" name="aprFoto" class="form-control" >
                                                    </div>
                                                </div>

                                            </div>  


                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                                        <input type="text" id="aprNama" name="aprNama" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                                        <input type="text" id="aprNoSTR" name="aprNoSTR" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div>  


                                            <div class="row">

                                                <div class="col-md-5" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Tanggal Keluar STR</label>
                                                        <input type="text" id="aprTglStr" name="aprTglStr" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-5" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Universitas</label>
                                                        <input type="text" id="aprUniversitas" name="aprUniversitas" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-2" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                        <input type="text" id="aprSalinan" name="aprSalinan" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row">

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                                        <input type="text" id="aprKompetensi" name="aprKompetensi" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Profesi</label>
                                                        <input type="text" id="aprProfesi" name="aprProfesi" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div>  

                    

                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Set Password</label>
                                                        <div class="input-group input-group-sm">
                                                        <input type="text" id="aprPassw" name="aprPassw" class="form-control" required>
                                                        <span class="input-group-append">
                                                            <button type="button" class="btn btn-info btn-flat" id="setrndmpass">Random</button>
                                                        </span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Status File STR</label>
                                                        <div class="row">
                                                            <div class="col-md-10 col-xs-10">
                                                                <select class="form-control" id="aprStatusFile" name="aprStatusFile" required>
                                                                    <option value="" selected disabled>--Pilih--</option>
                                                                    <option value="1">Upload Ulang</option>
                                                                    <option value="2">Tidak Berubah</option>

                                                                </select>
                                                            </div>
                                                            <div class="col-md-2 col-xs-2">
                                                                <i class="fas fa-file"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>  

                                            <button type="submit" id="SubmitAfterValidation" class="btn btn-success">Lanjutkan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="overlay" id="lodaing">
                                <i class="fas fa-2x fa-sync-alt"></i>
                            </div> -->
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="aktivasiNakesView">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Pendaftar Teraktifasi</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body">
                                <div class="embed-responsive embed-responsive-21by9">
                                    <embed class="embed-responsive-item" id="lihatoriginstrpendaftarV" src=""></embed>
                                </div>
                                <div class="embed-responsive embed-responsive-21by9">
                                    <iframe class="embed-responsive-item" id="arpUrlQRV" src=""></iframe>
                                </div>
                                <br />
                                <div class="alert alert-success alert-dismissible">
                                    <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Valid!</h5>
                                    Silahkan Set Password Untuk Mengapprove Pendaftaran Nakes Ini
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form id="lanjutdaftar" action="" method="post" class="form-horizontal">
                                        @csrf
                                            <div class="row" style="display:none">
                                                <div class="col-md-3" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">ID</label>
                                                        <input type="text" id="aprIDV" name="aprIDV" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">ID</label>
                                                        <input type="text" id="aprIDUpdater" name="aprIDUpdater" value="{{$user_id}}" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">username</label>
                                                        <input type="text" id="aprEmailV" name="aprEmailV" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">photo</label>
                                                        <input type="text" id="aprFotoV" name="aprFotoV" class="form-control" >
                                                    </div>
                                                </div>

                                            </div>  


                                            <div class="row" style="display:none">
                                                <div class="col-md-3" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                        <input type="text" id="aprsalinanV" name="aprsalinanV" class="form-control" >
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                                        <input type="text" id="aprNamaV" name="aprNamaV" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                                        <input type="text" id="aprNoSTRV" name="aprNoSTRV" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row" style="display:none">

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Tanggal Keluar STR</label>
                                                        <input type="text" id="aprTglStrV" name="aprTglStrV" class="form-control" >
                                                    </div>
                                                </div>

                                                

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                        <input type="text" id="aprsalinanV" name="aprsalinanV" class="form-control" >
                                                    </div>
                                                </div>

                                            </div>  


                                            <div class="row">

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                                        <input type="text" id="aprKompetensiV" name="aprKompetensi" class="form-control" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Profesi</label>
                                                        <input type="text" id="aprProfesiV" name="aprProfesi" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div>  

                    

                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Set Password</label>
                                                        <input type="text" id="aprPasswV" name="aprPasswV" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Status File STR</label>
                                                        <div class="row">
                                                            <div class="col-md-10 col-xs-10">
                                                                <select class="form-control" id="aprStatusFileV" name="aprStatusFileV">

                                                                    <option value="1">Upload Ulang</option>
                                                                    <option value="2">Tidak Berubah</option>

                                                                </select>
                                                            </div>
                                                            <div class="col-md-2 col-xs-2">
                                                                <i class="fas fa-file"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>  
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="overlay" id="lodaing">
                                <i class="fas fa-2x fa-sync-alt"></i>
                            </div> -->
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="pakaiSTRModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Silahkan Pilih STR Untuk Pengajuan</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4 col-xs-12">
                        <div class="thumbnail">
                            <div class="card card-outline card-danger" id="headsal1">
                                <div class="card-header">
                                    <h3 class="card-title" id="titlesal1">Salinan 1</h3>
                                </div>
                            </div>
                            <center><div class="position-relative">
                                <i class="fa fa-plus" id="iconsal1" style="font-size:150px"></i>
                            </div></center>
                            <br />

                            <div class="text-center">
                                <a class="btn btn-block btn-outline-secondary kepengajuan" id="kepengajuan1" data-id="{{$user_id}}">Pakai Salinan 1 </a>
                                <a class="btn btn-block btn-outline-secondary liatdetilpengajuan" id="liatkepengajuan1" data-id="{{$user_id}}">Lihat Detail </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-xs-12">
                        <div class="thumbnail">
                            <div class="card card-outline card-danger" id="headsal2">
                                <div class="card-header">
                                    <h3 class="card-title" id="titlesal2">Salinan 2</h3>
                                </div>
                            </div>
                            <center><div class="position-relative">
                            <i class="fa fa-plus" id="iconsal2" style="font-size:150px"></i>
                            </div></center>
                            <br />

                            <div class="text-center">
                                <a href="" class="btn btn-block btn-outline-secondary kepengajuan" id="kepengajuan2" data-id="{{$user_id}}">Pakai Salinan 2</a>
                                <a href="" class="btn btn-block btn-outline-secondary liatdetilpengajuan" id="liatkepengajuan2" data-id="{{$user_id}}">Lihat Detail</a>
                            </div>
                        
                        </div>
                    </div>

                    <div class="col-sm-4 col-xs-12" id="salinanketiga">
                        <div class="thumbnail">
                            <div class="card card-outline card-danger" id="headsal3">
                                <div class="card-header">
                                    <h3 class="card-title" id="titlesal3">Salinan 3</h3>
                                </div>
                            </div>
                            <center><div class="position-relative">
                                <i class="fa fa-plus" id="iconsal3" style="font-size:150px"></i>
                            </div></center>
                            <br />

                            <div class="text-center">
                                <a class="btn btn-block btn-outline-secondary kepengajuan" id="kepengajuan3" data-id="{{$user_id}}">Pakai Salinan 3</a>
                                <a class="btn btn-block btn-outline-secondary liatdetilpengajuan" id="liatkepengajuan3" data-id="{{$user_id}}">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="approvetodraft" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Persetujuan Pengajuan</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                
                    <div class="alert alert-warning alert-dismissible">
                        
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Peringatan!</h5>
                        Draft SIP akan dikirimkan ke Aplikasi ASOKA untuk Proses TTE. Pastikan Sudah Tidak Ada Perubahan Data.
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">

                        <div class="card card-success" id="carddraftSIP">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Draft SIP
                                </h3>

                                <div class="card-tools">
                                    <a type="button" id="donlitdraftsip" class="btn btn-success" target="_blank"><i class="fas fa-download"></i></a>
                                    <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body" id="fordraftsip">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="embed-responsive embed-responsive-21by9">
                                            <iframe class="embed-responsive-item" id="hasildraftsip" src=""></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="overlay" id="waitpdfsip">
                                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                            </div>
                            
                        </div>


                        <form id="draftSetujuPTSP" action="{{ route ('draft.persetujuan.sip') }}" method="post" class="form-horizontal">
                        @csrf

                        
                            <div class="row" style="display:none">
                                <div class="col-md-3" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">ID Persetujuan</label>
                                        <input type="text" id="draftid_persetujuan" name="draftid_persetujuan" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3" >
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">is Verifikator</label>
                                        <input type="text" id="draftid_verif" name="draftid_verif" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Updater</label>
                                        <input type="text" id="draftUpdater" name="draftUpdater" class="form-control" value="{{$user_id}}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">ID Nakes</label>
                                        <input type="text" id="draftid_nakes" name="draftid_nakes" class="form-control" readonly>
                                    </div>
                                </div>
                                
                            </div>
                           
                            
                        </form>
                        <button type="button" id="kirimdraftkeasoka" class="btn btn-success">Setujui</button>
                        <!-- <button type="button" id="bataldraftasoka" class="btn btn-danger">Batal</button> -->
                    </div>
                </div>
                
            </div>

            <!-- Modal footer -->
            <div class="overlay" id="waitingdraft">
                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="pilihfasyankes" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Silahkan Pilih Faskes Yang Telah Terdaftar DPMPTSP</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row" id="jikasipmanualfaskes">
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body table-responsive p-0">
                                <table class="table table-striped" id="tabelfaskes" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No</th>
                                            <th style="display:none">ID FASKES</th>
                                            <th>Nama Faskes</th>
                                            <th>Alamat Faskes</th>
                                            <th>Kecamatan Faskes</th>
                                            <th>Kabupaten Faskes</th>
                                            <th style="display:none">Latitude</th>
                                            <th style="display:none">Longitude</th>
                                            <th>Aksi</th>  
                                        </tr>
                                    </thead>
                                    <tbody id="pilihanfaskes">
                                    </tbody>
                                </table>
                            </div>
                            <div class="overlay" id="faskesloading">
                                <i class="fas fa-3x fa-sync-alt fa-spin"></i>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer" id="footerpilihfaskes">

                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="cabutmodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Konfirmasi Pencabutan SIP</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-header">
                                <h3>Silahkan Lengkapi Form Berikut</h3>
                            </div>
                            <div class="card-body">

                                <form enctype="multipart/form-data" id="formTask" action="{{ route('nakes.submit.pencabutan') }}" method="post" class="form-horizontal">
                                    @csrf
                                      
                                    <div class="row ifdokterapot">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Lampiran Dokumen Pendukung</label>
                                                <input type="file" id="tFileRekomdok" name="tFileRekomdok" class="form-control" accept=".pdf">
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Nomor Dokumen Pendukung</label>
                                                <input type="text" id="tNoDocumentrekomdok" name="tNoDocumentrekomdok" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row ifdokterapot">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Tanggal Dokumen</label>
                                                <input type="date" id="tTglRekomdok" name="tTglRekomdok" class="form-control" value="{{date('Y-m-d')}}">
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Perihal</label>
                                                <input type="text" id="tPerihalRekomdok" name="tPerihalRekomdok" class="form-control">
                                            </div>
                                        </div>
                                       
                                    </div>

                                    <hr class="ifdokterapot" />

                                    <div class="row">
                                    
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Alasan Pencabutan</label>
                                                <select class="form-control" id="tAlasanCabut" name="tAlasanCabut" required>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1" class="ms-0">Alasan Lain</label>
                                                <input type="text" id="tAlasanCabutRemark" name="tAlasanCabutRemark" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row toevent">
                                        
                                        <div class="col-md-6" style="display:none">
                                            <div class="input-group input-group-static mb-4">
                                                <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                <input type="text" id="cabutnakes_id" name="cabutnakes_id" value="{{$user_id}}" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6" style="display:none">
                                            <div class="input-group input-group-static mb-4">
                                                <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                <input type="text" id="cabutIdPengajuan" name="cabutIdPengajuan"  class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6" style="display:none">
                                            <div class="input-group input-group-static mb-4">
                                                <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                <input type="text" id="cabutIdSip" name="cabutIdSip"  class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-md-6" style="display:none">
                                            <div class="input-group input-group-static mb-4">
                                                <label for="exampleFormControlSelect1" class="ms-0">User</label>
                                                <input type="text" id="cabutSalinan" name="cabutSalinan"  class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" id="submitDoc" class="btn btn-success submitDoc">Submit</button>
                                </form>
                                
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">

                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="approvalpencabutanmod" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Konfirmasi Approval Pencabutan</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="kontentappcabut">
                
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">

                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="hasilgoogle">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Hasil Pencarian Google</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body">
                                <div class="embed-responsive embed-responsive-21by9" id="cobadarigenerator">
                                    <iframe class="embed-responsive-item" id="gogelhasil" src=""></iframe>
                                </div>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">

                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="PerpanjangamnModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Hasil Pengecheckan STR</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row" id="hasilscanupload" style="display:none">
                    <div class="col-md-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body">
                                <div class="embed-responsive embed-responsive-21by9">
                                    <iframe class="embed-responsive-item" id="hasilframed" src=""></iframe>
                                </div>
                                <br />
                                <div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> Valid!</h5>
                                    Jika Data Sudah Benar, Silahkan Lengkapi Form Berikut untuk melanjutkan pendaftaran. Pastikan Data Yang Anda Input <b>BENAR</b> dan <b>Dapat Dipertanggungjawabkan</b>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form id="lanjutperpanjangan" action="{{ route('simpan.perpanjangan.str') }}" method="post" class="form-horizontal">
                                        @csrf

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">URL e</label>
                                                        <input type="text" id="stURL" name="stURL" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Hasil Kompetensi</label>
                                                        <input type="text" id="stKompetensiBeda" name="stKompetensiBeda" class="form-control" value="0">
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                                        <input type="text" id="stNama" name="stNama" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                                        <input type="text" id="stNoSTR" name="stNoSTR" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div>  

                                           
                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga</label>
                                                        <input type="text" id="stDueOri" name="stDueOri" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Keluar</label>
                                                        <input type="text" id="stStrKeluarOri" name="stStrKeluarOri" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Status Dokumen</label>
                                                        <input type="text" id="stStatDok" name="stStatDok" class="form-control" >
                                                    </div>
                                                </div>


                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga Conv</label>
                                                        <input type="text" id="stDueConv" name="stDueConv" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Tetapan Conv</label>
                                                        <input type="text" id="stStrKeluarConv" name="stStrKeluarConv" class="form-control" >
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">img src</label>
                                                        <input type="text" id="stImg" name="stImg" class="form-control" >
                                                    </div>
                                                </div>


                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                                        <input type="text" id="stUserIDNakes" name="stUserIDNakes" class="form-control" value="{{$user_id}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">TemplateID</label>
                                                        <input type="text" id="stTemplateIDPerpanjangan" name="stTemplateIDPerpanjangan" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                        <input type="text" id="stSalinanPerpanjangan" name="stSalinanPerpanjangan" class="form-control">
                                                    </div>
                                                </div>


                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Current ID Pengajuan</label>
                                                        <input type="text" id="tIDPengajuanDokter" name="tIDPengajuanDokter" class="form-control">
                                                    </div>
                                                </div>

                                                

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">which file</label>
                                                        <input type="text" id="stWhichF" name="stWhichF" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="row">

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">TGL Penetapan STR *</label>
                                                        <input type="text" id="stSTRtetapSIP" name="stSTRtetapSIP" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga *</label>
                                                        <input type="text" id="stSTRHinggaSIP" name="stSTRHinggaSIP" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                                        <input type="text" id="stKompetensi" name="stKompetensi" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div> 

                                            <hr />
                                            <div class="row">

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kecocokan Nama</label>
                                                        
                                                        <div class="progress progress-sm" id="cocoknamabar">
                                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                                            </div>
                                                        </div>
                                                        <small id="cocoknamavalue">
                                                            57%
                                                        </small>

                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kecocokan Kompetensi</label>
                                                        
                                                        <div class="progress progress-sm" id="cocokkompetensibar">
                                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                                            </div>
                                                        </div>
                                                        <small id="cocokkompetensivalue">
                                                            57%
                                                        </small>

                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Validasi Masa Berlaku</label>
                                                        
                                                        <input type="text" id="validasimasaberlaku" name="validasimasaberlaku" class="form-control" value="valid" readonly>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row" id="jikanama" style="display:none">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Stop!</h5>
                                                        Informasi Nama pada STR yang Anda Upload Tidak Cocok Dengan STR Sebelumnya. Mohon Periksa Kembali
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="jikatanggalsama" style="display:none">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Stop!</h5>
                                                        Tanggal Berlaku STR yang Anda Upload Sama Dengan Tanggal Berlaku STR Sebelumnya. Mohon Periksa Kembali
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="jikabedakompetensi" style="display:none">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Peringatan!</h5>
                                                        Informasi Kompetensi Pada STR yang Anda Upload Mengalami Perubahan. Jika Anda Yakin Untuk Melanjutkan, Silahkan Ajukan Pengajuan Baru Setelah Proses Pembaharuan STR Berhasil.
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" id="SubmitPerpanjanganAfterValidation" class="btn btn-success">Lanjutkan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="overlay" id="lodaing">
                                <i class="fas fa-2x fa-sync-alt"></i>
                            </div> -->
                        </div>
                        
                    </div>
                </div>
              
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="DokterStrModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Hasil Pengecheckan STR</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row" id="hasilscanuploaddokter" style="display:none">
                    <div class="col-md-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body">
                                <div class="embed-responsive embed-responsive-21by9">
                                    <iframe class="embed-responsive-item" id="hasilframeddokter" src=""></iframe>
                                </div>
                                <br />
                                <div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> Valid!</h5>
                                    Jika Data Sudah Benar, Silahkan Lengkapi Form Berikut untuk melanjutkan pendaftaran. Pastikan Data Yang Anda Input <b>BENAR</b> dan <b>Dapat Dipertanggungjawabkan</b>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form id="lanjutuploaddokter" action="{{ route('simpan.str.dokter') }}" method="post" class="form-horizontal">
                                        @csrf

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">URL e</label>
                                                        <input type="text" id="stURL" name="stURL" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Hasil Kompetensi</label>
                                                        <input type="text" id="stKompetensiBeda" name="stKompetensiBeda" class="form-control" value="0">
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                                        <input type="text" id="stNamaDok" name="stNamaDok" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                                        <input type="text" id="stNoSTRDok" name="stNoSTRDok" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div>  

                                           
                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga</label>
                                                        <input type="text" id="stDueOriDok" name="stDueOriDok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Keluar</label>
                                                        <input type="text" id="stStrKeluarOriDok" name="stStrKeluarOriDok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Status Dokumen</label>
                                                        <input type="text" id="stStatDokDok" name="stStatDokDok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">UrlCode</label>
                                                        <input type="text" id="stUrlCodeDok" name="stUrlCodeDok" class="form-control" >
                                                    </div>
                                                </div>

                                                


                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga Conv</label>
                                                        <input type="text" id="stDueConvDok" name="stDueConvDok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Tetapan Conv</label>
                                                        <input type="text" id="stStrKeluarConvDok" name="stStrKeluarConvDok" class="form-control" >
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">img src</label>
                                                        <input type="text" id="stImgDok" name="stImgDok" class="form-control" >
                                                    </div>
                                                </div>


                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                                        <input type="text" id="stUserIDNakesDok" name="stUserIDNakesDok" class="form-control" value="{{$user_id}}">
                                                    </div>
                                                </div>

                            

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                        <input type="text" id="stSalinanDok" name="stSalinanDok" class="form-control" >
                                                    </div>
                                                </div>

                                                

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">which file</label>
                                                        <input type="text" id="stWhichFDok" name="stWhichFDok" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="row">

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">TGL Penetapan STR *</label>
                                                        <input type="text" id="stSTRtetapSIPDok" name="stSTRtetapSIPDok" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga *</label>
                                                        <input type="text" id="stSTRHinggaSIPDok" name="stSTRHinggaSIPDok" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                                        <input type="text" id="stKompetensiDok" name="stKompetensiDok" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div> 

                                            <hr />
                                            <div class="row">

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kecocokan Nama</label>
                                                        
                                                        <div class="progress progress-sm" id="cocoknamabardok">
                                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                                            </div>
                                                        </div>
                                                        <small id="cocoknamavaluedok">
                                                            57%
                                                        </small>

                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kecocokan Kompetensi</label>
                                                        
                                                        <div class="progress progress-sm" id="cocokkompetensibardok">
                                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                                            </div>
                                                        </div>
                                                        <small id="cocokkompetensivaluedok">
                                                            57%
                                                        </small>

                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Validasi Masa Berlaku</label>
                                                        
                                                        <input type="text" id="validasimasaberlaku" name="validasimasaberlaku" class="form-control" value="valid" readonly>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row" id="jikanamadok" style="display:none">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Stop!</h5>
                                                        Informasi Nama pada STR yang Anda Upload Tidak Cocok Dengan STR Sebelumnya. Mohon Periksa Kembali
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="jikatanggalsama" style="display:none">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Stop!</h5>
                                                        Tanggal Berlaku STR yang Anda Upload Sama Dengan Tanggal Berlaku STR Sebelumnya. Mohon Periksa Kembali
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="jikabedakompetensidok" style="display:none">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Peringatan!</h5>
                                                        Informasi Kompetensi Pada STR yang Anda Upload Mengalami Perubahan. Jika Anda Yakin Untuk Melanjutkan, Silahkan Ajukan Pengajuan Baru Setelah Proses Pembaharuan STR Berhasil.
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" id="SubmitDokterAfterValidation" class="btn btn-success">Lanjutkan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="overlay" id="lodaing">
                                <i class="fas fa-2x fa-sync-alt"></i>
                            </div> -->
                        </div>
                        
                    </div>
                </div>
              
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="lihatdocModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Lihat Dokumen Nakes</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 col-xs-12">
                                    <embed id="lihatDokumentNakes" src="" width="100%" height="100%"></embed>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">

                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="uploadrecopModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Upload Rekomendasi Organisasi Profesi</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <form enctype="multipart/form-data" id="lanjutrekomop" action="{{ route('simpan.rekomprofesi') }}" method="post" class="form-horizontal">
                        @csrf

                            <div class="row" style="display:none">

                                <div class="col-md-4" >
                                    <div class="form-group" >
                                        <label for="exampleFormControlSelect1" class="ms-0">File Rekomendasi Profesi</label>
                                        <input type="text" id="recIdPengajuan" name="recIdPengajuan" class="form-control"  required>
                                    </div>
                                </div>

                            </div> 

                            <div class="row">

                                <div class="col-md-4" >
                                    <div class="form-group" >
                                        <label for="exampleFormControlSelect1" class="ms-0">File Rekomendasi Profesi</label>
                                        <input type="file" id="recFileRekom" name="recFileRekom" class="form-control" accept=".pdf" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">No Dokumen</label>
                                        <input type="text" id="recNoDok" name="recNoDok" class="form-control" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" class="ms-0">Tanggal Berlaku</label>
                                        <input type="date" id="recTglDok" name="recTglDok" class="form-control" required>
                                    </div>
                                </div>

                            </div> 
                            <button type="submit" id="lanjutRekomOpButton" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="nonDokterStrModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Hasil Pengecheckan STR</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row" id="hasilscanuploadnondokter" style="display:none">
                    <div class="col-md-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body">
                                <div class="embed-responsive embed-responsive-21by9">
                                    <iframe class="embed-responsive-item" id="hasilframednondokter" src=""></iframe>
                                </div>
                                <br />
                                <div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> Valid!</h5>
                                    Jika Data Sudah Benar, Silahkan Lengkapi Form Berikut untuk melanjutkan pendaftaran. Pastikan Data Yang Anda Input <b>BENAR</b> dan <b>Dapat Dipertanggungjawabkan</b>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <form id="lanjutuploadnondokter" action="{{ route('simpan.str.nondokter') }}" method="post" class="form-horizontal">
                                        @csrf

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">URL e</label>
                                                        <input type="text" id="stURLnondok" name="stURLnondok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Hasil Kompetensi</label>
                                                        <input type="text" id="stKompetensiBedanondok" name="stKompetensiBedanondok" class="form-control" value="0">
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Nama</label>
                                                        <input type="text" id="stNamanonDok" name="stNamanonDok" class="form-control" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">No STR</label>
                                                        <input type="text" id="stNoSTRnonDok" name="stNoSTRnonDok" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div>  

                                           
                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga</label>
                                                        <input type="text" id="stDueOrinonDok" name="stDueOrinonDok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Keluar</label>
                                                        <input type="text" id="stStrKeluarOrinonDok" name="stStrKeluarOrinonDok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Status Dokumen</label>
                                                        <input type="text" id="stStatDoknonDok" name="stStatDoknonDok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">UrlCode</label>
                                                        <input type="text" id="stUrlCodenonDok" name="stUrlCodenonDok" class="form-control" >
                                                    </div>
                                                </div>

                                                


                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga Conv</label>
                                                        <input type="text" id="stDueConvnonDok" name="stDueConvnonDok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Tetapan Conv</label>
                                                        <input type="text" id="stStrKeluarConvnonDok" name="stStrKeluarConvnonDok" class="form-control" >
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">img src</label>
                                                        <input type="text" id="stImgnonDok" name="stImgnonDok" class="form-control" >
                                                    </div>
                                                </div>


                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                                        <input type="text" id="stUserIDNakesnonDok" name="stUserIDNakesnonDok" class="form-control" value="{{$user_id}}">
                                                    </div>
                                                </div>

                            

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                        <input type="text" id="stSalinannonDok" name="stSalinannonDok" class="form-control" >
                                                    </div>
                                                </div>

                                                

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">which file</label>
                                                        <input type="text" id="stWhichFnonDok" name="stWhichFnonDok" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>  

                                            <div class="row">

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">TGL Penetapan STR *</label>
                                                        <input type="text" id="stSTRtetapSIPnonDok" name="stSTRtetapSIPnonDok" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">STR Hingga *</label>
                                                        <input type="text" id="stSTRHinggaSIPnonDok" name="stSTRHinggaSIPnonDok" class="form-control" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kompetensi</label>
                                                        <input type="text" id="stKompetensinonDok" name="stKompetensinonDok" class="form-control" readonly>
                                                    </div>
                                                </div>

                                            </div> 

                                            <hr />
                                            <div class="row">

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kecocokan Nama</label>
                                                        
                                                        <div class="progress progress-sm" id="cocoknamabarnondok">
                                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                                            </div>
                                                        </div>
                                                        <small id="cocoknamavaluenondok">
                                                            57%
                                                        </small>

                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Kecocokan Kompetensi</label>
                                                        
                                                        <div class="progress progress-sm" id="cocokkompetensibardok">
                                                            <div class="progress-bar bg-green" role="progressbar" aria-valuenow="57" aria-valuemin="0" aria-valuemax="100" style="width: 57%">
                                                            </div>
                                                        </div>
                                                        <small id="cocokkompetensivaluenondok">
                                                            57%
                                                        </small>

                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-12">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Validasi Masa Berlaku</label>
                                                        
                                                        <input type="text" id="validasimasaberlaku" name="validasimasaberlaku" class="form-control" value="valid" readonly>

                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row" id="jikanamanondok" style="display:none">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Stop!</h5>
                                                        Informasi Nama pada STR yang Anda Upload Tidak Cocok Dengan STR Sebelumnya. Mohon Periksa Kembali
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="jikatanggalsamanondok" style="display:none">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Stop!</h5>
                                                        Tanggal Berlaku STR yang Anda Upload Sama Dengan Tanggal Berlaku STR Sebelumnya. Mohon Periksa Kembali
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row" id="jikabedakompetensinondok" style="display:none">
                                                <div class="col-md-12 col-xs-12">
                                                    <div class="alert alert-danger alert-dismissible">
                                                        <h5><i class="icon fas fa-ban"></i> Peringatan!</h5>
                                                        Informasi Kompetensi Pada STR yang Anda Upload Mengalami Perubahan. Jika Anda Yakin Untuk Melanjutkan, Silahkan Ajukan Pengajuan Baru Setelah Proses Pembaharuan STR Berhasil.
                                                    </div>
                                                </div>
                                            </div>

                                            <button type="submit" id="SubmitNonDokterAfterValidation" class="btn btn-success">Lanjutkan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="overlay" id="lodaing">
                                <i class="fas fa-2x fa-sync-alt"></i>
                            </div> -->
                        </div>
                        
                    </div>
                </div>
              
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="updateNakesStrModal" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Hasil Pengecheckan STR</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row" id="hasilscanupdateSTR" style="display:none">
                    <div class="col-md-12 col-xs-12">
                        <div class="card card-warning">
                            <div class="card-body">
                                <br />
                                <div class="alert alert-success alert-dismissible">
                                    <h5><i class="icon fas fa-check"></i> Valid!</h5>
                                    Jika Data Sudah Benar, Silahkan Lengkapi Form Berikut untuk melanjutkan pendaftaran. Pastikan Data Yang Anda Input <b>BENAR</b> dan <b>Dapat Dipertanggungjawabkan</b>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h3 class="card-title">Hasil Scan STR</h3>
                                            </div>
                                            <div class="card-body">
                                                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                                    <ol class="carousel-indicators">
                                                        <li data-bs-target="#carouselExampleIndicators" data-slide-to="0" class=""></li>
                                                        <li data-bs-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
    
                                                    </ol>
                                                    <div class="carousel-inner">
                                                        <div class="carousel-item">
                                                            <iframe class="embed-responsive-item" id="hasilframeupdate" height="500px" width="100%" src=""></iframe>
                                                        </div>
                                                        <div class="carousel-item active">
                                                            <iframe class="embed-responsive-item" id="lihatupdatedSTR" height="500px" src=""></iframe>
                                                        </div>
                                                    </div>
                                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-bs-slide="prev">
                                                        <span class="carousel-control-custom-icon" aria-hidden="true">
                                                            <i class="fas fa-chevron-left" ></i>
                                                        </span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </a>
                                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-bs-slide="next">
                                                        <span class="carousel-control-custom-icon" aria-hidden="true">
                                                            <i class="fas fa-chevron-right"></i>
                                                        </span>
                                                        <span class="visually-hidden">Next</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="lanjutupdatenondokter" action="{{ route('simpanupdate.str.nondokter') }}" method="post" class="form-horizontal">
                                        @csrf

                                            <div class="row" style="display:none">
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">URL e</label>
                                                        <input type="text" id="stURLnondok" name="stURLnondok" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Hasil Kompetensi</label>
                                                        <input type="text" id="stKompetensiBedanondok" name="stKompetensiBedanondok" class="form-control" value="0">
                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="row" style="display:none">
                                                
                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">user ID</label>
                                                        <input type="text" id="stUserIDNakesnonDokU" name="stUserIDNakesnonDokU" class="form-control" value="{{$user_id}}">
                                                    </div>
                                                </div>

                            

                                                <div class="col-md-6" >
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">Salinan</label>
                                                        <input type="text" id="stSalinannonDokU" name="stSalinannonDokU" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">which file</label>
                                                        <input type="text" id="stWhichFnonDokU" name="stWhichFnonDokU" class="form-control" >
                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlSelect1" class="ms-0">new file</label>
                                                        <input type="text" id="stNewFilename" name="stNewFilename" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>  

                                           

                                            <button type="submit" id="SubmitNonDokterAfterValidation" class="btn btn-success">Lanjutkan</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- <div class="overlay" id="lodaing">
                                <i class="fas fa-2x fa-sync-alt"></i>
                            </div> -->
                        </div>
                        
                    </div>
                </div>
              
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="detailnakespadafaskes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="juduldetailfaskes">Detail Nakes Pada Faskes</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List Nakes Pada Faskes</h3>
                            <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="table_search" class="form-control float-end" placeholder="Search">
                                <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="card-body table-responsive" style="height: 300px;">
                            <table class="table table-striped" id="mlistallnakesonfaskes">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th width="15%">Profesi</th>
                                    <th>Status Pengajuan</th>
                                    <th>Berlaku Hingga</th>
                                    </tr>
                                </thead>
                    
                            </table>
                        </div>

                        </div>
                    </div>
                    
                    <div class="col-md-12 col-xs-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Rekapitulasi Profesi</h3>
                            </div>
                            <div class="card-body table-responsive">
                                <table class="table table-striped" id="mpersebaranprofesinakesfaskes">
                                    <thead>
                                        <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Profesi</th>
                                        <th>Berpraktik / Diproses</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="profileNakesModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="juduldetailprofile">Profile</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 col-xs-12">
                        <div class="sticky-top mb-3">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="img-fluid custom-rounded" id="fotodetailnakes" src="" alt="User profile picture">
                                    </div>
                                    <hr />
                                    <h3 class="profile-username text-center" id="namadetailnakes">Nina Mcintire</h3>
                                    <p class="text-muted text-center" id="profesidetailnakes">Apoteker</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-xs-12">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#praktiknakes" data-bs-toggle="tab">Praktik</a></li>
                                <li class="nav-item"><a class="nav-link" href="#profilnakes" data-bs-toggle="tab">Profil</a></li>
                                <li class="nav-item"><a class="nav-link" href="#sejawatnakes" data-bs-toggle="tab">Sejawat</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="praktiknakes">
                                        <div class="row mt-4">
                                            <nav class="w-100">
                                                <div class="nav nav-tabs" id="product-tab" role="tablist">
                                                    <a class="nav-item nav-link active" id="product-desc-tab" data-bs-toggle="tab" href="#nakes-salinan1" role="tab" aria-controls="nakes-salinan1" aria-selected="true">Salinan 1</a>
                                                    <a class="nav-item nav-link" id="product-comments-tab" data-bs-toggle="tab" href="#nakes-salinan2" role="tab" aria-controls="nakes-salinan2" aria-selected="false">Salinan 2</a>
                                                    <a class="nav-item nav-link" id="product-rating-tab" data-bs-toggle="tab" href="#nakes-salinan3" role="tab" aria-controls="nakes-salinan3" aria-selected="false">Salinan 3</a>
                                                </div>
                                            </nav>
                                            <div class="tab-content p-3" id="nav-tabContent">
                                                <div class="tab-pane fade active show" id="nakes-salinan1" role="tabpanel" aria-labelledby="product-desc-tab"> 
                                                    <div class="row">
                                                        <div class="col-md-12" id="isi-salinan1">
                                                        
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            
                                                            <div class="table-responsive" style="max-width: 100%; width: 500px; height: 300px; overflow-x: scroll;">
                                                                <table class="table table-striped" id="histori-salinan1">
                                                                    <thead><tr><th>#</th><th>Nama Faskes</th><th>Alamat Faskes</th><th>Tanggal Berlaku</th><th>Tanggal Pencabutan</th><th>Alasan</th></tr>
                                                                    </thead>
                                                                    <tbody id="histori-isi-salinan1">
                                                                    </tbody>
                                                                    </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="tab-pane fade" id="nakes-salinan2" role="tabpanel" aria-labelledby="product-comments-tab">
                                                    <div class="row">
                                                        <div class="col-md-12" id="isi-salinan2">
                                                        
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            
                                                            <div class="table-responsive" style="max-width: 100%; width: 500px; height: 300px; overflow-x: scroll;">
                                                                <table class="table table-striped" id="histori-salinan2">
                                                                    <thead><tr><th>#</th><th>Nama Faskes</th><th>Alamat Faskes</th><th>Tanggal Berlaku</th><th>Tanggal Pencabutan</th><th>Alasan</th></tr>
                                                                    </thead>
                                                                    <tbody id="histori-isi-salinan2">
                                                                    </tbody>
                                                                    </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="nakes-salinan3" role="tabpanel" aria-labelledby="product-rating-tab">
                                                    <div class="row">
                                                        <div class="col-md-12" id="isi-salinan3">
                                                      
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            
                                                            <div class="table-responsive" style="max-width: 100%; width: 500px; height: 300px; overflow-x: scroll;">
                                                                <table class="table table-striped" id="histori-salinan3">
                                                                    <thead><tr><th>#</th><th>Nama Faskes</th><th>Alamat Faskes</th><th>Tanggal Berlaku</th><th>Tanggal Pencabutan</th><th>Alasan</th></tr>
                                                                    </thead>
                                                                    <tbody id="histori-isi-salinan3">
                                                                    </tbody>
                                                                    </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="profilnakes">
                                        <div class="row">
                                            <div class="col-md-12 box-profile">

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody id="isiprofilnakes">
                                                            <tr>
                                                                <td style="width:50%">
                                                                    <strong><i class="fas fa-book me-1"></i> Pendidikan</strong>
                                                                    <p class="text-muted">
                                                                    Silahkan Upload Dokumen Ijazah
                                                                    </p>
                                                                    <hr />
                                                                    <strong><i class="far fa-file-alt me-1"></i> Email</strong>
                                                                    <p class="text-muted">
                                                                    Silahkan Upload Dokumen Cekakasiba
                                                                    </p>
                                                                </td>
                                                                <td>
                                                                    <strong><i class="fas fa-map-marker-alt me-1"></i> Alamat</strong>
                                                                    <p class="text-muted">
                                                                    Silahkan Upload Dokumen SAKDHKASJHDA
                                                                    </p>
                                                                    <hr />
                                                                    <strong><i class="fas fa-map-marker-alt me-1"></i> Alamat Domisili</strong>
                                                                    <p class="text-muted">
                                                                    Silahkan Upload Dokumen SAKDHKASJHDA
                                                                    </p>
                                                                </td>
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="sejawatnakes">
                                        <div class="row" id="listsejawat">
                                            <blockquote class="quote-secondary">
                                                <p>Tidak Ada Informasi Yang Dapat Ditampilkan Untuk Menu Sejawat</p>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="contohskpmodal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title" id="judultambahnya">Cara Unduh Dokumen SKP (Satuan Kredit Profesi)</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <!-- Modal body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-tools">

                                    <a type="button" class="btn btn-primary btn-sm" target="_blank" href="{{ URL::to('/storageform')}}/SuratPernyataanSKP.docx">
                                        <i class="fas fa-download"></i> Form SKP
                                    </a>
                                    <a type="button" class="btn btn-tool" target="_blank" href="{{ URL::to('/storageform')}}/howtoskp.pdf">
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
                                <embed src="{{ URL::to('/storageform')}}/howtoskp.pdf" width="100%" height="450px"></embed>
                                <div class="alert alert-info alert-dismissible">
                                Buat Surat Pernyataan Kecukupan SKP Serta Lampirkan FIle PDF SKP Yang Telah Anda Download Seperti Contoh Berikut Dibawah. <a type="button" class="btn btn-primary btn-sm" target="_blank" href="{{ URL::to('/storageform')}}/SuratPernyataanSKP.docx">
                                        <i class="fas fa-download"></i> Form SKP
                                    </a>
                                </div>
                                <embed src="{{ URL::to('/storageform')}}/contohskp.pdf" width="100%" height="450px"></embed>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
