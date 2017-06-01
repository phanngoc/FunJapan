@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/popular_category.list_category') }}</h2></div>
            <div class="ibox-content">
                <div class="row">
                    {{ Form::open([
                        'action' => 'Admin\PopularCategoriesController@index',
                        'method' => 'GET',
                        'class' => 'category-list',
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
                    <table width="100%" class="table table-striped table-bordered table-hover" id="series-table" data-url="{{action('Admin\PopularCategoriesController@getListCategories', ['locale_id' => $localeId])}}">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('admin/popular_category.no') }}</th>
                                <th class="text-center">{{ trans('admin/popular_category.image') }}</th>
                                <th class="text-center">{{ trans('admin/popular_category.category') }}</th>
                                <th class="text-center">{{ trans('admin/popular_category.created_at') }}</th>
                                <th class="text-center">{{ trans('admin/popular_category.action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="button-edit" data-message="{{ trans('admin/popular_category.button.edit') }}"></div>
<div id="button-delete" data-message="{{ trans('admin/popular_category.button.delete') }}"></div>
<div id="delete-confirm" data-message="{{ trans('admin/popular_category.delete_confirm') }}"></div>
<div>
    {{ Form::open(['id' => 'deleteForm']) }}
    {{ Form::close() }}
</div>
@stop
@section('script')
    {{ Html::script('assets/admin/js/popular_category.js') }}
@endsection
