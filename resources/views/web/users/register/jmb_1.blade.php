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
            {{ Form::open(['action' => 'Web\RegisterController@storeJmb', 'id' => 'jmbRegisterForm']) }}
                <p class="guide-text center">Please provide all of the required information below and click the Next button.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-info">
                            <label class="col-md-36 col-form-label" for="firstName">Given Name
                                <span class="require">*</span>
                            </label>
                            <div class="col-md-64 col-xs-11">
                                <input class="form-control" id="jmbFirstName" type="text" name="firstName" placeholder="10 characters or less">
                                <i class="zmdi zmdi-plus-circle-o control-btn" id="addFn_2"></i>
                                <i class="zmdi zmdi-plus-circle-o control-btn" id="addFn_3"></i>
                                <i class="fa fa-question-circle info-tooltip-btn" id="firstName1Info" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-22 col-xs-11 hidden" id="firstName2_block">
                        <div class="form-group has-info">
                            <div class="col-md-12 no-padding">
                                <input class="form-control" id="jmbFirstName2" type="text" name="firstName2" placeholder="9 characters or less">
                                <i class="zmdi zmdi-minus-circle-outline control-btn" id="rmFn_2"></i>
                                <i class="fa fa-question-circle info-tooltip-btn" id="firstName2Info" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-22 col-xs-11 hidden" id="firstName3_block">
                        <div class="form-group has-info">
                            <div class="col-md-12 no-padding">
                                <input class="form-control" id="jmbFirstName3" type="text" name="firstName3" placeholder="9 characters or less">
                                <i class="zmdi zmdi-minus-circle-outline control-btn" id="rmFn_3"></i>
                                <i class="fa fa-question-circle info-tooltip-btn" id="firstName3Info" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-info">
                            <label class="col-md-36 col-form-label" for="lastName">Family Name
                                <span class="require">*</span>
                            </label>
                            <div class="col-md-64">
                                <input class="form-control" id="jmbLastName" type="text" name="lastName" placeholder="9 characters or less">
                                <i class="fa fa-question-circle info-tooltip-btn" id="lastNameInfo" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row has-info">
                            <label class="col-md-36 col-form-label alR" for="midName">Middle Name</label>
                            <div class="col-md-64">
                                <input class="form-control" id="jmbMidName" type="text" name="midName" placeholder="9 characters or less">
                                <i class="fa fa-question-circle info-tooltip-btn" id="midNameInfo" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-info">
                            <label class="col-md-36 col-form-label" for="password">Personal Identification Number (PIN)
                                <span class="require">*</span>
                            </label>
                            <div class="col-md-64">
                                <input class="form-control" id="jmbPassword" type="password" name="password" placeholder="Enter 6 numeric characters">
                                <i class="fa fa-question-circle info-tooltip-btn" id="pwInfo" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-36 col-form-label alR" for="confirmPassword">PIN Confirmation
                                <span class="require">*</span>
                            </label>
                            <div class="col-md-64">
                                <input class="form-control" id="jmbConfirmPassword" type="password" name="confirmPassword" placeholder="Enter 6 numeric characters">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-18 col-form-label" for="address1">Address 1
                        <span class="require">*</span>
                    </label>
                    <div class="col-md-82">
                        <input class="form-control addressInput" id="jmbAddress1" type="text" name="address1" placeholder="Address 1">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-18 col-form-label" for="address2">Address 2
                        <span class="require">*</span>
                    </label>
                    <div class="col-md-82">
                        <input class="form-control addressInput" id="jmbAddress2" type="text" name="address2" placeholder="Address 2">
                        <i class="zmdi zmdi-plus-circle-o control-btn address"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-36 col-form-label" for="zipcode">Zip Code
                                <span class="require">*</span>
                            </label>
                            <div class="col-md-64">
                                <input class="form-control" id="jmbZipcode" type="text" name="zipcode" placeholder="Zip Code">
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

                <div class="form-group row">
                    <label class="col-md-18 col-form-label" for="phoneNumber">Phone Number
                        <span class="require">*</span>
                    </label>
                    <div class="col-md-82">
                        <input class="form-control" id="jmbPhoneNumber" type="text" name="phoneNumber" placeholder="Phone Number">
                    </div>
                </div>
                <div class="form-group term">
                    <p class="term-title">
                        <label class="col-form-label" for="term">Acceptance of Rules and Conditions</label>
                        <span class="guide-text">Please agree to the JMB Rules and Conditions to continue</span>
                    </p>
                    <p class="term-banner">
                        <a href="https://www.jal.co.jp/en/jalmile/rules.html" target="_blank">
                            <img class="banner-dk" src="assets/images/registration/jmb_term.png" alt="jmb_term">
                            <img class="banner-mb" src="assets/images/registration/jmb_term_sm.png" alt="jmb_term">
                        </a>
                    </p>
                </div>
                <div class="form-group term-check">
                    <div class="checkbox-holder term-checkbox">
                        <input id="jmbIsAcceptPolicy" type="checkbox" name="isAcceptPolicy" value="true">
                        <input name="isAcceptPolicy" type="hidden" value="false">
                        <label class="checkbox-label tick" for="jmbIsAcceptPolicy"></label>
                        <label class="checkbox-label">
                            <span>I agree to the above Rules & Conditions</span>
                        </label>
                    </div>
                    <p class="feedback">
                        <strong><span id="jmbRequireMessage"></span></strong>
                    </p>
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
        var allCities = {!! json_encode($allCities) !!};
        var userBirthDay = {!! $userBirthDay !!};
    </script>
@endsection