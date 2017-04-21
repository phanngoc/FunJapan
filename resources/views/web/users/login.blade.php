@extends('layouts/default_login')
@section('content')
    <div class="top-body">
            <div class="main-content">
                <div class="main-content">
                    <div class="row">
                        <div class="main">
                            <div class="col-xs-12">
                            </div>
                            <div class="col-xs-offset-2 col-xs-8 text-center">
                                <div>
                                    <h3>{{ trans('web/user.login.login_title') }}</h3>
                                </div>
                                <div>
                                    <p>&nbsp;</p>
                                    <p>{{ trans('web/user.login.facebook_login_title') }}</p>

                                    <p class="text-center">
                                        <a
                                            class="btn btn-facebook"
                                            href="{{ action('Web\RegisterController@storeViaFaceBook') }}"
                                            title="{{ trans('web/user.login.facebook_login_text') }}"
                                        >
                                            <i class="fa fa-facebook-square"></i>&nbsp;{{ trans('web/user.login.facebook_login_text') }}
                                        </a>
                                    </p>

                                    <div class="text-center">
                                        <div class="text-center">
                                            <p><strong>{{ trans('web/user.login.or') }}</strong></p>
                                            <p>{{ trans('web/user.login.email_login_title') }}</p>
                                        </div>
                                    </div>
                                </div>
                                @include('web.includes._show_error')
                                {!! Form::open(['url' => action('Web\LoginController@login')]) !!}
                                    <div class="form-group">
                                        <label class="sr-only" for="email">{{ trans('web/user.label.email_title') }}</label>
                                        <input class="form-control" id="email" name="email" placeholder="{{ trans('web/user.label.email_placeholder') }}" type="text" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="password">{{ trans('web/user.label.password_title') }}</label>
                                        <input class="form-control" id="password" name="password" placeholder="{{ trans('web/user.label.password_placeholder') }}" type="password">
                                    </div>
                                    <p class="text-center">
                                        <button type="submit" id="btn-login" class="btn btn-primary">{{ trans('web/user.label.login') }}</button>
                                    </p>
                                {!! Form::close() !!}
                                <div class="text-center">
                                    <p>
                                        <a href="{{ action('Web\ResetPasswordController@lostPassWord') }}">{{ trans('web/user.label.forgot_password') }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
