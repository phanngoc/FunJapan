@extends('layouts.admin.default')

@section('style')
    {!! Html::style('assets/admin/css/omikuji.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/omikuji.detail') }}</h2></div>
                <div class="ibox-content">
                    <div class="box-content-omikuji first-padding">
                        <strong class="col-sm-2">{{ trans('admin/omikuji.label.name') }}: </strong>
                        <span class="col-sm-10">{{ $omikuji->name }}  </span>
                    </div>
                    <div class="box-content-omikuji">
                        <strong class="col-sm-2">{{ trans('admin/omikuji.label.description') }}: </strong>
                        <span class="col-sm-10"> {{ $omikuji->description }}  </span>
                    </div>
                    <div class="box-content-omikuji">
                        <strong class="col-sm-2">{{ trans('admin/omikuji.label.image') }}: </strong>
                        <span class="col-sm-10">
                            @if($omikuji->image)
                                <img src="{{ $omikuji->imageUrls['larger'] }}">
                            @endif
                        </span>
                    </div>
                    <div class="box-content-omikuji">
                        <strong class="col-sm-2">{{ trans('admin/omikuji.label.start_time') }}: </strong>
                        <span class="col-sm-10"> {{ $omikuji->start_time }} </span>
                    </div>
                    <div class="box-content-omikuji">
                        <strong class="col-sm-2">{{ trans('admin/omikuji.label.end_time') }}: </strong>
                        <span class="col-sm-10">{{ $omikuji->end_time }} </span>
                    </div>
                    <div class="box-content-omikuji">
                        <strong class="col-sm-2">{{ trans('admin/omikuji.label.locale') }}: </strong>
                        <span class="col-sm-10">{{ $omikuji->localeName }} </span>
                    </div>
                    <div class="box-content-omikuji">
                        <strong class="col-sm-2">{{ trans('admin/omikuji.label.recover_time') }}: </strong>
                        <span class="col-sm-10">{{ $omikuji->recover_time }} </span>
                    </div>
                    <div class="box-content-omikuji">
                        <strong class="col-sm-2">{{ trans('admin/omikuji.label.status') }}: </strong>
                        <span class="col-sm-10">{{ $omikuji->status }} </span>
                    </div>
                    <div class="box-content-omikuji">
                        <strong class="col-sm-2">{{ trans('admin/omikuji.label.created_at') }}: </strong>
                        <span class="col-sm-10">{{ $omikuji->created_at }} </span>
                    </div>
                    <br>

                    <table class="table table-striped table-bordered table-hover" id="detail-omikuji-table" data-url="{{action('Admin\OmikujisController@getListOmikujis')}}">
                        <thead>
                            <tr>
                                <th class="col-sm-1 text-center">{{ trans('admin/omikuji.no') }}</th>
                                <th class="col-sm-5 text-center">{{ trans('admin/omikuji.item_name') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/omikuji.item_rate_weight') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/omikuji.item_point') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/omikuji.item_image') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($omikujiItems))
                            @foreach ($omikujiItems as $key => $omikujiItem)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td>{{ $omikujiItem->name }}</td>
                                    <td class="text-center">{{ $omikujiItem->rate_weight }}</td>
                                    <td class="text-center">{{ $omikujiItem->point }}</td>
                                    <td class="text-center">
                                        @if($omikujiItem->image)
                                            <img src="{{ $omikujiItem->imageUrls['small'] }}">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                        <tr>
                            <td class="text-center" colspan="5">{{ trans('common.no_data') }}</td>
                        </tr>
                        @endif
                    </table>
                    <a href="{{ action('Admin\OmikujisController@edit', [$omikuji->id]) }}" class="btn btn-w-m btn-primary">
                            {{ trans('admin/omikuji.button.edit') }}
                    </a>
                    <a href="{{ action('Admin\OmikujisController@index') }}" class=" btn btn-w-m btn-primary">
                            {{ trans('admin/omikuji.button.cancel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/omikuji.js') !!}
@stop
