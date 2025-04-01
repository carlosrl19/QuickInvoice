@extends('layouts.app')

@section('title')
Dashboard
@endsection

@section('content')

@php
use App\Models\Clients;
use App\Models\Loans;
use App\Models\Pos;
use App\Models\PosDetails;
use App\Models\SystemLogs;
use App\Models\Quotes;
use Carbon\Carbon;

$actualMonth = Carbon::now()->month;
$actualYear = Carbon::now()->year;

// Logs
$newLogsThisMonth = SystemLogs::whereMonth('created_at', $actualMonth)
->whereYear('created_at', $actualYear)
->get();
$colorsList = ['secondary', 'success', 'info', 'warning', 'danger', 'primary', 'black'];
$colors = [];
foreach ($newLogsThisMonth as $log) {
$colors[] = $colorsList[array_rand($colorsList)];
}

// Clients
$clients_counter = Clients::count();
$newClientsThisMonth = Clients::whereMonth('created_at', $actualMonth)
->whereYear('created_at', $actualYear)
->count();

// Quotes
$newQuotesThisMonth = Quotes::whereMonth('created_at', $actualMonth)
->whereYear('created_at', $actualYear)
->count();
$newQuotesThisMonthSum = Quotes::whereMonth('created_at', $actualMonth)
->whereYear('created_at', $actualYear)
->sum('quote_total_amount');

// Sales
$pos = Pos::whereMonth('created_at', $actualMonth)->get();
$pos_counter = Pos::whereMonth('created_at', $actualMonth)->count();
$pos_counter_amount_sum = PosDetails::whereMonth('created_at', $actualMonth)
->sum('sale_price');

// Loans
$loans_counter = Loans::whereMonth('created_at', $actualMonth)->count();
$loan_counter_amount_sum = Loans::whereMonth('created_at', $actualMonth)
->sum('loan_amount');

@endphp

<div class="row row-card-no-pd">
    <!-- Ventas del mes actual -->
    <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-3">
        <div class="card bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="text-white fw-bold">
                            {{ $pos_counter }} ventas
                            <small>( L. {{ number_format($pos_counter_amount_sum,2) }})</small>
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
                            <small>( L. {{ number_format($newQuotesThisMonthSum,2) }})</small>
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
                            {{ $loans_counter }} <small>(L. {{ number_format($loan_counter_amount_sum,2) }})</small>
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

<div class="row">
    <!-- Ventas del mes actual -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ventas ultimo trimestre</div>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="lineChart" width="1456" height="600" style="display: block; width: 728px; height: 300px;" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividades recientes del mes actual -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Actividad reciente</div>
                    <div class="card-tools">
                        <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="pills-today" data-bs-toggle="pill" href="#pills-today"
                                    role="tab" aria-selected="true">Hoy</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-week" data-bs-toggle="pill" href="#pills-week"
                                    role="tab" aria-selected="false">Semana</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-month" data-bs-toggle="pill" href="#pills-month"
                                    role="tab" aria-selected="false">Mes</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @forelse($newLogsThisMonth as $index => $log)
                <div class="d-flex">
                    <div class="avatar avatar-online">
                        <span class="avatar-title rounded-circle border border-white bg-{{ $colors[$index] }}">
                            <x-heroicon-o-document-text style="width: 20px; height: 20px; color: white" />
                        </span>
                    </div>
                    <div class="flex-1 ms-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">
                            {{ $log->module_log }}
                            <span class="text-muted op-5 ps-3">
                                <small>{{ Carbon::parse($log->created_at)->setTimezone('America/Costa_Rica')->locale('es')->translatedFormat('d F')  }}</small>
                            </span>
                        </h6>
                        <span class="text-muted">{{ $log->log_description }}</span>
                    </div>
                    <div class="float-end pt-1">
                        <small class="text-muted">{{ Carbon::parse($log->created_at)->setTimezone('America/Costa_Rica')->locale('es')->translatedFormat('H:i a')  }}</small>
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
<script src="{{ Storage::url('assets/js/plugin/chart.js/chart.min.js') }}"></script>
@endsection