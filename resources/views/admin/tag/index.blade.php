@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"></div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover" id="tag-table" data-url="{{action('Admin\TagsController@getListTags')}}">
                    <thead>
                        <tr>
                            <th>{{ trans('admin/tag.no') }}</th>
                            <th>{{ trans('admin/tag.name') }}</th>
                            <th>{{ trans('admin/tag.created_at') }}</th>
                            <th>{{ trans('admin/tag.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/tag.js') !!}
@stop