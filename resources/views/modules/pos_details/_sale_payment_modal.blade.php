<div class="modal fade" id="sale_payment_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Finalizar cobro</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col">
                        <select class="form-select @error('sale_payment_type') is-invalid @enderror" name="sale_payment_type">
                            <option value="" selected disabled>Seleccione el tipo de pago</option>
                            <option value="1" {{ old('sale_payment_type') == '1' ? 'selected' : '' }}>EFECTIVO</option>
                            <option value="2" {{ old('sale_payment_type') == '2' ? 'selected' : '' }}>TARJETA</option>
                            <option value="3" {{ old('sale_payment_type') == '3' ? 'selected' : '' }}>DEPOSITO</option>
                        </select>
                        @error('sale_payment_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-floating">
                            <input type="number" value="" name="sale_total_amount" id="total_amount" class="form-control" autocomplete="off" />
                            <label for="sale_total_amount">Total a pagar <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-floating">
                            <input type="number" min="0" name="sale_payment" value="" id="sale_payment" class="form-control" autocomplete="off" />
                            @error('sale_payment')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label for="sale_payment">Recibido <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                        <div class="form-floating">
                            <input type="number" name="sale_payment_change" min="0" value="" id="sale_payment_change" class="form-control" autocomplete="off" />
                            @error('sale_payment_change')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <label for="sale_payment_change">Cambio <span class="text-danger">*</span></label>
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