<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Artisan ~ {{ $name = config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/artgui/artgui.css') }}">
</head>
<body class="bg-gray-100 font-mono">

<div id="app">
    <app
            home="{{ url('/') }}"
            endpoint="{{ config('artgui.force-https', false) ? secure_url(URL::route('artgui.index', [], false)) : route('artgui.index') }}"
            title="{{ config('artgui.title') }}"
    />
</div>

<script defer src="{{ asset('vendor/artgui/artgui.js') }}"></script>
</body>
</html>