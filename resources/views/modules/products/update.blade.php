@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">

<!-- Filepond -->
<link rel="stylesheet" href="{{ Storage::url('assets/js/plugin/filepond/filepond.css') }}">
<link rel="stylesheet" href="{{ Storage::url('assets/js/plugin/filepond/filepond-plugin-image-preview.css') }}">
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

@endsection

@section('content')
<form method="POST" id="create_product_form" action="{{ route('products.update', $product->id)}}" enctype="multipart/form-data" novalidate spellcheck="false">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-warning fw-bold text-white">
                    Actualización de información <span class="text-danger">*</span> / {{ $product->product_name }}
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col text-center">
                            <img class="rounded-circle p-1" src="{{ Storage::url('uploads/products/' . $product->product_image ) }}" onerror="this.onerror=null;this.src='{{ Storage::url('sys_config/img/image_loading_failed.png') }}'" width="180" height="180">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="13" name="product_barcode" oninput="this.value = this.value.replace(/\D/g, '')" value="{{ $product->product_barcode }}"
                                    id="product_barcode" class="form-control @error('product_barcode') is-invalid @enderror" autocomplete="off" />
                                @error('product_barcode')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_barcode">Código del producto</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="40" name="product_name" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ $product->product_name }}"
                                    id="product_name" class="form-control @error('product_name') is-invalid @enderror" autocomplete="off" />
                                @error('product_name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_name">Nombre del producto <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="1" name="product_stock" value="{{ $product->product_stock }}" id="product_stock"
                                    class="form-control @error('product_stock') is-invalid @enderror" autocomplete="off">
                                @error('product_stock')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_stock">Stock actual <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="any" name="product_buy_price" value="{{ $product->product_buy_price }}" id="product_buy_price"
                                    class="form-control @error('product_buy_price') is-invalid @enderror" autocomplete="off">
                                @error('product_buy_price')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_buy_price">Precio compra <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="any" name="product_sell_price" value="{{ $product->product_sell_price }}" id="product_sell_price"
                                    class="form-control @error('product_sell_price') is-invalid @enderror" autocomplete="off">
                                @error('product_sell_price')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_sell_price">Precio venta <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('products.index') }}" class="btn btn-round btn-sm bg-dark text-white">Volver</a>
                            <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-warning fw-bold text-white">
                    Actualización de presentación <span class="text-danger">*</span> / {{ $product->product_name }}
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="product_image" class="text-xs">Presentación del producto</label>
                            <input type="file" class="filepond @error('product_image') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml" id="product_image" name="product_image">
                            @error('product_image')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="category_id" class="text-xs">Categoría del producto <span class="text-danger"> *</span></label>
                            <select class="tom-select @error('category_id') is-invalid @enderror" id="category_id_select" name="category_id">
                                <option value="" selected disabled>Seleccione una categoría</option>
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()"
                                    class="form-control @error('product_description') is-invalid @enderror" autocomplete="off" maxlength="255"
                                    name="product_description" rows="6" id="product_description" style="resize: none;">{{ $product->product_description }}</textarea>
                                @error('product_description')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="product_description">Descripción</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')

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
@endsection