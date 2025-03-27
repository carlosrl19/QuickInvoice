@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- IMask.JS -->
<script src="{{ Storage::url('assets/js/plugin/imask/imask.js') }}"></script>
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
                <form method="POST" action="{{ route('settings.store')}}" enctype="multipart/form-data" novalidate spellcheck="false">
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
                                                <input type="text" maxlength="25" name="company_name" value="{{ old('company_name') }}"
                                                    id="company_name" class="form-control @error('company_name') is-invalid @enderror" autocomplete="off" />
                                                @error('company_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <label for="company_name">Nombre empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" maxlength="37" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')" name="company_cai" value="{{ old('company_cai') }}"
                                                    id="company_cai" class="form-control @error('company_cai') is-invalid @enderror" autocomplete="off" />
                                                @error('company_cai')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <label for="company_cai">CAI empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" maxlength="14" oninput="this.value = this.value.replace(/\D/g, '')" name="company_rtn" value="{{ old('company_rtn') }}"
                                                    id="company_rtn" class="form-control @error('company_rtn') is-invalid @enderror" autocomplete="off" />
                                                @error('company_rtn')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <label for="company_rtn">R.T.N empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" maxlength="9" oninput="this.value = this.value.replace(/\D/g, '')" name="company_phone" value="{{ old('company_phone') }}"
                                                    id="company_phone" class="form-control @error('company_phone') is-invalid @enderror" autocomplete="off" />
                                                @error('company_phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <label for="company_phone">Teléfono empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input type="text" maxlength="50" name="company_email" value="{{ old('company_email') }}"
                                                    id="company_email" class="form-control @error('company_email') is-invalid @enderror" autocomplete="off" />
                                                @error('company_email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
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
                                                <input type="text" class="form-control @error('company_address') is-invalid @enderror" autocomplete="off"
                                                    maxlength="75" name="company_address" id="company_address" value="{{ old('company_address') }}">
                                                @error('company_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
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
                                                <input type="text" class="form-control @error('company_short_address') is-invalid @enderror" autocomplete="off"
                                                    maxlength="35" name="company_short_address" id="company_short_address" value="{{ old('company_short_address') }}">
                                                @error('company_short_address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
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
                                    <div class="row">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <select class="form-select @error('show_system_name') is-invalid @enderror" name="show_system_name">
                                                        <option value="" selected disabled>Seleccione si mostrar nombre del sistema en panel izquierdo</option>
                                                        <option value="1" {{ old('show_system_name') ?? old('show_system_name') == '1' ? 'selected' : '' }}>MOSTRAR NOMBRE DEL SISTEMA EN PANEL IZQUIERDO</option>
                                                        <option value="0" {{ old('show_system_name') ?? old('show_system_name') == '0' ? 'selected' : '' }}>OCULTAR NOMBRE DEL SISTEMA EN PANEL IZQUIERDO</option>
                                                    </select>
                                                    @error('show_system_name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12 text-center">
                                                            <img class="mb-3" style="margin: auto" id="logoPreview" width="100" height="100"><br>
                                                            <label for="logoPreview">Imagen nueva</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-floating">
                                                        <input type="file" class="form-control @error('logo_company') is-invalid @enderror" accept="image/*" id="logo_company" name="logo_company" onchange="previewImage(event, '#logoPreview')">
                                                        <label for="logo_company">Logo para reportes</label>
                                                        @error('logo_company')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <div class="row mb-3">
                                                        <div class="col-md-12 text-center">
                                                            <img class="mb-3" style="margin: auto" id="systemIconPreview" width="100" height="100"><br>
                                                            <label for="systemIconPreview">Imagen nueva</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-floating">
                                                        <input type="file" class="form-control @error('system_icon') is-invalid @enderror" accept="image/*" id="system_icon" name="system_icon" onchange="previewImage(event, '#systemIconPreview')">
                                                        <label for="system_icon">Icono del sistema</label>
                                                        @error('system_icon')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
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
<!-- Images preview -->
<script>
    function previewImage(event, querySelector) {
        const input = event.target;
        const imgPreview = document.querySelector(querySelector);

        if (!input.files.length) return;

        const file = input.files[0];
        const objectURL = URL.createObjectURL(file);
        imgPreview.src = objectURL;
    }
</script>

<!-- IMask.JS -->
<script src="{{ Storage::url('customjs/imask/company/imask_company.js') }}"></script>
@endsection