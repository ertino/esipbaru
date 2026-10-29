@extends('layouts.adminlte4.back_master')

@section('title', 'General Elements')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline mb-4">
                <div class="card-header"><div class="card-title">Alerts</div></div>
                <div class="card-body">
                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                        <i class="bi bi-info-circle me-1"></i> Info alert with dismiss.
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    <div class="alert alert-warning mb-0">Warning alert.</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-success card-outline mb-4">
                <div class="card-header"><div class="card-title">Callouts and buttons</div></div>
                <div class="card-body">
                    <div class="callout callout-info">A callout for highlighting notes.</div>
                    <button class="btn btn-primary">Primary</button>
                    <button class="btn btn-success">Success</button>
                    <button class="btn btn-danger">Danger</button>
                </div>
            </div>
        </div>
    </div>
@endsection