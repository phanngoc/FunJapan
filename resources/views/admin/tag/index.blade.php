@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title"><h2>{{ trans('admin/tag.tag_list') }}</h2></div>
            <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover" id="tag-table" data-url="{{action('Admin\TagsController@getListTags')}}">
                    <thead>
                        <tr>
                            <th class="text-center">{{ trans('admin/tag.no') }}</th>
                            <th class="text-center">{{ trans('admin/tag.name') }}</th>
                            <th class="text-center">{{ trans('admin/tag.status') }}</th>
                            <th class="text-center">{{ trans('admin/tag.created_at') }}</th>
                            <th class="text-center">{{ trans('admin/tag.edit') }}</th>
                            <th class="text-center">{{ trans('admin/tag.delete') }}</th>
                            <th class="text-center">{{ trans('admin/tag.block') }}</th>
                        </tr>
                    </thead>

                    <tfoot>
                        <tr>
                            <th>{{ trans('admin/tag.no') }}</th>
                            <th>{{ trans('admin/tag.name') }}</th>
                            <th>{{ trans('admin/tag.status') }}</th>
                            <th>{{ trans('admin/tag.created_at') }}</th>
                            <th>{{ trans('admin/tag.edit') }}</th>
                            <th>{{ trans('admin/tag.delete') }}</th>
                            <th>{{ trans('admin/tag.block') }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<div id="delete-confirm" data-message="{{ trans('admin/tag.delete_confirm') }}"></div>
<div id="block-confirm" data-message="{{ trans('admin/tag.block_confirm') }}"></div>
<div id="un-block-confirm" data-message="{{ trans('admin/tag.un_block_confirm') }}"></div>
<div id="tag-block" data-message="{{ trans('admin/tag.tag_block') }}"></div>
<div id="tag-not-block" data-message="{{ trans('admin/tag.tag_not_block') }}"></div>
<div>
    {{ Form::open(['id' => 'deleteForm']) }}
        {{ method_field('DELETE') }}
    {{ Form::close() }}
</div>
<div>
    {{ Form::open(['id' => 'blockForm']) }}
        {{ method_field('PUT') }}
    {{ Form::close() }}
</div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/tag.js') !!}
@stop