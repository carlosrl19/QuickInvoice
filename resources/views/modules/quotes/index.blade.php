@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

{{ $currency = App\Models\Settings::value('default_currency_symbol') }}
@endsection

@section('title')
Cotizaciones
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
        <a href="#">Cotizaciones</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de cotizaciones</a>
    </li>
</ul>
@endsection

@section('create')
<a href="{{ route('quotes.create') }}" class="btn btn-sm btn-label-info btn-round me-2">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear cotización
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_quotes_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Respuesta</th>
                                <th>Detalles</th>
                                <th>Estado</th>
                                <th>Fecha vencimiento</th>
                                <th>Cotización</th>
                                <th>Cliente</th>
                                <th>Tipo cotización</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($quotes as $quote)
                            <tr>
                                <td>
                                    @if($quote->quote_status == 0)
                                    <a href="#" class="btn btn-sm btn-label-info btn-round me-2" id="quote_status{{ $quote->id }}">
                                        <x-heroicon-o-question-mark-circle style="width: 20px; height: 20px;" class="bg-label-info" />
                                        Cambiar estado
                                    </a>
                                    @elseif($quote->quote_status == 4)
                                    <span class="text-danger fw-bold">{{ $quote->quote_answer }}</span>
                                    @else
                                    {{ $quote->quote_answer }}
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('quote_details.quote_details_show', $quote->id) }}" class="btn btn-sm btn-primary btn-border">
                                        <x-heroicon-o-document-text style="width: 20px; height: 20px; color: #2f77f0" />
                                        Cotización
                                    </a>
                                </td>
                                <td>
                                    @php
                                    $statuses = [
                                    0 => 'bg-primary',
                                    1 => 'bg-success',
                                    2 => 'bg-danger',
                                    ];
                                    @endphp

                                    <span class="badge {{ $statuses[$quote->quote_status] ?? 'bg-warning' }}">
                                        {{
                                            $quote->quote_status == 0 ? 'En espera de respuesta' : 
                                            ($quote->quote_status == 1 ? 'Aceptada' : 
                                            ($quote->quote_status == 2 ? 'Rechazada' : 
                                            ($quote->quote_status == 3 ? 'Sin respuesta' : 'Vencida')))
                                        }}
                                    </span>
                                </td>
                                <td>{{ $quote->quote_expiration_date }}</td>
                                <td>{{ $quote->quote_code }}</td>
                                <td>
                                    {{ $quote->client->client_name }}
                                </td>
                                <td>
                                    {{ $quote->quote_type == 'E' ? 'EXONERADA' : ($quote->quote_type == 'G' ? 'GRAVADA' : 'EXENTA') }}
                                </td>
                                <td>
                                    {{ $currency }} {{ number_format($quote->quote_total_amount,2) }}
                                </td>

                                <td>
                                    {{ $quote->seller->seller_name }}
                                </td>
                            </tr>

                            <!-- Details Include -->
                            @include('modules.quote_details._quote_details')
                            @include('modules.quotes._sweet_alert_update')
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
<script src="{{ Storage::url('customjs/datatables/quotes/dt_quotes_index.js') }}"></script>
@endsection