@extends('layouts.admin.default')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    {{ trans('admin/recommend_article.label.articles_list', [
                        'locale' => '[' . ($locales[$input['locale_id'] ?? $input['default_locale_id']] ?? null) . ']'
                    ]) }}
                </h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    {{ Form::open([
                        'action' => 'Admin\RecommendedArticlesController@index',
                        'method' => 'GET',
                        'class' => 'articles-list',
                    ]) }}
                        <div class="col-sm-5 m-b-xs">
                            {{ Form::select('locale_id',
                                $locales,
                                $input['locale_id'] ?? $input['default_locale_id'],
                                [
                                    'class' => 'input-sm form-control input-s-sm inline select-locale',
                                ]
                            ) }}
                        </div>
                        <div class="col-sm-4 m-b-xs">
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                {{ Form::text('keyword', $input['keyword'] ?? null, ['class' => 'input-sm form-control', 'placeholder' => 'Search']) }}
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-sm btn-primary">{{ trans('admin/recommend_article.button.go') }}</button>
                                </span>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>#</th>
                                <th>{{ trans('admin/recommend_article.label.title') }}</th>
                                <th>{{ trans('admin/recommend_article.label.published_date') }}</th>
                            </tr>
                        </thead>
                        <tbody class="articles-list">
                            @if ($articlesLocale->count() > 0)
                                @foreach ($articlesLocale as $articleLocale)
                                    <tr data-id="{{ $articleLocale->id }}">
                                        <td>
                                            <input type="checkbox" class="i-checks select-article"
                                                data-article-locale-id="{{ $articleLocale->id }}"
                                                data-url="{{ action('Admin\RecommendedArticlesController@store') }}"
                                                {{ $articleLocale->recommended ? 'checked' : '' }}
                                            >
                                        </td>
                                        <td>{{ $articleLocale->article_id }}</td>
                                        <td>
                                            <a href="{{ action('Web\ArticlesController@show', $articleLocale->article_id) }}" target="_blank">
                                                {{ $articleLocale->title }}
                                            </a>
                                        </td>
                                        <td>{{ $articleLocale->published_at }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td></td>
                                    <td>
                                        <span class="label label-warning">
                                            {{ trans('admin/recommend_article.messages.no_article') }}
                                        </span>
                                    </td>
                                    <td></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="dataTables_paginate paging_simple_numbers">
                        {{ $articlesLocale->appends(Request::except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    {{ trans('admin/recommend_article.label.recommendation_articles_list', [
                        'locale' => '[' . ($locales[$input['locale_id'] ?? $input['default_locale_id']] ?? null) . ']'
                    ]) }}
                </h5>
            </div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/recommend_article.label.title') }}</th>
                                <th>{{ trans('admin/recommend_article.label.published_date') }}</th>
                                <th>{{ trans('admin/recommend_article.button.remove') }}</th>
                            </tr>
                        </thead>
                        <tbody class="recommended-articles-list">
                            @foreach ($recommendedArticles as $key => $articleLocale)
                                @include('admin.recommend_articles._tr_article', ['articleLocale' => $articleLocale])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
    {{ Html::script('assets/admin/js/recommend_article.js') }}
@endsection
