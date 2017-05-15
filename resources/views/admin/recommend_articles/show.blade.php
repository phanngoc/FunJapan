@extends('layouts.admin.default')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>
                    {{ trans('admin/recommend_article.label.recommendation_articles_list', [
                        'locale' => $locales[$input['locale_id'] ?? $input['default_locale_id']] ?? null
                    ]) }}
                </h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    {{ Form::open([
                        'action' => 'Admin\RecommendedArticlesController@recommendedLists',
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
                        data-title-confirm="{{ trans('admin/recommend_article.messages.confirm_title') }}"
                        data-message-confirm="{{ trans('admin/recommend_article.messages.confirm_remove') }}"
                        data-yes-confirm="{{ trans('admin/recommend_article.button.yes') }}"
                        data-cancel-confirm="{{ trans('admin/recommend_article.button.cancel') }}"
                        data-url="{{ action('Admin\RecommendedArticlesController@lists', ['locale_id' => $input['locale_id'] ?? $input['default_locale_id']]) }}">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('admin/recommend_article.label.no') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.title') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.author') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.created_at') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.published_at') }}</th>
                                <th class="text-center">{{ trans('admin/recommend_article.label.remove_recommend') }}</th>
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
        var flag = false;
    </script>
    {{ Html::script('assets/admin/js/recommend_article.js') }}
@endsection
