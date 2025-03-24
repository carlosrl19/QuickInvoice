@extends('layouts.app')

@section('head')
<style>
    .iframe-doc {
        height: 30rem;
    }

    @media (min-width: 768px) {
        .iframe-doc {
            height: 55rem;
        }
    }
</style>
@endsection

@section('title')
Solicitud crédito <span class="text-muted op-3">/ {{ $loan->client->client_name }}</span>
@endsection

@section('breadcrumb')
<ul class="breadcrumbs mb-1 op-4">
    <li class="nav-home">
        <a href="#">
            <i class="icon-home"></i>
        </a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item d-none d-xl-inline d-lg-inline">
        <a href="#">Créditos</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Estado de cuenta</a>
    </li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('loans.loans_request') }}" class="btn btn-sm btn-danger">
                        <x-heroicon-o-arrow-uturn-left style="width: 15px; height: 15px; color: white" /> Volver
                    </a>
                    <p class="text-center mb-0 d-none d-xl-inline d-lg-inline d-md-inline">
                        Solicitud de crédito / <span class="text-muted">#{{ $loan->loan_request_number }}</span>
                    </p>
                </div>
                <iframe frameborder="0" class="iframe-doc" style="width: 100%;" src="{{ route('loans.loan_request_information_report', $loan->id) }}"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/loans/dt_loans_index.js') }}"></script>

@endsection