<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <base href="/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="fragment" content="!">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Fun! Japan</title>
    @include('layouts.includes.scripts_detail')
    @include('layouts.includes.styles')
</head>
<body>
<div class="top-container" id="top-container">
    <div class="container detail">
        @include('layouts.includes.header_detail')
        @yield('content')
    </div>
</div>
</body>
</html>

