<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title or trans('admin/global.title') }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.admin.includes.styles')
</head>
<body>
@yield('styles')
@yield('modal')
<div class="wrapper">
    @include('layouts.admin.includes.left')
    <div id="page-wrapper" class="gray-bg">
        @include('layouts.admin.includes.header')
        @if (!isset($notIncludeNotice) || !$notIncludeNotice)
            @include('layouts.admin.includes.notice_messages')
        @endif
        <div class="wrapper wrapper-content">
            @yield('content')
        </div>
        @include('layouts.admin.includes.footer')
    </div>
</div>
@include('layouts.admin.includes.scripts')
@yield('scripts')
</body>
</html>