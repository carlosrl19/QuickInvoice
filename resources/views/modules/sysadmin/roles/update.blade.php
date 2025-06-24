@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
@endsection

@section('title')
Roles
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
        <a href="#">Roles</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de roles</a>
    </li>
</ul>
@endsection

@section('create')

@endsection

@section('content')
<form method="POST" id="update_role_form" action="{{ route('roles.update', $role->id)}}" novalidate autocomplete="off" spellcheck="false">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-warning fw-bold text-white">
                    Actualización de información <span class="text-danger">*</span> / {{ $permission->name }}
                </div>
                <div class="card-body">
                    <div class="mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="name" value="{{ $permission->name }}" id="name" class="form-control @error('name') is-invalid @enderror" autocomplete="off" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="name">Nombre role <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <div class="form-floating">
                                <textarea class="form-control @error('role_description') is-invalid @enderror" autocomplete="off" maxlength="255"
                                    name="role_description" id="role_description" style="resize: none; height: 100px; font-size: clamp(0.6rem, 3vw, 0.7rem)">{{ $permission->role_description }}</textarea>
                                @error('role_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="role_description">Descripción role <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-round btn-sm bg-dark text-white" data-bs-dismiss="modal">Cancelar</button>
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
<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! $validator !!}
@endsection