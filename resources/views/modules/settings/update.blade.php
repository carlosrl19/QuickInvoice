@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">

<!-- IMask.JS -->
<script src="{{ Storage::url('assets/js/plugin/imask/imask.js') }}"></script>

<!-- Filepond -->
<link rel="stylesheet" href="{{ Storage::url('assets/js/plugin/filepond/filepond.css') }}">
<link rel="stylesheet" href="{{ Storage::url('assets/js/plugin/filepond/filepond-plugin-image-preview.css') }}">

@endsection

@section('title')
Configuración
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
    <li class="nav-item fw-bold">
        <a href="#">Configuración del sistema</a>
    </li>
</ul>
@endsection

@section('content')


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('settings.update', $setting->id)}}" enctype="multipart/form-data" novalidate autocomplete="off" spellcheck="false">
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header bg-secondary text-white fw-bold">
                                    <x-heroicon-o-building-office style="width: 20px; height: 20px; color: white" />
                                    Información de la empresa
                                </div>
                                <div class="card-header">
                                    <!-- Company name, rtn, phone and email -->
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" maxlength="25" name="company_name" value="{{ $setting->company_name }}"
                                                    id="company_name" class="form-control @error('company_name') is-invalid @enderror" autocomplete="off" />
                                                @error('company_name')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_name">Nombre empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" maxlength="37" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')" name="company_cai" value="{{ $setting->company_cai }}"
                                                    id="company_cai" class="form-control @error('company_cai') is-invalid @enderror" autocomplete="off" />
                                                @error('company_cai')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_cai">CAI empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" maxlength="14" oninput="this.value = this.value.replace(/\D/g, '')" name="company_rtn" value="{{ $setting->company_rtn }}"
                                                    id="company_rtn" class="form-control @error('company_rtn') is-invalid @enderror" autocomplete="off" />
                                                @error('company_rtn')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_rtn">R.T.N empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" maxlength="9" oninput="this.value = this.value.replace(/\D/g, '')" name="company_phone" value="{{ $setting->company_phone }}"
                                                    id="company_phone" class="form-control @error('company_phone') is-invalid @enderror" autocomplete="off" />
                                                @error('company_phone')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_phone">Teléfono empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" maxlength="50" name="company_email" value="{{ $setting->company_email }}"
                                                    id="company_email" class="form-control @error('company_email') is-invalid @enderror" autocomplete="off" />
                                                @error('company_email')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_email">Email empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Company Address -->
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input
                                                    type="text"
                                                    class="form-control @error('company_address') is-invalid @enderror"
                                                    autocomplete="off"
                                                    maxlength="75"
                                                    name="company_address"
                                                    id="company_address"
                                                    value="{{ $setting->company_address }}">
                                                @error('company_address')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_address">Dirección completa empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Company Short Address -->
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input
                                                    type="text"
                                                    class="form-control @error('company_short_address') is-invalid @enderror"
                                                    autocomplete="off"
                                                    maxlength="35"
                                                    name="company_short_address"
                                                    id="company_short_address"
                                                    value="{{ $setting->company_short_address }}">
                                                @error('company_short_address')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_short_address">Dirección corta empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header bg-primary fw-bold text-white">
                                    <x-heroicon-o-cog-6-tooth style="width: 20px; height: 20px; color: white" />
                                    Configuración general
                                </div>
                                <div class="card-body">
                                    <div class="row text-center mb-3">
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <img class="mb-3" style="margin: auto" id="logoPreviewOld" width="100" height="100" src="{{ Storage::url('sys_config/img/' . $setting->logo_company) }}"><br>
                                            <label for="logoPreviewOld" class="text-xs">Logo de reportes</label>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6">
                                            <img class="mb-3" style="margin: auto" id="systemIconPreviewOld" width="100" height="100" src="{{ Storage::url('sys_config/img/' . $setting->system_icon) }}"><br>
                                            <label for="systemIconPreviewOld" class="text-xs">Logo del sistema</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label for="show_system_name" class="text-xs">Mostrar/Ocultar ícono del sistema <span class="text-danger"> *</span></label>
                                                    <select class="form-select @error('show_system_name') is-invalid @enderror" name="show_system_name">
                                                        <option value="" selected disabled>Seleccione si mostrar nombre del sistema en panel izquierdo</option>
                                                        <option value="1" {{ old('show_system_name') ?? $setting->show_system_name == '1' ? 'selected' : '' }}>MOSTRAR NOMBRE DEL SISTEMA EN PANEL IZQUIERDO</option>
                                                        <option value="0" {{ old('show_system_name') ?? $setting->show_system_name == '0' ? 'selected' : '' }}>OCULTAR NOMBRE DEL SISTEMA EN PANEL IZQUIERDO</option>
                                                    </select>
                                                    @error('show_system_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Default currency symbol / Seller -->
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <div class="form-floating">
                                                        <input type="text" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z.$€£¥₹]/g, '')" class="form-control @error('default_currency_symbol') is-invalid @enderror" autocomplete="off"
                                                            maxlength="3" name="default_currency_symbol" id="default_currency_symbol" value="{{ $setting->default_currency_symbol }}">
                                                        @error('default_currency_symbol')
                                                        <span class="invalid-feedback" role="alert">
                                                            {{ $message }}
                                                        </span>
                                                        @enderror
                                                        <label for="default_currency_symbol">Moneda predeterminada <span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label for="default_seller_id" class="text-xs">Vendedor predeterminado <span class="text-danger"> *</span></label>
                                                    <select class="tom-select @error('default_seller_id') is-invalid @enderror" id="default_seller_id_select" name="default_seller_id">
                                                        <option value="" selected disabled>Seleccione el vendedor predeterminado</option>
                                                        @foreach ($sellers as $seller)
                                                        <option value="{{ $seller->id }}" {{ $seller->id == $setting->default_seller_id ? 'selected' : '' }}>{{ $seller->seller_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('default_seller_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        {{ $message }}
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header bg-danger text-white fw-bold">
                                                    <x-heroicon-o-photo style="width: 20px; height: 20px; color: white" />
                                                    Logo para reportes
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <input type="file" class="filepond @error('logo_company') is-invalid @enderror" accept="image/*" name="logo_company" id="logo_company">
                                                            @error('logo_company')
                                                            <span class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="card">
                                                <div class="card-header bg-danger text-white fw-bold">
                                                    <x-heroicon-o-photo style="width: 20px; height: 20px; color: white" />
                                                    Icono del sistema
                                                </div>
                                                <div class="card-body">
                                                    <div class="row mb-3">
                                                        <div class="col">
                                                            <input type="file" class="filepond @error('system_icon') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml" id="system_icon" name="system_icon">
                                                            @error('system_icon')
                                                            <span class="invalid-feedback" role="alert">
                                                                {{ $message }}
                                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="row">
                            <div class="col">
                                <a href="{{ route('settings.index') }}" class="btn btn-sm btn-dark">
                                    Volver
                                </a>
                                <button class="btn btn-sm btn-success">
                                    Guardar configuración
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Include -->
                    @include('modules.settings._sweet_alerts')
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- IMask.JS -->
<script src="{{ Storage::url('customjs/imask/company/imask_company.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! $validator !!}

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
    FilePond.create(document.querySelector('input[name="logo_company"]'));
    FilePond.create(document.querySelector('input[name="system_icon"]'));

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