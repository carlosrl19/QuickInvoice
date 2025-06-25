@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
@endsection

@section('title')
Salida de inventario - Ventas
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
        <a href="#">Salida de inventario - Ventas </a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de ventas</a>
    </li>
</ul>
@endsection

@section('create')
<a href="{{ route('sales.create') }}" class="btn btn-sm btn-label-primary btn-round me-2">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear salida
</a>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_pos_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Doc. salida</th>
                                <th>Fecha salida</th>
                                <th>Total salida</th>
                                <th>Descripción salida</th>
                                <th>Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sales as $sale)
                            <tr>
                                <td>
                                    <a class="badge bg-danger text-white" href="{{ route('sales.show', $sale->id) }}">
                                        <x-heroicon-o-printer style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-secondary2 text-secondary">
                                        {{ $sale->sale_doc_number }}
                                    </span>
                                </td>
                                <td>{{ $sale->created_at }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        L. {{ number_format($sale->sale_total_amount,2) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="{{ $sale->sale_description ? '' : 'text-muted' }}">
                                        {{ $sale->sale_description ? $sale->sale_description : '--- SIN DESCRIPCION ---' }}
                                    </span>
                                </td>
                                <td>{{ $sale->user->name }}</td>
                            </tr>
                            @include('modules.sales._sweet_alerts')
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<!-- Datatables -->
<script src="{{ Storage::url('assets/js/plugin/datatables/datatables.min.js') }}"></script>
<script src="{{ Storage::url('customjs/datatables/pos/dt_pos_index.js') }}"></script>

@endsection