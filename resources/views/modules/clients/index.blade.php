@extends('layouts.app')

@section('head')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('title')
Clientes
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
        <a href="#">Clientes</a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de clientes</a>
    </li>
</ul>
@endsection

@section('pretitle')
Listado de clientes
@endsection

@section('create')
<a href="#" class="btn btn-sm btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_client">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear cliente
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_clients_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Nombre cliente</th>
                                <th>Documento</th>
                                <th>Tipo cliente</th>
                                <th>Teléfono 1</th>
                                <th>Teléfono 2</th>
                                <th>Domicilio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                <td>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#update_client{{ $client->id }}">
                                        {{ $client->client_name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $client->client_document }}
                                </td>
                                <td>
                                    {{ $client->client_type }}
                                </td>
                                <td>
                                    {{ $client->client_phone1 }}
                                </td>
                                <td>
                                    <span class="{{ $client->client_phone2 ? 'text-dark':'text-muted op-3' }}">
                                        {{ $client->client_phone2 ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="{{ $client->client_address ? 'text-dark':'text-muted op-3' }}">
                                        {{ $client->client_address ?? 'N/A' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="#" class="badge bg-danger text-white" id="delete_client{{ $client->id }}">
                                        <x-heroicon-o-trash style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- N+1 include -->
@include('modules.clients._sweet_alerts')
@include('modules.clients._update')
@include('modules.clients._create')

@endsection

@section('scripts')

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/clients/dt_clients_index.js') }}"></script>

@endsection