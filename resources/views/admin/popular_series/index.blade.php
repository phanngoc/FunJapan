@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/popular_series.list_series') }}</h2></div>
            <div class="ibox-content">
                <div class="row">
                    {{ Form::open([
                        'action' => 'Admin\PopularSeriesController@index',
                        'method' => 'GET',
                        'class' => 'series-list',
                        ])
                    }}
                    <div class="col-sm-5 m-b-xs">
                        {{ Form::select('locale', $locales, $localeId, [
                            'class' => 'input-sm form-control input-s-sm inline select-locale height-35',
                            ])
                        }}
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="series-table" data-url="{{action('Admin\PopularSeriesController@getListSeries', ['locale_id' => $localeId])}}">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('admin/popular_series.no') }}</th>
                                <th class="text-center">{{ trans('admin/popular_series.summary') }}</th>
                                <th class="text-center">{{ trans('admin/popular_series.image') }}</th>
                                <th class="text-center">{{ trans('admin/popular_series.link') }}</th>
                                <th class="text-center">{{ trans('admin/popular_series.type') }}</th>
                                <th class="text-center">{{ trans('admin/popular_series.created_at') }}</th>
                                <th class="text-center">{{ trans('admin/popular_series.action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="button-edit" data-message="{{ trans('admin/popular_series.button.edit') }}"></div>
<div id="button-delete" data-message="{{ trans('admin/popular_series.button.delete') }}"></div>
<div id="delete-confirm" data-message="{{ trans('admin/popular_series.delete_confirm') }}"></div>
<div>
    {{ Form::open(['id' => 'deleteForm']) }}
    {{ Form::close() }}
</div>
@stop
@section('script')
    {{ Html::script('assets/admin/js/popular_series.js') }}
@endsection
