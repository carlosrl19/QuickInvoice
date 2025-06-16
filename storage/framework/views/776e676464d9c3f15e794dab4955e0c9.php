<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title><?php echo e(config('app.name')); ?></title>
  <!-- CSS Files -->
  <link rel="stylesheet" href="<?php echo e(Storage::url('assets/css/bootstrap.min.css')); ?>" />
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
      padding: 20px;
    }

    .responsive-image {
      max-width: 100%;
      height: auto;
      margin: auto;
    }

    /* Tamaño para pantallas pequeñas (xs, sm, md) */
    @media (max-width: 768px) {
      .responsive-image {
        width: 400px;
        height: 350px;
      }
    }

    /* Tamaño para pantallas grandes (lg, xl) */
    @media (min-width: 769px) {
      .responsive-image {
        width: 600px;
        /* Ajusta según sea necesario */
        height: 550px;
        /* Ajusta según sea necesario */
      }
    }
  </style>
</head>

<body>
  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="row mt-4 text-center">
      <p class="fw-bold text-danger">Parece que la página que estás buscando no existe.</p>
      <img src="<?php echo e(Storage::url('errors/404.png')); ?>" class="responsive-image" />
      <p class="text-muted">
        "Intenta nuevamente dentro de un momento, si el problema persiste contacte al encargado para que pueda solucionarlo."
      </p>
      <p>
        <a href="/" class="btn btn-sm btn-danger">
          <?php if (isset($component)) { $__componentOriginal643fe1b47aec0b76658e1a0200b34b2c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal643fe1b47aec0b76658e1a0200b34b2c = $attributes; } ?>
<?php $component = BladeUI\Icons\Components\Svg::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('heroicon-o-arrow-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\BladeUI\Icons\Components\Svg::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['style' => 'right: 20px; height: 20px; color: white']); ?>
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
          Volver
        </a>
      </p>
    </div>
  </div>
</body>

</html><?php /**PATH /home/carlos/Code/Code/QuickInvoice/resources/views/errors/404.blade.php ENDPATH**/ ?>