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
<body class="gray-bg">
    @yield('styles')
    @yield('content')
    @include('layouts.admin.includes.scripts')
    @yield('scripts')
</body>
</html>
