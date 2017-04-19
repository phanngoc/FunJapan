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
                <div class="main-content">
                    <div class="row">
                        <div class="main">
                            <div class="col-xs-12">
                            </div>
                            <div class="col-xs-offset-2 col-xs-8 text-center">
                                <div>
                                    <p>&nbsp;</p>
                                    <p>Terhubung ke Fun! Japan dengan akun Facebook.</p>

                                    <p class="text-center">
                                        <a class="btn btn-facebook" href="{{ action('Web\RegisterController@storeViaFaceBook') }}" title="Login with Facebook">
                                            <i class="fa fa-facebook-square"></i> Login with Facebook</a>
                                    </p>

                                    <div class="text-center">
                                        <div class="text-center">
                                            <p><strong>ATAU</strong></p>
                                            <p>Sign in dengan e mail address</p>
                                        </div>
                                    </div>
                                </div>
                                @if (count($errors))
                                    <div class="validation-summary-errors panel panel-danger text-left">
                                        <div class="panel-heading">
                                            Please, correct the followings errors
                                        </div>
                                        <div class="panel-body">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li style="white-space:pre-wrap;">{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                                {!! Form::open(['url' => action('Web\LoginController@login')]) !!}
                                    <div class="form-group">
                                        <label class="sr-only" for="email">E-Mail Address</label>
                                        <input class="form-control" id="email" name="email" placeholder="Enter your email address" type="text" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="password">Password</label>
                                        <input class="form-control" id="password" name="password" placeholder="Minimum 6 letters" type="password">
                                    </div>
                                    <p class="text-center">
                                        <button type="submit" id="btn-login" class="btn btn-primary">Login</button>
                                    </p>
                                {!! Form::close() !!}
                                <div class="text-center">
                                    <p>
                                        <a href="">Lupa kata sandi?</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
