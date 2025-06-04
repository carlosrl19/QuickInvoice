@extends('layouts.app')

@section('head')
@php $currency = App\Models\Settings::value('default_currency_symbol') @endphp
@endsection

@section('title')
POS
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
        <a href="#">POS</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de ventas</a>
    </li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_pos_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Detalles</th>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Tipo venta</th>
                                <th>Estado</th>
                                <th>Tipo pago</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pos_sales as $sale)
                            <tr>
                                <td>
                                    <a href="{{ route('pos_details.pos_details_show', $sale->id) }}" class="btn btn-sm btn-primary btn-border">
                                        <x-heroicon-o-document-text style="width: 20px; height: 20px; color: #2f77f0" />
                                        Factura
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-danger2 text-danger">
                                        {{ $sale->folio_invoice_number }}
                                    </span>
                                </td>
                                <td>{{ $sale->client->client_name }}</td>
                                <td>
                                    {{ $sale->sale_type == 'E' ? 'EXONERADA' : ($sale->sale_type == 'G' ? 'GRAVADA' : 'EXENTA') }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary2 text-secondary">PAGADO</span>
                                </td>
                                <td>
                                    @php
                                    $classes = [
                                    1 => 'bg-success2 text-success',
                                    2 => 'bg-warning2 text-warning',
                                    3 => 'bg-primary2 text-primary',
                                    ];
                                    $class = $classes[$sale->sale_payment_type] ?? 'bg-dark';
                                    @endphp

                                    @php
                                    $paymentTypeText = match($sale->sale_payment_type) {
                                    1 => 'EFECTIVO',
                                    2 => 'TARJETA',
                                    3 => 'DEPOSITO',
                                    4 => 'CHEQUE',
                                    default => 'Tipo desconocido',
                                    };
                                    @endphp

                                    <span class="badge {{ $class }}">{{ $paymentTypeText }}</span>
                                </td>
                                <td>
                                    {{ $currency }} {{ number_format($sale->sale_total_amount,2) }}
                                </td>
                                <td>
                                    {{ $sale->seller->seller_name }}
                                </td>
                                <td>
                                    <span class="badge bg-primary2 text-primary">
                                        {{ $sale->created_at->format('H:i A') }}<br>
                                        {{ $sale->created_at->format('d/m/Y') }}
                                    </span>
                                </td>
                            </tr>

                            <!-- Details Include -->
                            @include('modules.pos_details._sale_details')
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
<script src="{{ Storage::url('customjs/datatables/pos/dt_pos_index.js') }}"></script>

@endsection