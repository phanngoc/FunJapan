@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/menu.top_menu_create') }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\MenusController@store'], 'id' => 'create-menu-form', 'class' => 'form-horizontal', 'files' => true]) }}


                    <div class="form-group">
                        {{ Form::label(
                            'type',
                            trans('admin/menu.label.type'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select(
                                'type',
                                $menuTypes,
                                null,
                                ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'locale_id',
                            trans('admin/menu.label.locale'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select(
                                'locale_id',
                                $locales,
                                null,
                                ['class' => 'form-control'])
                            }}
                        </div>
                    </div>

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

                    <div class="form-group required">
                        {{ Form::label(
                            'description',
                            trans('admin/menu.label.description'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::textarea(
                                'description',
                                '',
                                ['class' => 'form-control', 'required'])
                            }}
                        </div>
                    </div>

                    <div class="form-group required">
                        {{ Form::label(
                            'icon',
                            trans('admin/menu.label.icon'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt5">
                            {{ Form::file(
                                'icon',
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
                            <a class="btn btn-primary" href="{{ action('Admin\MenusController@index') }}">
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
        var menuTypes = {!! json_encode($menuTypes) !!}
        var oldInputs = {!! json_encode(old()) !!}
    </script>
    {!! Html::script('assets/admin/js/menu.js') !!}
@stop