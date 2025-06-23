<div class="modal fade" id="create_folio" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header" style="background-color: #A0C878; color: #fff">
                <p class="modal-title fw-bold">Crear nuevo folio</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('fiscalfolio.store')}}" novalidate autocomplete="off"spellcheck="false">
                    @csrf
                    <input type="hidden" name="folio_validation_status" value="1"> <!-- Controller get this -->
                    <input type="hidden" name="folio_status" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="folio_total_invoices" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="folio_total_invoices_available" value="0"> <!-- Controller get this -->

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="19" oninput="this.value = this.value.replace(/\D/g, '')" name="folio_authorized_range_start" value="{{ old('folio_authorized_range_start') }}"
                                    id="folio_authorized_range_start" class="form-control @error('folio_authorized_range_start') is-invalid @enderror" autocomplete="off" />
                                @error('folio_authorized_range_start')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="folio_authorized_range_start">Rango inicio autorizado folio<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="19" oninput="this.value = this.value.replace(/\D/g, '')" name="folio_authorized_range_end" value="{{ old('folio_authorized_range_end') }}"
                                    id="folio_authorized_range_end" class="form-control @error('folio_authorized_range_end') is-invalid @enderror" autocomplete="off" />
                                @error('folio_authorized_range_end')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="folio_authorized_range_end">Rango final autorizado folio<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" readonly style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                    oninput="this.value = this.value.replace(/\D/g, '')" name="folio_total_invoices" value="{{ old('folio_total_invoices') }}"
                                    id="folio_total_invoices" class="form-control @error('folio_total_invoices') is-invalid @enderror" autocomplete="off" />
                                @error('folio_total_invoices')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="folio_total_invoices">Total facturas autorizadas<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col d-none">
                            <div class="form-floating">
                                <input type="text" readonly style="background-color: #ffffff !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;"
                                    oninput="this.value = this.value.replace(/\D/g, '')" name="folio_total_invoices_available" value="{{ old('folio_total_invoices_available') }}"
                                    id="folio_total_invoices_available" class="form-control @error('folio_total_invoices_available') is-invalid @enderror" autocomplete="off" />
                                @error('folio_total_invoices_available')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="folio_total_invoices_available">Total facturas disponibles<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="date" name="folio_authorized_emission_date"
                                    value="{{ old('folio_authorized_emission_date') }}"
                                    min="{{ Carbon\Carbon::now()->addDay()->format('Y-m-d') }}"
                                    max="{{ Carbon\Carbon::now()->addYear()->format('Y-m-d') }}"
                                    id="folio_authorized_emission_date" class="form-control @error('folio_authorized_emission_date') is-invalid @enderror"
                                    autocomplete="off" />
                                @error('folio_authorized_emission_date')
                                <span class="invalid-feedback" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                <label for="folio_authorized_emission_date">Fecha límite emisión <span class="text-danger">*</span></label>
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

<script>
    function calcularTotalFacturas(folioAuthorizedRangeStart, folioAuthorizedRangeEnd) {
        // Extraer el número numérico de cada folio
        const startNum = parseInt(folioAuthorizedRangeStart.replace(/-/g, ''));
        const endNum = parseInt(folioAuthorizedRangeEnd.replace(/-/g, ''));

        // Calcular el total de facturas autorizadas
        const folioTotalInvoices = endNum - startNum + 1; // Sumamos 1 para incluir el folio final

        // Suponiendo que todas las facturas están disponibles
        const folioTotalInvoicesAvailable = folioTotalInvoices;

        return {
            folioTotalInvoices,
            folioTotalInvoicesAvailable
        };
    }

    document.addEventListener('DOMContentLoaded', function() {
        const startInput = document.getElementById('folio_authorized_range_start');
        const endInput = document.getElementById('folio_authorized_range_end');

        function actualizarTotal() {
            const folioAuthorizedRangeStart = startInput.value;
            const folioAuthorizedRangeEnd = endInput.value;

            if (folioAuthorizedRangeStart && folioAuthorizedRangeEnd) {
                const {
                    folioTotalInvoices,
                    folioTotalInvoicesAvailable
                } = calcularTotalFacturas(folioAuthorizedRangeStart, folioAuthorizedRangeEnd);

                document.getElementById('folio_total_invoices').value = folioTotalInvoices;
                document.getElementById('folio_total_invoices_available').value = folioTotalInvoicesAvailable;
            } else {
                document.getElementById('folio_total_invoices').value = '';
                document.getElementById('folio_total_invoices_available').value = '';
            }
        }

        startInput.addEventListener('input', actualizarTotal);
        endInput.addEventListener('input', actualizarTotal);
    });
</script>