@extends('layouts.app')

@section('head')
@php $currency = App\Models\Settings::value('default_currency_symbol') @endphp
@endsection

@section('title')
Dashboard
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
        <a href="#">Panel administrador</a>
    </li>
</ul>
@endsection

@section('content')

<!-- Información general I -->
<div class="row row-card-no-pd">
    <!-- Ventas del mes actual -->
    <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-sm-3">
        <div class="card bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="text-white fw-bold">
                            {{ $pos_counter_actual_month }}
                            <small>( {{ $currency }} {{ number_format($pos_counter_amount_sum,2) }})</small>
                        </h1>
                        <h6 class="text-white"><b>Ventas del mes</b></h6>
                    </div>
                    <div>
                        <x-heroicon-o-shopping-cart style="width: 80px; height: 100%; color: rgba(0,0,0,0.2)" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ingresos del mes actual -->
    <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-3">
        <div class="card bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="text-white fw-bold">
                            {{ $newQuotesThisMonth }}
                            <small>( {{ $currency }} {{ number_format($newQuotesThisMonthSum,2) }})</small>
                        </h1>
                        <h6 class="text-white"><b>Cotizaciones del mes</b></h6>
                    </div>
                    <div>
                        <x-heroicon-o-banknotes style="width: 80px; height: 100%; color: rgba(0,0,0,0.2)" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nuevos clientes del mes actual -->
    <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-3">
        <div class="card bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="text-white fw-bold">
                            {{ $newClientsThisMonth }} <small>({{ $clients_counter }})</small>
                        </h1>
                        <h6 class="text-white"><b>Nuevos clientes del mes</b></h6>
                    </div>
                    <div>
                        <x-heroicon-o-users style="width: 80px; height: 100%; color: rgba(0,0,0,0.2)" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nuevos créditos del mes actual -->
    <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-3">
        <div class="card bg-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="text-white fw-bold">
                            {{ $loans_counter }} <small>( {{ $currency }} {{ number_format($loan_counter_amount_sum,2) }})</small>
                        </h1>
                        <h6 class="text-white"><b>Nuevos créditos del mes</b></h6>
                    </div>
                    <div>
                        <x-heroicon-o-document-currency-dollar style="width: 80px; height: 100%; color: rgba(0,0,0,0.2)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Información general II -->
<div class="row">
    <!-- Ventas del día -->
    <div class="col-12 col-sm-4 col-md-4 col-xl-4 mb-3">
        <div class="card">
            <div class="card-body pb-0">
                <div class="h5 fw-bold float-end text-primary op-3 text-capitalize">
                    <x-heroicon-o-cursor-arrow-ripple style="width: 80px; height: 100%; color: rgba(0,0,0,0.2)" />
                </div>
                <h2 class="mb-2">{{ $pos_counter_actual_day }}</h2>
                <p class="text-muted">Ventas del día / <span class="op-5 text-primary">{{ $todayDate }}</span></p>
            </div>
        </div>
    </div>

    <!-- Cotizaciones activas actualmente -->
    <div class="col-12 col-sm-4 col-md-4 col-xl-4 mb-3">
        <div class="card">
            <div class="card-body pb-0">
                <div class="h5 fw-bold float-end text-primary op-3">
                    <x-heroicon-o-document-text style="width: 80px; height: 100%; color: rgba(0,0,0,0.2)" />
                </div>
                <h2 class="mb-2">{{ $activeQuotes }}</h2>
                <p class="text-muted">Cotizaciones activas / <span class="op-5 text-capitalize text-primary">{{ $actualMonth }}</span></p>
            </div>
        </div>
    </div>

    <!-- Créditos activos actualmente -->
    <div class="col-12 col-sm-4 col-md-4 col-xl-4 mb-3">
        <div class="card">
            <div class="card-body pb-0">
                <div class="h5 fw-bold float-end text-primary op-3">
                    <x-heroicon-o-document-duplicate style="width: 80px; height: 100%; color: rgba(0,0,0,0.2)" />
                </div>
                <h2 class="mb-2">{{ $loans_active_counter }}</h2>
                <p class="text-muted">Créditos activos / <span class="op-5 text-uppercase text-primary">{{ $currency }} {{ number_format($loan_active_amount_sum,2) }}</span></p>
            </div>
        </div>
    </div>
</div>

<!-- Ventas recientes (4) / gráfica pie -->
<div class="row">
    <!-- Ventas reciente -->
    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold">Ultimas ventas</h5>
                <div class="table-responsive">
                    <table id="dt_pos_dashboard" class="display table table-responsive">
                        <thead>
                            <tr>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pos_lastest as $sale)
                            <tr>
                                <td>
                                    <a href="{{ route('pos_details.pos_details_show', $sale->id) }}" target="_blank" class="btn btn-sm btn-primary btn-border">
                                        <x-heroicon-o-document-text style="width: 20px; height: 20px; color: #2f77f0" />
                                        Factura
                                    </a>
                                </td>
                                <td>{{ $sale->client->client_name }}</td>
                                <td>
                                    {{ $currency }} {{ number_format($sale->sale_total_amount,2) }}
                                </td>
                                <td>
                                    {{ $sale->seller->seller_name }}
                                </td>
                                <td>
                                    <span class="badge bg-primary2 text-primary">
                                        {{ $sale->created_at->format('d/m/Y') }}
                                    </span>
                                </td>
                            </tr>

                            <!-- Details Include -->
                            @include('modules.pos_details._sale_details')
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <a class="text-muted" href="{{ route('pos.index') }}">
                                        VER MÁS REGISTROS ...
                                    </a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top ventas más grandes -->
    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Top ventas del mes</div>
            </div>
            <div class="card-body">
                {!! $chart_bigger_sales->renderHtml() !!}
            </div>
        </div>
    </div>
</div>

<!-- Ventas del mes / año -->
<div class="row">
    <!-- Ventas del mes actual -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ventas del mes <small>({{ $pos_counter_actual_month }})</small></div>
            </div>
            <div class="card-body">
                {!! $chart_sales_actual_month->renderHtml() !!}
            </div>
        </div>
    </div>

    <!-- Ventas del año actual -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ventas del año <small>({{ $pos_counter_year }})</small></div>
            </div>
            <div class="card-body">
                {!! $chart_sales_actual_year->renderHtml() !!}
            </div>
        </div>
    </div>
</div>

<!-- Actividades recientes -->
<div class="row">
    <!-- Actividades recientes del mes actual -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Actividad reciente <small>({{ $new_logs_actual_month_counter }})</small></div>
                    <div class="card-tools">
                        <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" disabled id="pills-month" data-bs-toggle="pill" href="#" role="tab" aria-selected="false">
                                    Mes actual
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height: 38rem; overflow: auto;">
                @forelse($new_logs_actual_month as $index => $log)
                <div class="d-flex">
                    <div class="avatar avatar-online">
                        <span class="avatar-title rounded-circle border border-white bg-{{ $colorsList[array_rand($colorsList)] }}">
                            <x-heroicon-o-document-text style="width: 20px; height: 20px; color: white" />
                        </span>
                    </div>
                    <div class="flex-1 ms-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">
                            {{ $log->module_log }}
                            <span class="text-muted op-5 ps-3">
                                <small>{{ Carbon\Carbon::parse($log->created_at)->setTimezone('America/Costa_Rica')->locale('es')->translatedFormat('d F')  }}</small>
                            </span>
                        </h6>
                        <span class="text-muted">{{ $log->log_description }}</span>
                    </div>
                    <div class="float-end pt-1">
                        <small class="text-muted">{{ Carbon\Carbon::parse($log->created_at)->setTimezone('America/Costa_Rica')->locale('es')->translatedFormat('H:i a')  }}</small>
                    </div>
                </div>
                <div class="separator-dashed"></div>
                @empty
                <div class="d-flex">
                    <div class="avatar avatar-online">
                        <span class="avatar-title rounded-circle border border-white bg-danger">
                            <x-heroicon-o-face-smile style="width: 20px; height: 20px; color: white" />
                        </span>
                    </div>
                    <div class="flex-1 ms-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">
                            ¡Vaya!
                        </h6>
                        <span class="text-muted">Al parecer no se han realizado movimientos últimamente.</span>
                    </div>
                    <div class="float-end pt-1">
                        <small class="text-muted">N/A</small>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/pos/dt_pos_dashboard.js') }}"></script>

<!-- Chart ventas más grandes  -->
{!! $chart_bigger_sales->renderChartJsLibrary() !!}
{!! $chart_bigger_sales->renderJs() !!}

<!-- Chart mes actual -->
{!! $chart_sales_actual_month->renderChartJsLibrary() !!}
{!! $chart_sales_actual_month->renderJs() !!}

<!-- Chart año actual -->
{!! $chart_sales_actual_year->renderChartJsLibrary() !!}
{!! $chart_sales_actual_year->renderJs() !!}
@endsection