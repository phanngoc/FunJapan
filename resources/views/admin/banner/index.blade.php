@extends('layouts.admin.default')

@section('scripts')
    {!! Html::script('assets/admin/js/banner.js') !!}

    <script>
        var articleSuggest = {{ config('banner.article_suggest') }};
        var labelWrongFileType = '{{ trans('admin/banner.validate.file_type') }}';
        var labelUnauthorized = '{{ trans('admin/banner.validate.unauthorized') }}';
        var labelMaxSize = '{{ trans('validation.max.file', ['attribute' => 'photo', 'max' => config('images.validate.banner.max_size')]) }}';
        var lblButtonYes = '{{ trans('admin/banner.label_yes') }}';
        var lblButtonNo = '{{ trans('admin/banner.label_no') }}';
        var lblTitleChangeLocale = '{{ trans('admin/banner.label_change_locale_title') }}';
        var lblQuestionChangeLocale = '{{ trans('admin/banner.label_change_locale_question') }}';
        var lblButtonEdit = '{{ trans('admin/banner.label_edit') }}';
        var lblButtonStopEdit = '{{ trans('admin/banner.label_stop_edit') }}';
        var lblTitleChangeMode = '{{ trans('admin/banner.change_mode_edit_title') }}';
        var lblQuestionChangeMode = '{{ trans('admin/banner.change_mode_edit_question') }}';
        var lblTitleAddMode = '{{ trans('admin/banner.change_mode_add_title') }}';
        var lblQuestionAddMode = '{{ trans('admin/banner.change_mode_add_question') }}';
        var lblTitleReplace = '{{ trans('admin/banner.label_replace_question_title') }}';
        var lblQuestionReplace = '{{ trans('admin/banner.label_replace_question') }}';
    </script>
@endsection

@section('styles')
    {!! Html::style('assets/admin/css/banner.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h2>{{ trans('admin/banner.title') }}</h2>
                    <p class="text-danger font-bold m-xxs">* {{ trans('admin/banner.image_suggest_size') }}</p>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        {!! Form::open(['class' => 'form-horizontal', 'files' => true, 'id' => 'form-edit']) !!}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin/banner.label_locale') }}</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="locale_id" id="locale">
                                            @foreach ($locales as $id => $locale)
                                                <option value="{{ $id }}" {{ $id == $currentLocale ? 'selected' : '' }}>
                                                    {{ $locale }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input type="hidden" name="old_locale_id" id="old_locale" value="{{ $currentLocale }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin/banner.label_article') }}</label>
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
                                    <label class="col-sm-2 control-label">{{ trans('admin/banner.label_place') }}</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="order">
                                            @foreach (config('banner.order') as $position => $value)
                                                <option value="{{ $value }}" {{ $value == old('order') ? 'selected' : '' }}>
                                                    {{ trans('admin/banner.order.' . $position) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-success btn-upload btn-block" type="button">
                                        <i class="fa fa-upload"></i>&nbsp;&nbsp;
                                        <span class="bold">{{ trans('admin/banner.label_upload') }}</span>
                                    </button>
                                    <input
                                        type="file"
                                        name="photo"
                                        class="hide upload-file"
                                        accept="image/jpeg,image/png,image/jpg"
                                        max-size="{{ config('images.validate.banner.max_size') }}"
                                    >
                                    <input type="hidden" name="is_uploaded_photo">
                                </div>
                            </div>
                            <div class="input-group col-xs-6">
                                <div class="row image-banner-include">
                                    <img class="image-banner" src="{{ old('image_banner_base') }}" id="image-banner-pre">
                                    <p class="text-danger font-bold m-xxs error-message" id="photo_error"></p>
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block store-banner" type="button">
                                <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                <i class="fa fa-check"></i>&nbsp;
                                <strong>{{ trans('admin/banner.label_update') }}</strong>
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
                    <h2>{{ trans('admin/banner.title_list') }}</h2>
                    <p class="text-danger font-bold m-xxs">* {{ trans('admin/banner.condition_show_in_front') }}</p>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            @foreach ($locales as $key => $locale)
                                <li class="tab-title {{ $key == $currentLocale ? 'active' : null }}" id="tab-{{ $key }}">
                                    <a data-toggle="tab" href="#tab-pane-{{ $key }}"  data-locale-id="{{ $key }}">
                                        {{ $locale }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($bannerSettingLocales as $localeId => $bannerSettingLocale)
                                <div class="tab-pane {{ $localeId == $currentLocale ? 'active' : '' }}" id="tab-pane-{{ $localeId }}">
                                    @if (count($bannerSettingLocale))
                                        @foreach ($bannerSettingLocale as $bannerSetting)
                                            <div class="panel-body">
                                                <div class="row" id="banner-{{ $bannerSetting->id }}">
                                                    <div class="col-md-4 preview-image">
                                                        <div class="row">
                                                            <img class="image-banner" src="{{ $bannerSetting->photo_urls['original'] }}">
                                                            <p class="text-danger font-bold m-xxs error-message" id="photo_error_{{ $bannerSetting->id }}"></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h3 class="{{ $bannerSetting->active ? '' : 'text-danger' }}">
                                                            <strong>{{ trans('admin/banner.status') }} : </strong>
                                                            {{ $bannerSetting->active ? trans('admin/banner.active') : trans('admin/banner.deactive') }}
                                                        </h3>

                                                        <h3>
                                                            <strong>{{ trans('admin/banner.label_place') }} : </strong>
                                                            {{ $bannerSetting->order_text }}
                                                        </h3>

                                                        <h3><strong>{{ trans('admin/banner.label_title') }}</strong></h3>
                                                        <p id="title-{{ $bannerSetting->id }}">
                                                            {{ $bannerSetting->articleLocale ? $bannerSetting->articleLocale->title : '' }}
                                                        </p>

                                                        <h3><strong>{{ trans('admin/banner.label_summary') }}</strong></h3>
                                                        <p class="m-t" id="summary-{{ $bannerSetting->id }}">
                                                            {{ $bannerSetting->articleLocale ? $bannerSetting->articleLocale->summary : '' }}
                                                        </p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="row">
                                                            <button
                                                                class="btn btn-success btn-block btn-lg btn-edit"
                                                                type="button"
                                                                data-article-id="{{ $bannerSetting->article_locale_id }}"
                                                                data-article-title="{{ $bannerSetting->articleLocale->title }}"
                                                                data-from="{{ $bannerSetting->from }}"
                                                                data-to="{{ $bannerSetting->to }}"
                                                                data-order="{{ $bannerSetting->order }}"
                                                                data-photo="{{ $bannerSetting->photo_urls['original'] }}"
                                                                data-id="{{ $bannerSetting->id }}"
                                                            >
                                                                <strong>{{ trans('admin/banner.label_edit') }}</strong>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="1" id="has_place_{{ $bannerSetting->order }}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
