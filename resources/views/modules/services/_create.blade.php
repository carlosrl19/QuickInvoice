<div class="modal fade" id="create_service" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nuevo servicio</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="create_service_form" action="{{ route('services.store')}}" novalidate spellcheck="false">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="service_name" value="{{ old('service_name') }}" id="service_name" class="form-control @error('service_name') is-invalid @enderror" autocomplete="off" />
                                @error('service_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="service_name">Nombre del servicio <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="6" name="service_nomenclature" oninput="this.value = this.value.toCapitalize().replace(/[0-9]/g, '')" value="{{ old('service_nomenclature') }}" id="service_nomenclature" class="form-control @error('service_nomenclature') is-invalid @enderror" autocomplete="off" />
                                @error('service_nomenclature')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="service_nomenclature">Nomenclatura del servicio <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('service_description') is-invalid @enderror" autocomplete="off" maxlength="255"
                                    name="service_description" rows="6" id="service_description" style="resize: none; height: 100px;">{{ old('service_description') }}</textarea>
                                @error('service_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="service_description">Detalles de servicio</label>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-round btn-sm bg-dark text-white" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>