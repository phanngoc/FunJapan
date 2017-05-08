@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/category.category_list') }}</h2></div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover" id="category-table">
                    <thead>
                        <tr>
                            <th class="text-center">{{ trans('admin/category.no') }}</th>
                            <th class="text-center">{{ trans('admin/category.category_name') }}</th>
                            <th class="text-center">{{ trans('admin/category.short_name') }}</th>
                            <th class="text-center">{{ trans('admin/category.img') }}</th>
                            <th class="text-center">{{ trans('admin/category.locale') }}</th>
                            <th class="text-center">{{ trans('admin/category.created_at') }}</th>
                            <th class="text-center">{{ trans('admin/category.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $category)
                        <tr>
                            <td class="text-center">{{ $category->id }}</td>
                            <td><a href="{{ action('Admin\CategoriesController@show', [$category->id]) }}">{{ $category->name }}</a></td>
                            <td>{{ $category->short_name }}</td>
                            @if (!empty($category->icon))
                                <td><img src="{{ $category->iconUrls['normal'] }}"></td>
                            @else
                                <td></td>
                            @endif
                            <td>{{ $category->localeName }}</td>
                            <td class="text-center">{{ $category->created_at }}</td>
                            <td class="text-center">
                                <a href="{{ action('Admin\CategoriesController@edit', [$category->id]) }}" class="edit" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-pencil-square-o fa-lg"></i>
                                </a>
                                <a href="#" data-url="{{ action('Admin\CategoriesController@destroy', [$category->id]) }}" data-confirm="{{ trans('admin/category.delete_confirm') . $category->name . ' ?'}}" class="delete" data-toggle="tooltip" title="Delete">
                                    &nbsp;<i class="fa fa-trash-o fa-lg"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach()
                    </tbody>
                </table>
                <div id="delete-confirm" data-confirm-message="{{ trans('admin/category.delete_confirm') }}"></div>
                <div id="url-redirect" data-url="{{ url()->current() }}"></div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/category.js') !!}
@stop