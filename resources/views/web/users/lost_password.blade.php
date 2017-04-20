@extends('layouts/default_login')
@section('content')
    <div class="top-body">
        <div class="main-content">
            <div class="row">
                <div class="main">
                    <div class="col-xs-offset-2 col-xs-8 text-center">
                        <div>
                            <h3>{{ trans('web/user.lost_password.title') }}</h3>
                            <div id="ContentWrapper">
                                <p>{{ trans('web/user.lost_password.description') }}</p>
                            </div>
                        </div>
                        @include('web.includes._show_error')
                        {!! Form::open(['url' => action('Web\ResetPasswordController@lostPassWordProcess')]) !!}
                            <div class="form-group">
                                <label class="sr-only" for="EmailAddress">EmailAddress</label>
                                <input class="form-control" id="EmailAddress" name="email" placeholder="Enter your email address" type="text" value="{{ old('email') }}">
                            </div>
                            <p class="text-center">
                                <button type="submit" class="btn btn-primary">Get New Password</button>
                            </p>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
