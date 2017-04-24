<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        @include('layouts.includes.head')
        <title>Fun! Japan</title>
        @include('layouts.includes.styles')
    </head>
    <body>
        <div class="top-container" id="top-container">
            <div class="container">
                @include('layouts.includes.header_register')
                @yield('content')
                @include('layouts.includes.footer_register')
            </div>
        </div>
        @include('layouts.includes.scripts_register')
    </body>
</html>
