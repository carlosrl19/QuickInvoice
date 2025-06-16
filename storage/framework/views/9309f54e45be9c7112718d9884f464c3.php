<?php $__env->startSection('head'); ?>
<!-- SweetAlert -->
<script src="<?php echo e(Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js')); ?>"></script>

<!-- Tomselect -->
<link href="<?php echo e(Storage::url('assets/js/plugin/tomselect/tom-select.min.css')); ?>" rel="stylesheet">

<?php
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
?>

<?php $default_seller = App\Models\Settings::value('default_seller_id') ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
POS
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
        <a href="#">POS</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Creación de ventas</a>
    </li>
</ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('create'); ?>
<a class="btn btn-sm btn-label-danger btn-round me-2" href="<?php echo e(route('pos.exonerated_sale')); ?>">
    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-eye-slash'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 20px; height: 20px;','class' => 'bg-label-danger']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
    <span class="sub-item">Exonerar sin ISV</span>
</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-primary text-white fw-bold">
                REGISTRO DE NUEVA VENTA GRAVADA (G)
            </div>
            <div class="card-body">
                <form id="pos_creation" action="<?php echo e(route('pos.store')); ?>" method="POST" novalidate autocomplete="off" spellcheck="false">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="sale_discount" id="sale_discount" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="sale_tax" id="sale_tax" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="sale_isv_amount" id="sale_isv_amount" value="0"> <!-- Controller get this -->
                    <input type="hidden" name="folio_id" id="folio_id" value="1"> <!-- Controller get this -->
                    <input type="hidden" name="exempt_purchase_order_correlative" id="exempt_purchase_order_correlative" value="000000000000"> <!-- Controller get this -->
                    <input type="hidden" name="exonerated_certificate" id="exonerated_certificate" value="00000000000"> <!-- Controller get this -->
                    <input type="hidden" name="folio_invoice_number" id="folio_invoice_number" value="000-000-00-00000000"> <!-- Controller get this -->
                    <input type="hidden" id="sale_exempt_tax" name="sale_exempt_tax"> <!-- Controller get this -->

                    <div class="row">
                        <!-- Col izquierda -->
                        <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
                            <div class="row">
                                <!-- Selección de Servicios y Clientes -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                    <div class="row mb-3">
                                        <div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12" id="client_select_container">
                                            <label for="client_id">Cliente <span class="text-danger">*</span></label>
                                            <select class="tom-select <?php $__errorArgs = ['client_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="client_id_select" name="client_id">
                                                <option value="" selected disabled>Seleccione el cliente</option>
                                                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($client->id); ?>" <?php echo e(old('client_id') == $client->id ? 'selected' : ''); ?>><?php echo e($client->client_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['client_id'];
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
                                        <div class="col-xl-3 col-lg-3 col-sm-12 col-xs-12" id="seller_select_container">
                                            <label for="seller_id">Vendedor <span class="text-danger">*</span></label>
                                            <select class="tom-select <?php $__errorArgs = ['seller_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="seller_id_select" name="seller_id">
                                                <option value="" selected disabled>Seleccione el vendedor</option>
                                                <?php $__currentLoopData = $sellers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seller): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($seller->id); ?>" <?php echo e($default_seller == $seller->id ? 'selected' : ''); ?>><?php echo e($seller->seller_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['seller_id'];
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

                                        <!-- Selección de servicio -->
                                        <div class="col-xl-6 col-lg-6 col-sm-12 col-xs-12" id="service_select_container">
                                            <label for="service_id">Servicio <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <select class="tom-select w-75 <?php $__errorArgs = ['service_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="service_id_select" name="service_id[]">
                                                    <option value="" selected disabled>Seleccione los productos o servicios</option>
                                                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($service->id); ?>" <?php echo e(old('service_id') == $service->id ? 'selected' : ''); ?>>
                                                        <?php echo e($service->service_nomenclature); ?> - <?php echo e($service->service_name); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <button type="button" class="btn btn-sm btn-dark" id="add_service_button">
                                                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 20px; height: 20px; color: white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                                    Agregar
                                                </button>
                                                <?php $__errorArgs = ['service_id'];
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
                                    </div>
                                </div>

                                <!-- Tabla de Servicios -->
                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-head-bg-primary table-bordered-bd-primary mt-4">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Producto/ Código / Serie</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col">Precio</th>
                                                    <th scope="col">Subtotal</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="services_table_body">
                                                <tr id="no-items-row">
                                                    <td colspan="5" class="text-center">Sin items agregados a la tabla de la venta</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Col derecha -->
                        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 mb-3">
                            <div class="row mb-3">
                                <div class="col-xl-12 col-lg-12 col-sm-12" id="service_select_container">
                                    <div class="col">
                                        <input style="font-size: clamp(0.9rem, 3vw, 1.1rem)" class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                        <label class="form-check-label" for="flexCheckDefault" title="Seleccione esta opción para convertir a venta exenta de impuestos." data-bs-toogle="tooltip" data-bs-placement="right">
                                            &nbsp;Venta exenta de I.S.V.
                                        </label>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="display table table-responsive table-primary">
                                            <thead>
                                                <tr>
                                                    <th class="fw-bold">Subtotal</th>
                                                    <th class="fw-bold">ISV</th>
                                                    <th class="fw-bold">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td id="subtotal_amount">L. 0.00</td>
                                                    <td id="isv_amount">L. 0.00</td>
                                                    <td id="total_amount">L. 0.00</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-3">
                                    <div class="row mb-3 d-none">
                                        <div class="col">
                                            <select class="tom-select-no-search <?php $__errorArgs = ['sale_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="sale_type_select" name="sale_type">
                                                <option value="G" selected readonly>TIPO DE VENTA: NORMAL</option>
                                            </select>
                                            <?php $__errorArgs = ['sale_type'];
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
                                        <div style="height: 30px; position: relative;" id="sale_exempt_isv_text" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-none">
                                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
                                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-check-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 20px; height: 20px; color: white;']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                                VENTA EXENTA DE I.S.V
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col">
                                            <select class="tom-select-no-search <?php $__errorArgs = ['sale_payment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="sale_payment_type" id="sale_payment_type_select">
                                                <option value="0" selected disabled>Seleccione el tipo de pago</option>
                                                <option value="4" <?php echo e(old('sale_payment_type') == '4' ? 'selected' : ''); ?>>Cheque HNL</option>
                                                <option value="3" <?php echo e(old('sale_payment_type') == '3' ? 'selected' : ''); ?>>Depósito bancario</option>
                                                <option value="1" <?php echo e(old('sale_payment_type') == '1' ? 'selected' : ''); ?>>Efectivo HNL</option>
                                                <option value="2" <?php echo e(old('sale_payment_type') == '2' ? 'selected' : ''); ?>>Tarjeta HNL</option>
                                            </select>
                                            <?php $__errorArgs = ['sale_payment_type'];
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
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-floating">
                                                <input type="number" value="" readonly name="sale_total_amount" id="sale_total_amount" class="form-control <?php $__errorArgs = ['sale_total_amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off"
                                                    style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" />
                                                <?php $__errorArgs = ['sale_total_amount'];
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
                                                <label for="sale_total_amount">Total a pagar <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-floating">
                                                <input type="number" min="0" name="sale_payment_received" value="" id="sale_payment_received" class="form-control <?php $__errorArgs = ['sale_payment_received'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                                <?php $__errorArgs = ['sale_payment_received'];
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
                                                <label for="sale_payment_received">Recibido <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Card selected options -->
                                    <div id="card_option_selected" style="display: none;">
                                        <div class="row mb-3">
                                            <div class=" col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-floating">
                                                    <input type="text" oninput="this.value = this.value.replace(/\D/g, '')" minlength="4" maxlength="4"
                                                        name="sale_card_last_digits" value="" id="sale_card_last_digits" class="form-control <?php $__errorArgs = ['sale_card_last_digits'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                                    <?php $__errorArgs = ['sale_card_last_digits'];
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
                                                    <label for="sale_card_last_digits">Ultimos 4 digitos <span class="text-danger">*</span></label>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-floating">
                                                    <input type="text" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')" minlength="6" maxlength="12"
                                                        name="sale_card_auth_number" value="" id="sale_card_auth_number" class="form-control <?php $__errorArgs = ['sale_card_auth_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                                    <?php $__errorArgs = ['sale_card_auth_number'];
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
                                                    <label for="sale_card_auth_number">Nº autorización <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bank check selected options -->
                                    <div id="bankcheck_option_selected" style="display: none;">
                                        <div class="row mb-3">
                                            <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                <div class="form-floating">
                                                    <input type="text" oninput="this.value = this.value.replace(/[^a-zA-Z0-9\/]/g, '').toUpperCase();" minlength="40" maxlength="40" name="sale_bankcheck_info"
                                                        value="" id="sale_bankcheck_info" class="form-control <?php $__errorArgs = ['sale_bankcheck_info'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                                    <?php $__errorArgs = ['sale_bankcheck_info'];
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
                                                    <label for="sale_bankcheck_info">Banco / Nº cuenta<span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Deposito selected options -->
                                    <div id="bank_option_selected" style="display: none;">
                                        <div class="row mb-3">
                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <select class="tom-select <?php $__errorArgs = ['bank_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="bank_id_select" name="bank_id">
                                                    <option value="" selected disabled>Seleccione el banco</option>
                                                    <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($bank->id); ?>" <?php echo e(old('bank_id') == $bank->id ? 'selected' : ''); ?>>
                                                        <?php echo e($bank->bank_name); ?> / <?php echo e($bank->bank_account_number); ?>

                                                    </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['bank_id'];
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

                                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                <div class="form-floating">
                                                    <input type="text" oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9]/g, '')" minlength="6" maxlength="12" name="sale_bank_operation_number" value="" id="sale_bank_operation_number" class="form-control <?php $__errorArgs = ['sale_bank_operation_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off" />
                                                    <?php $__errorArgs = ['sale_bank_operation_number'];
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
                                                    <label for="sale_bank_operation_number">Nº operación <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                            <div class="form-floating">
                                                <input type="number" value="" readonly name="sale_payment_change" min="0" id="sale_payment_change" class="form-control <?php $__errorArgs = ['sale_payment_change'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" autocomplete="off"
                                                    style="background-color: transparent !important; border-left: 4px solid #A0C878 !important; border-bottom: 1px solid #A0C878 !important;" />
                                                <?php $__errorArgs = ['sale_payment_change'];
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
                                                <label for="sale_payment_change">Cambio <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                                            <button type="submit" class="btn btn-success">
                                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-cursor-arrow-ripple'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 25px; height: 25px; color: white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                                Cobrar
                                            </button>
                                            <a href="#" class="btn bg-warning text-white" id="sale_clear">
                                                <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-backspace'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 25px; height: 25px; color: white']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $attributes = $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c)): ?>
<?php $component = $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c; ?>
<?php unset($__componentOriginal643fe1b47aec0b76658e1a0200b34b2c); ?>
<?php endif; ?>
                                                Limpiar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('modules.pos._sweet_alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<!-- Tomselect -->
<script src="<?php echo e(Storage::url('assets/js/plugin/tomselect/tom-select.complete.js')); ?>"></script>
<script src="<?php echo e(Storage::url('customjs/tomselect/ts_init.js')); ?>"></script>

<!-- Laravel Javascript validation -->
<script src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>
<?php echo JsValidator::formRequest('App\Http\Requests\Pos\StoreRequest'); ?>


<!-- Venta exenta checkbox -->
<script src="<?php echo e(Storage::url('customjs/pos/checkbox_exempt_tax.js')); ?>"></script>

<!-- Script para manejar la lógica -->
<script src="<?php echo e(Storage::url('customjs/pos/pos_creation.js')); ?>"></script>

<!-- Ocultar campos exenta y correlativo si no es venta exonerada -->
<script src="<?php echo e(Storage::url('customjs/pos/hide_exempt_inputs.js')); ?>"></script>

<!-- Ocultar campos de card si no se usa Tarjeta -->
<script src="<?php echo e(Storage::url('customjs/pos/hide_card_inputs.js')); ?>"></script>

<!-- Ocultar campos de bank si no se usa Deposito -->
<script src="<?php echo e(Storage::url('customjs/pos/hide_bank_inputs.js')); ?>"></script>

<!-- Ocultar campos de bankcheck si no se usa Cheque -->
<script src="<?php echo e(Storage::url('customjs/pos/hide_bankcheck_inputs.js')); ?>"></script>

<!-- Ocultar campos de dolar si no se usa Dolar -->
<script src="<?php echo e(Storage::url('customjs/pos/hide_dolar_inputs.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/pos/create.blade.php ENDPATH**/ ?>