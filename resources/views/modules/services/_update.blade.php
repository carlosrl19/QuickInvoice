<div class="modal fade" id="update_service{{ $service->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #FFB22C; color: #fff">
                <p class="modal-title fw-bold">Actualizar información servicio</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="update_service_form{{ $service->id }}" action="{{ route('services.update', $service->id)}}" novalidate spellcheck="false">
                    @method('PUT')
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="service_name" value="{{ $service->service_name }}" id="service_name" class="form-control @error('service_name') is-invalid @enderror" autocomplete="off" />
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
                                <input type="text" maxlength="6" name="service_nomenclature" oninput="this.value = this.value.toLowerCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ $service->service_nomenclature }}" id="service_nomenclature" class="form-control @error('service_nomenclature') is-invalid @enderror" autocomplete="off" />
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
                            <select class="form-select @error('service_type') is-invalid @enderror" name="service_type">
                                <option value="" selected disabled>Seleccione el impuesto</option>
                                <option value="0" {{ $service->service_type == '0' ? 'selected' : '' }}>EXENTO</option>
                                <option value="1" {{ $service->service_type == '1' ? 'selected' : '' }}>ISV INCLUIDO</option>
                            </select>
                            @error('service_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('service_description') is-invalid @enderror" autocomplete="off" maxlength="255"
                                    name="service_description" rows="6" id="service_description" style="resize: none; height: 100px;">{{ $service->service_description }}</textarea>
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
                    <button type="submit" class="btn btn-round btn-sm bg-warning text-white">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>