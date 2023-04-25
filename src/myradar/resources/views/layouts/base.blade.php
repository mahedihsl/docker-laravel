<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ asset('images/favicon.ico', true) }}">
    <link rel="apple-touch-icon" href="{{ asset('landing/images/apple-touch-icon.png', true) }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('landing/images/apple-touch-icon-72x72.png', true) }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('landing/images/apple-touch-icon-114x114.png', true) }}">

    <!-- Google Font -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="{{ asset('css/tailwind.css?v='.config('cache.version'), true) }}">
    <script src="//unpkg.com/alpinejs" defer></script>
    @stack('style')
    <!-- Scripts -->
    <script>
      window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
</head>

<body class="tw-p-0 tw-m-0">

@yield('body')

@stack('script')
</body>

</html>