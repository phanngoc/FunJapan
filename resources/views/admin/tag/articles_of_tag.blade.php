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
                                <th class="text-center">{{ trans('admin/article.no') }}</th>
                                <th class="text-center">{{ trans('admin/article.title') }}</th>
                                <th class="text-center">{{ trans('admin/article.language') }}</th>
                                <th class="text-center">{{ trans('admin/article.created_at') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articlesOfTag as $key => $article)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td><a href="{{ action('Admin\ArticlesController@show',
                                                [$article->article_id, 'locale' => $article->locale->id]) }}">
                                            {{ $article->title }}
                                        </a>
                                    </td>
                                    <td>{{ $article->locale->name }}</td>
                                    <td class="text-center">{{ $article->created_at }}</td>
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
