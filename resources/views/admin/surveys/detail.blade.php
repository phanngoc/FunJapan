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
                        <div class="col-lg-12">
                            <strong>{{ trans('admin/survey.title') }}: </strong> {{ $survey->title }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <strong>{{ trans('admin/survey.description') }}:</strong> {!! $survey->html_description !!}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <strong>{{ trans('admin/survey.type') }}: </strong>
                            @foreach(config('survey.type') as $key => $type)
                                @if($survey->type == $key)
                                    {{ $type }}
                                @endif
                            @endforeach
                        </div>
                        <div class="col-lg-6">
                            <strong>{{ trans('admin/survey.multiple_join') }}:</strong> {{ $survey->multiple_join ? 'Yes' : 'No' }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <strong>{{ trans('admin/survey.point') }}:</strong> {{ $survey->point }}
                        </div>
                        <div class="col-lg-6">
                            <strong>{{ trans('admin/survey.created_by') }}:</strong> {{ $survey->user->name }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <strong>{{ trans('admin/survey.language') }}: </strong> {{ $survey->locale->name }}
                        </div>
                        <div class="col-lg-6">
                            <strong>{{ trans('admin/survey.created_at') }}: </strong> {{ $survey->created_at }}
                        </div>
                    </div>
                    <hr>
                    <a href="{{ action('Admin\SurveysController@edit', [$survey->id]) }}" class="btn btn-w-m btn-primary">
                        {{ trans('admin/article.button.edit') }}
                    </a>
                    <a href="{{ action('Admin\QuestionsController@create', [$survey->id])}}" class="btn btn-w-m btn-primary">
                        {{ trans('admin/question.add_question') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('admin.questions.detail')
@stop
