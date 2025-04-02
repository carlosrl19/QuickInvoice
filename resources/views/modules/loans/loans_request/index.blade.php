@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">
@endsection

@section('title')
Solicitud de créditos
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
        <a href="#">Solicitud de créditos</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de solicitudes</a>
    </li>
</ul>
@endsection

@section('create')
<a href="#" class="btn btn-sm btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_loan">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear préstamo
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_loans_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Creación</th>
                                <th>Solicitud</th>
                                <th>Estado</th>
                                <th>Cliente</th>
                                <th>ID</th>
                                <th>Monto préstamo</th>
                                <th>Nº Cuotas</th>
                                <th>Total a pagar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                            <tr>
                                <td>
                                    <button class="btn btn-sm btn-primary btn-border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Más acciones
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" id="confirm_request{{ $loan->id }}">Aceptar solicitud</a>
                                        <a class="dropdown-item" href="#" id="reject_request{{ $loan->id }}">Rechazar solicitud</a>
                                        <div role="separator" class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('loans.loan_request_information_show', $loan->id) }}">Información solicitud</a>
                                        <div role="separator" class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" id="delete_request{{ $loan->id }}">Eliminar solicitud</a>
                                    </div>
                                </td>
                                <td>{{ $loan->created_at }}</td>
                                <td>
                                    {{ $loan->loan_request_number }}
                                </td>
                                <td>
                                    @if($loan->loan_status == 0)
                                    <span class="badge bg-dark fw-bold">SOLICITUD EN ESPERA</span>
                                    @elseif($loan->loan_status == 1)
                                    <span class="badge bg-warning fw-bold">EN PROCESO</span>
                                    @elseif($loan->loan_status == 2)
                                    <span class="badge bg-success fw-bold">PAGADO</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $loan->client->client_name }}
                                </td>
                                <td>
                                    {{ $loan->client->client_document }}
                                </td>
                                <td>
                                    L. {{ number_format($loan->loan_amount, 2) }}
                                </td>
                                <td>{{ $loan->loan_quote_number }} cuotas</td>
                                <td>L. {{ number_format($loan->loan_total, 2) }}</td>
                            </tr>

                            <!-- Include -->
                            @include('modules.loans.loans_request._sweet_alerts')

                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modules.loans.loans_request._create')
@endsection

@section('scripts')

<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/loans/dt_loans_index.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.min.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Loans\StoreRequest') !!}

@endsection