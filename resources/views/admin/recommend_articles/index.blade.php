@extends('layouts.admin.default')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    {{ trans('admin/recommend_article.label.articles_list', [
                        'locale' => $locales[$input['locale_id'] ?? $input['default_locale_id']] ?? null
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
                    {{ Form::close() }}
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="article-table"
                        data-url-set-recommend="{{ action('Admin\RecommendedArticlesController@store') }}"
                        data-url="{{ action('Admin\ArticlesController@getListArticles', [
                            'locale_id' => $input['locale_id'] ?? $input['default_locale_id'],
                            'list_set_recommend' => true,
                        ]) }}">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('admin/recommend_article.label.no') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.title') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.author') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.created_at') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.published_at') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.set_recommend') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
    <script type="text/javascript">
        var flag = true;
    </script>
    {{ Html::script('assets/admin/js/recommend_article.js') }}
@endsection
