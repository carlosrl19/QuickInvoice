<?php $__env->startSection('head'); ?>
<!-- SweetAlert -->
<script src="<?php echo e(Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js')); ?>"></script>

<!-- Tomselect -->
<link href="<?php echo e(Storage::url('assets/js/plugin/tomselect/tom-select.min.css')); ?>" rel="stylesheet">

<!-- Filepond -->
<link rel="stylesheet" href="<?php echo e(Storage::url('assets/js/plugin/filepond/filepond.css')); ?>">
<link rel="stylesheet" href="<?php echo e(Storage::url('assets/js/plugin/filepond/filepond-plugin-image-preview.css')); ?>">

<?php
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
Productos
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
        <a href="#">Productos</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de productos</a>
    </li>
</ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('create'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form method="POST" id="create_product_form" action="<?php echo e(route('products.update', $product->id)); ?>" enctype="multipart/form-data" novalidate autocomplete="off" spellcheck="false">
    <?php echo method_field('PUT'); ?>
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-warning fw-bold text-white">
                    Actualización de información <span class="text-danger">*</span> / <?php echo e($product->product_name); ?>

                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col text-center">
                            <img class="rounded-circle p-1" src="<?php echo e(Storage::url('uploads/products/' . $product->product_image )); ?>" onerror="this.onerror=null;this.src='<?php echo e($product_error_image); ?>'" width="180" height="180">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" name="product_code" id="product_code" style="background-color: white !important;" readonly oninput="this.value = this.value.replace(/\D/g, '')" value="<?php echo e($product->product_code); ?>"
                                    class="form-control <?php $__errorArgs = ['product_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                <label for="product_code">Código del producto <span class="text-muted opacity-25">(solo lectura)</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" name="product_nomenclature" id="product_nomenclature" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ0-9\s]/g, '')" value="<?php echo e($product->product_nomenclature); ?>"
                                    class="form-control <?php $__errorArgs = ['product_nomenclature'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                <label for="product_nomenclature">Nomenclatura del producto</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" maxlength="40" name="product_name" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ0-9\s]/g, '')" value="<?php echo e($product->product_name); ?>"
                                    id="product_name" class="form-control <?php $__errorArgs = ['product_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                <?php $__errorArgs = ['product_name'];
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
                                <label for="product_name">Nombre del producto <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" name="product_brand" id="product_brand" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ0-9\s]/g, '')" value="<?php echo e($product->product_brand); ?>"
                                    class="form-control <?php $__errorArgs = ['product_brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                <label for="product_brand">Marca del producto</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" name="product_model" id="product_model" oninput="this.value = this.value.toUpperCase().replace(/[^A-ZÑ0-9\s]/g, '')" value="<?php echo e($product->product_model); ?>"
                                    class="form-control <?php $__errorArgs = ['product_model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                <label for="product_model">Modelo del producto</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="1" name="product_stock" value="<?php echo e($product->product_stock); ?>" id="product_stock"
                                    class="form-control <?php $__errorArgs = ['product_stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                <?php $__errorArgs = ['product_stock'];
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
                                <label for="product_stock">Stock actual <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" step="any" name="product_price" value="<?php echo e($product->product_price); ?>" id="product_price"
                                    class="form-control <?php $__errorArgs = ['product_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                <?php $__errorArgs = ['product_price'];
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
                                <label for="product_price">Precio <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-round btn-sm bg-dark text-white">Volver</a>
                            <button type="submit" class="btn btn-round btn-sm bg-success text-white">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header bg-warning fw-bold text-white">
                    Actualización de presentación <span class="text-danger">*</span> / <?php echo e($product->product_name); ?>

                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="product_image" class="text-xs">Presentación del producto</label>
                            <input type="file" class="filepond <?php $__errorArgs = ['product_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" accept="image/png, image/jpeg, image/jpg, image/webp, image/svg+xml" id="product_image" name="product_image">
                            <?php $__errorArgs = ['product_image'];
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
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <label for="category_id" class="text-xs">Categoría del producto <span class="text-danger"> *</span></label>
                            <select class="tom-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category_id_select" name="category_id">
                                <option value="" selected disabled>Seleccione una categoría</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo e($category->id == $product->category_id ? 'selected' : ''); ?>><?php echo e($category->category_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['category_id'];
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
                        </div>
                    </div>

                    <div class="row mb-3 align-items-end">
                        <div class="col">
                            <label for="product_status" class="text-xs">Estado del producto <span class="text-danger"> *</span></label>
                            <select class="tom-select" id="product_status" name="product_status">
                                <option value="" selected disabled>Seleccione el estado del producto</option>
                                <option value="1" <?php echo e($product->product_status == 1 ? 'selected' : ''); ?>>PRODUCTO NUEVO</option>
                                <option value="0" <?php echo e($product->product_status == 0 ? 'selected' : ''); ?>>PRODUCTO MALO</option>
                                <option value="2" <?php echo e($product->product_status == 2 ? 'selected' : ''); ?>>PRODUCTO SEMINUEVO</option>
                                <option value="3" <?php echo e($product->product_status == 3 ? 'selected' : ''); ?>>PRODUCTO USADO</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()"
                                    class="form-control <?php $__errorArgs = ['product_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" maxlength="600"
                                    name="product_description" rows="6" id="product_description" style="resize: none;"><?php echo e($product->product_description); ?></textarea>
                                <?php $__errorArgs = ['product_description'];
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
                                <label for="product_description">Descripción</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <textarea oninput="this.value = this.value.toUpperCase()"
                                    class="form-control <?php $__errorArgs = ['product_status_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" maxlength="600"
                                    name="product_status_description" rows="6" id="product_status_description" style="resize: none;"><?php echo e($product->product_status_description); ?></textarea>
                                <?php $__errorArgs = ['product_description'];
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
                                <label for="product_status_description">Descripción <span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="text" readonly style="background-color: white !important;" name="product_reviewed_by" value="<?php echo e($product->product_reviewed_by); ?>" id="product_reviewed_by"
                                    class="form-control <?php $__errorArgs = ['product_reviewed_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off">
                                <?php $__errorArgs = ['product_reviewed_by'];
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
                                <label for="product_reviewed_by">Técnico encargado <span class="text-danger">*</span> <span class="text-muted opacity-25">(solo lectura)</span></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<!-- Tomselect -->
<script src="<?php echo e(Storage::url('assets/js/plugin/tomselect/tom-select.complete.js')); ?>"></script>
<script src="<?php echo e(Storage::url('customjs/tomselect/ts_init.js')); ?>"></script>

<!-- Filepond -->
<script src="<?php echo e(Storage::url('assets/js/plugin/filepond/filepond.js')); ?>"></script>
<script src="<?php echo e(Storage::url('assets/js/plugin/filepond/filepond-plugin-file-validate-type.js')); ?>"></script>
<script src="<?php echo e(Storage::url('assets/js/plugin/filepond/filepond-plugin-image-preview.js')); ?>"></script>
<script>
    FilePond.registerPlugin(
        FilePondPluginFileValidateType,
        FilePondPluginImagePreview
    );

    // Inicializar FilePond en los inputs
    FilePond.create(document.querySelector('input[name="product_image"]'));

    FilePond.setOptions({
        server: {
            process: '/filepond/process',
            revert: '/filepond/revert',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            }
        },
        acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/svg+xml'],
        labelFileTypeNotAllowed: 'Tipo de archivo no permitido',
        fileValidateTypeLabelExpectedTypes: 'Debe ser una imagen: {allTypes}'
    });
</script>

<!-- Laravel Javascript validation -->
<script src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>
<?php echo JsValidator::formRequest('App\Http\Requests\Products\UpdateRequest'); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/products/update.blade.php ENDPATH**/ ?>