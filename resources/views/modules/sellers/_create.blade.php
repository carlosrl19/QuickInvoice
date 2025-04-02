<div class="modal fade" id="create_seller" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nuevo vendedor</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="create_seller_form" action="{{ route('sellers.store')}}" novalidate spellcheck="false">
                    @csrf
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="55" name="seller_name" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="{{ old('seller_name') }}" id="seller_name" class="form-control @error('seller_name') is-invalid @enderror" autocomplete="off" />
                                @error('seller_name')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="seller_name">Nombre del vendedor <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.toUpperCase().replace(/\D/g, '')" name="seller_document" maxlength="13" minlength="8" value="{{ old('seller_document') }}" id="seller_document" class="form-control @error('seller_document') is-invalid @enderror" autocomplete="off" />
                                @error('seller_document')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="seller_document">Nº identidad <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" minlength="8" maxlength="8" name="seller_phone" value="{{ old('seller_phone') }}" id="seller_phone" class="form-control @error('seller_phone') is-invalid @enderror" autocomplete="off">
                                @error('seller_phone')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="seller_phone">Nº teléfono<span class="text-danger">*</span></label>
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