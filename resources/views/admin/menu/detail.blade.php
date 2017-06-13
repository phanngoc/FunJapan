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
                                <strong class="col-sm-2">{{ trans('admin/menu.label.type') }}:</strong>
                                <p class="col-sm-10">{{ trans('admin/menu.parent_type' . '.' . $menu->type) }}</p>
                                <div class="clearfix"></div>
                                <hr>
                                <strong class="col-sm-2">{{ trans('admin/menu.label.name') }}:</strong>
                                <p class="col-sm-10">{{ $menu->name }}</p>
                                <div class="clearfix"></div>
                                <hr>
                                @if ($menu->link)
                                <strong class="col-sm-2">{{ trans('admin/menu.label.link') }}:</strong>
                                <p class="col-sm-10">{{ $menu->link }}</p>
                                <div class="clearfix"></div>
                                <hr>
                                @endif
                                @if ($menu->description)
                                <strong class="col-sm-2">{{ trans('admin/menu.label.description') }}:</strong>
                                <p class="col-sm-10 bw">{{ $menu->description }}</p>
                                <div class="clearfix"></div>
                                <hr>
                                @endif
                                @if ($menu->type == 'category')
                                <strong class="col-sm-2">{{ trans('admin/menu.label.selected_category') }}:</strong>
                                <div class="col-sm-2">
                                    @foreach ($selectedCategory as $category)
                                        <p>{{ $category->name }}</p>
                                        <hr>
                                    @endforeach
                                </div>
                                <div class="clearfix"></div>
                                <hr>
                                @endif
                                @if ($menu->parent_id)
                                <strong class="col-sm-2">{{ trans('admin/menu.label.parent') }}:</strong>
                                <p class="col-sm-10">{{ $menu->parent->name }}</p>
                                <div class="clearfix"></div>
                                <hr>
                                @endif
                                @if ($menu->icon_url['larger'])
                                <strong class="col-sm-2">{{ trans('admin/menu.label.icon') }}:</strong>
                                <div class="col-sm-10"><img src="{{ $menu->icon_url['normal'] }}"></div>
                                <div class="clearfix"></div>
                                <hr>
                                @endif
                                @if ($menu->icon_class)
                                <strong class="col-sm-2">{{ trans('admin/menu.label.icon_class') }}:</strong>
                                <p class="col-sm-10 bw">{{ $menu->icon_class }}</p>
                                <div class="clearfix"></div>
                                <hr>
                                @endif
                                <strong class="col-sm-2">{{ trans('admin/menu.created_at') }}:</strong>
                                <p class="col-sm-10">{{ $menu->created_at }}</p>
                                <div class="clearfix"></div>
                                <hr>
                                <a href="{{ action('Admin\MenusController@edit', [$menu->id]) }}" class="btn btn-w-m btn-primary">
                                    {{ trans('admin/menu.menu_edit') }}
                                </a>
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
