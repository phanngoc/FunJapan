@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/menu.menu_list') }}</h2></div>
            <div class="ibox-content">
                <div class="row">
                    {{ Form::open([
                        'action' => 'Admin\MenusController@index',
                        'method' => 'GET',
                        'class' => 'menus-list',
                    ]) }}
                        <div class="col-sm-5 m-b-xs">
                            {{ Form::select('locale',
                                $locales,
                                $localeId,
                                [
                                    'class' => 'input-sm form-control input-s-sm inline select-locale',
                                ]
                            ) }}
                        </div>
                    {{ Form::close() }}
                </div>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">{{ trans('admin/menu.order') }}</th>
                            <th class="text-center">{{ trans('admin/menu.label.name') }}</th>
                            <th class="text-center">{{ trans('admin/menu.label.description') }}</th>
                            <th class="text-center">{{ trans('admin/menu.label.type') }}</th>
                            <th class="text-center">{{ trans('admin/menu.label.icon') }}</th>
                            <th class="text-center">{{ trans('admin/menu.label.icon_class') }}</th>
                            <th class="text-center">{{ trans('admin/menu.created_at') }}</th>
                            <th class="text-center">{{ trans('admin/menu.action') }}</th>
                        </tr>
                    </thead>
                    <tbody id="sortable">
                        @foreach ($menus as $key => $menu)
                            <tr id="order_{{ $menu->id }}">
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    <a href="{{ action('Admin\MenusController@show', $menu->id) }}">
                                        {{ $menu->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $menu->description }}
                                </td>
                                <td>{{ $menu->type }}</td>
                                <td><img src="{{ $menu->icon_url['normal'] }}"></td>
                                <td>{{ $menu->icon_class }}</td>
                                <td class="text-center">{{ $menu->created_at }}</td>
                                <td class="text-center">
                                    @if ($menu->type === 'mix')
                                        <a href="{{ action('Admin\MenusController@createSubMenu', $menu->id) }}">
                                            <span class="fa fa-plus-square-o fa-lg"></span>
                                        </a>

                                        <a href="{{ action('Admin\MenusController@showSubMenu', $menu->id) }}">
                                            <span class="fa fa-list fa-lg"></span>
                                        </a>
                                    @endif
                                    <a href="{{ action('Admin\MenusController@edit', $menu->id) }}">
                                        <span class="fa fa-pencil-square-o fa fa-lg"></span>
                                    </a>
                                    <a href="#" class="delete" data-url="{{ action('Admin\MenusController@destroy', $menu->id) }}">
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
<div id="delete-confirm" data-message="{{ trans('admin/menu.delete_confirm') }}"></div>
<div id="delete-warning" data-message="{{ trans('admin/menu.delete_warning') }}"></div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/menu.js') !!}
@stop
