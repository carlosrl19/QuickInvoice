@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">

@endsection

@section('title')
Consignaciones
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
        <a href="#">Consignaciones</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de consignaciones</a>
    </li>
</ul>
@endsection

@section('create')
<a href="#" class="btn btn-sm btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_consignment">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear consignación
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_consignments_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Fecha creación</th>
                                <th>Código</th>
                                <th>Monto total</th>
                                <th>Consignatario</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consignments as $consignment)
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-danger text-white" id="delete_consignment{{ $consignment->id }}">
                                        <x-heroicon-o-trash style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $consignment->consignment_date }}</span>
                                </td>
                                <td>#{{ $consignment->consignment_code }}</td>
                                <td>L. {{ number_format($consignment->consignment_amount,2) }}</td>
                                <td>{{ $consignment->person_name }}<br><span class="text-muted">{{ $consignment->person_dni }}</span></td>
                                <td>
                                    <a href="{{ route('consignments.show', $consignment->id) }}" class="badge bg-danger text-white">
                                        <x-heroicon-o-printer style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                            </tr>
                            @include('modules.consignments._sweet_alerts')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Includes -->
@include('modules.consignments._create')

@endsection

@section('scripts')

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/consignments/dt_consignments_index.js') }}"></script>

<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! $validator !!}

@endsection