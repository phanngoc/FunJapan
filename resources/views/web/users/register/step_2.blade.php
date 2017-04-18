@extends('layouts/default_register')

@section('content')
<div class="registration-body">
    <div class="step-2">
        {!! Form::open(['url' => action('Web\RegisterController@store')]) !!}
            <div class="form-group row has-feedback">
                <label for="fullName" class="col-md-18 col-form-label">{{ trans('web/user.label.name_title') }}<span class="require">*</span></label>
                <div class="col-md-82">
                    <input
                        class="form-control"
                        id="name"
                        name="name"
                        placeholder="{{ trans('web/user.label.name_placeholder') }}"
                        type="text"
                        value="{{ old('name') ? : ($name ? : '') }}"
                    >
                    <label class="help-block">{{ $errors->has('name') ? $errors->first('name') : '' }}</label>
                </div>
            </div>
            <div class="form-group row has-feedback">
                <label for="email" class="col-md-18 col-form-label">{{ trans('web/user.label.email_title') }}<span class="require">*</span></label>
                <div class="col-md-82">
                    <input
                        type="text"
                        class="form-control"
                        id="email"
                        name="email"
                        placeholder="{{ trans('web/user.label.email_placeholder') }}"
                        value="{{ $email ? : old('email') }}"
                    >
                    <label class="help-block">{{ $errors->has('email') ? $errors->first('email') : '' }}</label>
                    <input type="hidden" value="{{ $socialId }}" name="social_id" readonly>
                    <input type="hidden" value="{{ $provider }}" name="provider" readonly>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row has-feedback">
                        <label for="gender" class="col-md-36 col-form-label">Gender<span class="require">*</span></label>
                        <div class="col-md-64">
                            <select class="form-control" id="gender" name="gender">
                                    <option value="">---</option>
                                    <option value="1" {{ old('gender') === '1' ? 'selected' : '' }}>Male</option>
                                    <option value="0" {{ old('gender') === '0' ? 'selected' : '' }}>Female</option>
                            </select>
                            <label class="help-block">{{ $errors->has('gender') ? $errors->first('gender') : '' }}</label>
                        </div>
                    </div>
                </div>
            </div>
            @if (!$socialId)
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback">
                            <label for="password" class="col-md-36 col-form-label">{{ trans('web/user.label.password_title') }}<span class="require">*</span></label>
                            <div class="col-md-64">
                                <input class="form-control" id="password" name="password" placeholder="{{ trans('web/user.label.password_placeholder') }}" type="password" >
                                <label class="help-block">{{ $errors->has('password') ? $errors->first('password') : '' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback">
                            <label for="confirmPassword" class="col-md-36 col-form-label">{{ trans('web/user.label.re_password_title') }}<span class="require">*</span></label>
                            <div class="col-md-64">
                                <input class="form-control" id="re_password" name="password_confirmation" placeholder="Confirm your password" type="password">
                                <label class="help-block">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="form-group row">
                <label for="dobl" class="col-md-18 col-form-label">Birthday<span class="require">*</span></label>
                <div class="col-md-82">
                    <div class="row">
                        <div class="col-xs-4">
                            <select class="form-control" id="birthday_month" name="birthday_month">
                                    <option disabled selected>{{ trans('web/user.label.month') }}</option>
                                    @foreach (range(1, 12) as $month)
                                        <option
                                            value="{{ $month }}"
                                            {{ old('birthday_month') == $month ? 'selected' : ''  }}
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
                                        {{ old('birthday_day') == $date ? 'selected' : ''  }}
                                    >
                                        {{ $date }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <select class="form-control" id="birthday_year" name="birthday_year">
                                <option disabled selected>{{ trans('web/user.label.year') }}</option>
                                    @foreach (range(1989, date("Y")) as $year)
                                        <option
                                            value="{{ $year }}"
                                            {{ old('birthday_year') == $year ? 'selected' : ''  }}
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
            </div>
            <div class="form-group row">
                <label for="location" class="col-md-18 col-form-label">{{ trans('web/user.label.location_title') }}<span class="require">*</span></label>
                <div class="col-md-82">
                    <select class="form-control" id="location_id" name="location_id">
                        <option value="">---</option>
                        @foreach ($locations as $location)
                            <option
                                value="{{ $location->id }}"
                                {{ old('location_id') == $location->id ? 'selected' : ''  }}
                            >
                                {{ $location->name }}
                            </option>
                        @endforeach
                    </select>
                    <label class="help-block">{{ $errors->has('location_id') ? $errors->first('location_id') : '' }}</label>
                </div>
            </div>
            <div class="form-group row">
                <label for="religion" class="col-md-18 col-form-label">{{ trans('web/user.label.religion_title') }}</label>
                <div class="col-md-82">
                    <select class="form-control" id="religion_id" name="religion_id">
                        <option selected="selected" value="">---</option>
                        @foreach ($religions as $religion)
                            <option
                                value="{{ $religion->id }}"
                                {{ old('religion_id') == $religion->id ? 'selected' : ''  }}
                            >
                                {{ $religion->locale['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <label class="help-block"></label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-18 col-form-label">{{ trans('web/user.label.subscription_title') }}</label>
                <div class="col-md-82">
                    <div class="checkbox-holder">
                        <input
                            id="newsCheckbox"
                            name="subscription_new_letter"
                            {{ old('subscription_new_letter') == 'on' ? 'checked' : ''  }}
                            type="checkbox"
                        >
                        <input type="hidden">
                        <label for="newsCheckbox" class="checkbox-label tick"></label>
                        <label class="checkbox-label"><span>{{ trans('web/user.label.subscription_new_letter') }}</span></label>
                    </div>
                    <div class="checkbox-holder">
                        <input
                            id="notiCheckbox"
                            name="subscription_reply_noti"
                            {{ old('subscription_reply_noti') == 'on' ? 'checked' : ''  }}
                            type="checkbox"
                        >
                        <input type="hidden">
                        <label for="notiCheckbox" class="checkbox-label tick"></label>
                        <label class="checkbox-label"><span>{{ trans('web/user.label.subscription_reply_noti') }}</span></label>
                    </div>
                </div>
            </div>
            @include('web.users.register._terms_conditions')
            <div class="form-group term-check">
                <div class="checkbox-holder term-checkbox">
                    <input
                        type="checkbox"
                        id="chk-license-agreement"
                        name="accept_policy"
                        {{ old('accept_policy') == 'on' ? 'checked' : ''  }}
                    >
                    <input type="hidden">
                    <label for="chk-license-agreement" class="checkbox-label tick"></label>
                    <label class="checkbox-label"><span>{{ trans('web/user.label.accept_policy') }}</span></label>
                </div>
                <label class="help-block">{{ $errors->has('accept_policy') ? $errors->first('accept_policy') : '' }}</label>
            </div>
            <div class="step-btn-container">
                <input class="btn btn-primary" id="submit-button" type="submit" value="{{ trans('web/user.label.next') }}">
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection
