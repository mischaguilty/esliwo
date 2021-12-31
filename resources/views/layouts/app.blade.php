<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta name="robots" content="no,all">
    <meta name="googlebot" content="no,all">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <livewire:styles/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ config('app.version') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/elsie_logo.png') }}?v={{ config('app.version') }}">
    <link rel="icon" href="{{ asset('images/elsie_logo.png') }}?v={{ config('app.version') }}">
    <link rel="manifest" href="{{ asset('json/manifest.json') }}?v={{ config('app.version') }}">
    @stack('styles')
</head>
<body>
<livewire:layouts.nav/>

<div class="container my-3">
    {{ $slot }}
</div>

<livewire:modal/>

<livewire:scripts/>
<script src="{{ asset('js/app.js') }}?v={{ config('app.version') }}"></script>
@stack('scripts')
</body>
</html>
