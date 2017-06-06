@extends('layouts.admin.default')

@section('style')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h2>{{ trans('admin/coupon.edit_coupon') }}</h2>
            </div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\CouponsController@update', $coupon->id], 'id' => 'create-coupon-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ method_field('PUT') }}
                    <div class="form-group required">
                        {{ Form::label(
                            'name',
                            trans('admin/coupon.label.name'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-3">
                            {{ Form::text('name', old('name', $coupon->name), ['class' => 'form-control', 'required' => 'required']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'description',
                            trans('admin/coupon.label.description'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt6">
                            {{ Form::textarea('description', old('description', $coupon->description), ['class' => 'form-control', 'id' => 'description']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'max_coupon',
                            trans('admin/coupon.label.max_coupon'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt6">
                            {{ Form::number('max_coupon', old('max_coupon', $coupon->max_coupon), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'max_coupon_per_user',
                            trans('admin/coupon.label.max_coupon_per_user'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt6">
                            {{ Form::number('max_coupon_per_user', old('max_coupon_per_user', $coupon->max_coupon_per_user), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'required_point',
                            trans('admin/coupon.label.required_point'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt6">
                            {{ Form::number('required_point', old('required_point', $coupon->required_point), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'pin',
                            trans('admin/coupon.label.pin'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt6">
                            {{ Form::text('pin', old('pin', $coupon->pin), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'pin_code',
                            trans('admin/coupon.label.pin_code'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt6">
                            {{ Form::text('pin_code', old('pin_code', $coupon->pin_code), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="date-time-get-coupon">
                        <div class="form-group required">
                            {{ Form::label(
                                'time_get_coupon',
                                trans('admin/coupon.label.time_get_coupon'),
                                [
                                    'class' => 'col-sm-2 control-label',
                                ]
                            ) }}
                            <div class="col-sm-5 width30">
                                {{ Form::text(
                                    'can_get_from',
                                    old('can_get_from', $coupon->can_get_from),
                                    ['class' => 'form-control datetime-picker', 'required' => 'required'])
                                }}
                            </div>
                            <div class="col-sm-5 width30">
                                {{ Form::text(
                                    'can_get_to',
                                    old('can_get_to', $coupon->can_get_to),
                                    ['class' => 'form-control datetime-picker', 'required' => 'required'])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="date-time-use-coupon">
                        <div class="form-group">
                            {{ Form::label(
                                'time_use_coupon',
                                trans('admin/coupon.label.time_use_coupon'),
                                [
                                    'class' => 'col-sm-2 control-label',
                                ]
                            ) }}
                            <div class="col-sm-5 width30">
                                {{ Form::text(
                                    'can_use_from',
                                    old('can_use_from', $coupon->can_use_from),
                                    ['class' => 'form-control datetime-picker'])
                                }}
                            </div>
                            <div class="col-sm-5 width30">
                                {{ Form::text(
                                    'can_use_to',
                                    old('can_use_to', $coupon->can_use_to),
                                    ['class' => 'form-control datetime-picker'])
                                }}
                            </div>
                        </div>
                    </div>

                    <div class="form-group required">
                        {{ Form::label(
                            'image',
                            trans('admin/coupon.label.image'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt6">
                            {{ Form::file('image', null, ['class' => 'form-control'])}}
                        </div>
                    </div>

                     <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <img id="image-preview" src="{{ $coupon->image_all['original'] }}" width="90" height="90" class="item-hide" title="Preview Image">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/coupon.button.update'), ['class' => 'btn btn-primary']) }}
                        </div>
                        <div class="col-sm-3">
                            <a id="btn-cancel" href="javascript:" data-confirm="{{ trans('admin/coupon.cancel_edit_page') }}" data-url="{{ action('Admin\CouponsController@index') }}" class="cancel btn-primary btn">{{ trans('admin/coupon.button.cancel') }}</a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script type="text/javascript">
        var dataMimes="{{ config('images.validate.coupon_image.mimes') }}";
        var dataMessageMineError="{{ trans('admin/coupon.image_message_mines',['type' => config('images.validate.coupon_image.mimes')]) }}";
        var dataMessageSizeError="{{ trans('admin/coupon.image_message_size', ['size' => config('images.validate.coupon_image.max_size')]) }}";
        var dataMaxSize="{{ config('images.validate.coupon_image.max_size') }}";
    </script>
    {!! Html::script('assets/admin/js/coupon.js') !!}
@stop