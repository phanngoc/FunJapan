@extends('layouts.admin.default')

@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{ trans('admin/category.edit_category') }}</h3>
            </div>
            <div class="ibox-content">
                {{ Form::open(['action' => ['Admin\CategoriesController@update', $category->id], 'id' => 'edit-category-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    {{ method_field('PUT') }}
                    @include('admin.elements.category_inputs_form')
                    {{ Form::hidden('id', $category->id) }}
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {{ Form::submit(trans('admin/category.button.update'), ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/article.js') !!}
@stop