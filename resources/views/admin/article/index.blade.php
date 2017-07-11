@extends('layouts.admin.default')

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading border-left">
        <div class="col-lg-10 page-title">
            <h2><b>{{ trans('admin/article.label.article') }}</b> {{ trans('admin/article.label.list') }}</h2>
            <ol class="breadcrumb">
                <li class="home">
                    <a href="{{ action('Admin\DashboardController@index') }}"><i class="fa fa-home"></i> <b>{{ trans('admin/article.label.home') }}</b></a>
                </li>
                <li class="active breadcrumb-preview">
                    <strong>
                        {{ trans('admin/article.article_list') }}
                    </strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-8">
                                {!! Form::open(['url'=> action('Admin\ArticlesController@index'),
                                    'class' => 'filter-sort-form',
                                    'method' => 'GET', 'onChange' => 'submit()']) !!}
                                    {!! Form::hidden('sortBy', $filter['sortBy'] ?? null) !!}
                                    {!! Form::hidden('perPage', $filter['limit'] ?? null) !!}
                                    {!! Form::hidden('dateFilter', $filter['dateFilter'] ?? null) !!}
                                    {!! Form::hidden('searchColumn', $filter['searchColumn'] ?? null) !!}
                                    <div class="input-group col-md-6">
                                        <div class="input-group-btn">
                                            <button data-toggle="dropdown" class="btn btn-white dropdown-toggle btn-left-radius" type="button" aria-expanded="false">
                                                <b class="selected-search-by">
                                                    {{ isset($filter['searchColumn']) ? trans('admin/article.label.' . $filter['searchColumn']) : trans('admin/article.label.client_id') }}
                                                </b>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu search-by">
                                                <li><a href="javascript:;" data-column="client_id">{{ trans('admin/article.label.client_id') }}</a></li>
                                                <li><a href="javascript:;" data-column="article_id">{{ trans('admin/article.label.article_id') }}</a></li>
                                                <li><a href="javascript:;" data-column="title">{{ trans('admin/article.label.title') }}</a></li>
                                            </ul>
                                        </div>
                                        {!! Form::text('keyword', $filter['keyword'] ?? null, [
                                            'class' => 'form-control',
                                            'placeholder' => trans('admin/article.label.search'),
                                        ]) !!}
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-primary btn-right-radius"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="col-sm-4">
                                <form class="form-inline pull-right">
                                    <div class="form-group">
                                        {!! Form::text('dateFilter', $filter['dateFilter'] ?? null, [
                                            'class' => 'input-sm form-control date-filter',
                                            'placeholder' => trans('admin/article.placeholder.published_at'),
                                        ]) !!}
                                    </div>
                                    <div class="form-group">
                                        <button type="button" class="btn btn-sm btn-primary date-filter-btn">{{ trans('admin/article.button.filter') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="min-width: 90px;" class="sortable" data-sort-name="client_id">{{ trans('admin/article.label.client_id') }}</th>
                                    <th style="min-width: 90px;" class="sortable" data-sort-name="id">{{ trans('admin/article.label.article_id') }}</th>
                                    <th>{{ trans('admin/article.label.title') }}</th>
                                    <th style="min-width: 150px;">{{ trans('admin/article.label.published_at') }}</th>
                                    <th style="min-width: 195px;">{{ trans('admin/article.label.country') }}</th>
                                    <th style="min-width: 160px;">{{ trans('admin/article.label.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($articles->count() > 0)
                                    @foreach ($articles as $article)
                                        <tr>
                                            <td># {{ $article->client_id }}</td>
                                            <td># {{ $article->id }}</td>
                                            <td>
                                                @if (count($article->arrangedArticleLocales) == 1)
                                                    {{ $article->arrangedArticleLocales[0]->title ?? null }}
                                                @else
                                                    <div class="btn-group">
                                                        <a data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                                                            {{ $article->arrangedArticleLocales[0]->title ?? null }} <span class="caret"></span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            @foreach ($article->arrangedArticleLocales as $key => $articleLocale)
                                                                @if ($key != 0)
                                                                    <li><a href="#">{{ $articleLocale->title }}</a></li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                @if (isset($article->arrangedArticleLocales[0]) && !is_null($article->arrangedArticleLocales[0]->published_at))
                                                    {{ $article->arrangedArticleLocales[0]->published_at->format('d F Y g:i A') }}
                                                @endif
                                            </td>
                                            <td class="label-locale text-uppercase">
                                                @foreach ($locales as $localeId => $localeName)
                                                    @if (in_array($localeId, $article->articleLocales->pluck('locale_id')->toArray()))
                                                        @php
                                                            $statusByLocale = $article->articleLocales->where('locale_id', $localeId)->first()->toArray();
                                                        @endphp
                                                        <span class="label label-custom-{{ array_flip(config('article.status_by_locale'))[$statusByLocale['status_by_locale']] }}">
                                                            {{ $localeName }}
                                                        </span>
                                                    @else
                                                        <span class="label label-custom-no-article">{{ $localeName }}</span>
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <button class="btn btn-info" type="button">
                                                    <i class="fa fa-pencil"></i> {{ trans('admin/article.button.edit') }}
                                                </button>
                                                <button type="button" class="btn btn-danger stop-btn"
                                                        {{ $article->articleLocales->where('status', config('article.status.published'))->count() ? '' : 'disabled' }}
                                                        data-message-confirm="{{ trans('admin/article.messages.confirm_stop') }}"
                                                        data-title="{{ trans('admin/article.messages.confirm_title', ['id' => $article->id]) }}"
                                                        data-yes-confirm="{{ trans('admin/article.button.yes') }}"
                                                        data-no-confirm="{{ trans('admin/article.button.cancel') }}"
                                                        data-url="{{ action('Admin\ArticlesController@stop') }}"
                                                        data-article-id="{{ $article->id }}">
                                                    <i class="fa fa-stop"></i> {{ trans('admin/article.button.stop') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">
                                            <span class="label label-warning">{{ trans('admin/article.label.no_article') }}</span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="ibox-content no-borders">
                            <div class="row pull-right label-explain">
                                <p><span class="label label-custom-published text-uppercase"></span> {{ trans('admin/article.status_by_locale.published') }}</p>
                                <p><span class="label label-custom-schedule text-uppercase"></span> {{ trans('admin/article.status_by_locale.schedule') }}</p>
                                <p><span class="label label-custom-draft text-uppercase"></span> {{ trans('admin/article.status_by_locale.draft') }}</p>
                                <p><span class="label label-custom-stop text-uppercase"></span> {{ trans('admin/article.status_by_locale.stop') }}</p>
                                <p><span class="label label-custom-no-article text-uppercase"></span> {{ trans('admin/article.status_by_locale.no_article') }}</p>
                            </div>
                            <div class="clearfix"></div>
                        </div>

                        <div class="box-footer clearfix pagination-limit">
                            <div class="select-limit">
                                <div class="form-inline">
                                    {{--<div class="form-group">
                                        {{ trans('admin/article.label.showing') }}
                                    </div>
                                    <div class="form-group">
                                        {!! Form::select(
                                            '',
                                            config('limitation.lists'),
                                            $filter['limit'] ?? null,
                                            ['class' => 'form-control', 'id' => 'per-page'])
                                        !!}
                                    </div>
                                    <div class="form-group">
                                        {{ trans('admin/article.label.items') }}
                                    </div>--}}
                                    <div class="form-group pull-right">
                                        {!! method_exists($articles, 'appends') ? $articles->appends(request()->except('page'))->links() : '' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/article.js') !!}
@stop
