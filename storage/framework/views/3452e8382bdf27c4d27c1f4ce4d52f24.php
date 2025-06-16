<?php $__env->startSection('head'); ?>
<!-- SweetAlert -->
<script src="<?php echo e(Storage::url('assets/js/plugin/sweetalert/sweetalert.min.js')); ?>"></script>

<!-- Tomselect -->
<link href="<?php echo e(Storage::url('assets/js/plugin/tomselect/tom-select.min.css')); ?>" rel="stylesheet">

<?php
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
?>

<?php $currency = App\Models\Settings::value('default_currency_symbol') ?>
<?php $default_seller = App\Models\Settings::value('default_seller_id') ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
Solicitud de créditos
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
        <a href="#">Solicitud de créditos</a>
    </li>
    <li class="separator d-none d-xl-inline d-lg-inline">
        <i class="icon-arrow-right"></i>
    </li>
    <li class="nav-item fw-bold">
        <a href="#">Listado principal de solicitudes</a>
    </li>
</ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('create'); ?>
<a href="#" class="btn btn-sm btn-label-info btn-round me-2" data-bs-toggle="modal" data-bs-target="#create_loan">
    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 20px; height: 20px;','class' => 'bg-label-info']); ?>
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
    Crear préstamo
</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_loans_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Acciones</th>
                                <th>Creación</th>
                                <th>Solicitud</th>
                                <th>Estado</th>
                                <th>Cliente</th>
                                <th>ID</th>
                                <th>Monto préstamo</th>
                                <th>Nº Cuotas</th>
                                <th>Total a pagar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <button class="btn btn-sm btn-primary btn-border dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Más acciones
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" id="confirm_request<?php echo e($loan->id); ?>">Aceptar solicitud</a>
                                        <a class="dropdown-item" href="#" id="reject_request<?php echo e($loan->id); ?>">Rechazar solicitud</a>
                                        <div role="separator" class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="<?php echo e(route('loans.loan_request_information_show', $loan->id)); ?>">Información solicitud</a>
                                        <div role="separator" class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" id="delete_request<?php echo e($loan->id); ?>">Eliminar solicitud</a>
                                    </div>
                                </td>
                                <td><?php echo e($loan->created_at); ?></td>
                                <td>
                                    <?php echo e($loan->loan_request_number); ?>

                                </td>
                                <td>
                                    <?php if($loan->loan_status == 0): ?>
                                    <span class="badge bg-dark fw-bold">SOLICITUD EN ESPERA</span>
                                    <?php elseif($loan->loan_status == 1): ?>
                                    <span class="badge bg-warning fw-bold">EN PROCESO</span>
                                    <?php elseif($loan->loan_status == 2): ?>
                                    <span class="badge bg-success fw-bold">PAGADO</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e($loan->client->client_name); ?>

                                </td>
                                <td>
                                    <?php echo e($loan->client->client_document); ?>

                                </td>
                                <td>
                                    <?php echo e($currency); ?> <?php echo e(number_format($loan->loan_amount, 2)); ?>

                                </td>
                                <td><?php echo e($loan->loan_quote_number); ?> cuotas</td>
                                <td><?php echo e($currency); ?> <?php echo e(number_format($loan->loan_total, 2)); ?></td>
                            </tr>

                            <!-- Include -->
                            <?php echo $__env->make('modules.loans.loans_request._sweet_alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('modules.loans.loans_request._create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<!-- Tomselect -->
<script src="<?php echo e(Storage::url('assets/js/plugin/tomselect/tom-select.complete.js')); ?>"></script>
<script src="<?php echo e(Storage::url('customjs/tomselect/ts_init.js')); ?>"></script>

<!-- Datatables -->
<script src="<?php echo e(Storage::url('assets/js/plugin/datatables/datatables.min.js')); ?>"></script>
<script src="<?php echo e(Storage::url('customjs/datatables/loans/dt_loans_index.js')); ?>"></script>

<!-- Laravel Javascript validation -->
<script src="<?php echo e(asset('vendor/jsvalidation/js/jsvalidation.js')); ?>"></script>
<?php echo JsValidator::formRequest('App\Http\Requests\Loans\StoreRequest'); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/loans/loans_request/index.blade.php ENDPATH**/ ?>