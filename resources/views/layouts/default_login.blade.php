<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    @include('layouts.includes.head')
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

