@extends('layouts.admin.default', ['notIncludeNotice' => true])

@section('scripts')
    {!! Html::script('assets/admin/js/banner.js') !!}

    <script>
        var articleSuggest = {{ config('banner.article_suggest') }};
        var minimumInputLength = {{ config('banner.minimum_input_length') }};
        var labelUpdateSuccess = '{{ trans('admin/banner.label_update_success') }}';
        var labelWrongFileType = '{{ trans('admin/banner.validate.file_type') }}';
        var labelUnauthorized = '{{ trans('admin/banner.validate.unauthorized') }}';
    </script>
@endsection

@section('styles')
    {!! Html::style('assets/admin/css/banner.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/banner.title') }}</h2></div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs">
                            @foreach ($locales as $key => $locale)
                                <li class="{{ $key == 1 ? 'active' : '' }}">
                                    <a data-toggle="tab" href="#{{ $key }}">{{ $locale }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            @foreach ($bannerSettingLocales as $localeId => $bannerSettingLocale)
                                <div id="{{ $localeId }}" class="tab-pane {{ $localeId == 1 ? 'active' : '' }}">
                                    {!!
                                        Form::open([
                                            'url' => action('Admin\BannerSettingsController@update', ['localeId' => $localeId]),
                                            'files' => true,
                                            'class' => 'banner-form'
                                        ])
                                    !!}
                                        @if (count($bannerSettingLocale))
                                            @foreach ($bannerSettingLocale as $bannerSetting)
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <input
                                                            type="hidden"
                                                            name="banner[{{ $bannerSetting->id }}][id]"
                                                            value="{{ $bannerSetting->id }}"
                                                        >
                                                        <div class="col-md-4">
                                                            <h3><strong>{{ trans('admin/banner.label_title') }}</strong></h3>
                                                            <p id="title-{{ $bannerSetting->id }}">
                                                                {{ $bannerSetting->articleLocale ? $bannerSetting->articleLocale->title : '' }}
                                                            </p>

                                                            <h3><strong>{{ trans('admin/banner.label_summary') }}</strong></h3>
                                                            <p class="m-t" id="summary-{{ $bannerSetting->id }}">
                                                                {{ $bannerSetting->articleLocale ? $bannerSetting->articleLocale->summary : '' }}
                                                            </p>
                                                        </div>
                                                        <div class="col-md-4 preview-image">
                                                            <div class="row">
                                                                <img class="image-banner" src="{{ $bannerSetting->photo_urls['original'] }}">
                                                                <p class="text-danger font-bold m-xxs error-message" id="photo_error_{{ $bannerSetting->id }}"></p>
                                                            </div>
                                                            <div class="row text-center form-upload margin-top-10">
                                                                <input type="file" accept="image/jpeg,image/png,image/jpg" name="banner[{{ $bannerSetting->id }}][photo]" class="upload-file" style="display:none">
                                                                <input
                                                                    type="hidden"
                                                                    class="is_uploaded_photo"
                                                                    name="banner[{{ $bannerSetting->id }}][is_uploaded_photo]"
                                                                    value="{{ $bannerSetting->photo ? 1 : 0 }}"
                                                                >
                                                                <button class="btn btn-success btn-upload" type="button">
                                                                    <i class="fa fa-upload"></i>&nbsp;&nbsp;
                                                                    <span class="bold">{{ trans('admin/banner.label_upload') }}</span>
                                                                </button>
                                                                <p class="text-danger font-bold m-xxs">{{ trans('admin/banner.image_suggest_sie') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <p>{{ trans('admin/banner.search_by') }}  <span class="text-danger">*<span></p>
                                                                <select
                                                                    name="article[{{ $bannerSetting->id }}]"
                                                                    class="article-select2"
                                                                    style="width: 100%"
                                                                    data-locale="{{ $localeId }}"
                                                                    data-banner-id="{{ $bannerSetting->id }}">
                                                                    @if ($bannerSetting->article_locale_id)
                                                                        <option value="{{ $bannerSetting->article_locale_id }}" selected="selected">
                                                                            {{ $bannerSetting->articleLocale->title }}
                                                                        </option>
                                                                    @endif
                                                                </select>
                                                                <p class="text-danger font-bold m-xxs error-message" id="article_locale_id_error_{{ $bannerSetting->id }}"></p>
                                                                <input
                                                                    type="hidden"
                                                                    name="banner[{{ $bannerSetting->id }}][article_locale_id]"
                                                                    value="{{ $bannerSetting->article_locale_id }}"
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            @foreach (range(1, config('banner.limit')) as $key)
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <input
                                                            type="hidden"
                                                            name="banner[{{ $key }}][id]"
                                                            value="0"
                                                        >
                                                        <div class="col-md-4">
                                                            <h3><strong>{{ trans('admin/banner.label_title') }}</strong></h3>
                                                            <p id="title-{{ $key }}"></p>

                                                            <h3><strong>{{ trans('admin/banner.label_summary') }}</strong></h3>
                                                            <p class="m-t" id="summary-{{ $key }}"></p>
                                                        </div>
                                                        <div class="col-md-4 preview-image">
                                                            <div class="row">
                                                                <img class="image-banner" src="">
                                                                <p class="text-danger font-bold m-xxs error-message" id="photo_error_{{ $key }}"></p>
                                                            </div>
                                                            <div class="row text-center form-upload margin-top-10">
                                                                <input type="file" accept="image/jpeg,image/png,image/jpg" name="banner[{{ $key }}][photo]" class="upload-file" style="display:none">
                                                                <input
                                                                    type="hidden"
                                                                    class="is_uploaded_photo"
                                                                    name="banner[{{ $key }}][is_uploaded_photo]"
                                                                    value="0"
                                                                >
                                                                <button class="btn btn-success btn-upload" type="button">
                                                                    <i class="fa fa-upload"></i>&nbsp;&nbsp;
                                                                    <span class="bold">{{ trans('admin/banner.label_upload') }}</span>
                                                                </button>
                                                                <p class="text-danger font-bold m-xxs">{{ trans('admin/banner.image_suggest_sie') }}</p>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="row">
                                                                <p>{{ trans('admin/banner.search_by') }} <span class="text-danger">*<span></p>
                                                                <select
                                                                    name="article[{{ $key }}]"
                                                                    class="article-select2"
                                                                    style="width: 100%"
                                                                    data-locale="{{ $localeId }}"
                                                                    data-banner-id="0">
                                                                </select>
                                                                <p class="text-danger font-bold m-xxs error-message" id="article_locale_id_error_{{ $key }}"></p>
                                                                <input
                                                                    type="hidden"
                                                                    name="banner[{{ $key }}][article_locale_id]"
                                                                    value=""
                                                                >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                        <button class="btn btn-primary margin-top-10 update-banner-all" type="button">
                                            <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                            <i class="fa fa-check"></i>&nbsp;
                                            <strong>{{ trans('admin/banner.label_update_all') }}</strong>
                                        </button>
                                        <button
                                            class="btn btn-danger margin-top-10 delete-banner-all"
                                            action="{{ action('Admin\BannerSettingsController@delete', ['localeId' => $localeId]) }}"
                                            type="button"
                                            {{ !count($bannerSettingLocale) ? 'disabled' : '' }}
                                        >
                                            <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                            <i class="fa fa-ban"></i>&nbsp;
                                            <strong>{{ trans('admin/banner.label_delete_all') }}</strong>
                                        </button>
                                    {!! Form::close() !!}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
