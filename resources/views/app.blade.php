<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="https://cdn3.devexpress.com/jslib/22.2.3/css/dx.light.css" />
{{--      @vite(['resources/sass/app.scss','resources/js/app.js'])--}}
      <link rel="icon" href="{{ Storage::url(get_setting('logo_fabs')) }}">

      <link rel="stylesheet" href="{{ mix('css/app.css') }}">
      <script src="{{ mix('js/app.js') }}" defer></script>


  <style>


      .preloader{
          width:100%;
          height:100vh;
          background: var(--bs-primary);
          display: flex;
          align-items: center;
          justify-content: center;
      }
  </style>

    @inertiaHead
  </head>
  <body>
{{--      <div class="position-fixed preloader" id="pagePreloader">--}}
{{--          <div class="spinner-border" role="status">--}}
{{--              <span class="visually-hidden">Loading...</span>--}}
{{--          </div>--}}
{{--      </div>--}}
    @inertia


  <script>
      // document.addEventListener('DOMContentLoaded', function () {
      //     document.getElementById("pagePreloader").classList.add('d-none')
      // }, false);
  </script>

  </body>
</html>
