@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
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
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-header bg-dark text-white">
                                <x-heroicon-o-cog-8-tooth style="width: 20px; height: 20px; color: white" />
                                Opciones
                            </div>
                            <div class="card-body">
                                @if(App\Models\Settings::count() == 0)
                                <a class="text-muted mb-3" href="{{ route('settings.create') }}"
                                    title="Es necesario ingresar la información de la empresa." data-bs-toggle="tooltip" data-bs-placement="right">
                                    <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: orange;" class="me-2" />
                                    1. Configuración general
                                </a>
                                @else
                                <a class="text-muted mb-3" href="{{ route('settings.edit', App\Models\Settings::first()) }}"
                                    title="Configurar información de la empresa, logos del sistema y reportes." data-bs-toggle="tooltip" data-bs-placement="right">
                                    <x-heroicon-o-check-circle style="width: 20px; height: 20px; color: green" class="me-2" />
                                    1. Configuración general
                                </a>
                                @endif
                                <hr>

                                @if(App\Models\FiscalFolio::count() == 0)
                                <a class="text-muted mb-3" href="{{ route('fiscalfolio.index') }}"
                                    title="Es necesario ingresar la información del folio fiscal de facturación." data-bs-toggle="tooltip" data-bs-placement="right">
                                    <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: orange;" class="me-2" />
                                    2. Folios
                                </a>
                                @elseif(App\Models\FiscalFolio::where('folio_status', 1)->count() == 0)
                                <a class="text-muted mb-3" href="{{ route('fiscalfolio.index') }}"
                                    title="Es necesario activar el uso del folio fiscal creado." data-bs-toggle="tooltip" data-bs-placement="right">
                                    <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: orange;" class="me-2" />
                                    2. Folios
                                </a>
                                @elseif(App\Models\FiscalFolio::where('folio_status', 1)->where('folio_total_invoices_available', 0)->count() > 0)
                                <a class="text-muted mb-3" href="{{ route('fiscalfolio.index') }}"
                                    title="Se ha llegado al limite de facturación permitido para el folio actual, agregue un nuevo folio para facturación." data-bs-toggle="tooltip" data-bs-placement="right">
                                    <x-heroicon-o-exclamation-triangle style="width: 20px; height: 20px; color: orange;" class="me-2" />
                                    2. Folios
                                </a>
                                @else
                                <a class="text-muted mb-3" href="{{ route('fiscalfolio.index') }}"
                                    title="Ver o agregar folios fiscales disponibles en el sistema." data-bs-toggle="tooltip" data-bs-placement="right">
                                    <x-heroicon-o-check-circle style="width: 20px; height: 20px; color: green" class="me-2" />
                                    2. Folios
                                </a>
                                @endif
                                <hr>
                                <a class="text-muted mb-3" href="{{ route('logs.index') }}"
                                    title="Ver los registros del sistema." data-bs-toggle="tooltip" data-bs-placement="right">
                                    <x-heroicon-o-server-stack style="width: 20px; height: 20px; color: gray;" class="me-2" />
                                    3. Logs
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- PC screens -->
                    <div class="col-xl-8 col-lg-8 d-none d-xl-block d-lg-block d-md-none d-sm-none">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header bg-secondary text-white fw-bold">
                                    <x-heroicon-o-building-office style="width: 20px; height: 20px; color: white" />
                                    Información de la empresa
                                </div>
                                <div class="card-header">
                                    <!-- Company name, rtn, phone and email -->
                                    <div class="row text-center">
                                        <div class="col">
                                            <img class="mb-3" style="border: 1px solid #eee; padding: 5px; border-radius: 5px" id="logoPreviewOld" width="100" height="100" src="{{ Storage::url('sys_config/img/' . ($setting->logo_company ?? 'default_image.png')) }}">
                                            <p>Logo reportes</p>
                                        </div>
                                        <div class="col">
                                            <img class="mb-3" style="border: 1px solid #eee; padding: 5px; border-radius: 5px" id="systemIconPreviewOld" width="100" height="100" src="{{ Storage::url('sys_config/img/' . ($setting->system_icon ?? 'default_image.png')) }}"><br>
                                            <p>Logo sistema</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" type="text" maxlength="25" name="company_name" value="{{ $setting->company_name ?? 'N/A' }}"
                                                    id="company_name" class="form-control @error('company_name') is-invalid @enderror" autocomplete="off" />
                                                @error('company_name')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_name">Nombre empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" type="text" maxlength="14" oninput="this.value = this.value.replace(/\D/g, '')"
                                                    name="company_rtn" value="{{ $setting->company_rtn ?? 'N/A' }}" id="company_rtn" class="form-control @error('company_rtn') is-invalid @enderror" autocomplete="off" />
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
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" maxlength="32" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')"
                                                    name="company_cai" value="{{ $setting->company_cai ?? 'N/A' }}" id="company_cai" class="form-control @error('company_cai') is-invalid @enderror" autocomplete="off" />
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
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" maxlength="50" name="company_email" value="{{ $setting->company_email ?? 'N/A' }}" id="company_email"
                                                    class="form-control @error('company_email') is-invalid @enderror" autocomplete="off" />
                                                @error('company_email')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_email">Email empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" maxlength="8" oninput="this.value = this.value.replace(/\D/g, '')" name="company_phone" value="{{ $setting->company_phone ?? 'N/A' }}"
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

                                    <!-- Company Address -->
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" class="form-control @error('company_short_address') is-invalid @enderror" autocomplete="off"
                                                    maxlength="35" name="company_short_address" id="company_short_address"
                                                    value="{{ $setting->company_short_address ?? 'N/A' }}">
                                                @error('company_short_address')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_short_address">Dirección corta empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" class="form-control @error('company_address') is-invalid @enderror"
                                                    autocomplete="off" maxlength="75" name="company_address" id="company_address"
                                                    value="{{ $setting->company_address ?? 'N/A' }}">
                                                @error('company_address')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_address">Dirección completa empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile screens -->
                    <div class="mt-3 col-md-12 col-sm-12 col-xs-12 d-none d-xl-none d-lg-none d-md-block d-sm-block">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header bg-secondary text-white fw-bold">
                                    <x-heroicon-o-building-office style="width: 20px; height: 20px; color: white" />
                                    Información de la empresa
                                </div>
                                <div class="card-header">
                                    <!-- Company name, rtn, phone and email -->
                                    <div class="row text-center">
                                        <div class="col">
                                            <img class="mb-3" style="border: 1px solid #eee; padding: 5px; border-radius: 5px" id="logoPreviewOld" width="100" height="100" src="{{ Storage::url('sys_config/img/' . ($setting->logo_company ?? 'default_image.png')) }}"><br>
                                            <p>Logo reportes</p>
                                        </div>
                                        <div class="col">
                                            <img class="mb-3" style="border: 1px solid #eee; padding: 5px; border-radius: 5px" id="systemIconPreviewOld" width="100" height="100" src="{{ Storage::url('sys_config/img/' . ($setting->system_icon ?? 'default_image.png')) }}"><br>
                                            <p>Logo sistema</p>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" maxlength="25" name="company_name" value="{{ $setting->company_name ?? 'N/A' }}"
                                                    id="company_name" class="form-control @error('company_name') is-invalid @enderror" autocomplete="off" />
                                                @error('company_name')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_name">Nombre empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" maxlength="14" oninput="this.value = this.value.replace(/\D/g, '')" name="company_rtn" value="{{ $setting->company_rtn ?? 'N/A' }}"
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
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" maxlength="32" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')" name="company_cai" value="{{ $setting->company_cai ?? 'N/A' }}"
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
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" maxlength="50" name="company_email" value="{{ $setting->company_email ?? 'N/A' }}"
                                                    id="company_email" class="form-control @error('company_email') is-invalid @enderror" autocomplete="off" />
                                                @error('company_email')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_email">Email empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" maxlength="8" oninput="this.value = this.value.replace(/\D/g, '')" name="company_phone" value="{{ $setting->company_phone ?? 'N/A' }}"
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

                                    <!-- Company Address -->
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" class="form-control @error('company_short_address') is-invalid @enderror" autocomplete="off"
                                                    maxlength="35" name="company_short_address" id="company_short_address"
                                                    value="{{ $setting->company_short_address ?? 'N/A' }}">
                                                @error('company_short_address')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_short_address">Dirección corta empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-floating">
                                                <input readonly style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                                    type="text" class="form-control @error('company_address') is-invalid @enderror"
                                                    autocomplete="off" maxlength="75" name="company_address" id="company_address"
                                                    value="{{ $setting->company_address ?? 'N/A' }}">
                                                @error('company_address')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                                @enderror
                                                <label for="company_address">Dirección completa empresa <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('modules.settings._sweet_alerts')
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
@endsection