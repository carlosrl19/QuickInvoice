@extends('layouts.app')

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
                                <th>Fecha</th>
                                <th>Tipo pago</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pos_sales as $sale)
                            <tr>
                                <td>
                                    {{ $sale->created_at }}
                                </td>
                                <td>
                                    @php
                                    $classes = [
                                    1 => 'bg-success',
                                    2 => 'bg-warning',
                                    3 => 'bg-primary',
                                    ];
                                    $class = $classes[$sale->sale_payment_type] ?? 'bg-dark';
                                    @endphp

                                    @php
                                    $paymentTypeText = match($sale->sale_payment_type) {
                                    1 => 'EFECTIVO',
                                    2 => 'TARJETA',
                                    3 => 'DEPOSITO',
                                    default => 'Tipo desconocido',
                                    };
                                    @endphp

                                    <span class="badge {{ $class }}">{{ $paymentTypeText }}</span>
                                </td>
                                <td>
                                    L. {{ number_format($sale->sale_total_amount,2) }}
                                </td>
                                <td>
                                    {{ $sale->seller->seller_name }}
                                </td>
                                <td>
                                    <a href="#" class="badge bg-secondary" data-bs-toggle="modal" data-bs-target="#sale_details{{ $sale->id }}">
                                        <x-heroicon-o-document-text style="width: 20px; height: 20px; color: white" />
                                    </a>
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