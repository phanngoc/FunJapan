@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/article.list_article') }}</h2></div>
                <div class="ibox-content">
                    <div class="row">
                        {{ Form::open([
                                'action' => 'Admin\ArticlesController@index',
                                'method' => 'GET',
                                'class' => 'articles-list',
                            ])
                        }}
                            <div class="col-sm-5 m-b-xs">
                                {{ Form::select('locale_id', $locales, $localeId, [
                                        'class' => 'input-sm form-control input-s-sm inline select-locale height-35',
                                    ])
                                }}
                            </div>
                        {{ Form::close() }}
                    </div>
                    <div class="table-responsive">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="article-table" data-url="{{action('Admin\ArticlesController@getListArticles', ['locale_id' => $localeId, 'tag_id' => $tagId])}}">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ trans('admin/article.no') }}</th>
                                    <th class="text-center">{{ trans('admin/article.title') }}</th>
                                    <th class="text-center">{{ trans('admin/article.author') }}</th>
                                    <th class="text-center">{{ trans('admin/article.created_at') }}</th>
                                    <th class="text-center">{{ trans('admin/article.published_at') }}</th>
                                    <th class="text-center">{{ trans('admin/article.article_type') }}</th>
                                    <th class="text-center">{{ trans('admin/article.is_top_article') }}</th>
                                    <th class="text-center">{{ trans('admin/article.hide_alway') }}</th>
                                    <th class="text-center">{{ trans('admin/article.is_member_only') }}</th>
                                    <th class="text-center">{{ trans('admin/article.action') }}</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="button-edit" data-message="{{ trans('admin/article.button.edit') }}"></div>
    <div id="button-delete" data-message="{{ trans('admin/article.button.delete') }}"></div>
@stop
@section('script')
    <script type="text/javascript">
        var localeId = {!! $localeId !!};
        var articleTypes = {!! $types !!};
    </script>
    {!! Html::script('assets/admin/js/article.js') !!}
@stop
