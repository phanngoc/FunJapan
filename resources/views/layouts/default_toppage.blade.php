<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        @include('layouts.includes.head')
        <title>Fun! Japan</title>
        @include('layouts.includes.scripts_toppage')
        @include('layouts.includes.styles')
    </head>
    <body>
        <div class="top-container" id="top-container">
            <div class="container dark-background">
                @include('layouts.includes.header_toppage')
                <div class="top-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
