{{--
    Modals for the AdminLTE 4 layout.

    Currently only the nurse profiling modal is ported: it is the modal opened
    by the `.toprofilingnakes` links (see layouts/adminlte4/back_footer).
    Markup converted from layouts/minlte/back_modal.blade.php to Bootstrap 5 /
    AdminLTE 4 (data-bs-* attributes, btn-close, no jQuery plugin needed).
--}}
<div class="modal fade" id="profileNakesModal" tabindex="-1" aria-labelledby="juduldetailprofile" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="juduldetailprofile">{{ __('Profile') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="{{ __('Tutup') }}"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-3 col-12">
                        <div class="card card-primary card-outline mb-3">
                            <div class="card-body box-profile text-center">
                                <img class="img-fluid rounded-3 w-100" id="fotodetailnakes" src="" alt="{{ __('Foto Nakes') }}">
                                <hr>
                                <h5 class="profile-username mb-1" id="namadetailnakes">-</h5>
                                <p class="text-muted mb-0" id="profesidetailnakes">-</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 col-12">
                        <div class="card mb-0">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="tab-praktiknakes" data-bs-toggle="tab"
                                                data-bs-target="#praktiknakes" type="button" role="tab"
                                                aria-controls="praktiknakes" aria-selected="true">{{ __('Praktik') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab-profilnakes" data-bs-toggle="tab"
                                                data-bs-target="#profilnakes" type="button" role="tab"
                                                aria-controls="profilnakes" aria-selected="false">{{ __('Profil') }}</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="tab-sejawatnakes" data-bs-toggle="tab"
                                                data-bs-target="#sejawatnakes" type="button" role="tab"
                                                aria-controls="sejawatnakes" aria-selected="false">{{ __('Sejawat') }}</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="praktiknakes" role="tabpanel" aria-labelledby="tab-praktiknakes">
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="tab-salinan1" data-bs-toggle="tab"
                                                        data-bs-target="#nakes-salinan1" type="button" role="tab"
                                                        aria-controls="nakes-salinan1" aria-selected="true">{{ __('Salinan 1') }}</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="tab-salinan2" data-bs-toggle="tab"
                                                        data-bs-target="#nakes-salinan2" type="button" role="tab"
                                                        aria-controls="nakes-salinan2" aria-selected="false">{{ __('Salinan 2') }}</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="tab-salinan3" data-bs-toggle="tab"
                                                        data-bs-target="#nakes-salinan3" type="button" role="tab"
                                                        aria-controls="nakes-salinan3" aria-selected="false">{{ __('Salinan 3') }}</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content pt-3">
                                            @foreach ([1, 2, 3] as $salinan)
                                                <div class="tab-pane fade {{ $salinan === 1 ? 'show active' : '' }}"
                                                     id="nakes-salinan{{ $salinan }}" role="tabpanel"
                                                     aria-labelledby="tab-salinan{{ $salinan }}">
                                                    <div class="row">
                                                        <div class="col-md-12" id="isi-salinan{{ $salinan }}"></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="table-responsive" style="max-height: 300px;">
                                                                <table class="table table-striped" id="histori-salinan{{ $salinan }}">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>#</th>
                                                                            <th>{{ __('Nama Faskes') }}</th>
                                                                            <th>{{ __('Alamat Faskes') }}</th>
                                                                            <th>{{ __('Tanggal Berlaku') }}</th>
                                                                            <th>{{ __('Tanggal Pencabutan') }}</th>
                                                                            <th>{{ __('Alasan') }}</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="histori-isi-salinan{{ $salinan }}"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="profilnakes" role="tabpanel" aria-labelledby="tab-profilnakes">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody id="isiprofilnakes">
                                                    <tr>
                                                        <td style="width:50%">
                                                            <strong><i class="bi bi-book me-1"></i> {{ __('Pendidikan') }}</strong>
                                                            <p class="text-muted">{{ __('Tidak Ada Data Yang Dapat Ditampilkan') }}</p>
                                                            <hr>
                                                            <strong><i class="bi bi-envelope me-1"></i> {{ __('Email') }}</strong>
                                                            <p class="text-muted">{{ __('Tidak Ada Data Yang Dapat Ditampilkan') }}</p>
                                                        </td>
                                                        <td>
                                                            <strong><i class="bi bi-geo-alt me-1"></i> {{ __('Alamat') }}</strong>
                                                            <p class="text-muted">{{ __('Tidak Ada Data Yang Dapat Ditampilkan') }}</p>
                                                            <hr>
                                                            <strong><i class="bi bi-geo-alt me-1"></i> {{ __('Alamat Domisili') }}</strong>
                                                            <p class="text-muted">{{ __('Tidak Ada Data Yang Dapat Ditampilkan') }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="sejawatnakes" role="tabpanel" aria-labelledby="tab-sejawatnakes">
                                        <div class="row" id="listsejawat">
                                            <div class="col-md-12">
                                                <p class="text-muted">{{ __('Tidak Ada Informasi Yang Dapat Ditampilkan Untuk Menu Sejawat') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">{{ __('Tutup') }}</button>
            </div>
        </div>
    </div>
</div>

