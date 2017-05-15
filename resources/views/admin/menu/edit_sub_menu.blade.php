@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/menu.sub_menu_edit') }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\MenusController@updateSubMenu', $menu->id], 'id' => 'create-menu-form', 'class' => 'form-horizontal']) }}
                    {{ method_field('PUT') }}
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
                                $menu->name,
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
                                $menu->link,
                                ['class' => 'form-control', 'required'])
                            }}
                        </div>
                    </div>

                    <div class="form-group required">
                        {{ Form::label(
                            'description',
                            trans('admin/menu.label.description'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::textarea(
                                'description',
                                $menu->description,
                                ['class' => 'form-control', 'required'])
                            }}
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/menu.button.update'),
                                [
                                    'class' => 'btn btn-primary',
                                ])
                            }}

                        </div>
                        <div class="col-sm-3">
                            <a class="btn btn-primary" href="{{ action('Admin\MenusController@showSubMenu', $menu->parent_id) }}">
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
