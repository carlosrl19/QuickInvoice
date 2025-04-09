@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

{{ $currency = App\Models\Settings::value('default_currency_symbol') }}

@endsection

@section('title')
Créditos rechazados
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
        <a href="#">Listado principal de créditos rechazados</a>
    </li>
</ul>
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
                                <th>Fecha rechazado</th>
                                <th>Crédito #</th>
                                <th>Solicitud</th>
                                <th>Estado</th>
                                <th>Cliente</th>
                                <th>ID</th>
                                <th>Saldo actual</th>
                                <th>Valor cuota</th>
                                <th>Monto préstamo</th>
                                <th>Nº Cuotas</th>
                                <th>Pendiente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                            <tr>
                                <td>
                                    {{ $loan->updated_at }}
                                </td>
                                <td>
                                    {{ $loan->loan_code_number }}
                                </td>
                                <td>
                                    {{ $loan->loan_request_number }}
                                </td>
                                <td>
                                    @if($loan->loan_request_status == 2)
                                    <span class="badge bg-danger2 text-danger fw-bold">RECHAZADO</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $loan->client->client_name }}
                                </td>
                                <td>
                                    {{ $loan->client->client_document }}
                                </td>
                                <td class="text-danger">
                                    <?php
                                    $loan_payment_amount_sum = App\Models\LoanPayments::where('loan_id', $loan->id)->sum('loan_quote_payment_amount');
                                    $actual_debt = $loan->loan_total - $loan_payment_amount_sum;
                                    ?>
                                    {{ $currency }} {{ number_format($actual_debt, 2) }}
                                </td>
                                <td>
                                    {{ $currency }} {{ number_format($loan->loan_quote_value,2) }}
                                </td>
                                <td>
                                    {{ $currency }} {{ number_format($loan->loan_amount, 2) }}
                                </td>
                                <td>{{ $loan->loan_quote_number }} cuotas</td>
                                <td>{{ $currency }} {{ number_format($loan->loan_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include -->
@include('modules.loans.loans_rejected._sweet_alerts')
@endsection

@section('scripts')
<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/loans/dt_loans_index.js') }}"></script>

@endsection