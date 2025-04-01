<!doctype html>
<html lang="es">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>{{ config('app.name') }}</title>
  <!-- CSS Files -->
  <link rel="stylesheet" href="{{ Storage::url('assets/css/bootstrap.min.css') }}" />
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
      <img src="{{ Storage::url('errors/404.png') }}" class="responsive-image" />
      <p class="text-muted">
        "Intenta nuevamente dentro de un momento, si el problema persiste contacte al encargado para que pueda solucionarlo."
      </p>
      <p>
        <a href="/" class="btn btn-sm btn-danger">
          <x-heroicon-o-arrow-left style="right: 20px; height: 20px; color: white" />
          Volver
        </a>
      </p>
    </div>
  </div>
</body>

</html>