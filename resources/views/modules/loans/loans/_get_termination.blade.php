<div class="modal fade" id="loan-termination-{{ $loan->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="loan-termination-{{ $loan->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('loans.finish', $loan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header" style="background: #0ca678; color: white">
                    <p class="modal-title fw-bold" id="ModalLabel">Finalizar préstamo <span>/</span><span
                            class="fst-italic text-underline"> #{{ $loan->loan_code_number }} </span>
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <input type="hidden" name="loan_payment_type" value="2">
                            <input type="hidden" name="loan_old_debt" value="0"> <!-- Controller calcute this -->
                            <input type="hidden" name="loan_new_debt" value="0">
                            <input type="hidden" name="loan_payment_date" value="{{ Carbon\Carbon::now()->setTimezone('America/Costa_Rica')->format('Y-m-d H:i:s') }}">

                            @php
                            $loan_debt = DB::table('loan_payments')
                            ->where('loan_id', $loan->id)
                            ->sum('loan_quote_payment_amount')
                            @endphp

                            <input type="hidden" name="loan_quote_payment_amount" value="{{$loan->loan_total - $loan_debt}}">
                            <input type="hidden" name="loan_new_debt" value="{{$loan->loan_total - $loan_debt}}">
                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <div class="card-status-start bg-primary"></div>
                                        <input type="text" class="form-control" readonly
                                            name="loan_debt" id="loan_debt"
                                            value="L. {{ number_format($loan->loan_total - $loan_debt, 2) }}">
                                        <label for="loan_debt">Total a pagar / Deuda actual <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3 align-items-end">
                                <div class="col">
                                    <div class="form-floating">
                                        <textarea oninput="this.value = this.value.toUpperCase()" maxlength="255"
                                            style="overflow: hidden; height: 155px; resize: none;"
                                            class="form-control @error('loan_payment_comment') is-invalid @enderror"
                                            autocomplete="off" name="loan_payment_comment"
                                            id="loan_payment_comment"></textarea>
                                        @error('loan_payment_comment')
                                        <span class="invalid-feedback" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                        <label for="loan_payment_comment">Comentarios <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carrusel -->
                        <div class="col-6 mb-3">
                            <div class="card" style="padding: 5px; min-height: 100%; max-height: 100%;">
                                <div class="card-body">
                                    <h5 class="text-center" style="color: gray; font-weight: 400;">
                                        Visualizador (clic en la imagen para expandir)</h5>
                                    <div id="carousel-controls-termination-{{ $loan->id }}" class="carousel slide"
                                        data-bs-ride="carousel">
                                        <div class="carousel-inner"
                                            id="carousel-loan-termination-images-{{ $loan->id }}">
                                            <div class="carousel-item active">
                                                <img class="d-block w-100" alt=""
                                                    src="{{ asset('static/transfer-receipt.png')}}"
                                                    style="min-height: 100%; max-height: 100%;">
                                            </div>
                                        </div>

                                        <a class="carousel-control-prev"
                                            href="#carousel-controls-termination-{{ $loan->id }}" role="button"
                                            data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Anterior</span>
                                        </a>
                                        <a class="carousel-control-next"
                                            href="#carousel-controls-termination-{{ $loan->id }}" role="button"
                                            data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Siguiente</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para vista previa ampliada -->
                        <div class="modal modal-blur fade" id="previewImageLoanTerminationModal-{{ $loan->id }}"
                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                            aria-labelledby="previewImageLoanTerminationLabel-{{ $loan->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="previewImageLoanTerminationLabel-{{ $loan->id }}">
                                            Vista
                                            previa del comprobante</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <img id="previewImageLoanTermination-{{ $loan->id }}" src="" alt=""
                                            class="img-fluid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2 align-items-end">
                        <div class="col">
                            <button type="button" class="btn btn-form btn-secondary"
                                data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-form btn-teal">Finalizar
                                préstamo</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>