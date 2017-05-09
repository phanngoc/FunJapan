@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/category.detail') }}</h2></div>
                <div class="ibox-content">
                    <strong>{{ trans('admin/category.label.name') }}: </strong> {{ $category->name }}
                    <hr>
                    <strong>{{ trans('admin/category.label.short_name') }}: </strong> {{ $category->short_name }}
                    <hr>
                    <strong>{{ trans('admin/category.label.img') }}:</strong>
                        @if($category->icon)
                            <img src="{{ $category->iconUrls['normal'] }}">
                        @endif
                    <hr>
                    <strong>{{ trans('admin/category.label.locale') }}: </strong> {{ $category->localeName }}
                    <hr>
                    <strong>{{ trans('admin/category.label.created_at') }}: </strong> {{ $category->created_at }}
                    <hr>
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
