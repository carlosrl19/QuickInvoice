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
                <form method="POST" id="create_seller_form" action="{{ route('settings.update', $setting->id)}}" enctype="multipart/form-data" novalidate spellcheck="false">
                    @method('PUT')
                    @csrf
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <p class="text-muted fw-bold">Logo en reporte</p>
                        <div class="row mb-3">
                            <div class="col">
                                <div class="row mb-3">
                                    <div class="col-md-6 text-center">
                                        <img class="mb-3" style="margin: auto" id="logoPreviewOld" width="100" height="100" src="{{ Storage::url('sys_config/img/' . $setting->logo_company) }}"><br>
                                        <label for="logoPreviewOld">Imagen actual</label>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <img class="mb-3" style="margin: auto" id="logoPreview" width="100" height="100"><br>
                                        <label for="logoPreview">Imagen nueva</label>
                                    </div>
                                </div>
                                <div class="form-floating">
                                    <input type="file" class="form-control" accept="image/*" id="logo_company" name="logo_company" onchange="previewImage(event, '#logoPreview')">
                                    <label for="logo_company">Logo para reportes</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <p class="text-muted fw-bold">Icono del sistema</p>
                        <div class="row mb-3">
                            <div class="col">
                                <select class="form-select @error('show_system_name') is-invalid @enderror" name="show_system_name">
                                    <option value="" selected disabled>Seleccione si mostrar nombre del sistema en panel izquierdo</option>
                                    <option value="1" {{ old('show_system_name') ?? $setting->show_system_name == '1' ? 'selected' : '' }}>MOSTRAR NOMBRE DEL SISTEMA</option>
                                    <option value="0" {{ old('show_system_name') ?? $setting->show_system_name == '0' ? 'selected' : '' }}>OCULTAR NOMBRE DEL SISTEMA</option>
                                </select>
                                @error('show_system_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <div class="row mb-3">
                                    <div class="col-md-6 text-center">
                                        <img class="mb-3" style="margin: auto" id="systemIconPreviewOld" width="100" height="100" src="{{ Storage::url('sys_config/img/' . $setting->system_icon) }}"><br>
                                        <label for="systemIconPreviewOld">Imagen actual</label>
                                    </div>
                                    <div class="col-md-6 text-center">
                                        <img class="mb-3" style="margin: auto" id="systemIconPreview" width="100" height="100"><br>
                                        <label for="systemIconPreview">Imagen nueva</label>
                                    </div>
                                </div>
                                <div class="form-floating">
                                    <input type="file" class="form-control" accept="image/*" id="system_icon" name="system_icon" onchange="previewImage(event, '#systemIconPreview')">
                                    <label for="system_icon">Icono del sistema</label>
                                </div>
                            </div>
                        </div>
                    </div>

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
@endsection