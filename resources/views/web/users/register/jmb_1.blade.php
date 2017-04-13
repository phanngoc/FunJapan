@extends('layouts/default_register')

@section('content')
<div class="registration-body jmb">
    <div class="step-3-jmb">
        <p class="re-status">Resigtration completed</p>
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
                <p class="sm-text">ご搭乗・ご宿泊・ショッピングでマイルがたまる！</p>
                <p class="lg-text">FJ 会員だけのスペシャルオファー</p>
                <p class="caret-down"><i class="fa fa-caret-down" aria-hidden="true"></i></p>
            </div>
            <div class="card-banner">
                <img src="assets/images/registration/card_banner.png" alt="card_banner"></img>
                <div class="ribbon-text">
                    <span class="stars-group left"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>
                    <span class="text">FJ会員限定カード</span>
                    <span class="stars-group right"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>
                </div>
                <div class="dialog">
                    <p class="title"><span class="red-text">Fun!</span> Japan 限定</p>
                    <p><span class="green-text">JALマイレージバンクカードをプレゼント。今すぐ会員登録してみませんか？</span></p>
                </div>
            </div>
            <p class="summary"><span>JALマイレージバンクは、ご搭乗やご宿泊・ショッピングなどでためたマイルを、魅力的な特典と交換できるJALのマイレージプログラムです。</span></p>
            <div class="card-guide">
                <img src="assets/images/registration/card_guide.png" alt="card_banner"></img>
                <div class="guide blue-circle">
                    <p class="title">マイルをためる</p>
                    <p class="description">フライトやショッピングなどでマイルがたまります。</p>
                </div>
                <div class="guide green-circle">
                    <p class="title">マイルをつかう</p>
                    <p class="description">航空券のほか、クーポンなどの特典と交換ができます。</p>
                </div>
            </div>
        </div>
        <div class="jmb-intro-mobile">
            <div class="intro-title">
                <p class="sm-text">ご搭乗・ご宿泊・ショッピングでマイルがたまる！</p>
                <p class="lg-text">FJ 会員だけのスペシャルオファー</p>
                <p class="caret-down"><i class="fa fa-caret-down" aria-hidden="true"></i></p>
            </div>
            <div class="card-banner">
                <img src="assets/images/registration/card_banner_sm.png" alt="card_banner"></img>
                <div class="ribbon-text">
                    <span class="stars-group left"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>
                    <span class="text">FJ会員限定カード</span>
                    <span class="stars-group right"><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i><i class="fa fa-star" aria-hidden="true"></i></span>
                </div>
                <div class="dialog">
                    <p class="title"><span class="red-text">Fun!</span> Japan 限定</p>
                    <p><span class="green-text">JALマイレージバンクカードをプレゼント。今すぐ会員登録してみませんか？</span></p>
                </div>
            </div>
            <p class="summary"><span>JALマイレージバンクは、ご搭乗やご宿泊・ショッピングなどでためたマイルを、魅力的な特典と交換できるJALのマイレージプログラムです。</span></p>
            <div class="card-guide">
                <img src="assets/images/registration/card_guide_sm.png" alt="card_banner"></img>
                <div class="guide blue-circle">
                    <p class="title">マイルをためる</p>
                    <p class="description">フライトやショッピングなどでマイルがたまります。</p>
                </div>
                <div class="guide green-circle">
                    <p class="title">マイルをつかう</p>
                    <p class="description">航空券のほか、クーポンなどの特典と交換ができます。</p>
                </div>
            </div>
        </div>
        <div class="step-2 jmb">
            <form id="register-form" data-toggle="validator" role="form">
                <p class="guide-text center">Please provide all of the required information below and click the Next button.</p>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback has-info">
                            <label for="firstName" class="col-md-36 col-form-label">First name<span class="require">*</span></label>
                            <div class="col-md-64 col-xs-11">
                                <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name">
                                <span class="glyphicon form-control-feedback" id="firstName1"></span>
                                <i class="zmdi zmdi-plus-circle-o control-btn" id="addFn_2"></i>
                                <i class="zmdi zmdi-plus-circle-o control-btn" id="addFn_3"></i>
                                <i class="fa fa-question-circle info-tooltip-btn" id="firstName1Info" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-22 col-xs-11 hidden" id="firstName2_block">
                        <div class="form-group has-feedback has-info">
                            <div class="col-md-12 no-padding">
                                <input type="text" class="form-control" id="firstName2" name="firstName2" placeholder="First name 2">
                                <i class="zmdi zmdi-minus-circle-outline control-btn" id="rmFn_2"></i>
                                <i class="fa fa-question-circle info-tooltip-btn" id="firstName2Info" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-22 col-xs-11 hidden" id="firstName3_block">
                        <div class="form-group has-feedback has-info">
                            <div class="col-md-12 no-padding">
                                <input type="text" class="form-control" id="firstName3" name="firstName3" placeholder="First name 3">
                                <i class="zmdi zmdi-minus-circle-outline control-btn" id="rmFn_3"></i>
                                <i class="fa fa-question-circle info-tooltip-btn" id="firstName3Info" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback has-info">
                            <label for="lastName" class="col-md-36 col-form-label">Last name<span class="require">*</span></label>
                            <div class="col-md-64">
                                <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name">
                                <span class="glyphicon form-control-feedback" id="lastName1"></span>
                                <i class="fa fa-question-circle info-tooltip-btn" id="lastNameInfo" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row has-info">
                            <label for="midName" class="col-md-36 col-form-label alR">Middle name</label>
                            <div class="col-md-64">
                                <input type="text" class="form-control" id="midName" name="midName" placeholder="Middle name">
                                <i class="fa fa-question-circle info-tooltip-btn" id="midNameInfo" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="gender" class="col-md-36 col-form-label">Gender<span class="require">*</span></label>
                            <div class="col-md-64">
                                <select id="gender" name="gender">
                                        <option value="" selected hidden>Select</option>
                                        <option>Male</option>
                                        <option>Female</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback has-info">
                            <label for="password" class="col-md-36 col-form-label">JMB Password<span class="require" >*</span></label>
                            <div class="col-md-64">
                                <input type="password" class="form-control" id="password" name="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                <i class="fa fa-question-circle info-tooltip-btn" id="pwInfo" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row has-feedback">
                            <label for="password2" class="col-md-36 col-form-label alR">Confirm password<span class="require">*</span></label>
                            <div class="col-md-64">
                                <input type="password" class="form-control" id="password2" name="password2" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                                <span class="glyphicon form-control-feedback" id="password21"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="city" class="col-md-36 col-form-label">Residence City<span class="require">*</span></label>
                            <div class="col-md-64">
                                <select id="city" name="city">
                                    <option value="" selected hidden>Select</option>
                                    <option>Location 1</option>
                                    <option>Location 2</option>
                                    <option>Location 3</option>
                                    <option>Location 4</option>
                                    <option>Location 5</option>
                                    <option>Location 6</option>
                                    <option>Location 7</option>
                                    <option>Location 8</option>
                                    <option>Location 9</option>
                                    <option>Location 10</option>
                                    <option>Location 11</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="country" class="col-md-36 col-form-label  alR">Country of Residence<span class="require">*</span></label>
                            <div class="col-md-64">
                                <select id="country" name="country">
                                    <option value="" selected hidden>Select</option>
                                    <option>Location 1</option>
                                    <option>Location 2</option>
                                    <option>Location 3</option>
                                    <option>Location 4</option>
                                    <option>Location 5</option>
                                    <option>Location 6</option>
                                    <option>Location 7</option>
                                    <option>Location 8</option>
                                    <option>Location 9</option>
                                    <option>Location 10</option>
                                    <option>Location 11</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row has-feedback">
                            <label for="zipcode" class="col-md-36 col-form-label">Zip code<span class="require">*</span></label>
                            <div class="col-md-64">
                                <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Zip code">
                                <span class="glyphicon form-control-feedback" id="zipcode1"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row has-feedback">
                    <label for="address1" class="col-md-18 col-form-label">Address 1<span class="require">*</span></label>
                    <div class="col-md-82">
                        <input type="text" class="form-control" id="address1" name="address1" placeholder="Address 1">
                        <span class="glyphicon form-control-feedback" id="address11"></span>
                    </div>
                </div>
                <div class="form-group row has-feedback">
                    <label for="address2" class="col-md-18 col-form-label">Address 2<span class="require">*</span></label>
                    <div class="col-md-82">
                        <input type="text" class="form-control" id="address2" name="address2" placeholder="Address 2">
                        <span class="glyphicon form-control-feedback" id="address21"></span>
                        <i class="zmdi zmdi-plus-circle-o control-btn address"></i>
                    </div>
                </div>
                <div class="form-group row has-feedback">
                    <label for="phone" class="col-md-18 col-form-label">Phone number<span class="require">*</span></label>
                    <div class="col-md-82">
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone number">
                        <span class="glyphicon form-control-feedback" id="phone1"></span>
                    </div>
                </div>
                <div class="form-group term">
                    <label class="col-form-label">Enrollment in JAL Mileage Bank (JMB)</label>
                    <p class="guide-text">Japan Airlines (JAL) is fully aware of the importance and responsibility to safeguard your personal information collected through online access, and will respectfully take all precautionary means for its handling and protection.<br>
                        <a href="#"><i class="zmdi zmdi-open-in-new"></i>&nbsp <span>More information</span></a>
                    </p>
                    <p class="term-title"><label for="term" class="col-form-label">Acceptance of Rules and Conditions</label><span class="guide-text">Please agree to the JMB Rules and Conditions to continue</span></p>
                    <p class="term-banner">
                        <a href="https://www.jal.co.jp/en/jalmile/rules.html" target="_blank">
                            <img class="banner-dk" src="assets/images/registration/jmb_term.png" alt="jmb_term">
                            <img class="banner-mb" src="assets/images/registration/jmb_term_sm.png" alt="jmb_term">
                        </a>
                    </p>
                </div>
                <div class="form-group term-check">
                    <div class="checkbox-holder term-checkbox">
                        <input type="checkbox" class="terms-checkbox" id="terms" name="terms" value="">
                        <input name="terms" type="hidden" value="false">
                        <label for="terms" class="checkbox-label tick"></label>
                        <label class="checkbox-label"><span class="guide-text small">I have read and agree to the JMB Rules and Conditions and <a href="#"><i class="zmdi zmdi-open-in-new"></i>&nbsp <span>other relevant terms and conditions</span></a>.<br>
                                    If you are under the age of 20, your parent or legal guardian must read and agree to the JMB Rules and Conditions and <a href="#"><i class="zmdi zmdi-open-in-new"></i>&nbsp <span>relevant terms and conditions</span></a> before you submit your application.</span></label>
                    </div>
                </div>
                <div class="form-group term-check sm">
                    <p class="guide-text small">
                        I have read and agree to the JMB Rules and Conditions and <a href="#"><i class="zmdi zmdi-open-in-new"></i>&nbsp <span>other relevant terms and conditions</span></a>.<br> If you are under the age of 20, your parent or legal guardian
                        must read and agree to the JMB Rules and Conditions and <a href="#"><i class="zmdi zmdi-open-in-new"></i>&nbsp <span>relevant terms and conditions</span></a> before you submit your application.
                    </p>
                    <div class="checkbox-holder term-checkbox">
                        <input type="checkbox" class="terms-checkbox" id="smTerms" name="terms" value="">
                        <input name="terms" type="hidden" value="false">
                        <label for="terms" class="checkbox-label tick"></label>
                        <label class="checkbox-label"><span>I agree to above Terms & conditions.</span></label>
                    </div>
                </div>
                <div class="step-btn-container">
                    <input class="btn btn-primary" id="submit-button" type="submit" value="Next">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
