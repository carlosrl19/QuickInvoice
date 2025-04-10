@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

@php
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
@endphp

@endsection

@section('title')
Bancos
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
        <a href="#">Bancos</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de bancos</a>
    </li>
</ul>
@endsection

@section('create')
<a href="#" class="btn btn-sm btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_bank">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear banco
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_banks_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Titular de cuenta</th>
                                <th>Nombre banco</th>
                                <th>Nº de cuenta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banks as $bank)
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-danger text-white" id="delete_bank{{ $bank->id }}">
                                        <x-heroicon-o-trash style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#update_bank{{ $bank->id }}">
                                        {{ $bank->account_name }}
                                    </a>
                                </td>
                                <td>{{ $bank->bank_name }}</td>
                                <td>
                                    {{ $bank->bank_account_number }}
                                </td>
                            </tr>

                            <!-- Update/Delete include -->
                            @include('modules.banks._update')
                            @include('modules.banks._sweet_alerts')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Includes -->
@include('modules.banks._create')

@endsection

@section('scripts')
<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/banks/dt_banks_index.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Banks\StoreRequest', '#create_bank_form') !!}

@endsection