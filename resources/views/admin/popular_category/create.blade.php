@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/popular_category.setting_category') }}</h2></div>
            <div class="ibox-content">
                {{ Form::open(['action' => 'Admin\PopularCategoriesController@store', 'class' => 'form-horizontal', 'files' => true]) }}
                    <div class="form-group">
                        {{ Form::label(
                            'locale',
                            trans('admin/popular_category.label.locale'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select('locale', $locales, old('locale'), ['class' => 'form-control']) }}
                        </div>
                    </div>

                    <div class="form-group required">
                        {{ Form::label(
                            'name',
                            trans('admin/popular_category.label.name'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::text('name', '', ['class' => 'form-control', 'required']) }}
                        </div>
                    </div>

                    <div class="form-group required">
                        {{ Form::label(
                            'photo',
                            trans('admin/popular_category.label.photo'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt5">
                            {{ Form::file('photo') }}
                        </div>
                    </div>
                    <div class="form-group hidden" id="preview-section">
                        <div class="col-sm-4 col-sm-offset-2">
                            <img id="preview-img" src="#" alt="your image" data-url=""/>
                        </div>
                    </div>

                    <div class="form-group required">
                        {{ Form::label(
                            'link',
                            trans('admin/popular_category.label.link'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        @if (count(old()) > 0 && old('link') != null)
                            <div class="col-sm-10">
                                <select id="link" class="form-control" name="link">
                                    <option value="{{ old('oldLink')->id }}" selected="selected">{{ old('oldLink')->name }}</option>
                                </select>
                            </div>
                        @else
                            <div class="col-sm-10">
                                {{ Form::select('link', [], null, ['class' => 'form-control']) }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/popular_category.button.create'),
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