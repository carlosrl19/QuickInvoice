@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">

@php
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
@endphp

@endsection

@section('title')
Créditos vigentes
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
        <a href="#"># {{ $loan->loan_code_number }}</a>
    </li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('loan_payments.quote_payment', $loan->id)}}" method="POST" autocomplete="off" spellcheck="false">
                    @csrf
                    <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                    <input type="hidden" name="loan_quote_payment_amount" value="{{ $loan->loan_quote_value }}">
                    <input type="hidden" name="loan_old_debt" value="1">
                    <input type="hidden" name="loan_new_debt" value="0">
                    <input type="hidden" name="loan_quote_arrears" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="loan_quote_payment_status" value="1">
                    <input type="hidden" name="loan_quote_payment_date" value="{{ Carbon\Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d') }}">

                    <div class="row">
                        <div style="background-color: #d1eef6;" class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-xs-12">
                            <div class="row mb-3 mt-4">
                                <h5 class="text-center">Saldo actual <strong>L. {{ number_format($actual_debt, 2) }}</strong></h5>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating" style="background-color: #fff !important;">
                                        <input type="text" class="form-control" style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                            readonly value="L. {{ number_format($totalToPay - $loan->loan_quote_value,2) }}">
                                        <label for="loan_quote_arrears">Mora</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating" style="background-color: #fff !important;">
                                        <input type="text" class="form-control" style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                            readonly value="L. {{ number_format($loan->loan_quote_value,2) }}">
                                        <label for="loan_quote_amount">Total</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating" style="background-color: #fff !important;">
                                        <input type="text" class="form-control" value="L. {{ number_format($totalToPay,2) }}" style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                            readonly>
                                        <label for="loan_quote_total_amount">Monto a abonar</label>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                PLAN DE PAGOS
                            </div>

                            <div class="table-responsive" style="max-height: 32rem;">
                                <table id="dt_loan_payments_history" class="display table table-responsive table-striped">
                                    <thead>
                                        <tr class="text-center" style="position: sticky; top: 0px;">
                                            <th style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; color: #fff; font-weight: bold">#</th>
                                            <th style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; color: #fff; font-weight: bold">FECHA PAGO</th>
                                            <th style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; color: #fff; font-weight: bold">CUOTA</th>
                                            <th style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; color: #fff; font-weight: bold">MORA</th>
                                            <th style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; color: #fff; font-weight: bold">TOTAL</th>
                                            <th style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; color: #fff; font-weight: bold">PAGADO</th>
                                            <th style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; color: #fff; font-weight: bold">PENDIENTE</th>
                                            <th style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; color: #fff; font-weight: bold">ESTADO</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($loan_payments as $index => $loan_payment)
                                        <tr class="text-center" style="max-height: 22rem; overflow: auto;">
                                            <td style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; line-height: 0.5rem !important;">{{ $index + 1 }}</td>
                                            <td style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; line-height: 0.5rem !important;">{{ $loan_payment->loan_quote_payment_date }}</td>
                                            <td style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; line-height: 0.5rem !important;">{{ number_format($loan_payment->loan_quote_payment_amount,2) }}</td>
                                            <td style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; line-height: 0.5rem !important;">{{ number_format($loan_payment->loan_quote_arrears,2) }}</td>
                                            <td style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; line-height: 0.5rem !important;">{{ number_format($loan_payment->loan_quote_payment_amount + $loan_payment->loan_quote_arrears,2) }}</td>
                                            <td style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; line-height: 0.5rem !important;">
                                                @if($loan_payment->loan_quote_payment_status == 0 || $loan_payment->loan_quote_payment_status == 2)
                                                0.00
                                                @else
                                                {{ number_format($loan_payment->loan_quote_payment_received - $loan_payment->loan_quote_payment_change,2) }}
                                                @endif
                                            </td>
                                            <td style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; line-height: 0.5rem !important;">
                                                @if($loan_payment->loan_quote_payment_status == 0 || $loan_payment->loan_quote_payment_status == 2)
                                                {{ number_format($loan_payment->loan_quote_payment_amount + $loan_payment->loan_quote_arrears,2) }}
                                                @else
                                                0.00
                                                @endif
                                            </td>
                                            <td style="font-size: clamp(0.80rem, 3vw, 0.82rem) !important; line-height: 0.5rem !important;">
                                                @if($loan_payment->loan_quote_payment_status == 0)
                                                <span class="badge bg-dark text-white fw-bold">PENDIENTE</span>
                                                @elseif($loan_payment->loan_quote_payment_status == 1)
                                                <span class="badge bg-success text-white fw-bold">PAGADO</span>
                                                @else
                                                <span class="badge bg-danger text-white fw-bold">MORA</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="display table">
                                    <tfoot>
                                        <tr class="text-center fw-bold">
                                            <td style="background-color: #1879d5; color: white; font-size: clamp(0.80rem, 3vw, 0.82rem);"></td>
                                            <td style="background-color: #1879d5; color: white; font-size: clamp(0.80rem, 3vw, 0.82rem);"></td>
                                            <td style="background-color: #1879d5; color: white; font-size: clamp(0.80rem, 3vw, 0.82rem);">
                                                <x-heroicon-o-calendar-days style="width: 20px; height: 20px; color: white;" />
                                                TOTAL PRESTAMO: L. {{ number_format($loan->loan_total,2)}}
                                            </td>
                                            <td style="background-color: #1879d5; color: white; font-size: clamp(0.80rem, 3vw, 0.82rem);">
                                                <x-heroicon-o-calendar-days style="width: 20px; height: 20px; color: white;" />
                                                TOTAL PAGADO: L. {{ number_format($loan->loan_total - $actual_debt,2)}}
                                            </td>
                                            <td style="background-color: #1879d5; color: white; font-size: clamp(0.80rem, 3vw, 0.82rem);">
                                                <x-heroicon-o-calendar-days style="width: 20px; height: 20px; color: white;" />
                                                DEUDA ACTUAL: L. {{ number_format($actual_debt,2) }}
                                            </td>
                                            <td style="background-color: #1879d5; color: white; font-size: clamp(0.80rem, 3vw, 0.82rem);"></td>
                                            <td style="background-color: #1879d5; color: white; font-size: clamp(0.80rem, 3vw, 0.82rem);"></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-xs-12">
                            <div class="row mb-3">
                                <div class="col">
                                    <select class="tom-select @error('loan_quote_payment_mode') is-invalid @enderror" id="loan_quote_payment_mode_select" name="loan_quote_payment_mode">
                                        <option value="" selected disabled>Seleccione el método de pago</option>
                                        <option value="1" {{ old('loan_quote_payment_mode') == '1' ? 'selected':'' }}>Efectivo HNL</option>
                                        <option value="2" {{ old('loan_quote_payment_mode') == '2' ? 'selected':'' }}>Cheque HNL(X)</option>
                                        <option value="3" {{ old('loan_quote_payment_mode') == '3' ? 'selected':'' }}>Depósito bancario(X)</option>
                                        <option value="4" {{ old('loan_quote_payment_mode') == '4' ? 'selected':'' }}>Dólar(X)</option>
                                        <option value="5" {{ old('loan_quote_payment_mode') == '5' ? 'selected':'' }}>Tarjeta HNL</option>
                                    </select>
                                    @error('loan_quote_payment_mode')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="number" class="form-control @error('loan_quote_payment_received') is-invalid @enderror" step="any" name="loan_quote_payment_received" id="loan_quote_payment_received" value="{{ old('loan_quote_payment_received') ?? 0 }}" oninput="calcularCambio()">
                                        @error('loan_quote_payment_received')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                        <label for="loan_quote_payment_received">Recibido <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" name="quote_value" id="quote_value"
                                            style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                            value="{{ $totalToPay }}" readonly>
                                        <label for="">Valor cuota <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <!-- Dollar options -->
                            <div id="dolar_option_selected" style="display: none;">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="form-floating input-group">
                                            <input type="number" class="form-control" value="0.000" name="tasa_cambio" id="tasa_cambio" oninput="calcularMoneda()">
                                            <label for="tasa_cambio" style="z-index: 5">Tasa cambio <span class="text-danger">*</span></label>
                                            <a title="Ver tasa de cambio actual" data-bs-toggle="tooltip" data-bs-placement="right" class="btn btn-success text-white d-flex justify-content-center align-items-center" href="https://www.google.com/finance/quote/USD-HNL" target="_blank">
                                                <x-heroicon-o-currency-dollar style="width: 25px; height: 25px; color: white;" />
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="number" value="0.000" style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" readonly class="form-control" name="dolar_a_hnl" id="dolar_a_hnl">
                                            <label for="dolar_a_hnl">Dolar a HNL</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card options -->
                            <div id="card_option_selected" style="display: none;">
                                <div class="row mb-3">
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" class="form-control @error('card_last_digits') is-invalid @enderror" value="" minlength="4" maxlength="4" name="card_last_digits" id="card_last_digits">
                                            @error('card_last_digits')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                            @enderror
                                            <label for="card_last_digits" style="z-index: 5">Ultimos 4 digitos<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-floating">
                                            <input type="text" class="form-control @error('card_auth_number') is-invalid @enderror" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')" value="" minlength="6" maxlength="12" name="card_auth_number" id="card_auth_number">
                                            @error('card_auth_number')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                            @enderror
                                            <label for="card_auth_number" style="z-index: 5">Nº autorización<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('loan_quote_payment_change') is-invalid @enderror" name="loan_quote_payment_change" id="loan_quote_payment_change" value="{{ old('loan_quote_payment_change') ?? 0 }}" style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" readonly>
                                        @error('loan_quote_payment_change')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                        <label for="loan_quote_payment_change">Cambio</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <a href="{{ route('loans.index') }}" class="btn btn-sm btn-danger w-100">
                                        <x-heroicon-o-arrow-uturn-left style="width: 15px; height: 15px; color: white" />
                                        &nbsp;Atrás
                                    </a>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-sm btn-primary w-100">
                                        <x-heroicon-o-check style="width: 15px; height: 15px; color: white" />
                                        &nbsp;Procesar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Include -->
@include('modules.loans.loans._sweet_alerts')
@endsection

@section('scripts')

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/loans/dt_loan_payments_history.js') }}"></script>

<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\LoanPayments\StoreRequest') !!}

<!-- Dolar to HNL -->
<script>
    function calcularMoneda() {
        const cuota = document.getElementById('quote_value').value;
        const tasaCambio = document.getElementById('tasa_cambio').value;
        const lempiras = document.getElementById('dolar_a_hnl');

        if (cuota && tasaCambio) {
            const resultado = parseFloat(cuota) / parseFloat(tasaCambio);
            lempiras.value = resultado.toFixed(2);
        } else {
            lempiras.value = '';
        }
    }

    // Llama a la función al cargar la página o cuando cambie la tasa de cambio
    document.addEventListener('DOMContentLoaded', calcularMoneda);
    document.getElementById('tasa_cambio').addEventListener('input', calcularMoneda);
</script>

<!-- Cambio monetario del cliente -->
<script>
    function calcularCambio() {
        const paymentReceived = document.getElementById('loan_quote_payment_received').value;
        const quoteValue = document.getElementById('quote_value').value;
        const cambio = document.getElementById('loan_quote_payment_change');

        if (paymentReceived && quoteValue) {
            const resultado = parseFloat(paymentReceived) - parseFloat(quoteValue);
            cambio.value = resultado.toFixed(2);
        } else {
            cambio.value = '';
        }
    }
</script>

<!-- Ocultar tasa cambio si no es seleccionado Dolar -->
<script>
    document.getElementById('loan_quote_payment_mode_select').addEventListener('change', function() {
        const seleccionado = this.value;
        const dolar_option = document.getElementById('dolar_option_selected');
        const card_option = document.getElementById('card_option_selected');

        if (seleccionado === '4') {
            dolar_option.style.display = 'block';
        } else {
            dolar_option.style.display = 'none';
        }

        if (seleccionado === '5') {
            card_option.style.display = 'block';
        } else {
            card_option.style.display = 'none';
        }
    });
</script>
@endsection