@extends('layouts.admin.default')

@section('style')
{!! Html::style('assets/admin/css/category.css') !!}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h2>{{ trans('admin/category.add_category') }}</h2>
            </div>
            <div class="ibox-content">
                {{ Form::open(['action' => 'Admin\CategoriesController@store', 'id' => 'create-category-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    <div class="form-group required">
                        {{ Form::label(
                            'locale_id',
                            trans('admin/category.label.locale'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-3">
                            {{ Form::select(
                                'locale_id',
                                $locales,
                                null,
                                [
                                    'class' => 'form-control'
                                ])
                            }}
                        </div>
                    </div>
                    @include('admin.elements.category_inputs_form')
                    <div class="form-group required">
                        {{ Form::label(
                            'image',
                            trans('admin/category.label.img'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt6">
                            {{ Form::file('image', null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                     <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            <img id="image-preview" src="" width="90" height="90" class="item-hide" title="Preview Image">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/category.button.save'), ['class' => 'btn btn-primary']) }}
                        </div>
                        <div class="col-sm-3">
                            <a href="#" data-confirm="{{ trans('admin/category.cancel_confirm') }}" data-url="{{ action('Admin\CategoriesController@index') }}" class="cancel btn-primary btn">{{ trans('admin/category.button.cancel') }}</a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/category.js') !!}
@stop
