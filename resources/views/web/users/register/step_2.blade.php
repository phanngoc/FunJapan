@extends('layouts/default_register')

@section('content')
<div class="registration-body">
    <div class="step-2">
        <form id="fjRegisterForm" data-toggle="validator" role="form">
            <div class="form-group row has-feedback">
                <label for="fullName" class="col-md-18 col-form-label">Your Name<span class="require">*</span></label>
                <div class="col-md-82">
                    <input class="form-control" id="fullName" name="FullName" placeholder="Enter your name" type="text" value="">
                    <label class="help-block"></label>
                </div>
            </div>
            <div class="form-group row has-feedback">
                <label for="email" class="col-md-18 col-form-label">Email<span class="require">*</span></label>
                <div class="col-md-82">
                    <input type="text" class="form-control" id="email" name="Email" placeholder="Email" data-error="Bruh, that email address is invalid">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row has-feedback">
                        <label for="gender" class="col-md-36 col-form-label">Gender<span class="require">*</span></label>
                        <div class="col-md-64">
                            <select class="form-control" id="gender" name="Gender">
                                    <option value="">---</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                            </select>
                            <label class="help-block"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row has-feedback">
                        <label for="password" class="col-md-36 col-form-label">Password<span class="require">*</span></label>
                        <div class="col-md-64">
                            <input class="form-control" id="password" name="Password" placeholder="Minimum 6 letters" type="password">
                            <label class="help-block"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group row has-feedback">
                        <label for="confirmPassword" class="col-md-36 col-form-label">Password, Again<span class="require">*</span></label>
                        <div class="col-md-64">
                            <input class="form-control" id="confirmPassword" name="ConfirmPassword" placeholder="Confirm your password" type="password">
                            <label class="help-block"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="dobl" class="col-md-18 col-form-label">Birthday<span class="require">*</span></label>
                <div class="col-md-82">
                    <div class="row">
                        <div class="col-xs-4">
                            <select class="form-control" id="BirthdayMonth" name="BirthdayMonth"><option value="">Month</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <select class="form-control" id="BirthdayDay" name="BirthdayDay"><option value="">Day</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                            </select>
                        </div>
                        <div class="col-xs-4">
                            <select class="form-control" id="BirthdayYear" name="BirthdayYear"><option value="">Year</option>
                                    <option value="1989">1989</option>
                                    <option value="1990">1990</option>
                                    <option value="1991">1991</option>
                                    <option selected="selected" value="1992">1992</option>
                                    <option value="1993">1993</option>
                                    <option value="1994">1994</option>
                                    <option value="1995">1995</option>
                                    <option value="1996">1996</option>
                                    <option value="1997">1997</option>
                                    <option value="1998">1998</option>
                                    <option value="1999">1999</option>
                                    <option value="2000">2000</option>
                                    <option value="2001">2001</option>
                                    <option value="2002">2002</option>
                                    <option value="2003">2003</option>
                                    <option value="2004">2004</option>
                                    <option value="2005">2005</option>
                                    <option value="2006">2006</option>
                                    <option value="2007">2007</option>
                                    <option value="2008">2008</option>
                                    <option value="2009">2009</option>
                                    <option value="2010">2010</option>
                                    <option value="2011">2011</option>
                                    <option value="2012">2012</option>
                                    <option value="2013">2013</option>
                                    <option value="2014">2014</option>
                                    <option value="2015">2015</option>
                                    <option value="2016">2016</option>
                                    <option value="2017">2017</option>
                            </select>
                        </div>
                    </div>
                    <div class="row" style="padding-left: 8px; padding-right: 8px">
                        <label class="help-block"></label>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="location" class="col-md-18 col-form-label">Location<span class="require">*</span></label>
                <div class="col-md-82">
                    <select class="form-control" id="location" name="Location"><option value="">---</option>
                            <option value="Jabodetabek">Jabodetabek</option>
                            <option value="Bandung">Bandung</option>
                            <option value="Surabaya">Surabaya</option>
                            <option value="Medan">Medan</option>
                            <option value="JawaBaratBanten">Jawa Barat, Banten</option>
                            <option value="JawaTengahYogyakarta">Jawa Tengah, Yogyakarta</option>
                            <option value="JawaTimur">Jawa Timur</option>
                            <option value="Sumatra">Sumatra</option>
                            <option value="Kalimantan">Kalimantan</option>
                            <option value="Sulawesi">Sulawesi</option>
                            <option value="BaliNTBNTT">Bali, NTB, NTT</option>
                            <option value="MalukuPapua">Maluku, Papua</option>
                            <option value="OtherCountry">Not in Indonesia</option>
                            <option value="Japan">Jepang</option>
                    </select>
                    <label class="help-block"></label>
                </div>
            </div>
            <div class="form-group row">
                <label for="religion" class="col-md-18 col-form-label">Religion</label>
                <div class="col-md-82">
                    <select class="form-control" id="religion" name="Religion"><option selected="selected" value="">---</option>
                            <option value="Buddhism">Buddhism</option>
                            <option value="Catholics">Catholics</option>
                            <option value="Christianity">Christianity</option>
                            <option value="Confucianism">Confucianism</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Islam">Islam</option>
                            <option value="Other">Other</option>
                            <option value="Taoism">Taoism</option>
                    </select>
                    <label class="help-block"></label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-18 col-form-label">Subscription</label>
                <div class="col-md-82">
                    <div class="checkbox-holder">
                        <input checked="checked" id="newsCheckbox" name="ReceivesNewsletters" type="checkbox" value="true"><input name="ReceivesNewsletters" type="hidden" value="false">
                        <label for="newsCheckbox" class="checkbox-label tick"></label>
                        <label class="checkbox-label"><span>Receive "Newsletter Email"</span></label>
                    </div>
                    <div class="checkbox-holder">
                        <input checked="checked" id="notiCheckbox" name="ReceivesReplyCommentNotification" type="checkbox" value="true"><input name="ReceivesReplyCommentNotification" type="hidden" value="false">
                        <label for="notiCheckbox" class="checkbox-label tick"></label>
                        <label class="checkbox-label"><span>Receive "Reply Notification Email"</span></label>
                    </div>
                </div>
            </div>
            @include('web.users.register._terms_conditions')
            <div class="form-group term-check">
                <div class="checkbox-holder term-checkbox">
                    <input type="checkbox" id="chk-license-agreement" name="IsAcceptPolicy" value="">
                    <input name="IsAcceptPolicy" type="hidden" value="false">
                    <label for="chk-license-agreement" class="checkbox-label tick"></label>
                    <label class="checkbox-label"><span>I accept the terms of use and the privacy policy.</span></label>
                </div>
            </div>
            <div class="step-btn-container">
                <input class="btn btn-primary" id="submit-button" type="submit" value="Next">
            </div>
        </form>
    </div>
</div>
@endsection
