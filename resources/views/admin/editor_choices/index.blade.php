@extends('layouts.admin.default')

@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title"><h2>{{ trans('admin/editor_choices.editor_choices') }}</h2></div>
                <div class="ibox-content" id="editor-choices-content">
                @if (count($editorChoices) > 0)
                    @foreach ($editorChoices as $key => $item)
                        <div class="row margin-bottom-10">
                            <div class="col-lg-1 text-center mt7 no">
                                <button class="btn btn-info m-r-sm btn-circle btn-lg">{{ $key + 1 }}</button>
                            </div>
                            <div class="col-lg-3 text-center" id="preview-section"><img id="thumbnail-{{ $item['item']->id }}" src="{{ $item['thumbnail']['normal'] }}"></div>
                            <div class="col-lg-4 text-center link mt20" id="link-{{ $item['item']->id }}">{{ $item['item']->link }}</div>
                            <div class="col-lg-2 text-center mt15">
                                <button class="btn btn-primary modify" id="modify-{{ $item['item']->id }}" data-id="{{ $item['item']->id }}">{{ trans('admin/editor_choices.modify') }}</button>
                            </div>
                            <div class="col-lg-2 text-center mt15">
                                <button class="btn btn-primary delete" id="delete-{{ $item['item']->id }}" data-id="{{ $item['item']->id }}">{{ trans('admin/editor_choices.delete') }}</button>
                            </div>
                        </div>
                        <hr>
                    @endforeach
                @else
                    <div class="row" id="no-article-section">
                        <div class="col-lg-12">
                            {{ trans('admin/editor_choices.no_article') }}
                        </div>
                    </div>
                    <hr>
                @endif
                    <div class="row margin-bottom-10 hidden" id="add-section">
                        <div class="col-lg-2 col-lg-offset-2">
                            <label>{{ trans('admin/editor_choices.article_id') }}</label>
                        </div>
                        <div class="col-lg-4">
                            <div class="row margin-bottom-10">
                                <select class="form-control article-select2" id="url-input">
                                </select>
                            </div>
                            <div class="row hidden">
                                <p class="text-danger"><b id="error-message"></b></p>
                            </div>
                        </div>
                        <div class="col-lg-2 text-center"><button class="btn btn-primary" id="choice" data-url="{{ action('Admin\EditorChoicesController@store') }}">{{ trans('admin/editor_choices.create') }}</button></div>
                        <div class="col-lg-2 text-center"><button class="btn btn-primary" id="cancel-add" data-url="{{ action('Admin\EditorChoicesController@store') }}">{{ trans('admin/editor_choices.cancel') }}</button></div>
                    </div>

                    <div class="row margin-bottom-10 hidden" id="update-section">
                        <div class="col-lg-2 col-lg-offset-2">
                        <label>{{ trans('admin/editor_choices.article_id_update') }} <span id="editor-choices-id"></span></label>
                        </div>
                        <div class="col-lg-4">
                            <div class="row margin-bottom-10">
                                <select class="form-control article-select2" id="update-url-input" placeholder="{{ trans('admin/editor_choices.article_url') }}">
                                </select>
                            </div>
                            <div class="row hidden">
                                <p class="text-danger"><b id="update-error-message"></b></p>
                            </div>
                        </div>
                        <div class="col-lg-2 text-center"><button class="btn btn-primary" id="update" data-url="{{ action('Admin\EditorChoicesController@update') }}">{{ trans('admin/editor_choices.update') }}</button></div>
                        <div class="col-lg-2 text-center"><button class="btn btn-primary" id="cancel-update" data-url="{{ action('Admin\EditorChoicesController@update') }}">{{ trans('admin/editor_choices.cancel') }}</button></div>
                    </div>

                    <button class="btn btn-primary  @if (count($editorChoices) == 10) hidden @endif " id="add-form">{{ trans('admin/editor_choices.add') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div id="delete-url" data-url="{{ action('Admin\EditorChoicesController@destroy') }}"></div>
    <div id="delete-button" data-message="{{ trans('admin/editor_choices.delete') }}"></div>
    <div id="modify-button" data-message="{{ trans('admin/editor_choices.modify') }}"></div>
    <div id="delete-message" data-message="{{ trans('admin/editor_choices.delete_confirm') }}"></div>
    <div id="no-article-message" data-message="{{ trans('admin/editor_choices.no_article') }}"></div>
@stop
@section('script')
    {!! Html::script('assets/admin/js/editor_choices.js') !!}
    <script>
        var articleSuggest = {{ config('banner.article_suggest') }};
    </script>
@endsection