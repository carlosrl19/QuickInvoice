@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">
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
        <a href="#">Creación de cotización</a>
    </li>
</ul>
@endsection

@section('create')
<a class="btn btn-sm btn-label-danger btn-round me-2" href="{{ route('quotes.exonerated_quote') }}">
    <x-heroicon-o-eye-slash style="width: 20px; height: 20px;" class="bg-label-danger" />
    <span class="sub-item">Exonerar sin ISV</span>
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-secondary text-white fw-bold">
                REGISTRO DE NUEVA COTIZACIÓN GRAVADA (G)
            </div>
            <div class="card-body">
                <form id="quotes_creation" action="{{ route('quotes.store') }}" method="POST" novalidate autocomplete="off" spellcheck="false">
                    @csrf
                    <input type="hidden" name="quote_code" id="quote_code" value="000000000"> <!-- Controller get this -->
                    <input type="hidden" name="quote_discount" id="quote_discount" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="quote_tax" id="quote_tax" value="15"> <!-- Controller get this -->
                    <input type="hidden" name="quote_total_amount" id="quote_total_amount" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="quote_isv_amount" id="quote_isv_amount" value="0"> <!-- Controller get this -->
                    <input type="hidden" id="quote_exempt_tax" name="quote_exempt_tax"> <!-- Controller get this -->
                    <input type="hidden" id="quote_answer" name="quote_answer" value="xxx"> <!-- Controller get this -->

                    <div class="row">
                        <!-- Col izquierda -->
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3">
                            <div class="row">
                                <!-- Selección de Servicios y Clientes -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="row mb-3">
                                        <div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12" id="client_select_container">
                                            <label for="client_id">Cliente <span class="text-danger">*</span></label>
                                            <select class="tom-select @error('client_id') is-invalid @enderror" id="client_id_select" name="client_id">
                                                <option value="" selected disabled>Seleccione el cliente</option>
                                                @foreach ($clients as $client)
                                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->client_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('client_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12" id="seller_select_container">
                                            <label for="seller_id">Vendedor <span class="text-danger">*</span></label>
                                            <select class="tom-select @error('seller_id') is-invalid @enderror" id="seller_id_select" name="seller_id">
                                                <option value="" selected disabled>Seleccione el vendedor</option>
                                                @foreach ($sellers as $seller)
                                                <option value="{{ $seller->id }}" {{ $seller->id == 1 ? 'selected' : '' }}>{{ $seller->seller_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('seller_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <!-- Selección de servicio -->
                                        <div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12" id="service_select_container">
                                            <label for="service_id">Servicio <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="tom-select w-75 @error('service_id') is-invalid @enderror" id="service_id_select" name="service_id">
                                                    <option value="" selected disabled>Seleccione los productos o servicios</option>
                                                    @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}
                                                        data-price="{{ $service->price }}">{{ $service->service_nomenclature }} - {{ $service->service_name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-sm btn-secondary" id="add_service_button">
                                                    <x-heroicon-o-plus style="width: 20px; height: 20px; color: white" />
                                                </button>
                                                @error('service_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12" id="service_select_container">
                                            <label for="service_id">Fecha de vencimiento <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="quote_expiration_date" id="quote_expiration_date" min="{{ Carbon\Carbon::now()->addWeek()->format('Y-m-d') }}">
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de Servicios -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="table-responsive" style="max-height: 35rem; overflow: auto;">
                                        <table class="table table-bordered table-head-bg-secondary table-bordered-bd-secondary mt-4">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Producto/ Código / Serie</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col">Precio</th>
                                                    <th scope="col">Subtotal</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="services_table_body">
                                                <tr id="no-items-row">
                                                    <td colspan="5" class="text-center">Sin items agregados a la tabla de la venta</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Col derecha -->
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-xl-12 col-lg-12 col-sm-12" id="service_select_container">
                                    <div class="col">
                                        <input style="font-size: clamp(0.9rem, 3vw, 1.1rem)" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault" title="Seleccione esta opción para convertir a venta exenta de impuestos." data-bs-toogle="tooltip" data-bs-placement="right">
                                            &nbsp;Cotización exenta de I.S.V.
                                        </label>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="display table table-responsive table-primary">
                                            <thead>
                                                <tr>
                                                    <th class="fw-bold">Subtotal</th>
                                                    <th class="fw-bold">ISV</th>
                                                    <th class="fw-bold">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="subtotal_amount">L. 0.00</td>
                                                    <td id="isv_amount">L. 0.00</td>
                                                    <td id="total_amount">L. 0.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="row mb-3 d-none">
                                        <div class="col">
                                            <select class="tom-select-no-search @error('quote_type') is-invalid @enderror" id="quote_type_select" name="quote_type">
                                                <option value="G" selected readonly>TIPO DE COTIZACIÓN: NORMAL</option>
                                            </select>
                                            @error('quote_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div style="height: 30px; position: relative;" id="quote_exempt_isv_text" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-none">
                                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                <x-heroicon-o-check-circle style="width: 20px; height: 20px; color: white;" />
                                                COTIZACIÓN EXENTA DE I.S.V
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                            <button type="submit" class="btn btn-success">
                                                <x-heroicon-o-cursor-arrow-ripple style="width: 25px; height: 25px; color: white" />
                                                Finalizar
                                            </button>
                                            <a href="#" class="btn bg-warning text-white" id="quote_clear">
                                                <x-heroicon-o-backspace style="width: 25px; height: 25px; color: white" />
                                                Limpiar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('modules.quotes._sweet_alerts')
@endsection

@section('scripts')

<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- Venta exenta checkbox -->
<script src="{{ Storage::url('customjs/quotes/checkbox_exempt_tax.js') }}"></script>

<!-- Script para manejar la lógica -->
<script src="{{ Storage::url('customjs/quotes/quote_creation.js') }}"></script>

<!-- Ocultar campos exenta y correlativo si no es venta exonerada -->
<script src="{{ Storage::url('customjs/quotes/hidde_inputs.js') }}"></script>
@endsection