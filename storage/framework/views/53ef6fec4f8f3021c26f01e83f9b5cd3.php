<?php $__env->startSection('head'); ?>
<?php $currency = App\Models\Settings::value('default_currency_symbol') ?>
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
        <a href="#">Listado principal de ventas</a>
    </li>
</ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dt_pos_index" class="display table table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Detalles</th>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Tipo venta</th>
                                <th>Estado</th>
                                <th>Tipo pago</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pos_sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href="<?php echo e(route('pos_details.pos_details_show', $sale->id)); ?>" class="btn btn-sm btn-primary btn-border">
                                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-document-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 20px; height: 20px; color: #2f77f0']); ?>
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
                                        Factura
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-danger2 text-danger">
                                        <?php echo e($sale->folio_invoice_number); ?>

                                    </span>
                                </td>
                                <td><?php echo e($sale->client->client_name); ?></td>
                                <td>
                                    <?php echo e($sale->sale_type == 'E' ? 'EXONERADA' : ($sale->sale_type == 'G' ? 'GRAVADA' : 'EXENTA')); ?>

                                </td>
                                <td>
                                    <span class="badge bg-secondary2 text-secondary">PAGADO</span>
                                </td>
                                <td>
                                    <?php
                                    $classes = [
                                    1 => 'bg-success2 text-success',
                                    2 => 'bg-warning2 text-warning',
                                    3 => 'bg-primary2 text-primary',
                                    ];
                                    $class = $classes[$sale->sale_payment_type] ?? 'bg-dark';
                                    ?>

                                    <?php
                                    $paymentTypeText = match($sale->sale_payment_type) {
                                    1 => 'EFECTIVO',
                                    2 => 'TARJETA',
                                    3 => 'DEPOSITO',
                                    4 => 'CHEQUE',
                                    default => 'Tipo desconocido',
                                    };
                                    ?>

                                    <span class="badge <?php echo e($class); ?>"><?php echo e($paymentTypeText); ?></span>
                                </td>
                                <td>
                                    <?php echo e($currency); ?> <?php echo e(number_format($sale->sale_total_amount,2)); ?>

                                </td>
                                <td>
                                    <?php echo e($sale->seller->seller_name); ?>

                                </td>
                                <td>
                                    <span class="badge bg-primary2 text-primary">
                                        <?php echo e($sale->created_at->format('H:i A')); ?><br>
                                        <?php echo e($sale->created_at->format('d/m/Y')); ?>

                                    </span>
                                </td>
                            </tr>

                            <!-- Details Include -->
                            <?php echo $__env->make('modules.pos_details._sale_details', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<!-- Datatables -->
<script src="<?php echo e(Storage::url('assets/js/plugin/datatables/datatables.min.js')); ?>"></script>
<script src="<?php echo e(Storage::url('customjs/datatables/pos/dt_pos_index.js')); ?>"></script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/pos/index.blade.php ENDPATH**/ ?>