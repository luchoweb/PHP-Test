<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Evertec PHP Test</title>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css">

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">
    </head>
    <body class="antialiased">
      <header class="pt-3 pb-3">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-12 col-lg-6">
              <h1 class="text-light m-0 text-center text-lg-start">
                Evertec PHP Test
              </h1>
            </div>
            <div class="col-12 col-lg-6 mt-3 mt-lg-0">
              <ul class="menu list-unstyled m-0 p-0 d-flex align-items-center gap-4 justify-content-center justify-content-lg-end">
                <li>
                  <a href="/orders" class="text-light">
                    All orders
                  </a>
                </li>
                <li>
                  <a href="/orders/new" class="text-light">
                    New order
                  </a>
                </li>
                <li>
                  <a href="/orders/tracking" class="text-light">
                    Tracking order
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </header>

      @yield('content')

      <footer class="pt-4 pb-3 text-center">
        <p class="m-0 text-dark">
          <small>
            Made with <span class="heart">&#10084;</span> by Lucho Web
          </small>
        </p>
      </footer>
    </body>
</html>
