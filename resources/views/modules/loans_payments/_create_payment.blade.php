<div class="modal fade" id="quote_payment_{{ $loan->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Nuevo pago de cuota / <small>#{{ $loan->loan_code }}</small></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('loan_payments.quote_payment', $loan->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xl-12">
                            <input type="hidden" name="loan_id" value="{{ $loan->id }}">
                            <input type="hidden" name="client_id" value="{{ $loan->client->id }}">
                            <input type="hidden" name="loan_old_debt" value="1"> <!-- Controller calculate this -->
                            <input type="hidden" name="loan_new_debt" value="1"> <!-- Controller calculate this -->
                            <input type="hidden" name="loan_payment_type" value="0">
                            <input type="hidden" name="loan_payment_date" value="{{ Carbon\Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s') }}">

                            <!-- Payment amount -->
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="text" style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" readonly class="text-muted input-form form-control" value="#{{ $loan->loan_code }}">
                                        <label for="loan_code">Codigo préstamo <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-floating">
                                        <input type="number" style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" readonly name="loan_payment_amount" step="any" value="{{ $loan->loan_quote_value }}" id="loan_payment_amount" class="input-form form-control @error('loan_payment_amount') is-invalid @enderror" />
                                        @error('loan_payment_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="loan_payment_amount">Monto del pago <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment img -->
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-3">
                                    <div class="image-upload-container w-100">
                                        <label for="loan_payment_img" class="image-upload-label w-100">
                                            <x-heroicon-o-cloud-arrow-up style="width: 20px; height: 20px;" /> Subir comprobante(s)
                                        </label>
                                        <input multiple type="file" accept="image/*"
                                            class="image-upload-input d-none @error('loan_payment_img') is-invalid @enderror"
                                            id="loan_payment_img" name="loan_payment_img[]"
                                            onchange="carouselLoanPaymentsViewer(event, '{{ $loan->id }}')">
                                    </div>
                                    <div id="image-preview-container" class="image-preview-container"></div>
                                </div>
                            </div>

                            <!-- Payment comment -->
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="form-floating">
                                        <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('loan_payment_comment') is-invalid @enderror" autocomplete="off" maxlength="255"
                                            name="loan_payment_comment" id="loan_payment_comment" rows="8" style="resize: none;">{{ old('loan_payment_comment') }}</textarea>
                                        @error('loan_payment_comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        <label for="loan_payment_comment">Comentarios</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="d-flex justify-content-start">
                                <button type="button" class="btn btn-round btn-sm bg-dark text-white" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom input file -->
<link rel="stylesheet" href="{{ Storage::url('css/loan_paymentscustom_input_file.css') }}">
<script src="{{ Storage::url('customjs/loans/loan_payment_custom_input_file.js') }}"></script>