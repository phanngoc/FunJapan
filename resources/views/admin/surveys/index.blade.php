@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/survey.survey_list') }}</h2></div>
            <div class="ibox-content">
                <div class="table-responsive">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="survey-table">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/survey.no') }}</th>
                                <th class="text-center">{{ trans('admin/survey.title') }}</th>
                                <th class="text-center">{{ trans('admin/survey.type') }}</th>
                                <th class="text-center">{{ trans('admin/survey.language') }}</th>
                                <th class="text-center">{{ trans('admin/survey.point') }}</th>
                                <th class="text-center">{{ trans('admin/survey.created_at') }}</th>
                                <th class="text-center">{{ trans('admin/tag.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($surveys as $survey)
                                <tr>
                                    <td class="text-center">{{ $survey->id }}</td>
                                    <td>
                                        <a href="{{ action('Admin\SurveysController@show', [$survey->id]) }}">
                                            {{ $survey->title }}
                                        </a>
                                    </td>
                                    <td>
                                        @foreach(config('survey.type') as $key => $type)
                                            @if($survey->type == $key)
                                                {{ $type }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>{{ $survey->locale->name }}</td>
                                    <td>{{ $survey->point }}</td>
                                    <td class="text-center">{{ $survey->created_at }}</td>
                                    <td class="text-center">
                                        <a href="{{ action('Admin\SurveysController@edit', [$survey->id]) }}" class="edit">
                                            &nbsp;<i class="fa fa-pencil-square-o fa-lg"></i>
                                        </a>
                                        <a href="#" data-url="" class="delete">
                                            &nbsp;<i class="fa fa-trash-o fa-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/survey.js') !!}
@stop