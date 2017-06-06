@extends('layouts.admin.default_login')

@section('style')
    <link media="all" type="text/css" rel="stylesheet" href="/assets/css/main.css">
@endsection

@section('content')

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div class="flex-center position-ref full-height top-header">
                <div class="content header-text">
                    <div class="title m-b-md header-title-text">
                        <p class="header-text">
                            <a href="/">
                                <img src="/assets/images/brand-icon.png" alt="brand-icon">
                                <span>&nbsp;FUN!
                                    <span class="title-country">&nbsp;Japan</span>
                                </span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            @if (!isset($notIncludeNotice) || !$notIncludeNotice)
                @include('layouts.admin.includes.notice_messages')
            @endif
            {!! Form::open(['url' => action('Admin\LoginController@login'), 'class' => 'm-t', 'role' => 'form']) !!}
                <div class="form-group">
                    <input class="form-control" id="email" name="email" placeholder="{{ trans('admin/user.placeholder.email') }}" type="text" value="{{ old('email') }}">
                </div>
                <div class="form-group">
                    <input class="form-control" id="password" name="password" placeholder="{{ trans('admin/user.placeholder.password') }}" type="password">
                </div>
                <button type="submit" id="btn-login" class="btn btn-primary block full-width m-b">{{ trans('admin/user.button.login') }}</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
