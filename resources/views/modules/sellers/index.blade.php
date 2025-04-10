@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

@php
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
@endphp

@endsection

@section('title')
Vendedores
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
        <a href="#">Vendedores</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de vendedores</a>
    </li>
</ul>
@endsection

@section('create')
<a href="#" class="btn btn-sm btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_seller">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear vendedor
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_clients_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Nº ventas</th>
                                <th>Nombre vendedor</th>
                                <th>Documento</th>
                                <th>Teléfono</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sellers as $seller)
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-danger text-white" id="delete_seller{{ $seller->id }}">
                                        <x-heroicon-o-trash style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-primary2 text-primary">{{ $seller->pos->count() > 1 ? $seller->pos->count() . ' ventas': $seller->pos->count() .' venta' }}</span>
                                </td>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#update_seller{{ $seller->id }}">
                                        {{ $seller->seller_name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $seller->seller_document }}
                                </td>
                                <td>
                                    {{ $seller->seller_phone }}
                                </td>
                            </tr>

                            <!-- Update/Delete include -->
                            @include('modules.sellers._update')
                            @include('modules.sellers._sweet_alerts')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Includes -->
@include('modules.sellers._create')

@endsection

@section('scripts')
<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/clients/dt_clients_index.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Sellers\StoreRequest', '#create_seller_form') !!}

@endsection