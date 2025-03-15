@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Venobox -->
<link href="{{ Storage::url('assets/js/plugin/venobox/venobox.min.css') }}" rel="stylesheet">

<!-- CSS ul -->
<style>
    ul {
        list-style-type: none;
        /* Elimina los puntos de la lista */
        padding: 0;
        /* Elimina el padding por defecto */
    }

    .row {
        display: flex;
        /* Utiliza flexbox para alinear los elementos */
        justify-content: space-between;
        /* Espacio entre columnas */
    }

    .row strong {
        flex-basis: 50%;
        /* Ancho del texto fuerte */
    }

    .row span {
        flex-basis: 50%;
        /* Ancho del dato */
    }
</style>
@endsection

@section('title')
Créditos
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
        <a href="#">Créditos</a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">#{{ $loan->loan_code_number }}</a>
    </li>
</ul>
@endsection

@section('create')
<!-- Botones para abrir los modales -->
<a href="#" data-bs-toggle="modal" data-bs-target="#loan_request_report{{ $loan->id }}" class="btn btn-sm btn-danger">
    <x-heroicon-o-document-text style="width: 20px; height: 20px; color: white" />
    &nbsp;Solicitud de préstamo
</a>

<a href="#" data-bs-toggle="modal" data-bs-target="#loan_payment_plan_report{{ $loan->id }}" class="btn btn-sm btn-secondary">
    <x-heroicon-o-document-text style="width: 20px; height: 20px; color: white" />
    &nbsp;Plan de pagos
</a>

<a href="#" data-bs-toggle="modal" data-bs-target="#loan_history_payments{{ $loan->id }}" class="btn btn-sm btn-warning text-white">
    <x-heroicon-o-document-text style="width: 20px; height: 20px; color: white" />
    &nbsp;Historial de pagos
</a>
@endsection

@section('content')
<div class="row">
    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header fw-bold">
            <p class="offcanvas-title fw-bold" id="offcanvasExampleLabel">Información del préstamo</p>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="table-responsive">
                <table class="display table table-responsive">
                    <tbody>
                        <tr>
                            <td><strong>Cliente:</strong></td>
                            <td class="text-muted">
                                <strong>{{ $loan->client->client_name }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Documento</strong></td>
                            <td class="text-muted">{{ $loan->client->client_document }}</td>
                        </tr>
                        <tr>
                            @if($loan->client->client_phone2 == '')
                            <td><strong>Teléfono</strong></td>
                            <td class="text-muted">{{ $loan->client->client_phone1 }}</td>
                            @else
                            <td><strong>Teléfonos</strong></td>
                            <td class="text-muted">{{ $loan->client->client_phone1 }}, {{ $loan->client->client_phone2 }}</td>
                            @endif
                        </tr>
                        <tr>
                            <td><strong>Código préstamo</strong></td>
                            <td class="text-muted">{{ $loan->loan_code_number }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha creación</strong></td>
                            <td class="text-muted">{{ $loan->created_at }}</td>
                        </tr>
                        <tr>
                            <td><strong>Tipo de pago</strong></td>
                            <td class="text-muted">
                                @if ($loan->loan_payment_type == 1)
                                <span>DIARIO</span>
                                @elseif ($loan->loan_payment_type == 2)
                                <span>SEMANAL</span>
                                @elseif ($loan->loan_payment_type == 3)
                                <span>QUINCENAL</span>
                                @else
                                <span>MENSUAL</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Fecha primer pago</strong></td>
                            <td class="text-muted">{{ $loan->loan_start_date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Fecha último pago (previsto)</strong></td>
                            <td class="text-muted">{{ $loan->loan_end_date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Préstamo</strong></td>
                            <td class="text-muted">L. {{ number_format($loan->loan_amount, 2) }}
                                ({{ number_format($loan->loan_interest, 0) }}%)</td>
                        </tr>
                        <tr>
                            <td><strong>Prima</strong></td>
                            <td class="text-muted">L. {{ number_format($loan->loan_down_payment, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total a pagar</strong></td>
                            <td class="text-muted">L. {{ number_format($loan->loan_total, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Nº cuotas</strong></td>
                            <td class="text-muted">{{ $loan->loan_quote_number }} x {{ number_format($loan->loan_quote_value, 2) }} c/u</td>
                        </tr>
                        <tr>
                            <td><strong>Pagado</strong></td>
                            <td class="text-muted">L. {{ number_format($loan_payment_amount_sum, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Deuda actual</strong></td>
                            <td class="text-muted">L. {{ number_format($actual_debt, 2) }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td><strong>Comentarios</strong></td>
                            <td class="text-muted">{{ $loan->loan_description }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-xl-12 col-lg-12">
        <div class="card">
            <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                <span>
                    <a data-bs-toggle="offcanvas" href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <x-heroicon-o-information-circle style="width: 25px; height: 25px; color: lightgray" />
                    </a>
                    &nbsp;Historial de pagos / <span class="op-3">#{{ $loan->loan_code_number }} / {{ $loan->client->client_name }}</span>
                </span>
                <div>
                    @if($actual_debt > 0 && $actual_debt < $loan->loan_quote_value)
                        <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#bonus_payment_{{ $loan->id }}">
                            <x-heroicon-o-plus style="width: 20px; height: 20px; color: white" />
                            &nbsp;Nuevo abono
                        </a>
                    @elseif($actual_debt > 0 && $actual_debt >= $loan->loan_quote_value)
                        <a href="#" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#quote_payment_{{ $loan->id }}">
                            <x-heroicon-o-plus style="width: 20px; height: 20px; color: white" />
                            &nbsp;Nuevo pago
                        </a>
                        <a class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#bonus_payment_{{ $loan->id }}">
                            <x-heroicon-o-plus style="width: 20px; height: 20px; color: white" />
                            &nbsp;Nuevo abono
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-3 align-items-end">
                    <div class="table-responsive">
                        <table id="dt_loan_payments_history" class="display table table-responsive table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>RECIBO</th>
                                    <th>COMPR.</th>
                                    <th>FECHA</th>
                                    <th>TIPO DE PAGO</th>
                                    <th>COMENTARIO</th>
                                    <th>DEUDA ACT.</th>
                                    <th>MONTO</th>
                                    <th>NUEVA DEUDA</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($loan_payments as $loan_payment)
                                <tr class="text-center">
                                    <td>
                                        <a href="{{ route('loans.loan_receipt_report', ['id' => $loan->id, 'payment_id' => $loan_payment->id]) }}" data-bs-toggle="modal" data-bs-target="#loan_pdf_receipt"
                                            class="badge bg-danger me-1 text-white">
                                            <x-heroicon-o-printer style="width: 20px; height: 20px; color: white" />
                                        </a>
                                    </td>
                                    <td>
                                        @if ($loan_payment->loan_payment_img)
                                        <div class="d-flex flex-wrap justify-content-center">
                                            @foreach (json_decode($loan_payment->loan_payment_img) as $image)
                                            <div class="mx-2 my-1">
                                                <a class="loan_payment_img" data-gall="loan_payment_gallery"
                                                    title="# RP{{ $loan_payment->loan_payment_doc_number }} -> P #{{ $loan->loan_code_number }} - {{ $loan->client->client_name }}"
                                                    data-fitview="true"
                                                    href="{{ Storage::url('uploads/loan_payments/' . $loan->loan_code_number . '/' . $image) }}">
                                                    <img id="image-preview"
                                                        style="border: 1px solid #e3e3e3; border-radius: 5px; padding: 5px;"
                                                        src="{{ Storage::url('uploads/loan_payments/' . $loan->loan_code_number . '/' . $image) }}"
                                                        alt="" width="30" height="30">
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                        @else
                                        <span class="text-muted">N/D</span>
                                        @endif
                                    <td>{{ $loan_payment->loan_payment_date }}</td>
                                    <td>
                                        @if($loan_payment->loan_payment_type == 0)
                                        <span class="badge bg-success">CUOTA</span>
                                        @else
                                        <span class="badge bg-warning">ABONO</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="{{ $loan_payment->loan_payment_comment ? 'text-dark' : 'text-muted' }}">
                                            {{ $loan_payment->loan_payment_comment ? $loan_payment->loan_payment_comment : 'N/D' }}
                                        </span>
                                    </td>
                                    <td>L. {{ number_format($loan_payment->loan_old_debt, 2) }}</td>
                                    <td>L. {{ number_format($loan_payment->loan_payment_amount, 2) }}</td>
                                    <td>L. {{ number_format($loan_payment->loan_new_debt, 2) }}</td>
                                </tr>

                                <!-- Include -->
                                @include('modules.loans_payments._loan_payment_receipt_modal')
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-muted text-center">
                                    <td colspan="5"></td>
                                    @if($actual_debt == 0.00)
                                    <td>---</td>
                                    <td class="bg-success">
                                        <span class="fw-bold text-white">PAGADO</span>
                                    </td>
                                    @else
                                    <td colspan="2" class="bg-dark fw-bold text-white">TOTAL DEUDA</td>
                                    <td class="bg-dark">
                                        <span class="fw-bold text-white">L.
                                            {{ number_format($actual_debt, 2) }}</span>
                                    </td>
                                    @endif
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include -->
@include('modules.loans._sweet_alerts')
@include('modules.loans_payments._create_payment')
@include('modules.loans_payments._create_bonus')
@include('modules.loans.pdf_viewer')
@endsection

@section('scripts')

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/loans/dt_loan_payments_history.js') }}"></script>

<!-- Venobox -->
<script src="{{ Storage::url('assets/js/plugin/venobox/venobox.min.js') }}"></script>
<script src="{{ Storage::url('customjs/venobox/vb_loan_payments.js') }}"></script>

<!-- Receipt Modal -->
<script>
    $('#loan_pdf_receipt').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Botón que activó el modal
        var url = button.attr('href'); // Extraer la información de los atributos data-*
        var modal = $(this);
        modal.find('#loan_pdf_receipt_iframe').attr('src', url);
    });

    $('#loan_pdf_receipt').on('hidden.bs.modal', function(e) {
        $(this).find('#loan_pdf_receipt_iframe').attr('src', '');
    });
</script>
@endsection