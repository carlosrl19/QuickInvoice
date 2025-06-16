<!-- JQuery -->
<script src="<?php echo e(Storage::url('assets/js/core/jquery-3.7.1.min.js')); ?>"></script>

<?php if(Session::has('success')): ?>
<script>
    Swal.fire({
        title: "Exito",
        text: "<?php echo e(session('success')); ?>",
        icon: "success",
        allowOutsideClick: false,
        showConfirmButton: false,
        timer: 1000,
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
        timer: 2000,
        timerProgressBar: true,
    })
</script>
<?php endif; ?><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/settings/_sweet_alerts.blade.php ENDPATH**/ ?>