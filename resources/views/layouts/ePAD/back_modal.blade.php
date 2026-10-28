<!-- PROFIL PEDAGANG -->
<div class="modal" id="profil_pedagangModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Informasi Pedagang</h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                  <div class="col-md-12 col-sm-12 col-xs-12">
                    <table id="" class="TabelModal_profil_pedagang table-striped table-bordered">
                      <thead>
                        <tr>
                          <th></th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Nama Lengkap</td>
                          <td class="pedagangModal_nama"></td>
                        </tr>
                        <tr>
                          <td>Tanggal Bayar Terakhir</td>
                          <td class="pedagangModal_tgl_bayar"></td>
                        </tr>
                        <tr>
                          <td>Total Tagihan</td>
                          <td class="pedagangModal_total_tagihan"></td>
                        </tr>
                        <tr>
                          <td>Total Tunggakan</td>
                          <td class="pedagangModal_total_tunggakan"></td>
                        </tr>

                        <tr>
                          <td>Pasar</td>
                          <td>
                            <select id="select2_pasarmodal" required name="pasar" class='form-control' style="width: 100%">
                              <option></option>
                              @foreach($pasar as $row)
                              <option value="{{ $row->nama_pasar }}">{{ $row->nama_pasar }}</option>
                              @endforeach
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <td>NPWRD</td>
                          <td class="pedagangModal_npwrd"></td>
                        </tr>
                        <tr>
                          <td>Data Kios/LOS</td>
                          <td class="pedagangModal_kios"></td>
                        </tr>
                        <tr>
                          <td>No. Situ</td>
                          <td class="pedagangModal_no_situ"></td>
                        </tr>
                        <tr>
                          <td>Kelas Kios/LOS</td>
                          <td class="pedagangModal_kelas"></td>
                        </tr>
                        <tr>
                          <td>Jenis Usaha</td>
                          <td class="pedagangModal_jenis_usaha"></td>
                        </tr>
                        <tr>
                          <td>Ukuran/m<sup>2</sup></td>
                          <td class="pedagangModal_ukuran"></td>
                        </tr>
                        <tr>
                          <td>Lantai</td>
                          <td class="pedagangModal_lantai"></td>
                        </tr>
                        <tr>
                          <td>Tarif Kios/LOS</td>
                          <td class="pedagangModal_tarif"></td>
                        </tr>
                        <tr>
                          <td>Total Tarif (1 Pasar)</td>
                          <td class="pedagangModal_total_tarif"></td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>

            </div>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
