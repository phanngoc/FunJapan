@extends('layouts.admin.default')

@section('style')
{!! Html::style('assets/admin/css/coupon.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/coupon.title_show') }}</h2></div>
                <div class="ibox-content">
                    <div class="box-content-category first-padding">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.name') }}: </strong>
                        <span class="col-sm-10" >{{ $coupon->name }} &nbsp; </span>
                    </div>
                    <div class="box-content-category coupon-description">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.description') }}:</strong>
                        <span class="col-sm-10" >{!! $coupon->html_description !!} &nbsp;</span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.time_get_coupon') }}:</strong>
                        <span class="col-sm-10" >{{ $coupon->can_get_from . '&nbsp; &nbsp; ~&nbsp; &nbsp; ' . $coupon->can_use_to }} &nbsp;</span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.time_use_coupon') }}:</strong>
                        <span class="col-sm-10" >{{ $coupon->can_use_from . '&nbsp; &nbsp; ~&nbsp; &nbsp; ' . $coupon->can_use_to }} &nbsp;</span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.max_coupon') }}:</strong>
                        <span class="col-sm-10" >{{ $coupon->max_coupon }} &nbsp;</span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.max_coupon_per_user') }}:</strong>
                        <span class="col-sm-10" >{{ $coupon->max_coupon_per_user }} &nbsp;</span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.required_point') }}:</strong>
                        <span class="col-sm-10" >{{ $coupon->required_point }} &nbsp;</span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.pin') }}:</strong>
                        <span class="col-sm-10" >{{ $coupon->pin }} &nbsp;</span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.pin_code') }}:</strong>
                        <span class="col-sm-10" >{{ $coupon->pin_code }} &nbsp;</span>
                    </div>

                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.created_at') }}:</strong>
                        <span class="col-sm-10" >{{ $coupon->created_at }} &nbsp;</span>
                    </div>

                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.status') }}:</strong>
                        <span class="col-sm-10" >{{ $coupon->status }} &nbsp;</span>
                    </div>

                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/coupon.label.image') }}:</strong>
                        <span class="col-sm-10" >
                            @if($coupon->image)
                                <img src="{{ $coupon->imageAll['original'] }}" class="image-preview">
                            @endif
                            &nbsp;
                        </span>
                    </div>

                    <br>
                    <a href="{{ action('Admin\CouponsController@edit', [$coupon->id]) }}" class="btn btn-w-m btn-primary">
                        {{ trans('admin/coupon.button.edit') }}
                    </a>
                    <a href="{{ action('Admin\CouponsController@index') }}" class="btn btn-w-m btn-primary">
                        {{ trans('admin/coupon.button.cancel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
