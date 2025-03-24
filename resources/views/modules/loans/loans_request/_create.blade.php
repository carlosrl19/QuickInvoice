<div class="modal fade" id="create_loan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nueva solicitud de préstamo</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('loans.store')}}" method="POST">
                    @csrf
                    <input type="hidden" name="loan_status" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="loan_request_status" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="loan_code_number" value="892739213"> <!-- Controller get this -->
                    <input type="hidden" name="loan_request_number" value="892739213"> <!-- Controller get this -->

                    <!-- Client / Payment type -->
                    <div class="row mb-3">
                        <div class="col" id="seller_select_container">
                            <select class="tom-select" id="seller_id_select" name="seller_id">
                                <option value="" selected disabled>Seleccione el vendedor</option>
                                @foreach ($sellers as $seller)
                                <option value="{{ $seller->id }}" {{ $seller->id == 1 ? 'selected' : '' }}>{{ $seller->seller_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <select class="tom-select  @error('client_id') is-invalid @enderror" id="client_id_select" name="client_id">
                                    <option value="" selected disabled>Seleccione el cliente</option>
                                    @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>{{ $client->client_name }}</option>
                                    @endforeach
                                    </optgroup>
                                </select>
                                @error('client_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating">
                                <select class="tom-select @error('loan_payment_type') is-invalid @enderror" name="loan_payment_type">
                                    <option value="" selected disabled>Seleccione el tipo de pago</option>
                                    <option value="1" {{ old('loan_payment_type') == '1' ? 'selected' : '' }}>PAGO DIARIO</option>
                                    <option value="2" {{ old('loan_payment_type') == '2' ? 'selected' : '' }}>PAGO SEMANAL</option>
                                    <option value="3" {{ old('loan_payment_type') == '3' ? 'selected' : '' }}>PAGO QUINCENAL</option>
                                    <option value="4" {{ old('loan_payment_type') == '4' ? 'selected' : '' }}>PAGO MENSUAL</option>
                                </select>
                                @error('loan_payment_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Amount / quotes -->
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" name="loan_amount" step="any" id="loan_amount" value="{{ old('loan_amount') }}" class="form-control @error('loan_amount') is-invalid @enderror" />
                                @error('loan_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="loan_amount">Monto del préstamo <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating">
                                <input type="number" name="loan_quote_number" min="1" id="loan_quote_number" value="{{ old('loan_quote_number') }}" class="form-control @error('loan_quote_number') is-invalid @enderror" />
                                @error('loan_quote_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="loan_quote_number">Nº cuotas <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Down payment / interest -->
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" name="loan_interest" min="0" max="100" value="0.00" id="loan_interest" value="{{ old('loan_interest') }}" class="form-control @error('loan_interest') is-invalid @enderror" />
                                @error('loan_interest')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="loan_interest">Intereses del préstamo <span class="text-danger">*</span></label>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-floating">
                                <input type="number" name="loan_down_payment" value="0.00" step="any" id="loan_down_payment" value="{{ old('loan_down_payment') }}" class="form-control @error('loan_down_payment') is-invalid @enderror" />
                                @error('loan_down_payment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="loan_down_payment">Prima del préstamo</label>
                            </div>
                        </div>
                    </div>

                    <!-- Total payment -->
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" value="{{ old('loan_total') }}" style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" readonly name="loan_total" min="1" id="loan_total" class="form-control @error('loan_total') is-invalid @enderror" />
                                @error('loan_total')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="loan_total">Total a pagar <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" value="{{ old('loan_quote_value') }}" style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" readonly name="loan_quote_value" min="1" id="loan_quote_value" class="form-control @error('loan_quote_value') is-invalid @enderror" />
                                @error('loan_quote_value')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="loan_quote_value">Valor por cuota <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Start-end dates -->
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" name="loan_start_date" value="{{ old('loan_start_date') }}"
                                    id="loan_start_date"
                                    class="form-control @error('loan_start_date') is-invalid @enderror" />
                                @error('loan_start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="clamp_text loan_start_date">Fecha primer pago <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" readonly name="loan_end_date" value="{{ old('loan_end_date') }}"
                                    id="loan_end_date"
                                    class="form-control @error('loan_end_date') is-invalid @enderror" />
                                @error('loan_end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="loan_end_date">Fecha final <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()" class="form-control @error('loan_description') is-invalid @enderror" autocomplete="off" maxlength="600"
                                    name="loan_description" id="loan_description" rows="8" style="resize: none; height: 100px;">{{ old('loan_description') }}</textarea>
                                @error('loan_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <label for="loan_description">Descripción <span class="text-danger">*</span></label>
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

<!-- Loan payment type script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const loanQuoteInput = document.getElementById('loan_quote_number');
        const loanPaymentTypeSelect = document.querySelector('select[name="loan_payment_type"]');
        const loanStartDateInput = document.getElementById('loan_start_date');
        const loanEndDateInput = document.getElementById('loan_end_date');

        function calculateLoanEndDate() {
            const loanQuoteNumber = parseInt(loanQuoteInput.value);
            const loanPaymentType = loanPaymentTypeSelect.value;
            const loanStartDateValue = loanStartDateInput.value;

            if (loanQuoteNumber && loanPaymentType && loanStartDateValue) {
                const startDate = new Date(loanStartDateValue);
                let endDate;

                switch (loanPaymentType) {
                    case '1': // Diario
                        endDate = new Date(startDate);
                        endDate.setDate(startDate.getDate() + loanQuoteNumber);
                        break;
                    case '2': // Semanal
                        endDate = new Date(startDate);
                        endDate.setDate(startDate.getDate() + (loanQuoteNumber * 7));
                        break;
                    case '3': // Quincenal
                        endDate = new Date(startDate);
                        endDate.setDate(startDate.getDate() + (loanQuoteNumber * 15));
                        break;
                    case '4': // Mensual
                        endDate = new Date(startDate);
                        endDate.setMonth(startDate.getMonth() + loanQuoteNumber);
                        break;
                    default:
                        return; // No se seleccionó un tipo de pago válido
                }

                const endDateFormatted = endDate.toISOString().split('T')[0]; // Formato YYYY-MM-DD
                loanEndDateInput.value = endDateFormatted;
            } else {
                loanEndDateInput.value = ''; // Limpiar si no hay valores válidos
            }
        }

        // Agregar event listeners para recalcular cuando cambien los inputs
        loanQuoteInput.addEventListener('input', calculateLoanEndDate);
        loanPaymentTypeSelect.addEventListener('change', calculateLoanEndDate);
        loanStartDateInput.addEventListener('change', calculateLoanEndDate);
    });
</script>

<!-- Loan quote value script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Obtener referencias a los elementos del DOM
        const loanAmountInput = document.getElementById('loan_amount');
        const loanDownAmountInput = document.getElementById('loan_down_payment');
        const loanQuoteNumberInput = document.getElementById('loan_quote_number');
        const loanTaxInput = document.getElementById('loan_interest');
        const loanQuoteValueInput = document.getElementById('loan_quote_value');
        const loanTotalValueInput = document.getElementById('loan_total');

        // Función para calcular el valor de la cuota
        function calculateLoanQuoteValue() {
            // Obtener los valores de los inputs
            const loanAmount = parseFloat(loanAmountInput.value) || 0;
            const loanDown = parseFloat(loanDownAmountInput.value) || 0;
            const loanQuoteNumber = parseInt(loanQuoteNumberInput.value) || 1; // Evitar división por cero
            const loanTax = parseFloat(loanTaxInput.value) || 0;

            // Calcular el valor del total y valor de las cuotas
            const totalLoanWithTax = loanAmount + (loanAmount * (loanTax / 100) - loanDown);
            const quoteValue = totalLoanWithTax / loanQuoteNumber;

            // Actualizar el input del valor total y valor por cuota
            loanTotalValueInput.value = totalLoanWithTax.toFixed(2); // Formatear a dos decimales
            loanQuoteValueInput.value = quoteValue.toFixed(2); // Formatear a dos decimales
        }

        // Agregar eventos para recalcular al cambiar los inputs
        loanAmountInput.addEventListener('input', calculateLoanQuoteValue);
        loanDownAmountInput.addEventListener('input', calculateLoanQuoteValue);
        loanQuoteNumberInput.addEventListener('input', calculateLoanQuoteValue);
        loanTaxInput.addEventListener('input', calculateLoanQuoteValue);
        loanTotalValueInput.addEventListener('input', calculateLoanQuoteValue);
    });
</script>