@extends('layouts.app')

@section('pretitle')
Listado de consignaciones
@endsection

@section('title')
<span class="text-muted text-sm">Información consignación</span>
@endsection

@section('content')
<div class="card" style="width: 100%">
    <div class="card-header">
        <a href="{{ route('consignments.index') }}" class="btn btn-sm btn-danger mb-1">
            <x-heroicon-o-arrow-uturn-left style="width: 15px; height: 15px; color: white" /> Volver
        </a>
        <span class="float-end">Consignación / Pagaré #{{ $consignment->consignment_code }}</strong>
    </div>
    <div class="card-body">
        <iframe style="width:100%; height: 900px;" src="{{ route('consignments.consignment_format_print', ['id' => $consignment->id]) }}"></iframe>
    </div>
</div>
@endsection