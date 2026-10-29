@extends('layouts.adminlte4.back_master')
@section('content')

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="row">
                        <div class="col-lg-6 col-7">
                            <h6>Silahkan Upload File XLSX</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pb-2">
                    <div class="table-responsive">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="row">
                                    <form id="kegiatanForm" enctype="multipart/form-data" action="{{ route('upload.test') }}" method="post" class="form-horizontal">
                                    @csrf
                                        <div class="input-group input-group-outline mb-4">
                                        <label for="name" class="label-control col-md-4">Upload Dokumen Excel</label>
                                        <div class="col-md-8">
                                            <div>
                                                <div id="preview-container">
                                                    <input type="file" id="filekpcpn" name="filekpcpn" accept=".csv" />
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </form>
                                    <div class="form-group">
                                        <div class="progress toshow" style="display:none">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    </div>
    


@endsection
@section('js')


@endsection