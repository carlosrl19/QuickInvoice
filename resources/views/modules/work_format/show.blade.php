@extends('layouts.app')

@section('head')
<style>
    .iframe-doc {
        height: 30rem;
    }

    @media (min-width: 768px) {
        .iframe-doc {
            height: 55rem;
        }
    }
</style>
@endsection

@section('title')
Formato de trabajo
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
        <a href="#">Formato de trabajo</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Detalles de formato</a>
    </li>
</ul>
@endsection

@section('content')
<div class="card" style="width: 100%">
    <div class="card-body">
        <a href="{{ route('formats.index') }}" class="btn btn-sm btn-danger mb-1">
            <x-heroicon-o-arrow-uturn-left style="width: 15px; height: 15px; color: white" /> Volver
        </a>
        <iframe frameborder="0" class="iframe-doc" style="width: 100%;" src="{{ route('formats.format_details',$format->id) }}"></iframe>
    </div>
</div>
@endsection