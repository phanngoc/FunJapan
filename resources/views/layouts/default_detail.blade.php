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
                <div class="top-body">
                    <div class="main-content">
                      <div class="row gutter-32">
                        @yield('content')
                        @include('web.includes._side_bar_detail')
                      </div>
                      @include('web.articles._related_articles')
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
