@extends('layouts/default_login')
@section('content')
    <div class="top-body">
        <div class="main-content">
            <div class="row">
                <div class="main">
                    <div class="col-xs-offset-2 col-xs-8 text-center">
                    @if ($errors->has('token'))
                        @include('web.includes._show_error')
                    @else
                        <div>
                            <h3>{{ trans('web/user.lost_password.title_reset_password') }}</h3>
                            <div id="ContentWrapper">
                                <p>{{ trans('web/user.lost_password.description_reset_password') }}</p>
                            </div>
                        </div>
                        @include('web.includes._show_error')

                        {!! Form::open(['url' => action('Web\ResetPasswordController@resetPasswordProcess')]) !!}
                            <input name="token" type="hidden" value="{{ $token }}">
                            <div class="form-group">
                                <label class="sr-only" for="Password">Password</label>
                                <input class="form-control" id="Password" name="password" placeholder="Minimum 6 letters" type="password">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="ConfirmPassword">ConfirmPassword</label>
                                <input class="form-control" id="ConfirmPassword" name="password_confirmation" placeholder="Confirm your password" type="password">
                            </div>
                            <p class="text-center">
                                <button type="submit" class="btn btn-primary">Reset Password</button>
                            </p>
                        {!! Form::close() !!}
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
