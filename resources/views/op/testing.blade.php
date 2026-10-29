@extends('layouts.adminlte4.back_master')
@section('content')
<div class="content-wrapper" style="min-height: 1416.8125px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Selamat Datang e-SIP</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- COLOR PALETTE -->

        <div class="row">
            <div class="col-md-12">
                <div class="card card-default">
                    <div class="card-header">
                        <h3 class="card-title">bs-stepper</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="bs-stepper linear">
                            <div class="bs-stepper-header" role="tablist">
                                <div class="step" data-bs-target="#lokasi-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="lokasi-part" id="lokasi-part-trigger" aria-selected="false" disabled="disabled">
                                        <span class="bs-stepper-circle">1</span>
                                        <span class="bs-stepper-label">Lokasi</span>
                                    </button>
                                </div>
                                <div class="line">
                                </div>
                                <div class="step active" data-bs-target="#information-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="information-part" id="information-part-trigger" aria-selected="true">
                                        <span class="bs-stepper-circle">2</span>
                                        <span class="bs-stepper-label">Dokumen</span>
                                    </button>
                                </div>
                                <div class="step" data-bs-target="#jadwal-part">
                                    <button type="button" class="step-trigger" role="tab" aria-controls="jadwal-part" id="jadwal-part-trigger" aria-selected="true">
                                        <span class="bs-stepper-circle">3</span>
                                        <span class="bs-stepper-label">Jadwal Praktik</span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content">
                                <div id="lokasi-part" class="content" role="tabpanel" aria-labelledby="lokasi-part-trigger">
                                    <div class="form-group">
                                        
                                    </div>
                                    <div class="form-group">
                                        
                                    </div>
                                    <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                                </div>
                                <div id="information-part" class="content" role="tabpanel" aria-labelledby="information-part-trigger">
                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                    <button class="btn btn-primary" onclick="stepper.next()">Next</button>
                                </div>
                                <div id="jadwal-part" class="content" role="tabpanel" aria-labelledby="jadwal-part-trigger">
                                    <div class="form-group">
                                        <label for="exampleInputFile">File input</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile">
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Upload</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary" onclick="stepper.previous()">Previous</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">

                    </div>
                </div>

            </div>
        </div>
        </div><!-- /.container-fluid -->
    </section>
</div>
  


  

@endsection
@section('js')

@endsection