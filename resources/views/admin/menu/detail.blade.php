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
                <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#{{ $menu->name }}">{{ $menu->name }}</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="{{ $menu->name }}" class="tab-pane active">
                                <div class="panel-body">
                                    <strong>{{ trans('admin/menu.label.name') }}</strong>:
                                    {{ $menu->name }}
                                    <hr>
                                    @if ($menu->link)
                                        <strong>{{ trans('admin/menu.label.link') }}</strong>:
                                        {!! $menu->link !!}
                                        <hr>
                                    @endif
                                    <strong>{{ trans('admin/menu.created_at') }}</strong>:
                                    {{ $menu->created_at }}
                                    <hr>
                                    @if ($menu->icon_url['normal'])
                                        <strong>{{ trans('admin/menu.label.icon') }}</strong>:
                                        <img src="{{ $menu->icon_url['normal'] }}">
                                        <hr>
                                    @endif
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
