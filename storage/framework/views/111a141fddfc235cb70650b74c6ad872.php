<?php $__env->startSection('head'); ?>
<!-- SweetAlert -->
<script src="<?php echo e(Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
Categorías
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<ul class="breadcrumbs mb-1 op-4">
    <li class="nav-home">
        <a href="#">
            <i class="icon-home"></i>
        </a>
    </li>
    <li class="separator">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item d-none d-xl-inline d-lg-inline">
        <a href="#">Categorías</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de categorías</a>
    </li>
</ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('create'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" id="update_category_form" action="<?php echo e(route('categories.update', $category->id)); ?>" novalidate spellcheck="false">
    <?php echo method_field('PUT'); ?>
    <?php echo csrf_field(); ?>
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header bg-warning fw-bold text-white">
                Actualización de información <span class="text-danger">*</span> / <?php echo e($category->category_name); ?>

            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="text" maxlength="55" name="category_name"
                                oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ\s]/g, '')" value="<?php echo e($category->category_name); ?>"
                                id="category_name" class="form-control <?php $__errorArgs = ['category_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                            <?php $__errorArgs = ['category_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <?php echo e($message); ?>

                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <label for="category_name">Nombre de categoría <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <textarea oninput="this.value = this.value.toUpperCase()"
                                class="form-control <?php $__errorArgs = ['category_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" maxlength="155"
                                name="category_description" rows="6" id="category_description" style="resize: none;"><?php echo e($category->category_description); ?></textarea>
                            <?php $__errorArgs = ['category_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="invalid-feedback" role="alert">
                                <?php echo e($message); ?>

                            </span>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <label for="category_description">Descripción</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-round btn-sm bg-dark text-white">Volver</a>
                        <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- Laravel Javascript validation -->
<script src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>
<?php echo $validator; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/categories/update.blade.php ENDPATH**/ ?>