@extends('layouts/default_toppage')

@section('style')

@endsection

@section('content')
    <div class="main-content">
        <div class="row gutter-32">
            <div class="col-md-70 main-column">
                <!-- MAIN -->
                @if (Session::has('status'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>{{ Session::get('status') }}</strong>
                    </div>
                @endif

                <h3>{{ trans('web/user.profile_page.setting') }}</h3>

                <div class="text-right">
                    <ul class="list-inline separator-pipe">
                        <li><a href="{{ route('profile') }}">{{ trans('web/user.profile_page.profile') }}</a></li>
                        <li><a href="{{ route('interest') }}">{{ trans('web/user.profile_page.interest') }}</a></li>
                        @if (!$user->registeredBySocial())
                            <li>{{ trans('web/user.profile_page.password') }}</li>
                        @endif
                    </ul>
                </div>

                @if (isset($message_error))
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <strong>{{ $message_error }}</strong>
                    </div>
                @else
                    {!! Form::open(['url' => action('Web\UsersController@updatePassword')]) !!}
                        @if (count($errors) > 0)
                            <div class="validation-summary-errors panel panel-danger text-left" data-valmsg-summary="true">
                                <div class="panel-heading">
                                    {{ trans('web/user.profile_page.please_correct') }}
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
                        <div class="form-group">
                            <label for="OldPassword">{{ trans('web/user.profile_page.password') }}</label>
                            <input class="form-control" id="OldPassword" name="password" placeholder="Enter the current password." type="password">
                        </div>
                        <div class="form-group">
                            <label for="NewPassword">{{ trans('web/user.profile_page.new_password') }}</label>
                            <input class="form-control" id="NewPassword" name="new_password" placeholder="Minimum 6 letters" type="password">
                        </div>
                        <div class="form-group">
                            <label for="ConfirmNewPassword">{{ trans('web/user.profile_page.new_password_again') }}</label>
                            <input class="form-control" id="ConfirmNewPassword" name="confirm_new_password" placeholder="Confirm your password" type="password">
                        </div>
                        <p class="text-center">
                            <button type="submit" class="btn btn-primary">{{ trans('web/user.profile_page.update_setting') }}</button>
                        </p>
                    {!! Form::close() !!}
                @endif
            </div>
            <div class="col-md-30 sidebar">
                @include('web.includes._side_bar_toppage')
            </div>
        </div>
    </div>
@endsection
