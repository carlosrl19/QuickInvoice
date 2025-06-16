<!DOCTYPE html>
<html lang="es" translate="no">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title><?php echo e(config('app.name')); ?></title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <link rel="icon" href="<?php echo e(Storage::url('assets/img/kaiadmin/favicon.ico')); ?>" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="<?php echo e(Storage::url('assets/js/plugin/webfont/webfont.min.js')); ?>"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["<?php echo e(Storage::url('assets/css/fonts.min.css')); ?>"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="<?php echo e(Storage::url('assets/css/bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(Storage::url('assets/css/plugins.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(Storage::url('assets/css/kaiadmin.min.css')); ?>" />
    <?php echo $__env->yieldContent('head'); ?>
</head>

<body>
    <div class="wrapper">
        <div id="spinner" style="position: fixed; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6);
            z-index: 9999; display: flex; justify-content: center; align-items: center;">
            <div class="spinner-border text-white" role="status" style="width: 3rem; height: 3rem;">
            </div>
            <span class="text-white fw-bold">&nbsp; Cargando...</span>
        </div>
        <!-- Sidebar -->
        <?php echo $__env->make('layouts._sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                <div class="main-header-logo">
                    <!-- Logo Header -->
                    <?php echo $__env->make('layouts._logo_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <!-- End Logo Header -->
                </div>
                <!-- Navbar Header -->
                <?php echo $__env->make('layouts._navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <!-- End Navbar -->
            </div>

            <div class="container">
                <div class="page-inner">
                    <div
                        class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <div class="page-header">
                                <h3 class="fw-bold mb-1"><?php echo $__env->yieldContent('title'); ?></h3>
                                <?php echo $__env->yieldContent('breadcrumb'); ?>
                            </div>
                        </div>
                        <div class="ms-md-auto py-2 py-md-0">
                            <?php echo $__env->yieldContent('create'); ?>
                        </div>
                    </div>

                    <?php if($errors->any()): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                        <p class="text-danger fw-bold">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-exclamation-triangle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 20px; height: 20px; color: red']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>&nbsp;
                            Error al completar acción. Intente nuevamente.
                        </p>
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php echo $__env->yieldContent('content'); ?>
                </div>
            </div>
        </div>
        <!-- End Custom template -->
    </div>

    <!--   Core JS Files   -->
    <script src="<?php echo e(Storage::url('assets/js/core/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(Storage::url('assets/js/core/popper.min.js')); ?>"></script>
    <script src="<?php echo e(Storage::url('assets/js/core/bootstrap.min.js')); ?>"></script>

    <!-- jQuery Scrollbar -->
    <script src="<?php echo e(Storage::url('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')); ?>"></script>

    <!-- Datatables -->
    <script src="<?php echo e(Storage::url('assets/js/plugin/datatables/datatables.min.js')); ?>"></script>

    <!-- Sweet Alert -->
    <script src="<?php echo e(Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js')); ?>"></script>

    <!-- Kaiadmin JS -->
    <script src="<?php echo e(Storage::url('assets/js/kaiadmin.min.js')); ?>"></script>

    <!-- Spinner -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("spinner").style.display = "none";
        });
    </script>

    <?php echo $__env->yieldContent('scripts'); ?>
</body>

</html><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/layouts/app.blade.php ENDPATH**/ ?>