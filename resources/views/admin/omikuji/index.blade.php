@extends('layouts.admin.default')

@section('style')
    {!! Html::style('assets/admin/css/omikuji.css') !!}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/omikuji.omikuji_list') }}</h2></div>
            <div class="ibox-content">
                <div class="row">
                    {{ Form::open([
                            'action' => 'Admin\OmikujisController@index',
                            'method' => 'GET',
                            'class' => 'omikuji-list',
                        ])
                    }}
                        <div class="col-sm-5 m-b-xs">
                            {{ Form::select('locale_id', $locales, $localeId ?? '', [
                                    'class' => 'form-control select-locale',
                                ])
                            }}
                        </div>
                    {{ Form::close() }}
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="omikuji-table" data-url="{{action('Admin\OmikujisController@getListOmikujis', ['locale_id' => $localeId])}}">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('admin/omikuji.no') }}</th>
                                <th class="col-sm-3 text-center">{{ trans('admin/omikuji.omikuji_name') }}</th>
                                <th class="col-sm-1 text-center">{{ trans('admin/omikuji.image') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/omikuji.start_time') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/omikuji.end_time') }}</th>
                                <th class="col-sm-1 text-center">{{ trans('admin/omikuji.recover_time') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/omikuji.created_at') }}</th>
                                <th class="col-sm-1 text-center">{{ trans('admin/omikuji.status') }}</th>
                                <th class="text-center">{{ trans('admin/omikuji.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    {{ Form::open(['action' => ['Admin\OmikujisController@index'], 'id' => 'delete-omikuji-form', 'class' => 'form-horizontal', 'files' => true]) }}
                        {{ method_field('DELETE') }}
                    {{ Form::close() }}
                    <div id="delete-confirm" data-confirm-message="{{ trans('admin/omikuji.delete_confirm') }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/omikuji.js') !!}
@stop