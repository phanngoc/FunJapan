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
                            'method' => 'PUT',
                            'action' => ['Admin\QuestionsController@update', $survey->id, $question->id],
                            'id' => 'edit-question-form',
                            'class' => 'form-horizontal',
                        ]
                    ) }}
                        <div class="form-create">
                            @include('admin.questions._form_edit')
                        </div>
                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-1">
                                {{ Form::submit(trans('admin/survey.button.update'), ['class' => 'btn btn-primary']) }}
                            </div>
                            <div class="col-sm-2">
                                <a href="#" data-url="{{ action('Admin\SurveysController@show', [$survey->id]) }}" data-confirm="{{ trans('admin/category.cancel_confirm') }}" class="cancel btn btn-primary">
                                    {{ trans('admin/survey.button.cancel') }}
                                </a>
                            </div>
                        </div>
                    {{ Form::close() }}
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