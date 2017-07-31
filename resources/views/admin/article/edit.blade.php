@extends('layouts.admin.default')

@section('style')
    {{ Html::style('assets/admin/css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}
    {{ Html::style('assets/medium-editor/css/medium-editor.min.css') }}
    {{ Html::style('assets/medium-editor/css/themes/default.css') }}
    {{ Html::style('assets/medium-editor-handsontable/css/medium-editor-handsontable.css') }}
    {{ Html::style('assets/medium-editor-handsontable/css/handsontable.full.css') }}
    {{ Html::style('assets/medium-editor-insert/css/medium-editor-insert-plugin.min.css') }}

@endsection
@section('content')
    <div class="row wrapper border-bottom white-bg page-heading border-left">
        <div class="col-lg-10 page-title">
            <h2><b>{{ trans('admin/article.label.article') }}</b> {{ trans('admin/article.label.edit') }}</h2>
            <ol class="breadcrumb">
                <li class="home">
                    <a href="{{ action('Admin\DashboardController@index') }}"><i class="fa fa-home"></i> <b>{{ trans('admin/article.label.home') }}</b></a>
                </li>
                <li>
                    <b>{{ trans('admin/article.article_list') }}</b>
                </li>
                <li class="active breadcrumb-preview">
                    <strong>
                        {{ trans('admin/article.label.article_edit') }}
                    </strong>
                </li>
            </ol>
        </div>
    </div>
    <div class="wrapper wrapper-content alert-error-section hidden">
        <div class="alert alert-danger">
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight back-section">
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ action('Admin\ArticlesController@show', $article->id) }}" class="btn btn-default btn-w-m btn-back">
                    <i class="fa fa-arrow-left"></i> {{ trans('admin/article.button.back') }}
                </a>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight article-form-edit">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <div class="row">
                            {{ Form::open([
                                'action' => 'Admin\ArticlesController@preview',
                                'role' => 'form',
                                'method' => 'POST',
                                'class' => 'article-create',
                            ]) }}
                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label(
                                            'author_id',
                                            trans('admin/article.label.author'),
                                            ['class' => 'control-label'])
                                        }}
                                        {{ Form::select(
                                            'author_id',
                                            $authors,
                                            old('author_id') ?? ($article->author_id ?? null),
                                            [
                                                'class' => 'form-control m-b',
                                            ]
                                        ) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label(
                                            'client_id',
                                            trans('admin/article.label.choose_client_id'),
                                            ['class' => 'control-label'])
                                        }}
                                        {{ Form::select(
                                            'client_id',
                                            $clients,
                                            old('client_id') ?? ($article->client_id ?? null),
                                            [
                                                'class' => 'form-control m-b',
                                            ]
                                        ) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label(
                                            'locale_id',
                                            trans('admin/article.label.choose_country'),
                                            ['class' => 'control-label'])
                                        }}
                                        {{ Form::select(
                                            'locale_id',
                                            [$articleLocale->locale_id => $articleLocale->locale->name],
                                            $articleLocale->locale_id,
                                            [
                                                'class' => 'form-control m-b',
                                                'data-url' => action('Admin\ArticlesController@getCategoryLocale'),
                                                'readonly' => true,
                                            ]
                                        ) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label(
                                            'category_id',
                                            trans('admin/article.label.choose_category'),
                                            ['class' => 'control-label'])
                                        }}
                                        {{ Form::select(
                                            'category_id',
                                            [],
                                            null,
                                            [
                                                'class' => 'form-control m-b',
                                                'data-select-text' => trans('admin/article.label.select_category'),
                                            ]
                                        ) }}
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label(
                                            'sub_category_id',
                                            trans('admin/article.label.choose_sub_category'),
                                            ['class' => 'control-label'])
                                        }}
                                        {{ Form::select(
                                            'sub_category_id',
                                            $subCategories,
                                            old('sub_category_id') ?? ($articleLocale->sub_category_id ?? null),
                                            ['class' => 'form-control m-b']
                                        ) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-6 padding-left-0">
                                            {{ Form::label(
                                                'publish_date',
                                                trans('admin/article.label.publish_date'),
                                                ['class' => 'control-label'])
                                            }}
                                            <div class="input-group date">
                                                {{ Form::text(
                                                    'publish_date',
                                                    old('publish_date') ?? ($articleLocale->published_at ? $articleLocale->published_at->format('Y-m-d') : null),
                                                    [
                                                        'class' => 'form-control',
                                                        'autocomplete' => 'off',
                                                        'disabled' => $notEditPublishedTime ?? false,
                                                    ])
                                                }}
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            {{ Form::label(
                                                'published_time',
                                                trans('admin/article.label.published_time'),
                                                ['class' => 'control-label'])
                                            }}
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                {{ Form::text(
                                                    'publish_time',
                                                    old('publish_time') ?? ($articleLocale->published_at ? $articleLocale->published_at->format('H:i') : null),
                                                    [
                                                        'class' => 'form-control',
                                                        'autocomplete' => 'off',
                                                        'disabled' => $notEditPublishedTime ?? false,
                                                    ])
                                                }}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                        @if (isset($notEditPublishedTime) && $notEditPublishedTime)
                                            <input type="hidden" name="publish_date" value="{{ $articleLocale->published_at->format('Y-m-d') }}">
                                            <input type="hidden" name="publish_time" value="{{ $articleLocale->published_at->format('H:i') }}">
                                        @endif
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-6 padding-left-0">
                                            {{ Form::label(
                                                'end_publish_date',
                                                trans('admin/article.label.end_publish_date'),
                                                ['class' => 'control-label'])
                                            }}
                                            <div class="input-group date">
                                                {{ Form::text(
                                                    'end_publish_date',
                                                    old('end_publish_date') ?? ($articleLocale->end_published_at ? $articleLocale->end_published_at->format('Y-m-d') : null),
                                                    [
                                                        'class' => 'form-control',
                                                        'autocomplete' => 'off',
                                                    ])
                                                }}
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
                                                {{ Form::text(
                                                    'end_publish_time',
                                                    old('end_publish_time') ?? ($articleLocale->end_published_at ? $articleLocale->end_published_at->format('H:i') : null),
                                                    [
                                                        'class' => 'form-control',
                                                        'autocomplete' => 'off',
                                                    ])
                                                }}
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="col-sm-6 member-only-btn">
                                            {{ Form::label(
                                                'is_member_only',
                                                trans('admin/article.label.member_only'),
                                                ['class' => 'control-label'])
                                            }}
                                            <div class="form-group-radio">
                                                <div class="radio radio-success radio-inline">
                                                    {{ Form::radio('is_member_only', 1, old('is_member_only') ? old('is_member_only') == 1 :
                                                        ($articleLocale->is_member_only == 1)) }}
                                                    <label>{{ trans('admin/article.button.yes') }}</label>
                                                </div>
                                                <div class="radio radio-success radio-inline">
                                                    {{ Form::radio('is_member_only', 0, old('is_member_only') ? old('is_member_only') == 0 :
                                                        ($articleLocale->is_member_only == 0)) }}
                                                    <label>{{ trans('admin/article.button.no') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            {{ Form::label(
                                                'hide',
                                                trans('admin/article.label.hide'),
                                                ['class' => 'control-label'])
                                            }}
                                            <div class="form-group-radio">
                                                <div class="radio radio-success radio-inline">
                                                    <input type="radio" value="1" name="hide">
                                                    {{ Form::radio('hide', 1, old('hide') ? old('hide') == 1 : ($articleLocale->hide == 1), ['disabled' => $notEditHideAttr]) }}
                                                    <label>{{ trans('admin/article.button.yes') }}</label>
                                                </div>
                                                <div class="radio radio-success radio-inline">
                                                    {{ Form::radio('hide', 0, old('hide') ? old('hide') == 0 : ($articleLocale->hide == 0), ['disabled' => $notEditHideAttr]) }}
                                                    <label>{{ trans('admin/article.button.no') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <hr>
                                    <div class="form-group">
                                        {{ Form::label(
                                            'title',
                                            trans('admin/article.label.title'),
                                            ['class' => 'control-label'])
                                        }}
                                        {{ Form::text(
                                            'title',
                                            old('title') ?? ($articleLocale->title ?? null),
                                            [
                                                'class' => 'form-control',
                                                'placeholder' => trans('admin/article.placeholder.title'),
                                            ])
                                        }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label(
                                            'content',
                                            trans('admin/article.label.content'),
                                            ['class' => 'control-label'])
                                        }}
                                        <div class="switch-editor">
                                            <div class="form-group-radio">
                                                <div class="radio radio-success radio-inline">
                                                    {{ Form::radio('switch_editor', config('article.content_type.medium'),
                                                        old('switch_editor') ? old('switch_editor') == config('article.content_type.medium') :
                                                        ($articleLocale->content_type == config('article.content_type.medium'))) }}
                                                    <label>{{ trans('admin/article.button.use_medium') }}</label>
                                                </div>
                                                <div class="radio radio-success radio-inline">
                                                    {{ Form::radio('switch_editor', config('article.content_type.markdown'),
                                                        old('switch_editor') ? old('switch_editor') == config('article.content_type.markdown') :
                                                        ($articleLocale->content_type == config('article.content_type.markdown'))) }}
                                                    <label>{{ trans('admin/article.button.use_markdown') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        {{ Form::textarea(
                                            'contentMarkdown',
                                            old('contentMarkdown') ?? ($articleLocale->content_type == config('article.content_type.markdown') ? $articleLocale->content : ''),
                                            [
                                                'class' => 'form-control article-content',
                                                'placeholder' => trans('admin/article.placeholder.content'),
                                                'rows' => 10,
                                            ])
                                        }}
                                    </div>
                                    <div class="form-group medium-section">
                                        {{ Form::hidden('contentMedium', old('contentMedium') ?? ($articleLocale->content_type == config('article.content_type.medium')) ? $articleLocale->content : '') }}
                                        <div class="editable medium-editor">
                                            {!! old('contentMedium') ?? ($articleLocale->content_type == config('article.content_type.medium') ? $articleLocale->content : '') !!}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label(
                                            'tags',
                                            trans('admin/article.label.tags'),
                                            ['class' => 'control-label'])
                                        }}
                                        {{ Form::select(
                                            'tags[]',
                                            old('tags') ? array_flip(old('tags')) : array_flip($tags),
                                            null,
                                            [
                                                'class' => 'form-control article-tag',
                                                'multiple' => 'multiple',
                                                'data-url' => action('Admin\TagsController@suggest')
                                            ])
                                        }}
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label(
                                            'description',
                                            trans('admin/article.label.description'),
                                            ['class' => 'control-label'])
                                        }}
                                        {{ Form::textarea(
                                            'description',
                                            old('description') ?? ($articleLocale->summary ?? null),
                                            [
                                                'class' => 'form-control',
                                                'rows' => 2,
                                            ])
                                        }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary btn-w-m create-action save-draft" type="button"
                                        data-url="{{ action('Admin\ArticlesController@validateInput') }}">
                                        <i class="fa fa-eyedropper"></i>&nbsp{{ trans('admin/article.button.draft') }}
                                        <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-sm-12 button-group">
                                <span class="simple_tag col-sm-12">
                                    {{ Form::hidden('previewMode', null, ['class' => 'preview-mode']) }}
                                    {{ Form::hidden('editMode', true) }}
                                    {{ Form::hidden('photo', $articleLocale->url_photo) }}
                                    {{ Form::hidden('title_bg_color', $articleLocale->title_bg_color) }}
                                    {{ Form::hidden('articleLocaleId', $articleLocale->id ?? null) }}
                                    {{ Form::hidden('saveDraft', null, ['class' => 'save-draft-input']) }}
                                    <button class="btn btn-success btn-w-l create-action check-preview" type="button"
                                        data-url="{{ action('Admin\ArticlesController@validateInput') }}">
                                        &nbsp;<i class="fa fa-eye"></i>&nbsp;{{ trans('admin/article.button.check_preview') }}&nbsp;
                                        <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                    </button>
                                </span>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="upload-file-data"
         data-url-upload="{{ action('Admin\ArticlesController@uploadImage') }}"
         data-url-delete="{{ action('Admin\ArticlesController@deleteImage') }}"
         data-max-size="{{ config('images.article_content.max_size') }}"
         data-message-file-type-error="{{ trans('admin/article.messages.not_supported_format') }}"
         data-message-size-error="{{ trans('admin/article.messages.max_size_error') }}">
    </div>
    <div class="modal inmodal fade" id="confirm-check-preview" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row btn-preview">
                        <a class="btn btn-success preview-mode-btn" data-value="1"><i class="fa fa-eye"></i> {{ trans('admin/article.button.mobile_preview') }}</a>
                        <a class="btn btn-success preview-mode-btn" data-value="2"><i class="fa fa-eye"></i> {{ trans('admin/article.button.pc_preview') }}</a>
                        <a class="btn btn-success preview-mode-btn" data-value="3"><i class="fa fa-eye"></i> {{ trans('admin/article.button.thumbnail_preview') }}</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    {{ Html::script('assets/medium-editor-handsontable/js/handsontable.full.js') }}
    {{ Html::script('assets/medium-editor/js/medium-editor.min.js') }}
    {{ Html::script('assets/medium-editor-handsontable/js/medium-editor-handsontable.js') }}
    {{ Html::script('assets/medium-editor-markdown/me-markdown.standalone.min.js') }}
    {{ Html::script('assets/handlebars/handlebars.runtime.min.js') }}
    {{ Html::script('assets/jquery-sortable/js/jquery-sortable-min.js') }}
    {{ Html::script('assets/blueimp-file-upload/js/vendor/jquery.ui.widget.js') }}
    {{ Html::script('assets/blueimp-file-upload/js/jquery.iframe-transport.js') }}
    {{ Html::script('assets/blueimp-file-upload/js/jquery.fileupload.js') }}
    {{ Html::script('assets/medium-editor-insert/js/medium-editor-insert-plugin.min.js') }}
    <script>
        var categoryId = "{{ old('category_id') ?? ($articleLocale->category_id ?? null) }}";
        var showMarkdown = "{{ old('switch_editor') ? (old('switch_editor') == config('article.content_type.markdown')) : $articleLocale->content_type == config('article.content_type.markdown') }}";
        var warningChangeTxt = "{{ trans('admin/article.messages.warning_change_data') }}";
        var localeId = "{{ $articleLocale->locale_id }}";
    </script>
    {{ Html::script('assets/admin/js/article_create.js') }}
@stop
