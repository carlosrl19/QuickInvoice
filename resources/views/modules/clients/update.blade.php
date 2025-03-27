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

@endsection

@section('content')
<form method="POST" id="create_client_form" action="{{ route('clients.update', $client->id)}}" novalidate spellcheck="false">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-warning fw-bold text-white">
                    Actualización de información <span class="text-danger">*</span> / {{ $client->client_name }}
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select @error('client_type') is-invalid @enderror" name="client_type">
                                <option value="" selected disabled>Seleccione el tipo de cliente</option>
                                <option value="N" {{ old('client_type') ?? $client->client_type == 'N' ? 'selected':'' }}>NATURAL</option>
                                <option value="J" {{ old('client_type') ?? $client->client_type == 'J' ? 'selected':'' }}>JURIDICA</option>
                            </select>
                            @error('client_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col">
                            <select class="form-select @error('client_status') is-invalid @enderror" name="client_status">
                                <option value="" selected disabled>Seleccione el estado del cliente</option>
                                <option value="1" {{ old('client_status') ?? $client->client_status == '1' ? 'selected' : '' }}>ACTIVO</option>
                                <option value="0" {{ old('client_status') ?? $client->client_status == '0' ? 'selected' : '' }}>INACTIVO</option>
                            </select>
                            @error('client_status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select @error('client_exonerated') is-invalid @enderror" name="client_exonerated">
                                <option value="" selected disabled>Seleccione el exonerado</option>
                                <option value="1" {{ old('client_exonerated') ?? $client->client_exonerated == '1' ? 'selected' : '' }}>CLIENTE EXONERADO</option>
                                <option value="0" {{ old('client_exonerated') ?? $client->client_exonerated == '0' ? 'selected' : '' }}>CLIENTE SIN EXONERADO</option>
                            </select>
                            @error('client_exonerated')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" readonly id="client_code" name="client_code" value=" {{ $client->client_code }}" class="form-control"
                                    style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" />
                                <label for=" client_code">Código del cliente <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="client_name"
                                    oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ $client->client_name }}"
                                    id="client_name" class="form-control @error('client_name') is-invalid @enderror" autocomplete="off" />
                                @error('client_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_name">Nombre del cliente <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.toUpperCase().replace(/\D/g, '')" name="client_document"
                                    maxlength="14" minlength="13" value="{{ $client->client_document }}" id="client_document"
                                    class="form-control @error('client_document') is-invalid @enderror" autocomplete="off" />
                                @error('client_document')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_document">Nº documento <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" minlength="8" maxlength="8"
                                    name="client_phone1" value="{{ $client->client_phone1 }}" id="client_phone1"
                                    class="form-control @error('client_phone1') is-invalid @enderror" autocomplete="off">
                                @error('client_phone1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_phone1">Nº teléfono 1 <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" minlength="8" maxlength="8"
                                    name="client_phone2" value="{{ $client->client_phone2 }}" id="client_phone2"
                                    class="form-control @error('client_phone2') is-invalid @enderror" autocomplete="off">
                                @error('client_phone2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_phone2">Nº teléfono 2</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" name="client_email"
                                    oninput="this.value = this.value.replace(/[^a-zA-Z0-9@.]/g, ''); this.value = this.value.replace(/\.{2,}/g, '.');"
                                    value="{{ $client->client_email }}" id="client_email"
                                    class="form-control @error('client_email') is-invalid @enderror" autocomplete="off">
                                @error('client_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_email">Email</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="{{ route('clients.index') }}" class="btn btn-round btn-sm bg-dark text-white">Volver</a>
                            <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-secondary fw-bold text-white">
                    Información adicional
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" name="client_birthdate" value="{{ $client->client_birthdate }}" id="client_birthdate"
                                    class="form-control @error('client_birthdate') is-invalid @enderror" autocomplete="off">
                                @error('client_birthdate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_birthdate">Fecha nacimiento</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" name="client_phone_home" oninput="this.value = this.value.replace(/\D/g, '')"
                                    minlength="8" maxlength="8" value="{{ $client->client_phone_home }}" id="client_phone_home"
                                    class="form-control @error('client_phone_home') is-invalid @enderror" autocomplete="off">
                                @error('client_phone_home')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_phone_home">Teléfono casa</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="client_actual_job"
                                    oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ $client->client_actual_job }}"
                                    id="client_actual_job" class="form-control @error('client_actual_job') is-invalid @enderror" autocomplete="off" />
                                @error('client_actual_job')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_actual_job">Nombre trabajo actual</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="client_last_job"
                                    oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ $client->client_last_job }}"
                                    id="client_last_job" class="form-control @error('client_last_job') is-invalid @enderror" autocomplete="off" />
                                @error('client_last_job')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_last_job">Nombre trabajo anterior</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" name="client_job_length" oninput="this.value = this.value.replace(/\D/g, '')"
                                    minlength="8" maxlength="8" value="{{ $client->client_job_length }}" id="client_job_length"
                                    class="form-control @error('client_job_length') is-invalid @enderror" autocomplete="off">
                                @error('client_job_length')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_job_length">Antiguedad laboral (meses)</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" name="client_phone_work" oninput="this.value = this.value.replace(/\D/g, '')"
                                    minlength="8" maxlength="8" value="{{ $client->client_phone_work }}" id="client_phone_work"
                                    class="form-control @error('client_phone_work') is-invalid @enderror" autocomplete="off">
                                @error('client_phone_work')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_phone_work">Teléfono trabajo</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select @error('client_own_business') is-invalid @enderror" name="client_own_business">
                                <option value="" selected disabled>Seleccione si es dueño de negocios</option>
                                <option value="1" {{ old('client_own_business') ?? $client->client_own_business == '1' ? 'selected' : '' }}>CLIENTE CON NEGOCIOS</option>
                                <option value="0" {{ old('client_own_business') ?? $client->client_own_business == '0' ? 'selected' : '' }}>CLIENTE SIN NEGOCIO</option>
                            </select>
                            @error('client_own_business')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()"
                                    class="form-control @error('client_address') is-invalid @enderror" autocomplete="off" maxlength="255"
                                    name="client_address" rows="6" id="client_address" style="resize: none;">{{ $client->client_address }}</textarea>
                                @error('client_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_address">Domicilio</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection