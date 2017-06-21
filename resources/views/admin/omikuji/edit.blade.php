@extends('layouts.admin.default')

@section('style')
    {!! Html::style('assets/admin/css/omikuji.css') !!}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h2>{{ trans('admin/omikuji.edit_omikuji') }}</h2>
            </div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\OmikujisController@update', $omikuji->id], 'id' => 'edit-omikuji-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ method_field('PUT') }}
                    @include('admin.elements.omikuji_inputs_form')
                    <div class="form-group">
                        {{ Form::label(
                            'image',
                            trans('admin/omikuji.label.image'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt5">
                            {{ Form::file('image', ['id' => 'upload-image'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <img class="image-preview" id="image-preview" src="{{ $omikuji->imageUrls['larger'] ?? '' }}" width="90" height="90" title="Preview Logo">
                        </div>
                    </div>

                    {{ Form::hidden('deleteList', old('deleteList') ?? '' , ['id' => 'deleteList']) }}
                    {{ Form::hidden('omikujiId', $omikuji->id) }}

                    <br>
                    <table class="table table-striped table-bordered table-hover" id="omikuji-item-table" ">
                        <thead>
                            <tr>
                                <th class="text-center">{{ trans('admin/omikuji.no') }}</th>
                                <th class="col-sm-4 text-center">{{ trans('admin/omikuji.item_name') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/omikuji.item_rate_weight') }}</th>
                                <th class="col-sm-2 text-center">{{ trans('admin/omikuji.item_point') }}</th>
                                <th class="col-sm-3 text-center">{{ trans('admin/omikuji.item_image') }}</th>
                                <th class="text-center">{{ trans('admin/omikuji.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if(old('item'))
                                <?php
                                    $countOld = count(old('item'));
                                ?>
                                @for ($i = 1; $i <= $countOld; $i++)
                                    <tr>
                                        <td class="text-center">{{ $i }}</td>
                                        <td>{{ Form::text('item['.$i.']', old('item')[$i], ['class' => 'form-control']) }}</td>
                                        <td>{{ Form::text('rate_weight['.$i.']', old('rate_weight')[$i], ['class' => 'form-control', 'pattern'=> '[0-9]*']) }}</td>
                                        <td>{{ Form::text('point['.$i.']', old('point')[$i], ['class' => 'form-control', 'pattern'=> '[0-9]*']) }}</td>
                                        <td>{{ Form::file('item_image['.$i.']', ['class' => 'mt5 upload-image-item', 'data-index' => $i]) }}
                                            &nbsp; <img class="item-hide" id="image-item-preview-{{ $i }}" src="" width="32" height="32"  title="Preview Image">
                                        </td>
                                        <td class="text-center">
                                            @if (old('omikujiItem_id')[$i])
                                                    <a href="javascript:void(0)" data-confirm="{{ trans('admin/omikuji.delete_confirm', ['name' => old('item')[$i]]) }}" class="delete-omikuji-item" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-trash-o fa-lg"></i>
                                                </a>
                                                {{ Form::hidden('omikujiItem_id['.$i.']', old('omikujiItem_id')[$i]) }}
                                            @else
                                                <a href="javascript:void(0)" class="delete-new-row" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-trash-o fa-lg"></i>
                                                </a>
                                                {{ Form::hidden('omikujiItem_id['.$i.']', '') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endfor
                            @else
                                @foreach($omikujiItems as $key => $omikujiItem)
                                    <tr>
                                        <td class="text-center">{{ ++$key }}</td>
                                        <td>{{ Form::text('item['.$key.']', $omikujiItem->name, ['class' => 'form-control']) }}</td>
                                        <td>{{ Form::text('rate_weight['.$key.']', $omikujiItem->rate_weight, ['class' => 'form-control', 'pattern'=> '[0-9]*']) }}</td>
                                        <td>{{ Form::text('point['.$key.']', $omikujiItem->point, ['class' => 'form-control', 'pattern'=> '[0-9]*']) }}</td>
                                        <td>{{ Form::file('item_image['.$key.']', ['class' => 'mt5 upload-image-item', 'data-index' => $key]) }}
                                            &nbsp; <img class="" id="image-item-preview-{{ $key }}" src="{{ $omikujiItem->imageUrls['small'] ?? '' }}" width="32" height="32"  title="Preview Image">
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" data-confirm="{{ trans('admin/omikuji.delete_confirm', ['name' => $omikujiItem->name]) }}" class="delete-omikuji-item" data-toggle="tooltip" title="Delete">
                                                <i class="fa fa-trash-o fa-lg"></i>
                                            </a>
                                            {{ Form::hidden('omikujiItem_id['.$key.']', $omikujiItem->id) }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <div class="form-group">
                        <div class="col-sm-2 ">
                            <a href="javascript:void(0)" class="add-row-edit-form"> Add more</a>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/omikuji.button.update'), ['class' => 'btn btn-primary']) }}
                        </div>
                        <div class="col-sm-3">
                            <a href="javascript:void(0)" data-confirm="{{ trans('admin/omikuji.cancel_confirm') }}" data-url="{{ action('Admin\OmikujisController@index') }}" class="cancel btn-primary btn">{{ trans('admin/omikuji.button.cancel') }}</a>
                        </div>
                    </div>
                {{ Form::close() }}
                {{ Form::open(['action' => ['Admin\OmikujisController@update', $omikuji->id], 'id' => 'delete-omikuji-item-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ method_field('DELETE') }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/omikuji.js') !!}
@stop