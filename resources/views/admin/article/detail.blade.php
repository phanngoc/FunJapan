@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h2>
                        {{ trans('admin/article.list_language') }}
                        <a href="{{ action('Admin\ArticlesController@index') }}" type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true" class="fa fa-times"></span>
                        </a>
                    </h2>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <div class="tab-content">
                            <h3>{{ trans('admin/article.title_global') }}</h3>
                            <hr>
                            <strong>{{ trans('admin/article.category') }}: </strong>
                            {{ $article->category->name }}
                            <hr>
                            <strong>{{ trans('admin/article.label.type') }}:</strong>
                            {{ $types[$article->type] ?? null }}
                            @if ($article->type == config('article.type.photo'))
                            <hr>
                                <strong>{{ trans('admin/article.label.auto_approve_photo') }}:</strong>
                                {{ $article->auto_approve_photo ? trans('admin/article.label.yes') : trans('admin/article.label.no') }}
                            @endif
                            <hr>
                            <a href="{{ action('Admin\ArticlesController@editGlobalInfo',
                                [$article->id, 'locale' => $article->articleLocales->first()->locale_id]) }}" class="btn btn-w-m btn-primary">
                                {{ trans('admin/article.button.edit') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            @foreach ($article->articleLocales as $key => $articleLocale)
                                <li class="@if ($tab == $articleLocale->locale->id) active @endif"><a data-toggle="tab" href="#{{ $articleLocale->locale->name }}">{{ $articleLocale->locale->name }}</a></li>
                            @endforeach
                            @if (count($article->articleLocales) !== count($locales))
                            <li class="dropdown">
                                    <a id="set-language" data-target="#" href="http://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-plus"></i>
                                        {{ trans('admin/article.button.set_language') }}
                                    </a>
                                    <ul class="dropdown-menu set-language" aria-labelledby="set-language">
                                        <li>
                                            <a href="{{ action('Admin\ArticlesController@setOtherLanguage', [$article->id]) }}">{{ trans('admin/article.button.create_new') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ action('Admin\ArticlesController@setOtherLanguage', [$article->id, 'clone' => 1]) }}">{{ trans('admin/article.button.clone') }}</a>
                                        </li>
                                    </ul>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content">
                            @foreach ($article->articleLocales as $key => $articleLocale)
                                <div id="{{ $articleLocale->locale->name }}" class="tab-pane @if ($tab == $articleLocale->locale->id) active @endif">
                                    <div class="panel-body">
                                        <h2>{{ $articleLocale->title }}</h2>
                                        <hr>
                                        <div class="article-content">
                                            {!! $articleLocale->html_content !!}
                                        </div>
                                        <hr>
                                        {{ $articleLocale->summary }}
                                        <hr>
                                        <img src="{{ $articleLocale->thumbnail_urls['small'] }}">
                                        <hr>
                                        <strong>{{ trans('admin/article.list_tag') }}: </strong>
                                        @foreach ($article->articleTags as $articleTag)
                                            @if ($articleTag->article_locale_id == $articleLocale->id)
                                                {{ $articleTag->tag->status ? '' : '#' . $articleTag->tag->name }}
                                            @endif
                                        @endforeach
                                        <hr>
                                        <strong>{{ trans('admin/article.label.is_top') }}:</strong>
                                        {{ $articleLocale->is_top_article ? trans('admin/article.label.yes') : trans('admin/article.label.no') }}
                                        <hr>
                                        <strong>{{ trans('admin/article.published_at') }}: </strong>
                                        {{ $articleLocale->published_at }}
                                        <hr>
                                        <strong>{{ trans('admin/article.label.is_alway_hide') }}:</strong>
                                        {{ $articleLocale->hide_always ? trans('admin/article.label.yes') : trans('admin/article.label.no') }}
                                        <hr>
                                        <strong>{{ trans('admin/article.label.is_member_only') }}:</strong>
                                        {{ $articleLocale->is_member_only ? trans('admin/article.label.yes') : trans('admin/article.label.no') }}
                                        <hr>
                                        @if ($articleLocale->start_campaign || $articleLocale->end_campaign)
                                            <strong>{{ trans('admin/article.label.start_campaign') }}: </strong>
                                            {{ $articleLocale->start_campaign ?? '-' }}
                                            <hr>
                                            <strong>{{ trans('admin/article.label.end_campaign') }}: </strong>
                                            {{ $articleLocale->end_campaign ?? '-' }}
                                            <hr>
                                        @endif
                                        <a href="{{ action('Admin\ArticlesController@edit',
                                            [$article->id, 'locale' => $articleLocale->locale_id]) }}" class="btn btn-w-m btn-primary">
                                            {{ trans('admin/article.button.edit') }}
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
