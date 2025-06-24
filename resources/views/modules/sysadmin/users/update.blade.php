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
Usuarios
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
        <a href="#">Usuarios</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de usuarios</a>
    </li>
</ul>
@endsection

@section('create')

@endsection

@section('content')
<form method="POST" id="update_user_form" action="{{ route('users.update', $user->id)}}" novalidate autocomplete="off" spellcheck="false">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-warning fw-bold text-white">
                    Actualización de información <span class="text-danger">*</span> / {{ $user->name }}
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="profile_photo" class="text-xs">Imagen actual del usuario</label>
                            <div class="card">
                                <div class="card-body">
                                    <img width="150" height="150" src="{{ Storage::url('uploads/users/' . $user->profile_photo) ?: Storage::url('sys_config/img/no_image_available.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="profile_photo" class="text-xs">Imagen de usuario <span class="text-danger">*</span></label>
                            <input type="file" class="filepond @error('profile_photo') is-invalid @enderror" accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml" id="profile_photo" name="profile_photo">
                            @error('profile_photo')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="name" value="{{ $user->name }}" id="name" class="form-control @error('name') is-invalid @enderror" autocomplete="off" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="name">Nombre usuario <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <input type="email" oninput="this.value = this.value.toLowerCase()" maxlength="55" name="email" value="{{ $user->email }}" id="email" class="form-control @error('email') is-invalid @enderror" autocomplete="off" />
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="email">Email usuario <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating position-relative">
                                <input type="password" maxlength="55" name="password" value="{{ old('password') }}" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="off" />
                                <button type="button" class="btn btn-sm btn-outline-primary position-absolute top-50 end-0 translate-middle-y me-2" style="z-index:2;" onclick="var p=document.getElementById('password');p.type=p.type==='password'?'text':'password';this.innerText=p.type==='password'?'Ver':'Ocultar';">Ver</button>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="password">Contraseña usuario <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <label for="profile_photo" class="text-xs">Role de usuario <span class="text-danger">*</span></label>
                            <select class="tom-select" id="role" name="role">
                                <option value="" disabled>Seleccione el role del usuario</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->role == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('users.index') }}" class="btn btn-round btn-sm bg-dark text-white">Volver</a>
                            <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
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
    FilePond.create(document.querySelector('input[name="profile_photo"]'));

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