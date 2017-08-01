@extends('layouts.admin.default')

@section('scripts')
    {!! Html::script('assets/admin/js/advertisement.js') !!}
    <script>
        var labelWrongFileType = '{{ trans('admin/banner.validate.file_type') }}';
        var labelUnauthorized = '{{ trans('admin/banner.validate.unauthorized') }}';
        var labelMaxSize = '{{ trans('validation.max.file', ['attribute' => 'photo', 'max' => config('images.validate.banner.max_size')]) }}';
        var lblButtonYes = '{{ trans('admin/banner.label_yes') }}';
        var lblButtonNo = '{{ trans('admin/banner.label_no') }}';
    </script>
@endsection

@section('style')
    {!! Html::style('assets/admin/css/advertisement.css') !!}
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h2>{{ trans('admin/advertisement.add_title') }}</h2>
                    <p class="text-danger font-bold m-xxs">* {{ trans('admin/advertisement.label.note') }}</p>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="tabs-container form-group">
                            @foreach ($locales as $key => $locale)
                                @if ($loop->index % 2 == 0)
                                    <div class="list-advertisement">
                                @endif
                                <div class="panel-body col-md-6">
                                    <div class="col-md-6 preview-image">
                                        <img class="image-advertisement" id="image-advertisement-{{ $key }}">
                                        <p class="text-danger font-bold m-xxs error-message" id="photo_error_{{ $key }}"></p>
                                        <div class="row text-center form-upload margin-top-10">
                                            <input
                                                type="file"
                                                accept="image/jpeg,image/png,image/jpg"
                                                max-size="{{ config('images.validate.banner.max_size') }}"
                                                name="advertisement[{{ $key }}][photo]"
                                                class="upload-file"
                                                style="display:none"
                                                id="upload-file-{{ $key }}"
                                                data-locale="{{ $key }}"
                                            >
                                            <input
                                                type="hidden"
                                                class="is_uploaded_photo"
                                                name="advertisement[{{ $key }}][is_uploaded_photo]"
                                                value="0"
                                            >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-success font-bold m-xxs">
                                                {{ $locale }}
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('admin/advertisement.label.url') }}</label>
                                            <input
                                                type="text"
                                                name="advertisement[{{ $key }}][url]"
                                                class="form-control input-url"
                                                autocomplete="off"
                                                placeholder="{{ trans('admin/advertisement.label.url') }}"
                                            >
                                            <p class="text-danger font-bold m-xxs error-message" id="url_error_{{ $key }}"></p>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('admin/advertisement.label.from_to') }} </label>
                                                <input
                                                    type="text"
                                                    name="advertisement[{{ $key }}][start_date]"
                                                    class="form-control from-datetime-picker"
                                                    data-locale="{{ $key }}"
                                                    autocomplete="off"
                                                    id="min-date-locale-{{ $key }}"
                                                    placeholder="{{ trans('admin/advertisement.label.from') }}"
                                                >
                                                <p class="text-danger font-bold m-xxs error-message" id="from_error_{{ $key }}"></p>

                                                <input
                                                    type="text"
                                                    name="advertisement[{{ $key }}][end_date]"
                                                    class="form-control to-datetime-picker"
                                                    data-locale="{{ $key }}"
                                                    autocomplete="off",
                                                    id="max-date-locale-{{ $key }}"
                                                    placeholder="{{ trans('admin/advertisement.label.to') }}"
                                                >
                                                <p class="text-danger font-bold m-xxs error-message" id="to_error_{{ $key }}"></p>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-block btn-primary btn-upload" data-locale="{{ $key }}">{{ trans('admin/advertisement.label.upload') }}</button>
                                        </div>
                                    </div>
                                </div>
                                @if ($loop->index % 2 == 1)
                                    </div>
                                @endif
                            @endforeach
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="button" class="btn btn-block btn-success btn-public" disabled=tr>
                                        <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                        <i class="fa fa-check"></i>&nbsp;
                                        {{ trans('admin/advertisement.label.publish') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h2>{{ trans('admin/advertisement.list_title') }}</h2>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['class' => 'form-horizontal', 'files' => true]) !!}
                        <div class="tabs-container form-group">
                            @foreach ($advertisements as $advertisement)
                                @if ($loop->index % 2 == 0)
                                    <div class="list-advertisement">
                                @endif
                                <div class="panel-body col-md-6">
                                    <div class="col-md-6 preview-image">
                                        <img
                                            class="image-advertisement"
                                            id="image-advertisement-{{ $advertisement->locale_id }}"
                                            src="{{ $advertisement->photo_urls['normal'] }}"
                                        >
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="text-success font-bold m-xxs">
                                                {{ $advertisement->locale->name }}
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('admin/advertisement.label.url') }}</label>
                                            <input type="text" name="url" class="form-control" value="{{ $advertisement->url }}" disabled>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ trans('admin/advertisement.label.from_to') }}</label>
                                                <input
                                                    type="text"
                                                    name="from"
                                                    class="form-control from-datetime-picker-edit"
                                                    data-locale="{{ $advertisement->locale_id }}"
                                                    autocomplete="off"
                                                    id="min-date-edit-locale-{{ $advertisement->locale_id }}"
                                                    value = "{{ $advertisement->start_date }}"
                                                    {{ $advertisement->status == config('banner.advertisement.status.in_future') ? null : 'disabled' }}
                                                    placeholder="{{ trans('admin/advertisement.label.from') }}"
                                                >
                                                <p class="text-danger font-bold m-xxs error-message" id="from_edit_error_{{ $advertisement->locale_id }}"></p>
                                                <input
                                                    type="text"
                                                    name="to"
                                                    class="form-control to-datetime-picker-edit"
                                                    data-locale="{{ $advertisement->locale_id }}"
                                                    autocomplete="off"
                                                    id="max-date-edit-locale-{{ $advertisement->locale_id }}"
                                                    value = "{{ $advertisement->end_date }}"
                                                    {{ $advertisement->status == config('banner.advertisement.status.public') ? 'disabled' : null}}
                                                    placeholder="{{ trans('admin/advertisement.label.to') }}"
                                                >
                                                <p class="text-danger font-bold m-xxs error-message" id="to_edit_error_{{ $advertisement->locale_id }}"></p>
                                                <input
                                                    type="hidden"
                                                    value="{{ $advertisement->status == config('banner.advertisement.status.public') ? 1 : 0 }}"
                                                    type="hidden"
                                                    id="is_active_{{ $advertisement->locale_id }}"
                                                >
                                        </div>
                                        <div class="form-group">
                                            <button
                                                type="button"
                                                class="btn btn-block btn-edit {{ $advertisement->status == config('banner.advertisement.status.public') ? 'btn-danger' :  ($advertisement->status == config('banner.advertisement.status.in_future') ? 'btn-warning' : 'btn-success')}}"
                                                data-locale="{{ $advertisement->locale_id }}"
                                                data-action="{{ action('Admin\AdvertisementsController@change', ['advertisementId' => $advertisement->id]) }}"
                                            >
                                                <i class="fa fa-spinner fa-pulse fa-fw hidden"></i>
                                                <i class="fa fa-check"></i>&nbsp;
                                                @if ($advertisement->status == config('banner.advertisement.status.unpublic'))
                                                    {{ trans('admin/advertisement.label.publish') }}
                                                @elseif ($advertisement->status == config('banner.advertisement.status.public'))
                                                    {{ trans('admin/advertisement.label.unpublish') }}
                                                @else
                                                    {{ trans('admin/advertisement.label.in_future') }}
                                                @endif
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @if ($loop->index % 2 == 1)
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

@stop