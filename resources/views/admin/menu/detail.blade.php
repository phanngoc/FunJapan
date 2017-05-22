@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h2>
                    {{ trans('admin/menu.menu_detail') . $menu->name . ' - ' . $menu->locale->name}}
                    <a href="@if ($menu->parent_id)
                                {{ action('Admin\MenusController@showSubMenu', $menu->parent_id) }}
                            @else
                                {{ action('Admin\MenusController@index', ['locale' => $menu->locale_id]) }}
                            @endif" type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="fa fa-times"></span>
                    </a>
                </h2>
            </div>
            <div class="ibox-content">
                <div class="">
                    <div class="tab-content">
                        <div id="{{ $menu->name }}" class="tab-pane active">
                            <div class="panel-body">
                                <strong>{{ trans('admin/menu.label.type') }}</strong>:
                                {{ trans('admin/menu.parent_type' . '.' . $menu->type) }}
                                <hr>
                                <strong>{{ trans('admin/menu.label.name') }}</strong>:
                                {{ $menu->name }}
                                <hr>
                                @if ($menu->link)
                                <strong>{{ trans('admin/menu.label.link') }}</strong>:
                                {!! $menu->link !!}
                                <hr>
                                @endif
                                @if ($menu->description)
                                <strong>{{ trans('admin/menu.label.description') }}</strong>:
                                {!! $menu->description !!}
                                <hr>
                                @endif
                                @if ($menu->parent_id)
                                <strong>{{ trans('admin/menu.label.parent') }}</strong>:
                                {!! $menu->parent->name !!}
                                <hr>
                                @endif
                                @if ($menu->icon_url['larger'])
                                <strong>{{ trans('admin/menu.label.icon') }}</strong>:
                                <img src="{{ $menu->icon_url['larger'] }}">
                                <hr>
                                @endif
                                @if ($menu->icon_class)
                                <strong>{{ trans('admin/menu.label.icon_class') }}</strong>:
                                {{ $menu->icon_class }}
                                <hr>
                                @endif
                                <strong>{{ trans('admin/menu.created_at') }}</strong>:
                                {{ $menu->created_at }}
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    <script type="text/javascript">
        var oldInputs = {!! json_encode(old()) !!}
    </script>
    {!! Html::script('assets/admin/js/menu.js') !!}
@stop
