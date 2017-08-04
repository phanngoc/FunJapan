<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        @include('layouts.includes.head')
        <title>{{ trans('web/global.app_name') . ' ' . trans('web/global.site_name') }}</title>
        @include('layouts.includes.scripts_toppage')
        @include('layouts.includes.styles')
    </head>
    <body>
        <div class="top-container" id="top-container">
            <div class="container">
                @include('layouts.includes.header_toppage')
                <div class="top-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </body>
</html>
