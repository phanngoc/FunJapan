@extends('layouts.admin.default')

@section('style')
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3>{{ trans('admin/survey.edit') }}</h3>
            </div>
            <div class="ibox-content">
                {{ Form::open(
                    [
                        'method' => 'PUT',
                        'action' => ['Admin\SurveysController@update', $survey->id],
                        'id' => 'edit-survey-form',
                        'class' => 'form-horizontal',
                    ]
                ) }}
                    @include('admin.surveys._form')
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {{ Form::submit(trans('admin/survey.button.update'), ['class' => 'btn btn-primary']) }}
                        </div>
                        <div class="col-sm-2">
                            <a href="#" data-confirm="{{ trans('admin/category.cancel_confirm') }}" data-url="{{ action('Admin\SurveysController@index') }}" class="cancel btn btn-primary">
                                {{ trans('admin/survey.button.cancel') }}
                            </a>
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
    {!! Html::script('assets/admin/js/survey.js') !!}
@stop