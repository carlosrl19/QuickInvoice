@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">
@endsection

@section('title')
Préstamos
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
    <li class="nav-item">
        <a href="#">Préstamos</a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de préstamos</a>
    </li>
</ul>
@endsection

@section('pretitle')
Listado de préstamos
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
                                <th>Creación</th>
                                <th>Código</th>
                                <th>Estado</th>
                                <th>Cliente</th>
                                <th>Monto préstamo</th>
                                <th>Nº Cuotas</th>
                                <th>Total a pagar</th>
                                <th>Deuda actual</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                            <tr>
                                <td>{{ $loan->created_at }}</td>
                                <td>
                                    <a href="{{ route('loans.show', $loan->id) }}">
                                        #{{ $loan->loan_code }}
                                    </a>
                                </td>
                                <td>
                                    @if($loan->loan_status == 0)
                                    <span class="badge bg-success fw-bold">Pagado</span>
                                    @else
                                    <span class="badge bg-warning fw-bold">En proceso</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $loan->client->client_name }}
                                </td>
                                <td>
                                    L. {{ number_format($loan->loan_amount, 2) }}
                                    <sup>
                                        ({{ number_format($loan->loan_tax, 2) }} %)
                                    </sup>
                                </td>
                                <td>{{ $loan->loan_quote_number }} cuotas</td>
                                <td>L. {{ number_format($loan->loan_total, 2) }}</td>
                                <td class="text-danger">
                                    <?php
                                    $loan_payment_amount_sum = App\Models\LoanPayments::where('loan_id', $loan->id)->sum('loan_payment_amount');
                                    $actual_debt = $loan->loan_total - $loan_payment_amount_sum;
                                    ?>
                                    <span class="badge bg-danger text-white fw-bold">
                                        L. {{ number_format($actual_debt, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="input-group-append">
                                        @if($loan->loan_status = 1)
                                        <button class="btn btn-primary btn-sm btn-border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Mas acciones
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#quote_payment_{{ $loan->id }}">Pagar cuota</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#bonus_payment_{{ $loan->id }}">Nuevo abono</a>
                                            <div role="separator" class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loan_termination_{{ $loan->id }}">Finalizar préstamo</a>
                                        </div>
                                        @else
                                        <strong class="text-red">Acción no disponible</strong>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            <!-- Include -->
                            @include('modules.loans_payments._create_payment')
                            @include('modules.loans_payments._create_bonus')
                            @include('modules.loans._get_termination')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include -->
@include('modules.loans._sweet_alerts')
@include('modules.loans._create')
@endsection

@section('scripts')

<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/loans/dt_loans_index.js') }}"></script>

@endsection