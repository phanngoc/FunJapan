@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/tag.list_hot_tags') }}</h2></div>
                <div class="ibox-content">
                    <div class="row">
                        {{ Form::open([
                                'action' => 'Admin\TagsController@showHotTags',
                                'method' => 'GET',
                                'class' => 'tags-list',
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
                        <table width="100%" class="table table-striped table-bordered table-hover" id="tag-table" data-url="{{action('Admin\TagsController@getListTags', ['locale_id' => $localeId, 'is_hot_tag' => true])}}" data-setting-url="{{action('Admin\TagsController@updateHotTag')}}">
                            <thead>
                                <tr>
                                    <th class="text-center">{{ trans('admin/tag.no') }}</th>
                                    <th class="text-center">{{ trans('admin/tag.name') }}</th>
                                    <th class="text-center">{{ trans('admin/tag.created_at') }}</th>
                                    <th class="text-center">{{ trans('admin/tag.remove-hot-tags') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="button-error" data-message="{{ trans('admin/tag.setting_error') }}"></div>
    <div id="button-success" data-message="{{ trans('admin/tag.setting_success') }}"></div>
@stop
@section('script')
    <script type="text/javascript">
        var localeId = {{ $localeId }}
    </script>
    {{ Html::script('assets/admin/js/setting_hot_tags.js') }}
@stop
