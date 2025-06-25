@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">

<!-- Filepond -->
<link rel="stylesheet" href="{{ Storage::url('assets/js/plugin/filepond/filepond.css') }}">
<link rel="stylesheet" href="{{ Storage::url('assets/js/plugin/filepond/filepond-plugin-image-preview.css') }}">

@php
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
@endphp

@php $currency = App\Models\Settings::value('default_currency_symbol') @endphp

@endsection

@section('title')
Productos
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
        <a href="#">Productos</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de productos</a>
    </li>
</ul>
@endsection

@section('create')
@if($products->count() > 0)
<a href="{{ route('exports.products_export') }}" class="btn btn-sm btn-success btn-round me-2">
    <x-heroicon-o-document-text style="width: 20px; height: 20px;" class="bg-label-info" />
    Excel inventario
</a>
@endif

<a href="#" class="btn btn-sm btn-label-secondary btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_category">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear categoría
</a>

<a href="#" class="btn btn-sm btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_product">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear productos
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                @if($products->count() > 0)
                <div class="col-12 mb-2" style="background-color: rgba(0, 0, 0, 0.05); padding: 10px; text-align: center">
                    <div class="col mt-2">
                        @foreach ($letters as $letter)
                        <a href="{{ route('products.index', ['letter' => $letter]) }}"
                            class="mx-1 px-2 py-1 border {{ $selectedLetter == $letter ? 'bg-primary text-white' : 'op-7 text-muted' }}">
                            {{ $letter }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
                <div class="table-responsive">
                    <table id="dt_products_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Código</th>
                                <th style="max-width: 60px;">Imagen</th>
                                <th>Nombre</th>
                                <th>Nomenclatura</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Estado</th>
                                <th>Precio</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-danger text-white" id="delete_product{{ $product->id }}">
                                        <x-heroicon-o-trash style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                                <td>
                                    <span class="badge @if($product->product_code != '') bg-secondary2 text-secondary @else bg-warning text-white @endif">{{ $product->product_code ? $product->product_code:'SIN CODIGO' }}</span>
                                </td>
                                <td>
                                    <img class="rounded-circle" width="50" height="50"
                                        src="{{ Storage::url('uploads/products/' . $product->product_image) ?: Storage::url('sys_config/img/no_image_available.png') }}"
                                        onerror="this.onerror=null;this.src='{{ $product_error_image }}'"
                                        alt="Imagen de {{ $product->product_name }}">
                                </td>
                                <td>
                                    <a href="{{ route('products.edit', $product->id) }}">
                                        {{ $product->product_name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $product->product_nomenclature }}
                                </td>
                                <td>
                                    {{ $product->product_brand }}
                                </td>
                                <td>
                                    {{ $product->product_model }}
                                </td>
                                <td>
                                    @if($product->product_status == 0)
                                    <span class="badge bg-danger">
                                        Malo
                                    </span>
                                    @elseif($product->product_status == 1)
                                    <span class="badge bg-success">Nuevo</span>
                                    @elseif($product->product_status == 2)
                                    <span class="badge bg-warning">Seminuevo</span>
                                    @elseif($product->product_status == 3)
                                    <span class="badge bg-secondary">Usado</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $currency }} {{ number_format($product->product_price,2) }}
                                </td>
                                <td>
                                    {{ $product->product_stock }}
                                </td>
                            </tr>
                            @include('modules.products._sweet_alerts')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Includes -->
@include('modules.products._create')
@include('modules.categories._create')

@endsection

@section('scripts')

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/products/dt_products_index.js') }}"></script>

<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- Filepond -->
<script src="{{ Storage::url('assets/js/plugin/filepond/filepond.js') }}"></script>
<script src="{{ Storage::url('assets/js/plugin/filepond/filepond-plugin-file-validate-type.js') }}"></script>
<script src="{{ Storage::url('assets/js/plugin/filepond/filepond-plugin-image-preview.js') }}"></script>
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview
    );

    // Inicializar FilePond en los inputs
    FilePond.create(document.querySelector('input[name="product_image"]'));

    FilePond.setOptions({
        server: {
            process: '/filepond/process',
            revert: '/filepond/revert',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        },
        acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/svg+xml'],
        labelFileTypeNotAllowed: 'Tipo de archivo no permitido',
        fileValidateTypeLabelExpectedTypes: 'Debe ser una imagen: {allTypes}'
    });
</script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest('App\Http\Requests\Products\StoreRequest') !!}

@endsection