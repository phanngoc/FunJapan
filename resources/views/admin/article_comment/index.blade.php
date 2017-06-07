@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/article_comment.article_comment_list') }}</h2></div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-sm-5 m-b-xs">
                        {{ Form::select('locale_id', $locales, $localeId ?? '', [
                                'class' => 'form-control select-locale',
                                'id' => 'locale_id',
                            ])
                        }}
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table-align table table-striped table-bordered table-hover" id="article-comment-table" data-url="{{action('Admin\ArticleCommentsController@getListArticleComments')}}">
                        <thead>
                            <tr>
                                <th class="col-sm-1 text-center">{{ trans('admin/article_comment.no') }}</th>
                                <th class="col-sm-4 text-center">{{ trans('admin/article_comment.content') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/article_comment.favorite_count') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/article_comment.user_comment') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/article_comment.comment_date') }}</th>
                                <th class="col-sm-1 text-center">{{ trans('admin/article_comment.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    {{ Form::open(['action' => ['Admin\ArticleCommentsController@index'], 'id' => 'delete-article-comment-form', 'class' => 'form-horizontal', 'files' => true]) }}
                        {{ method_field('DELETE') }}
                    {{ Form::close() }}
                    <div id="delete-confirm" data-confirm-message="{{ trans('admin/omikuji.delete_confirm') }}"></div>
                    <div id="actionUrl" data-url="{{ url()->current() }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/article_comment.js') !!}
@stop