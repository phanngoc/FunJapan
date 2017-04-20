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
                                <th>{{ trans('admin/tag.no') }}</th>
                                <th>{{ trans('admin/tag.title') }}</th>
                                <th>{{ trans('admin/tag.language') }}</th>
                                <th>{{ trans('admin/tag.created_at') }}</th>
                                <th>{{ trans('admin/tag.action') }}</th>
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