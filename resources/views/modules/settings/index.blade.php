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
                    <div class="col-xl-2 col-lg-2 col-md-4 col-sm-4">
                        <div class="sidebar-secundario bg-light border p-3 h-100">
                            <p class="text-muted">Opciones de configuración</p>
                            <ul class="nav flex-column">
                                <li style="border-bottom: 1px solid #eee;" class="nav-item">
                                    @if(App\Models\Settings::count() == 0)
                                    <a class="nav-link text-muted" href="{{ route('settings.create') }}">
                                        <x-heroicon-o-document-text style="width: 20px; height: 20px; color: gray" />
                                        Reportes
                                    </a>
                                    @else
                                    <a class="nav-link text-muted" href="{{ route('settings.edit', App\Models\Settings::first()) }}">
                                        <x-heroicon-o-document-text style="width: 20px; height: 20px; color: gray" />
                                        Reportes
                                    </a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xl-10 col-lg-10 col-md-8 col-sm-8">

                    </div>
                </div>
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