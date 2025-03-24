<div class="modal fade" id="create_client" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nuevo cliente</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="create_client_form" action="{{ route('clients.store')}}" novalidate spellcheck="false">
                    @csrf
                    <input type="hidden" name="client_code" id="client_code" value="123456789"> <!-- Controller get this -->
                    <input type="hidden" name="client_status" id="client_status" value="1"> <!-- Controller get this -->

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab" aria-controls="general" aria-selected="true">Datos generales <span class="text-danger">*</span></button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="adicional-tab" data-bs-toggle="tab" data-bs-target="#adicional" type="button" role="tab" aria-controls="adicional" aria-selected="false">Datos adicionales</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <!-- Datos generales -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                            <div class="row mb-3 mt-3">
                                <div class="col">
                                    <select class="form-select @error('client_type') is-invalid @enderror" name="client_type">
                                        <option value="" selected disabled>Seleccione el tipo de cliente</option>
                                        <option value="NATURAL" {{ old('client_type') == 'NATURAL' ? 'selected' : '' }}>NATURAL</option>
                                        <option value="JURIDICA" {{ old('client_type') == 'JURIDICA' ? 'selected' : '' }}>JURIDICA</option>
                                    </select>
                                    @error('client_type')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="col">
                                    <select class="form-select @error('client_exonerated') is-invalid @enderror" name="client_exonerated">
                                        <option value="" selected disabled>Seleccione el exonerado</option>
                                        <option value="1" {{ old('client_exonerated') == '1' ? 'selected' : '' }}>CLIENTE EXONERADO</option>
                                        <option value="0" {{ old('client_exonerated') == '0' ? 'selected' : '' }}>CLIENTE SIN EXONERADO</option>
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
                                        <input type="text" maxlength="55" name="client_name"
                                            oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ old('client_name') }}"
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
                                            maxlength="14" minlength="13" value="{{ old('client_document') }}" id="client_document"
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
                                            name="client_phone1" value="{{ old('client_phone1') }}" id="client_phone1"
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
                                            name="client_phone2" value="{{ old('client_phone2') }}" id="client_phone2"
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
                                            value="{{ old('client_email') }}" id="client_email"
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
                        </div>

                        <!-- Datos adicionales -->
                        <div class="tab-pane fade" id="adicional" role="tabpanel" aria-labelledby="adicional-tab">
                            <div class="row mb-3 mt-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="date" name="client_birthdate" value="{{ old('client_birthdate') }}" id="client_birthdate"
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
                                            minlength="8" maxlength="8" value="{{ old('client_phone_home') }}" id="client_phone_home"
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
                                            oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ old('client_actual_job') }}"
                                            id="client_actual_job" class="form-control @error('client_actual_job') is-invalid @enderror" autocomplete="off" />
                                        @error('client_actual_job')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="client_actual_job">Nombre trabajo actual</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" name="client_job_length" oninput="this.value = this.value.replace(/\D/g, '')"
                                            minlength="8" maxlength="8" value="{{ old('client_job_length') }}" id="client_job_length"
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
                                            minlength="8" maxlength="8" value="{{ old('client_phone_work') }}" id="client_phone_work"
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
                                    <div class="form-floating">
                                        <input type="text" maxlength="55" name="client_last_job"
                                            oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ old('client_last_job') }}"
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
                                    <select class="form-select @error('client_own_business') is-invalid @enderror" name="client_own_business">
                                        <option value="" selected disabled>Seleccione si es dueño de negocios</option>
                                        <option value="1" {{ old('client_own_business') == '1' ? 'selected' : '' }}>CLIENTE CON NEGOCIOS</option>
                                        <option value="0" {{ old('client_own_business') == '0' ? 'selected' : '' }}>CLIENTE SIN NEGOCIO</option>
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
                                            name="client_address" rows="6" id="client_address" style="resize: none;">{{ old('client_address') }}</textarea>
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
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-round btn-sm bg-dark text-white" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>