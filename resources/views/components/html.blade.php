<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }} - {{ $doc }}</title>
        <link rel="stylesheet" href="{{ asset('css/global.css') }}">
        <link rel="stylesheet" href="{{ asset('font/fontawesome-free-6.7.2-web/css/all.min.css') }}">

        @if(isset($css))
        <link rel="stylesheet" href="{{ asset('css/'.$css.'.css') }}">
        @endif

    </head>      
    <body >
        <x-navbar></x-navbar>
    <main class={{ $class }}>
    {{ $slot }}        
    </main>
    <x-footer></x-footer>
</body>
</html>