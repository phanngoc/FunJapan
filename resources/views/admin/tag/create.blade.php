@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/tag.create') }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => 'Admin\TagsController@store', 'class' => 'form-horizontal']) }}
                    <div class="form-group required">
                        {!! Form::label('name', trans('admin/tag.label.tag_name'), ['class' => 'col-sm-2 control-label required']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('name', '', [
                                'class' => 'form-control',
                                'placeholder' => trans('admin/tag.placeholder.input_tag_name'),
                                'required',
                            ]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/tag.button.create'), ['class' => 'btn btn-primary']) }}
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