@extends('layouts/default_register')

@section('content')
<div class="registration-body">
    <div class="step-3">
        <p class="re-status">{{ trans('web/user.register_page.banner.step_3_title') }}</p>
        <p class="re-checked"><i class="fa fa-check-circle" aria-hidden="true"></i></p>
        <p class="re-thankyou">Thank you for signing up!</p>
        <p class="re-country">for FUN! {{ trans('web/user.register_page.banner.text_country') }}</p>
        <div class="step-btn-container">
            <a class="btn" role="button" href="/{{ $currentLocale }}">
                <span>Go to FUN! Japan</span>
            </a>
        </div>
    </div>
</div>
@endsection
