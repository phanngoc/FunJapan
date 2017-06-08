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

                    <div class="form-group">
                        {{ Form::label(
                            'photo',
                            trans('admin/popular_category.label.photo'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt5">
                            {{ Form::file('photo', ['class' => 'max100']) }}
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
                        <div class="col-sm-10">
                        {{ Form::select('link', array_pluck($categories, 'name', 'id'), count(old()) ? old('link') : $popularCategory->link, ['class' => 'form-control']) }}
                        </div>
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
<div id="extension" data-extension="{{ config('images.validate.popular_category_image.mimes') }}"></div>
<div id="size" data-size="{{ config('images.validate.popular_category_image.max_size') }}"></div>
<div id="mimes-message" data-message="{{ trans('admin/article.mimes_message') }}"></div>
<div id="size-message" data-message="{{ trans('admin/article.size_message') }}"></div>
<div id="suggest-url" data-url="{{ action('Admin\PopularCategoriesController@getSuggest') }}"></div>
@stop
@section('script')
    {{ Html::script('assets/admin/js/popular_category.js') }}
@endsection