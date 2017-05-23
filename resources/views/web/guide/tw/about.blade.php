@extends('web.guide.layout_guide')

@section('content_child')
    <div>
        <h1>
            <img class="img-responsive" alt="HP_about_03" src="/assets/images/guide/guide-about-introduce-jp.jpg">
        </h1>
        <p>
            <strong>
                <span style="font-size: 24px;">
                    <a href="{{ action('Web\GuidesController@staff') }}" target="_blank">
                        <span style="color: #ff0000;">{{ trans('web/guide.about.team_staff') }}</span>
                    </a>
                    <br>
                </span>
            </strong>
            <a href="{{ action('Web\GuidesController@staff') }}" target="_blank">
                <img height="200" alt="20150728-18-01-about" width="550" src="/assets/images/guide/guide-about-staff.jpg">
            </a>
            <br>
        </p>
        <p></p><br>
    </div>
@endsection
