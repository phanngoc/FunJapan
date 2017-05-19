@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/menu.sub_menu_create') . $menu->name }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\MenusController@storeSubMenu', $menu->id], 'id' => 'create-menu-form', 'class' => 'form-horizontal']) }}

                    {{ Form::hidden('type', $type) }}
                    {{ Form::hidden('locale_id', $menu->locale_id) }}

                    <div class="form-group required">
                        {{ Form::label(
                            'name',
                            trans('admin/menu.label.name'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::text(
                                'name',
                                '',
                                ['class' => 'form-control', 'required'])
                            }}
                        </div>
                    </div>

                    <div class="form-group required" id="section_link">
                        {{ Form::label(
                            'link',
                            trans('admin/menu.label.link'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10" id="link_input">
                            {{ Form::text(
                                'link',
                                '',
                                ['class' => 'form-control', 'required'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'description',
                            trans('admin/menu.label.description'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::text(
                                'description',
                                '',
                                ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/menu.button.create'),
                                [
                                    'class' => 'btn btn-primary',
                                    'id' => 'menu-create',
                                ])
                            }}
                        </div>

                        <div class="col-sm-3">
                            <a class="btn btn-primary cancel" data-message="{{ trans('admin/menu.cancel_message') }}" href="{{ action('Admin\MenusController@showSubMenu', $menu->id) }}">
                            {{ trans('admin/menu.button.cancel') }}
                            </a>
                        </div>
                    </div>
                {{ Form::close() }}
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
