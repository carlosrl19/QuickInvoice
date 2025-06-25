<div class="modal fade" id="sale_details{{ $sale->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header bg-secondary">
                <p class="modal-title fw-bold">Detalles de salida / {{ $sale->id }}</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="sale_details_iframe{{ $sale->id }}" style="width: 100%; height: 55rem;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

<!-- JQuery -->
<script src="{{ Storage::url('assets/js/core/jquery-3.7.1.min.js') }}"></script>

<script>
    // Espera a que el documento esté listo
    $(document).ready(function() {

        // Cargar PDF en el modal de Solicitud de préstamo
        $('#sale_details{{ $sale->id }}').on('show.bs.modal', function(event) {
            var url = '{{ route("sales_details.sale_details_report", $sale->id) }}';
            $(this).find('#sale_details_iframe{{ $sale->id }}').attr('src', url);
        });

        // Limpiar URL al cerrar el modal de Solicitud de préstamo
        $('#sale_details{{ $sale->id }}').on('hidden.bs.modal', function() {
            $(this).find('#sale_details_iframe{{ $sale->id }}').attr('src', '');
        });
    });
</script>