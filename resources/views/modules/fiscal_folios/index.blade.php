@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- IMask.JS -->
<script src="{{ Storage::url('assets/js/plugin/imask/imask.js') }}"></script>

@php
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
@endphp

@endsection

@section('title')
Folios
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
        <a href="#">Folios</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de folios</a>
    </li>
</ul>
@endsection

@section('create')
<a href="#" class="btn btn-sm btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_folio">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear folio
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_folios_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Uso</th>
                                <th>Estado</th>
                                <th>Días validez</th>
                                <th>Total facturas</th>
                                <th>Rango inicial-final autorizado</th>
                                <th>Fecha limite emisión</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fiscal_folios as $folio)
                            <tr>
                                <td>
                                    @if($folio->folio_validation_status == 1 && $folio->folio_status == 0 && $folio->folio_total_invoices_available > 0)
                                    <a href="#" class="badge bg-primary text-white" id="use_folio{{ $folio->id }}">
                                        <x-heroicon-o-arrow-right-end-on-rectangle style="width: 20px; height: 20px; color: white;" />
                                        Usar folio
                                    </a>
                                    @elseif($folio->folio_total_invoices_available == 0 && $folio->folio_status == 1)
                                    <x-heroicon-o-exclamation-circle style="width: 20px; height: 20px; color: red" />
                                    Limite facturación alcanzado
                                    @elseif($folio->folio_total_invoices_available == 0 && $folio->folio_status == 0)
                                    <x-heroicon-o-minus-circle style="width: 20px; height: 20px; color: orange" />
                                    @else
                                    <x-heroicon-o-check-circle style="width: 20px; height: 20px; color: green" />
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $folio->folio_validation_status == 1 && $folio->folio_total_invoices_available > 0 ? 'bg-success':'bg-danger' }}">
                                        {{ $folio->folio_validation_status == 1 && $folio->folio_total_invoices_available > 0 ? 'VALIDO':'NO DISPONIBLE' }}
                                    </span>
                                </td>
                                <td>
                                    {{ number_format(Carbon\Carbon::now()->diffInDays($folio->folio_authorized_emission_date,0)) }} días
                                </td>
                                <td><span class="{{ $folio->folio_total_invoices_available > 0 ? 'text-primary':'text-danger'  }}">{{ $folio->folio_total_invoices_available }}</span> / {{ $folio->folio_total_invoices }}</td>
                                <td><span class="badge bg-dark text-white">{{ $folio->folio_authorized_range_start }}</span> A <span class="badge bg-dark text-white">{{ $folio->folio_authorized_range_end }}</span></td>
                                <td>{{ $folio->folio_authorized_emission_date }}</td>
                            </tr>
                            @include('modules.fiscal_folios._sweet_alerts')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Includes -->
@include('modules.fiscal_folios._create')

@endsection

@section('scripts')

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/fiscal_folios/dt_folios_index.js') }}"></script>

<!-- IMask.JS -->
<script src="{{ Storage::url('customjs/imask/fiscal_folios/imask_fiscal_folios.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\FiscalFolios\StoreRequest') !!}

@endsection