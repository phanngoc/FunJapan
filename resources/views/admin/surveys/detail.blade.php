@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/survey.detail') }}</h2></div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-1 label-survey">
                            <strong>{{ trans('admin/survey.title') }}: </strong>
                        </div>
                        <div class="col-lg-10">
                            {{ $survey->title }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-1 label-survey">
                            <strong>{{ trans('admin/survey.description') }}:</strong>
                        </div>
                        <div class="col-lg-10 article-content">
                            {!! $survey->html_description !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-1 label-survey">
                            <strong>{{ trans('admin/survey.type') }}: </strong>
                        </div>
                        <div class="col-lg-5">
                            @foreach(config('survey.type') as $key => $type)
                                @if($survey->type == $key)
                                    {{ $type }}
                                @endif
                            @endforeach
                        </div>
                        <div class="col-lg-1 label-survey">
                            <strong>{{ trans('admin/survey.multiple_join') }}:</strong>
                        </div>
                        <div class="col-lg-4">
                            {{ $survey->multiple_join ? 'Yes' : 'No' }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-1 label-survey">
                            <strong>{{ trans('admin/survey.point') }}:</strong>
                        </div>
                        <div class="col-lg-5">
                            {{ $survey->point }}
                        </div>
                        <div class="col-lg-1 label-survey">
                            <strong>{{ trans('admin/survey.created_by') }}:</strong>
                        </div>
                        <div class="col-lg-4">
                            {{ $survey->user->name }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-1 label-survey">
                            <strong>{{ trans('admin/survey.language') }}: </strong>
                        </div>
                        <div class="col-lg-5">
                            {{ $survey->locale->name }}
                        </div>
                        <div class="col-lg-1 label-survey">
                            <strong>{{ trans('admin/survey.created_at') }}: </strong>
                        </div>
                        <div class="col-lg-4">
                            {{ $survey->created_at }}
                        </div>
                    </div>
                    <hr>
                    <a href="{{ action('Admin\SurveysController@edit', [$survey->id]) }}" class="btn btn-w-m btn-primary">
                        {{ trans('admin/article.button.edit') }}
                    </a>
                    <a href="{{ action('Admin\QuestionsController@create', [$survey->id])}}" class="btn btn-w-m btn-primary">
                        {{ trans('admin/question.add_question') }}
                    </a>
                    @if ($survey->type == config('survey.psychological'))
                        <a href="{{ action('Admin\ResultsController@create', [$survey->id]) }}" class="btn btn-w-m btn-primary">
                            {{ trans('admin/result.button.add') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content">
                <div class="tabs-container">
                    <ul class="nav nav-tabs">
                        <li class="active" data-tab="question">
                            <a data-toggle="tab" href="#question">Question</a>
                        </li>
                        <li data-tab="result">
                            <a data-toggle="tab" href="#result">Result</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="question" class="tab-pane fade in active">
                            @include('admin.questions.detail')
                        </div>
                        @if ($survey->type == config('survey.psychological'))
                            <div id="result" class="tab-pane fade">
                                @include('admin.results.detail')
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    {!! Html::script('assets/admin/js/question.js') !!}
    {!! Html::script('assets/admin/js/result.js') !!}
    <script type="text/javascript">
        function showDetail(id) {
            $('.show-detail-' + id).slideToggle();
        }
        function showOption(id) {
            $('.show-option-' + id).slideToggle();
        }
    </script>
@stop