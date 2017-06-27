@extends('layouts.admin.default')

@section('scripts')
    {!! Html::script('assets/admin/js/banner.js') !!}

    <script>
        var articleSuggest = {{ config('banner.article_suggest') }};
        var minimumInputLength = {{ config('banner.minimum_input_length') }};
        var labelWrongFileType = '{{ trans('admin/banner.validate.file_type') }}';
        var labelUnauthorized = '{{ trans('admin/banner.validate.unauthorized') }}';
        var labelMaxSize = '{{ trans('validation.max.file', ['attribute' => 'photo', 'max' => config('images.validate.banner.max_size')]) }}';
        var lblConfirmRemove = '{{ trans('admin/banner.label_delete_question_title') }}';
        var lblConfirmRemoveTitle = '{{ trans('admin/banner.label_delete_question') }}';
        var lblButtonYes = '{{ trans('admin/banner.label_yes') }}';
        var lblButtonNo = '{{ trans('admin/banner.label_no') }}';
        var lblTitleChangeLocale = '{{ trans('admin/banner.label_change_locale_title') }}';
        var lblQuestionChangeLocale = '{{ trans('admin/banner.label_change_locale_question') }}';
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
                        {!! Form::open(['class' => 'form-horizontal', 'files' => true]) !!}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin/banner.label_locale') }}</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="locale_id" id="locale">
                                            @foreach ($locales as $id => $locale)
                                                <option value="{{ $id }}" {{ $id == $currentLocale ? 'selected' : '' }}>{{ $locale }}</option>
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
                                    <label class="col-sm-2 control-label">{{ trans('admin/banner.label_from_to') }}</label>
                                    <div class="col-sm-5">
                                        <input type="text" name="from" class="form-control from-datetime-picker" autocomplete="off">
                                        <p class="text-danger font-bold m-xxs error-message" id="from_error"></p>
                                        <p class="text-danger font-bold m-xxs error-message" id="to_error"></p>
                                    </div>
                                    <div class="col-sm-5">
                                        <input type="text" name="to" class="form-control to-datetime-picker" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">{{ trans('admin/banner.label_place') }}</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="order">
                                            @foreach (config('banner.order') as $position => $value)
                                                <option value="{{ $value }}" {{ $value == old('order') ? 'selected' : '' }}>{{ ucfirst($position) }}</option>
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
                                <strong>{{ trans('admin/banner.label_update_all') }}</strong>
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
                                <li class="tab-title {{ $key == $currentLocale ? 'active' : '' }}" id="tab-{{ $key }}">
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
                                                        <h3><strong>{{ trans('admin/banner.label_from_to') }} : </strong> {{ $bannerSetting->from . ' -> ' .  $bannerSetting->to }}</h3>
                                                        <h3 class="{{ $bannerSetting->active ? '' : 'text-danger' }}">
                                                            <strong>{{ trans('admin/banner.status') }} : </strong>
                                                            {{ $bannerSetting->active ? trans('admin/banner.active') : trans('admin/banner.deactive') }}</h3>

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
                                                                class="btn btn-danger btn-block btn-lg delete-banner"
                                                                type="button"
                                                                action="{{ action('Admin\BannerSettingsController@delete', ['bannerId' => $bannerSetting->id]) }}"
                                                            >
                                                                <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                                                <i class="fa fa-check"></i>&nbsp;
                                                                <strong>{{ trans('admin/banner.label_delete_all') }}</strong>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
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
