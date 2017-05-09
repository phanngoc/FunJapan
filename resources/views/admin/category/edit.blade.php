@extends('layouts.admin.default')

@section('style')
{!! Html::style('assets/admin/css/category.css') !!}
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h2>{{ trans('admin/category.edit_category') }}</h2>
            </div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\CategoriesController@update', $category->id], 'id' => 'edit-category-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ method_field('PUT') }}
                    @include('admin.elements.category_inputs_form')
                    <div class="form-group">
                        {{ Form::label(
                            'image',
                            trans('admin/category.label.img'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10 pt6">
                            {{ Form::file('image', null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    {{ Form::hidden('id', $category->id) }}
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/category.button.update'), ['class' => 'btn btn-primary']) }}
                        </div>
                        <div class="col-sm-3">
                            <a href="{{ action('Admin\CategoriesController@index') }}" class="btn-primary btn">{{ trans('admin/category.button.cancel') }}</a>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('script')

@stop