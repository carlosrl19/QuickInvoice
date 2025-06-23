@extends('layouts.app')

@section('head')
<!-- SweetAlert -->
<script src="{{ Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

<!-- Tomselect -->
<link href="{{ Storage::url('assets/js/plugin/tomselect/tom-select.min.css') }}" rel="stylesheet">
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
        <a href="#">Formulario online</a>
    </li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                Formulario de trabajo online
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('formats.work_format_online_store')}}" novalidate autocomplete="off" autocomplete="off" spellcheck="false">
                    @csrf
                    <input type="hidden" name="workformat_date" id="workformat_date" value="{{ $todayDate }}">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="workformat_date" class="text-xs">Fecha hora actual<span class="text-danger">*</span></label>
                                    <input type="datetime-local" readonly class="form-control @error('workformat_date') is-invalid @enderror" value="{{ $todayDate }}">
                                    @error('workformat_date')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="55" name="client_name" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ0-9\s]/g, '')" value="{{ old('client_name') }}" id="client_name" class="form-control @error('client_name') is-invalid @enderror" />
                                        @error('client_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="client_name">Nombre cliente <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="8" name="client_phone" oninput="this.value = this.value.toUpperCase().replace(/[^0-9]/g, '')" value="{{ old('client_phone') }}" id="client_phone" class="form-control @error('client_phone') is-invalid @enderror" />
                                        @error('client_phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="client_phone">Teléfono cliente <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="255" name="client_address" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z\s]/g, '')" value="{{ old('client_address') }}" id="client_address" class="form-control @error('client_address') is-invalid @enderror" />
                                        @error('client_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="client_address">Dirección cliente <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" maxlength="55" name="worker_name" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z\s]/g, '')" value="{{ old('worker_name') }}" id="worker_name" class="form-control @error('worker_name') is-invalid @enderror" />
                                        @error('worker_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="worker_name">Técnico encargado <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" readonly style="background-color: white !important;" maxlength="19" name="receipt_number" oninput="this.value = this.value.toUpperCase().replace(/[^0-9]/g, '')" value="NO DISPONIBLE" id="receipt_number" class="form-control @error('receipt_number') is-invalid @enderror" />
                                        @error('receipt_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="receipt_number">Nº Factura</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <label for="workformat_type" class="text-xs @error('workformat_type') is-invalid @enderror">Tipo de trabajo <span class="text-danger">*</span></label>
                                    <select class="tom-select" id="workformat_type" name="workformat_type">
                                        <option value="" disabled {{ old('workformat_type') === null ? 'selected' : '' }}>Seleccione el tipo de trabajo</option>
                                        <option value="0" {{ old('workformat_type') == '0' ? 'selected' : '' }}>ORDEN DE TRABAJO</option>
                                        <option value="1" {{ old('workformat_type') == '1' ? 'selected' : '' }}>ESTUDIO DE CAMPO</option>
                                        <option value="2" {{ old('workformat_type') == '2' ? 'selected' : '' }}>REVISIÓN DE EQUIPO</option>
                                        <option value="3" {{ old('workformat_type') == '3' ? 'selected' : '' }}>RECEPCIÓN DE EQUIPO</option>
                                        <option value="4" {{ old('workformat_type') == '4' ? 'selected' : '' }}>ENTREGA DE EQUIPO</option>
                                    </select>
                                    @error('workformat_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('workformat_description') is-invalid @enderror" maxlength="600"
                                            name="workformat_description" rows="10" id="workformat_description" style="resize: none;">{{ old('workformat_description') }}</textarea>
                                        @error('workformat_description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="workformat_description">Descripción del trabajo<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="form-floating" style="width: 100%; height: 200px;">
                                    <canvas id="signatureCanvas" class="form-control @error('client_signature') is-invalid @enderror"></canvas>
                                    @error('client_signature')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    <label>Firma del cliente <span class="text-danger">*</span></label>
                                </div>
                                <input type="hidden" name="client_signature" id="signatureInput">

                                <button type="button" class="btn btn-xs btn-danger" style="float: right" id="clearSignature">Limpiar</button>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <a href="{{ route('formats.index') }}" class="btn btn-sm btn-dark btn-round">Regresar</a>
                            <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<!-- SignaturePad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script src="{{ Storage::url('customjs/workformats/signatures.js') }}"></script>

<!-- Tomselect -->
<script src="{{ Storage::url('assets/js/plugin/tomselect/tom-select.complete.js') }}"></script>
<script src="{{ Storage::url('customjs/tomselect/ts_init.js') }}"></script>

<!-- Laravel Javascript validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! $validator !!}
@endsection