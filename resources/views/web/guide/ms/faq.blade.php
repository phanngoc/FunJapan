@extends('web.guide.layout_guide')

@section('content_child')
    <div>
        <h1>
            <img class="img-responsive" alt="faq-top-01" src="assets/images/guide/faq-01.jpg">
        </h1>
        <h2>{{ trans('web/guide.faq.title') }}</h2>
        {!! trans('web/guide.faq.description', ['url' => action('Web\GuidesController@contactUs')]) !!}
        <h2>
            <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
            {{ trans('web/guide.faq.fun_japan_title') }}
        </h2>
        <p>
            {{ trans('web/guide.faq.fun_japan_description') }}
        </p>
        <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
        <h2>{{ trans('web/guide.faq.benefit_becoming_title') }}</h2>
        <p>
            {{ trans('web/guide.faq.benefit_becoming_description') }}
            <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
        </p>
        <h2>{{ trans('web/guide.faq.become_member_title') }}</h2>
        <p>{!! trans('web/guide.faq.become_member_description', ['url' => action('Web\RegisterController@create')]) !!}
            <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
        </p>
        <h2>{{ trans('web/guide.faq.become_member_free_question') }}</h2>
        <p>{{ trans('web/guide.faq.become_member_free_answer') }}<br><br>
            <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
        </p>
        <h2>{{ trans('web/guide.faq.login_question') }}</h2>
        <p>
            {{ trans('web/guide.faq.login_answer') }}
            <br><br>
            <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
        </p>
        <h2>{{ trans('web/guide.faq.login_facebook') }}</h2>
        <p>
            {!! trans('web/guide.faq.login_facebook_answer') !!}
            <br><br>
            <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
        </p>
        <h2>{{ trans('web/guide.faq.forgot_password') }}</h2>
            {!! trans('web/guide.faq.forgot_answer', ['url' => action('Web\ResetPasswordController@lostPassWord')]) !!}
        <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
        <h2>
            {{ trans('web/guide.faq.change_pass_help') }}
        </h2>
            {!! trans('web/guide.faq.change_pass', ['url' => '#']) !!}
            <br>
            <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
        </p>
        <h2>{{ trans('web/guide.faq.delete_user') }}</h2>
        <p>
            {!! trans('web/guide.faq.delete_user_answer', ['url' => '#']) !!}
            <br>
            <br>
            <img class="img-responsive" alt="faq-line-01" src="assets/images/guide/faq-line-01.jpg">
        </p>
    </div>
@endsection

