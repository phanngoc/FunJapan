@extends('layouts/default_toppage')

@section('style')

@endsection

@section('content')
    <div class="main-content">
        <div class="row gutter-32">
            <div class="col-md-70 main-column">
                <div>
                    <h3>{{ trans('web/user.close_page.title') }}</h3>
                    <div id="ContentWrapper">
                        <p>{{ trans('web/user.close_page.info_close') }}</p>
                        <p>{{ trans('web/user.close_page.sub_info_close') }}</p>
                    </div>
                </div>
                {!! Form::open(['url' => action('Web\UsersController@closeAccount')]) !!}
                    @if (Session::has('error'))
                        <div class="alert alert-danger">
                          <strong>{{ Session::get('error') }}</strong>
                        </div>
                    @endif
                    <div class="form-group">
                        <input class="form-control" name="password" placeholder="Minimum 6 letters" type="password">
                        <label class="help-block">{{ $errors->has('password') ? $errors->first('password') : '' }}</label>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="ConfirmNewPassword" name="confirm_password" placeholder="Confirm your password" type="password">
                        <label class="help-block">{{ $errors->has('confirm_password') ? $errors->first('confirm_password') : '' }}</label>
                    </div>
                    <p class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </p>
                {!! Form::close() !!}
            </div>
            <div class="col-md-30 sidebar">
                @include('web.includes._side_bar_toppage')
            </div>
        </div>
    </div>
@endsection
