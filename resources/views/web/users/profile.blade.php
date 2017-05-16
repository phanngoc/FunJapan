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
                        <li>{{ trans('web/user.profile_page.profile') }}</li>
                        <li><a href="{{ route('interest') }}">{{ trans('web/user.profile_page.interest') }}</a></li>
                        @if (!$user->registeredBySocial())
                            <li><a href="{{ route('change_password') }}">{{ trans('web/user.profile_page.password') }}</a></li>
                        @endif
                    </ul>
                </div>

                {!! Form::open(['url' => action('Web\UsersController@update')]) !!}
                    <p class="text-danger">* These are mandatory fields.</p>
                    <div class="form-group">
                        {{ Form::label('Your Name', null, ['class' => 'required']) }}
                        {{ Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Enter your name']) }}
                        <label class="help-block">{{ $errors->has('name') ? $errors->first('name') : '' }}</label>
                    </div>

                    <div class="form-group">
                        {{ Form::label('Email', null, ['class' => 'required']) }}
                        {{ Form::text('email', $user->email, ['class' => 'form-control', 'readonly' => 'readonly']) }}
                        <label class="help-block">{{ $errors->has('email') ? $errors->first('email') : '' }}</label>
                    </div>

                    <div class="form-group">
                        {{ Form::label('Gender', null, ['class' => 'required']) }}
                        <select class="form-control" id="gender" name="gender">
                            <option value="">---</option>
                            <option {{ ($user->gender == 0 ? 'selected' : '') }} value="0">Male</option>
                            <option {{ ($user->gender == 1 ? 'selected' : '') }} value="1">Female</option>
                        </select>
                        <label class="help-block">{{ $errors->has('gender') ? $errors->first('gender') : '' }}</label>
                    </div>
                    <div class="form-group">
                        @php
                            $monthV = (old('birthday_month') == null) ? $user->birthday_parse->month : old('birthday_month');
                            $dayV = (old('birthday_day') == null) ? $user->birthday_parse->day : old('birthday_day');
                            $yearV = (old('birthday_year') == null) ? $user->birthday_parse->year : old('birthday_year');
                            $locationV = (old('location_id') == null) ? $user->location_id : old('location_id');
                            $religionV = (old('religion_id') == null) ? $user->religion_id : old('religion_id');

                            $subscriptionNewLetterV = (old('subscription_new_letter') == null) ? ($user->subscription_new_letter ? 'checked' : '') : (old('subscription_new_letter') ? 'checked' : '');
                            $subscriptionReplyNotiV = (old('subscription_reply_noti') == null) ? ($user->subscription_reply_noti ? 'checked' : '') : (old('subscription_reply_noti') ? 'checked' : '');
                        @endphp
                        <label class="required" for="BirthdayMonth">{{ trans('web/user.label.birthday') }}</label>
                        <div class="row">
                            <div class="col-xs-4">
                                <select class="form-control" id="BirthdayMonth" name="birthday_month">
                                    <option disabled selected>{{ trans('web/user.label.month') }}</option>
                                    @foreach (range(1, 12) as $month)
                                        <option
                                            value="{{ $month }}"
                                            {{ $monthV == $month ? 'selected' : ''  }}
                                        >
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-4">
                                <select class="form-control" id="birthday_day" name="birthday_day">
                                    <option disabled selected>{{ trans('web/user.label.day') }}</option>
                                    @foreach (range(1, 31) as $date)
                                        <option
                                            value="{{ $date }}"
                                            {{ $dayV == $date ? 'selected' : ''  }}
                                        >
                                            {{ $date }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-xs-4">
                               <select class="form-control" id="birthday_year" name="birthday_year">
                                    <option disabled selected>{{ trans('web/user.label.year') }}</option>
                                    @foreach (range(1900, date("Y")) as $year)
                                        <option
                                            value="{{ $year }}"
                                            {{ $yearV == $year ? 'selected' : ''  }}
                                        >
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" style="padding-left: 8px; padding-right: 8px">
                            <label class="help-block">{{ $errors->has('birthday') ? $errors->first('birthday') : '' }}</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="required" for="Location">Location</label>
                        <select class="form-control" id="location_id" name="location_id">
                            <option value="">---</option>
                            @foreach ($locations as $location)
                                <option
                                    value="{{ $location->id }}"
                                    {{ $locationV == $location->id ? 'selected' : ''  }}
                                >
                                    {{ $location->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="help-block">{{ $errors->has('location_id') ? $errors->first('location_id') : '' }}</label>
                    </div>

                    <div class="form-group">
                        <label for="religion" class="col-md-18 col-form-label">{{ trans('web/user.label.religion_title') }}</label>
                        <select class="form-control" id="religion_id" name="religion_id">
                            <option selected="selected" value="">---</option>
                            @foreach ($religions as $religion)
                                <option
                                    value="{{ $religion->id }}"
                                    {{ $religionV == $religion->id ? 'selected' : ''  }}
                                >
                                    {{ $religion->locale['name'] }}
                                </option>
                            @endforeach
                        </select>
                        <label class="help-block"></label>
                    </div>

                    <div class="form-group">
                        <label>{{ trans('web/user.label.subscription_title') }}</label>
                        <div class="panel panel-default">
                            <ul class="list-unstyled" style="margin-left: 15px;">
                                <li>
                                    <div class="checkbox">
                                        <label>
                                            <input {{ $subscriptionNewLetterV }} id="ReceivesNewsletters" name="subscription_new_letter" type="checkbox" value="true">
                                            <input type="hidden" />
                                            {{ trans('web/user.label.subscription_new_letter') }}
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="checkbox">
                                        <label>
                                            <input {{ $subscriptionReplyNotiV }} id="ReceivesReplyCommentNotification" name="subscription_reply_noti" type="checkbox" value="true">
                                            <input type="hidden" />
                                            {{ trans('web/user.label.subscription_reply_noti') }}
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <p class="text-danger">Please allow 15 to 30 minutes for setting changes to take effect.</p>
                    <p class="text-center">
                        <button type="submit" class="btn btn-primary">Update setting</button>
                    </p>
                {!! Form::close() !!}
            </div>
            <div class="col-md-30 sidebar">
                @include('web.includes._side_bar_toppage')
            </div>
        </div>
    </div>
@endsection
