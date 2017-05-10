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
                        <li>{{ trans('web/user.profile_page.interest') }}</li>
                        @if (!$user->registeredBySocial())
                            <li><a href="{{ route('change_password') }}">{{ trans('web/user.profile_page.password') }}</a></li>
                        @endif
                    </ul>
                </div>

                {!! Form::open(['url' => action('Web\UsersController@updateInterest')]) !!}
                    <div class="form-group">
                        <label for="Interests">{{ trans('web/user.profile_page.title_interest') }}</label>
                        @foreach ($categories as $category)
                            <div class="checkbox">
                                <label>
                                    <input {{ in_array($category->id, $interests) ? 'checked' : '' }} type="checkbox" name="interests[]" value="{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-center">
                        <button type="submit" class="btn btn-primary">{{ trans('web/user.profile_page.update_setting') }}</button>
                    </p>
                {!! Form::close() !!}
            </div>
            <div class="col-md-30 sidebar">
                @include('web.includes._side_bar_toppage')
            </div>
        </div>
    </div>
@endsection
