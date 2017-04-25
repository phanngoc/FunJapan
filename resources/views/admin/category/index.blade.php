@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"></div>
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
                            <td class="text-center">{{$category->id}}</td>
                            <td>{{$category->name}}</td>
                            <td>{{$category->short_name}}</td>
                            @if (!empty($category->photo))
                                <td><img src="{{asset($category->photo)}}"></td>
                            @else
                                <td></td>
                            @endif                            
                            <td>{{$category->locale}}</td>
                            <td class="text-center">{{$category->created_at}}</td>
                            <td class="text-center">
                                <a href="#" class="detail"><i class="fa fa-plus-square-o fa-lg"></i></a>
                                <a href="#" class="edit"><i class="fa fa-pencil-square-o fa-lg"></i></a>
                                <a href="#" class="delete"><i class="fa fa-trash-o fa-lg"></i></a>
                            </td>
                        </tr>
                    @endforeach()
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/category.js') !!}
@stop