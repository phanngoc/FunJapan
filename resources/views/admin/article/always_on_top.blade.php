@extends('layouts.admin.default')

@section('scripts')
    {!! Html::script('assets/admin/js/alwaysOnTop.js') !!}

    <script>
        var articleSuggest = {{ config('banner.article_suggest') }};;
        var labelUnauthorized = '{{ trans('admin/banner.validate.unauthorized') }}';
        var lblConfirmRemove = '{{ trans('admin/article.always_on_top.label_delete_question_title') }}';
        var lblConfirmRemoveTitle = '{{ trans('admin/article.always_on_top.label_delete_question') }}';
        var lblButtonYes = '{{ trans('admin/article.always_on_top.label_yes') }}';
        var lblButtonNo = '{{ trans('admin/article.always_on_top.label_no') }}';
        var lblTitleChangeLocale = '{{ trans('admin/article.always_on_top.label_change_locale_title') }}';
        var lblQuestionChangeLocale = '{{ trans('admin/article.always_on_top.label_change_locale_question') }}';
        var lblTitleUpdate = '{{ trans('admin/article.always_on_top.label_update_title') }}';
        var lblQuestionUpdate = '{{ trans('admin/article.always_on_top.label_update_question_title') }}';
    </script>
@endsection

@section('styles')
    {!! Html::style('assets/admin/css/banner.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-6 add-always-top-box">
            <div class="ibox">
                <div class="ibox-title">
                    <h2>{{ trans('admin/article.always_on_top.title') }}</h2>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        {!! Form::open(['class' => 'form-horizontal', 'files' => true]) !!}
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('admin/article.always_on_top.label_country') }}</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="locale_id" id="locale">
                                        @foreach ($locales as $id => $locale)
                                            <option value="{{ $id }}" {{ $id == $currentLocale ? 'selected' : '' }}>{{ $locale }}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" value="{{ $currentLocale }}" id="old_locale">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('admin/article.always_on_top.label_article') }}</label>
                                <div class="col-sm-10">
                                    <select
                                            name="article_locale_id"
                                            class="article-select2"
                                            style="width: 100%"
                                    >
                                        @if (old('article_id'))
                                            <option value="{{ old('article_id') }}" selected="selected">
                                                {{ old('article_title') }}
                                            </option>
                                        @endif
                                    </select>
                                    <input type="hidden" name="article_title">
                                    <p class="text-danger font-bold m-xxs error-message" id="article_locale_id_error"></p>
                                </div>
                            </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                {{ trans('admin/article.always_on_top.label_from_to') }}
                            </label>
                            <div class="col-sm-5">
                                <input type="text" name="start_date" class="form-control from-datetime-picker" autocomplete="off">
                                <p class="text-danger font-bold m-xxs error-message" id="start_date_error"></p>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" name="end_date" class="form-control to-datetime-picker" autocomplete="off">
                                <p class="text-danger font-bold m-xxs error-message" id="end_date_error"></p>
                            </div>
                        </div>
                            <button class="btn btn-primary btn-block set-always-on-top" type="button">
                                <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                <i class="fa fa-check"></i>&nbsp;
                                <strong>{{ trans('admin/article.always_on_top.label_update') }}</strong>
                            </button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h2>{{ trans('admin/article.always_on_top.title_list') }}</h2>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            @foreach ($locales as $key => $locale)
                                <li class="tab-title {{ $key == $currentLocale ? 'active' : '' }}" id="tab-{{ $key }}">
                                    <a data-toggle="tab" href="#tab-pane-{{ $key }}"  data-locale-id="{{ $key }}">{{ $locale }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($tops as $top)
                                <div class="tab-pane {{ $top->locale_id == $currentLocale ? 'active' : '' }}" id="tab-pane-{{ $top->locale_id }}">
                                    <div class="panel-body">
                                        <div class="row" id="top-{{ $top->id }}">
                                            <div class="col-md-4 preview-image">
                                                <div class="row">
                                                    <img class="image-banner" src="{{ $top->articleLocale->thumbnail_urls['original'] }}">
                                                </div>
                                                <input type="hidden" value="1" id="setted_locale_{{ $top->locale_id }}">
                                            </div>
                                            <div class="col-md-4">

                                                <h3><strong>{{ trans('admin/article.always_on_top.label_from_to') }} : </strong> {{ $top->start_date . ' -> ' .  $top->end_date }}</h3>
                                                <h3 class="{{ $top->active ? '' : 'text-danger' }}">
                                                    <strong>{{ trans('admin/article.always_on_top.status') }} : </strong>
                                                    {{ $top->active ? trans('admin/article.always_on_top.active') : trans('admin/article.always_on_top.deactive') }}
                                                </h3>

                                                <h3><strong>{{ trans('admin/article.always_on_top.label_title') }}</strong></h3>
                                                <p id="title-{{ $top->id }}">{{ $top->articleLocale->title }}</p>

                                                <h3><strong>{{ trans('admin/article.always_on_top.label_summary') }}</strong></h3>
                                                <p class="m-t" id="summary-{{ $top->id }}">
                                                    {{ $top->articleLocale->summary }}
                                                </p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="row">
                                                    <button
                                                        class="btn btn-danger btn-block btn-lg delete-always-on-top"
                                                        type="button"
                                                        action="{{ action('Admin\ArticlesController@deleteAlwaysOnTop', ['articleLocaleId' => $top->id]) }}"
                                                    >
                                                        <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                                        <i class="fa fa-check"></i>&nbsp;
                                                        <strong>{{ trans('admin/article.always_on_top.label_delete') }}</strong>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
