@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
@endsection

@section('title')
Servicios
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
    <li class="nav-item">
        <a href="#">Servicios</a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de servicios</a>
    </li>
</ul>
@endsection

@section('pretitle')
Listado de servicios
@endsection

@section('create')
<a href="#" class="btn btn-sm btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_service">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear servicio
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_services_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Nombre servicio</th>
                                <th>Nomenclatura</th>
                                <th>Detalles</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                            <tr>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#update_service{{ $service->id }}">
                                        {{ $service->service_name }}
                                    </a>
                                </td>
                                <td>
                                    <span class="{{ $service->service_nomenclature ? 'text-dark':'text-muted op-3' }}">
                                        {{ $service->service_nomenclature ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="{{ $service->service_description ? 'text-dark':'text-muted op-3' }}">
                                        {{ $service->service_description ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="badge bg-danger text-white" id="delete_service{{ $service->id }}">
                                        <x-heroicon-o-trash style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                            </tr>

                            <!-- Update/Delete include -->
                            @include('modules.services._update')
                            @include('modules.services._sweet_alerts')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Includes -->
@include('modules.services._create')

@endsection

@section('scripts')

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/services/dt_services_index.js') }}"></script>

@endsection