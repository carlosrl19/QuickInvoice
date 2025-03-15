@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">
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
        <a href="#">Creación de ventas</a>
    </li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="pos_creation" action="{{ route('pos.store') }}" method="POST" novalidate autocomplete="off" spellcheck="false">
                    @csrf
                    <input type="hidden" name="sale_total_amount" id="sale_total_amount" value=""> <!-- Controller get this -->
                    <input type="hidden" name="sale_discount" id="sale_discount" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="sale_tax" id="sale_tax" value="0"> <!-- Controller get this -->

                    <div class="row">
                        <!-- Col izquierda -->
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 mb-3">
                            <div class="row">
                                <!-- Selección de Servicios y Clientes -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="row mb-3">
                                        <div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12" id="client_select_container">
                                            <label for="client_id">Cliente:</label>
                                            <select class="tom-select" id="client_id_select" name="client_id">
                                                <option value="" selected disabled>Seleccione el cliente</option>
                                                @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12" id="seller_select_container">
                                            <label for="seller_id">Vendedor:</label>
                                            <select class="tom-select" id="seller_id_select" name="seller_id">
                                                <option value="" selected disabled>Seleccione el vendedor</option>
                                                @foreach ($sellers as $seller)
                                                <option value="{{ $seller->id }}" {{ $seller->id == 1 ? 'selected' : '' }}>{{ $seller->seller_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- Selección de servicio -->
                                        <div class="col-xl-4 col-lg-4 col-sm-12 col-xs-12" id="service_select_container">
                                            <label for="service_id">Servicio:</label>
                                            <div class="input-group">
                                                <select class="tom-select w-75" id="service_id_select" name="service_id">
                                                    <option value="" selected disabled>Seleccione los productos o servicios</option>
                                                    @foreach ($services as $service)
                                                    <option value="{{ $service->id }}" data-price="{{ $service->price }}">{{ $service->service_name }}</option>
                                                    @endforeach
                                                </select>
                                                <button type="button" class="btn btn-sm btn-primary" id="add_service_button">
                                                    <x-heroicon-o-plus style="width: 20px; height: 20px; color: white" />
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tabla de Servicios -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-head-bg-primary table-bordered-bd-primary mt-4">
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

                                        <!-- Botones -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#sale_payment_modal" class="btn btn-success">
                                                <x-heroicon-o-cursor-arrow-ripple style="width: 25px; height: 25px; color: white" />
                                                Cobrar
                                            </a>
                                            <a href="#" class="btn bg-warning text-white" id="sale_clear">
                                                <x-heroicon-o-backspace style="width: 25px; height: 25px; color: white" />
                                                Limpiar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- SweetAlert Include -->
                    @include('modules.pos_details._sale_payment_modal')
                    <!--</div> Este div que cierra el form está dentro del modal -->
            </div>
        </div>
    </div>
</div>

@include('modules.pos._sweet_alerts')

@endsection

@section('scripts')

<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- Script para manejar la lógica -->
<script src="{{ Storage::url('customjs/pos/pos_creation.js') }}"></script>
@endsection