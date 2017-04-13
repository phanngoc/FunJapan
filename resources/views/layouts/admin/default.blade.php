<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title or trans('admin/global.title') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('layouts.admin.includes.styles')
</head>
<body>
@yield('modal')
<div class="wrapper">
    @include('layouts.admin.includes.left')
    <div id="page-wrapper" class="gray-bg">
        @include('layouts.admin.includes.header')
        @include('layouts.admin.includes.notice_messages')
        <div class="wrapper wrapper-content">
            @yield('content')
        </div>
        @include('layouts.admin.includes.footer')
    </div>
</div>
@include('layouts.admin.includes.scripts')
</body>
</html>