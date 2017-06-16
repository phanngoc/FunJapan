@extends('layouts.admin.default')

@section('style')
    {!! Html::style('assets/admin/css/omikuji.css') !!}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h2>{{ trans('admin/omikuji.add_omikuji') }}</h2>
            </div>
            <div class="ibox-content">

                    {{ Form::open(['action' => 'Admin\OmikujisController@store', 'id' => 'create-omikuji-form', 'class' => 'form-horizontal', 'files' => true]) }}
                        <div class="form-group">
                            {{ Form::label(
                                'locale_id',
                                trans('admin/omikuji.label.locale'),
                                ['class' => 'col-sm-2 control-label'])
                            }}
                            <div class="col-sm-10 width30">
                                {{ Form::select(
                                    'locale_id',
                                    $locales,
                                    $locale_select ?? '',
                                    [
                                        'class' => 'form-control',
                                    ])
                                }}
                            </div>
                        </div>

                        @include('admin.elements.omikuji_inputs_form')

                        <div class="form-group required">
                            {{ Form::label(
                                'image',
                                trans('admin/omikuji.label.image'),
                                ['class' => 'col-sm-2 control-label'])
                            }}
                            <div class="col-sm-10 mt5">
                                {{ Form::file('image', ['id' => 'upload-image'])}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <img id="image-preview" src="" width="90" height="90" class="item-hide" title="Preview Image">
                            </div>
                        </div>

                        <br>
                        <table class="table table-striped table-bordered table-hover" id="omikuji-item-table" data-url="{{action('Admin\OmikujisController@getListOmikujis')}}">
                            <thead>
                                <tr>
                                    <th class="col-sm-1 text-center">{{ trans('admin/omikuji.no') }}</th>
                                    <th class="col-sm-4 text-center">{{ trans('admin/omikuji.item_name') }}</th>
                                    <th class="col-sm-2 text-center">{{ trans('admin/omikuji.item_rate_weight') }}</th>
                                    <th class="col-sm-2 text-center">{{ trans('admin/omikuji.item_point') }}</th>
                                    <th class="col-sm-3 text-center">{{ trans('admin/omikuji.item_image') }}</th>
                                    <th class="col-sm-3 text-center">{{ trans('admin/omikuji.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(old('item'))
                                    @foreach (old('item') as $key => $value)
                                        <tr>
                                            <td class="text-center">{{ $key }}</td>
                                            <td>{{ Form::text('item['.$key.']', $value, ['class' => 'form-control']) }}</td>
                                            <td>{{ Form::text('rate_weight['.$key.']', old('rate_weight')[$key], ['class' => 'form-control', 'pattern'=> '[0-9]*']) }}</td>
                                            <td>{{ Form::text('point['.$key.']', old('point')[$key], ['class' => 'form-control', 'pattern'=> '[0-9]*']) }}</td>
                                            <td>
                                                {{ Form::file('item_image['.$key.']', ['class' => 'mt5 upload-image-item', 'data-index' => $key ]) }}
                                                &nbsp; <img class="item-hide" id="{{ 'image-item-preview-'.$key }}" src="" width="32" height="32"  title="Preview Image">
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0)" data-confirm="a" class="delete-new-row" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-trash-o fa-lg"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                <tr>
                                    <td class="text-center"> 1 </td>
                                    <td>{{ Form::text('item[1]', null, ['class' => 'form-control']) }}</td>
                                    <td>{{ Form::text('rate_weight[1]', null, ['class' => 'form-control', 'pattern'=> '[0-9]*']) }}</td>
                                    <td>{{ Form::text('point[1]', null, ['class' => 'form-control', 'pattern'=> '[0-9]*']) }}</td>
                                    <td>
                                        {{ Form::file('item_image[1]', ['class' => 'mt5 upload-image-item', 'data-index' => '1']) }}
                                        &nbsp; <img class="item-hide" id="image-item-preview-1" src="" width="32" height="32"  title="Preview Image">
                                    </td>
                                    <td class="text-center">
                                        <a href="javascript:void(0)" data-confirm="a" class="delete-new-row" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-trash-o fa-lg"></i>
                                                </a>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="form-group">
                            <div class="col-sm-2 ">
                                <a href="javascript:void(0)" class="add-row-create-form"> Add more</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                {{ Form::submit(trans('admin/omikuji.button.save'), ['class' => 'btn btn-primary']) }}
                            </div>
                            <div class="col-sm-3">
                                <a href="#" data-confirm="{{ trans('admin/omikuji.cancel_confirm') }}" data-url="{{ action('Admin\OmikujisController@index') }}" class="cancel btn-primary btn">{{ trans('admin/omikuji.button.cancel') }}</a>
                            </div>
                        </div>
                    {{ Form::close() }}

            </div
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/omikuji.js') !!}
@stop
