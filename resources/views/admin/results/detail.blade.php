@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2><strong>{{ trans('admin/survey.title') }}: </strong> {{ $survey->title }}</h2></div>
                <div class="ibox-content">
                    @foreach($results as $result)
                        <div class="row">
                            <div class="col-lg-6">
                                <strong>Required Score From: </strong> {{ $result->required_point_from }}
                            </div>
                            <div class="col-lg-6">
                                <strong>Required Score To: </strong> {{ $result->required_point_to }}
                            </div>
                            <div class="col-lg-12">
                                <strong>{{ trans('admin/survey.title') }}: </strong> {{ $result->title }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <strong>{{ trans('admin/survey.description') }}:</strong> {!! $result->html_description !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                            <strong>Photo Result: </strong>
                                <img src="{{ $result->photoUrl['original'] }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <strong>Bottom Text:</strong> {{ $survey->bottom_text }}
                            </div>
                            <div class="col-lg-6">
                                <strong>{{ trans('admin/survey.created_by') }}:</strong> {{ $survey->user->name }}
                            </div>
                        </div>
                        <hr>
                    @endforeach
                    <a href="{{ action('Admin\ResultsController@edit', [$survey->id]) }}" class="btn btn-w-m btn-primary">
                        {{ trans('admin/article.button.edit') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop
