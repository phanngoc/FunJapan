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
    <div id="author" class="tab-pane fade in active">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title"><h2>{{ trans('admin/author.add') }}</h2></div>
                    <div class="ibox-content">
                        <div class="row">
                            {{ Form::open([
                                    'id' => 'author-form',
                                    'class' => 'form-horizontal',
                                    'files' => true,
                                ])
                            }}
                                @include('admin.authors._form')
                                <div class="form-group">
                                    <div class="col-sm-1 col-sm-offset-1">
                                        <a href="javascript:;" class="btn btn-primary" id="update-author"
                                            data-url="{{ action('Admin\AuthorsController@store') }}">
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
    {!! Html::script('assets/admin/js/author.js') !!}
@endsection