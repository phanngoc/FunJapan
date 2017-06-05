@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/popular_category.edit_category') }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\PopularCategoriesController@update', 'popularCategory' => $popularCategory->id], 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ Form::hidden('locale', $popularCategory->locale_id, ['id' => 'locale']) }}

                    <div class="form-group required">
                        {{ Form::label(
                            'name',
                            trans('admin/popular_category.label.name'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::text('name', $popularCategory->name, ['class' => 'form-control', 'required']) }}
                        </div>
                    </div>

                    <div class="form-group">
                        {{ Form::label(
                            'photo',
                            trans('admin/popular_category.label.photo'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt5">
                            {{ Form::file('photo') }}
                        </div>
                    </div>

                    <div class="form-group" id="preview-section">
                        <div class="col-sm-4 col-sm-offset-2">
                            <img id="preview-img" src="{{ $popularCategory->photo_urls['normal'] }}" alt="your image" data-url="{{ $popularCategory->photo_urls['normal'] }}"/>
                        </div>
                    </div>

                    <div class="form-group required">
                        {{ Form::label(
                            'link',
                            trans('admin/popular_category.label.link'),
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
                            {{ Form::submit(trans('admin/popular_category.button.update'),
                                [
                                    'class' => 'btn btn-primary',
                                ])
                            }}
                        </div>

                        <div class="col-sm-3">
                            <a class="btn btn-primary cancel" data-message="{{ trans('admin/popular_category.cancel_message') }}" href="{{ action('Admin\PopularCategoriesController@index') }}">
                                {{ trans('admin/popular_category.button.cancel') }}
                            </a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<div id="suggest-url" data-url="{{ action('Admin\PopularCategoriesController@getSuggest') }}"></div>
@stop
@section('script')
    {{ Html::script('assets/admin/js/popular_category.js') }}
@endsection