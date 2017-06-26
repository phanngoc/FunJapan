@extends('layouts.admin.default')

@section('style')
    {{ Html::style('assets/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}
    {{ Html::style('assets/medium-editor-handsontable/css/handsontable.full.css') }}
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading border-left">
        <div class="col-lg-10 page-title">
            <h2><b>{{ trans('admin/article.label.article') }}</b> {{ trans('admin/article.label.preview') }}</h2>
            <ol class="breadcrumb">
                <li class="home">
                    <a href="{{ action('Admin\DashboardController@index') }}">
                        <i class="fa fa-home"></i> <b>{{ trans('admin/article.label.home') }}</b>
                    </a>
                </li>
                <li>
                    <a href="{{ action('Admin\ArticlesController@create') }}">{{ trans('admin/article.label.article_create') }}</a>
                </li>
                <li class="active breadcrumb-preview">
                    <strong class="mb-preview {{ $input['previewMode'] == 1 ? '' : 'hidden' }}">
                        {{ trans('admin/article.label.article_preview_mobile') }}
                    </strong>
                    <strong class="pc-preview {{ $input['previewMode'] == 2 ? '' : 'hidden' }}">
                        {{ trans('admin/article.label.article_preview_pc') }}
                    </strong>
                    <strong class="thumb-preview {{ $input['previewMode'] == 3 ? '' : 'hidden' }}">
                        {{ trans('admin/article.label.article_preview_thumbnail') }}
                    </strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="row btn-preview">
        <a class="btn not-selected-btn {{ $input['previewMode'] == 1 ? 'btn-success active' : '' }}"
            data-toggle="tab" href="#mobile-preview" aria-expanded="true">
            <i class="fa fa-eye"></i> {{ trans('admin/article.button.mobile_preview') }}
        </a>
        <a class="btn not-selected-btn {{ $input['previewMode'] == 2 ? 'btn-success active' : '' }}"
            data-toggle="tab" href="#pc-preview" aria-expanded="false">
            <i class="fa fa-eye"></i> {{ trans('admin/article.button.pc_preview') }}
        </a>
        <a class="btn not-selected-btn {{ $input['previewMode'] == 3 ? 'btn-success active' : '' }}"
            data-toggle="tab" href="#thumbnail-preview" aria-expanded="false">
            <i class="fa fa-eye"></i> {{ trans('admin/article.button.thumbnail_preview') }}
        </a>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight article-preview">
        <div class="row">
            <div class="col-lg-12">
                <div class="tabs-container">
                    <div class="tab-content">
                        <div id="mobile-preview" class="tab-pane {{ $input['previewMode'] == 1 ? 'active' : '' }}">
                            <div class="panel-body">
                                <div class="col-lg-12">
                                    <div class="ibox float-e-margins">
                                        <div class="ibox-content mobile-preview">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <span class="simple_tag pull-left title-left">
                                                        {{ $category->name ?? null }}
                                                    </span>
                                                    <span class="simple_tag pull-right title-right">
                                                        {{ $author->name ?? null }}
                                                    </span>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="social-feed-box">
                                                        <div class="col-sm-12 title">
                                                            <h2>{{ $input['title'] }}</h2>
                                                        </div>
                                                        <div class="social-body body">
                                                            {!! $content !!}
                                                        </div>
                                                    </div>
                                                    @if (isset($input['tags']))
                                                        <div class="tags">
                                                            @foreach ($input['tags'] as $tag)
                                                                <span class="tag label label-warning">{{ $tag }}<span data-role="remove"></span></span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="col-sm-12 button-group">
                                                    <span class="simple_tag col-sm-12">
                                                        <button class="btn btn-success next-to-confirm" type="button">
                                                            <i class="fa fa-hand-o-right"></i>&nbsp;{{ trans('admin/article.button.next') }}
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="pc-preview" class="tab-pane {{ $input['previewMode'] == 2 ? 'active' : '' }}">
                            <div class="panel-body">
                                <div class="panel-body">
                                    <div class="col-lg-12">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-content">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <span class="simple_tag pull-left title-left">
                                                            {{ $category->name ?? null }}
                                                        </span>
                                                        <span class="simple_tag pull-right title-right">
                                                            {{ $author->name ?? null }}
                                                        </span>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="social-feed-box">
                                                            <div class="col-sm-12 title">
                                                                <h2>{{ $input['title'] }}</h2>
                                                            </div>
                                                            <div class="social-body body">
                                                                {!! $content !!}
                                                            </div>
                                                        </div>
                                                        @if (isset($input['tags']))
                                                            <div class="tags">
                                                                @foreach ($input['tags'] as $tag)
                                                                    <span class="tag label label-warning">{{ $tag }}<span data-role="remove"></span></span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="col-sm-12 button-group">
                                                        <span class="simple_tag col-sm-12">
                                                            <button class="btn btn-success btn-w-m next-to-confirm" type="button">
                                                                <i class="fa fa-hand-o-right"></i>&nbsp;{{ trans('admin/article.button.next') }}
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="thumbnail-preview" class="tab-pane image-preview {{ $input['previewMode'] == 3 ? 'active' : '' }}">
                            <div class="panel-body">
                                @if (count($images) > 0)
                                    <div class="row">
                                        <div class="col-xs-12 col-md-8">
                                            <div class="selected-image">
                                                @if (isset($images[0]))
                                                    <img src="{{ $images[0] }}">
                                                @endif
                                                <div class="title-preview">
                                                    <span>{{ $input['title'] }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-md-4">
                                            <div class="row list-image-preview">
                                                @foreach ($images as $key => $image)
                                                    <div class="col-md-5 image-item {{ $key == 0 ? 'preview-selected' : '' }}"
                                                        data-src="{{ $image }}"
                                                        style="background-image:url({{ $image }})">
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <a class="btn btn-danger btn-block colorpicker-element" href="javascript:;">
                                                    {{ trans('admin/article.button.color_panel') }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 button-group">
                                            <span class="simple_tag col-sm-12">
                                                <button class="btn btn-success btn-w-m next-to-confirm" type="button">
                                                    <i class="fa fa-hand-o-right"></i>&nbsp;{{ trans('admin/article.button.next') }}
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                @else
                                    <p>{{ trans('admin/article.messages.no_images') }}</p>
                                    <div class="title-preview"></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::open([
                    'action' => 'Admin\ArticlesController@confirm',
                    'role' => 'form',
                    'method' => 'POST',
                    'class' => 'form-confirm'
                ]) }}
                    {{ Form::hidden('author_id', $input['author_id'] ?? null) }}
                    {{ Form::hidden('client_id', $input['client_id'] ?? null) }}
                    {{ Form::hidden('locale_id', $input['locale_id'] ?? null) }}
                    {{ Form::hidden('publish_date', $input['publish_date'] ?? null) }}
                    {{ Form::hidden('publish_time', $input['publish_time'] ?? null) }}
                    {{ Form::hidden('end_publish_date', $input['end_publish_date'] ?? null) }}
                    {{ Form::hidden('end_publish_time', $input['end_publish_time'] ?? null) }}
                    {{ Form::hidden('category_id', $input['category_id'] ?? null) }}
                    {{ Form::hidden('sub_category_id', $input['sub_category_id'] ?? null) }}
                    {{ Form::hidden('hide', $input['hide'] ?? null) }}
                    {{ Form::hidden('is_member_only', $input['is_member_only'] ?? null) }}
                    {{ Form::hidden('title', $input['title'] ?? null) }}
                    {{ Form::hidden('switch_editor', $input['switch_editor'] ?? null) }}
                    {{ Form::hidden('contentMedium', $input['contentMedium'] ?? null) }}
                    {{ Form::hidden('contentMarkdown', $input['contentMarkdown'] ?? null) }}
                    {{ Form::hidden('description', $input['description'] ?? null) }}
                    {{ Form::hidden('previewMode', $input['previewMode'] ?? null) }}
                    {{ Form::hidden('saveDraft', $input['saveDraft'] ?? null) }}
                    {{ Form::hidden('titleBgColor', null, ['class' => 'title-bg-color']) }}
                    {{ Form::hidden('thumbnail', $images[0] ?? null, ['class' => 'thumbnail']) }}
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section('script')
    {{ Html::script('assets/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}
    {{ Html::script('assets/admin/js/article_preview.js') }}
@stop
