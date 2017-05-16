@extends('layouts.admin.default')

@section('style')
{!! Html::style('assets/admin/css/category.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/category.detail') }}</h2></div>
                <div class="ibox-content">
                    <div class="box-content-category first-padding">
                        <strong class="col-sm-2">{{ trans('admin/category.label.name') }}: </strong>
                        <span class="col-sm-10" >{{ $category->name }} &nbsp; </span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/category.label.short_name') }}:</strong>
                        <span class="col-sm-10" >{{ $category->short_name }} &nbsp;</span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/category.label.img') }}:</strong>
                        <span class="col-sm-10" >
                            @if($category->icon)
                                <img src="{{ $category->iconUrls['normal'] }}">
                            @endif
                            &nbsp;
                        </span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/category.label.locale') }}: </strong>
                        <span class="col-sm-10" >{{ $category->localeName }} &nbsp; </span>
                    </div>
                    <div class="box-content-category">
                        <strong class="col-sm-2">{{ trans('admin/category.label.created_at') }}: </strong>
                        <span class="col-sm-10" >{{ $category->created_at }} &nbsp;</span>
                    </div>
                    <br>
                    <a href="{{ action('Admin\CategoriesController@edit', [$category->id]) }}" class="btn btn-w-m btn-primary">
                            {{ trans('admin/category.button.edit') }}
                    </a>
                    <a href="{{ action('Admin\CategoriesController@index') }}" class="btn btn-w-m btn-primary">
                            {{ trans('admin/category.button.cancel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
