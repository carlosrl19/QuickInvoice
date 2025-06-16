<!-- JQuery -->
<script src="<?php echo e(Storage::url('assets/js/core/jquery-3.7.1.min.js')); ?>"></script>

<script>
    document.getElementById('sale_clear').addEventListener('click', function() {
        Swal.fire({
            title: "Limpiar formulario",
            html: `
            <p>¿Está seguro de limpiar el formulario? Perderá todos lo agregado a la venta.</p>
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
                // Redirecciona a pos.pos_create
                window.location.href = "<?php echo e(route('pos.create')); ?>";
            }
        });
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
        timer: 3000,
        timerProgressBar: true,
    })
</script>
<?php endif; ?><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/pos/_sweet_alerts.blade.php ENDPATH**/ ?>