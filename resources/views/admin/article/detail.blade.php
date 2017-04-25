@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/article.list_language') . $article->id }}</h2></div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            @foreach ($article->articleLocales as $key => $articleLocale)
                                <li class="@if ($tab == $articleLocale->locale->id) active @endif"><a data-toggle="tab" href="#{{ $articleLocale->locale->name }}">{{ $articleLocale->locale->name }}</a></li>
                            @endforeach
                            @if (count($article->articleLocales) !== count($locales))
                            <li>
                                <a href="{{ action('Admin\ArticlesController@setOtherLanguage', [$article->id]) }}">
                                    <i class="fa fa-plus"></i>
                                    {{ trans('admin/article.button.set_language') }}
                                </a>
                            </li>
                            @endif
                        </ul>
                        <div class="tab-content">
                            @foreach ($article->articleLocales as $key => $articleLocale)
                                <div id="{{ $articleLocale->locale->name }}" class="tab-pane @if ($tab == $articleLocale->locale->id) active @endif">
                                    <div class="panel-body">
                                        <h2>{{ $articleLocale->title }}</h2>
                                        <hr>
                                        {!! $articleLocale->html_content !!}
                                        <hr>
                                        {{ $articleLocale->summary }}
                                        <hr>
                                        <img src="{{ $articleLocale->thumbnail_urls['small_'] }}">
                                        <hr>
                                        <strong>{{ trans('admin/article.category') }}: </strong> {{$articleLocale->article->category->name}}
                                        <hr>
                                        <strong>{{ trans('admin/article.list_tag') }}: </strong>
                                        @foreach ($article->articleTags as $articleTag)
                                            @if ($articleTag->article_locale_id == $articleLocale->id)
                                                {{ $articleTag->tag->status ? '' : '#' . $articleTag->tag->name }}
                                            @endif
                                        @endforeach
                                        <hr>
                                        <strong>{{ trans('admin/article.published_at') }}: </strong>
                                        {{ $articleLocale->published_at }}
                                        <hr>
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
