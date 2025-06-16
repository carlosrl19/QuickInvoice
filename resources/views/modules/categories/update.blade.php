@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
@endsection

@section('title')
Categorías
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
        <a href="#">Categorías</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de categorías</a>
    </li>
</ul>
@endsection

@section('create')

@endsection

@section('content')
<form method="POST" id="update_category_form" action="{{ route('categories.update', $category->id)}}" novalidate spellcheck="false">
    @method('PUT')
    @csrf
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header bg-warning fw-bold text-white">
                Actualización de información <span class="text-danger">*</span> / {{ $category->category_name }}
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" maxlength="55" name="category_name"
                                oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ $category->category_name }}"
                                id="category_name" class="form-control @error('category_name') is-invalid @enderror" autocomplete="off" />
                            @error('category_name')
                            <span class="invalid-feedback" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <label for="category_name">Nombre de categoría <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="{{ route('categories.index') }}" class="btn btn-round btn-sm bg-dark text-white">Volver</a>
                        <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection