<div class="modal fade" id="update_client{{ $client->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #FFB22C; color: #fff">
                <p class="modal-title fw-bold">Actualizar información cliente</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="update_client_form{{ $client->id }}" action="{{ route('clients.update', $client->id)}}" novalidate spellcheck="false">
                    @method('PUT')
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <select class="form-select @error('client_type') is-invalid @enderror" name="client_type">
                                <option value="" selected disabled>Seleccione el tipo de cliente</option>
                                <option value="NATURAL" {{ $client->client_type == "NATURAL" ? 'selected' : '' }}>NATURAL</option>
                                <option value="JURIDICA" {{ $client->client_type == "JURIDICA" ? 'selected' : '' }}>JURIDICA</option>
                            </select>
                            @error('client_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" validate="name" maxlength="55" name="client_name" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ $client->client_name }}" id="client_name" class="form-control @error('client_name') is-invalid @enderror" autocomplete="off" />
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
                                <input type="text" oninput="this.value = this.value.toUpperCase().replace(/\D/g, '')" name="client_document" maxlength="13" minlength="8" value="{{ $client->client_document }}" id="client_document" class="form-control @error('client_document') is-invalid @enderror" autocomplete="off" />
                                @error('client_document')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_document">Nº documento <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" minlength="8" maxlength="8" name="client_phone1" value="{{ $client->client_phone1 }}" id="client_phone1" class="form-control @error('client_phone1') is-invalid @enderror" autocomplete="off">
                                @error('client_phone1')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_phone1">Nº teléfono 1 <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" minlength="8" maxlength="8" name="client_phone2" value="{{ $client->client_phone2 }}" id="client_phone2" class="form-control @error('client_phone2') is-invalid @enderror" autocomplete="off">
                                @error('client_phone2')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_phone2">Nº teléfono 2</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()" class="clamp_text_sm form-control @error('client_address') is-invalid @enderror" autocomplete="off" maxlength="255"
                                    name="client_address" id="client_address" style="resize: none; height: 100px;">{{ $client->client_address }}</textarea>
                                @error('client_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="client_address">Domicilio</label>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-round btn-sm bg-dark text-white" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-round btn-sm bg-warning text-white">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>