<div class="modal fade" id="quote_details{{ $quote->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header bg-secondary">
                <p class="modal-title fw-bold">Detalles de cotización / {{ $quote->id }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="quote_details_iframe{{ $quote->id }}" style="width: 100%; height: 55rem;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    // Espera a que el documento esté listo
    $(document).ready(function() {

        // Cargar PDF en el modal de Solicitud de préstamo
        $('#quote_details{{ $quote->id }}').on('show.bs.modal', function(event) {
            var url = '{{ route("quote_details.quote_details_show", $quote->id) }}';
            $(this).find('#quote_details_iframe{{ $quote->id }}').attr('src', url);
        });

        // Limpiar URL al cerrar el modal de Solicitud de préstamo
        $('#quote_details{{ $quote->id }}').on('hidden.bs.modal', function() {
            $(this).find('#quote_details_iframe{{ $quote->id }}').attr('src', '');
        });
    });
</script>