@extends('layouts/default_login', ['defaultBackground' => true])

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="main">
                <div class="col-xs-12">

                </div>
                <div class="col-xs-offset-2 col-xs-8 text-center">

                    <div>
                        <div style="padding-bottom: 30px; text-align: left;">
                            <h1>{{ trans('web/guide.inquiry.japan_company') }}</h1>
                            <p>{!! trans('web/guide.inquiry.japan_company_des1') !!}</p>
                            <span>
                                ● {{ trans('web/guide.inquiry.japan_company_des5') }}<br>
                                ● {{ trans('web/guide.inquiry.japan_company_des6') }}<br>
                                ● {{ trans('web/guide.inquiry.japan_company_des7') }}<br>
                                ● {{ trans('web/guide.inquiry.japan_company_des8') }}
                            </span>
                            <br><br>
                            <p>
                                {!! trans('web/guide.inquiry.japan_company_des4') !!}
                                {!! trans('web/guide.inquiry.japan_company_des2') !!}
                                {!! trans('web/guide.inquiry.japan_company_des3') !!}
                                <br>
                            </p>
                            <p>{{ trans('web/guide.inquiry.english_follow') }}<br>
                                <br>
                                {!! trans('web/guide.inquiry.english_follow_to') !!}<br>
                                <br>
                                {!! trans('web/guide.inquiry.english_follow_des1') !!}<br>
                                ● {{ trans('web/guide.inquiry.english_follow_des2') }}<br>
                                ● {{ trans('web/guide.inquiry.english_follow_des3') }}<br>
                                ● {{ trans('web/guide.inquiry.english_follow_des4') }}<br>
                                ● {{ trans('web/guide.inquiry.english_follow_des9') }}<br>
                                {!! trans('web/guide.inquiry.english_follow_des5', ['email' => 'inquiry-tw@fun-japan.jp']) !!}
                                <br>
                                {!! trans('web/guide.inquiry.english_follow_des6') !!}.<br>
                                {!! trans('web/guide.inquiry.english_follow_des7') !!}
                                {!! trans('web/guide.inquiry.english_follow_des8') !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
