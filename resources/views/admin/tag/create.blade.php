@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div id="notification"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/tag.create') }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => 'Admin\TagsController@store', 'class' => 'form-horizontal', 'id' => 'tag-create-form']) }}
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
                    @foreach ($locales as $key => $locale)
                        <div class="form-group required">
                            {!! Form::label('name' . $key, $locale . ' ' . trans('admin/tag.label.tag_name'), ['class' => 'col-sm-2 control-label required']) !!}
                            <div class="col-sm-10">
                                {!! Form::text('name' . $key, '', [
                                    'class' => 'form-control',
                                    'placeholder' => trans('admin/tag.placeholder.input_tag_name'),
                                    'required',
                                ]) !!}
                            </div>
                        </div>
                    @endforeach

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/tag.button.create'), ['class' => 'btn btn-primary', 'id' => 'create']) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h2>{{ trans('admin/tag.tag_list') }}</h2>
            </div>
            <div class="ibox-content">
                <div id="search-section">
                    {{ Form::open(['class' => 'form-horizontal', 'id' => 'search-form']) }}
                        <div class="form-group">
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" id="search-input" class="form-control" placeholder="Search Tag Name"> <span class="input-group-btn">
                                        <button type="button" class="btn btn-primary" id="search">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                            <button class="btn btn-primary hidden" id="clear">Clear</button>
                        </div>
                    {{ Form::close() }}
                    <hr>
                </div>
                <div id="tag-list">
                    @include('admin.tag._tag_list', ['tags' => $tags])
                </div>
            </div>
        </div>
    </div>
</div>
<div id="form-place-holder" class="hidden">
    {{ Form::open(['id' => 'form-edit', 'class' => 'form-horizontal']) }}
        {{ Form::hidden('id') }}
        <div class="form-group required">
            {!! Form::label('name', trans('admin/tag.label.tag_name'), ['class' => 'col-sm-3 control-label required']) !!}
            <div class="col-sm-9">
                {!! Form::text('name', '', [
                    'class' => 'form-control',
                    'placeholder' => trans('admin/tag.placeholder.input_tag_name'),
                    'required',
                ]) !!}
            </div>
        </div>
        @foreach ($locales as $key => $locale)
            <div class="form-group required">
                {!! Form::label('name' . $key, $locale . ' ' . trans('admin/tag.label.tag_name'), ['class' => 'col-sm-3 control-label required']) !!}
                <div class="col-sm-9">
                    {!! Form::text('name' . $key, '', [
                        'class' => 'form-control',
                        'placeholder' => trans('admin/tag.placeholder.input_tag_name'),
                        'required',
                    ]) !!}
                </div>
            </div>
        @endforeach

        <div class="form-group">
            <div class="col-sm-2 col-sm-offset-3">
                {{ Form::submit(trans('admin/tag.button.edit'), ['class' => 'btn btn-primary update', 'data-url' => action('Admin\TagsController@update')]) }}
            </div>
            <div class="col-sm-2">
                {{ Form::submit(trans('admin/tag.button.cancel'), ['class' => 'btn btn-primary cancel']) }}
            </div>
        </div>
    {{ Form::close() }}
</div>
<div id="delete-confirm" data-message="{{ trans('admin/tag.delete_confirm') }}"></div>
<div id="delete-warning" data-message="{{ trans('admin/tag.delete_warning') }}"></div>
@stop
@section('script')
    <script type="text/javascript">
        var locales = {!! json_encode($locales) !!};
        var tagLoadUrl = '{!! action('Admin\TagsController@ajaxTagList') !!}';
    </script>
    {!! Html::script('assets/admin/js/tag.js') !!}
@stop