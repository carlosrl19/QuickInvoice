<div class="modal fade" id="sale_details<?php echo e($sale->id); ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="border: 2px solid #52524E">
            <div class="modal-header bg-secondary">
                <p class="modal-title fw-bold">Detalles de venta / <?php echo e($sale->id); ?></p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <iframe id="sale_details_iframe<?php echo e($sale->id); ?>" style="width: 100%; height: 55rem;" src=""></iframe>
            </div>
        </div>
    </div>
</div>

<!-- JQuery -->
<script src="<?php echo e(Storage::url('assets/js/core/jquery-3.7.1.min.js')); ?>"></script>

<script>
    // Espera a que el documento esté listo
    $(document).ready(function() {

        // Cargar PDF en el modal de Solicitud de préstamo
        $('#sale_details<?php echo e($sale->id); ?>').on('show.bs.modal', function(event) {
            var url = '<?php echo e(route("pos_details.pos_details_report", $sale->id)); ?>';
            $(this).find('#sale_details_iframe<?php echo e($sale->id); ?>').attr('src', url);
        });

        // Limpiar URL al cerrar el modal de Solicitud de préstamo
        $('#sale_details<?php echo e($sale->id); ?>').on('hidden.bs.modal', function() {
            $(this).find('#sale_details_iframe<?php echo e($sale->id); ?>').attr('src', '');
        });
    });
</script><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/pos_details/_sale_details.blade.php ENDPATH**/ ?>