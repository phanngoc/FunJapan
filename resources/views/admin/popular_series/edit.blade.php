@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/popular_series.edit_series') }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\PopularSeriesController@update', 'popularSeries' => $popularSeries->id], 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ Form::hidden('locale', $popularSeries->locale_id, ['id' => 'locale']) }}

                    <div class="form-group required">
                        {{ Form::label(
                            'summary',
                            trans('admin/popular_series.label.summary'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::text('summary', $popularSeries->summary, ['class' => 'form-control', 'required']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'photo',
                            trans('admin/popular_series.label.photo'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt5">
                            {{ Form::file('photo') }}
                        </div>
                    </div>

                    <div class="form-group" id="preview-section">
                        <div class="col-sm-4 col-sm-offset-2">
                            <img id="preview-img" src="{{ $popularSeries->photo_urls['normal'] }}" alt="your image" data-url="{{ $popularSeries->photo_urls['normal'] }}"/>
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'type',
                            trans('admin/popular_series.label.type'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select('type', $type, count(old()) > 0 ? old('type') : $popularSeries->type , ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group required">
                        {{ Form::label(
                            'link',
                            trans('admin/popular_series.label.link'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        @if (count(old()))
                            @if (old('link'))
                                <div class="col-sm-10">
                                    <select id="link" class="form-control" name="link">
                                        <option value="{{ old('oldLink')->id }}" selected="selected">{{ old('oldLink')->name }}</option>
                                    </select>
                                </div>
                            @else
                                <div class="col-sm-10">
                                    <select id="link" class="form-control" name="link">
                                    </select>
                                </div>
                            @endif
                        @else
                            <div class="col-sm-10">
                                <select id="link" class="form-control" name="link">
                                    <option value="{{ $oldLink->id }}" selected="selected">{{ $oldLink->name }}</option>
                                </select>
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/popular_series.button.update'),
                                [
                                    'class' => 'btn btn-primary',
                                ])
                            }}
                        </div>

                        <div class="col-sm-3">
                            <a class="btn btn-primary cancel" data-message="{{ trans('admin/popular_series.cancel_message') }}" href="{{ action('Admin\PopularSeriesController@index') }}">
                                {{ trans('admin/popular_series.button.cancel') }}
                            </a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<div id="extension" data-extension="{{ config('images.validate.popular_series_image.mimes') }}"></div>
<div id="size" data-size="{{ config('images.validate.popular_series_image.max_size') }}"></div>
<div id="mimes-message" data-message="{{ trans('admin/article.mimes_message') }}"></div>
<div id="size-message" data-message="{{ trans('admin/article.size_message') }}"></div>
<div id="suggest-url" data-url="{{ action('Admin\PopularSeriesController@getSuggest') }}"></div>
@stop
@section('script')
    {{ Html::script('assets/admin/js/popular_series.js') }}
@endsection
