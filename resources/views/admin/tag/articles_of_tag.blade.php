@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/article.list_article_of_tag') . $tag->name }}</h2></div>
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
                            @foreach ($articlesOfTag as $article)
                                <tr>
                                    <td>{{ $article->id }}</td>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ $article->locale->name }}</td>
                                    <td>{{ $article->created_at }}</td>
                                    <td>
                                        <a href="{{ action('Admin\ArticlesController@show',
                                                [$article->article_id, 'locale' => $article->locale->id]) }}">
                                            {{ trans('admin/article.detail') }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="">
                        {{ $articlesOfTag->appends(Request::except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
