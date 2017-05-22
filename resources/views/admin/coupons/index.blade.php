@extends('layouts.admin.default')

@section('style')
    {!! Html::style('assets/admin/css/coupon.css') !!}
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/coupon.coupon_list') }}</h2></div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover" id="coupon-table" data-url="{{action('Admin\CouponsController@getListCoupons')}}">
                    <thead>
                        <tr>
                            <th class="text-center">{{ trans('admin/coupon.label.no') }}</th>
                            <th class="col-lg-2 text-center">{{ trans('admin/coupon.label.name') }}</th>
                            <th class="col-lg-3 text-center">{{ trans('admin/coupon.label.get_from') }}</th>
                            <th class="col-lg-3 text-center">{{ trans('admin/coupon.label.get_to') }}</th>
                            <th class="col-lg-2 text-center">{{ trans('admin/coupon.label.max_coupon') }}</th>
                            <th class="col-lg-1 text-center">{{ trans('admin/coupon.label.required_point') }}</th>
                            <th class="col-lg-1 text-center">{{ trans('admin/coupon.label.status') }}</th>
                            <th class="text-center">{{ trans('admin/coupon.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/coupon.js') !!}
@stop
