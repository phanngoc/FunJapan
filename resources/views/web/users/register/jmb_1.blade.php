@extends('layouts/default_register')

@section('content')
<div class="registration-body jmb">
    <div class="step-3-jmb">
        <p class="re-status">{{ trans('web/user.register_page.banner.step_3_title') }}</p>
        <p class="re-checked"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
        <p class="re-thankyou">Thank you for signing up!</p>
    </div>
    <div class="break-line">
        <img class="break-line-dk" src="assets/images/registration/break_line.png" alt="breack-line"></img>
        <img class="break-line-mb" src="assets/images/registration/break_line_sm.png" alt="breack-line"></img>
    </div>
    <div class="jmb-registration">
        <div class="jmb-intro">
            <div class="intro-title">
                <p class="sm-text">Earn miles by boarding, lodging or shopping!</p>
                <p class="lg-text">Special offer for FJ members</p>
                <p class="caret-down"><i class="fa fa-caret-down" aria-hidden="true"></i></p>
            </div>
            <div class="card-banner">
                <img src="assets/images/registration/card_banner.png" alt="card_banner"></img>
                <div class="ribbon-text">
                    <span class="stars-group left"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>
                    <span class="text">Special card for FJ members</span>
                    <span class="stars-group right"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>
                </div>
                <div class="dialog">
                    <p class="title">
                        Get
                        <span class="red-text">Fun!</span>
                        <span class="large-text">Japan</span> members only special JAL mileage bank card!
                    </p>
                    <p class="register-now">
                        <span class="green-text">Let's register now!</span>
                    </p>
                </div>
            </div>
            <p class="summary"><span>With JAL mileage bank service, you can exchange miles for many attractive rewards. Miles can be earned through boarding, lodging or shopping activities.</span></p>
            <div class="card-guide">
                <img src="assets/images/registration/card_guide.png" alt="card_banner"></img>
                <div class="guide blue-circle">
                    <p class="title">Earn miles</p>
                    <p class="description">Earn miles by boarding flight or shopping.</p>
                </div>
                <div class="guide green-circle">
                    <p class="title">Exchange miles</p>
                    <p class="description">Exchange miles for flight tickets, coupons and more.</p>
                </div>
            </div>
        </div>
        <div class="jmb-intro-mobile">
            <div class="intro-title">
                <p class="sm-text">Earn miles by boarding, lodging or shopping!</p>
                <p class="lg-text">Special offer for FJ members</p>
                <p class="caret-down"><i class="fa fa-caret-down" aria-hidden="true"></i></p>
            </div>
            <div class="card-banner">
                <img src="assets/images/registration/card_banner_sm.png" alt="card_banner"></img>
                <div class="ribbon-text">
                    <span class="stars-group left"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>
                    <span class="text">Special card for FJ members</span>
                    <span class="stars-group right"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>
                </div>
                <div class="dialog">
                    <p class="title">
                        Get
                        <span class="red-text">Fun!</span>
                        <span class="large-text">Japan</span> members only special JAL mileage bank card!
                    </p>
                    <p class="register-now">
                        <span class="green-text">Let's register now!</span>
                    </p>
                </div>
            </div>
            <p class="summary"><span>With JAL mileage bank service, you can exchange miles for many attractive rewards. Miles can be earned through boarding, lodging or shopping activities.</span></p>
            <div class="card-guide">
                <img src="assets/images/registration/card_guide_sm.png" alt="card_banner"></img>
                <div class="guide blue-circle">
                    <p class="title">Earn miles</p>
                    <p class="description">Earn miles by boarding flight or shopping.</p>
                </div>
                <div class="guide green-circle">
                    <p class="title">Exchange miles</p>
                    <p class="description">Exchange miles for flight tickets, coupons and more.</p>
                </div>
            </div>
        </div>
        <div class="step-2 jmb">
            {{ Form::open(['action' => 'Web\RegisterController@storeJmb']) }}
                <p class="guide-text center">Please provide all of the required information below and click the Next button.</p>
                <div class="row" id="given-name-section">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback has-info">
                            <label for="firstName" class="col-md-36 col-form-label">{{ trans('web/user.jmb.label.given_name') }}<span class="require">*</span></label>
                            <div class="col-md-64 col-xs-11">
                                <input type="text" class="form-control" id="firstName" name="first_name1" placeholder="First name" value="{{ old('first_name1') ?? '' }}">
                                <i class="zmdi zmdi-plus-circle-o control-btn" id="add-input"></i>
                                <i class="fa fa-question-circle info-tooltip-btn" id="firstName1Info" aria-hidden="true"></i>
                                <label class="help-block">{{ $errors->has('first_name1') ? $errors->first('first_name1') : '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-22 col-xs-11 @if (!array_key_exists('first_name2', old()))
                        hidden
                    @endif" id="firstName2_block">
                        <div class="form-group has-feedback has-info">
                            <div class="col-md-12 no-padding">
                                <input type="text" class="form-control" id="firstName2" placeholder="First name 2" value="{{ old('first_name2') ?? '' }}" name="{{ array_key_exists('first_name2', old()) ? 'first_name2' : '' }}">
                                <i class="zmdi zmdi-minus-circle-outline control-btn
                                @if (array_key_exists('first_name3', old()))
                                    hidden
                                @endif" id="remove-2"></i>
                                <i class="fa fa-question-circle info-tooltip-btn" id="firstName2Info" aria-hidden="true"></i>
                                <label class="help-block">{{ $errors->has('first_name2') ? $errors->first('first_name2') : '' }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-22 col-xs-11 @if (!array_key_exists('first_name3', old()))
                        hidden
                    @endif" id="firstName3_block">
                        <div class="form-group has-feedback has-info">
                            <div class="col-md-12 no-padding">
                                <input type="text" class="form-control" id="firstName3" placeholder="First name 3" value="{{ old('first_name3') ?? '' }}" name="{{ array_key_exists('first_name3', old()) ? 'first_name3' : '' }}">
                                <i class="zmdi zmdi-minus-circle-outline control-btn" id="remove-3"></i>
                                <i class="fa fa-question-circle info-tooltip-btn" id="firstName3Info" aria-hidden="true"></i>
                                <label class="help-block">{{ $errors->has('first_name3') ? $errors->first('first_name3') : '' }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback has-info">
                            <label for="lastName" class="col-md-36 col-form-label">{{ trans('web/user.jmb.label.family_name') }}<span class="require">*</span></label>
                            <div class="col-md-64">
                                <input type="text" class="form-control" id="lastName" name="last_name" placeholder="Last name" value="{{ old('last_name') ?? '' }}" {{ array_key_exists('first_name2', old()) ? 'disabled' : '' }}>
                                <span class="glyphicon form-control-feedback" id="lastName1"></span>
                                <i class="fa fa-question-circle info-tooltip-btn" id="lastNameInfo" aria-hidden="true"></i>
                                <label class="help-block">{{ $errors->has('last_name') ? $errors->first('last_name') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row has-info">
                            <label for="midName" class="col-md-36 col-form-label alR">{{ trans('web/user.jmb.label.middle_name') }}</label>
                            <div class="col-md-64">
                                <input type="text" class="form-control" id="midName" name="mid_name" placeholder="Middle name" value="{{ old('mid_name') ?? '' }}" {{ array_key_exists('first_name2', old()) ? 'disabled' : '' }}>
                                <i class="fa fa-question-circle info-tooltip-btn" id="midNameInfo" aria-hidden="true"></i>
                                <label class="help-block">{{ $errors->has('mid_name') ? $errors->first('mid_name') : '' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback has-info">
                            <label for="password" class="col-md-36 col-form-label">{{ trans('web/user.jmb.label.pin_password') }}<span class="require" >*</span></label>
                            <div class="col-md-64">
                                <input type="password" class="form-control" id="password" name="password" maxlength="6" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                <i class="fa fa-question-circle info-tooltip-btn" id="pwInfo" aria-hidden="true"></i>
                                <label class="help-block">{{ $errors->has('password') ? $errors->first('password') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row has-feedback">
                            <label for="password2" class="col-md-36 col-form-label alR">{{ trans('web/user.jmb.label.pin_confirm') }}<span class="require">*</span></label>
                            <div class="col-md-64">
                                <input type="password" class="form-control" id="password2" name="password_confirmation" maxlength="6" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                <span class="glyphicon form-control-feedback" id="password21"></span>
                                <label class="help-block">{{ $errors->has('password_confirmation') ? $errors->first('password_confirmation') : '' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row has-feedback">
                    <label for="address1" class="col-md-18 col-form-label">Address 1<span class="require">*</span></label>
                    <div class="col-md-82">
                        <input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1" value="{{ old('address1') ?? '' }}">
                        <span class="glyphicon form-control-feedback" id="address11"></span>
                        <label class="help-block">{{ $errors->has('address1') ? $errors->first('address1') : '' }}
                    </div>
                </div>
                <div class="form-group row has-feedback">
                    <label for="address2" class="col-md-18 col-form-label">Address 2<span class="require">*</span></label>
                    <div class="col-md-82">
                        <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2" value="{{ old('address2') ?? '' }}">
                        <span class="glyphicon form-control-feedback" id="address21"></span>
                        <label class="help-block">{{ $errors->has('address2') ? $errors->first('address2') : '' }}
                        <i class="zmdi zmdi-plus-circle-o control-btn address @if (old('address3'))
                            hidden
                        @endif" id="add-address-3"></i>
                    </div>
                </div>

                <div class="form-group row has-feedback @if (!old('address3'))
                    hidden
                @endif" id="input-address-3">
                    <label for="address3" class="col-md-18 col-form-label">Address 3</label>
                    <div class="col-md-82">
                        <input type="text" class="form-control" id="address3" name="address3" placeholder="Address 3" value="{{ old('address3') ?? '' }}">
                        <span class="glyphicon form-control-feedback" id="address21"></span>
                        <label class="help-block">{{ $errors->has('address3') ? $errors->first('address3') : '' }}
                        <i class="zmdi zmdi-plus-circle-o control-btn address @if (old('address4'))
                            hidden
                        @endif" id="add-address-4"></i>
                    </div>
                </div>

                <div class="form-group row has-feedback @if (!old('address4'))
                    hidden
                @endif" id="input-address-4">
                    <label for="address4" class="col-md-18 col-form-label">Address 4</label>
                    <div class="col-md-82">
                        <input type="text" class="form-control" id="address4" name="address4" placeholder="Address 4" value="{{ old('address4') ?? '' }}">
                        <span class="glyphicon form-control-feedback" id="address21"></span>
                        <label class="help-block">{{ $errors->has('address4') ? $errors->first('address4') : '' }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback">
                            <label for="zipcode" class="col-md-36 col-form-label">{{ trans('web/user.jmb.label.zipcode') }}<span class="require">*</span></label>
                            <div class="col-md-64">
                                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zip code" value="{{ old('zipcode') ?? '' }}">
                                <span class="glyphicon form-control-feedback" id="zipcode1"></span>
                                <label class="help-block">{{ $errors->has('zipcode') ? $errors->first('zipcode') : '' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="city" class="col-md-36 col-form-label">{{ trans('web/user.jmb.label.city') }}<span class="require">*</span></label>
                            <div class="col-md-64">
                                {!! Form::select('city', $initCity, null, ['id' => 'city']) !!}
                                <label class="help-block">{{ $errors->has('city') ? $errors->first('city') : '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="country" class="col-md-45 col-form-label  alR">{{ trans('web/user.jmb.label.country') }}<span class="require">*</span></label>
                            <div class="col-md-55">
                                {!! Form::select('country', $locales, count(old()) == 0 ? $currentLocale : old('country'), ['id' => 'country']) !!}
                                <label class="help-block">{{ $errors->has('country') ? $errors->first('country') : '' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row has-feedback">
                    <label for="phone" class="col-md-18 col-form-label">{{ trans('web/user.jmb.label.phone') }}<span class="require">*</span></label>
                    <div class="col-md-82">
                        <input type="text" class="form-control"
                            id="phone" name="phone" placeholder="Phone number"
                            value="{{ old('phone') ?? '' }}">
                        <span class="glyphicon form-control-feedback" id="phone1"></span>
                        <label class="help-block">{{ $errors->has('phone') ? $errors->first('phone') : '' }}
                    </div>
                </div>

                <div class="form-group term">
                    <p class="term-title"><label for="term" class="col-form-label">{{ trans('web/user.jmb.text.accept_terms') }}</label><span class="guide-text">{{ trans('web/user.jmb.text.accept_terms_warning') }}</span></p>
                    <p class="term-banner">
                        <a href="https://www.jal.co.jp/en/jalmile/rules.html" target="_blank">
                            <img class="banner-dk" src="assets/images/registration/jmb_term.png" alt="jmb_term">
                            <img class="banner-mb" src="assets/images/registration/jmb_term_sm.png" alt="jmb_term">
                        </a>
                    </p>
                </div>
                <div class="form-group term-check">
                    <div class="checkbox-holder term-checkbox">
                        <input type="checkbox" class="terms-checkbox" id="smTerms" name="terms" value="">
                        <input name="terms" type="hidden" value="{{ count(old()) > 0 ? old('terms') : 'false' }}" id="inputTerm">
                        <label for="terms" class="checkbox-label tick"></label>
                        <label class="checkbox-label"><span>{{ trans('web/user.jmb.label.terms') }}</span></label>
                    </div>
                    <label class="help-block">{{ $errors->has('terms') ? $errors->first('terms') : '' }}
                </div>
                <div class="step-btn-container">
                    <input class="btn btn-primary" id="submit-button" type="submit" value="Next">
                </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript">
        var terms = {{ count(old()) > 0 ? old('terms') : 'false' }};
        var allCities = {!! json_encode($allCities) !!};
        var oldInputs = {!! json_encode(old()) !!};
    </script>
    {{ Html::script('assets/js/web/jmb.js') }}
@endsection