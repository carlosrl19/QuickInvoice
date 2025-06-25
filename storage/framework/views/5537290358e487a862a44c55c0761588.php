<?php $__env->startSection('title'); ?>
Dashboard
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
    <li class="nav-item">
        <a href="#">Panel administrador</a>
    </li>
</ul>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Información general I -->
<div class="row row-card-no-pd">
    <!-- Ventas del mes actual -->
    <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-sm-3">
        <div class="card bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="text-white fw-bold">
                            <?php echo e($pos_counter_actual_month); ?>

                            <small>( <?php echo e($currency); ?> <?php echo e(number_format($pos_counter_amount_sum,2)); ?>)</small>
                        </h1>
                        <h6 class="text-white"><b>Ventas del mes</b></h6>
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-shopping-cart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 80px; height: 100%; color: rgba(0,0,0,0.2)']); ?>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ingresos del mes actual -->
    <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-3">
        <div class="card bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="text-white fw-bold">
                            <?php echo e($newQuotesThisMonth); ?>

                            <small>( <?php echo e($currency); ?> <?php echo e(number_format($newQuotesThisMonthSum,2)); ?>)</small>
                        </h1>
                        <h6 class="text-white"><b>Cotizaciones del mes</b></h6>
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-banknotes'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 80px; height: 100%; color: rgba(0,0,0,0.2)']); ?>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nuevos clientes del mes actual -->
    <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-3">
        <div class="card bg-info">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="text-white fw-bold">
                            <?php echo e($newClientsThisMonth); ?> <small>(<?php echo e($clients_counter); ?>)</small>
                        </h1>
                        <h6 class="text-white"><b>Nuevos clientes del mes</b></h6>
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-users'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 80px; height: 100%; color: rgba(0,0,0,0.2)']); ?>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Nuevos créditos del mes actual -->
    <div class="col-12 col-sm-6 col-md-6 col-xl-3 mb-3">
        <div class="card bg-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h1 class="text-white fw-bold">
                            <?php echo e($loans_counter); ?> <small>( <?php echo e($currency); ?> <?php echo e(number_format($loan_counter_amount_sum,2)); ?>)</small>
                        </h1>
                        <h6 class="text-white"><b>Nuevos créditos del mes</b></h6>
                    </div>
                    <div>
                        <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-document-currency-dollar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 80px; height: 100%; color: rgba(0,0,0,0.2)']); ?>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Información general II -->
<div class="row">
    <!-- Ventas del día -->
    <div class="col-12 col-sm-4 col-md-4 col-xl-4 mb-3">
        <div class="card">
            <div class="card-body pb-0">
                <div class="h5 fw-bold float-end text-primary op-3 text-capitalize">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-cursor-arrow-ripple'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 80px; height: 100%; color: rgba(0,0,0,0.2)']); ?>
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
                </div>
                <h2 class="mb-2"><?php echo e($pos_counter_actual_day); ?></h2>
                <p class="text-muted">Ventas del día / <span class="op-5 text-primary"><?php echo e($todayDate); ?></span></p>
            </div>
        </div>
    </div>

    <!-- Cotizaciones activas actualmente -->
    <div class="col-12 col-sm-4 col-md-4 col-xl-4 mb-3">
        <div class="card">
            <div class="card-body pb-0">
                <div class="h5 fw-bold float-end text-primary op-3">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-document-text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 80px; height: 100%; color: rgba(0,0,0,0.2)']); ?>
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
                </div>
                <h2 class="mb-2"><?php echo e($activeQuotes); ?></h2>
                <p class="text-muted">Cotizaciones activas / <span class="op-5 text-capitalize text-primary"><?php echo e($actualMonth); ?></span></p>
            </div>
        </div>
    </div>

    <!-- Créditos activos actualmente -->
    <div class="col-12 col-sm-4 col-md-4 col-xl-4 mb-3">
        <div class="card">
            <div class="card-body pb-0">
                <div class="h5 fw-bold float-end text-primary op-3">
                    <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-document-duplicate'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'width: 80px; height: 100%; color: rgba(0,0,0,0.2)']); ?>
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
                </div>
                <h2 class="mb-2"><?php echo e($loans_active_counter); ?></h2>
                <p class="text-muted">Créditos activos / <span class="op-5 text-uppercase text-primary"><?php echo e($currency); ?> <?php echo e(number_format($loan_active_amount_sum,2)); ?></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Ventas recientes (4) / gráfica pie -->
<div class="row">
    <!-- Ventas reciente -->
    <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-body">
                <h5 class="fw-bold">Ultimas ventas</h5>
                <div class="table-responsive">
                    <table id="dt_pos_dashboard" class="display table table-responsive">
                        <thead>
                            <tr>
                                <th>Factura</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Vendedor</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pos_lastest; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                <td><?php echo e($sale->client->client_name); ?></td>
                                <td>
                                    <?php echo e($currency); ?> <?php echo e(number_format($sale->sale_total_amount,2)); ?>

                                </td>
                                <td>
                                    <?php echo e($sale->seller->seller_name); ?>

                                </td>
                                <td>
                                    <span class="badge bg-primary2 text-primary">
                                        <?php echo e($sale->created_at->format('d/m/Y')); ?>

                                    </span>
                                </td>
                            </tr>

                            <!-- Details Include -->
                            <?php echo $__env->make('modules.pos_details._sale_details', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5">
                                    <a class="text-muted" href="<?php echo e(route('pos.index')); ?>">
                                        VER MÁS REGISTROS ...
                                    </a>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top ventas más grandes -->
    <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Top ventas del mes</div>
            </div>
            <div class="card-body">
                <?php echo $chart_bigger_sales->renderHtml(); ?>

            </div>
        </div>
    </div>
</div>

<!-- Ventas del mes / año -->
<div class="row">
    <!-- Ventas del mes actual -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ventas del mes <small>(<?php echo e($pos_counter_actual_month); ?>)</small></div>
            </div>
            <div class="card-body">
                <?php echo $chart_sales_actual_month->renderHtml(); ?>

            </div>
        </div>
    </div>

    <!-- Ventas del año actual -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Ventas del año <small>(<?php echo e($pos_counter_year); ?>)</small></div>
            </div>
            <div class="card-body">
                <?php echo $chart_sales_actual_year->renderHtml(); ?>

            </div>
        </div>
    </div>
</div>

<!-- Actividades recientes -->
<div class="row">
    <!-- Actividades recientes del mes actual -->
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="card-head-row">
                    <div class="card-title">Actividad reciente <small>(<?php echo e($new_logs_actual_month_counter); ?>)</small></div>
                    <div class="card-tools">
                        <ul class="nav nav-pills nav-secondary nav-pills-no-bd nav-sm" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" disabled id="pills-month" data-bs-toggle="pill" href="#" role="tab" aria-selected="false">
                                    Mes actual
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body" style="max-height: 38rem; overflow: auto;">
                <?php $__empty_1 = true; $__currentLoopData = $new_logs_actual_month; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="d-flex">
                    <div class="avatar avatar-online">
                        <span class="avatar-title rounded-circle border border-white bg-<?php echo e($colorsList[array_rand($colorsList)]); ?>">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-document-text'); ?>
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
                        </span>
                    </div>
                    <div class="flex-1 ms-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">
                            <?php echo e($log->module_log); ?>

                            <span class="text-muted op-5 ps-3">
                                <small><?php echo e(Carbon\Carbon::parse($log->created_at)->setTimezone('America/Costa_Rica')->locale('es')->translatedFormat('d F')); ?></small>
                            </span>
                        </h6>
                        <span class="text-muted"><?php echo e($log->log_description); ?></span>
                    </div>
                    <div class="float-end pt-1">
                        <small class="text-muted"><?php echo e(Carbon\Carbon::parse($log->created_at)->setTimezone('America/Costa_Rica')->locale('es')->translatedFormat('H:i a')); ?></small>
                    </div>
                </div>
                <div class="separator-dashed"></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="d-flex">
                    <div class="avatar avatar-online">
                        <span class="avatar-title rounded-circle border border-white bg-danger">
                            <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-face-smile'); ?>
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
                        </span>
                    </div>
                    <div class="flex-1 ms-3 pt-1">
                        <h6 class="text-uppercase fw-bold mb-1">
                            ¡Vaya!
                        </h6>
                        <span class="text-muted">Al parecer no se han realizado movimientos últimamente.</span>
                    </div>
                    <div class="float-end pt-1">
                        <small class="text-muted">N/A</small>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- Datatables -->
<script src="<?php echo e(Storage::url('assets/js/plugin/datatables/datatables.min.js')); ?>"></script>
<script src="<?php echo e(Storage::url('customjs/datatables/pos/dt_pos_dashboard.js')); ?>"></script>

<!-- Chart ventas más grandes  -->
<?php echo $chart_bigger_sales->renderChartJsLibrary(); ?>

<?php echo $chart_bigger_sales->renderJs(); ?>


<!-- Chart mes actual -->
<?php echo $chart_sales_actual_month->renderChartJsLibrary(); ?>

<?php echo $chart_sales_actual_month->renderJs(); ?>


<!-- Chart año actual -->
<?php echo $chart_sales_actual_year->renderChartJsLibrary(); ?>

<?php echo $chart_sales_actual_year->renderJs(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/modules/dashboard/index.blade.php ENDPATH**/ ?>