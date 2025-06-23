@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
@endsection

@section('title')
Formatos de trabajo
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
        <a href="#">Formatos de trabajo</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de formatos creados</a>
    </li>
</ul>
@endsection

@section('create')
<a href="{{ route('formats.work_format') }}" class="btn btn-sm btn-label-primary btn-round me-2">
    <x-heroicon-o-document-text style="width: 20px; height: 20px;" />
    Imprimir formato
</a>

<a href="{{ route('formats.work_format_online') }}" class="btn btn-sm btn-label-info btn-round me-2">
    <x-heroicon-o-plus style="width: 20px; height: 20px;" class="bg-label-info" />
    Crear formato online
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
                                <th>Fecha</th>
                                <th>Nombre cliente</th>
                                <th>Teléfono</th>
                                <th>Tipo formato</th>
                                <th>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($workformats as $format)
                            <tr>
                                <td>
                                    <a href="#" class="badge bg-danger text-white" id="delete_format{{ $format->id }}">
                                        <x-heroicon-o-trash style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="badge bg-primary text-white">
                                        {{ $format->workformat_date }}
                                    </a>
                                </td>
                                <td>
                                    {{ $format->client_name }}
                                </td>
                                <td>
                                    {{ $format->client_phone }}
                                </td>
                                <td>
                                    @if($format->workformat_type == 0)
                                    <span class="badge bg-success2 text-dark fw-bold">ORDEN DE TRABAJO</span>
                                    @elseif($format->workformat_type == 1)
                                    <span class="badge bg-primary2 text-primary fw-bold">ESTUDIO DE CAMPO</span>
                                    @elseif($format->workformat_type == 2)
                                    <span class="badge bg-warning2 text-warning fw-bold">REVISIÓN DE EQUIPO</span>
                                    @elseif($format->workformat_type == 3)
                                    <span class="badge bg-secondary2 text-secondary fw-bold">RECEPCIÓN DE EQUIPO</span>
                                    @elseif($format->workformat_type == 4)
                                    <span class="badge bg-success2 text-success fw-bold">ENTREGA DE EQUIPO</span>
                                    @else
                                    <span class="badge bg-danger2 text-danger fw-bold">ERROR</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('formats.show', $format->id) }}" class="badge bg-danger text-white2">
                                        <x-heroicon-o-printer style="width: 20px; height: 20px; color: white;" />
                                    </a>
                                </td>
                            </tr>
                            @include('modules.work_format._sweet_alerts')
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
<script src="{{ Storage::url('customjs/datatables/clients/dt_clients_index.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! $validator !!}

@endsection