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

                        @if (!Auth::user()->registeredBySocial())
                            <div class="form-group">
                                <input class="form-control" name="password" placeholder="Minimum 6 letters" type="password">
                            </div>
                            <div class="form-group">
                                <input class="form-control" id="ConfirmNewPassword" name="confirm_password" placeholder="Confirm your password" type="password">
                            </div>
                        @endif
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
