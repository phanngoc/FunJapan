@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover" id="article-table">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/article.no') }}</th>
                                <th>{{ trans('admin/article.title') }}</th>
                                <th>{{ trans('admin/article.language') }}</th>
                                <th>{{ trans('admin/article.created_at') }}</th>
                                <th>{{ trans('admin/article.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articleLocales as $articleLocale)
                                <tr>
                                    <td>{{ $articleLocale->id }}</td>
                                    <td>{{ $articleLocale->title }}</td>
                                    <td>{{ $articleLocale->locale->name }}</td>
                                    <td>{{ $articleLocale->article->created_at }}</td>
                                    <td>
                                        <a href="{{ action('Admin\ArticlesController@show', [$articleLocale->article_id]) }}">{{ trans('admin/article.detail') }}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="">
                        {{ $articleLocales->appends(Request::except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop