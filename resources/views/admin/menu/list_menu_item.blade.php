@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h2>{{ trans('admin/menu.list_sub_menu') . $menu->name }}
                    <a class="btn btn-primary pull-right" href="{{ action('Admin\MenusController@createSubMenu', $menu->id) }}">{{ trans('admin/menu.add_sub_menu') }}</a>
                </h2>
            </div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">{{ trans('admin/menu.order') }}</th>
                            <th class="text-center">{{ trans('admin/menu.label.name') }}</th>
                            <th class="text-center">{{ trans('admin/menu.label.description') }}</th>
                            <th class="text-center">{{ trans('admin/menu.label.link') }}</th>
                            <th class="text-center">{{ trans('admin/menu.created_at') }}</th>
                            <th class="text-center">{{ trans('admin/menu.action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @foreach ($menuItems as $key => $menu)
                            <tr id="order_{{ $menu->id }}">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>
                                    <a href="{{ action('Admin\MenusController@show', $menu->id) }}">
                                        {{ $menu->name }}
                                    </a>
                                </td>
                                <td>{{ $menu->description }}</td>
                                <td>{{ $menu->link }}</td>
                                <td class="text-center">{{ $menu->created_at }}</td>
                                <td class="text-center">
                                    <a data-placement="top" data-toggle="tooltip" title="{{ trans('admin/menu.menu_edit') }}" href="{{ action('Admin\MenusController@editSubMenu', $menu->id) }}">
                                        <span class="fa fa-pencil-square-o fa fa-lg"></span>
                                    </a>
                                    <a data-placement="top" data-toggle="tooltip" title="{{ trans('admin/menu.delete_menu') }}" href="#" class="delete" data-url="{{ action('Admin\MenusController@destroy', $menu->id) }}">
                                        <span class="fa fa-trash-o fa fa-lg"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div>
                    <button data-url="{{ action('Admin\MenusController@updateOrder') }}" id="update-order" class="btn btn-primary hidden">
                        {{ trans('admin/menu.update_position') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
{{ Form::open(['id' => 'delete-menu-form']) }}
    {{ method_field('DELETE') }}
{{ Form::close() }}

{{ Form::open(['id' => 'update-order-form']) }}
    {{ method_field('POST') }}
{{ Form::close() }}
<div id="delete-confirm" data-message="{{ trans('admin/menu.delete_confirm') }}"></div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/menu.js') !!}
@stop