@php
    $identity = \App\Models\Master\Identity::first();
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $title ?? config('app.name') }}</title>

    <meta name="robots" content="noindex, follow" />

    <meta name="description" content="">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Sistem Informasi Layanan" name="description" />
    <meta content="UBD" name="author" />
    <!-- Favicon -->

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/images/identity/' . $identity->favicon) }}">
    <!-- CSS
============================================ -->

    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/slick.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/vendor/slick-theme.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/sal.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/feather.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/fontawesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/euclid-circulara.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/swiper.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/magnify.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/odometer.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/animation.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/bootstrap-select.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/jquery-ui.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/magnigy-popup.min.css') }}">

    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">

    @livewireStyles
    @stack('style')
</head>

<body class="rbt-header-sticky">

    <x-f-header />

    {{ $slot }}

    <x-f-footer />

    <!-- JS
============================================ -->
    <!-- Modernizer JS -->

    <script src="{{ asset('frontend/js/vendor/modernizr.min.js') }}"></script>
    <!-- jQuery JS -->

    <script src="{{ asset('frontend/js/vendor/jquery.js') }}"></script>
    <!-- Bootstrap JS -->

    <script src="{{ asset('frontend/js/vendor/bootstrap.min.js') }}"></script>
    <!-- Parallax JS -->

    <script src="{{ asset('frontend/js/vendor/paralax.js') }}"></script>
    <!-- sal.js -->

    <script src="{{ asset('frontend/js/vendor/sal.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/swiper.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/magnify.min.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/jquery-appear.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/odometer.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/backtotop.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/isotop.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/imageloaded.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/countdown.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/wow.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/waypoint.min.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/easypie.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/text-type.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/jquery-one-page-nav.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/bootstrap-select.min.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/jquery-ui.js') }}"></script>

    <script src="{{ asset('frontend/js/vendor/magnify-popup.min.js') }}"></script>
    <!-- Main JS -->

    <script src="{{ asset('frontend/js/main.js') }}"></script>

    @livewireScripts
    @stack('script')
</body>

</html>
