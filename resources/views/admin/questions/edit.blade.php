@extends('layouts.admin.default')

@section('style')
@endsection
@section('content')
    <div class="row" id="add-question">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/question.edit_question') }}</h2></div>
                <div class="ibox-content">
                    {{ Form::open(
                        [
                            'id' => 'edit-question-form',
                            'class' => 'form-horizontal',
                        ]
                    ) }}
                        <div class="form-create">
                            @include('admin.questions._form_edit')
                        </div>
                        <div id="statusForm" data-status=""></div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-1">
                                <a href="javascript:;" class="btn btn-primary" id="edit-question"
                                    data-url="{{ action('Admin\QuestionsController@store', [$survey->id]) }}"
                                    data-survey-id="{{ $survey->id }}"
                                    data-id="{{ $question->id }}">
                                    {{ trans('admin/survey.button.save') }}
                                </a>
                            </div>
                            <div class="col-sm-2">
                                <a href="#" data-url="{{ action('Admin\SurveysController@show', [$survey->id]) }}" data-confirm="{{ trans('admin/category.cancel_confirm') }}" class="cancel btn btn-primary">
                                    {{ trans('admin/survey.button.cancel') }}
                                </a>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <div id="redirect-show" data-url="{{ action('Admin\SurveysController@show', [$survey->id]) }}"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {!! Html::script('assets/admin/js/question.js') !!}
    <script type="text/javascript">
        var checkbox = {{ config('question.type_value.checkbox') }};
        var radio = {{ config('question.type_value.radio') }};
    </script>
@stop