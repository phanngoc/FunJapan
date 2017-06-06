@extends('layouts.admin.default')

@section('style')
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h2><strong>{{ trans('admin/survey.title') }}: </strong> {{ $survey->title }}</h2>
                </div>
                <div class="ibox-content">
                    {{ Form::open(
                        [
                            'id' => 'create-result-form',
                            'class' => 'form-horizontal',
                            'files' => true
                        ]
                    ) }}
                        <div class="form-create">
                            @include('admin.results._form_edit')
                        </div>
                        @if(count($results))
                            <div class="form-group">
                                <div class="col-sm-2 col-sm-offset-1">
                                    <a href="javascript:;" class="btn btn-primary" id="create-result"
                                        data-url="{{ action('Admin\ResultsController@store', [$survey->id]) }}" data-survey-id="{{ $survey->id }}">
                                        {{ trans('admin/survey.button.save') }}
                                    </a>
                                </div>
                                <div class="col-sm-2">
                                    <a href="#" data-url="{{ action('Admin\SurveysController@show', [$survey->id]) }}" data-confirm="{{ trans('admin/category.cancel_confirm') }}" class="cancel btn btn-primary">
                                        {{ trans('admin/survey.button.cancel') }}
                                    </a>
                                </div>
                            </div>
                        @else
                            Nothing to show. <a href="{{ action('Admin\ResultsController@create', [$survey->id]) }}"><b>Add result?</b></a>
                        </div>
                        @endif
                    {{ Form::close() }}
                    <div id="redirect-show" data-url="{{ action('Admin\SurveysController@show', [$survey->id]) }}"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! Html::script('assets/admin/js/article.js') !!}
    {!! Html::script('assets/admin/js/result.js') !!}
@stop