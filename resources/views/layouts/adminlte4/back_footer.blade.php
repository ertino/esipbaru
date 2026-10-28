{{--
    Global page script for the AdminLTE 4 layout.

    Port of the parts of layouts/minlte/back_footer.blade.php that the
    AdminLTE 4 pages rely on. The legacy footer is written for Bootstrap 4 /
    AdminLTE 3 (jQuery modal plugin, data-toggle, ...) and is therefore not
    loaded here: only the handlers actually used by the migrated pages are
    ported, using the Bootstrap 5 API available on window.bootstrap.
--}}
<script>
    $(function () {

        // ------------------------------------------------------------------
        // Sidebar badge counters
        // ------------------------------------------------------------------
        @if (isset($role) && !empty($role))
        var role = '{{ $role }}';
        @else
        var role = '{{ Auth::user()->role }}';
        @endif

        if ($('#hitungpendingdaftar').length) {
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("admin.count.menu") }}',
                data: {
                    'jenis': 'pendaftaran',
                    'role': role,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
                        if (data.result.length > 0) {
                            $('#hitungpendingdaftar').html(data.result.length)
                        }
                    }
                },
                error: function (request, status, error) {
                    console.error('Gagal menghitung pendaftaran', request.responseText)
                }
            });
        }

        if ($('#hitungpendingaju').length) {
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("admin.count.menu") }}',
                data: {
                    'jenis': 'pengajuan',
                    'role': role,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
                        if (data.result.length > 0) {
                            $('#hitungpendingaju').html(data.result.length + data.result2.length)
                        }
                    }
                },
                error: function (request, status, error) {
                    console.error('Gagal menghitung pengajuan', request.responseText)
                }
            });
        }

        if ($('#menupencabutan').length) {
            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("admin.count.menu") }}',
                data: {
                    'jenis': 'admincabut',
                    'role': role,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (data) {
                    if (data.success == true) {
                        if (data.totalcabut > 0) {
                            $('#hitungpendingcabut').html(data.totalcabut)
                        }
                    }
                },
                error: function (request, status, error) {
                    console.error('Gagal menghitung pencabutan', request.responseText)
                }
            });
        }

        // ------------------------------------------------------------------
        // Detail pengajuan (DataTable "Aksi" column)
        // ------------------------------------------------------------------
        $('#historyapprovehdinkes').on('click', '.viewdetailpengajuan', function (e) {
            e.preventDefault();
            var id_pengajuan = $(this).attr('data-id');
            var urled = '{{ route("get.detail.pengajuan", ":id") }}';
            urled = urled.replace(':id', id_pengajuan);
            window.location.href = urled;
        });

        // ------------------------------------------------------------------
        // Profiling Nakes modal
        // ------------------------------------------------------------------
        function writejadwalpraktik(data, detail, kompetensi, sip_manual) {

            var jadwalpraktik = ''
            var detailpraktik = ''
            var salinan = detail.salinan
            var shifting = ''
            var sebagai = kompetensi
            var status_p = '<span class="badge text-bg-info">Proses Pengajuan</span>'
            var isFaskes = detail.isFaskes
            var alamat_pengajuan = detail.alamat_pengajuan + ', ' + detail.kecamatan + ', ' + detail.kabupaten

            if (sip_manual == '0') {
                if (detail.template_id == '4') {
                    sebagai = 'Apoteker Penanggung Jawab'
                } else if (detail.template_id == '3') {
                    sebagai = 'Apoteker'
                } else if (detail.template_id == '2') {
                    // The legacy footer compared the misspelled `tempate_id` here, so this
                    // branch never ran. It is wired to `template_id` now, but the remark is
                    // only used when it actually holds a value, otherwise the behaviour stays
                    // the same as before (fall back to the competence).
                    if (detail.remark != null && detail.remark != '' && detail.remark != '0') {
                        sebagai = detail.remark
                    } else {
                        sebagai = kompetensi
                    }
                }
            }

            var treker = detail.tracker;

            if (detail.isApproved == '4') {
                status_p = '<span class="badge text-bg-success">Disetujui</span>'
            } else if (detail.isApproved == '9') {
                status_p = '<span class="badge text-bg-danger">Ditolak</span>'
                treker = treker + ' (' + detail.alasan_ditolak + ')';
            } else if (detail.isApproved == 'CF') {
                status_p = '<span class="badge text-bg-secondary">Dicabut</span>'
                treker = treker + ' (' + detail.nama_alasan + ')';
            }

            if (isFaskes == '1') {
                alamat_pengajuan = detail.nama_faskes + ', ' + detail.alamat_pengajuan + ', ' + detail.kecamatan + ', ' + detail.kabupaten
            }

            var detailaju = '<div class="table-responsive"><table class="table"><tbody><tr><td style="width:50%"><strong><i class="bi bi-person me-1"></i> Pengajuan Sebagai</strong><p class="text-muted">' + sebagai + '</p><hr /><strong><i class="bi bi-file-earmark-text me-1"></i> Status Pengajuan</strong><p class="text-muted">' + status_p + '</p></td><td><strong><i class="bi bi-geo-alt me-1"></i> Alamat Pengajuan</strong><p class="text-muted">' + alamat_pengajuan + '</p><hr /><strong><i class="bi bi-info-circle me-1"></i> Keterangan Status</strong><p class="text-muted">' + treker + '</p></td></tr></tbody></table></div>';

            if (sip_manual == '1') {
                var iter = 0
                for (var i = 0; i < data.length; i++) {
                    var hari = ''

                    if (data[i].isSet == '1') {
                        iter++;
                        if (data[i].is_shift == '1') {
                            shifting = 'Shift';
                        }

                        switch (data[i].urutan) {
                            case '1':
                                hari = 'Senin'
                                break;
                            case '2':
                                hari = 'Selasa'
                                break;
                            case '3':
                                hari = 'Rabu'
                                break;
                            case '4':
                                hari = 'Kamis'
                                break;
                            case '5':
                                hari = 'Jumat'
                                break;
                            case '6':
                                hari = 'Sabtu'
                                break;
                            default:
                                hari = 'Minggu'
                        }

                        detailpraktik += '<tr><td>' + iter + '</td><td>' + hari + '</td><td>' + data[i].mulai + ' - ' + data[i].selesai + '</td><td>' + shifting + '</td><td>' + data[i].uraian + '</td></tr>';
                    }
                }
            } else {
                for (var i = 0; i < data.length; i++) {

                    if (data[i].is_shift == '1') {
                        shifting = 'Shift';
                    }

                    detailpraktik += '<tr><td>' + (i + 1) + '</td><td>' + data[i].hari + '</td><td>' + data[i].mulai + ' - ' + data[i].selesai + '</td><td>' + shifting + '</td><td>' + data[i].uraian + '</td></tr>';
                }
            }

            jadwalpraktik = '<div class="row"><div class="col-md-12">' + detailaju + '<div class="table-responsive"><table class="table table-striped"><thead><tr><th>#</th><th>Hari</th><th>Pukul</th><th>Shift</th><th>Uraian</th></tr></thead><tbody>' + detailpraktik + '</tbody></table></div></div></div>'
            $('#isi-salinan' + salinan).html(jadwalpraktik)
        }


        function writesejawat(data) {
            var temansejawat = '';

            for (var i = 0; i < data.length; i++) {

                var fotoUrl = "{{ URL::to('/storagefoto') }}/" + data[i].saved_photo;

                temansejawat += '<tr><td>' + (i + 1) + '</td><td><img src="' + fotoUrl + '" width="50px" alt="user image"></td><td>' + data[i].nama + '</td><td>' + data[i].no_reg + '</td><td>' + data[i].str_hingga + '</td></tr>';
            }

            var sejawatan = '<div class="col-md-12"><div class="table-responsive" style="max-height: 300px;"><table class="table table-striped"><thead><tr><th>#</th><th>Foto</th><th>Nama</th><th>No Registrasi</th><th>STR Hingga</th></tr></thead><tbody>' + temansejawat + '</tbody></table></div></div>'
            $('#listsejawat').html(sejawatan)
        }

        function writesejarah(data) {
            var sejarahnya = '';
            var salinan = data[0].salinan;
            $('#histori-salinan' + salinan).show()

            for (var i = 0; i < data.length; i++) {
                var nama_faskes = '';

                if (data[i].isFaskes == 1) {
                    nama_faskes = data[i].nama_faskes
                } else {
                    nama_faskes = 'Mandiri'
                }

                sejarahnya += '<tr><td>' + (i + 1) + '</td><td>' + nama_faskes + '</td><td>' + data[i].alamat_pengajuan + ', ' + data[i].kecamatan + ', ' + data[i].kabupaten + '</td><td>' + data[i].signed_date + '</td><td>' + data[i].updated_at + '</td><td>' + data[i].nama_alasan + '</td></tr>';
            }
            $('#histori-isi-salinan' + salinan).html(sejarahnya)
        }

        function showprofilingnakes(id_nakes) {

            $.ajax({
                type: 'ajax',
                method: 'get',
                url: '{{ route("profiling.nakes") }}',
                data: { 'id_nakes': id_nakes, _token: '{{ csrf_token() }}' },
                dataType: 'json',
                beforeSend: function (data) {
                    $('#histori-salinan1').hide()
                    $('#histori-salinan2').hide()
                    $('#histori-salinan3').hide()
                },
                success: function (data) {

                    var default_note = '<div class="col-md-12"><p class="text-muted">Tidak Ada Data Yang Dapat Ditampilkan</p></div>';
                    if (data.success == true) {

                        if (data.sejawat.length > 0) {
                            writesejawat(data.sejawat)
                        } else {
                            $('#listsejawat').html(default_note)
                        }

                        if (data.jadwal1.length > 0) {
                            writejadwalpraktik(data.jadwal1, data.salinan1, data.detail_pengaju.kompetensi, data.salinan1.sip_manual)
                        } else {
                            $('#isi-salinan1').html(default_note)
                        }
                        if (data.jadwal2.length > 0) {
                            writejadwalpraktik(data.jadwal2, data.salinan2, data.detail_pengaju.kompetensi, data.salinan2.sip_manual)
                        } else {
                            $('#isi-salinan2').html(default_note)
                        }
                        if (data.jadwal3.length > 0) {
                            writejadwalpraktik(data.jadwal3, data.salinan3, data.detail_pengaju.kompetensi, data.salinan3.sip_manual)
                        } else {
                            $('#isi-salinan3').html(default_note)
                        }

                        if (data.sejarah1.length > 0) {
                            writesejarah(data.sejarah1)
                        }
                        if (data.sejarah2.length > 0) {
                            writesejarah(data.sejarah2)
                        }
                        if (data.sejarah3.length > 0) {
                            writesejarah(data.sejarah3)
                        }


                        var pendidikan = data.infonakes.universitas == ''
                            ? 'Belum Ada Data Pendidikan'
                            : data.infonakes.strata + ', Jurusan ' + data.infonakes.jurusan + ', ' + data.infonakes.universitas

                        var alamat = data.infonakes.alamat_ktp == ''
                            ? 'Belum Ada Data Alamat'
                            : data.infonakes.alamat_ktp + ', ' + data.infonakes.kec_ktp + ', ' + data.infonakes.kab_ktp

                        var alamat_domisili = data.infonakes.isdomi == 'D'
                            ? data.infonakes.alamat_domisili + ', ' + data.infonakes.kec_domisili + ', ' + data.infonakes.kab_domisili
                            : 'Sesuai KTP'

                        var htmlprofile = '<tr><td style="width:50%"><strong><i class="bi bi-book me-1"></i> Pendidikan</strong><p class="text-muted">' + pendidikan + '</p><hr /><strong><i class="bi bi-envelope me-1"></i> Email</strong><p class="text-muted">' + data.detail_pengaju.email + '</p></td><td><strong><i class="bi bi-geo-alt me-1"></i> Alamat</strong><p class="text-muted">' + alamat + '</p><hr /><strong><i class="bi bi-geo-alt me-1"></i> Alamat Domisili</strong><p class="text-muted">' + alamat_domisili + '</p></td></tr>';

                        // Bootstrap 5 modal API: the legacy jQuery .modal() plugin is not loaded here.
                        bootstrap.Modal.getOrCreateInstance(document.getElementById('profileNakesModal')).show();

                        var fotoUrl = "{{ URL::to('/storagefoto') }}/" + data.detail_pengaju.saved_photo;
                        $('#fotodetailnakes').attr('src', fotoUrl)
                        $('#namadetailnakes').html(data.detail_pengaju.nama)
                        $('#profesidetailnakes').html(data.detail_pengaju.kompetensi)
                        $('#isiprofilnakes').html(htmlprofile)

                    }
                },
                error: function (request, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Error Menampilkan Profil Nakes',
                    })
                }
            });
        }

        // Delegated so it also works for rows injected by DataTables.
        $(document).on('click', '.toprofilingnakes', function (e) {
            e.preventDefault();
            showprofilingnakes($(this).attr('data-id'))
        });

    });
</script>

