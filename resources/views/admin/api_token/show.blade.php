@extends('layouts.admin.default')

@section('content')
<div class="row">
    @can('permission', 'api.add')
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        {{ trans('admin/api_token.label.create_token') }}
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="box-body">
                        {!! Form::open(['action' => 'Admin\ApiTokenController@store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">
                                        {{
                                            Form::label('start_time',trans('admin/api_token.label.expired_to'))
                                        }}
                                    </label>

                                    <div class="col-sm-10">
                                        {{
                                            Form::text(
                                                'expired_to',
                                                old('expired_to'),
                                                ['class' => 'form-control datetime-picker']
                                            )
                                        }}
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-lg-6 -->
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">
                                        {{
                                            Form::label('start_time',trans('admin/api_token.label.user'))
                                        }}
                                    </label>
                                    <div class="col-sm-10">
                                        <select name="user_id" id="user-choice" style="width: 100%">
                                            @if (old('user_name'))
                                                <option value="{{ old('user_id') }}" selected="selected">
                                                    {{ old('user_name') }}
                                                </option>
                                            @endif
                                        </select>
                                        {{
                                            Form::hidden('user_name', old('user_name'))
                                        }}
                                    </div>
                                </div>
                            </div>
                            <!-- /.col-lg-6 -->
                        </div>

                        <div class="row text-center">
                            {{ Form::submit(trans('admin/api_token.button.create'), ['class' => 'btn btn-primary']) }}
                        </div>

                        <p class="text-danger font-bold m-xxs error-message"></p>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    @endcan

    @can('permission', 'api.list')
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        {{ trans('admin/api_token.label.token_list') }}
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table
                            width="100%"
                            class="table table-striped table-bordered table-hover"
                            id="api-token-table"
                            data-url="{{ action('Admin\ApiTokenController@lists') }}"
                        >
                            <thead>
                            <tr>
                                <th class="text-center">{{ trans('admin/api_token.label.id') }}</th>
                                <th class="text-center">{{ trans('admin/api_token.label.token') }}</th>
                                <th class="text-center">{{ trans('admin/api_token.label.expired_to') }}</th>
                                <th class="text-center">{{ trans('admin/api_token.label.user') }}</th>
                                <th class="text-center">{{ trans('admin/api_token.label.active') }}</th>
                                <th class="text-center">{{ trans('admin/api_token.label.remove') }}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endcan
</div>
@stop

@section('script')
    <script type="text/javascript">
        var lblConfirmRemove = '{{ trans('admin/api_token.label_delete_question_title') }}';
        var lblConfirmRemoveTitle = '{{ trans('admin/api_token.label_delete_question') }}';
        var lblButtonYes = '{{ trans('admin/api_token.label_yes') }}';
        var lblButtonNo = '{{ trans('admin/api_token.label_no') }}';
        var articleSuggest = {{ config('banner.article_suggest') }};
    </script>

    {{ Html::script('assets/admin/js/api_token.js') }}
@endsection
