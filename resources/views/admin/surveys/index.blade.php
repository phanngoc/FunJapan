@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/survey.survey_list') }}</h2></div>
            <div class="ibox-content">
                <div class="row">
                    {{ Form::open([
                            'action' => 'Admin\SurveysController@index',
                            'method' => 'GET',
                            'class' => 'surveys-list',
                        ])
                    }}
                        <div class="col-sm-5 m-b-xs">
                            {{ Form::select('locale_id', $locales, $localeId, [
                                    'class' => 'input-sm form-control input-s-sm inline select-locale height-35',
                                ])
                            }}
                        </div>
                    {{ Form::close() }}
                </div>
                <div class="table-responsive">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="survey-table">
                        <thead>
                            <tr>
                                <th>{{ trans('admin/survey.no') }}</th>
                                <th class="text-center">{{ trans('admin/survey.title') }}</th>
                                <th class="text-center">{{ trans('admin/survey.type') }}</th>
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
                                    <td class="min-width-160">
                                        @foreach(config('survey.type') as $key => $type)
                                            @if($survey->type == $key)
                                                {{ $type }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="min-width-160">{{ $survey->point }}</td>
                                    <td class="text-center min-width-160">{{ $survey->created_at }}</td>
                                    <td class="text-center">
                                        <a data-toggle="tooltip" data-placement="left" title="Edit" href="{{ action('Admin\SurveysController@edit', [$survey->id]) }}" class="edit">
                                            &nbsp;<i class="fa fa-pencil-square-o fa-lg"></i>
                                        </a>
                                        <a data-toggle="tooltip" data-placement="top" title="Delete" href="#" data-url="" class="delete">
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