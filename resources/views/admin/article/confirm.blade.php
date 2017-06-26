@extends('layouts.admin.default')

@section('style')
    {{ Html::style('assets/admin/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}
@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading border-left">
        <div class="col-lg-10 page-title">
            <h2><b>{{ trans('admin/article.label.confirmation') }}</b></h2>
            <ol class="breadcrumb">
                <li class="home">
                    <a href="{{ action('Admin\DashboardController@index') }}"><i class="fa fa-home"></i> <b>{{ trans('admin/article.label.home') }}</b></a>
                </li>
                <li>
                    <a href="{{ action('Admin\ArticlesController@create') }}">{{ trans('admin/article.label.article_create') }}</a>
                </li>
                <li class="active breadcrumb-preview">
                    <strong>
                        {{ trans('admin/article.label.article_confirm') }}
                    </strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-6 b-r">
                                <div class="form-group">
                                    {{ Form::label(
                                            'author_id',
                                            trans('admin/article.label.author'),
                                            ['class' => 'control-label'])
                                        }}
                                    {{ Form::select(
                                        'author_id',
                                        $authors,
                                        $input['author_id'] ?? null,
                                        [
                                            'class' => 'form-control m-b',
                                            'disabled' => true,
                                        ]
                                    ) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label(
                                            'client_id',
                                            trans('admin/article.label.choose_client_id'),
                                            ['class' => 'control-label'])
                                        }}
                                    {{ Form::select(
                                        'client_id',
                                        $clients,
                                        $input['client_id'] ?? null,
                                        [
                                            'class' => 'form-control m-b',
                                            'disabled' => true,
                                        ]
                                    ) }}
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6 padding-left-0">
                                        {{ Form::label(
                                            'publish_date',
                                            trans('admin/article.label.publish_date'),
                                            ['class' => 'control-label'])
                                        }}
                                        <div class="input-group date">
                                            <input type="text" class="form-control" disabled name="publish_date"
                                                value="{{ $input['publish_date'] }}" autocomplete="off">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::label(
                                            'publish_time',
                                            trans('admin/article.label.published_time'),
                                            ['class' => 'control-label'])
                                        }}
                                        <div class="input-group clockpicker" data-autoclose="true">
                                            <input type="text" class="form-control" disabled name="publish_time"
                                                value="{{ $input['publish_time'] }}" autocomplete="off">
                                            <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6 padding-left-0">
                                        {{ Form::label(
                                            'end_publish_date',
                                            trans('admin/article.label.end_publish_date'),
                                            ['class' => 'control-label'])
                                        }}
                                        <div class="input-group date">
                                            <input type="text" class="form-control" disabled name="end_publish_date"
                                                value="{{ $input['end_publish_date'] }}" autocomplete="off">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        {{ Form::label(
                                            'end_publish_time',
                                            trans('admin/article.label.end_publish_time'),
                                            ['class' => 'control-label'])
                                        }}
                                        <div class="input-group clockpicker" data-autoclose="true">
                                            <input type="text" class="form-control" disabled name="end_publish_time"
                                                value="{{ $input['end_publish_time'] }}" autocomplete="off">
                                            <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <div class="col-sm-6 right-column">
                                <div class="form-group">
                                    {{ Form::label(
                                            'category_id',
                                            trans('admin/article.label.choose_category'),
                                            ['class' => 'control-label'])
                                        }}
                                    {{ Form::select(
                                        'category_id',
                                        $categories,
                                        $input['category_id'],
                                        [
                                            'class' => 'form-control m-b',
                                            'disabled' => true,
                                        ]
                                    ) }}
                                </div>
                                <div class="form-group">
                                    {{ Form::label(
                                        'sub_category_id',
                                        trans('admin/article.label.choose_sub_category'),
                                        ['class' => 'control-label']
                                    ) }}
                                    {{ Form::select(
                                        'sub_category_id',
                                        $subCategories,
                                        $input['sub_category_id'],
                                        [
                                            'class' => 'form-control m-b',
                                            'disabled' => true,
                                        ]
                                    ) }}
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        {{ Form::label(
                                            'hide',
                                            trans('admin/article.label.hide'),
                                            ['class' => 'control-label'])
                                        }}
                                        <div class="form-group-radio">
                                            <div class="radio radio-success radio-inline">
                                                {{ Form::radio('hide', 1, $input['hide'] == 1, ['disabled' => true]) }}
                                                <label>{{ trans('admin/article.button.yes') }}</label>
                                            </div>
                                            <div class="radio radio-success radio-inline">
                                                {{ Form::radio('hide', 0, $input['hide'] == 0, ['disabled' => true]) }}
                                                <label>{{ trans('admin/article.button.no') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        {{ Form::label(
                                            'member_only',
                                            trans('admin/article.label.member_only'),
                                            ['class' => 'control-label'])
                                        }}
                                        <div class="form-group-radio">
                                            <div class="radio radio-success radio-inline">
                                                {{ Form::radio('is_member_only', 1, $input['is_member_only'] == 1, ['disabled' => true]) }}
                                                <label>{{ trans('admin/article.button.yes') }}</label>
                                            </div>
                                            <div class="radio radio-success radio-inline">
                                                {{ Form::radio('is_member_only', 0, $input['is_member_only'] == 0, ['disabled' => true]) }}
                                                <label>{{ trans('admin/article.button.no') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 button-group">
                                {{ Form::open([
                                    'action' => 'Admin\ArticlesController@store',
                                    'role' => 'form',
                                    'method' => 'POST',
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
                                    {{ Form::hidden('titleBgColor', $input['titleBgColor'] ?? null, ['class' => 'title-bg-color']) }}
                                    {{ Form::hidden('thumbnail', $input['thumbnail'] ?? null, ['class' => 'thumbnail']) }}
                                    <span class="simple_tag col-sm-12">
                                        <button type="submit" class="btn btn-w-m btn-primary-custom">{{ trans('admin/article.button.yes') }}</button>
                                        <button type="button" class="btn btn-w-m btn-danger btn-cancel">{{ trans('admin/article.button.no') }}</button>
                                    </span>
                                {{ Form::close() }}
                            </div>
                            {{ Form::open([
                                'action' => 'Admin\ArticlesController@cancelConfirm',
                                'role' => 'form',
                                'method' => 'POST',
                                'class' => 'form-cancel',
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
                                {{ Form::hidden('titleBgColor', $input['titleBgColor'] ?? null, ['class' => 'title-bg-color']) }}
                                {{ Form::hidden('thumbnail', $input['thumbnail'] ?? null, ['class' => 'thumbnail']) }}
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    {{ Html::script('assets/admin/js/article_confirm.js') }}
@stop
