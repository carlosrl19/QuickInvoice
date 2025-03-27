@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
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
    <li class="nav-item d-none d-xl-inline d-lg-inline">
        <a href="#">Clientes</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de clientes</a>
    </li>
</ul>
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
                                <th>Acciones</th>
                                <th>Código cliente</th>
                                <th>Nombre cliente</th>
                                <th>Documento</th>
                                <th>Tipo cliente</th>
                                <th>Teléfono 1</th>
                                <th>Teléfono 2</th>
                                <th>Domicilio</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-danger text-white" id="delete_client{{ $client->id }}">
                                        <x-heroicon-o-trash style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                                <td>
                                    {{ $client->client_code }}
                                </td>
                                <td>
                                    <a href="{{ route('clients.edit', $client->id) }}">
                                        {{ $client->client_name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $client->client_document }}
                                </td>
                                <td>
                                    {{ $client->client_type == 'N' ? 'NATURAL':'JURIDICA' }}
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
                            </tr>
                            @include('modules.clients._sweet_alerts')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Includes -->
@include('modules.clients._create')

@endsection

@section('scripts')

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/clients/dt_clients_index.js') }}"></script>

@endsection