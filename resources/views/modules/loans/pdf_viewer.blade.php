<!-- PDF Viewer Modal 1 -->
<div class="modal fade modal-blur" id="loan_request_report{{ $loan->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fw-bold" id="pdfModalLabel">Solicitud de crédito #{{ $loan->loan_code_number }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="loan_request_report_iframe{{ $loan->id }}" style="width:100%; height: 55rem;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

<!-- PDF Viewer Modal 2 -->
<div class="modal fade modal-blur" id="loan_payment_plan_report{{ $loan->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="pdfRequestLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fw-bold" id="pdfRequestLabel">Plan de pagos #{{ $loan->loan_code_number }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="loan_payment_plan_report_iframe{{ $loan->id }}" style="width:100%; height: 55rem;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

<!-- PDF Viewer Modal 3 -->
<div class="modal fade modal-blur" id="loan_history_payments{{ $loan->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="pdfPaymentHistoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fw-bold" id="pdfPaymentHistoryLabel">Historial de pagos #{{ $loan->loan_code_number }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="loan_history_payments_iframe{{ $loan->id }}" style="width:100%; height: 55rem;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    // Espera a que el documento esté listo
    $(document).ready(function() {

        // Cargar PDF en el modal de Solicitud de préstamo
        $('#loan_request_report{{ $loan->id }}').on('show.bs.modal', function(event) {
            var url = '{{ route("loans.loan_request_report", $loan->id) }}';
            $(this).find('#loan_request_report_iframe{{ $loan->id }}').attr('src', url);
        });

        // Limpiar URL al cerrar el modal de Solicitud de préstamo
        $('#loan_request_report{{ $loan->id }}').on('hidden.bs.modal', function() {
            $(this).find('#loan_request_report_iframe{{ $loan->id }}').attr('src', '');
        });

        // Cargar PDF en el modal de Plan de pagos
        $('#loan_payment_plan_report{{ $loan->id }}').on('show.bs.modal', function(event) {
            var url = '{{ route("loans.loan_payment_plan_report", $loan->id) }}';
            $(this).find('#loan_payment_plan_report_iframe{{ $loan->id }}').attr('src', url);
        });

        // Limpiar URL al cerrar el modal de Plan de pagos
        $('#loan_payment_plan_report{{ $loan->id }}').on('hidden.bs.modal', function() {
            $(this).find('#loan_payment_plan_report_iframe{{ $loan->id }}').attr('src', '');
        });

        // Cargar PDF en el modal de Historial de pagos
        $('#loan_history_payments{{ $loan->id }}').on('show.bs.modal', function(event) {
            var url = '{{ route("loans.loan_history_payment_report", $loan->id) }}';
            $(this).find('#loan_history_payments_iframe{{ $loan->id }}').attr('src', url);
        });

        // Limpiar URL al cerrar el modal de Historial de pagos
        $('#loan_history_payments{{ $loan->id }}').on('hidden.bs.modal', function() {
            $(this).find('#loan_history_payments_iframe{{ $loan->id }}').attr('src', '');
        });
    });
</script>