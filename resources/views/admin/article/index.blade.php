@extends('layouts.admin.default')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/article.list_article') }}</h2></div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-sm-8">
                            {!! Form::open(['url'=> request()->fullUrl(),
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
                                                {{ isset($filter['searchColumn']) ? trans('admin/article.label.' . $filter['searchColumn']) : trans('admin/article.label.article_id') }}
                                            </b>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu search-by">
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
                                    <input type="text" name="dateFilter" placeholder="Date time" class="input-sm form-control date-filter datetime-picker">
                                </div>
                                <div class="form-group">
                                    <button type="button" class="btn btn-sm btn-primary">{{ trans('admin/article.button.filter') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <hr>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
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
                                        <td># {{ $article->id }}</td>
                                        <td>
                                            @if (count($article->arrangedArticleLocales) == 1)
                                                {{ $article->arrangedArticleLocales[0]->title }}
                                            @else
                                                <div class="btn-group">
                                                    <a data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
                                                        {{ $article->arrangedArticleLocales[0]->title }} <span class="caret"></span>
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
                                            @if (!is_null($article->arrangedArticleLocales[0]->published_at))
                                                {{ $article->arrangedArticleLocales[0]->published_at->format('d F Y g:i A') }}
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($locales as $localeId => $localeName)
                                                @if (in_array($localeId, $article->articleLocales->pluck('locale_id')->toArray()))
                                                    @php
                                                        $statusByLocale = $article->articleLocales->where('locale_id', $localeId)->first()->toArray();
                                                    @endphp
                                                    <span class="label text-uppercase
                                                        label-custom-{{ array_flip(config('article.status_by_locale'))[$statusByLocale['status_by_locale']] }}">
                                                        {{ $localeName }}
                                                    </span>
                                                @else
                                                    <span class="label label-custom-no-article text-uppercase">{{ $localeName }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <button class="btn btn-info" type="button">
                                                <i class="fa fa-pencil"></i> {{ trans('admin/article.button.edit') }}
                                            </button>
                                            <button type="button" class="btn btn-danger">
                                                <i class="fa fa-stop"></i> {{ trans('admin/article.button.stop') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">
                                        <span class="label label-warning">{{ trans('admin/article.label.no_article') }}</span>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div class="box-footer clearfix pagination-limit">
                        <div class="select-limit">
                            <div class="form-inline">
                                <div class="form-group">
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
                                </div>
                                <div class="form-group pull-right">
                                    {!! method_exists($articles, 'appends') ? $articles->appends(request()->except('page'))->links() : '' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content no-borders">
                        <div class="row pull-right label-explain">
                            <p><span class="label label-custom-schedule text-uppercase">TH</span> {{ trans('admin/article.status_by_locale.schedule') }}</p>
                            <p><span class="label label-custom-stop text-uppercase">TH</span> {{ trans('admin/article.status_by_locale.stop') }}</p>
                            <p><span class="label label-custom-published text-uppercase">TH</span> {{ trans('admin/article.status_by_locale.published') }}</p>
                            <p><span class="label label-custom-no-article text-uppercase">TH</span> {{ trans('admin/article.status_by_locale.no_article') }}</p>
                            <p><span class="label label-custom-draft text-uppercase">TH</span> {{ trans('admin/article.status_by_locale.draft') }}</p>
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
