@extends('web.guide.layout_guide')

@section('content_child')
    <div>
        <h1>{{ trans('web/guide.contact_us.title') }}</h1>
        <p>{!! trans('web/guide.contact_us.mail_to', ['email' => 'support-th@fun-japan.jp']) !!}</p>
        <p>{!! trans('web/guide.contact_us.facebook_site', ['facebookUrl' => 'https://www.facebook.com/thailand.funjapan']) !!}</p>
    </div>
@endsection

