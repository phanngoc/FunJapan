@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#client">{{ trans('admin/client.client_management') }}</a></li>
    <li><a data-toggle="tab" href="#author">{{ trans('admin/client.author_management') }}</a></li>
    <li><a data-toggle="tab" href="#tag">{{ trans('admin/client.tag_management') }}</a></li>
</ul>

<div class="tab-content">
    <div id="client" class="tab-pane fade in active">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title"><h2>{{ trans('admin/client.edit') }}</h2></div>
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
                                        ['class' => 'col-sm-1 control-label'])
                                    }}
                                    <div class="col-sm-9">
                                        {{ Form::text(
                                            'name',
                                            $client->name,
                                            [
                                                'class' => 'form-control',
                                                'required',
                                            ])
                                        }}
                                        <p class="text-danger font-bold error-client-name"></p>
                                    </div>
                                    <input type="hidden" value="{{ $client->id }}" name="id">
                                    <div class="col-sm-1">
                                        <a href="javascript:;" class="btn btn-primary" id="update-client"
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
    </div>
</div>
@endsection
@section('script')
    {!! Html::script('assets/admin/js/client.js') !!}
@endsection