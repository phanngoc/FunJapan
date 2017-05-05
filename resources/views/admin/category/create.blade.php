@extends('layouts.admin.default')

@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{ trans('admin/category.add_category') }}</h3>
            </div>
            <div class="ibox-content">
                {{ Form::open(['action' => 'Admin\CategoriesController@store', 'id' => 'create-category-form', 'class' => 'form-horizontal', 'files' => true]) }}
                    @include('admin.elements.category_inputs_form')
                    <div class="form-group">
                        {{ Form::label(
                            'img',
                            trans('admin/category.label.img'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::file('img', null, ['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label(
                            'locale_id',
                            trans('admin/category.label.locale'),
                            ['class' => 'col-sm-2 control-label'])
                        }}
                        <div class="col-sm-10">
                            {{ Form::select(
                                'locale_id',
                                $locales,
                                null,
                                ['class' => 'form-control'])
                            }}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            {{ Form::submit(trans('admin/category.button.create'), ['class' => 'btn btn-primary']) }}
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
