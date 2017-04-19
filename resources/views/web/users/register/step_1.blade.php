@extends('layouts/default_register')

@section('content')
<div class="registration-body">
    <div class="step-1">
        <div class="signup-area">
            <div class="signup-btn-container">
                <a class="btn email-signup" role="button" href="{{ action('Web\RegisterController@createStep2') }}">
                    <span>
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        &nbsp;Sign up with email
                    </span>
                </a>
                <a class="btn fb-signup" role="button" href="{{ action('Web\RegisterController@storeViaFaceBook') }}">
                    <span><i class="fa fa-facebook" aria-hidden="true"></i>&nbsp;Sign up with facebook</span>
                </a>
            </div>
        </div>
        <div class="signup-area sm">
            <div class="signup-btn-container">
                <a class="btn email-signup" role="button" href="{{ action('Web\RegisterController@createStep2') }}">
                    <span><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Sign up with email</span>
                </a>
                <a class="btn fb-signup" role="button" href="{{ action('Web\RegisterController@storeViaFaceBook') }}">
                    <span><i class="fa fa-facebook" aria-hidden="true"></i>&nbsp;Sign up with facebook</span>
                </a>
            </div>
        </div>
        <div class="intro-area">
            <div class="row">
                <div class="col-md-6">
                    <div class="intro-card">
                        <div class="card-img">
                            <img src="assets/images/registration/intro_01.png">
                        </div>
                        <div class="card-info">
                            <div class="card-number">
                                01
                            </div>
                            <p class="card-title">Enjoy original Fun! Japan contents everyday for free!</p>
                            <p class="card-description">Great contents that will make you love Japan even more: selected food, popular tourist spots, fashion, anime and more!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="intro-card">
                        <div class="card-img">
                            <img src="assets/images/registration/intro_2.png">
                        </div>
                        <div class="card-info">
                            <div class="card-number">
                                02
                            </div>
                            <p class="card-title">Community where Japanese lovers gather!</p>
                            <p class="card-description">Share your stories about food, sightseeing, shopping, entertainment with fellow Japan lovers!</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="intro-card">
                        <div class="card-img">
                            <img src="assets/images/registration/intro_3.png">
                        </div>
                        <div class="card-info">
                            <div class="card-number">
                                03
                            </div>
                            <p class="card-title">Fun! Japan staff will become your friends!</p>
                            <p class="card-description">Know more about Japan from friendly staff with latest insight on Japan!</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="intro-card">
                        <div class="card-img">
                            <img src="assets/images/registration/intro_4.png">
                        </div>
                        <div class="card-info">
                            <div class="card-number">
                                04
                            </div>
                            <p class="card-title">Lot of benefits exclusive for Fun! Japan members!</p>
                            <p class="card-description">Get member exclusive benefits: coupon, win gift, event. All in collaboration with Japanese companies.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-square"></div>
        </div>
        <div class="signup-area bottom">
            <div class="signup-btn-container">
                <a class="btn email-signup" role="button" href="{{ action('Web\RegisterController@createStep2') }}">
                    <span><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Sign up with email</span>
                </a>
                <a class="btn fb-signup" role="button" href="{{ action('Web\RegisterController@storeViaFaceBook') }}">
                    <span><i class="fa fa-facebook" aria-hidden="true"></i>&nbsp;Sign up with facebook</span>
                </a>
            </div>
        </div>
        <div class="signup-area sm">
            <div class="signup-btn-container">
                <a class="btn email-signup" role="button" href="{{ action('Web\RegisterController@createStep2') }}">
                    <span><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;Sign up with email</span>
                </a>
                <a class="btn fb-signup" role="button" href="{{ action('Web\RegisterController@storeViaFaceBook') }}">
                    <span><i class="fa fa-facebook" aria-hidden="true"></i>&nbsp;Sign up with facebook</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
