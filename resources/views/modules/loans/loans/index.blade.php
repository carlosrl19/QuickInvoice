@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

@php $currency = App\Models\Settings::value('default_currency_symbol') @endphp
@endsection

@section('title')
Créditos vigentes
@endsection

@section('create')
<a href="{{ route('loans.update_quotes_status') }}" class="btn btn-sm btn-label-info btn-round me-2">
    <x-heroicon-o-arrow-path style="width: 20px; height: 20px;" class="bg-label-info" />
    Actualizar estado de préstamos
</a>
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
        <a href="#">Listado principal de créditos</a>
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
                                <th>Acciones</th>
                                <th>Crédito #</th>
                                <th>Solicitud</th>
                                <th>Estado</th>
                                <th>Cliente</th>
                                <th>ID</th>
                                <th>Saldo actual</th>
                                <th>Valor cuota</th>
                                <th>Monto préstamo</th>
                                <th>Nº Cuotas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                            {{ $quote_arrears_counter = App\Models\LoanPayments::where('loan_id', $loan->id)->where('loan_quote_arrears', '>', 0)->count() }}
                            <tr>
                                <td>
                                    <button class="btn btn-sm {{ $quote_arrears_counter > 0 ? 'btn-danger':'btn-primary'  }} btn-border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $quote_arrears_counter > 0 ? 'Cuotas mora (' . $quote_arrears_counter . ')':'Más acciones' }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('loan_payments.new_pay', $loan->id) }}">
                                            @if($quote_arrears_counter > 0)
                                            <span class="text-danger">Abonar cuotas atrasadas</span>
                                            @else
                                            Abonar
                                            @endif
                                        </a>
                                        <div role="separator" class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="{{ route('loans.loan_receipt_delivery_show', $loan->id) }}">Comprobante entrega</a>
                                        <a class="dropdown-item" href="{{ route('loans.loan_account_statement_show', $loan->id) }}">Estado de cuenta</a>
                                        <a class="dropdown-item" href="{{ route('loans.loan_payment_plan_show', $loan->id) }}">Plan de pagos</a>
                                        <div role="separator" class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" id="loan_cancellation{{ $loan->id }}">Anular</a>
                                    </div>
                                </td>
                                <td>
                                    {{ $loan->loan_code_number }}
                                </td>
                                <td>
                                    {{ $loan->loan_request_number }}
                                </td>
                                <td>
                                    @if($loan->loan_status == 0)
                                    <span class="badge bg-dark text-white fw-bold">SOLICITUD EN ESPERA</span>
                                    @elseif($loan->loan_status == 1)
                                    <span class="badge bg-warning2 text-warning fw-bold">EN PROCESO</span>
                                    @elseif($loan->loan_status == 2)
                                    <span class="badge bg-success2 text-success fw-bold">PAGADO</span>
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
                                    $loan_payment_amount_sum = App\Models\LoanPayments::where('loan_id', $loan->id)->where('loan_quote_payment_status', 1)->sum('loan_quote_payment_amount');
                                    $actual_debt = $loan->loan_total - $loan_payment_amount_sum;
                                    ?>
                                    <span class="badge bg-danger2 text-danger">{{ $currency }} {{ number_format($actual_debt, 2) }}</span>
                                </td>
                                <td>
                                    {{ $currency }} {{ number_format($loan->loan_quote_value,2) }}
                                </td>
                                <td>
                                    {{ $currency }} {{ number_format($loan->loan_amount, 2) }}
                                </td>
                                <td>
                                    {{ $loan->loan_quote_number }} cuotas
                                </td>
                            </tr>

                            <!-- Include -->
                            @include('modules.loans.loans._sweet_alerts')
                            @endforeach
                        </tbody>
                    </table>
                </div>
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