@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/article.list_article') }}</h2></div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="article-table" data-url="{{action('Admin\ArticlesController@getListArticles')}}">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ trans('admin/article.no') }}</th>
                                    <th class="text-center">{{ trans('admin/article.title') }}</th>
                                    <th class="text-center">{{ trans('admin/article.language') }}</th>
                                    <th class="text-center">{{ trans('admin/article.created_at') }}</th>
                                    <th class="text-center">{{ trans('admin/article.published_at') }}</th>
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
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    <script type="text/javascript">
        var locales = {!! $locales !!};
    </script>
    {!! Html::script('assets/admin/js/article.js') !!}
    {!! Html::script('assets/admin/js/recommend_article.js') !!}
@stop
