@extends('web.guide.layout_guide')

@section('content_child')
    <div>
        <span style="font-size: 32px; color: #002060;"><strong>{{ trans('web/guide.article_series.title') }}</strong></span>
        <h6>
            <p>
                <span style="font-size: 18px; color: #595959;">
                    {{ trans('web/guide.article_series.summary_1') }}<br>
                    {{ trans('web/guide.article_series.summary_2') }}<br>
                    {{ trans('web/guide.article_series.summary_3') }}<br>
                    {{ trans('web/guide.article_series.summary_4') }}<br><br>
                </span>
            </p>
        </h6>
        <strong>
            <span style="color: #ff0000;">{!! trans('web/guide.article_series.title_campaign') !!}</span></strong><br>
        <a href="#">
            <img
                height="90"
                alt="TW_Series-Campaign"
                width="180"
                vertical-align="text-top"
                src="/assets/images/guide/article-series-tw-1.jpg"
                style="margin-right: 10px; float: left;">
        </a>
        {!! trans('web/guide.article_series.des_campaign') !!}<br><br><br><br>
        <strong>
            <span style="color: #ffc000;"><br>{!! trans('web/guide.article_series.title_how_to') !!}</span>
        </strong><br>
        <a href="#">
            <img
                height="90"
                alt="TW_Series-Howto"
                width="180"
                vertical-align="text-top"
                src="/assets/images/guide/article-series-tw-2.jpg"
                style="margin-right: 10px; float: left; height: 90px; width: 180px;"
            >
        </a>{{ trans('web/guide.article_series.des_how_to') }}<br>
        <br><br><br>
        <strong>
            <span style="color: #f79646;">
                <br>{!! trans('web/guide.article_series.title_photo') !!}
            </span>
        </strong>
        <br>
        <a href="#">
            <img
                height="90"
                alt="TW_Series-Howto"
                width="180"
                vertical-align="text-top"
                src="/assets/images/guide/article-series-tw-3.jpg"
                style="margin-right: 10px; float: left; height: 90px; width: 180px;">
        </a>
        {{ trans('web/guide.article_series.des_photo') }}
        <br><br><br><br>
        <strong>
            <span style="color: #e36c09;"><br>
                {!! trans('web/guide.article_series.title_chat') !!}
            </span>
        </strong><br>

        <a href="#">
            <img
                height="90"
                alt="TW_Series-Howto"
                width="180"
                vertical-align="text-top"
                src="/assets/images/guide/article-series-tw-4.jpg"
                style="margin-right: 10px; float: left;"
            >
        </a>
        {{ trans('web/guide.article_series.des_chat') }}<br><br><br>
        <strong>
            <span style="color: #0070c0;">
                <br>
                {!! trans('web/guide.article_series.title_reporte') !!}
            </span>
        </strong>
        <br>
        <a href="/?tag=Fun-Japan-Reporter-Id">
            <img
                height="90"
                alt="TW_Series-Howto"
                width="180"
                vertical-align="text-top"
                src="/assets/images/guide/article-series-tw-5.jpg"
                style="margin-right: 10px; float: left;"
            >
        </a>
        {{ trans('web/guide.article_series.des_reporte') }}
        <br><br><br><br>
        <strong>
            <span style="color: #00b050;"><br>{!! trans('web/guide.article_series.title_word') !!}</span>
        </strong><br>
        <a href="#">
            <img
                height="90"
                alt="TW_Series-Howto"
                width="180"
                vertical-align="text-top"
                src="/assets/images/guide/article-series-tw-6.jpg"
                style="margin-right: 10px; float: left;">
        </a>{{ trans('web/guide.article_series.des_word') }}<br>
        <br><br><br>

        <strong>
            <span style="color: #ffc000;">
                <br>{!! trans('web/guide.article_series.title_talk') !!}</span>
        </strong><br>
        <a href="#">
            <img
                height="90"
                alt="TW_Series-Howto"
                width="180"
                vertical-align="text-top"
                src="/assets/images/guide/article-series-tw-7.jpg"
                style="margin-right: 10px; float: left;">
        </a>
        {!! trans('web/guide.article_series.des_talk') !!}<br><br>

        <strong>
            <span style="color: #00b050;"><br><br>
                {!! trans('web/guide.article_series.title_member') !!}
            </span>
        </strong><br>
        <a href="#">
            <img
                height="90"
                alt="TW_Series-Howto"
                width="180"
                vertical-align="text-top"
                src="/assets/images/guide/article-series-tw-8.jpg"
                style="margin-right: 10px; float: left;"
            >
        </a>
            {!! trans('web/guide.article_series.des_member') !!}<br><br><br>

    <strong>
        <span style="color: #548dd4;"><br>
            {!! trans('web/guide.article_series.title_test') !!}
        </span></strong><br>
    <a href="#">
        <img
            height="90"
            alt="TW_Series-Howto"
            width="180"
            vertical-align="text-top"
            src="/assets/images/guide/article-series-tw-9.jpg"
            style="margin-right: 10px; float: left; height: 90px; width: 180px;">
    </a>{{ trans('web/guide.article_series.des_test') }}<br><br><br><br>

    <span>
        <strong>
            <span style="color: #8064a2;">
                <strong><br>
                    {!! trans('web/guide.article_series.title_rewards') !!}</strong>
            </span>
        </strong>
    </span><br>
    <a href="#">
        <img
            height="90"
            alt="TW_Series-Howto"
            width="180"
            vertical-align="text-top"
            src="/assets/images/guide/article-series-tw-10.jpg"
            style="margin-right: 10px; float: left;"
        ></a>
    {{ trans('web/guide.article_series.des_rewards') }}<br><br><br><br><br><br>
</div>
@endsection
