@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/tag.edit_tag') }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\TagsController@update', $tag->id], 'class' => 'form-horizontal']) }}
                    {{ method_field('PUT') }}
                    <div class="form-group required">
                        {!! Form::label('name', trans('admin/tag.label.tag_name'), ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', $tag->name, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-3 col-sm-offset-2">
                            {{ Form::submit(trans('admin/tag.button.edit'), ['class' => 'btn btn-primary']) }}
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ action('Admin\TagsController@index') }}" class="btn-primary btn">{{ trans('admin/tag.button.cancel') }}</a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/tag.js') !!}
@stop