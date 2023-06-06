@php
$hasHttps= env('APP_ENV')=='production'
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico', $hasHttps) }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/landing/images/apple-touch-icon.png', $hasHttps) }}">
    <link rel="apple-touch-icon" sizes="72x72"
        href="{{ asset('assets/landing/images/apple-touch-icon-72x72.png', $hasHttps) }}">
    <link rel="apple-touch-icon" sizes="114x114"
        href="{{ asset('assets/landing/images/apple-touch-icon-114x114.png', $hasHttps) }}">

    <!-- <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}"> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('js')
    @stack('css')
</head>

<body class="tw-bg-slate-100">
    @yield('content')
</body>

</html>