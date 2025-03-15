<!-- PDF Viewer Modal 4 -->
<div class="modal fade modal-blur" id="loan_pdf_receipt" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    role="dialog" aria-labelledby="pdfReceiptLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title fw-bold" id="pdfReceiptLabel">Recibo de pago #{{ $loan->loan_code_number }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="loan_pdf_receipt_iframe" style="width:100%; height: 55rem;" src=""></iframe>
            </div>
        </div>
    </div>
</div>