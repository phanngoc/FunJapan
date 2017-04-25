@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"></div>
                <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover" id="article-table" data-url="{{action('Admin\ArticlesController@getListArticles')}}">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/article.no') }}</th>
                                <th>{{ trans('admin/article.title') }}</th>
                                <th>{{ trans('admin/article.language') }}</th>
                                <th>{{ trans('admin/article.created_at') }}</th>
                                <th>{{ trans('admin/article.action') }}</th>
                            </tr>
                        </thead>
                        <tfoot>
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
@stop
@section('script')
    <script type="text/javascript">
        var locales = {!! $locales !!};
    </script>
    {!! Html::script('assets/admin/js/article.js') !!}
    {!! Html::script('assets/admin/js/recommend_article.js') !!}
@stop
