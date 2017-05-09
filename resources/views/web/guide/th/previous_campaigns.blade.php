@extends('web.guide.layout_guide')

@section('content_child')
    <div>
        <h1>
            <strong>
                <span style="font-size: 32px; color: #00b0f0;">{!! trans('web/guide.previous_campaigns.title') !!}
                </span>
            </strong>
        </h1>
        <p>{!! trans('web/guide.previous_campaigns.description') !!}</p>
        <br>
        <p><span style="color: #002060;"></span></p>
        <p>
            <img class="img-responsive" height="175" alt="20150728-20-03-Campaign" width="550" src="assets/images/guide/previous-campaigns-03.jpg">
        <p><br>
        </p>
    </div>
@endsection
