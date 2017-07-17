<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/client.add') }}</h2></div>
            <div class="ibox-content">
                <div class="row">
                    {{ Form::open([
                            'id' => 'client-form',
                            'class' => 'form-horizontal',
                        ])
                    }}
                        <div class="form-group required">
                            {{ Form::label(
                                'name',
                                trans('admin/client.label.name'),
                                ['class' => 'col-sm-2 control-label'])
                            }}
                            <div class="col-sm-8">
                                {{ Form::text(
                                    'name',
                                    null,
                                    [
                                        'class' => 'form-control',
                                        'required',
                                    ])
                                }}
                                <p class="text-danger font-bold error-client-name"></p>
                            </div>
                            <div class="col-sm-1">
                                <a href="javascript:;" class="btn btn-primary" id="create-client"
                                    data-url="{{ action('Admin\ClientsController@store') }}">
                                    {{ trans('admin/survey.button.save') }}
                                </a>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <div id="redirect" data-url="{{ action('Admin\IdsController@index') }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>