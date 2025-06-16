<!-- JQuery -->
<script src="<?php echo e(Storage::url('assets/js/core/jquery-3.7.1.min.js')); ?>"></script>

<!-- Update SweetAlert -->
<script>
    $('#update_category_form<?php echo e($category->id); ?>').on('click', function(e) {
        e.preventDefault();
        Swal.fire({
            title: "Actualizar registro",
            text: "Está seguro de continuar?",
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Continuar"
        }).then((result) => {
            this.submit()
        })
    })
</script>

<!-- Delete SweetAlert -->
<script>
    document.getElementById('delete_category<?php echo e($category->id); ?>').addEventListener('click', function() {
        Swal.fire({
            title: "Eliminar registro",
            html: `
                <p>¿Está seguro de eliminar la categoría de productos <b><?php echo e($category->category_name); ?></b>?</p>
                <form id="confirm-delete-form" action="<?php echo e(route('categories.destroy', $category->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field("DELETE"); ?>
                </form>
            `,
            icon: "warning",
            showCancelButton: true,
            allowOutsideClick: false,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            cancelButtonText: "Cancelar",
            confirmButtonText: "Confirmar"
        }).then((result) => {
            if (result.value) {
                // Envía el formulario manualmente
                document.getElementById('confirm-delete-form').submit();
            }
        })
    })
</script>

<?php if(Session::has('success')): ?>
<script>
    Swal.fire({
        title: "Exito",
        text: "<?php echo e(session('success')); ?>",
        icon: "success",
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 2000,
        timerProgressBar: true,
    })
</script>
<?php endif; ?>

<?php if(Session::has('error')): ?>
<script>
    Swal.fire({
        title: "Error",
        text: "<?php echo e(session('error')); ?>",
        icon: "error",
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
    })
</script>
<?php endif; ?><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/categories/_sweet_alerts.blade.php ENDPATH**/ ?>